<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';
	if (!$conn)
		die("Connection failed: " . mysqli_connect_error());

	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "")
		$like = "AND saleArticleName LIKE '" . $_POST["search"] . "'";

if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["add"]))
		echo '<strong>Success!</strong> The article has been added to inventory succesfully.';
	
	else if(isset($_REQUEST["create"]))
		echo '<strong>Success!</strong> The article has been added to sales succesfully.';		
	
	else if(isset($_REQUEST["remove"]))
		echo '<strong>Success!</strong> The article has been removed from sales succesfully.';

	else if(isset($_REQUEST["update"]))
		echo '<strong>Success!</strong> The article has been updated succesfully.';
	
	echo '</div>';
}

$orderby = "saleId";
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
	$orderby = "saleArticleName";

else if ($sort == 2)
	$orderby = "saleWeight";

else if ($sort == 3)
	$orderby = "saleDateTime";

else if ($sort == 4)
	$orderby = "saleFinalPrice";

else if ($sort == 5)
	$orderby = "forsale";

$sql = "SELECT * FROM sales WHERE forSale!='0' AND goldStatus='1' ".$like." ORDER BY ".$orderby." ".$typeOrder."";

?>
<h3>New Gold Inventory</h3>
<div class="table-responsive">
	<form action="new-gold.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
			<div class="question-group" id="question-group">
				<div class="col-md-3">
					<a href="add-to-inventory.php" class="btn btn-primary"><i class="fa fa-plus"></i><b> Add to Inventory</b></a>
				</div>
				<div class="col-md-3">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
				<div class="col-md-3 pull-right"><a href="view-inventory-pdf.php" class="btn btn-info">Generate PDF</a></div>
			</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td><a href="new-gold.php?s=1&a_d=<?php echo $A_D ?>"><b>Name</b></a></td>
			<td><a href="new-gold.php?s=2&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
			<td><a href="new-gold.php?s=3&a_d=<?php echo $A_D ?>"><b>Date Added</b></a></td>
			<td><a href="new-gold.php?s=4&a_d=<?php echo $A_D ?>"><b>Sale Price</b></a></td>
			<td><a href="new-gold.php?s=5&a_d=<?php echo $A_D ?>"><b>On Sale</b></a></td>
			<td><b>Options</b></td>
		</tr>
		<?php
		
		$result = $conn->query($sql);	
		
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {

	    		$articleDate = date("Y-m-d", strtotime($row["saleDateAdded"]) ); 

		        echo "<tr><td>" . $row["saleArticleName"]. "</td><td>" . $row["saleWeight"] . "g " . $row["saleWeightMili"] ."mg". "</td><td>" . $articleDate . "</td>";

		        if(isset($row["saleFinalPrice"])){
		        	echo "<td>" . $row["saleFinalPrice"] . "</td><td>";
		        }else{
		        	echo "<td>Not Set</td><td>";
		        }

		    	if($row["forsale"] == 1) {
		    		echo "Yes" . "</td><td>";
		    		echo "
			    	<a href='../backend/inventory/remove-from-sales.php?new=".$row["saleId"]."'><i class='fa fa-minus fa-fw'></i>Remove from Sales</a></td></tr>";
		    	}
		    	else if($row["forsale"] == 2) {
		    		echo "No" . "</td><td>";
		    		echo "
			    	<a href='../backend/inventory/add-to-sales.php?new=".$row["saleId"]."'><i class='fa fa-plus fa-fw'></i>Add to Sales</a></td></tr>";
		    	}
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

