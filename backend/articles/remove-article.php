<?php
include '../connection.php';

	if (!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}

	if (isset($_GET["articleId"])){
		$sql = "DELETE FROM articles WHERE articleId='".$_GET['articleId']."'";

		if (mysqli_query($conn, $sql)) {
			header("Location: ../../articles/list-articles.php?success=1&close=1");
		} else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

	mysqli_close($conn);
	exit();
?>