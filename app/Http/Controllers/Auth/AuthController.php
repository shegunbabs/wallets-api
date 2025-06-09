<?php

namespace App\Http\Controllers\Auth;

use App\Models\ApiCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function App\Helpers\packageExceptionData;

class AuthController
{
    public function store(Request $request)
    {
        $basicAuth = $request->header('Authorization');
        [,$encodedString] = explode(" ", $basicAuth);

        $exceptionData = packageExceptionData(
            message: 'Authentication failed.',
            errors: [['field' => 'key_error', 'message' => 'Key decode error']]
        );

        if ( empty($encodedString) ) {
            throw new \RuntimeException($exceptionData, 400);
        }

        [$apiKey, $secretKey] = explode(":", base64_decode($encodedString));
        $apiCredential = ApiCredential::query()->where('api_key', $apiKey)->first();

        $checkError = match (true) {
            is_null($apiCredential) => true,
            !Hash::check($secretKey, $apiCredential->secret_hash) => true,
            default => false,
        };

        if ($checkError) {
            throw new \RuntimeException($exceptionData, 400);
        }



        dd(
            $basicAuth,
            base64_decode($encodedString),
            $apiKey,
            $secretKey,
            $apiCredential,
            //Hash::check($secretKey, $apiCredential->secret_hash),
        );
        // validate form


        // verify user

        // create token for user
    }
}
