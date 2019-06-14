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
	$sql = "UPDATE sales SET saleFirstName='".$_POST["saleFirstName"]."', saleLastName='".$_POST["saleLastName"]."', saleAddress='".$_POST["saleAddress"]."', forsale='0' WHERE saleId=".$_POST["saleId"]."";
	

	if (mysqli_query($conn, $sql)) {
	    header("Location: ../../sales/bill-sales.php?success=1&update=1");
	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	}

	mysqli_close($conn);

    exit();   	
?>