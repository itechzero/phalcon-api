<?php
declare(strict_types=1);

namespace App\Tools;

use HttpRequest;

class RequestClient
{
    public static function httpGet()
    {
        return HttpRequest::get('',[]);
    }
}