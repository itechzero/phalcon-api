<?php
declare(strict_types=1);

namespace App\Plugins;

use HttpRequest;

class RequestClient
{
    public static function httpGet()
    {
        return HttpRequest::get('',[]);
    }
}