<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php include '../backend/connection.php'; ?>
<h3>New pawn</h3>
<p>Fill in the fields to create a new pawn</p>
<form method="POST" action="../backend/pawnings/create-pawning.php" onsubmit="return nroBillNo();">
    <div class="question-group" id="question-group">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Pawn Date (format: Y/m/d hr/min/sec, I.E. 2017-06-30 10:22:56)</label>
                
                <?php
                $sql = "SELECT timezone FROM config";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                date_default_timezone_set($row["timezone"]);
                $date = date('Y-m-d H:i:s');                
                ?>
                <input type="text" class="form-control" id="pawnDateTime" name="pawnDateTime" required="" value="<?php echo $date; ?>"></input>         
            </div>
            <div class="form-group col-md-4">
                <label for="">Bill Number</label>
                <input type="text" class="form-control" id="pawnBillNo" name="pawnBillNo" required=""></input>              
            </div>
        </div>
    	<div class="row">
    			
    	
            <div class="form-group col-md-4">
                <label for="">First Name</label>
                <input type="text" class="form-control" id="pawnFirstName" name="  pawnFirstName" required=""></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Last Name</label>
                <input type="text" class="form-control" id="pawnLastName" name="pawnLastName" required=""></input>            
            </div>
            <div class="form-group col-md-4" id="resultado">                
            </div>
            
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Age</label>
                <input type="number" step="0.01" class="form-control" id="pawnAge" name="pawnAge" required="" value="0"></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Address</label>
                <input type="text" class="form-control" id="pawnAddress" name="pawnAddress" required=""></input>            
            </div>
            <div class="form-group col-md-4">
                <label for="">NIC No.</label>
                <input type="text" class="form-control" id="pawnIdcard" name="pawnIdcard" required=""></input>            
            </div>
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Area Name</label>
                <select name="pawnAreaName" id="pawnAreaName" class="form-control">
                <?php
                    $sql3 = "SELECT areaName FROM areas ";
                    $result3 = $conn->query($sql3);
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
            
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Name of Authorized Person </label>
                <input type="text" class="form-control" id="pawnAuthorized" name="pawnAuthorized" required=""></input>            
            </div>  
            <div class="form-group col-md-4">
                <label for="">NIC No. of Authorized Person </label>
                <input type="text" class="form-control" id="pawnIdcardAuthorized" name="pawnIdcardAuthorized" required=""></input>            
            </div>  
        </div>
        <div class="row">            
            <div class="form-group col-md-2">
                <label for="">Net Weight of Article (gram)</label>
                <input type="number" step="0.01" class="form-control" id="pawnNetWeight" name="pawnNetWeight[]" required="" value="0"></input>            
            </div>
            <div class="form-group col-md-2">
                <label for="">Net Weight of Article (milligram)</label>
                <input type="number" step="0.01" class="form-control" id="pawnNetWeightMili" name="pawnNetWeightMili[]" required="" value="0"></input>            
            </div>
            <div class="form-group col-md-2">
                <label for="">Gross Weight of Article (gram)</label>
                <input type="number" step="0.01" class="form-control" id="pawnGrossWeight" name="pawnGrossWeight[]" required="" value="0"></input>            
            </div>
            <div class="form-group col-md-2">
                <label for="">Gross Weight of Article (milligram)</label>
                <input type="number" step="0.01" class="form-control" id="pawnGrossWeightMili" name="pawnGrossWeightMili[]" required="" value="0"></input>            
            </div>                            
        </div>        
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Type of Article</label>
                <input type="text" class="form-control" id="pawnArticleType" name="pawnArticleType[]" required=""></input>            
            </div> 
            <div class="form-group col-md-4">
                <label for="">Amount Being Paid</label>
                <input type="number" step="0.01" class="form-control" id="pawnAmount" name="pawnAmount[]" required="" value="0"></input>            
            </div>           
        </div>
    </div>	
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
            <button class="btn btn-info" id="oneMore">Add one more pawn</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?> 

<script src="../js/multi-pawnings.js?2"></script>  

<script type="text/javascript">
/*----------------- SECCION DE GENERACION DE UN BILLNO ----------------*/
                        
    var consulta= 0;

    function generateSaleBillNo(){                                   
        $("#resultado").html('<img src="../img/ajax-loader.gif" />');
        $.ajax({
            type: "POST",
            url: "../backend/pawnings/check-pawnBillNo.php",
            data: "b="+consulta,
            dataType: "html",
            error: function(){
                alert("Ajax error.");
            },
            success: function(data){                
                if(data){
                    $("#pawnBillNo").val("VJ"+data);
                    $("#resultado").html('');
                }else{
                    $("#resultado").html('Error: fetching from database.');
                    generateSaleBillNo();
                }                                                
                
            }
        });
    }                                   
    
    generateSaleBillNo();
/*----------------- RETORNO EL VALOR DEL BILLNO SIN VJ ----------------*/
function nroBillNo(){
    str = $("#pawnBillNo").val();
    var res = str.substring(2);
    $("#pawnBillNo").val(res);
}

/*-------- SECCION DE VALIDACION DE NOMBRES -----------*/
    //deshabilitamos el boton de finish
    $("#action").prop("disabled", true);
    var nombreCompletado=0;                                             
    //comprobamos si se pulsa una tecla    
    $("#pawnFirstName, #pawnLastName").keyup(function(e){
        verificarNombres(e);                      
    });    

    function verificarNombres(e){
        //obtenemos el texto introducido en el campo
        nombre = $("#pawnFirstName").val();
        nombre2 = $("#pawnLastName").val();
                                        
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
                        $("#action").prop("disabled", false);
                    }
                    else{
                        
                        $("#resultado").html("<span style='font-weight:bold;color:red;'>This customer name doesnt exists.</span>");
                    }                    
                }
            });           
                                           
        //});
    }
/*-------- SECCION DE AUTOLLENADO DE CAMPOS SEGUN EL NOMBRE -----------*/    
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
                        $("#pawnAddress").val(res[1]);
                        $("#pawnAreaName").val(res[2]);
                        $("#pawnIdcard").val(res[3]);
                        
                    }else{
                        alert("AJAX ERROR: Customer data not found");
                    }                    
                }
            });            
        });
    }
</script>
