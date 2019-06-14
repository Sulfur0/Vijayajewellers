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
	$condition .= "AND pawnBillNo LIKE '" . $_GET["search"] . "'";
    $condition .= " OR pawnFirstName LIKE '" . $_GET["search"] . "'";
    $condition .= " OR pawnLastName LIKE '" . $_GET["search"] . "'"; 
}

// Include the main TCPDF library (search for installation path).
require_once('../../backend/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vijaya Jewellers');
$pdf->SetTitle('upcoming-pawn-report');
$pdf->SetSubject('Upcoming Pawn');
$pdf->SetKeywords('TCPDF, PDF, Upcoming, Pawn');

// set default header data
//logo,logo-width
$pdf->SetHeaderData(null, 0, 'upcoming-pawn-report  Vijaya Jewellers', '', array(0,64,255), array(0,64,128));
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
$sql = "SELECT * FROM pawnings WHERE forPawn='1' ".$condition;
$result = $conn->query($sql);

//$pdf->MultiCell(180, 7, $sql, 0, 'L', 0, 0, '0', '0', true);
if ($result->num_rows > 0) {

	$pdf->MultiCell(10, 7, "Row", 0, 'L', 0, 0, '10', $y, true);
	$pdf->MultiCell(23, 7, "Bill Number", 0, 'L', 0, 0, '20', $y, true);
	$pdf->MultiCell(25, 7, "Max Redeem Date", 0, 'L', 0, 0, '43', $y, true);
	$pdf->MultiCell(35, 7, "First Name", 0, 'L', 0, 0, '68', $y, true);
	$pdf->MultiCell(35, 7, "Last Name", 0, 'L', 0, 0, '103', $y, true);
	$pdf->MultiCell(37, 7, "Authorized Person", 0, 'L', 0, 0, '140', $y, true);
	$pdf->MultiCell(19, 7, "Warnings", 0, 'L', 0, 0, '177', $y, true);
	$y +=11 ;
	while($row = $result->fetch_assoc()) {
		if($i % 15 == 0 && $i>1){
			$pdf->AddPage();
			$bMargin = $pdf->getBreakMargin();
			$auto_page_break = $pdf->getAutoPageBreak();
			$pdf->SetAutoPageBreak(false, 0);
			$y = 30;
		}
		$delivery = date("Y-m-d", strtotime(date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"])) . " + 11 months"));         
        $finished = date("Y-m-d");
		if ($delivery <= $finished) {
            $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"])) . " + 1 year + 7 days"));         

            $pdf->MultiCell(10, 7, $i+1, 1, 'L', 0, 0, '10', $y, true);
			$pdf->MultiCell(23, 7, $row["pawnBillNo"], 1, 'L', 0, 0, '20', $y, true);
			$pdf->MultiCell(25, 7, $newEndingDate, 1, 'L', 0, 0, '43', $y, true);
			$pdf->MultiCell(35, 7, $row["pawnFirstName"], 1, 'L', 0, 0, '68', $y, true);
			$pdf->MultiCell(37, 7, $row["pawnLastName"], 1, 'L', 0, 0, '103', $y, true);
			$pdf->MultiCell(37, 7, $row["pawnAuthorized"], 1, 'L', 0, 0, '140', $y, true);
			$pdf->MultiCell(19, 7, $row["warning"], 1, 'L', 0, 0, '177', $y, true);
			$y +=11 ;
			$i++;                     
        }

		
			
	}
}


//
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('upcoming-pawn-report'.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
