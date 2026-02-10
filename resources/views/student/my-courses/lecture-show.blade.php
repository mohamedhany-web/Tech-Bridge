@extends('layouts.app')

@section('title', $lecture->title . ' - ' . $course->title)
@section('header', 'تفاصيل المحاضرة')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- مسار التنقل -->
        <div class="mb-6 flex flex-wrap items-center gap-2 text-sm">
            <a href="{{ route('my-courses.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                كورساتي
            </a>
            <span class="text-gray-400">/</span>
            <a href="{{ route('my-courses.show', $course) }}" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                {{ $course->title }}
            </a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-900 dark:text-white font-medium">{{ $lecture->title }}</span>
        </div>

        @php
            $statusConfig = [
                'scheduled' => ['label' => 'مجدولة', 'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', 'icon' => 'fa-calendar'],
                'in_progress' => ['label' => 'قيد التنفيذ', 'class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 'icon' => 'fa-play-circle'],
                'completed' => ['label' => 'مكتملة', 'class' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', 'icon' => 'fa-check-circle'],
                'cancelled' => ['label' => 'ملغاة', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200', 'icon' => 'fa-times-circle'],
            ];
            $status = $statusConfig[$lecture->status] ?? $statusConfig['scheduled'];
        @endphp

        <!-- بطاقة المحاضرة -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- الهيدر -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $lecture->title }}</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2 {{ $status['class'] }}">
                            <i class="fas {{ $status['icon'] }} ml-2"></i>
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-600 dark:text-gray-400">
                    <span class="flex items-center">
                        <i class="fas fa-calendar-alt ml-2"></i>
                        {{ $lecture->scheduled_at->format('Y/m/d') }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-clock ml-2"></i>
                        {{ $lecture->scheduled_at->format('H:i') }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-hourglass-half ml-2"></i>
                        {{ $lecture->duration_minutes }} دقيقة
                    </span>
                    @if($lecture->instructor)
                        <span class="flex items-center">
                            <i class="fas fa-user-tie ml-2"></i>
                            {{ $lecture->instructor->name }}
                        </span>
                    @endif
                    @if($lecture->lesson)
                        <span class="flex items-center">
                            <i class="fas fa-book ml-2"></i>
                            {{ $lecture->lesson->title }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- روابط الدخول والتسجيل -->
            <div class="p-6 bg-gray-50 dark:bg-gray-700/30 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-link ml-2 text-blue-600 dark:text-blue-400"></i>
                    روابط المحاضرة
                </h2>
                <div class="space-y-3">
                    @if($lecture->teams_registration_link)
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ $lecture->teams_registration_link }}" target="_blank" rel="noopener"
                               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors shadow">
                                <i class="fas fa-edit ml-2"></i>
                                رابط التسجيل في المحاضرة
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">سجّل حضورك مسبقاً إن طُلب منك</span>
                        </div>
                    @endif
                    @if($lecture->teams_meeting_link)
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ $lecture->teams_meeting_link }}" target="_blank" rel="noopener"
                               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors shadow-lg">
                                <i class="fas fa-video ml-2"></i>
                                دخول المحاضرة (انضم الآن)
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">رابط Microsoft Teams للانضمام للمحاضرة المباشرة</span>
                        </div>
                    @endif
                    @if($lecture->recording_url)
                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ $lecture->recording_url }}" target="_blank" rel="noopener"
                               class="inline-flex items-center px-5 py-2.5 bg-gray-700 hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 text-white rounded-lg font-medium transition-colors">
                                <i class="fas fa-play-circle ml-2"></i>
                                مشاهدة تسجيل المحاضرة
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">متاح بعد انتهاء المحاضرة</span>
                        </div>
                    @endif
                    @if(!$lecture->teams_registration_link && !$lecture->teams_meeting_link && !$lecture->recording_url)
                        <p class="text-gray-500 dark:text-gray-400">لم يضف المدرب روابط لهذه المحاضرة بعد.</p>
                    @endif
                </div>
            </div>

            <!-- الوصف -->
            @if($lecture->description)
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <i class="fas fa-align-right ml-2 text-blue-600 dark:text-blue-400"></i>
                        وصف المحاضرة
                    </h2>
                    <div class="text-gray-600 dark:text-gray-300 whitespace-pre-line">{{ $lecture->description }}</div>
                </div>
            @endif

            <!-- ملاحظات المدرب -->
            @if($lecture->notes)
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <i class="fas fa-sticky-note ml-2 text-amber-600 dark:text-amber-400"></i>
                        ملاحظات المدرب
                    </h2>
                    <div class="text-gray-600 dark:text-gray-300 whitespace-pre-line bg-amber-50 dark:bg-amber-900/20 rounded-lg p-4">{{ $lecture->notes }}</div>
                </div>
            @endif

            <!-- العودة للكورس -->
            <div class="p-6">
                <a href="{{ route('my-courses.show', $course) }}?tab=lectures"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 font-medium transition-colors">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة إلى محاضرات الكورس
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
