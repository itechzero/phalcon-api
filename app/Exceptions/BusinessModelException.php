<?php
declare(strict_types=1);

namespace App\Exceptions;

use Phalcon\Mvc\Model\Exception;

class BusinessModelException extends BaseException
{
    const MODEL_ERROR = 2000;

    public static $msg = [
        self::MODEL_ERROR => 'model error',
    ];
}