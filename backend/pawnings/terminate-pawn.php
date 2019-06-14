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
		
	$sql = "UPDATE pawnings SET forPawn='2' WHERE pawnBillNo='".$_POST['pawnBillNo']."'";
	
	if(mysqli_query($conn, $sql)){
		header("Location: ../../pawnings/list-pawnings-won.php?success=1&create=1");
	}else{		
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
		
		
	mysqli_close($conn);

    exit();  	
?>