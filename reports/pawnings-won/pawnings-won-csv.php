<?php
include '../../backend/connection.php';
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());

//PONGO LOS MISMOS FILTROS DEL REPORTE
$condition = "";

if(isset($_GET["search"]) && $_GET["search"] != ""){
	$condition .= "AND pawnBillNo LIKE '" . $_GET["search"] . "'";
    $condition .= " OR pawnArticleType LIKE '" . $_GET["search"] . "'";
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

$sql = "SELECT * FROM pawnings WHERE forPawn='2' ".$condition;
$result = $conn->query($sql);
//array_push($arr,array($sql,'','','',''));
$arr = array();
array_push($arr,array('Row','Bill Number','Article Name','Weight'));

$contador = 0;
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {	 
		$contador++;
        $newEndingDate = date("Y-m-d h:i:s a", strtotime(date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"])) . " + 1 year + 7 days"));          

        array_push($arr,array($contador,$row["pawnBillNo"],$row["pawnArticleType"],$row["pawnNetWeight"]."g ".$row["pawnNetWeightMili"]."mg"));                          
        
		
	}
}
array_to_csv_download(
	$arr,
  	"pawnings-won-report.csv"
);
?> 