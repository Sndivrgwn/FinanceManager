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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('from_wallet_id')
                ->constrained('wallets')
                ->restrictOnDelete();

            $table->foreignId('to_wallet_id')
                ->constrained('wallets')
                ->restrictOnDelete();

            $table->decimal('amount', 15, 2);

            $table->text('description')->nullable();

            $table->date('transfer_date');

            $table->timestamps();

            $table->index(['user_id', 'transfer_date']);
            $table->index('from_wallet_id');
            $table->index('to_wallet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};