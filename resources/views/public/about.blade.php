@extends('layouts.public')

@section('title', 'من نحن - Tech Bridge')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient min-h-[60vh] flex items-center relative overflow-hidden pt-28 sm:pt-32"
         style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.85) 25%, rgba(14, 165, 233, 0.7) 50%, rgba(14, 165, 233, 0.75) 75%, rgba(2, 132, 199, 0.8) 100%);">
    <!-- Background Particles -->
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 6s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 8s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 10s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 12s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 14s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 16s;"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="text-center text-white">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight slide-in-left">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-sky-500 via-sky-600 to-slate-400 text-glow">من نحن</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed fade-in">
                نحن نؤمن بقوة التعليم في تحويل المستقبل
            </p>
            <p class="text-lg md:text-xl text-white/90 mb-10 fade-in max-w-2xl mx-auto">
                نقدم تعليماً برمجياً عالي الجودة يجمع بين النظرية والتطبيق العملي
            </p>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">
            <!-- Vision Card -->
            <div class="group relative">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 card-hover border border-gray-100 h-full">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-sky-400/10 to-sky-600/5 rounded-bl-full"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-sky-500 to-sky-700 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-eye text-white text-2xl"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">رؤيتنا</h2>
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-4">
                            نطمح لأن نكون الرائدين في مجال التعليم البرمجي في المنطقة، حيث نقدم تعليماً عالي الجودة
                            يجمع بين النظرية والتطبيق العملي.
                        </p>
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed">
                            نسعى لتخريج جيل من المبرمجين المحترفين القادرين على المنافسة في السوق العالمي.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mission Card -->
            <div class="group relative">
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-10 card-hover border border-gray-100 h-full">
                    <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-blue-600/5 rounded-br-full"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-bullseye text-white text-2xl"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">مهمتنا</h2>
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-6">
                            مهمتنا هي تقديم أفضل تجربة تعليمية في البرمجة والتطوير، مع التركيز على:
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start group/item">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-sky-400 to-sky-600 rounded-lg flex items-center justify-center ml-4 mt-1 group-hover/item:scale-110 transition-transform">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <span class="text-gray-700 text-base md:text-lg pt-1">تعليم عملي يواكب أحدث التقنيات</span>
                            </li>
                            <li class="flex items-start group/item">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-sky-400 to-sky-600 rounded-lg flex items-center justify-center ml-4 mt-1 group-hover/item:scale-110 transition-transform">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <span class="text-gray-700 text-base md:text-lg pt-1">دعم مستمر ومتابعة شخصية</span>
                            </li>
                            <li class="flex items-start group/item">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-sky-400 to-sky-600 rounded-lg flex items-center justify-center ml-4 mt-1 group-hover/item:scale-110 transition-transform">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <span class="text-gray-700 text-base md:text-lg pt-1">بيئة تعليمية محفزة ومبتكرة</span>
                            </li>
                            <li class="flex items-start group/item">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-sky-400 to-sky-600 rounded-lg flex items-center justify-center ml-4 mt-1 group-hover/item:scale-110 transition-transform">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <span class="text-gray-700 text-base md:text-lg pt-1">شهادات معتمدة ومعترف بها</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mb-20">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 text-center mb-12">
                <span class="bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">إحصائياتنا</span>
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="group relative">
                    <div class="bg-gradient-to-br from-sky-50 via-white to-sky-50 rounded-2xl shadow-xl p-8 text-center card-hover border-2 border-sky-200/50 hover:border-sky-400 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-sky-500 to-sky-700 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-book text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-sky-600 to-sky-700 bg-clip-text text-transparent mb-2">{{ $stats['courses'] ?? 50 }}+</div>
                        <div class="text-gray-700 font-semibold text-base md:text-lg">كورس متاح</div>
                    </div>
                </div>
                <div class="group relative">
                    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-50 rounded-2xl shadow-xl p-8 text-center card-hover border-2 border-blue-200/50 hover:border-blue-400 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent mb-2">{{ $stats['students'] ?? 1000 }}+</div>
                        <div class="text-gray-700 font-semibold text-base md:text-lg">طالب نشط</div>
                    </div>
                </div>
                <div class="group relative">
                    <div class="bg-gradient-to-br from-indigo-50 via-white to-indigo-50 rounded-2xl shadow-xl p-8 text-center card-hover border-2 border-indigo-200/50 hover:border-indigo-400 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-indigo-600 to-indigo-700 bg-clip-text text-transparent mb-2">{{ $stats['instructors'] ?? 20 }}+</div>
                        <div class="text-gray-700 font-semibold text-base md:text-lg">مدرس محترف</div>
                    </div>
                </div>
                <div class="group relative">
                    <div class="bg-gradient-to-br from-green-50 via-white to-green-50 rounded-2xl shadow-xl p-8 text-center card-hover border-2 border-green-200/50 hover:border-green-400 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg">
                            <i class="fas fa-star text-white text-2xl"></i>
                        </div>
                        <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent mb-2">100%</div>
                        <div class="text-gray-700 font-semibold text-base md:text-lg">رضا العملاء</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mb-20">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 text-center mb-12">
                <span class="bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">قيمنا الأساسية</span>
            </h2>
            <div class="bg-gradient-to-br from-white via-gray-50 to-white rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="group text-center card-hover p-8 rounded-2xl bg-white/50 hover:bg-white transition-all duration-300">
                        <div class="relative w-24 h-24 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fas fa-lightbulb text-white text-4xl"></i>
                            <div class="absolute inset-0 bg-gradient-to-br from-yellow-300/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3">الابتكار</h3>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed">نواكب أحدث التقنيات والمناهج التعليمية العالمية لنقدم تجربة تعليمية متطورة</p>
                    </div>
                    <div class="group text-center card-hover p-8 rounded-2xl bg-white/50 hover:bg-white transition-all duration-300">
                        <div class="relative w-24 h-24 bg-gradient-to-br from-sky-400 to-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fas fa-award text-white text-4xl"></i>
                            <div class="absolute inset-0 bg-gradient-to-br from-sky-300/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3">الجودة</h3>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed">نلتزم بأعلى معايير الجودة في التعليم والتدريب لتخريج مبرمجين محترفين</p>
                    </div>
                    <div class="group text-center card-hover p-8 rounded-2xl bg-white/50 hover:bg-white transition-all duration-300">
                        <div class="relative w-24 h-24 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                            <i class="fas fa-heart text-white text-4xl"></i>
                            <div class="absolute inset-0 bg-gradient-to-br from-red-300/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3">الشغف</h3>
                        <p class="text-gray-600 text-base md:text-lg leading-relaxed">نحب ما نفعله ونؤمن بقوة التعليم في تحويل حياة الطلاب وتطوير مهاراتهم</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us Section -->
        <div class="mb-20">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 text-center mb-12">
                <span class="bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">لماذا نحن؟</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-sky-50 to-white rounded-2xl p-8 shadow-xl border border-sky-100 card-hover">
                    <div class="flex items-start">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-700 rounded-xl flex items-center justify-center ml-4 flex-shrink-0 shadow-lg">
                            <i class="fas fa-code text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3">محتوى حديث ومتطور</h3>
                            <p class="text-gray-700 text-base md:text-lg leading-relaxed">نقدم محتوى تعليمي محدث باستمرار ليتوافق مع أحدث التقنيات والمتطلبات في سوق العمل</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl p-8 shadow-xl border border-blue-100 card-hover">
                    <div class="flex items-start">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center ml-4 flex-shrink-0 shadow-lg">
                            <i class="fas fa-user-tie text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3">مدربون محترفون</h3>
                            <p class="text-gray-700 text-base md:text-lg leading-relaxed">فريق من المدربين المحترفين ذوي الخبرة الواسعة في المجال البرمجي</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-8 shadow-xl border border-indigo-100 card-hover">
                    <div class="flex items-start">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center ml-4 flex-shrink-0 shadow-lg">
                            <i class="fas fa-headset text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3">دعم فني مستمر</h3>
                            <p class="text-gray-700 text-base md:text-lg leading-relaxed">نوفر دعم فني وتعليمي مستمر على مدار الساعة لمساعدتك في رحلتك التعليمية</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl p-8 shadow-xl border border-purple-100 card-hover">
                    <div class="flex items-start">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center ml-4 flex-shrink-0 shadow-lg">
                            <i class="fas fa-certificate text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900 mb-3">شهادات معتمدة</h3>
                            <p class="text-gray-700 text-base md:text-lg leading-relaxed">احصل على شهادات معتمدة ومعترف بها عند إتمامك للكورسات بنجاح</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-gradient-to-r from-sky-600 via-sky-500 to-blue-600 text-white text-center relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 text-white">
                ابدأ رحلتك معنا اليوم!
            </h2>
            <p class="text-xl md:text-2xl text-white/95 mb-10">
                انضم إلى آلاف الطلاب الذين يغيرون مستقبلهم معنا
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('register') }}" class="btn-primary text-lg">
                    <i class="fas fa-user-plus"></i>
                    سجل الآن مجاناً
                </a>
                <a href="{{ route('public.courses') }}" class="btn-outline text-lg text-white border-white hover:bg-white hover:text-gray-900">
                    <i class="fas fa-book"></i>
                    استعرض الكورسات
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
