<?php include '../include/layout-top-low.php'; ?>
<?php 
    include '../backend/connection.php';
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
 
    if (isset($_GET["billno"])){
        $sql = "SELECT * FROM pawnings WHERE forPawn='1' AND pawnBillNo='".$_GET["billno"]."'";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();
    }
    else if(isset($_POST["pawnBillNo"])){
        $sql = "SELECT * FROM pawnings WHERE forPawn='1' AND pawnBillNo='".$_POST["pawnBillNo"]."'";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();

        $warnings = $row["warning"] + 1;
        $warning_flag = 0;
        if ($warnings > 3){
            $warnings = 3;
            $warning_flag = 1;
        }
        $sql = "UPDATE pawnings SET warning='".$warnings."' WHERE pawnBillNO='".$_POST["pawnBillNo"]."'";
        $result = mysqli_query($conn, $sql);
    }
    else {
        //header("Location: pawning-list?error=1");
    }

    $name = $row["pawnFirstName"] . " " . $row["pawnLastName"];
    $print = "billno=" . $row["pawnBillNo"] . "&name=" . $name;
    $send = "billno=" . $row["pawnBillNo"] . "&name=" . $row["pawnFirstName"] . "&lastName=" . $row["pawnLastName"];

?>
<h3>Warning Letter</h3>
<form method="GET" action="../backend/pawnings/warning-letter.php">
	<div>
		<div class="row">
            <div class="col-md-8 table-responsive">                
                <?php if(isset($row)){ ?>
                <p>Dear <?php echo $name; ?><br>
                	Your pawn with Bill Number: <?php echo $row["pawnBillNo"];?><br>
                	Will be terminated soon, remember to redeem your article.
                </p>
                <?php }else if($_GET["billno"]=='sent'){ ?>
                <p>
                    The mail has been sent successfully
                </p>
                <?php }else{ ?>
                <p>
                    This pawn is already closed
                </p>
                <?php } ?>
            </div>            
            
        </div>
    </div>
    
    <?php if(isset($row)): ?>
	<div class="option-group">
        <div class="btn-group">
            <a href="print-warning-letter.php?<?php echo $print?>" class="btn btn-primary" id="action" target="_blank">Print</a>
            <a href="send-mail.php?<?php echo $send;?>" class="btn btn-primary" id="action">Send</a>
        </div>
    </div>
    <?php endif; ?>
</form>
<?php include '../include/layout-bottom-low.php'; ?>       