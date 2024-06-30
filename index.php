<?php

session_start();

// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

require_once 'vendor/autoload.php';



use App\Db;
use App\User;
use App\UserController;



try {
    $dbInstance = Db::getInstance();
    $pdo = $dbInstance->getConnection();
 
    $model = new User($pdo);
    
    $controller = new UserController($model);
    $controller->handleRequest();
    

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}