<?php

class ControlCategories{
    /*===============================
    CREATE CATEGORIES
    ============================== */
    static public function ctrCreateCategory()
    {
        if (isset($_POST['newCategory'])) {
            if (preg_match('/^[a-zA-Z0-9- ]+$/', $_POST['newCategory'])) {
                $table = 'categories';

                $data = $_POST['newCategory'];

                $reply = ModelCategories::mdlCreateCategory($table, $data);

                if ($reply === 'ok') {
                    echo '<script>

							swal({

								type: "success",
								title: "Category created successfully!",
								showConfirmButton: true,
								confirmButtonText: "Close",
								closeOnConfirm: false
								}).then((result)=>{
									if(result.value){

										window.location = "categories";

									}

								});

                            </script>';
                }
            } else {
                echo '<script>

						swal({

								type: "error",
								title: "The category cannot be blank or use special characters!",
								showConfirmButton: true,
								confirmButtonText: "Close",
								closeOnConfirm: false
								}).then((result)=>{
									if(result.value){

										window.location = "categories";

									}

								});

                        </script>';
            }
        }
    }

    /*===============================
    SHOW CATEGORIES
    ============================== */
    // static public function ctrShowCategories($item, $value)
    // {
    //     $table = "categories";
        
    //     $reply = ModelCategories::mdlShowCategories($table, $item, $value);

    //     return $reply;
    // }
    static public function ctrShowCategories($item, $value) {
    $table = "categories";
    
    try {
        // Debug: Log the query parameters
        error_log("Querying categories where {$item} = {$value}");
        
        $reply = ModelCategories::mdlShowCategories($table, $item, $value);
        
        // Debug: Log the result
        error_log("Query result: " . print_r($reply, true));
        
        if (empty($reply)) {
            error_log("No results found for {$item} = {$value}");
        }
        
        return $reply;
    } catch (Exception $e) {
        error_log("Error in ctrShowCategories: " . $e->getMessage());
        return [];
    }
}

    /*===============================
    EDIT  CATEGORIES
    ============================== */
    static public function ctrEditCategory()
    {
        if (isset($_POST['editCategory'])) {
            if (preg_match('/^[a-zA-Z0-9- ]+$/', $_POST['editCategory'])) {
                $table = 'categories';

                $data = array('category' => $_POST['editCategory'],
                'id' => $_POST['idCategory'],);

                $reply = ModelCategories::mdlEditCategory($table, $data);

                if ($reply === 'ok') {
                    echo '<script>

							swal({

								type: "success",
								title: "Category changed successfully!",
								showConfirmButton: true,
								confirmButtonText: "Close",
								closeOnConfirm: false

								}).then((result)=>{

									if(result.value){

										window.location = "categories";

									}

								});

                            </script>';
                }
            } else {
                echo '<script>

						swal({

								type: "error",
								title: "The category cannot be blank or use special characters!",
								showConfirmButton: true,
								confirmButtonText: "Close",
								closeOnConfirm: false

								}).then((result)=>{

									if(result.value){

										window.location = "categories";

									}

								});

                    </script>';
            }
        }
    }

    /*======================
    DELETE CATEGORY
    ======================= */
    static public function  ctrDeleteCategory()
    {
        if (isset($_GET['idCategory'])) {
            $table = 'categories';
            $data = $_GET['idCategory'];

            $reply = ModelCategories::mdlDeleteCategory($table, $data);

            if ($reply === 'ok') {
                echo '<script>

						swal({

							type: "success",
							title: "Category deleted successfully!",
							showConfirmButton: true,
							confirmButtonText: "Close",
							closeOnConfirm: false
							}).then((result)=>{

								if(result.value){

									window.location = "categories";

								}

							})

                    </script>';
            }
        }
    }
}