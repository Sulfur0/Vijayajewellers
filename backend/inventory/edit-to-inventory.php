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
	// sql to delete a record
	$sql = "UPDATE sales SET 
	saleArticleName='".$_POST["saleArticleName"]."',
	saleArticleCode='".$_POST["saleArticleCode"]."',
	saleWeight='".$_POST["saleWeight"]."',
	saleWeightMili='".$_POST["saleWeightMili"]."',
	saleLabor='".$_POST["saleLabor"]."',
	saleLossGold='".$_POST["saleLossGold"]."',
	saleGoldValue='".$_POST["saleGoldValue"]."',
	saleFinalPrice='".$_POST["saleFinalPrice"]."'
	    WHERE saleId=".$_POST["saleId"]."";
	

	if (mysqli_query($conn, $sql)) {
	    header("Location: ../../inventory/new-gold.php?success=1&update=1");
	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	}

	mysqli_close($conn);

    exit();   	
?>