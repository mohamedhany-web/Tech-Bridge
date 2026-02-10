<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * جعل subject_id اختيارياً في بنك الأسئلة (بنك أسئلة المدرب قد لا يكون مرتبطاً بمادة).
     */
    public function up(): void
    {
        $tableName = 'question_banks';

        // الحصول على اسم المفتاح الأجنبي إن وُجد
        $fkName = DB::selectOne("
            SELECT CONSTRAINT_NAME as name
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = 'subject_id'
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$tableName]);

        if ($fkName && !empty($fkName->name)) {
            Schema::table($tableName, function (Blueprint $table) use ($fkName) {
                $table->dropForeign($fkName->name);
            });
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->nullable()->change();
        });

        // لا نعيد إضافة المفتاح الأجنبي لتجنب خطأ التوافق مع جدول subjects إن وُجد

        // قيمة افتراضية لـ difficulty لأن بنك أسئلة المدرب قد لا يحددها
        Schema::table($tableName, function (Blueprint $table) {
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableName = 'question_banks';

        $fkName = DB::selectOne("
            SELECT CONSTRAINT_NAME as name
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND COLUMN_NAME = 'subject_id'
              AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$tableName]);

        if ($fkName && !empty($fkName->name)) {
            Schema::table($tableName, function (Blueprint $table) use ($fkName) {
                $table->dropForeign($fkName->name);
            });
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->nullable(false)->change();
        });
    }
};
