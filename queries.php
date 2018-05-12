<?php include("master/db.php");

// Create users table
$sql = "CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_role` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'users'";
}else{
	echo "'users' table already exist";
}

// Create Departments table
$sql = "CREATE TABLE `departments` (
`dept_id` int(11) NOT NULL,
`dept_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'departments'";
}else{
	echo "'departments' table already exist";
}

// Create doctors table
$sql = "CREATE TABLE `doctors` ( `doc_id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `doc_name` VARCHAR(50) NOT NULL , `address` TEXT NOT NULL , `ph_no` VARCHAR(20) NOT NULL , `designation` VARCHAR(50) NOT NULL , `dept` INT NOT NULL , `exp` INT NOT NULL , `gender` VARCHAR(10) NOT NULL , PRIMARY KEY (`doc_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'doctors'";
}else{
	echo "'doctors' table already exist";
}
// Create patients table
$sql = "CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `mobileno` int(11) NOT NULL,
  `guardian` varchar(50) NOT NULL,
  `emergencycontact` int(11) NOT NULL,
  `gender` char(10) NOT NULL,
  `bgroup` varchar(5) NOT NULL,
  `cur_medication` char(5) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'patients'";
}else{
	echo "'patients' table already exist";
}



include("about.php");
?>