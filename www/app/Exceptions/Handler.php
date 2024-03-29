<?php

namespace App\Exceptions;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Request;
use Throwable;


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

        $this->renderable(function (ModelNotFoundException $e, Request $request): JsonResponse {
            return response()->json(["message"=> "Cliente não encontrado"], Response::HTTP_NOT_FOUND);
        });
    }

    public function render($request, Throwable $e) {
        if ($e instanceof ModelNotFoundException) {
            return response()->json(["message"=> "Cliente não encontrado"], Response::HTTP_NOT_FOUND);
        }
        return parent::render($request, $e);
    }
}
