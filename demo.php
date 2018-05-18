<?php session_start();
if(isset($_SESSION['log_id'])){
	header("location: dashboard.php");
}
?>
<html>
<head>
	<title>Online Appointment System: Register</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="css/style.css" type="text/css" rel="stylesheet" />
	<link href="css/patientreg.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<div id="container">
		<table id="wrap" cellspacing="0" border="0" cellpadding="0">
			<tr>
				<td colspan="2" id="header"><h1>Online Appointment System</h1></td>
			</tr>
			<tr>
				<td colspan="2" id="menu">
					<ul>
						<li><a class="menu-item-active" href="index.php">Home</a></li>
						<li><a href="about.php">About</a></li>
						<?php if (isset($_SESSION['log_id'])) {
							echo "<li><a href='dashboard.php'>Dashboard</a></li>";
						} else {
							echo "<li><a href='login.php'>Login</a></li>";
						} ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td class="content">
					<form action="">
						<input type="text" data-validation="required">
						<button type="submit">Submit</button>
					</form>
				</td>
				<?php include('master/foot.php'); ?>