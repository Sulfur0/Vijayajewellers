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
		/*FILTRO SI ES CREDIT O DEBIT*/

		$answer = $_POST['type'];  
		if ($answer == "credit") {          
		    /*SI ES CREDIT, OSEA PART PAYMENT*/ 
		    /*OBTENGO CUANTO SE PAGA*/
			$sql = "SELECT pawnPaid FROM pawnings WHERE pawnId='".$_POST["pawnIdentifier"]."'";	
		    //echo $sql."<br>";
			$result = mysqli_query($conn, $sql);
			$row = $result->fetch_assoc();
			/*SUMO CANTIDADES Y GUARDO*/
			$pawnPaid = $_POST['pawnAmount']+$row['pawnPaid'];
			$pawnId = $_POST['pawnIdentifier'];
			$sql = "UPDATE pawnings SET pawnPaid=".$pawnPaid." WHERE pawnId='".$pawnId."'";
			//echo $sql."<br>";
			$conn->query($sql);
		}
		else {
			/*SI ES DEBIT, OSEA REPAWN*/
		    /*OBTENGO CUANTO SE DEBE*/
			$sql = "SELECT pawnOwed FROM pawnings WHERE pawnId='".$_POST["pawnIdentifier"]."'";	
		    //echo $sql."<br>";
			$result = mysqli_query($conn, $sql);
			$row = $result->fetch_assoc();
			/*SUMO CANTIDADES Y GUARDO*/
			$pawnOwed = $_POST['pawnAmount']+$row['pawnOwed'];
			$pawnId = $_POST['pawnIdentifier'];
			$sql = "UPDATE pawnings SET pawnOwed=".$pawnOwed." WHERE pawnId='".$pawnId."'";
			//echo $sql."<br>";
			$conn->query($sql);
		} 
		/*REGISTRO EN PAWNINGEXTRAS*/
		$sql = "INSERT INTO pawningextras (pawnId, extraValue, extraConcept, pawnBillNo, extraDate)
VALUES ('".$_POST["pawnIdentifier"]."',
 '".$_POST['pawnAmount']."',
 '".$answer."',
 '".$_POST['pawnBillNo']."',
  '".$_POST['pawnDateTime']."')";

		

		if ($conn->query($sql) === TRUE) {
		    header("Location: ../../pawnings/list-pawnings.php?success=1&update=1");
		} else {
		    echo "Error updating record: " . $conn->error;
		}

		
	mysqli_close($conn);

    exit();
?>