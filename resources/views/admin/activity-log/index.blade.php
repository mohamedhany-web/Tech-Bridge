@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-history text-sky-600 ml-3"></i>
                    {{ __('سجل النشاطات') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('راقب كل العمليات التي تمت داخل المنصة') }}</p>
                <div class="mt-2 inline-flex items-center gap-2 rounded-xl bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-300">
                    <i class="fas fa-info-circle"></i>
                    <span>تسجيلات الدخول مخفية افتراضياً لتقليل الزحمة - يمكن تفعيلها من الفلتر أدناه</span>
                </div>
                <div class="mt-2 inline-flex items-center gap-2 rounded-xl bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 dark:bg-amber-500/15 dark:text-amber-300">
                    <i class="fas fa-lightbulb"></i>
                    <span>السجل يعرض فقط النشاطات المهمة - تسجيلات الدخول المتكررة مخفية تلقائياً</span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <!-- Dropdown for delete options -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="bg-gradient-to-l from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>{{ __('مسح السجلات') }}</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition
                         class="absolute left-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden">
                        <div class="p-2">
                            <button onclick="clearActivityLog('filtered')" 
                                    class="w-full text-right px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center justify-between">
                                <span>
                                    <i class="fas fa-filter text-gray-400 ml-2"></i>
                                    {{ __('مسح المطابقة للفلتر') }}
                                </span>
                                <i class="fas fa-chevron-left text-xs text-gray-400"></i>
                            </button>
                            <button onclick="clearActivityLog('old')" 
                                    class="w-full text-right px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center justify-between">
                                <span>
                                    <i class="fas fa-calendar text-gray-400 ml-2"></i>
                                    {{ __('مسح أقدم من 3 أشهر') }}
                                </span>
                                <i class="fas fa-chevron-left text-xs text-gray-400"></i>
                            </button>
                            <button onclick="clearActivityLog('older')" 
                                    class="w-full text-right px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center justify-between">
                                <span>
                                    <i class="fas fa-calendar-alt text-gray-400 ml-2"></i>
                                    {{ __('مسح أقدم من 6 أشهر') }}
                                </span>
                                <i class="fas fa-chevron-left text-xs text-gray-400"></i>
                            </button>
                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                            <button onclick="clearActivityLog('all')" 
                                    class="w-full text-right px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center justify-between font-semibold">
                                <span>
                                    <i class="fas fa-exclamation-triangle text-red-500 ml-2"></i>
                                    {{ __('مسح جميع السجلات') }}
                                </span>
                                <i class="fas fa-chevron-left text-xs text-red-400"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($stats))
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- إجمالي النشاطات -->
        <div class="bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-slate-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ __('إجمالي النشاطات') }}</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-sky-700 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-sky-500 dark:to-slate-400">{{ number_format($stats['total']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">جميع النشاطات المسجلة في النظام</p>
            </div>
        </div>

        <!-- نشاطات اليوم -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-green-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-emerald-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ __('نشاطات اليوم') }}</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-green-600 via-emerald-700 to-green-600 bg-clip-text text-transparent dark:from-green-400 dark:via-emerald-500 dark:to-green-400">{{ number_format($stats['today']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-day text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">تم تسجيلها اليوم</p>
            </div>
        </div>

        <!-- هذا الأسبوع -->
        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-purple-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-100/50 to-indigo-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ __('هذا الأسبوع') }}</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-purple-600 via-indigo-700 to-purple-600 bg-clip-text text-transparent dark:from-purple-400 dark:via-indigo-500 dark:to-purple-400">{{ number_format($stats['this_week']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-week text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">خلال الأسبوع الحالي</p>
            </div>
        </div>

        <!-- هذا الشهر -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-amber-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-100/50 to-orange-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">{{ __('هذا الشهر') }}</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-amber-600 via-orange-700 to-amber-600 bg-clip-text text-transparent dark:from-amber-400 dark:via-orange-500 dark:to-amber-400">{{ number_format($stats['this_month']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-calendar-alt text-white text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">خلال الشهر الحالي</p>
            </div>
        </div>
    </div>
    @endif

<div class="space-y-6">
    <!-- Search and Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
            <i class="fas fa-filter text-sky-600 ml-3"></i>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('فلترة وبحث النشاطات') }}</h3>
        </div>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-search text-gray-400 ml-1"></i>
                    {{ __('البحث') }}
                </label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="{{ __('البحث في النشاطات...') }}"
                           class="w-full px-4 py-2.5 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                    <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-tag text-gray-400 ml-1"></i>
                    {{ __('نوع النشاط') }}
                </label>
                <select name="type" id="type" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                    <option value="">{{ __('جميع الأنواع') }}</option>
                    <option value="create" {{ request('type') == 'create' ? 'selected' : '' }}>{{ __('إنشاء') }}</option>
                    <option value="update" {{ request('type') == 'update' ? 'selected' : '' }}>{{ __('تحديث') }}</option>
                    <option value="delete" {{ request('type') == 'delete' ? 'selected' : '' }}>{{ __('حذف') }}</option>
                    <option value="login" {{ request('type') == 'login' ? 'selected' : '' }}>{{ __('تسجيل دخول') }}</option>
                    <option value="logout" {{ request('type') == 'logout' ? 'selected' : '' }}>{{ __('تسجيل خروج') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-calendar text-gray-400 ml-1"></i>
                    {{ __('من تاريخ') }}
                </label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-calendar-check text-gray-400 ml-1"></i>
                    {{ __('إلى تاريخ') }}
                </label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-sign-in-alt text-gray-400 ml-1"></i>
                    {{ __('تسجيلات الدخول') }}
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="include_logins" value="1" {{ request('include_logins') == '1' ? 'checked' : '' }} 
                           class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-sky-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('إظهار تسجيلات الدخول') }}</span>
                </label>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">افتراضياً يتم إخفاء تسجيلات الدخول لتقليل الزحمة</p>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i>
                    <span>{{ __('بحث') }}</span>
                </button>
                @if(request()->anyFilled(['search', 'type', 'date_from', 'date_to', 'include_logins']))
                <a href="{{ route('admin.activity-log') }}" 
                   class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-colors"
                   title="{{ __('مسح الفلتر') }}">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Activities List -->
    @if ($activities->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-blue-50 dark:from-gray-800 dark:to-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-list text-sky-600"></i>
                            {{ __('العمليات المسجلة') }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            <span class="font-semibold text-sky-600 dark:text-sky-400">{{ $activities->total() }}</span> عملية تم تسجيلها
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock"></i>
                        <span>آخر تحديث: {{ now()->format('H:i') }}</span>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-right">
                    <thead class="bg-slate-50 dark:bg-slate-900/70">
                        <tr class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-300">
                            <th class="px-6 py-4">
                                <i class="fas fa-user ml-2 text-sky-500"></i>
                                المستخدم
                            </th>
                            <th class="px-6 py-4">
                                <i class="fas fa-tag ml-2 text-sky-500"></i>
                                النوع
                            </th>
                            <th class="px-6 py-4">
                                <i class="fas fa-comment ml-2 text-sky-500"></i>
                                الوصف
                            </th>
                            <th class="px-6 py-4">
                                <i class="fas fa-clock ml-2 text-sky-500"></i>
                                الوقت
                            </th>
                            <th class="px-6 py-4">
                                <i class="fas fa-cog ml-2 text-sky-500"></i>
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white/80 text-sm text-slate-700 dark:divide-slate-800 dark:bg-slate-900/70 dark:text-slate-200">
                        @foreach ($activities as $activity)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/70 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-300">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <div class="space-y-1">
                                            <p class="font-semibold text-slate-900 dark:text-white">{{ $activity->user->name ?? 'مستخدم غير معروف' }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-300">{{ $activity->user->email ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $actionType = $activity->action;
                                        // تحديد نوع النشاط من action
                                        $isCreate = str_contains($actionType, 'create') || str_contains($actionType, 'created');
                                        $isUpdate = str_contains($actionType, 'update') || str_contains($actionType, 'updated') || str_contains($actionType, 'changed');
                                        $isDelete = str_contains($actionType, 'delete') || str_contains($actionType, 'deleted');
                                        $isLogin = str_contains($actionType, 'login') && !str_contains($actionType, 'logout');
                                        $isLogout = str_contains($actionType, 'logout');
                                        
                                        if ($isCreate) {
                                            $badgeClasses = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200';
                                            $typeLabel = 'إنشاء';
                                        } elseif ($isUpdate) {
                                            $badgeClasses = 'bg-sky-100 text-sky-700 dark:bg-sky-500/15 dark:text-sky-200';
                                            $typeLabel = 'تحديث';
                                        } elseif ($isDelete) {
                                            $badgeClasses = 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200';
                                            $typeLabel = 'حذف';
                                        } elseif ($isLogin) {
                                            $badgeClasses = 'bg-purple-100 text-purple-700 dark:bg-purple-500/15 dark:text-purple-200';
                                            $typeLabel = 'تسجيل دخول';
                                        } elseif ($isLogout) {
                                            $badgeClasses = 'bg-slate-100 text-slate-700 dark:bg-slate-500/15 dark:text-slate-200';
                                            $typeLabel = 'تسجيل خروج';
                                        } else {
                                            $badgeClasses = 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200';
                                            $typeLabel = 'نشاط آخر';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                        <span class="h-2 w-2 rounded-full bg-current"></span>
                                        {{ $typeLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-slate-900 dark:text-white">
                                        {{ $activity->description ?: ($activity->action_description ?? $activity->action) }}
                                    </p>
                                    @if ($activity->model_type && $activity->model_id)
                                        <p class="text-xs text-slate-500 dark:text-slate-300 mt-1">
                                            <i class="fas fa-link text-xs ml-1"></i>
                                            {{ class_basename($activity->model_type) }} #{{ $activity->model_id }}
                                        </p>
                                    @endif
                                    @if ($activity->action)
                                        <p class="text-xs text-slate-400 dark:text-slate-400 mt-1">
                                            {{ $activity->action }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-300">
                                    <p>{{ $activity->created_at->format('Y-m-d') }}</p>
                                    <p>{{ $activity->created_at->format('H:i:s') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.activity-log.show', $activity) }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200 dark:hover:border-sky-500 dark:hover:text-sky-300">
                                        <i class="fas fa-eye"></i>
                                        عرض التفاصيل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($activities->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    {{ $activities->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center">
                    <i class="fas fa-history text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('لا توجد نشاطات') }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    {{ __('لا توجد نشاطات مطابقة للمعايير الحالية') }}
                </p>
            </div>
        </div>
    @endif
</div>
</div>

@push('scripts')
<script>
function clearActivityLog(type) {
    let confirmMessage = '';
    let confirmText = '';
    
    switch(type) {
        case 'all':
            confirmMessage = 'هل أنت متأكد من مسح جميع السجلات؟\n\n⚠️ تحذير: هذا الإجراء لا يمكن التراجع عنه!';
            confirmText = 'مسح جميع السجلات';
            break;
        case 'old':
            confirmMessage = 'هل أنت متأكد من مسح السجلات الأقدم من 3 أشهر؟';
            confirmText = 'مسح السجلات الأقدم من 3 أشهر';
            break;
        case 'older':
            confirmMessage = 'هل أنت متأكد من مسح السجلات الأقدم من 6 أشهر؟';
            confirmText = 'مسح السجلات الأقدم من 6 أشهر';
            break;
        case 'filtered':
            confirmMessage = 'هل أنت متأكد من مسح السجلات المطابقة للفلتر الحالي؟';
            confirmText = 'مسح السجلات المطابقة للفلتر';
            break;
    }
    
    if (confirm(confirmMessage)) {
        // Show loading indicator
        const loadingToast = document.createElement('div');
        loadingToast.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
        loadingToast.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري مسح السجلات...';
        document.body.appendChild(loadingToast);
        
        // Get current filter values
        const formData = new FormData();
        formData.append('delete_type', type);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Add current filter values if deleting filtered logs
        if (type === 'filtered') {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('type')) {
                formData.append('type', urlParams.get('type'));
            }
            if (urlParams.has('user_id')) {
                formData.append('user_id', urlParams.get('user_id'));
            }
            if (urlParams.has('date_from')) {
                formData.append('date_from', urlParams.get('date_from'));
            }
            if (urlParams.has('date_to')) {
                formData.append('date_to', urlParams.get('date_to'));
            }
            if (urlParams.has('search')) {
                formData.append('search', urlParams.get('search'));
            }
        }
        
        fetch('{{ route('admin.activity-log.destroy') }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.body.removeChild(loadingToast);
            
            if (data.success) {
                // Show success message
                const successToast = document.createElement('div');
                successToast.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
                successToast.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
                document.body.appendChild(successToast);
                
                // Reload page after 1.5 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                // Show error message
                const errorToast = document.createElement('div');
                errorToast.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
                errorToast.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + data.message;
                document.body.appendChild(errorToast);
                
                setTimeout(() => {
                    if (document.body.contains(errorToast)) {
                        document.body.removeChild(errorToast);
                    }
                }, 5000);
            }
        })
        .catch(error => {
            document.body.removeChild(loadingToast);
            
            // Show error message
            const errorToast = document.createElement('div');
            errorToast.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2';
            errorToast.innerHTML = '<i class="fas fa-exclamation-circle"></i> حدث خطأ: ' + error.message;
            document.body.appendChild(errorToast);
            
            setTimeout(() => {
                if (document.body.contains(errorToast)) {
                    document.body.removeChild(errorToast);
                }
            }, 5000);
        });
    }
}
</script>
@endpush
@endsection

