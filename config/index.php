<?php include '../include/layout-top-low.php'; ?>
<?php
if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The settings have been updated succesfully.';
	}
	echo '</div>';
}

include '../backend/connection.php';
$sql = "SELECT * FROM config";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
    $row = $result->fetch_assoc();
	$conn->close();
}else{
	echo 'WARNING: NO CONFIGURATION DETECTED';
}
?>
<h3>Configuration</h3>
<p>Configure your admin panel and website</p>
<form method="POST" action="../backend/config.php">

	<div class="row">
		<div class="form-group col-md-1">
			<label for="">Timezone</label>	

		</div>	
		<div class="col-md-4">
			<input type="text" class="form-control" id="timezone" name="timezone" required="" value="<?php if(isset($row["timezone"])) echo $row["timezone"]; ?>"></input>
		</div>				
	</div>
	<div class="row">
		<div class="col-md-12">
			<p>Search for your correct timezone in this website and then type it into the field above. <a target="_blank" href="http://php.net/manual/en/timezones.php">Timezone list</a></p>
			<p>Example of correct timezone: America/Caracas</p>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<p>This is the email used for all of the email operations in the website.</p>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-1">
			<label for="email">Website email</label>	

		</div>	
		<div class="col-md-4">
			<input type="email" class="form-control" id="email" name="email" required="" value="<?php if(isset($row["webEmail"])) echo $row["webEmail"]; ?>" autocomplete="off" placeholder="Website email"></input>
		</div>	
		<div class="form-group col-md-1">
			<label for="email">Website email password</label>	

		</div>	
		<div class="col-md-4">
			<input type="password" class="form-control" id="password" name="password" value="" autocomplete="off" placeholder="Website email password"></input>
		</div>			
	</div>
	<!--
	<div class="row">
		<div class="col-md-12">
			<p>This is the information showed in the mails sent to users asking for a password recovery.</p>
		</div>
	</div>
	
	<div class="row">
		<div class="form-group col-md-1">
			<label for="email">Mail Body Beginning</label>	

		</div>	
		<div class="col-md-4">
			<input type="text" class="form-control" id="mailBody" name="mailBody" required="" value="<?php// echo $row["mailBody"]; ?>" placeholder="Beginning of the mail body"></input>
		</div>	
		<div class="form-group col-md-1">
			<label for="email">Mail Body End</label>	

		</div>	
		<div class="col-md-4">
			<input type="text" class="form-control" id="endmailBody" name="endmailBody" required="" value="<?php// echo $row["endmailBody"]; ?>" placeholder="Final part of the mail body"></input>
		</div>			
	</div>

	<div class="row">
		<div class="form-group col-md-1">
			<label for="email">Mail Tittle</label>	

		</div>	
		<div class="col-md-4">
			<input type="text" class="form-control" id="mailTittle" name="mailTittle" required="" value="<?php //echo $row["mailTittle"]; ?>" placeholder="Password recovery (no reply)"></input>
		</div>	
		<div class="form-group col-md-1">
			<label for="email">Mail Author</label>	

		</div>	
		<div class="col-md-4">
			<input type="text" class="form-control" id="mailAuthor" name="mailAuthor" required="" value="<?php //echo $row["mailAuthor"]; ?>" placeholder="Website name"></input>
		</div>			
	</div>
	-->

	<div class="row">
		<div class="form-group col-md-4">
			<button class="btn btn-primary">Save changes</button>
		</div>
	</div>
</form>
<?php include '../include/layout-bottom-low.php'; ?>    