<?php
	require "init.php";

	$message = $_POST['message'];
	$title = $_POST['title'];
	$info1 = $_POST['info1'];
	$info2 = $_POST['info2'];
	$path_to_fcm = 'https://fcm.googleapis.com/fcm/send';
	$server_key = "AAAAReN2_Lc:APA91bHHA2RmLYxFmOlCp5wBhMZIZeY2N0TPd4tcP3zWtcICdWx0BUDfHECmXtAk41ujj7-r_9e16lmHALPNXlqSkR1c2bCfSJQgsyvEqJnNF5YXMQbn1jHIn2mq5nPGCaXWzmioRsOI";

	$mysql = "SELECT fcm_token FROM fcm";
	$result = mysqli_query($conn, $mysql);
	$row = mysqli_fetch_row($result);
	$key = $row[0];

	$headers = array(
				'Authorization:key=' .$server_key,
				'Content-Type:application/json');

	$fields = array('to'=>$key,
				   'data'=>array('title'=>$title, 'body'=>$message, 'info1'=>$info1, 'info2'=>$info2));

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
?>