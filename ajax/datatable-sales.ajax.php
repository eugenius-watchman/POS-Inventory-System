<?php
require_once '../controllers/products.controller.php';
require_once '../models/products.model.php';

/**
 *
 */
class TableProductsSales
{
    /*=======================================
    SHOW PRODUCTS TABLE
    =========================================*/
    /**
     *
     */
    public function showTableProductsSales()
    {
        $item = null;
        $value = null;
        $order = 'id';

        $products = ControlProducts::ctrShowProducts($item, $value, $order);

        if (count($products) === 0) {
            $json_data = '{"data":[]}';

            echo $json_data;

            return;
        }

        $jason_data = '{
            "data": [';

        for ($i = 0; $i < count($products); $i++) {
            /*=======================================
            COLLECTING THE IMAGE
            =========================================*/
            $image = "<img src='" . $products[$i]['image'] . "' width='40px'>";

            /*=======================================
            STOCKS
            =========================================*/
            if ($products[$i]['stock'] <= 10) {
                $stock = "<button class='btn btn-danger'>" . $products[$i]['stock'] . '</button>';
            } else if ($products[$i]['stock'] > 11 && $products[$i]['stock'] <= 15) {
                $stock = "<button class='btn btn-warning'>" . $products[$i]['stock'] . '</button>';
            } else {
                $stock = "<button class='btn btn-success'>" . $products[$i]['stock'] . '</button>';
            }

            /*=======================================
            ACTIONS
            =========================================*/
            $buttons = "<div class='btn-group'><button class='btn btn-primary addProduct recoverButton' idProduct='" . $products[$i]['id'] . "'>Add</button></div>";

            $jason_data .= '[
                "' . ($i + 1) . '",
                "' . $image . '",
                "' . $products[$i]['code'] . '",
                "' . $products[$i]['description'] . '",
                "' . $stock . '",
                "' . $buttons . '"
                ],';
        }

        $jason_data = substr($jason_data, 0, -1);

        $jason_data .= ']

            }';

        echo $jason_data;
    }
}

/*=======================================
ACTIVATE PRODUCTS TABLE
=========================================*/
$activateProductsSales = new TableProductsSales();
$activateProductsSales->showTableProductsSales();