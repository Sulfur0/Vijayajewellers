<?php
include '../connection.php';
// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT areaName FROM areas WHERE areaName='".$_POST["area"]."'";
$result = mysqli_query($conn, $sql);
if (!mysqli_num_rows($result) > 0) {
	$sql =  "INSERT INTO areas (areaName) VALUES('".$_POST["area"]."')";
			
	if (!mysqli_query($conn, $sql)) {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
 
$sql = sprintf("INSERT INTO customers(name,lastname,email,address,idCard,area,telephone) VALUES('%s','%s','%s','%s','%s','%s','%s');",
    $_POST["name"],
    $_POST["lastname"],
    $_POST["email"],
    $_POST["address"],
    $_POST["idCard"],
    $_POST["area"],
    $_POST["telephone"]                				
	);

if (mysqli_query($conn, $sql)) {
	header("Location: ../../customers/list-customers.php?success=1&create=1");
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

    
   	
?>