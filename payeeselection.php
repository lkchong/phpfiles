<?php
	require "conn.php";
	
	$custID = $_POST["custID"];
	$payees_others = array();
	$payees_same_bank = array();

	// Get other payee list
	$sql_others = "SELECT payee_name, payee_bank, payee_account_no FROM payee WHERE payee_id IN (SELECT payee_id FROM customerpayee WHERE cust_id = '$custID')";
	
	$result = mysqli_query($conn, $sql_others);

	while ($row = mysqli_fetch_assoc($result)) {
		array_push($payees_others, $row);
	}

	// Get same bank payee list
	$sql_same_bank = "SELECT customer.first_name, customer.last_name, customerpayeeparent.payee_account_no FROM customer, customerpayeeparent WHERE customer.cust_id = customerpayeeparent.payee_id AND customerpayeeparent.cust_id = '$custID'";

	$result = mysqli_query($conn, $sql_same_bank);

	while($row = mysqli_fetch_assoc($result)) {
		array_push($payees_same_bank, $row);
	}

	// Storing payee list to respective key value
	$response['payees_others'] = $payees_others;
	$response['payees_same_bank'] = $payees_same_bank;
	echo json_encode($response);

	mysqli_close($conn);
?>
