<?php session_start();
if(isset($_SESSION['log_id'])){
	header("location: dashboard.php");
}
?>
<html>
<head>
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
					<h1>Patient Details</h1>
					<table id="tab-form">
						<tr>
							<td></td>
							<td><span class="msg-alert">
								<?php if(isset($_SESSION['msg'])){
									echo $_SESSION['msg'];
									unset($_SESSION['msg']);
								} ?>
							</span></td>
						</tr>
						<form action="process.php" method="POST">

							<tr>
								<td>Patient Name :</td>
								<td><input type="text" name="name" placeholder="Enter your full name"></td>
							</tr>
							<tr>
								<td>Username</td>
								<td><input type="text" name="username" placeholder="Select username"></td>
							</tr>
							<tr>
								<td>Address</td>
								<td><textarea name="address"></textarea></td>
							</tr>
							<tr>
								<td>Mobile number</td>
								<td><input type="text" name="mobileno" maxlength="10"></td>
							</tr>
							<tr>
								<td>Guardian Name</td>
								<td><input type="text" name="guardian"></td>
							</tr>
							<tr>
								<td>Emergency Contact Number</td>
								<td><input type="text" name="emcont" maxlength="10"></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td>
									male
									<input type="radio" name="gender" value="male">
									female
									<input type="radio" name="gender" value="female">
									Others
									<input type="radio" name="gender" value="other">
								</td>
							</tr>
							<tr>
								<td>Blood group</td>
								<td>
									<select name="bgroup">
										<option value="" selected disabled>Select</option>
										<option value="A+">A+</option>
										<option value="A-">A-</option>
										<option value="B+">B+</option>
										<option value="B-">B-</option>
										<option value="AB+">AB+</option>
										<option value="AB-">AB-</option>
										<option value="O+">O+</option>
										<option value="O-">O-</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Current medication</td>
								<td><input type="text" name="cur_medication"></td>
							</tr>
							<tr>
								<td>Email id</td>
								<td><input type="text" name="email_id"></td>
							</tr>
							
							<tr>
								<td>Password</td>
								<td><input type="password" name="pass"></td>
							</tr>
							<tr>
								<td>Confirm Password</td>
								<td><input type="password" name="cnf_pass"></td>
							</tr>
							
							<tr>
								<td></td>
								<td>
									<button class="btn" type="submit" name="patientreg">Submit</button>
									<button class="btn" type="reset">Reset</button>
								</td>
							</tr>
						</form>
					</table>
				</td>
				<?php include('master/foot.php'); ?>