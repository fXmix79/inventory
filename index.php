<?php

session_start();

require_once 'vendor/autoload.php';


use App\Db;
use App\UserModel;
use App\Controller;

try {
    $dbInstance = Db::getInstance();
    $pdo = $dbInstance->getConnection();


    $model = new UserModel($pdo);
    
   
    $controller = new Controller($model);
    $controller->handleRequest();
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}