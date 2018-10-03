<?php
	require "conn.php";

	$custID = $_POST["custID"];
	$feedback_category = $_POST["feedbackCategory"];
	$feedback_rating = $_POST["feedbackRating"];
	$feedback_details = $_POST["feedbackDetails"];


	$mysql_qry = "CALL Submit_Feedback($custID, $feedback_category, $feedback_rating, $feedback_details)";

	$result = mysqli_query($conn, $mysql_qry);
	if(mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo $row['cust_id'];
		}
	}
	else {
		echo "Failed";
	}
?>