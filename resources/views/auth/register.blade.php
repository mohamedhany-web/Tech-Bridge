<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إنشاء حساب - منصة التعلم</title>

    <!-- الخطوط العربية الاحترافية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- تخصيص TailwindCSS -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'arabic': ['IBM Plex Sans Arabic', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome للأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-primary-50 via-white to-secondary-100 dark:from-secondary-900 dark:via-secondary-800 dark:to-secondary-900 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || false }"
      x-init="
          $watch('darkMode', value => {
              localStorage.setItem('darkMode', value);
              if (value) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          });
          if (darkMode) document.documentElement.classList.add('dark');
      ">

    <div class="w-full max-w-lg px-4 space-y-6">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">إنشاء حساب جديد</h2>
            <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-300">انضم إلى منصة التعلم واستكشف عالم المعرفة</p>
        </div>

        <!-- مفتاح الوضع المظلم -->
        <div class="flex justify-center">
            <button @click="darkMode = !darkMode" 
                    class="p-2 rounded-lg bg-white/90 dark:bg-secondary-800 shadow-md hover:shadow-lg transition-all duration-300 border border-secondary-200 dark:border-secondary-700 text-secondary-600 dark:text-secondary-200">
                <i x-show="!darkMode" class="fas fa-moon"></i>
                <i x-show="darkMode" class="fas fa-sun text-amber-400"></i>
            </button>
        </div>

        <!-- نموذج التسجيل -->
        <form class="mt-6 space-y-4 bg-white dark:bg-secondary-800 p-4 sm:p-6 rounded-2xl shadow-xl border border-secondary-200 dark:border-secondary-700/60 w-full max-w-full box-border" 
              action="{{ route('register') }}" method="POST" 
              x-data="{ showPassword: false, showPasswordConfirm: false }">
            @csrf
            
            <div class="space-y-4">
                <!-- ملاحظة: التسجيل متاح فقط للطلاب -->
                <div class="bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-secondary-800 dark:to-secondary-900 border border-primary-200 dark:border-secondary-700 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                            <i class="fas fa-user-graduate text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">تسجيل الطلاب</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">التسجيل متاح فقط للطلاب. إنشاء حسابات المدربين والمديرين يتم من قبل الإدارة.</p>
                        </div>
                    </div>
                </div>

                <!-- الاسم -->
                <div>
                    <label for="name" class="block text-sm font-medium text-secondary-700 dark:text-secondary-200 mb-2">
                        <i class="fas fa-user ml-2"></i>
                        الاسم الكامل
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           required 
                           class="w-full px-4 py-3 border border-secondary-300 dark:border-secondary-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-secondary-700 dark:text-white transition-colors duration-200 @error('name') border-red-500 @enderror" 
                           placeholder="أدخل اسمك الكامل">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- البريد الإلكتروني (مطلوب) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-secondary-700 dark:text-secondary-200 mb-2">
                        <i class="fas fa-envelope ml-2"></i>
                        البريد الإلكتروني
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email') }}"
                           required 
                           class="w-full px-4 py-3 border border-secondary-300 dark:border-secondary-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-secondary-700 dark:text-white transition-colors duration-200 @error('email') border-red-500 @enderror" 
                           placeholder="example@email.com"
                           dir="ltr">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- رقم الهاتف + كود الدولة -->
                @php $countryCodes = $countryCodes ?? config('country_codes.list', []); @endphp
                <div x-data="{
                    countryCode: '{{ old('country_code', '20') }}',
                    countries: @json($countryCodes)
                }">
                    <label class="block text-sm font-medium text-secondary-700 dark:text-secondary-200 mb-2">
                        <i class="fas fa-phone ml-2"></i>
                        رقم الهاتف
                    </label>
                    <div class="flex flex-wrap gap-2 w-full">
                        <select name="country_code" 
                                x-model="countryCode"
                                required
                                class="w-full sm:w-auto min-w-0 flex-shrink-0 sm:max-w-[11rem] px-3 py-3 border border-secondary-300 dark:border-secondary-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-secondary-700 dark:text-white text-sm @error('country_code') border-red-500 @enderror"
                                dir="ltr">
                            @forelse($countryCodes as $key => $country)
                                <option value="{{ $key }}" {{ old('country_code', '20') == (string)$key ? 'selected' : '' }}>{{ $country['code'] }} {{ $country['name'] }}</option>
                            @empty
                                <option value="20">+20 مصر</option>
                            @endforelse
                        </select>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone') }}"
                               required
                               :placeholder="countries[countryCode] ? countries[countryCode].placeholder : ''"
                               :maxlength="countries[countryCode] ? countries[countryCode].max_length : 15"
                               class="flex-1 min-w-0 sm:min-w-[8rem] px-4 py-3 border border-secondary-300 dark:border-secondary-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-secondary-700 dark:text-white text-sm transition-colors duration-200 @error('phone') border-red-500 @enderror" 
                               dir="ltr">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('country_code')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- كود الإحالة (اختياري) -->
                @php
                    $referralCode = request()->get('ref') ?? old('referral_code');
                @endphp
                @if($referralCode)
                <div class="bg-gradient-to-r from-sky-50 to-purple-50 dark:from-sky-900/20 dark:to-purple-900/20 border border-sky-200 dark:border-sky-700 rounded-xl p-4">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-gift text-sky-600 dark:text-sky-400"></i>
                        <label for="referral_code" class="block text-sm font-medium text-sky-700 dark:text-sky-300">
                            كود الإحالة (اختياري)
                        </label>
                    </div>
                    <input type="text" 
                           name="referral_code" 
                           id="referral_code" 
                           value="{{ $referralCode }}"
                           readonly
                           class="w-full px-4 py-3 border-2 border-sky-300 dark:border-sky-600 rounded-lg bg-white dark:bg-secondary-700 text-gray-900 dark:text-white font-bold text-center uppercase"
                           placeholder="REF123456">
                    <p class="mt-2 text-xs text-sky-600 dark:text-sky-400">
                        <i class="fas fa-info-circle ml-1"></i>
                        احصل على خصم خاص عند التسجيل باستخدام هذا الكود!
                    </p>
                </div>
                @else
                <div>
                    <label for="referral_code" class="block text-sm font-medium text-secondary-700 dark:text-secondary-200 mb-2">
                        <i class="fas fa-gift ml-2"></i>
                        كود الإحالة (اختياري)
                    </label>
                    <input type="text" 
                           name="referral_code" 
                           id="referral_code" 
                           value="{{ old('referral_code') }}"
                           class="w-full px-4 py-3 border border-secondary-300 dark:border-secondary-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-secondary-700 dark:text-white transition-colors duration-200 uppercase" 
                           placeholder="REF123456"
                           dir="ltr">
                    <p class="mt-1 text-xs text-secondary-500 dark:text-secondary-400">
                        <i class="fas fa-info-circle ml-1"></i>
                        إذا كان لديك كود إحالة، أدخله هنا للحصول على خصم خاص
                    </p>
                </div>
                @endif

                <!-- كلمة المرور -->
                <div>
                    <label for="password" class="block text-sm font-medium text-secondary-700 dark:text-secondary-200 mb-2">
                        <i class="fas fa-lock ml-2"></i>
                        كلمة المرور
                    </label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" 
                               name="password" 
                               id="password" 
                               required 
                               class="w-full px-4 py-3 border border-secondary-300 dark:border-secondary-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-secondary-700 dark:text-white transition-colors duration-200 @error('password') border-red-500 @enderror" 
                               placeholder="أدخل كلمة مرور قوية">
                        <button type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-secondary-400 hover:text-secondary-500 dark:hover:text-secondary-200">
                            <i x-show="!showPassword" class="fas fa-eye"></i>
                            <i x-show="showPassword" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- تأكيد كلمة المرور -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-secondary-700 dark:text-secondary-200 mb-2">
                        <i class="fas fa-lock ml-2"></i>
                        تأكيد كلمة المرور
                    </label>
                    <div class="relative">
                        <input :type="showPasswordConfirm ? 'text' : 'password'" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               required 
                               class="w-full px-4 py-3 border border-secondary-300 dark:border-secondary-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-secondary-700 dark:text-white transition-colors duration-200" 
                               placeholder="أعد إدخال كلمة المرور">
                        <button type="button" 
                                @click="showPasswordConfirm = !showPasswordConfirm" 
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-secondary-400 hover:text-secondary-500 dark:hover:text-secondary-200">
                            <i x-show="!showPasswordConfirm" class="fas fa-eye"></i>
                            <i x-show="showPasswordConfirm" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <!-- موافقة على الشروط -->
                <div class="flex items-start">
                    <input type="checkbox" 
                           id="terms" 
                           required
                           class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded">
                    <label for="terms" class="mr-2 text-sm text-secondary-700 dark:text-secondary-200">
                        أوافق على 
                        <a href="#" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 underline">شروط الاستخدام</a>
                        و
                        <a href="#" class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 underline">سياسة الخصوصية</a>
                    </label>
                </div>
            </div>

            <!-- زر إنشاء الحساب -->
            <div class="flex-shrink-0 pt-2">
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105">
                    <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                        <i class="fas fa-user-plus group-hover:text-primary-100"></i>
                    </span>
                    إنشاء الحساب
                </button>
            </div>

            <!-- رابط تسجيل الدخول -->
            <div class="text-center flex-shrink-0 pt-2">
                <p class="text-sm text-secondary-600 dark:text-secondary-300">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                        سجل الدخول
                    </a>
                </p>
            </div>
        </form>

        <!-- العودة للصفحة الرئيسية -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-secondary-600 dark:text-secondary-300 hover:text-secondary-800 dark:hover:text-white transition-colors duration-200">
                <i class="fas fa-arrow-right ml-2"></i>
                العودة للصفحة الرئيسية
            </a>
        </div>
    </div>
</body>
</html>
