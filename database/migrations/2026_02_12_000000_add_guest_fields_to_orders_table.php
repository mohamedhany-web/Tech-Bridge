<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('guest_name')->nullable()->after('user_id');
            $table->string('guest_email')->nullable()->after('guest_name');
            $table->string('guest_phone')->nullable()->after('guest_email');
        });

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql' && Schema::hasColumn('orders', 'user_id')) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE orders MODIFY user_id BIGINT UNSIGNED NULL');
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_email', 'guest_phone']);
        });
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE orders MODIFY user_id BIGINT UNSIGNED NOT NULL');
        }
    }
};
