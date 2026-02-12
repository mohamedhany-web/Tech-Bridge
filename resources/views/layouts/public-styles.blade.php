<style>
* {
    font-family: 'Cairo', system-ui, sans-serif;
}

/* ألوان اللوجو: أزرق #0ea5e9 / #0284c7، أحمر #dc2626 / #991b1b، رمادي #475569 */
.logo-text-gradient {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 45%, #dc2626 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-gradient {
    background: linear-gradient(180deg, rgba(224, 242, 254, 0.6) 0%, rgba(255, 255, 255, 1) 40%);
    position: relative;
    overflow: hidden;
}

/* Navbar - لون أزرق صلب وتصميم أوضح */
.navbar-bg {
    background: #0369a1 !important;
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 40%, #0369a1 100%) !important;
}

/* صندوق اللوغو - خلفية بيضاء لظهور اللوغو بوضوح على النافبار الأزرق */
.nav-logo-box {
    width: 52px;
    height: 52px;
    background: #fff;
    padding: 6px;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.12);
    border: 1px solid rgba(255,255,255,0.4);
}
.nav-logo-img {
    object-fit: contain;
    max-width: 100%;
    max-height: 100%;
}

/* نص العلامة في النافبار */
.nav-brand-text { color: #fff !important; font-size: 1.2rem; }
.nav-brand-sub { color: rgba(255,255,255,0.9) !important; }

/* روابط النافبار */
.nav-link-item { text-decoration: none; }
.nav-link-active {
    color: #fff !important;
    background: rgba(255,255,255,0.2);
}

/* أزرار النافبار */
.btn-nav-primary {
    background: #fff;
    color: #0369a1;
    padding: 10px 22px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.btn-nav-primary:hover {
    background: #f0f9ff;
    color: #0284c7;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.btn-nav-ghost {
    color: #fff;
    padding: 10px 18px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid rgba(255,255,255,0.4);
}
.btn-nav-ghost:hover {
    background: rgba(255,255,255,0.15);
    color: #fff;
    border-color: rgba(255,255,255,0.6);
}

/* زر القائمة للموبايل */
.nav-mobile-btn {
    background: rgba(255,255,255,0.1);
    color: #fff;
}

/* درج القائمة الجانبي - موبايل - وضوح كامل للنص والأيقونات */
.mobile-drawer {
    background: #0369a1 !important;
    background-image: linear-gradient(180deg, #0284c7 0%, #0369a1 50%, #0c4a6e 100%) !important;
    border-left: 1px solid rgba(255,255,255,0.25);
    -webkit-overflow-scrolling: touch;
    opacity: 1 !important;
}
/* كل النصوص والأيقونات داخل الدرج أبيض إلا أزرار الخلفية البيضاء */
.mobile-drawer,
.mobile-drawer * {
    box-sizing: border-box;
}
.mobile-drawer-header {
    background: rgba(0,0,0,0.2) !important;
}
.mobile-drawer-header span,
.mobile-drawer-close,
.mobile-drawer-close i {
    color: #ffffff !important;
}
.mobile-drawer-nav .mobile-drawer-link,
.mobile-drawer-nav .mobile-drawer-link span,
.mobile-drawer-nav .mobile-drawer-link i {
    color: #ffffff !important;
    text-decoration: none !important;
    font-weight: 600;
    font-size: 1.05rem;
    transition: background 0.2s ease, color 0.2s ease;
}
.mobile-drawer-nav .mobile-drawer-link:hover {
    background: rgba(255,255,255,0.22) !important;
}
.mobile-drawer-nav .mobile-drawer-link:hover span,
.mobile-drawer-nav .mobile-drawer-link:hover i {
    color: #ffffff !important;
}
.mobile-drawer-link-active {
    background: rgba(255,255,255,0.28) !important;
}
.mobile-drawer-link-active span,
.mobile-drawer-link-active i {
    color: #ffffff !important;
    font-weight: 700;
}
/* زر تسجيل الدخول - حدود بيضاء ونص أبيض واضح */
.mobile-drawer-btn-outline {
    background: transparent !important;
    border: 2px solid #ffffff !important;
    color: #ffffff !important;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.mobile-drawer-btn-outline:hover {
    background: rgba(255,255,255,0.2) !important;
    color: #ffffff !important;
    border-color: #ffffff !important;
}
.mobile-drawer-btn-outline span,
.mobile-drawer-btn-outline i {
    color: #ffffff !important;
}
/* زر إنشاء حساب / لوحة التحكم - خلفية بيضاء ونص أزرق */
.mobile-drawer-btn-primary {
    background: #ffffff !important;
    color: #0369a1 !important;
    text-decoration: none !important;
    transition: all 0.2s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,0.2);
}
.mobile-drawer-btn-primary span,
.mobile-drawer-btn-primary i {
    color: #0369a1 !important;
}
.mobile-drawer-btn-primary:hover {
    background: #f0f9ff !important;
    box-shadow: 0 4px 16px rgba(0,0,0,0.25);
}
.mobile-drawer-btn-primary:hover span,
.mobile-drawer-btn-primary:hover i {
    color: #0284c7 !important;
}
@media (max-width: 1023px) {
    .mobile-drawer {
        max-height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .mobile-drawer nav {
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
    }
    .mobile-drawer nav::-webkit-scrollbar {
        width: 6px;
    }
    .mobile-drawer nav::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.08);
        border-radius: 3px;
    }
    .mobile-drawer nav::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.25);
        border-radius: 3px;
    }
}

