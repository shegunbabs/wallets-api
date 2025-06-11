<?php

declare(strict_types=1);

namespace App\Helpers;

function environment() {
}

function isSerialized(string $data): bool
{
    $data = trim($data);

    if ($data === 'N;') {
        return true; // serialized null
    }

    if (strlen($data) < 4) {
        return false;
    }

    if ($data[1] !== ':') {
        return false;
    }

    $lastc = substr($data, -1);
    if ($lastc !== ';' && $lastc !== '}') {
        return false;
    }

    // Attempt to unserialize
    $result = @unserialize($data, ['allowed_classes' => false]);
    return $result !== false || $data === 'b:0;';
}

function packageExceptionData(string $message, $errors = [], bool $serialized = true): array|string
{
    $return = [];
    $return['message'] = $message;

    if ( count($errors) === 0 ) {
//            return $serialized ? serialize($return) : $return;
        goto returnee;
    }



    foreach ($errors as $key => $value)
    {
        if ( is_array($value) ) {
            $return['errors'][] = $value;
            continue;
        }

        //$return['errors'][][$key] = $value;
        $return['errors'] = $errors;
        break;
    }
    returnee:
    return $serialized ? serialize($return) : $return;
}
