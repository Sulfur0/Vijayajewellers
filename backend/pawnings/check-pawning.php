<?php
      session_start();
      if($_SESSION["usuario"]==null){
            header("Location: ../../index.php?fail=1&not-authorized=1");
      }
      $bill = $_POST['b'];      
       
      if(!empty($bill)) {
            comprobar($bill);
      }      
       
      function comprobar($b) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = mysqli_query($conn,"SELECT * FROM pawnings WHERE pawnBillNo = '".$b."'");
             
            $contar = mysqli_num_rows($sql);
            


            if($contar == 0){
                  echo "<span style='font-weight:bold;color:red;'>No pawning bill has been found for this number.</span>";
            }else{
                  echo "<span style='font-weight:bold;color:green;'>Pawn found.</span>";
            }
      }    
?>