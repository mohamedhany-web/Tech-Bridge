@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-comments text-sky-600 ml-3"></i>
                    {{ __('إدارة الرسائل') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('إدارة وإرسال الرسائل والتقارير عبر الواتساب') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.messages.create') }}" 
                   class="bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('رسالة جديدة') }}</span>
                </a>
                <a href="{{ route('admin.messages.monthly-reports') }}" 
                   class="bg-gradient-to-l from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="fas fa-chart-line"></i>
                    <span class="hidden sm:inline">{{ __('التقارير الشهرية') }}</span>
                </a>
                <a href="{{ route('admin.messages.templates') }}" 
                   class="bg-gradient-to-l from-purple-600 to-purple-500 hover:from-purple-700 hover:to-purple-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="fas fa-file-alt"></i>
                    <span class="hidden sm:inline">{{ __('قوالب الرسائل') }}</span>
                </a>
                <a href="{{ route('admin.messages.settings') }}" 
                   class="bg-gradient-to-l from-amber-600 to-amber-500 hover:from-amber-700 hover:to-amber-600 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <i class="fas fa-cog"></i>
                    <span class="hidden sm:inline">{{ __('الإعدادات') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border-r-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ __('إجمالي الرسائل') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_messages']) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                        <i class="fas fa-arrow-up text-green-500 ml-1"></i>
                        جميع الرسائل
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-envelope text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border-r-4 border-emerald-500">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ __('رسائل اليوم') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['sent_today']) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                        <i class="fas fa-check-circle text-emerald-500 ml-1"></i>
                        تم الإرسال اليوم
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-paper-plane text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border-r-4 border-red-500">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ __('رسائل فاشلة') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['failed_messages']) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                        <i class="fas fa-exclamation-circle text-red-500 ml-1"></i>
                        تحتاج للمراجعة
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border-r-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ __('تقارير هذا الشهر') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['monthly_reports']) }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                        <i class="fas fa-chart-line text-purple-500 ml-1"></i>
                        تقارير شهرية
                    </p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-chart-bar text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
            <i class="fas fa-filter text-sky-600 ml-3"></i>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('فلترة وبحث الرسائل') }}</h3>
        </div>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-search text-gray-400 ml-1"></i>
                    {{ __('البحث') }}
                </label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="{{ __('البحث في الرسائل، الأسماء، أو الأرقام...') }}"
                           class="w-full px-4 py-2.5 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                    <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-info-circle text-gray-400 ml-1"></i>
                    {{ __('الحالة') }}
                </label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                    <option value="">{{ __('جميع الحالات') }}</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('في الانتظار') }}</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>{{ __('تم الإرسال') }}</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>{{ __('تم التسليم') }}</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>{{ __('فشل الإرسال') }}</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <i class="fas fa-tag text-gray-400 ml-1"></i>
                    {{ __('النوع') }}
                </label>
                <select name="type" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                    <option value="">{{ __('جميع الأنواع') }}</option>
                    <option value="text" {{ request('type') === 'text' ? 'selected' : '' }}>{{ __('رسالة نصية') }}</option>
                    <option value="template" {{ request('type') === 'template' ? 'selected' : '' }}>{{ __('قالب') }}</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i>
                    <span>{{ __('بحث') }}</span>
                </button>
                @if(request()->anyFilled(['search', 'status', 'type']))
                <a href="{{ route('admin.messages.index') }}" 
                   class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-colors"
                   title="{{ __('مسح الفلتر') }}">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Messages List -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-blue-50 dark:from-gray-800 dark:to-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-list text-sky-600"></i>
                        {{ __('سجل الرسائل') }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        <span class="font-semibold text-sky-600 dark:text-sky-400">{{ $messages->total() }}</span> رسالة
                    </p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-clock"></i>
                    <span>آخر تحديث: {{ now()->format('H:i') }}</span>
                </div>
            </div>
        </div>

        @if($messages->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-user ml-2 text-sky-500"></i>
                                {{ __('المستلم') }}
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-comment ml-2 text-sky-500"></i>
                                {{ __('الرسالة') }}
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-info-circle ml-2 text-sky-500"></i>
                                {{ __('الحالة') }}
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-clock ml-2 text-sky-500"></i>
                                {{ __('تاريخ الإرسال') }}
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-cog ml-2 text-sky-500"></i>
                                {{ __('الإجراءات') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gradient-to-r hover:from-sky-50 hover:to-blue-50 dark:hover:from-gray-700 dark:hover:to-gray-700 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold text-lg">
                                                {{ $message->user ? mb_substr($message->user->name, 0, 1, 'UTF-8') : 'غ' }}
                                            </span>
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                {{ $message->user->name ?? 'غير معروف' }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                                <i class="fas fa-phone text-gray-400"></i>
                                                <span>{{ $message->phone_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white max-w-md">
                                        <div class="line-clamp-2">
                                            {{ Str::limit($message->message, 120) }}
                                        </div>
                                        @if(strlen($message->message) > 120)
                                        <a href="{{ route('admin.messages.show', $message) }}" class="text-xs text-sky-600 hover:text-sky-800 mt-1 inline-block">
                                            قراءة المزيد...
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm
                                        @if($message->status_color === 'green') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($message->status_color === 'red') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($message->status_color === 'blue') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($message->status_color === 'yellow') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                        @endif">
                                        @if($message->status === 'sent')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif($message->status === 'failed')
                                            <i class="fas fa-times-circle"></i>
                                        @elseif($message->status === 'delivered')
                                            <i class="fas fa-check-double"></i>
                                        @else
                                            <i class="fas fa-clock"></i>
                                        @endif
                                        <span>{{ $message->status_text }}</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white font-medium">
                                        {{ $message->sent_at ? $message->sent_at->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $message->sent_at ? $message->sent_at->format('H:i') : '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.messages.show', $message) }}" 
                                           class="w-9 h-9 flex items-center justify-center bg-blue-50 hover:bg-blue-100 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-600 dark:text-blue-300 rounded-lg transition-colors"
                                           title="{{ __('عرض التفاصيل') }}">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        @if($message->status === 'failed')
                                            <form action="{{ route('admin.messages.resend', $message) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-9 h-9 flex items-center justify-center bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900 dark:hover:bg-emerald-800 text-emerald-600 dark:text-emerald-300 rounded-lg transition-colors"
                                                        title="{{ __('إعادة الإرسال') }}"
                                                        onclick="return confirm('هل تريد إعادة إرسال هذه الرسالة؟')">
                                                    <i class="fas fa-redo text-sm"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-9 h-9 flex items-center justify-center bg-red-50 hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-800 text-red-600 dark:text-red-300 rounded-lg transition-colors"
                                                    title="{{ __('حذف') }}"
                                                    onclick="return confirm('هل تريد حذف هذه الرسالة؟')">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                {{ $messages->withQueryString()->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center">
                    <i class="fas fa-envelope-open text-gray-400 text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('لا توجد رسائل') }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    {{ __('ابدأ بإرسال أول رسالة للطلاب عبر الواتساب') }}
                </p>
                <a href="{{ route('admin.messages.create') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus"></i>
                    <span>{{ __('إرسال رسالة جديدة') }}</span>
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection
