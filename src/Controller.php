<?php

namespace App;

class Controller {
    private $model;
    

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {

        $page = $_GET['page'] ?? 'home';
        if(!isset($_SESSION['username'])) {
            $page = 'login'; }

        switch ($page) {
            case 'login':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);
                    if ($this->model->checkUser($username, $password)){
                        $_SESSION['username'] = $username;                      
                        $this->render('home');
                        break;
                    }
                }
                $this->render('login');
                break;            
            case 'addUser':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);
                    $this->model->addUser($username, $password);
                }
                $this->render('addUser');
                break;
            case 'removeUser':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $username = htmlspecialchars($_POST['username']);
                    $this->model->removeUser($username);
                }
                $this->render('removeUser');
                break;
            case 'getAllUsers':
                $users = $this->model->getAllUsers();
                $this->render('getAllUsers', ['users' => $users]);
                break;
            case 'modifyUser':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $users = $this->model->modifyUser();
                }
                $this->render('modifyUser');
                break;
            default:
                $this->render('home');
        }
    }

    private function render($view, $data = []) {
        isset($_SESSION['username']) ? include_once 'views/header.php' : include_once 'views/loginHeader.php';        
        include_once "views/{$view}.php";
        include_once 'views/footer.php';
    }
}
