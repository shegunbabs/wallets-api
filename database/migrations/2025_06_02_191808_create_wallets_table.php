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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->uuid('wallet_id')->unique(); // user id maybe
            $table->string('owner_id'); // User, Company, System, etc
            $table->string('currency', 3);
            $table->decimal('balance', 19, 2)->default(0);
            $table->decimal('available_balance', 19, 2)->default(0);
            $table->decimal('held_balance', 19, 2)->default(0);
            $table->string('status')->default('active'); // active, frozen, closed, suspended
            $table->unsignedBigInteger('version')->default(1);
            $table->string('wallet_type')->default('primary'); // primary, escrow, settlement | primary, prepaid (gift cards), credit
            $table->json('metadata')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['owner_id', 'owner_type']);
            $table->index('status');
            $table->index('wallet_type');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
