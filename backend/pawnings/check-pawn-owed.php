<?php
    session_start();
    if($_SESSION["usuario"]==null){
        header("Location: ../../index.php?fail=1&not-authorized=1");
    }
    $pawn = $_POST['b'];      
       
    if(!empty($pawn)) {
        comprobar($pawn);
    }      
       
    function comprobar($b) {
        include '../connection.php';
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }           
        $sql = mysqli_query($conn,"SELECT pawnOwed,pawnPaid,pawnAmount FROM pawnings WHERE pawnId = '".$b."'");
             
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $pawnOwed = (float) $row["pawnOwed"]*1;
        $pawnAmount = (float) $row["pawnAmount"]*1;
        $pawnPaid = (float) $row["pawnPaid"]*1;

        $resultado = $pawnOwed+$pawnAmount-$pawnPaid*1;
        echo $resultado;
        
    }    
?>