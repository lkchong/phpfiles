<?php
	require "conn.php";
	
	// Variable Declaration
	$custID = $_POST["custID"];
	$account = $_POST["accountName"];

	// Get account balance
	$sql_balance = "CALL Get_Balance('$custID', '$account')";
	
	$result_balance = mysqli_query($conn, $sql_balance);
		
	while ($row = mysqli_fetch_assoc($result_balance)) {
		$balance = $row['account_balance'];
	}

	$response['balance'] = $balance;

	// Get account transaction list
	require "conn.php";

	$transaction = array();

	$sql_transaction = "CALL Get_Transactions('$custID', '$account')";

	$result_transaction = mysqli_query($conn, $sql_transaction);

	// Storing transaction list in array
	while ($row = mysqli_fetch_assoc($result_transaction)) {
		array_push($transaction, $row);
	}

	// Encode as JSON format and echo
	$response['transaction_history'] = $transaction;
	echo json_encode($response);

	mysqli_close($conn);
?>