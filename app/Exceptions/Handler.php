<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use TypeError;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    {
        // if ($e instanceof ValidationException) {
        //     if ($request->expectsJson()) {
        //         return response()->error(
        //             'Dữ liệu nhập không hợp lê.',
        //             Arr::first($e->errors()),
        //             Response::HTTP_UNPROCESSABLE_ENTITY
        //         );
        //     } else {
        //         return redirect()->back()->withInput()->withErrors($e->errors());
        //     }
        // }

        // if ($e instanceof NotFoundHttpException || $e instanceof MethodNotAllowedHttpException) {
        //     $route = $request->is('admin*') ? 'admin' : 'user';

        //     if ($request->is('admin*')) {
        //         return redirect()->route("admin.error.not_found");
        //     }

        //     return redirect()->route("{$route}.error.not_found");
        // }

        // if ($e instanceof TypeError || $e instanceof \Exception) {
        //     $route = $request->is('admin*') ? 'admin' : 'user';
        //     return redirect()->route("{$route}.error.error");
        // }

        return parent::render($request, $e);
    }
}
