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

include '../backend/into-words.php';
include '../backend/connection.php';
$sql = "SELECT * FROM pawnings WHERE forpawn = '1' AND pawnId='".$_GET["pawnId"]."'";	
//echo $sql;
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
//echo "SQL: ".$sql."<br>";
$sql2 = "SELECT * FROM pawningextras WHERE pawnBillNo='".$row['pawnBillNo']."'";
//echo "SQL: ".$sql2."<br>";
$extraConcept = array();
$extraValue = array();
$extracontent = "<p><b>Owed and Paid</b></p><table><tr><td>Concept</td><td>Value</td></tr>";

$result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
if ($result2->num_rows > 0) {
	// output data of each row
	while($row2 = $result2->fetch_assoc()) {
		array_push($extraConcept,$row2["extraConcept"]);
		array_push($extraValue,$row2["extraValue"]);
		$extracontent .= "<tr><td>".$row2["extraConcept"]."</td><td>".$row2["extraValue"]."</td></tr>";
	}
}

$pawnDateTime = date("d-m-Y",strtotime($row["pawnDateTime"]));

//calculo la cantidad que se debe actualmente
$cantidad = $row["pawnOwed"]+$row["pawnAmount"]-$row["pawnPaid"];
//reviso si no tiene punto flotante y le agrega punto flotante, flag = 1 para no mostrar 
//centimos en string
$pos = strpos($cantidad, '.');
$flag=0;
if ($pos === false) {
	$cantidad.=".";
	$flag = 1;
}

$float = $cantidad;
$parts = explode('.', (string)$float);
$entero = $parts[0];
$decimal = $parts[1];

$number = int_to_words($entero);
$numberDec = int_to_words($decimal);

if($flag == 0)
	$stringToShow = $number." with ".$numberDec." cents.";
else
	$stringToShow = $number;


// Include the main TCPDF library (search for installation path).
require_once('../backend/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vijaya Jewellers');
$pdf->SetTitle('bill-number-'.$row["pawnBillNo"]);
$pdf->SetSubject('Pawn Bill');
$pdf->SetKeywords('TCPDF, PDF, , bill');

// set default header data
//logo,logo-width
$pdf->SetHeaderData(null, 0, 'bill-number-'.$row["pawnBillNo"].'  Vijaya Jewellers', '', array(0,64,255), array(0,64,128));
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
$pdf->Image('vijaya.jpeg', 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

$name = $row["pawnFirstName"] . " " . $row["pawnLastName"];

$pdf->MultiCell(30, 7, $pawnDateTime, 0, 'L', 0, 0, '30', '85', true);
$pdf->MultiCell(40, 9, $row["pawnBillNo"], 0, 'L', 0, 0, '158', '85', true);
$pdf->MultiCell(80, 7, $name, 0, 'L', 0, 0, '40', '102', true);
$pdf->MultiCell(43, 7, $cantidad, 0, 'L', 0, 0, '155', '102', true);
$pdf->MultiCell(80, 15, $row["pawnAddress"]. " ," .$row["pawnAreaName"], 0, 'L', 0, 0, '40', '112', true);
$pdf->MultiCell(68, 20, $stringToShow, 0, 'L', 0, 0, '130', '117', true);
$pdf->MultiCell(80, 7, $row["pawnIdcard"], 0, 'L', 0, 0, '40', '130', true);
$pdf->MultiCell(180, 15, $row["pawnArticleType"], 0, 'L', 0, 0, '15', '152', true);
$pdf->MultiCell(15, 7, $row["pawnGrossWeight"] ." g", 0, 'L', 0, 0, '48', '175', true);
$pdf->MultiCell(35, 7, $row["pawnGrossWeightMili"] ." mg", 0, 'L', 0, 0, '71', '175', true);
$pdf->MultiCell(15, 7, $row["pawnNetWeight"] ." g", 0, 'L', 0, 0, '48', '192', true);
$pdf->MultiCell(35, 7, $row["pawnNetWeightMili"] ." mg", 0, 'L', 0, 0, '71', '192', true);
$pdf->MultiCell(30, 7, $pawnDateTime, 0, 'L', 0, 0, '163', '208', true);

$pdf->MultiCell(180, 15, $row["pawnAuthorized"], 0, 'L', 0, 0, '15', '228', true);
$pdf->MultiCell(180, 15, $row["pawnIdcardAuthorized"], 0, 'L', 0, 0, '145', '228', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('bill-pawn-'.$row['pawnBillNo'].'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
