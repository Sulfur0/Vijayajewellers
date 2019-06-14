<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM sales WHERE saleId='".$_GET["saleId"]."' AND forsale = '1'";
	

	$result = mysqli_query($conn, $sql);

	$row = $result->fetch_assoc();

	mysqli_close($conn);       	
?>
<h3>Purchase sale</h3>
<p>Fill in the fields to purchase an existing sale</p>
<form method="POST" action="../backend/sales/purchase-sale.php">
	<!--
	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Sale Date</label>
            
            <?php
                //$sql = "SELECT timezone FROM config";
                //$result = $conn->query($sql);
                //$row = $result->fetch_assoc();
                //date_default_timezone_set($row["timezone"]);
                //$date = date('Y/m/d h:i:s', time()); 
            ?>
			<input type="text" class="form-control" id="saleDateTime" name="saleDateTime" required="" value="<?php //echo $date; ?>"></input>			
		</div>
	</div>
    -->
	<div class="row">
        <div class="form-group col-md-4">
            <label for="">Customer First Name</label>
            <input type="text" class="form-control" id="saleFirstName" name="saleFirstName" required=""></input>   
                    
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-4">
            <label for="">Customer Last Name</label>
            <input type="text" class="form-control" id="saleLastName" name="saleLastName" required=""></input>            
        </div>
        <div class="form-group col-md-4" id="resultado">

    		
    	</div> 
    </div>    

	<div class="row">
		<div class="form-group col-md-4">
			<label for="">Address</label>
			<input type="text" class="form-control" id="saleAddress" name="saleAddress" required=""></input>			
		</div>
	</div>

    
	<input type="hidden" class="form-control" id="saleId" name="saleId" required="" value="<?php echo $_GET["saleId"]; ?>"></input>
    

	<button class="btn btn-info" id="action">Purchase and create bill</button>
</form>
<?php include '../include/layout-bottom-low.php'; ?>       

<script type="text/javascript">
//codigo para chequear si el username ya esta registrado
$(document).ready(function(){
                         
    var consulta;
    var consulta2;
    
             
    //hacemos focus
    $("#saleLastName").focus();
                                                 
    //comprobamos si se pulsa una tecla    
    $("#saleLastName").keyup(function(e){
        //obtenemos el texto introducido en el campo
        consulta = $("#saleFirstName").val();
        consulta2 = $("#saleLastName").val();
                                        
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
                    
                    if(data=="<span style='font-weight:bold;color:red;'>This customer name already exists.</span>"){
                        $("#action").prop("disabled", false);
                        $("#resultado").html("");                        
                    }else{
                        $("#action").prop("disabled", true);
                        $("#resultado").html("<span style='font-weight:bold;color:red;'>This customer doesn't exists. You can create a new customer here: <a href='../customers/create-customer.php'>here</a></span>");
                    }
                    n();
                }
            });           
                                           
        });
                                
    });
    /*
    $('#exchangeCB').change(function(){        
        var checkeado = $(this).attr('checked', true);
        var unchecked = $(this).removeAttr('checked');
        if(checkeado) {
            alert('activado');
        } else if(unchecked) {
            alert('desactivado');
        }
    });   
    */
    /*
    $("#exchangeCB").click(function() {  
        if($("#checkbox").is('checked')) {  
            alert("Está activado");  
        } else {  
            alert("No está activado");  
        }  
    }); 
    */  
    
                          
});
</script>