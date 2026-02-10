<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            // إضافة الأعمدة المفقودة
            if (!Schema::hasColumn('referrals', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->nullable()->after('reward_points');
            }
            
            if (!Schema::hasColumn('referrals', 'discount_used_count')) {
                $table->integer('discount_used_count')->default(0)->after('discount_amount');
            }
            
            if (!Schema::hasColumn('referrals', 'discount_expires_at')) {
                $table->dateTime('discount_expires_at')->nullable()->after('discount_used_count');
            }
            
            if (!Schema::hasColumn('referrals', 'referral_program_id')) {
                $table->foreignId('referral_program_id')->nullable()->constrained('referral_programs')->onDelete('set null')->after('id');
            }
            
            if (!Schema::hasColumn('referrals', 'code')) {
                $table->string('code')->nullable()->after('referral_code');
            }
            
            if (!Schema::hasColumn('referrals', 'commission_amount')) {
                $table->decimal('commission_amount', 10, 2)->nullable()->after('code');
            }
            
            if (!Schema::hasColumn('referrals', 'commission_type')) {
                $table->string('commission_type')->nullable()->after('commission_amount');
            }
            
            if (!Schema::hasColumn('referrals', 'paid_at')) {
                $table->dateTime('paid_at')->nullable()->after('commission_type');
            }
            
            if (!Schema::hasColumn('referrals', 'metadata')) {
                $table->json('metadata')->nullable()->after('paid_at');
            }
            
            if (!Schema::hasColumn('referrals', 'auto_coupon_id')) {
                $table->foreignId('auto_coupon_id')->nullable()->constrained('coupons')->onDelete('set null')->after('metadata');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropForeign(['referral_program_id']);
            $table->dropForeign(['auto_coupon_id']);
            $table->dropColumn([
                'discount_amount',
                'discount_used_count',
                'discount_expires_at',
                'referral_program_id',
                'code',
                'commission_amount',
                'commission_type',
                'paid_at',
                'metadata',
                'auto_coupon_id',
            ]);
        });
    }
};
