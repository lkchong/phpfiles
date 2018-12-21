<?php

	require "init.php";

	$transctID = $_POST['transctID'];

	$mysql_trans_status = "SELECT transc_status FROM transaction WHERE transc_id = '$transctID'";

	$result = mysqli_query($conn, $mysql_trans_status);
	while ($row = mysqli_fetch_assoc($result)) {
		$transc_status = $row['transc_status'];
	}

	mysqli_close($conn);

	echo $transc_status;
?>