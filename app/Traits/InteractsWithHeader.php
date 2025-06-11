<?php

namespace App\Traits;

trait InteractsWithHeader
{
    public function basicToken(): ?string
    {
        $header = request()->header('Authorization');
        $position = strripos($header, 'Basic ');

        if ($position === false) {
            return null;
        }

        $header = substr($header, $position + 6);

        return $header ?: null;
    }

    public function decodeBasicToken(string $token): array|false
    {
        [$apiKey, $secretKey] =  explode(":", base64_decode($token));

        return isset($apiKey, $secretKey)
            ? ['api_key' => $apiKey, 'secret_key' => $secretKey]
            : false ;
    }
}
