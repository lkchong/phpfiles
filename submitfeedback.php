<?php
	require "conn.php";

	// Variable Declaration
	$custID = $_POST["custID"];
	$feedback_category = $_POST["feedbackCategory"];
	$feedback_rating = $_POST["feedbackRating"];
	$feedback_details = $_POST["feedbackDetails"];

	// Calling stored procedure for feedback submission
	$mysql_qry = "CALL Submit_Feedback('$custID', '$feedback_category', '$feedback_rating', '$feedback_details')";

	$result = mysqli_query($conn, $mysql_qry);
	if($result) {
		echo "Success";
	}
	else {
		echo "Failed";
	}
?>