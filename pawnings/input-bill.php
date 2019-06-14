<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php 
$forward="";
if(isset($_GET['repawn'])){
    $forward = 'repawn.php';
}else if(isset($_GET['redeem'])){
    $forward = 'redeem.php';
}else if(isset($_GET['warning-letter'])){
    $forward = 'warning-letter.php';
}
else if(isset($_GET['terminate-pawn'])){
    $forward = '../backend/pawnings/terminate-pawn.php';
}

?>
<h3>Please input a pawning bill number</h3>
<p>Exclude the "VJ" in the beginning, for example for VJ30002 write 30002</p>
<form method="POST" action="<?php echo $forward; ?>">
	<div>
		<div class="row spaced">
            <div class="col-md-4 table-responsive">                
                <input class="form-control" type="number" name="pawnBillNo" id="pawnBillNo">
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
    $("#pawnBillNo").focus();
                                                 
    //comprobamos si se pulsa una tecla
    $("#pawnBillNo").keyup(function(e){
        //obtenemos el texto introducido en el campo
        consulta = $("#pawnBillNo").val();
                                      
        //hace la búsqueda
        //$("#resultado").delay(1000).queue(function(n) {      
                                           
            $("#resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/pawnings/check-pawning.php",
                data: "b="+consulta,
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                                                    
                    $("#resultado").html(data);
                    if(data=="<span style='font-weight:bold;color:red;'>No pawning bill has been found for this number.</span>")
                        $("#action").prop("disabled", true);
                    else
                        $("#action").prop("disabled", false);
                    n();
                }
            });
                                           
        //});
                                
    });
                          
});
</script>