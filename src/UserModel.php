<?php

namespace App;

use PDO;

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashedPassword]);
    }

    public function removeUser($username) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE username = ?");
        return $stmt->execute([$username]);
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
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt = $this->pdo->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
                if ($stmt->execute([$new_username, $hashed_password, $old_username])) {
                    echo "User updated successfully.";
                } else {
                    echo "Failed to update user.";
                }
            } else {
                echo "Passwords do not match.";
            }   
        } else {
            echo "No {$old_username} in database";
        }
        
    }
}
