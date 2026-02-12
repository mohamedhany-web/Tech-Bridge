<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\StudentCourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * عرض قائمة الطلبات
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'course.academicSubject', 'course.academicYear']);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة حسب طريقة الدفع
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // البحث (مستخدم مسجل أو ضيف)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%");
                })
                ->orWhere('guest_name', 'like', "%{$search}%")
                ->orWhere('guest_email', 'like', "%{$search}%")
                ->orWhere('guest_phone', 'like', "%{$search}%")
                ->orWhereHas('course', function ($cq) use ($search) {
                    $cq->where('title', 'like', "%{$search}%");
                });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        // إحصائيات سريعة
        $stats = [
            'total' => Order::count(),
            'pending' => Order::pending()->count(),
            'approved' => Order::approved()->count(),
            'rejected' => Order::rejected()->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * عرض تفاصيل الطلب
     */
    public function show(Order $order)
    {
        $order->load(['user', 'course.academicSubject', 'course.academicYear', 'approver']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * الموافقة على الطلب
     */
    public function approve(Request $request, Order $order)
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return back()->with('error', 'لا يمكن الموافقة على هذا الطلب');
        }

        try {
            DB::beginTransaction();

            // التحقق من عدم وجود فاتورة للطلب مسبقاً
            if ($order->invoice_id) {
                return back()->with('error', 'تم إنشاء فاتورة لهذا الطلب مسبقاً');
            }

            // إذا كان طلب ضيف: إنشاء حساب طالب وربطه بالطلب
            if ($order->isGuestOrder()) {
                $existingUser = \App\Models\User::where('email', $order->guest_email)->first();
                if ($existingUser) {
                    $order->update(['user_id' => $existingUser->id]);
                } else {
                    $student = \App\Models\User::create([
                        'name' => $order->guest_name,
                        'email' => $order->guest_email,
                        'phone' => $order->guest_phone,
                        'password' => bcrypt(\Illuminate\Support\Str::random(12)),
                        'role' => 'student',
                    ]);
                    $order->update(['user_id' => $student->id]);
                }
            }

            // إنشاء الفاتورة تلقائياً
            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'user_id' => $order->user_id,
                'type' => 'course',
                'description' => 'فاتورة تسجيل في الكورس: ' . ($order->course->title ?? 'كورس'),
                'subtotal' => $order->amount,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $order->amount,
                'status' => 'paid', // تم الدفع لأنه تم قبول الطلب
                'due_date' => now(),
                'paid_at' => now(),
                'notes' => 'فاتورة مسبقة الدفع - من طلب رقم: ' . $order->id,
                'items' => [
                    [
                        'description' => 'تسجيل في الكورس: ' . ($order->course->title ?? 'كورس'),
                        'quantity' => 1,
                        'price' => $order->amount,
                        'total' => $order->amount,
                    ]
                ],
            ]);

            // إنشاء المدفوعات تلقائياً
            // تحويل طريقة الدفع من order إلى payment
            $paymentMethodMap = [
                'bank_transfer' => 'bank_transfer',
                'cash' => 'cash',
                'card' => 'card',
                'online' => 'online',
                'wallet' => 'wallet',
                'other' => 'other',
            ];
            $paymentMethod = $paymentMethodMap[$order->payment_method] ?? 'other';
            // قيم payment_method المسموحة في جدول التسجيلات (بدون other)
            $enrollmentPaymentMethods = ['cash', 'card', 'bank_transfer', 'online', 'wallet', 'subscription', 'free'];
            $paymentMethodForEnrollment = in_array($paymentMethod, $enrollmentPaymentMethods) ? $paymentMethod : null;

            $payment = Payment::create([
                'payment_number' => Payment::generatePaymentNumber(),
                'invoice_id' => $invoice->id,
                'user_id' => $order->user_id,
                'payment_method' => $paymentMethod,
                'amount' => $order->amount,
                'currency' => 'EGP',
                'status' => 'completed',
                'paid_at' => now(),
                'processed_by' => auth()->id(),
                'notes' => 'دفعة من طلب رقم: ' . $order->id . ($order->wallet_id ? ' - محفظة: ' . $order->wallet_id : ''),
            ]);

            // ربط المدفوعات بالمحفظة إذا كانت موجودة وإضافة المبلغ للمحفظة
            $wallet = null;
            if ($order->wallet_id) {
                $payment->update([
                    'wallet_id' => $order->wallet_id,
                ]);

                // إضافة المبلغ للمحفظة (إيداع)
                $wallet = \App\Models\Wallet::find($order->wallet_id);
                if ($wallet) {
                    try {
                        // تحديث transaction_id بعد إنشاء المعاملة المالية
                        $wallet->deposit(
                            $order->amount,
                            $payment->id,
                            null, // transaction_id سيتم ربطه لاحقاً بعد إنشاء المعاملة المالية
                            'إيداع من طلب رقم: ' . $order->id . ' - فاتورة: ' . $invoice->invoice_number . ' - الكورس: ' . ($order->course->title ?? 'كورس')
                        );
                    } catch (\Exception $e) {
                        \Log::error('Error depositing to wallet: ' . $e->getMessage());
                        \Log::error('Stack trace: ' . $e->getTraceAsString());
                        // لا نوقف العملية في حالة فشل الإيداع
                    }
                }
            }

            // إنشاء معاملة مالية (إيراد)
            $transaction = Transaction::create([
                'transaction_number' => Transaction::generateTransactionNumber(),
                'user_id' => $order->user_id,
                'payment_id' => $payment->id,
                'invoice_id' => $invoice->id,
                'expense_id' => null,
                'subscription_id' => null,
                'type' => 'credit', // دائن (إيراد)
                'category' => 'course_payment',
                'amount' => $order->amount,
                'currency' => 'EGP',
                'description' => 'دفعة مقابل تسجيل في الكورس: ' . ($order->course->title ?? 'كورس') . ' - طلب رقم: ' . $order->id . ' - فاتورة: ' . $invoice->invoice_number . ($wallet ? ' - محفظة: ' . $wallet->name : ''),
                'status' => 'completed',
                'metadata' => [
                    'order_id' => $order->id,
                    'invoice_id' => $invoice->id,
                    'payment_id' => $payment->id,
                    'course_id' => $order->advanced_course_id,
                    'wallet_id' => $order->wallet_id,
                ],
                'created_by' => auth()->id(),
            ]);

            // ربط معاملة المحفظة بالمعاملة المالية إذا كانت موجودة
            if ($wallet) {
                try {
                    // البحث عن معاملة المحفظة (بدون استخدام payment_id إذا لم يكن موجوداً)
                    $walletTransactionQuery = \App\Models\WalletTransaction::where('wallet_id', $wallet->id)
                        ->where('type', 'deposit')
                        ->whereNull('transaction_id')
                        ->latest();
                    
                    // إضافة payment_id فقط إذا كان العمود موجوداً
                    if (\Schema::hasColumn('wallet_transactions', 'payment_id')) {
                        $walletTransactionQuery->where('payment_id', $payment->id);
                    }
                    
                    $walletTransaction = $walletTransactionQuery->first();
                    
                    if ($walletTransaction) {
                        $walletTransaction->update(['transaction_id' => $transaction->id]);
                    }
                } catch (\Exception $e) {
                    \Log::warning('Error linking wallet transaction: ' . $e->getMessage());
                    // لا نوقف العملية في حالة فشل الربط
                }
            }

            // تحديث حالة الطلب وربطه بالفاتورة والمدفوعات
            $order->update([
                'status' => Order::STATUS_APPROVED,
                'approved_at' => now(),
                'approved_by' => auth()->id(),
                'invoice_id' => $invoice->id,
                'payment_id' => $payment->id,
            ]);

            // تحديث حالة الإحالة إذا كانت موجودة
            $referralService = app(\App\Services\ReferralService::class);
            $referral = \App\Models\Referral::where('referred_id', $order->user_id)
                ->where('status', \App\Models\Referral::STATUS_PENDING)
                ->first();
            
            if ($referral) {
                $referralService->markReferralAsCompleted($referral, $order->amount);
            }

            // التحقق من وجود تسجيل مسبق
            $existingEnrollment = StudentCourseEnrollment::where('user_id', $order->user_id)
                ->where('advanced_course_id', $order->advanced_course_id)
                ->first();

            if (!$existingEnrollment) {
                // تسجيل الطالب في الكورس مع ربطه بالفاتورة والمدفوعات
                StudentCourseEnrollment::create([
                    'user_id' => $order->user_id,
                    'advanced_course_id' => $order->advanced_course_id,
                    'enrolled_at' => now(),
                    'activated_at' => now(),
                    'activated_by' => auth()->id(),
                    'status' => 'active',
                    'progress' => 0,
                    'invoice_id' => $invoice->id,
                    'payment_id' => $payment->id,
                    'payment_method' => $paymentMethodForEnrollment,
                    'final_price' => $order->amount,
                ]);
            } else {
                // تفعيل التسجيل إذا كان موجود ولكن غير مفعل
                $existingEnrollment->update([
                    'status' => 'active',
                    'activated_at' => now(),
                    'activated_by' => auth()->id(),
                    'invoice_id' => $invoice->id,
                    'payment_id' => $payment->id,
                    'payment_method' => $paymentMethodForEnrollment,
                    'final_price' => $order->amount,
                ]);
            }

            DB::commit();

            return back()->with('success', 'تمت الموافقة على الطلب وتم تفعيل الكورس للطالب. تم إنشاء الفاتورة رقم: ' . $invoice->invoice_number . ' والمدفوعات رقم: ' . $payment->payment_number);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error approving order: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Order ID: ' . $order->id);
            
            return back()->with('error', 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage());
        }
    }

    /**
     * رفض الطلب
     */
    public function reject(Request $request, Order $order)
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return back()->with('error', 'لا يمكن رفض هذا الطلب');
        }

        try {
            DB::beginTransaction();

            // إذا كان الطلب مرتبطاً بمحفظة وتم قبوله مسبقاً (أي تم إيداع المبلغ)
            // يجب سحب المبلغ من المحفظة عند الرفض
            if ($order->wallet_id) {
                $wallet = \App\Models\Wallet::find($order->wallet_id);
                if ($wallet) {
                    // البحث عن WalletTransaction المرتبطة بهذا الطلب (من خلال Payment)
                    $payment = Payment::where('invoice_id', $order->invoice_id)
                        ->where('wallet_id', $order->wallet_id)
                        ->first();
                    
                    if ($payment) {
                        $walletTransaction = \App\Models\WalletTransaction::where('payment_id', $payment->id)
                            ->where('type', 'deposit')
                            ->first();
                        
                        if ($walletTransaction && $wallet->balance >= $walletTransaction->amount) {
                            // سحب المبلغ من المحفظة
                            $wallet->withdraw(
                                $walletTransaction->amount,
                                'إلغاء طلب مرفوض رقم: ' . $order->id . ' - فاتورة: ' . ($order->invoice->invoice_number ?? 'N/A')
                            );
                        }
                    }
                }
            }

            $order->update([
                'status' => Order::STATUS_REJECTED,
                'approved_by' => auth()->id(),
            ]);

            DB::commit();
            return back()->with('success', 'تم رفض الطلب' . ($order->wallet_id ? ' وتم سحب المبلغ من المحفظة' : ''));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error rejecting order: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء رفض الطلب: ' . $e->getMessage());
        }
    }
}