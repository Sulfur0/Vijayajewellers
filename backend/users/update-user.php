<?php
   	include '../connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	// sql to delete a record
	$sql = "UPDATE users SET name='".$_REQUEST["name"]."', password='".password_hash($_REQUEST["password"], PASSWORD_DEFAULT)."', email='".$_REQUEST["email"]."',privileges ='".$_REQUEST["privileges"]."'  WHERE userId=".$_REQUEST["userId"]."";
	

	if (mysqli_query($conn, $sql)) {
	    header("Location: ../../users/list-users.php?success=1&update=1");
	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	}

	mysqli_close($conn);

    exit();   	
?>