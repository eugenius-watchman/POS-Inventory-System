<?php

require_once '../controllers/users.controller.php';
require_once '../models/users.model.php';

class AjaxUsers{
    /*EDIT USER*/
    public $idUser;

    public function ajaxEditUser()
{
        $item = 'id';
        $value = $this->idUser;

        $reply = ControlUsers::ctrShowUsers($item, $value);

        echo json_encode($reply);
    }

    /*ACTIVATE USER*/
    public $userActivate;
    public $idActivate;

    public function ajaxUserActivate(){
        $table = 'users';

        $item1 = 'status';
        $value1 = $this->userActivate;

        $item2 = 'id';
        $value2 = $this->idActivate;

        $reply = ModelUsers::mdlUpdateUser($table, $item1, $value1, $item2, $value2);
    }

    /* VALIDATE IF USER ALREADY EXISTS  */
    public $validateUser;

    public function ajaxValidateUser()
    {
        $item = 'user';
        $value = $this->validateUser;
        $reply = ControlUsers::ctrShowUsers($item, $value);

        echo json_encode($reply);
    }
}

/*EDIT USER*/
if (isset($_POST['idUser'])) {
    $edit = new AjaxUsers();
    $edit->idUser = $_POST['idUser'];
    $edit->ajaxEditUser();
}

/*ACTIVATE USER ...//OBJECTS*/
if (isset($_POST['userActivate'])) {
    $userActivate = new AjaxUsers();
    $userActivate->userActivate = $_POST['userActivate'];
    $userActivate->idActivate = $_POST['idActivate'];
    $userActivate->ajaxUserActivate();
}

/*OBJECT TO VALIDATE USER USER EXISTS */
if (isset($_POST['validateUser'])) {
    $valUser = new AjaxUsers();
    $valUser->validateUser = $_POST['validateUser'];
    $valUser->ajaxValidateUser();
}