<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/6
 * Time: 18:23
 */

namespace App\Controller;

use App\Lib\Util;
use App\Model\Db;
use duncan3dc\Laravel\BladeInstance;

abstract class Base {
    public $blade;
    public $db;
    public $redis;
    public $input = [];
    public $postInput = [];
    public $getInput = [];

    public function __construct() {
        $this->blade = new BladeInstance(ROOT . '/app/view', ROOT . '/runtime/view');
        $this->db = new Db();
        $this->redis = new \Predis\Client();

        foreach ($_GET as $key => $value)
            $this->getInput[$key] = trim($value);
        foreach ($_POST as $key => $value)
            $this->postInput[$key] = trim($value);
        $this->input = array_merge($this->getInput, $this->postInput);
    }

    public function view($tpl, $data = []) {
        return $this->blade->render($tpl, $data);
    }

    public function error($statusCode = 404) {
        switch ($statusCode) {
            case '404':
                header("HTTP/1.1 404 Not Found");
                break;
            case '401':
                header('HTTP/1.1 401 Unauthorized');
                break;
            default:
                header('HTTP/1.1 404 Not Found');
                break;
        }
        return $this->view("error.{$statusCode}");
    }

    public function input($key = '') {
        if($key === '')
            return $this->input;
        if($key && isset($this->input[$key]))
            return $this->input[$key];
        else
            return false;
    }

    public function get($key = '') {
        if($key === '')
            return $this->getInput;
        if($key && isset($this->getInput[$key]))
            return $this->getInput[$key];
        else
            return false;
    }

    public function post($key = '') {
        if($key === '')
            return $this->postInput;
        if($key && isset($this->postInput[$key]))
            return $this->postInput[$key];
        else
            return false;
    }

    public function redirect($path, $query = []) {
        $queryString = $path;
        if(!empty($data)) $queryString .= "?" . http_build_query($data);
        header("location: $queryString");
    }

    /**
     * 支持 'required|string|number|email|domain|ip|url'
     * @param $condition ['name' => 'required|email']
     * @return bool
     */
    public function inputFilter($condition) {
        $type = strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? INPUT_GET : INPUT_POST;
        foreach ($condition as $key => $str) {
            $value = $this->input($key);
            $conditions = explode('|', $str);
            foreach ($conditions as $each) {
                switch ($each) {
                    case 'required':
                        if(empty($value)) return false;
                        break;
                    case 'string':
                        if(!is_string($value)) return false;
                        break;
                    case 'number':
                        if(!is_numeric($value)) return false;
                        break;
                    case 'email':
                        if( filter_input($type, $key, FILTER_VALIDATE_EMAIL) === false ) return false;
                        break;
                    case 'domain':
                        if( filter_input($type, $key, FILTER_VALIDATE_DOMAIN) === false ) return false;
                        break;
                    case 'ip':
                        if( filter_input($type, $key, FILTER_VALIDATE_IP) === false ) return false;
                        break;
                    case 'url':
                        print_r(filter_input($type, $key, FILTER_VALIDATE_URL));
                        if( filter_input($type, $key, FILTER_VALIDATE_URL) === false ) return false;
                        break;
                    default:
                        break;
                }
            }
        }
        return true;
    }
}