<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseObserver
{
    /**
     * Handle the Expense "deleting" event.
     * يتم تنفيذ هذا قبل حذف المصروف
     */
    public function deleting(Expense $expense): void
    {
        try {
            DB::beginTransaction();

            // 1. إذا كان المصروف معتمداً ومرتبطاً بمحفظة، نرجع المبلغ للمحفظة
            if ($expense->status === 'approved' && $expense->wallet_id) {
                $wallet = Wallet::find($expense->wallet_id);
                if ($wallet) {
                    try {
                        // البحث عن WalletTransaction المرتبطة بهذا المصروف
                        $walletTransactions = WalletTransaction::where('wallet_id', $wallet->id)
                            ->where('type', 'withdrawal')
                            ->where('amount', $expense->amount)
                            ->whereNotNull('transaction_id')
                            ->get();
                        
                        // إرجاع المبلغ للمحفظة
                        $wallet->increment('balance', $expense->amount);
                        
                        // إنشاء معاملة إيداع جديدة لتسجيل الإرجاع
                        WalletTransaction::create([
                            'wallet_id' => $wallet->id,
                            'type' => 'deposit',
                            'amount' => $expense->amount,
                            'balance_after' => $wallet->balance,
                            'notes' => 'إرجاع مبلغ مصروف محذوف رقم: ' . $expense->expense_number . ' - ' . $expense->title,
                            'created_by' => auth()->id(),
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('فشل إرجاع المبلغ للمحفظة عند حذف المصروف: ' . $e->getMessage());
                        // لا نوقف العملية في حالة فشل تحديث المحفظة
                    }
                }
            }

            // 2. حذف المعاملات المالية المرتبطة بالمصروف
            $transactions = Transaction::where('expense_id', $expense->id)->get();
            foreach ($transactions as $transaction) {
                $transaction->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ في ExpenseObserver عند حذف المصروف: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            // نستمر في الحذف حتى لو فشلت العمليات الإضافية
        }
    }
}
