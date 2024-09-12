<?php

error_reporting(0);

if (isset($_GET['initialDate'])) {
    $initial_date = $_GET['initialDate'];
    $finalDate = $_GET['finalDate'];
} else {
    $initialDate = null;
    $finalDate = null;
}

$reply = ControlSales::ctrSalesDatesRange($initialDate, $finalDate);

$arrayDates = array();
$arraySales = array();
$addingMonthlyPayments = array();

foreach ($reply as $key => $value) {
    #Capture only year and month
    $date = substr($value['date'], 0, 7);

    #Introduce dates in arrayDates
    array_push($arrayDates, $date);

    #Capture the sales
    $arraySales = array($date => $value['total']);

    #Adding payments made in the same month
    foreach ($arraySales as $key => $value) {
        $addingMonthlyPayments[$key] += $value;
    }
}

$dontRepeatDates = array_unique($arrayDates);

?>

<!--=====================================
SALES GRAPH
======================================-->

<div class="box box-solid bg-teal-gradient">

<div class="box-header">

<i class="fa fa-th"></i>

<h3 class="box-title">Sales Graph</h3>

</div>

<div class="box-body border-radius-none newSalesGraph">

<div class="chart" id="line-chart-sales" style="height: 250px;"></div>

</div>

</div>

<script>

var line = new Morris.Line({
element          : 'line-chart-sales',
resize           : true,
data             : [

<?php

if ($dontRepeatDates !== null) {
    foreach ($dontRepeatDates as $key) {
        echo "{ y: '" . $key . "', sales: " . $addingMonthlyPayments[$key] . ' },';
    }

    echo "{y: '" . $key . "', sales: " . $addingMonthlyPayments[$key] . ' }';
} else {
    echo "{ y: '0', sales: '0' }";
}

?>

],
xkey             : 'y',
ykeys            : ['sales'],
labels           : ['sales'],
lineColors       : ['#efefef'],
lineWidth        : 2,
hideHover        : 'auto',
gridTextColor    : '#fff',
gridStrokeWidth  : 0.4,
pointSize        : 4,
pointStrokeColors: ['#efefef'],
gridLineColor    : '#efefef',
gridTextFamily   : 'Open Sans',
preUnits         : '$',
gridTextSize     : 10
});

</script>