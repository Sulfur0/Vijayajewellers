<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["delete"])){
		echo '<strong>Success!</strong> The user has been deleted succesfully.';
	}else if(isset($_REQUEST["create"])){
		echo '<strong>Success!</strong> The user has been created succesfully.';
	}else if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The user has been updated succesfully.';
	}
	echo '</div>';
}
?>
<h3>List of Users</h3>
<div class="table-responsive">
  	<table class="table">
		<tr>
			<td><b>Name</b></td><td><b>Username</b></td><td><b>Email</b></td><td><b>Privileges</b></td><td><b>Options</b></td>
		</tr>
		<?php
		include '../backend/connection.php';
		$sql = "SELECT * FROM users";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		        echo "<tr><td>" . $row["name"]. "</td><td>" . $row["username"]. "</td><td>" . $row["email"]. "</td><td>";
		        if($row["privileges"] == '1'){
		        	echo 'Cashier';
		        }else if($row["privileges"] == '2'){
		        	echo 'Admin';
		        }	        
		        echo "</td><td><a href='update-user.php?userid=".$row["userId"]."'><i class='fa fa-pencil fa-fw'></i>Edit</a>  <a href='delete-user.php?userid=".$row["userId"]."'><i class='fa fa-trash fa-fw'></i>Delete</a></td></tr>";
		    }
		} else {
		    echo "0 results";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

