<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * جعل correct_answer و options يقبلان NULL للأسئلة المقالية واملأ الفراغ بدون إجابة نموذجية.
     */
    public function up(): void
    {
        if (!Schema::hasTable('questions')) {
            return;
        }

        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'correct_answer')) {
                $table->json('correct_answer')->nullable()->change();
            }
            if (Schema::hasColumn('questions', 'options')) {
                $table->json('options')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('questions')) {
            return;
        }

        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'correct_answer')) {
                $table->json('correct_answer')->nullable(false)->change();
            }
        });
    }
};
