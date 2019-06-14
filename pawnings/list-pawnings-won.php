<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';

	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "")
		$like = "AND pawnBillNo LIKE '" . $_POST["search"] . "'";

if (isset($_REQUEST["success"])) {
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	echo '<strong>Success!</strong> The pawn has been won.';
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
	$orderby = "pawnNetWeight";

else if ($sort == 3)
	$orderby = "pawnFirstName";

else if ($sort == 4)
	$orderby = "pawnLastName";

?>
<h3>Pawn Won Inventory</h3>
<div class="table-responsive">
	<form action="list-pawnings-won.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
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
			<td><a href="list-pawnings-won.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></td>
			<td><a href="list-pawnings-won.php?s=2&a_d=<?php echo $A_D ?>"><b>Weight</b></td>
			<td><a href="list-pawnings-won.php?s=3&a_d=<?php echo $A_D ?>"><b>First Name</b></td>
			<td><a href="list-pawnings-won.php?s=4&a_d=<?php echo $A_D ?>"><b>Last Name</b></td>
		</tr>
		<?php
		
		$sql = "SELECT * FROM pawnings WHERE forPawn = '2' ".$like." ORDER BY ".$orderby." ".$typeOrder."";
		$result = $conn->query($sql);	
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {   	
		        echo "<tr><td>" . $row["pawnBillNo"]. "</td><td>" . $row["pawnNetWeight"] . "</td><td>" . $row["pawnFirstName"]. "</td><td>" . $row["pawnLastName"]. "</td>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

