<?php
declare(strict_types=1);

namespace App\Exceptions;

class BusinessException extends BaseException
{
    const HTTP_API_ERROR = 1000;
    const MQ_CONNECT_ERROR = 1001;

    public static $statusCode = [
        self::HTTP_API_ERROR => 200,
    ];

    public static $statusTexts = [
        self::HTTP_API_ERROR => 'api Error',
        self::MQ_CONNECT_ERROR => 'mq connect error',
    ];
}