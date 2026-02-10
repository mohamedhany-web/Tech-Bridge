<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    /**
     * Handle the Payment "deleting" event.
     * يتم تنفيذ هذا قبل حذف الدفعة
     */
    public function deleting(Payment $payment): void
    {
        try {
            DB::beginTransaction();

            // 1. حذف جميع المعاملات المالية المرتبطة بالدفعة مباشرة
            // المعاملات المالية المرتبطة بالدفعة يجب حذفها لأنها تمثل نفس العملية المالية
            $transactions = Transaction::where('payment_id', $payment->id)->get();
            
            foreach ($transactions as $transaction) {
                // حذف المعاملة المالية المرتبطة بالدفعة
                // لأنها تمثل نفس العملية المالية للدفعة المحذوفة
                $transaction->delete();
            }

            // 2. تحديث رصيد المحفظة وحذف WalletTransaction المرتبطة
            // نتحقق من وجود WalletTransaction مرتبطة بهذه الدفعة
            $walletTransactions = \App\Models\WalletTransaction::where('payment_id', $payment->id)->get();
            
            foreach ($walletTransactions as $walletTransaction) {
                // إذا كانت معاملة إيداع، نسحب المبلغ من المحفظة
                if ($walletTransaction->type === 'deposit' && $payment->status === 'completed') {
                    $wallet = Wallet::find($walletTransaction->wallet_id);
                    if ($wallet) {
                        try {
                            // سحب المبلغ الذي تم إيداعه سابقاً
                            if ($wallet->balance >= $walletTransaction->amount) {
                                $wallet->decrement('balance', $walletTransaction->amount);
                                
                                // إنشاء معاملة سحب جديدة لتسجيل العملية
                                \App\Models\WalletTransaction::create([
                                    'wallet_id' => $wallet->id,
                                    'type' => 'withdrawal',
                                    'amount' => $walletTransaction->amount,
                                    'balance_after' => $wallet->balance,
                                    'notes' => 'إلغاء دفعة محذوفة رقم: ' . $payment->payment_number,
                                    'created_by' => auth()->id(),
                                ]);
                            }
                        } catch (\Exception $e) {
                            Log::warning('فشل تحديث رصيد المحفظة عند حذف الدفعة: ' . $e->getMessage());
                            // لا نوقف العملية في حالة فشل تحديث المحفظة
                        }
                    }
                }
                
                // حذف WalletTransaction المرتبطة بالدفعة
                $walletTransaction->delete();
            }

            // 3. تحديث حالة الفاتورة
            if ($payment->invoice_id) {
                $invoice = Invoice::find($payment->invoice_id);
                if ($invoice) {
                    // إعادة حساب المبلغ المدفوع
                    $invoice->refresh();
                    
                    // إذا كانت الفاتورة مدفوعة بالكامل وكانت هذه الدفعة هي الأخيرة، نرجع الحالة
                    if ($invoice->isPaid() && $invoice->remaining_amount > 0) {
                        $invoice->update([
                            'status' => 'pending',
                            'paid_at' => null,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في PaymentObserver عند حذف الدفعة: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            // نستمر في الحذف حتى لو فشلت العمليات الإضافية
        }
    }
}
