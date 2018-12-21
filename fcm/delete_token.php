<?php
	require "init.php";

	$fcm_username = $_POST["fcm_username"];

	$mysql_delete = "DELETE FROM fcm WHERE username = '$fcm_username'";
	$result = mysqli_query($conn, $mysql_delete);

	mysqli_close($conn);
?>