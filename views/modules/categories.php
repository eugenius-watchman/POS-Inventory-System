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

Manage Categories

</h1>

<ol class="breadcrumb">

<li><a href="home"><i class="fa fa-dashboard"></i> Home </a></li>

<li class="active">Manage Categories</li>

</ol>

</section>

<section class="content">

<div class="box">

<div class="box-header with-border">

<button class="btn btn-primary" data-toggle="modal" data-target="#modalAddCategories">

Add Categories

</button>

</div>

<div class="box-body">

<table class="table table-bordered table-striped dt-responsive tables">

<thead>

<tr>

<th style="width:10px">#</th>
<th>Categories</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

$item = null;
$value = null;

$categories = ControlCategories::ctrShowCategories($item, $value);

foreach ($categories as $key => $value) {
    echo '<tr>

                <td>' . ($key + 1) . '</td>

                  <td class="text-uppercase">' . $value['category'] . '</td>

                <td>

                <div class="btn-group">

                <button class="btn btn-warning btn-warning btnEditCategory"
                  idCategory="' . $value['id'] . '" data-toggle="modal"
                  data-target="#modalEditCategory"><i class="fa fa-pencil"></i>
                </button>';

    if ($_SESSION['profile'] === 'Administrator') {
        echo '<button class="btn btn-danger btnDeleteCategory"
                idCategory="' . $value['id'] . '"><i class="fa fa-times"></i>
              </button>';
    }

    echo '</div>

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
=  MODAL ADD CATEGORY
======================================-->

<div id="modalAddCategories" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" >

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background: #3c8dbc;color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Add Category</h4>

</div>

<!--=====================================
=  MODAL BODY
======================================-->

<div class="modal-body">

<div class="box-body">

<!--    ENTRY FOR NAME -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-th"></i></span>

<input type="text" class="form-control input-lg" name="newCategory" placeholder="Add Category" required>

</div>

</div>

</div>

</div>
<!--=====================================
=  MODAL FOOTER
======================================-->

<div class="modal-footer">

<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

<button type="submit" class="btn btn-primary">Save Category</button>

</div>

<?php

$createCategory = new ControlCategories();
$createCategory->ctrCreateCategory();

?>

</form>

</div>

</div>

</div>

<!--=====================================
=  MODAL EDIT CATEGORY
======================================-->

<div id="modalEditCategory" class="modal fade" role="dialog">

<div class="modal-dialog">

<div class="modal-content">

<form role="form" method="post" >

<!--=====================================
=  MODAL HEADER
======================================-->

<div class="modal-header" style="background:#3c8dbc; color: white;">

<button type="button" class="close" data-dismiss="modal">&times;</button>

<h4 class="modal-title">Edit Category</h4>

</div>

<!--=====================================
=  MODAL BODY
======================================-->

<div class="modal-body">

<div class="box-body">

<!--    ENTRY FOR NAME -->

<div class="form-group">

<div class="input-group">

<span class="input-group-addon"><i class="fa fa-th"></i></span>

<input type="text" class="form-control input-lg" name="editCategory" id="editCategory" required>

<input type="hidden"  name="idCategory" id="idCategory" required>

</div>

</div>

</div>

</div>
<!--=====================================
=  MODAL FOOTER
======================================-->

<div class="modal-footer">

<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

<button type="submit" class="btn btn-primary">Save Changes</button>

</div>

<?php

$editCategory = new ControlCategories();
$editCategory->ctrEditCategory();

?>

</form>

</div>

</div>

</div>

<?php

$deleteCategory = new ControlCategories();
$deleteCategory->ctrDeleteCategory();