@extends('layouts.app')

@section('title', 'إضافة مستخدم جديد - Tech Bridge')
@section('header', 'إضافة مستخدم جديد')

@section('content')
<div class="space-y-10">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <nav class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500 flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="text-sky-600 hover:text-sky-700 dark:text-sky-300">لوحة التحكم</a>
                    <span>/</span>
                    <a href="{{ route('admin.users') }}" class="text-sky-600 hover:text-sky-700 dark:text-sky-300">إدارة المستخدمين</a>
                    <span>/</span>
                    <span class="text-slate-500 dark:text-slate-400">إضافة مستخدم</span>
                </nav>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">إنشاء حساب مستخدم جديد</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">أدخل بيانات المستخدم الأساسية، حدد دوره، واضبط حالة الحساب قبل الحفظ.</p>
            </div>
            <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:text-sky-300">
                <i class="fas fa-arrow-right"></i>
                العودة للقائمة
            </a>
        </div>
    </section>

    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-10">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 p-5 sm:p-8 lg:p-12">
                <div class="lg:col-span-2 space-y-8">
                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 p-6 space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">المعلومات الأساسية</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">بيانات الهوية والتواصل يتم استخدامها في التنبيهات وتسجيل الدخول.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الاسم الكامل <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" />
                                @error('name')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                            @php $countryCodes = $countryCodes ?? config('country_codes.list', []); @endphp
                            <div x-data="{ countryCode: '{{ old('country_code', '20') }}', countries: @json($countryCodes) }">
                                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">رقم الهاتف <span class="text-rose-500">*</span></label>
                                <div class="flex gap-2">
                                    <select name="country_code" x-model="countryCode" required
                                            class="w-36 flex-shrink-0 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-3 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500"
                                            dir="ltr">
                                        @foreach($countryCodes as $key => $country)
                                            <option value="{{ $key }}" {{ old('country_code', '20') == (string)$key ? 'selected' : '' }}>{{ $country['code'] }} {{ $country['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                           :placeholder="countries[countryCode] ? countries[countryCode].placeholder : ''"
                                           :maxlength="countries[countryCode] ? countries[countryCode].max_length : 15"
                                           class="min-w-0 flex-1 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500"
                                           dir="ltr" />
                                </div>
                                @error('phone')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                                @error('country_code')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">البريد الإلكتروني <span class="text-rose-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="example@email.com" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" />
                                @error('email')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">كلمة المرور <span class="text-rose-500">*</span></label>
                                <input type="password" name="password" id="password" required minlength="8" class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500" />
                                @error('password')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                                <p class="mt-2 text-xs text-slate-500 dark:text-slate-300">يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل.</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 p-6 space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">الدور والصلاحيات</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">حدد مستوى الوصول المسموح للمستخدم وحالة الحساب عند الإنشاء.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="role" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">الدور <span class="text-rose-500">*</span></label>
                                <select name="role" id="role" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="">اختر الدور</option>
                                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>إداري</option>
                                    <option value="instructor" {{ old('role') == 'instructor' ? 'selected' : '' }}>مدرس</option>
                                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>طالب</option>
                                </select>
                                @error('role')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="is_active" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">حالة الحساب <span class="text-rose-500">*</span></label>
                                <select name="is_active" id="is_active" required class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>نشط</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('is_active')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="rounded-2xl border border-sky-200 bg-sky-50/80 p-4 text-sm text-sky-700 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-200">
                            <h4 class="font-semibold mb-2">وصف سريع للأدوار</h4>
                            <ul class="list-disc pr-5 space-y-1">
                                <li><strong>إداري:</strong> صلاحيات كاملة لإدارة المنصة والمستخدمين.</li>
                                <li><strong>مدرس:</strong> إدارة المحتوى التعليمي، المحاضرات، الامتحانات.</li>
                                <li><strong>طالب:</strong> الوصول للكورسات، أداء الواجبات والامتحانات.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 p-6">
                        <label for="bio" class="block text-xs font-semibold text-slate-500 dark:text-slate-300 mb-2">نبذة تعريفية (اختياري)</label>
                        <textarea name="bio" id="bio" rows="4" placeholder="اكتب ملخصاً عن خبرات المستخدم أو ملاحظات داخلية..." class="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/90 dark:bg-slate-900/60 px-4 py-3 text-sm leading-7 text-slate-900 dark:text-white focus:border-sky-400 focus:ring-2 focus:ring-sky-500">{{ old('bio') }}</textarea>
                        @error('bio')<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 p-6">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">إرشادات إنشاء الحساب</h3>
                        <ul class="mt-4 space-y-2 text-sm text-slate-600 dark:text-slate-300">
                            <li class="flex items-start gap-2"><i class="fas fa-check text-sky-500 mt-1"></i><span>تأكد من صحة رقم الهاتف لأنه يُستخدم في تسجيل الدخول.</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-sky-500 mt-1"></i><span>اختر الدور المناسب بناءً على مهام المستخدم في الفريق.</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-sky-500 mt-1"></i><span>يمكن تفعيل الحساب لاحقاً إذا رغبت في المراجعة أولاً.</span></li>
                            <li class="flex items-start gap-2"><i class="fas fa-check text-sky-500 mt-1"></i><span>أضف نبذة تعريفية للمدربين لعرضها في صفحة الكورس.</span></li>
                        </ul>
                    </div>

                    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/70 p-6 space-y-4">
                        <p class="text-xs text-slate-500 dark:text-slate-300"><span class="text-rose-500">*</span> الحقول المطلوبة لإكمال إنشاء الحساب.</p>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800/70">
                                إلغاء والعودة
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                                <i class="fas fa-save"></i>
                                إنشاء المستخدم
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

@push('scripts')
<script>
    const roleDescriptions = {
        super_admin: 'الإداري لديه صلاحيات كاملة لإدارة المنصة والمستخدمين والمحتوى',
        instructor: 'المدرس يمكنه إنشاء وإدارة الكورسات والدروس والامتحانات',
        student: 'الطالب يمكنه الوصول للكورسات المسجل بها وأداء المهام والامتحانات'
    };

    document.getElementById('role').addEventListener('change', function () {
        const description = roleDescriptions[this.value] || '';
        if (description) {
            console.info(description);
        }
    });

    document.getElementById('phone').addEventListener('input', function () {
        const sanitized = this.value.replace(/\D/g, '');
        // إزالة شرط بدء الرقم بـ 05
        if (sanitized.length && sanitized.length < 8) {
            this.setCustomValidity('رقم الهاتف يجب أن يكون 8 أرقام على الأقل');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endpush
@endsection
