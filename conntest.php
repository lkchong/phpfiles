<?php
require "conn.php";

if (!$conn) {
	echo "Connection Failed";
}
else {
	echo "Connection Success";
}

?>