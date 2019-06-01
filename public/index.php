<?php
session_start();

use \core\Router;

define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');

error_reporting(E_ALL);

spl_autoload_register(function($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});


Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

$query = rtrim($_SERVER['QUERY_STRING'], '/');
Router::dispatch($query);