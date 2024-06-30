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
}
