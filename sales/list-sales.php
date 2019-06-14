<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php

if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["delete"])){
		echo '<strong>Success!</strong> The sale has been deleted succesfully.';
	}else if(isset($_REQUEST["create"])){
		echo '<strong>Success!</strong> The sale has been created succesfully.';
	}else if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The sale has been updated succesfully.';
	}
	echo '</div>';
}

$orderby = "saleId";
$A_D = 0;
$typeOrder = "ASC";
$sort = -1;

if (isset($_GET["s"])) {
	$sort = $_GET["s"];
	if($_GET["a"] == 0) {
		$typeOrder = "DESC";
		$A_D = 1;
	}
}

if ($sort == 1)
	$orderby = "saleArticleName";

else if ($sort == 2)
	$orderby = "saleArticleCode";

else if ($sort == 3)
	$orderby = "saleWeight";

else if ($sort == 4)
	$orderby = "saleLabor";

else if ($sort == 5)
	$orderby = "saleLossGold";

else if ($sort == 6)
	$orderby = "saleFinalPrice";

?>
<h3>List of sales</h3>
<div class="table-responsive">
  	<table class="table">
		<tr>
			<td><a href="list-sales.php?s=1&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="list-sales.php?s=2&a_d=<?php echo $A_D ?>"><b>Code</b></a></td>
			<td><a href="list-sales.php?s=3&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
			<td><a href="list-sales.php?s=4&a_d=<?php echo $A_D ?>"><b>Labor</b></a></td>
			<td><a href="list-sales.php?s=5&a_d=<?php echo $A_D ?>"><b>Loss of gold</b></a></td>
			<td><a href="list-sales.php?s=6&a_d=<?php echo $A_D ?>"><b>Final Price</b></a></td>
			<td><a href="#"><b>Options</b></a></td>
		</tr>
		<?php
		include '../backend/connection.php';
		$sql = "SELECT * FROM sales WHERE forsale = '1' ORDER BY ".$orderby." ".$typeOrder." ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "<tr><td>" . $row["saleArticleName"]. "</td><td>" . $row["saleArticleCode"]. "</td><td>" . $row["saleWeight"]. "</td><td>" . $row["saleLabor"]. "</td><td>" . $row["saleLossGold"]. "</td><td>" . $row["saleFinalPrice"]. "</td>";		        	        
		        echo "<td><a href='purchase-sale.php?saleId=".$row["saleId"]."'><i class='fa fa-cart-plus fa-fw'></i>Purchase</a> <a href='update-sale.php?saleId=".$row["saleId"]."'><i class='fa fa-pencil fa-fw'></i>Edit</a> <a href='delete-sale.php?saleId=".$row["saleId"]."'><i class='fa fa-trash fa-fw'></i>Delete</a></td></tr>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

