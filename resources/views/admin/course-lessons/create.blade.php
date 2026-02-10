@extends('layouts.app')

@section('title', 'إضافة درس برمجي جديد')
@section('header', 'إضافة درس جديد للكورس: ' . $course->title)

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
                <span>إضافة درس جديد</span>
            </nav>
        </div>
        <a href="{{ route('admin.courses.lessons.index', $course) }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة
        </a>
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

    <!-- نموذج إضافة الدرس -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">بيانات الدرس الجديد</h4>
        </div>

        <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- عنوان الدرس -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        عنوان الدرس <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}"
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
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>فيديو</option>
                        <option value="document" {{ old('type') == 'document' ? 'selected' : '' }}>مستند</option>
                        <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>كويز</option>
                        <option value="assignment" {{ old('type') == 'assignment' ? 'selected' : '' }}>واجب</option>
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
                           value="{{ old('duration_minutes') }}"
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
                           value="{{ old('order') }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                           placeholder="سيتم تحديده تلقائياً إذا تُرك فارغاً">
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
                               {{ old('is_free') ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <span class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">درس مجاني</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
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
                          placeholder="وصف مختصر عن محتوى الدرس">{{ old('description') }}</textarea>
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
                          placeholder="محتوى الدرس التفصيلي">{{ old('content') }}</textarea>
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
                       value="{{ old('video_url') }}"
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                       placeholder="https://www.youtube.com/watch?v=... أو https://vimeo.com/... أو أي رابط فيديو"
                       onblur="previewVideo()">
                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    <p class="mb-1"><strong>المصادر المدعومة:</strong></p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>YouTube: https://www.youtube.com/watch?v=VIDEO_ID</li>
                        <li>Vimeo: https://vimeo.com/VIDEO_ID</li>
                        <li>Google Drive: رابط مشاركة الفيديو</li>
                        <li>ملفات فيديو مباشرة: .mp4, .avi, .mov</li>
                    </ul>
                </div>
                
                <!-- معاينة الفيديو -->
                <div id="video_preview" class="mt-3" style="display: none;">
                    <div class="bg-black rounded-lg overflow-hidden" style="aspect-ratio: 16/9; max-height: 200px;">
                        <div id="video_embed_container"></div>
                    </div>
                </div>
                
                @error('video_url')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>



            <!-- رفع المرفقات -->
            <div class="mt-6">
                <label for="attachments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    المرفقات (اختياري)
                </label>
                <input type="file" 
                       name="attachments[]" 
                       id="attachments" 
                       multiple
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">يمكن رفع عدة ملفات. الحد الأقصى لكل ملف: 10 ميجابايت</p>
                @error('attachments.*')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- أزرار الحفظ -->
            <div class="flex items-center justify-end space-x-4 space-x-reverse mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.courses.lessons.index', $course) }}" 
                   class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                    إلغاء
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-save ml-2"></i>
                    حفظ الدرس
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

function previewVideo() {
    const url = document.getElementById('video_url').value;
    const previewDiv = document.getElementById('video_preview');
    const embedContainer = document.getElementById('video_embed_container');
    
    if (!url) {
        previewDiv.style.display = 'none';
        return;
    }
    
    // تحويل الرابط إلى embed
    let embedHtml = generateVideoEmbed(url);
    
    if (embedHtml.includes('غير مدعوم')) {
        embedContainer.innerHTML = `
            <div class="bg-red-100 text-red-700 p-4 rounded-lg h-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                رابط الفيديو غير صحيح أو غير مدعوم
            </div>
        `;
    } else {
        embedContainer.innerHTML = embedHtml;
    }
    
    previewDiv.style.display = 'block';
}

function generateVideoEmbed(url) {
    // YouTube
    const youtubeMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
    if (youtubeMatch) {
        const videoId = youtubeMatch[1];
        return `<iframe src="https://www.youtube.com/embed/${videoId}?rel=0&modestbranding=1&showinfo=0" width="100%" height="100%" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>`;
    }
    
    // Vimeo
    const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
    if (vimeoMatch) {
        const videoId = vimeoMatch[1];
        return `<iframe src="https://player.vimeo.com/video/${videoId}?title=0&byline=0&portrait=0" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>`;
    }
    
    // Google Drive
    const driveMatch = url.match(/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/);
    if (driveMatch) {
        const fileId = driveMatch[1];
        return `<iframe src="https://drive.google.com/file/d/${fileId}/preview" width="100%" height="100%" frameborder="0" allow="autoplay" class="w-full h-full"></iframe>`;
    }
    
    // ملف فيديو مباشر
    if (url.match(/\.(mp4|webm|ogg|avi|mov)(\?.*)?$/i)) {
        return `<video controls width="100%" height="100%" class="w-full h-full"><source src="${url}" type="video/mp4">متصفحك لا يدعم تشغيل الفيديو.</video>`;
    }
    
    // مصدر غير مدعوم
    return `<div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg h-full flex items-center justify-center">نوع الفيديو غير مدعوم حالياً</div>`;
}
</script>
@endpush
@endsection
