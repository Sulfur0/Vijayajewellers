<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php
include '../backend/connection.php';
if (!$conn) 
	die("Connection failed: " . mysqli_connect_error());

//SACO EL SALEBILLNO DE LOS BILLS DONDE COINCIDAN LAS FECHAS SUMINISTRADAS POR INPUT DATE
/*
ejemplo de query
SELECT * FROM salebills WHERE MONTH(sbillDate) = 8 AND YEAR(sbillDate) >= 2017 AND YEAR(sbillDate) <= 2017
*/
$parameters = "?";
$condition = "1";
$condition2 = "";

if(isset($_POST["filter-from-year"]) && $_POST["filter-from-year"] != ""){
	$condition .= " AND YEAR(sbillDate) >= ".$_POST["filter-from-year"];
	echo "<input type='hidden' name='filter-from-year' value='".$_POST["filter-from-year"]."'></input>";
	$parameters .= "from-year=".$_POST["filter-from-year"];
}
if(isset($_POST["filter-to-year"]) && $_POST["filter-to-year"] != ""){
	$condition .= " AND YEAR(sbillDate) <= ".$_POST["filter-to-year"];
	echo "<input type='hidden' name='filter-to-year' value='".$_POST["filter-to-year"]."'></input>";
	$parameters .= "&to-year=".$_POST["filter-to-year"];
}
if(isset($_POST["filter-year"]) && $_POST["filter-year"] != ""){
	$condition .= " AND YEAR(sbillDate) = ".$_POST["filter-year"];
	echo "<input type='hidden' name='filter-year' value='".$_POST["filter-year"]."'></input>";
	$parameters .= "year=".$_POST["filter-year"];
}
if(isset($_POST["filter-month"]) && $_POST["filter-month"] != ""){
	$condition .= " AND MONTH(sbillDate) = ".$_POST["filter-month"];
	echo "<input type='hidden' name='filter-month' value='".$_POST["filter-month"]."'></input>";
	$parameters .= "&month=".$_POST["filter-month"];
}
if(isset($_POST["filter-article"]) && $_POST["filter-article"] != ""){
	$condition2 .= " AND saleArticleName = '".$_POST["filter-article"]."'";
	$condition2 .= " OR saleArticleCode = '".$_POST["filter-article"]."'";
	echo "<input type='hidden' name='filter-article' value='".$_POST["filter-article"]."'></input>";
	$parameters .= "&article=".$_POST["filter-article"];
}

$like = "";



	
if (isset($_POST["search"]) && $_POST["search"] != "") {
	$like = "AND saleBillNo LIKE '" . $_POST["search"] . "'";
	$like .= "OR saleArticleName LIKE '" . $_POST["search"] . "'";
	$like .= "OR saleWeight LIKE '" . $_POST["search"] . "'";

	$sql = "SELECT saleBillNo FROM sales WHERE 1 ".$like;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$condition .= " AND saleBillNo LIKE '" . $row["saleBillNo"] . "'";
	$parameters .= "&search=".$_POST["search"];
}


$orderby = "saleId";
$A_D = 0;
$typeOrder = "ASC";
$sort = -1;

if (isset($_GET["s"])) {
	$sort = $_GET["s"];
	if($_GET["a_d"] == 0) {
		$typeOrder = "DESC";
		$A_D = 1;
	}else if($_GET["a_d"] == 1){
		$typeOrder = "ASC";
		$A_D = 0;
	}
}

if($sort == 1)
	$orderby = "saleBillNo";

else if ($sort == 2)
	$orderby = "saleArticleName";

else if ($sort == 3)
	$orderby = "saleArticleName";

else if ($sort == 4)
	$orderby = "saleArticleName";

else if ($sort == 5)
	$orderby = "saleWeight";

else if ($sort == 6)
	$orderby = "saleFinalPrice";

$sql = "SELECT timezone FROM config";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
date_default_timezone_set($row["timezone"]);

$totalSales = 0;
$totalQtySales = 0;

$sql2 = "SELECT saleBillNo,sbillDate FROM salebills WHERE ".$condition;
$result2 = $conn->query($sql2);
?>
<h3>Sale Report</h3>
<div class="table-responsive">
	<form action="sales-report.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
			<div class="question-group" id="question-group">
				<div class="col-md-3">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>		
				
				<div class="pull-right btn-group">
					<a target="_blank" href="sales/sales-report-pdf.php<?php echo $parameters; ?>" class="btn btn-info">Generate PDF</a>
					<a target="_blank" href="sales/sales-report-csv.php<?php echo $parameters; ?>" class="btn btn-info">Generate CSV</a>
				</div>
			</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td>Row</td>
			<td><a href="sales-report.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill No</b></a></td>
			<td><a href="sales-report.php?s=2&a_d=<?php echo $A_D ?>"><b>Date</b></a></td>
			<td><a href="sales-report.php?s=3&a_d=<?php echo $A_D ?>"><b>Article Code</b></a></td>
			<td><a href="sales-report.php?s=4&a_d=<?php echo $A_D ?>"><b>Article Name</b></a></td>
			<td><a href="sales-report.php?s=5&a_d=<?php echo $A_D ?>"><b>Weight</b></a></td>
			<td style='text-align:right;'><a href="sales-report.php?s=6&a_d=<?php echo $A_D ?>"><b>Price</b></a></td>
		</tr>
	<?php
	$contador = 0;
	$saleAmount = 0;
	if ($result2->num_rows > 0) {
		while ($row2 = $result2->fetch_assoc()) {
			$time = strtotime($row2["sbillDate"]);
			$date = date('Y-m-d',$time);
			
			$sql3 = "SELECT * FROM sales WHERE forsale='0' ".$condition2." AND saleBillNo='".$row2["saleBillNo"]."'  ORDER BY ".$orderby." ".$typeOrder."";
			
			$result3 = $conn->query($sql3);			
			if ($result3->num_rows > 0) {
				while ($row3 = $result3->fetch_assoc()) {
					$contador++;

					$price = number_format( $row3["saleFinalPrice"] , 2 , '.' , ',' );

					echo "<tr><td>".$contador."</td><td>" . $row3["saleBillNo"] . "</td><td>" . $date . "</td><td>" . $row3["saleArticleCode"] . "</td><td>" . $row3["saleArticleName"] . "</td><td>" . $row3["saleWeight"] . "g " . $row3["saleWeightMili"] .  "mg</td><td style='text-align:right;'>" . $price . "</td><tr>";
					$saleAmount += $row3["saleFinalPrice"];
				}	
				
			}	
		}
		$price = number_format( $saleAmount , 2 , '.' , ',' );

		echo "<tr class='success'><td></td><td></td><td></td><td></td><td></td><td style='font-size:1.5em'>Total Sales Amount</td><td style='text-align:right;font-size:1.5em'>".$price."</td></tr>";
	
	}	
	?>
	</table>
</div>
<?php include '../include/layout-bottom-low.php'; ?> 