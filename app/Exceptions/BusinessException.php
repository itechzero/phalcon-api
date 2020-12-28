<?php
declare(strict_types=1);

namespace App\Exceptions;

class BusinessException extends BaseException
{
    const HTTP_API_ERROR = 1000;
    const MQ_CONNECT_ERROR = 1001;
    const MQ_CHANNEL_ERROR = 1002;
    const MQ_EXCHANGE_ERROR = 1003;
    const MQ_QUEUE_ERROR = 1005;
    const MQ_PUBLISH_ERROR = 1006;

    public static $msg = [
        self::HTTP_API_ERROR => 'api error',
        self::MQ_CONNECT_ERROR => 'mq connect error',
        self::MQ_CHANNEL_ERROR => 'mq channel error',
        self::MQ_EXCHANGE_ERROR => 'mq exchange error',
        self::MQ_QUEUE_ERROR => 'mq queue error',
        self::MQ_PUBLISH_ERROR => 'mq publish error',
    ];

}