<?php

namespace App\Services;

use App\Enums\WalletStatusEnum;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function createWallet(
        string $ownerId,
        string $ownerType,
        string $currency,
        string $walletType,
        array $metadata = [],
    ): Wallet
    {
        return DB::transaction(
            static function () use ($metadata, $walletType, $currency, $ownerType, $ownerId) {

                $wallet = new Wallet([
                    'owner_id' => $ownerId,
                    'owner_type' => $ownerType,
                    'currency' => $currency,
                    'wallet_type' => $walletType,
                    'metadata' => $metadata ?? [],
                    'status' => WalletStatusEnum::ACTIVE->value,
                ]);

                $wallet->save();

                // log activity here

                return $wallet;
            }
        );
    }
}
