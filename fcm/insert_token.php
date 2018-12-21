<?php
	require "init.php";

	$fcm_token = $_POST["fcm_token"];
	$fcm_username = $_POST["fcm_username"];

	$mysql_check = "SELECT username FROM fcm WHERE username = '$fcm_username'";
	$result = mysqli_query($conn, $mysql_check);

	if(mysqli_num_rows($result) > 0) {
		$mysql = "UPDATE fcm  SET fcm_token = '".$fcm_token."' WHERE username = '$fcm_username'";
		mysqli_query($conn, $mysql);
	}
	else {
		$mysql = "INSERT INTO fcm  VALUES ('".$fcm_token."', '$fcm_username');";
		mysqli_query($conn, $mysql);
	}

	mysqli_close($conn);
?>