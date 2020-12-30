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