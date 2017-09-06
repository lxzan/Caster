<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/6
 * Time: 14:56
 */
require_once './vendor/autoload.php';

const ROOT = __DIR__;
$_CONF = \App\Lib\Util::getConf();

$routes = explode('/', $_SERVER['PATH_INFO']);
$controller = \App\Lib\Util::underline2camel($routes[1]);
$method = \App\Lib\Util::underline2camel("{$_SERVER['REQUEST_METHOD']}_{$routes[2]}", false);
$className = "\\App\\Controller\\$controller";
$controllerInstance = new $className();
echo $controllerInstance->$method();