
<div class="content-wrapper">

<section class="content-header">

<h1>

Manage Products

</h1>

<ol class="breadcrumb">

<li><a href="home"><i class="fa fa-dashboard"></i> Home Page</a></li>

<li class="active">Product Management</li>

</ol>

</section>

<section class="content">

<div class="box">

<div class="box-header with-border">

<button class="btn btn-primary" data-toggle="modal"
data-target=#modalAddProduct>

Add Product

</button>

</div>

<div class="box-body">

<table class="table table-bordered table-striped dt-responsive tables">

<thead>

<tr>

<th style="width: 10px">#</th>
<th>Image</th>
<th>Code</th>
<th>Description</th>
<th>Category</th>
<th>Stock</th>
<th>Buying Price</th>
<th>Sale Price</th>
<th>Date added</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<tr>

<td>1</td>
<td><img src="views/img/products/default/anonymous.png" class="ing-thumbnail"
width="40px"></td>
<td>0001</td>
<td>Lets talk more about the product,okay.</td>
<td>Product category details</td>
<td>20</td>
<td>$5.00</td>
<td>$10.00</td>
<td>2021-06-03 13:55:00 </td>
<td>
<div class="btn-group">

<button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

<button class="btn btn-danger"><i class="fa fa-times"></i></button>

</div>

</td>

</tr>

<tr>

<td>1</td>
<td><img src="views/img/products/default/anonymous.png" class="ing-thumbnail"
width="40px"></td>
<td>0001</td>
<td>Lets talk more about the product,okay.</td>
<td>Product category details</td>
<td>20</td>
<td>$5.00</td>
<td>$10.00</td>
<td>2021-06-03 13:55:00 </td>
<td>
<div class="btn-group">

<button class="btn btn-warning"><i class="fa fa-pencil"></i></button>

<button class="btn btn-danger"><i class="fa fa-times"></i></button>

</div>

</td>

</tr>

<tr>

<td>1</td>
<td><img src="views/img/products/default/anonymous.png"
class="ing-thumbnail" width="40px"></td>
<td>0001</td>
<td>Lets talk more about the product,okay.</td>
<td>Product category details</td>
<td>20</td>
<td>$5.00</td>
<td>$10.00</td>
<td>2021-06-03 13:55:00 </td>
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
=  MODAL ADD PRODUCT
======================================-->

<div id="modalAddProduct" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" enctype="multipart/form-data">

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background: #3c8dbc; color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Add Product</h4>

</div>

<!--=====================================
=  MODAL BODY
======================================-->

<div class="modal-body">

<div class="box-body">

<div class="form-group">

<!--    ENTRY FOR CODE -->

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-code"></i></span>
a
<!--ENTRY FOR DESCRIPTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

<input type="text" class="form-control input-lg" name="newDescription"
placeholder=" Enter Description" required>

</div>

</div>

<!-- ENTRY FOR CATEGORY SELECTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-th"></i></span>

<select class="form-control input-lg" name="newCategory">

<option value="">Select Category</option>

<option value="Drills<">Drills</option>

<option value="Scaffold">Scaffold</option>

<option value="Construction Equipments">Construction Equipments</option>

</select>

</div>

</div>

<!--ENTRY FOR STOCK -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-product-check"></i></span>

<input type="number" class="form-control input-lg" name="newStock" min="0"
placeholder="Stock" required>

</div>

</div>

<!--ENTRY FOR BUYING PRICE -->

<div class="form-group row">

<div class="col-xs-12 col-sm-6">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

<input type="number" class="form-control input-lg" name="newBuyingPrice" min="0"
placeholder="Buying Price" required>

</div>

</div>

<!--ENTRY FOR SALE PRICE -->

<div class="col-xs-12 col-sm-6">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>

<input type="number" class="form-control input-lg" name="newSalePrice" min="0"
placeholder="Sale Price" required>

</div>

<br>

<!-- CHECKBOX FOR PERCENTAGE -->

<div class="col-xs-6">

<div class="form-group">

<label>
<input type="checkbox" class="minimal percentage" checked>

Use percentage

</label>

</div>

</div>

<!-- INPUT FOR PERCENTAGE -->

<div class="col-xs-6" style="padding:0">

<div class="input-group">

<input type="number" class="form-control input-lg newPercentage" min="0"
value="40" required>

<span class="input-group-addon"><i class="fa fa-percent"></i></span>

</div>

</div>

</div>

</div>

<!-- INPUT FOR PICTURE -->

<div class="form-group">

<div class="panel"> UPLOAD PICTURE</div>

<input type="file" id="newImage" name="newImage">

<p class="help-block">Picture size max of 2Mb</p>

<img src="views/img/products/default/anonymous.png"
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

<button type="submit" class="btn btn-primary">Save Product</button>

</div>

</form>

</div>

</div>

</div>