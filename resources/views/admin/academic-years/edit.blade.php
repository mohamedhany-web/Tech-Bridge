@extends('layouts.app')

@section('title', 'تعديل مسار التعلم')

@section('content')
<div class="px-4 py-8">
    <div class="max-w-6xl mx-auto space-y-8">
        <div class="bg-gradient-to-br from-sky-500 via-sky-600 to-indigo-700 dark:from-sky-600 dark:via-sky-700 dark:to-indigo-900 rounded-3xl p-6 sm:p-8 shadow-xl text-white relative overflow-hidden">
            <div class="absolute inset-y-0 left-0 w-40 bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 text-sm font-semibold">
                        <i class="fas fa-route"></i>
                        مسار التعلم
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold">{{ $academicYear->name }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15">
                            <i class="fas fa-barcode"></i>
                            {{ $academicYear->code }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $trackSummary['courses_count'] }} كورس مرتبط
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $academicYear->is_active ? 'bg-emerald-100/80 text-emerald-900' : 'bg-rose-100/80 text-rose-900' }}">
                            <i class="fas fa-circle"></i>
                            {{ $academicYear->is_active ? 'نشط' : 'موقوف' }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <form method="POST" action="{{ route('admin.academic-years.toggle-status', $academicYear) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white/15 hover:bg-white/25 transition px-4 py-2 text-sm font-semibold">
                            <i class="fas fa-power-off"></i>
                            {{ $academicYear->is_active ? 'إيقاف مؤقت' : 'تفعيل المسار' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.academic-years.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/40 px-5 py-2 text-sm font-semibold hover:bg-white/10 transition">
                        <i class="fas fa-arrow-right"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
            <div class="border-b border-gray-100 dark:border-gray-800 px-6 sm:px-8 py-5">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">بيانات المسار</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    حدّث بيانات المسار، اللون، الأيقونة وترتيب العرض. استخدم مربع الاختيار لتفعيل المسار أو إيقافه.
                </p>
            </div>
            <form action="{{ route('admin.academic-years.update', $academicYear) }}" method="POST" class="p-6 sm:p-8 space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">اسم المسار *</label>
                        <input type="text" name="name" value="{{ old('name', $academicYear->name) }}" required
                               class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">رمز المسار *</label>
                        <input type="text" name="code" value="{{ old('code', $academicYear->code) }}" required
                               class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                        @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">الوصف ومعلومات إضافية</label>
                            <button type="button" onclick="document.getElementById('path-description').value='';" class="text-xs text-sky-600 hover:text-sky-700 dark:text-sky-400 font-medium">مسح الوصف</button>
                        </div>
                        <textarea id="path-description" name="description" rows="4"
                                  class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition"
                                  placeholder="المهارات المستهدفة، الأهداف التعليمية، المتطلبات، إلخ.">{{ old('description', $academicYear->description) }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400">هذا النص هو <strong>معلومات المسار الإضافية</strong>. يمكنك تعديله أو مسحه من هنا في أي وقت.</p>
                        @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">الأيقونة</label>
                        <select name="icon"
                                class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                            @php
                                $icons = [
                                    'fas fa-calendar-alt' => '📅 تقويم',
                                    'fas fa-graduation-cap' => '🎓 تخرج',
                                    'fas fa-school' => '🏫 مدرسة',
                                    'fas fa-book' => '📚 كتاب',
                                    'fas fa-user-graduate' => '👨‍🎓 طالب',
                                    'fas fa-compass' => '🧭 مسار',
                                    'fas fa-lightbulb' => '💡 مهارات'
                                ];
                            @endphp
                            @foreach($icons as $iconValue => $label)
                                <option value="{{ $iconValue }}" {{ old('icon', $academicYear->icon) === $iconValue ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('icon') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">اللون</label>
                        <input type="color" name="color" value="{{ old('color', $academicYear->color ?? '#0ea5e9') }}"
                               class="w-full h-12 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500/40">
                        @error('color') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">ترتيب الظهور</label>
                        <input type="number" name="order" value="{{ old('order', $academicYear->order) }}" min="0"
                               class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-sky-500 focus:ring-4 focus:ring-sky-500/20 transition">
                        @error('order') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">حالة المسار</label>
                        <div class="flex items-center gap-2 px-4 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $academicYear->is_active) ? 'checked' : '' }}
                                   class="w-5 h-5 text-sky-600 border-gray-300 rounded focus:ring-sky-500">
                            <span class="text-sm text-gray-700 dark:text-gray-200">المسار متاح للطلاب</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle text-sky-600 ml-1"></i>
                        <strong>من أين أضفت المعلومات؟</strong> كل ما يظهر كـ «معلومات إضافية» للمسار موجود في حقل <strong>«الوصف ومعلومات إضافية»</strong> أعلاه. للتعديل: عدّل النص في نفس الحقل. للحذف: استخدم زر «مسح الوصف» أو امسح النص يدوياً ثم احفظ.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        آخر تعديل: {{ $academicYear->updated_at?->diffForHumans() ?? 'غير متوفر' }}
                    </span>
                    <div class="flex flex-col md:flex-row md:items-center gap-3">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 text-sm font-semibold shadow-lg shadow-sky-500/20 transition">
                            <i class="fas fa-save"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
                    <div class="border-b border-gray-100 dark:border-gray-800 px-6 sm:px-8 py-5">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">الكورسات في هذا المسار</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            اللغات، أطر العمل والمستويات في كارد المسار تُحسب تلقائياً من الكورسات المرتبطة بالمسار. إدارة الكورسات وربطها بالمسار من <a href="{{ route('admin.advanced-courses.index') }}" class="text-sky-600 dark:text-sky-400 hover:underline">صفحة الكورسات</a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
                    <div class="border-b border-gray-100 dark:border-gray-800 px-6 sm:px-8 py-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إحصائيات المسار</h3>
                    </div>
                    <div class="px-6 sm:px-8 py-5 space-y-4 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex items-center justify-between">
                            <span>عدد الكورسات</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $trackSummary['courses_count'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>متوسط المدة</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $trackSummary['avg_duration'] ?? 'غير محدد' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>التقييم المتوسط</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $trackSummary['avg_rating'] ?? 'غير متوفر' }}</span>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">اللغات</p>
                            <div class="flex flex-wrap gap-1">
                                @forelse($trackSummary['languages'] as $language)
                                    <span class="px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-xs">{{ $language }}</span>
                                @empty
                                    <span class="text-xs text-gray-400">-</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="space-y-2">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">أطر العمل</p>
                            <div class="flex flex-wrap gap-1">
                                @forelse($trackSummary['frameworks'] as $framework)
                                    <span class="px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-xs">{{ $framework }}</span>
                                @empty
                                    <span class="text-xs text-gray-400">-</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-rose-200/60 dark:border-rose-800 overflow-hidden">
                    <div class="border-b border-rose-100 dark:border-rose-800 px-6 sm:px-8 py-4">
                        <h3 class="text-lg font-semibold text-rose-600 dark:text-rose-300">منطقة خطرة</h3>
                    </div>
                    <div class="px-6 sm:px-8 py-5 space-y-4 text-sm text-gray-600 dark:text-gray-300">
                        <p>حذف المسار سيزيله من لوحة التحكم. الكورسات المرتبطة به ستبقى ويمكن ربطها بمسار آخر من صفحة الكورسات.</p>
                        <form action="{{ route('admin.academic-years.destroy', $academicYear) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المسار؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 rounded-2xl px-5 py-2 text-sm font-semibold bg-rose-600 text-white hover:bg-rose-700">
                                <i class="fas fa-trash"></i>
                                حذف المسار
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection