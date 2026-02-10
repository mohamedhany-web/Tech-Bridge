@extends('layouts.app')

@section('title', 'صلاحيات ' . $user->name . ' - Tech Bridge')
@section('header', 'صلاحيات ' . $user->name)

@section('content')
<div class="p-6 space-y-6">
    <!-- معلومات المستخدم -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                @if($user->profile_image)
                    <img class="h-16 w-16 rounded-full" src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
                @else
                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->phone }}</p>
                </div>
            </div>
            <div class="text-left">
                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                    {{ $user->role === 'super_admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                       ($user->role === 'instructor' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                       'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200') }}">
                    {{ $user->role === 'super_admin' ? 'مدير عام' : ($user->role === 'instructor' ? 'مدرب' : 'طالب') }}
                </span>
            </div>
        </div>
    </div>

    <!-- إحصائيات الصلاحيات -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">من الأدوار</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $rolePermissions->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tag text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">مباشرة</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $directPermissions->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-key text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">إجمالي الصلاحيات</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $allUserPermissions->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">الأدوار</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->roles->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users-cog text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- إدارة الصلاحيات المباشرة -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إدارة الصلاحيات المباشرة</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">يمكنك إضافة أو إزالة صلاحيات مباشرة للمستخدم (بغض النظر عن الأدوار)</p>
        </div>

        <form action="{{ route('admin.user-permissions.update', $user) }}" method="POST" id="permissionsForm">
            @csrf
            @method('PUT')
            
            <div class="p-6 space-y-6">
                @foreach($allPermissions as $group => $permissions)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-b-0 last:pb-0">
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <i class="fas fa-folder text-blue-500"></i>
                            {{ $group ?: 'عام' }}
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($permissions as $permission)
                                @php
                                    $hasFromRole = $rolePermissions->contains('id', $permission->id);
                                    $hasDirect = $directPermissions->contains('id', $permission->id);
                                    $isChecked = $hasDirect;
                                @endphp
                                <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors
                                    {{ $hasFromRole ? 'border-purple-300 dark:border-purple-700 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-200 dark:border-gray-700' }}
                                    {{ $isChecked ? 'border-blue-500 dark:border-blue-600 bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                    <input type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}"
                                           {{ $isChecked ? 'checked' : '' }}
                                           class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                           onchange="updatePermission({{ $permission->id }}, this.checked)">
                                    <div class="mr-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $permission->display_name }}
                                            </span>
                                            @if($hasFromRole)
                                                <span class="text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200" title="من الأدوار">
                                                    <i class="fas fa-user-tag"></i>
                                                </span>
                                            @endif
                                        </div>
                                        @if($permission->description)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $permission->description }}</p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-info-circle ml-2"></i>
                        الصلاحيات المميزة باللون البنفسجي متوفرة من الأدوار. يمكنك إضافة صلاحيات مباشرة إضافية.
                    </p>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function updatePermission(permissionId, isChecked) {
    const url = isChecked 
        ? '{{ route("admin.user-permissions.attach", $user) }}'
        : '{{ route("admin.user-permissions.detach", $user) }}';
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            permission_id: permissionId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // إظهار رسالة نجاح
            showNotification(data.message, 'success');
        } else {
            // إظهار رسالة خطأ
            showNotification(data.message || 'حدث خطأ', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('حدث خطأ أثناء تحديث الصلاحية', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 left-4 z-50 px-6 py-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endpush
@endsection

