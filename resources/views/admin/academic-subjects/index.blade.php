@extends('layouts.app')

@section('title', 'مجموعات المهارات')
@section('header', 'مجموعات المهارات')

@section('content')
<div class="space-y-8">
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-xl overflow-hidden">
        <div class="px-4 py-6 sm:px-8 sm:py-8">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">
                <div class="space-y-4 max-w-3xl">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-100 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300 text-sm font-semibold">
                        <i class="fas fa-layer-group"></i>
                        إدارة مجموعات المهارات ضمن مسارات التعلم
                    </span>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white leading-tight">
                        نسّق المهارات الأساسية لكل مسار تعلّم، وضمن ارتباطها بالكورسات العملية
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        استخدم مجموعات المهارات لتجميع الكورسات في وحدات متخصصة تركّز على لغات وأطر وتقنيات معينة. يمكنك متابعة جاهزية كل مجموعة، توزيع المحتوى على الفرق، وضمان تسلسل واضح للمتعلم.
                    </p>
                    <div class="mt-4 inline-flex items-start gap-2 rounded-xl bg-blue-50 px-4 py-2.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/15 dark:text-blue-300">
                        <i class="fas fa-info-circle mt-0.5"></i>
                        <div>
                            <strong>ما هي مجموعة المهارات؟</strong><br>
                            مجموعة المهارات هي تصنيف أكاديمي يضم كورسات متخصصة في مجال معين (مثل: Frontend Development، Backend Development، Data Science). كل مجموعة تنتمي لمسار تعلم محدد وتحتوي على كورسات مرتبطة بهذه المهارات.
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3 gap-3 w-full xl:w-auto">
                    @if($currentTrack)
                        <a href="{{ route('admin.academic-years.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 text-sm font-semibold w-full sm:w-auto">
                            <i class="fas fa-arrow-right"></i>
                            الرجوع لمسار {{ $currentTrack->name }}
                        </a>
                    @endif
                    <a href="{{ route('admin.academic-subjects.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 text-white hover:bg-sky-700 transition-colors text-sm font-semibold shadow-lg shadow-sky-600/20 w-full sm:w-auto">
                        <i class="fas fa-plus"></i>
                        إضافة مجموعة مهارية
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mt-8">
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">إجمالي المجموعات</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $summary['total_clusters'] }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">المجموعات النشطة</p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $summary['active_clusters'] }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">كورسات مرتبطة</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $summary['courses'] }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">اللغات</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ ($summary['languages'] ?? collect())->count() }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-5">
                    <p class="text-sm text-slate-500 dark:text-slate-400">أطر العمل</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ ($summary['frameworks'] ?? collect())->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($clusters->count() > 0)
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 2xl:grid-cols-3">
            @foreach($clusters as $cluster)
                @php
                    $metrics = $cluster->cluster_metrics ?? [];
                    $languages = collect($metrics['languages'] ?? []);
                    $frameworks = collect($metrics['frameworks'] ?? []);
                    $levels = collect($metrics['levels'] ?? []);
                    $previewCourses = $cluster->preview_courses ?? collect();
                    $track = $cluster->academicYear;
                @endphp
                <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                    <div class="px-5 py-6 flex flex-col gap-5 flex-1">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl text-white shadow-lg"
                                          style="background: linear-gradient(135deg, {{ $cluster->color ?? '#0ea5e9' }} 0%, {{ $cluster->color ?? '#0ea5e9' }} 100%);">
                                        <i class="{{ $cluster->icon ?? 'fas fa-layer-group' }} text-lg"></i>
                                    </span>
                                    <div class="space-y-1">
                                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $cluster->name }}</h2>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ $cluster->code }}</p>
                                        @if($track)
                                            <p class="text-xs text-sky-600 dark:text-sky-400 font-semibold">
                                                جزء من مسار {{ $track->name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $cluster->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300' }}">
                                    {{ $cluster->is_active ? 'نشطة' : 'معلقة' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $cluster->description ? Str::limit($cluster->description, 200) : 'مجموعة مهارات تركز على إتقان أدوات ولغات محددة مع كورسات تطبيقية متدرجة.' }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200 text-xs font-semibold">
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

                        @if($languages->isNotEmpty() || $frameworks->isNotEmpty() || $levels->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 rounded-xl p-4">
                                <div class="space-y-2">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">اللغات الأساسية</p>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($languages as $language)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                                {{ $language }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">لم يتم تحديد لغات</span>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">أطر العمل</p>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($frameworks as $framework)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                                {{ $framework }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">لم يتم تحديد أطر</span>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">المستويات المستهدفة</p>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($levels as $level)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200 capitalize">
                                                {{ __($level) }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">لم يتم تحديد مستويات</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">كورسات حديثة ضمن المجموعة</p>
                            @if($previewCourses->isNotEmpty())
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
                            @else
                                <p class="text-xs text-gray-400">لم يتم ربط كورسات بعد بهذه المجموعة.</p>
                            @endif
                        </div>
                    </div>
                    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/60">
                        <div class="flex flex-wrap items-center justify-end gap-2">
                            <a href="{{ route('admin.academic-subjects.edit', $cluster) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 text-xs font-semibold">
                                <i class="fas fa-pen"></i>
                                تعديل المجموعة
                            </a>
                            <a href="{{ route('admin.advanced-courses.index', ['cluster' => $cluster->id]) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-200 dark:bg-sky-900/40 dark:text-sky-300 text-xs font-semibold">
                                <i class="fas fa-graduation-cap"></i>
                                إدارة الكورسات
                            </a>
                            <form method="POST" action="{{ route('admin.academic-subjects.toggle-status', $cluster) }}" class="inline-flex">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 text-xs font-semibold">
                                    <i class="fas fa-power-off"></i>
                                    {{ $cluster->is_active ? 'إيقاف مؤقت' : 'تفعيل المجموعة' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.academic-subjects.destroy', $cluster) }}" class="inline-flex" onsubmit="return confirm('هل أنت متأكد من حذف هذه المجموعة؟ سيتم فقدان أي ربط يدوي للكورسات مع هذا الاسم.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-rose-100 text-rose-700 hover:bg-rose-200 dark:bg-rose-900/40 dark:text-rose-300 dark:hover:bg-rose-800/60 text-xs font-semibold">
                                    <i class="fas fa-trash"></i>
                                    حذف المجموعة
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl shadow-xl p-12 text-center space-y-4">
            <div class="flex items-center justify-center">
                <span class="w-16 h-16 rounded-2xl bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-300 flex items-center justify-center text-2xl">
                    <i class="fas fa-layer-group"></i>
                </span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">لا توجد مجموعات مهارية بعد</h3>
            <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto">
                أنشئ أول مجموعة مهارات لتقسيم المسار التعليمي إلى وحدات متخصصة. اختر اسمًا، رمزًا، وحدد المهارات المستهدفة.
            </p>
            <a href="{{ route('admin.academic-subjects.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 text-white hover:bg-sky-700 transition-colors">
                <i class="fas fa-plus"></i>
                إضافة مجموعة مهارية
            </a>
        </div>
    @endif
</div>
@endsection
 