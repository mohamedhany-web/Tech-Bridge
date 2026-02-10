@extends('layouts.app')

@section('title', 'إرسال إشعار جديد')
@section('header', 'إرسال إشعار جديد')

@section('content')
<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <nav class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-sky-600 hover:text-sky-700 dark:text-sky-300">لوحة التحكم</a>
                    <span>/</span>
                    <a href="{{ route('admin.notifications.index') }}" class="text-sky-600 hover:text-sky-700 dark:text-sky-300">الإشعارات</a>
                    <span>/</span>
                    <span class="text-slate-500 dark:text-slate-400">إرسال جديد</span>
                </nav>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">إنشاء إشعار جديد</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">صغ رسالة مخصصة واختر الجمهور المستهدف مع معاينة مباشرة قبل الإرسال.</p>
            </div>
            <a href="{{ route('admin.notifications.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200 dark:hover:border-sky-500 dark:hover:text-sky-300">
                <i class="fas fa-arrow-right"></i>
                العودة إلى الإشعارات
            </a>
        </div>
    </section>

    <form action="{{ route('admin.notifications.store') }}" method="POST" class="space-y-10">
        @csrf
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 space-y-8">
                <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
                    <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">محتوى الإشعار</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">اكتب النص الأساسي وحدد نوع الإشعار وأولويته.</p>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div>
                            <label for="title" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">عنوان الإشعار <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" placeholder="مثال: تذكير بالامتحان النهائي" />
                            @error('title')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="message" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">نص الإشعار <span class="text-rose-500">*</span></label>
                            <textarea name="message" id="message" rows="5" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm leading-7 text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" placeholder="اكتب تفاصيل الإشعار والنقاط المهمة...">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="type" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">نوع الإشعار <span class="text-rose-500">*</span></label>
                                <select name="type" id="type" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="">اختر نوع الإشعار</option>
                                    @foreach ($notificationTypes as $key => $type)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('type')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="priority" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الأولوية <span class="text-rose-500">*</span></label>
                                <select name="priority" id="priority" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="">اختر الأولوية</option>
                                    @foreach ($priorities as $key => $priority)
                                        <option value="{{ $key }}" {{ old('priority', 'normal') == $key ? 'selected' : '' }}>{{ $priority }}</option>
                                    @endforeach
                                </select>
                                @error('priority')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="action_url" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">رابط الإجراء (اختياري)</label>
                                <input type="url" name="action_url" id="action_url" value="{{ old('action_url') }}" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" placeholder="https://example.com/action" />
                            </div>
                            <div>
                                <label for="action_text" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">نص زر الإجراء</label>
                                <input type="text" name="action_text" id="action_text" value="{{ old('action_text') }}" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" placeholder="مثال: عرض التفاصيل" />
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
                    <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">تحديد الجمهور</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">اختر من سيستلم الإشعار واحصل على عدد المستهدفين المتوقع.</p>
                    </div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div>
                            <label for="target_type" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">المستهدفون <span class="text-rose-500">*</span></label>
                            <select name="target_type" id="target_type" required onchange="updateTargetOptions()" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                <option value="">اختر المستهدفين</option>
                                @foreach ($targetTypes as $key => $type)
                                    <option value="{{ $key }}" {{ old('target_type') == $key ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('target_type')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                        </div>
                        <div id="target-options" style="display: none;" class="space-y-4">
                            <div id="course-selection" style="display: none;">
                                <label for="course_target" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">اختر المسار / الكورس</label>
                                <select id="course_target" name="target_id_course" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="">اختر الكورس</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}@if($course->academicSubject) - {{ $course->academicSubject->name }}@endif</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="year-selection" style="display: none;">
                                <label for="year_target" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">اختر المسار التعليمي</label>
                                <select id="year_target" name="target_id_year" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="">اختر المسار</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="subject-selection" style="display: none;">
                                <label for="subject_target" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">اختر مجموعة المهارات</label>
                                <select id="subject_target" name="target_id_subject" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="">اختر المجموعة</option>
                                    @foreach ($academicSubjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }} - {{ $subject->academicYear->name ?? 'غير محدد' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="student-selection" style="display: none;">
                                <label for="student_target" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">اختر طالباً محدداً</label>
                                <select id="student_target" name="target_id_student" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="">اختر الطالب</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="target-count-display" style="display: none;" class="rounded-2xl border border-sky-200 bg-sky-50/80 p-4 text-sm text-sky-600 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-200">
                            <span class="inline-flex items-center gap-2 font-semibold">
                                <i class="fas fa-users"></i>
                                سيتم الإرسال إلى
                                <span id="target-count" class="text-sky-700 dark:text-sky-100">0</span>
                                مستلم
                            </span>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
                    <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">معاينة فورية</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">تظهر المعاينة تلقائياً عند كتابة المحتوى.</p>
                    </div>
                    <div class="p-5 sm:p-8">
                        <div id="notification-preview" class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300 min-h-[150px]">
                            <div class="text-center text-slate-400 dark:text-slate-500">
                                <i class="fas fa-bell text-2xl mb-3"></i>
                                <p>اكتب عنوان الإشعار ومحتواه لعرض المعاينة هنا.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="space-y-8">
                <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
                    <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">إعدادات إضافية</h3>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">تحكم في موعد انتهاء الإشعار وخيارات الإرسال.</p>
                    </div>
                    <div class="p-5 sm:p-8 space-y-5">
                        <div>
                            <label for="expires_at" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">انتهاء الصلاحية</label>
                            <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" />
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-300">اترك الحقل فارغاً إذا كان الإشعار دائماً.</p>
                        </div>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="send_immediately" value="1" {{ old('send_immediately', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                            <span class="text-sm text-slate-600 dark:text-slate-300">إرسال فوري عند الحفظ</span>
                        </label>
                    </div>
                </section>

                <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
                    <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">نصائح سريعة</h3>
                    </div>
                    <div class="p-5 sm:p-8 space-y-5 text-sm text-slate-600 dark:text-slate-300">
                        <div class="rounded-2xl border border-sky-200 bg-sky-50/70 p-4 dark:border-sky-500/30 dark:bg-sky-500/10">
                            <p class="font-semibold text-sky-700 dark:text-sky-200 mb-2"><i class="fas fa-lightbulb ml-2"></i>كتابة فعالة</p>
                            <ul class="list-disc pr-5 space-y-1">
                                <li>اجعل العنوان مختصراً وواضحاً.</li>
                                <li>استخدم لغة ودودة ومباشرة.</li>
                                <li>حدد الأولوية بعناية لجذب الانتباه الصحيح.</li>
                                <li>أضف رابطاً واضحاً إذا كان هناك إجراء مطلوب.</li>
                            </ul>
                        </div>
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50/70 p-4 dark:border-emerald-500/30 dark:bg-emerald-500/10">
                            <p class="font-semibold text-emerald-700 dark:text-emerald-200 mb-2"><i class="fas fa-bullseye ml-2"></i>استهداف دقيق</p>
                            <ul class="list-disc pr-5 space-y-1">
                                <li>جميع الطلاب: يصل لكل الطلاب النشطين.</li>
                                <li>كورس محدد: يستهدف مساراً تعليمياً بعينه.</li>
                                <li>مسار أو مجموعة مهارات: يركز على فئة محددة.</li>
                                <li>طالب محدد: رسائل شخصية تحتاج متابعة خاصة.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
                    <div class="p-5 sm:p-8 space-y-4">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-5 py-3 text-sm font-semibold text-white shadow-lg hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-paper-plane"></i>
                            إرسال الإشعار الآن
                        </button>
                        <a href="{{ route('admin.notifications.index') }}" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800/70">
                            إلغاء والعودة
                        </a>
                    </div>
                </section>
            </div>
        </div>

        <input type="hidden" name="target_id" id="target_id">
    </form>
</div>

@push('scripts')
<script>
function updateTargetOptions() {
    const targetType = document.getElementById('target_type').value;
    const targetOptions = document.getElementById('target-options');
    const targetCountDisplay = document.getElementById('target-count-display');

    document.getElementById('course-selection').style.display = 'none';
    document.getElementById('year-selection').style.display = 'none';
    document.getElementById('subject-selection').style.display = 'none';
    document.getElementById('student-selection').style.display = 'none';

    if (targetType) {
        targetOptions.style.display = 'block';
        targetCountDisplay.style.display = 'block';

        switch (targetType) {
            case 'course_students':
                document.getElementById('course-selection').style.display = 'block';
                break;
            case 'year_students':
                document.getElementById('year-selection').style.display = 'block';
                break;
            case 'subject_students':
                document.getElementById('subject-selection').style.display = 'block';
                break;
            case 'individual':
                document.getElementById('student-selection').style.display = 'block';
                break;
        }

        updateTargetCount();
    } else {
        targetOptions.style.display = 'none';
        targetCountDisplay.style.display = 'none';
    }
}

function updateTargetCount() {
    const targetType = document.getElementById('target_type').value;
    let targetId = null;

    switch (targetType) {
        case 'course_students':
            targetId = document.getElementById('course_target').value;
            document.getElementById('target_id').value = targetId;
            break;
        case 'year_students':
            targetId = document.getElementById('year_target').value;
            document.getElementById('target_id').value = targetId;
            break;
        case 'subject_students':
            targetId = document.getElementById('subject_target').value;
            document.getElementById('target_id').value = targetId;
            break;
        case 'individual':
            targetId = document.getElementById('student_target').value;
            document.getElementById('target_id').value = targetId;
            break;
        case 'all_students':
            document.getElementById('target_id').value = '';
            break;
    }

    if (targetType) {
        fetch(`{{ route('admin.notifications.target-count') }}?target_type=${targetType}&target_id=${targetId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('target-count').textContent = data.count ?? 0;
            })
            .catch(() => {
                document.getElementById('target-count').textContent = '0';
            });
    }
}

function updatePreview() {
    const title = document.getElementById('title').value;
    const message = document.getElementById('message').value;
    const type = document.getElementById('type').value;
    const priority = document.getElementById('priority').value;
    const actionUrl = document.getElementById('action_url').value;
    const actionText = document.getElementById('action_text').value;

    const preview = document.getElementById('notification-preview');

    if (!title && !message) {
        preview.innerHTML = `
            <div class="text-center text-slate-400 dark:text-slate-500">
                <i class="fas fa-bell text-2xl mb-3"></i>
                <p>اكتب محتوى الإشعار لرؤية المعاينة</p>
            </div>
        `;
        return;
    }

    const typeIcons = {
        'general': 'fas fa-info-circle',
        'course': 'fas fa-graduation-cap',
        'exam': 'fas fa-clipboard-check',
        'assignment': 'fas fa-tasks',
        'grade': 'fas fa-star',
        'announcement': 'fas fa-bullhorn',
        'reminder': 'fas fa-bell',
        'warning': 'fas fa-exclamation-triangle',
        'system': 'fas fa-cog',
    };

    const typeColors = {
        'general': 'sky',
        'course': 'emerald',
        'exam': 'violet',
        'assignment': 'amber',
        'grade': 'yellow',
        'announcement': 'rose',
        'reminder': 'sky',
        'warning': 'rose',
        'system': 'slate',
    };

    const priorityColors = {
        'low': ['bg-slate-100', 'text-slate-600'],
        'high': ['bg-amber-100', 'text-amber-700'],
        'urgent': ['bg-rose-100', 'text-rose-700'],
    };

    const typeColor = typeColors[type] || 'sky';
    const icon = typeIcons[type] || 'fas fa-info-circle';
    const priorityBadge = priority !== 'normal' && priorityColors[priority]
        ? `<span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ${priorityColors[priority][0]} ${priorityColors[priority][1]}"><span class="h-2 w-2 rounded-full bg-current"></span>${{ 'low': 'منخفضة', 'high': 'عالية', 'urgent': 'عاجلة' }[priority]}</span>`
        : '';

    const actionButton = actionUrl && actionText
        ? `<div class="mt-4"><a href="${actionUrl}" class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2 text-xs font-semibold text-white">${actionText}<i class="fas fa-arrow-left text-[10px]"></i></a></div>`
        : '';

    preview.innerHTML = `
        <div class="flex items-start gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-${typeColor}-100 text-${typeColor}-600">
                <i class="${icon}"></i>
            </span>
            <div class="flex-1 space-y-2">
                <div class="flex flex-wrap items-center gap-2">
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">${title || 'عنوان الإشعار'}</h4>
                    ${priorityBadge}
                </div>
                <p class="text-sm leading-6 text-slate-600 dark:text-slate-300">${message || 'نص الإشعار سيظهر هنا...'}</p>
                ${actionButton}
                <span class="block text-xs text-slate-400">منذ لحظات</span>
            </div>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', () => {
    ['title', 'message', 'type', 'priority', 'action_url', 'action_text'].forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.addEventListener('input', updatePreview);
            field.addEventListener('change', updatePreview);
        }
    });

    ['course_target', 'year_target', 'subject_target', 'student_target'].forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.addEventListener('change', updateTargetCount);
        }
    });

    updatePreview();
    updateTargetOptions();
});
</script>
@endpush
@endsection
