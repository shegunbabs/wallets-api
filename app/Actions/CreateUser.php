<?php

namespace App\Actions;

use App\DTOs\UserData;
use App\Helpers\ApiKeyGenerator;
use App\Models\ApiCredential;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function __construct(private ApiKeyGenerator $keyGenerator)
    {

    }
    /**
     * @return array{user:User, secret_key:string}
     * @throws \Throwable
     */
    public function handle(UserData $userData): array
    {
        return DB::transaction(
            function() use ($userData) {
                $user = User::query()->create([
                    'name' => $userData->name,
                    'email' => $userData->email,
                    'password' => Hash::make($userData->password),
                ]);

                $api_key = $this->keyGenerator->generateApiKey();
                $secret_key = $this->keyGenerator->generateSecretKey();

                $apiCredentials = new ApiCredential([
                    'api_key' => $api_key,
                    'secret_hash' => Hash::make($secret_key),
                ]);
                $user->apiCredentials()->save($apiCredentials);

                return [
                    'user' => $user,
                    'secret_key' => $secret_key,
                ];
            }
        );


    }
}
