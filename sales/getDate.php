<?php 
$sql = "SELECT timezone FROM config";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
date_default_timezone_set($row["timezone"]);
$date = date('Y-m-d H:i:s', time());
echo $date;
?>