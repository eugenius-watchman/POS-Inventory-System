<?php

/**
 *
 */
class ControlClients
{
    /*=========================================
    CREATE CLIENTS
    ==========================================*/
    /**
     *
     */
    static public function ctrCreateClient()
    {
        if (isset($_POST['newClient'])) {
            if (preg_match('/^[.\a-zA-Z0-9- ]+$/', $_POST['newClient']) &&
                preg_match('/^[0-9]+$/', $_POST['newDocumentId']) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["newEmail"]) &&
                preg_match('/^[()\-0-9 ]+$/', $_POST['newTelephone']) &&
                preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST['newAddress'])){
                $table = 'clients';

                $data = array('name' => $_POST['newClient'], 'document' => $_POST['newDocumentId'], 'email' => $_POST['newEmail'], 'telephone' => $_POST['newTelephone'], 'address' => $_POST['newAddress'], 'birthday' => $_POST['newBirthday'],);

                $reply = ModelClients::mdlAddClient($table, $data);

                //echo "success";
                if ($reply === 'ok') {
                    echo'<script>

							swal({

								type: "success",
								title: "Client added successfully!",
								showConfirmButton: true,
								confirmButtonText: "Close",
								closeOnConfirm: false
								}).then((result)=>{
									if(result.value){

										window.location = "clients";

									}

								});

                        </script>';
                }
            } else {
                echo'<script>

                            swal({
                                type: "error",
                                title: "The client cannot be empty or have special characters!",
                                showConfirmButton: true,
                                confirmButtonText: "Close",
                                closeOnConfirm: false
                                }).then((result)=>{
                                    if(result.value) {

                                    window.location = "clients";

                                    }
                                })

                    </script>';
            }
        }
    }

    /*=========================================
    SHOW CLIENTS
    ==========================================*/
    /**
     *
     *
     * @param $item
     * @param $value
     * @return
     */
    static public function ctrShowClients($item, $value)
    {
        $table = 'clients';

        $reply = ModelClients::mdlShowClients($table, $item, $value);

        return $reply;
    }

    /*=========================================
    EDIT CLIENTS
    ==========================================*/
    /**
     *
     */
    static public function ctrEditClient()
    {
        if (isset($_POST['editClient'])) {
            if (preg_match('/^[.\a-zA-Z0-9- ]+$/', $_POST['editClient']) &&
                preg_match('/^[0-9]+$/', $_POST['editDocumentId']) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+
                    ([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["editEmail"]) &&
                preg_match('/^[()\-0-9 ]+$/', $_POST['editTelephone']) &&
                preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST['editAddress'])){
                $table = 'clients';

                $data = array('id' => $_POST['idClient'], 'name' => $_POST['editClient'], 'document' => $_POST['editDocumentId'], 'email' => $_POST['editEmail'], 'telephone' => $_POST['editTelephone'], 'address' => $_POST['editAddress'], 'birthday' => $_POST['editBirthday'],);

                $reply = ModelClients::mdlEditClient($table, $data);

                if ($reply === 'ok') {
                    echo'<script>

							swal({

								type: "success",
								title: "Client edited successfully!",
								showConfirmButton: true,
								confirmButtonText: "Close",😻
								closeOnConfirm: false
								}).then((result)=>{
									if(result.value){

										window.location = "clients";

									}

								});

                    </script>';
                }
            } else {
                echo'<script>

                            swal({
                                type: "error",
                                title: "The client cannot be empty or have
                                special characters!",
                                showConfirmButton: true,
                                confirmButtonText: "Close",
                                closeOnConfirm: false
                                }).then((result)=>{
                                    if(result.value) {

                                    window.location = "clients";

                                    }
                                })

                    </script>';
            }
        }
    }

    /*=========================================
    DELETE CLIENT
    ==========================================*/
    /**
     *
     */
    static public function ctrDeleteClient()
    {
        if (isset($_GET['idClient'])) {
            $table = 'clients';
            $data = $_GET['idClient'];

            $reply = ModelClients::mdlDeleteClient($table, $data);

            if ($reply === 'ok') {
                echo'<script>
                        swal({
                            type: "success",
                            title: "The client has been deleted successfully",
                            showConfirmButton: true,
                            confirmButtonText: "Close",
                            closeOnConfirm: false
                            }).then(function(result){
                                        if(result.value) {

                                        window.location = "clients";

                                        }
                                    })

                    </script>';
            }
        }
    }
}