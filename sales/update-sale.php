<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	/*CONSULTAS DE saleBills*/
    $sql = "SELECT * FROM saleBills WHERE saleBillNo='".$_GET["billno"]."'";
    
    $result = mysqli_query($conn, $sql);

    $row = $result->fetch_assoc();


    /*CONSULTAS DE sales*/
    $sql2 = "SELECT * FROM sales WHERE saleBillNo='".$_GET["billno"]."'";
	
	$result2 = mysqli_query($conn, $sql2);
    

	/*CONSULTA DE customerId para el edit*/
    $sql3 = "SELECT customerId FROM customers WHERE name='".$row["sbillFirstName"]."' AND lastname='".$row["sbillLastName"]."'";
    
    $result3 = mysqli_query($conn, $sql3);

    $row3 = $result3->fetch_assoc();

	mysqli_close($conn);       	
?>
<h3>Update sale</h3>
<p>Fill in the fields to update an existing sale</p>
<form method="POST" action="../backend/sales/update-sale.php">
	<div class="row">
		<div class="form-group col-md-4 col-xs-12">
			<label for="">Bill No.</label>
			<input type="text" class="form-control" id="saleBillNo" name="saleBillNo" required="" value="<?php echo $row['saleBillNo']; ?>" readonly=""></input>				
		</div>
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Bill Date</label>
            <input type="text" class="form-control" id="sbillDate" name="sbillDate" required="" value="<?php echo $row['sbillDate']; ?>"></input>                
        </div>		
	</div>    
    <div class="row">
        <div class="form-group col-md-4 col-xs-12">
            <label for="">First Name</label>
            <input type="text" class="form-control" id="sbillFirstName" name="sbillFirstName" required="" value="<?php echo $row['sbillFirstName']; ?>"></input>            
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Last Name</label>
            <input type="text" class="form-control" id="sbillLastName" name="sbillLastName" required="" value="<?php echo $row['sbillLastName']; ?>"></input>            
        </div>
        <div id="resultado" class="col-md-4 col-xs-12"></div> 
    </div>  
    <hr>
    <?php
    if ($result2->num_rows > 0) {

        while($row2 = $result2->fetch_assoc()) {
        ?>
    <div class="row">
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Article Name</label>
            <input type="text" class="form-control" id="saleArticleName" name="saleArticleName[]" required="" value="<?php echo $row2['saleArticleName']; ?>"></input>            
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Article Code</label>
            <input type="text" class="form-control saleArticleCode" id="saleArticleCode" name="saleArticleCode[]" required="" value="<?php echo $row2['saleArticleCode']; ?>"></input>
            <input type="hidden" class="oldSaleArticleCode" id="oldSaleArticleCode" name="oldSaleArticleCode[]" value="<?php echo $row2['saleArticleCode']; ?>"></input>           
        </div>
        <div class="col-md-4 col-xs-12 articleCodeExist"></div> 
    </div>     
    <div class="row">
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Article Weight (grams)</label>
            <input type="number" step="0.0001" class="form-control" id="saleWeight" name="saleWeight[]" required="" value="<?php echo $row2['saleWeight']; ?>"></input>            
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Article Weight (milligrams)</label>
            <input type="number" step="0.0001" class="form-control" id="saleWeightMili" name="saleWeightMili[]" required="" value="<?php echo $row2['saleWeightMili']; ?>"></input>            
        </div>
    </div> 
    <div class="calculations">
        <div class="row">
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Labor</label>
                <input type="number" step="0.0001" class="form-control saleLabor" id="saleLabor" name="saleLabor[]" required="" value="<?php echo $row2['saleLabor']; ?>"></input>            
            </div>
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Loss of Gold</label>
                <input type="number" step="0.0001" class="form-control saleLossGold" id="saleLossGold" name="saleLossGold[]" required="" value="<?php echo $row2['saleLossGold']; ?>"></input>            
            </div>
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Gold Value</label>
                <input type="number" step="0.0001" class="form-control saleGoldValue" id="saleGoldValue" name="saleGoldValue[]" required="" value="<?php echo $row2['saleGoldValue']; ?>"></input>            
            </div>
        </div> 
        <div class="row">
            <div class="form-group col-md-4 col-xs-12 pull-right">
                <label for="">Article Final Price</label>
                <input type="number" step="0.0001" class="form-control saleFinalPrice" id="saleFinalPrice" name="saleFinalPrice[]" required="" value="<?php echo $row2['saleFinalPrice']; ?>" readonly=""></input>            
            </div>
        </div>        
    </div>
    <br>
    <hr>
    <input type="hidden" name="saleId[]" id="saleId" value="<?php echo $row2['saleId']; ?>">

        <?php
        }

    }
    if(isset($row['sbillExchArticle']) && $row['sbillExchArticle']!=""){
    ?>
    <h3>This sale was an exchange</h3><p>To make this sale not an exchange leave Exchanged Article field blank</p>
    <div class="row">
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Exchanged Article</label>
            <input type="text" class="form-control sbillExchArticle" id="sbillExchArticle" name="sbillExchArticle" value="<?php echo $row['sbillExchArticle']; ?>"></input>            
        </div>
        <div class="form-group col-md-4 col-xs-12">
            <label for="">Exchanged Value</label>
            <input type="number" step="0.0001" class="form-control sbillExchange" id="sbillExchange" name="sbillExchange" value="<?php echo $row['sbillExchange']; ?>"></input>            
        </div>
        <div class="form-group col-md-2 col-xs-12">
            <label for="">Weight (grams)</label>
            <input type="number" step="0.0001" class="form-control sbillExchWeight" id="sbillExchWeight" name="sbillExchWeight" value="<?php echo $row['sbillExchWeight']; ?>"></input>            
        </div>
        <div class="form-group col-md-2 col-xs-12">
            <label for="">Weight (milligrams)</label>
            <input type="number" step="0.0001" class="form-control sbillExchWeightMili" id="sbillExchWeightMili" name="sbillExchWeightMili" value="<?php echo $row['sbillExchWeightMili']; ?>"></input>            
        </div>
    </div>

    <?php } else { ?>
    <p>This sale was not an exchange</p>
    <?php } ?>
    <div class="row">
        <div class="form-group col-md-4 col-xs-12 pull-right">
            <label for="">Bill Final Price</label>
            <input type="number" step="0.0001" class="form-control sbillFinalPrice" id="sbillFinalPrice" name="sbillFinalPrice" required="" value="<?php echo $row['sbillFinalPrice']; ?>" readonly=""></input>            
        </div>
    </div>  
    
	<button class="btn btn-info" id="action">Update</button>
