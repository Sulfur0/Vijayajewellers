<?php
      $name = $_POST['b'];
      $lastname = $_POST['c'];
       
      if(!empty($name) && !empty($lastname)) {
            comprobar($name,$lastname);
      }      
       
      function comprobar($b,$c) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = "SELECT * FROM customers WHERE name = '".$b."' AND lastname = '".$c."'";
             
            $result = mysqli_query($conn, $sql);
            $row = $result->fetch_assoc();

            echo $row["telephone"].",".$row["address"].",".$row["area"].",".$row["idCard"];

      }    
?>