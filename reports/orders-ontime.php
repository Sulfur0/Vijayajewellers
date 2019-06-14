<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php 
	include '../backend/connection.php';
	$parameters = "?";
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like .= "AND orderBillNo LIKE '" . $_POST["search"] . "'";
		$like .= " OR orderFirstName LIKE '" . $_POST["search"] . "'";
		$like .= " OR orderLastName LIKE '" . $_POST["search"] . "'";
		$parameters .= "&search=".$_POST["search"];
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
	$orderby = "orderFinished";

else if ($sort == 4)
	$orderby = "orderFirstName";

else if ($sort == 5)
	$orderby = "orderLastName";

else if ($sort == 6)
	$orderby = "orderTelephone";

$sql = "SELECT * FROM orders WHERE orderFinished <= orderDeliveryDate ".$like." ORDER BY ".$orderby." ".$typeOrder."";
$result = $conn->query($sql);
?>
<h3>Orders Completed On Time</h3>
<div class="table-responsive">
	<form action="orders-ontime.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
		<div class="question-group" id="question-group">
			<div class="col-md-3">
				<input type="text" class="form-control" name="search" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>		
			
			<div class="pull-right btn-group">
				<a target="_blank" href="orders-ontime/orders-ontime-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
				<a target="_blank" href="orders-ontime/orders-ontime-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
			</div>
		</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td>Row</td>
			<td><a href="orders-ontime.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="orders-ontime.php?s=2&a_d=<?php echo $A_D ?>"><b>Delivery Date</b></a></td>
			<td><a href="orders-ontime.php?s=3&a_d=<?php echo $A_D ?>"><b>Finish Date</b></a></td>
			<td><a href="orders-ontime.php?s=4&a_d=<?php echo $A_D ?>"><b>First Name</b></a></td>
			<td><a href="orders-ontime.php?s=5&a_d=<?php echo $A_D ?>"><b>Last Name</b></a></td>
			<td><a href="orders-ontime.php?s=6&a_d=<?php echo $A_D ?>"><b>Telephone</b></a></td>
		</tr>
	<?php
	$contador = 0;
	if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$contador++;
				
				$orderDelivery = date("Y-m-d h:i:s a", strtotime($row["orderDeliveryDate"])); 
				$orderFinish = 	date("Y-m-d h:i:s a", strtotime($row["orderFinished"])); 

		       	echo "<tr><td>".$contador."</td><td>" . $row["orderBillNo"] . "</td><td>" . $orderDelivery . "</td><td>" . $orderFinish . "</td><td>" . $row["orderFirstName"]. "</td><td>" . $row["orderLastName"] . "</td><td>" . $row["orderTelephone"] . "</td>";
				
			}
		}
		else {
			echo "<tr><td>0 results</td></tr>";
		}
	?>
	</table>
</div>
<?php include '../include/layout-bottom-low.php'; ?> 