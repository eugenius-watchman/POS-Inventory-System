<?php

if ($_SESSION['profile'] === 'Special') {
    echo '<script>

    window.location = "home";

  </script>';

    return;
}

?>

<div class="content-wrapper">

<section class="content-header">

<h1>

Manage Sales

</h1>

<ol class="breadcrumb">

<li><a href="home"><i class="fa fa-dashboard"></i> Home </a></li>

<li class="active">Manage Sales</li>

</ol>

</section>

<section class="content">

<div class="box">

<div class="box-header with-border">

<a href="create-sales">

<button class="btn btn-primary" >

Add Sale

</button>

</a>

<button type="button" class="btn btn-default pull-right" id="daterange-btn">

<span>
<i class="fa fa-calendar"></i> Date range
</span>

<i class="fa fa-caret-down"></i>

</button>

</div>

<div class="box-body">

<table class="table table-bordered table-striped dt-responsive tables" width="100%">

<thead>

<tr>

<th style="width:10px">#</th>
<th>Invoice code</th>
<th>Client</th>
<th>Seller</th>
<th>Mode of Payment</th>
<th>Net cost</th>
<th>Total cost</th>
<th>Date</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

if (isset($_GET['initialDate'])) {
    $initialDate  = $_GET['initialDate'];
    $finalDate    = $_GET['finalDate'];
} else {
    $initialDate  = null;
    $finalDate    = null;
}

$item = null;
$value = null;

$reply = ControlSales::ctrSalesDatesRange($initialDate, $finalDate);

foreach ($reply as $key => $value) {
    echo ' <tr>

                            <td>' . ($key + 1) . '</td>

                              <td>' . $value['code'] . '</td>';

    $itemClient = 'id';
    $valueClient = $value['id_client'];

    $replyClient = ControlClients::ctrShowClients($itemClient, $valueClient);

    echo '<td>' . $replyClient['name'] . '</td>';

    $itemUser = 'id';
    $valueUser = $value['id_seller'];

    $replyUser = ControlUsers::ctrShowUsers($itemUser, $valueUser);

    echo '<td>' . $replyUser['name'] . '</td>

                              <td>' . $value['mode_payment'] . '</td>

                              <td>' . number_format($value['net'], 2) . '</td>

                              <td>' . number_format($value['total'], 2) . '</td>

                              <td>' . $value['date'] . '</td>

                            <td>

                              <div class="btn-group">

                                <button class="btn btn-info btnPrintBill" saleCode="' . $value['code'] . '">

                                  <i class="fa fa-print"></i>

                                </button>';

    if ($_SESSION['profile'] === 'Administrator') {
        echo '<button class="btn btn-warning btnEditSale" idSale="'
        . $value['id'] . '"><i class="fa fa-pencil"></i></button>

        <button class="btn btn-danger btnDeleteSale" idSale="'
        . $value['id'] . '""><i class="fa fa-times"></i></button>';
    }
    echo '</div>

                            </td>

                        </tr>';
}

?>

</tbody>

</table>

<?php

$deleteSale = new ControlSales();
$deleteSale->ctrDeleteSales();

?>

</div>

</div>

</section>

</div>