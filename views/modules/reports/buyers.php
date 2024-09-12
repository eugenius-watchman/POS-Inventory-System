<?php

$item = null;
$value = null;

$sales = ControlSales::ctrShowSales($item, $value);
$customers = ControlClients::ctrShowClients($item, $value);

$arrayCustomers = array();
$arrayCustomersList = array();

foreach ($sales as $key => $valueSales) {
    foreach ($customers as $key => $value_customers) {
        if ($valueCustomers['id'] === $valueSales['id_client']) {
            #Capture Customers in an array
            array_push($arrayCustomers, $valueCustomers['name']);

            #Capture the names and net values in the same array
            $arrayCustomersList = array($valueCustomers['name'] => $valueSales['net']);

            #Add the netprice of each Customer
            foreach ($arrayCustomersList as $key => $value) {
                $addingTotalSales[$key] += $value;
            }
        }
    }
}

#Avoiding repeated names
$dontrepeatnames = array_unique($arrayCustomers);

?>

<!--=====================================
Customers
======================================-->

<div class="box box-success">

<div class="box-header with-border">

<h3 class="box-title">Clients</h3>

</div>

<div class="box-body">

<div class="chart-responsive">

<div class="chart" id="bar-chart2" style="height: 300px;"></div>

</div>

</div>

</div>

<script>

//BAR CHART
var bar = new Morris.Bar({
element: 'bar-chart2',
resize: true,
data: [

<?php

foreach ($dontrepeatnames as $value) {
    echo "{y: '" . $value . "', a: '" . $addingTotalSales[$value] . "'},";
}

?>
],
barColors: ['#f6a'],
xkey: 'y',
ykeys: ['a'],
labels: ['sales'],
preUnits: '$',
hideHover: 'auto'
});
</script>