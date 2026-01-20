<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Tambahkan kolom status
            $table->enum('status', ['pending', 'in_progress', 'completed'])
                  ->default('pending')
                  ->after('priority');
        });

        // Migrate data dari is_completed ke status (jika kolom is_completed ada)
        if (Schema::hasColumn('tasks', 'is_completed')) {
            DB::table('tasks')->where('is_completed', true)->update(['status' => 'completed']);
            DB::table('tasks')->where('is_completed', false)->update(['status' => 'pending']);
            
            // Hapus kolom is_completed (optional)
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn('is_completed');
            });
        }
    }

    public function down(): void
    {
        // Restore kolom is_completed
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('is_completed')->default(false)->after('status');
        });

        // Migrate data kembali
        DB::table('tasks')->where('status', 'completed')->update(['is_completed' => true]);
        DB::table('tasks')->whereIn('status', ['pending', 'in_progress'])->update(['is_completed' => false]);

        // Hapus kolom status
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};