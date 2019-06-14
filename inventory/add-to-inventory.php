<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<h3>Add to Inventory</h3>

<form method="POST" action="../backend/inventory/add-to-inventory.php">
    <div class="question-group" id="question-group">
        <div class="row">
            <div class="form-group col-md-4 col-xs-12">
                <label for="">Article Name</label>
                <input type="text" class="form-control" id="saleArticleName" name="saleArticleName" required="">
            </div>
            <div id="livesearch" class="form-group col-md-4 col-xs-12 alert alert-info"></div>
        </div>
        <div class="row">            
            <div class="form-group col-md-4">
                <label for="">Article Code</label>
                <input type="text" class="form-control" id="saleArticleCode" name="saleArticleCode" required=""> 
            </div>
            <div class="form-group col-md-4" id="resultado"></div>
            
        </div>
        <div class="row">
            
            <div class="form-group col-md-4">
                <label for="">Weight (gram)</label>
                <input type="number" value="0" step="0.0001" class="form-control" id="saleWeight" name="saleWeight" required=""> 
            </div>

            <div class="form-group col-md-4">
                <label for="">Weight (milligram)</label>
                <input type="number" value="0" step="0.0001" class="form-control" id="saleWeightMili" name="saleWeightMili" required=""> 
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Labor</label>
                <input type="number" value="0" step="0.0001" class="form-control" id="saleLabor" name="saleLabor" required=""> 
            </div>
            <div class="form-group col-md-4">
                <label for="">Loss Gold</label>
                <input type="number" value="0" step="0.0001" class="form-control" id="saleLossGold" name="saleLossGold" required=""> 
            </div>
            <div class="form-group col-md-4">
                <label for="">Gold Value</label>
                <input type="number" value="0" step="0.0001" class="form-control" id="saleGoldValue" name="saleGoldValue" required=""> 
            </div>
            <div class="form-group col-md-4">
                <label for="">Final Price</label>
                <input type="number" value="0" step="0.0001" class="form-control" id="saleFinalPrice" name="saleFinalPrice" required="" readonly=""> 
            </div>
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
    
    /*-------------- SECCION DE GENERACION DE UN ARTICLE CODE --------------*/
                         
    var consulta;

    function generarRandom(){
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        var possible2= "0123456789"

        for (var i = 0; i < 4; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
        for (var i = 0; i < 4; i++)
        text += possible2.charAt(Math.floor(Math.random() * possible2.length));

        return text;
    }         
        
    function generateArticleCode(){                             
        $("#resultado").html('<img src="../img/ajax-loader.gif" /> Generating Article Code ...');
        consulta = generarRandom();                      
        $.ajax({
            type: "POST",
            url: "../backend/inventory/check-articlecode.php",
            data: "b="+consulta,
            dataType: "html",
            error: function(){
                alert("Ajax error.");
            },
            success: function(data){
                if(data == 'free'){
                    $("#saleArticleCode").val(consulta);

                }else if(data == 'taken'){
                    generateArticleCode();

                }                                                 
                $("#resultado").html('');
            }
        });
    }                                   
    
    generateArticleCode();

    /*-------------- SECCION DE BUSQUEDA DE ARTICLE NAME -------------*/
    //comprobamos si se pulsa una tecla    
    
    $("#saleArticleName").keyup(function(e){        
        searchArea(e);                      
    });
    var campos;
    function searchArea(e){
        //obtenemos el texto introducido en el campo
        area = $("#saleArticleName").val();
                                        
        //hace la búsqueda
        //$("#livesearch").delay(1000).queue(function(n) {      
        if(area!=""){                                   
            $("#livesearch").html('<img src="../img/ajax-loader.gif" /> Loading ...');
                                           
            $.ajax({
                type: "POST",
                url: "../backend/articles/check-article.php",
                data: { aC: area},
                dataType: "html",
                error: function(){
                    alert("Ajax error.");
                },
                success: function(data){                
                    //alert("livesearch = "+data);
                    if(data == 'fail'){
                        $("#livesearch").html("<span style='font-weight:bold;color:black;'>The article was not found in the database, a new article will be created.</span>");
                    }else{
                        $("#livesearch").html(data);
                        setArticle();
                    }
                    
                                       
                }
            });           
        //});
        }                                  
        
    }  
    function setArticle(){
        $(".setArticle").click(function(e){ 
            var txt = $(e.target).text(); 
            $('#saleArticleName').val(txt);
            $("#livesearch").html("");                                        
        });
    } 
    /*-------------- SECCION DE CALCULO DEL PRECIO FINAL --------------*/
                        
    function calculateFinalPrice(){                            
        
        labor = parseFloat($("#saleLabor").val(), 10); 
        lossGold = parseFloat($("#saleLossGold").val(), 10); 
        goldValue = parseFloat($("#saleGoldValue").val(), 10); 
        finalPrice = labor+lossGold+goldValue*1;
        $("#saleFinalPrice").val(finalPrice);
        parseInt($('#a').val(), 10);

    } 
    calculateFinalPrice();
    $("#saleLabor, #saleLossGold, #saleGoldValue").change(function(){
        calculateFinalPrice();
    });

</script>

