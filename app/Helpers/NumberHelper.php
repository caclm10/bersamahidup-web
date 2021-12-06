<?php

namespace App\Helpers;

class NumberHelper
{
    public static function money($value)
    {
        return number_format($value, 0, '', '.');
    }
}
