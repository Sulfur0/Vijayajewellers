<?php include '../include/layout-top-low.php'; ?>

<!-- Aqui va el contenido de la ventana principal -->
<h3>Close Pawn</h3>
<form method="POST" action="../backend/pawnings/redeem.php">
	<div>
		<div class="row">
            <div class="col-md-4 table-responsive">  
                <p>Enter final ammount payed by customer with interests</p>              
                <table class="table">                
                <tr><td>Enter Amount</td></tr>
                <tr class="question-group" id="question-group">  
                    <td><input type="number" step="0.01" class="form-control" id="extraValue" name="extraValue[]" required="" value=""></input></td>
                </tr>                
                </table>
            </div>            
            
        </div>
    </div>
    
	<div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Close Pawn</button>            
        </div>
    </div>
    <input type="hidden" name="pawnBillNo" id="pawnBillNo" value="<?php echo $_POST["pawnBillNo"]; ?>">
</form>

<?php include '../include/layout-bottom-low.php'; ?>
