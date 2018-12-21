<?php
	require "conn.php";

	if (!$conn) {
		echo "Connection Failed";
	}
	else {
		echo "Connection Success";
	}
	
	mysqli_close($conn);
?>