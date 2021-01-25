<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * @inheritdoc}
     */
    protected $dontReport = [
        //
    ];

    /**
     * @inheritdoc}
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @inheritdoc}
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
