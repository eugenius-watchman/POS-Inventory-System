<?php

if ($_SESSION['profile'] === 'Seller') {
    echo '<script>

    window.location = "home";

  </script>';

    return;
}
?>

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
data-target="#modalAddProduct">

Add Product

</button>

</div>

<div class="box-body">

<table class="table table-bordered table-striped
dt-responsive tableProducts" width="100%">

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

</table>

<input type="hidden" value="<?php echo $_SESSION['profile']; ?>"
id="hiddenProfile">

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

<!-- ENTRY FOR CATEGORY SELECTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-th"></i></span>

<select class="form-control input-lg" id="newCategory"
name="newCategory" required>

<option value="">Select Category</option>
<?php

$item = null;
$value = null;

$categories = ControlCategories::ctrShowCategories($item, $value);

foreach ($categories as $key => $value) {
    echo '<option value="' . $value['id'] . '">' .
    $value['category'] . '</option>';
}

?>

</select>

</div>

</div>

<div class="form-group">

<!--    ENTRY FOR CODE -->

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-code"></i></span>

<input type="text" class="form-control input-lg" id="newCode" name="newCode"
placeholder="Enter Code" readonly required>

</div>

</div>

<!--ENTRY FOR DESCRIPTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

<input type="text" class="form-control input-lg" id="newDescription"
name="newDescription" placeholder=" Enter Description" required>

</div>

</div>

<!--ENTRY FOR STOCK -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-check"></i></span>

<input type="number" class="form-control input-lg" id="newStock"
name="newStock" min="0" placeholder="Stock" required>

</div>

</div>

<!--ENTRY FOR BUYING PRICE -->

<div class="form-group row">

<div class="col-xs-12 col-sm-6">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

<input type="number" class="form-control input-lg" id="newBuyingPrice"
name="newBuyingPrice" min="0" step="any" placeholder="Buying Price" required>

</div>

</div>

<!--ENTRY FOR SALE PRICE -->

<div class="col-xs-12 col-sm-6">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>

<input type="number" class="form-control input-lg" id="newSalePrice"
name="newSalePrice" min="0" step="any" placeholder="Sale Price" required>

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

<!-- INPUT FOR IMAGE -->

<div class="form-group">

<div class="panel"> UPLOAD IMAGE</div>

<input type="file" class="newImage" name="newImage">

<p class="help-block">Image size max of 2Mb</p>

<img src="views/img/products/default/anonymous.png"
class="img-thumbnail preview" width="100px">

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

<?php

$createProduct = new ControlProducts();
$createProduct->ctrCreateProduct();

?>

</div>

</div>

</div>

<!--=====================================
=  MODAL EDIT PRODUCT
======================================-->

<div id="modalEditProduct" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" enctype="multipart/form-data">

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background: #3c8dbc; color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Edit Product</h4>

</div>

<!--=====================================
=  MODAL BODY
======================================-->

<div class="modal-body">

<div class="box-body">

<!-- ENTRY FOR CATEGORY SELECTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-th"></i></span>

<select class="form-control input-lg"  name="editCategory" readonly required>

<option id="editCategory"></option>

</select>

</div>

</div>

<div class="form-group">

<!--    ENTRY FOR CODE -->

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-code"></i></span>

<input type="text" class="form-control input-lg" id="editCode"
name="editCode"  readonly required>

</div>

</div>

<!--ENTRY FOR DESCRIPTION -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

<input type="text" class="form-control input-lg" id="editDescription"
name="editDescription"  required>

</div>

</div>

<!--ENTRY FOR STOCK -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-check"></i></span>

<input type="number" class="form-control input-lg" id="editStock"
name="editStock" min="0"  required>

</div>

</div>

<!--ENTRY FOR BUYING PRICE -->

<div class="form-group row">

<div class="col-xs-12 col-sm-6">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

<input type="number" class="form-control input-lg" id="editBuyingPrice"
name="editBuyingPrice" min="0" step="any"  required>

</div>

</div>

<!--ENTRY FOR SALE PRICE -->

<div class="col-xs-12 col-sm-6">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>

<input type="number" class="form-control input-lg" id="editSalePrice"
name="editSalePrice" min="0" step="any" readonly required>

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

<input type="number" class="form-control input-lg newPercentage"
min="0" value="40" required>

<span class="input-group-addon"><i class="fa fa-percent"></i></span>

</div>

</div>

</div>

</div>

<!-- INPUT FOR IMAGE -->

<div class="form-group">

<div class="panel"> UPLOAD IMAGE</div>

<input type="file" class="newImage" name="editImage">

<p class="help-block">Image size max of 2Mb</p>

<img src="views/img/products/default/anonymous.png"
class="img-thumbnail preview" width="100px">

<input type="hidden" name="actualImage" id="actualImage">

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

<?php

$editProduct = new ControlProducts();
$editProduct->ctrEditProduct();

?>

</div>

</div>

</div>

<?php

$deleteProduct = new ControlProducts();
$deleteProduct->ctrDeleteProduct();