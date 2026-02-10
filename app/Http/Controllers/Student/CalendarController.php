<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->get('year', now()->year);
        $month = (int) $request->get('month', now()->month);

        $events = CalendarEvent::visibleToUser(auth()->user())
            ->inMonth($year, $month)
            ->orderBy('start_date')
            ->get();

        $upcoming = CalendarEvent::visibleToUser(auth()->user())
            ->upcoming(15)
            ->get();

        $prevMonth = $month === 1 ? 12 : $month - 1;
        $prevYear = $month === 1 ? $year - 1 : $year;
        $nextMonth = $month === 12 ? 1 : $month + 1;
        $nextYear = $month === 12 ? $year + 1 : $year;

        $currentMonth = \Carbon\Carbon::createFromDate($year, $month, 1);

        return view('student.calendar.index', compact(
            'events',
            'upcoming',
            'year',
            'month',
            'currentMonth',
            'prevMonth',
            'prevYear',
            'nextMonth',
            'nextYear'
        ));
    }

    public function create()
    {
        $types = CalendarEvent::typeLabels();
        $colors = CalendarEvent::colorMap();
        return view('student.calendar.create', compact('types', 'colors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_all_day' => 'boolean',
            'type' => 'required|in:exam,lesson,assignment,meeting,holiday,deadline,review,personal,system',
            'color' => 'nullable|string|max:7',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ], [
            'title.required' => 'عنوان الحدث مطلوب',
            'start_date.required' => 'تاريخ البداية مطلوب',
        ]);

        $data['created_by'] = auth()->id();
        $data['is_all_day'] = $request->boolean('is_all_day');
        $data['visibility'] = 'private';
        $data['status'] = 'scheduled';
        if (empty($data['color'])) {
            $data['color'] = CalendarEvent::colorMap()[$data['type']] ?? '#3B82F6';
        }
        if (empty($data['end_date']) && !$data['is_all_day']) {
            $data['end_date'] = $data['start_date'];
        }

        CalendarEvent::create($data);

        return redirect()->route('calendar')->with('success', 'تم إضافة الحدث بنجاح');
    }

    public function edit(CalendarEvent $event)
    {
        if ($event->created_by !== auth()->id()) {
            abort(403);
        }
        $types = CalendarEvent::typeLabels();
        $colors = CalendarEvent::colorMap();
        return view('student.calendar.edit', compact('event', 'types', 'colors'));
    }

    public function update(Request $request, CalendarEvent $event)
    {
        if ($event->created_by !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_all_day' => 'boolean',
            'type' => 'required|in:exam,lesson,assignment,meeting,holiday,deadline,review,personal,system',
            'color' => 'nullable|string|max:7',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:scheduled,completed,cancelled,postponed',
        ]);

        $data['is_all_day'] = $request->boolean('is_all_day');
        if (empty($data['end_date']) && !$data['is_all_day']) {
            $data['end_date'] = $data['start_date'];
        }
        if (empty($data['color'])) {
            $data['color'] = CalendarEvent::colorMap()[$data['type']] ?? '#3B82F6';
        }

        $event->update($data);

        return redirect()->route('calendar')->with('success', 'تم تحديث الحدث بنجاح');
    }

    public function destroy(CalendarEvent $event)
    {
        if ($event->created_by !== auth()->id()) {
            abort(403);
        }
        $event->delete();
        return redirect()->route('calendar')->with('success', 'تم حذف الحدث');
    }
}
