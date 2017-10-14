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

    public static function getConfig($file = '', $key = '') {
        if($file == '' && $key == '') {
            $files = glob(ROOT . 'config/*');
            $conf = [];
            foreach ($files as $file) {
                $key = basename($file, '.php');
                $conf[$key] = include $file;
            }
            return $conf;
        }
        else if($file != '' && $key == '') {
            $path = ROOT . "config/{$file}.php";
            $conf = include $path;
            return $conf;
        }
        else {
            $path = ROOT . "config/{$file}.php";
            $conf = include $path;
            return $conf[$key];
        }
    }

    public static function isAjax(){
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    public static function isPost() {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
    }

    public static function isGet() {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'get';
    }
}