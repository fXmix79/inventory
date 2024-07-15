<?php

namespace App\Controllers;

use App\Utils\Utils;


class UserController {
    private $model;
    

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {        
        
        switch ($_GET['page']) {
            case 'login':                
                $this->login();                                                          
                break;  
            case 'logout':
                $this->logout();
                $this->render('login');
                break;          
            case 'addUser':                
                $this->addUser();
                $this->render('addUser');    
                break;
            case 'deleteUser':
                $this->deleteUser();
                $this->render('deleteUser');
                break;
            case 'getAllUsers':
                $this->getAllUsers();
                break;
            case 'modifyUser':                
                $this->modifyUser();
                $this->render('modifyUser');               
                break;
            case 'home':
                $this->render('home');
                break;
            case'404':
                $this->render('404');
        }
    }

    private function login(){ 
        if (Utils::isPostSet()) {
            $this->model->checkUser(Utils::sanitizePostToArray());                        
        }
        isset($_SESSION['username'])
            ? $this->render('home')
            : $this->render('login');
    }

    private function logout(){
        session_unset();
        session_destroy();        
    }

    private function addUser(){
        if (Utils::isPostSet()) {
            $this->model->addUser(Utils::sanitizePostToArray());  
        }
    }

    private function deleteUser(){  
        if (Utils::isPostSet()) {
            $this->model->deleteUser(Utils::sanitizePostToArray());            
        }
    }             
 
    private function getAllUsers(){
        $users = $this->model->getAllUsers();
        $this->render('getAllUsers', ['users' => $users]);        
    }

    private function modifyUser(){    
        if (Utils::isPostSet()){    
        $this->model->modifyUser(Utils::sanitizePostToArray());            
        }
    }

    private function render($view, $data = []) {
        isset($_SESSION['username'])
            ? include_once ROOT . 'src/views/layouts/header.php'
            : include_once ROOT . 'src/views/layouts/loginHeader.php';        
        include_once ROOT . "src/views/user/{$view}.php";
        include_once ROOT . 'src/views/layouts/footer.php';
    }
}
