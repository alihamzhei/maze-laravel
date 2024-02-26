<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use App\Facades\Response as ResponseFacade;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
            $message = Response::$statusTexts[$statusCode];

            return ResponseFacade::message($message)
                ->send($statusCode);
        }

        if ($e instanceof ModelNotFoundException) {
            return ResponseFacade::message('global.errors.not_found')
                ->send(Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof BadRequestException) {
            return ResponseFacade::message($e->getMessage())
                ->send(Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof AuthorizationException) {
            return ResponseFacade::message($e->getMessage())
                ->send(Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof UnauthorizedException) {
            return ResponseFacade::message($e->getMessage())
                ->send(Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof AuthenticationException) {
            return ResponseFacade::message($e->getMessage())
                ->send(Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof ValidationException) {
            $errors = $e->validator->errors()->messages();

            return ResponseFacade::errors($errors)
                ->message($e->getMessage())
                ->send(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($e instanceof ClientException) {
            $errors = $e->getResponse()->getBody();
            $code = $e->getCode();

            return ResponseFacade::errors($errors)
                ->send($code);
        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $e);
        }

        return ResponseFacade::message('Unexpected Error , try later please')
            ->send(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
