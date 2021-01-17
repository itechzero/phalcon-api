<?php
declare(strict_types=1);

use App\Exceptions\BaseException;

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        if (empty($vars)) {
            var_dump('no thing to dd');
        }

        foreach ($vars as $row) {
            var_dump($row);
        }
        die;
    }
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        if (defined($key)) {
            return constant($key);
        }

        return getenv($key) ?: $default;
    }
}

if (!function_exists('milliSecondTimeStamp')) {
    function milliSecondTimeStamp()
    {
        list($mSec, $sec) = explode(' ', microtime());
        $mSecTimeStamp = (float)sprintf('%.0f', (floatval($mSec) + floatval($sec)) * 1000);
        return (int)$mSecTimeStamp;
    }
}

if (!function_exists('multi_array_sort')) {
    function multi_array_sort($array, $shortKey, $short = SORT_ASC, $shortType = SORT_REGULAR)
    {
        foreach ($array as $key => $data) {
            $name[$key] = $data[$shortKey];
        }
        array_multisort($name, $shortType, $short, $array);
        return $array;
    }
}

if (!function_exists('myErrorHandler')) {
    function myErrorHandler($errNo, $errStr, $errFile, $errLine)
    {
        set_error_handler(
            function ($errNo, $errStr, $errFile, $errLine) {
                throw new BaseException($errStr);
            }
        );
    }
}


if (function_exists('decodeJson')) {
    function decodeJson($json, $assoc = false, $depth = 512, $options = 0)
    {
        $data = json_decode($json, $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException('json_decode error: ' . json_last_error_msg());
        }
        return $data;
    }
}

if (function_exists('encodeJson')) {
    function encodeJson($value, $options = 0, $depth = 512)
    {
        $json = json_encode($value, $options, $depth);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException('json_encode error: ' . json_last_error_msg());
        }
        return $json;
    }
}
