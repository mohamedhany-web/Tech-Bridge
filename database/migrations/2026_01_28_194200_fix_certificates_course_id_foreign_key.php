<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('certificates')) {
            return;
        }

        // حذف Foreign Key القديم إذا كان موجوداً
        try {
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'certificates' 
                AND COLUMN_NAME = 'course_id'
                AND REFERENCED_TABLE_NAME = 'courses'
            ");
            
            foreach ($foreignKeys as $fk) {
                DB::statement("ALTER TABLE certificates DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
            }
        } catch (\Exception $e) {
            // Foreign key غير موجود أو تم حذفه بالفعل
        }

        // إضافة Foreign Key الجديد إلى advanced_courses
        try {
            DB::statement("
                ALTER TABLE certificates 
                ADD CONSTRAINT certificates_course_id_foreign 
                FOREIGN KEY (course_id) 
                REFERENCES advanced_courses(id) 
                ON DELETE SET NULL
            ");
        } catch (\Exception $e) {
            // Foreign key موجود بالفعل أو حدث خطأ
            // قد يكون موجوداً بالفعل من migration سابق
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('certificates')) {
            return;
        }

        // حذف Foreign Key الجديد
        try {
            DB::statement("ALTER TABLE certificates DROP FOREIGN KEY certificates_course_id_foreign");
        } catch (\Exception $e) {
            // Foreign key غير موجود
        }

        // إعادة Foreign Key القديم (إذا كان موجوداً)
        try {
            DB::statement("
                ALTER TABLE certificates 
                ADD CONSTRAINT certificates_course_id_foreign 
                FOREIGN KEY (course_id) 
                REFERENCES courses(id) 
                ON DELETE CASCADE
            ");
        } catch (\Exception $e) {
            // لا يمكن إعادة الإنشاء
        }
    }
};
