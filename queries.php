<?php include("master/db.php");

// Create users table
$sql = "CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_role` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'users'"."<br>";
}else{
	echo "'users' table already exist"."<br>";
}

// Create Departments table
$sql = "CREATE TABLE `departments` (
`dept_id` int(11) NOT NULL,
`dept_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'departments'"."<br>";
}else{
	echo "'departments' table already exist"."<br>";
}

// Create doctors table
$sql = "CREATE TABLE `doctors` ( `doc_id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `doc_name` VARCHAR(50) NOT NULL , `address` TEXT NOT NULL , `ph_no` VARCHAR(20) NOT NULL , `designation` VARCHAR(50) NOT NULL , `dept` INT NOT NULL , `exp` INT NOT NULL , `gender` VARCHAR(10) NOT NULL , PRIMARY KEY (`doc_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'doctors'"."<br>";
}else{
	echo "'doctors' table already exist"."<br>";
}

// Create patients table
$sql = "CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `mobileno` varchar(15) NOT NULL,
  `guardian` varchar(50) NOT NULL,
  `emergencycontact` int(11) NOT NULL,
  `gender` char(10) NOT NULL,
  `bgroup` varchar(5) NOT NULL,
  `cur_medication` char(5) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `user_id` varchar(15) NOT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'patients'"."<br>";
}else{
	echo "'patients' table already exist"."<br>";
}


// Add profile pic in doctor
$sql = "ALTER TABLE `doctors` ADD `profile_pic` VARCHAR(50) NOT NULL DEFAULT 'images/profile/default.jpg' AFTER `gender`;";
if (mysqli_query($con,$sql)) {
  echo "Column name profile pic created"."<br>";
}else{
  echo mysqli_error($con)."<br>";
}

// Schedule table
$sql = "CREATE TABLE `oapp`.`schedule` ( `schedule_id` INT NOT NULL AUTO_INCREMENT , `doc_id` INT NOT NULL , `day` VARCHAR(10) NOT NULL , `time_from` VARCHAR(10) NOT NULL , `time_to` VARCHAR(10) NOT NULL , PRIMARY KEY (`schedule_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
  echo "Created table name 'schedule'"."<br>";
}else{
  echo "'schedule' table already exist"."<br>";
}


// Bookings Table
$sql = "CREATE TABLE `oapp`.`bookings` ( `booking_id` INT NOT NULL AUTO_INCREMENT , `schedule_id` INT NOT NULL , `patient_id` INT NOT NULL , `date_of_booking` DATE NOT NULL , `date_of_appointment` DATE NOT NULL , PRIMARY KEY (`booking_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
  echo "Created table name 'bookings'"."<br>";
}else{
  echo "'bookings' table already exist"."<br>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
  <div style="background: url(images/about.jpg) no-repeat; background-position: center; background-size: contain; height: 500px;"></div>
</body>
</html>