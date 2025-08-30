<?php

require_once '../controllers/categories.controller.php';
require_once '../models/categories.model.php';

/**
 *
 */
class AjaxCategories
{
    /*===========================================
    EDIT CATEGORY
    =============================================*/
    /**
     * @var
     */
    public $idCategory;

    /**
     *
     */
    public function ajaxEditCategory() {
    error_log("Requested category ID: ".$this->idCategory);

    header('Content-Type: application/json');
    ob_clean();

    try {
        $item = 'id';
        $value = $this->idCategory;
        $reply = ControlCategories::ctrShowCategories($item, $value);

        // Convert to consistent associative array
        if (is_array($reply) && isset($reply[0])) {
            $categoryData = $reply[0];
            // Handle both numeric and named keys
            $response = [
                'id' => $categoryData['id'] ?? $categoryData[0] ?? null,
                'category' => $categoryData['category'] ?? $categoryData[1] ?? null
            ];
        } else {
            $response = $reply;
        }

        if (empty($response['id']) || empty($response['category'])) {
            throw new Exception("Required fields missing in response");
        }

        echo json_encode($response);
        
    } catch (Exception $e) {
        echo json_encode([
            'error' => $e->getMessage(),
            'debug_data' => $reply ?? null,
            'requested_id' => $this->idCategory
        ]);
    }
    exit();
}
    // public function ajaxEditCategory()
    // {
    //     $item = 'id';
    //     $value = $this->idCategory;

    //     $reply = ControlCategories::ctrShowCategories($item, $value);

    //     echo json_encode($reply);
    // }
}

/*===========================================
EDIT CATEGORY
=============================================*/
if (isset($_POST['idCategory'])) {
    $category = new AjaxCategories();
    $category->idCategory = $_POST['idCategory'];
    $category->ajaxEditCategory();
}