$('#oneMore').on('click',function(){

	cambiarClaseFecha();
	cambiarClaseBill();
	insertDivs();
	popularFecha();

});

function insertDivs(){
	//objetos = buildSelect();	
	$( "#question-group" ).after( $( '<div class="question-group" id="question-group"><div class="row"><div class="form-group col-md-4 col-xs-12"><label for="">Article Name</label><input type="text" class="form-control" id="saleArticleName" name="saleArticleName[]" required=""></input></div><div id="resultado" class="col-md-6 col-xs-12"></div></div><div class="row"><div class="form-group col-md-4 col-xs-12"><label for="">Article Code</label><input type="text" class="form-control" id="saleArticleCode" name="saleArticleCode[]" required=""></input></div><div class="form-group col-md-4 col-xs-12"><label for="">Article Gold Weight (gram)</label><input type="number" step="0.01" class="form-control" id="saleWeight" name="saleWeight[]" required="" value="0"></input></div><div class="form-group col-md-4 col-xs-12"><label for="">Article Gold Weight (milligram)</label><input type="number" step="0.01" class="form-control" id="saleWeightMili" name="saleWeightMili[]" required="" value="0"></input></div></div><div id="prices"><div class="row"><div class="form-group col-md-4 col-xs-12"><label for="">Labor</label><input type="number" step="0.01" class="form-control" id="saleLabor" name="saleLabor[]" required="" value="0"></input></div><div class="form-group col-md-4 col-xs-12"><label for="">Loss of Gold</label><input type="number" step="0.01" class="form-control" id="saleLossGold" name="saleLossGold[]" required="" value="0"></input></div><div class="form-group col-md-4 col-xs-12"><label for="">Final Price</label><input type="number" step="0.01" class="form-control" id="saleFinalPrice" name="saleFinalPrice[]" value="0"></input></div></div></div><div class="row"><div class="form-group col-md-8 col-xs-12"><label for="">Extra Details</label><input type="text" class="form-control" id="saleDetail" name="saleDetail[]" required="" value=""></input></div><div class="form-group col-md-4 col-xs-12"><label for="">Sale Date</label><input type="text" class="form-control saleDateTime" id="saleDateTime" name="saleDateTime[]" required="" value=""></input></div></div><div class="row"><div class="form-group col-md-4"><label for="exchange">Exchange</label><input type="checkbox" class="exchangeCB" name="exchangeCB" id="exchangeCB" value="exchangeCB"> This sale was an exchange</div></div><div class="row"><div id="exchangeDiv" style="display: none;"><div class="col-md-4"><label for="exchange" id="exchangelbl">Exchange Article Name</label><input type="text" class="form-control" id="saleExchArticle" name="saleExchArticle[]" maxlength="10"></input></div><div class="col-md-4"><label for="exchange" id="exchangelbl">Exchange Article Weight</label><input type="number" step="0.01" class="form-control" id="saleExchWeight" name="saleExchWeight[]" maxlength="10"></input></div><div class="col-md-4"><label for="exchange" id="exchangelbl">Exchange Value</label><input type="number" step="0.01" class="form-control" id="saleExchange" name="saleExchange[]" maxlength="10"></input></div></div></div></div><hr>' ) );
	$( "#question-group" ).attr('id', 'question-group1');
	$('html, body').animate({
        scrollTop: $("#question-group").offset().top
    }, 2000);
	//$( ".option-group" ).closest( ".question-group" ).after( $( '<p>hello</p>'));
	
}
function cambiarClaseFecha(){
	$(".saleDateTime").attr('class', 'form-control');
}
function cambiarClaseBill(){
	$(".saleBillNo").attr('class', 'form-control');
}
function popularFecha(){
	$.get("../sales/getDate.php", function(data, status){
            //alert("Data: " + data + "\nStatus: " + status);
            $(".saleDateTime").val(data);
        });	
}
function popularFecha(){
	$.get("../sales/getDate.php", function(data, status){
            //alert("Data: " + data + "\nStatus: " + status);
            $(".saleDateTime").val(data);
        });	
}
var consulta;

     
/*
function buildSelect(){
	options="";
	var opts = document.getElementById('catId').options;	
	for (var i = opts.length - 1; i >= 0; i--) {
		options+="<option value='" + opts[i].value + "'>" + opts[i].text + "</option>";
	}
	return options;
	//alert(options);
}
*/