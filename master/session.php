<?php 
session_start();
if(!isset($_SESSION['log_id'])){
	session_destroy();
	header('location: login.php');
}
?>