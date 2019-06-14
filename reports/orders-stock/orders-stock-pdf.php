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
include '../../backend/connection.php';

//PONGO LOS MISMOS FILTROS DEL REPORTE
$condition = "";
if(isset($_GET["search"]) && $_GET["search"] != ""){
	$condition .= " AND orderFirstName LIKE '" . $_GET["search"] . "'";
    $condition .= " OR orderLastName LIKE '" . $_GET["search"] . "'";
}

// Include the main TCPDF library (search for installation path).
require_once('../../backend/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vijaya Jewellers');
$pdf->SetTitle('orders-stock-report');
$pdf->SetSubject('Orders Stock Report');
$pdf->SetKeywords('TCPDF, PDF, sale, bill');

// set default header data
//logo,logo-width
$pdf->SetHeaderData(null, 0, 'orders-stock-report  Vijaya Jewellers', '', array(0,64,255), array(0,64,128));
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
$pdf->SetFont('helvetica', 'B', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
/*$pdf->Image('vijaya.png', 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);*/
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();


// Print text using writeHTMLCell()
$y = 30;
$flag = 0;
$i = 0;
$sql = "SELECT * FROM orders WHERE orderPending='0' ".$condition;
$result = $conn->query($sql);

//$pdf->MultiCell(180, 7, $sql, 0, 'L', 0, 0, '0', '0', true);

if ($result->num_rows > 0) {

	$pdf->MultiCell(10, 7, "Row", 0, 'L', 0, 0, '10', $y, true);
	$pdf->MultiCell(60, 7, "First Name", 0, 'L', 0, 0, '20', $y, true);
	$pdf->MultiCell(60, 7, "Last Name", 0, 'L', 0, 0, '80', $y, true);
	$pdf->MultiCell(30, 7, "Weight", 0, 'L', 0, 0, '140', $y, true);
	$pdf->MultiCell(25, 7, "Purchase Date", 0, 'L', 0, 0, '170', $y, true);
	$y +=11 ;
	while($row = $result->fetch_assoc()) {

		if($i % 15 == 0 && $i>1){
			$pdf->AddPage();
			$bMargin = $pdf->getBreakMargin();
			$auto_page_break = $pdf->getAutoPageBreak();
			$pdf->SetAutoPageBreak(false, 0);
			$y = 30;
		}
		
		if($i > 6 && $flag == 1) {
			$y++;
			$flag = 0;
		}
		$articleDate = date("Y-m-d", strtotime($row["orderDeliveryDate"]) );

		$pdf->MultiCell(10, 7, $i+1, 1, 'L', 0, 0, '10', $y, true);
		$pdf->MultiCell(60, 7, $row["orderFirstName"], 1, 'L', 0, 0, '20', $y, true);
		$pdf->MultiCell(60, 7, $row["orderLastName"], 1, 'L', 0, 0, '80', $y, true);
		$pdf->MultiCell(30, 7, $row["orderWeight"]. "g ". $row["orderWeightMili"] . "mg", 1, 'L', 0, 0, '140', $y, true);
		$pdf->MultiCell(25, 7, $articleDate, 1, 'L', 0, 0, '170', $y, true);
		$y +=11 ;
		$i++;
			
	}
}


//
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('orders-stock-report'.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
