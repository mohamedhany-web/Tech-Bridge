<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\AdvancedCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::with(['academicSubjects'])
            ->ordered()
            ->get();

        $allCourses = AdvancedCourse::where('is_active', true)
            ->select([
                'id',
                'title',
                'description',
                'category',
                'programming_language',
                'framework',
                'level',
                'duration_hours',
                'duration_minutes',
                'price',
                'is_free',
                'rating',
                'skills',
                'created_at',
            ])
            ->get();

        $tracks = $academicYears->map(function (AcademicYear $year) use ($allCourses) {
            return $this->hydrateTrack($year, $allCourses);
        });

        $summary = [
            'total_tracks' => $tracks->count(),
            'active_tracks' => $tracks->where('is_active', true)->count(),
            'courses' => $tracks->sum(fn($track) => optional($track->track_metrics)['courses_count'] ?? 0),
            'languages' => $tracks->flatMap(fn($track) => optional($track->track_metrics)['languages'] ?? [])->filter()->unique()->values(),
            'frameworks' => $tracks->flatMap(fn($track) => optional($track->track_metrics)['frameworks'] ?? [])->filter()->unique()->values(),
        ];

        return view('admin.academic-years.index', compact('tracks', 'summary'));
    }

    public function create()
    {
        return view('admin.academic-years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:academic_years',
            'code' => 'required|string|max:10|unique:academic_years',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم السنة الدراسية مطلوب',
            'name.unique' => 'اسم السنة الدراسية موجود مسبقاً',
            'code.required' => 'رمز السنة الدراسية مطلوب',
            'code.unique' => 'رمز السنة الدراسية موجود مسبقاً',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;

        AcademicYear::create($data);

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'تم إضافة مسار التعلم بنجاح');
    }

    public function show(AcademicYear $academicYear)
    {
        $academicYear->load(['academicSubjects']);

        $academicYear->academicSubjects->each(function ($subject) {
            $subject->advanced_courses_count = 0;
            $subject->setRelation('advancedCourses', collect());
        });

        return view('admin.academic-years.show', compact('academicYear'));
    }

    public function edit(AcademicYear $academicYear)
    {
        $allCourses = AdvancedCourse::where('is_active', true)
            ->select([
                'id',
                'title',
                'description',
                'category',
                'programming_language',
                'framework',
                'level',
                'duration_hours',
                'duration_minutes',
                'price',
                'is_free',
                'rating',
                'skills',
                'created_at',
            ])->get();

        $track = $this->hydrateTrack($academicYear, $allCourses);

        $trackSummary = [
            'courses_count' => optional($track->track_metrics)['courses_count'] ?? 0,
            'languages' => collect(optional($track->track_metrics)['languages'] ?? []),
            'frameworks' => collect(optional($track->track_metrics)['frameworks'] ?? []),
            'levels' => collect(optional($track->track_metrics)['levels'] ?? []),
            'avg_duration' => optional($track->track_metrics)['avg_duration'] ?? null,
            'avg_rating' => optional($track->track_metrics)['avg_rating'] ?? null,
        ];

        return view('admin.academic-years.edit', [
            'academicYear' => $academicYear,
            'track' => $track,
            'trackSummary' => $trackSummary,
        ]);
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('academic_years')->ignore($academicYear->id),
            ],
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('academic_years')->ignore($academicYear->id),
            ],
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم السنة الدراسية مطلوب',
            'name.unique' => 'اسم السنة الدراسية موجود مسبقاً',
            'code.required' => 'رمز السنة الدراسية مطلوب',
            'code.unique' => 'رمز السنة الدراسية موجود مسبقاً',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;

        $academicYear->update($data);

        return redirect()->route('admin.academic-years.edit', $academicYear)
            ->with('success', 'تم تحديث مسار التعلم بنجاح');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return redirect()->route('admin.academic-years.index')
            ->with('success', 'تم حذف مسار التعلم بنجاح');
    }

    public function toggleStatus(Request $request, AcademicYear $academicYear)
    {
        $academicYear->update([
            'is_active' => !$academicYear->is_active
        ]);

        $status = $academicYear->is_active ? 'تم تفعيل' : 'تم إلغاء تفعيل';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $status . ' المسار بنجاح',
                'is_active' => $academicYear->is_active
            ]);
        }

        return redirect()->back()->with('success', $status . ' المسار بنجاح');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:academic_years,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $item) {
            AcademicYear::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث ترتيب المسارات التعليمية بنجاح'
        ]);
    }

    private function hydrateTrack(AcademicYear $year, Collection $courses): AcademicYear
    {
        $matchedCourses = $this->filterCourses($courses, [$year->code, $year->name, $year->description]);
        if ($matchedCourses->isEmpty()) {
            $matchedCourses = $courses;
        }

        $languages = $matchedCourses->pluck('programming_language')->filter()->unique()->values();
        $frameworks = $matchedCourses->pluck('framework')->filter()->unique()->values();
        $levels = $matchedCourses->pluck('level')->filter()->unique()->values();
        $minutes = $matchedCourses->sum(function ($course) {
            return ((int) ($course->duration_hours ?? 0) * 60) + (int) ($course->duration_minutes ?? 0);
        });
        $avgMinutes = $matchedCourses->count() > 0 ? (int) round($minutes / $matchedCourses->count()) : 0;

        $year->setAttribute('track_metrics', [
            'courses_count' => $matchedCourses->count(),
            'languages' => $languages->take(8),
            'frameworks' => $frameworks->take(8),
            'levels' => $levels,
            'avg_duration' => $this->formatDurationMinutes($avgMinutes),
            'avg_rating' => $matchedCourses->count() > 0 ? round((float) ($matchedCourses->avg('rating') ?? 0), 1) : null,
        ]);

        $year->setRelation('preview_courses', $matchedCourses->sortByDesc('created_at')->take(3));

        return $year;
    }

    private function hydrateClusterForTrack($subject, Collection $courses)
    {
        $track = $subject->academicYear;

        $matchedCourses = $this->filterCourses($courses, [
            optional($track)->code,
            optional($track)->name,
            $subject->code,
            $subject->name,
            $subject->description,
        ]);

        if ($matchedCourses->isEmpty()) {
            $matchedCourses = $courses;
        }

        $languages = $matchedCourses->pluck('programming_language')->filter()->unique()->values();
        $frameworks = $matchedCourses->pluck('framework')->filter()->unique()->values();
        $levels = $matchedCourses->pluck('level')->filter()->unique()->values();
        $minutes = $matchedCourses->sum(function ($course) {
            return ((int) ($course->duration_hours ?? 0) * 60) + (int) ($course->duration_minutes ?? 0);
        });
        $avgMinutes = $matchedCourses->count() > 0 ? (int) round($minutes / $matchedCourses->count()) : 0;

        $subject->setAttribute('cluster_metrics', [
            'courses_count' => $matchedCourses->count(),
            'languages' => $languages->take(8),
            'frameworks' => $frameworks->take(8),
            'levels' => $levels,
            'avg_duration' => $this->formatDurationMinutes($avgMinutes),
            'avg_rating' => $matchedCourses->count() > 0 ? round((float) ($matchedCourses->avg('rating') ?? 0), 1) : null,
        ]);

        $subject->setRelation('preview_courses', $matchedCourses->sortByDesc('created_at')->take(3));

        return $subject;
    }

    private function filterCourses(Collection $courses, array $identifiers): Collection
    {
        $needles = collect($identifiers)
            ->filter()
            ->map(fn($value) => Str::of($value)->lower()->replace(['-', '_'], ' ')->squish())
            ->filter(fn($value) => $value->isNotEmpty());

        if ($needles->isEmpty()) {
            return collect();
        }

        return $courses->filter(function (AdvancedCourse $course) use ($needles) {
            $fields = collect([
                $course->category,
                $course->programming_language,
                $course->framework,
                $course->level,
                $course->title,
                $course->description,
            ])->merge((array) ($course->skills ?? []));

            return $fields->contains(function ($field) use ($needles) {
                if (empty($field)) {
                    return false;
                }

                $value = Str::of($field)->lower()->replace(['-', '_'], ' ')->squish();

                foreach ($needles as $needle) {
                    if ($needle->isNotEmpty() && Str::contains($value, $needle)) {
                        return true;
                    }
                }

                return false;
            });
        })->values();
    }

    private function formatDurationMinutes(int $minutes): ?string
    {
        if ($minutes <= 0) {
            return null;
        }

        $hours = intdiv($minutes, 60);
        $remaining = $minutes % 60;

        if ($hours === 0) {
            return $remaining . ' د';
        }

        if ($remaining === 0) {
            return $hours . ' س';
        }

        return $hours . ' س ' . $remaining . ' د';
    }
}