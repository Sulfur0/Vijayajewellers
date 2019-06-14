<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>Create customer</h3>
<p>Fill in the fields to create a new customer</p>
<form method="POST" action="../backend/customers/create-customer.php">
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">First Name</label>
			<input type="text" class="form-control" id="name" name="name" required=""></input>			
		</div>
        <div class="form-group col-md-4">
            <label for="">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required=""></input>              
        </div>
        <div id="resultado" class="col-md-4"></div> 
	</div>	
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Email</label>
			<input type="email" class="form-control" id="email" name="email"></input>			
		</div>
        <div class="form-group col-md-4">
            <label for="">Address</label>
            <input type="text" class="form-control" id="address" name="address"></input>           
        </div>
	</div>    
    <div class="row">
        <div class="form-group col-md-4">
            <label for="">NIC No.</label>
            <input type="text" class="form-control" id="idCard" name="idCard"></input>           
        </div>
        <div class="form-group col-md-4">
            <label for="">Area</label>
            <input type="text" class="form-control" id="area" name="area"></input>           
        </div>
        <div class="form-group col-md-4">
            <div class="livesearch" id="livesearch"></div>
        </div>
    </div>    
    <div class="row">
        <div class="form-group col-md-4">
            <label for="">Telephone</label>
            <input type="text" class="form-control" id="telephone" name="telephone"></input>           
        </div>
    </div>
	<button class="btn btn-primary" id="action">Create</button>	
</form>
<?php include '../include/layout-bottom-low.php'; ?>     

<script type="text/javascript">
//codigo para chequear si el username ya esta registrado
$(document).ready(function(){
                         
    var consulta;
    var consulta2;
    
             
    //hacemos focus
    $("#lastname").focus();
                                                 
    //comprobamos si se pulsa una tecla    
    $("#lastname, #name").keyup(function(e){
        //obtenemos el texto introducido en el campo
        consulta = $("#name").val();
        consulta2 = $("#lastname").val();
                                        
        //hace la búsqueda
        $("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/customers/check-customer.php",
                data: { b: consulta, c: consulta2},
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){               	
                    //alert("resultado = "+data);
                    $("#resultado").html(data);
                    if(data=="<span style='font-weight:bold;color:red;'>This customer name already exists.</span>")
                        $("#action").prop("disabled", true);
                    else
                        $("#action").prop("disabled", false);
                    n();
                }
            });           
                                           
        });
                                
    });
                          
});
/*-------------- SECCION DE BUSQUEDA DE AREA -------------*/
    //comprobamos si se pulsa una tecla    
    
    $("#area").keyup(function(e){        
        searchArea(e);                      
    });
    var campos;
    function searchArea(e){
        //obtenemos el texto introducido en el campo
        area = $("#area").val();
                                        
        //hace la búsqueda
        //$("#livesearch").delay(1000).queue(function(n) {      
        if(area!=""){                                   
            $("#livesearch").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/areas/check-area.php",
                data: { aC: area},
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                
                    //alert("livesearch = "+data);
                    if(data == 'fail'){
                        $("#livesearch").html("<span style='font-weight:bold;color:black;'>The area was not found in the database, a new area will be registered</span>");
                    }else{
                        $("#livesearch").html(data);
                        setArea();
                    }
                    
                                       
                }
            });           
        //});
        }                                  
        
    }  
    function setArea(){
        $(".setArea").click(function(e){ 
            var txt = $(e.target).text(); 
            $('#area').val(txt);
            $("#livesearch").html("");                                        
        });
    } 
</script>