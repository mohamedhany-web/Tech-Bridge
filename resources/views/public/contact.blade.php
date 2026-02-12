@extends('layouts.public')

@section('title', 'تواصل معنا - Tech Bridge')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="section-title text-3xl md:text-4xl mb-3">
            تواصل <span class="logo-text-gradient">معنا</span>
        </h1>
        <p class="section-subtitle text-lg">
            نحن هنا للإجابة على استفساراتك
        </p>
    </div>
</section>

<!-- Contact -->
<section class="py-16 sm:py-20 bg-white border-b border-slate-200/80">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Form -->
            <div class="page-card card-hover p-8 rounded-2xl">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-paper-plane text-sky-500"></i>
                    أرسل رسالتك
                </h2>

                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('public.contact.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">الاسم</label>
                            <input type="text" name="name" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">البريد الإلكتروني</label>
                            <input type="email" name="email" required
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">رقم الهاتف (اختياري)</label>
                            <input type="tel" name="phone"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">الموضوع</label>
                            <input type="text" name="subject" required
                                   value="{{ old('subject', request('subject')) }}"
                                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all"
                                   placeholder="مثال: طلب شراء كورس، استفسار...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">الرسالة</label>
                            <textarea name="message" rows="5" required
                                      class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all"></textarea>
                        </div>
                        <button type="submit" class="btn-page-primary w-full justify-center">
                            <i class="fas fa-paper-plane"></i>
                            إرسال الرسالة
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info -->
            <div class="space-y-6">
                <div class="page-card card-hover p-8 rounded-2xl">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-info-circle text-sky-500"></i>
                        معلومات التواصل
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50/50">
                            <div class="w-12 h-12 bg-sky-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 mb-1">العنوان</h3>
                                <p class="text-slate-600 text-sm">123 شارع الأكاديمية، مدينة المعرفة</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50/50">
                            <div class="w-12 h-12 bg-sky-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 mb-1">الهاتف</h3>
                                <p class="text-slate-600 text-sm">+20 100 123 4567</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50/50">
                            <div class="w-12 h-12 bg-sky-500 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 mb-1">البريد الإلكتروني</h3>
                                <p class="text-slate-600 text-sm">info@techbridge.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-card card-hover p-6 rounded-2xl">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-clock text-sky-500"></i>
                        ساعات العمل
                    </h2>
                    <div class="space-y-2 text-slate-600 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="font-medium">الأحد - الخميس</span>
                            <span>9:00 ص - 6:00 م</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="font-medium">الجمعة</span>
                            <span class="text-red-500">مغلق</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="font-medium">السبت</span>
                            <span>10:00 ص - 2:00 م</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
