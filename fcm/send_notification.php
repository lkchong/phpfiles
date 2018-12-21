<?php

	require "init.php";

	$title = $_POST['title'];
	//$message = $_POST['message'];

	$username = $_POST['username'];
	//$transctID = $_POST['transctID'];
	$transctDetails = $_POST['transctDetails'];
	$transctAmount = $_POST['transctAmt'];
	//$transctDateTime = $_POST['transctDateTime'];
	$custID = '1';
	$accountNO = '1000001';
	$payeeID = '102';
	$payeeName = "Lazada";


	$mysql_qry = "INSERT INTO transaction (cust_id, account_no, transc_reference, transc_amount, payee_id, transc_status) VALUES ('$custID', '$accountNO', '$transctDetails', '$transctAmount', '$payeeID', 'Pending')";

	$result = mysqli_query($conn, $mysql_qry);

	if($result) {
		$mysql_qry = "SELECT transc_id, transc_datetime FROM transaction WHERE cust_id = '$custID' ORDER BY transc_datetime DESC LIMIT 1";
		$result = mysqli_query($conn, $mysql_qry);

		while ($row = mysqli_fetch_assoc($result)) {
			$transctID = $row['transc_id'];
			$transctDateTime = $row['transc_datetime'];
		}
	}


	$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
	$server_key = "AAAAReN2_Lc:APA91bHHA2RmLYxFmOlCp5wBhMZIZeY2N0TPd4tcP3zWtcICdWx0BUDfHECmXtAk41ujj7-r_9e16lmHALPNXlqSkR1c2bCfSJQgsyvEqJnNF5YXMQbn1jHIn2mq5nPGCaXWzmioRsOI";

	$mysql = "SELECT fcm_token FROM fcm WHERE username = '$username'";
	$result = mysqli_query($conn, $mysql);
	$row = mysqli_fetch_row($result);
	$key = $row[0];

	$headers = array(
				'Authorization:key=' .$server_key,
				'Content-Type:application/json');

	$fields = array('to'=>$key,
				   'data'=>array('title'=>$title, 'body'=>$transctDetails, 'transctID'=>$transctID, 'custID'=>$custID, 'accountNO'=>$accountNO, 'payeeID'=>$payeeID, 'transctAmount'=>$transctAmount, 'payeeName'=>$payeeName, 'transctDateTime'=>$transctDateTime));

	$payload = json_encode($fields);

	$curl_session = curl_init();

	curl_setopt($curl_session, CURLOPT_URL, $path_to_fcm);
	curl_setopt($curl_session, CURLOPT_POST, true);
	curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload);

	$result = curl_exec($curl_session);

	curl_close($curl_session);

	mysqli_close($conn);

	echo $transctID;
?>