<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * إضافة قيمة 'expense' لعمود category في جدول transactions (للموافقة على المصروفات).
     */
    public function up(): void
    {
        if (!\Schema::hasTable('transactions') || !\Schema::hasColumn('transactions', 'category')) {
            return;
        }

        DB::statement("ALTER TABLE transactions MODIFY COLUMN category ENUM(
            'course_payment',
            'subscription',
            'refund',
            'commission',
            'fee',
            'expense',
            'other'
        ) DEFAULT 'other'");
    }

    public function down(): void
    {
        if (!\Schema::hasTable('transactions') || !\Schema::hasColumn('transactions', 'category')) {
            return;
        }

        // تحويل أي معاملات من نوع expense إلى other قبل إزالة القيمة
        DB::table('transactions')->where('category', 'expense')->update(['category' => 'other']);

        DB::statement("ALTER TABLE transactions MODIFY COLUMN category ENUM(
            'course_payment',
            'subscription',
            'refund',
            'commission',
            'fee',
            'other'
        ) DEFAULT 'other'");
    }
};
