<?php
      session_start();
      if($_SESSION["usuario"]==null){
            header("Location: ../../index.php?fail=1&not-authorized=1");
      }
      $saleBillNo = $_POST['b'];
       
      if(!empty($saleBillNo)) {
            comprobar($saleBillNo);
      }      
       
      function comprobar($b) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = "SELECT MAX( saleBillNo )FROM sales WHERE 1 ";

            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                  //SI ENCUENTRA DATA EN SERVER
                  $row = mysqli_fetch_assoc($result);
                  $numero = $row["MAX( saleBillNo )"];
                  if($numero<3000){
                        echo '3000';
                  }else{
                        echo $numero+1; 
                 }                  
            }else{
                  //CREA EL PRIMER BILL NO
                  echo '3000';
            }
      }    
?>