<?php
      $user = $_POST['b'];
       
      if(!empty($user)) {
            comprobar($user);
      }
       
      function comprobar($b) {
            include 'connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = mysqli_query($conn,"SELECT * FROM users WHERE username = '".$b."'");
             
            $contar = mysqli_num_rows($sql);
             
            if($contar == 0){
                  echo "<span style='font-weight:bold;color:green;'>Username available.</span>";
            }else{
                  echo "<span style='font-weight:bold;color:red;'>This username already exists.</span>";
            }
      }    
?>