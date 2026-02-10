<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_number',
        'invoice_id',
        'user_id',
        'payment_method',
        'payment_gateway',
        'wallet_id',
        'installment_payment_id',
        'amount',
        'currency',
        'status',
        'transaction_id',
        'reference_number',
        'gateway_response',
        'notes',
        'paid_at',
        'processed_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'gateway_response' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function installmentPayment()
    {
        return $this->belongsTo(InstallmentPayment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * توليد رقم دفعة فريد
     */
    public static function generatePaymentNumber(): string
    {
        $lastPayment = self::orderBy('id', 'desc')->first();
        
        if ($lastPayment && preg_match('/PAY-(\d+)/', $lastPayment->payment_number, $matches)) {
            $lastNumber = (int) $matches[1];
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $paymentNumber = 'PAY-' . str_pad($newNumber, 8, '0', STR_PAD_LEFT);
        
        // التحقق من عدم التكرار (في حالة race condition)
        $attempts = 0;
        while (self::where('payment_number', $paymentNumber)->exists() && $attempts < 10) {
            $newNumber++;
            $paymentNumber = 'PAY-' . str_pad($newNumber, 8, '0', STR_PAD_LEFT);
            $attempts++;
        }
        
        return $paymentNumber;
    }
}
