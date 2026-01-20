<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payment_code')->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('payment_method', ['bank_transfer', 'credit_card', 'e_wallet', 'cash']);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->text('description')->nullable();
            $table->string('reference_number')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};