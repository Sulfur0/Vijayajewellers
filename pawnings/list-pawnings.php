<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';

	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "")
		$like = "AND pawnBillNo LIKE '" . $_POST["search"] . "'";

if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["close"])){
		echo '<strong>Success!</strong> The pawn has been closed succesfully.';
	}else if(isset($_REQUEST["create"])){
		echo '<strong>Success!</strong> The pawn has been created succesfully.';		
	}else if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The pawn has been updated succesfully.';
	}
	echo '</div>';
}
else if(isset($_REQUEST["failure"])) {
	echo '<div class="alert alert-danger alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	echo '<strong>Failure</strong> The pawn still have time to be redeemed';
	echo '</div>';
}

$orderby = "pawnId";
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
	$orderby = "pawnBillNo";

else if ($sort == 2)
	$orderby = "pawnDateTime";

else if ($sort == 3)
	$orderby = "pawnFirstName";

else if ($sort == 4)
	$orderby = "pawnLastName";

else if ($sort == 6)
	$orderby = "warning";
?>
<h3>List of pawnings</h3>
<div class="table-responsive">
	<form action="list-pawnings.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
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
			<td><a href="list-pawnings.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="list-pawnings.php?s=5&a_d=<?php echo $A_D ?>"><b>Date Time</b></a></td>
			<td><a href="list-pawnings.php?s=2&a_d=<?php echo $A_D ?>"><b>Max Redeem Date</b></a></td>
			<td><a href="list-pawnings.php?s=3&a_d=<?php echo $A_D ?>"><b>First Name</b></a></td>
			<td><a href="list-pawnings.php?s=4&a_d=<?php echo $A_D ?>"><b>Last Name</b></a></td>
			<td><a href="list-pawnings.php?s=6&a_d=<?php echo $A_D ?>"><b>Warnings</b></a></td>
			<td><b>Options</b></td>
		</tr>
		<?php
		
		$sql = "SELECT * FROM pawnings WHERE forPawn = '1' ".$like." ORDER BY ".$orderby." ".$typeOrder." ";
		$result = $conn->query($sql);	
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    	//CALCULANDO FECHA LIMITE DE ENTREGA
		    	$newEndingDate = date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s", strtotime($row["pawnDateTime"])) . " + 1 year + 7 days"));		    	
		    	$pawnDate = date("Y-m-d h:i:s", strtotime($row["pawnDateTime"]));		    	

		        echo "<tr><td>VJ" . $row["pawnBillNo"]. "</td><td>" . $pawnDate . "</td><td>" . $newEndingDate. "</td><td>" . $row["pawnFirstName"]. "</td><td>" . $row["pawnLastName"]. "</td><td>" . $row["warning"] . "</td>";		        	        
		        echo "<td>	        
		        
		        <a href='update-pawning.php?pawnId=".$row["pawnId"]."'><i class='fa fa-pencil fa-fw'></i>View/Edit</a> 
		        <a target='_blank' href='view-bill.php?pawnId=".$row["pawnId"]."'><i class='fa fa-file fa-fw'></i>View Bill</a></td></tr>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

