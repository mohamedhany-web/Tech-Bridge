@extends('layouts.app')

@section('title', 'تفاصيل الفاتورة')
@section('header', 'تفاصيل الفاتورة')

@section('content')
<div class="space-y-10 invoice-print-wrapper">
    <section class="rounded-3xl bg-white/95 dark:bg-slate-900/80 backdrop-blur border border-slate-200 dark:border-slate-800 shadow-lg overflow-hidden">
        <div class="px-5 py-6 sm:px-8 lg:px-12 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between" data-print-hide>
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 dark:text-slate-500">فاتورة رقم</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">#{{ $invoice->invoice_number }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">أُنشئت في {{ $invoice->created_at->format('Y-m-d') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.invoices.edit', $invoice) }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-sky-300 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200 dark:hover:border-sky-500 dark:hover:text-sky-300">
                    <i class="fas fa-edit"></i>
                    تعديل الفاتورة
                </a>
                <button type="button" onclick="window.printInvoice()" class="inline-flex items-center gap-2 rounded-2xl bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:focus:ring-offset-slate-900">
                    <i class="fas fa-print"></i>
                    طباعة الفاتورة
                </button>
                <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800/70">
                    <i class="fas fa-arrow-right"></i>
                    العودة
                </a>
            </div>
        </div>

        <div id="invoice-print-area" class="px-5 py-6 sm:px-8 lg:px-12 space-y-10">
            <div class="flex flex-col gap-6 rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70 print-card">
                <div class="flex flex-col items-start gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Tech Bridge</p>
                        <h1 class="mt-2 text-2xl font-bold text-slate-900">أكاديمية البرمجة</h1>
                        <p class="text-sm text-slate-500">support@techbridge.academy · 0500 000 000</p>
                    </div>
                    <div class="text-sm text-slate-500 text-left md:text-right">
                        <p><span class="text-slate-400">رقم الفاتورة:</span> <span class="font-semibold text-slate-900">#{{ $invoice->invoice_number }}</span></p>
                        <p><span class="text-slate-400">تاريخ الإنشاء:</span> <span class="font-semibold text-slate-900">{{ $invoice->created_at->format('Y-m-d') }}</span></p>
                        <p><span class="text-slate-400">تاريخ الطباعة:</span> <span class="font-semibold text-slate-900">{{ now()->format('Y-m-d H:i') }}</span></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50/60 p-5 text-sm text-slate-600 dark:bg-slate-900/60 dark:text-slate-300 print-strip">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-3">بيانات العميل</h3>
                        <dl class="space-y-2">
                            <div class="flex justify-between gap-6"><dt>الاسم</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $invoice->user->name ?? 'غير معروف' }}</dd></div>
                            <div class="flex justify-between gap-6"><dt>رقم الهاتف</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $invoice->user->phone ?? '—' }}</dd></div>
                            <div class="flex justify-between gap-6"><dt>البريد الإلكتروني</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $invoice->user->email ?? '—' }}</dd></div>
                            <div class="flex justify-between gap-6"><dt>نوع الفاتورة</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $invoice->type }}</dd></div>
                        </dl>
                    </div>
                    <div class="rounded-2xl bg-slate-50/60 p-5 text-sm text-slate-600 dark:bg-slate-900/60 dark:text-slate-300 print-strip">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white mb-3">حالة الفاتورة</h3>
                        <dl class="space-y-2">
                            <div class="flex justify-between gap-6"><dt>الحالة</dt><dd>
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold status-badge" data-status="{{ $invoice->status }}">
                                    <span class="h-2 w-2 rounded-full bg-current"></span>
                                    {{ $invoice->status === 'paid' ? 'مدفوعة' : ($invoice->status === 'pending' ? 'معلقة' : 'متأخرة') }}
                                </span>
                            </dd></div>
                            <div class="flex justify-between gap-6"><dt>تاريخ الاستحقاق</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '—' }}</dd></div>
                            <div class="flex justify-between gap-6"><dt>آخر تحديث</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $invoice->updated_at->format('Y-m-d H:i') }}</dd></div>
                            <div class="flex justify-between gap-6"><dt>ملاحظات</dt><dd class="font-semibold text-slate-900 dark:text-white">{{ $invoice->notes ?: '—' }}</dd></div>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70 print-card">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">ملخص الرسوم</h3>
                <table class="mt-4 w-full text-sm text-slate-600 dark:text-slate-300">
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        <tr class="flex items-center justify-between py-3">
                            <td>المبلغ الفرعي</td>
                            <td class="font-semibold text-slate-900 dark:text-white">{{ number_format($invoice->subtotal, 2) }} ج.م</td>
                        </tr>
                        @if ($invoice->tax_amount > 0)
                            <tr class="flex items-center justify-between py-3">
                                <td>الضريبة</td>
                                <td class="font-semibold text-slate-900 dark:text-white">{{ number_format($invoice->tax_amount, 2) }} ج.م</td>
                            </tr>
                        @endif
                        @if ($invoice->discount_amount > 0)
                            <tr class="flex items-center justify-between py-3">
                                <td>الخصم</td>
                                <td class="font-semibold text-rose-600 dark:text-rose-300">-{{ number_format($invoice->discount_amount, 2) }} ج.م</td>
                            </tr>
                        @endif
                        <tr class="flex items-center justify-between py-3 text-lg font-bold text-slate-900 dark:text-white">
                            <td>الإجمالي المستحق</td>
                            <td class="text-sky-600 dark:text-sky-300">{{ number_format($invoice->total_amount, 2) }} ج.م</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($invoice->payments && $invoice->payments->count() > 0)
                <div class="rounded-2xl border border-slate-200 bg-white/85 p-6 dark:border-slate-800 dark:bg-slate-900/70 print-card">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">سجل المدفوعات</h3>
                    <table class="mt-4 w-full text-sm text-slate-600 dark:text-slate-300">
                        <thead>
                            <tr class="grid grid-cols-3 gap-4 border-b border-slate-200 pb-3 text-xs uppercase tracking-widest text-slate-400 dark:border-slate-700">
                                <th class="text-right">رقم الدفعة</th>
                                <th class="text-center">تاريخ الدفع</th>
                                <th class="text-left">المبلغ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @foreach ($invoice->payments as $payment)
                                <tr class="grid grid-cols-3 items-center gap-4 py-3">
                                    <td class="text-right font-semibold text-slate-900 dark:text-white">{{ $payment->payment_number }}</td>
                                    <td class="text-center">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d') : '—' }}</td>
                                    <td class="text-left font-semibold text-slate-900 dark:text-white">{{ number_format($payment->amount, 2) }} ج.م</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
