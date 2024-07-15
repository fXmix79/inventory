<?php

namespace App\Controllers;


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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {       
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            if ($this->model->checkUser($username, $password)){
                $_SESSION['username'] = $username;                      
                $this->render('home');
                return;
            } else {
                echo "<script>alert('Bad username or password.');</script>";                                            
            }                       
        }
        $this->render('login');
    }

    private function logout(){
        session_unset();
        session_destroy();        
    }

    private function addUser(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {        
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $this->model->addUser($username, $password);  
        }
    }

    private function deleteUser(){  
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
            $username = htmlspecialchars($_POST['username']);
            $this->model->deleteUser($username);            
        }
    }
               
       

    private function getAllUsers(){
        $users = $this->model->getAllUsers();
        $this->render('getAllUsers', ['users' => $users]);        
    }

    private function modifyUser(){    
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){    
        $users = $this->model->modifyUser();            
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
