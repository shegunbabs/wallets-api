<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'available_balance' => $this->available_balance,
            'balance' => $this->balance,
            'currency' => $this->currency,
            'held_balance' => $this->held_balance,
            'owner_id' => $this->owner_id,
            'status' => $this->status,
            'wallet_id' => $this->wallet_id,
            'wallet_type' => $this->wallet_type,
            'metadata' => $this->metadata,
        ];
    }
}
