<?php
session_start();
if (isset($_GET['schedule_id'])) {

	if (!isset($_SESSION['log_id'])) {
		$_SESSION['schedule_id'] = $_GET['schedule_id'];
		header("location: login.php");
	}

	if($_SESSION['log_role']!='patient'){
		$_SESSION['msg'] = "You are not patient.";
		header("location: dashboard.php");
	}else{
		
	}
	
}else{
	header("location: index.php");
}

?>