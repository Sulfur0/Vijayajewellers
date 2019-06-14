<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["delete"])){
		echo '<strong>Success!</strong> The sale has been deleted succesfully.';
	}else if(isset($_REQUEST["create"])){
		echo '<strong>Success!</strong> The sale has been created succesfully.';
	}else if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The sale has been updated succesfully.';
	}
	echo '</div>';
}

$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "") {
		$like = "AND saleBillNo LIKE '" . $_POST["search"] . "'";
		$like .= " OR sbillFirstName LIKE '" . $_POST["search"] . "'";
		$like .= " OR sbillLastName LIKE '" . $_POST["search"] . "'";
	}

$orderby = "sbillId";
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
	$orderby = "saleBillNo";

else if ($sort == 2)
	$orderby = "sbillFirstName";

else if ($sort == 3)
	$orderby = "sbillLastName";

else if ($sort == 4)
	$orderby = "sbillFinalPrice";

else if ($sort == 5)
	$orderby = "sbillDate";

?>
<h3>List of purchased sales and bills</h3>
<div class="table-responsive">
	<form action="bill-sales.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
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
			<td><a href="bill-sales.php?s=1&a_d=<?php echo $A_D ?>"><b>Bill No.</b></a></td>
			<td><a href="bill-sales.php?s=2&a_d=<?php echo $A_D ?>"><b>Cust. First Name</b></a></td>
			<td><a href="bill-sales.php?s=3&a_d=<?php echo $A_D ?>"><b>Last Name</b></a></td>
			<td><a href="bill-sales.php?s=4&a_d=<?php echo $A_D ?>"><b>Final Price</b></a></td>
			<td><a href="bill-sales.php?s=5&a_d=<?php echo $A_D ?>"><b>Bill Date</b></a></td>
			<td><a href="bill-sales.php?s=6&a_d=<?php echo $A_D ?>"><b>Exchange</b></a></td>
			<td><b>Options</b></td>
		</tr>
		<?php
		include '../backend/connection.php';
		$sql = "SELECT * FROM saleBills WHERE sbillActive = '1' ".$like." ORDER BY ".$orderby." ".$typeOrder."";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "<tr>
		        <td>" . $row["saleBillNo"]. "</td>
		        <td>" . $row["sbillFirstName"]. "</td>
		        <td>" . $row["sbillLastName"]. "</td>
		        <td>" . $row["sbillFinalPrice"]. "</td>
		        <td>" . $row["sbillDate"]. "</td>";	
		        if(isset($row["sbillExchange"])&&$row["sbillExchange"]!=""){
		        	echo "<td>Yes</td>";
		        }else{
		        	echo "<td>No</td>";
		        }        	        
		        echo "<td><a href='view-bill.php?billno=".$row["saleBillNo"]."'><i class='fa fa-cart-plus fa-fw'></i>View Bill</a>  <a href='update-sale.php?billno=".$row["saleBillNo"]."'><i class='fa fa-pencil fa-fw'></i>Edit</a></td></tr>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

