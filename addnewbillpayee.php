<?php
	require "conn.php";

	$custID = $_POST['custID'];
	$billPayeeName = $_POST['billPayeeName'];
	$billAccountNO = $_POST['billAccountNO'];

	// Get payee_id
	$mysql_get_payeeID = "SELECT payee_id FROM payeebill WHERE payee_organization = '$billPayeeName'";
	$result = mysqli_query($conn, $mysql_get_payeeID);

	while ($row = mysqli_fetch_assoc($result)) {
		$payeeID = $row['payee_id'];
	}

	// Check if payee_id and bill_account_no pair exist in payeebillcustomer
	$mysql_check_payeebillcustomer_exist = "SELECT * FROM payeebillcustomer WHERE payee_id = '$payeeID' AND bill_account_no = '$billAccountNO'";

	$result = mysqli_query($conn, $mysql_check_payeebillcustomer_exist);

	if(mysqli_num_rows($result) > 0) { // Record exist in payeebillcustomer
		// Check if record exist in customerpayeebill
		$mysql_check_customerpayeebill_exist = "SELECT * FROM customerpayeebill WHERE cust_id = '$custID' AND payee_id = '$payeeID' AND bill_account_no = '$billAccountNO'";
		$result = mysqli_query($conn, $mysql_check_customerpayeebill_exist);

		if(mysqli_num_rows($result) > 0) { // Record already exist in customerpayeebill
			echo "Exist";
		}
		else { // Record does not exist in customerpayeebill
			// Insert record into customerpayeebill
			$mysql_insert = "INSERT INTO customerpayeebill (cust_id, payee_id, bill_account_no) VALUES ($custID, $payeeID, $billAccountNO)";
			$result = mysqli_query($conn, $mysql_insert);

			if($result) {
				echo "Added";
			}
		}
	}
	else { // Record does not exist in payeebillcustomer
		echo "Failed";
	}

mysqli_close($conn);
?>