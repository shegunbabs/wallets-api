<?php

namespace App\Services;

class ErrorType
{
    public const KEY_DECODE_ERROR = [
        'message' => 'Authentication failed.',
        'code' => 'KEY_DECODE_ERROR',
        'code_message' => 'Error decoding keys',
    ];
}
