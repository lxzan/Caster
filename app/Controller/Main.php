<?php
/**
 * Created by PhpStorm.
 * User: caster
 * Date: 2017/9/6
 * Time: 21:10
 */

namespace App\Controller;


class Main extends Base
{
    public function actionIndex() {
        dd($this->input());
    }
}