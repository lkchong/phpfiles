<?php
	require "conn.php";

	// Variable Delclaration
	$senderAccNO = $_POST['senderAccNO'];
	$receiverAccNO = $_POST['receiverAccNO'];
	$transferAmount = $_POST['transferAmount'];
	$transctID = $_POST['transctID'];

	// Update payer account
	$mysql_update_payer = "UPDATE account SET account_balance = account_balance - '$transferAmount' WHERE account_no = '$senderAccNO'";
	$result1 = mysqli_query($conn, $mysql_update_payer);

	// Update payee account
	if($result1) {
		$mysql_update_payee = "UPDATE account SET account_balance = account_balance + '$transferAmount' WHERE account_no = '$receiverAccNO'";
		$result2 = mysqli_query($conn, $mysql_update_payee);
	}

	// Update Transaction
	if($result2) {
		$mysql_update_transct = "UPDATE transaction SET transc_status = 'Success' WHERE transc_id = '$transctID'";
		$result3 = mysqli_query($conn, $mysql_update_transct);
	}

	// Return Success
	if($result3) {
		echo "Success";
	}

	mysqli_close($conn);
?>