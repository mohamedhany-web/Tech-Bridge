<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstallmentAgreement;
use App\Models\InstallmentPayment;
use App\Models\InstallmentPlan;
use App\Models\StudentCourseEnrollment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstallmentAgreementController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage.installments');
    }

    public function index(Request $request): View
    {
        $agreements = InstallmentAgreement::with(['student', 'course', 'plan'])
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $statuses = $this->statusOptions();

        return view('admin.installments.agreements.index', compact('agreements', 'statuses'));
    }

    public function create(Request $request): View
    {
        $plans = InstallmentPlan::active()->with('course')->orderBy('name')->get();
        $statuses = $this->statusOptions();
        $selectedPlanId = $request->integer('plan_id');

        $enrollmentsQuery = StudentCourseEnrollment::with(['student', 'course'])->latest();

        if ($request->filled('student')) {
            $term = $request->string('student');
            $enrollmentsQuery->whereHas('student', function (Builder $query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%");
            });
        }

        if ($request->filled('course')) {
            $term = $request->string('course');
            $enrollmentsQuery->whereHas('course', function (Builder $query) use ($term) {
                $query->where('title', 'like', "%{$term}%");
            });
        }

        $enrollments = $enrollmentsQuery->limit(50)->get();

        return view('admin.installments.agreements.create', compact('plans', 'enrollments', 'statuses', 'selectedPlanId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $plan = InstallmentPlan::findOrFail($data['installment_plan_id']);
        $enrollment = StudentCourseEnrollment::with(['student', 'course'])->findOrFail($data['student_course_enrollment_id']);

        if (InstallmentAgreement::where('student_course_enrollment_id', $enrollment->id)
            ->whereIn('status', ['active', 'overdue'])
            ->exists()) {
            return back()->withErrors(['student_course_enrollment_id' => 'هناك خطة تقسيط نشطة بالفعل لهذا التسجيل.'])->withInput();
        }

        $totalAmount = $data['total_amount'] ?? $plan->total_amount ?? $enrollment->course?->price ?? 0;
        $depositAmount = $data['deposit_amount'] ?? $plan->deposit_amount ?? 0;

        if ($totalAmount < $depositAmount) {
            return back()->withErrors(['deposit_amount' => 'الدفعة المقدمة أكبر من إجمالي المبلغ.'])->withInput();
        }

        $agreement = InstallmentAgreement::create([
            'installment_plan_id' => $plan->id,
            'student_course_enrollment_id' => $enrollment->id,
            'user_id' => $enrollment->user_id,
            'advanced_course_id' => $enrollment->advanced_course_id,
            'total_amount' => $totalAmount,
            'deposit_amount' => $depositAmount,
            'installments_count' => $data['installments_count'] ?? $plan->installments_count,
            'start_date' => $data['start_date'],
            'status' => $data['status'] ?? InstallmentAgreement::STATUS_ACTIVE,
            'notes' => $data['notes'] ?? null,
            'created_by' => $request->user()?->id,
        ]);

        $agreement->payments()->delete();
        $agreement->generateSchedule(Carbon::parse($agreement->start_date));

        return redirect()->route('admin.installments.agreements.show', $agreement)->with('success', 'تم إنشاء اتفاقية التقسيط وجدول السداد بنجاح.');
    }

    public function show(InstallmentAgreement $agreement): View
    {
        $agreement->load(['student', 'course', 'plan', 'payments' => function ($query) {
            $query->orderBy('sequence_number');
        }]);

        $statuses = $this->statusOptions();
        $paymentStatuses = $this->paymentStatuses();
        $frequencyUnits = $this->frequencyUnits();

        return view('admin.installments.agreements.show', compact('agreement', 'statuses', 'paymentStatuses', 'frequencyUnits'));
    }

    public function edit(InstallmentAgreement $agreement): View
    {
        $plans = InstallmentPlan::active()->with('course')->orderBy('name')->get();
        $statuses = $this->statusOptions();

        return view('admin.installments.agreements.edit', compact('agreement', 'plans', 'statuses'));
    }

    public function update(Request $request, InstallmentAgreement $agreement): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys($this->statusOptions()))],
            'notes' => ['nullable', 'string'],
        ]);

        $agreement->update($data);

        return back()->with('success', 'تم تحديث حالة الاتفاقية بنجاح.');
    }

    public function destroy(InstallmentAgreement $agreement): RedirectResponse
    {
        $agreement->update(['status' => InstallmentAgreement::STATUS_CANCELLED]);
        $agreement->payments()->update(['status' => InstallmentPayment::STATUS_SKIPPED]);

        return redirect()->route('admin.installments.agreements.index')->with('success', 'تم إلغاء اتفاقية التقسيط.');
    }

    public function markPayment(Request $request, InstallmentPayment $installmentPayment): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', array_keys($this->paymentStatuses()))],
            'paid_at' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'in:cash,card,bank_transfer,online,wallet,other'],
            'notes' => ['nullable', 'string'],
        ]);

        try {
            DB::beginTransaction();

            // التأكد من تحميل العلاقات
            $installmentPayment->load('agreement');
            $agreement = $installmentPayment->agreement;

            if ($data['status'] === InstallmentPayment::STATUS_PAID) {
                // التحقق من عدم وجود Payment مرتبط بالفعل
                if (!$installmentPayment->payment_id) {
                    // إنشاء أو الحصول على Invoice للتقسيط
                    $enrollment = $agreement->enrollment ?? null;
                    $invoice = $enrollment && $enrollment->invoice_id 
                        ? Invoice::find($enrollment->invoice_id)
                        : null;
                    
                    // إذا لم يكن هناك Invoice، أنشئ واحدة
                    if (!$invoice) {
                        $invoice = Invoice::create([
                            'invoice_number' => Invoice::generateInvoiceNumber(),
                            'user_id' => $agreement->user_id,
                            'type' => 'course',
                            'description' => 'فاتورة تقسيط - ' . ($agreement->course->title ?? 'كورس'),
                            'subtotal' => $installmentPayment->amount,
                            'tax_amount' => 0,
                            'discount_amount' => 0,
                            'total_amount' => $installmentPayment->amount,
                            'status' => 'paid',
                            'due_date' => $installmentPayment->due_date,
                            'paid_at' => isset($data['paid_at']) && $data['paid_at'] ? Carbon::parse($data['paid_at']) : now(),
                            'notes' => 'فاتورة قسط تقسيط رقم: ' . $installmentPayment->sequence_number,
                            'items' => [
                                [
                                    'description' => 'قسط تقسيط - ' . ($agreement->course->title ?? 'كورس'),
                                    'quantity' => 1,
                                    'price' => $installmentPayment->amount,
                                    'total' => $installmentPayment->amount,
                                ]
                            ],
                        ]);
                    }

                    // إنشاء Payment
                    $payment = Payment::create([
                        'payment_number' => Payment::generatePaymentNumber(),
                        'invoice_id' => $invoice->id,
                        'user_id' => $agreement->user_id,
                        'payment_method' => $data['payment_method'] ?? 'cash',
                        'amount' => $installmentPayment->amount,
                        'currency' => 'EGP',
                        'status' => 'completed',
                        'paid_at' => isset($data['paid_at']) && $data['paid_at'] ? Carbon::parse($data['paid_at']) : now(),
                        'processed_by' => auth()->id(),
                        'installment_payment_id' => $installmentPayment->id,
                        'notes' => 'دفعة قسط تقسيط رقم: ' . $installmentPayment->sequence_number . (isset($data['notes']) && $data['notes'] ? ' - ' . $data['notes'] : ''),
                    ]);

                    // إنشاء Transaction
                    Transaction::create([
                        'transaction_number' => Transaction::generateTransactionNumber(),
                        'user_id' => $agreement->user_id,
                        'payment_id' => $payment->id,
                        'invoice_id' => $invoice->id,
                        'expense_id' => null,
                        'subscription_id' => null,
                        'type' => 'credit', // دائن (إيراد)
                        'category' => 'course_payment',
                        'amount' => $installmentPayment->amount,
                        'currency' => 'EGP',
                        'description' => 'دفعة قسط تقسيط - ' . ($agreement->course->title ?? 'كورس') . ' - قسط رقم: ' . $installmentPayment->sequence_number,
                        'status' => 'completed',
                        'metadata' => [
                            'installment_agreement_id' => $agreement->id,
                            'installment_payment_id' => $installmentPayment->id,
                            'sequence_number' => $installmentPayment->sequence_number,
                        ],
                        'created_by' => auth()->id(),
                    ]);

                    // ربط InstallmentPayment بالPayment
                    $installmentPayment->payment_id = $payment->id;
                }
            }

            // تحديث السجل - استخدام update() مباشرة مع القيم
            $updateData = [
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ];
            
            if ($data['status'] === InstallmentPayment::STATUS_PAID) {
                $updateData['paid_at'] = isset($data['paid_at']) && $data['paid_at'] 
                    ? Carbon::parse($data['paid_at']) 
                    : now();
            } else {
                $updateData['paid_at'] = null;
            }
            
            if (isset($installmentPayment->payment_id) && $installmentPayment->payment_id) {
                $updateData['payment_id'] = $installmentPayment->payment_id;
            }
            
            $installmentPayment->update($updateData);

            // تحديث حالة الاتفاقية
            $installmentPayment->agreement->refreshStatus();

            DB::commit();

            return back()->with('success', 'تم تحديث حالة القسط بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء تحديث حالة القسط: ' . $e->getMessage());
        }
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'installment_plan_id' => ['required', 'exists:installment_plans,id'],
            'student_course_enrollment_id' => ['required', 'exists:student_course_enrollments,id'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
            'installments_count' => ['nullable', 'integer', 'min:1', 'max:60'],
            'start_date' => ['required', 'date'],
            'status' => ['nullable', 'in:' . implode(',', array_keys($this->statusOptions()))],
            'notes' => ['nullable', 'string'],
        ]);
    }

    protected function statusOptions(): array
    {
        return [
            InstallmentAgreement::STATUS_ACTIVE => 'نشط',
            InstallmentAgreement::STATUS_OVERDUE => 'متأخر',
            InstallmentAgreement::STATUS_COMPLETED => 'مكتمل',
            InstallmentAgreement::STATUS_CANCELLED => 'ملغى',
        ];
    }

    protected function paymentStatuses(): array
    {
        return [
            InstallmentPayment::STATUS_PENDING => 'قيد الانتظار',
            InstallmentPayment::STATUS_PAID => 'مدفوع',
            InstallmentPayment::STATUS_OVERDUE => 'متأخر',
            InstallmentPayment::STATUS_SKIPPED => 'متجاوز',
        ];
    }

    protected function frequencyUnits(): array
    {
        return [
            'month' => 'شهري',
            'week' => 'أسبوعي',
            'day' => 'يومي',
            'year' => 'سنوي',
        ];
    }
}
