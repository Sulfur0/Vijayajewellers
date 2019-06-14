<?php include '../include/layout-top-low.php'; ?>
<?php 
    include '../backend/connection.php';
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
                
                
    $sql = "SELECT * FROM pawnings WHERE pawnBillNo='".$_POST["pawnBillNo"]."'";   

    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();

    $newEndingDate = date("Y-m-d h:i:s", strtotime(date("Y-m-d h:i:s", strtotime($row["pawnDateTime"])) . " + 1 year + 7 days"));
    $currentDate = date("Y-m-d h:i:s", time());

    if($newEndingDate < $currentDate) {
        $sql = "UPDATE pawnings SET forPawn='2' WHERE pawnBillNo='".$_POST['pawnBillNo']."' LIMIT 1";
        $result = mysqli_query($conn, $sql);
    }

?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>Terminate Pawn</h3>
<form method="POST" action="../backend/pawnings/terminate-pawn.php">
	<div>
		<div class="row">
            <div class="col-md-4 table-responsive">
                <table class="table">
                    <?php if($newEndingDate < $currentDate): ?>
                        <tr><td>The pawn has been closed succesfully</td></tr>
                    <?php else: ?>
                        <tr><td>The pawn still have time to be redeemed</td></tr>
                    <?php endif;?>          
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
