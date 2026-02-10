@extends('layouts.app')

@section('title', 'لوحة تحكم الطالب')
@section('header', 'لوحة تحكم الطالب')

@section('content')
<div class="space-y-6">
    <!-- ترحيب شخصي -->
    <div class="bg-gradient-to-r from-sky-500 via-sky-600 to-slate-600 rounded-2xl shadow-2xl p-8 text-white relative overflow-hidden card-hover-effect">
        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black mb-2">مرحباً، {{ auth()->user()->name }}</h2>
                    <p class="text-sky-100 text-lg font-medium">استمر في التعلم وحقق أهدافك التعليمية</p>
                </div>
                <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-xl border border-white/30">
                    <i class="fas fa-user-graduate text-4xl text-white"></i>
                </div>
            </div>
            
            <!-- شريط التقدم العام -->
            <div class="mt-8">
                <div class="flex items-center justify-between text-sm mb-3 font-semibold">
                    <span class="text-white">التقدم الإجمالي</span>
                    <span class="text-2xl font-black">{{ $stats['total_progress'] }}%</span>
                </div>
                <div class="w-full bg-white/20 backdrop-blur-sm rounded-full h-3 shadow-inner border border-white/30">
                    <div class="bg-gradient-to-r from-white via-sky-100 to-white h-3 rounded-full transition-all duration-500 shadow-lg" style="width: {{ $stats['total_progress'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- كورساتي المفعلة -->
        <div class="bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-sky-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-slate-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">كورساتي المفعلة</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-sky-700 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-sky-500 dark:to-slate-400">{{ number_format($stats['active_courses']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-play-circle text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('academic-years') }}" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        عرض الكورسات
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- الكورسات المكتملة -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-green-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-emerald-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">مكتمل</p>
                        <p class="text-4xl font-black text-green-600 dark:text-green-400">{{ number_format($stats['completed_courses']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-sm font-semibold text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition-colors inline-flex items-center gap-2">
                        عرض الشهادات
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- طلباتي المعلقة -->
        <div class="bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-amber-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-100/50 to-yellow-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">طلبات معلقة</p>
                        <p class="text-4xl font-black text-amber-600 dark:text-amber-400">{{ number_format($stats['pending_orders']) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors inline-flex items-center gap-2">
                        عرض الطلبات
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- التقدم الإجمالي -->
        <div class="bg-gradient-to-br from-slate-50 to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl p-6 border border-slate-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 card-hover-effect relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-100/50 to-gray-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-1">التقدم</p>
                        <p class="text-4xl font-black bg-gradient-to-r from-sky-600 via-sky-700 to-slate-600 bg-clip-text text-transparent dark:from-sky-400 dark:via-sky-500 dark:to-slate-400">{{ $stats['total_progress'] }}%</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-500 via-sky-600 to-slate-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">متوسط التقدم</span>
                </div>
            </div>
        </div>
    </div>

    <!-- كورساتي الحالية -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- الكورسات الجارية -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 card-hover-effect">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">
                        <i class="fas fa-play-circle text-sky-600 dark:text-sky-400 ml-2"></i>
                        كورساتي المفعلة
                    </h3>
                    <a href="{{ route('academic-years') }}" class="text-sm font-semibold text-sky-600 dark:text-sky-400 hover:text-sky-700 dark:hover:text-sky-300 transition-colors inline-flex items-center gap-2">
                        عرض الكل
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($activeCourses as $course)
                    <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl hover:from-sky-100 hover:to-slate-100 dark:hover:from-gray-600 dark:hover:to-gray-600 transition-all duration-300 cursor-pointer border border-sky-100 dark:border-gray-600 card-hover-effect group">
                        <div class="w-14 h-14 bg-gradient-to-br from-sky-500 via-sky-600 to-slate-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-play text-white text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate mb-1">{{ $course->title }}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">
                                <i class="fas fa-book text-sky-500 ml-1"></i>
                                {{ optional($course->academicSubject)->name ?? 'غير محدد' }} - {{ $course->academicYear->name ?? 'غير محدد' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                <i class="fas fa-user text-slate-500 ml-1"></i>
                                بواسطة: {{ $course->teacher->name ?? 'غير محدد' }}
                            </p>
                            
                            <!-- شريط التقدم -->
                            @php
                                $progress = (float) ($course->pivot->progress ?? optional($course->enrollment ?? null)->progress ?? 0);
                            @endphp
                            <div class="mt-3">
                                <div class="flex items-center justify-between text-xs mb-2 font-semibold">
                                    <span class="text-gray-700 dark:text-gray-300">التقدم</span>
                                    <span class="text-sky-600 dark:text-sky-400 font-bold">{{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 shadow-inner">
                                    <div class="bg-gradient-to-r from-sky-500 via-sky-600 to-slate-600 h-2.5 rounded-full transition-all duration-500 shadow-lg" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            @if(!empty($course->id))
                            <a href="{{ route('my-courses.show', $course->id) }}" class="p-3 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl text-white hover:from-sky-600 hover:to-sky-700 transition-all duration-300 shadow-md hover:shadow-lg">
                                <i class="fas fa-play"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-book-open text-3xl mb-2"></i>
                        <p>لا توجد كورسات مفعلة</p>
                        <a href="{{ route('academic-years') }}" class="inline-flex items-center mt-3 px-6 py-3 bg-gradient-to-r from-sky-500 to-sky-600 text-white rounded-xl hover:from-sky-600 hover:to-sky-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                            <i class="fas fa-search ml-2"></i>
                            استكشف الكورسات
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- الطلبات الأخيرة -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">طلباتي الأخيرة</h3>
                    <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">عرض الكل</a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                    <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                        <div class="w-10 h-10 
                            @if($order->status == 'pending') bg-yellow-100 dark:bg-yellow-900
                            @elseif($order->status == 'approved') bg-green-100 dark:bg-green-900
                            @else bg-red-100 dark:bg-red-900
                            @endif 
                            rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas 
                                @if($order->status == 'pending') fa-clock text-yellow-600 dark:text-yellow-400
                                @elseif($order->status == 'approved') fa-check text-green-600 dark:text-green-400
                                @else fa-times text-red-600 dark:text-red-400
                                @endif"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $order->course->title }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ optional($order->course->academicSubject)->name ?? 'غير محدد' }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($order->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $order->status_text }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                        <p>لا توجد طلبات</p>
                        <a href="{{ route('academic-years') }}" class="inline-flex items-center mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-plus ml-2"></i>
                            اطلب كورس
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- الواجبات والاختبارات القادمة -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-tasks text-sky-600 dark:text-sky-400 ml-2"></i>
                    الواجبات القادمة
                </h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $upcomingAssignments->count() }} واجب</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($upcomingAssignments as $assignment)
                        @php
                            $lecture = $assignment->lecture;
                            $course = optional($lecture)->course;
                            $dueDate = optional($assignment->due_date);
                            $isOverdue = $dueDate && $dueDate->isPast();
                            $dueText = $dueDate ? $dueDate->translatedFormat('d F Y g:i A') : 'بدون موعد نهائي';
                            $dueBadgeClass = $isOverdue
                                ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300'
                                : 'bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300';
                        @endphp
                        <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600 card-hover-effect">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center {{ $isOverdue ? 'bg-rose-500/15 text-rose-500' : 'bg-sky-500/15 text-sky-500' }}">
                                <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $assignment->title }}</h4>
                                @if($course)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-book-open ml-1 text-sky-500"></i>
                                        {{ $course->title }}
                                    </p>
                                @endif
                                @if($lecture)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-chalkboard-teacher ml-1 text-slate-500"></i>
                                        {{ $lecture->title }}
                                    </p>
                                @endif
                                <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full font-semibold {{ $dueBadgeClass }}">
                                        <i class="fas fa-clock ml-1 text-[10px]"></i>
                                        {{ $dueText }}
                                </span>
                                    @if($dueDate)
                                        <span class="text-gray-500 dark:text-gray-400">{{ $dueDate->diffForHumans() }}</span>
                                    @endif
                                    @if(!is_null($assignment->max_score))
                                        <span class="text-gray-500 dark:text-gray-400">
                                            الدرجة: {{ $assignment->max_score }}
                                </span>
                                    @endif
                        </div>
                            </div>
                            @if($course)
                                <a href="{{ route('my-courses.show', $course->id) }}" class="px-3 py-2 text-xs font-semibold rounded-lg bg-sky-500 text-white hover:bg-sky-600 transition-colors">
                                    متابعة
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-clipboard-check text-3xl mb-3"></i>
                            <p>لا توجد واجبات قادمة للكورسات المفعلة حالياً.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-clipboard-check text-purple-600 dark:text-purple-400 ml-2"></i>
                    الاختبارات القادمة
                </h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $upcomingExams->count() }} اختبار</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($upcomingExams as $exam)
                        @php
                            $course = $exam->course;
                            $startAt = $exam->start_time ?? ($exam->start_date ? $exam->start_date->copy()->startOfDay() : null);
                            $endAt = $exam->end_time ?? ($exam->end_date ? $exam->end_date->copy()->endOfDay() : null);
                            $isAvailableNow = $startAt ? $startAt->isPast() : true;
                            $statusText = $isAvailableNow ? 'متاح الآن' : 'سيبدأ قريباً';
                            $statusClass = $isAvailableNow
                                ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                                : 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300';
                            if ($endAt && $endAt->isPast()) {
                                $statusText = 'انتهى';
                                $statusClass = 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-200';
                            }
                            $startText = $startAt ? $startAt->translatedFormat('d F Y g:i A') : 'متاح فوراً';
                            $remainingAttempts = method_exists($exam, 'getRemainingAttempts') ? $exam->getRemainingAttempts(auth()->id()) : null;
                        @endphp
                        <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-purple-100 dark:border-gray-600 card-hover-effect">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-purple-500/15 text-purple-500">
                                <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $exam->title }}</h4>
                                @if($course)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-book ml-1 text-purple-500"></i>
                                        {{ $course->title }}
                                    </p>
                                @endif
                                <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full font-semibold {{ $statusClass }}">
                                        <i class="fas fa-calendar ml-1 text-[10px]"></i>
                                        {{ $statusText }} @if($startAt) – {{ $startText }} @endif
                                    </span>
                                    @if($exam->duration_minutes)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                            <i class="fas fa-hourglass-half ml-1 text-[10px]"></i>
                                            المدة: {{ $exam->duration_minutes }} دقيقة
                                </span>
                                    @endif
                                    @if(!is_null($remainingAttempts))
                                        <span class="text-gray-500 dark:text-gray-400">
                                            المحاولات المتبقية: {{ $remainingAttempts }}
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('student.exams.show', $exam) }}" class="px-3 py-2 text-xs font-semibold rounded-lg bg-purple-500 text-white hover:bg-purple-600 transition-colors">
                                    التفاصيل
                                </a>
                                @if($endAt)
                                    <span class="text-[10px] text-gray-500 dark:text-gray-400 text-center">
                                        ينتهي {{ $endAt->diffForHumans() }}
                                </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-clipboard-list text-3xl mb-3"></i>
                            <p>لا توجد اختبارات قادمة للكورسات الحالية.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- نتائج الامتحانات والشهادات -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-chart-pie text-emerald-600 dark:text-emerald-400 ml-2"></i>
                    نتائج الامتحانات الأخيرة
                </h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $recentExamAttempts->count() }} نتيجة</span>
        </div>
        <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentExamAttempts as $attempt)
                        @php
                            $exam = $attempt->exam;
                            $course = optional($exam)->course;
                            $resultColor = [
                                'green' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
                                'red' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300',
                                'gray' => 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                            ][$attempt->result_color ?? 'gray'];
                        @endphp
                        <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-emerald-100 dark:border-gray-600 card-hover-effect">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-emerald-500/15 text-emerald-500">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $exam->title ?? 'امتحان محذوف' }}</h4>
                                @if($course)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-book ml-1 text-emerald-500"></i>
                                        {{ $course->title }}
                                    </p>
                                @endif
                                <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full font-semibold {{ $resultColor }}">
                                        <i class="fas fa-check-circle ml-1 text-[10px]"></i>
                                        {{ $attempt->result_status }}
                                    </span>
                                    @if(!is_null($attempt->percentage))
                                        <span class="text-gray-600 dark:text-gray-300">
                                            النسبة: {{ number_format($attempt->percentage, 1) }}%
                                        </span>
                                    @endif
                                    @if(!is_null($attempt->score))
                                        <span class="text-gray-500 dark:text-gray-400">
                                            الدرجة: {{ number_format($attempt->score, 1) }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                    تم التحديث {{ $attempt->created_at->diffForHumans() }}
                                </p>
                            </div>
                            @if($exam)
                                <a href="{{ route('student.exams.result', [$exam, $attempt]) }}" class="px-3 py-2 text-xs font-semibold rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition-colors">
                                    عرض النتيجة
                                </a>
                            @endif
                    </div>
                    @empty
                        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-poll text-3xl mb-3"></i>
                            <p>لم يتم تسجيل نتائج امتحانات بعد.</p>
                    </div>
                    @endforelse
                </div>
                    </div>
                </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-gray-800 dark:to-gray-800 rounded-t-2xl flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-certificate text-amber-500 dark:text-amber-400 ml-2"></i>
                    الشهادات الصادرة
                </h3>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $recentCertificates->count() }} شهادة</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentCertificates as $certificate)
                        <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-amber-100 dark:border-gray-600 card-hover-effect">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-amber-500/15 text-amber-500">
                                <i class="fas fa-ribbon"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                    {{ $certificate->title ?? $certificate->course_name ?? 'شهادة بدون عنوان' }}
                                </h4>
                                @if($certificate->course)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-book ml-1 text-amber-500"></i>
                                        {{ $certificate->course->title }}
                                    </p>
                                @endif
                                <div class="flex flex-wrap items-center gap-2 mt-3 text-xs">
                                    @if($certificate->certificate_number)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                                            رقم الشهادة: {{ $certificate->certificate_number }}
                                        </span>
                                    @endif
                                    @if($certificate->issue_date)
                                        <span class="text-gray-600 dark:text-gray-300">
                                            أُصدرت في {{ $certificate->issue_date->translatedFormat('d F Y') }}
                                        </span>
                                    @endif
                                    <span class="text-gray-500 dark:text-gray-400">
                                        الحالة: {{ $certificate->status ? __($certificate->status) : 'صادرة' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full {{ $certificate->is_verified ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}">
                                        {{ $certificate->is_verified ? 'موثّقة' : 'غير موثّقة' }}
                                    </span>
                                </div>
                            </div>
                    </div>
                    @empty
                        <div class="text-center py-10 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-certificate text-3xl mb-3"></i>
                            <p>لم يتم إصدار شهادات حتى الآن.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
