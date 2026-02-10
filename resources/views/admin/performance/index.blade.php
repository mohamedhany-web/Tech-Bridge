@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-tachometer-alt text-sky-600 ml-3"></i>
                    {{ __('أداء الموقع') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">{{ __('متابعة وتحسين أداء الموقع') }}</p>
            </div>
        </div>
    </div>

    <!-- System Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ __('إصدار PHP') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $systemInfo['php_version'] }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fab fa-php text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ __('إصدار Laravel') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $systemInfo['laravel_version'] }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fab fa-laravel text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">{{ __('حد الذاكرة') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $systemInfo['memory_limit'] }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-memory text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Memory Usage -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-microchip text-sky-600"></i>
                {{ __('استخدام الذاكرة') }}
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">{{ __('الاستخدام الحالي') }}:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $performanceInfo['memory_usage'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">{{ __('الحد الأقصى') }}:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $performanceInfo['memory_peak'] }}</span>
                </div>
            </div>
        </div>

        <!-- Disk Space -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-hdd text-sky-600"></i>
                {{ __('مساحة القرص') }}
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">{{ __('المساحة المتاحة') }}:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $performanceInfo['disk_free_space'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <span class="text-gray-600 dark:text-gray-400">{{ __('إجمالي المساحة') }}:</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $performanceInfo['disk_total_space'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cache Management -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-8 border border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-database text-sky-600"></i>
            {{ __('إدارة الكاش') }}
        </h2>

        <!-- Cache Sizes -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ __('كاش الإعدادات') }}</div>
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $cacheSizes['config'] }}</div>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ __('كاش المسارات') }}</div>
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $cacheSizes['route'] }}</div>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-4 border border-emerald-200 dark:border-emerald-800">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ __('كاش العروض') }}</div>
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $cacheSizes['view'] }}</div>
            </div>
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl p-4 border border-orange-200 dark:border-orange-800">
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ __('كاش التطبيق') }}</div>
                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $cacheSizes['application'] }}</div>
            </div>
        </div>

        <!-- Cache Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <button onclick="clearCache('config')" class="bg-gradient-to-l from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-trash"></i>
                {{ __('مسح كاش الإعدادات') }}
            </button>
            <button onclick="clearCache('route')" class="bg-gradient-to-l from-purple-600 to-purple-500 hover:from-purple-700 hover:to-purple-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-trash"></i>
                {{ __('مسح كاش المسارات') }}
            </button>
            <button onclick="clearCache('view')" class="bg-gradient-to-l from-emerald-600 to-emerald-500 hover:from-emerald-700 hover:to-emerald-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-trash"></i>
                {{ __('مسح كاش العروض') }}
            </button>
            <button onclick="clearCache('application')" class="bg-gradient-to-l from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-trash"></i>
                {{ __('مسح كاش التطبيق') }}
            </button>
            <button onclick="clearCache('all')" class="bg-gradient-to-l from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-broom"></i>
                {{ __('مسح جميع الكاش') }}
            </button>
            <button onclick="optimizeCache()" class="bg-gradient-to-l from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-rocket"></i>
                {{ __('تحسين الأداء') }}
            </button>
        </div>
    </div>

    <!-- Optimization Tools -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Clear Temp Files -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-file-archive text-sky-600"></i>
                {{ __('تنظيف الملفات المؤقتة') }}
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                {{ __('حذف الملفات المؤقتة القديمة لتحرير مساحة القرص') }}
            </p>
            <button onclick="clearTempFiles()" class="w-full bg-gradient-to-l from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-broom"></i>
                {{ __('تنظيف الملفات المؤقتة') }}
            </button>
        </div>

        <!-- Optimize Database -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-database text-sky-600"></i>
                {{ __('تحسين قاعدة البيانات') }}
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                {{ __('تحسين الجداول وتحسين الأداء') }}
            </p>
            <button onclick="optimizeDatabase()" class="w-full bg-gradient-to-l from-teal-600 to-teal-500 hover:from-teal-700 hover:to-teal-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-tools"></i>
                {{ __('تحسين قاعدة البيانات') }}
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function clearCache(type) {
    if (confirm('{{ __('هل أنت متأكد من مسح الكاش؟') }}')) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('جاري المعالجة...') }}';
        
        fetch(`{{ route('admin.performance.clear-cache') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type: type })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('حدث خطأ: ' + data.message);
                button.disabled = false;
                button.innerHTML = originalText;
            }
        })
        .catch(error => {
            alert('حدث خطأ: ' + error.message);
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
}

function optimizeCache() {
    if (confirm('{{ __('هل تريد تحسين الأداء بإنشاء الكاش؟') }}')) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('جاري التحسين...') }}';
        
        fetch(`{{ route('admin.performance.optimize-cache') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('حدث خطأ: ' + data.message);
                button.disabled = false;
                button.innerHTML = originalText;
            }
        })
        .catch(error => {
            alert('حدث خطأ: ' + error.message);
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
}

function clearTempFiles() {
    if (confirm('{{ __('هل تريد حذف الملفات المؤقتة؟') }}')) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('جاري التنظيف...') }}';
        
        fetch(`{{ route('admin.performance.clear-temp-files') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert('حدث خطأ: ' + data.message);
            }
            button.disabled = false;
            button.innerHTML = originalText;
        })
        .catch(error => {
            alert('حدث خطأ: ' + error.message);
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
}

function optimizeDatabase() {
    if (confirm('{{ __('هل تريد تحسين قاعدة البيانات؟ قد يستغرق هذا الأمر بعض الوقت.') }}')) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('جاري التحسين...') }}';
        
        fetch(`{{ route('admin.performance.optimize-database') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert('حدث خطأ: ' + data.message);
            }
            button.disabled = false;
            button.innerHTML = originalText;
        })
        .catch(error => {
            alert('حدث خطأ: ' + error.message);
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
}
</script>
@endpush
@endsection

