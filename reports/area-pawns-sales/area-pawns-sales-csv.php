<?php
include '../../backend/connection.php';
if (!$conn) 
    die("Connection failed: " . mysqli_connect_error());

//PONGO LOS MISMOS FILTROS DEL REPORTE
$condition = "";

if(isset($_GET["search"]) && $_GET["search"] != ""){
    $condition .= "'".$_GET["search"]."'";
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
//$sql = "SELECT saleBillNo,sbillDate FROM salebills WHERE ".$condition;
$sql = "SELECT * FROM sales WHERE saleArea=".$condition;
$result = $conn->query($sql);

$arr = array();
array_push($arr,array('Row','Article Name','Weight','Purchase Date','Type'));
$contador = 0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sql2 = "SELECT * FROM salebills WHERE saleBillNo='".$row["saleBillNo"]."'";
        $result2 = $conn->query($sql2);
        $row2 = $result2->fetch_assoc();                
        
        $articleDate = date("Y-m-d h:i:s a", strtotime($row2["sbillDate"]) );       
        $contador++;               
        
        array_push($arr,array($contador,$row["saleArticleName"],$row["saleWeight"]."g ".$row["saleWeightMili"]."mg",$articleDate,"Sale"));                 
    }
}
$sql2 = "SELECT * FROM pawnings WHERE pawnAreaName=".$condition;
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $articleDate = date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"]) );     
        $contador++;        
        array_push($arr,array($contador,$row["pawnArticleType"],$row["pawnNetWeight"]."g ".$row["pawnNetWeightMili"]."mg",$articleDate,"Pawn")); 
                
    }
}
array_to_csv_download(
    $arr,
    "area-pawns-sales.csv"
);
?> 