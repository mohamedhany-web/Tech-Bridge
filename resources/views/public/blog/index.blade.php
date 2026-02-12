@extends('layouts.public')

@section('title', 'المدونة - Tech Bridge')

@section('content')
<!-- Hero -->
<section class="page-hero">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="section-title text-3xl md:text-4xl mb-3">
            <span class="logo-text-gradient">المدونة</span>
        </h1>
        <p class="section-subtitle text-lg">
            أحدث المقالات والأخبار
        </p>
    </div>
</section>

<!-- Blog -->
<section class="py-16 sm:py-20 bg-slate-50/80 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($featuredPosts->count() > 0)
        <div class="mb-12">
            <h2 class="section-title mb-6">مقالات مميزة</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredPosts as $post)
                <a href="{{ route('public.blog.show', $post->slug) }}" class="block page-card card-hover rounded-2xl overflow-hidden">
                    <div class="relative h-48 bg-slate-100">
                        <div class="absolute inset-0 flex items-center justify-center"><i class="fas fa-image text-4xl text-slate-300"></i></div>
                        @if($post->featured_image)
                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="relative z-10 w-full h-48 object-cover" onerror="this.style.display='none'">
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2">{{ $post->title }}</h3>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}</p>
                        <div class="flex items-center text-xs text-slate-500 gap-4">
                            <span><i class="fas fa-user ml-1"></i> {{ $post->author->name ?? 'غير معروف' }}</span>
                            <span><i class="fas fa-calendar ml-1"></i> {{ $post->published_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <h2 class="section-title mb-6">{{ $featuredPosts->count() > 0 ? 'جميع المقالات' : 'المقالات' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($posts as $post)
            <a href="{{ route('public.blog.show', $post->slug) }}" class="block page-card card-hover rounded-2xl overflow-hidden">
                <div class="relative h-48 bg-slate-100">
                    <div class="absolute inset-0 flex items-center justify-center"><i class="fas fa-image text-4xl text-slate-300"></i></div>
                    @if($post->featured_image)
                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="relative z-10 w-full h-48 object-cover" onerror="this.style.display='none'">
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2">{{ $post->title }}</h3>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}</p>
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span><i class="fas fa-eye ml-1"></i> {{ $post->views_count }}</span>
                        <span>{{ $post->published_at->format('Y-m-d') }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-16">
                <div class="w-20 h-20 bg-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-newspaper text-slate-400 text-4xl"></i>
                </div>
                <p class="text-slate-600 text-lg">لا توجد مقالات متاحة حالياً</p>
            </div>
            @endforelse
        </div>

        <div class="flex justify-center">
            {{ $posts->links() }}
        </div>
    </div>
</section>
@endsection
