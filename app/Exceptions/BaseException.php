<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    public static $statusTexts = [
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    /**
     * BaseException constructor.
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {

    }
}