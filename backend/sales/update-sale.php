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
	// sql to udpdate a salebill
	$sql = "UPDATE saleBills SET 
	sbillDate='".$_POST["sbillDate"]."',
	sbillFirstName='".$_POST["sbillFirstName"]."',
	sbillLastName='".$_POST["sbillLastName"]."',
	sbillFinalPrice='".$_POST["sbillFinalPrice"]."',
	sbillExchange='".$_POST["sbillExchange"]."',
	sbillExchArticle='".$_POST["sbillExchArticle"]."',
	sbillExchWeight='".$_POST["sbillExchWeight"]."',
	sbillExchWeightMili='".$_POST["sbillExchWeightMili"]."'
	 WHERE saleBillNo='".$_POST["saleBillNo"]."';";

	foreach ($_POST["saleArticleName"] as $key => $getid) {
		$sql .= "UPDATE sales SET 
		saleArticleName='".$_POST["saleArticleName"][$key]."',
		saleArticleCode='".$_POST["saleArticleCode"][$key]."',
		saleWeight='".$_POST["saleWeight"][$key]."',
		saleWeightMili='".$_POST["saleWeightMili"][$key]."',
		saleLabor='".$_POST["saleLabor"][$key]."',
		saleLossGold='".$_POST["saleLossGold"][$key]."',
		saleGoldValue='".$_POST["saleGoldValue"][$key]."',
		saleFinalPrice='".$_POST["saleFinalPrice"][$key]."'
		 WHERE saleId='".$_POST["saleId"][$key]."';";
	}

	/*Si el customer no existe lo registra*/
	$sql2 = "SELECT name, lastname FROM customers WHERE name ='".$_POST["sbillFirstName"]."' AND lastname = '".$_POST["sbillLastName"]."'";
	$result2 = mysqli_query($conn, $sql2);

	if (!mysqli_num_rows($result2) > 0) {
		$sql .= "INSERT INTO customers (name, lastname)
		VALUES ('".$_POST["sbillFirstName"]."', '".$_POST["sbillLastName"]."')";
	}

	//echo $sql;
	
	if (mysqli_multi_query($conn, $sql)) {			
		header("Location: ../../sales/bill-sales.php?success=1&update=1");
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	

	mysqli_close($conn);

    exit();   	
?>