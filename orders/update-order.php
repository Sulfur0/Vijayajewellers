<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
   	include '../backend/connection.php';
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "SELECT * FROM orders WHERE orderBillNo='".$_POST["orderBillNo"]."'";	
    //echo $sql;
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();

	mysqli_close($conn);       	
?>
<?php if (!isset($_GET['deliver'])): ?>
<h3>Edit Order</h3>
<p>Fill in the fields to update an existing order</p>
<form method="POST" action="../backend/orders/update-order.php">
	<div class="question-group" id="question-group">

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Delivery Date (format: Y/m/d hr/min/sec, I.E. 2017-06-30 10:22:56)</label>
                
                <?php
                $sql = "SELECT timezone FROM config";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                date_default_timezone_set($row["timezone"]);
                $date = date('Y/m/d h:i:s', time()); 
                ?>
                <input type="text" class="form-control" id="orderDeliveryDate" name="orderDeliveryDate" required="" value="<?php echo $date; ?>"></input>         
            </div>
            
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="">First Name</label>
                <input type="text" class="form-control" id="orderFirstName" name="orderFirstName" required="" value="<?php echo $row['orderFirstName']; ?>"></input>            
            </div>
        
            <div class="form-group col-md-4">
                <label for="">Last Name</label>
                <input type="text" class="form-control" id="orderLastName" name="orderLastName" required="" value="<?php echo $row['orderLastName']; ?>"></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Address</label>
                <input type="text" class="form-control" id="orderAddress" name="orderAddress" required="" value="<?php echo $row['orderAddress']; ?>"></input>            
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Telephone</label>
                <input type="text" class="form-control" id="orderTelephone" name="orderTelephone" required="" value="<?php echo $row['orderTelephone']; ?>"></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Cost</label>
                <input type="number" class="form-control" id="orderCost" name="orderCost" required="" value="<?php echo $row['orderCost']; ?>"></input>            
            </div>

            <div class="form-group col-md-4">
                <label for="">Advance Being Paid</label>
                <input type="number" step="0.01" class="form-control" id="orderAdvance" name="orderAdvance" required="" value="<?php echo $row['orderAdvance']; ?>"></input>            
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="">Quality</label>
                <input type="number" step="0.01" class="form-control" id="orderQuality" name="orderQuality" required="" value="<?php echo $row['orderQuality']; ?>"></input> 
            </div>
            <div class="form-group col-md-4">
                <label for="">Weigh</label>
                <input type="number" step="0.01" class="form-control" id="orderWeight" name="orderWeight" required="" value="<?php echo $row['orderWeight']; ?>"></input> 
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Design Requirements</label>
                <textarea style="resize:none;" class="form-control" id="orderDesignDetail" name="orderDesignDetail" required="" ><?php echo $row['orderDesignDetail']; ?></textarea> 
            </div>
        </div>
            
    </div>
    <input type="hidden" name="orderBillNo" id="orderBillNo" value="<?php echo $_POST["orderBillNo"]; ?>">
	<button class="btn btn-info" id="action">Update</button>
</form>
<?php endif; ?>

<?php if(isset($_GET['deliver'])): ?>

<h3>Deliver Order</h3>
<form method="POST" action="../backend/orders/update-order.php">
    <div class="table-responsive">
        <table class="table">
            <tr>
                <td><b>Bill Number</b></td><td><b>Delivery Date</b></td><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Telephone</b></td><td><b>Address</b></td>
            </tr>
            <tr>
                <?php
                    echo "<td>" . $row["orderBillNo"] . "</td><td>" . $row["orderDeliveryDate"] . "</td><td>" . $row["orderFirstName"] . "</td><td>" . $row["orderLastName"]. "</td><td>" . $row["orderTelephone"] . "</td><td>" . $row["orderAddress"] . "</td>";
                ?>
            </tr>
        </table>
    </div>
    <label for="">
       Deliver <button class="btn btn-primary fa fa-check"></button>
    </label>
    <input type="hidden" name="deliver-order" id="deliver-order" value="1">
    <input type="hidden" name="orderBillNo" id="orderBillNo" value="<?php echo $_POST["orderBillNo"]; ?>">
</form>

<?php endif; ?>
<?php include '../include/layout-bottom-low.php'; ?>