<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // if ($exception instanceof ValidationException) {
        //     return $this->convertValidationExceptionToResponse($exception, $request);
        // }

        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("Does not exists any {$modelName} with the specified identificator.", 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found', 404);
        }

        if ($exception instanceof MethodNotAllowedException) {
            return $this->errorResponse('The specified method for the request is invalid.', 405);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof QueryException) {
            // dd($exception);
            $errorCode = $exception->errorInfo[1];

            if ($errorCode == 1451) {
                return $this->errorResponse('Cannot remove this resource permanently. It is related with any other resource.', 409);
            }
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected Exception. Try alater', 500);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponse('Unauthenticated.', 401);

        // if ($request->expectsJson()) {
        //     return response()->json(['error' => 'Unauthenticated.'], 401);
        // }

        // return redirect()->guest('login');
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
        // if ($e->response) {
        //     return $e->response;
        // }

        // return $request->expectsJson()
        //     ? $this->invalidJson($request, $e)
        //     : $this->invalid($request, $e);
    }
}
