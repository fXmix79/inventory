<?php

namespace App\Utils;



class Utils {


    public static function sanitizePostToArray(): array {
        
        $sanitizedData = [];
        foreach ($_POST as $key => $value) {
            if (stripos($key, 'password') === false) {
                
                $sanitizedData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } else {
                $sanitizedData[$key] = $value;
            }
        }
        $_POST = array();
        return $sanitizedData;
    }


    public static function isPostSet() : bool {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }
        return false;
    }


}