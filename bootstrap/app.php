<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use function App\Helpers\isSerialized;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (RuntimeException $e, Request $request)
        {
            $unserializedData = isSerialized($e->getMessage())
                ? unserialize($e->getMessage(), ['allowed_classes' => false])
                : $e->getMessage();

            $body['status']['code'] = $e->getCode() ?? Response::HTTP_BAD_REQUEST;
            $body['status']['success'] = false;
            $body['status']['message'] = $unserializedData['message'] ?? $e->getMessage();

            if (! empty($unserializedData['errors']) ) {
                $body['status']['error'] = $unserializedData['errors'];
            }

            return response()->json(
                data: $body,
                status: Response::HTTP_BAD_REQUEST
            );
        });

        $exceptions->render(function (ValidationException $e) {
            $httpStatus = $e->status;
            $errors = $e->validator->errors()->toArray();
            $err = static function() use ($errors) {
                $return = [];
                foreach($errors as $key => $value) {
                    $return[] = [
                        'field' => $key,
                        'message' => $value[0]
                    ];
                }
                return $return;
            };

            $body['status']['success'] = false;
            $body['status']['code'] = $httpStatus;
            $body['status']['message'] = 'Validation Error Occurred';
            $body['status']['errors'] = $err();

            return response()->json(
                data: $body,
                status: 422
            );
        });
    })->create();
