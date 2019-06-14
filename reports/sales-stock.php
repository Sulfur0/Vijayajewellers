<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';
	$parameters = "?";
	$like = "";
	$like2 = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like .= "AND saleArticleName LIKE '" . $_POST["search"] . "'";
		$like .= "OR saleArticleCode LIKE '" . $_POST["search"] . "'";
		$like2 .= "AND pawnArticleType LIKE '" . $_POST["search"] . "'";
		$parameters .= "&search=".$_POST["search"];
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

if ($sort == 1){
	$orderby = "saleArticleCode";
	$orderby2 = "";

}else if ($sort == 2){
	$orderby = "saleArticleName";
	$orderby2 = "pawnArticleType";

}else if ($sort == 3){
	$orderby = "saleWeight";
	$orderby2 = "pawnNetWeight";
}

$sql = "SELECT * FROM sales WHERE forsale!='0'  ".$like." ORDER BY ".$orderby." ".$typeOrder."";
$sql2 = "SELECT * FROM pawnings WHERE forPawn='2' ".$like2." ORDER BY ".$orderby2." ".$typeOrder."";

?>
<h3>Gold in Stock</h3>
<div class="table-responsive">
	<form action="sales-stock.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
		<div class="question-group" id="question-group">
			<div class="col-md-3">
				<input type="text" class="form-control" name="search" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>		
			
			<div class="pull-right btn-group">
				<a target="_blank" href="sales-stock/sales-stock-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
				<a target="_blank" href="sales-stock/sales-stock-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
			</div>
		</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td><b>Row</b></td>
			<td><a href="sales-stock.php?s=1&a_d=<?php echo $A_D ?>"><b>Code</b></a></td>
			<td><a href="sales-stock.php?s=2&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="sales-stock.php?s=3&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
			<td><b>Old/New</b></td>
		</tr>
		<?php
		$contador = 0;
		$result = $conn->query($sql);	
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {

		    	$contador++;
			    echo "<tr><td>".$contador."</td><td>" . $row["saleArticleCode"] . "</td><td>" . $row["saleArticleName"] . "</td><td>" . $row["saleWeight"] . "g ". $row["saleWeightMili"] ."mg</td>";
			    if($row["goldStatus"]=='1')
			    echo "<td>New</td></tr>";
				else if($row["goldStatus"]=='0')
			    echo "<td>Old</td></tr>";
			   
		    }
		} 

		$result2 = $conn->query($sql2);
		if ($result2->num_rows > 0) {
			while ($row = $result2->fetch_assoc()) {

				$contador++;
				$articleDate = date("Y-m-d h:i:s a", strtotime($row["pawnDateTime"]) );    	
			    echo "<tr><td>".$contador."</td><td></td><td>" . $row["pawnArticleType"]. "</td><td>" . $row["pawnNetWeight"] . "g ". $row["pawnNetWeightMili"] ."mg</td><td>Old</td></tr>";
			    
			}
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     