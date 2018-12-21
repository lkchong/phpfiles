<?php
	require "conn.php";

	$custID = $_POST['custID'];
	$bankName = $_POST['bankName'];
	$payeeAccountNO = $_POST['payeeAccountNO'];

	// Check if payee already exist in payee/account table
	if($bankName == "ABC Bank") { // Do this if bank is ABC Bank
		$mysql_check_payee_exist = "SELECT cust_id FROM account WHERE account_no = '$payeeAccountNO' AND cust_id != '$custID'";

		$result = mysqli_query($conn, $mysql_check_payee_exist);
	}
	else { // Do this if not ABC Bank
		$mysql_check_payee_exist = "SELECT payee_id FROM payee WHERE payee_account_no = '$payeeAccountNO'";

		$result = mysqli_query($conn, $mysql_check_payee_exist);
	}

	// Based on whether payee already in payee/account table do the following:
	if(mysqli_num_rows($result) > 0) { //Do this if in payee/account table
		if($bankName == "ABC Bank") { // Do this if ABC Bank
			while($row = mysqli_fetch_assoc($result)) {
				$payee_id = $row['cust_id'];
			}

			// Get payee name
			$mysql_get_name = "SELECT first_name, last_name FROM customer WHERE cust_id = '$payee_id'";

			$result_name = mysqli_query($conn, $mysql_get_name);
			
			while($row = mysqli_fetch_assoc($result_name)) {
				$payeeName = $row['first_name'] . " " . $row['last_name'];
			}

			// Check if exist in customerpayeeparent
			$mysql_check_customerpayeeparent_exist = "SELECT * FROM customerpayeeparent WHERE cust_id = '$custID' AND payee_id = '$payee_id' AND payee_account_no = '$payeeAccountNO'";

			$result = mysqli_query($conn, $mysql_check_customerpayeeparent_exist);

			if(mysqli_num_rows($result) > 0) { // Already exist in customerpayeeparent
				$response['result'] = "Exist";
				$response['payeeName'] = $payeeName;
				echo json_encode($response);
			}
			else { // Add to customerpayeeparent
				$mysql_insert_customerpayee = "INSERT INTO customerpayeeparent (cust_id, payee_id, payee_account_no) VALUES ('$custID', '$payee_id', '$payeeAccountNO')";
				$result = mysqli_query($conn, $mysql_insert_customerpayee);

				if($result) {
					$response['result'] = "Added";
					$response['payeeName'] = $payeeName;
					echo json_encode($response);
				}
			}
		}
		else { // If bank name not equal ABC Bank
			while($row = mysqli_fetch_assoc($result)) {
				$payee_id = $row['payee_id'];
			}

			// Get payee name
			$mysql_get_name = "SELECT payee_name FROM payee WHERE payee_id = '$payee_id'";

			$result_name = mysqli_query($conn, $mysql_get_name);
			
			while($row = mysqli_fetch_assoc($result_name)) {
				$payeeName = $row['payee_name'];
			}

			// Check if exist in customerpayee table
			$mysql_check_customerpayee_exist = "SELECT * FROM customerpayee WHERE payee_id = '$payee_id' AND cust_id = '$custID'";

			$result = mysqli_query($conn, $mysql_check_customerpayee_exist);

			if(mysqli_num_rows($result) > 0) { // Already exist in customerpayee
				$response['result'] = "Exist";
				$response['payeeName'] = $payeeName;
				echo json_encode($response);
			}
			else { // Add to customerpayee table
				$mysql_insert_customerpayee = "INSERT INTO customerpayee (cust_id, payee_id) VALUES ('$custID', '$payee_id')";
				$result = mysqli_query($conn, $mysql_insert_customerpayee);

				if($result) {
					$response['result'] = "Added";
					$response['payeeName'] = $payeeName;
					echo json_encode($response);
				}
			}
		}
	}
	else { //Do this if not in payee/account table
		$response['result'] = "Failed";
		echo json_encode($response);
	}

mysqli_close($conn);
?>