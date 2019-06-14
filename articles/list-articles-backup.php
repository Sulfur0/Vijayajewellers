<?php include '../include/layout-top-low.php'; ?>
<!-- Aqui va el contenido de la ventana principal -->
<?php
include '../backend/connection.php';

	$like = "";
	if (isset($_POST["search"]) && $_POST["search"] != "")
		$like = "WHERE articleName LIKE '" . $_POST["search"] . "'";

if(isset($_REQUEST["success"])){
	echo '<div class="alert alert-success alert-dismissable fade in">';
	echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
	if(isset($_REQUEST["close"])){
		echo '<strong>Success!</strong> The article has been removed succesfully.';
	}else if(isset($_REQUEST["create"])){
		echo '<strong>Success!</strong> The article has been created succesfully.';		
	}else if(isset($_REQUEST["update"])){
		echo '<strong>Success!</strong> The article has been updated succesfully.';
	}

	echo '</div>';
}
$orderby = "articleId";
$A_D = 0;
$typeOrder = "ASC";
$sort = -1;

if (isset($_GET["s"])) {
	$sort = $_GET["s"];
	if($_GET["a_d"] == 0) {
		$typeOrder = "DESC";
		$A_D = 1;
	}
}

if ($sort == 1)
	$orderby = "articleName";
?>
<h3>List of articles</h3>
<div class="table-responsive">
	<form action="list-articles.php?<?php echo $_SERVER['QUERY_STRING']; ?>" method="POST">
			<div class="question-group" id="question-group">
				<div class="col-md-3">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
			</div>
	</form>
	<br>
  	<table class="table">
		<tr>
			<td><a href="list-articles.php?s=1&a_d=<?php echo $A_D ?>"><b>Name</b></a></td>
			<td><b>Remove</b></td>
		
		<?php
		
		$sql = "SELECT * FROM articles ".$like." ORDER BY ".$orderby." ".$typeOrder." ";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) { 	

		        echo "<tr><td>" . $row["articleName"] . "</td>";
		        echo "<td> 
		        <a href='../backend/articles/remove-article.php?articleId=".$row["articleId"]."'><i class='fa fa-close fa-fw'></i></a></td></tr>";
		        
		    }
		} 
		else {
		    echo "0 results";
		}
		$conn->close();
		?>
	</table>		
</div>	
<?php include '../include/layout-bottom-low.php'; ?>     

