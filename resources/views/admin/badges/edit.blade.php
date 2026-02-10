@extends('layouts.app')

@section('title', 'تعديل الشارة')
@section('header', 'تعديل الشارة')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">تعديل الشارة</h1>
        
        <form action="{{ route('admin.badges.update', $badge) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الاسم *</label>
                    <input type="text" name="name" required value="{{ old('name', $badge->name) }}" 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                </div>

                @php
                    $formCategory = match($badge->type ?? 'skill') {
                        'milestone' => 'dedication',
                        'special', 'seasonal' => 'other',
                        default => 'skill',
                    };
                @endphp
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الفئة *</label>
                    <select name="category" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="excellence" {{ old('category', $formCategory) == 'excellence' ? 'selected' : '' }}>تفوق</option>
                        <option value="dedication" {{ old('category', $formCategory) == 'dedication' ? 'selected' : '' }}>تفاني</option>
                        <option value="leadership" {{ old('category', $formCategory) == 'leadership' ? 'selected' : '' }}>قيادة</option>
                        <option value="community" {{ old('category', $formCategory) == 'community' ? 'selected' : '' }}>مجتمع</option>
                        <option value="skill" {{ old('category', $formCategory) == 'skill' ? 'selected' : '' }}>مهارة</option>
                        <option value="other" {{ old('category', $formCategory) == 'other' ? 'selected' : '' }}>أخرى</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الأيقونة</label>
                    <input type="text" name="icon" value="{{ old('icon', $badge->icon ?? 'fas fa-award') }}" 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white"
                           placeholder="fas fa-award">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اللون</label>
                    <input type="text" name="color" value="{{ old('color', $badge->color ?? 'sky') }}" 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white"
                           placeholder="sky, blue, green, etc.">
                    <p class="mt-1 text-xs text-gray-500">أو hex code مثل #3B82F6</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الوصف</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">{{ old('description', $badge->description) }}</textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $badge->is_active ?? true) ? 'checked' : '' }} 
                       class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-sky-500">
                <label class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">نشط</label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                    تحديث الشارة
                </button>
                <a href="{{ route('admin.badges.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

