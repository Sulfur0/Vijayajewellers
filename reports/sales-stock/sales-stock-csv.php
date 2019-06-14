<?php
include '../../backend/connection.php';
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());

//PONGO LOS MISMOS FILTROS DEL REPORTE
$condition = "";
$condition2 = "";

if(isset($_GET["search"]) && $_GET["search"] != ""){
	$condition .= " AND saleArticleCode LIKE '" . $_GET["search"] . "'";
    $condition .= " OR saleArticleName LIKE '" . $_GET["search"] . "'";
    $condition2 .= " AND pawnArticleType LIKE '" . $_GET["search"] . "'";
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
//$sql = "SELECT * FROM pawnings WHERE forPawn!='0' ".$condition;
$sql = "SELECT * FROM sales WHERE forsale!='0'  ".$condition;
$sql2 = "SELECT * FROM pawnings WHERE forPawn='2' ".$condition2;
$result = $conn->query($sql);
//array_push($arr,array($sql,'','','',''));
$arr = array();
array_push($arr,array('Row','Code','Article Name','Weight','Old/New'));

$contador = 0;
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$contador++;
        if($row["goldStatus"]=='1')
            array_push($arr,array($contador,$row["saleArticleCode"],$row["saleArticleName"],$row["saleWeight"] . "g ". $row["saleWeightMili"] ."mg",'New'));
        else if($row["goldStatus"]=='0')
            array_push($arr,array($contador,$row["saleArticleCode"],$row["saleArticleName"],$row["saleWeight"] . "g ". $row["saleWeightMili"] ."mg",'Old'));
			
	}
}
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $contador++;
        array_push($arr,array($contador,'',$row["pawnArticleType"],$row["pawnNetWeight"] . "g ". $row["pawnNetWeightMili"] ."mg",'Old'));                   
    }
}
array_to_csv_download(
	$arr,
  	"sales-stock-report.csv"
);
?> 