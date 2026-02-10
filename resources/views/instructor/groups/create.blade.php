@extends('layouts.app')

@section('title', 'إنشاء مجموعة جديدة - Tech Bridge')
@section('header', 'إنشاء مجموعة جديدة')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="mb-6">
            <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('instructor.groups.index') }}" class="hover:text-sky-600">المجموعات</a>
                <span class="mx-2">/</span>
                <span>إنشاء مجموعة جديدة</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">إنشاء مجموعة جديدة</h1>
        </div>

        <form action="{{ route('instructor.groups.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- الكورس -->
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الكورس <span class="text-red-500">*</span>
                </label>
                <select name="course_id" id="course_id" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="">اختر الكورس</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- اسم المجموعة -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    اسم المجموعة <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white"
                       placeholder="مثال: مجموعة المشروع النهائي">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- الوصف -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الوصف
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white"
                          placeholder="وصف مختصر عن المجموعة وأهدافها">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- القائد -->
            <div>
                <label for="leader_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    قائد المجموعة
                </label>
                <select name="leader_id" id="leader_id"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="">بدون قائد (سيتم تعيينه لاحقاً)</option>
                    <!-- سيتم ملء هذا من خلال JavaScript بناءً على الكورس المختار -->
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">يمكنك اختيار قائد المجموعة من الطلاب المسجلين في الكورس</p>
                @error('leader_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- الحد الأقصى للأعضاء -->
            <div>
                <label for="max_members" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الحد الأقصى للأعضاء <span class="text-red-500">*</span>
                </label>
                <input type="number" name="max_members" id="max_members" value="{{ old('max_members', 10) }}" 
                       min="2" max="50" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                @error('max_members')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- الحالة -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    الحالة <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشطة</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>معطلة</option>
                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>مؤرشفة</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- الأزرار -->
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('instructor.groups.index') }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    إلغاء
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                    <i class="fas fa-save ml-2"></i>
                    إنشاء المجموعة
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // تحديث قائمة الطلاب عند اختيار الكورس
    document.getElementById('course_id').addEventListener('change', function() {
        const courseId = this.value;
        const leaderSelect = document.getElementById('leader_id');
        
        // مسح الخيارات الحالية (ما عدا الخيار الأول)
        while (leaderSelect.children.length > 1) {
            leaderSelect.removeChild(leaderSelect.lastChild);
        }
        
        if (courseId) {
            // جلب الطلاب المسجلين في الكورس
            fetch(`/api/courses/${courseId}/students`)
                .then(response => response.json())
                .then(data => {
                    if (data.students) {
                        data.students.forEach(student => {
                            const option = document.createElement('option');
                            option.value = student.id;
                            option.textContent = student.name;
                            leaderSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching students:', error);
                });
        }
    });
</script>
@endsection

