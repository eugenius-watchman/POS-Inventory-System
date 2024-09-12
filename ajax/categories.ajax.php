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
    public function ajaxEditCategory()
    {
        $item = 'id';
        $value = $this->idCategory;

        $reply = ControlCategories::ctrShowCategories($item, $value);

        echo json_encode($reply);
    }
}

/*===========================================
EDIT CATEGORY
=============================================*/
if (isset($_POST['idCategory'])) {
    $category = new AjaxCategories();
    $category->idCategory = $_POST['idCategory'];
    $category->ajaxEditCategory();
}