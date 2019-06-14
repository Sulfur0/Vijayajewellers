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
$sql = "SELECT * FROM sales WHERE forsale != '0'  AND goldStatus='1'";
$result = $conn->query($sql);
$content ="";




$content .= '<table cellpadding="1" cellspacing="1" border="1" style="text-align:center;">
	<tr>
	<td>Row</td>
	<td>Name</td>
	<td>Weight</td>
	<td>Date Added</td>
	<td>Sale Price</td>
	<td>On Sale</td>
	</tr>';

if ($result->num_rows > 0) {
    // output data of each row
    $count = 0;

    
	while ($row = $result->fetch_assoc()) {	
		$sql2 = "SELECT sbillDate FROM salebills WHERE saleBillNo = '".$row['saleBillNo']."'";
		$result2 = $conn->query($sql2);				
		$row2 = $result2->fetch_assoc();
		$time = strtotime($row2["sbillDate"]);
		$date = date('Y-m-d',$time);

		$count++;

		$price = number_format( $row['saleFinalPrice'] , 3 , '.' , ',' );
		$content .= "<tr>
		<td>".$count."</td>
		<td>".$row['saleArticleName']."</td>
		<td>".$row['saleWeight']."g ".$row['saleWeightMili']."mg</td>
		<td>".$date."</td>
		<td>".$price."</td>
		";
		if($row["forsale"] == 1) {
			$content .= "<td>Yes</td></tr>";
		}else{
			$content .= "<td>No</td></tr>";
		}
	}
	// paginar a 30 resultados mostrados
	
}

$content .= "</table>";




// Include the main TCPDF library (search for installation path).
require_once('../backend/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vijaya Jewellers');
$pdf->SetTitle('Inventory');
$pdf->SetSubject('Inventory');
$pdf->SetKeywords('TCPDF, PDF, Inventory, list');

// set default header data
//logo,logo-width
$pdf->SetHeaderData(null, 0, 'Inventory List - Vijaya Jewellers', '', array(0,64,255), array(0,64,128));
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
/*$pdf->Image('vijaya.png', 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);*/
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->setPageMark();

// output the HTML content
$pdf->writeHTML($content, true, false, true, false, '');

/*
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
*/

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('inventory'.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
