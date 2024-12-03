<?php
include "conn/conn.php";
error_reporting(0);
session_start();
if (empty($_SESSION['UserID']) AND empty($_SESSION['Password']))
{
  header('location:index.php');
}
else
{
	$course_code = $_POST['course_code'];
	$prerequisite = $_POST['prerequisite'];

	$sql = mysqli_query($conn, "UPDATE course SET prerequisite = '$prerequisite' WHERE course_code = '$course_code'");
		
	header('location:manage_course.php?act=assigned&course_code=' . $course_code);

}

?>