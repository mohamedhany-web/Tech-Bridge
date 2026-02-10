<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\AdvancedCourse;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Group::with(['course', 'leader', 'members'])
            ->withCount('members');
        
        // فلترة حسب الكورس
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        
        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $groups = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $courses = AdvancedCourse::where('is_active', true)
            ->orderBy('title')
            ->get();
        
        $stats = [
            'total' => Group::count(),
            'active' => Group::where('status', 'active')->count(),
            'inactive' => Group::where('status', 'inactive')->count(),
            'archived' => Group::where('status', 'archived')->count(),
        ];
        
        return view('admin.groups.index', compact('groups', 'courses', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = AdvancedCourse::where('is_active', true)
            ->orderBy('title')
            ->get();
        
        $students = User::where('role', 'student')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        return view('admin.groups.create', compact('courses', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:advanced_courses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:users,id',
            'max_members' => 'required|integer|min:2|max:50',
            'status' => 'required|in:active,inactive,archived',
        ], [
            'course_id.required' => 'يجب اختيار الكورس',
            'course_id.exists' => 'الكورس المحدد غير موجود',
            'name.required' => 'اسم المجموعة مطلوب',
            'max_members.min' => 'الحد الأدنى للأعضاء هو 2',
            'max_members.max' => 'الحد الأقصى للأعضاء هو 50',
        ]);
        
        $group = Group::create($validated);
        
        // إضافة القائد كعضو إذا تم تحديده
        if ($validated['leader_id']) {
            \App\Models\GroupMember::create([
                'group_id' => $group->id,
                'user_id' => $validated['leader_id'],
                'role' => 'leader',
            ]);
        }
        
        return redirect()->route('admin.groups.show', $group)
            ->with('success', 'تم إنشاء المجموعة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $group->load(['course', 'leader', 'members']);
        
        // جلب الطلاب المسجلين في الكورس (غير أعضاء في المجموعة) كقائمة مستخدمين
        $enrollments = \App\Models\StudentCourseEnrollment::where('advanced_course_id', $group->course_id)
            ->where('status', 'active')
            ->with('user')
            ->get();
        
        $availableStudents = $enrollments->pluck('user')->filter()->unique('id')->values();
        
        return view('admin.groups.show', compact('group', 'availableStudents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        $courses = AdvancedCourse::where('is_active', true)
            ->orderBy('title')
            ->get();
        
        $students = User::where('role', 'student')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        
        $group->load(['leader', 'members']);
        
        return view('admin.groups.edit', compact('group', 'courses', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:advanced_courses,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:users,id',
            'max_members' => 'required|integer|min:2|max:50',
            'status' => 'required|in:active,inactive,archived',
        ]);
        
        $group->update($validated);
        
        // تحديث القائد
        if ($validated['leader_id']) {
            $existingLeader = \App\Models\GroupMember::where('group_id', $group->id)
                ->where('role', 'leader')
                ->first();
            
            if ($existingLeader) {
                $existingLeader->update(['user_id' => $validated['leader_id']]);
            } else {
                \App\Models\GroupMember::updateOrCreate(
                    ['group_id' => $group->id, 'user_id' => $validated['leader_id']],
                    ['role' => 'leader']
                );
            }
        }
        
        return redirect()->route('admin.groups.show', $group)
            ->with('success', 'تم تحديث المجموعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $group->delete();
        
        return redirect()->route('admin.groups.index')
            ->with('success', 'تم حذف المجموعة بنجاح');
    }

    /**
     * إضافة عضو للمجموعة
     */
    public function addMember(Request $request, Group $group)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|in:leader,member',
        ]);
        
        // التحقق من أن المجموعة ليست ممتلئة
        if ($group->isFull()) {
            return back()->with('error', 'المجموعة ممتلئة');
        }
        
        // التحقق من أن الطالب مسجل في الكورس
        $enrollment = \App\Models\StudentCourseEnrollment::where('advanced_course_id', $group->course_id)
            ->where('user_id', $validated['user_id'])
            ->where('status', 'active')
            ->first();
        
        if (!$enrollment) {
            return back()->with('error', 'الطالب غير مسجل في هذا الكورس');
        }
        
        \App\Models\GroupMember::updateOrCreate(
            [
                'group_id' => $group->id,
                'user_id' => $validated['user_id'],
            ],
            [
                'role' => $validated['role'] ?? 'member',
            ]
        );
        
        return back()->with('success', 'تم إضافة العضو بنجاح');
    }

    /**
     * إزالة عضو من المجموعة
     */
    public function removeMember(Request $request, Group $group, $member)
    {
        \App\Models\GroupMember::where('group_id', $group->id)
            ->where('user_id', $member)
            ->delete();
        
        // إذا كان العضو هو القائد، إزالة القائد من المجموعة
        if ($group->leader_id == $member) {
            $group->update(['leader_id' => null]);
        }
        
        return back()->with('success', 'تم إزالة العضو بنجاح');
    }
}
