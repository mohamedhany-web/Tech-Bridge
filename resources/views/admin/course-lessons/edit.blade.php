@extends('layouts.app')

@section('title', 'تعديل الدرس')
@section('header', 'تعديل الدرس: ' . $lesson->title)

@section('content')
<div class="space-y-6">
    <!-- الهيدر والعودة -->
    <div class="flex items-center justify-between">
        <div>
            <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">لوحة التحكم</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.advanced-courses.index') }}" class="hover:text-primary-600">الكورسات</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.courses.lessons.index', $course) }}" class="hover:text-primary-600">دروس {{ $course->title }}</a>
                <span class="mx-2">/</span>
                <span>تعديل {{ $lesson->title }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.courses.lessons.show', [$course, $lesson]) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-eye ml-2"></i>
                عرض الدرس
            </a>
            <a href="{{ route('admin.courses.lessons.index', $course) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-right ml-2"></i>
                العودة
            </a>
        </div>
    </div>

    <!-- معلومات الكورس -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center ml-4">
                <i class="fas fa-graduation-cap text-primary-600 dark:text-primary-400"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $course->title }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $course->academicYear->name ?? 'غير محدد' }}@if($course->academicSubject) - {{ $course->academicSubject->name }}@endif
                </p>
            </div>
        </div>
    </div>

    <!-- نموذج تعديل الدرس -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">تعديل بيانات الدرس</h4>
        </div>

        <form action="{{ route('admin.courses.lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- عنوان الدرس -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        عنوان الدرس <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $lesson->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                           placeholder="أدخل عنوان الدرس"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- نوع الدرس -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        نوع الدرس <span class="text-red-500">*</span>
                    </label>
                    <select name="type" 
                            id="type" 
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                            required 
                            onchange="toggleTypeFields()">
                        <option value="">اختر نوع الدرس</option>
                        <option value="video" {{ old('type', $lesson->type) == 'video' ? 'selected' : '' }}>فيديو</option>
                        <option value="document" {{ old('type', $lesson->type) == 'document' ? 'selected' : '' }}>مستند</option>
                        <option value="quiz" {{ old('type', $lesson->type) == 'quiz' ? 'selected' : '' }}>كويز</option>
                        <option value="assignment" {{ old('type', $lesson->type) == 'assignment' ? 'selected' : '' }}>واجب</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- مدة الدرس -->
                <div>
                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        مدة الدرس (بالدقائق)
                    </label>
                    <input type="number" 
                           name="duration_minutes" 
                           id="duration_minutes" 
                           value="{{ old('duration_minutes', $lesson->duration_minutes) }}"
                           min="1"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                           placeholder="مثال: 30">
                    @error('duration_minutes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ترتيب الدرس -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        ترتيب الدرس
                    </label>
                    <input type="number" 
                           name="order" 
                           id="order" 
                           value="{{ old('order', $lesson->order) }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- الخيارات -->
                <div class="flex items-center space-x-6 space-x-reverse">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_free" 
                               value="1"
                               {{ old('is_free', $lesson->is_free) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <span class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">درس مجاني</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $lesson->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <span class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">درس نشط</span>
                    </label>
                </div>
            </div>

            <!-- وصف الدرس -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    وصف الدرس
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                          placeholder="وصف مختصر عن محتوى الدرس">{{ old('description', $lesson->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- محتوى الدرس -->
            <div class="mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    محتوى الدرس
                </label>
                <textarea name="content" 
                          id="content" 
                          rows="6"
                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                          placeholder="محتوى الدرس التفصيلي">{{ old('content', $lesson->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- رابط الفيديو (للفيديوهات) -->
            <div id="video_url_field" class="mt-6" style="display: none;">
                <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    رابط الفيديو
                </label>
                <input type="url" 
                       name="video_url" 
                       id="video_url" 
                       value="{{ old('video_url', $lesson->video_url) }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                       placeholder="https://www.youtube.com/watch?v=... أو https://vimeo.com/... أو أي رابط فيديو">
                
                @if($lesson->video_url)
                    <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">معاينة الفيديو الحالي:</span>
                            @php
                                $videoSource = \App\Helpers\VideoHelper::getVideoSource($lesson->video_url);
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($videoSource == 'youtube') bg-red-100 text-red-800
                                @elseif($videoSource == 'vimeo') bg-blue-100 text-blue-800
                                @elseif($videoSource == 'google_drive') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @if($videoSource == 'youtube') YouTube
                                @elseif($videoSource == 'vimeo') Vimeo
                                @elseif($videoSource == 'google_drive') Google Drive
                                @elseif($videoSource == 'direct') ملف مباشر
                                @else مصدر آخر
                                @endif
                            </span>
                        </div>
                        <div class="bg-black rounded-lg overflow-hidden" style="aspect-ratio: 16/9; max-height: 200px;">
                            {!! \App\Helpers\VideoHelper::generateEmbedHtml($lesson->video_url, '100%', '100%') !!}
                        </div>
                    </div>
                @endif
                
                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    <p class="mb-1"><strong>المصادر المدعومة:</strong></p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>YouTube: https://www.youtube.com/watch?v=VIDEO_ID</li>
                        <li>Vimeo: https://vimeo.com/VIDEO_ID</li>
                        <li>Google Drive: رابط مشاركة الفيديو</li>
                        <li>ملفات فيديو مباشرة: .mp4, .avi, .mov</li>
                    </ul>
                </div>
                @error('video_url')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>



            <!-- المرفقات الحالية -->
            @if($lesson->attachments)
                @php
                    $attachments = json_decode($lesson->attachments, true);
                @endphp
                @if($attachments && count($attachments) > 0)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المرفقات الحالية</label>
                        <div class="space-y-2">
                            @foreach($attachments as $attachment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <i class="fas fa-file text-primary-600 dark:text-primary-400"></i>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $attachment['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($attachment['size'] / 1024, 2) }} KB</div>
                                        </div>
                                    </div>
                                    <a href="{{ $attachment['path'] }}" 
                                       target="_blank"
                                       class="text-primary-600 hover:text-primary-700 font-medium">
                                        <i class="fas fa-download ml-1"></i>
                                        تحميل
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- رفع مرفقات جديدة -->
            <div class="mt-6">
                <label for="attachments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    إضافة مرفقات جديدة (اختياري)
                </label>
                <input type="file" 
                       name="attachments[]" 
                       id="attachments" 
                       multiple
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">يمكن رفع عدة ملفات. الحد الأقصى لكل ملف: 10 ميجابايت. سيتم إضافتها للمرفقات الحالية.</p>
                @error('attachments.*')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- أزرار الحفظ -->
            <div class="flex items-center justify-end space-x-4 space-x-reverse mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.courses.lessons.show', [$course, $lesson]) }}" 
                   class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                    إلغاء
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-save ml-2"></i>
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleTypeFields() {
    const type = document.getElementById('type').value;
    const videoUrlField = document.getElementById('video_url_field');
    
    // إخفاء جميع الحقول أولاً
    videoUrlField.style.display = 'none';
    
    // إظهار حقل رابط الفيديو للفيديوهات فقط
    if (type === 'video') {
        videoUrlField.style.display = 'block';
    }
}

// تشغيل الدالة عند تحميل الصفحة للحفاظ على القيم القديمة
document.addEventListener('DOMContentLoaded', function() {
    toggleTypeFields();
});
</script>
@endpush
@endsection
