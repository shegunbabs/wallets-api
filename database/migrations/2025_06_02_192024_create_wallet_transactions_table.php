<?php

declare(strict_types=1);

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
        Schema::create('wallet_transactions', function (Blueprint $table): void {
            $table->id();
            $table->uuid('transaction_id')->unique();
            $table->foreignId('wallet_id')->constrained();
            $table->string('idempotency_key')->unique();
            $table->decimal('amount', 19, 2);
            $table->string('type'); // credit, debit, hold, release
            $table->string('status'); // pending, completed, failed, reversed
            $table->decimal('balance_before', 19, 2);
            $table->decimal('balance_after', 19, 2);
            $table->decimal('available_balance_before', 19, 2);
            $table->decimal('available_balance_after', 19, 2);
            $table->string('currency', 3);
            $table->string('reference')->unique();
            $table->string('description');
            $table->string('source'); // api, system, manual
            $table->json('metadata')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->uuid('initiated_by')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['wallet_id', 'type', 'status']);
            $table->index('idempotency_key');
            $table->index('type');
            $table->index('processed_at');
            $table->index(['created_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
