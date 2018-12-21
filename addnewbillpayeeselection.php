<?php
	require "conn.php";
	
	$payees = array();

	// Get payee list
	$sql_others = "SELECT payee_organization FROM payeebill";
	
	$result = mysqli_query($conn, $sql_others);

	while ($row = mysqli_fetch_assoc($result)) {
		array_push($payees, $row);
	}

	// Storing payee list to respective key value
	$response['payees'] = $payees;
	echo json_encode($response);

	mysqli_close($conn);
?>
