<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (env('APP_DEBUG')) {
          return parent::render($request, $exception);
        }

        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof HttpResponseException) {
          $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
          return response()->json([
               'code' => Response::HTTP_METHOD_NOT_ALLOWED,
               'message' => 'Метод не доступен',
               'data' => []
           ], Response::HTTP_METHOD_NOT_ALLOWED);
        } elseif ($exception instanceof NotFoundHttpException) {
          return response()->json([
               'code' => Response::HTTP_NOT_FOUND,
               'message' => 'Ничего не найдено',
               'data' => []
           ], Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof AuthorizationException) {
            return response()->json([
               'code' => Response::HTTP_FORBIDDEN,
               'message' => 'Доступ к ресурсу закрыт',
               'data' => []
           ], Response::HTTP_FORBIDDEN);
        } elseif($exception instanceof ValidationException) {
            return response()->json([
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Приведенные данные неверны',
                'errors' => $exception->validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } elseif ($exception) {
          $exception = new HttpException($status, 'Внутренняя ошибка сервера');
        }

        return response()->json([
          'code' => $status,
          'message' => $exception->getMessage(),
          'data' => []
        ], $status);
    }
}
