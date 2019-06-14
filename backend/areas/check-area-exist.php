<?php
      session_start();
      if($_SESSION["usuario"]==null){
            header("Location: ../../index.php?fail=1&not-authorized=1");
      }
      $area = $_POST['b'];
       
      if(!empty($area)) {
            comprobar($area);
      }      
       
      function comprobar($b) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = "SELECT * FROM areas WHERE areaName = '".$b."'";

            $result = $conn->query($sql);

            $qlen = strlen($b);

            $resultado = "";


            if ($result->num_rows > 0) {                  
                  //si consigue el area    
                  echo "<span style='font-weight:bold;color:red;'>This area already exists.</span>";              
            }else{
                  //si no consigue el area
                  echo "<span style='font-weight:bold;color:red;'>Area available.</span>";
            }          
      }    
?>