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

		$pawnDateTime = $_POST["pawnDateTime"];
		$pawnBillNo = $_POST["pawnBillNo"];
		$pawnFirstName = $_POST["pawnFirstName"];	
		$pawnLastName = $_POST["pawnLastName"];
        $pawnAge = $_POST["pawnAge"];
        $pawnAreaName = $_POST["pawnAreaName"]; 
        $pawnAddress = $_POST["pawnAddress"]; 
        $pawnIdcard = $_POST["pawnIdcard"]; 
        $pawnIdcardAuthorized = $_POST["pawnIdcardAuthorized"]; 
        $pawnAuthorized = $_POST["pawnAuthorized"]; 


        $sql3="SELECT name FROM customers WHERE name='".$_POST["pawnFirstName"]."' AND lastname='".$_POST["pawnLastName"]."'";
		//echo $sql3 . "<br>";
		$result = mysqli_query($conn,$sql3);
		$row = $result->fetch_assoc();

		if (!isset($row["name"])) {
			$sql3 = "INSERT INTO customers SET name='".$_POST["pawnFirstName"]."', lastname='".$_POST["pawnLastName"]."'";
				mysqli_query($conn,$sql3);
		}	


		foreach ($_POST["pawnAmount"] as $key => $getid) {
			
            $pawnArticleType = $_POST["pawnArticleType"][$key]; 
            $pawnNetWeight = $_POST["pawnNetWeight"][$key]; 
            $pawnNetWeightMili = $_POST["pawnNetWeightMili"][$key]; 
            $pawnGrossWeight = $_POST["pawnGrossWeight"][$key];
            $pawnGrossWeightMili = $_POST["pawnGrossWeightMili"][$key];
            $pawnAmount = $_POST["pawnAmount"][$key]; 	
		    $sql .=  "INSERT INTO pawnings (pawnDateTime,pawnBillNo,pawnFirstName,pawnLastName,pawnAge,pawnAreaName,pawnAddress,pawnIdcard,pawnArticleType,pawnNetWeight,pawnNetWeightMili,pawnGrossWeight,pawnGrossWeightMili,pawnAuthorized,pawnIdcardAuthorized,pawnAmount) VALUES('".$pawnDateTime."','".$pawnBillNo."','".$pawnFirstName."','".$pawnLastName."','".$pawnAge."','".$pawnAreaName."','".$pawnAddress."','".$pawnIdcard."','".$pawnArticleType."','".$pawnNetWeight."','".$pawnNetWeightMili."','".$pawnGrossWeight."','".$pawnGrossWeightMili."','".$pawnAuthorized."','".$pawnIdcardAuthorized."','".$pawnAmount."');";
		}		
		
		if (mysqli_multi_query($conn, $sql)) {
			echo '<br>'.$sql.'<br>';
			header("Location: ../../pawnings/list-pawnings.php?success=1&create=1");
		} else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		
		
	mysqli_close($conn);
	
?>