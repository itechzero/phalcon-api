<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * BaseException constructor.
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {

    }
}