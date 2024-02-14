<?php

namespace xGrz\LaravelAppSettings\Support\Helpers;

class KeyValidationHelper
{
    public static function validateKey(string $key): bool
    {
        return preg_match('/^[a-zA-Z]+(\.[a-zA-Z]+)*$/', $key);
    }
}
