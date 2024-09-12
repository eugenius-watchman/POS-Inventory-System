<?php

class ControlProducts{
    /*=======================================
    SHOW PRODUCTS
    =========================================*/
    static public function ctrShowProducts($item, $value, $order)
    {
        $table = 'products';
        $reply = ModelProducts::mdlShowProducts($table, $item, $value, $order);

        return $reply;
    }

    /*=======================================
    CREATE PRODUCTS
    =========================================*/
    static public function ctrCreateProduct()
    {
        if (isset($_POST['newDescription'])) {
            if (preg_match('/^[a-zA-Z0-9- ]+$/', $_POST['newDescription']) &&
                preg_match('/^[0-9]+$/', $_POST['newStock']) &&
                preg_match('/^[0-9.]+$/', $_POST['newBuyingPrice']) &&
                preg_match('/^[0-9.]+$/', $_POST['newSalePrice'])) { 
                /*======================
                IMAGE VALIDATION
                ======================= */
                $imageRoute = "views/img/products/default/anonymous.png";
                if (isset($_FILES['newImage']['tmp_name'])) {
                    list($width, $height) = getimagesize($_FILES['newImage']['tmp_name']);
                    $newWidth = 500;
                    $newHeight = 500;

                    /* FOLDER FOR SAVING PICTURE OF THE PRODUCT  */
                    $folder = 'views/img/products/' .$_POST['newCode'];
                    if (!file_exists($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    /* APPLY DEFAULT PHP FUNCTIONS ACCORDING TO IMAGE TYPE */
                    if ($_FILES['newImage']['type'] === 'image/jpeg') {
                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $imageRoute = "views/img/products/".$_POST["newCode"]."/".$randomNum.".jpg";

                        $imgSource = imagecreatefromjpeg($_FILES["newImage"]["tmp_name"]);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagejpeg($destination, $imageRoute);
                    }

                    if ($_FILES['newImage']['type'] === 'image/png') {
                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $imageRoute = "views/img/products/".$_POST["newCode"]."/".$randomNum.".png";

                        $imgSource = imagecreatefrompng($_FILES["newImage"]["tmp_name"]);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagepng($destination, $imageRoute);
                    }
                }
                $table = 'products';

                $data = array('id_category' => $_POST['newCategory'],
                    'code' => $_POST['newCode'],
                    'description' => $_POST['newDescription'],
                    'stock' => $_POST['newStock'],
                    'buying_price' => $_POST['newBuyingPrice'],
                    'sale_price' => $_POST['newSalePrice'],
                'image' => $imageRoute);

                $reply = ModelProducts::mdlAddProduct($table, $data);

                if ($reply === "ok") {
                    echo'<script>

						swal({
                              type: "success",
                              title: "The product saved successfully.",
                              showConfirmButton: true,
                              confirmButtonText: "Close",
                              closeOnConfirm: false
                              }).then((result)=>{
                                if(result.value) {
                                  window.location = "products";
                                  }
                                })
                        </script>';
                }
            } else {
                echo'<script>
                        swal({
                              type: "error",
							  title: "The product cannot be empty or have special characters!",
                              showConfirmButton: true,
                              confirmButtonText: "Close",
                              closeOnConfirm: false
                              }).then((result)=>{
                              if(result.value) {
                                  window.location = "products";
                                  }
                              })
                    </script>';
            }
        }
    }

    /*=======================================
    EDIT PRODUCT
    =========================================*/
    static public function ctrEditProduct(){
        if(isset($_POST["editDescription"])){
            if (preg_match('/^[a-zA-Z0-9- ]+$/', $_POST['editDescription']) &&
                preg_match('/^[0-9]+$/', $_POST['editStock']) &&
                preg_match('/^[0-9.]+$/', $_POST['editBuyingPrice']) &&
                preg_match('/^[0-9.]+$/', $_POST['editSalePrice'])){ 
                /*======================
                IMAGE VALIDATION
                ======================= */
                $imageRoute = $_POST["actualImage"];

                if (isset($_FILES['editImage']['tmp_name']) && !empty($_FILES['editImage']['tmp_name'])) {
                    list($width, $height) = getimagesize($_FILES['editImage']['tmp_name']);

                    $newWidth = 500;
                    $newHeight = 500;

                    /* FOLDER FOR SAVING PICTURE OF THE PRODUCT  */
                    $folder = 'views/img/products/' .$_POST['editCode'];

                    /*WE ASK IF WE HAVE ANOTHER PICTURE IN THE DB */
                   if(!empty($_POST['actualImage']) && $_POST['actualImage'] != 'views/img/products/default/anonymous.png'){
                        unlink($_POST['actualImage']);
                    } else/* if(!file_exists($folder))*/{
                        mkdir($folder, 0755, true); 
                    }
                               
                    /* APPLY DEFAULT PHP FUNCTIONS ACCORDING TO IMAGE TYPE */
                    if ($_FILES['editImage']['type'] === 'image/jpeg') {
                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $imageRoute = "views/img/products/".$_POST["editCode"]."/".$randomNum.".jpg";

                        $imgSource = imagecreatefromjpeg($_FILES["editImage"]["tmp_name"]);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagejpeg($destination, $imageRoute);
                    }

                    if ($_FILES['editImage']['type'] === 'image/png') {
                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $imageRoute = "views/img/products/".$_POST["editCode"]."/".$randomNum.".png";

                        $imgSource = imagecreatefrompng($_FILES["editImage"]["tmp_name"]);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagepng($destination, $imageRoute);
                    }
                }

                $table = 'products';

                $data = array('id_category' => $_POST['editCategory'],
                    'code' => $_POST['editCode'],
                    'description' => $_POST['editDescription'],
                    'stock' => $_POST['editStock'],
                    'buying_price' => $_POST['editBuyingPrice'],
                    'sale_price' => $_POST['editSalePrice'],
                'image' => $imageRoute);

                $reply = ModelProducts::mdlEditProduct($table, $data);

                if ($reply === 'ok') {
                    echo'<script>
UPDATE
						swal({
                                type: "success",
                                title: "The product edited successfully.",
                                showConfirmButton: true,
                                confirmButtonText: "Close",
                                closeOnConfirm: false
                                }).then((result)=>{
                                if(result.value) {

                                   window.location = "products";

                                   }
                            })
                    </script>';
                }
            } else {
                echo'<script>

						swal({
                              type: "error",
                              title: "The product cannot be empty
                              or have special characters!",
                              showConfirmButton: true,
                              confirmButtonText: "Close",
                              closeOnConfirm: false
                            }).then((result)=>{
                                if(result.value) {

                                 window.location = "products";

                                }
                            })

                    </script>';
            }
        }
    }

    /*=======================================
    EDIT PRODUCT
    =========================================*/
    static public function ctrDeleteProduct()
    {
        if (isset($_GET['idProduct'])) {
            $table = 'products';
            $data = $_GET['idProduct'];

            if ($_GET['image'] !== '' && $_GET['image'] !== 'views/img/products/default/anonymous.png') {
                unlink($_GET['image']);
                rmdir('views/img/products/' . $_GET['code']);
            }

            $reply = ModelProducts::mdlDeleteProduct($table, $data);

            if ($reply === 'ok') {
                echo'<script>

                    swal({
                          type: "success",
                          title: "Product deleted successfully.",
                          showConfirmButton: true,
                          confirmButtonText: "Close",
                          closeOnConfirm: false
                          }).then((result)=>{
                            if(result.value) {

                                window.location = "products";

                                }
                            })

                </script>';
            }
        }
    }

    /*=============================================
    SHOW ADDING OF THE SALES
    =============================================*/
    static public function ctrShowAddingOfTheSales()
    {
        $table = 'products';
        $reply = ModelProducts::mdlShowAddingOfTheSales($table);

        return $reply;
    }
}