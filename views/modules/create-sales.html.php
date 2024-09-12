
<div class="content-wrapper">

<section class="content-header">

<h1>

Client Sales

</h1>

<ol class="breadcrumb">

<li><a href="#"><i class="fa fa-dashboard"></i> Home Page</a></li>

<li class="active">Client Sales</li>

</ol>

</section>

<!-- =============================Main content ==============================-->
<section class="content">

<div class="row">

<!-- ============================= FORMULAE ==============================-->

<div class="col-lg-5 col-xs-12">

<div class="box box-success">

<div class="box-header with-border"></div>

<form role="form" method="post">

<div class="box-body">

<div class="box">

<!-- ======== SELLER INPUT =========-->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-user"></i></span>
<input type="text" class="form-control" name="newSeller" id="newSeller" value="User Administrator" readonly>

</div>

</div>

<!-- ======== CODE INPUT =========-->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-key"></i></span>
<input type="text" class="form-control" name="newSeller" id="newSeller" value="123456" readonly>

</div>

</div>

<!-- ======== CUSTOMER INPUT =========-->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-users"></i></span>

<select type="text" class="form-control" name="selectClient" id="selectClient" required>

<option value="">Select Client</option>

</select>

<span class="input-group-addon"><button type="button" class="btn btn-default btn-xs"
data-toggle="modal" data-target="#modalAddClient" data-dismiss="modal"> Add Client </button></span>

</div>

</div>

<!-- ======== PRODUCT INPUT =========-->

<div class="form-group row newProduct">

<!--**Product Type**-->

<div class="col-xs-6" style="padding-right:0px">

<div class="input-group">

<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs">
<i class="fa fa-times"></i></button></span>

<input type="text" class="form-control" name="addProduct" id="addProduct" placeholder="Product Type" required>

</div>

</div>

<!--**Product Quantity**-->

<div class="col-xs-3">

<input type="number" class="form-control" name="newProductQty" id="newProductQty" min="1" placeholder="0" required>

</div>

<!--**Product Price**-->

<div class="col-xs-3" style="padding-left:0px">

<div class="input-group">

<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

<input type="number" class="form-control" name="newProductPrice" id="newProductPrice" min="1" placeholder="000000" readonly required>

</div>

</div>

</div>

<!-- ======== ADD PRODUCT BUTTON  =========-->

<button type="button" class="btn btn-default hidden-lg">Add Product</button>

<hr>

<div class="row">

<!-- ======== TAXES AND TOTAL INPUT =========-->

<div class="col-xs-8 pull-right">

<table class="table">

<thead>

<tr>
<th>Tax</th>
<th>Total</th>
</tr>

</thead>

<tbody>

<tr>

<td style="width: 50%">

<div class="input-group">

<input type="number" class="form-control" min="0" name="newTaxPrice" id="newTaxPrice"  placeholder="0" required>

<span class="input-group-addon"><i class="fa fa-percent"></i></span>

</div>

</td>

<td style="width: 50%">

<div class="input-group">

<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

<input type="number" class="form-control" name="newTotalSale" id="newTotalSale" min="1"
placeholder="000000" readonly required>

</div>

</td>

</tr>

</tbody>

</table>

</div>

</div>

<hr>

<!-- ========INPUT FOR METHOD/MODE OF PAYMENT=========-->

<div class="form-group row">

<div class="col-xs-6">

<div class="input-group">

<select class="form-control" name="newPaymentMode" id="newPaymentMode" required>

<option value="">Select Mode of Payment</option>
<option value="cash">Cash</option>
<option value="creditCard">Credit Card</option>
<option value="debitCard">Debit Card</option>
<option value="mobileMoney">Mobile Money</option>

</select>

</div>

</div>

<div class="col-xs-6" style="padding-left:0px;">

<div class="input-group">

<input type="text" class="form-control" name="newTransactionCode" id="newTransactionCode"
placeholder="Transaction Code" required>

<span class="input-group-addon"><i class="fa fa-lock"></i></span>

</div>

</div>

</div>

<br>

</div>

</div>

<div class="box-footer">

<button type="submit" class="btn btn-primary pull-right">Save Sale</button>

</div>

</form>

</div>

</div>

<!-- ============================= PRODUCTS TABLE  =======================-->

<div class="col-lg-7 hidden-md hidden-sm hidden-xs">

<div class="box box-warning">

<div class="box-header with-border"></div>

<div class="box-body">

<table class="table table-bordered table-stripped dt-responsive tables">

<thead>

<tr>
<th style="width:10px">#</th>
<th>Image</th>
<th>Code</th>
<th>Description</th>
<th>Stock</th>
<th>Actions</th>
</tr>

</thead>

<tbody>

<tr>
<td>1.</td>
<td><img src="views/img/products/default/anonymous.png" class="img-thumbnail" width="40px"></td>
<td>01234</td>
<td>Lets do business</td>
<td>20</td>
<td>

<div class="btn-group">

<button type="button" class="btn btn-primary">Add</button>

</div>

</td>
</tr>

</tbody>
</table>

</div>

</div>

</div>

</div>

</section>

</div>

<!--=================== ADD CLIENT =========================-->

<div id="modalAddClient" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" >

<!--============= MODAL HEADER =======================-->

<div class="modal-header" style="background: #3c8dbc;color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Add Client</h4>

</div>

<!--============ MODAL BODY=================-->

<div class="modal-body">

<div class="box-body">

<!--========= ENTRY FOR NAME ============ -->

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

<?php

$createClient = new ControlClients();
$createClient->ctrCreateClient();

?>

</div>

</div>

</div>