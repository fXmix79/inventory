<?php

namespace App\Models;

use PDO;

class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
        

    public function addProduct($name, $quantity, $price) {        
        $stmt = $this->pdo->prepare("select username from users where username = ?");
        $stmt->execute([$_SESSION['username']]);
        $user_id = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("insert into products (name, quantity, price, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $quantity, $price, $user_id]);

        if($stmt->rowCount() > 0){
            echo "<script>alert('Product {$name} with quantity {$quantity} and price €{$price} added to database');</script>";
        } else {
            echo "<script>alert('Database insert unsucsessfull.');</script>";
        }
    }

    public function deleteProduct($name) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE name = ?");
        $stmt->execute([$name]);

        if($stmt->rowCount() > 0){
            echo "<script>alert('Product {$name} deleted from database');</script>";
        } else {
            echo "<script>alert('No product named {$name} in database');</script>";
        }
    }

    public function getAllProducts() {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function modifyProduct($old_name, $new_name, $new_quantity, $new_price) {
        $stmt = $this->pdo->prepare("select name from products where name = ?");
        $stmt->execute([$old_name]);
        if($stmt->rowCount() == 0) {
            echo "<script>alert('No {$old_name} in database');</script>";
            return;
        }

        $stmt = $this->pdo->prepare("select username from users where username = ?");
        $stmt->execute([$_SESSION['username']]);
        $user_id = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("update products set name = ?, quantity = ?, price = ?, user_id = ? WHERE name = ?");
        $stmt->execute([$new_name, $new_quantity, $new_price, $user_id, $old_name]);
        if($stmt->rowCount() == 1){
            echo "<script>alert('Product updated successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update product.');</script>";
        }
             
            
        
        
    }
}
