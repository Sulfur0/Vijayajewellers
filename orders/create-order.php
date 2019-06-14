<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>New order</h3>
<p>Fill in the fields to create a new order</p>
<form method="POST" action="../backend/orders/create-order.php">
    <div class="question-group" id="question-group">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Delivery Date (format: Y/m/d hr/min/sec, I.E. 2017-06-30 10:22:56)</label>
                
                <?php
                include '../backend/connection.php';
                $sql = "SELECT timezone FROM config";
                $result = mysqli_query($conn, $sql);
                $row = $result->fetch_assoc();
                date_default_timezone_set($row["timezone"]);
                $date = date('Y/m/d h:i:s', time()); 
                ?>
                <input type="text" class="form-control" id="orderDeliveryDate" name="orderDeliveryDate[]" required="" value="<?php echo $date; ?>"></input>         
            </div>
            <div class="form-group col-md-4">
                <label for="">Bill Number</label>
                <input type="number" step="0.01" class="form-control" id="orderBillNo" name="orderBillNo[]" required=""></input>                
            </div>
        </div>
    	<div class="row">   			
    	
            <div class="form-group col-md-4">
                <label for="">First Name</label>
                <input type="text" class="form-control" id="orderFirstName" name="  orderFirstName[]" required=""></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Last Name</label>
                <input type="text" class="form-control" id="orderLastName" name="orderLastName[]" required=""></input>            
            </div>
            <div class="resultado col-md-4" id="resultado"></div>
        </div>

        <div class="row">
        
            <div class="form-group col-md-4">
                <label for="">Address</label>
                <input type="text" class="form-control" id="orderAddress" name="orderAddress[]" required=""></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Telephone</label>
                <input type="text" class="form-control" id="orderTelephone" name="orderTelephone[]" required=""></input>            
            </div>

            <div class="form-group col-md-4">
                <label>Area</label>
                <input type="text" class="form-control" id="orderArea" name="orderArea[]" required=""></input>
            </div>            

        </div>

        <div class="row">

            <div class="form-group col-md-4">
                <label for="">Cost</label>
                <input type="number" class="form-control" id="orderCost" name="orderCost[]" required=""></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Advance Being Paid</label>
                <input type="number" step="0.01" class="form-control" id="orderAdvance" name="orderAdvance[]" required="" value="0"></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Quality</label>
                <input type="number" step="0.01" class="form-control" id="orderQuality" name="orderQuality[]" required="" value="0"></input>            
            </div>            

        </div>

        <div class="row">

            <div class="form-group col-md-4">
                <label for="">Weight (grams)</label>
                <input type="number" step="0.01" class="form-control" id="orderWeight" name="orderWeight[]" required="" value="0"></input>     
            </div>

            <div class="form-group col-md-4">
                <label for="">Weight (milligrams)</label>
                <input type="number" step="0.01" class="form-control" id="orderWeightMili" name="orderWeightMili[]" required="" value="0"></input>     
            </div>

        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Design Requirements</label>
                <textarea style="resize:none;" class="form-control" id="orderDesignDetail" name="orderDesignDetail[]" required=""></textarea> 
            </div>
        </div>


    </div>	
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
            <button class="btn btn-info" id="oneMore">Create one more order</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?>
<script src="../js/multi-orders.js?26"></script>
<script type="text/javascript">    
/*-------- SECCION DE VALIDACION DE NOMBRES -----------*/
    
    var nombreCompletado=0;                                             
    //comprobamos si se pulsa una tecla    
    $("#orderFirstName, #orderLastName").keyup(function(e){
        verificarNombres(e);                      
    });    

    function verificarNombres(e){
        //obtenemos el texto introducido en el campo
        nombre = $("#orderFirstName").val();
        nombre2 = $("#orderLastName").val();
                                        
        //hace la búsqueda
        //$("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/customers/check-customer.php",
                data: { b: nombre, c: nombre2},
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                
                    //alert("resultado = "+data);
                    
                    if(data=="<span style='font-weight:bold;color:red;'>This customer name already exists.</span>"){                        
                        
                        $("#resultado").html("<span style='font-weight:bold;color:green;'>Customer found. <a href='javascript:void(0);' id='autofill' class='autofill'>Autofill the customer data</a></span>");
                        autofill(nombre,nombre2);
                    }
                    else{
                        
                        $("#resultado").html("<span style='font-weight:bold;color:red;'>This customer name doesn't exists. A new customer will be created.</span>");
                    }                    
                }
            });           
                                           
        //});
    }
    function autofill(b,c){
        $( "#autofill" ).click(function() {

            $("#resultado").html('<img src="../img/ajax-loader.gif" />');                                           
            $.ajax({
                type: "POST",
                url: "../backend/customers/pull-customer-data.php",
                data: { b: nombre, c: nombre2},
                dataType:"html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                
                    //alert("resultado = "+data);
                    
                    if(data){      
                        $("#resultado").html(''); 
                        var res = data.split(",");  
                        $("#orderTelephone").val(res[0]);
                        $("#orderAddress").val(res[1]);
                        $("#orderArea").val(res[2]);
                        
                    }else{
                        alert("AJAX ERROR: Customer data not found");
                    }                    
                }
            });            
        });
    }
    
</script>

