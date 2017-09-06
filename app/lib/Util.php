<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/6
 * Time: 17:26
 */
namespace App\Lib;
class Util {
    public static function underline2camel ( $str , $ucfirst = true) {
        $str = strtolower($str);
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ','',lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }

    public static function getConf() {
        $files = glob(ROOT . '/config/*');
        $conf = [];
        foreach ($files as $file) {
            $key = basename($file, '.php');
            $conf[$key] = include $file;
        }
        return $conf;
    }
}