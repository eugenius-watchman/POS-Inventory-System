<?php

require_once "../../../controllers/sales.controller.php";
require_once "../../../models/sales.model.php";

require_once "../../../controllers/clients.controller.php";
require_once "../../../models/clients.model.php";

require_once "../../../controllers/users.controller.php";
require_once "../../../models/users.model.php";

require_once "../../../controllers/products.controller.php";
require_once "../../../models/products.model.php";

class printBill
{

	public $code;

	public function getPrintingBill()
	{

		//BRINGING THE INFORMATION OF THE SALE

		$itemSale  = "code";
		$valueSale = $this->code;

		$replySale = ControlSales::ctrShowSales($itemSale, $valueSale);

		$date     = substr($replySale["date"], 0, -8);
		$products = json_decode($replySale["products"], true);
		$net      = number_format($replySale["net"], 2);
		$tax      = number_format($replySale["tax"], 2);
		$total    = number_format($replySale["total"], 2);

		//BRINGING CLIENTS INFORMATION

		$itemClient  = "id";
		$valueClient = $replySale["id_client"];

		$replyClient = ControlClients::ctrShowClients($itemClient, $valueClient);

		//BRINGING SELLERS INFORMATION

		$itemSeller  = "id";
		$valueSeller = $replySale["id_seller"];

		$replySeller = ControlUsers::ctrShowUsers($itemSeller, $valueSeller);

		//REQUIRE THE CLASS TCPDF

		require_once 'tcpdf_include.php';

		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// $pdf->startPageGroup();

		// $pdf->AddPage();

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, [226, 235], true, 'UTF-8', false);
		$pdf->startPageGroup();
		$pdf->AddPage('P', 'A7');
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// **********************************************************************
		// Header Block
		$block1 = <<<EOF

        <table style="font-size:9px; text-align:center">
            <tr>
                <td style="width:160px;">
                    <div>
                        Date: $date
                        <br><br>
                        <strong>Royal Riddles</strong>
                        <br>
                        Address: Adenta Accra
                        <br>
                        Phone: +233 55 660 9611
                        <br>
                        Invoice N.$valueSale
                        <br><br>
                        Customer: $replyClient[name]
                        <br>
                        Seller: $replySeller[name]
                        <br>
                    </div>
                </td>
            </tr>
        </table>

        EOF;

		$pdf->writeHTML($block1, false, false, false, false, '');

		// ---------------------------------------------------------
		// Products List

		foreach ($products as $key => $item) {

			// $itemProduct = "description";
			// $valueProduct = $item["description"];
			// $order = null;

			// $replyProduct = ControlProducts::ctrShowProducts($itemProduct, $valueProduct, $order);

			$valueUnit = number_format($item["price"], 2);

			$totalPrice = number_format($item["total"], 2);

			$block2 = <<<EOF

            <table style="font-size:9px;">
                <tr>
                    <td style="width:160px; text-align:left">
                    $item[description]
                    </td>
                </tr>
                <tr>
                    <td style="width:160px; text-align:right">
                    GHS $valueUnit × $item[quantity] = GHS $totalPrice
                    <br>
                    </td>
                </tr>
            </table>
            EOF;

			$pdf->writeHTML($block2, false, false, false, false, '');
		}

		// ---------------------------------------------------------
		// Totals Block
		$block3 = <<<EOF

        <table style="font-size:9px; text-align:right">
            <tr>
                <td style="width:80px;">
                     NET:
                </td>
                <td style="width:80px;">
                    GHS $net
                </td>
            </tr>
            <tr>
                <td style="width:80px;">
                     TAX:
                </td>
                <td style="width:80px;">
                    GHS $tax
                </td>
            </tr>
            <tr>
                <td style="width:160px;">
                     --------------------------
                </td>
            </tr>
            <tr>
                <td style="width:80px;">
                     TOTAL:
                </td>
                <td style="width:80px;">
                    GHS $total
                </td>
            </tr>
            <tr>
                <td style="width:160px; text-align:center; font-size:8px;">
                    <br><br>
                    Thank you for your purchase
                    <br><br>
                    Designed by BSS Inventory Systems<br>
                    © 2021 All Rights Reserved
                </td>
            </tr>
        </table>
        EOF;

		$pdf->writeHTML($block3, false, false, false, false, '');

		// ---------------------------------------------------------
		//FILE OUT

		$pdf->Output('bill.pdf');
	}
}

$bill       = new printBill();
$bill->code = $_GET["code"];
$bill->getPrintingBill();
