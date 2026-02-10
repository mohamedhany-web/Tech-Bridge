@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
    $roleLabels = [
        'student' => ['label' => 'طالب', 'color' => 'from-sky-500 to-blue-600', 'chip' => 'bg-sky-500/15 text-sky-300 border border-sky-500/40'],
        'teacher' => ['label' => 'معلم', 'color' => 'from-emerald-500 to-green-600', 'chip' => 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/30'],
        'admin' => ['label' => 'إداري', 'color' => 'from-indigo-500 to-violet-600', 'chip' => 'bg-indigo-500/15 text-indigo-200 border border-indigo-500/40'],
        'super_admin' => ['label' => 'مدير عام', 'color' => 'from-blue-600 to-indigo-700', 'chip' => 'bg-blue-500/20 text-blue-100 border border-blue-500/40'],
    ];

    $roleMeta = $roleLabels[$user->role] ?? ['label' => 'مستخدم', 'color' => 'from-slate-500 to-slate-600', 'chip' => 'bg-slate-500/15 text-gray-200 border border-slate-500/40'];

    $memberSince = null;
    if ($user && $user->created_at instanceof \Carbon\CarbonInterface) {
        $memberSince = $user->created_at->copy()->locale('ar')->translatedFormat('d F Y');
    }

    $coursesCount = method_exists($user, 'courseEnrollments') ? $user->courseEnrollments()->count() : 0;
    $notificationsCount = method_exists($user, 'notifications') ? $user->notifications()->count() : 0;

    $lastLogin = null;
    if ($user && $user->last_login_at instanceof \Carbon\CarbonInterface) {
        $lastLogin = $user->last_login_at->copy()->locale('ar')->diffForHumans();
    }

    $stats = [
        ['icon' => 'fa-calendar-week', 'label' => 'تاريخ الانضمام', 'value' => $memberSince ?: '—'],
        ['icon' => 'fa-layer-group', 'label' => 'الكورسات النشطة', 'value' => $coursesCount],
        ['icon' => 'fa-bell', 'label' => 'الإشعارات', 'value' => $notificationsCount],
        ['icon' => 'fa-clock-rotate-left', 'label' => 'آخر تسجيل دخول', 'value' => $lastLogin ?: '—'],
    ];

    $profileImageUrl = $user->profile_image ? asset($user->profile_image) : null;
@endphp

<div class="min-h-screen bg-gray-50 dark:bg-slate-950 py-3 sm:py-8">
    <div class="w-full px-2 sm:px-6 lg:px-12 xl:px-16">
        <div class="rounded-2xl sm:rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/70 dark:border-slate-800 shadow-md sm:shadow-lg text-gray-900 dark:text-gray-100">
            <div class="px-4 py-6 sm:px-10 sm:py-8 lg:px-14 lg:py-10">
                <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-5 w-full lg:w-auto">
                        <div class="flex items-center justify-center h-20 w-20 sm:h-24 sm:w-24 rounded-2xl bg-gradient-to-br {{ $roleMeta['color'] }} text-white shadow-md overflow-hidden">
                            @if($user->profile_image)
                                <img src="{{ asset($user->profile_image) }}" alt="صورة الملف الشخصي" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl sm:text-4xl font-bold leading-none">{{ mb_substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="flex-1 text-center sm:text-right">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 text-slate-600 dark:bg-slate-800/80 dark:text-slate-200 px-3 py-1 text-xs font-semibold border border-slate-200 dark:border-slate-700 mb-2">
                                        <i class="fas fa-user-shield text-[11px]"></i>
                                        {{ $roleMeta['label'] }}
                                    </span>
                                    <h1 class="text-2xl sm:text-3xl font-semibold tracking-tight">{{ $user->name }}</h1>
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">إدارة بياناتك وإعدادات حسابك الشخصي</p>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col sm:flex-row sm:justify-end gap-3 text-sm">
                                <span class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-100 text-slate-600 dark:bg-slate-800/70 dark:text-slate-200 px-4 py-2 font-medium border border-slate-200 dark:border-slate-700">
                                    <i class="fas fa-phone text-xs"></i>
                                    {{ $user->phone ?? '—' }}
                                </span>
                                @if($user->email)
                                    <span class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-100 text-slate-600 dark:bg-slate-800/70 dark:text-slate-200 px-4 py-2 font-medium border border-slate-200 dark:border-slate-700">
                                        <i class="fas fa-envelope text-xs"></i>
                                        {{ $user->email }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 xl:gap-5 w-full lg:w-auto">
                        @foreach ($stats as $stat)
                            <div class="rounded-2xl border border-slate-200/70 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-5 text-center shadow-sm">
                                <div class="text-slate-500 dark:text-slate-400 text-xs font-medium mb-2 flex items-center justify-center gap-2">
                                    <i class="fas {{ $stat['icon'] }} text-[13px]"></i>
                                    <span>{{ $stat['label'] }}</span>
                                </div>
                                <div class="text-base sm:text-lg font-semibold text-slate-800 dark:text-slate-100">
                                    {{ $stat['value'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        <!-- المحتوى الرئيسي -->
        <div class="mt-8 sm:mt-10 grid grid-cols-1 gap-6 lg:gap-8 lg:grid-cols-3">
            <!-- البطاقات الجانبية -->
            <div class="space-y-6">
                <div class="rounded-3xl bg-white dark:bg-slate-900 shadow-lg border border-slate-200/70 dark:border-slate-800 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">معلومات الاتصال</h2>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-500/10 text-sky-600 dark:text-sky-300"><i class="fas fa-id-badge"></i></span>
                                <span class="font-medium">رقم العضوية</span>
                            </div>
                            <span class="text-gray-800 dark:text-gray-100 font-semibold">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-300"><i class="fas fa-user-shield"></i></span>
                                <span class="font-medium">نوع الحساب</span>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $roleMeta['chip'] }}">{{ $roleMeta['label'] }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 text-gray-600 dark:text-gray-300">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-300"><i class="fas fa-signal"></i></span>
                                <span class="font-medium">الحالة</span>
                            </div>
                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300 border border-emerald-500/30' : 'bg-rose-500/10 text-rose-600 dark:text-rose-300 border border-rose-500/40' }}">
                                <span class="relative flex h-2 w-2">
                                    <span class="absolute inline-flex h-full w-full rounded-full opacity-75 {{ $user->is_active ? 'bg-emerald-500 animate-ping' : 'bg-rose-500' }}"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                </span>
                                {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>
                        <div class="flex items-start gap-3 rounded-2xl bg-slate-100/60 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700 px-4 py-3 text-gray-600 dark:text-gray-300">
                            <span class="mt-1 text-sky-500"><i class="fas fa-shield-halved"></i></span>
                            <p>يمكنك تحسين أمان حسابك بتفعيل التحقق بخطوتين من الإعدادات المتقدمة (قريباً).</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white dark:bg-slate-900 shadow-lg border border-slate-200/70 dark:border-slate-800 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">نصائح سريعة</h2>
                    <ul class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 text-sky-500"><i class="fas fa-check-circle"></i></span>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-gray-100">حدّث معلومات التواصل</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">احرص على أن يكون بريدك الإلكتروني ورقم هاتفك محدثين لاستقبال كل الإشعارات المهمة.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 text-emerald-500"><i class="fas fa-lock"></i></span>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-gray-100">أنشئ كلمة مرور قوية</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">استخدم مزيجاً من الأحرف والأرقام والرموز، وقم بتغيير كلمة المرور بشكل دوري.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 text-indigo-500"><i class="fas fa-bell"></i></span>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-gray-100">فعّل الإشعارات</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">ابقَ على اطلاع بالمستجدات من خلال متابعة جديد الكورسات والتنبيهات.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- النماذج -->
            <div class="lg:col-span-2 space-y-8">
                <div class="rounded-3xl bg-white dark:bg-slate-900 shadow-lg border border-slate-200/70 dark:border-slate-800 p-8">
                    <div class="flex items-center justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">تحديث البيانات الأساسية</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">قم بمراجعة معلوماتك وتحديثها في أي وقت</p>
                        </div>
                        <span class="hidden sm:inline-flex items-center gap-2 text-xs font-semibold rounded-full bg-sky-500/10 text-sky-600 dark:text-sky-300 border border-sky-500/30 px-4 py-2">
                            <i class="fas fa-shield-check"></i>
                            بياناتك مشفرة وآمنة
                        </span>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-10" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">الاسم الكامل</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-sky-500"></i>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                           class="w-full rounded-2xl border border-gray-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-10 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                                </div>
                                @error('name')
                                    <p class="text-rose-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">رقم الهاتف</label>
                                <div class="relative">
                                    <i class="fas fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-sky-500"></i>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                           class="w-full rounded-2xl border border-gray-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-10 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                                </div>
                                @error('phone')
                                    <p class="text-rose-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2 group">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">البريد الإلكتروني (اختياري)</label>
                                <div class="relative">
                                    <i class="fas fa-at absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-sky-500"></i>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 px-10 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                                </div>
                                @error('email')
                                    <p class="text-rose-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200">صورة الملف الشخصي</label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                <div class="w-24 h-24 rounded-2xl overflow-hidden border border-dashed border-slate-300 dark:border-slate-700 bg-slate-100 dark:bg-slate-900/60 flex items-center justify-center">
                                    @if($user->profile_image)
                                        <img src="{{ asset($user->profile_image) }}" alt="صورة الملف الشخصي" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-camera text-slate-400 text-2xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <label class="flex cursor-pointer items-center justify-center rounded-2xl border border-dashed border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/60 px-4 py-3 text-sm font-semibold text-slate-600 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                        <i class="fas fa-upload ml-2"></i>
                                        اختر صورة جديدة (PNG أو JPG)
                                        <input type="file" name="profile_image" accept="image/*" class="hidden">
                                    </label>
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">الحد الأقصى لحجم الملف 2 ميجابايت.</p>
                                    @error('profile_image')
                                        <p class="text-rose-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 rounded-2xl border border-dashed border-gray-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-900/60 p-6">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h4 class="text-base font-semibold text-gray-900 dark:text-white">تغيير كلمة المرور</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">اترك الحقول فارغة إذا لم ترغب في التغيير الآن</p>
                                </div>
                                <span class="inline-flex items-center gap-2 text-xs font-semibold text-sky-500"><i class="fas fa-key"></i> نصيحة: استخدم كلمة مرور مكونة من 12 حرفًا على الأقل</span>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div class="group">
                                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">كلمة المرور الحالية</label>
                                    <input type="password" name="current_password"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900/70 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                                    @error('current_password')
                                        <p class="text-rose-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">كلمة المرور الجديدة</label>
                                    <input type="password" name="password"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900/70 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition">
                                    @error('password')
                                        <p class="text-rose-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="group">
                                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">تأكيد كلمة المرور</label>
                                    <input type="password" name="password_confirmation"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900/70 px-4 py-3 text-sm text-gray-900 dark:text-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition">
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                <i class="fas fa-info-circle text-sky-500"></i>
                                <span>سيتم إرسال إشعار إلى بريدك في حال تغيير كلمة المرور.</span>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-200 dark:border-slate-700 bg-white/70 dark:bg-transparent px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:border-gray-300 hover:bg-slate-50 dark:hover:bg-slate-900 transition">
                                    <i class="fas fa-arrow-right"></i>
                                    رجوع إلى اللوحة
                                </a>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-sky-500 via-indigo-500 to-purple-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-500/25 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-sky-500/30 transition">
                                    <i class="fas fa-save"></i>
                                    حفظ التعديلات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="rounded-3xl bg-white dark:bg-slate-900 shadow-lg border border-slate-200/70 dark:border-slate-800 p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">نشاط الحساب الأخير</h3>
                    <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex items-center justify-between rounded-2xl border border-gray-200 dark:border-slate-800 bg-gray-50/70 dark:bg-slate-900/60 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-500/10 text-sky-500"><i class="fas fa-desktop"></i></span>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100">آخر نشاط للنظام</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">تم تسجيل الدخول بنجاح باستخدام متصفح آمن</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $lastLogin ?: 'قبل قليل' }}</span>
                        </div>

                        <div class="flex items-center justify-between rounded-2xl border border-gray-200 dark:border-slate-800 bg-gray-50/70 dark:bg-slate-900/60 px-4 py-3">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-500"><i class="fas fa-shield-heart"></i></span>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100">أمان الحساب</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"> ننصح بتحديث كلمة المرور كل 90 يومًا للحفاظ على أعلى درجات الحماية.</p>
                                </div>
                            </div>
                            <a href="#" class="text-xs font-semibold text-sky-500 hover:text-sky-400">تعلم المزيد</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection









