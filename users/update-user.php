<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM users WHERE userId='".$_REQUEST["userid"]."'";
	

	$result = mysqli_query($conn, $sql);

	$row = $result->fetch_assoc();

	mysqli_close($conn);       	
?>
<h3>Update user</h3>
<p>Fill in the fields to update an existing user</p>
<form method="POST" action="../backend/users/update-user.php">
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Name</label>
			<input type="text" class="form-control" id="name" name="name" value="<?php echo $row["name"]?>" required=""></input>			
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Username</label>
			<input type="text" class="form-control" id="username" name="username" value="<?php echo $row["username"]?>" readonly="readonly"></input>		
		</div>	
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $row["email"]?>" required=""></input>			
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Password</label>
			<input type="password" class="form-control" id="password" name="password" required=""></input>			
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Privileges</label>
			<select class="form-control" id="privileges" name="privileges" required=""  >
				<?php				
				if($row["privileges"] == '1'){
					echo '<option value="1" selected="selected">Cashier</option>';
				}else{
					echo '<option value="1">Cashier</option>';
				}
				if($row["privileges"] == '2'){
					echo '<option value="2" selected="selected">Admin</option>';
				}else{
					echo '<option value="2">Admin</option>';
				}
				?>				  	
			</select>						
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $row["userId"]?>" required=""></input>			
		</div>
	</div>

	<button class="btn btn-info">Update</button>
</form>
<?php include '../include/layout-bottom-low.php'; ?>       
