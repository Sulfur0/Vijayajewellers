$('#oneMore').on('click',function(){

	
	insertDivs();
	setData();

});
function insertDivs(){
	//objetos = buildSelect();	
	$( "#question-group" ).after( $( '<hr><div class="question-group" id="question-group"><div class="row"><div class="form-group col-md-4"><label for="">Delivery Date (format: Y/m/d hr/min/sec, I.E. 2017-06-30 10:22:56)</label><input type="text" class="form-control" id="orderDeliveryDate" name="orderDeliveryDate[]" required="" value=""></input></div><div class="form-group col-md-4"><label for="">Bill Number</label><input type="number" step="0.01" class="form-control" id="orderBillNo" name="orderBillNo[]" required=""></input></div></div><div class="multi"><div class="row nameDiv"><div class="form-group col-md-4"><label for="">First Name</label><input type="text" class="form-control orderFirstName" name="orderFirstName[]" required=""></input></div><div class="form-group col-md-4"><label for="">Last Name</label><input type="text" class="form-control orderLastName" name="orderLastName[]" required=""></input></div><div class="resultado col-md-4" id="resultado"></div></div><div class="row"><div class="form-group col-md-4"><label for="">Address</label><input type="text" class="form-control orderAddress" id="orderAddress" name="orderAddress[]" required=""></input></div><div class="form-group col-md-4"><label for="">Telephone</label><input type="text" class="form-control orderTelephone" id="orderTelephone" name="orderTelephone[]" required=""></input></div><div class="form-group col-md-4"><label for="">Area</label><input type="text" class="form-control orderArea" id="orderArea" name="orderArea[]" required=""></input></div></div></div><div class="row"><div class="form-group col-md-4"><label for="">Cost</label><input type="number" class="form-control" id="orderCost" name="orderCost[]" required=""></input></div><div class="form-group col-md-4"><label for="">Advance Being Paid</label><input type="number" step="0.01" class="form-control" id="orderAdvance" name="orderAdvance[]" required="" value="0"></input></div><div class="form-group col-md-4"><label for="">Quality</label><input type="number" step="0.01" class="form-control" id="orderQuality" name="orderQuality[]" required="" value="0"></input></div></div><div class="row"><div class="form-group col-md-4"><label for="">Weight (grams)</label><input type="number" step="0.01" class="form-control" id="orderWeight" name="orderWeight[]" required="" value="0"></input> </div><div class="form-group col-md-4"><label for="">Weight (milligrams)</label><input type="number" step="0.01" class="form-control" id="orderWeightMili" name="orderWeightMili[]" required="" value="0"></input></div></div><div class="row"><div class="form-group col-md-12"><label for="">Desing Detais</label><textarea style="resize:none;" class="form-control" id="orderDesignDetail" name="orderDesignDetail[]" required=""></textarea> </div></div>	' ) );
	$( "#question-group" ).attr('id', 'question-group1');
	$('html, body').animate({
		scrollTop: $("#question-group").offset().top
}, 2000);
	//$( ".option-group" ).closest( .nameDiv".question-group" ).after( $( '<p>hello</p>'));
	
}
function setData(){
	/*-------- SECCION DE VALIDACION DE NOMBRES -----------*/
    
    var nombreCompletado=0;                                             
    //comprobamos si se pulsa una tecla    
    $(".orderFirstName, .orderLastName").keyup(function(e){
        verificarMultiNombres($(this));               
    }); 
    
    
}
	function verificarMultiNombres(trigger){

        //obtenemos el texto introducido en el campo
        nombre = $(trigger).closest(".nameDiv").find(".orderFirstName").val();
        nombre2 = $(trigger).closest(".nameDiv").find(".orderLastName").val();
        //alert(nombre+" "+nombre2);                              
        //hace la búsqueda
        //$("#resultado").delay(1000).queue(function(n) {      
                                           
            $(trigger).closest(".nameDiv").find(".resultado").html('<img src="../img/ajax-loader.gif" />');
                                           
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
                        
                        $(trigger).closest(".nameDiv").find(".resultado").html("<span style='font-weight:bold;color:green;'>Customer found. <a href='javascript:void(0);' id='autofill' class='autofill'>Autofill the customer data</a></span>");
                        autofillMulti(nombre,nombre2,$(trigger));
                    }
                    else{
                        
                        $(trigger).closest(".nameDiv").find(".resultado").html("<span style='font-weight:bold;color:red;'>This customer name doesn't exists. A new customer will be created.</span>");
                    }                    
                }
            });           
                                           
        //});
    }
    function autofillMulti(b,c,trigger){
        $( ".autofill" ).click(function() {
        	$boton = trigger;
        	
            $boton.closest(".nameDiv").find(".resultado").html('<img src="../img/ajax-loader.gif" />');    
                                                 
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

                        $boton.closest(".nameDiv").find(".resultado").html(''); 
                        var res = data.split(",");  
                        $boton.closest(".multi").find(".orderTelephone").val(res[0]);
                        $boton.closest(".multi").find(".orderAddress").val(res[1]);
                        $boton.closest(".multi").find(".orderArea").val(res[2]);

                    }else{
                        alert("AJAX ERROR: Customer data not found");
                    }                    
                }
            });            
        });
    }
