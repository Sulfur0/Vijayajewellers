<?php
	session_start();
	if($_SESSION["usuario"]==null){
	    header("Location: ../index.php?fail=1&not-authorized=1");
	}
   	include 'connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$webEmail = $_REQUEST["email"];	
	$timezone = $_REQUEST["timezone"];
	if(isset($_REQUEST["password"]) && $_REQUEST["password"]!=""){
		$Password = $_REQUEST["password"];
		$sql = "UPDATE config SET webEmail='".$webEmail."', Password='".$Password."', timezone='".$timezone."' WHERE configId='1'";
	}else{
		$sql = "UPDATE config SET webEmail='".$webEmail."', timezone='".$timezone."' WHERE configId='1'";
	}
	/*
	$mailBody = $_REQUEST["mailBody"];
	$endmailBody = $_REQUEST["endmailBody"];
	$mailTittle = $_REQUEST["mailTittle"];
	$mailAuthor = $_REQUEST["mailAuthor"];
	*/

	
	

	if (mysqli_query($conn, $sql)) {
	    header("Location: ../config/index.php?success=1&update=1");
	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	}

	mysqli_close($conn);

    exit();   	
?>