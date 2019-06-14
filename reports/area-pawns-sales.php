<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';
	if (!$conn) 
		die("Connection failed: " . mysqli_connect_error());
	
if (isset($_REQUEST["success"])) {
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if (isset($_REQUEST["add"]))
		echo '<strong>Success!</strong> The article has been added to inventory succesfully.';
	
	else if (isset($_REQUEST["create"]))
		echo '<strong>Success!</strong> The article has been added to sales succesfully.';		
	
	else if (isset($_REQUEST["remove"]))
		echo '<strong>Success!</strong> The article has been removed from sales succesfully.';
	
	echo '</div>';
}

$areaName = "";
$parameters = "?";
if (isset($_POST["areaName"])) {
	$areaName = $_POST["areaName"];
	$parameters .= "&search=".$_POST["areaName"];
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

$sql = "SELECT * FROM sales WHERE saleArea='".$areaName."' ORDER BY ".$orderby." ".$typeOrder."";


?>

<h3>Area Wise Sales / Pawns</h3>
<div class="table-responsive">
	<form action="area-pawns-sales.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">		
			<div class="question-group col-md-4" id="question-group">
				<div class="col-md-10">
					<select name="areaName" class="form-control">
					<?php
						$sql3 = mysqli_query($conn, "SELECT * FROM areas");
						while ($row = $sql3->fetch_assoc()) {
							echo "<option value='".$row['areaName']."'>" . $row['areaName'] . "</option>";
						}
					?>
					</select>					
				</div>

				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
			</div>
			<div class="pull-right btn-group">
				<a target="_blank" href="area-pawns-sales/area-pawns-sales-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
				<a target="_blank" href="area-pawns-sales/area-pawns-sales-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
			</div>
	</form>
	<br>
	<br>
  	<table class="table">
		<tr>
			<td>Row</td>
			<td><a href="area-pawns-sales.php?s=1&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="area-pawns-sales.php?s=2&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
			<td><a href="area-pawns-sales.php?s=3&a_d=<?php echo $A_D ?>"><b>Purchase Date</b></a></td>
			<td><b>Type</b></td>
		</tr>
		<?php		
		$result = $conn->query($sql);	
		$contador=0;
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		    	$sql2 = "SELECT * FROM salebills WHERE saleBillNo='".$row["saleBillNo"]."'";
				$result2 = $conn->query($sql2);
				$row2 = $result2->fetch_assoc();				

		    	$articleDate = date("Y-m-d h:i:s a", strtotime($row2["sbillDate"]) );    	
		    	$contador++;		    	
		        echo "<tr><td>".$contador."</td><td>" . $row["saleArticleName"]. "</td><td>" . $row["saleWeight"] . "</td><td>" . $articleDate . "</td><td>" . "Sale" . "</td></tr>";
		    }
		}
		$sql2 = "SELECT * FROM pawnings WHERE pawnAreaName='".$areaName."' ORDER BY ".$orderby2." ".$typeOrder."";
		$result2 = $conn->query($sql2);

		if ($result2->num_rows > 0) {
			while ($row = $result2->fetch_assoc()) {
				$articleDate = date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"]) );    	
				$contador++;
			    echo "<tr><td>".$contador."</td><td>" . $row["pawnArticleType"]. "</td><td>" . $row["pawnNetWeight"] . "</td><td>" . $articleDate . "</td><td>" . "Pawn" . "</td></tr>";
			    
			}
		}

		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

