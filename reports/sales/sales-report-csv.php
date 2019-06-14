<?php
include '../../backend/connection.php';
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());

//PONGO LOS MISMOS FILTROS DEL REPORTE
$condition = "1";
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
$sql2 = "SELECT saleBillNo,sbillDate FROM salebills WHERE ".$condition;
$result2 = $conn->query($sql2);

$arr = array();
array_push($arr,array('Bill No','Date','Article Code','Article Name','Weight','Price'));

if ($result2->num_rows > 0) {
	while ($row2 = $result2->fetch_assoc()) {
		$time = strtotime($row2["sbillDate"]);
		$date = date('Y-m-d',$time);
			
		$sql3 = "SELECT * FROM sales WHERE forsale='0' AND saleBillNo='".$row2["saleBillNo"]."'";
			
		$result3 = $conn->query($sql3);			
		if ($result3->num_rows > 0) {
			while ($row3 = $result3->fetch_assoc()) {
				array_push($arr,array($row3["saleBillNo"],$date,$row3["saleArticleCode"],$row3["saleArticleName"],$row3["saleWeight"] . "g " . $row3["saleWeightMili"] .  "mg",$row3["saleFinalPrice"]));
			}
		}		
	}
}
array_to_csv_download(
	$arr,
  	"sale-report.csv"
);
?> 