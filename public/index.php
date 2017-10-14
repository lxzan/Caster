<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/6
 * Time: 14:56
 */

//session_start();
require_once '../vendor/autoload.php';
define('ROOT', __DIR__ . "/../");
define('CONF', \App\Lib\Util::getConfig());
define('APP_NAME', CONF['common']['app_name']);
date_default_timezone_set('Asia/Shanghai');
if(!isset($_SERVER['PATH_INFO'])) {
    $controller = CONF['common']['mvc']['default_controller'];
    $method = CONF['common']['mvc']['default_method'];
}
else {
    $routes = explode('/', $_SERVER['PATH_INFO']);
    $controller = \App\Lib\Util::underline2camel($routes[1]);
    if(isset($routes[2]) && !empty($routes[2]))
        $method = $routes[2];
    else
        $method = CONF['common']['mvc']['default_method'];
}
$className = "\\App\\Controller\\$controller";
if( !class_exists($className) ) {
    $controllerInstance = new \App\Controller\Main();
    echo $controllerInstance->error('404');
    return 0;
}
// action方法接受所有http请求方式
$controllerInstance = new $className();
$method1 = \App\Lib\Util::underline2camel("{$_SERVER['REQUEST_METHOD']}_$method", false);
$method2 = \App\Lib\Util::underline2camel("action_$method", false);
if(method_exists($controllerInstance, $method1))
    echo $controllerInstance->$method1();
else if(method_exists($controllerInstance, $method2))
    echo $controllerInstance->$method2();
else
    echo $controllerInstance->error('404');