</form>
<?php include '../include/layout-bottom-low.php'; ?>       

<script type="text/javascript">

/*-------- SECCION DE CALCULO DE PRECIO FINAL -----------*/
    $(document).ready(function(){
    	$(".saleLossGold,.saleLabor,.saleGoldValue").keyup(function(e){        
            calculatePrice($(this));
        });        
        function calculatePrice(trigger){
            //alert(trigger.closest(".calculations").find(".saleFinalPrice").val());
            $LossGold = parseFloat(trigger.closest(".calculations").find(".saleLossGold").val()*1);
            $labor = parseFloat(trigger.closest(".calculations").find(".saleLabor").val()*1);
            $goldValue = parseFloat(trigger.closest(".calculations").find(".saleGoldValue").val()*1);
            $saleFinalPrice = parseFloat($LossGold+$labor+$goldValue*1);
            trigger.closest(".calculations").find(".saleFinalPrice").val($saleFinalPrice);

            //calculando el Bill Final Price
            var finalPrices = $(".saleFinalPrice");
            var billFinalPrice = 0;
            for(var i = 0; i < finalPrices.length; i++){
                billFinalPrice += $(finalPrices[i]).val()*1;
            }
            $("#sbillFinalPrice").val(billFinalPrice);
        }
        
    });
/*-------- SECCION DE VALIDACION DE NOMBRES -----------*/
    /*
    Se debe verificar si el cliente ingresado existe, si no se creará el cliente nuevo
    */
    var nombreCompletado=0;                                             
    //comprobamos si se pulsa una tecla    
    $("#sbillFirstName, #sbillLastName").keyup(function(e){
        verificarNombres(e);                      
    });  
    function verificarNombres(e){
        //obtenemos el texto introducido en el campo
        var nombre = $("#sbillFirstName").val();
        var nombre2 = $("#sbillLastName").val();                           
        //hace la búsqueda
        //$("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/customers/check-customer-update.php",
                data: { b: nombre, c: nombre2},
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                
                    //alert("resultado = "+data);
                    $("#resultado").html(data);                                       
                }
            });           
                                           
        //});
    }
/*----------------- SECCION DE CHEQUEO DE ARTICLE CODE ----------------*/
    //comprobamos si se pulsa una tecla    
    var articleCode;
    var oldArticleCode;
    $(".saleArticleCode").keyup(function(e){
        articleCode = $(this).val();          
        oldArticleCode = $(this).siblings(".oldSaleArticleCode").val();  
        checkArticleCode(articleCode,oldArticleCode,$(this));                  
    });                     
       
    function checkArticleCode(b,c,trigger){                        
        trigger.closest("div").siblings(".articleCodeExist").html('<img src="../img/ajax-loader.gif" />');
        $.ajax({
            type: "POST",
            url: "../backend/articles/check-article-exist.php",
            data: {b:b,c:c},
            dataType: "html",
            error: function(){
                alert("Ajax error.");
            },
            success: function(data){
                trigger.closest("div").siblings(".articleCodeExist").html(data);                
            }
        });        
    }                                   
    
</script>