<div class="space-y-4">
    @forelse($course->lessons->sortBy('order') as $index => $lesson)
        @php
            $lessonProgress = $lesson->progress->first();
            $isCompleted = $lessonProgress && $lessonProgress->is_completed;
            $isCurrentLesson = !$isCompleted && ($index == 0 || $course->lessons->take($index)->every(function($prevLesson) {
                return $prevLesson->progress->isNotEmpty() && $prevLesson->progress->first()->is_completed;
            }));
        @endphp

        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-5 hover:shadow-md transition-all duration-300 {{ $isCurrentLesson ? 'ring-2 ring-blue-500' : '' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4 flex-1">
                    <!-- أيقونة الحالة -->
                    <div class="flex-shrink-0">
                        @if($isCompleted)
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 dark:text-green-400 text-lg"></i>
                            </div>
                        @elseif($isCurrentLesson)
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center animate-pulse">
                                <i class="fas fa-play text-blue-600 dark:text-blue-400 text-lg"></i>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <i class="fas fa-lock text-gray-400 text-lg"></i>
                            </div>
                        @endif
                    </div>

                    <!-- معلومات الدرس -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $lesson->title }}
                            </h3>
                            @if($isCurrentLesson)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    الدرس الحالي
                                </span>
                            @endif
                        </div>
                        @if($lesson->description)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $lesson->description }}</p>
                        @endif
                        <div class="flex items-center gap-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
                            <span class="flex items-center">
                                <i class="fas fa-clock ml-1"></i>
                                {{ $lesson->duration_minutes ?? 0 }} دقيقة
                            </span>
                            @if($lesson->video_url)
                                <span class="flex items-center">
                                    <i class="fas fa-video ml-1"></i>
                                    فيديو
                                </span>
                            @endif
                            @if($lesson->attachments && $lesson->attachments != '[]' && $lesson->attachments != 'null')
                                <span class="flex items-center">
                                    <i class="fas fa-paperclip ml-1"></i>
                                    مرفقات
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- أزرار العمل -->
                <div class="flex items-center gap-2">
                    @if($isCompleted)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            <i class="fas fa-check-circle mr-1"></i>
                            مكتمل
                        </span>
                        <a href="{{ route('my-courses.lesson.watch', [$course, $lesson]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <i class="fas fa-eye ml-1"></i>
                            مراجعة
                        </a>
                    @elseif($isCurrentLesson)
                        <a href="{{ route('my-courses.lesson.watch', [$course, $lesson]) }}" 
                           class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-medium transition-all duration-300 shadow-lg shadow-blue-500/30">
                            <i class="fas fa-play ml-2"></i>
                            ابدأ الدرس
                        </a>
                    @else
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                            <i class="fas fa-lock mr-1"></i>
                            مقفل
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-video text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">لا توجد دروس</h3>
            <p class="text-gray-500 dark:text-gray-400">لم يتم إضافة دروس لهذا الكورس بعد.</p>
        </div>
    @endforelse
</div>

