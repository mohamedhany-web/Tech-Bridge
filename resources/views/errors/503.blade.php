<!DOCTYPE html>
<html lang="ar" dir="rtl" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>503 - الخدمة غير متاحة | {{ config('app.name', 'Tech Bridge') }}</title>

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
        
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .spin-slow {
            animation: spin-slow 3s linear infinite;
        }
        
        @keyframes pulse-teal {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        
        .pulse-teal {
            animation: pulse-teal 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-50 via-cyan-50 to-blue-50 dark:from-slate-900 dark:via-teal-900/20 dark:to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full text-center">
        <!-- الرقم 503 -->
        <div class="mb-8">
            <h1 class="text-9xl md:text-[12rem] font-bold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-cyan-500 to-blue-600 dark:from-teal-300 dark:via-cyan-400 dark:to-blue-500">
                503
            </h1>
        </div>

        <!-- الأيقونة -->
        <div class="mb-6 pulse-teal">
            <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/30 dark:to-cyan-900/30 relative">
                <i class="fas fa-tools text-5xl text-teal-500 dark:text-teal-400 spin-slow"></i>
            </div>
        </div>

        <!-- العنوان -->
        <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4">
            الخدمة غير متاحة مؤقتاً
        </h2>

        <!-- الوصف -->
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 mb-8 max-w-2xl mx-auto">
            عذراً، الموقع قيد الصيانة حاليًا.
            <br>
            نحن نعمل على تحسين الخدمة وسنعود قريباً.
        </p>

        <!-- الأزرار -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button onclick="window.location.reload()" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-500/30 hover:shadow-xl hover:shadow-teal-500/40 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-redo"></i>
                <span>إعادة المحاولة</span>
            </button>
            
            <a href="{{ url('/') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 border-2 border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 font-semibold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-300">
                <i class="fas fa-home"></i>
                <span>العودة للصفحة الرئيسية</span>
            </a>
        </div>

        <!-- معلومات إضافية -->
        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-700">
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
                نعتذر عن الإزعاج. يمكنك متابعة آخر التحديثات عبر:
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ url('/blog') }}" 
                   class="text-teal-600 dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300 transition-colors">
                    <i class="fas fa-newspaper mr-1"></i> المدونة
                </a>
                <a href="{{ url('/contact') }}" 
                   class="text-teal-600 dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300 transition-colors">
                    <i class="fas fa-envelope mr-1"></i> اتصل بنا
                </a>
            </div>
        </div>
    </div>

    <!-- خلفية ديكورية -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-teal-200 dark:bg-teal-900/20 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-cyan-200 dark:bg-cyan-900/20 rounded-full blur-3xl opacity-20"></div>
    </div>
</body>
</html>
