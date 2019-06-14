<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';
	$parameters = "?";
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND orderFirstName LIKE '" . $_POST["search"] . "'";
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
	$orderby = "orderFirstName";

else if ($sort == 2)
	$orderby = "orderLastName";

else if ($sort == 3)
	$orderby = "orderWeight";

else if ($sort == 4)
	$orderby = "orderDeliveryDate";

$sql = "SELECT * FROM orders WHERE orderPending='0' ".$like." ORDER BY ".$orderby." ".$typeOrder."";

?>
<h3>Orders in Stock</h3>
<div class="table-responsive">
	<form action="orders-stock.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
		<div class="question-group" id="question-group">
			<div class="col-md-3">
				<input type="text" class="form-control" name="search" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>		
			
			<div class="pull-right btn-group">
				<a target="_blank" href="orders-stock/orders-stock-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
				<a target="_blank" href="orders-stock/orders-stock-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
			</div>
		</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td>Row</td>
			<td><a href="orders-stock.php?s=1&a_d=<?php echo $A_D ?>"><b>First Name</b></td>
			<td><a href="orders-stock.php?s=2&a_d=<?php echo $A_D ?>"><b>Last Name</b></td>
			<td><a href="orders-stock.php?s=3&a_d=<?php echo $A_D ?>"><b>Weight</b></td>
			<td><a href="orders-stock.php?s=4&a_d=<?php echo $A_D ?>"><b>Purchase Date</b></td>
		</tr>
		<?php
		
		$result = $conn->query($sql);	
		$contador = 0;
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    	$contador++;
		    	$articleDate = date("Y-m-d h:i:s a", strtotime($row["orderDeliveryDate"]) );    	

			    echo "<tr><td>".$contador."</td><td>" . $row["orderFirstName"]. "</td><td>" . $row["orderLastName"]. "</td><td>" . $row["orderWeight"]. "g ". $row["orderWeightMili"] . "mg" . "</td><td>" . $articleDate . "</td><td>";
		    }
		} 
		else {
		    echo "<tr><td>0 results</td></tr>";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

