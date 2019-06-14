<?php
      session_start();
      if($_SESSION["usuario"]==null){
            header("Location: ../../index.php?fail=1&not-authorized=1");
      }
      $saleArticleCode = $_POST['b'];
       
      if(!empty($saleArticleCode)) {
            comprobar($saleArticleCode);
      }      
       
      function comprobar($b) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = "SELECT * FROM sales WHERE saleArticleCode = '".$b."'";

            $result = $conn->query($sql);
            
            if($result->num_rows > 0){
                  echo "taken";
            }else{
                  echo "free";
            }
            
      }    
?>