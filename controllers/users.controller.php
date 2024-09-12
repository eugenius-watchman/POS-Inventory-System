<?php

class ControlUsers{

    /*======================
    USER LOGiN
    ======================= */
    static public function ctrUserLogin()
    {
        if (isset($_POST['userLogin'])) {
            if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['userLogin']) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST['loginPass'])) {
                $passEncrypt = crypt($_POST['loginPass'], '$2y$12$b.1hQK3906YJnALQY7Bil.Ml.VxWr21VNmFe/SwMTOYqse9qNEoE2');

                $table = 'users';

                $item = 'user';

                $value = $_POST['userLogin'];

                $reply = ModelUsers::MdlShowUsers($table, $item, $value);

                if ($reply['user'] === $_POST['userLogin'] && $reply['password'] === $passEncrypt) {
                    if ($reply['status'] == 1) {
                        $_SESSION['loginSession'] = 'ok';
                        $_SESSION['id'] = $reply['id'];
                        $_SESSION['name'] = $reply['name'];
                        $_SESSION['user'] = $reply['user'];
                        $_SESSION['picture'] = $reply['picture'];
                        $_SESSION['profile'] = $reply['profile'];

                        /*REGISTER DATE TO DETERMINE LAST LOGIN*/
                        date_default_timezone_set('Africa/Accra');

                        $date = date('Y-m-d');
                        $hour = date('H:i:s');

                        $currentDate = $date.' '.$hour;

                        $item1 = 'last_login';
                        $value1 = $currentDate;

                        $item2 = 'i';
                        $value2 = $reply['id'];

                        $lastLogin = ModelUsers::mdlUpdateUser($table, $item1, $value1, $item2, $value2);

                        if ($lastLogin == 'ok') {
                            echo'<script>

											window.location = "home";

                                </script>';
                        }
                    }
                } else {
                    echo '<br><div class="alert alert-danger">User not activated.Please try again.</div>';
                }
            } else {
                echo '<br><div class="alert alert-danger">Login Failed!User not activated.Please try again.</div>';
            }
        }

    }

    /*===========================
    USER REGISTER/CREATE USER
    ============================= */
    static public function ctrCreateUser(){
        if (isset($_POST['newUser'])) {
            if (preg_match('/^[a-zA-Z0-9- ]+$/', $_POST['newname']) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST['newUser']) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST['newPassword'])){
                /*======================
                IMAGE VALIDATION
                ======================= */
                $routePic = "";
                if (isset($_FILES['newPicture']['tmp_name'])){
                    list($width, $height) = getimagesize($_FILES['newPicture']['tmp_name']);

                    $newWidth = 500;
                    $newHeight = 500;

                    /* FOLDER FOR SAVING PICTURE OF THE USER */
                    $folder = 'views/img/users/' . $_POST['newUser'];
                    if (!file_exists($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    /* APPLY DEFAULT PHP FUNCTIONS ACCORDING TO IMAGE TYPE */
                    if ($_FILES['newPicture']['type'] === 'image/jpeg') {
                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $routePic = 'views/img/users/' . $_POST['newUser'] . '/' . $randomNum. ' .jpg';

                        $imgSource = imagecreatefromjpeg($_FILES['newPicture']['tmp_name']);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagejpeg($destination, $routePic);
                    }

                    if($_FILES['newPicture']['type'] == 'image/png'){
                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $routePic = 'views/img/users/' . $_POST['newUser'] . '/'.$randomNum . '.png';

                        $imgSource = imagecreatefrompng($_FILES['newPicture']['tmp_name']);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagepng($destination, $routePic);
                    }
                }

                $table = 'users';

                $passEncrypt = crypt($_POST['newPassword'],'$2y$12$b.1hQK3906YJnALQY7Bil.Ml.VxWr21VNmFe/SwMTOYqse9qNEoE2');

                $data = array('name' => $_POST['newname'],
                    'user' => $_POST['newUser'],
                    'password' => $passEncrypt ,
                    'profile' => $_POST['newProfile'],
                'picture' => $routePic);

                $reply = ModelUsers::mdlAddUser($table, $data);

                if ($reply === 'ok') {
                    echo '<script>

							swal({

								type: "success",
								title: "User added successfully!",
								showConfirmButton: true,
								confirmButtonText: "Close",
								closeOnConfirm: false

								}).then((result)=>{

									if(result.value){

										window.location = "users";

									}

								});

                        </script>';
                }
            } else {
                echo '<script>

						swal({

							type: "error",
							title: "The user cannot be blank or use special characters!",
							showConfirmButton: true,
							confirmButtonText: "Close",
							closeOnConfirm: false

							}).then((result)=>{

								if(result.value){

									window.location = "users";

								}
                            });
                    </script>';
            }
        }
    }

    /*======================
    SHOW USERS
    ======================= */
    static public function ctrShowUsers($item, $value) {
        $table = 'users';

        $reply = ModelUsers::MdlShowUsers($table, $item, $value);

        return $reply;
    }

    /*======================
    EDIT USERS
    ======================= */
    static public function ctrEditUser() {
        if (isset($_POST['editUser'])) {
            if (preg_match('/^[a-zA-Z0-9- ]+$/', $_POST['editName'])) {
                /*VALIDATE IMAGE*/
                $routePic = $_POST['currentPicture'];

                if (isset($_FILES["editPicture"]["tmp_name"]) && !empty($_FILES["newPicture"]["tmp_name"])) {
                    list($width, $height) = getimagesize($_FILES['editPicture']['tmp_name']);

                    $newWidth = 500;
                    $newHeight = 500;

                    /* FOLDER FOR SAVING PICTURE OF THE USER */
                    $folder = 'views/img/users/' . $_POST['editUser'];

                    /*CHECK FOR EXTRA IMAGE IN DATA BASE*/
                    if (!empty($_POST['currentPicture'])) {
                        unlink($_POST['currentPicture']);
                    } elseif (!file_exists($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    /* APPLY DEFAULT PHP FUNCTIONS ACCORDING TO IMAGE TYPE */
                    if ($_FILES['editPicture']['type'] === 'image/jpeg') {
                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $routePic = 'views/img/users/' . $_POST['editUser'] . '/' . $randomNum . ' .jpg';

                        $imgSource = imagecreatefromjpeg($_FILES['editPicture']['tmp_name']);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagejpeg($destination, $routePic);
                    }

                    if ($_FILES['editPicture']['type'] === 'image/png') {

                        /*SAVE IMAGE IN FOLDER*/
                        $randomNum = mt_rand(100,999);

                        $routePic = 'views/img/users/'.$_POST['editUser'] . '/' . $randomNum . ' .png';

                        $imgSource = imagecreatefrompng($_FILES['editPicture']['tmp_name']);

                        $destination = imagecreatetruecolor($newWidth, $newHeight);

                        imagecopyresized($destination, $imgSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        imagepng($destination, $routePic);
                    }
                }

                $table = 'users';

                if ($_POST['editPassword'] !== ""){
                    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['editPassword'])){
                        $passEncrypt = crypt($_POST["editPassword"],'$2y$12$b.1hQK3906YJnALQY7Bil.Ml.VxWr21VNmFe/SwMTOYqse9qNEoE2');
                    } else {
                        echo'<script>
                                    swal({
                                            type: "error",
												title: "The user cannot be blank or use special characters!",
												showConfirmButton: true,
												confirmButtonText: "Close",
												closeOnConfirm: false

												}).then((result)=>{

													if(result.value){

														window.location = "users";

													}
                                        );
                            </script>';
                    }
                } else {
                    $passEncrypt = $_POST['currentPassword'];
                }
                $data = array('name' => $_POST['editName'],
                    'user' => $_POST['editUser'],
                    'password' => $passEncrypt ,
                    'profile' => $_POST['editProfile'],
                'picture' => $routePic);

                $reply = ModelUsers::mdlEditUser($table, $data);
                echo 'success';
                if ($reply === 'ok') {
                    echo '<script>

									swal({

										type: "success",
										title: "User saved successfully!",
										showConfirmButton: true,
										confirmButtonText: "Close",
										closeOnConfirm: false

										}).then((result)=>{

											if(result.value){

												window.location = "users";

											}
                                    });
                        </script>';
                }
            } else {
                echo '<script>

						swal({

							type: "error",
							title: "The user cannot be blank or use special characters!",
							showConfirmButton: true,
							confirmButtonText: "Close",
							closeOnConfirm: false

							}).then((result)=>{

								if(result.value){

									window.location = "users";

								}
                        });
                </script>';
            }
        }
    }

    /*======================
    DELETE USER
    ======================= */
    static public function ctrDeleteUser() {
        if (isset($_GET['userId'])) {
            $table = 'users';
            $data = $_GET['userId'];

            //$userid = $_POST["idUser"];
            if ($_GET['userPicture'] !== "") {
                unlink($_GET['userPicture']);
                rmdir('views/img/users/' . $_GET['user']);
            }

            $reply = ModelUsers::mdlDeleteUser($table, $data);

            if ($reply === 'ok') {
                echo'<script>

						swal({

							type: "success",
							title: "User deleted successfully!",
							showConfirmButton: true,
							confirmButtonText: "Close",
							closeOnConfirm: false
							}).then((result)=>{

								if(result.value){

									window.location = "users";

								}

							})

                    </script>';
            }
        }
    }
}