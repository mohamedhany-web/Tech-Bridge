@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">التقويم الأكاديمي</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">الأحداث والمواعيد المهمة</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('calendar.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            إضافة حدث
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('calendar', ['year' => $prevYear, 'month' => $prevMonth]) }}" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white min-w-[180px] text-center">
                                {{ $currentMonth->locale('ar')->translatedFormat('F Y') }}
                            </h2>
                            <a href="{{ route('calendar', ['year' => $nextYear, 'month' => $nextMonth]) }}" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </div>
                        <a href="{{ route('calendar') }}" class="text-sm text-sky-600 dark:text-sky-400 hover:underline">الشهر الحالي</a>
                    </div>

                    @php
                        $start = $currentMonth->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::SUNDAY);
                        $end = $currentMonth->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);
                        $days = [];
                        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
                            $days[] = $d->copy();
                        }
                        $eventsByDay = $events->groupBy(fn($e) => $e->start_date->format('Y-m-d'));
                    @endphp

                    <div class="grid grid-cols-7 gap-1 mb-4">
                        @foreach(['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'] as $day)
                            <div class="p-2 text-center text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 rounded">
                                {{ $day }}
                            </div>
                        @endforeach
                        @foreach($days as $day)
                            @php
                                $key = $day->format('Y-m-d');
                                $dayEvents = $eventsByDay->get($key, collect());
                                $isToday = $day->isToday();
                                $isCurrentMonth = $day->month === $month;
                            @endphp
                            <div class="p-2 min-h-[80px] border border-gray-200 dark:border-gray-700 rounded {{ !$isCurrentMonth ? 'bg-gray-50 dark:bg-gray-900/50 text-gray-400' : '' }} {{ $isToday ? 'ring-2 ring-blue-500' : '' }}">
                                <div class="text-sm {{ $isToday ? 'font-bold text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ $day->day }}
                                </div>
                                @foreach($dayEvents->take(2) as $ev)
                                    <a href="{{ route('calendar.edit', $ev) }}" class="block mt-1 text-xs truncate rounded px-1 py-0.5 text-white" style="background-color: {{ $ev->color }};">
                                        {{ $ev->title }}
                                    </a>
                                @endforeach
                                @if($dayEvents->count() > 2)
                                    <span class="text-xs text-gray-500">+{{ $dayEvents->count() - 2 }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">أحداث هذا الشهر</h3>
                    @if($events->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">لا توجد أحداث في هذا الشهر.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($events->take(10) as $event)
                                <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $event->color }}"></span>
                                        <a href="{{ route('calendar.edit', $event) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-sky-600 truncate">{{ $event->title }}</a>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $event->start_date->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-300">{{ \App\Models\CalendarEvent::typeLabels()[$event->type] ?? $event->type }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">الأحداث القادمة</h3>
                    @if($upcoming->isEmpty())
                        <p class="text-sm text-gray-500 dark:text-gray-400">لا توجد أحداث قادمة.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($upcoming as $event)
                                <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $event->color }}"></span>
                                        <a href="{{ route('calendar.edit', $event) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-sky-600 truncate">{{ $event->title }}</a>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $event->start_date->format('d/m/Y - H:i') }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
