<?php
namespace App\Controller;
use App\Model\BaseModel;

class BaseController {
    public $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function view($template, $data = []) {
        global $blade;
        return $blade->render($template, $data);
    }

    public function index() {
        return $this->view('index');
    }
}