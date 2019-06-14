<?php  
    include '../connection.php';

    if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

    if (isset($_GET["new"])) {
        $sql = "UPDATE sales SET forsale='2' WHERE saleId='".$_GET["new"]."'";
        mysqli_query($conn, $sql);
        header("Location: ../../inventory/new-gold.php?success=1&remove=1");
    }


    else if (isset($_GET["old"])) {
        $sql = "UPDATE sales SET forsale='2' WHERE saleId='".$_GET["old"]."'";
        mysqli_query($conn, $sql);
        header("Location: ../../inventory/old-gold.php?success=1&remove=1");
    }


        
?>