<?php
class ControlSales{
    /*=========================================
    SHOW SALES
    ==========================================*/
    static public function ctrShowSales($item, $value)
    {
        $table = 'sales';
        $reply = ModelSales::mdlShowSales($table, $item, $value);

        return $reply;
    }

    /*=========================================
    CREATE SALES
    ==========================================*/
    static public function ctrCreateSale()
    {
        if (isset($_POST['newSale'])) {
            /*===================================
            UPDATE client'S PURCHASES; REDUCE THE STOCK; INCREASE SALES OF PRODUCT
            ====================================*/
            $productsList = json_decode($_POST['productsList'], true);
            $totalPurchasedProducts = array();
            foreach ($productsList as $value) {
                array_push($totalPurchasedProducts, $value['quantity']);

                $tableProducts = 'products';
                $item = 'id';
                $valPdtId = $value['id'];  
                $order = 'id';

                $getProduct = ModelProducts::mdlShowProducts($tableProducts, $item, $valPdtId, $order);

                $item1a = 'sales';
                $value1a = $value['quantity'] + $getProduct['sales'];

                $newSales = ModelProducts::mdlUpdateProducts($tableProducts, $item1a, $value1a, $valPdtId);

                $item1b = 'stock';
                $value1b = $value['stock'];

                $newStock = ModelProducts::mdlUpdateProducts($tableProducts, $item1b, $value1b, $valPdtId);
            }

            $tableClients = 'clients';

            $item = 'id'; 
            $valueClient = $_POST['selectClient'];

            $getClient = ModelClients::mdlShowClients($tableClients, $item, $valueClient);

            $item1a = 'purchases';
            $value1a = array_sum($totalPurchasedProducts) + $getClient['purchases'];

            $clientSales = ModelClients::mdlUpdateClients($tableClients, $item1a, $value1a, $valueClient);

            $item1b = 'last_purchase';

            date_default_timezone_set('Africa/Accra');

            $date = date('Y-m-d');
            $hour = date('H:i:s');

            $value1b = $date.' '.$hour;

            $dateClient = ModelClients::mdlUpdateClients($tableClients, $item1b, $value1b, $valueClient);

            /*=============================================
            SAVE SALE
            =============================================*/
            $table = 'sales';

            $data = array('id_seller' => $_POST['sellerId'],
                'id_client' => $_POST['selectClient'],
                'code' => $_POST['newSale'],
                'products' => $_POST['productsList'],
                'tax' => $_POST['currentTaxPrice'],
                'net' => $_POST['newNetPrice'],
                'total' => $_POST['totalSale'],
            'mode_payment' => $_POST['listPaymentMode'],);

            $reply = ModelSales::mdlAddSale($table, $data);

            //echo "success";
            if ($reply === 'ok') {
                echo '<script>

                  localStorage.removeItem("range");

                  swal({
                        type: "success",
                        title: "The sale has been added successfully!",
                        showConfirmButton: true,
                        confirmButtonText: "Close"
                        }).then((result) => {
                              if (result.value) {

                              window.location = "sales";

                            }
                        })

              </script>';
            }
        }
    }

