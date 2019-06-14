<?php
   	include '../connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	// sql to delete a record
	$sql = "DELETE FROM customers WHERE customerId=".$_POST["customerId"]."";

	if (mysqli_query($conn, $sql)) {
	    header("Location: ../../customers/list-customers.php?success=1&delete=1");
	} else {
	    echo "Error deleting record: " . mysqli_error($conn);
	}

	mysqli_close($conn);

    exit();   	
?>