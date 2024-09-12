
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

<button class="btn btn-primary" data-toggle="modal" data-target=#modalAddUser>

Add User

</button>

</div>

<div class="box-body">

<table class="table table-bordered table-striped dt-responsive tables">

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

<tr>

<td>1</td>
<td>User Adminnistrator</td>
<td>admin</td>
<td><img src="views/img/users/default/anonymous.png" width="40px"></td>
<td>Administrator</td>
<td><button class="btn btn-success btn-xs">Activated</button></td>
<td>2021-04-03 11:02:14</td>
<td>
<div class="btn-group">

<button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

<button class="btn btn-danger"><i class="fa fa-times"></i></button>

</div>

</td>

</tr>

<tr>

<td>2</td>
<td>User Adminnistrator</td>
<td>admin</td>
<td><img src="views/img/users/default/anonymous.png" width="40px"></td>
<td>Administrator</td>
<td><button class="btn btn-success btn-xs">Activated</button></td>
<td>2021-04-03 11:02:14</td>
<td>
<div class="btn-group">

<button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

<button class="btn btn-danger"><i class="fa fa-times"></i></button>

</div>

</td>

</tr>

<tr>

<td>3</td>
<td>User Adminnistrator</td>
<td>admin</td>
<td><img src="views/img/users/default/anonymous.png" width="40px"></td>
<td>Administrator</td>
<td><button class="btn btn-danger btn-xs">Deactivated</button></td>
<td>2021-04-03 11:02:14</td>
<td>
<div class="btn-group">

<button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

<button class="btn btn-danger"><i class="fa fa-times"></i></button>

</div>

</td>

</tr>

</tbody>

</table>

</div>

</div>

</section>

</div>

<!--=====================================
=  MODAL ADD USER
======================================-->

<div id="modalAddUser" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" enctype="multipart/form-data">

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background: #3c8dbc;color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Add User</h4>

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

<input type="text" class="form-control" name="newname"
placeholder="Insert name" required>

</div>

</div>

<!--ENTRY FOR USER -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-key"></i></span>

<input type="text" class="form-control" name="newUser"
placeholder=" Enter User" required>

</div>

</div>

<!--  ENTRY FOR PASSWORD -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-lock"></i></span>

<input type="password" class="form-control" name="newPassword"
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

<option value="Stock">Stock</option>

<option value="Seller">Seller Profile</option>

</select>

</div>

</div>

<!-- INPUT FOR PICTURE -->

<div class="form-group">

<div class="panel"> INSERT PICTURE</div>

<input type="file" id="newPicture" name="newPicture">

<p class="help-block">Picture size max of 200Mb</p>

<img src="views/img/users/default/anonymous.png"
class="img-thumbnail" with="100px">

</div>

</div>

</div>

<!--=====================================
=  MODAL FOOTER
======================================-->

<div class="modal-footer">

<button type="button" class="btn btn-default pull-left"
data-dismiss="modal">Close</button>

<button type="submit" class="btn btn-primary">Save changes</button>

</div>

</form>

</div>

</div>

</div>