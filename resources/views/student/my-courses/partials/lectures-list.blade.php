<div class="space-y-6">
    @if($course->lectures->count() > 0)
        <!-- إحصائيات المحاضرات -->
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            <i class="fas fa-chalkboard-teacher ml-1"></i>
            محاضرات المدرب والمحتوى المرفوع (روابط الانضمام، التسجيلات، المرفقات).
        </p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $course->lectures->where('status', 'scheduled')->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">مجدولة</div>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $course->lectures->where('status', 'in_progress')->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">قيد التنفيذ</div>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $course->lectures->where('status', 'completed')->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">مكتملة</div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <div class="text-2xl font-bold text-gray-600 dark:text-gray-400">{{ $course->lectures->count() }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">إجمالي</div>
            </div>
        </div>

        <!-- المحاضرات مرتبة حسب الدرس -->
        @if($lecturesByLesson->count() > 0)
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center">
                <i class="fas fa-layer-group ml-2"></i>
                المحاضرات مرتبة حسب الدرس
            </h3>
            @foreach($lecturesByLesson as $lessonId => $lectures)
                @php
                    $lesson = $course->lessons->find($lessonId);
                @endphp
                <div class="mb-8">
                    @if($lesson)
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-book text-blue-600 dark:text-blue-400 ml-2"></i>
                            {{ $lesson->title }}
                            <span class="mr-2 text-sm text-gray-500 dark:text-gray-400">({{ $lectures->count() }} محاضرة)</span>
                        </h4>
                    @else
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            محاضرات عامة
                            <span class="mr-2 text-sm text-gray-500 dark:text-gray-400">({{ $lectures->count() }} محاضرة)</span>
                        </h4>
                    @endif

                    <div class="space-y-3">
                        @foreach($lectures->sortByDesc('scheduled_at') as $lecture)
                            @php
                                $statusColors = [
                                    'scheduled' => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-800 dark:text-blue-200', 'icon' => 'fa-calendar'],
                                    'in_progress' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200', 'icon' => 'fa-play-circle'],
                                    'completed' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fa-check-circle'],
                                    'cancelled' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fa-times-circle'],
                                ];
                                $status = $statusColors[$lecture->status] ?? $statusColors['scheduled'];
                                $statusText = [
                                    'scheduled' => 'مجدولة',
                                    'in_progress' => 'قيد التنفيذ',
                                    'completed' => 'مكتملة',
                                    'cancelled' => 'ملغاة',
                                ][$lecture->status] ?? 'غير محدد';
                            @endphp

                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-start gap-4 flex-1">
                                        <!-- أيقونة المحاضرة -->
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 {{ $status['bg'] }} rounded-full flex items-center justify-center">
                                                <i class="fas {{ $status['icon'] }} {{ $status['text'] }}"></i>
                                            </div>
                                        </div>

                                        <!-- معلومات المحاضرة -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    {{ $lecture->title }}
                                                </h4>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                                    {{ $statusText }}
                                                </span>
                                            </div>
                                            @if($lecture->description)
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $lecture->description }}</p>
                                            @endif
                                            <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center">
                                                    <i class="fas fa-calendar-alt ml-1"></i>
                                                    {{ $lecture->scheduled_at->format('Y/m/d') }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-clock ml-1"></i>
                                                    {{ $lecture->scheduled_at->format('H:i') }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-hourglass-half ml-1"></i>
                                                    {{ $lecture->duration_minutes }} دقيقة
                                                </span>
                                                @if($lecture->instructor)
                                                    <span class="flex items-center">
                                                        <i class="fas fa-user-tie ml-1"></i>
                                                        {{ $lecture->instructor->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- أزرار العمل -->
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('my-courses.lectures.show', [$course, $lecture]) }}"
                                           class="inline-flex items-center px-4 py-2 bg-sky-100 dark:bg-sky-900/40 text-sky-700 dark:text-sky-300 rounded-lg hover:bg-sky-200 dark:hover:bg-sky-800/50 text-sm font-medium transition-colors">
                                            <i class="fas fa-info-circle ml-1"></i>
                                            تفاصيل المحاضرة
                                        </a>
                                        @if($lecture->teams_meeting_link)
                                            <a href="{{ $lecture->teams_meeting_link }}" target="_blank"
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                                <i class="fas fa-video ml-1"></i>
                                                انضم
                                            </a>
                                        @endif
                                        @if($lecture->recording_url)
                                            <a href="{{ $lecture->recording_url }}" target="_blank"
                                               class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                                <i class="fas fa-play-circle ml-1"></i>
                                                التسجيل
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <!-- المحاضرات غير مرتبطة بدروس -->
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center">
                <i class="fas fa-list ml-2"></i>
                جميع المحاضرات
            </h3>
            <div class="space-y-3">
                @foreach($course->lectures->sortByDesc('scheduled_at') as $lecture)
                    @php
                        $statusColors = [
                            'scheduled' => ['bg' => 'bg-blue-100 dark:bg-blue-900', 'text' => 'text-blue-800 dark:text-blue-200', 'icon' => 'fa-calendar'],
                            'in_progress' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900', 'text' => 'text-yellow-800 dark:text-yellow-200', 'icon' => 'fa-play-circle'],
                            'completed' => ['bg' => 'bg-green-100 dark:bg-green-900', 'text' => 'text-green-800 dark:text-green-200', 'icon' => 'fa-check-circle'],
                            'cancelled' => ['bg' => 'bg-red-100 dark:bg-red-900', 'text' => 'text-red-800 dark:text-red-200', 'icon' => 'fa-times-circle'],
                        ];
                        $status = $statusColors[$lecture->status] ?? $statusColors['scheduled'];
                        $statusText = [
                            'scheduled' => 'مجدولة',
                            'in_progress' => 'قيد التنفيذ',
                            'completed' => 'مكتملة',
                            'cancelled' => 'ملغاة',
                        ][$lecture->status] ?? 'غير محدد';
                    @endphp

                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:shadow-md transition-all duration-300">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 {{ $status['bg'] }} rounded-full flex items-center justify-center">
                                        <i class="fas {{ $status['icon'] }} {{ $status['text'] }}"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $lecture->title }}
                                        </h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['bg'] }} {{ $status['text'] }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                    @if($lecture->description)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $lecture->description }}</p>
                                    @endif
                                    <div class="flex flex-wrap items-center gap-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar-alt ml-1"></i>
                                            {{ $lecture->scheduled_at->format('Y/m/d') }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-clock ml-1"></i>
                                            {{ $lecture->scheduled_at->format('H:i') }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-hourglass-half ml-1"></i>
                                            {{ $lecture->duration_minutes }} دقيقة
                                        </span>
                                        @if($lecture->instructor)
                                            <span class="flex items-center">
                                                <i class="fas fa-user-tie ml-1"></i>
                                                {{ $lecture->instructor->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('my-courses.lectures.show', [$course, $lecture]) }}"
                                   class="inline-flex items-center px-4 py-2 bg-sky-100 dark:bg-sky-900/40 text-sky-700 dark:text-sky-300 rounded-lg hover:bg-sky-200 dark:hover:bg-sky-800/50 text-sm font-medium transition-colors">
                                    <i class="fas fa-info-circle ml-1"></i>
                                    تفاصيل المحاضرة
                                </a>
                                @if($lecture->teams_meeting_link)
                                    <a href="{{ $lecture->teams_meeting_link }}" target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        <i class="fas fa-video ml-1"></i>
                                        انضم
                                    </a>
                                @endif
                                @if($lecture->recording_url)
                                    <a href="{{ $lecture->recording_url }}" target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                        <i class="fas fa-play-circle ml-1"></i>
                                        التسجيل
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-chalkboard-teacher text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">لا توجد محاضرات</h3>
            <p class="text-gray-500 dark:text-gray-400">لم يتم جدولة أي محاضرات لهذا الكورس بعد.</p>
        </div>
    @endif
</div>

