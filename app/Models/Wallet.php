<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property-read string $wallet_id
 * @property-read string $owner_id
 * @property-read string $currency
 * @property-read float $balance
 * @property-read float $available_balance
 * @property-read float $held_balance
 * @property-read string $status
 * @property-read int $version
 * @property-read string $wallet_type
 * @property-read array $metadata
 * @property-read Carbon $last_activity
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $deleted_at
 */
class Wallet extends Model
{
    protected $fillable = [];

    protected $casts = [
        'available_balance' => 'float',
        'balance' => 'float',
        'held_balance' => 'float',
        'metadata' => 'array'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (Wallet $wallet): void {
            $wallet->wallet_id = (string) Str::uuid();
        });
    }

    /**
     * @return HasMany<WalletTransaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
