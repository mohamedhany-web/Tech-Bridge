@extends('layouts.app')

@section('title', ($medium ?? $media)->title . ' - Tech Bridge')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ ($medium ?? $media)->title }}</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ ($medium ?? $media)->type === 'image' ? 'صورة' : 'فيديو' }}</p>
                </div>
                <div class="flex space-x-3 space-x-reverse">
                    <a href="{{ route('admin.media.edit', $medium ?? $media) }}" 
                       class="inline-flex items-center px-4 py-2 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        تعديل
                    </a>
                    <a href="{{ route('admin.media.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-right mr-2"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="space-y-6">
                @php
                    $mediaItem = $medium ?? $media;
                @endphp
                
                @if($mediaItem->type === 'image' && $mediaItem->file_path)
                <div>
                    <img src="{{ asset($mediaItem->file_path) }}" alt="{{ $mediaItem->title }}" class="w-full rounded-lg">
                </div>
                @elseif($mediaItem->type === 'video' && $mediaItem->file_path)
                <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-8 text-center">
                    <i class="fas fa-video text-6xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">فيديو: {{ $mediaItem->file_path }}</p>
                </div>
                @endif

                @if($mediaItem->description)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">الوصف</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $mediaItem->description }}</p>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">النوع</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $mediaItem->type === 'image' ? 'صورة' : 'فيديو' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">الفئة</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $mediaItem->category ?? 'غير محدد' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">مميز</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $mediaItem->is_featured ? 'نعم' : 'لا' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">الحالة</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $mediaItem->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $mediaItem->is_active ? 'نشط' : 'غير نشط' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تاريخ الإنشاء</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $mediaItem->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تاريخ آخر تعديل</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $mediaItem->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

