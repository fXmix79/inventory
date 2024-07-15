<?php

namespace App\Models;

use PDO;

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function checkUser($data) {
        $stmt = $this->pdo->prepare("SELECT password from users where username = ?");
        $hash =  $stmt->execute([$data['username']]);
        $hash = $stmt->fetchColumn();
        if (password_verify($data['password'], $hash)){
            $_SESSION['username'] = $data['username'];
        } else {
            echo "<script>alert('Bad username or password.');</script>";
        }
    }
        

    public function addUser($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("insert into users (username, password) values (?, ?)");
        $stmt->execute([$data['username'], $hashedPassword]);
        echo "<script>alert('User {$data['username']} added to database');</script>";
    }

    public function deleteUser($data) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE username = ?");
        $stmt->execute([$data['username']]);
        if($stmt->rowCount()){
            echo "<script>alert('User {$data['username']} deleted from database');</script>";
        } else {
            echo "<script>alert('User {$data['username']} not found in database');</script>";
        }
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT username FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifyUser($data) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$data['old_username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user){
            if ($data['new_password'] === $data['repeat_password']) {
                $hashed_password = password_hash($data['new_password'], PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("update users set username = ?, password = ? WHERE username = ?");
                if ($stmt->execute([$data['new_username'], $hashed_password, $data['old_username']])) {
                    echo "<script>alert('User updated successfully.');</script>";
                } else {
                    echo "<script>alert('Failed to update user.');</script>";
                }
            } else {
                echo "<script>alert('Passwords do not match.');</script>";
            }   
        } else {
            echo "<script>alert('No {$data['old_username']} in database');</script>";
        }
        
    }
}
