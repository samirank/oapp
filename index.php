<?php session_start(); ?>
<?php include('master/db.php'); ?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="css/style.css" type="text/css" rel="stylesheet" />
	<link href="css/index.css" type="text/css" rel="stylesheet" />
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
					<?php if (isset($_SESSION['log_id'])) { ?>
						<div class="menu-right">  
							<a id="logout-btn" href="logout.php">Logout</a>
						</div>
					<?php } ?>

				</td>
			</tr>
			<tr>
				<td id="content">
					<div class="header">
						<div class="landing-text">
							<h2>Book Appointments Online</h2>
							<?php if (!isset($_SESSION['log_id'])) { ?>
								<a id="registerLink" href="patientreg.php">Register Now</a>
							<?php }else{ ?>
								<br><br>
							<?php } ?>
							<p>This Online Appiontment  Manageemet system is
							developed by the students of IGNOU as a mini project for the course MCS-044. Find more in the about section.</p>
						</div>
						<div class="landing-form">
							<a href="#bookDoc" id="bookDoctor">Book Doctor</a>
							<hr>
							<a href="#bookDoc" id="bookLab">Book lab test</a>
						</div>
					</div>
					<!-- Book Doctor Form -->
					<div id="bookDoc">
						<div class="background-curve"></div>
						<div class="doctor_background"></div>
						<!-- <img src="images/doctor_background.jpg" alt="doctor_background"> -->
						<div class="search-input-field book-doc">
							<div class="doctor-icon"></div>
							<form action="results.php" method="POST">
								<p>Search by Department</p>
								<!-- <input type="text" placeholder="Department"> -->
								<select name="symptom">
									<option value="" disabled selected>Select</option>
									<?php $result = mysqli_query($con,"select * from departments");
									if (mysqli_num_rows($result) > 0) {
										while ($row = mysqli_fetch_assoc($result)) { ?>
											<option value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
										<?php }}?>                       
									</select>
									<button type="Submit" name="search_doc">Submit</button>
								</form>
							</div>
							<div class="search-input-field book-lab">
								<div class="patient-img"></div>
								<form action="results.php" method="POST">
									<p>Enter Name of Lab test</p>
									<select name="symptom">
										<option value="" disabled selected>Select</option>
										<?php $result = mysqli_query($con,"select * from lab_test");
										if (mysqli_num_rows($result) > 0) {
											while ($row = mysqli_fetch_assoc($result)) { ?>
												<option value="<?php echo $row['lab_test_id']; ?>"><?php echo $row['lab_test']; ?></option>
											<?php }}?>                       
										</select>
										<button type="Submit" name="search_lab">Submit</button>
									</form>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" id="footer"></td>
					</tr>
				</table>
			</div>
		</body>
		</html>