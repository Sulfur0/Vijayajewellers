<?php  
    include '../backend/connection.php';
    if (isset($_GET["new"])) {
        $sql = "UPDATE FROM sales SET forsale='1' WHERE saleId='".$_GET["new"]."'";
        $conn ->query($sql);
    }

    else if (isset($_GET["old"])) {
        $sql = "UPDATE FROM sales SET forsale='1' WHERE saleId='"$_GET["old"]"'";
        $conn ->query($sql);
    }

    else if (isset($_GET["oldp"])) {
        $sql = "SELECT * FROM pawnings WHERE pawnId='"$_GET["old"]"'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $sql2 = "INSERT INTO sales (saleArticleName,saleWeight,forsale,goldStatus) VALUES('".$row["pawnArticleType"]."','".$row["pawnNetWeight"]."','1','1');";
        $conn ->query($sql2);

        $sql = "DELETE * FROM pawnings WHERE pawnId='"$_GET["old"]"'";
    }

?>