@extends('layouts.app')

@section('title', 'إضافة اشتراك جديد')
@section('header', 'إضافة اشتراك جديد')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">إضافة اشتراك جديد</h1>
        
        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المستخدم *</label>
                    <select name="user_id" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="">اختر المستخدم</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} - {{ $user->phone }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">نوع الاشتراك *</label>
                    <select name="subscription_type" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="monthly" {{ old('subscription_type') == 'monthly' ? 'selected' : '' }}>شهري</option>
                        <option value="quarterly" {{ old('subscription_type') == 'quarterly' ? 'selected' : '' }}>ربع سنوي</option>
                        <option value="yearly" {{ old('subscription_type') == 'yearly' ? 'selected' : '' }}>سنوي</option>
                        <option value="lifetime" {{ old('subscription_type') == 'lifetime' ? 'selected' : '' }}>مدى الحياة</option>
                        <option value="trial" {{ old('subscription_type') == 'trial' ? 'selected' : '' }}>تجريبي</option>
                        <option value="custom" {{ old('subscription_type') == 'custom' ? 'selected' : '' }}>مخصص</option>
                    </select>
                    @error('subscription_type')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اسم الخطة *</label>
                    <input type="text" name="plan_name" required value="{{ old('plan_name') }}" 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    @error('plan_name')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">السعر *</label>
                    <input type="number" name="price" step="0.01" min="0" required value="{{ old('price') }}" 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    @error('price')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تاريخ البداية *</label>
                    <input type="date" name="start_date" required value="{{ old('start_date', date('Y-m-d')) }}" 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    @error('start_date')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تاريخ الانتهاء *</label>
                    <input type="date" name="end_date" required value="{{ old('end_date', date('Y-m-d', strtotime('+1 month'))) }}" 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                    @error('end_date')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">دورة الفوترة *</label>
                    <select name="billing_cycle" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white">
                        <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>شهري</option>
                        <option value="quarterly" {{ old('billing_cycle') == 'quarterly' ? 'selected' : '' }}>ربع سنوي</option>
                        <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>سنوي</option>
                        <option value="biannual" {{ old('billing_cycle') == 'biannual' ? 'selected' : '' }}>كل 6 أشهر</option>
                        <option value="weekly" {{ old('billing_cycle') == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                    </select>
                    @error('billing_cycle')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="auto_renew" value="1" {{ old('auto_renew', false) ? 'checked' : '' }} 
                       class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-sky-500">
                <label class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">تجديد تلقائي</label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                    إنشاء الاشتراك
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

