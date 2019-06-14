<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';

// if(isset($_REQUEST["success"])){
// 	echo '<div class="alert alert-success alert-dismissable fade in">';
// 	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
// 	if(isset($_REQUEST["close"])){
// 		echo '<strong>Success!</strong> The pawn has been closed succesfully.';
// 	}else if(isset($_REQUEST["create"])){
// 		echo '<strong>Success!</strong> The pawn has been created succesfully.';		
// 	}else if(isset($_REQUEST["update"])){
// 		echo '<strong>Success!</strong> The pawn has been updated succesfully.';
// 	}
// 	echo '</div>';
// }
$flag = 1;
if($_GET["sts"]) {
	$sql = "SELECT * FROM sales WHERE forSale='2'";
}
else if (!$_GET["sts"]) {
	$sql = "SELECT * FROM pawnings WHERE forPawn='2' OR forpawn='3'";
	$flag = 0;
}

?>
<h3>Inventory</h3>
<div class="table-responsive">

	<?php if($flag): ?>
	<h4>New Gold</h4>
	<br><a href=""><i class="fa fa-plus"></i>Add New Gold to Inventory</a><br><br>
	<?php endif; ?>

  	<table class="table">
		<tr>
			<td><b>Name</b></td><td><b>Weight</b></td><td><b>Purchase Date</b></td><td><b>On Sale</b></td><td><b>Options</b></td>
		</tr>
		<?php
		
		$result = $conn->query($sql);	
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {

		    	if ($flag) {
		    		$articleDate = date("Y-m-d h:i:s", strtotime($row["saleDateTime"]) );    	

			        echo "<tr><td>" . $row["saleArticleName"]. "</td><td>" . $row["saleWeight"] . "</td><td>" . $articleDate . "</td><td>" . "Yes" . "</td><td>";
		    	}
		    	else if (!$flag) {
		    		$articleDate = date("Y-m-d h:i:s", strtotime($row["pawnDateTime"]) );    	

			        echo "<tr><td>" . $row["pawnArticleType"]. "</td><td>" . $row["pawnNetWeight"] . "</td><td>" . $articleDate . "</td>";

			        echo "<td><a href='add-gold.php?sts=".$_GET["sts"]."'><i class='fa fa-plus fa-fw'></i>Add to Sales</a><br>";    	        
		    	}
		    	echo "
			    <a href='remove-gold.php?sts=".$_GET["sts"]."'><i class='fa fa-minus fa-fw'></i>Remove from Sales</a></td></tr>";
		    }
		} else {
		    echo "<tr><td>0 results</td></tr>";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

