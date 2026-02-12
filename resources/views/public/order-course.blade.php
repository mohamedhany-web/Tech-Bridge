@extends('layouts.public')

@section('title', 'طلب شراء: ' . ($course->title ?? 'كورس') . ' - Tech Bridge')

@section('content')
<section class="page-hero py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="mb-4 text-slate-600 text-sm">
            <a href="{{ url('/') }}" class="hover:text-sky-600">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.courses') }}" class="hover:text-sky-600">الكورسات</a>
            <span class="mx-2">/</span>
            <a href="{{ route('public.course.show', $course->id) }}" class="hover:text-sky-600">{{ $course->title }}</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800 font-medium">طلب الشراء</span>
        </nav>
        <h1 class="section-title text-2xl md:text-3xl mb-2">طلب شراء الكورس</h1>
        <p class="text-slate-600">أكمل البيانات وإثبات الدفع؛ سيتم مراجعة الطلب والتواصل معك</p>
    </div>
</section>

<section class="py-16 sm:py-20 bg-white border-t border-slate-200/80">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="page-card p-6 sm:p-8 rounded-2xl">
                    @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('public.course.order.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @if(!auth()->check())
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">الاسم الكامل <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('name') border-red-300 @enderror">
                                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">البريد الإلكتروني <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('email') border-red-300 @enderror" dir="ltr">
                                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">رقم الهاتف <span class="text-red-500">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                       class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('phone') border-red-300 @enderror" dir="ltr">
                                @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">طريقة الدفع <span class="text-red-500">*</span></label>
                            <select name="payment_method" required
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('payment_method') border-red-300 @enderror">
                                <option value="">اختر طريقة الدفع</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدي</option>
                                <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('payment_method')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">صورة إثبات الدفع (إيصال تحويل أو صورة) <span class="text-red-500">*</span></label>
                            <input type="file" name="payment_proof" accept="image/jpeg,image/png,image/jpg" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('payment_proof') border-red-300 @enderror">
                            <p class="mt-1 text-xs text-slate-500">صيغ مسموحة: jpeg, png, jpg — الحجم الأقصى 2 ميجابايت</p>
                            @error('payment_proof')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">ملاحظات (اختياري)</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                                      placeholder="أي تفاصيل إضافية عن الدفع أو الطلب">{{ old('notes') }}</textarea>
                            @error('notes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn-page-primary w-full justify-center py-3">
                            <i class="fas fa-paper-plane"></i>
                            إرسال طلب الشراء
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="page-card p-6 rounded-2xl sticky-sidebar">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">ملخص الطلب</h3>
                    <p class="font-bold text-slate-800 mb-2">{{ $course->title }}</p>
                    @if($course->academicSubject)
                    <p class="text-slate-600 text-sm mb-4">{{ $course->academicSubject->name }}</p>
                    @endif
                    <p class="text-slate-500 text-sm mb-2"><i class="fas fa-play-circle text-sky-500 ml-1"></i> {{ $course->lessons_count ?? 0 }} درس</p>
                    <div class="pt-4 border-t border-slate-200">
                        @if(($course->price ?? 0) > 0)
                        <p class="text-2xl font-black text-sky-600">{{ number_format($course->price, 0) }} ج.م</p>
                        @else
                        <p class="text-xl font-bold text-emerald-600">مجاني</p>
                        @endif
                    </div>
                    <a href="{{ route('public.course.show', $course->id) }}" class="mt-4 block text-center text-sky-600 font-medium text-sm hover:text-sky-700">
                        <i class="fas fa-arrow-right ml-1"></i>
                        العودة لصفحة الكورس
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
