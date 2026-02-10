@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- الهيدر -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">طلباتي</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">تتبع حالة طلباتك وعمليات الشراء</p>
            </div>
            <a href="{{ route('academic-years') }}" 
               class="bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                <i class="fas fa-plus mr-2"></i>
                تصفح الكورسات
            </a>
        </div>
    </div>

    <!-- الطلبات -->
    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row items-start justify-between gap-4">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-3 mb-3">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $order->course->title ?? 'كورس غير محدد' }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($order->status == 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-200
                                    @elseif($order->status == 'approved') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200
                                    @else bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200
                                    @endif">
                                    {{ $order->status_text }}
                                </span>
                            </div>
                            
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
                                <span class="text-gray-400 dark:text-gray-500">•</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                            @else
                            <div class="mb-3">
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <div class="p-3 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-sky-100 dark:border-gray-600">
                                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">
                                        <i class="fas fa-money-bill-wave ml-1 text-xs"></i>
                                        المبلغ
                                    </div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($order->amount, 2) }} ج.م</div>
                                </div>
                                
                                <div class="p-3 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-sky-100 dark:border-gray-600">
                                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">
                                        <i class="fas fa-wallet ml-1 text-xs"></i>
                                        طريقة الدفع
                                    </div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">
                                        @if($order->payment_method == 'bank_transfer')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-200">
                                                تحويل بنكي
                                            </span>
                                        @elseif($order->payment_method == 'cash')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-200">
                                                نقدي
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                أخرى
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="p-3 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-sky-100 dark:border-gray-600">
                                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">
                                        <i class="fas fa-calendar-alt ml-1 text-xs"></i>
                                        تاريخ الطلب
                                    </div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->created_at->format('d/m/Y') }}</div>
                                </div>
                                
                                @if($order->approved_at)
                                <div class="p-3 bg-gradient-to-br from-sky-50 to-slate-50 dark:from-gray-700 dark:to-gray-700 rounded-lg border border-sky-100 dark:border-gray-600">
                                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wide">
                                        <i class="fas fa-check-circle ml-1 text-xs"></i>
                                        تاريخ الموافقة
                                    </div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->approved_at->format('d/m/Y') }}</div>
                                </div>
                                @endif
                            </div>

                            @if($order->notes)
                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1 flex items-center gap-2">
                                        <i class="fas fa-sticky-note text-sky-500"></i>
                                        ملاحظاتك
                                    </div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300">{{ $order->notes }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-row lg:flex-col gap-2 w-full lg:w-auto">
                            <a href="{{ route('orders.show', $order) }}" 
                               class="flex-1 lg:flex-none bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center shadow-lg shadow-sky-500/30">
                                <i class="fas fa-eye ml-2"></i>
                                عرض التفاصيل
                            </a>
                            
                            @if($order->status == 'approved' && $order->course)
                                <a href="{{ route('courses.show', $order->course) }}" 
                                   class="flex-1 lg:flex-none bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center shadow-lg shadow-emerald-500/30">
                                    <i class="fas fa-play ml-2"></i>
                                    ادخل للكورس
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- الصفحات -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center border border-gray-200 dark:border-gray-700">
            <div class="text-gray-500 dark:text-gray-400">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-sky-100 to-slate-100 dark:from-gray-700 dark:to-gray-700 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-3xl text-sky-600 dark:text-sky-400"></i>
                </div>
                <p class="text-lg font-bold text-gray-900 dark:text-white mb-2">لا توجد طلبات</p>
                <p class="text-sm mb-6">لم تقم بتقديم أي طلبات بعد</p>
                <a href="{{ route('academic-years') }}" 
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-sky-700 hover:from-sky-700 hover:to-sky-800 text-white px-6 py-3 rounded-lg font-medium transition-colors shadow-lg shadow-sky-500/30">
                    <i class="fas fa-plus"></i>
                    تصفح الكورسات
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
