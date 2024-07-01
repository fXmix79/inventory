<?php

namespace App\Models;

use PDO;

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function checkUser($username, $password) {
        $stmt = $this->pdo->prepare("SELECT password from users where username = ?");
        $hash =  $stmt->execute([$username]);
        $hash = $stmt->fetchColumn();
        return password_verify($password, $hash);
    }
        

    public function addUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
        echo "<script>alert('User {$username} added to database');</script>";
    }

    public function deleteUser($username) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if($stmt->rowCount()){
            echo "<script>alert('User {$username} deleted from database');</script>";
        } else {
            echo "<script>alert('No user {$username} found in database');</script>";
        }
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT username FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifyUser() {
        
           
        $old_username =     htmlspecialchars($_POST['old_username']);
        $new_username =     htmlspecialchars($_POST['new_username']);
        $new_password =     htmlspecialchars($_POST['new_password']);
        $repeat_password =  htmlspecialchars($_POST['repeat_password']);

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$old_username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user){
            if ($new_password === $repeat_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $this->pdo->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
                if ($stmt->execute([$new_username, $hashed_password, $old_username])) {
                    echo "<script>alert('User updated successfully.');</script>";
                } else {
                    echo "<script>alert('Failed to update user.');</script>";
                }
            } else {
                echo "<script>alert('Passwords do not match.');</script>";
            }   
        } else {
            echo "<script>alert('No {$old_username} in database');</script>";
        }
        
    }
}
