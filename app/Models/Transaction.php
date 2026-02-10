<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'user_id',
        'payment_id',
        'invoice_id',
        'expense_id',
        'subscription_id',
        'type',
        'category',
        'amount',
        'currency',
        'description',
        'status',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * توليد رقم معاملة مالية فريد
     */
    public static function generateTransactionNumber(): string
    {
        $lastTransaction = self::orderBy('id', 'desc')->first();
        
        if ($lastTransaction && preg_match('/TXN-(\d+)/', $lastTransaction->transaction_number, $matches)) {
            $lastNumber = (int) $matches[1];
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $transactionNumber = 'TXN-' . str_pad($newNumber, 8, '0', STR_PAD_LEFT);
        
        // التحقق من عدم التكرار (في حالة race condition)
        $attempts = 0;
        while (self::where('transaction_number', $transactionNumber)->exists() && $attempts < 10) {
            $newNumber++;
            $transactionNumber = 'TXN-' . str_pad($newNumber, 8, '0', STR_PAD_LEFT);
            $attempts++;
        }
        
        return $transactionNumber;
    }
}
