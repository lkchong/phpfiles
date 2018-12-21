<?php
	require "conn.php";

	$transctID = $_POST['transctID'];

	$mysql_update_transct = "UPDATE transaction SET transc_status = 'Canceled' WHERE transc_id = '$transctID'";

	$result = mysqli_query($conn, $mysql_update_transct);

	if($result) {
		echo "Success";
	}

	mysqli_close($conn);
?>