<?php include '../include/layout-top-low.php'; ?>
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM customers WHERE customerId='".$_REQUEST["customerId"]."'";	

	$result = mysqli_query($conn, $sql);

	$row = $result->fetch_assoc();

	echo '<h3>Delete customer</h3>';
	echo '<form method="POST" action="../backend/customers/delete-customer.php">';
		echo '<input type="hidden" name="customerId" id="customerId" value="'.$_REQUEST["customerId"].'">';
		echo '<div class="row">';
			echo '<p>Are you sure you want to delete the customer '.$row["name"].' '.$row["lastname"].'?</p>';
			echo '<p>You cannot undo this action.</p>';
		echo '</div>';
		echo '<button class="btn btn-danger">Delete</button>';
	echo '</form>';

	mysqli_close($conn);
       	
?>
<!-- Aqui va el contenido de la ventana principal -->


<?php include '../include/layout-bottom-low.php'; ?>       

