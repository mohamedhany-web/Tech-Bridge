@extends('layouts.app')

@section('title', 'إدارة المستخدمين - Tech Bridge')
@section('header', 'إدارة المستخدمين')

@section('content')
@php
    $stats = [
        [
            'label' => 'إجمالي المستخدمين',
            'value' => \App\Models\User::count(),
            'icon' => 'fas fa-users',
            'color' => 'text-sky-500 bg-sky-100/70 dark:text-sky-300 dark:bg-sky-500/10',
        ],
        [
            'label' => 'المستخدمون النشطون',
            'value' => \App\Models\User::where('is_active', true)->count(),
            'icon' => 'fas fa-user-check',
            'color' => 'text-emerald-500 bg-emerald-100/70 dark:text-emerald-300 dark:bg-emerald-500/10',
        ],
        [
            'label' => 'المدرسون',
            'value' => \App\Models\User::whereIn('role', ['instructor', 'teacher'])->count(),
            'icon' => 'fas fa-chalkboard-teacher',
            'color' => 'text-indigo-500 bg-indigo-100/70 dark:text-indigo-300 dark:bg-indigo-500/10',
        ],
        [
            'label' => 'الطلاب',
            'value' => \App\Models\User::where('role', 'student')->count(),
            'icon' => 'fas fa-user-graduate',
            'color' => 'text-purple-500 bg-purple-100/70 dark:text-purple-300 dark:bg-purple-500/10',
        ],
    ];

    $roles = [
        'super_admin' => ['label' => 'مدير عام', 'badge' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-200'],
        'admin' => ['label' => 'إداري', 'badge' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-200'],
        'instructor' => ['label' => 'مدرب', 'badge' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-200'],
        'teacher' => ['label' => 'مدرس', 'badge' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-200'],
        'student' => ['label' => 'طالب', 'badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-200'],
        'parent' => ['label' => 'ولي أمر', 'badge' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-200'],
    ];
@endphp

<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">مركز إدارة المستخدمين</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-2">متابعة الحسابات، الصلاحيات، وحالة النشاط عبر المنصة.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-sky-600 rounded-xl shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                <i class="fas fa-user-plus"></i>
                إضافة مستخدم جديد
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 p-5 sm:p-8">
            @foreach ($stats as $stat)
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                        <p class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($stat['value']) }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $stat['color'] }}">
                        <i class="{{ $stat['icon'] }} text-xl"></i>
                    </span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800">
            <form method="GET" action="{{ route('admin.users') }}" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">البحث</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="الاسم، البريد الإلكتروني، رقم الهاتف" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 pr-10 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الدور</label>
                        <select name="role" id="role_filter" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400">
                            <option value="">جميع الأدوار</option>
                            <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>مدير عام</option>
                            <option value="instructor" {{ request('role') == 'instructor' ? 'selected' : '' }}>مدرب</option>
                            <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>طالب</option>
                            {{-- خيارات للتوافق مع الأدوار القديمة --}}
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>إداري (قديم)</option>
                            <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>مدرس (قديم)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الحالة</label>
                        <select name="status" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-sky-500 focus:border-sky-400">
                            <option value="">جميع الحالات</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                            <i class="fas fa-search"></i>
                            بحث متقدم
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-right">
                <thead class="bg-slate-50 dark:bg-slate-900/70">
                    <tr class="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-300">
                        <th class="px-6 py-4">المستخدم</th>
                        <th class="px-6 py-4">الدور</th>
                        <th class="px-6 py-4">الحالة</th>
                        <th class="px-6 py-4 whitespace-nowrap">تاريخ التسجيل</th>
                        <th class="px-6 py-4">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-sm text-slate-700 dark:text-slate-200">
                    @forelse ($users as $user)
                        <tr class="bg-white/70 dark:bg-slate-900/60 hover:bg-slate-50 dark:hover:bg-slate-800/70 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-100/80 text-sky-600 dark:bg-sky-500/15 dark:text-sky-300">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-300">{{ $user->email ?: 'لا يوجد بريد إلكتروني' }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-300">{{ $user->phone }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleMeta = $roles[$user->role] ?? null;
                                @endphp
                                @if($roleMeta)
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $roleMeta['badge'] }}">
                                        <span class="h-2 w-2 rounded-full bg-current"></span>
                                        {{ $roleMeta['label'] }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-200' : 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-200' }}">
                                    <span class="h-2 w-2 rounded-full bg-current"></span>
                                    {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-300">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3 text-lg">
                                    <button type="button" onclick="editUser({{ $user->id }})" class="text-sky-500 hover:text-sky-600 dark:text-sky-300 dark:hover:text-sky-200" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if ($user->id !== auth()->id())
                                        <button type="button" onclick="deleteUser({{ $user->id }})" class="text-rose-500 hover:text-rose-600 dark:text-rose-300 dark:hover:text-rose-200" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-300">
                                لا توجد نتائج مطابقة للبحث الحالي.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800">
                {{ $users->links() }}
            </div>
        @endif
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">إجراءات سريعة</h3>
                <p class="text-sm text-slate-500 dark:text-slate-300">تنظيم وإدارة صلاحيات المستخدمين بكفاءة.</p>
            </div>
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                <i class="fas fa-tools"></i>
                Quick Actions
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 p-5 sm:p-8">
            <a href="{{ route('admin.roles.index') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 hover:border-sky-300 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">إدارة الأدوار</h4>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-300">تعريف الصلاحيات وتوزيعها حسب الفريق.</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100/70 text-sky-600 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fas fa-shield-alt"></i>
                    </span>
                </div>
            </a>
            <a href="{{ route('admin.permissions.index') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 hover:border-sky-300 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">مصفوفة الصلاحيات</h4>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-300">إدارة الصلاحيات الدقيقة لكل مستخدم.</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100/70 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i class="fas fa-key"></i>
                    </span>
                </div>
            </a>
            <a href="{{ route('admin.users.create') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 hover:border-sky-300 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">إضافة حساب جديد</h4>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-300">إنشاء حسابات للمدرسين أو الطلاب الجدد.</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100/70 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i class="fas fa-user-plus"></i>
                    </span>
                </div>
            </a>
            <a href="{{ route('admin.activity-log') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/70 p-5 hover:border-sky-300 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">سجل النشاطات</h4>
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-300">مراجعة تحركات الفريق على المنصة.</p>
                    </div>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100/70 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition">
                        <i class="fas fa-history"></i>
                    </span>
                </div>
            </a>
        </div>
    </section>
</div>

<div id="editUserModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 transition-opacity duration-300">
    <div class="w-full max-w-lg rounded-3xl border border-slate-200 bg-white shadow-2xl dark:border-slate-800 dark:bg-slate-900 max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="editUserModalContent">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">تعديل بيانات المستخدم</h3>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 transition hover:text-slate-600 dark:hover:text-slate-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editUserForm" method="POST" class="space-y-4 px-6 py-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الاسم الكامل</label>
                    <input type="text" name="name" id="edit_name" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-sky-400 focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900/60 dark:text-white" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" id="edit_email" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-sky-400 focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900/60 dark:text-white" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">رقم الهاتف</label>
                    <input type="text" name="phone" id="edit_phone" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-sky-400 focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900/60 dark:text-white" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">كلمة المرور الجديدة (اختياري)</label>
                    <input type="password" name="password" id="edit_password" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-sky-400 focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900/60 dark:text-white" />
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">نبذة تعريفية (اختياري)</label>
                    <textarea name="bio" id="edit_bio" rows="3" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-sky-400 focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900/60 dark:text-white"></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الدور</label>
                        <select name="role" id="edit_role" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-sky-400 focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900/60 dark:text-white">
                            <option value="super_admin">مدير عام</option>
                            <option value="admin">إداري</option>
                            <option value="instructor">مدرب</option>
                            <option value="teacher">مدرس</option>
                            <option value="student">طالب</option>
                            <option value="parent">ولي أمر</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">حالة الحساب</label>
                        <select name="is_active" id="edit_is_active" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 focus:border-sky-400 focus:ring-2 focus:ring-sky-500 dark:border-slate-700 dark:bg-slate-900/60 dark:text-white">
                            <option value="1">نشط</option>
                            <option value="0">غير نشط</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4">
                <button type="button" onclick="closeEditModal()" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800/70">
                    إلغاء
                </button>
                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                    <i class="fas fa-save"></i>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const editModal = document.getElementById('editUserModal');
    const editForm = document.getElementById('editUserForm');
    
    // معالجة إرسال النموذج
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(editForm);
        const submitButton = editForm.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        
        // تعطيل الزر وإظهار حالة التحميل
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
        
        fetch(editForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                // إذا كان الـ response redirect، نعيد تحميل الصفحة
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    // إذا كان JSON response
                    return response.json().then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            throw new Error(data.message || 'حدث خطأ أثناء التحديث');
                        }
                    }).catch(() => {
                        // إذا لم يكن JSON، نعيد تحميل الصفحة
                        window.location.reload();
                    });
                }
            } else {
                // إذا كان هناك خطأ في الـ response
                return response.text().then(html => {
                    // محاولة استخراج رسالة الخطأ من HTML
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const errorMessage = doc.querySelector('.alert-danger, .text-red-500, .error')?.textContent || 'حدث خطأ أثناء التحديث';
                    throw new Error(errorMessage);
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'حدث خطأ أثناء تحديث بيانات المستخدم');
        })
        .finally(() => {
            // إعادة تفعيل الزر
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
    });

    function openModal() {
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        
        // إضافة animation للفتح
        setTimeout(() => {
            const modalContent = document.getElementById('editUserModalContent');
            if (modalContent) {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }
        }, 10);
    }

    function closeEditModal() {
        const modalContent = document.getElementById('editUserModalContent');
        if (modalContent) {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
        }
        
        setTimeout(() => {
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
            editForm.reset();
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // إغلاق الـ modal عند الضغط على Escape
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !editModal.classList.contains('hidden')) {
            closeEditModal();
        }
    });
    
    // إغلاق الـ modal عند الضغط على الخلفية
    editModal.addEventListener('click', (event) => {
        if (event.target === editModal) {
            closeEditModal();
        }
    });

    function editUser(userId) {
        fetch(`/admin/users/${userId}/edit`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(user => {
                document.getElementById('edit_name').value = user.name || '';
                document.getElementById('edit_email').value = user.email || '';
                document.getElementById('edit_phone').value = user.phone || '';
                document.getElementById('edit_role').value = user.role || 'student';
                document.getElementById('edit_is_active').value = user.is_active ? '1' : '0';
                if (document.getElementById('edit_bio')) {
                    document.getElementById('edit_bio').value = user.bio || '';
                }

                editForm.action = `/admin/users/${userId}`;
                openModal();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء تحميل بيانات المستخدم');
            });
    }

    function deleteUser(userId) {
        if (confirm('هل أنت متأكد من حذف هذا المستخدم؟ هذا الإجراء لا يمكن التراجع عنه.')) {
            // إظهار مؤشر التحميل
            const loadingIndicator = document.createElement('div');
            loadingIndicator.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.8); color: white; padding: 20px; border-radius: 8px; z-index: 9999;';
            loadingIndicator.textContent = 'جاري الحذف...';
            document.body.appendChild(loadingIndicator);
            
            fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                // إزالة مؤشر التحميل
                if (document.body.contains(loadingIndicator)) {
                    document.body.removeChild(loadingIndicator);
                }
                
                // التحقق من نوع المحتوى
                const contentType = response.headers.get('content-type') || '';
                
                if (!response.ok) {
                    // محاولة قراءة JSON
                    if (contentType.includes('application/json')) {
                        try {
                            const data = await response.json();
                            throw new Error(data.message || 'حدث خطأ أثناء حذف المستخدم');
                        } catch (e) {
                            if (e instanceof Error && e.message && e.message !== 'Unexpected end of JSON input') {
                                throw e;
                            }
                            throw new Error(`خطأ ${response.status}: ${response.statusText}`);
                        }
                    } else {
                        // إذا لم يكن JSON، قراءة النص
                        const text = await response.text();
                        throw new Error(text || `خطأ ${response.status}: ${response.statusText}`);
                    }
                }
                
                // قراءة JSON response
                if (contentType.includes('application/json')) {
                    try {
                        const data = await response.json();
                        return data;
                    } catch (e) {
                        // إذا فشل parse JSON، لكن الـ status code هو 200، نعتبره نجاح
                        if (response.status === 200) {
                            return { success: true, message: 'تم حذف المستخدم بنجاح' };
                        }
                        throw new Error('فشل في قراءة الاستجابة من الخادم');
                    }
                } else {
                    // إذا لم يكن JSON، إرجاع success افتراضي
                    return { success: true, message: 'تم حذف المستخدم بنجاح' };
                }
            })
            .then(data => {
                if (data && data.success) {
                    // إظهار رسالة نجاح
                    alert(data.message || 'تم حذف المستخدم بنجاح');
                    // إعادة تحميل الصفحة بعد تأخير قصير
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    alert(data?.message || 'حدث خطأ أثناء حذف المستخدم');
                }
            })
            .catch(error => {
                // إزالة مؤشر التحميل في حالة الخطأ
                if (document.body.contains(loadingIndicator)) {
                    document.body.removeChild(loadingIndicator);
                }
                
                console.error('Error:', error);
                let errorMessage = 'حدث خطأ أثناء حذف المستخدم';
                
                if (error instanceof Error) {
                    errorMessage = error.message || errorMessage;
                } else if (typeof error === 'string') {
                    errorMessage = error;
                }
                
                // تجاهل خطأ "Unexpected end of JSON input" إذا كان الحذف ناجحاً
                if (errorMessage.includes('Unexpected end of JSON input')) {
                    alert('تم حذف المستخدم بنجاح');
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    alert(errorMessage);
                }
            });
        }
    }
</script>
@endpush
@endsection
