
<div class="content-wrapper">

<section class="content-header">

<h1>

Manage Clients

</h1>

<ol class="breadcrumb">

<li><a href="home"><i class="fa fa-dashboard"></i> Home </a></li>

<li class="active">Manage Clients</li>

</ol>

</section>

<section class="content">

<div class="box">

<div class="box-header with-border">

<button class="btn btn-primary" data-toggle="modal" data-target="#modalAddClient">

Add Client

</button>

</div>

<div class="box-body">

<table class="table table-bordered table-striped dt-responsive tables" width="100%">

<thead>

<tr>

<th style="width:10px">#</th>
<th>Name</th>
<th>Document ID</th>
<th>Email</th>
<th>Telephone</th>
<th>Address</th>
<th>Birthday</th>
<th>Total purchases</th>
<th>Last purchase</th>
<th>Last login</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<tr>

<td>1</td>

<td>Eugenius Darrah</td>
<td>1234852</td>
<td>eugenius@ymail.com</td>
<td>080 2882 338</td>
<td>Adenta #127 Aviation St.</td>
<td>1994-28-09</td>
<td>76</td>
<td>2021-10-05 12:05:45</td>
<td>2021-10-05 12:05:45</td>

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
=  ADD CLIENT
======================================-->

<div id="modalAddClient" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" >

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background: #3c8dbc;color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Add Client</h4>

</div>

<!--=====================================
=  MODAL BODY
======================================-->

<div class="modal-body">

<div class="box-body">

<!--    ENTRY FOR NAME -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-user"></i></span>

<input type="text" class="form-control input-lg" name="newClient" placeholder="Enter Name" required>

</div>

</div>

<!--    ENTRY FOR DOCUMENT ID-->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-key"></i></span>

<input type="number" min="0" class="form-control input-lg" name="newDocumentId" placeholder="Enter Document ID" required>

</div>

</div>

<!--    ENTRY FOR EMAIL -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-envelope"></i></span>

<input type="email" class="form-control input-lg" name="newEmail" placeholder="Enter Email" required>

</div>

</div>

<!--    ENTRY FOR TELEPHONE -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-phone"></i></span>

<input type="text" class="form-control input-lg" name="newTelephone" placeholder="Enter Telephone"
data-inputmask="'mask':'(999) 999-9999'" data-mask required>

</div>

</div>

<!--    ENTRY FOR ADDRESS -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

<input type="text" class="form-control input-lg" name="newAddress" placeholder="Enter Address" required>

</div>

</div>

<!--    ENTRY FOR BIRTHDAY -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-calendar"></i></span>

<input type="text" class="form-control input-lg" name="newBirthday" placeholder="Enter Birthday"
data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>

</div>

</div>

</div>

</div>
<!--=====================================
=  MODAL FOOTER
======================================-->

<div class="modal-footer">

<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

<button type="submit" class="btn btn-primary">Save Client</button>

</div>

</form>

</div>

</div>

</div>