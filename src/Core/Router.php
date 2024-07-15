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
        ['route' => 'filterProduct',    'controller' => 'product'],
        ['route' => 'logout',           'controller' => 'user'],
        
    ];


    public static function dispatch($route) {
        
        if($route == 'login') return 'user';

        foreach(self::$routes as $_route){
            if($_route['route'] == $route){
                $controller = $_route['controller'];
                return $controller;
            }
        }
        $_GET['page'] = '404';
        return 'user';        
    }

    public static function getAllRoutes(){
       return array_column(self::$routes, 'route');

    }

}