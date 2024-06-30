<?php

namespace App;

class Links {
    
    private static $links = [
        'home' => '/',
        'addUser' => '/addUser',
        'removeUser' => '/removeUser',
        'getAllUsers' => '/getAllUsers'
    ];


    public static function getLinks() {
        return Links::$links;
    }
}
