<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
	include '../backend/connection.php';
	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != ""){
		$like = "WHERE name LIKE '" . $_POST["search"] . "'";
		$like .= "OR lastname LIKE '" . $_POST["search"] . "'";
		$like .= "OR idCard LIKE '" . $_POST["search"] . "'";
		$like .= "OR area LIKE '" . $_POST["search"] . "'";
	}
	
if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["delete"])){
		echo '<strong>Success!</strong> The customer has been deleted succesfully.';
	}else if(isset($_REQUEST["create"])){
		echo '<strong>Success!</strong> The customer has been created succesfully.';
	}else if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The customer has been updated succesfully.';
	}
	echo '</div>';
}

$orderby = "customerId";
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
	$orderby = "name";

else if ($sort == 2)
	$orderby = "lastname";

else if ($sort == 3)
	$orderby = "idCard";

else if ($sort == 3)
	$orderby = "area";

?>

<h3>List of customers</h3>
<div class="table-responsive">
	<form action="list-customers.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
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
			<td><a href="list-customers.php?s=1&a_d=<?php echo $A_D ?>"><b>Name</b></a></td>
			<td><a href="list-customers.php?s=2&a_d=<?php echo $A_D ?>"><b>Last name</b></a></td>
			<td><a href="list-customers.php?s=3&a_d=<?php echo $A_D ?>"><b>NIC No.</b></a></td>
			<td><a href="list-customers.php?s=4&a_d=<?php echo $A_D ?>"><b>Area</b></a></td>
			<td><b>Options</b></td>
		</tr>
		<?php
		
		$sql = "SELECT * FROM customers ".$like." ORDER BY ".$orderby." ".$typeOrder." ";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "<tr><td>" . $row["name"]. "</td><td>" . $row["lastname"]. "</td><td>" . $row["idCard"]. "</td><td>" . $row["area"]. "</td>";		        	        
		        echo "<td><a href='update-customer.php?customerId=".$row["customerId"]."'><i class='fa fa-pencil fa-fw'></i>Edit</a>  <a href='delete-customer.php?customerId=".$row["customerId"]."'><i class='fa fa-trash fa-fw'></i>Delete</a></td></tr>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

