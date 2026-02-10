<!DOCTYPE html>
<html lang="ar" dir="rtl" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - غير مصرح | {{ config('app.name', 'Tech Bridge') }}</title>

    <!-- الخطوط العربية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'arabic': ['IBM Plex Sans Arabic', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    
    <style>
        * {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .rotate-animation {
            animation: rotate 20s linear infinite;
        }
        
        @keyframes pulse-amber {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        
        .pulse-amber {
            animation: pulse-amber 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 dark:from-slate-900 dark:via-amber-900/20 dark:to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full text-center">
        <!-- الرقم 403 -->
        <div class="mb-8">
            <h1 class="text-9xl md:text-[12rem] font-bold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-500 to-yellow-600 dark:from-amber-300 dark:via-orange-400 dark:to-yellow-500">
                403
            </h1>
        </div>

        <!-- الأيقونة -->
        <div class="mb-6 pulse-amber">
            <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900/30 dark:to-orange-900/30 relative">
                <i class="fas fa-lock text-5xl text-amber-500 dark:text-amber-400"></i>
                <div class="absolute inset-0 border-4 border-amber-300 dark:border-amber-700 rounded-full rotate-animation opacity-30"></div>
            </div>
        </div>

        <!-- العنوان -->
        <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4">
            غير مصرح بالوصول
        </h2>

        <!-- الوصف -->
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 mb-8 max-w-2xl mx-auto">
            عذراً، ليس لديك صلاحية للوصول إلى هذه الصفحة.
            <br>
            إذا كنت تعتقد أن هذا خطأ، يرجى التواصل مع المسؤول.
        </p>

        <!-- الأزرار -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/30 hover:shadow-xl hover:shadow-amber-500/40 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-home"></i>
                <span>العودة للصفحة الرئيسية</span>
            </a>
            
            <button onclick="window.history.back()" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 font-semibold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-300">
                <i class="fas fa-arrow-right"></i>
                <span>العودة للخلف</span>
            </button>
        </div>

        <!-- معلومات إضافية -->
        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-700">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">
                تحتاج إلى تسجيل الدخول أو الحصول على صلاحيات إضافية؟
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                        <i class="fas fa-tachometer-alt mr-1"></i> لوحة التحكم
                    </a>
                @else
                    <a href="{{ url('/login') }}" 
                       class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                        <i class="fas fa-sign-in-alt mr-1"></i> تسجيل الدخول
                    </a>
                @endauth
                <a href="{{ url('/contact') }}" 
                   class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                    <i class="fas fa-envelope mr-1"></i> اتصل بنا
                </a>
            </div>
        </div>
    </div>

    <!-- خلفية ديكورية -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-amber-200 dark:bg-amber-900/20 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-orange-200 dark:bg-orange-900/20 rounded-full blur-3xl opacity-20"></div>
    </div>
</body>
</html>
