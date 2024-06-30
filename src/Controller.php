<?php

namespace App;

class Controller {
    private $model;
    

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
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
                    $this->model->removeUser($_POST['username']);
                }
                $this->render('removeUser');
                break;
            case 'getAllUsers':
                $users = $this->model->getAllUsers();
                $this->render('getAllUsers', ['users' => $users]);
                break;
            default:
                $this->render('home');
        }
    }

    private function render($view, $data = []) {
        include_once 'views/header.php';
        include_once "views/{$view}.php";
        include_once 'views/footer.php';
    }
}
