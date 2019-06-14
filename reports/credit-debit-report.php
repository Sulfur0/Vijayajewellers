<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php
include '../backend/connection.php';

if (!$conn)
	die("Connection failed: " . mysqli_connect_error());
	
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND pawnBillNo LIKE '" . $_POST["search"] . "'";
		$like .= " OR extraConcept LIKE '" . $_POST["search"] . "'";
		$like .= " OR extraDate LIKE '" . $_POST["search"] . "'";
		$like .= " OR extraValue LIKE '" . $_POST["search"] . "'";
	}

	$orderby = "pawnBillNo";
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
		$orderby = "extraConcept";

	else if ($sort == 3)
		$orderby = "extraDate";

	else if ($sort == 4)
		$orderby = "extraValue";

	
	

	$sql = "SELECT timezone FROM config";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    date_default_timezone_set($row["timezone"]);

	$pawnAmount = 0;
	$pawnWeightAmount = 0;
	$sql = "SELECT * FROM pawningextras WHERE 1 ".$like." ORDER BY ".$orderby." ".$typeOrder." ";
	$result = $conn->query($sql);

	if (isset($_GET["m"])) {
		echo "<h3>Monthly Credit/Debit History</h3>";
		$date2 = date("Y-m");
		$dateText = "Y-m";
		$A_D .= "&m=1";
	}
	else if (isset($_GET["a"])) {
		echo "<h3>Anual Credit/Debit History</h3>";
		$date2 = date("Y");
		$dateText = "Y";
		$A_D .= "&a=1";
	}

?>
<div class="table-responsive">
	<form action="pawns-report.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
			<div class="question-group" id="question-group">
				<div class="col-md-3">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<div class="col-md-3">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
				</div>				
			</div>
	</form>
	
			
	<br>
  	<table class="table">
		<tr>
			<td><a href="pawns-report.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="pawns-report.php?s=2&a_d=<?php echo $A_D ?>"><b>Date time</b></a></td>
			<td><a href="pawns-report.php?s=3&a_d=<?php echo $A_D ?>"><b>Concept</b></a></td>
			<td><a href="pawns-report.php?s=4&a_d=<?php echo $A_D ?>"><b>Amount</b></a></td>
		</tr>
	<?php
	if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$date = date($dateText,strtotime($row["extraDate"]));
				
				if ($date == $date2) {
					$pawnDate = date("Y-m-d h:i:s a", strtotime($row["extraDate"]));		    	

		        	echo "<tr><td>" . $row["pawnBillNo"] . "</td><td>" . $date . "</td><td>" . $row["extraConcept"] . "</td><td>" . $row["extraValue"] . "</td></tr>";
		        	$pawnAmount += $row["extraValue"];
				}
			}
			echo "<tr><td><br>Pawn Amount  =  " . $pawnAmount .  "</td></tr>";
		}
		else {
			echo "<td>0 results<td></tr>";
		}
	?>
	</table>
</div>
<?php include '../include/layout-bottom-low.php'; ?> 