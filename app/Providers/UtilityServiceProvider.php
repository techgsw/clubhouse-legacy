<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * encode turns any string (e.g. for a "name" field) into a slug, suitable
     * for a code field
     * see https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
     */
    public static function encode($str)
    {
        // replace non letter or digits by -
        $str = preg_replace("/[^\pL\d]+/", "-", $str);
        // remove unwanted characters
        $str = preg_replace('/[^-\w]+/', '', $str);
        // trim
        $str = trim($str, '-');
        // remove duplicate -
        $str = preg_replace('/-+/', '-', $str);
        // lowercase
        $code = strtolower($str);

        if (empty($code)) {
            return '-';
        }

        return $code;
    }
}
