<?php 
require_once '../controllers/products.controller.php';
require_once '../models/products.model.php';

require_once '../controllers/categories.controller.php';
require_once '../models/categories.model.php';

class AjaxProducts {

    /*======================================
    GENERATING CODE FROM ID CATEGORY
    =======================================*/
    public $idCategory;

    public function ajaxCreateCodeProducts(){
        $item = 'id_category';
        $value = $this->idCategory;
        $order = 'id';

        $reply = ControlProducts::ctrShowProducts($item, $value, $order);

        echo json_encode($reply);
    }
    
    /*======================================
    EDIT PRODUCT
    =======================================*/
    public $idProduct;
    public $getProducts;
    public $productName;

    public function ajaxEditProduct(){

        if ($this->getProducts == 'ok'){

            $item = null;
            $value = null;
            $order = 'id';

            $reply = ControlProducts::ctrShowProducts($item, $value, $order);

            echo json_encode($reply);
           
        }else if($this->productName != ""){
            $item = 'description';
            $value = $this->productName;
            $order = 'id';

            $reply = ControlProducts::ctrShowProducts($item, $value, $order);

            echo json_encode($reply);
        } else {
            $item = 'id';
            $value = $this->idProduct;
            $order = 'id';

            $reply = ControlProducts::ctrShowProducts($item, $value, $order);

            echo json_encode($reply);
        }
    }
}

/*======================================
    GENERATING CODE FROM ID CATEGORY
=======================================*/
if (isset($_POST['idCategory'])) {
    $productCode = new AjaxProducts();
    $productCode->idCategory = $_POST['idCategory'];
    $productCode->ajaxCreateCodeProducts();
}

/*======================================
EDIT PRODUCT
=======================================*/
if (isset($_POST['idProduct'])) {
    $editProduct= new AjaxProducts();
    $editProduct->idProduct = $_POST['idProduct'];
    $editProduct->ajaxEditProduct();

}

/*======================================
GET PRODUCT
=======================================*/
if (isset($_POST['getProducts'])) {
    $getProducts = new AjaxProducts();
    $getProducts->getProducts = $_POST['getProducts'];
    $getProducts->ajaxEditProduct();
}

/*======================================
GET PRODUCT
=======================================*/
if (isset($_POST["productName"])){

$getProducts = new AjaxProducts();
$getProducts -> productName = $_POST["productName"];
$getProducts -> ajaxEditProduct();

}