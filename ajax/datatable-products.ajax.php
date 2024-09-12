<?php
require_once '../controllers/products.controller.php';
require_once '../models/products.model.php';

require_once '../controllers/categories.controller.php';
require_once '../models/categories.model.php';

/**
 *
 */
class TableProducts
{
    /*=======================================
    SHOW PRODUCTS TABLE
    ========================================*/
    /**
     *
     */
    public function showTableProducts()
    {
        $item = null;
        $value = null;
        $order = 'id';

        $products = ControlProducts::ctrShowProducts($item, $value, $order);

        if(count($products) == 0) {
            $jsonData = '{"data":[]}';
            echo $jsonData;
            return;
        }

        $jasonData =  '{"data": [';

        for($i = 0; $i < count($products); $i++) {
            /*=======================================
            COLLECTING THE IMAGE
            =========================================*/
            $image = "<img src='".$products[$i]["image"]."' width='40px'>";

            /*=======================================
            COLLECTING THE CATEGORY
            =========================================*/
            $item = "id";
            $value = $products[$i]["id_category"];

            $categories = ControlCategories::ctrShowCategories($item, $value);

            /*=======================================
            STOCKS
            =========================================*/
            if ($products[$i] ["stock"]<=10){
                $stock = "<button class='btn btn-danger'>".$products[$i]["stock"]."</button>";
            } else if ($products[$i]["stock"] > 11 && $products[$i]["stock"] <= 15){
                $stock = "<button class='btn btn-warning'>".$products[$i]["stock"]."</button>";
            } else {
                $stock = "<button class='btn btn-success'>".$products[$i]["stock"]."</button>";
            }

            /*=======================================
            ACTIONS
            =========================================*/
            if (isset($_GET["hiddenProfile"]) && $_GET["hiddenProfile"] == "Special") {
                $buttons =  "<div class='btn-group'><button class='btn btn-warning btnEditProduct' idProduct='".$products[$i]["id"]."' data-toggle='modal' data-target='#modalEditProduct'><i class='fa fa-pencil'></i></button></div>";
            } else {
                $buttons = "<div class='btn-group'><button class='btn btn-warning btnEditProduct' idProduct='".$products[$i]["id"]."' data-toggle = 'modal' data-target ='#modalEditProduct'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteProduct' idProduct='".$products[$i]["id"]."' code='".$products[$i]["code"]."' image='".$products[$i]["image"]."'><i class='fa fa-times'></i></button></div>";
            }
            $jasonData.= '[
                "'.($i+1).'",
                "'.$image.'",
                "'.$products[$i]["code"].'",
                "'.$products[$i]["description"].'",
                "'.$categories["category"].'",
                "'.$stock.'",
                "'.$products[$i]["buying_price"].'",
                "'.$products[$i]["sale_price"].'",
                "'.$products[$i]["date"].'",
                "'.$buttons.'"
                ],';
        }
        $jasonData = substr($jasonData, 0, -1);

        $jasonData .=  ']
            }';
        echo $jasonData;
    }
}

/*=======================================
ACTIVATE PRODUCTS TABLE
=========================================*/
$activateProducts = new TableProducts();
$activateProducts->showTableProducts();