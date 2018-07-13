<?php
$server = "localhost";
$dbname = "oapp";
$user = "oapp";
$pwd = "cZ5sVh8hXr8M7JmB";

$con = mysqli_connect($server, $user, $pwd, $dbname);
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>