    /*=========================================
    EDIT SALES
    ==========================================*/
    static public function ctrEditSales(){
        if (isset($_POST['editSale'])) {
            /*================================================
            FORMAT PRODUCTS AND clientS/CLIENTS TABLES
            ==================================================*/
            $table = 'sales';

            $item = 'code';
            $valueEd = $_POST['editSale'];

            $getSale = ModelSales::mdlShowSales($table, $item, $valueEd);

            /*=============================================
            CHECK FOR ANY EDITED SALE
            =============================================*/
            if ($_POST['productsList'] === '') {
                $productsList = $getSale['products'];
                $changeProduct = false;
            } else {
                $productsList = $_POST['productsList'];
                $changeProduct = true;
            }

            if ($changeProduct) {
                $products = json_decode($getSale['products'], true);

                $totalPurchasedProducts = array(); 

                foreach ($products as $value) {
                    array_push($totalPurchasedProducts, $value['quantity']);

                    $tableProducts = 'products';

                    $item = 'id';
                    $value1 = $value['id'];
                    $order = 'id';

                    $getProduct = ModelProducts::mdlShowProducts($tableProducts, $item, $value1, $order);

                    $item1a = 'sales';
                    $value1a = $getProduct['sales'] - $value['quantity'];

                    $newSales = ModelProducts::mdlUpdateProducts($tableProducts, $item1a, $value1a, $valueEd);

                    $item1b = 'stock';
                    $value1b = $value['quantity'] + $getProduct['stock'];

                    $newStock = ModelProducts::mdlUpdateProducts($tableProducts, $item1b, $value1b, $valueEd);
                }

                $tableClients = 'clients';

                $itemClient   = 'id'; 
                $valueClient  = $_POST['selectClient'];

                $getClient = ModelClients::mdlShowClients($tableClients, $itemClient, $valueClient);

                $item1a = 'purchases';
                $value1a = $getClient['purchases'] - array_sum($totalPurchasedProducts);

                $clientSales  = ModelClients::mdlUpdateClients($tableClients, $item1a, $value1a, $valueClient);

                /*==================================================================================== 
                UPDATE client'S PURCHASES AND REDUCE THE STOCK AND INCREASE SALES OF THE PRODUCT
                ====================================================================================*/
                $productsList_2 = json_decode($productsList, true);

                $totalPurchasedProducts_2 = array();

                foreach ($productsList_2 as $value){
                    array_push($totalPurchasedProducts_2, $value['quantity']);

                    $tableProducts_2 = 'products';

                    $item_2 = 'id';
                    $value_2 = $value['id'];
                    $order = 'id';

                    $getProduct_2 = ModelProducts::mdlShowProducts($tableProducts_2, $item_2, $value_2, $order);

                    $item1a_2 = 'sales';
                    $value1a_2 = $value['quantity'] + $getProduct_2['sales'];

                    $newSales_2 = ModelProducts::mdlUpdateProducts($tableProducts_2, $item1a_2, $value1a_2, $value_2);

                    $item1b_2 = 'stock';
                    $value1b_2 = $value['stock'];

                    $newStock_2 = ModelProducts::mdlUpdateProducts($tableProducts_2, $item1b_2, $value1b_2, $value_2);
                }

                $tableClients_2 = 'clients';

                $item_2 = 'id';
                $value_2 = $_POST['selectClient'];

                $getClient_2 = ModelClients::mdlShowClients($tableClients_2, $item_2, $value_2);

                //var_dump($getClient["purchases"]);
                $item1a_2 = 'purchases';
                $value1a_2 = array_sum($totalPurchasedProducts_2) + $getClient_2['purchases'];

                $clientSales_2 = ModelClients::mdlUpdateClients($tableClients_2, $item1a_2, $value1a_2, $value_2);

                $item1b_2 = 'last_purchase';

                date_default_timezone_set('Africa/Accra');

                $date = date('Y-m-d');
                $hour = date('H:i:s');

                $value1b_2 = $date.' '.$hour;

                $dateClient_2 = ModelClients::mdlUpdateClients($tableClients_2, $item1b_2, $value1b_2, $value_2);
            }

            /*=============================================
            SAVE SALE CHANGES
            =============================================*/
            $data = array('id_seller' => $_POST['sellerId'],
                'id_client' => $_POST['selectClient'],
                'code' => $_POST['editSale'],
                'products' => $productsList,
                'tax' => $_POST['currentTaxPrice'],
                'net' => $_POST['newNetPrice'],
                'total' => $_POST['totalSale'],
            'mode_payment' => $_POST['listPaymentMode'],);
            $reply = ModelSales::mdlEditSales($table, $data);

            if ($reply === 'ok') {
                echo'<script>

                  localStorage.removeItem("range");

                  swal({
                      type: "success",
                      title: "Sale edited successfully!",
                      showConfirmButton: true,
                      confirmButtonText: "Close"
                      }).then((result) => {
                          if (result.value) {

                          window.location = "sales";

                          }
                        })

              </script>';
            }
        }
    }

