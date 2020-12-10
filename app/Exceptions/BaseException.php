<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    protected $message;

    protected $code;

    const HTTP_OK = 200;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    public static $statusCode = [
        self::HTTP_OK => 200,
        self::HTTP_BAD_REQUEST => 400,
        self::HTTP_NOT_FOUND => 404,
        self::HTTP_INTERNAL_SERVER_ERROR => 500,
    ];

    public static $statusTexts = [
        self::HTTP_OK => 'OK',
        self::HTTP_BAD_REQUEST => 'Bad Request',
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
    ];


    /**
     * BaseException constructor.
     */
    public function __construct(int $code = 0, $message = "", Throwable $previous = null)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public static function getStatusCode($code)
    {
        return isset(static::$statusCode[$code]) ? static::$statusCode[$code] : self::HTTP_BAD_REQUEST;
    }

}