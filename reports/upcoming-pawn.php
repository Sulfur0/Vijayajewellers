<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php 
	include '../backend/connection.php';

	$parameters = "?";
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND pawnBillNo LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnFirstName LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnLastName LIKE '" . $_POST["search"] . "'";
		$parameters .= "&search=".$_POST["search"];
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

else if ($sort == 5)
	$orderby = "pawnAuthorized";

else if ($sort == 6)
	$orderby = "warning";

	$sql = "SELECT * FROM pawnings WHERE forPawn='1' ".$like." ORDER BY ".$orderby." ".$typeOrder."";
	$result = $conn->query($sql);
?>
<h3>Upcoming Pawns</h3>
<div class="table-responsive">
	<form action="upcoming-pawn.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
		<div class="question-group" id="question-group">
			<div class="col-md-3">
				<input type="text" class="form-control" name="search" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>		
			
			<div class="pull-right btn-group">
				<a target="_blank" href="upcoming-pawn/upcoming-pawn-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
				<a target="_blank" href="upcoming-pawn/upcoming-pawn-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
			</div>
		</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td>Row</td>
			<td><a href="upcoming-pawn.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="upcoming-pawn.php?s=2&a_d=<?php echo $A_D ?>"><b>Max Redeem Date</b></a></td>
			<td><a href="upcoming-pawn.php?s=3&a_d=<?php echo $A_D ?>"><b>First Name</b></a></td>
			<td><a href="upcoming-pawn.php?s=4&a_d=<?php echo $A_D ?>"><b>Last Name</b></a></td>
			<td><a href="upcoming-pawn.php?s=5&a_d=<?php echo $A_D ?>"><b>Authorized Person</b></a></td>
			<td><a href="upcoming-pawn.php?s=6&a_d=<?php echo $A_D ?>"><b>Warnings</b></a></td>
		</tr>
	<?php
		if ($result->num_rows > 0) {
			$contador = 0;
			while($row = $result->fetch_assoc()) {
				
				$delivery = date("Y-m-d", strtotime(date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"])) . " + 11 months"));		   
				$finished = date("Y-m-d");

				if ($delivery <= $finished) {
					$contador++;
					$newEndingDate = date("Y-m-d h:i:s a", strtotime(date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"])) . " + 1 year + 7 days"));		    	
		        	echo "<tr><td>".$contador."</td><td>" . $row["pawnBillNo"]. "</td><td>" . $newEndingDate. "</td><td>" . $row["pawnFirstName"]. "</td><td>" . $row["pawnLastName"]. "</td><td>" . $row["pawnAuthorized"]. "</td><td>" . $row["warning"] . "</td></tr>";		        	        
				}
			}
		}
		else {
			echo "<td>0 results<td></tr>";
		}
	?>
	</table>
</div>
<?php include '../include/layout-bottom-low.php'; ?> 