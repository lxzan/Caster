<?php

function rule() {
    return [
        'App\\' => __DIR__,
        'Controller\\' => '/controller/',
        'Model\\' => '/model/',
    ];
}

function autoload($namespace) {
    $rule = rule();
    foreach ($rule as $key => $value) {
        $namespace = str_replace($key, $value, $namespace);
    }
    require_once $namespace . '.php';
}

spl_autoload_register('autoload');