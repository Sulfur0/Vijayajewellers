<?php
   	include '../connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	
	// sql to delete a record
	$sql = "DELETE FROM users WHERE userId=".$_REQUEST["userId"]."";

	if (mysqli_query($conn, $sql)) {
	    header("Location: ../../users/list-users.php?success=1&delete=1");
	} else {
	    echo "Error deleting record: " . mysqli_error($conn);
	}

	mysqli_close($conn);
	
      	
?>