#mainNavbar.navbar-scrolled {
    box-shadow: 0 1px 3px rgba(14, 165, 233, 0.08) !important;
}

.btn-outline-public {
    background: transparent;
    color: #0284c7;
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    border: 2px solid #0ea5e9;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.btn-outline-public:hover {
    background: rgba(14, 165, 233, 0.08);
    color: #0284c7;
    border-color: #0284c7;
}


/* أنماط الصفحات العامة (مثل الصفحة الرئيسية) */
.btn-page-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #0284c7;
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    padding: 14px 28px;
    border-radius: 14px;
    border: none;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
}
.btn-page-primary:hover {
    background: #0369a1;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(2, 132, 199, 0.4);
}
.btn-page-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #fff;
    color: #0284c7;
    font-weight: 700;
    font-size: 1rem;
    padding: 14px 28px;
    border-radius: 14px;
    border: 2px solid #0284c7;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-page-secondary:hover {
    background: #f0f9ff;
    color: #0369a1;
    border-color: #0369a1;
    transform: translateY(-2px);
}
.section-title {
    font-size: 1.875rem;
    font-weight: 900;
    color: #0f172a;
}
@media (min-width: 768px) {
    .section-title { font-size: 2.25rem; }
}
.section-subtitle {
    color: #64748b;
    font-size: 1rem;
}
.page-card {
    background: #fff;
    border-radius: 1rem;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.page-card:hover {
    box-shadow: 0 12px 28px rgba(14, 165, 233, 0.1);
    border-color: #bae6fd;
}
.page-hero {
    background: linear-gradient(180deg, rgba(224, 242, 254, 0.7) 0%, rgba(255, 255, 255, 1) 60%);
    padding-top: 6rem;
    padding-bottom: 4rem;
    min-height: 40vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
}

.card-hover {
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.card-hover:hover {
    box-shadow: 0 12px 28px rgba(14, 165, 233, 0.12);
    border-color: #bae6fd;
}

.btn-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 30%, #0369a1 50%, #475569 75%, #dc2626 95%, #991b1b 100%);
    color: white;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(14, 165, 233, 0.5),
                0 2px 10px rgba(220, 38, 38, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    box-shadow: 0 8px 24px rgba(14, 165, 233, 0.45);
}

.btn-secondary {
    background: white;
    color: #0ea5e9;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.4s ease;
    border: 2px solid #0ea5e9;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 35%, #0369a1 60%, #475569 80%, #dc2626 100%);
    color: white;
    transform: translateY(-3px) scale(1.05);
}

.btn-outline {
    background: transparent;
    color: white;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.4s ease;
    border: 2px solid white;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.btn-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px) scale(1.05);
}

.nav-link {
    position: relative;
    transition: all 0.3s ease;
}

.mobile-accordion {
    border-radius: 1.25rem;
    border: 1px solid rgba(148, 163, 184, 0.25);
    background: rgba(248, 250, 252, 0.95);
    padding: 1rem 1.25rem;
}

.mobile-accordion button {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 700;
    color: #0f172a;
}

.mobile-accordion-content {
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    border-top: 1px dashed rgba(148, 163, 184, 0.4);
}

.text-glow {
    text-shadow: 0 0 8px rgba(255,255,255,0.5);
}

.dropdown-menu {
    position: absolute !important;
    top: calc(100% + 0.75rem) !important;
    right: 0 !important;
    left: auto !important;
    bottom: auto !important;
    min-width: 300px;
    max-width: 350px;
    max-height: 75vh;
    overflow-y: auto;
    overflow-x: hidden;
    background: #ffffff !important;
    backdrop-filter: blur(30px);
    border: 1px solid rgba(14, 165, 233, 0.15);
    border-radius: 1.25rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2),
                0 15px 30px rgba(0, 0, 0, 0.15),
                0 5px 15px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.8);
    z-index: 99999 !important;
    transform-origin: top right;
    padding: 0.5rem 0;
    margin-top: 0;
}

.dropdown-menu::-webkit-scrollbar {
    width: 6px;
}

.dropdown-menu::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
}

.dropdown-menu::-webkit-scrollbar-thumb {
    background: rgba(14, 165, 233, 0.3);
    border-radius: 10px;
}

.dropdown-menu a {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    color: #1f2937;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    text-decoration: none;
    position: relative;
    margin: 0 0.5rem;
    border-radius: 0.75rem;
}

.dropdown-menu a:last-child {
    border-bottom: none;
}

.dropdown-menu a:hover {
    background: linear-gradient(90deg, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0.08) 100%);
    color: #0284c7;
    box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
}

.dropdown-menu a.bg-sky-50 {
    background: linear-gradient(90deg, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0.1) 100%) !important;
    color: #0284c7 !important;
    font-weight: 700;
    border-right: 3px solid #0284c7;
}

.dropdown-menu a i {
    margin-left: 0.875rem;
    color: #0284c7;
    width: 20px;
    font-size: 1rem;
    transition: transform 0.25s ease;
}

.dropdown-menu a:hover i {
    opacity: 1;
}

[x-cloak] {
    display: none !important;
}

.no-scroll {
    overflow: hidden !important;
    height: 100vh !important;
    position: fixed !important;
    width: 100% !important;
}

/* Mobile Menu Styles */
@media (max-width: 1023px) {
    /* Ensure mobile menu appears above content but below navbar */
    .mobile-menu-container {
        z-index: 45 !important;
        height: calc(100vh - 6rem) !important;
        max-height: calc(100vh - 6rem) !important;
        overflow: hidden !important;
        display: flex !important;
        flex-direction: column !important;
    }
    
    /* Prevent body scroll when menu is open on mobile */
    body.overflow-hidden {
        overflow: hidden !important;
        position: fixed !important;
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Ensure mobile menu inner container is scrollable */
    .mobile-menu-scrollable {
        flex: 1 !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        -webkit-overflow-scrolling: touch !important;
        overscroll-behavior: contain !important;
        position: relative !important;
        min-height: 0 !important;
    }
    
    /* Custom scrollbar for mobile menu */
    .mobile-menu-scrollable::-webkit-scrollbar {
        width: 6px;
    }
    
    .mobile-menu-scrollable::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 3px;
    }
    
    .mobile-menu-scrollable::-webkit-scrollbar-thumb {
        background: rgba(14, 165, 233, 0.3);
        border-radius: 3px;
    }
    
    .mobile-menu-scrollable::-webkit-scrollbar-thumb:hover {
        background: rgba(14, 165, 233, 0.5);
    }
    
    /* Force scrollbar to be visible on mobile */
    .mobile-menu-scrollable {
        scrollbar-width: thin;
        scrollbar-color: rgba(14, 165, 233, 0.3) rgba(0, 0, 0, 0.05);
    }
}

html {
    scroll-behavior: smooth;
}

section[id] {
    scroll-margin-top: 100px;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.sticky-sidebar {
    position: sticky;
    top: 6rem;
    align-self: flex-start;
}

.logo-animation:hover {
    opacity: 0.95;
}

/* Enhanced Dark Theme */
body.dark-theme {
    background: #0f172a;
    color: #f1f5f9;
}

body.dark-theme .bg-white {
    background: #1e293b !important;
    color: #f1f5f9 !important;
}

body.dark-theme .bg-gray-50 {
    background: #0f172a !important;
}

body.dark-theme .text-gray-900 {
    color: #f1f5f9 !important;
}

body.dark-theme .text-gray-700 {
    color: #cbd5e1 !important;
}

body.dark-theme .text-gray-600 {
    color: #94a3b8 !important;
}
</style>

<script>
tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                'arabic': ['Cairo', 'system-ui', 'sans-serif'],
            }
        }
    }
}
</script>

