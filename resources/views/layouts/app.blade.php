<!DOCTYPE html>
<html lang="ar" dir="rtl" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'منصة التعلم') }} - @yield('title', 'لوحة التحكم')</title>

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
    
    <!-- حماية المنصة من التصوير -->
    @hasSection('enable-content-protection')
    <script>
        window.Laravel = {
            user: {
                name: '{{ auth()->check() ? auth()->user()->name : "زائر" }}'
            }
        };
    </script>
    <script src="{{ asset('js/platform-protection.js') }}"></script>
    @endif

    <style>
        body {
            font-family: 'IBM Plex Sans Arabic', system-ui, sans-serif;
        }
        
        .dark-mode-toggle {
            transition: all 0.3s ease;
        }
        
        .sidebar-transition {
            transition: transform 0.3s ease;
        }

        /* تحسين المخرولة للوضع المظلم */
        .dark .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 3px;
        }
        
        .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* تحسين الشريط الجانبي */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: #0ea5e9 #e2e8f0;
        }

        /* تحسين الأنيميشن */
        .rotate-animation {
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* تأثيرات hover */
        .sidebar-link {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .sidebar-link:hover {
            transform: translateX(-5px);
        }

        /* تحسين Header */
        header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(224, 242, 254, 0.3) 50%, rgba(241, 245, 249, 0.3) 100%);
        }

        .dark header {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(17, 24, 39, 0.3) 50%, rgba(17, 24, 39, 0.3) 100%);
        }

        /* تحسين الكروت */
        .card-hover-effect {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card-hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(14, 165, 233, 0.15);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300" 
      x-data="{ 
          darkMode: localStorage.getItem('darkMode') === 'true' || false,
          sidebarOpen: window.innerWidth >= 1024
      }"
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
          window.addEventListener('resize', () => {
              if (window.innerWidth >= 1024) {
                  sidebarOpen = true;
              } else {
                  sidebarOpen = false;
              }
          });
      ">

    <div class="flex h-screen overflow-hidden">
        @auth
            <!-- الشريط الجانبي -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 right-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg lg:static lg:translate-x-0 sidebar-transition">
                
                @include('layouts.sidebar')
            </div>

            <!-- تراكب للهواتف -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-gray-600 bg-opacity-75 lg:hidden"></div>
        @endauth

        <!-- المحتوى الرئيسي -->
        <div class="flex flex-col flex-1 overflow-hidden">
            @auth
                <!-- شريط التنقل العلوي -->
                <header class="relative z-40 bg-gradient-to-r from-white via-sky-50/30 to-slate-50/30 dark:from-gray-800 dark:via-gray-800 dark:to-gray-800 shadow-lg border-b border-sky-200 dark:border-gray-700 backdrop-blur-sm">
                    <div class="flex items-center justify-between px-6 py-4">
                        <div class="flex items-center gap-4">
                            <!-- زر فتح/إغلاق الشريط الجانبي -->
                            <button @click="sidebarOpen = !sidebarOpen" 
                                    class="p-2 rounded-xl bg-gradient-to-r from-sky-100 to-slate-100 dark:from-gray-700 dark:to-gray-700 hover:from-sky-200 hover:to-slate-200 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 shadow-md hover:shadow-lg lg:hidden group">
                                <i class="fas fa-bars text-sky-600 dark:text-sky-400 group-hover:text-sky-700 dark:group-hover:text-sky-300"></i>
                            </button>
                            
                            <h1 class="text-xl font-black bg-gradient-to-r from-sky-600 via-sky-700 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-sky-500 dark:to-slate-400">@yield('header', 'لوحة التحكم')</h1>
                        </div>

                        <div class="flex items-center gap-4">
                            @if(auth()->user()->isAdmin())
                                <!-- إرسال إشعار سريع للأدمن -->
                                <button onclick="showQuickNotificationModal()" 
                                        class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors"
                                        title="إرسال إشعار سريع">
                                    <i class="fas fa-paper-plane text-blue-600 dark:text-blue-400"></i>
                                </button>
                            @endif
                            
                            <!-- مفتاح الوضع المظلم -->
                            <button @click="darkMode = !darkMode" 
                                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors dark-mode-toggle">
                                <i x-show="!darkMode" class="fas fa-moon"></i>
                                <i x-show="darkMode" class="fas fa-sun"></i>
                            </button>

                            <!-- إشعارات -->
                            <div class="relative" x-data="{ open: false, unreadCount: 0 }" x-init="loadUnreadCount()">
                                <button @click="open = !open; if(open) loadRecentNotifications()" 
                                        class="relative p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    <i class="fas fa-bell"></i>
                                    <span x-show="unreadCount > 0" 
                                          x-text="unreadCount > 99 ? '99+' : unreadCount"
                                          class="absolute -top-1 -left-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"></span>
                                </button>

                                <!-- قائمة الإشعارات -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition
                                     class="absolute left-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 z-50">
                                    <div class="p-4 border-b dark:border-gray-700 flex items-center justify-between">
                                        <h3 class="font-semibold">الإشعارات</h3>
                                        <span x-show="unreadCount > 0" 
                                              x-text="unreadCount"
                                              class="bg-red-500 text-white text-xs px-2 py-1 rounded-full"></span>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto" id="notifications-container">
                                        <!-- سيتم تحميل الإشعارات هنا -->
                                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-spinner fa-spin mb-2"></i>
                                            <p class="text-sm">جاري تحميل الإشعارات...</p>
                                        </div>
                                    </div>
                                    <div class="p-4 text-center border-t dark:border-gray-700">
                                        <a href="{{ route('notifications') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">عرض جميع الإشعارات</a>
                                    </div>
                                </div>
                            </div>

                            <!-- قائمة المستخدم -->
                            <div class="relative z-50" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-8 h-8 rounded-full overflow-hidden border border-sky-500/40 bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                        @if(auth()->user()->profile_image)
                                            <img src="{{ asset(auth()->user()->profile_image) }}" alt="صورة الحساب" class="w-full h-full object-cover">
                                        @else
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <span class="text-sm font-medium hidden md:block">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>

                                <!-- قائمة منسدلة -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition
                                     class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700 z-50"
                                     @click="open = false">
                                    <div class="p-2">
                                        <a href="{{ route('profile') }}" class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-user"></i>
                                            الملف الشخصي
                                        </a>
                                        <a href="{{ route('settings') }}" class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-cog"></i>
                                            الإعدادات
                                        </a>
                                        <hr class="my-2 border-gray-200 dark:border-gray-700">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 w-full text-right text-red-600 dark:text-red-400">
                                                <i class="fas fa-sign-out-alt"></i>
                                                تسجيل الخروج
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            @endauth

            <!-- المحتوى (z-30 أقل من الهيدر z-40 حتى لا يغطي القائمة المنسدلة للبروفايل) -->
            <main class="relative z-30 flex-1 overflow-auto p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="mb-6 bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-600 text-blue-700 dark:text-blue-300 px-4 py-3 rounded-lg">
                        {{ session('info') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- نافذة الإشعارات السريعة معطلة مؤقتاً --}}
    @if(false && auth()->user()->isAdmin())
    <!-- نافذة الإرسال السريع للأدمن -->
    <div id="quickNotificationModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">إرسال إشعار سريع</h3>
                <button onclick="hideQuickNotificationModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="quickNotificationForm">
                <div class="space-y-4">
                    <!-- العنوان -->
                    <div>
                        <label for="modal_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">العنوان</label>
                        <input type="text" name="title" id="modal_title" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                               placeholder="عنوان الإشعار">
                    </div>

                    <!-- المستهدفين -->
                    <div>
                        <label for="modal_target" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المستهدفين</label>
                        <select name="target_type" id="modal_target" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="">اختر المستهدفين</option>
                            <option value="all_students">جميع الطلاب</option>
                        </select>
                    </div>

                    <!-- النص -->
                    <div>
                        <label for="modal_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">النص</label>
                        <textarea name="message" id="modal_message" rows="3" required
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="اكتب نص الإشعار..."></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 space-x-reverse mt-6">
                    <button type="button" onclick="hideQuickNotificationModal()" 
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg font-medium transition-colors">
                        إلغاء
                    </button>
                    <button type="button" onclick="sendQuickNotification()" 
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-paper-plane ml-2"></i>
                        إرسال
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @stack('scripts')
    
    <!-- JavaScript للإشعارات -->
    @auth
    <script>
    function loadUnreadCount() {
        fetch('/api/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                this.unreadCount = data.count;
            })
            .catch(error => {
                console.error('Error loading unread count:', error);
            });
    }

    function loadRecentNotifications() {
        fetch('/api/notifications/recent')
            .then(response => response.json())
            .then(notifications => {
                const container = document.getElementById('notifications-container');
                
                if (notifications.length === 0) {
                    container.innerHTML = `
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-bell-slash mb-2"></i>
                            <p class="text-sm">لا توجد إشعارات</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                notifications.forEach(notification => {
                    const typeIcons = {
                        'general': 'fas fa-info-circle',
                        'course': 'fas fa-graduation-cap',
                        'exam': 'fas fa-clipboard-check',
                        'assignment': 'fas fa-tasks',
                        'grade': 'fas fa-star',
                        'announcement': 'fas fa-bullhorn',
                        'reminder': 'fas fa-bell',
                        'warning': 'fas fa-exclamation-triangle',
                        'system': 'fas fa-cog',
                    };

                    const typeColors = {
                        'general': 'blue',
                        'course': 'green',
                        'exam': 'purple',
                        'assignment': 'orange',
                        'grade': 'yellow',
                        'announcement': 'red',
                        'reminder': 'blue',
                        'warning': 'red',
                        'system': 'gray',
                    };

                    const icon = typeIcons[notification.type] || 'fas fa-info-circle';
                    const color = typeColors[notification.type] || 'blue';
                    
                    html += `
                        <div class="p-4 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 ${!notification.is_read ? 'bg-blue-50 dark:bg-blue-900/20' : ''}">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-${color}-100 dark:bg-${color}-900 rounded-full flex items-center justify-center mt-1">
                                    <i class="${icon} text-${color}-600 dark:text-${color}-400 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">${notification.title}</p>
                                        ${!notification.is_read ? '<div class="w-2 h-2 bg-blue-500 rounded-full"></div>' : ''}
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">${notification.message.substring(0, 80)}${notification.message.length > 80 ? '...' : ''}</p>
                                    <p class="text-xs text-gray-400 mt-1">${timeAgo(notification.created_at)}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                document.getElementById('notifications-container').innerHTML = `
                    <div class="p-4 text-center text-red-500">
                        <i class="fas fa-exclamation-triangle mb-2"></i>
                        <p class="text-sm">خطأ في تحميل الإشعارات</p>
                    </div>
                `;
            });
    }

    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInMinutes = Math.floor((now - date) / (1000 * 60));
        
        if (diffInMinutes < 1) return 'الآن';
        if (diffInMinutes < 60) return `منذ ${diffInMinutes} دقيقة`;
        
        const diffInHours = Math.floor(diffInMinutes / 60);
        if (diffInHours < 24) return `منذ ${diffInHours} ساعة`;
        
        const diffInDays = Math.floor(diffInHours / 24);
        return `منذ ${diffInDays} يوم`;
    }

    // تحديث عداد الإشعارات كل دقيقة
    setInterval(loadUnreadCount, 60000);

    {{-- نافذة الإشعارات السريعة معطلة مؤقتاً --}}
    @if(false && auth()->user()->isAdmin())
    // نافذة الإرسال السريع للأدمن
    function showQuickNotificationModal() {
        document.getElementById('quickNotificationModal').classList.remove('hidden');
    }

    function hideQuickNotificationModal() {
        document.getElementById('quickNotificationModal').classList.add('hidden');
        document.getElementById('quickNotificationForm').reset();
    }

    function sendQuickNotification() {
        const form = document.getElementById('quickNotificationForm');
        const formData = new FormData(form);
        
        const data = {
            title: formData.get('title'),
            message: formData.get('message'),
            target_type: formData.get('target_type'),
            target_id: formData.get('target_id') || null,
        };
        
        if (!data.title || !data.message || !data.target_type) {
            alert('يرجى ملء جميع الحقول المطلوبة');
            return;
        }
        
        fetch('/admin/notifications/quick-send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                hideQuickNotificationModal();
            } else {
                alert('حدث خطأ في إرسال الإشعار');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في إرسال الإشعار');
        });
    }
    @endif
    </script>
    @endauth
</body>
</html>
