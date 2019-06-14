<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php include '../backend/connection.php'; ?>
<?php
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}           
$sql = "SELECT * FROM sales WHERE forsale='1'";

$result = $conn->query($sql);            

?>

<h3>New sale</h3>
<p>Fill in the fields to create a new sale</p>
<form method="POST" action="../backend/sales/create-sale.php">
    <div class="question-group" id="question-group">
        <div class="row">
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Bill Number</label>
                <input type="text" class="form-control saleBillNo" id="saleBillNo" name="saleBillNo" required="" value=""></input>              
            </div>            
        </div>
    	<div class="row">
            <div class="form-group col-md-4">
                <label for="">Customer First Name</label>
                <input type="text" class="form-control" id="saleFirstName" name="saleFirstName" required=""></input>   
                        
            </div>
            <div class="form-group col-md-4">
                <label for="">Customer Last Name</label>
                <input type="text" class="form-control" id="saleLastName" name="saleLastName" required=""></input>            
            </div>
            <div class="form-group col-md-4" id="resultado">                
            </div> 
        </div>  
        <div class="row">
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Sale area</label>
                <!--
                <select name="saleArea" class="form-control">
                <?php
                    /*
                    $sql3 = "SELECT * FROM areas";
                    $result3 = $conn->query($sql3);
                    while ($row3 = $result3->fetch_assoc()) {
                        //echo $row3['saleArea'];
                        echo "<option value='".$row3['saleArea']."'>" . $row3['saleArea'] . "</option>";
                    }
                    */
                ?>
                </select>
                -->
                <input type="text" class="form-control" name="saleArea" id="saleArea">
                
            </div>
            <div id="livesearch" class="form-group col-md-4 col-xs-12 alert alert-info"></div>
            <!--<div class="form-group col-md-4 col-xs-12">
                <input type="text" class="form-control" placeholder="Search" onkeyup="showResult(this.value)">
                
            </div>--> 
        </div>      
        <div class="row">
            <h3>Search an article by Article Code</h3>
            <div class="col-md-4">
                <input type="text" class="form-control" id="saleArticleCode" name="saleArticleCode"></input>                 
            </div>
            <div class="col-md-4" id="searchResult">
                
            </div>
            
        </div>
        <div class="row">
            <h3>Select an article</h3>
            <div class="col-md-4">
                <select class="form-control" id="selectArticle">
                    <option value="" disabled selected="">Select an article</option>
                <?php
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<option value="'.$row["saleArticleCode"].'">
                            '.$row["saleArticleName"].'
                        </option>';
                    }
                }
                ?>                   
                </select>
            </div>
            <div class="col-md-4" id="selectResult">
                
            </div>
        </div>
        
        <div class="row">
            <h3>List of purchased articles</h3>
            <div class="table-responsive">
                <table class="table" id="newTable">
                    <tr>  
                        <td><b>Code</b></td>                   
                        <td><b>Article Name</b></td>      
                        <td><b>Weight(gram)</b></td>       
                        <td><b>Weight(milligram)</b></td>       
                        <td><b>Final Price</b></td>                         
                        <td><b>Option</b></td>
                        
                    </tr>
                    <tr class="linea">        
                        
                    </tr>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-md-8 col-xs-12">
                <label for="">Extra Details</label>
                <input type="text" class="form-control" id="saleDetail" name="saleDetail" value=""></input>
            </div>
            <?php
            $sql = "SELECT timezone FROM config";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            date_default_timezone_set($row["timezone"]);
            $date = date('Y-m-d H:i:s');    
            ?>       
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Sale Date</label>
                <input type="text" class="form-control saleDateTime" id="saleDateTime" name="saleDateTime" required="" value="<?php echo $date; ?>"></input> 
            </div>
        </div>  
        <div class="row">
            <div class="form-group col-md-4">
                <label for="exchange">Exchange</label>
                <input type="checkbox" class="exchangeCB" name="exchangeCB" id="exchangeCB" value="exchangeCB"> This sale was an exchange
            </div>             
        </div>     
        <div class="row">
            <div id="exchangeDiv" style="display: none;">           
                <div class="col-md-3 col-xs-12">                    
                    <label for="exchange" id="exchangelbl">Exchange Article Name</label>  
                    <input type="text" class="form-control" id="saleExchArticle" name="saleExchArticle"></input>    
                </div>
                <div class="col-md-3 col-xs-12">
                    <label for="exchange" id="exchangelbl">Exchange Article Weight (gram)</label>  
                    <input type="number" step="0.0001" class="form-control" id="saleExchWeight" name="saleExchWeight" value="0"></input>
                </div>
                <div class="col-md-3 col-xs-12">
                    <label for="exchange" id="exchangelbl">Exchange Article Weight (milligram)</label>  
                    <input type="number" step="0.0001" class="form-control" id="saleExchWeightMili" name="saleExchWeightMili" value="0"></input>
                </div>
                <div class="col-md-3 col-xs-12">
                    <label for="exchange" id="exchangelbl">Exchange Value</label>  
                    <input type="number" step="0.0001" class="form-control" id="saleExchange" name="saleExchange" value="0"></input>
                </div>
            </div>
        </div> 
        <hr>
    </div>
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?> 



