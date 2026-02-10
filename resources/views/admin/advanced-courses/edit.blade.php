@extends('layouts.app')

@section('title', 'تعديل الكورس البرمجي')
@section('header', 'تعديل الكورس')

@section('content')
<div class="px-4 py-8" x-data="courseBuilder({
        tracks: @json($trackOptions ?? []),
        selectedTrack: '{{ old('academic_year_id', $advancedCourse->academic_year_id ?? '') }}',
        selectedSkills: @json(old('skills', is_array($advancedCourse->skills) ? $advancedCourse->skills : (is_string($advancedCourse->skills) ? json_decode($advancedCourse->skills, true) : [])),
    })" x-init="init()">
    <div class="max-w-6xl mx-auto space-y-8">
        <div class="bg-gradient-to-br from-indigo-500 via-sky-500 to-emerald-500 dark:from-indigo-600 dark:via-sky-700 dark:to-emerald-700 rounded-3xl p-6 sm:p-8 shadow-xl text-white relative overflow-hidden">
            <div class="absolute inset-y-0 left-0 w-40 bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 text-sm font-semibold">
                        <i class="fas fa-edit"></i>
                        تعديل الكورس
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold">تعديل بيانات الكورس البرمجي</h1>
                    <p class="text-sm text-white/80 max-w-2xl">
                        قم بتحديث معلومات الكورس والمحتوى التدريبي والمهارات المستهدفة.
                    </p>
                </div>
                <a href="{{ route('admin.advanced-courses.index') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-white/40 px-5 py-2 text-sm font-semibold hover:bg-white/10 transition">
                    <i class="fas fa-arrow-right"></i>
                    العودة للكورسات
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl shadow-sm mb-6">
                <i class="fas fa-check-circle ml-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm mb-6">
                <i class="fas fa-exclamation-circle ml-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm mb-6">
                <p class="font-semibold mb-2"><i class="fas fa-exclamation-triangle ml-2"></i>يرجى تصحيح الأخطاء التالية:</p>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.advanced-courses.update', $advancedCourse) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
                        <div class="border-b border-gray-100 dark:border-gray-800 px-6 sm:px-8 py-5">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">المعلومات الأساسية</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">املأ تفاصيل الكورس واختر المسار التعليمي المناسب.</p>
                        </div>
                        <div class="p-6 sm:p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2 space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">عنوان الكورس *</label>
                                    <input type="text" name="title" value="{{ old('title', $advancedCourse->title) }}" required
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                           placeholder="مثال: أساسيات تطوير واجهات الويب">
                                    @error('title') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">المسار التعليمي *</label>
                                    <select name="academic_year_id" x-model="formTrack" required
                                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                        <option value="">اختر المسار</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ old('academic_year_id', $advancedCourse->academic_year_id) == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('academic_year_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">المدرّس المسؤول</label>
                                    <select name="instructor_id"
                                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                        <option value="">بدون مدرّس محدد</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ old('instructor_id', $advancedCourse->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                                {{ $instructor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instructor_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">مستوى الكورس</label>
                                    <select name="level"
                                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                        <option value="beginner" {{ old('level', $advancedCourse->level) == 'beginner' ? 'selected' : '' }}>مبتدئ</option>
                                        <option value="intermediate" {{ old('level', $advancedCourse->level) == 'intermediate' ? 'selected' : '' }}>متوسط</option>
                                        <option value="advanced" {{ old('level', $advancedCourse->level) == 'advanced' ? 'selected' : '' }}>متقدم</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">لغة البرمجة</label>
                                    <input list="programming_languages" name="programming_language" value="{{ old('programming_language', $advancedCourse->programming_language) }}"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                           placeholder="مثال: JavaScript">
                                    <datalist id="programming_languages">
                                        @foreach($languages as $language)
                                            <option value="{{ $language }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">الإطار / التقنية</label>
                                    <input list="frameworks" name="framework" value="{{ old('framework', $advancedCourse->framework) }}"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                           placeholder="مثال: React">
                                    <datalist id="frameworks">
                                        @foreach($frameworks as $framework)
                                            <option value="{{ $framework }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">التصنيف</label>
                                    <input list="categories" name="category" value="{{ old('category', $advancedCourse->category) }}"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                           placeholder="مثال: تطوير الويب">
                                    <datalist id="categories">
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">مدة الكورس (ساعات)</label>
                                    <input type="number" name="duration_hours" value="{{ old('duration_hours', $advancedCourse->duration_hours ?? 0) }}" min="0"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                           placeholder="عدد الساعات">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">مدة إضافية (دقائق)</label>
                                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $advancedCourse->duration_minutes ?? 0) }}" min="0" max="59"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                           placeholder="دقائق إضافية">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">سعر الكورس (جنيه)</label>
                                    <input type="number" name="price" value="{{ old('price', $advancedCourse->price ?? 0) }}" min="0" step="0.01"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                           placeholder="0 للمواد المجانية">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">وصف الكورس</label>
                                <textarea name="description" rows="4"
                                          class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                          placeholder="اشرح محتوى الكورس وقيمته للطلاب.">{{ old('description', $advancedCourse->description) }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">أهداف الكورس</label>
                                <textarea name="objectives" rows="3"
                                          class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                          placeholder="الأهداف التعليمية للكورس">{{ old('objectives', $advancedCourse->objectives) }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">تاريخ البداية</label>
                                    <input type="date" name="starts_at" value="{{ old('starts_at', $advancedCourse->starts_at ? $advancedCourse->starts_at->format('Y-m-d') : '') }}"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">تاريخ النهاية</label>
                                    <input type="date" name="ends_at" value="{{ old('ends_at', $advancedCourse->ends_at ? $advancedCourse->ends_at->format('Y-m-d') : '') }}"
                                           class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
                        <div class="border-b border-gray-100 dark:border-gray-800 px-6 sm:px-8 py-5">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">المهارات والمخرجات</h2>
                        </div>
                        <div class="p-6 sm:p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">المهارات الرئيسية <span class="text-gray-500 font-normal">(اختياري)</span></label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                                    اختر مهارات موجودة أو أضف مهارات جديدة لدعم الفريق أثناء تصميم مسار الكورس.
                                </p>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @php
                                        $allSkills = \App\Models\AdvancedCourse::whereNotNull('skills')
                                            ->pluck('skills')
                                            ->flatMap(function($json) {
                                                $decoded = json_decode($json, true);
                                                return is_array($decoded) ? $decoded : [];
                                            })
                                            ->unique()
                                            ->values();
                                    @endphp
                                    @foreach($allSkills as $skill)
                                        <button type="button" class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800/70 text-slate-600 dark:text-slate-200 border border-slate-200 dark:border-slate-700 hover:border-indigo-400 transition"
                                                @click="addSkill('{{ $skill }}')">
                                            {{ $skill }}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="flex items-center gap-2">
                                    <input id="customSkill" type="text" class="flex-1 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition" placeholder="اكتب مهارة جديدة">
                                    <button type="button" class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm font-semibold transition"
                                            @click="addSkill(document.getElementById('customSkill').value); document.getElementById('customSkill').value='';">
                                        <i class="fas fa-plus"></i>
                                        إضافة
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-2 mt-3" x-show="selectedSkills.length">
                                    <template x-for="(skill, index) in selectedSkills" :key="skill">
                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 text-xs font-semibold">
                                            <span x-text="skill"></span>
                                            <button type="button" class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-800" @click="removeSkill(index)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="skills[]" :value="skill">
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">المتطلبات المسبقة</label>
                                    <textarea name="prerequisites" rows="3"
                                              class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                              placeholder="ما الذي يجب أن يعرفه الطالب قبل بدء الكورس؟">{{ old('prerequisites', $advancedCourse->prerequisites) }}</textarea>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">ما الذي سيتعلمه الطالب؟</label>
                                    <textarea name="what_you_learn" rows="3"
                                              class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                              placeholder="المخرجات التعليمية والمهارات المكتسبة">{{ old('what_you_learn', $advancedCourse->what_you_learn) }}</textarea>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">متطلبات إضافية</label>
                                <textarea name="requirements" rows="3"
                                          class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition"
                                          placeholder="أدوات أو برامج يحتاجها الطلاب خلال الدراسة.">{{ old('requirements', $advancedCourse->requirements) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
                        <div class="border-b border-gray-100 dark:border-gray-800 px-6 sm:px-8 py-5">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">إعدادات العرض</h2>
                        </div>
                        <div class="p-6 sm:p-8 space-y-4 text-sm text-gray-700 dark:text-gray-300">
                            <label class="flex items-center justify-between">
                                <span class="font-medium">تفعيل الكورس فوراً</span>
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $advancedCourse->is_active) ? 'checked' : '' }} class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                            </label>
                            <label class="flex items-center justify-between">
                                <span class="font-medium">وضع الكورس ضمن الكورسات المميزة</span>
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $advancedCourse->is_featured) ? 'checked' : '' }} class="w-5 h-5 text-amber-500 border-gray-300 rounded focus:ring-amber-500">
                            </label>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">لغة المحتوى</label>
                                <select name="language"
                                        class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-3 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                    <option value="ar" {{ old('language', $advancedCourse->language ?? 'ar') == 'ar' ? 'selected' : '' }}>العربية</option>
                                    <option value="en" {{ old('language', $advancedCourse->language) == 'en' ? 'selected' : '' }}>الإنجليزية</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">رفع صورة للكورس</label>
                                @if($advancedCourse->thumbnail)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $advancedCourse->thumbnail) }}" alt="صورة الكورس الحالية" 
                                             class="w-full h-32 object-cover rounded-xl border border-gray-200 dark:border-gray-700">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">الصورة الحالية</p>
                                    </div>
                                @endif
                                <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp"
                                       class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/70 px-4 py-2 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition">
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG أو JPG بحد أقصى 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
                        <div class="px-6 sm:px-8 py-5 border-b border-gray-100 dark:border-gray-800">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">ملخص سريع</h2>
                        </div>
                        <div class="p-6 sm:p-8 space-y-3 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center justify-between">
                                <span>المسار التعليمي</span>
                                <span class="font-semibold" x-text="summaryTrack"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>عدد المهارات (اختياري)</span>
                                <span class="font-semibold" x-text="selectedSkills.length"></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>الحالة</span>
                                <span class="font-semibold">{{ old('is_active', $advancedCourse->is_active) ? 'نشط' : 'مسودة' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100/60 dark:border-gray-800 overflow-hidden">
                        <div class="p-6 sm:p-8 space-y-3">
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 text-sm font-semibold shadow-lg shadow-indigo-500/20 transition">
                                <i class="fas fa-save"></i>
                                حفظ التعديلات
                            </button>
                            <a href="{{ route('admin.advanced-courses.show', $advancedCourse) }}" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-green-600 hover:bg-green-700 text-white px-6 py-3 text-sm font-semibold transition">
                                <i class="fas fa-eye"></i>
                                عرض الكورس
                            </a>
                            <a href="{{ route('admin.advanced-courses.index') }}" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-200 dark:border-gray-700 px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                إلغاء
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function courseBuilder({tracks, selectedTrack, selectedSkills}) {
    return {
        tracks,
        formTrack: selectedTrack ? String(selectedTrack) : '',
        selectedSkills: selectedSkills || [],
        get summaryTrack() {
            const track = this.tracks.find(t => String(t.id) === String(this.formTrack));
            return track ? track.name : 'غير محدد';
        },
        init() {
            if (!this.tracks || this.tracks.length === 0) return;
        },
        addSkill(value) {
            const skill = (value || '').trim();
            if (!skill) return;
            if (!this.selectedSkills.includes(skill)) {
                this.selectedSkills.push(skill);
            }
        },
        removeSkill(index) {
            this.selectedSkills.splice(index, 1);
        }
    }
}
</script>
@endpush
@endsection