</div>

@push('styles')
<style>
    .print-strip { border: 1px solid rgba(226, 232, 240, 0.6); }
    .status-badge[data-status="paid"] { background: rgba(34, 197, 94, 0.18) !important; color: #15803d !important; }
    .status-badge[data-status="pending"] { background: rgba(245, 158, 11, 0.18) !important; color: #b45309 !important; }
    .status-badge[data-status="overdue"],
    .status-badge[data-status="unpaid"],
    .status-badge[data-status="cancelled"] { background: rgba(248, 113, 113, 0.18) !important; color: #b91c1c !important; }
    @media print {
        body * { visibility: hidden; }
        .invoice-print-wrapper, .invoice-print-wrapper * { visibility: visible; }
        .invoice-print-wrapper { position: absolute; left: 0; top: 0; width: 100%; }
        [data-print-hide] { display: none !important; }
    }
</style>
@endpush

@push('scripts')
<script>
    window.printInvoice = function () {
        var printArea = document.getElementById('invoice-print-area');
        if (!printArea) return;

        var printDate = new Date().toLocaleString('ar-EG', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' });
        var bodyHtml = '<div class="invoice-print-container">' +
            '<header class="invoice-print-header">' +
            '<div><p class="brand-label">Tech Bridge</p><h1>أكاديمية البرمجة</h1><p class="brand-meta">support@techbridge.academy · 0500 000 000</p></div>' +
            '<div class="invoice-meta">' +
            '<p><span>رقم الفاتورة:</span> #{{ $invoice->invoice_number }}</p>' +
            '<p><span>تاريخ الإنشاء:</span> {{ $invoice->created_at->format('Y-m-d') }}</p>' +
            '<p><span>تاريخ الطباعة:</span> ' + printDate + '</p>' +
            '</div></header>' +
            '<main class="invoice-print-body">' + printArea.innerHTML + '</main>' +
            '<footer class="invoice-print-footer"><p>توقيع الإدارة</p><p class="signature-line"></p></footer>' +
            '</div>';

        var printCss = '@page { size: A4 portrait; margin: 12mm 15mm; }' +
            'body { font-family: system-ui, sans-serif; color: #0f172a; background: #fff; margin: 0; padding: 0; }' +
            '.invoice-print-container { max-width: 760px; margin: 0 auto; padding: 16px; }' +
            '.invoice-print-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; border-bottom: 1px solid #d8e3f0; padding-bottom: 16px; margin-bottom: 24px; }' +
            '.invoice-meta p { margin: 0 0 4px 0; font-size: 12px; color: #334155; }' +
            '.invoice-meta span { font-weight: 600; color: #0f172a; }' +
            '.brand-label { text-transform: uppercase; letter-spacing: 4px; font-size: 11px; color: #64748b; margin: 0 0 4px 0; }' +
            '.brand-meta { font-size: 12px; color: #475569; margin: 4px 0 0 0; }' +
            '.invoice-print-body { display: flex; flex-direction: column; gap: 20px; }' +
            '.invoice-print-body .print-card { border: 1px solid #d9e3f0; background: #fff; border-radius: 12px; padding: 18px 22px; }' +
            '.invoice-print-body .print-strip { border: 1px solid #d9e3f0; background: #f8fafc; border-radius: 12px; padding: 18px 22px; }' +
            '.invoice-print-body h3 { margin: 0 0 12px 0; font-size: 16px; }' +
            '.invoice-print-body table { width: 100%; border-collapse: collapse; }' +
            '.invoice-print-body thead { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #64748b; }' +
            '.invoice-print-body tbody tr { border-bottom: 1px solid #eef2f7; }' +
            '.invoice-print-body td, .invoice-print-body th { padding: 8px 0; font-size: 13px; }' +
            '.invoice-print-footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #d8e3f0; font-size: 12px; color: #475569; }' +
            '.signature-line { margin-top: 12px; width: 180px; height: 1px; background: #cbd5f5; }';

        var fullDoc = '<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><title>فاتورة {{ $invoice->invoice_number }}</title><style>' + printCss + '</style></head><body>' + bodyHtml + '</body></html>';

        var printWindow = window.open('', '_blank');
        if (!printWindow) {
            document.body.classList.add('printing-invoice');
            window.print();
            document.body.classList.remove('printing-invoice');
            return;
        }
        printWindow.document.open();
        printWindow.document.write(fullDoc);
        printWindow.document.close();

        function doPrint() {
            try {
                printWindow.focus();
                printWindow.print();
            } catch (e) {}
            setTimeout(function () { try { printWindow.close(); } catch (e) {} }, 800);
        }
        if (printWindow.document.readyState === 'complete') {
            doPrint();
        } else {
            printWindow.onload = doPrint;
        }
    };
</script>
@endpush
@endsection

