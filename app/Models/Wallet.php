<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Wallet extends Model
{
    protected $fillable = [];

    protected $casts = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function ($wallet): void{
            $wallet->wallet_id = (string) Str::uuid();
        });
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class );
    }


}
