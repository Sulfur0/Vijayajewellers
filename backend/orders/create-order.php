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
		
		foreach ($_POST["orderDeliveryDate"] as $key => $getid) {
			$orderDeliveryDate = $_POST["orderDeliveryDate"][$key];
            $orderBillNo = $_POST["orderBillNo"][$key];
            $orderFirstName = $_POST["orderFirstName"][$key];
            $orderLastName = $_POST["orderLastName"][$key];
            $orderAddress = $_POST["orderAddress"][$key];
            $orderTelephone = $_POST["orderTelephone"][$key];
			$orderDesignDetail = $_POST["orderDesignDetail"][$key];
			$orderCost = $_POST["orderCost"][$key];
			$orderAdvance = $_POST["orderAdvance"][$key];
			$orderQuality = $_POST["orderQuality"][$key];
			$orderWeight = $_POST["orderWeight"][$key];
			$orderWeightMili = $_POST["orderWeightMili"][$key];
			$orderArea = $_POST["orderArea"][$key];

		    $sql .=  "INSERT INTO orders (orderDeliveryDate,orderBillNo,orderFirstName,orderLastName,orderAddress,orderTelephone,orderDesignDetail,orderCost,orderAdvance,orderQuality,orderWeight,orderWeightMili,orderPending,orderArea) VALUES(
		    '".$orderDeliveryDate."',
		    '".$orderBillNo."',
		    '".$orderFirstName."',
		    '".$orderLastName."',
		    '".$orderAddress."',
		    '".$orderTelephone."',
		    '".$orderDesignDetail."',
		    '".$orderCost."',
		    '".$orderAdvance."',
		    '".$orderQuality."',
		    '".$orderWeight."',
		    '".$orderWeightMili."',
		    '0',
		    '".$orderArea."');";

		}		
		if (mysqli_multi_query($conn, $sql)) {
			//echo '<br>'.$sql.'<br>';
			header("Location: ../../orders/list-orders.php?success=1&create=1");
		} else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		mysqli_close($conn);

      	exit();  	

?>