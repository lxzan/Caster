<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/6
 * Time: 17:37
 */
namespace App\Controller;

use App\Lib\Util;

class Auth extends Base {
    public function getTest() {
        return $this->view('index');
    }
}