@extends('layouts.app')

@section('title', $course->title . ' - كورساتي')
@section('header', $course->title)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8" 
     x-data="{
         activeTab: (() => {
             const urlParams = new URLSearchParams(window.location.search);
             const tab = urlParams.get('tab');
             return tab && ['overview', 'lessons', 'lectures'].includes(tab) ? tab : 'overview';
         })()
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- العودة -->
        <div class="mb-6">
            <a href="{{ route('my-courses.index') }}" 
               class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة إلى كورساتي
            </a>
        </div>

        <!-- معلومات الكورس -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mb-6 overflow-hidden">
            <div class="md:flex">
                <!-- صورة الكورس -->
                <div class="md:w-1/3 h-64 md:h-auto bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-center text-white">
                            <i class="fas fa-graduation-cap text-5xl mb-3"></i>
                            <p>{{ optional($course->academicSubject)->name ?? 'كورس' }}</p>
                        </div>
                    @endif
                </div>

                <!-- تفاصيل الكورس -->
                <div class="md:w-2/3 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $course->title }}</h1>
                            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <span class="flex items-center">
                                    <i class="fas fa-graduation-cap ml-2"></i>
                                    {{ $course->academicYear->name ?? 'غير محدد' }}@if($course->academicSubject) - {{ $course->academicSubject->name }}@endif
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-user-tie ml-2"></i>
                                    {{ $course->teacher->name ?? 'غير محدد' }}
                                </span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="fas fa-check-circle mr-1"></i>
                            مفعل
                        </span>
                    </div>

                    @if($course->description)
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $course->description }}</p>
                    @endif

                    <!-- شريط التقدم الإجمالي -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">التقدم الإجمالي</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $progress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span>{{ $completedLessons }} من {{ $totalLessons }} درس مكتمل</span>
                            <span>{{ $course->duration_hours }} ساعة إجمالية</span>
                        </div>
                    </div>

                    <!-- إحصائيات سريعة -->
                    <div class="grid grid-cols-3 gap-4 text-center mb-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalLessons }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">دروس</div>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $completedLessons }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">مكتمل</div>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $course->lectures->count() }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">محاضرة</div>
                        </div>
                    </div>

                    <!-- أزرار العمل -->
                    <div class="flex gap-3">
                        <a href="{{ route('my-courses.show', $course) }}?tab=lessons" 
                           class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition-all duration-300 shadow-lg shadow-blue-500/30">
                            <i class="fas fa-play ml-2"></i>
                            ابدأ التعلم
                        </a>
                        <a href="{{ route('my-courses.show', $course) }}?tab=lectures" 
                           class="inline-flex items-center px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 font-medium transition-colors">
                            <i class="fas fa-chalkboard-teacher ml-2"></i>
                            المحاضرات
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mb-6">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex -mb-px">
                    <button @click="activeTab = 'overview'" 
                            :class="activeTab === 'overview' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="py-4 px-6 text-sm font-medium border-b-2 transition-colors">
                        <i class="fas fa-info-circle ml-2"></i>
                        نظرة عامة
                    </button>
                    <button @click="activeTab = 'lessons'" 
                            :class="activeTab === 'lessons' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="py-4 px-6 text-sm font-medium border-b-2 transition-colors">
                        <i class="fas fa-book ml-2"></i>
                        الدروس ({{ $totalLessons }})
                    </button>
                    <button @click="activeTab = 'lectures'" 
                            :class="activeTab === 'lectures' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                            class="py-4 px-6 text-sm font-medium border-b-2 transition-colors">
                        <i class="fas fa-chalkboard-teacher ml-2"></i>
                        المحاضرات ({{ $course->lectures->count() }})
                    </button>
                </nav>
            </div>

            <!-- توضيح الفرق بين الدروس والمحاضرات -->
            <div class="mx-6 mt-4 p-4 bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-800 rounded-xl">
                <h4 class="text-sm font-semibold text-sky-900 dark:text-sky-200 mb-2 flex items-center">
                    <i class="fas fa-lightbulb ml-2"></i>
                    ما الفرق بين الدروس والمحاضرات؟
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-sky-800 dark:text-sky-300">
                    <div class="flex gap-3">
                        <span class="flex-shrink-0 w-8 h-8 bg-sky-200 dark:bg-sky-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-sky-600 dark:text-sky-400"></i>
                        </span>
                        <div>
                            <strong class="block text-sky-900 dark:text-sky-100">الدروس:</strong>
                            محتوى مسجل ومنهج مرتب (فيديوهات، نصوص). تتابع الدروس بالترتيب وتكمل كل درس لفتح التالي. يمكنك مشاهدتها في أي وقت.
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="flex-shrink-0 w-8 h-8 bg-sky-200 dark:bg-sky-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-sky-600 dark:text-sky-400"></i>
                        </span>
                        <div>
                            <strong class="block text-sky-900 dark:text-sky-100">المحاضرات:</strong>
                            جلسات مباشرة أو مجدولة مع المدرب (مثل Microsoft Teams). يوجد رابط للانضمام في موعد المحاضرة، وبعد انتهائها قد يُرفع تسجيل للمشاهدة.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Overview Tab -->
                <div x-show="activeTab === 'overview'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">وصف الكورس</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $course->description ?? 'لا يوجد وصف متاح' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">معلومات الكورس</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">المستوى:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $course->level ?? 'غير محدد' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">المدة:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $course->duration_hours }} ساعة</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">عدد الدروس:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $totalLessons }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">عدد المحاضرات:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $course->lectures->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lessons Tab -->
                <div x-show="activeTab === 'lessons'" x-transition>
                    @include('student.my-courses.partials.lessons-list', ['course' => $course])
                </div>

                <!-- Lectures Tab -->
                <div x-show="activeTab === 'lectures'" x-transition>
                    @include('student.my-courses.partials.lectures-list', ['course' => $course, 'lecturesByLesson' => $lecturesByLesson ?? collect()])
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
