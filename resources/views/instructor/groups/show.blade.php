@extends('layouts.app')

@section('title', $group->name . ' - Tech Bridge')
@section('header', $group->name)

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('instructor.groups.index') }}" class="hover:text-sky-600">المجموعات</a>
                    <span class="mx-2">/</span>
                    <span>{{ $group->name }}</span>
                </nav>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $group->name }}</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($group->status == 'active') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                        @elseif($group->status == 'inactive') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                        @else bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-200
                        @endif">
                        @if($group->status == 'active') نشطة
                        @elseif($group->status == 'inactive') معطلة
                        @else مؤرشفة
                        @endif
                    </span>
                </div>
                <p class="text-gray-600 dark:text-gray-400">{{ $group->course->title ?? 'غير محدد' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('instructor.groups.edit', $group) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-edit ml-2"></i>
                    تعديل
                </a>
                <a href="{{ route('instructor.groups.index') }}" 
                   class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-arrow-right ml-2"></i>
                    العودة
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- معلومات المجموعة -->
        <div class="lg:col-span-2 space-y-6">
            <!-- الوصف -->
            @if($group->description)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">الوصف</h3>
                <p class="text-gray-600 dark:text-gray-400">{{ $group->description }}</p>
            </div>
            @endif

            <!-- الأعضاء -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الأعضاء</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $group->members->count() }} / {{ $group->max_members }}
                    </span>
                </div>

                @if($group->members->count() > 0)
                    <div class="space-y-3">
                        @foreach($group->members as $member)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-sky-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->email ?? 'غير محدد' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($member->pivot->role == 'leader')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-200">
                                    <i class="fas fa-crown ml-1"></i>
                                    قائد
                                </span>
                                @endif
                                <form action="{{ route('instructor.groups.remove-member', $group) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('هل أنت متأكد من إزالة هذا العضو؟')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="user_id" value="{{ $member->id }}">
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">لا يوجد أعضاء في هذه المجموعة</p>
                @endif
            </div>
        </div>

        <!-- الجانب الجانبي -->
        <div class="space-y-6">
            <!-- معلومات المجموعة -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">معلومات المجموعة</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">الكورس</div>
                        <div class="text-gray-900 dark:text-white font-medium">{{ $group->course->title ?? 'غير محدد' }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">الحد الأقصى للأعضاء</div>
                        <div class="text-gray-900 dark:text-white font-medium">{{ $group->max_members }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">عدد الأعضاء الحالي</div>
                        <div class="text-gray-900 dark:text-white font-medium">{{ $group->members->count() }}</div>
                    </div>
                    @if($group->leader)
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">قائد المجموعة</div>
                        <div class="text-gray-900 dark:text-white font-medium">{{ $group->leader->name }}</div>
                    </div>
                    @endif
                    <div>
                        <div class="text-gray-500 dark:text-gray-400 mb-1">تاريخ الإنشاء</div>
                        <div class="text-gray-900 dark:text-white font-medium">{{ $group->created_at->format('Y/m/d') }}</div>
                    </div>
                </div>
            </div>

            <!-- إضافة عضو -->
            @if(!$group->isFull())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">إضافة عضو</h3>
                <form action="{{ route('instructor.groups.add-member', $group) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <select name="user_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                            <option value="">اختر الطالب</option>
                            @foreach($enrollments as $enrollment)
                                @if(!$group->members->contains($enrollment->user_id))
                                <option value="{{ $enrollment->user->id }}">{{ $enrollment->user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="role"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                            <option value="member">عضو</option>
                            <option value="leader">قائد</option>
                        </select>
                    </div>
                    <button type="submit" 
                            class="w-full bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

