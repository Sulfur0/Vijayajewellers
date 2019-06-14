$('#oneMore').on('click',function(){

	
	insertDivs();

});
function insertDivs(){
	//objetos = buildSelect();	
	$( "#question-group" ).after( $( '<tr class="question-group" id="question-group"><td><input type="text" class="form-control" id="extraConcept" name="extraConcept[]" required="" value=""></input></td><td><input type="text" class="form-control" id="extraValue" name="extraValue[]" required="" value=""></input></td></tr> ' ) );
	$( "#question-group" ).attr('id', 'question-group1');
	$('html, body').animate({
        scrollTop: $("#question-group").offset().top
    }, 2000);
	//$( ".option-group" ).closest( ".question-group" ).after( $( '<p>hello</p>'));
	
}

 
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