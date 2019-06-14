<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>New area</h3>

<form method="POST" action="../backend/areas/create-area.php">
    <div class="question-group" id="question-group">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Name</label>
                <input type="text" class="form-control" id="areaName" name="areaName" required="">           
            </div>
            <div id="resultado"></div>
        </div>
    </div>	
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?> 

<script type="text/javascript">
//codigo para chequear si el username ya esta registrado
$(document).ready(function(){
                         
    var consulta;
    
             
    //hacemos focus
    //$("#areaName").focus();
                                                 
    //comprobamos si se pulsa una tecla    
    $("#areaName").keyup(function(e){
        //obtenemos el texto introducido en el campo
        consulta = $("#areaName").val();
                                        
        //hace la búsqueda
        //$("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/areas/check-area-exist.php",
                data: { b: consulta},
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                
                    //alert("resultado = "+data);
                    $("#resultado").html(data);
                    if(data=="<span style='font-weight:bold;color:red;'>This area already exists.</span>"){
                        $("#action").prop("disabled", true);
                        $("#resultado").html(data);
                    }else{
                        $("#action").prop("disabled", false);
                        $("#resultado").html(data);
                    }
                    n();
                }
            });           
                                           
        //});
                                
    });
                          
});
</script>
