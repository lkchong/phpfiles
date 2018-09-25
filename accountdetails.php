<?php
	require "conn.php";
	
	$custID = $_POST["custID"];
	$account = $_POST["accountName"];

	//$custID = 1;
	//$account = "Saving Account 1";

	$sql_balance = "CALL Get_Balance('$custID', '$account')";
	
	$result_balance = mysqli_query($conn, $sql_balance);
		
	while ($row = mysqli_fetch_assoc($result_balance)) {
		$balance = $row['account_balance'];
	}

	$response['balance'] = $balance;


	require "conn.php";

	$transaction = array();

	$sql_transaction = "CALL Get_Transactions('$custID', '$account')";

	$result_transaction = mysqli_query($conn, $sql_transaction);

	while ($row = mysqli_fetch_assoc($result_transaction)) {
		array_push($transaction, $row);
	}

	$response['transaction_history'] = $transaction;

	echo json_encode($response);
	mysqli_close($conn);
?>