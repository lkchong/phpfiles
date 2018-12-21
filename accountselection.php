<?php
	require "conn.php";
	
	// Variable Declaration
	$custID = $_POST["custID"];
	$accounts = array();

	// Calling stored procedure to obtain account list
	$sql = "CALL Get_Accounts('$custID')";
	
	// Performing query
	$result = mysqli_query($conn, $sql);
	
	// Storing query result in array
	while ($row = mysqli_fetch_assoc($result)) {
		array_push($accounts, $row);
	}
	
	// Storing account list into response variable with key = accounts
	// encode into json and echo
	$response['accounts'] = $accounts;
	echo json_encode($response);

	mysqli_close($conn);
?>
