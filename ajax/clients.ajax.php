<?php

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


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

/*=====================================
AJAX REQUEST HANDLING
// =======================================*/
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['idClient'])) {
//         $client = new AjaxClients();
//         $client->idClient = $_POST['idClient'];
//         $client->ajaxEditClient();
//         exit; // Exit to avoid further processing
//     }
// }

/*=====================================
DELETE CLIENT
=======================================*/
//clients.ajax.php
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
//     $idClient = $_POST['idClient'];

//     // Call delete function
//     $deleteSuccess = ControlClients::ctrDeleteClient($idClient); // Ensure this function exists

//     echo json_encode(['success' => $deleteSuccess]);
//     exit;

// }

//clients.ajax.php

// header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['action'])) {
//         switch ($_POST['action']) {
//             case 'delete':
//                 if (isset($_POST['idClient'])) {
//                     $idClient = $_POST['idClient'];
//                     // Call delete function
//                     $deleteSuccess = ControlClients::ctrDeleteClient($idClient);
//                     echo json_encode(['success' => $deleteSuccess]);
//                 } else {
//                     echo json_encode(['success' => false, 'error' => 'ID missing']);
//                 }
//                 exit;
//         }
//     }
// }

// header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Check for delete action
//     if (isset($_POST['action']) && $_POST['action'] === 'delete') {
//         if (isset($_POST['idClient'])) {
//             $idClient = $_POST['idClient'];
//             // Call delete function
//             $deleteSuccess = ControlClients::ctrDeleteClient($idClient);
//             echo json_encode(['success' => $deleteSuccess]);
//         } else {
//             echo json_encode(['success' => false, 'error' => 'ID missing']);
//         }
//         exit;
//     }
// }