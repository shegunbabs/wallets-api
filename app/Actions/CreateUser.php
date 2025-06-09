<?php

namespace App\Actions;

use App\DTOs\UserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function handle(UserData $userData): User
    {
        return User::query()->create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => Hash::make($userData->password),
        ]);
    }
}
