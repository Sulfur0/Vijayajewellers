<?php	
   		
      	
	include '../connection.php';
	// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}
        /*
        old school
		$sql = sprintf("INSERT INTO users(name,username,email,privileges,password) VALUES('%s','%s','%s','%s','%s');",
                $_REQUEST["name"],
                $_REQUEST["username"],
                $_REQUEST["email"],
                $_REQUEST["privileges"],
                password_hash($_REQUEST["password"], PASSWORD_DEFAULT)				
				);
		

		if (mysqli_query($conn, $sql)) {
		    header("Location: ../../users/list-users.php?success=1&create=1");
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);

      	exit();
        */


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO users (name,username,email,privileges,password)
        VALUES ('".$_POST["name"]."', '".$_POST["username"]."', '".$_POST["email"]."', '".$_POST["privileges"]."', '".password_hash($_POST["password"], PASSWORD_DEFAULT)."')";
        // use exec() because no results are returned
        $conn->exec($sql);
        header("Location: ../../users/list-users.php?success=1&create=1");
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;   
   	
?>