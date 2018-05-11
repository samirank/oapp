
<?php include("master/db.php");
$sql = "CREATE TABLE `oapp`.`doctors` ( `doc_id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `doc_name` INT NOT NULL , `address` TEXT NOT NULL , `ph_no` INT NOT NULL , `designation` VARCHAR(50) NOT NULL , `dept` VARCHAR(50) NOT NULL , `exp` INT NOT NULL , `gender` VARCHAR(10) NOT NULL , PRIMARY KEY (`doc_id`)) ENGINE = InnoDB;";
if (mysqli_query($con,$sql)) {
	echo "Created table name 'doctors'";
}else{
	echo "'doctors' table already exist";
}

include("about.php");
?>