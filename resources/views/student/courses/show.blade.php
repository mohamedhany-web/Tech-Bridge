@extends('layouts.app')

@push('styles')
<style>
    .course-video-card {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }
    
    .play-button {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .play-button:hover {
        transform: scale(1.08);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
    }
    
    .play-button::after {
        content: '';
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 10px 0 10px 16px;
        border-color: transparent transparent transparent #0ea5e9;
        margin-right: -2px;
    }
    
    @media (min-width: 640px) {
        .play-button {
            width: 70px;
            height: 70px;
        }
        
        .play-button::after {
            border-width: 12px 0 12px 20px;
        }
    }
    
    .stat-card {
        transition: all 0.3s ease;
        border-radius: 16px;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .sticky-purchase-card {
        position: sticky;
        top: 100px;
        z-index: 10;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }
    
    .sticky-purchase-card::-webkit-scrollbar {
        width: 6px;
    }
    
    .sticky-purchase-card::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .sticky-purchase-card::-webkit-scrollbar-thumb {
        background: #0ea5e9;
        border-radius: 10px;
    }
    
    .sticky-purchase-card::-webkit-scrollbar-thumb:hover {
        background: #0284c7;
    }
    
    .level-badge {
        border-radius: 20px;
        padding: 6px 16px;
        font-weight: 600;
        font-size: 14px;
    }
    
    /* Prevent card overlap */
    .course-video-card,
    .stat-card,
    .sticky-purchase-card {
        isolation: isolate;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- تفاصيل الكورس -->
            <div class="lg:col-span-2 space-y-6">
                <!-- فيديو الكورس -->
                <div class="course-video-card bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 h-[280px] sm:h-[320px] md:h-[350px] flex items-center justify-center relative">
                    @if($advancedCourse->image)
                        <img src="{{ asset('storage/' . $advancedCourse->image) }}" alt="{{ $advancedCourse->title }}" 
                             class="w-full h-full object-cover absolute inset-0">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/80 via-purple-600/80 to-pink-500/80"></div>
                    @endif
                    
                    <!-- زر التشغيل -->
                    <div class="play-button relative z-10">
                    </div>
                    
                    <!-- شارة المستوى -->
                    <div class="absolute top-3 right-3 z-10">
                        <span class="level-badge inline-flex items-center gap-1.5 text-xs px-3 py-1.5
                            @if($advancedCourse->level == 'beginner') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($advancedCourse->level == 'intermediate') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            <i class="fas fa-signal text-xs"></i>
                            <span class="text-xs font-semibold">{{ $advancedCourse->level_badge['text'] ?? 'مبتدئ' }}</span>
                        </span>
                    </div>
                </div>

                <!-- محتوى الكورس -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-8">
                        <!-- Breadcrumb -->
                        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-6 flex items-center gap-2">
                            <a href="{{ route('academic-years') }}" class="hover:text-sky-600 transition-colors">السنوات الدراسية</a>
                            @if($advancedCourse->academicYear)
                            <span>/</span>
                            <a href="{{ route('academic-years.subjects', $advancedCourse->academicYear) }}" class="hover:text-sky-600 transition-colors">{{ $advancedCourse->academicYear->name }}</a>
                            @endif
                            @if($advancedCourse->academicSubject)
                            <span>/</span>
                            <a href="{{ route('subjects.courses', $advancedCourse->academicSubject) }}" class="hover:text-sky-600 transition-colors">{{ $advancedCourse->academicSubject->name }}</a>
                            @endif
                        </nav>

                        <!-- عنوان الكورس -->
                        <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-4">{{ $advancedCourse->title }}</h1>
                        
                        <!-- وصف الكورس -->
                        <div class="prose max-w-none dark:prose-invert mb-8">
                            <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">{{ $advancedCourse->description }}</p>
                        </div>

                        <!-- معلومات الكورس -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="stat-card bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl p-6 border border-orange-200 dark:border-orange-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">الطلاب</div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $advancedCourse->enrollments_count ?? 0 }}</div>
                                    </div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-users text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="stat-card bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">المستوى</div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ $advancedCourse->level_badge['text'] ?? 'مبتدئ' }}
                                        </div>
                                    </div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-signal text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            
                            @if($advancedCourse->duration_hours)
                            <div class="stat-card bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">المدة</div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $advancedCourse->duration_hours }} ساعة</div>
                                    </div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-clock text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($advancedCourse->lessons_count)
                            <div class="stat-card bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-6 border border-emerald-200 dark:border-emerald-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">الدروس</div>
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $advancedCourse->lessons_count }} درس</div>
                                    </div>
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-video text-white text-xl"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- محتوى الكورس -->
                        @if($advancedCourse->syllabus)
                            <div class="mb-6">
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="fas fa-list-ul text-sky-600"></i>
                                    محتوى الكورس
                                </h3>
                                <div class="prose max-w-none dark:prose-invert">
                                    <div class="text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 border border-gray-200 dark:border-gray-600 whitespace-pre-line">{{ $advancedCourse->syllabus }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- بطاقة الشراء -->
            <div class="lg:col-span-1">
                <div class="sticky-purchase-card bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 p-6">
                    <!-- السعر -->
                    <div class="text-center mb-6 pb-6 border-b border-gray-200 dark:border-gray-700" id="priceDisplay">
                        @if($advancedCourse->price && $advancedCourse->price > 0)
                            <div class="original-price">
                                <div class="text-5xl font-black text-gray-900 dark:text-white mb-2" id="coursePrice" data-price="{{ $advancedCourse->price }}">{{ number_format($advancedCourse->price) }}</div>
                                <div class="text-lg text-gray-600 dark:text-gray-400">ج.م</div>
                            </div>
                            <!-- عرض السعر بعد الخصم (مخفي بشكل افتراضي) -->
                            <div class="discount-price hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400 line-through" id="originalPriceDisplay">{{ number_format($advancedCourse->price) }} ج.م</span>
                                    <span class="text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 px-2 py-1 rounded-full font-bold" id="discountPercentage"></span>
                                </div>
                                <div class="text-4xl font-black text-emerald-600 dark:text-emerald-400 mb-2" id="finalPriceDisplay">{{ number_format($advancedCourse->price) }}</div>
                                <div class="text-lg text-emerald-600 dark:text-emerald-400">ج.م</div>
                                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-2" id="discountAmountText"></p>
                            </div>
                        @else
                            <div class="text-5xl font-black text-green-600 mb-2">مجاني</div>
                        @endif
                    </div>

                    <!-- حالة التسجيل -->
                    @if($isEnrolled)
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl p-4 mb-6">
                            <div class="flex items-center gap-3 text-green-800 dark:text-green-300">
                                <i class="fas fa-check-circle text-2xl"></i>
                                <span class="font-bold">أنت مسجل في هذا الكورس</span>
                            </div>
                        </div>
                        <a href="{{ route('my-courses.show', $advancedCourse->id) }}" class="w-full bg-gradient-to-l from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl text-center block flex items-center justify-center gap-2">
                            <i class="fas fa-play"></i>
                            ادخل للكورس
                        </a>
                    @elseif($existingOrder)
                        @if($existingOrder->status == 'pending')
                            <div class="bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border-2 border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                                <div class="flex items-center gap-3 text-yellow-800 dark:text-yellow-300 mb-2">
                                    <i class="fas fa-clock text-2xl"></i>
                                    <span class="font-bold">طلبك قيد المراجعة</span>
                                </div>
                                <p class="text-sm text-yellow-700 dark:text-yellow-400">سيتم مراجعة طلبك والرد عليك قريباً</p>
                            </div>
                            <a href="{{ route('orders.show', $existingOrder) }}" class="w-full bg-gradient-to-l from-yellow-600 to-yellow-500 hover:from-yellow-700 hover:to-yellow-600 text-white py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl text-center block flex items-center justify-center gap-2">
                                <i class="fas fa-eye"></i>
                                عرض حالة الطلب
                            </a>
                        @elseif($existingOrder->status == 'rejected')
                            <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
                                <div class="flex items-center gap-3 text-red-800 dark:text-red-300 mb-2">
                                    <i class="fas fa-times-circle text-2xl"></i>
                                    <span class="font-bold">تم رفض طلبك</span>
                                </div>
                                <p class="text-sm text-red-700 dark:text-red-400">يمكنك تقديم طلب جديد</p>
                            </div>
                            <button onclick="toggleOrderForm()" class="w-full bg-gradient-to-l from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart"></i>
                                اطلب الآن
                            </button>
                        @endif
                    @else
                        <button onclick="toggleOrderForm()" class="w-full bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-cart"></i>
                            @if($advancedCourse->price && $advancedCourse->price > 0)
                                اشتري الآن
                            @else
                                سجل مجاناً
                            @endif
                        </button>
                    @endif

                    <!-- نموذج الطلب -->
                    @if(!$isEnrolled && (!$existingOrder || $existingOrder->status == 'rejected'))
                        <div id="orderForm" class="hidden mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <form action="{{ route('courses.order', $advancedCourse) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                
                                <!-- حقل كوبون الخصم -->
                                @if($advancedCourse->price && $advancedCourse->price > 0)
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-ticket-alt text-sky-600 ml-2"></i>
                                        كوبون الخصم (اختياري)
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               name="coupon_code" 
                                               id="coupon_code" 
                                               value="{{ old('coupon_code') }}"
                                               placeholder="أدخل كود الكوبون"
                                               autocomplete="off"
                                               class="flex-1 px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all uppercase">
                                        <button type="button" 
                                                id="applyCouponBtn"
                                                onclick="validateCoupon()"
                                                class="bg-gradient-to-l from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white px-6 py-3 rounded-xl font-bold transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                            <i class="fas fa-check"></i>
                                            تطبيق
                                        </button>
                                    </div>
                                    <div id="couponMessage" class="mt-2 text-sm hidden"></div>
                                    <input type="hidden" name="applied_coupon_id" id="applied_coupon_id" value="">
                                </div>
                                @endif
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-credit-card text-sky-600 ml-2"></i>
                                        طريقة الدفع
                                    </label>
                                    <select name="payment_method" id="payment_method" required 
                                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all">
                                        <option value="">اختر طريقة الدفع</option>
                                        <option value="bank_transfer">تحويل بنكي</option>
                                        <option value="cash">نقدي</option>
                                        <option value="other">أخرى</option>
                                    </select>
                                </div>

                                <!-- اختيار المحفظة الإلكترونية -->
                                @if(isset($availableWallets) && $availableWallets->count() > 0)
                                <div id="wallet_selection" class="hidden">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-wallet text-sky-600 ml-2"></i>
                                        المحفظة الإلكترونية
                                    </label>
                                    <select name="wallet_id" id="wallet_id" 
                                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all">
                                        <option value="">اختر المحفظة الإلكترونية</option>
                                        @foreach($availableWallets as $wallet)
                                            <option value="{{ $wallet->id }}" 
                                                    data-type="{{ $wallet->type }}"
                                                    data-name="{{ $wallet->name }}"
                                                    data-account-number="{{ $wallet->account_number }}"
                                                    data-bank-name="{{ $wallet->bank_name }}"
                                                    data-account-holder="{{ $wallet->account_holder }}"
                                                    data-notes="{{ $wallet->notes }}">
                                                {{ $wallet->name ?? \App\Models\Wallet::typeLabel($wallet->type) }}
                                                @if($wallet->account_number)
                                                    - {{ $wallet->account_number }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- تفاصيل المحفظة المختارة -->
                                    <div id="wallet_details" class="hidden mt-4 p-4 bg-gradient-to-br from-sky-50 to-blue-50 dark:from-gray-700 dark:to-gray-800 rounded-xl border-2 border-sky-200 dark:border-gray-600">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                            <i class="fas fa-info-circle text-sky-600"></i>
                                            تفاصيل المحفظة للتحويل
                                        </h4>
                                        <div class="space-y-2 text-sm">
                                            <div id="wallet_type_detail" class="flex items-center justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">النوع:</span>
                                                <span class="font-semibold text-gray-900 dark:text-white" id="wallet_type_text"></span>
                                            </div>
                                            <div id="wallet_name_detail" class="hidden flex items-center justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">الاسم:</span>
                                                <span class="font-semibold text-gray-900 dark:text-white" id="wallet_name_text"></span>
                                            </div>
                                            <div id="wallet_account_detail" class="hidden flex items-center justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">رقم الحساب:</span>
                                                <span class="font-semibold text-gray-900 dark:text-white font-mono" id="wallet_account_text"></span>
                                            </div>
                                            <div id="wallet_bank_detail" class="hidden flex items-center justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">اسم البنك:</span>
                                                <span class="font-semibold text-gray-900 dark:text-white" id="wallet_bank_text"></span>
                                            </div>
                                            <div id="wallet_holder_detail" class="hidden flex items-center justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">صاحب الحساب:</span>
                                                <span class="font-semibold text-gray-900 dark:text-white" id="wallet_holder_text"></span>
                                            </div>
                                            <div id="wallet_notes_detail" class="hidden mt-3 pt-3 border-t border-sky-200 dark:border-gray-600">
                                                <span class="text-gray-600 dark:text-gray-400 block mb-1">ملاحظات:</span>
                                                <span class="text-sm text-gray-700 dark:text-gray-300" id="wallet_notes_text"></span>
                                            </div>
                                        </div>
                                        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                            <p class="text-xs text-yellow-800 dark:text-yellow-300 flex items-center gap-2">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                <span>يرجى التحويل على البيانات المذكورة أعلاه وإرفاق صورة الإيصال</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-image text-sky-600 ml-2"></i>
                                        صورة الإيصال
                                    </label>
                                    <input type="file" name="payment_proof" accept="image/*" required 
                                           class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        <i class="fas fa-info-circle ml-1"></i>
                                        ارفع صورة الإيصال أو الفاتورة
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-sticky-note text-sky-600 ml-2"></i>
                                        ملاحظات (اختياري)
                                    </label>
                                    <textarea name="notes" rows="3" 
                                              class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 dark:bg-gray-700 dark:text-white transition-all resize-none"
                                              placeholder="أي ملاحظات إضافية..."></textarea>
                                </div>

                                <button type="submit" class="w-full bg-gradient-to-l from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    إرسال الطلب
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleOrderForm() {
    const form = document.getElementById('orderForm');
    if (form) {
        form.classList.toggle('hidden');
        // Scroll to form smoothly
        if (!form.classList.contains('hidden')) {
            setTimeout(() => {
                form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }
    }
}

// إظهار/إخفاء اختيار المحفظة حسب طريقة الدفع
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethod = document.getElementById('payment_method');
    const walletSelection = document.getElementById('wallet_selection');
    const walletId = document.getElementById('wallet_id');
    const walletDetails = document.getElementById('wallet_details');

    if (paymentMethod && walletSelection) {
        paymentMethod.addEventListener('change', function() {
            // إظهار اختيار المحفظة إذا كانت طريقة الدفع تحويل بنكي أو أخرى
            if (this.value === 'bank_transfer' || this.value === 'other') {
                walletSelection.classList.remove('hidden');
            } else {
                walletSelection.classList.add('hidden');
                walletDetails.classList.add('hidden');
                walletId.value = '';
            }
        });

        // عرض تفاصيل المحفظة المختارة
        if (walletId && walletDetails) {
            walletId.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                if (this.value && selectedOption) {
                    // عرض التفاصيل
                    const type = selectedOption.getAttribute('data-type');
                    const name = selectedOption.getAttribute('data-name');
                    const accountNumber = selectedOption.getAttribute('data-account-number');
                    const bankName = selectedOption.getAttribute('data-bank-name');
                    const accountHolder = selectedOption.getAttribute('data-account-holder');
                    const notes = selectedOption.getAttribute('data-notes');

                    // تحديث النوع
                    const typeLabels = {
                        'vodafone_cash': 'فودافون كاش',
                        'instapay': 'إنستا باي',
                        'bank_transfer': 'تحويل بنكي',
                        'cash': 'كاش',
                        'other': 'أخرى'
                    };
                    document.getElementById('wallet_type_text').textContent = typeLabels[type] || type;

                    // إظهار/إخفاء الحقول حسب البيانات المتاحة
                    if (name) {
                        document.getElementById('wallet_name_detail').classList.remove('hidden');
                        document.getElementById('wallet_name_text').textContent = name;
                    } else {
                        document.getElementById('wallet_name_detail').classList.add('hidden');
                    }

                    if (accountNumber) {
                        document.getElementById('wallet_account_detail').classList.remove('hidden');
                        document.getElementById('wallet_account_text').textContent = accountNumber;
                    } else {
                        document.getElementById('wallet_account_detail').classList.add('hidden');
                    }

                    if (bankName) {
                        document.getElementById('wallet_bank_detail').classList.remove('hidden');
                        document.getElementById('wallet_bank_text').textContent = bankName;
                    } else {
                        document.getElementById('wallet_bank_detail').classList.add('hidden');
                    }

                    if (accountHolder) {
                        document.getElementById('wallet_holder_detail').classList.remove('hidden');
                        document.getElementById('wallet_holder_text').textContent = accountHolder;
                    } else {
                        document.getElementById('wallet_holder_detail').classList.add('hidden');
                    }

                    if (notes) {
                        document.getElementById('wallet_notes_detail').classList.remove('hidden');
                        document.getElementById('wallet_notes_text').textContent = notes;
                    } else {
                        document.getElementById('wallet_notes_detail').classList.add('hidden');
                    }

                    walletDetails.classList.remove('hidden');
                } else {
                    walletDetails.classList.add('hidden');
                }
            });
        }
    }

    // التحقق من الكوبون
    window.validateCoupon = function() {
        const couponCode = document.getElementById('coupon_code');
        const couponMessage = document.getElementById('couponMessage');
        const applyBtn = document.getElementById('applyCouponBtn');
        const coursePrice = parseFloat(document.getElementById('coursePrice')?.dataset.price || 0);
        const courseId = {{ $advancedCourse->id }};

        if (!couponCode || !couponCode.value.trim()) {
            couponMessage.classList.remove('hidden', 'text-green-600', 'text-red-600', 'bg-green-50', 'bg-red-50', 'border-green-200', 'border-red-200');
            couponMessage.classList.add('text-red-600', 'bg-red-50', 'dark:bg-red-900/20', 'border', 'border-red-200', 'dark:border-red-800', 'p-3', 'rounded-lg');
            couponMessage.innerHTML = '<i class="fas fa-exclamation-circle ml-2"></i> يرجى إدخال كود الكوبون';
            return;
        }

        // تعطيل الزر أثناء التحقق
        applyBtn.disabled = true;
        applyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التحقق...';
        couponMessage.classList.add('hidden');

        fetch('{{ route("api.validate-coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                coupon_code: couponCode.value.trim(),
                course_id: courseId
            })
        })
        .then(response => response.json())
        .then(data => {
            applyBtn.disabled = false;
            
            if (data.valid) {
                // عرض رسالة نجاح
                couponMessage.classList.remove('hidden', 'text-red-600', 'bg-red-50', 'border-red-200');
                couponMessage.classList.add('text-green-600', 'bg-green-50', 'dark:bg-green-900/20', 'border', 'border-green-200', 'dark:border-green-800', 'p-3', 'rounded-lg');
                couponMessage.innerHTML = '<i class="fas fa-check-circle ml-2"></i> ' + data.message;

                // حفظ الكوبون
                document.getElementById('applied_coupon_id').value = data.coupon.id;

                // تحديث السعر
                updatePriceDisplay(data.pricing);

                // تغيير زر التطبيق
                applyBtn.classList.remove('from-sky-600', 'to-sky-500', 'hover:from-sky-700', 'hover:to-sky-600');
                applyBtn.classList.add('from-green-600', 'to-green-500', 'hover:from-green-700', 'hover:to-green-600');
                applyBtn.innerHTML = '<i class="fas fa-check"></i> مطبق';
            } else {
                // عرض رسالة خطأ
                couponMessage.classList.remove('hidden', 'text-green-600', 'bg-green-50', 'border-green-200');
                couponMessage.classList.add('text-red-600', 'bg-red-50', 'dark:bg-red-900/20', 'border', 'border-red-200', 'dark:border-red-800', 'p-3', 'rounded-lg');
                couponMessage.innerHTML = '<i class="fas fa-exclamation-circle ml-2"></i> ' + data.message;

                // إعادة تعيين الكوبون
                document.getElementById('applied_coupon_id').value = '';
                resetPriceDisplay();
            }
        })
        .catch(error => {
            applyBtn.disabled = false;
            applyBtn.innerHTML = '<i class="fas fa-check"></i> تطبيق';
            
            couponMessage.classList.remove('hidden', 'text-green-600', 'bg-green-50', 'border-green-200');
            couponMessage.classList.add('text-red-600', 'bg-red-50', 'dark:bg-red-900/20', 'border', 'border-red-200', 'dark:border-red-800', 'p-3', 'rounded-lg');
            couponMessage.innerHTML = '<i class="fas fa-exclamation-circle ml-2"></i> حدث خطأ أثناء التحقق من الكوبون';
            console.error('Error:', error);
        });
    }

    // تحديث عرض السعر
    function updatePriceDisplay(pricing) {
        const originalPriceDisplay = document.getElementById('originalPriceDisplay');
        const finalPriceDisplay = document.getElementById('finalPriceDisplay');
        const discountAmountText = document.getElementById('discountAmountText');
        const discountPercentage = document.getElementById('discountPercentage');
        const discountPriceSection = document.querySelector('.discount-price');
        const originalPriceSection = document.querySelector('.original-price');

        if (discountPriceSection && originalPriceDisplay && finalPriceDisplay && discountAmountText && discountPercentage) {
            originalPriceDisplay.textContent = number_format(pricing.original_price) + ' ج.م';
            finalPriceDisplay.textContent = number_format(pricing.final_amount);
            discountAmountText.textContent = 'وفرت: ' + number_format(pricing.discount_amount) + ' ج.م';
            discountPercentage.textContent = '-' + pricing.discount_percentage + '%';

            // إخفاء السعر الأصلي وإظهار السعر بعد الخصم
            originalPriceSection.classList.add('hidden');
            discountPriceSection.classList.remove('hidden');
        }
    }

    // إعادة تعيين عرض السعر
    function resetPriceDisplay() {
        const discountPriceSection = document.querySelector('.discount-price');
        const originalPriceSection = document.querySelector('.original-price');
        const applyBtn = document.getElementById('applyCouponBtn');

        if (discountPriceSection && originalPriceSection) {
            originalPriceSection.classList.remove('hidden');
            discountPriceSection.classList.add('hidden');
        }

        // إعادة تعيين زر التطبيق
        if (applyBtn) {
            applyBtn.classList.remove('from-green-600', 'to-green-500', 'hover:from-green-700', 'hover:to-green-600');
            applyBtn.classList.add('from-sky-600', 'to-sky-500', 'hover:from-sky-700', 'hover:to-sky-600');
            applyBtn.innerHTML = '<i class="fas fa-check"></i> تطبيق';
        }
    }

    // تنسيق الأرقام
    function number_format(number) {
        return new Intl.NumberFormat('ar-EG').format(number);
    }

    // إعادة تعيين الكوبون عند تغيير الكود
    const couponInput = document.getElementById('coupon_code');
    if (couponInput) {
        couponInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                resetPriceDisplay();
                document.getElementById('applied_coupon_id').value = '';
                document.getElementById('couponMessage').classList.add('hidden');
            }
        });

        // تطبيق الكوبون عند الضغط على Enter
        couponInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                validateCoupon();
            }
        });
    }
});
</script>
@endsection


