@extends('layouts.app')

@section('title', 'إدارة الإشعارات')
@section('header', 'إدارة الإشعارات')

@section('content')
@php
    $summaryCards = [
        [
            'label' => 'إجمالي الإشعارات',
            'value' => number_format($stats['total']),
            'icon' => 'fas fa-bell',
            'color' => 'text-sky-500 bg-sky-100/70 dark:text-sky-300 dark:bg-sky-500/10',
        ],
        [
            'label' => 'غير المقروء',
            'value' => number_format($stats['unread']),
            'icon' => 'fas fa-envelope-open-text',
            'color' => 'text-amber-500 bg-amber-100/70 dark:text-amber-300 dark:bg-amber-500/10',
        ],
        [
            'label' => 'مقروء',
            'value' => number_format($stats['total'] - $stats['unread']),
            'icon' => 'fas fa-check-circle',
            'color' => 'text-emerald-500 bg-emerald-100/70 dark:text-emerald-300 dark:bg-emerald-500/10',
        ],
        [
            'label' => 'أُرسلت اليوم',
            'value' => number_format($stats['today']),
            'icon' => 'fas fa-calendar-day',
            'color' => 'text-purple-500 bg-purple-100/70 dark:text-purple-300 dark:bg-purple-500/10',
        ],
    ];
@endphp

