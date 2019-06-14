<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';

	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "")
		$like = "AND orderBillNo LIKE '" . $_POST["search"] . "'";

if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["close"])){
		echo '<strong>Success!</strong> The order has been closed succesfully.';
	}else if(isset($_REQUEST["create"])){
		echo '<strong>Success!</strong> The order has been created succesfully.';		
	}else if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The order has been updated succesfully.';
	}
	else if(isset($_REQUEST["deliver"])){
		echo '<strong>Success!</strong> The order has been delivered succesfully.';
	}
	echo '</div>';
}
$orderby = "orderId";
$A_D = 0;
$typeOrder = "ASC";
$sort = -1;

if (isset($_GET["s"])) {
	$sort = $_GET["s"];
	if($_GET["a_d"] == 0) {
		$typeOrder = "DESC";
		$A_D = 1;
	}
}

if ($sort == 1)
	$orderby = "orderBillNo";

else if ($sort == 2)
	$orderby = "orderDeliveryDate";

else if ($sort == 3)
	$orderby = "orderFirstName";

else if ($sort == 4)
	$orderby = "orderLastName";

else if ($sort == 5)
	$orderby = "orderTelephone";

else if ($sort == 6)
	$orderby = "orderAddress";
?>
<h3>List of Pending Orders</h3>
<div class="table-responsive">
	<form action="pending-orders.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
			<div class="question-group" id="question-group">
				<div class="col-md-3">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
			</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td><a href="pending-orders.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="pending-orders.php?s=2&a_d=<?php echo $A_D ?>"><b>Delivery Date</b></a></td>
			<td><a href="pending-orders.php?s=3&a_d=<?php echo $A_D ?>"><b>First Name</b></a></td>
			<td><a href="pending-orders.php?s=4&a_d=<?php echo $A_D ?>"><b>Last Name</b></a></td>
			<td><a href="pending-orders.php?s=5&a_d=<?php echo $A_D ?>"><b>Telephone</b></a></td>
			<td><a href="pending-orders.php?s=6&a_d=<?php echo $A_D ?>"><b>Address</b></a></td>
		</tr>
		
		<?php
		
		$sql = "SELECT * FROM orders WHERE orderPending='0' ".$like." ORDER BY ".$orderby." ".$typeOrder." ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while ($row = $result->fetch_assoc()) {
		    	//CALCULANDO FECHA LIMITE DE ENTREGA
		    	$orderTime = date("Y-m-d h:i:s", strtotime($row["orderDeliveryDate"]));  	

		        echo "<tr><td>" . $row["orderBillNo"] . "</td><td>" . $orderTime . "</td><td>" . $row["orderFirstName"] . "</td><td>" . $row["orderLastName"]. "</td><td>" . $row["orderTelephone"] . "</td><td>" . $row["orderAddress"] . "</td>";
		    }
		} 
		else 
		    echo "0 results";

		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

