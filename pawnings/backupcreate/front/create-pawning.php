<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>New pawn</h3>
<p>Fill in the fields to create a new pawn</p>
<form method="POST" action="../backend/pawnings/create-pawning.php">
    <div class="question-group" id="question-group">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Pawn Date (format: Y/m/d hr/min/sec, I.E. 2017-06-30 10:22:56)</label>
                
                <?php
                $sql = "SELECT timezone FROM config";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                date_default_timezone_set($row["timezone"]);
                $date = date('Y/m/d h:i:s', time()); 
                ?>
                <input type="text" class="form-control" id="pawnDateTime" name="pawnDateTime[]" required="" value="<?php echo $date; ?>"></input>         
            </div>
        </div>
    	<div class="row">
    		<div class="form-group col-md-4">
    			<label for="">Bill Number</label>
    			<input type="number" step="0.01" class="form-control" id="pawnBillNo" name="pawnBillNo[]" required=""></input>				
    		</div>	
    	
            <div class="form-group col-md-4">
                <label for="">First Name</label>
                <input type="text" class="form-control" id="    pawnFirstName" name="  pawnFirstName[]" required=""></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Last Name</label>
                <input type="text" class="form-control" id="pawnLastName" name="pawnLastName[]" required=""></input>            
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Age</label>
                <input type="number" step="0.01" class="form-control" id="pawnAge" name="pawnAge[]" required="" value="0"></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Area Name</label>
                <input type="text" class="form-control" id="pawnAreaName" name="pawnAreaName[]" required=""></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Address</label>
                <input type="text" class="form-control" id="pawnAddress" name="pawnAddress[]" required=""></input>            
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">ID Card Number</label>
                <input type="text" class="form-control" id="pawnIdcard" name="pawnIdcard[]" required=""></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Type of Article</label>
                <input type="text" class="form-control" id="pawnArticleType" name="pawnArticleType[]" required=""></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Net Weight of Article</label>
                <input type="number" step="0.01" class="form-control" id="pawnNetWeight" name="pawnNetWeight[]" required="" value="0"></input>            
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Gross Weight of Article</label>
                <input type="number" step="0.01" class="form-control" id="pawnGrossWeight" name="pawnGrossWeight[]" required="" value="0"></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Amount Being Paid</label>
                <input type="number" step="0.01" class="form-control" id="extraValue" name="extraValue[]" required="" value="0"></input>            
            </div>            
        
            <div class="form-group col-md-4">
                <label for="">Name of Authorized Person </label>
                <input type="text" class="form-control" id="pawnAuthorized" name="pawnAuthorized[]" required=""></input>            
            </div>
        </div>
    </div>	
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
            <button class="btn btn-info" id="oneMore">Create one more pawning</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?> 

<script src="../js/multi-pawnings.js?1"></script>  