<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">مركز الإشعارات</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-2">إرسال التنبيهات ومتابعة حالة القراءة لجميع المستلمين.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.notifications.statistics') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200 dark:hover:border-sky-500 dark:hover:text-sky-300">
                    <i class="fas fa-chart-line"></i>
                    الإحصائيات</a>
                <a href="{{ route('admin.notifications.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                    <i class="fas fa-paper-plane"></i>
                    إرسال إشعار جديد</a>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 p-5 sm:p-8">
            @foreach ($summaryCards as $card)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                        <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ $card['value'] }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $card['color'] }}">
                        <i class="{{ $card['icon'] }} text-xl"></i>
                    </span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white">البحث المتقدم</h3>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">تصفية الإشعارات حسب النوع والحالة أو البحث داخل العناوين.</p>
        </div>
        <div class="p-5 sm:p-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">البحث</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="عنوان الإشعار أو محتواه" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" />
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">نوع الإشعار</label>
                    <select name="type" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                        <option value="">جميع الأنواع</option>
                        @foreach ($notificationTypes as $key => $type)
                            <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الحالة</label>
                    <select name="status" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                        <option value="">جميع الحالات</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>مقروءة</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>غير مقروءة</option>
                    </select>
                </div>
                <div class="flex items-end gap-3">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                        <i class="fas fa-filter"></i>
                        تطبيق الفلاتر
                    </button>
                    <a href="{{ route('admin.notifications.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800/70">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">الإشعارات المرسلة</h3>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">{{ $notifications->total() }} إشعار تم إرساله حتى الآن.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" onclick="markAllAsRead()" class="inline-flex items-center gap-2 rounded-2xl border border-emerald-200 px-4 py-2 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-500 hover:text-white dark:border-emerald-500/30 dark:text-emerald-300">
                    <i class="fas fa-check-double"></i>
                    تحديد الكل كمقروء</button>
                <button type="button" onclick="cleanupOld()" class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-500 hover:text-white dark:border-rose-500/30 dark:text-rose-300">
                    <i class="fas fa-trash-alt"></i>
                    حذف القديمة</button>
            </div>
        </div>

        @if ($notifications->count() > 0)
            <div class="p-5 sm:p-8 space-y-4">
                @foreach ($notifications as $notification)
                    @php
                        $typeColor = match($notification->type_color) {
                            'blue' => 'bg-sky-100/80 text-sky-600 dark:bg-sky-500/15 dark:text-sky-300',
                            'green' => 'bg-emerald-100/80 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-200',
                            'yellow' => 'bg-amber-100/80 text-amber-600 dark:bg-amber-500/15 dark:text-amber-200',
                            'red' => 'bg-rose-100/80 text-rose-600 dark:bg-rose-500/15 dark:text-rose-200',
                            'purple' => 'bg-purple-100/80 text-purple-600 dark:bg-purple-500/15 dark:text-purple-200',
                            'orange' => 'bg-orange-100/80 text-orange-600 dark:bg-orange-500/15 dark:text-orange-200',
                            default => 'bg-slate-100/80 text-slate-600 dark:bg-slate-800/80 dark:text-slate-200',
                        };
                        $priorityClasses = match($notification->priority_color) {
                            'red' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200',
                            'yellow' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200',
                            'blue' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/15 dark:text-sky-200',
                            default => 'bg-slate-100 text-slate-700 dark:bg-slate-500/15 dark:text-slate-200',
                        };
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white/80 dark:border-slate-800 dark:bg-slate-900/70 p-5 transition hover:border-sky-300 hover:shadow-lg {{ $notification->is_read ? 'opacity-80' : '' }}">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex flex-1 items-start gap-4">
                                <span class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $typeColor }}">
                                    <i class="{{ $notification->type_icon }} text-lg"></i>
                                </span>
                                <div class="space-y-3">
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                                        <h4 class="text-base font-semibold text-slate-900 dark:text-white">{{ $notification->title }}</h4>
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $priorityClasses }}">
                                            <span class="h-2 w-2 rounded-full bg-current"></span>
                                            {{ \App\Models\Notification::getPriorities()[$notification->priority] ?? $notification->priority }}
                                        </span>
                                        @unless ($notification->is_read)
                                            <span class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700 dark:bg-sky-500/15 dark:text-sky-200">
                                                <span class="h-2 w-2 rounded-full bg-current"></span>
                                                جديد
                                            </span>
                                        @endunless
                                    </div>
                                    <p class="text-sm leading-relaxed text-slate-600 dark:text-slate-300">{{ Str::limit($notification->message, 200) }}</p>
                                    <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-300">
                                        <span class="inline-flex items-center gap-1"><i class="fas fa-user"></i>{{ $notification->user->name }}</span>
                                        <span class="inline-flex items-center gap-1"><i class="fas fa-tag"></i>{{ \App\Models\Notification::getTypes()[$notification->type] ?? $notification->type }}</span>
                                        <span class="inline-flex items-center gap-1"><i class="fas fa-clock"></i>{{ $notification->created_at->diffForHumans() }}</span>
                                        @if ($notification->target_type !== 'individual')
                                            <span class="inline-flex items-center gap-1"><i class="fas fa-users"></i>{{ \App\Models\Notification::getTargetTypes()[$notification->target_type] ?? $notification->target_type }}</span>
                                        @endif
                                        @if ($notification->action_url)
                                            <span class="inline-flex items-center gap-1 text-sky-600 dark:text-sky-300"><i class="fas fa-link"></i>{{ $notification->action_text ?: 'رابط مرتبط' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-end lg:self-start">
                                <a href="{{ route('admin.notifications.show', $notification) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-300 dark:hover:border-sky-500 dark:hover:text-sky-300" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الإشعار؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-rose-200 text-rose-600 transition hover:bg-rose-500 hover:text-white dark:border-rose-500/30 dark:text-rose-300" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($notifications->hasPages())
                    <div class="border-t border-slate-200 pt-6 dark:border-slate-800">
                        {{ $notifications->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="p-12 text-center text-slate-500 dark:text-slate-300">
                <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <i class="fas fa-bell-slash text-3xl"></i>
                </div>
                لا توجد إشعارات مطابقة للبحث الحالي.
            </div>
        @endif
    </section>

    <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">إرسال سريع</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">أرسل تنبيهاً عاماً لجميع الطلاب بخطوات بسيطة.</p>
            </div>
            <div class="p-5 sm:p-8">
                <form id="quick-send-form" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">العنوان</label>
                        <input type="text" id="quick_title" name="title" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" placeholder="عنوان الإشعار" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">المستهدفون</label>
                        <select id="quick_target" name="target_type" required onchange="updateQuickTargetCount()" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                            <option value="">اختر المستهدفين</option>
                            <option value="all_students">جميع الطلاب</option>
                        </select>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-300">سيتم الإرسال إلى <span id="quick-target-count" class="font-semibold text-slate-900 dark:text-white">0</span> طالب.</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">نص الإشعار</label>
                        <textarea id="quick_message" name="message" rows="3" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-3 text-sm leading-relaxed text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" placeholder="اكتب رسالة مختصرة ومباشرة..."></textarea>
                    </div>
                    <div class="md:col-span-2 flex items-center justify-end">
                        <button type="button" onclick="sendQuickNotification()" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-paper-plane"></i>
                            إرسال سريع
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
            <div class="px-5 py-6 sm:px-8 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">توزيع حسب النوع</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">مؤشر سريع لأكثر أنواع الإشعارات استخداماً.</p>
            </div>
            <div class="p-5 sm:p-8">
                @if ($stats['by_type']->count() > 0)
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($stats['by_type'] as $type => $count)
                            <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 text-center text-sm text-slate-600 dark:border-slate-800 dark:bg-slate-900/70 dark:text-slate-300">
                                <p class="text-xl font-bold text-slate-900 dark:text-white">{{ $count }}</p>
                                <p>{{ $notificationTypes[$type] ?? $type }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 dark:text-slate-300">لم يتم تجميع بيانات كافية بعد.</p>
                @endif
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    function updateQuickTargetCount() {
        const targetType = document.getElementById('quick_target').value;
        const targetId = null;
        if (targetType) {
            fetch(`{{ route('admin.notifications.target-count') }}?target_type=${targetType}&target_id=${targetId}`)
                .then(response => response.json())
                .then(data => document.getElementById('quick-target-count').textContent = data.count || 0)
                .catch(() => document.getElementById('quick-target-count').textContent = 0);
        } else {
            document.getElementById('quick-target-count').textContent = 0;
        }
    }

    function sendQuickNotification() {
        const form = document.getElementById('quick-send-form');
        const formData = new FormData(form);
        const payload = {
            title: formData.get('title'),
            message: formData.get('message'),
            target_type: formData.get('target_type'),
            target_id: null,
        };

        if (!payload.title || !payload.message || !payload.target_type) {
            alert('يرجى ملء جميع الحقول المطلوبة');
            return;
        }

        fetch('{{ route("admin.notifications.quick-send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(payload),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                form.reset();
                document.getElementById('quick-target-count').textContent = 0;
                window.location.reload();
            } else {
                alert('حدث خطأ في إرسال الإشعار');
            }
        })
        .catch(() => alert('حدث خطأ في إرسال الإشعار'));
    }

    function markAllAsRead() {
        if (!confirm('هل تريد تحديد جميع الإشعارات كمقروءة؟')) return;
        fetch('{{ route("admin.notifications.mark-all-read") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            }
        });
    }

    function cleanupOld() {
        if (!confirm('هل تريد حذف الإشعارات المقروءة الأقدم من 30 يوم؟')) return;
        fetch('{{ route("admin.notifications.cleanup") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ days: 30 }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            }
        });
    }
</script>
@endpush
@endsection
