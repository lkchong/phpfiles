<?php
	require "conn.php";
	
	$custID = $_POST["custID"];
	$accounts = array();
	$sql = "CALL Get_Accounts('$custID')";
	
	$result = mysqli_query($conn, $sql);
		
	while ($row = mysqli_fetch_assoc($result)) {
		array_push($accounts, $row);
	}

	$response['accounts'] = $accounts;
	echo json_encode($response);

	mysqli_close($conn);
?>
