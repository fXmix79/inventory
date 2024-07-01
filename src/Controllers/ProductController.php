<?php

namespace App\Controllers;


class ProductController {
    private $model;
    

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {

        $page = $_GET['page'] ?? 'getAllProducts';

        switch ($page) {
            case 'getAllProducts':                
                $this->getAllProducts();                                                          
                break;  
            case 'addProduct':
                $this->addProduct();
                $this->render('addProduct');
                break;          
            case 'deleteProduct':                
                $this->deleteProduct();
                $this->render('deleteProduct');    
                break;
            case 'modifyProduct':
                $this->modifyProduct();
                $this->render('modifyProduct');
                break;
        }
    }

    private function getAllProducts(){      
        $products = $this->model->getAllProducts();
        $this->render('getAllProducts', $products);
    }



    private function addProduct(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $quantity = htmlspecialchars($_POST['quantity']);
            $price =  htmlspecialchars($_POST['price']);
            if($price < 0){
                echo "<script>alert('Price can not be less than 0.');</script>";
                return;
            }  
            $this->model->addProduct($name, $quantity, $price);  
        }
    }

    private function deleteProduct(){  
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
            $name = htmlspecialchars($_POST['name']);
            $this->model->deleteProduct($name);           
        }
    }
               
       


    private function modifyProduct(){    
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $old_name = htmlspecialchars($_POST['old_name']);
            $new_name = htmlspecialchars($_POST['new_name']);
            $new_quantity = htmlspecialchars($_POST['new_quantity']);
            $new_price =  htmlspecialchars($_POST['new_price']);
        $this->model->modifyProduct($old_name, $new_name, $new_quantity, $new_price);         
        }
    }

    private function render($view, $data = []) {
        
        include_once ROOT . 'src/views/layouts/header.php';          
        include_once ROOT . "src/views/product/{$view}.php";
        include_once ROOT . 'src/views/layouts/footer.php';
    }
}
