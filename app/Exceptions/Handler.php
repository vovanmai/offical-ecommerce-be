<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use TypeError;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {dd($e);
        return match (true) {
            $e instanceof AuthenticationException => $this->unauthenticated($request, $e),
            $e instanceof ModelNotFoundException => $this->notFound(),
            $e instanceof BadRequestException => $this->badRequest($e),
            $e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
            default => $this->renderExceptionResponse($request, $e),
        };

        return parent::render($request, $e);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        $errors = $exception->errors();
        foreach ($errors as &$error) {
            $error = $error[0];
        }
        return response()->error(
            'Dữ liệu đầu vào không hợp lệ.',
            $errors,
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    protected function notFound()
    {
        return response()->error(
            'Không tìm thấy trang.',
            [],
            Response::HTTP_NOT_FOUND
        );
    }

    protected function badRequest($ex)
    {
        return response()->error(
            $ex->getMessage(),
            [],
            Response::HTTP_BAD_REQUEST
        );
    }
}
