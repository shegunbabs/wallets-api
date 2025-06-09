<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property-read string $api_key
 * @property-read string $secret_hash
 * @property-read array $scopes
 * @property-read Carbon $last_used_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class ApiCredential extends Model
{
    protected $fillable = [
        'api_key', 'secret_hash'
    ];
    /**
     * @var string[]
     */
    protected $hidden = [
        'secret_hash'
    ];

    protected function casts(): array
    {
        return [
            'last_used_at' => 'timestamp',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
