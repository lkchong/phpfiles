<?php
	require "conn.php";

	$custID = $_POST['custID'];
	$accountNO = $_POST['accountNO'];
	$billOrganization = $_POST['billOrganization'];
	$billAccountNO = $_POST['billAccountNO'];
	$billAmount = $_POST['billAmount'];
	$transferType = $_POST['transferType'];

	// Get payee ID and account number
	$mysql_qry_payeeID = "SELECT payee_id, payee_account_no FROM payeebill WHERE payee_organization = '$billOrganization'";
	$result = mysqli_query($conn, $mysql_qry_payeeID);

	if($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$payeeID = $row['payee_id'];
			$payeeAccountNO = $row['payee_account_no'];
		}
	}

	// Insert transaction
	$mysql_qry = "INSERT INTO transaction (cust_id, account_no, transc_reference, transc_amount, payee_id, payee_account_no, transc_status, transfer_type) VALUES ('$custID', '$accountNO', '$billAccountNO', '$billAmount', '$payeeID', '$payeeAccountNO', 'Pending', '$transferType')";

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
	$mysql_balance = "SELECT account_balance FROM account WHERE account_no = '$accountNO'";
	$result = mysqli_query($conn, $mysql_balance);

	while ($row = mysqli_fetch_assoc($result)) {
		$account_balance = $row['account_balance'];
	}

	if($account_balance >= $billAmount) { // Do this if account balance >= bill amount
		$response['result'] = "Success";
		$response['transctID'] = $transctID;
		$response['transctDateTime'] = $transctDateTime;
		echo json_encode($response);
	} else { // Do this if account balance < bill amount
		$mysql_update_transct = "UPDATE transaction SET transc_status = 'Failed' WHERE transc_id = '$transctID'";
			$result = mysqli_query($conn, $mysql_update_transct);
		if($result) {
			echo "Failed";
		}
	}

	mysqli_close($conn);
?>