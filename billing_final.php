<?php
	require "conn.php";

	// Variable Delclaration
	$accountNO = $_POST['accountNO'];
	$billOrganization = $_POST['billOrganization'];
	$billAmount = $_POST['billAmount'];
	$transctID = $_POST['transctID'];

	// Get billing organization account number
	$mysql_get_no = "SELECT payee_account_no FROM payeebill WHERE payee_organization = '$billOrganization'";
	$result = mysqli_query($conn, $mysql_get_no);

	while($row = mysqli_fetch_assoc($result)) {
		$payeeAccountNO = $row['payee_account_no'];
	}

	// Update payer account
	$mysql_update_payer = "UPDATE account SET account_balance = account_balance - '$billAmount' WHERE account_no = '$accountNO'";
	$result1 = mysqli_query($conn, $mysql_update_payer);

	// Update payee account
	if($result1) {
		$mysql_update_payee = "UPDATE payeebill SET payee_balance = payee_balance + '$billAmount' WHERE payee_account_no = '$payeeAccountNO'";
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