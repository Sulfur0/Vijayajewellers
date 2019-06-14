<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM customers WHERE customerId='".$_GET["customerId"]."'";
	

	$result = mysqli_query($conn, $sql);

	$row = $result->fetch_assoc();

	mysqli_close($conn);       	
?>
<h3>Update customer</h3>
<p>Fill in the fields to update an existing customer</p>
<form method="POST" action="../backend/customers/update-customer.php">
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">First Name</label>
			<input type="text" class="form-control" id="name" name="name" value="<?php echo $row["name"]?>" required=""></input>			
		</div>
		<div class="form-group col-md-4">
			<label for="">Last Name</label>
			<input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row["lastname"]?>"></input>		
		</div>
		<div id="resultado" class="col-md-4"></div>
	</div>

	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Email</label>
			<input type="email" class="form-control" id="email" name="email" value="<?php echo $row["email"]?>"></input>			
		</div>
		<div class="form-group col-md-4">
			<label for="">Address</label>
			<input type="text" class="form-control" id="address" name="address" value="<?php echo $row["address"]?>"></input>			
		</div>
		
	</div>
	
	<div class="row">		
		<div class="form-group col-md-4">
			<label for="">Card Id</label>
			<input type="text" class="form-control" id="idCard" name="idCard" value="<?php echo $row["idCard"]?>"></input>			
		</div>
		<div class="form-group col-md-4">
			<label for="">Area</label>
			<input type="text" class="form-control" id="area" name="area" value="<?php echo $row["area"]?>"></input>			
		</div>
		<div class="form-group col-md-4">
            <div class="livesearch" id="livesearch"></div>
        </div>
	</div>

	<div class="row">		
		<div class="form-group col-md-4">
			<label for="">Telephone</label>
			<input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $row["telephone"]?>"></input>			
		</div>
	</div>

	<input type="hidden" class="form-control" id="customerId" name="customerId" value="<?php echo $row["customerId"]?>" required=""></input>

	<button class="btn btn-info" id="action">Update</button>
</form>
<?php include '../include/layout-bottom-low.php'; ?>       
<script type="text/javascript">
//codigo para chequear si el username ya esta registrado
$(document).ready(function(){
                         
    var consulta;
    var consulta2;
    var me;         
    //hacemos focus
    $("#lastname").focus();
                                                 
    //comprobamos si se pulsa una tecla
    $("#lastname, #name").keyup(function(e){
        //obtenemos el texto introducido en el campo
        consulta = $("#name").val();
        consulta2 = $("#lastname").val();
        me = $("#customerId").val(); 

        //hace la búsqueda
        $("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../	img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/customers/check-customer-not-me.php",
                data: "b="+consulta+"&c="+consulta2+"&me="+me,
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){               	                                                  
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