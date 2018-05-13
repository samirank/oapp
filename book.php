<?php
session_start();
include('master/db.php');

if(isset($_GET['schedule_id'])){
	$schedule_id = $_GET['schedule_id'];
	$_SESSION['schedule_id'] = $schedule_id;
}
elseif (isset($_SESSION['schedule_id'])) {
	$schedule_id = $_SESSION['schedule_id'];
}
else{
	header("location: index.php");
}

if (!isset($_SESSION['log_id'])) {
	header("location: login.php");
}
else{
	if ($_SESSION['log_role']!='patient') {
		$_SESSION['msg']="Only patient can book appointment";
		unset($_SESSION['schedule_id']);
		header("location: dashboard.php");
	}else{
		$sql = "SELECT * FROM schedule WHERE schedule_id = $schedule_id";
		$result = mysqli_query($con,$sql);
		if (mysqli_num_rows($result)>0) {
			$row = mysqli_fetch_assoc($result);
		}else{
			die("Schedule does not exist");
		}

		// if(date('l')==$row['day']){
		// 	$date_of_appointment = date('d-m-y');
		// }else{
		$date = 'next '.$row['day'];
		$date_of_appointment = date('Y-m-d', strtotime($date));
		// }
		$patient_id = mysqli_query($con,"SELECT * from patients where user_id = {$_SESSION['log_id']}");
		$patient_id = mysqli_fetch_assoc($patient_id);
		$patient_id = $patient_id['patient_id'];
		$sql = "INSERT INTO `bookings` (`schedule_id`, `patient_id`, `date_of_booking`, `date_of_appointment`) VALUES ('$schedule_id', '$patient_id', now(), '$date_of_appointment')";
		if (mysqli_query($con,$sql)) {
			unset($_SESSION['schedule_id']);
			$_SESSION['msg'] = "Booking confirmed. Your booking id is".mysqli_insert_id($con);
			header("location: dashboard.php");
		}else{
			echo mysqli_error($con);
		}
	}
}
?>