<?php include '../include/layout-top-low.php'; ?>
<?php 
    include '../backend/connection.php';
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
                
                
    $sql = "SELECT pawnId FROM pawnings WHERE pawnBillNo='".$_POST["pawnBillNo"]."'";   
    //echo $sql;
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();

?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>Close Pawn</h3>
<form method="POST" action="../backend/pawnings/redeem.php">
	<div>
		<div class="row">
            <div class="col-md-4 table-responsive">                
                <table class="table">
                <tr><td>Enter final ammount payed by customer with interests</td></tr>
                <tr class="question-group" id="question-group">    
                    <td><input type="number" step="0.01" class="form-control" id="extraValue" name="extraValue[]" required="" value=""></input></td>
                </tr>                
                </table>
            </div>            
            
        </div>
    </div>
    
	<div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>            
        </div>
    </div>
    <input type="hidden" name="pawnId" id="pawnId" value="<?php echo $row["pawnId"]; ?>">
</form>
<?php include '../include/layout-bottom-low.php'; ?>
<script>
    window.confirm()
</script>
