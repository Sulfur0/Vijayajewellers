<?php
      session_start();
      if($_SESSION["usuario"]==null){
            header("Location: ../../index.php?fail=1&not-authorized=1");
      }
      $articleCode = $_POST['b'];
      $oldArticleCode = $_POST['c'];
       
      if(!empty($articleCode) && !empty($oldArticleCode)) {
            comprobar($articleCode,$oldArticleCode);
      }      
       
      function comprobar($b,$c) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = "SELECT saleArticleCode FROM sales WHERE saleArticleCode = '".$b."' AND NOT saleArticleCode = '".$c."' ";

            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                  //SI ENCUENTRA DATA EN SERVER
                  echo "<span style='font-weight:bold;color:red;'>This article code has been already taken, please type other.</span>";                 
            }else{
                  //SI NO
                  echo "<span style='font-weight:bold;color:green;'>Article Code available.</span>";
            }            
      }    
?>