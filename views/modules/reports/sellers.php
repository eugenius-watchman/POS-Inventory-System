<?php

$item = null;
$value = null;

$sales = ControlSales::ctrShowSales($item, $value);
$users = ControlUsers::ctrShowUsers($item, $value);

$arraySellers = array();
$arraySellersList = array();

foreach ($sales as $key => $valueSales) {
    foreach ($users as $key => $valueUsers) {
        if ($valueUsers['id'] === $valueSales['id_seller']) {
            #Capture sellers in an array
            array_push($arraySellers, $valueUsers['name']);

            #Capture the names and net values in the same array
            $arraySellersList = array($valueUsers['name'] => $valueSales['net']);

            #Add the netprice of each seller
            foreach ($arraySellersList as $key => $value) {
                $addingTotalSales[$key] += $value;
            }
        }
    }
}

#Avoiding repeated names
$dontrepeatnames = array_unique($arraySellers);

?>

<!--=====================================
SELLERS
======================================-->

<div class="box box-success">

<div class="box-header with-border">

<h3 class="box-title">Sellers</h3>

</div>

<div class="box-body">

<div class="chart-responsive">

<div class="chart" id="bar-chart1" style="height: 300px;"></div>

</div>

</div>

</div>

<script>

//BAR CHART
var bar = new Morris.Bar({
element: 'bar-chart1',
resize: true,
data: [

<?php

foreach ($dontrepeatnames as $value) {
    echo "{y: '" . $value . "', a: '" . $addingTotalSales[$value] . "'},";
}

?>
],
barColors: ['#0af'],
xkey: 'y',
ykeys: ['a'],
labels: ['sales'],
preUnits: '$',
hideHover: 'auto'
});
</script>