<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php include '../backend/connection.php'; ?>
<?php
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}           
$sql = "SELECT * FROM sales WHERE forsale='1' AND saleId='".$_GET['saleId']."'";

$result = $conn->query($sql); 
$row = $result->fetch_assoc();           

?>
<h3>Edit article</h3>

<form method="POST" action="../backend/inventory/edit-to-inventory.php">
    <div class="question-group" id="question-group">
        <div class="row">
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Article Name</label>
                <input type="text" class="form-control" id="saleArticleName" name="saleArticleName" required="" value="<?php echo $row["saleArticleName"]; ?>" readonly=""> 
            </div>
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Article Code</label>
                <input type="text" class="form-control" id="saleArticleCode" name="saleArticleCode" required="" value="<?php echo $row["saleArticleCode"]; ?>" readonly=""> 
            </div>
            <div class="form-group col-md-4" id="resultado"></div>
            
        </div>
        <div class="row">
            
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Weight (gram)</label>
                <input type="number" step="0.01" class="form-control" id="saleWeight" name="saleWeight" required="" value="<?php echo $row["saleWeight"]; ?>" readonly=""> 
            </div>

            <div class="form-group col-md-4 col-xs-12">
                <label for="">Weight (milligram)</label>
                <input type="number" step="0.01" class="form-control" id="saleWeightMili" name="saleWeightMili" required="" value="<?php echo $row["saleWeightMili"]; ?>" readonly=""> 
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3 col-xs-12">
                <label for="">Labor</label>
                <input type="number" step="0.01" class="form-control" id="saleLabor" name="saleLabor" required="" value="<?php echo $row["saleLabor"]; ?>"> 
            </div>
            <div class="form-group col-md-3 col-xs-12">
                <label for="">Loss Gold</label>
                <input type="number" step="0.01" class="form-control" id="saleLossGold" name="saleLossGold" required="" value="<?php echo $row["saleLossGold"]; ?>"> 
            </div>
            <div class="form-group col-md-3 col-xs-12">
                <label for="">Gold Value</label>
                <input type="number" step="0.01" class="form-control" id="saleGoldValue" name="saleGoldValue" required="" value="<?php echo $row["saleGoldValue"]; ?>"> 
            </div>
            <div class="form-group col-md-3 col-xs-12">
                <label for="">Final Price</label>
                <input type="number" step="0.01" class="form-control" id="saleFinalPrice" name="saleFinalPrice" required="" readonly="" value="<?php echo $row["saleFinalPrice"]; ?>"> 
            </div>
        </div>
        <input type="hidden" name="saleId" value="<?php echo $row["saleId"]; ?>">
    </div>	
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?> 
<script type="text/javascript">
    
    /*-------------- SECCION DE CALCULO DEL PRECIO FINAL --------------*/
                        
    function calculateFinalPrice(){                            
        
        labor = parseFloat($("#saleLabor").val(), 10); 
        lossGold = parseFloat($("#saleLossGold").val(), 10); 
        goldValue = parseFloat($("#saleGoldValue").val(), 10); 
        finalPrice = labor+lossGold+goldValue*1;
        $("#saleFinalPrice").val(finalPrice);
        parseInt($('#a').val(), 10);

    } 
    calculateFinalPrice();
    $("#saleLabor, #saleLossGold, #saleGoldValue").change(function(){
        calculateFinalPrice();
    });
    
</script>

