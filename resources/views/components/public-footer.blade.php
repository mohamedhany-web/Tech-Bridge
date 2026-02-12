<!-- Footer - خلفية بيضاء وألوان اللوجو -->
<footer class="bg-white border-t border-gray-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
            <!-- Logo & Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-16 h-16 bg-transparent rounded-xl flex items-center justify-center p-1">
                        <img src="{{ asset('images/Tech_Bridge_LOGO.png') }}" alt="Tech Bridge Logo" class="w-full h-full object-contain" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-code text-sky-600 text-2xl\'></i>';">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold logo-text-gradient">Tech Bridge</h3>
                        <p class="text-slate-600 text-sm">أكاديمية برمجة</p>
                    </div>
                </div>
                <p class="text-slate-600 mb-6 leading-relaxed text-sm">
                    منصة تعليمية متخصصة في البرمجة تهدف إلى تبسيط مفاهيم البرمجة وجعلها أكثر متعة وفهماً للطلاب في جميع المستويات من المبتدئين إلى المحترفين.
                </p>
                <div class="flex space-x-4 space-x-reverse">
                    <a href="https://www.facebook.com/share/184vKCiPnU/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-100 hover:text-sky-700 flex items-center justify-center transition-colors text-lg" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@tech.bridge.programming?_r=1&_t=ZS-93kQyEQSCBu" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 hover:bg-sky-100 hover:text-sky-700 flex items-center justify-center transition-colors text-lg" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-700 flex items-center justify-center transition-colors text-lg"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-700 flex items-center justify-center transition-colors text-lg"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- معلومات -->
            <div>
                <h4 class="text-lg font-bold mb-6 flex items-center text-slate-800">
                    <i class="fas fa-info-circle text-sky-600 ml-2"></i>
                    معلومات
                </h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('public.about') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-graduation-cap ml-2 text-xs text-sky-500"></i>من نحن</a></li>
                    <li><a href="{{ route('public.team') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-users ml-2 text-xs text-sky-500"></i>الفريق</a></li>
                    <li><a href="{{ route('public.testimonials') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-star ml-2 text-xs text-sky-500"></i>آراء العملاء</a></li>
                    <li><a href="{{ route('public.partners') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-handshake ml-2 text-xs text-sky-500"></i>الشركاء</a></li>
                </ul>
            </div>

            <!-- المحتوى والدعم -->
            <div>
                <h4 class="text-lg font-bold mb-6 flex items-center text-slate-800">
                    <i class="fas fa-book-open text-sky-600 ml-2"></i>
                    المحتوى والدعم
                </h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('public.courses') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-code ml-2 text-xs text-sky-500"></i>الكورسات</a></li>
                    <li><a href="{{ route('public.blog.index') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-newspaper ml-2 text-xs text-sky-500"></i>المدونة</a></li>
                    <li><a href="{{ route('public.events') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-calendar-alt ml-2 text-xs text-sky-500"></i>الفعاليات</a></li>
                    <li><a href="{{ route('public.media.index') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-images ml-2 text-xs text-sky-500"></i>معرض الصور</a></li>
                    <li><a href="{{ route('public.certificates') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-certificate ml-2 text-xs text-sky-500"></i>الشهادات</a></li>
                    <li><a href="{{ route('public.contact') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-envelope ml-2 text-xs text-sky-500"></i>تواصل معنا</a></li>
                    <li><a href="{{ route('public.faq') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-question-circle ml-2 text-xs text-sky-500"></i>الأسئلة الشائعة</a></li>
                    <li><a href="{{ route('public.help') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center"><i class="fas fa-life-ring ml-2 text-xs text-sky-500"></i>مركز المساعدة</a></li>
                </ul>
            </div>

            <!-- معلومات التواصل -->
            <div>
                <h4 class="text-lg font-bold mb-6 flex items-center text-slate-800">
                    <i class="fas fa-map-marker-alt text-sky-600 ml-2"></i>
                    تواصل معنا
                </h4>
                <ul class="space-y-3 text-slate-600 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt ml-3 text-sky-600 mt-1"></i>
                        <span>123 شارع الأكاديمية<br>مدينة المعرفة</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone ml-3 text-sky-600"></i>
                        <span>+20 100 123 4567</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope ml-3 text-sky-600"></i>
                        <span>info@techbridge.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-8 pt-8">
            <div class="text-center mb-4">
                <p class="text-slate-600 text-sm">
                    &copy; {{ date('Y') }} Tech Bridge - أكاديمية برمجة. جميع الحقوق محفوظة.
                </p>
            </div>
            <div class="flex justify-center flex-wrap gap-4 text-sm">
                <a href="{{ route('public.terms') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center">
                    <i class="fas fa-file-contract ml-1 text-xs text-sky-500"></i>
                    الشروط والأحكام
                </a>
                <a href="{{ route('public.privacy') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center">
                    <i class="fas fa-shield-alt ml-1 text-xs text-sky-500"></i>
                    سياسة الخصوصية
                </a>
                <a href="{{ route('public.refund') }}" class="text-slate-600 hover:text-sky-600 transition-colors flex items-center">
                    <i class="fas fa-undo ml-1 text-xs text-sky-500"></i>
                    سياسة الاسترجاع
                </a>
            </div>
        </div>
    </div>
</footer>
