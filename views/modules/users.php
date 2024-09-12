<?php

if ($_SESSION['profile'] === 'Special' || $_SESSION['profile'] === 'Seller') {
    echo '<script>

    window.location = "home";

  </script>';

    return;
}

?>

<div class="content-wrapper">

<section class="content-header">

<h1>

Manage Users

</h1>

<ol class="breadcrumb">

<li><a href="home"><i class="fa fa-dashboard"></i> Home Page</a></li>

<li class="active">User Management</li>

</ol>

</section>

<section class="content">

<div class="box">

<div class="box-header with-border">

<button class="btn btn-primary" data-toggle="modal" data-target="#modalAddUser">

Add User

</button>

</div>

<div class="box-body">

<table class="table table-bordered table-striped dt-responsive tables"
width ="100%">

<thead>

<tr>

<th style="width: 10px">#</th>
<th>Name</th>
<th>User</th>
<th>Photo</th>
<th>Profile</th>
<th>Status</th>
<th>Last Login</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$item = null;
$value = null;

$users = ControlUsers::ctrShowUsers($item, $value);

foreach ($users as $key => $value) {
    echo '<tr>

                        <td>' . ($key + 1) . '</td>
                        <td>' . $value['name'] . '</td>
                        <td>' . $value['user'] . '</td>';

    if ($value['picture'] !== '') {
        echo '<td><img src="' . $value['picture'] . '" class = "img-thumbnail"
        width="40px"></td>';
    } else {
        echo '<td><img src="views/img/users/default/anonymous.png"
        class = "img-thumbnail" width="40px"></td>';
    }

    echo '<td>' . $value['profile'] . '</td>';

    if ($value['status'] !== 0) {
        echo '<td><button class="btn btn-success btn-xs btnActivate" idUser="'
        . $value['id'] . '" userStatus="0">Activated</button></td>';
    } else {
        echo '<td><button class="btn btn-danger btn-xs btnActivate" idUser="'
        . $value['id'] . '" userStatus="1">Deactivated</button></td>';
    }

    echo '<td>' . $value['last_login'] . '</td>

            <td>

              <div class="btn-group">

                <button class="btn btn-warning btnEditUser" idUser="'
                . $value['id'] . '" data-toggle = "modal"
                data-target = "#modalEditUser"><i class="fa fa-pencil"></i>
                </button>

                <button class="btn btn-danger btnDeleteUser" userId="'
                . $value['id'] . '" user="' . $value['user'] .
                  '" userPicture="' . $value['picture'] . '" >
                  <i class="fa fa-times"></i></button>

              </div>

            </td>

          </tr>';
}

?>

</tbody>

</table>

</div>

</div>

</section>

</div>

<!--=====================================
=  MODAL ADD USER
======================================-->

<!-- Modal -->
<div id="modalAddUser" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" enctype="multipart/form-data">

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background: #3c8dbc;color: white;">

<button type="button" class="close" data-dismiss="modal">&times;<td>

<div class="btn-group">

<button class="btn btn-warning btnEditUser" idUser="'
. $value['id'] . '" data-toggle = "modal"
data-target = "#modalEditUser"><i class="fa fa-pencil"></i></button>

<button class="btn btn-danger btnDeleteUser" userId="'
. $value['id'] . '" user="' . $value['user'] .
'" userPicture="' . $value['picture'] . '" ><i class="fa fa-times"></i></button>

</div>

</td>

</tr>';</button>

<h4 class="modal-title">Add User</h4>

</div>

<!--=====================================
=  MODAL BODY
======================================-->

<div class="modal-body">

<div class="box-body">

<!-- ENTRY FOR NAME -->
<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-user"></i></span>

<input type="text" class="form-control input-lg" name="newname"
placeholder="Insert name" required>

</div>

</div>

<!--ENTRY FOR USER -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-key"></i></span>

<input type="text" class="form-control input-lg" name="newUser" id="newUser"
placeholder="Enter Username" value="" required>

</div>

</div>

<!--  ENTRY FOR PASSWORD -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-lock"></i></span>

<input type="password" class="form-control input-lg" name="newPassword"
placeholder="Enter password" required>

</div>

</div>

<!-- ENTRY FOR FROFILE SELECTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-users"></i></span>

<select class="form-control input-lg" name="newProfile">

<option value="">Select Profile</option>

<option value="Administrator">Administrator</option>

<option value="Special">Special</option>

<option value="Seller">Seller </option>

</select>

</div>

</div>

<!-- INPUT FOR PICTURE -->

<div class="form-group">

<div class="panel"> UPLOAD PICTURE</div>

<input type="file" class="newPicture" name="newPicture">

<p class="help-block">Picture size max of 2MB</p>

<img src="views/img/users/default/anonymous.png" class="img-thumbnail preview"
width="100px" >

</div>

</div>

</div>

<!--=====================================
=  MODAL FOOTER
======================================-->

<div class="modal-footer">

<button type="button" class="btn btn-default pull-left"
data-dismiss="modal">Close</button>

<button type="submit"  class="btn btn-primary">Create User</button>

</div>

<?php

//php object ... method to save user
$createUser = new ControlUsers();
$createUser->ctrCreateUser();

?>

</form>

</div>

</div>

</div>
<!--====  End of module add user  ====-->

<!--=====================================
=  MODAL EDIT USER
======================================-->

<div id="modalEditUser" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="POST" enctype="multipart/form-data">

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background: #3c8dbc;color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Edit User</h4>

</div>

<!--=====================================
=  MODAL BODY
======================================-->

<div class="modal-body">

<div class="box-body">

<div class="form-group">

<!--    ENTRY FOR NAME -->

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-user"></i></span>

<input type="text" class="form-control input-lg" id="editName"
name="editName" value="" required>

</div>

</div>

<!--ENTRY FOR USER -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-key"></i></span>

<input type="text" class="form-control input-lg" id="editUser"
name="editUser" value="" readonly>

</div>

</div>

<!--  ENTRY FOR PASSWORD -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-lock"></i></span>

<input type="password" class="form-control" name="editPassword"
placeholder="Enter a new password">

<input type="hidden" id= "currentPassword" name="currentPassword">

</div>

</div>

<!-- ENTRY FOR FROFILE SELECTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-users"></i></span>

<select class="form-control input-lg" name="editProfile">

<option value="" id="editProfile"></option>

<option value="Administrator">Administrator</option>

<option value="special">Special</option>

<option value="seller">Seller </option>

</select>

</div>

</div>

<!-- INPUT FOR PICTURE -->

<div class="form-group">

<div class="panel"> INSERT PICTURE</div>

<input type="file" class="editPicture" name="editPicture">

<p class="help-block">Picture size max of 2MB</p>

<img src="views/img/users/default/anonymous.png"
class="img-thumbnail preview" width="100px" >

<input type="hidden"  name="currentPicture" id="currentPicture">

</div>

</div>

</div>

<!--=====================================
=  MODAL FOOTER
======================================-->

<div class="modal-footer">

<button type="button" class="btn btn-default pull-left"
data-dismiss="modal">Close</button>

<button type="submit" class="btn btn-primary">Modify User</button>

</div>

<?php

//php object ... method to save user
$editUser = new ControlUsers();
$editUser->ctrEditUser();

?>

</form>

</div>

</div>

</div>
<?php

$deleteUser = new ControlUsers();
$deleteUser->ctrDeleteUser();