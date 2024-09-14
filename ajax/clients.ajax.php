<?php

require_once '../controllers/clients.controller.php';
require_once '../models/clients.model.php';

class AjaxClients
{
    /*=====================================
    EDIT CLIENT
    =======================================*/
    public $idClient;
    public function ajaxEditClient()
    {
        $item = 'id';
        $value = $this->idClient;

        $reply = ControlClients::ctrShowClients($item, $value);

        echo json_encode($reply);
    }
}

/*=====================================
EDIT CLIENT
=======================================*/
if (isset($_POST['idClient'])) {
    $client = new AjaxClients();
    $client->idClient = $_POST['idClient'];
    $client->ajaxEditClient();
}