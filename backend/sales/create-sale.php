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

		$sql2 = "SELECT `address` FROM `customers` WHERE `name` = '".$_POST["saleFirstName"]."' AND `lastname` = '".$_POST["saleLastName"]."';";
		$address;
		$result = mysqli_query($conn, $sql2);
		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		        $address = $row["address"];
		    }
		} 
		$totalFinalPrice = 0;
		foreach ($_POST["saleArticleName"] as $key => $getid) {
			$sql3 = "SELECT `saleFinalPrice` FROM `sales` WHERE `saleId` = '".$_POST["saleId"][$key]."';";
			$result = mysqli_query($conn, $sql3);
			if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    $row = mysqli_fetch_assoc($result);
			        $totalFinalPrice+=floatval($row["saleFinalPrice"]);	  
			}
		}
		

		$sql="";		
		$i=0;

		$saleBillNo = $_POST["saleBillNo"]; 
		$saleDetail = $_POST["saleDetail"]; 
		$saleDateTime = $_POST["saleDateTime"]; 
		$saleExchArticle = $_POST["saleExchArticle"]; 
		$saleExchWeight = $_POST["saleExchWeight"]; 
		$saleExchWeightMili = $_POST["saleExchWeightMili"]; 
		$saleExchange = $_POST["saleExchange"]; 
		$saleArea = $_POST["saleArea"]; 

		$sql .= "INSERT INTO saleBills (saleBillNo, sbillFirstName, sbillLastName, sbillDate, sbillExchange,sbillExchArticle,sbillExchWeight,sbillExchWeightMili,sbillFinalPrice)
VALUES (
		'".$saleBillNo."',
		'".$_POST["saleFirstName"]."',
		'".$_POST["saleLastName"]."',
		'".$saleDateTime."',
		'".$saleExchange."',
		'".$saleExchArticle."',
		'".$saleExchWeight."',
		'".$saleExchWeightMili."',
		'".$totalFinalPrice."'
		);";

		foreach ($_POST["saleArticleName"] as $key => $getid) {
			//$saleQty = $_POST["saleQty"][$key];
			//saleQty='".$saleQty."',
			$saleArticleName = $_POST["saleArticleName"][$key];
            $saleArticleCode = $_POST["saleArticleCode"][$key]; 

            $sql .= "UPDATE sales SET             
            saleAddress='".$address."',
            saleBillNo='".$saleBillNo."',
            saleDetail='".$saleDetail."',
            saleArticleName='".$saleArticleName."',
            saleArticleCode='".$saleArticleCode."',
            saleArea='".$saleArea."',
            forsale='0' WHERE saleId='".$_POST["saleId"][$key]."';";          
			
		    $i++;
		    //echo "saleDateTime".$i.": ".$saleDateTime."<br>";

		}	

		//echo '<br>'.$sql.'<br>';
		
		if (mysqli_multi_query($conn, $sql)) {			
		    header("Location: ../../sales/bill-sales.php?success=1&create=1");
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		mysqli_close($conn);

      	exit();

   	

?>