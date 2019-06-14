<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM pawnings WHERE pawnId='".$_GET["pawnId"]."'";	
    //echo $sql;
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();

    $sql2 = "SELECT * FROM pawningextras WHERE pawnId='".$_GET["pawnId"]."'";
    //echo $sql2;
    $result2 = mysqli_query($conn, $sql2);    

		
?>
<h3>Update pawn</h3>
<p>Fill in the fields to update an existing pawn</p>
<form method="POST" action="../backend/pawnings/update-pawning.php">
	<div class="question-group" id="question-group">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Pawn Date (format: Y/m/d hr/min/sec, I.E. 2017-06-30 10:22:56)</label>
                
                <input type="text" class="form-control" id="pawnDateTime" name="pawnDateTime" required="" value="<?php echo $row['pawnDateTime']; ?>"></input>         
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Bill Number</label>
                <input type="number" step="0.01" class="form-control" id="pawnBillNo" name="pawnBillNo" required="" value="<?php echo $row['pawnBillNo']; ?>"></input>              
            </div>  
        
            <div class="form-group col-md-4">
                <label for="">First Name</label>
                <input type="text" class="form-control" id="    pawnFirstName" name="  pawnFirstName" required="" value="<?php echo $row['pawnFirstName']; ?>"></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Last Name</label>
                <input type="text" class="form-control" id="pawnLastName" name="pawnLastName" required="" value="<?php echo $row['pawnLastName']; ?>"></input>            
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Age</label>
                <input type="number" step="0.01" class="form-control" id="pawnAge" name="pawnAge" required="" value="<?php echo $row['pawnAge']; ?>"></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Address</label>
                <input type="text" class="form-control" id="pawnAddress" name="pawnAddress" required="" value="<?php echo $row['pawnAddress']; ?>"></input>            
            </div>

            <div class="form-group col-md-4 col-xs-12">
                <label for="">Area Name</label>
                <select name="pawnAreaName" class="form-control">
                <?php
                    $sql3 = "SELECT * FROM areas";
                    $result3 = $conn->query($sql3);
                      echo "<option value='".$row['pawnAreaName']."'>" . $row['pawnAreaName'] . "</option>";
                    while ($row3 = $result3->fetch_assoc()) {
                        //echo $row3['areaName'];
                        echo "<option value='".$row3['areaName']."'>" . $row3['areaName'] . "</option>";
                    }
                    mysqli_close($conn);       
                ?>
                </select>
            </div>        
            
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">NIC No.</label>
                <input type="text" class="form-control" id="pawnIdcard" name="pawnIdcard" required="" value="<?php echo $row['pawnIdcard']; ?>"></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Type of Article</label>
                <input type="text" class="form-control" id="pawnArticleType" name="pawnArticleType" required="" value="<?php echo $row['pawnArticleType']; ?>"></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Net Weight of Article</label>
                <input type="number" step="0.01" class="form-control" id="pawnNetWeight" name="pawnNetWeight" required="" value="<?php echo $row['pawnNetWeight']; ?>"></input>            
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Gross Weight of Article</label>
                <input type="number" step="0.01" class="form-control" id="pawnGrossWeight" name="pawnGrossWeight" required="" value="<?php echo $row['pawnGrossWeight']; ?>"></input>            
            </div>
            <!--
            <div class="form-group col-md-4">
                <label for="">Initial Amount Being Paid</label>
                <input type="number" step="0.01" class="form-control" id="extraValue" name="extraValue" required="" value="<?php //echo $row['extraValue']; ?>"></input>            
            </div>            
            -->
            <div class="form-group col-md-4">
                <label for="">Name of Authorized Person </label>
                <input type="text" class="form-control" id="pawnAuthorized" name="pawnAuthorized" required="" value="<?php echo $row['pawnAuthorized']; ?>"></input>            
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12"><h3>Owed and paid</h3></div>
            <div class="col-md-8 col-xs-12 table-responsive">                
                <table class="table">
                <tr><td>Concept</td><td>Amount</td><td>Date</td></tr>
                <tr>
                    <td>Initial Owed Amount</td>
                    <td><?php echo $row['pawnAmount']; ?></td>
                    <td><?php echo $row['pawnDateTime']; ?></td>
                </tr>
                <?php 
                if (mysqli_num_rows($result) > 0) {
                    while($row2 = mysqli_fetch_assoc($result2)) {
                ?>
                <tr>
                    <td><?php echo $row2['extraConcept']; ?></td>
                    <td><?php echo $row2['extraValue']; ?></td>
                    <td><?php echo $row2['extraDate']; ?></td>
                </tr>      
                <?php                         
                    }
                }
                ?> 
                 

                </table>
            </div>             

            
        </div>
    </div>
    <input type="hidden" name="pawnId" id="pawnId" value="<?php echo $_GET["pawnId"]; ?>">
	<button class="btn btn-info" id="action">Update</button>
</form>
<?php include '../include/layout-bottom-low.php'; ?>       

