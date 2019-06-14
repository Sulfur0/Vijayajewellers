<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php
include '../backend/connection.php';

if (!$conn)
	die("Connection failed: " . mysqli_connect_error());
	
	$like = "";
	$parameters = "?";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND pawnBillNo LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnArticleType LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnFirstName LIKE '" . $_POST["search"] . "'";
		$like .= " OR pawnLastName LIKE '" . $_POST["search"] . "'";
	}
	if(isset($_POST["filter-from-year"]) && $_POST["filter-from-year"] != ""){
		$like .= " AND YEAR(pawnDateTime) >= ".$_POST["filter-from-year"];
		echo "<input type='hidden' name='filter-from-year' value='".$_POST["filter-from-year"]."'></input>";
		$parameters .= "from-year=".$_POST["filter-from-year"];
	}
	if(isset($_POST["filter-to-year"]) && $_POST["filter-to-year"] != ""){
		$like .= " AND YEAR(pawnDateTime) <= ".$_POST["filter-to-year"];
		echo "<input type='hidden' name='filter-to-year' value='".$_POST["filter-to-year"]."'></input>";
		$parameters .= "&to-year=".$_POST["filter-to-year"];
	}
	if(isset($_POST["filter-year"]) && $_POST["filter-year"] != ""){
		$like .= " AND YEAR(pawnDateTime) = ".$_POST["filter-year"];		
		echo "<input type='hidden' name='filter-year' value='".$_POST["filter-year"]."'></input>";
		$parameters .= "year=".$_POST["filter-year"];
	}
	if(isset($_POST["filter-month"]) && $_POST["filter-month"] != ""){
		$like .= " AND MONTH(pawnDateTime) = ".$_POST["filter-month"];
		echo "<input type='hidden' name='filter-month' value='".$_POST["filter-month"]."'></input>";
		$parameters .= "&month=".$_POST["filter-month"];
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
		$orderby = "pawnGrossWeight";

	else if ($sort == 5)
		$orderby = "";

	else if ($sort == 6)
		$orderby = "pawnDateTime";

	else if ($sort == 7)
		$orderby = "pawnFirstName";

	else if ($sort == 8)
		$orderby = "pawnLastName";

	$sql = "SELECT timezone FROM config";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    date_default_timezone_set($row["timezone"]);

	$pawnAmount = 0;
	$sql = "SELECT * FROM pawnings WHERE forPawn='1' ".$like." ORDER BY ".$orderby." ".$typeOrder." ";
	//echo $sql;
	$result = $conn->query($sql);

	if (isset($_GET["m"])) {
		$date2 = date("Y-m");
		$dateText = "Y-m";
		$A_D .= "&m=1";
	}
	else if (isset($_GET["a"])) {
		$date2 = date("Y");
		$dateText = "Y";
		$A_D .= "&a=1";
	}

?>
<h3>Pawn Report</h3>
<div class="table-responsive">
	<form action="pawns-report.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
		<div class="question-group" id="question-group">
			<div class="row">
				<div class="col-md-3 col-xs-9">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<div class="col-md-1 col-xs-3">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
				</div>
				<div class="col-md-6 pull-right btn-group">
									
						<a href="credit-debit-report.php??<?php echo $A_D;?>" class="btn btn-primary"><i class="fa fa-search"></i>View Credit and Debit History</a>
					
						<a target="_blank" href="pawnings/pawnings-report-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
					
						<a target="_blank" href="pawnings/pawnings-report-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
					</div>
				</div>
			</div>
		</div>
	</form>
	
			
	<br>
  	<table class="table">
		<tr>
			<td><b>Row</b></td>
			<td><a href="pawns-report.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill Number</b></a></td>
			<td><a href="pawns-report.php?s=2&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="pawns-report.php?s=3&a_d=<?php echo $A_D ?>"><b>Net Weight</b></a></td>
			<td><a href="pawns-report.php?s=4&a_d=<?php echo $A_D ?>"><b>Gross Weight</b></a></td>
			<td style='text-align:right;'><a href="pawns-report.php?s=5&a_d=<?php echo $A_D ?>"><b>Amount</b></a></td>
			<td><a href="pawns-report.php?s=6&a_d=<?php echo $A_D ?>"><b>Pawn Date</b></a></td>
			<td><a href="pawns-report.php?s=7&a_d=<?php echo $A_D ?>"><b>First Name</b></a></td>
			<td><a href="pawns-report.php?s=8&a_d=<?php echo $A_D ?>"><b>Last Name</b></a></td>
		</tr>
	<?php
		$contador = 0;
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$contador++;
				
				$pawnDate = date("Y-m-d", strtotime($row["pawnDateTime"]));		    	
				/*Combinar el peso neto unitario y mili
		        $coef = strlen($row["pawnNetWeightMili"]);
		        $mul = 1;
		        for ($i=0; $i < $coef; $i++) { 
		        	$mul*=10;
		        }
		        $decNetWeight = $row["pawnNetWeightMili"]/$mul;
		        $NetWeight = $row["pawnNetWeight"]+$decNetWeight;
		        */

		        /*Combinar el peso gross unitario y mili
		        $coef = strlen($row["pawnGrossWeightMili"]);
		        $mul = 1;
		        for ($i=0; $i < $coef; $i++) { 
		        	$mul*=10;
		        }
		        $decNetWeight = $row["pawnGrossWeightMili"]/$mul;
		        $GrossWeight = $row["pawnGrossWeight"]+$decNetWeight;
		        */
		        $NetWeight = $row["pawnNetWeight"]."g ".$row["pawnNetWeightMili"]." mg";
		        $GrossWeight = $row["pawnGrossWeight"]."g ".$row["pawnGrossWeightMili"]." mg";

		        $price = number_format( $row["pawnAmount"] , 2 , '.' , ',' );
		        echo "<tr><td>".$contador."</td><td>" . $row["pawnBillNo"] . "</td><td>" . $row["pawnArticleType"] . "</td><td>" . $NetWeight . "</td><td>".$GrossWeight."</td><td style='text-align:right;'>" . $price . "</td><td>" . $pawnDate . "</td><td>" . $row["pawnFirstName"] . "</td><td>" . $row["pawnLastName"]. "</td></tr>";
		        	

		        $pawnAmount += $row["pawnAmount"];
				
			}
			$price = number_format( $pawnAmount , 2 , '.' , ',' );
			echo "<tr class='success'><td></td><td></td><td style='font-size:1.5em'>Total Pawn Amount</td><td></td><td></td><td style='text-align:right;font-size:1.5em'>".$price."</td><td></td><td></td><td></td></tr>";
		}
		else {
			echo "<td>0 results<td></tr>";
		}
	?>
	</table>
</div>
<?php include '../include/layout-bottom-low.php'; ?> 