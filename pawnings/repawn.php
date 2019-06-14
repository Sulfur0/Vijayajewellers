<?php include '../include/layout-top-low.php'; ?>
<?php 
    include '../backend/connection.php';
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
                
                
    $sql = "SELECT * FROM pawnings WHERE pawnBillNo='".$_POST["pawnBillNo"]."'";   
    //echo $sql;
    $result = mysqli_query($conn, $sql);
    

?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>Re Pawn</h3>
<form method="POST" action="../backend/pawnings/repawn.php">
	<div>
		<div class="row">
            <p>Choose the pawn to make the repawn</p>
            <div class="col-md-12 table-responsive">                
                <table class="table">
                <tr>
                    <td>Pawn</td>                    
                    <td>Incoming Money or Part Payment</td>
                    <td>Outgoing money or Repawn</td>
                    <td>Amount</td>
                    <td>Date time</td>
                </tr>
                <tr class="question-group" id="question-group">    
                    <td>
                        <select class="form-control" name="pawnIdentifier" id="pawnIdentifier">    <?php
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='".$row['pawnId']."'>".$row['pawnArticleType']." owed:".$row['pawnAmount']+$row['pawnOwed']."</option>";
                            }
                            ?>
                        </select>
                    </td> 
                    <td>Credit <input type="radio" name="type" value="credit" /><br /></td>
                    <td>Debit <input type="radio" name="type" value="debit"  /><br /></td>              
                	<td><input type="number" step="0.01" class="form-control" id="pawnAmount" name="pawnAmount" required="" value=""></input></td>
                    <td>                      
                        <?php
                        $sql = "SELECT timezone FROM config";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        date_default_timezone_set($row["timezone"]);
                        $date = date('Y/m/d h:i:s', time()); 
                        ?>
                        <input type="text" class="form-control" id="pawnDateTime" name="pawnDateTime" required="" value="<?php echo $date; ?>"></input>                       
                    </td>
                </tr>                
                </table>
            </div>
            
            
        </div>
    </div>
    <input type="hidden" name="pawnBillNo" id="pawnBillNo" value="<?php echo $_POST["pawnBillNo"]; ?>">
	<div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
        </div>
    </div>
    <input type="hidden" name="pawnId" id="pawnId" value="<?php echo $row["pawnId"]; ?>">
</form>
<?php include '../include/layout-bottom-low.php'; ?>       


<script src="../js/multi-payments.js?1"></script>  