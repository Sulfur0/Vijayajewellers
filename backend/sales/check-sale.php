<?php
      session_start();
      if($_SESSION["usuario"]==null){
            header("Location: ../../index.php?fail=1&not-authorized=1");
      }
      $articleCode = $_POST['aC'];
       
      if(!empty($articleCode)) {
            comprobar($articleCode);
      }      
       
      function comprobar($b) {
            include '../connection.php';
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }           
            $sql = "SELECT * FROM sales WHERE saleArticleCode = '".$b."'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                  while($row = $result->fetch_assoc()) {
                        
                        echo '<tr>        
                        <td>'.$row["saleArticleCode"].'</td>
                        <td>'.$row["saleArticleName"].'</td>
                        <td>'.$row["saleWeight"].'</td>
                        <td>'.$row["saleWeightMili"].'</td>
                        <td>'.$row["saleFinalPrice"].'</td>
                        <td><a href="../inventory/edit-to-inventory.php?saleId='.$row["saleId"].'" target="_blank"><i class="fa fa-pencil"><b>Edit</b></i></a> <a href="#" class="deleteArticle"><i class="fa fa-close"><b>Delete</b></i></a></td>  
                        <input type="hidden" name="saleArticleCode[]" required="" value="'.$row["saleArticleCode"].'"></input>
                        <input type="hidden" name="saleArticleName[]" required="" value="'.$row["saleArticleName"].'"></input>
                        <input type="hidden" name="saleId[]" required="" value="'.$row["saleId"].'"></input>                     
                        </tr>';
                        

                  }
                  
            }else{
                  echo "fail"; 
            }            
      }    
?>