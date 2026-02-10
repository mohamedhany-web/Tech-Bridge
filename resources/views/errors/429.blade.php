<!DOCTYPE html>
<html lang="ar" dir="rtl" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>429 - طلبات كثيرة جداً | {{ config('app.name', 'Tech Bridge') }}</title>

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
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .bounce-animation {
            animation: bounce 1s ease-in-out infinite;
        }
        
        @keyframes pulse-violet {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .pulse-violet {
            animation: pulse-violet 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-violet-50 via-fuchsia-50 to-pink-50 dark:from-slate-900 dark:via-violet-900/20 dark:to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full text-center">
        <!-- الرقم 429 -->
        <div class="mb-8">
            <h1 class="text-9xl md:text-[12rem] font-bold text-transparent bg-clip-text bg-gradient-to-r from-violet-400 via-fuchsia-500 to-pink-600 dark:from-violet-300 dark:via-fuchsia-400 dark:to-pink-500">
                429
            </h1>
        </div>

        <!-- الأيقونة -->
        <div class="mb-6 pulse-violet">
            <div class="inline-flex items-center justify-center w-32 h-32 rounded-full bg-gradient-to-br from-violet-100 to-fuchsia-100 dark:from-violet-900/30 dark:to-fuchsia-900/30">
                <i class="fas fa-tachometer-alt text-5xl text-violet-500 dark:text-violet-400 bounce-animation"></i>
            </div>
        </div>

        <!-- العنوان -->
        <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 mb-4">
            طلبات كثيرة جداً
        </h2>

        <!-- الوصف -->
        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 mb-8 max-w-2xl mx-auto">
            عذراً، قمت بإرسال عدد كبير جداً من الطلبات في وقت قصير.
            <br>
            يرجى الانتظار قليلاً ثم المحاولة مرة أخرى.
        </p>

        <!-- الأزرار -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button onclick="setTimeout(() => window.location.reload(), 5000)" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-fuchsia-600 hover:from-violet-700 hover:to-fuchsia-700 text-white font-semibold rounded-xl shadow-lg shadow-violet-500/30 hover:shadow-xl hover:shadow-violet-500/40 transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-clock"></i>
                <span>انتظر 5 ثواني</span>
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
                نصائح لتجنب هذه المشكلة:
            </p>
            <div class="flex flex-wrap justify-center gap-6 text-sm text-slate-600 dark:text-slate-400">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-violet-500"></i>
                    <span>لا تضغط على الأزرار بشكل متكرر</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-violet-500"></i>
                    <span>انتظر حتى يكتمل تحميل الصفحة</span>
                </div>
            </div>
        </div>
    </div>

    <!-- خلفية ديكورية -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-violet-200 dark:bg-violet-900/20 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-fuchsia-200 dark:bg-fuchsia-900/20 rounded-full blur-3xl opacity-20"></div>
    </div>
</body>
</html>
