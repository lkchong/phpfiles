<?php
	require "conn.php";

	// Variables Declaration
	$senderAccNO = $_POST['senderAccNO'];
	$receiverAccNO = $_POST['receiverAccNO'];
	$receiverBank = $_POST['receiverBank'];
	$transferAmount = $_POST['transferAmount'];
	$transctID = $_POST['transctID'];

	// Update payer account
	$mysql_update_payer = "UPDATE account SET account_balance = account_balance - '$transferAmount' WHERE account_no = '$senderAccNO'";
	$result1 = mysqli_query($conn, $mysql_update_payer);

	// Update payee account
	if($result1) { // Do this if ABC bank
		if($receiverBank == "ABC Bank") {
			$mysql_update_payee = "UPDATE account SET account_balance = account_balance + '$transferAmount' WHERE account_no = '$receiverAccNO'";
			$result2 = mysqli_query($conn, $mysql_update_payee);
		}
		else { // Do this if other bank
			$mysql_update_payee = "UPDATE payee SET payee_balance = payee_balance + '$transferAmount' WHERE payee_account_no = '$receiverAccNO'";
			$result2 = mysqli_query($conn, $mysql_update_payee);
		}
	}

	// Update transaction record
	if($result2) {
		$mysql_update_transct = "UPDATE transaction SET transc_status = 'Success' WHERE transc_id = '$transctID'";
		$result3 = mysqli_query($conn, $mysql_update_transct);
	}

	if($result3) {
		echo "Success";
	}

	mysqli_close($conn);
?>