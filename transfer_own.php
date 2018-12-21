<?php
	require "conn.php";

	// Variable Declaration
	$custID = $_POST['custID'];
	$senderAccNO = $_POST['senderAccNO'];
	$receiverAccNO = $_POST['receiverAccNO'];
	$senderAccName = $_POST['senderAccName'];
	$receiverAccName = $_POST['receiverAccName'];
	$paymentReference = $_POST['paymentReference'];
	$transctAmount = $_POST['transctAmount'];

	// Insert transaction
	$mysql_qry = "INSERT INTO transaction (cust_id, account_no, transc_reference, transc_amount, self_account, transc_status, transfer_type) VALUES ('$custID', '$senderAccNO', '$paymentReference', '$transctAmount', '$receiverAccNO', 'Pending', 'Self')";

	$result = mysqli_query($conn, $mysql_qry);

	sleep(0.25);

	// Get transaction ID and transaction date and time
	if($result) {
		$mysql_qry = "SELECT transc_id, transc_datetime FROM transaction WHERE cust_id = '$custID' ORDER BY transc_datetime DESC LIMIT 1";
		$result = mysqli_query($conn, $mysql_qry);

		while ($row = mysqli_fetch_assoc($result)) {
			$transctID = $row['transc_id'];
			$transctDateTime = $row['transc_datetime'];
		}
	}

	// Check Balance
	$mysql_balance = "SELECT account_balance FROM account WHERE account_no = '$senderAccNO'";
	$result = mysqli_query($conn, $mysql_balance);

	while ($row = mysqli_fetch_assoc($result)) {
		$account_balance = $row['account_balance'];
	}

	// If account balance more than transaction amount
	if($account_balance >= $transctAmount) {
		$response['result'] = "Success";
		$response['transctID'] = $transctID;
		$response['transctDateTime'] = $transctDateTime;
		echo json_encode($response);
	} else { // If account balance less than transaction amount
		$mysql_update_transct = "UPDATE transaction SET transc_status = 'Failed' WHERE transc_id = '$transctID'";
			$result = mysqli_query($conn, $mysql_update_transct);
		if($result) {
			echo "Failed";
		}
	}

	mysqli_close($conn);
?>