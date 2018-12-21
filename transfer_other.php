<?php
	require "conn.php";

	$custID = $_POST['custID'];
	$payeeBankName = $_POST['payeeBankName'];
	$receiverAccNO = $_POST['receiverAccNO'];
	$senderAccName = $_POST['senderAccName'];
	$paymentReference = $_POST['paymentReference'];
	$transferType = $_POST['transferType'];
	$transctAmount = $_POST['transctAmount'];

	// Get sender Account Number
	$mysql_qry_senderNO = "SELECT account_no FROM account WHERE cust_id = '$custID' AND account_name = '$senderAccName'";
	$result = mysqli_query($conn, $mysql_qry_senderNO);

	if($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$senderAccNO = $row['account_no'];
		}
	}

	// Get receiver ID
	if($payeeBankName == "ABC Bank") { // Do this if bankname is ABC Bank
		$mysql_qry_receiverNO = "SELECT cust_id FROM account WHERE account_no = '$receiverAccNO'";
		$result = mysqli_query($conn, $mysql_qry_receiverNO);

		if($result) {
			while ($row = mysqli_fetch_assoc($result)) {
				$receiverID = $row['cust_id'];
			}
		}
	}
	else { // Do this if bankname not ABC bank
		$mysql_qry_receiverNO = "SELECT payee_id FROM payee WHERE payee_account_no = '$receiverAccNO'";
		$result = mysqli_query($conn, $mysql_qry_receiverNO);

		if($result) {
			while ($row = mysqli_fetch_assoc($result)) {
				$receiverID = $row['payee_id'];
			}
		}
	}

	// Insert transaction
	$mysql_qry = "INSERT INTO transaction (cust_id, account_no, transc_reference, transc_amount, payee_id, payee_account_no, transc_status, transfer_type) VALUES ('$custID', '$senderAccNO', '$paymentReference', '$transctAmount', '$receiverID', '$receiverAccNO', 'Pending', '$transferType')";

	$result = mysqli_query($conn, $mysql_qry);

	sleep(0.25);

	// Get transaction id and datetime
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

	if($account_balance >= $transctAmount) {
		$response['result'] = "Success";
		$response['transctID'] = $transctID;
		$response['transctDateTime'] = $transctDateTime;
		$response['senderAccNO'] = $senderAccNO;
		echo json_encode($response);
	} else {
		$mysql_update_transct = "UPDATE transaction SET transc_status = 'Failed' WHERE transc_id = '$transctID'";
			$result = mysqli_query($conn, $mysql_update_transct);
		if($result) {
			echo "Failed";
		}
	}

	mysqli_close($conn);
?>