<?php

if (!function_exists('once')) {
    function once($fn)
    {
        $hasRun = false;

        return function (...$params) use ($fn, &$hasRun) {
            if ($hasRun) return;

            $hasRun = true;

            return $fn(...$params);
        };
    }
}