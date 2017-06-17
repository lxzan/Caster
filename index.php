<?php
use duncan3dc\Laravel\BladeInstance;
use Noodlehaus\Config;
use Slim\PDO\Database;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/autoload.php';
define('ROOT_PATH', __DIR__);

function toCamelCase($str){
    $array = explode('_', $str);
    $result = '';
    foreach($array as $value){
        $result.= ucfirst($value);
    }
    return $result;
}

$blade = new BladeInstance(__DIR__ . '/app/view', __DIR__ . '/runtime/view');

$conf = Config::load(ROOT_PATH . '/config/db.json');
$host = $conf->get('host');
$dbname = $conf->get('database');
$username = $conf->get('username');
$password = $conf->get('password');
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
$pdo = new Database($dsn, $username, $password);

$parser = parse_url($_SERVER['REQUEST_URI']);
if($parser['path'] === '/') {
    $controller = 'BaseController';
    $method = 'index';
}
else {
    $arr = explode('/', $parser['path']);
    $controller = toCamelCase($arr[1]) . 'Controller';
    $method = isset($arr[2]) ? toCamelCase($arr[2]) : 'index';
    $method[0] = strtolower($method[0]);
}

$Controller = "App\\Controller\\$controller";
$controller = new $Controller();

$data = [];
if( !empty($parser['query']) ) {
    $arr = explode('&', $parser['query']);
    foreach ($arr as $item) {
        $temp = explode('=', $item);
        $data[ $temp[0] ] = $temp[1];
    }
}

echo $controller->$method($data);