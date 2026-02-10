@extends('layouts.public')

@section('title', 'تواصل معنا - Tech Bridge')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient min-h-[50vh] flex items-center relative overflow-hidden pt-28" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.85) 25%, rgba(14, 165, 233, 0.7) 50%, rgba(14, 165, 233, 0.75) 75%, rgba(2, 132, 199, 0.8) 100%);">
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-6 fade-in" style="text-shadow: 0 4px 16px rgba(0,0,0,0.8), 0 2px 8px rgba(0,0,0,0.6), 0 0 12px rgba(14, 165, 233, 0.4);">
            تواصل معنا
        </h1>
        <p class="text-xl md:text-2xl text-white mb-10 fade-in font-semibold" style="text-shadow: 0 3px 12px rgba(0,0,0,0.7), 0 1px 6px rgba(0,0,0,0.5), 0 0 8px rgba(14, 165, 233, 0.3);">
            نحن هنا للإجابة على استفساراتك
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <!-- Contact Form -->
            <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-paper-plane text-sky-500 ml-3"></i>
                    أرسل رسالتك
                </h2>
                
                @if(session('success'))
                <div class="bg-green-100 border-r-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fas fa-check-circle ml-2"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('public.contact.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">الاسم</label>
                            <input type="text" name="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                            <input type="email" name="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف (اختياري)</label>
                            <input type="tel" name="phone"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">الموضوع</label>
                            <input type="text" name="subject" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">الرسالة</label>
                            <textarea name="message" rows="6" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all"></textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center">
                            <i class="fas fa-paper-plane ml-2"></i>
                            إرسال الرسالة
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-lg p-8 card-hover">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-sky-500 ml-3"></i>
                        معلومات التواصل
                    </h2>
                    <div class="space-y-6">
                        <div class="flex items-start card-hover p-4 rounded-lg">
                            <div class="w-14 h-14 bg-gradient-to-br from-sky-400 to-sky-600 rounded-lg flex items-center justify-center ml-4 shadow-lg">
                                <i class="fas fa-map-marker-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">العنوان</h3>
                                <p class="text-gray-600">123 شارع الأكاديمية، مدينة المعرفة</p>
                            </div>
                        </div>
                        <div class="flex items-start card-hover p-4 rounded-lg">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center ml-4 shadow-lg">
                                <i class="fas fa-phone text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">الهاتف</h3>
                                <p class="text-gray-600">+20 100 123 4567</p>
                            </div>
                        </div>
                        <div class="flex items-start card-hover p-4 rounded-lg">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-lg flex items-center justify-center ml-4 shadow-lg">
                                <i class="fas fa-envelope text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">البريد الإلكتروني</h3>
                                <p class="text-gray-600">info@techbridge.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl shadow-lg p-8 card-hover">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-clock text-sky-500 ml-3"></i>
                        ساعات العمل
                    </h2>
                    <div class="space-y-3 text-gray-700">
                        <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                            <span class="font-semibold">الأحد - الخميس</span>
                            <span>9:00 ص - 6:00 م</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                            <span class="font-semibold">الجمعة</span>
                            <span class="text-red-500">مغلق</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                            <span class="font-semibold">السبت</span>
                            <span>10:00 ص - 2:00 م</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
