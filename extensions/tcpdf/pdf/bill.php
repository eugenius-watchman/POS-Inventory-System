<?php

require_once "../../../controllers/sales.controller.php";
require_once "../../../models/sales.model.php";

require_once "../../../controllers/clients.controller.php";
require_once "../../../models/clients.model.php";

require_once "../../../controllers/users.controller.php";
require_once "../../../models/users.model.php";

require_once "../../../controllers/products.controller.php";
require_once "../../../models/products.model.php";

class printBill{

public $code;

public function getPrintingBill(){

//BRINGING THE INFORMATION OF THE SALE

$itemSale = "code";
$valueSale = $this->code;

$replySale = ControlSales::ctrShowSales($itemSale, $valueSale);

$date = substr($replySale["date"],0,-8);
$products = json_decode($replySale["products"], true);
$net = number_format($replySale["net"],2);
$tax = number_format($replySale["tax"],2);
$total = number_format($replySale["total"],2);

//BRINGING CLIENTS INFORMATION

$itemClient = "id";
$valueClient = $replySale["id_client"];

$replyClient = ControlClients::ctrShowClients($itemClient, $valueClient);

//BRINGING SELLERS INFORMATION

$itemSeller = "id";
$valueSeller = $replySale["id_seller"];

$replySeller = ControlUsers::ctrShowUsers($itemSeller, $valueSeller); 

//REQUIRE THE CLASS TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// **********************************************************************

$block1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:150px"><img src="images/logo-negro-bloque.png"></td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					BINARY STUDIOS

					<br>
					ADDRESS: Adenta,Accra

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					TELEPHONE: 0244 53 42 43
					
					<br>
					sales@inventorysystem.com

				</div>
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>BILL No.<br>$valueSale</td>


		</tr>

	</table>

EOF;

$pdf->writeHTML($block1, false, false, false, false, '');


// **********************************************************************

$block2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Client: $replyClient[name]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Date: $date

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Seller: $replySeller[name]</td>

		</tr>

		<tr>
		
			<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($block2, false, false, false, false, '');

// **********************************************************************

$block3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:center">Product</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center">Quantity</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Value Unit.</td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">Value Total</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($block3, false, false, false, false, '');

// **********************************************************************

foreach ($products as $key => $item) {

$itemProduct = "description";
$valueProduct = $item["description"];
$order = null;

$replyProduct = ControlProducts::ctrShowProducts($itemProduct, $valueProduct, $order);

$valueUnit = number_format($replyProduct["sale_price"], 2);

$totalPrice = number_format($item["total"], 2);

$block4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
				$item[description]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[quantity]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$valueUnit
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$totalPrice
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($block4, false, false, false, false, '');

}

// **********************************************************************

$block5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>

		</tr>
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				Net:
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $net
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Tax: 
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $tax
			</td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				Total:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
				$ $total
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($block5, false, false, false, false, '');


// **********************************************************************
//FILE OUT 

$pdf->Output('bill.pdf');

}

}

$bill = new printBill();
$bill -> code = $_GET["code"];
$bill -> getPrintingBill();

?>