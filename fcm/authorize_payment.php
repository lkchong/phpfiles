<?php
	require "init.php";

	// Variable Declaration
	$custID = $_POST['custID'];
	$transctID = $_POST['transctID'];
	$accountNO = $_POST['accountNO'];
	$payeeID = $_POST['payeeID'];
	$transctAmount = $_POST['transctAmount'];

	// Check account balance
	$mysql_balance = "SELECT account_balance FROM account WHERE account_no = '$accountNO'";
	$result = mysqli_query($conn, $mysql_balance);

	while ($row = mysqli_fetch_assoc($result)) {
		$account_balance = $row['account_balance'];
	}

	// Proceed based on account balance
	if($account_balance >= $transctAmount) { // If account balance greater than transaction amount
		
		// Update payer account
		$mysql_update_payer = "UPDATE account SET account_balance = account_balance - '$transctAmount' WHERE account_no = '$accountNO'";
		$result1 = mysqli_query($conn, $mysql_update_payer);

		// Update payee account
		if($result1) {
			$mysql_update_payee = "UPDATE payee SET payee_balance = payee_balance + '$transctAmount' WHERE payee_id = '$payeeID'";
			$result2 = mysqli_query($conn, $mysql_update_payee);
		}

		// Update transaction record
		if($result2) {
			$mysql_update_transct = "UPDATE transaction SET transc_status = 'Success' WHERE transc_id = '$transctID'";
			$result3 = mysqli_query($conn, $mysql_update_transct);
		}

		if($result3) {
			echo "Success";
		}
	} else { // If account balance less than transaction amount
		// Update transaction record
		$mysql_update_transct = "UPDATE transaction SET transc_status = 'Failed' WHERE transc_id = '$transctID'";
			$result = mysqli_query($conn, $mysql_update_transct);
		if($result) {
			echo "Failed";
		}
	}

	mysqli_close($conn);
?>