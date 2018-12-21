<?php
	require "conn.php";

	$custID = $_POST['custID'];
	//$senderAccName = $_POST['senderAccName'];
	$receiverAccName = $_POST['receiverAccName'];
	//$paymentReference = $_POST['paymentReference'];
	//$transferType = $_POST['transferType'];
	//$transctAmount = $_POST['transctAmount'];

	// Get receiver bank name
	$mysql_qry_receiverNO = "SELECT payee_bank FROM payee WHERE payee_name = '$receiverAccName' AND payee_id IN (SELECT payee_id FROM customerpayee WHERE cust_id = '$custID')";
	$result = mysqli_query($conn, $mysql_qry_receiverNO);

	if($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$receiverBankName = $row['payee_bank'];
		}
		echo $receiverBankName;
	}

	mysqli_close($conn);
?>