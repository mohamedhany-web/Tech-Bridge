<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tech Bridge - أكاديمية البرمجة')</title>

    <!-- الخطوط العربية -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles from welcome.blade.php -->
    @include('layouts.public-styles')
</head>

<body class="bg-white text-slate-800"
      x-data="{ mobileMenu: false }"
      :class="{ 'no-scroll': mobileMenu }">

    @include('components.public-navbar')

    <!-- Main Content - مسافة علوية لتفادي النافبار الثابت -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.public-footer')

    @stack('scripts')

    <script>
        // تأثير الناف بار عند السكرول - شفافية مع نص واضح
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            if (navbar) {
                window.addEventListener('scroll', function() {
                    const currentScroll = window.pageYOffset;
                    
                    if (currentScroll > 100) {
                        navbar.classList.add('navbar-scrolled');
                    } else {
                        navbar.classList.remove('navbar-scrolled');
                    }
                });
            }
        });
    </script>
</body>
</html>

