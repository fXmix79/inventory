<?php

namespace App\Controllers;

use App\Utils\Utils;

class ProductController {
    private $model;
    

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {

        switch ($_GET['page']) {
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
            case 'filterProduct':
                $products = $this->filterProduct();
                $this->render('filterProduct', $products);
                break;
            case 'report':
                $this->report();
                break;
        }
    }

    private function getAllProducts(){      
        $products = $this->model->getAllProducts();
        $this->render('getAllProducts', $products);
    }



    private function addProduct(){
        if (Utils::isPostSet()) {
            $this->model->addProduct(Utils::sanitizePostToArray());  
        }
    }

    private function deleteProduct(){  
        if (Utils::isPostSet()) {
            $this->model->deleteProduct(Utils::sanitizePostToArray());           
        }
    }
               
       


    private function modifyProduct(){    
        if (Utils::isPostSet()){
        $this->model->modifyProduct(Utils::sanitizePostToArray());         
        }
    }

    private function filterProduct(){ 
        if (Utils::isPostSet()){
            return $this->model->filterProduct(Utils::sanitizePostToArray());         
        }
    }

    private function report(){      
        $products = $this->model->report();
        $this->render('report', $products);
    }

    private function render($view, $data = []) {
        
        include_once ROOT . 'src/views/layouts/header.php';          
        include_once ROOT . "src/views/product/{$view}.php";
        include_once ROOT . 'src/views/layouts/footer.php';
    }
}
