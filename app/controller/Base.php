<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/6
 * Time: 18:23
 */

namespace App\Controller;

use duncan3dc\Laravel\BladeInstance;

class Base {
    protected $blade;
    public function __construct() {
        $this->blade = new BladeInstance(ROOT . '/app/view', ROOT . '/runtime/view');
    }

    public function view($tpl, $data = []) {
        return $this->blade->render($tpl, $data);
    }
}