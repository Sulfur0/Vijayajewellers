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
            $sql = mysqli_query($conn,"SELECT * FROM customers WHERE name = '".$b."' AND lastname = '".$c."'");
             
            $contar = mysqli_num_rows($sql);
            


            if($contar == 0){
                  echo "<span style='font-weight:bold;color:green;'>Customer name available.</span>";
            }else{
                  echo "<span style='font-weight:bold;color:red;'>This customer name already exists.</span>";
            }
      }    
?>