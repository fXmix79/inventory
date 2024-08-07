<?php

session_start();

// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require_once '../vendor/autoload.php';



use App\Core\Db;
use App\Core\Router;
use App\Models\User;
use App\Models\Product;
use App\Controllers\UserController;
use App\Controllers\ProductController;


define('ROOT', dirname(__DIR__) . '/');

try {
    $dbInstance = Db::getInstance();
    $pdo = $dbInstance->getConnection();

    $_GET['page'] = $_GET['page'] ?? 'login';
    $_GET['page'] = htmlspecialchars($_GET['page']);

    switch (Router::dispatch($_GET['page'])){
        case 'user':
            $model = new User($pdo);    
            $controller = new UserController($model);
            $controller->handleRequest();
            break;
        case 'product':
            $model = new Product($pdo);    
            $controller = new ProductController($model);
            $controller->handleRequest();
            break;
    }

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}