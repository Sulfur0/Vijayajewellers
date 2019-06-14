<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';
	if (!$conn) 
		die("Connection failed: " . mysqli_connect_error());

	$like = "";
	$like2 = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND pawnArticleType LIKE '" . $_POST["search"] . "'";
		$like2 = "AND saleArticleName LIKE '" . $_POST["search"] . "'";
	}
	
if(isset($_REQUEST["success"])) {
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["add"]))
		echo '<strong>Success!</strong> The article has been added to inventory succesfully.';
	
	else if(isset($_REQUEST["create"]))
		echo '<strong>Success!</strong> The article has been added to sales succesfully.';		
	
	else if(isset($_REQUEST["remove"]))
		echo '<strong>Success!</strong> The article has been removed from sales succesfully.';
	
	echo '</div>';
}

$orderby = "saleId";
$orderby2 = "pawnId";
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

if ($sort == 1) {
	$orderby = "saleArticleName";
	$orderby2 = "pawnArticleType";
}

else if ($sort == 2) {
	$orderby = "saleWeight";
	$orderby2 = "pawnNetWeight";
}

else if ($sort == 3) {
	$orderby = "saleDateTime";
	$orderby2 = "pawnDateTime";
}

else if ($sort == 4) {
	$orderby = "forsale";
	$orderby2 = "forPawn";
}

$sql = "SELECT * FROM sales WHERE forSale!='0' AND goldStatus='0' ".$like." ORDER BY ".$orderby." ".$typeOrder."";
$sql2 = "SELECT * FROM pawnings WHERE forPawn='2' ".$like2." ORDER BY ".$orderby2." ".$typeOrder."";

?>
<h3>Old Gold Inventory</h3>
<div class="table-responsive">
	<form action="pawnings-won.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
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
			<td><a href="old-gold.php?s=1&a_d=<?php echo $A_D ?>"><b>Name</b></a></td>
			<td><a href="old-gold.php?s=2&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
			<td><a href="old-gold.php?s=3&a_d=<?php echo $A_D ?>"><b>Purchase Date</b></a></td>
			<td><a href="old-gold.php?s=4&a_d=<?php echo $A_D ?>"><b>On Sale</b></a></td>
			<td><b>Options</b></td>
		</tr>
		<?php
		
		$result = $conn->query($sql);	
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    	$articleDate = date("Y-m-d h:i:s", strtotime($row["saleDateTime"]) );    	

		        echo "<tr><td>" . $row["saleArticleName"]. "</td><td>" . $row["saleWeight"] . "</td><td>" . $articleDate . "</td><td>";

		        if($row["forsale"] == 1) {
		    		echo "Yes" . "</td><td>";
		    		echo "
			    	<a href='../backend/inventory/remove-from-sales.php?old=".$row["saleId"]."'><i class='fa fa-minus fa-fw'></i>Remove from Sales</a></td></tr>";
		    	}
		    	else if($row["forsale"] == 2) {
		    		echo "No" . "</td><td>";
		    		echo "
			    	<a href='../backend/inventory/add-to-sales.php?old=".$row["saleId"]."'><i class='fa fa-minus fa-fw'></i>Add to Sales</a></td></tr>";
		    	}
		    }
		}

		$result2 = $conn->query($sql2);

		if ($result2->num_rows > 0) {
			while ($row = $result2->fetch_assoc()) {
				$articleDate = date("Y-m-d h:i:s", strtotime($row["pawnDateTime"]) );    	

			    echo "<tr><td>" . $row["pawnArticleType"]. "</td><td>" . $row["pawnNetWeight"] . "</td><td>" . $articleDate . "</td><td>No</td>";

			    if($row["forPawn"] == 2)
			    	echo "<td><a href='../backend/inventory/add-to-sales.php?oldp=".$row["pawnId"]."'><i class='fa fa-plus fa-fw'></i>Add to Sales</a></td></tr>"; 
			    
			}
		}

		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

