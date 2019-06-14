<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM orders WHERE orderId='".$_GET["orderId"]."'";	
    //echo $sql;
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();

      	
?>
<h3>Update order</h3>
<p>Fill in the fields to update an existing order</p>
<form method="POST" action="../backend/orders/update-order.php">
	<div class="question-group" id="question-group">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Delivery Date (format: Y/m/d hr/min/sec, I.E. 2017-06-30 10:22:56)</label>
                <?php
                $sql2 = "SELECT timezone FROM config";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = $result2->fetch_assoc();
                date_default_timezone_set($row2["timezone"]);
                $date = date('Y/m/d h:i:s', time()); 
                ?>
                <input type="text" class="form-control" id="orderDeliveryDate" name="orderDeliveryDate" required="" value="<?php echo $date; ?>"></input>         
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Bill Number</label>
                <input type="number" step="0.01" class="form-control" id="orderBillNo" name="orderBillNo" required="" value="<?php echo $row['orderBillNo']; ?>"></input>
            </div> 
            <div class="form-group col-md-4">
                <label for="">First Name</label>
                <input type="text" class="form-control" id="    orderFirstName" name="  orderFirstName" required="" value="<?php echo $row['orderFirstName']; ?>"></input>            
            </div>        
            <div class="form-group col-md-4">
                <label for="">Last Name</label>
                <input type="text" class="form-control" id="orderLastName" name="orderLastName" required="" value="<?php echo $row['orderLastName']; ?>"></input>            
            </div>
        </div>
        <div class="row">
        
            <div class="form-group col-md-4">
                <label for="">Address</label>
                <input type="text" class="form-control" id="orderAddress" name="orderAddress" required="" value="<?php echo $row['orderAddress']; ?>"></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Telephone</label>
                <input type="text" class="form-control" id="orderTelephone" name="orderTelephone" required="" value="<?php echo $row['orderTelephone']; ?>"></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Cost</label>
                <input type="number" class="form-control" id="orderCost" name="orderCost" required="" value="<?php echo $row['orderCost']; ?>"></input>            
            </div>

        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Advance Being Paid</label>
                <input type="number" step="0.01" class="form-control" id="orderAdvance" name="orderAdvance" required="" value="<?php echo $row['orderAdvance']; ?>"></input>            
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Design Requirements</label>
                <textarea style="resize:none;" class="form-control" id="orderDesignDetail" name="orderDesignDetail" required="" ><?php echo $row['orderDesignDetail']; ?></textarea> 
            </div>
        </div>
            
    </div>
    <input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET["orderId"]; ?>">
	<button class="btn btn-info" id="action">Update</button>
</form>
<?php include '../include/layout-bottom-low.php'; ?>       

