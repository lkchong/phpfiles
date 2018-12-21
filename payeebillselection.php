<?php
	require "conn.php";
	
	$custID = $_POST["custID"];
	$payees = array();

	// Get payee list
	$sql = "SELECT customerpayeebill.bill_account_no, payeebill.payee_organization FROM customerpayeebill, payeebill WHERE customerpayeebill.cust_id = '$custID' AND customerpayeebill.payee_id = payeebill.payee_id";
	
	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($result)) {
		array_push($payees, $row);
	}

	// Storing payee list
	$response['payeeList'] = $payees;
	echo json_encode($response);

	mysqli_close($conn);
?>