    /*==========================================
    DELETE SALES
    =============================================*/
    static public function ctrDeleteSales(){
        if (isset($_GET['idSale'])) {
            $table = 'sales';

            $item = 'id';
            $value = $_GET['idSale'];

            $getSale = ModelSales::mdlShowSales($table, $item, $value);

            /*=============================================
            UPDATE THE LAST SALE
            =============================================*/
            $tableClients = 'clients';

            $itemSales = null;
            $valueSales = null;

            $getSales = ModelSales::mdlShowSales($table, $itemSales, $valueSales);

            $saveDates = array();

            foreach ($getSales as $value){
                if ($value['id_client'] === $getSale['id_client']) {
                    array_push($saveDates, $value['date']);
                }
            }

            if (count($saveDates) > 1) {
                if ($getSale['date'] > $saveDates[count($saveDates)-2]) {
                    $item = 'last_purchase';
                    $value = $saveDates[count($saveDates)-2];
                    $valueIdClient = $getSale['id_client'];

                    $clientSales = ModelClients::mdlUpdateClients($tableClients, $item, $value, $valueIdClient);
                } else {
                    $item = 'last_purchase';
                    $value = $saveDates[count($saveDates)-1];
                    $valueIdClient = $getSale['id_client'];

                    $clientSales = ModelClients::mdlUpdateClients($tableClients, $item, $value, $valueIdClient);
                }
            } else {
                $item = 'last_purchase';
                $value = '0000-00-00 00:00:00';
                $valueIdClient = $getSale['id_client'];

                $clientSales = ModelClients::mdlUpdateClients($tableClients, $item, $value, $valueIdClient);
            }

            /*=============================================
            FORMATTING PRODUCTS AND CLIENTS TABLE
            =============================================*/
            $products = json_decode($getSale['products'], true);

            $totalPurchasedProducts = array(); 

            foreach ($products as $value) {
                array_push($totalPurchasedProducts, $value['quantity']);

                $tableProducts = 'products';

                $item = 'id';
                $valueDel = $value['id'];  
                $order = 'id';
                $getProduct = ModelProducts::mdlShowProducts($tableProducts, $item, $valueDel, $order);

                $item1a = 'sales';
                $value1a = $getProduct['sales'] - $value['quantity'];

                $newSales = ModelProducts::mdlUpdateProducts($tableProducts, $item1a, $value1a, $value);

                $item1b = 'stock';
                $value1b = $value['quantity'] + $getProduct['stock'];

                $newStock = ModelProducts::mdlUpdateProducts($tableProducts, $item1b, $value1b, $value);
            }

            $tableClients = 'clients'; 
            $itemClient = 'id'; 
            $valueClient = $getSale['id_client'];
            $getClient = ModelClients::mdlShowClients($tableClients, $itemClient, $valueClient);

            $item1a = 'purchases';
            $value1a = $getClient['purchases'] - array_sum($totalPurchasedProducts);

            $clientSales = ModelClients::mdlUpdateClients($tableClients, $item1a, $value1a, $valueClient);

            /*============================
            DELETE SALE
            ==============================*/
            $reply = ModelSales::mdlDeleteSales($table, $_GET['idSale']);

            if ($reply === 'ok') {
                echo'<script>

            swal({
                type: "success",
                title: "Sale deleted successfully!",
                showConfirmButton: true,
                confirmButtonText: "Close",
                closeOnConfirm: false
                }).then((result) => {
                    if (result.value) {

                    window.location = "sales";

                    }
                  })

            </script>';
            }
        }
    }

