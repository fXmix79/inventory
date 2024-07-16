<?php

namespace App\Models;

use PDO;

class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
        

    public function addProduct($data = []) {
        if($data['price'] < 0){
            echo "<script>alert('Price can not be less than 0.');</script>";
            return;
        }

        $stmt = $this->pdo->prepare("select username from users where username = ?");
        $stmt->execute([$_SESSION['username']]);
        $user_id = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("insert into products (name, quantity, price, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['name'], $data['quantity'], $data['price'], $user_id]);

        if($stmt->rowCount() > 0){
            echo "<script>alert('Product {$data['name']} with quantity {$data['quantity']} and price €{$data['price']} added to database by user {$_SESSION['username']}');</script>";
        } else {
            echo "<script>alert('Database insert unsucsessfull.');</script>";
        }
    }

    public function deleteProduct($data = []) {
        $stmt = $this->pdo->prepare("delete from products where name = ?");
        $stmt->execute([$data['name']]);

        if($stmt->rowCount() > 0){
            echo "<script>alert('Product {$data['name']} deleted from database');</script>";
        } else {
            echo "<script>alert('Product named {$data['name']} not found in database');</script>";
        }
    }

    public function getAllProducts() {
        $stmt = $this->pdo->query("select * from products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function modifyProduct($data = []) {
        $stmt = $this->pdo->prepare("select name from products where name = ?");
        $stmt->execute([$data['old_name']]);
        if($stmt->rowCount() == 0) {
            echo "<script>alert('No {$data['old_name']} in database');</script>";
            return;
        }

        $stmt = $this->pdo->prepare("select username from users where username = ?");
        $stmt->execute([$_SESSION['username']]);
        $user_id = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("update products set name = ?, quantity = ?, price = ?, user_id = ? WHERE name = ?");
        $stmt->execute([$data['new_name'], $data['new_quantity'], $data['new_price'], $user_id, $data['old_name']]);
        if($stmt->rowCount() == 1){
            echo "<script>alert('Product updated successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update product.');</script>";
        }    
    }

    public function filterProduct($data = []){
        $stmt = $this->pdo->prepare("select * from products where name like ? and quantity between ? and ?");
        $searchTerm = '%' . $data['search'] . '%';
        $stmt->execute([$searchTerm, $data['min_quantity'], $data['max_quantity']]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //echo "<pre>"; var_dump($products); die();
        return $products;
    }

    public function report(){
        $stmt = $this->pdo->prepare("
            select 
                name, 
                sum(quantity) as total_quantity, 
                avg(price) as average_price, 
                sum(quantity * price) as total_value 
            from products 
            group by name
        ");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //echo "<pre>"; var_dump($products); die();
        return $products;
    }


}
