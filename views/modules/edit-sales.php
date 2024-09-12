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

<!-- ======================== Main content =========================-->
<section class="content">

<div class="row">

<!-- =============================
FORM
==============================-->

<div class="col-lg-5 col-xs-12">

<div class="box box-success">

<div class="box-header with-border"></div>

<form role="form" method="post" class="formSales">

<div class="box-body">

<div class="box">

<?php

$item = 'id';
$value = $_GET['idSale'];

$sale = ControlSales::ctrShowSales($item, $value);

$itemUser = 'id';
$valueUser = $sale['id_seller'];

$seller = ControlUsers::ctrShowUsers($itemUser, $valueUser);

$itemClient = 'id';
$valueClient = $sale['id_client'];

$client = ControlClients::ctrShowClients($itemClient, $valueClient);

$percentageTax = round(($sale['total'] * 100 / $sale['net'])- 100);

?>

<!-- ===================
SELLER INPUT
======================-->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-user"></i></span>

<input type="text" class="form-control" id="newSeller" value="<?php echo $seller['name']; ?>" readonly>

<input type="hidden" name="sellerId" value="<?php echo $seller['id']; ?>">

</div>

</div>

<!-- ==================
CODE INPUT
=====================-->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-key"></i></span>

<input type="text" class="form-control" id="newSale" name="editSale" value="<?php echo $sale['code']; ?>" readonly>

</div>

</div>

<!-- ====================
CUSTOMER INPUT
=======================-->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-users"></i></span>

<select type="text" class="form-control" name="selectClient" id="selectClient" required>

<option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>

<?php

$item = null;
$value = null;

$categories = ControlClients::ctrShowClients($item, $value);

foreach ($categories as $key => $value) {
    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
}

?>

</select>

<span class="input-group-addon"><button type="button" class="btn btn-default btn-xs"
data-toggle="modal" data-target="#modalAddClient" data-dismiss="modal"> Add Client </button></span>

</div>

</div>

<!-- ======================
PRODUCT INPUT
========================-->

<div class="form-group row newProduct">

<?php

$listProduct = json_decode($sale['products'], true);

if (is_array($listProduct)) {
    foreach ($listProduct as $key => $value) {
        $item = 'id';
        $valuePdt = $value['id'];
        $order = 'id';

        $reply = ControlProducts::ctrShowProducts($item, $valuePdt, $order);

        $lastStock = $reply['stock'] + $value['quantity'];

        echo '<div class="row" style="padding:5px 15px">

                <div class="col-xs-6" style="padding-right:0px">

                    <div class="input-group">

                        <span class="input-group-addon"><button type="button"
                        class="btn btn-danger btn-xs removeProduct" idProduct="' . $value['id'] . '">
                        <i class="fa fa-times"></i></button></span>

                        <input type="text" class="form-control  newProductType"
                        idProduct="' . $value['id'] . '" name="addProduct"
                        value="' . $value['description'] . '" readonly required>

                    </div>

                </div>

                <div class="col-xs-3">

                    <input type="number" class="form-control newProductQty"
                    name="newProductQty" min="0" value="' . $value['quantity']
                    . '" stock="' . $lastStock . '" newStock="' . $value['stock'] . '" required>

                </div>

                <div class="col-xs-3 enterPrice" style="padding-left:0px">

                    <div class="input-group">

                        <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                        <input type="text" class="form-control newProductPrice"
                        realPrice="' . $reply['sale_price'] . '"
                        name="newProductPrice" value="' . $value['total'] . '" readonly required>

                    </div>

                </div>

        </div>';
    }
}

?>

</div>

<input type="hidden" id="productsList" name="productsList">

<!-- =====================
ADD PRODUCT BUTTON
===========================-->

<button type="button" class="btn btn-default hidden-lg btnAddProduct">
Add Product</button>

<hr>

<div class="row">

<!-- ==========================
TAXES AND TOTAL INPUT
==============================-->

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

<input type="number" class="form-control  input-lg" min="0" name="newTaxPrice"
id="newTaxPrice" value="<?php echo $percentageTax; ?>" placeholder="0" required>

<input type="hidden" name="currentTaxPrice" id="currentTaxPrice"
value="<?php echo $sale['tax']; ?>" required>

<input type="hidden" name="newNetPrice" id="newNetPrice"
value="<?php echo $sale['net']; ?>" required>

<span class="input-group-addon"><i class="fa fa-percent"></i></span>

</div>

</td>

<td style="width: 50%">

<div class="input-group">

<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

<input type="text" class="form-control input-lg" name="newTotalSale" id="newTotalSale"
total="<?php echo $sale['net']; ?>" value="<?php echo $sale['total']; ?>" readonly required>

<input type="hidden" id="totalSale" name="totalSale" value="<?php echo $sale['total']; ?>"  required>

</div>

</td>

</tr>

</tbody>

</table>

</div>

</div>

<hr>

<!-- ===============================
INPUT FOR METHOD/MODE OF PAYMENT
====================================-->

<div class="form-group row">

<div class="col-xs-6">

<div class="input-group">

<select class="form-control" name="newPaymentMode" id="newPaymentMode" required>

<option value="">Select Mode of Payment</option>
<option value="Cash">Cash</option>
<option value="CC">Credit Card</option>
<option value="DC">Debit Card</option>
<option value="MM">Mobile Money</option>

</select>

</div>

</div>

<div class="paymentModeBoxes"></div>

<input type="hidden" id="listPaymentMode" name="listPaymentMode">

</div>

<br>

</div>

</div>

<div class="box-footer">

<button type="submit" class="btn btn-primary pull-right">Save Changes</button>

</div>

</form>

<?php

$editSales = new ControlSales();
$editSales->ctrEditSales();

?>

</div>

</div>

<!-- =============================
PRODUCTS TABLE
=================================-->

<div class="col-lg-7 hidden-md hidden-sm hidden-xs">

<div class="box box-warning">

<div class="box-header with-border"></div>

<div class="box-body">

<table class="table table-bordered table-stripped dt-responsive tableSales">

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