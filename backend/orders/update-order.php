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
	echo var_dump($_POST['deliver-order']);
	if (isset($_POST['deliver-order'])){
		$date = date("Y-m-d");
		$sql = "UPDATE orders SET orderPending='1', orderFinished='".$date."' WHERE orderBillNo='".$_POST["orderBillNo"]."'";

		if (mysqli_query($conn, $sql)) {
		    header("Location: ../../orders/list-orders.php?success=1&deliver=1");
		} 
		else {
		    echo "Error delivering record: " . mysqli_error($conn);
		}
	}
	else if (!isset($_POST['deliver-order'])){
		// sql to update a record
		$sql="";
		$orderDeliveryDate = $_POST["orderDeliveryDate"];
	    $orderFirstName = $_POST["orderFirstName"];
	    $orderLastName = $_POST["orderLastName"];
	    $orderAddress = $_POST["orderAddress"];
	    $orderTelephone = $_POST["orderTelephone"];
		$orderDesignDetail = $_POST["orderDesignDetail"];
		$orderCost = $_POST["orderCost"];
		$orderAdvance = $_POST["orderAdvance"];
		$orderBillNo = $_POST["orderBillNo"];
		$orderWeight = $_POST["orderWeight"];
		$orderQuality = $_POST["orderQuality"];

		$sql .= "UPDATE orders SET orderDeliveryDate='".$orderDeliveryDate."', orderFirstName='".$orderFirstName."', orderLastName='".$orderLastName."', orderAddress='".$orderAddress."', orderTelephone='".$orderTelephone."', orderDesignDetail='".$orderDesignDetail."', orderCost='".$orderCost."', orderAdvance='".$orderAdvance."', orderQuality='".$orderQuality."', orderWeight='".$orderWeight."' WHERE orderBillNo='".$orderBillNo."';";
		
		
		if (mysqli_multi_query($conn, $sql)) {
		    header("Location: ../../orders/list-orders.php?success=1&update=1");
		    
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}
	mysqli_close($conn);

    exit();   	
?>