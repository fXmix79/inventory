<?php

namespace App\Core;

class Router {
    
    private static $routes = [
        ['route' => 'home',             'controller' => 'user'],
        ['route' => 'addUser',          'controller' => 'user'],
        ['route' => 'deleteUser',       'controller' => 'user'],
        ['route' => 'getAllUsers',      'controller' => 'user'],
        ['route' => 'modifyUser',       'controller' => 'user'],                
        ['route' => 'addProduct',       'controller' => 'product'],
        ['route' => 'deleteProduct',    'controller' => 'product'],
        ['route' => 'getAllProducts',   'controller' => 'product'],
        ['route' => 'modifyProduct',    'controller' => 'product'],
        ['route' => 'logout',           'controller' => 'user'],
        
    ];


    public static function getController($route) {
        foreach(self::$routes as $routes){
            if($routes['route'] === $route){
                $controller = $routes['controller'];
                return $controller;
            }
        }
        return 'user';
    }

    public static function getAllRoutes(){
       return array_column(self::$routes, 'route');

    }

}