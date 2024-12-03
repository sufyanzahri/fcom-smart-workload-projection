<?php
include "conn/conn.php";
session_start();
if (empty($_SESSION['UserID']) && empty($_SESSION['Password'])) {
    header('location:index.php');
}
else
{

	$program_code = $_GET['program_code'];
	$session_id = $_GET['session_id'];

	// Check if projection exists for the specified program code and session ID
	$sqlWorkload = mysqli_query($conn, "SELECT * FROM projection WHERE program_code = '$program_code' AND session_id = '$session_id'");
	if (mysqli_num_rows($sqlWorkload) > 0) {
		echo 'exists'; // Return 'exists' if projection data is found
	} else {
		echo 'not_exists'; // Return 'not_exists' if no data is found
	}
}
?>
