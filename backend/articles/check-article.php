<?php
      session_start();
      if($_SESSION["usuario"]==null){
            header("Location: ../../index.php?fail=1&not-authorized=1");
      }
      $article = $_POST['aC'];
       
      if(!empty($article)) {
            comprobar($article);
      }      
       
      function comprobar($b) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = "SELECT * FROM articles WHERE 1";

            $result = $conn->query($sql);

            $qlen = strlen($b);

            $resultado = "";

            $fail = 1;

            if ($result->num_rows > 0) {                  
                // itera en cada row
                  while($row = $result->fetch_assoc()) {
                        //si la longitud de la pregunta es menor a la logitud del nombre en DB
                        if($qlen <= strlen($row["articleName"])) {
                              
                              //si la pregunta esta dentro del nombre en bd 
                              $pos = strpos($row["articleName"], $b);
                              if ($pos !== false) {
                                    $resultado .= "<div class='col-md-12'><a href='javascript:void(0);' class='setArticle'>".$row["articleName"]."</a></div>";
                                    $fail = 0;                                       
                              } else {
                                    //echo $b." pertenece a ".$row["articleName"]."<br>";
                              }
                              
                        }
                        
                  }
                  echo $resultado;
                  
            }   
            if ($fail == 1){
                  echo "fail";
            }         
      }    
?>