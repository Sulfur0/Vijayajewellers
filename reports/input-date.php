<?php include '../include/layout-top-low.php'; ?>
<?php include '../include/check-who.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php 
$forward="";
if(isset($_GET['target']) && $_GET['target']=="sales"){
    $forward = 'sales-report.php?m=1';
}else if(isset($_GET['target']) && $_GET['target']=="pawnings"){
    $forward = 'pawns-report.php?m=1'; 
}    


?>
<h3>Please input a date</h3>
<form method="POST" id="myForm" action="<?php echo $forward; ?>">
	<div>
		<div class="row spaced">
            <div class="col-md-12">
                <div class="col-md-3 col-xs-12">
                    <input type="radio" name="target" class="target" value="m" /> Filter by month 
                </div>
                <div class="col-md-3 col-xs-12">
                    <input type="radio" name="target" class="target" value="y" /> Filter by year 
                </div>
                <div class="col-md-3 col-xs-12">
                    <input type="radio" name="target" class="target" value="r" /> Filter by year range 
                </div>
                <?php if(isset($_GET['target']) && $_GET['target']=="sales"){?>
                <div class="col-md-3 col-xs-12">
                    <input type="radio" name="target" class="target" value="a" /> Article wise filter 
                </div>
                <?php } ?>
                
            </div>            
            
            <div class="col-md-4"  id="filter-month">  
                <label>Select a month</label>              
                <select name="filter-month" class="form-control" >
                    <option value="" disabled selected="">Select a Month</option>
                    <option value="01">01 - January</option>
                    <option value="02">02 - February</option>
                    <option value="03">03 - March</option>
                    <option value="04">04 - April</option>
                    <option value="05">05 - May</option>
                    <option value="06">06 - June</option>
                    <option value="07">07 - July</option>                   
                    <option value="08">08 - August</option>
                    <option value="09">09 - September</option>
                    <option value="10">10 - October</option>
                    <option value="11">11 - November</option>
                    <option value="12">12 - December</option>
                </select>
            </div>           
            <div class="col-md-4" id="filter-from-year"> 
                <label>From year</label>               
                <input class="form-control" type="number" pattern=".{4}" name="filter-from-year">
            </div>            
            <div class="col-md-4" id="filter-to-year"> 
                <label>To year</label>               
                <input class="form-control" type="number" pattern=".{4}" name="filter-to-year">
            </div> 
            <div class="col-md-4" id="filter-year"> 
                <label>Input Year</label>               
                <input class="form-control" type="number" pattern=".{4}" name="filter-year" >
            </div> 
            <div class="col-md-4" id="filter-article"> 
                <label>Input article name or code</label>               
                <input class="form-control" type="text" name="filter-article" >
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
<script type="text/javascript">
//inicio todos los inputs escondidos
$( "#filter-month" ).hide( "slow", function() {});
$( "#filter-year" ).hide( "slow", function() {});
$( "#filter-to-year" ).hide( "slow", function() {});
$( "#filter-from-year" ).hide( "slow", function() {});
$( "#filter-article" ).hide( "slow", function() {});

//filtro segun el radio button
$('#myForm .target').on('change', function() {
    $radioVal = $('input[name=target]:checked', '#myForm').val();
    if($radioVal == 'm'){
        //MUESTRO MES Y AÑO EL RESTO LO ESCONDO
        $( "#filter-month" ).fadeIn( "slow", function() {});
        $( "#filter-year" ).fadeIn( "slow", function() {});
        $( "#filter-to-year" ).hide( "slow", function() {});
        $( "#filter-from-year" ).hide( "slow", function() {});
        $( "#filter-article" ).hide( "slow", function() {});
    }else if($radioVal == 'y'){
        //MUESTRO MES Y AÑO EL RESTO LO ESCONDO
        $( "#filter-month" ).hide( "slow", function() {});
        $( "#filter-year" ).fadeIn( "slow", function() {});
        $( "#filter-to-year" ).hide( "slow", function() {});
        $( "#filter-from-year" ).hide( "slow", function() {});
        $( "#filter-article" ).hide( "slow", function() {});
    }else if($radioVal == 'r'){
        //MUESTRO MES Y AÑO EL RESTO LO ESCONDO
        $( "#filter-month" ).hide( "slow", function() {});
        $( "#filter-year" ).hide( "slow", function() {});
        $( "#filter-to-year" ).fadeIn( "slow", function() {});
        $( "#filter-from-year" ).fadeIn( "slow", function() {});
        $( "#filter-article" ).hide( "slow", function() {});
    }else if($radioVal == 'a'){
        //MUESTRO MES Y AÑO EL RESTO LO ESCONDO
        $( "#filter-month" ).hide( "slow", function() {});
        $( "#filter-year" ).hide( "slow", function() {});
        $( "#filter-to-year" ).fadeIn( "slow", function() {});
        $( "#filter-from-year" ).fadeIn( "slow", function() {});
        $( "#filter-article" ).fadeIn( "slow", function() {});
    }
});

</script>
