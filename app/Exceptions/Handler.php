<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        'credit_card',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (QueryException $e) {
             if($e->getCode() == 23000){
                Log::channel('sql')->warning($e->getMessage());
                return false;
             }
        });

        $this->renderable(function (QueryException $e , Request $request) {
            if ($e->getCode() == 23000) {
                $message = 'Foreign key constraint failed';
            } else {
                $message = $e->getMessage();
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message'=> $message,
                ], 400);
            }

            return redirect()->back()->withInput()->withErrors([
                'message' => $e->getMessage(),
            ])
            ->with('info', $message);
        });
    }
}
