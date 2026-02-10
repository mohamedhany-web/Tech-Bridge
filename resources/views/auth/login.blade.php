<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول - Tech Bridge Academy</title>

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

    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">مرحباً بك مرة أخرى</h2>
            <p class="mt-2 text-sm text-secondary-600 dark:text-secondary-300">سجل دخولك للوصول إلى منصة التعلم</p>
        </div>

        <!-- مفتاح الوضع المظلم -->
        <div class="flex justify-center">
            <button @click="darkMode = !darkMode" 
                    class="p-2 rounded-lg bg-white/90 dark:bg-secondary-800 shadow-md hover:shadow-lg transition-all duration-300 border border-secondary-200 dark:border-secondary-700 text-secondary-600 dark:text-secondary-200">
                <i x-show="!darkMode" class="fas fa-moon"></i>
                <i x-show="darkMode" class="fas fa-sun text-amber-400"></i>
            </button>
        </div>

        <!-- نموذج تسجيل الدخول -->
        <form class="mt-8 space-y-6 bg-white dark:bg-secondary-800 p-8 rounded-2xl shadow-xl border border-secondary-200 dark:border-secondary-700/60" 
              action="{{ route('login') }}" method="POST" x-data="{ showPassword: false }">
            @csrf
            
            <div class="space-y-4">
                <!-- البريد الإلكتروني -->
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
                               placeholder="أدخل كلمة المرور">
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

                <!-- خيارات إضافية -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="remember" 
                               id="remember" 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-secondary-300 rounded">
                        <label for="remember" class="mr-2 block text-sm text-secondary-700 dark:text-secondary-200">
                            تذكرني
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                            نسيت كلمة المرور؟
                        </a>
                    </div>
                </div>
            </div>

            <!-- زر تسجيل الدخول -->
            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 transform hover:scale-105">
                    <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                        <i class="fas fa-sign-in-alt group-hover:text-primary-100"></i>
                    </span>
                    تسجيل الدخول
                </button>
            </div>

            <!-- رابط التسجيل -->
            <div class="text-center">
                <p class="text-sm text-secondary-600 dark:text-secondary-300">
                    ليس لديك حساب؟
                    <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                        سجل الآن
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
