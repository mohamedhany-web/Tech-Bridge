<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AdvancedCourse;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * عرض صفحة طلب شراء الكورس (خارج المنصة - عامة)
     */
    public function showOrderForm($id)
    {
        $course = AdvancedCourse::where('id', $id)
            ->where('is_active', true)
            ->with(['academicSubject', 'academicYear'])
            ->withCount('lessons')
            ->firstOrFail();

        return view('public.order-course', compact('course'));
    }

    /**
     * حفظ طلب الشراء (ضيف أو مسجل)
     */
    public function store(Request $request, $id)
    {
        $course = AdvancedCourse::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        $isGuest = !auth()->check();

        $rules = [
            'payment_method' => 'required|in:bank_transfer,cash,other',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:500',
        ];

        if ($isGuest) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email';
            $rules['phone'] = 'required|string|max:30';
        }

        $request->validate($rules, [
            'payment_method.required' => 'طريقة الدفع مطلوبة',
            'payment_proof.required' => 'صورة إثبات الدفع مطلوبة',
            'payment_proof.image' => 'يجب أن يكون الملف صورة',
            'payment_proof.mimes' => 'صيغة الصورة: jpeg, png أو jpg',
            'payment_proof.max' => 'حجم الصورة لا يتجاوز 2 ميجابايت',
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
        ]);

        if (!$isGuest) {
            $existingApproved = Order::where('user_id', auth()->id())
                ->where('advanced_course_id', $course->id)
                ->where('status', Order::STATUS_APPROVED)
                ->exists();
            if ($existingApproved) {
                return back()->with('error', 'أنت مسجل بالفعل في هذا الكورس');
            }
            $existingPending = Order::where('user_id', auth()->id())
                ->where('advanced_course_id', $course->id)
                ->where('status', Order::STATUS_PENDING)
                ->exists();
            if ($existingPending) {
                return back()->with('error', 'لديك طلب قيد المراجعة لهذا الكورس');
            }
        }

        $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        $originalAmount = $course->price ?? 0;
        $finalAmount = $originalAmount;

        $orderData = [
            'advanced_course_id' => $course->id,
            'original_amount' => $originalAmount,
            'discount_amount' => 0,
            'amount' => $finalAmount,
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
            'notes' => $request->notes ?? '',
            'status' => Order::STATUS_PENDING,
        ];

        if ($isGuest) {
            $orderData['user_id'] = null;
            $orderData['guest_name'] = $request->name;
            $orderData['guest_email'] = $request->email;
            $orderData['guest_phone'] = $request->phone;
        } else {
            $orderData['user_id'] = auth()->id();
        }

        Order::create($orderData);

        return redirect()->route('public.course.show', $course->id)
            ->with('success', 'تم إرسال طلبك بنجاح. سيتم مراجعته من الإدارة والتواصل معك قريباً.');
    }
}
