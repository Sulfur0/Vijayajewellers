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

            $sql = mysqli_query($conn,"SELECT * FROM orders WHERE orderPending='0' AND orderBillNo = '".$b."'");
             
            $contar = mysqli_num_rows($sql);
            


            if($contar == 0){
                  echo "<span style='font-weight:bold;color:red;'>No order bill has been found for this number.</span>";
            }else{
                  echo "<span style='font-weight:bold;color:green;'>order found.</span>";
            }
      }    
?>