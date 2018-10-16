<?php
	require "init.php";

	$fcm_token = $_POST["fcm_token"];

	$mysql = "INSERT INTO fcm  VALUES ('".$fcm_token."');";

	mysqli_query($conn, $mysql);
	mysqli_close($conn);
?>