<?php
session_start();
include 'connection.php';
$sql = "SELECT * FROM users WHERE username='".$_POST["username"]."'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();

	if ($row && crypt($_POST["password"], $row['password']) == $row['password']) {
		//User validated
		if (array_key_exists('remember',$_POST)) {
        	// creating a new session cookie that will expire in 30 days
        	ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
        	session_regenerate_id(TRUE);
    	}
    	// Get in session and send to admin page
	    $_SESSION["usuario"] = $row["name"];
	    $_SESSION["privileges"] = $row["privileges"];
		header ("Location: ../admin.php");
	} else {
	    header("Location: ../index.php?fail=1&auth=0");
	}
} else {
	header("Location: ../index.php?fail=1&auth=0");
}
$conn->close();

?>
