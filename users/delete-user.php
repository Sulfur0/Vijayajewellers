<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM users WHERE userId='".$_REQUEST["userid"]."'";
	

	$result = mysqli_query($conn, $sql);

	$row = $result->fetch_assoc();

	echo '<h3>Delete user</h3>';
	echo '<form method="POST" action="../backend/users/delete-user.php">';
		echo '<input type="hidden" name="userId" id="userId" value="'.$_REQUEST["userid"].'">';
		echo '<div class="row">';
			echo '<p>Are you sure you want to delete the user '.$row["name"].'?</p>';
			echo '<p>You cannot undo this action.</p>';
		echo '</div>';
		echo '<button class="btn btn-danger">Delete</button>';
	echo '</form>';

	mysqli_close($conn);
       	
?>
<!-- Aqui va el contenido de la ventana principal -->


<?php include '../include/layout-bottom-low.php'; ?>       

