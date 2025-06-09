<?php

declare(strict_types=1);

namespace App\Helpers;

class ApiKeyGenerator
{
    private const API_KEY_LENGTH = 24;
    private const SECRET_KEY_LENGTH = 32;
    private string $env = '';


    public function __construct()
    {
        // cache environment here
        $this->env = (string) app()->environment();
    }

    public function generateApiKey(): string
    {
        $envPrefix = $this->apiKeyPrefix();
        $key = base64_encode(random_bytes(static::API_KEY_LENGTH));
        $key = strtr($key, "+/", "-_");
        $key = rtrim($key, "=");

        return $envPrefix.$key;
    }

    public function generateSecretKey(): string
    {
        $prefix = $this->secretKeyPrefix();
        return $prefix . bin2hex(random_bytes(static::SECRET_KEY_LENGTH));
    }
    public function generateKeyPair(): array
    {
        return [
            'api_key' => $this->generateApiKey(),
            'secret' => $this->generateSecretKey(),
        ];
    }

    private function apiKeyPrefix(): string
    {
        return match ($this->env) {
            'local' => 'ak_local_',
            'staging' => 'ak_staging_',
            default => 'ak_live_',
        };
    }

    private function secretKeyPrefix(): string
    {
        return match ($this->env) {
            'local' => 'sk_local_',
            'staging' => 'sk_staging_',
            default => 'sk_live_',
        };
    }


}
