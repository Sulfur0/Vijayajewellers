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
			
			
		$sql = "SELECT pawnBillNo FROM pawnings WHERE pawnId='".$_POST["pawnId"]."'";	
	    echo $sql;
		$result = mysqli_query($conn, $sql);
		$row = $result->fetch_assoc();
	    
	    $sql2="";
		
		foreach ($_POST["extraValue"] as $key => $getid) {
			$sql2 .=  "INSERT INTO pawningextras (extraValue,extraConcept,pawnBillNo) VALUES('".$_POST["extraValue"][$key]."','Additional payment to client','".$row["pawnBillNo"]."');";		    

		}		
		if (mysqli_multi_query($conn, $sql2)) {
			//echo '<br>'.$sql2.'<br>';
			header("Location: ../../pawnings/list-pawnings.php?success=1&update=1");
		} else {			
		    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
		}
		
		mysqli_close($conn);

      	exit();

   	

?>