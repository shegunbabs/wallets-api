<?php

namespace App\Http\Controllers\Auth;

use App\Models\ApiCredential;
use App\Models\User;
use App\Services\ErrorType;
use App\Traits\InteractsWithException;
use App\Traits\InteractsWithHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function App\Helpers\packageExceptionData;

class AuthController
{
    use InteractsWithHeader;
    use InteractsWithException;

    public function store(Request $request)
    {
        $basicToken = $this->basicToken();

        if (! isset($basicToken)) {
            throw new \RuntimeException(
                $this->exceptionData(ErrorType::KEY_DECODE_ERROR),
                400
            );
        }

        ['api_key' => $apiKey, 'secret_key' => $secretKey] = $this->decodeBasicToken($basicToken);

        if (! isset($apiKey, $secretKey)) {
            throw new \RuntimeException(
                $this->exceptionData(ErrorType::KEY_DECODE_ERROR),
                400
            );
        }

        $apiCredential = ApiCredential::query()->where('api_key', $apiKey)->first();
        $user = User::query()->whereRelation('apiCredential', 'api_key', $apiKey)->first();

        $authCheck = match (true) {
            is_null($apiCredential) => true,
            !Hash::check($secretKey, $apiCredential->secret_hash) => true,
            default => false,
        };

        if ($authCheck) {
            throw new \RuntimeException(
                $this->exceptionData(ErrorType::KEY_DECODE_ERROR),
                400
            );
        }

        $token = $user->createToken(
            $request->get('token_name', Str::slug($user->name))
        );


        // create token for user
        return response()->json(
            [
                'status' => [
                    "code" => 200,
                    "success" => true,
                    "message" => "Token generated successfully",
                ],
                "data" => [
                    "access_token" => $token->plainTextToken,
                ]
            ],
        );
    }
}
