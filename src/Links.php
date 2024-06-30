<?php

namespace App;

class Links {
    
    private static $links = [
        'home'          => '/',
        'addUser'       => '/addUser',
        'removeUser'    => '/removeUser',
        'getAllUsers'   => '/getAllUsers',
        'modifyUser'    => '/modifyUser',
        'logout'        => '/logout'
    ];


    public static function getLinks() {
        return Links::$links;
    }
}
