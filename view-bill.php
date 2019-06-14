<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */
include '../backend/connection.php';
$sql = "SELECT * FROM sales WHERE forsale = '0' AND saleId='".$_GET["saleId"]."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$billNo = $row['saleBillNo'];
	$Detail = $row["saleDetail"]; 
	$DateTime = $row["saleDateTime"]; 
	$ExchArticle = $row["saleExchArticle"]; 
	$ExchWeight = $row["saleExchWeight"]; 
	$ExchWeightMili = $row["saleExchWeightMili"]; 
	$Exchange = $row["saleExchange"];
	$FirstName = $row["saleFirstName"];
	$LastName = $row["saleLastName"];
	$Address = $row["saleAddress"];
	
}

$sql2 = "SELECT * FROM `sales` WHERE `saleBillNo` = '".$billNo."' AND forsale = '0'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    // output data of each row
    $count = 0;

    /*
	while ($row2 = $result2->fetch_assoc()) {
		$saleDateTime =$row['saleDateTime'];
		$saleArticleName =$row['saleArticleName'];
		$saleAddress =$row['saleAddress'];
		$saleArticleCode =$row['saleArticleCode'];
		$saleWeight =$row['saleWeight'];
		$saleFirstName =$row['saleFirstName'];
		$saleLastName =$row['saleLastName'];
		$saleLabor =$row['saleLabor'];
		$saleLossGold =$row['saleLossGold'];
		$saleFinalPrice =$row['saleFinalPrice'];
		$saleExchange =$row['saleExchange'];
		$finalPrice = $saleFinalPrice-$saleExchange;
		$content .= "Bill for sale number:".$_GET["saleId"]."";
		$content .=	"Customer: ".$saleFirstName." ".$saleLastName."";
		$content .=	"Thank you for your purchase!";
		$content .=	"<br><br>";

		$count++;
		if($count > 6) {
			$content .= "<br>";
		}
	}
	*/
}
/*
-	Sales bill is written: Customer name, address, article name, article code, weight of gold, cost break down (Labor, Loss of Gold and Final Price) in the case of exchange, we mention the value of old gold and deduct the amount and final payable will be the difference.
*/



// Include the main TCPDF library (search for installation path).
require_once('../backend/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vijaya Jewellers');
$pdf->SetTitle('bill-number-'.$billNo);
$pdf->SetSubject('Sale Bill');
$pdf->SetKeywords('TCPDF, PDF, sale, bill');

// set default header data
//logo,logo-width
$pdf->SetHeaderData(null, 0, 'bill-number-'.$billNo.'  Vijaya Jewellers', '', array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', 'B', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
$pdf->Image('vijaya.png', 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();



// Print text using writeHTMLCell()
$y = 104;
$flag = 0;
$i = 0;
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc() {
		$particulars = "Code: ".$row["saleArticleCode"] . " " . $row["saleArticleName"];
		$rs = $row["saleLabor"]." + ".$row["saleLossGold"];
		if($i > 6 && $flag == 1) {
			$y++;
			$flag = 0;
		}

		$pdf->MultiCell(5, 7, $row["saleQty"], 0, 'L', 0, 0, '10', $y, true);
		$pdf->MultiCell(90, 7, $particulars, 0, 'L', 0, 0, '20', $y, true);
		$pdf->MultiCell(15, 7, $row["saleWeight"], 0, 'L', 0, 0, '114', $y, true);
		$pdf->MultiCell(15, 7, $row["saleWeight"], 0, 'L', 0, 0, '134', $y, true);
		$pdf->MultiCell(35, 7, $rs, 0, 'L', 0, 0, '154', $y, true);
		$pdf->MultiCell(15, 7, $row["saleFinalPrice"], 0, 'L', 0, 0, '190', $y, true);
		$y +=11 ;
		$i++;
	}
}
//
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('bill-sale-'.$billNo.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
