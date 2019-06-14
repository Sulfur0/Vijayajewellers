
<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>Create user</h3>
<p>Fill in the fields to create a new user</p>
<form method="POST" action="../backend/users/create-user.php">
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Name</label>
			<input type="text" class="form-control" id="name" name="name" required=""></input>			
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Username</label>
			<input type="text" class="form-control" id="username" name="username" required=""></input>				
		</div>
		<div id="resultado" class="col-md-6"></div>	
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Email</label>
			<input type="email" class="form-control" id="email" name="email" required=""></input>			
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Password</label>
			<input type="password" class="form-control" id="password" name="password" required=""></input>			
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Privileges</label>
			<select class="form-control" id="privileges" name="privileges" required=""  >
				<option value="10" selected="selected">Select the level of privilege</option>
			  	<option value="1">Cashier</option>
			  	<option value="2">Admin</option>
			</select>						
		</div>
	</div>
	<button class="btn btn-primary">Create</button>
</form>
<?php include '../include/layout-bottom-low.php'; ?>     

<script type="text/javascript">
//codigo para chequear si el username ya esta registrado
$(document).ready(function(){
                         
    var consulta;
             
    //hacemos focus
    $("#username").focus();
                                                 
    //comprobamos si se pulsa una tecla
    $("#username").keyup(function(e){
        //obtenemos el texto introducido en el campo
        consulta = $("#username").val();
                                      
        //hace la búsqueda
        $("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/check-user.php",
                data: "b="+consulta,
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                                                    
                    $("#resultado").html(data);
                    n();
                }
            });
                                           
        });
                                
    });
                          
});
</script>