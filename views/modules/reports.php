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

Sales Report

</h1>

<ol class="breadcrumb">

<li><a href="home"><i class="fa fa-dashboard"></i> Home Page</a></li>

<li class="active">Sales Report</li>

</ol>

</section>

<section class="content">

<div class="box">

<div class="box-header with-border">

<div class="input-group">

<button type="button" class="btn btn-default" id="daterange-btn2">

<span>
<i class="fa fa-calendar"></i> Date range
</span>

<i class="fa fa-caret-down"></i>

</button>

</div>

<div class="box-tools pull-right">

<?php

if (isset($_GET['initialDate'])) {
    echo '<a href="views/modules/download-report.php?report=report&initialDate='
    . $_GET['initialDate'] . '&finalDate=' . $_GET['finalDate'] . '">';
} else {
    echo '<a href="views/modules/download-report.php?report=report">';
}

?>

<button class="btn btn-success" style="margin-top:5px">Export to Excel</button>

</a>

</div>

</div>

<div class="box-body">

<div class="row">

<div class="col-xs-12">

<?php

include 'reports/sales-graph.php';

?>

</div>

<div class="col-md-6 col-xs-12">

<?php

include 'reports/bestselling-products.php';

?>

</div>

<div class="col-md-6 col-xs-12">

<?php

include 'reports/sellers.php';

?>

</div>

<div class="col-md-6 col-xs-12">

<?php

include 'reports/buyers.php';

?>

</div>

</div>

</section>

</div>