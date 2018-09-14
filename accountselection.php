<?php
	require "conn.php";
	
	$pdo = new PDO("mysql:host=$server_name;dbname=$db_name", $mysql_username, $mysql_password);
	
	$sql = 'CALL Get_Saving_Accounts()';
	
	$result = $pdo->query($sql);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	
	while($values= $result->fetch()) {
		print "<pre>";
		print_r($values);
	}
?>