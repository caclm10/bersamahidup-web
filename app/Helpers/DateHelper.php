<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Date;

class DateHelper
{
    public static function diffString($value, $time = 'now')
    {
        $time = Date::parse($value)->diff($time);

        $type = '';
        $value = 0;
        if ($time->d < 1) {
            if ($time->h < 1) {
                if ($time->i < 1) {
                    $type = 'detik';
                    $value = $time->s;
                } else {
                    $type = 'menit';
                    $value = $time->i;
                }
            } else {
                $type = 'jam';
                $value = $time->h;
            }
        } else {
            if ($time->m >= 1) {
                if ($time->y >= 1) {
                    $type = 'tahun';
                    $value = $time->y;
                } else {
                    $type = 'bulan';
                    $value = $time->m;
                }
            } else {
                $type = 'hari';
                $value = $time->d;
            }
        }

        return "$value $type yang lalu";
    }

    public static function diffEndDays($value, $time = 'now')
    {
        $time = Date::parse($value)->diff($time);

        $type = '';
        $value = 0;
        if ($time->d < 1) {
            if ($time->h < 1) {
                if ($time->i < 1) {
                    $type = 'detik';
                    $value = $time->s;
                } else {
                    $type = 'menit';
                    $value = $time->i;
                }
            } else {
                $type = 'jam';
                $value = $time->h;
            }
        } else {
            $type = 'hari';
            $value = $time->days;
        }


        return "$value $type lagi";
    }
}
