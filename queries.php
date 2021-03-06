<?php include("master/db.php");

$flag = 0;
// Create users table
$sql = "CREATE TABLE `users` (
`user_id` int(11) NOT NULL AUTO_INCREMENT,
`user_name` varchar(50) NOT NULL,
`user_role` varchar(10) NOT NULL,
`password` varchar(100) NOT NULL, PRIMARY KEY (`user_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'users'"."<br>";
  $flag = 1;
}
$sql = "ALTER TABLE `users` CHANGE `user_role` `user_role` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
mysqli_query($con,$sql);
$sql = "ALTER TABLE `users` ADD UNIQUE(`user_name`);";
mysqli_query($con,$sql);


// Create Departments table
$sql = "CREATE TABLE `departments` (
`dept_id` int(11) NOT NULL AUTO_INCREMENT,
`dept_name` varchar(50) NOT NULL, PRIMARY KEY (`dept_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'departments'"."<br>";
  $flag = 1;
}


//Created lab table
$sql = "CREATE TABLE `lab_test` (
`lab_test_id` int(10) NOT NULL AUTO_INCREMENT,
`lab_test` varchar(100) NOT NULL, PRIMARY KEY (`lab_test_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
if (mysqli_query($con,$sql)) {
  echo "Created table name 'lab_test'"."<br>";
  $flag = 1;
}


// Create doctors table
$sql = "CREATE TABLE `doctors` ( `doc_id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `doc_name` VARCHAR(50) NOT NULL , `address` TEXT NOT NULL , `ph_no` VARCHAR(20) NOT NULL , `designation` VARCHAR(50) NOT NULL , `dept` INT NOT NULL , `exp` INT NOT NULL , `gender` VARCHAR(10) NOT NULL , PRIMARY KEY (`doc_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'doctors'"."<br>";
  $flag = 1;
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
  $flag = 1;
}
mysqli_query($con,"ALTER TABLE `patients` CHANGE `cur_medication` `cur_medication` CHAR(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'None'");

// Create Laboratorian table
$sql = "CREATE TABLE `laboratorian` (`laboratorian_id` int(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL, `name` varchar(50) NOT NULL, `email_id` varchar(50) NOT NULL,`ph_no` varchar(15) NOT NULL, PRIMARY KEY (`laboratorian_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1";
if (mysqli_query($con,$sql)) {
  echo "Created table name 'laboratorian'"."<br>";
  $flag = 1;
}

// Add profile pic in doctor
$sql = "ALTER TABLE `doctors` ADD `profile_pic` VARCHAR(50) NOT NULL DEFAULT 'images/profile/default.jpg' AFTER `gender`;";
if (mysqli_query($con,$sql)) {
  echo "Column name profile pic created"."<br>";
  $flag = 1;
}

// Schedule table
$sql = "CREATE TABLE `oapp`.`schedule` ( `schedule_id` INT NOT NULL AUTO_INCREMENT , `doc_id` INT NOT NULL , `day` VARCHAR(10) NOT NULL , `time_from` VARCHAR(10) NOT NULL , `time_to` VARCHAR(10) NOT NULL , PRIMARY KEY (`schedule_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
  echo "Created table name 'schedule'"."<br>";
  $flag = 1;
}


// Bookings Table
$sql = "CREATE TABLE `oapp`.`bookings` ( `booking_id` INT NOT NULL AUTO_INCREMENT , `schedule_id` INT NOT NULL , `patient_id` INT NOT NULL , `date_of_booking` DATE NOT NULL , `date_of_appointment` DATE NOT NULL , PRIMARY KEY (`booking_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
  echo "Created table name 'bookings'"."<br>";
  $flag = 1;
}


// Lab_booking table
$sql = "CREATE TABLE `oapp`.`lab_bookings` ( `booking_id` INT NOT NULL AUTO_INCREMENT , `patient_id` INT NOT NULL , `test_id` INT NOT NULL , `date_of_booking` INT NOT NULL , `date_of_test` INT NOT NULL , `status` INT NOT NULL , PRIMARY KEY (`booking_id`)) ENGINE = InnoDB";
if (mysqli_query($con,$sql)) {
  echo "Created table name 'lab_bookings'"."<br>";
  $flag = 1;
}
// Change lab_bookings datatypes
$sql = "ALTER TABLE `lab_bookings` CHANGE `date_of_booking` `date_of_booking` DATE NOT NULL, CHANGE `date_of_test` `date_of_test` DATE NOT NULL, CHANGE `status` `status` VARCHAR(20) NOT NULL;";
mysqli_query($con,$sql);
$sql = "ALTER TABLE `lab_bookings` CHANGE `status` `status` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'active'";
mysqli_query($con,$sql);

// Added status column to  bookings table
$sql = "ALTER TABLE `bookings` ADD `status` VARCHAR(10) NOT NULL DEFAULT 'active' AFTER `date_of_appointment`";
if (mysqli_query($con,$sql)) {
  echo "Added status column to 'bookings' table"."<br>";
  $flag = 1;
}

// Added status column to  users table
$sql = "ALTER TABLE `users` ADD `status` VARCHAR(20) NOT NULL DEFAULT 'active' AFTER `password`";
if (mysqli_query($con,$sql)) {
  echo "Added status column to 'users' table"."<br>";
  $flag = 1;
}


// Added Status to schedule table
$sql = "ALTER TABLE `schedule`  ADD `status` VARCHAR(10) NOT NULL DEFAULT 'active'  AFTER `time_to`";
if (mysqli_query($con,$sql)) {
  echo "Added status column to 'schedule' table"."<br>";
  $flag = 1;
}

// Added date of registration to users table
$sql = "ALTER TABLE `users` ADD `date_of_reg` DATE NULL DEFAULT NULL AFTER `password`";
if (mysqli_query($con,$sql)) {
  echo "Added date of registration to 'users' table"."<br>";
  $flag = 1;
}

// Added days to lab_test table
$sql = "ALTER TABLE `lab_test` ADD `days` VARCHAR(100) NULL AFTER `lab_test`";
if (mysqli_query($con,$sql)) {
  echo "Added days to 'lab_test' table"."<br>";
  $flag = 1;
}


// Message to show when nothing is changed/added to the database
if ($flag == 0) {
  echo "Nothing new to add";
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