<?php
include '../connection.php';

	if (!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}

	if (isset($_GET["areaId"])){
		$sql = "DELETE FROM areas WHERE areaId='".$_GET['areaId']."'";

		if (mysqli_query($conn, $sql)) {
			header("Location: ../../areas/list-areas.php?success=1&close=1");
		} else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

	mysqli_close($conn);
	exit();
?>