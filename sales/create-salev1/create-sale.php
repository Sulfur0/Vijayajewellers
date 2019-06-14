<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
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
    		<div class="form-group col-md-4 col-xs-12">
    			<label for="">Article Name</label>
    			<input type="text" class="form-control" id="saleArticleName" name="saleArticleName[]" required=""></input>				
    		</div>            
    		<div id="resultado" class="col-md-4 col-xs-12"></div>	
    	</div>
        <div class="row">
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Article Code</label>
                <input type="text" class="form-control" id="saleArticleCode" name="saleArticleCode[]" required=""></input>            
            </div>        
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Article Gold Weight (gram)</label>
                <input type="number" step="0.01" class="form-control" id="saleWeight" name="saleWeight[]" required="" value="0"></input>            
            </div>
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Article Gold Weight (milligram)</label>
                <input type="number" step="0.01" class="form-control" id="saleWeightMili" name="saleWeightMili[]" required="" value="0"></input>            
            </div>
        </div>
        <div id="prices">    
            <div class="row">
                <div class="form-group col-md-4 col-xs-12">
                    <label for="">Labor</label>
                    <input type="number" step="0.01" class="form-control" id="saleLabor" name="saleLabor[]" required="" value="0"></input>            
                </div>
            
                <div class="form-group col-md-4 col-xs-12">
                    <label for="">Loss of Gold</label>
                    <input type="number" step="0.01" class="form-control" id="saleLossGold" name="saleLossGold[]" required="" value="0"></input>            
                </div>
            
                <div class="form-group col-md-4 col-xs-12">
                    <label for="">Final Price</label>
                    <input type="number" step="0.01" class="form-control" id="saleFinalPrice" name="saleFinalPrice[]" value="0"></input>            
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-8 col-xs-12">
                <label for="">Extra Details</label>
                <input type="text" class="form-control" id="saleDetail" name="saleDetail[]" required="" value=""></input>
            </div>
                       
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Sale Date</label>
                <input type="text" class="form-control saleDateTime" id="saleDateTime" name="saleDateTime[]" required="" value=""></input> 
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
                <div class="col-md-4">                    
                    <label for="exchange" id="exchangelbl">Exchange Article Name</label>  
                    <input type="text" class="form-control" id="saleExchArticle" name="saleExchArticle[]" maxlength="10"></input>    
                </div>
                <div class="col-md-4">
                    <label for="exchange" id="exchangelbl">Exchange Article Weight</label>  
                    <input type="number" step="0.01" class="form-control" id="saleExchWeight" name="saleExchWeight[]" maxlength="10"></input>
                </div>
                <div class="col-md-4">
                    <label for="exchange" id="exchangelbl">Exchange Value</label>  
                    <input type="number" step="0.01" class="form-control" id="saleExchange" name="saleExchange[]" maxlength="10"></input>
                </div>
            </div>
        </div> 
        <hr>
    </div>	
    <div class="option-group">
        <div class="btn-group">
            <button class="btn btn-primary" id="action">Finish</button>
            <button class="btn btn-info" id="oneMore">Add more articles to this sale</button>
        </div>
    </div>
</form>
<?php include '../include/layout-bottom-low.php'; ?> 



<script src="../js/multi-sales.js?6"></script>   

<script type="text/javascript">

$(document).ready(function(){
    
    //Javascript file
    $.post('getDate.php', 'val=' + $(".saleDateTime").val(), function (response){
            $(".saleDateTime").val(response);
            //alert();
    });
    
    //$(".saleDateTime").val(fecha);
                         
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
                if(data == 'free'){
                    $("#saleBillNo").val(consulta);

                }else if(data == 'taken'){
                    generateSaleBillNo();

                }                                                 
                $("#resultado").html('');
                n();
            }
        });
    }                                   
    
    generateSaleBillNo();

    $(".saleLossGold").keyup(function(e){   
        //calculatePrice(this);
    });
    $(".saleLabor").keyup(function(e){        
        //calculatePrice(this);
    });
    $(".saleWeight").keyup(function(e){
        //calculatePrice(this);
    });
    function calculatePrice($e){        
        $saleLabor=$($e).closest('#prices').find('#saleLabor').val();
        $saleLossGold=$($e).closest('#prices').find('#saleLossGold').val();
        $finalPrice = $saleLabor*1+$saleLossGold*1;
        $($e).closest('#prices').find('#saleFinalPrice').val($finalPrice);
    }
    function test(){
        alert("HELLO");
    }

    $('.exchangeCB').attr('checked', false);
    
});
$(document).on('click', '.exchangeCB', function () {
    //alert('Seleccionado '+$(this).closest('.row').find('#exchangeDiv'));
    if( $(this).prop('checked') ) {            
        $(this).closest('.question-group').find('#exchangeDiv').fadeIn(1000);
    }else{
        $(this).closest('.question-group').find('#exchangeDiv').fadeOut(1000);
    }
     
});

</script>
