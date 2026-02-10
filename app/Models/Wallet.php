<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'account_number',
        'bank_name',
        'account_holder',
        'notes',
        'is_active',
        'balance',
        'pending_balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * خريطة أنواع المحافظ
     */
    public static function typeLabels(): array
    {
        return [
            'vodafone_cash' => 'فودافون كاش',
            'instapay' => 'إنستا باي',
            'bank_transfer' => 'تحويل بنكي',
            'cash' => 'كاش',
            'other' => 'أخرى',
        ];
    }

    /**
     * الحصول على تسمية نوع محدد
     */
    public static function typeLabel(?string $type): string
    {
        if ($type === null || $type === '') {
            return 'غير محدد';
        }

        return static::typeLabels()[$type] ?? $type;
    }

    /**
     * العلاقة مع المعاملات
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع التقارير
     */
    public function reports()
    {
        return $this->hasMany(WalletReport::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * إيداع مبلغ
     */
    public function deposit($amount, $paymentId = null, $transactionId = null, $notes = null)
    {
        $balanceBefore = $this->balance;
        $this->increment('balance', $amount);
        
        $data = [
            'wallet_id' => $this->id,
            'type' => 'deposit',
            'amount' => $amount,
            'balance_after' => $this->balance,
        ];
        
        // إضافة الأعمدة فقط إذا كانت موجودة في الجدول
        if (\Schema::hasColumn('wallet_transactions', 'payment_id')) {
            $data['payment_id'] = $paymentId;
        }
        
        if (\Schema::hasColumn('wallet_transactions', 'transaction_id')) {
            $data['transaction_id'] = $transactionId;
        }
        
        if (\Schema::hasColumn('wallet_transactions', 'balance_before')) {
            $data['balance_before'] = $balanceBefore;
        }
        
        if (\Schema::hasColumn('wallet_transactions', 'notes')) {
            $data['notes'] = $notes;
        } elseif (\Schema::hasColumn('wallet_transactions', 'description')) {
            $data['description'] = $notes ?? 'إيداع';
        }
        
        if (\Schema::hasColumn('wallet_transactions', 'created_by') && auth()->check()) {
            $data['created_by'] = auth()->id();
        }
        
        return WalletTransaction::create($data);
    }

    /**
     * سحب مبلغ
     */
    public function withdraw($amount, $notes = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('رصيد المحفظة غير كافي');
        }

        $balanceBefore = $this->balance;
        $this->decrement('balance', $amount);
        
        $data = [
            'wallet_id' => $this->id,
            'type' => 'withdrawal',
            'amount' => $amount,
            'balance_after' => $this->balance,
        ];
        
        // إضافة الأعمدة فقط إذا كانت موجودة في الجدول
        if (\Schema::hasColumn('wallet_transactions', 'balance_before')) {
            $data['balance_before'] = $balanceBefore;
        }
        
        if (\Schema::hasColumn('wallet_transactions', 'notes')) {
            $data['notes'] = $notes;
        } elseif (\Schema::hasColumn('wallet_transactions', 'description')) {
            $data['description'] = $notes ?? 'سحب';
        }
        
        if (\Schema::hasColumn('wallet_transactions', 'created_by') && auth()->check()) {
            $data['created_by'] = auth()->id();
        }
        
        return WalletTransaction::create($data);
    }

    /**
     * الحصول على نوع المحفظة بالعربية
     */
    public function getTypeNameAttribute()
    {
        return static::typeLabel($this->type);
    }

    /**
     * حساب الرصيد الفعلي بناءً على جميع المعاملات
     * هذه الدالة تحسب الرصيد من الصفر بناءً على جميع WalletTransactions
     */
    public function calculateBalanceFromTransactions(): float
    {
        $deposits = $this->transactions()
            ->where('type', 'deposit')
            ->sum('amount');
        
        $withdrawals = $this->transactions()
            ->where('type', 'withdrawal')
            ->sum('amount');
        
        return $deposits - $withdrawals;
    }

    /**
     * مزامنة الرصيد مع المعاملات
     * تستخدم لإصلاح أي اختلافات بين الرصيد المحفوظ والرصيد المحسوب
     */
    public function syncBalance(): bool
    {
        $calculatedBalance = $this->calculateBalanceFromTransactions();
        
        if (abs($this->balance - $calculatedBalance) > 0.01) {
            $this->balance = $calculatedBalance;
            return $this->save();
        }
        
        return true;
    }
}
