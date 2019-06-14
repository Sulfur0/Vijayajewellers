<?php
if($_SESSION["usuario"]==null){
    header("Location: ../index.php?fail=1&not-authorized=1");
}

if($_SESSION["privileges"]=='1'){
    echo "You are not allowed to view this page.";
    exit();
}
?>