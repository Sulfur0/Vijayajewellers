<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php 
	include '../backend/connection.php';

	$parameters = "?";
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND pawnBillNo LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnArticleType LIKE '" . $_POST["search"] . "'";
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
	$orderby = "pawnArticleType";

else if ($sort == 3)
	$orderby = "pawnNetWeight";

$sql = "SELECT * FROM pawnings WHERE forPawn='2' ".$like." ORDER BY ".$orderby." ".$typeOrder."";
$result = $conn->query($sql);
?>
<h3>Pawnings Won</h3>
<div class="table-responsive">
	<form action="pawnings-won.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
		<div class="question-group" id="question-group">
			<div class="col-md-3">
				<input type="text" class="form-control" name="search" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>		
			
			<div class="pull-right btn-group">
				<a target="_blank" href="pawnings-won/pawnings-won-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
				<a target="_blank" href="pawnings-won/pawnings-won-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
			</div>
		</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td>Row</td>
			<td><a href="pawnings-won.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="pawnings-won.php?s=2&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="pawnings-won.php?s=3&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
		</tr>
	<?php
	if ($result->num_rows > 0) {
			$contador = 0;
			while($row = $result->fetch_assoc()) {	
				$contador++;
		        echo "<tr><td>".$contador."</td><td>" . $row["pawnBillNo"] . "</td><td>" . $row["pawnArticleType"] . "</td><td>" . $row["pawnNetWeight"] . "</td></tr>";
			}
		}
		else {
			echo "<td>0 results<td></tr>";
		}
	?>
	</table>
</div>
<?php include '../include/layout-bottom-low.php'; ?> 