<script src="../js/multi-sales.js?6"></script> 
<script type="text/javascript">
/*----------------- SECCION DE GENERACION DE UN BILLNO ----------------*/
                        
    var consulta;

    function generarRandom(){
        return Math.floor((Math.random() * 1000000000000) + 1);
    }         
        
    function generateSaleBillNo(){                                   
        $("#resultado").html('<img src="../img/ajax-loader.gif" />');
        consulta = generarRandom();                        
        $.ajax({
            type: "POST",
            url: "../backend/sales/check-saleBillNo.php",
            data: "b="+consulta,
            dataType: "html",
            error: function(){
                alert("Ajax error.");
            },
            success: function(data){
                if(data){
                    $("#saleBillNo").val(data);
                    $("#resultado").html('');
                }else{
                    $("#resultado").html('Error: fetching from database.');
                    generateSaleBillNo();
                }                                                
                
            }
        });
    }                                   
    
    generateSaleBillNo();
    

/*-------------- AÑADIR ARTICULOS POR SELECT -------------*/
    
    var valor;
    var texto;
    $(document).on('change','#selectArticle',function(){
        $("#selectResult").html("<a href='javascript:void(0);' id='addingSelect' ><b>Add this to list of purchase </b></a> ");
        $("#addingSelect").click(function(e){   

            valor = $( "#selectArticle" ).val();
            $.post( "../backend/sales/check-sale.php", { aC: valor })
                .done(function( data ) {
                    if(data=='fail'){
                        alert('Error en AJAX');
                    }else{
                        $('#newTable').append(data);
                        $("#action").prop("disabled", false);
                        borrarArticulos();
                    }                    
            });
            
            /*
            $("#selectArticle option[value='"+valor+"']").each(function() {
                $(this).remove();
            });
            */
            
        });
    });
    
    

/*-------------- BORRAR ARTICULOS DE LA LISTA -------------*/
    function borrarArticulos(){
        $(".deleteArticle").click(function(e){
            this.closest('tr').remove();       
            return false;                 
        });
    }
    borrarArticulos();
    


/*-------------- SECCION DE BUSQUEDA DE ARTICULOS -------------*/
    //comprobamos si se pulsa una tecla    
    
    $("#saleArticleCode").keyup(function(e){        
        searchArticle(e);                      
    });
    var campos;
    function searchArticle(e){
        //obtenemos el texto introducido en el campo
        articleCode = $("#saleArticleCode").val();
                                        
        //hace la búsqueda
        //$("#searchResult").delay(1000).queue(function(n) {      
        if(articleCode!=""){                                   
            $("#searchResult").html('<img src="../img/ajax-loader.gif" />');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/sales/check-sale.php",
                data: { aC: articleCode},
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                
                    //alert("searchResult = "+data);
                    
                    if(data=="fail"){
                        $("#searchResult").html("<span style='font-weight:bold;color:red;'>This Article Code doesnt exists in database.</span>");
                    }
                    else{

                        $("#searchResult").html("<a href='javascript:void(0);' id='addingrow' ><b>Add this to list of purchase </b></a> ");
                        campos = data;
                        $("#addingrow").click(function(e){       
                            if(campos != "fail"){
                                $('#newTable').append(campos);
                                $("#saleArticleCode").val(" ");
                                $("#saleArticleCode").focus();
                                $("#searchResult").html("");
                                $("#action").prop("disabled", false);
                            }                      
                        });
                        borrarArticulos();                           
                        
                    }                    
                }
            });           
        //});
        }                                  
        
    }    
/*-------------- SECCION DE BUSQUEDA DE AREA -------------*/
    //comprobamos si se pulsa una tecla    
    
    $("#saleArea").keyup(function(e){        
        searchArea(e);                      
    });
    var campos;
    function searchArea(e){
        //obtenemos el texto introducido en el campo
        area = $("#saleArea").val();
                                        
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
                        $("#livesearch").html("<span style='font-weight:bold;color:red;'>The area was not found in the database</span>");
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
            $('#saleArea').val(txt);
            $("#livesearch").html("");                                        
        });
    } 
    
/*-------- SECCION DE VALIDACION DE NOMBRES -----------*/
    //deshabilitamos el boton de finish
    $("#action").prop("disabled", true);
    var nombreCompletado=0;                                             
    //comprobamos si se pulsa una tecla    
    $("#saleFirstName, #saleLastName").keyup(function(e){
        verificarNombres(e);                      
    });    

    function verificarNombres(e){
        //obtenemos el texto introducido en el campo
        nombre = $("#saleFirstName").val();
        nombre2 = $("#saleLastName").val();
                                        
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
                        $("#saleArea").val(res[2]);
                        
                    }else{
                        alert("AJAX ERROR: Customer data not found");
                    }                    
                }
            });            
        });
    }

/*----------- SECCION DE EXCHANGE ----------*/


    $('.exchangeCB').attr('checked', false);
    

$(document).on('click', '.exchangeCB', function () {
    //alert('Seleccionado '+$(this).closest('.row').find('#exchangeDiv'));
    if( $(this).prop('checked') ) {            
        $(this).closest('.question-group').find('#exchangeDiv').fadeIn(1000);
    }else{
        $(this).closest('.question-group').find('#exchangeDiv').fadeOut(1000);
    }
     
});

</script>
