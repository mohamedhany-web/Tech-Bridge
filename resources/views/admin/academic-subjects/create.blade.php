@extends('layouts.app')

@section('content')
<div class="px-4 py-8">
    <div class="max-w-5xl mx-auto space-y-8">
        <div class="bg-gradient-to-br from-emerald-500 via-sky-500 to-indigo-600 dark:from-emerald-600 dark:via-sky-700 dark:to-indigo-800 rounded-3xl p-6 sm:p-8 shadow-xl text-white relative overflow-hidden">
            <div class="absolute inset-y-0 left-0 w-40 bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 text-sm font-semibold">
                        <i class="fas fa-layer-group"></i>
                        إضافة مجموعة مهارية
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold">إنشاء مجموعة مهارات جديدة</h1>
                    <p class="text-sm text-white/80 max-w-2xl">
                        قم بإنشاء مجموعة مهارية داخل مسار تعلّم محدد، وحدد اسم المجموعة، رمزها، لونها، والأيقونة الخاصة بها.
                        يمكنك لاحقًا ربط الكورسات والمهارات لهذه المجموعة لإكمال رحلة التعلم.
                    </p>
                </div>
                <a href="{{ route('admin.academic-subjects.index', ['track' => $selectedTrack]) }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/40 px-5 py-2 text-sm font-semibold hover:bg-white/10 transition">
                    <i class="fas fa-arrow-right"></i>
                    العودة للمجموعات
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden" x-data="{
            selectedTrack: '{{ old('academic_year_id', $selectedTrack) }}',
            selectedSkills: {{ json_encode(old('skills', [])) }},
            addSkill(value) {
                if (!value) return;
                if (!this.selectedSkills.includes(value)) {
                    this.selectedSkills.push(value);
                }
            },
            removeSkill(index) {
                this.selectedSkills.splice(index, 1);
            }
        }">
            <div class="border-b border-gray-100 dark:border-gray-800 px-6 sm:px-8 py-5">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">بيانات مجموعة المهارات</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    حدّد المسار، الاسم، الرمز، اللون والأيقونة. يمكنك إضافة روابط مهارات ليستفيد منها الفريق عند تخطيط المحتوى.
                </p>
            </div>
            <form method="POST" action="{{ route('admin.academic-subjects.store') }}" class="p-6 sm:p-8 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">المسار التعليمي *</label>
                        <select name="academic_year_id" x-model="selectedTrack" required
                                class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition">
                            <option value="">اختر المسار</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                        @error('academic_year_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">رمز المجموعة *</label>
                        <input type="text" name="code" value="{{ old('code') }}" required
                               class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition"
                               placeholder="مثال: FE-FOUND أو AI-JUNIOR">
                        @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">اسم المجموعة *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition"
                               placeholder="مثال: أساسيات الواجهة الأمامية">
                        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">الأيقونة</label>
                        <select name="icon"
                                class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition">
                            @php
                                $icons = [
                                    'fas fa-layer-group' => '🌐 مجموعة مهارات',
                                    'fas fa-laptop-code' => '💻 برمجة',
                                    'fas fa-paint-brush' => '🎨 تصميم',
                                    'fas fa-robot' => '🤖 ذكاء اصطناعي',
                                    'fas fa-database' => '🗄️ قواعد بيانات',
                                    'fas fa-chart-line' => '📊 تحليل بيانات',
                                    'fas fa-network-wired' => '🔗 بنية تحتية',
                                ];
                            @endphp
                            @foreach($icons as $value => $label)
                                <option value="{{ $value }}" {{ old('icon') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('icon') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">اللون</label>
                        <input type="color" name="color" value="{{ old('color', '#0ea5e9') }}"
                               class="w-full h-12 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                        @error('color') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">ترتيب العرض</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                               class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition"
                               placeholder="0">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">0 = تظهر أولاً ضمن المسار</p>
                        @error('order') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">الوصف</label>
                        <textarea name="description" rows="4"
                                  class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition"
                                  placeholder="ڤصف مختصر يوضح الهدف من المجموعة والمهارات التي تغطيها.">{{ old('description') }}</textarea>
                        @error('description') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">المهارات الرئيسية</label>
                    <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700 rounded-2xl p-4 space-y-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            اختر مهارات موجودة أو أضف مهارات جديدة لدعم الفريق أثناء تخطيط الكورسات المرتبطة.
                        </p>
                        <div class="flex flex-wrap items-center gap-2">
                            @foreach($skills as $skill)
                                <button type="button" @click="addSkill('{{ $skill }}')" class="px-3 py-1 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-200 hover:border-emerald-400 transition">
                                    {{ $skill }}
                                </button>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" id="customSkill" class="flex-1 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 transition" placeholder="أضف مهارة جديدة">
                            <button type="button" @click="
                                const value = document.getElementById('customSkill').value.trim();
                                addSkill(value);
                                document.getElementById('customSkill').value = '';
                            " class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-semibold transition">
                                <i class="fas fa-plus"></i>
                                إضافة مهارة
                            </button>
                        </div>
                        <div class="flex flex-wrap items-center gap-2" x-show="selectedSkills.length">
                            <template x-for="(skill, index) in selectedSkills" :key="skill">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 text-xs font-semibold">
                                    <span x-text="skill"></span>
                                    <button type="button" @click="removeSkill(index)" class="text-emerald-600 dark:text-emerald-300 hover:text-emerald-800">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="hidden" name="skills[]" :value="skill">
                                </span>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">لغات برمجة مرتبطة</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($languages as $language)
                                    <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800/60 text-xs text-slate-600 dark:text-slate-300">{{ $language }}</span>
                                @endforeach
                                @if($languages->isEmpty())
                                    <span class="text-xs text-gray-400">لم يتم ربط كورسات بعد.</span>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">أطر العمل المحتملة</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($frameworks as $framework)
                                    <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800/60 text-xs text-slate-600 dark:text-slate-300">{{ $framework }}</span>
                                @endforeach
                                @if($frameworks->isEmpty())
                                    <span class="text-xs text-gray-400">لا توجد بيانات أطر عمل حالياً.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <div>
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">المجموعة نشطة</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            يمكن للطلاب رؤية المحتوى المرتبط بالمجموعة عندما تكون نشطة.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        تأكد من اكتمال البيانات قبل الحفظ. يمكنك تعديل المجموعة لاحقاً.
                    </span>
                    <div class="flex flex-col md:flex-row md:items-center gap-3">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 text-sm font-semibold shadow-lg shadow-emerald-500/20 transition">
                            <i class="fas fa-save"></i>
                            حفظ المجموعة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection