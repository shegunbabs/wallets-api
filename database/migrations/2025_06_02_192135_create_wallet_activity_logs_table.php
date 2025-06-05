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
        Schema::create('wallet_activity_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('wallet_id')->constrained();
            $table->string('action'); // created, credited, debited, frozen, closed.
            $table->json('details');
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->uuid('performed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_activity_logs');
    }
};
