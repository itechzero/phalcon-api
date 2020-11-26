<?php

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