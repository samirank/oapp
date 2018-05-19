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
	<style>

</style>
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
				<h1>Patient Registration</h1>
				<div id="tab-form" style="display: table;">
					<form action="process.php" method="POST">

						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Patient Name</label>
							</div>
							<div class="form-col" ">
								<input type="text" name="name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" placeholder="Enter your full name" autofocus>
							</div>
						</div>

						
						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Username</label>
							</div>
							<div class="form-col" ">
								<input type="text" name="username" data-validation="required alphanumeric server" data-validation-url="form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower" placeholder="Select username">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Address</label>
							</div>
							<div class="form-col" ">
								<textarea data-validation="required" data-validation-error-msg="Please enter your address" name="address"></textarea>
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Mobile number</label>
							</div>
							<div class="form-col" ">
								<input data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="mobileno" maxlength="10">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Guardian Name</label>
							</div>
							<div class="form-col" ">
								<input type="text" data-validation="required" data-validation-error-msg="Please enter your guardian name" name="guardian">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Emergency contact number</label>
							</div>
							<div class="form-col" ">
								<input type="text" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" name="emcont" maxlength="10">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Gender</label>
							</div>
							<div class="form-col">
								<div class="form-radio-btn">
									<input type="radio" name="gender" value="male">
									male
								</div>
								<div class="form-radio-btn">
									<input type="radio" name="gender" value="female">
									female
								</div>
								<div class="form-radio-btn">
									<input type="radio" data-validation="required" data-validation-error-msg="Please select an option" name="gender" value="other">
									Others
								</div>
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Blood group</label>
							</div>
							<div class="form-col">
								<select name="bgroup" data-validation="required" data-validation-error-msg="Please select blood group">
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
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Current medication</label>
							</div>
							<div class="form-col">
								<input type="text" name="cur_medication">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Email id</label>
							</div>
							<div class="form-col">
								<input type="text" data-validation="email" name="email_id">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Password</label>
							</div>
							<div class="form-col">
								<input type="password" data-validation="strength" data-validation-strength="2" name="pass">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-label w-50">
								<label for="">Confirm password</label>
							</div>
							<div class="form-col">
								<input type="password" data-validation="confirmation" data-validation-confirm="pass" data-validation-error-msg="Entered value do not match with your password." name="cnf_pass">
							</div>
						</div>


						<div class="form-row">
							<div class="form-col form-btn">
								<button class="btn btn-submit" type="submit">Submit</button>
								<button class="btn btn-submit" type="reset">Reset</button>
							</div>
						</div>
					</form>
				</div>
			</td>
			<?php include('master/foot.php'); ?>