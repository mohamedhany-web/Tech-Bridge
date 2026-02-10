<!DOCTYPE html>
<html lang="ar" dir="rtl" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - خطأ في الخادم | {{ config('app.name', 'Tech Bridge') }}</title>

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
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .shake-animation {
            animation: shake 0.5s ease-in-out infinite;
        }
        
        @keyframes pulse-red {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .pulse-red {
            animation: pulse-red 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 via-rose-50 to-pink-50 dark:from-slate-900 dark:via-red-900/20 dark:to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full text-center">
        <!-- الرقم 500 -->
        <div class="mb-8">
            <h1 class="text-9xl md:text-[12rem] font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-rose-500 to-pink-600 dark:from-red-300 dark:via-rose-400 dark:to-pink-500">
                500
            </h1>
        </div>

        <!-- الأيقونة -->
        <div class="mb-6 pulse-red">
            <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-red-100 to-rose-100 dark:from-red-900/30 dark:to-rose-900/30">
                <i class="fas fa-exclamation-triangle text-5xl text-red-500 dark:text-red-400 shake-animation"></i>
            </div>
        </div>

        <!-- العنوان -->
        <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4">
            خطأ في الخادم
        </h2>

        <!-- الوصف -->
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 mb-8 max-w-2xl mx-auto">
            عذراً، حدث خطأ داخلي في الخادم.
            <br>
            فريقنا يعمل على إصلاح المشكلة. يرجى المحاولة مرة أخرى لاحقاً.
        </p>

        <!-- الأزرار -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-home"></i>
                <span>العودة للصفحة الرئيسية</span>
            </a>
            
            <button onclick="window.location.reload()" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 font-semibold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-300">
                <i class="fas fa-redo"></i>
                <span>إعادة المحاولة</span>
            </button>
        </div>

        <!-- معلومات إضافية -->
        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-700">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">
                إذا استمرت المشكلة، يرجى التواصل مع الدعم الفني
            </p>
            <a href="{{ url('/contact') }}" 
               class="inline-flex items-center gap-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                <i class="fas fa-headset"></i>
                <span>اتصل بالدعم</span>
            </a>
        </div>
    </div>

    <!-- خلفية ديكورية -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-200 dark:bg-red-900/20 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-rose-200 dark:bg-rose-900/20 rounded-full blur-3xl opacity-20"></div>
    </div>
</body>
</html>
