<?php

namespace App;

class Links {
    
    private static $links = [
        'home'          => '/',
        'addUser'       => '/addUser',
        'deleteUser'    => '/deleteUser',
        'getAllUsers'   => '/getAllUsers',
        'modifyUser'    => '/modifyUser',
        'logout'        => '/logout'
    ];


    public static function getLinks(){
        return self::$links;
    }


}
