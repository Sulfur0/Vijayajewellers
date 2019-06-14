<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';
	$parameters = "?";
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != ""){
		$like .= "AND pawnArticleType LIKE '" . $_POST["search"] . "'";
		$like .= "OR pawnBillNo LIKE '" . $_POST["search"] . "'";
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
	$orderby = "";

else if ($sort == 2)
	$orderby = "pawnDateTime";

else if ($sort == 3)
	$orderby = "pawnBillNo";

else if ($sort == 4)
	$orderby = "pawnArticleType";

else if ($sort == 5)
	$orderby = "pawnNetWeight";

$sql = "SELECT * FROM pawnings WHERE forPawn!='0' ".$like." ORDER BY ".$orderby." ".$typeOrder."";

?>
<h3>Pawning Gold in Stock</h3>
<div class="table-responsive">	
	<form action="pawn-stock.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
		<div class="question-group" id="question-group">
			<div class="col-md-3">
				<input type="text" class="form-control" name="search" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>		
			
			<div class="pull-right btn-group">
				<a target="_blank" href="pawn-stock/pawn-stock-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
				<a target="_blank" href="pawn-stock/pawn-stock-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
			</div>
		</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td><b>Row</b></td>
			<td><a href="pawn-stock.php?s=2&a_d=<?php echo $A_D ?>"><b>Pawning Date</b></a></td>
			<td><a href="pawn-stock.php?s=3&a_d=<?php echo $A_D ?>"><b>Bill No.</b></a></td>
			<td><a href="pawn-stock.php?s=4&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="pawn-stock.php?s=5&a_d=<?php echo $A_D ?>"><b>Net Weight</b></a></td>
		</tr>
		<?php
		
		$result = $conn->query($sql);	
		$contador = 0;
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    	$contador++;

		    	$articleDate = date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"]) );    	

			    echo "<tr><td>".$contador."</td><td>".$row["pawnDateTime"]."</td><td>".$row["pawnBillNo"]."</td><td>" . $row["pawnArticleType"]. "</td><td>" . $row["pawnNetWeight"] ."g ". $row["pawnNetWeightMili"] . "mg" . "</td></tr>";
		    }
		} 
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

