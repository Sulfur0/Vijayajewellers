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
		
		$areaName = $_POST["areaName"]; 

		$sql =  "INSERT INTO areas (areaName) VALUES('".$areaName."')";
			
		if (mysqli_query($conn, $sql)) {
			//echo '<br>'.$sql.'<br>';
			header("Location: ../../areas/list-areas.php?success=1&create=1");
		} else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		mysqli_close($conn);

      	exit();  	

?>