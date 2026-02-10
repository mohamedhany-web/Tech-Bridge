@extends('layouts.app')

@section('title', 'مسارات التعلم')
@section('header', 'مسارات التعلم')

@section('content')
<div class="space-y-8">
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-xl overflow-hidden">
        <div class="px-4 py-6 sm:px-8 sm:py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300 text-sm font-semibold">
                        <i class="fas fa-route"></i>
                        إدارة مسارات التعلم في Tech Bridge
                    </span>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white leading-tight">
                        أنشئ مسارات تعليمية مترابطة تجمع المهارات، الأطر، واللغات المطلوبة لسوق العمل
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        كل مسار يمثل رحلة تعلم كاملة تضم مجموعات مهارية وكورسات تطبيقية. من هنا يمكنك التخطيط للمحتوى، مراقبة جاهزية المسارات، وتنسيق الفرق المسؤولة عن إنتاج الدروس.
                    </p>
                </div>
                <a href="{{ route('admin.academic-years.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-sky-600 text-white hover:bg-sky-700 transition-colors text-sm font-semibold shadow-lg shadow-sky-600/20 w-full sm:w-auto">
                    <i class="fas fa-plus"></i>
                    إنشاء مسار تعلم جديد
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-4 mt-8">
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">إجمالي المسارات</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $summary['total_tracks'] }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">مسارات نشطة</p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $summary['active_tracks'] }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">كورسات مرتبطة</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $summary['courses'] }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">اللغات المغطاة</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ ($summary['languages'] ?? collect())->count() }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">أطر العمل</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ ($summary['frameworks'] ?? collect())->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($tracks->count() > 0)
        <div class="space-y-3 mb-6">
            <div class="bg-sky-50 dark:bg-sky-900/20 border border-sky-200 dark:border-sky-800 rounded-2xl p-4">
                <p class="text-sm text-sky-800 dark:text-sky-200">
                    <i class="fas fa-info-circle ml-1"></i>
                    <strong>الوصف النصي:</strong> من حقل «الوصف ومعلومات إضافية» في صفحة إنشاء/تعديل المسار. للتعديل أو الحذف: «تعديل المسار» → عدّل الحقل أو «مسح الوصف».
                </p>
            </div>
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-4">
                <p class="text-sm text-amber-800 dark:text-amber-200">
                    <i class="fas fa-tags ml-1"></i>
                    <strong>اللغات، أطر العمل، المستويات، وكورسات حديثة في المسار:</strong> تظهر تلقائياً من الكورسات المرتبطة بالمسار. <strong>لتعديلها:</strong> عدّل بيانات كل كورس (المسار، اللغة، الإطار، المستوى) من صفحة الكورسات.
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            @foreach($tracks as $track)
                @php
                    $metrics = $track->track_metrics ?? [];
                    $languages = collect($metrics['languages'] ?? []);
                    $frameworks = collect($metrics['frameworks'] ?? []);
                    $levels = collect($metrics['levels'] ?? []);
                    $previewCourses = $track->preview_courses ?? collect();
                @endphp
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 text-white shadow-lg">
                                    <i class="fas fa-compass text-lg"></i>
                                </span>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $track->name }}</h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ $track->code }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 max-w-xl">
                                {{ $track->description ? Str::limit($track->description, 160) : 'مسار تعلم متكامل يضم مجموعات مهارية متعددة مع كورسات تطبيقية متدرجة المستوى.' }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300 text-xs font-semibold">
                                    <i class="fas fa-graduation-cap text-[10px]"></i>
                                    {{ $metrics['courses_count'] ?? 0 }} كورس متخصص
                                </span>
                                @if(!empty($metrics['avg_duration']))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 text-xs font-semibold">
                                        <i class="fas fa-clock text-[10px]"></i>
                                        مدة متوسطة {{ $metrics['avg_duration'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col sm:items-end sm:text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $track->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                                {{ $track->is_active ? 'نشط' : 'مغلق' }}
                            </span>
                        </div>
                    </div>

                    <div class="px-4 py-5 sm:px-6 space-y-4">
                        @if($languages->isNotEmpty() || $frameworks->isNotEmpty() || $levels->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-xl p-4">
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">اللغات</p>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($languages as $language)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                                {{ $language }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">-</span>
                                        @endforelse
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">أطر العمل</p>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($frameworks as $framework)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                                {{ $framework }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">-</span>
                                        @endforelse
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">المستويات</p>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($levels as $level)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200 capitalize">
                                                {{ __($level) }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">-</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <i class="fas fa-info-circle ml-0.5"></i>
                                مصدرها: الكورسات المرتبطة بالمسار. للتعديل: «إدارة المجموعات» أو تعديل بيانات الكورسات (لغة/إطار/مستوى).
                            </p>
                        @endif

                        @if($previewCourses->isNotEmpty())
                            <div class="space-y-2">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">كورسات حديثة في المسار</p>
                                <div class="space-y-2">
                                    @foreach($previewCourses as $course)
                                        <div class="flex items-center justify-between gap-3 text-sm text-gray-600 dark:text-gray-300">
                                            <div class="flex items-center gap-2 truncate">
                                                <span class="w-2 h-2 rounded-full bg-gradient-to-br from-sky-500 to-indigo-600"></span>
                                                <span class="truncate">{{ $course->title }}</span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                                @if($course->programming_language)
                                                    <span><i class="fas fa-code ml-1"></i>{{ $course->programming_language }}</span>
                                                @endif
                                                @if($course->level)
                                                    <span><i class="fas fa-signal ml-1"></i>{{ $course->level }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- أزرار الإجراءات -->
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('admin.academic-years.edit', $track) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 text-xs font-semibold">
                                    <i class="fas fa-pen"></i>
                                    تعديل المسار
                                </a>
                                <form method="POST" action="{{ route('admin.academic-years.toggle-status', $track) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 text-xs font-semibold">
                                        <i class="fas fa-power-off"></i>
                                        {{ $track->is_active ? 'إيقاف مؤقت' : 'تفعيل المسار' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.academic-years.destroy', $track) }}" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المسار التعليمي؟ سيتم حذف جميع البيانات المرتبطة به. هذا الإجراء لا يمكن التراجع عنه!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/40 dark:text-red-300 text-xs font-semibold">
                                        <i class="fas fa-trash"></i>
                                        حذف المسار
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-xl p-12 text-center space-y-4">
            <div class="flex items-center justify-center">
                <span class="w-16 h-16 rounded-2xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300 flex items-center justify-center text-2xl">
                    <i class="fas fa-route"></i>
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">لا توجد مسارات تعلم بعد</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                قم بإنشاء أول مسار تعلم لتجميع الكورسات داخل رحلة تعليمية واضحة. ابدأ بتحديد الهدف التقني، مجموعات المهارات، والمهارات المطلوبة.
            </p>
            <a href="{{ route('admin.academic-years.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 text-white hover:bg-sky-700 transition-colors">
                <i class="fas fa-plus"></i>
                إنشاء مسار جديد
            </a>
        </div>
    @endif
</div>
@endsection