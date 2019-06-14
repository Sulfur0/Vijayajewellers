<?php
   	include '../connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT areaName FROM areas WHERE areaName='".$_POST["area"]."'";
	$result = mysqli_query($conn, $sql);
	if (!mysqli_num_rows($result) > 0) {
		$sql =  "INSERT INTO areas (areaName) VALUES('".$_POST["area"]."')";
				
		if (!mysqli_query($conn, $sql)) {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

	$sql = "UPDATE customers SET 
	name='".$_POST["name"]."', 
	lastname='".$_POST["lastname"]."', 
	email='".$_POST["email"]."', 
	address='".$_POST["address"]."', 
	idCard='".$_POST["idCard"]."', 
	area='".$_POST["area"]."', 
	telephone='".$_POST["telephone"]."'
	WHERE customerId=".$_POST["customerId"]."";
	

	if (mysqli_query($conn, $sql)) {
	    header("Location: ../../customers/list-customers.php?success=1&update=1");
	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	}

	mysqli_close($conn);

    exit();   	
?>