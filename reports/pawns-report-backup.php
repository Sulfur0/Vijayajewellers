<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php
include '../backend/connection.php';

if (!$conn)
	die("Connection failed: " . mysqli_connect_error());
	
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND pawnBillNo LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnArticleType LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnFirstName LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnLastName LIKE '" . $_POST["search"] . "'";
	}

	$orderby = "pawnId";
	$A_D = "0";
	$typeOrder = "ASC";
	$sort = -1;

	if (isset($_GET["s"])) {
		$sort = $_GET["s"];
		if($_GET["a_d"] == 0) {
			$typeOrder = "DESC";
			$A_D = "1";
		}
	}

	if ($sort == 1) 
		$orderby = "pawnBillNo";

	else if ($sort == 2)
		$orderby = "pawnArticleType";

	else if ($sort == 3)
		$orderby = "pawnNetWeight";

	else if ($sort == 4)
		$orderby = "";

	else if ($sort == 5)
		$orderby = "pawnDateTime";

	else if ($sort == 6)
		$orderby = "pawnFirstName";

	else if ($sort == 7)
		$orderby = "pawnLastName";

	$sql = "SELECT timezone FROM config";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    date_default_timezone_set($row["timezone"]);

	$pawnAmount = 0;
	$pawnWeightAmount = 0;
	$sql = "SELECT * FROM pawnings WHERE forPawn='1' ".$like." ORDER BY ".$orderby." ".$typeOrder." ";
	$result = $conn->query($sql);

	if (isset($_GET["m"])) {
		echo "<h3>Monthly Pawn Report</h3>";
		$date2 = date("Y-m");
		$dateText = "Y-m";
		$A_D .= "&m=1";
	}
	else if (isset($_GET["a"])) {
		echo "<h3>Anual Pawn Report</h3>";
		$date2 = date("Y");
		$dateText = "Y";
		$A_D .= "&a=1";
	}

?>
<div class="table-responsive">
	<form action="pawns-report.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
			<div class="question-group" id="question-group">
			<div class="row">
				<div class="col-md-3 col-xs-9">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<div class="col-md-3 col-xs-3">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
				</div>
				<div class="col-md-3  col-xs-12 pull-right">					
					<a href="credit-debit-report.php??<?php echo $A_D;?>" class="btn btn-primary"><i class="fa fa-search"></i>View Credit and Debit History</a>
				</div>
			</div>
			</div>
	</form>
	
			
	<br>
  	<table class="table">
		<tr>
			<td><a href="pawns-report.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="pawns-report.php?s=2&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="pawns-report.php?s=3&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
			<td><a href="pawns-report.php?s=4&a_d=<?php echo $A_D ?>"><b>Amount</b></a></td>
			<td><a href="pawns-report.php?s=5&a_d=<?php echo $A_D ?>"><b>Pawn Date</b></a></td>
			<td><a href="pawns-report.php?s=6&a_d=<?php echo $A_D ?>"><b>First Name</b></a></td>
			<td><a href="pawns-report.php?s=7&a_d=<?php echo $A_D ?>"><b>Last Name</b></a></td>
		</tr>
	<?php
	if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$date = date($dateText,strtotime($row["pawnDateTime"]));
				
				if ($date == $date2) {
					$pawnDate = date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"]));		    	

		        	echo "<tr><td>" . $row["pawnBillNo"] . "</td><td>" . $row["pawnArticleType"] . "</td><td>" . $row["pawnNetWeight"] . "</td><td>" . "" . "</td><td>" . $pawnDate . "</td><td>" . $row["pawnFirstName"] . "</td><td>" . $row["pawnLastName"]. "</td></tr>";
		        	$pawnAmount += $row["pawnFinalPrice"];
		        	$pawnWeightAmount += $row["pawnNetWeight"];
				}
			}
			echo "<tr><td><br>Pawn Amount  =  " . $pawnAmount .  "</td><td><br>Weight Amount  =  " . $pawnWeightAmount ."</td></tr>";
		}
		else {
			echo "<td>0 results<td></tr>";
		}
	?>
	</table>
</div>
<?php include '../include/layout-bottom-low.php'; ?> 