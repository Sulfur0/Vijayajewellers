<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php 
$forward="";
if (isset($_GET['update-order'])){
    $forward = 'update-order.php';
}
else if (isset($_GET['deliver-order'])){
    $forward= 'update-order.php?deliver=1';
}
?>
<h3>Please input a order bill number</h3>
<form method="POST" action="<?php echo $forward; ?>">
	<div>
		<div class="row spaced">
            <div class="col-md-4 table-responsive">                
                <input class="form-control" type="number" name="orderBillNo" id="orderBillNo">
            </div>
            <div class="col-md-4" id="resultado">
                
            </div>                        
        </div>
    </div>    
    
	<div class="option-group">
        <div class="btn-group">
            <button style="margin-top: 50px;" class="btn btn-primary" id="action">Next</button>
        </div>
    </div>    	
</form>
<?php include '../include/layout-bottom-low.php'; ?>       


<script src="../js/multi-payments.js?1"></script>  

<script type="text/javascript">
//codigo para chequear si el bill ya esta registrado
$(document).ready(function(){
    $("#action").prop("disabled", true);                      
    var consulta;
             
    //hacemos focus
    $("#orderBillNo").focus();
                                                 
    //comprobamos si se pulsa una tecla
    $("#orderBillNo").keyup(function(e){
        //obtenemos el texto introducido en el campo
        consulta = $("#orderBillNo").val();
                                      
        //hace la búsqueda
        $("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/orders/check-order.php",
                data: "b="+consulta,
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                                                    
                    $("#resultado").html(data);
                    if(data=="<span style='font-weight:bold;color:red;'>No order bill has been found for this number.</span>")
                        $("#action").prop("disabled", true);
                    else
                        $("#action").prop("disabled", false);
                    n();
                }
            });
                                           
        });
                                
    });
                          
});
</script>