<?php
	session_start();
    if($_SESSION["usuario"]==null){
        header("Location: ../../index.php?fail=1&not-authorized=1");
    }
   	include '../connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	// sql to update a record
	$sql="";
	$pawnDateTime = $_POST["pawnDateTime"];
    $pawnBillNo = $_POST["pawnBillNo"];
    $pawnFirstName = $_POST["pawnFirstName"];
    $pawnLastName = $_POST["pawnLastName"];
    $pawnAge = $_POST["pawnAge"];
    $pawnAreaName = $_POST["pawnAreaName"]; 
    $pawnAddress = $_POST["pawnAddress"]; 
    $pawnIdcard = $_POST["pawnIdcard"]; 
    $pawnArticleType = $_POST["pawnArticleType"]; 
    $pawnNetWeight = $_POST["pawnNetWeight"]; 
    $pawnGrossWeight = $_POST["pawnGrossWeight"];
    $pawnAuthorized = $_POST["pawnAuthorized"]; 

	$sql .= "UPDATE pawnings SET pawnDateTime='".$pawnDateTime."', pawnBillNo='".$pawnBillNo."', pawnFirstName='".$pawnFirstName."', pawnLastName='".$pawnLastName."', pawnAge='".$pawnAge."', pawnAreaName='".$pawnAreaName."', pawnAddress='".$pawnAddress."', pawnIdcard='".$pawnIdcard."', pawnArticleType='".$pawnArticleType."', pawnNetWeight='".$pawnNetWeight."', pawnGrossWeight='".$pawnGrossWeight."', pawnAuthorized='".$pawnAuthorized."' WHERE pawnId='".$_POST["pawnId"]."';";
	//echo "pawnId: ".$_POST["pawnId"]."<br>";
	/*
	foreach ($_POST["extraValue"] as $key => $getid) {

		//echo "extraId: ".$_POST["extraId"][$key]."<br>";


		$sql .=  "UPDATE pawningextras SET extraValue = '".$_POST["extraValue"][$key]."', extraConcept = '".$_POST["extraConcept"][$key]."' WHERE extraId = '".$_POST["extraId"][$key]."';";
		//echo "SQL: ".$sql."<br>";

	}
	*/
	
	if (mysqli_multi_query($conn, $sql)) {
	    header("Location: ../../pawnings/list-pawnings.php?success=1&update=1");
	    
	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	}	
	


	mysqli_close($conn);

    exit();   	
?>