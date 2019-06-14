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
$condition = "1";
$condition2 = "";
if(isset($_GET["from-year"]) && $_GET["from-year"] != ""){
	$condition .= " AND YEAR(sbillDate) >= ".$_GET["from-year"];
}
if(isset($_GET["to-year"]) && $_GET["to-year"] != ""){
	$condition .= " AND YEAR(sbillDate) <= ".$_GET["to-year"];
}
if(isset($_GET["year"]) && $_GET["year"] != ""){
	$condition .= " AND YEAR(sbillDate) = ".$_GET["year"];
}
if(isset($_GET["month"]) && $_GET["month"] != ""){
	$condition .= " AND MONTH(sbillDate) = ".$_GET["month"];
}
if(isset($_GET["search"]) && $_GET["search"] != ""){
	$condition .= " AND saleBillNo LIKE '" . $_GET["search"] . "'";
}
if(isset($_GET["article"]) && $_GET["article"] != ""){
	$condition2 .= " AND saleArticleName = '".$_GET["article"]."'";
	$condition2 .= " OR saleArticleCode = '".$_GET["article"]."'";
	$condition .= " LIMIT 1";
}


// Include the main TCPDF library (search for installation path).
require_once('../../backend/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vijaya Jewellers');
$pdf->SetTitle('sale-report');
$pdf->SetSubject('Sale Report');
$pdf->SetKeywords('TCPDF, PDF, sale, report');

// set default header data
//logo,logo-width
$pdf->SetHeaderData(null, 0, 'sale-report  Vijaya Jewellers', '', array(0,64,255), array(0,64,128));
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
$sql = "SELECT * FROM saleBills WHERE ".$condition;
$result = $conn->query($sql);

//$pdf->MultiCell(180, 7, $sql, 0, 'L', 0, 0, '0', '0', true);

if ($result->num_rows > 0) {

	$pdf->MultiCell(10, 7, "Row", 0, 'L', 0, 0, '10', $y, true);
	$pdf->MultiCell(22, 7, "Bill No.", 0, 'L', 0, 0, '20', $y, true);
	$pdf->MultiCell(23, 7, "Date", 0, 'L', 0, 0, '42', $y, true);
	$pdf->MultiCell(25, 7, "Art. Code", 0, 'L', 0, 0, '65', $y, true);
	$pdf->MultiCell(50, 7, "Art. Name", 0, 'L', 0, 0, '90', $y, true);
	$pdf->MultiCell(25, 7, "Weight", 0, 'L', 0, 0, '140', $y, true);
	$pdf->MultiCell(30, 7, "Price", 0, 'R', 0, 0, '165', $y, true);
	$y +=11 ;
	while($row = $result->fetch_assoc()) {
		$sql2 = "SELECT * FROM `sales` WHERE `saleBillNo` = '".$row["saleBillNo"]."' ".$condition2;
		$result2 = $conn->query($sql2);
		
		//$pdf->MultiCell(180, 7, $sql2, 0, 'L', 0, 0, '0', '0', true);

		$time = strtotime($row["sbillDate"]);
		$date = date('Y-m-d',$time);
		if ($result2->num_rows > 0) {
			/*TH
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			*/
			
			/*TBODY*/
			while($row2 = $result2->fetch_assoc()) {
				if($i % 15 == 0 && $i>1){
					$pdf->AddPage();
					$bMargin = $pdf->getBreakMargin();
					$auto_page_break = $pdf->getAutoPageBreak();
					$pdf->SetAutoPageBreak(false, 0);
					$y = 30;
				}
				
				$particulars = $row2["saleArticleCode"] . " " . $row2["saleArticleName"];
				$amount = number_format( $row2["saleFinalPrice"] , 3 , '.' , ',' );
				if($i > 6 && $flag == 1) {
					$y++;
					$flag = 0;
				}
				$time = strtotime($row["sbillDate"]);
				$date = date('Y-m-d',$time);

				$pdf->MultiCell(10, 7, $i+1, 1, 'L', 0, 0, '10', $y, true);
				$pdf->MultiCell(22, 7, $row2["saleBillNo"], 1, 'L', 0, 0, '20', $y, true);
				$pdf->MultiCell(23, 7, $date, 1, 'L', 0, 0, '42', $y, true);
				$pdf->MultiCell(25, 7, $row2["saleArticleCode"], 1, 'L', 0, 0, '65', $y, true);
				$pdf->MultiCell(50, 7, $row2["saleArticleName"], 1, 'L', 0, 0, '90', $y, true);
				$pdf->MultiCell(25, 7, $row2["saleWeight"]."g ".$row2["saleWeightMili"]."mg", 1, 'L', 0, 0, '140', $y, true);
				$pdf->MultiCell(30, 7, $amount, 1, 'R', 0, 0, '165', $y, true);
				$y +=11 ;
				$i++;
			}
		}
	}
}
//prueb de paginado
/*
$pdf->AddPage();
$bMargin = $pdf->getBreakMargin();
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak(false, 0);
*/
/*$pdf->Image('vijaya.png', 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);*/


/*

$float = $row["sbillFinalPrice"];
$parts = explode('.', (string)$float);
$rs = $parts[0];
$rs = number_format( $rs , 0 , '.' , ',' );
$cts = $parts[1];

$pdf->MultiCell(90, 7, "TOTAL", 0, 'L', 0, 0, '20', 240, true);
$pdf->MultiCell(35, 7, $rs, 0, 'R', 0, 0, '154', 240, true);
$pdf->MultiCell(15, 7, ".".$cts, 0, 'L', 0, 0, '191', 240, true);
*/
//
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('sale-report'.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
