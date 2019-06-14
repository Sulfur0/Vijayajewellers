<?php
include '../../backend/connection.php';
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());

//PONGO LOS MISMOS FILTROS DEL REPORTE
$condition = "";
if(isset($_GET["from-year"]) && $_GET["from-year"] != ""){
	$condition .= " AND YEAR(pawnDateTime) >= ".$_GET["from-year"];
}
if(isset($_GET["to-year"]) && $_GET["to-year"] != ""){
	$condition .= " AND YEAR(pawnDateTime) <= ".$_GET["to-year"];
}
if(isset($_GET["year"]) && $_GET["year"] != ""){
	$condition .= " AND YEAR(pawnDateTime) = ".$_GET["year"];
}
if(isset($_GET["month"]) && $_GET["month"] != ""){
	$condition .= " AND MONTH(pawnDateTime) = ".$_GET["month"];
}
if(isset($_GET["search"]) && $_GET["search"] != ""){
	$condition .= " AND saleBillNo LIKE '" . $_GET["search"] . "'";
}



function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}
$sql2 = "SELECT * FROM pawnings WHERE  forPawn='1' ".$condition;
$result2 = $conn->query($sql2);

$arr = array();
array_push($arr,array('Row','Bill No','Article Name','Net Weight','Gross Weight','Amount','Date','Customer Name'));
$contador=0;
if ($result2->num_rows > 0) {	
	while ($row2 = $result2->fetch_assoc()) {
		$contador++;
		$netWeight = $row2["pawnNetWeight"]."g ".$row2["pawnNetWeightMili"]."mg";
		$grossWeight = $row2["pawnGrossWeight"]."g ".$row2["pawnGrossWeightMili"]."mg";
		$customer = $row2["pawnFirstName"]." ".$row2["pawnLastName"];
		$price = number_format( $row2["pawnAmount"] , 2 , '.' , ',' );
		$pawnDate = date("Y-m-d", strtotime($row2["pawnDateTime"]));
			
		array_push($arr,array($contador,$row2["pawnBillNo"],$row2["pawnArticleType"],$netWeight,$grossWeight,$price,$pawnDate,$customer));				
	}
}
array_to_csv_download(
	$arr,
  	"pawnings-report.csv"
);
?> 