    /*=============================================
    DATE  RANGE
    =============================================*/
    static public function ctrSalesDatesRange($initialDate, $finalDate)
    {
        $table = 'sales';

        $reply = ModelSales::mdlSalesDatesRange($table, $initialDate, $finalDate);

        return $reply;
    }

    /*=============================================
    DOWNLOAD EXCEL
    =============================================*/
    public function ctrDownloadReport()
    {
        if (isset($_GET['report'])) {
            $table = 'sales';

            if (isset($_GET['initialDate']) && isset($_GET['finalDate'])) {
                $sales = ModelSales::mdlSalesDatesRange($table, $_GET['initialDate'], $_GET['finalDate']);
            } else {
                $item = null;
                $value = null;

                $sales = ModelSales::mdlShowSales($table, $item, $value);
            }

            /*=============================================
            CREATE EXCEL FILE
            =============================================*/
            $name = $_GET['report'] . '.xls';

            header('Expires: 0');
            header('Cache-control: private');

            //Excel file
            header('Content-type: application/vnd.ms-excel');
            header('Cache-Control: cache, must-revalidate');
            header('Content-Description: File Transfer');
            header('Last-Modified: ' . date('D, d M Y H:i:s'));
            header('Pragma: public');
            header('Content-Disposition:; filename="' . $name . '"');
            header('Content-Transfer-Encoding: binary');

            echo ("<table border='0'>

    <tr>
    <td style='font-weight:bold; border:1px solid #eee;'>CODE</td>
    <td style='font-weight:bold; border:1px solid #eee;'>CLIENT</td>
    <td style='font-weight:bold; border:1px solid #eee;'>SELLER</td>
    <td style='font-weight:bold; border:1px solid #eee;'>QUANTITY</td>
    <td style='font-weight:bold; border:1px solid #eee;'>PRODUCTS</td>
    <td style='font-weight:bold; border:1px solid #eee;'>TAX</td>
    <td style='font-weight:bold; border:1px solid #eee;'>NET</td>
    <td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>
    <td style='font-weight:bold; border:1px solid #eee;'>MODE OF PAYMENT</td>
    <td style='font-weight:bold; border:1px solid #eee;'>DATE</td>
    </tr>");

            foreach ($sales as $item) {
                $client = ControlClients::ctrShowClients('id', $item['id_client']);
                $seller = ControlUsers::ctrShowUsers('id', $item['id_seller']);

                echo ("<tr>
    <td style='border:1px solid #eee;'>" . $item['code'] . "</td>
    <td style='border:1px solid #eee;'>" . $client['name'] . "</td>
    <td style='border:1px solid #eee;'>" . $seller['name'] . "</td>
    <td style='border:1px solid #eee;'>");

                $products = json_decode($item['products'], true);

                foreach ($products as $key => $valueProducts) {
                    echo ($valueProducts['quantity'] . '<br>');
                }

                echo ("</td><td style='border:1px solid #eee;'>");

                foreach ($products as $valueProducts) {
                    echo ($valueProducts['description'] . '<br>');
                }

                echo ("</td>
    <td style='border:1px solid #eee;'>$ " . number_format($item['tax'], 2) . "</td>
    <td style='border:1px solid #eee;'>$ " . number_format($item['net'], 2) . "</td>
    <td style='border:1px solid #eee;'>$ " . number_format($item['total'], 2) . "</td>
    <td style='border:1px solid #eee;'> " . $item['mode_payment'] . "</td>
    <td style='border:1px solid #eee;'> " . substr($item['date'], 0, 10) . '</td>
    </tr>');
            }
            echo '</table>';
        }
    }

    /*=============================================
    ADDING TOTAL SALES
    =============================================*/
    public function ctrAddingTotalSales()
    {
        $table = 'sales';

        $reply = ModelSales::mdlAddingTotalSales($table);

        return $reply;
    }
}