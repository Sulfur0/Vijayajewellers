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
		
		$articleName = $_POST["articleName"]; 

		$sql =  "INSERT INTO articles (articleName) VALUES('".$articleName."')";
			
		if (mysqli_query($conn, $sql)) {
			//echo '<br>'.$sql.'<br>';
			header("Location: ../../articles/list-articles.php?success=1&create=1");
		} else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		mysqli_close($conn);

      	exit();  	

?>