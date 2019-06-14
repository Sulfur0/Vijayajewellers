<?php
   	
   	session_start();
    if($_SESSION["usuario"]==null){
        header("Location: ../../index.php?fail=1&not-authorized=1");
    }
   	include '../connection.php';
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "SELECT articleName FROM inventory WHERE articleName='".$_POST["saleArticleName"]."'";
		$result = mysqli_query($conn, $sql);
		if (!mysqli_num_rows($result) > 0) {
			$sql =  "INSERT INTO inventory (articleName) VALUES('".$_POST["saleArticleName"]."')";
					
			if (!mysqli_query($conn, $sql)) {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		
		$articleName = $_POST["saleArticleName"];
		$articleCode = $_POST["saleArticleCode"];
		$articleWeight = $_POST["saleWeight"];
		$articleWeightMili = $_POST["saleWeightMili"];	

		$sql = "INSERT INTO sales (saleArticleName,saleArticleCode,saleWeight,saleWeightMili,saleLabor,saleLossGold,saleGoldValue,saleFinalPrice,forsale) VALUES(
		'".$articleName."',
		'".$articleCode."',
		'".$articleWeight."',
		'".$articleWeightMili."',
		'".$_POST["saleLabor"]."',
		'".$_POST["saleLossGold"]."',
		'".$_POST["saleGoldValue"]."',
		'".$_POST["saleFinalPrice"]."',
		'2');";
		//echo '<br>'.$sql.'<br>';	
		
		if (mysqli_query($conn, $sql)) {
			
			header("Location: ../../inventory/new-gold.php?success=1&create=1");
		} else {			
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		mysqli_close($conn);

      	exit();  	

?>