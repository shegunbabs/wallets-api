<?php

namespace App\Traits;

use function App\Helpers\packageExceptionData;

trait InteractsWithException
{
    protected function exceptionData(array $error): string
    {
        return packageExceptionData(
            message: $error['message'],
            errors: ['code' => $error['code'], 'message' => $error['code_message']]
        );
    }

}
