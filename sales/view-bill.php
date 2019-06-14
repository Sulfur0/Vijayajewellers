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
$sql = "SELECT * FROM saleBills WHERE saleBillNo = '".$_GET["billno"]."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sql2 = "SELECT * FROM `sales` WHERE `saleBillNo` = '".$_GET["billno"]."'";
$result2 = $conn->query($sql2);


$time = strtotime($row["sbillDate"]);
$date = date('Y-m-d',$time);

// Include the main TCPDF library (search for installation path).
require_once('../backend/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vijaya Jewellers');
$pdf->SetTitle('bill-number-'.$_GET["billno"]);
$pdf->SetSubject('Sale Bill');
$pdf->SetKeywords('TCPDF, PDF, sale, bill');

// set default header data
//logo,logo-width
$pdf->SetHeaderData(null, 0, 'bill-number-'.$_GET["billno"].'  Vijaya Jewellers', '', array(0,64,255), array(0,64,128));
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


$nombrecompleto = $row["sbillFirstName"]." ".$row["sbillLastName"];

// Print text using writeHTMLCell()
$y = 104;
$pdf->MultiCell(90, 7, $nombrecompleto,0, 'L', 0, 0, '20', 80, true);
$pdf->MultiCell(35, 7, $date, 0, 'L', 0, 0, '165', 80, true);
$flag = 0;
$i = 0;
if ($result2->num_rows > 0) {
	while($row2 = $result2->fetch_assoc()) {
		$particulars = $row2["saleArticleCode"] . " " . $row2["saleArticleName"];
		$float = $row2["saleFinalPrice"];
		$parts = explode('.', (string)$float);
		$rs = $parts[0];
		$rs = number_format( $rs , 0 , '.' , ',' );
		$cts = $parts[1];
		if($i > 6 && $flag == 1) {
			$y++;
			$flag = 0;
		}

		$pdf->MultiCell(5, 7, "1", 0, 'L', 0, 0, '10', $y, true);
		$pdf->MultiCell(90, 7, $particulars, 0, 'L', 0, 0, '20', $y, true);
		$pdf->MultiCell(15, 7, $row2["saleWeight"], 0, 'L', 0, 0, '114', $y, true);
		$pdf->MultiCell(15, 7, $row2["saleWeightMili"], 0, 'L', 0, 0, '134', $y, true);
		$pdf->MultiCell(35, 7, $rs, 0, 'R', 0, 0, '154', $y, true);
		$pdf->MultiCell(15, 7, ".".$cts, 0, 'L', 0, 0, '191', $y, true);
		$y +=11 ;
		$i++;
	}
}
//Agrego los exchange si existen
if(isset($row["sbillExchArticle"])&&($row["sbillExchArticle"]!="")){
	$float = $row["sbillExchange"];
	$parts = explode('.', (string)$float);
	$rs = $parts[0];
	$rs = number_format( $rs , 0 , '.' , ',' );
	$cts = $parts[1];

	$pdf->MultiCell(90, 7, "Exchange: ".$row["sbillExchArticle"], 0, 'L', 0, 0, '20', $y, true);
	$pdf->MultiCell(15, 7, $row["sbillExchWeight"], 0, 'L', 0, 0, '114', $y, true);
	$pdf->MultiCell(15, 7, $row["sbillExchWeightMili"], 0, 'L', 0, 0, '134', $y, true);
	$pdf->MultiCell(35, 7, $rs, 0, 'R', 0, 0, '154', $y, true);
	$pdf->MultiCell(15, 7, ".".$cts, 0, 'L', 0, 0, '191', $y, true);
	$y +=11 ;
	$i++;
}


$float = $row["sbillFinalPrice"];
$parts = explode('.', (string)$float);
$rs = $parts[0];
$rs = number_format( $rs , 0 , '.' , ',' );
$cts = $parts[1];

$pdf->MultiCell(90, 7, "TOTAL", 0, 'L', 0, 0, '20', 240, true);
$pdf->MultiCell(35, 7, $rs, 0, 'R', 0, 0, '154', 240, true);
$pdf->MultiCell(15, 7, ".".$cts, 0, 'L', 0, 0, '191', 240, true);
//
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('bill-sale-'.$_GET["billno"].'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
