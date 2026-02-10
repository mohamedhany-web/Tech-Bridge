@extends('layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->id . ' - Tech Bridge')
@section('header', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl shadow-sm">
            <i class="fas fa-check-circle ml-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl shadow-sm">
            <i class="fas fa-exclamation-circle ml-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">تفاصيل الطلب #{{ $order->id }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-xs"></i>
                    {{ $order->created_at->format('d/m/Y - H:i') }}
                </p>
            </div>
            <a href="{{ route('admin.orders.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة للطلبات
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- تفاصيل الطلب -->
        <div class="lg:col-span-2 space-y-6">
            <!-- معلومات الطالب -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-user-graduate text-sky-600 dark:text-sky-400"></i>
                        معلومات الطالب
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-user ml-1"></i>
                                الاسم
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $order->user->name ?? 'غير محدد' }}</div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-phone ml-1"></i>
                                رقم الهاتف
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $order->user->phone ?? 'غير محدد' }}</div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-envelope ml-1"></i>
                                البريد الإلكتروني
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white break-all">{{ $order->user->email ?? 'غير محدد' }}</div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-calendar-check ml-1"></i>
                                تاريخ التسجيل
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $order->user->created_at ? $order->user->created_at->format('d/m/Y') : 'غير محدد' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- معلومات الكورس -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-book-open text-sky-600 dark:text-sky-400"></i>
                        معلومات الكورس
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-24 h-24 bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                            @if($order->course && $order->course->thumbnail)
                                <img src="{{ asset('storage/' . $order->course->thumbnail) }}" alt="{{ $order->course->title ?? 'كورس' }}" 
                                     class="w-full h-full object-cover rounded-xl">
                            @else
                                <i class="fas fa-play-circle text-white text-3xl"></i>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $order->course->title ?? 'كورس غير محدد' }}</h3>
                            @if($order->course && ($order->course->academicYear || $order->course->academicSubject))
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                @if($order->course->academicYear)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-sky-100 text-sky-700 dark:bg-sky-500/15 dark:text-sky-200">
                                    <i class="fas fa-graduation-cap ml-1 text-xs"></i>
                                    {{ $order->course->academicYear->name }}
                                </span>
                                @endif
                                @if($order->course->academicSubject)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-200">
                                    <i class="fas fa-layer-group ml-1 text-xs"></i>
                                    {{ $order->course->academicSubject->name }}
                                </span>
                                @endif
                            </div>
                            @endif
                            @if($order->course && $order->course->description)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::limit($order->course->description, 150) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- تفاصيل الدفع -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-credit-card text-sky-600 dark:text-sky-400"></i>
                        تفاصيل الدفع
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-money-bill-wave ml-1"></i>
                                المبلغ
                            </label>
                            <div class="text-2xl font-bold bg-gradient-to-r from-sky-600 to-sky-700 bg-clip-text text-transparent">
                                {{ number_format($order->amount, 2) }} <span class="text-base text-gray-600 dark:text-gray-400">ج.م</span>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-wallet ml-1"></i>
                                طريقة الدفع
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">
                                @if($order->payment_method == 'bank_transfer')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-200">
                                        <i class="fas fa-university ml-1 text-xs"></i>
                                        تحويل بنكي
                                    </span>
                                @elseif($order->payment_method == 'cash')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-200">
                                        <i class="fas fa-money-bill ml-1 text-xs"></i>
                                        نقدي
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        <i class="fas fa-question-circle ml-1 text-xs"></i>
                                        أخرى
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-calendar-alt ml-1"></i>
                                تاريخ الطلب
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">
                                {{ $order->created_at->format('d/m/Y') }}
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-normal">- {{ $order->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                        
                        @if($order->approved_at)
                        <div class="p-4 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-xl border border-sky-100 dark:border-gray-600">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wide">
                                <i class="fas fa-check-circle ml-1"></i>
                                تاريخ المراجعة
                            </label>
                            <div class="text-base font-bold text-gray-900 dark:text-white">
                                {{ $order->approved_at->format('d/m/Y') }}
                                <span class="text-sm text-gray-500 dark:text-gray-400 font-normal">- {{ $order->approved_at->format('H:i') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($order->notes)
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                <i class="fas fa-sticky-note text-sky-500"></i>
                                ملاحظات الطالب
                            </label>
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                {{ $order->notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- صورة الإيصال -->
            @if($order->payment_proof)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-sky-50 to-slate-50 dark:from-gray-800 dark:to-gray-800">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fas fa-receipt text-sky-600 dark:text-sky-400"></i>
                            إيصال الدفع
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="text-center">
                            <div class="inline-block p-2 bg-gray-50 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                @php
                                    $fullPath = storage_path('app/public/' . $order->payment_proof);
                                    $imageExists = file_exists($fullPath);
                                    
                                    // استخدام route بديل إذا فشل الرابط الرمزي
                                    if ($imageExists) {
                                        $imageUrl = asset('storage/' . $order->payment_proof);
                                        // إذا كان الرابط الرمزي لا يعمل، استخدم route
                                        if (!file_exists(public_path('storage/' . $order->payment_proof))) {
                                            $imageUrl = route('storage.file', ['path' => $order->payment_proof]);
                                        }
                                    }
                                @endphp
                                @if($imageExists)
                                <img src="{{ $imageUrl }}" 
                                     alt="إيصال الدفع" 
                                     class="max-w-full h-auto rounded-lg shadow-md cursor-pointer hover:shadow-xl transition-all duration-300"
                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';"
                                     onclick="openImageModal(this.src)">
                                <div class="hidden p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300 flex items-center gap-2">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>الصورة غير متوفرة حالياً</span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">المسار المحفوظ: {{ $order->payment_proof }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">URL المستخدم: {{ $imageUrl }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">المسار الكامل: {{ $fullPath }}</p>
                                </div>
                                @else
                                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300 flex items-center gap-2">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>الصورة غير موجودة في الخادم</span>
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">المسار المحفوظ: {{ $order->payment_proof }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">المسار المطلوب: {{ $fullPath }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">URL المتوقع: {{ $imageUrl }}</p>
                                </div>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-4 flex items-center justify-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                اضغط على الصورة لعرضها بحجم أكبر
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- حالة الطلب والإجراءات -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden sticky top-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r 
                    @if($order->status == 'pending') from-amber-50 to-yellow-50 dark:from-gray-800 dark:to-gray-800
                    @elseif($order->status == 'approved') from-emerald-50 to-green-50 dark:from-gray-800 dark:to-gray-800
                    @else from-rose-50 to-red-50 dark:from-gray-800 dark:to-gray-800
                    @endif">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fas 
                            @if($order->status == 'pending') fa-clock text-amber-600 dark:text-amber-400
                            @elseif($order->status == 'approved') fa-check-circle text-emerald-600 dark:text-emerald-400
                            @else fa-times-circle text-rose-600 dark:text-rose-400
                            @endif"></i>
                        حالة الطلب
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-xl flex items-center justify-center shadow-lg
                            @if($order->status == 'pending') bg-amber-100 dark:bg-amber-500/20
                            @elseif($order->status == 'approved') bg-emerald-100 dark:bg-emerald-500/20
                            @else bg-rose-100 dark:bg-rose-500/20
                            @endif">
                            <i class="fas 
                                @if($order->status == 'pending') fa-clock text-amber-600 dark:text-amber-400 text-3xl
                                @elseif($order->status == 'approved') fa-check text-emerald-600 dark:text-emerald-400 text-3xl
                                @else fa-times text-rose-600 dark:text-rose-400 text-3xl
                                @endif"></i>
                        </div>
                        
                        <div class="text-xl font-bold mb-2
                            @if($order->status == 'pending') text-amber-600 dark:text-amber-400
                            @elseif($order->status == 'approved') text-emerald-600 dark:text-emerald-400
                            @else text-rose-600 dark:text-rose-400
                            @endif">
                            {{ $order->status_text }}
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if($order->status == 'pending')
                                جاري المراجعة
                            @elseif($order->status == 'approved')
                                تمت الموافقة
                            @else
                                تم الرفض
                            @endif
                        </p>
                    </div>

                    @if($order->status == 'pending')
                        <div class="space-y-3">
                            <form method="POST" action="{{ route('admin.orders.approve', $order) }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white py-3 px-4 rounded-lg font-medium transition-colors shadow-lg shadow-emerald-500/30"
                                        onclick="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟\nسيتم تفعيل الكورس للطالب تلقائياً.')">
                                    <i class="fas fa-check ml-2"></i>
                                    الموافقة على الطلب
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.orders.reject', $order) }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-700 hover:to-rose-800 text-white py-3 px-4 rounded-lg font-medium transition-colors shadow-lg shadow-rose-500/30"
                                        onclick="return confirm('هل أنت متأكد من رفض هذا الطلب؟')">
                                    <i class="fas fa-times ml-2"></i>
                                    رفض الطلب
                                </button>
                            </form>
                        </div>
                    @elseif($order->status == 'approved')
                        <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-lg p-4">
                            <p class="text-sm text-emerald-800 dark:text-emerald-200 flex items-start gap-2">
                                <i class="fas fa-check-circle mt-0.5"></i>
                                <span>تمت الموافقة على الطلب وتم تفعيل الكورس للطالب.</span>
                            </p>
                        </div>
                    @else
                        <div class="bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/30 rounded-lg p-4">
                            <p class="text-sm text-rose-800 dark:text-rose-200 flex items-start gap-2">
                                <i class="fas fa-exclamation-circle mt-0.5"></i>
                                <span>تم رفض هذا الطلب.</span>
                            </p>
                        </div>
                    @endif

                    @if($order->approver)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wide">تمت المراجعة بواسطة:</p>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-sky-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    {{ substr($order->approver->name ?? 'غير محدد', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $order->approver->name ?? 'غير محدد' }}</p>
                                    @if($order->approved_at)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->approved_at->format('d/m/Y - H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal لعرض الصورة -->
<div id="imageModal" class="fixed inset-0 bg-black/90 backdrop-blur-sm hidden items-center justify-center z-50" onclick="closeImageModal()">
    <div class="max-w-5xl max-h-[90vh] p-4 relative">
        <button onclick="closeImageModal()" class="absolute -top-12 left-0 text-white hover:text-gray-300 text-3xl font-bold transition-colors">
            <i class="fas fa-times-circle"></i>
        </button>
        <img id="modalImage" src="" alt="إيصال الدفع" class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl">
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
