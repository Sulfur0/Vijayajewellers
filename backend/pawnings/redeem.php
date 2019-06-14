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
			
			
	$sql = "SELECT pawnId FROM pawnings WHERE pawnBillNo='".$_POST["pawnBillNo"]."'";	
	$result = mysqli_query($conn, $sql);
	$sql2="";
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	        $sql2 .= "UPDATE pawnings SET forPawn='0' WHERE pawnId='".$row["pawnId"]."';";
	    }
	} else {
	    echo "0 results";
	}
		
	$sql2 .=  "INSERT INTO pawningextras (extraValue,extraConcept,pawnBillNo) VALUES('".$_POST["extraValue"]."','Final payment by client','".$_POST["pawnBillNo"]."');";		    
	//echo '<br>'.$sql2.'<br>';
	if (mysqli_multi_query($conn, $sql2)) {			
		header("Location: ../../pawnings/list-pawnings.php?success=1&close=1");
	} else {			
		echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
	}
		
	mysqli_close($conn);

    exit();

   	

?>