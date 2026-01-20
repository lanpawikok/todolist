<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Cek apakah kolom belum ada sebelum menambahkan
            if (!Schema::hasColumn('tasks', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('due_date');
            }
            
            if (!Schema::hasColumn('tasks', 'status')) {
                $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending')->after('priority');
            }
            
            if (!Schema::hasColumn('tasks', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('user_id')->constrained('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['priority', 'status', 'created_by']);
        });
    }
};