<?php
include '../../backend/connection.php';
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());

//PONGO LOS MISMOS FILTROS DEL REPORTE
$condition = "";

if(isset($_GET["search"]) && $_GET["search"] != ""){
	$condition .= " AND orderFirstName LIKE '" . $_GET["search"] . "'";
    $condition .= " OR orderLastName LIKE '" . $_GET["search"] . "'";
    $condition .= " OR orderBillNo LIKE '" . $_GET["search"] . "'";
    
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

$sql = "SELECT * FROM orders WHERE orderFinished <= orderDeliveryDate ".$condition;
$result = $conn->query($sql);
//array_push($arr,array($sql,'','','',''));
$arr = array();
array_push($arr,array('Row','Bill Number','Delivery Date','Finish Date','First Name','Last Name','Telephone'));

$contador = 0;
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {		  
		$contador++;
        $orderTime = date("Y-m-d", strtotime($row["orderDeliveryDate"])); 
        $orderFinish =  date("Y-m-d", strtotime($row["orderFinished"]));

		array_push($arr,array($contador,$row["orderBillNo"],$orderTime,$orderFinish,$row["orderFirstName"],$row["orderLastName"],$row["orderTelephone"]));	
	}
}
array_to_csv_download(
	$arr,
  	"orders-ontime-report.csv"
);
?> 