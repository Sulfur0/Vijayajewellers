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
		$sql="";	
		$sql2="";	
		
		foreach ($_POST["pawnDateTime"] as $key => $getid) {
			$sql3="SELECT email FROM customers WHERE name='".$_POST["pawnFirstName"][$key]."'";
			echo $sql3 . "<br>";
			$result = mysqli_query($conn,$sql3);
			$row = $result->fetch_assoc();

			if (!isset($row["email"])) {
				$sql3 = "INSERT INTO customers SET name='".$_POST["pawnFirstName"][$key]."', lastname='".$_POST["pawnLastName"][$key]."'";
				mysqli_query($conn,$sql3);
			}

			$pawnDateTime = $_POST["pawnDateTime"][$key];
            $pawnBillNo = $_POST["pawnBillNo"][$key];
            $pawnFirstName = $_POST["pawnFirstName"][$key];
            $pawnLastName = $_POST["pawnLastName"][$key];
            $pawnAge = $_POST["pawnAge"][$key];
            $pawnAreaName = $_POST["pawnAreaName"][$key]; 
            $pawnAddress = $_POST["pawnAddress"][$key]; 
            $pawnIdcard = $_POST["pawnIdcard"][$key]; 
            $pawnArticleType = $_POST["pawnArticleType"][$key]; 
            $pawnNetWeight = $_POST["pawnNetWeight"][$key]; 
            $pawnGrossWeight = $_POST["pawnGrossWeight"][$key];
            $pawnAuthorized = $_POST["pawnAuthorized"][$key]; 
			$extraValue = $_POST["extraValue"][$key]; 
            $extraConcept = 'Initial Payment to Customer';	
		    $sql .=  "INSERT INTO pawnings (pawnDateTime,pawnBillNo,pawnFirstName,pawnLastName,pawnAge,pawnAreaName,pawnAddress,pawnIdcard,pawnArticleType,pawnNetWeight,pawnGrossWeight,pawnAuthorized) VALUES('".$pawnDateTime."','".$pawnBillNo."','".$pawnFirstName."','".$pawnLastName."','".$pawnAge."','".$pawnAreaName."','".$pawnAddress."','".$pawnIdcard."','".$pawnArticleType."','".$pawnNetWeight."','".$pawnGrossWeight."','".$pawnAuthorized."');";
		    $sql .=  "INSERT INTO pawningextras (extraValue,extraConcept,pawnBillNo) VALUES('".$extraValue."','".$extraConcept."','".$pawnBillNo."');";
		}		
		
		if (mysqli_multi_query($conn, $sql)) {
			//echo '<br>'.$sql.'<br>';
			header("Location: ../../pawnings/list-pawnings.php?success=1&create=1");
		} 
		else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		mysqli_close($conn);

      	exit();  	
?>