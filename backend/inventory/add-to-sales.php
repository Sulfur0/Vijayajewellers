<?php  
    include '../connection.php';
    if (isset($_GET["new"])) {
        $sql = "UPDATE sales SET forsale='1' WHERE saleId='".$_GET["new"]."'";
        mysqli_query($conn, $sql);
        header("Location: ../../inventory/new-gold.php?success=1&create=1");
    }

    else if (isset($_GET["old"])) {
        $sql = "UPDATE sales SET forsale='1' WHERE saleId='".$_GET["old"]."'";
        mysqli_query($conn,$sql);
        header("Location: ../../inventory/old-gold.php?success=1&create=1");
    }

    else if (isset($_GET["oldp"])) {
        $sql = "SELECT * FROM pawnings WHERE pawnId='".$_GET["oldp"]."'";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();

        $sql2 = "INSERT INTO sales (saleArticleName,saleWeight,forsale,goldStatus) VALUES('".$row["pawnArticleType"]."','".$row["pawnNetWeight"]."','1','0');";
        mysqli_query($conn, $sql2);

        $sql = "DELETE FROM pawnings WHERE pawnId='".$_GET["oldp"]."'";
        mysqli_query($conn, $sql);

        header("Location: ../../inventory/old-gold.php?success=1&create=1");
    }
?>