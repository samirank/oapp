<?php
include 'master/head.php';
include 'master/db.php'; 

if (isset($_GET['id'])) {
	$result = mysqli_fetch_array(mysqli_query($con,"SELECT user_role FROM users WHERE user_id = {$_GET['id']}"));
	$role = $result[0];
}else{
	$role = $_SESSION['log_role'];
}

// View Exception for admin
if ($_SESSION['log_role']=="admin") {
	if (($role!="laboratorian")&&(isset($_GET['id']))) {
		$user_id = $_GET['id'];
	}else{
		header("location: laboratorian.php");
	}
}

// View Exception for patient
if ($_SESSION['log_role']=="patient") {
	if(($role=="doctor")&&(isset($_GET['id']))){
		$user_id = $_GET['id'];
	}
}

// View Exception for doctor
if ($_SESSION['log_role']=="doctor") {
	if(($role=="patient")&&(isset($_GET['id']))){
		$user_id = $_GET['id'];
	}
}

// View Exception for Laboratorian
if ($_SESSION['log_role']=="laboratorian") {
	if(($role=="patient")&&(isset($_GET['id']))){
		$user_id = $_GET['id'];
	}
}


if (!isset($user_id)){
	$user_id = $_SESSION['log_id'];
}
$sql = "SELECT * from users where user_id = '$user_id'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
?>
<td id="content">
	<style>
	#tab-form input:disabled , textarea:disabled , select:disabled{
		border: none;
		background-color: #fff;
		color: #333;
	}
	table#view-form tr.bg-white:hover {
		background-color: #fff;
	}
	.font-lg td,input{
		font-size: 14;
	}
	#view-form th{
		background-color: #777;
		border: 1px solid #777;
	}
</style>
<ul class="breadcrumb">
	<li><a href="dashboard.php">Dashboard</a></li>
	<?php if (($row['user_role']!=$_SESSION['log_role']) ||($_SESSION["log_role"]=="admin")): ?>
	<li><a href="bookings.php">Bookings</a></li>
<?php endif ?>
<?php if ($_SESSION['log_role']=='admin'): ?>
	<li><a href="doctors.php">Doctors</a></li>
<?php endif ?>
<li>Profile</li>
</ul>

<!-- if user not found -->
<?php 
if (mysqli_num_rows($result) != 1) {
	echo "User not found.";
}
?>









<!-- For admin profile -->
<?php if ($row['user_role']=='admin'): ?>
	admin
<?php endif ?>










<!-- For doctor Profile -->
<?php if ($row['user_role']=='doctor'): ?>

	<!-- Header buttons -->
	<?php if ($_SESSION['log_role']!='patient'): ?>
		<div style="display: flex;">
			<a class="btn-a btn-lg" href="edit_profile.php?id=<?php echo $user_id; ?>">Edit Account</a>
			<a class="btn-a btn-lg" href="profile.php?id=<?php echo $user_id; ?>&change_pass=1">Change Password</a>
			<?php if ($_SESSION['log_role']=="admin"): ?>
				<?php if ($row['status']!="active"): ?>
					<a class="btn-a btn-lg" href="process.php?activate=<?php echo $row['user_id']; ?>">Activate account</a>
					<?php else: ?>
						<a class="btn-a btn-lg" href="process.php?suspend=<?php echo $row['user_id']; ?>">Suspend Account</a>
					<?php endif ?>
				<?php endif ?>
			</div>
		<?php endif ?>

		<!-- To display doctor details -->
		<?php $sql = "SELECT * FROM doctors JOIN departments ON doctors.dept=departments.dept_id JOIN users ON doctors.user_id = users.user_id WHERE doctors.user_id = '$user_id'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_assoc($result); ?>
		
		<!-- Change Password -->
		<?php if (isset($_GET['change_pass'])): ?>
			<div class="change-pass">
				<form action="process.php" method="POST">
					Enter new password :
					<input type="password" data-validation="strength" data-validation-strength="2" name="pass">
					&emsp;&emsp;&emsp;
					Confirm password :
					<input type="password" data-validation="confirmation" data-validation-confirm="pass" data-validation-error-msg="Entered value do not match with your password." name="cnf_pass">
					<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
					&emsp;&emsp;
					<button class="btn" type="submit" name="change_pass">Change</button>
				</form>
			</div>
		<?php endif ?>

		<!-- Profile Picture -->
		<div class="profile-pic">
			<img src="<?php echo $row['profile_pic'] ?>" alt="profile picture">
			<?php if ($_SESSION['log_role']=="doctor"): ?>
				<a class="btn" href="">Change profile picture</a>
			<?php endif ?>
		</div>
		<!-- Doctor Form -->
		<table id="tab-form">
			<tr>
				<td></td>
				<td>
					<span class="msg-alert">
						<?php if(isset($_SESSION['msg'])){
							echo $_SESSION['msg'];
							unset($_SESSION['msg']);
						} ?>
					</span>
				</td>
			</tr>
			<tr>
				<td>Doctor Name :</td>
				<td><input type="text" name="dname" value="<?php echo $row['doc_name']; ?>" disabled></td>
			</tr>
			<?php if ($_SESSION['log_role']!='patient'): ?>
				<tr>
					<td>User name</td>
					<td><input type="text" name="uname" value="<?php echo $row['user_name']; ?>" disabled></td>
				</tr>
			<?php endif ?>
			<tr>
				<td>Address :</td>
				<td><div style="padding-left: 10px; width: 200px;"><?php echo $row['address']; ?></div></td>
			</tr>
			<tr>
				<td>Phone Number :</td>
				<td><input type="text" name="dphno" maxlength="10" value="<?php echo $row['ph_no']; ?>" disabled></td>
			</tr>
			<tr>
				<td>Designation :</td>
				<td><input type="text" value="<?php echo $row['designation']; ?>" disabled></td>
			</tr>
			<tr>
				<td>Department :</td>
				<td>
					<input type="text" value="<?php echo $row['dept_name']; ?>" disabled>
				</td>
			</tr>
			<tr>
				<td>Experience :</td>
				<td><input type="text" name="d_exp" value="<?php echo $row['exp']; ?> years" disabled></td>
			</tr>
			<tr>
				<td>Gender :</td>
				<td>
					<input type="text" value="<?php echo $row['gender']; ?>" disabled>
				</td>
			</tr>
			<tr>
				<td>Date of registration :</td>
				<td><input type="text" name="d_exp" value="<?php echo $row['date_of_reg']; ?>" disabled></td>
			</tr>
		</table>
	<?php endif ?>






















	<!-- For patient Profile -->
	<?php if ($row['user_role']=='patient'): ?>

		<!-- Header buttons -->
		<div style="display: flex;">
			<?php if ($_SESSION['log_role']=="patient"): ?>
				<a class="btn-a btn-lg" href="edit_profile.php?id=<?php echo $user_id; ?>">Edit profile</a>
				<a class="btn-a btn-lg" href="profile.php?id=<?php echo $user_id; ?>&change_pass=1">Change Password</a>
			<?php endif ?>
			<?php if ($_SESSION['log_role']=="admin"): ?>
				<?php if ($row['status']!="active"): ?>
					<a class="btn-a btn-lg" href="process.php?activate=<?php echo $row['user_id']; ?>">Activate account</a>
					<?php else: ?>
						<a class="btn-a btn-lg" href="process.php?suspend=<?php echo $row['user_id']; ?>">Suspend Account</a>
					<?php endif ?>
				<?php endif ?>
				<?php if ($_SESSION['log_role']!="doctor"): ?>
					<a class="btn-a btn-lg" href="lab_bookings.php?id=<?php echo $row['user_id']; ?>">Lab bookings</a>
				<?php endif ?>
				<?php if ($_SESSION['log_role']=="patient"): ?>
					<a class="btn-a btn-lg" href="process.php?delete_acc=<?php echo $user_id; ?>&change_pass=1">Delete account</a>
				<?php endif ?>
			</div>

			<!-- Change Password -->
			<?php if (isset($_GET['change_pass'])): ?>
				<div class="change-pass">
					<form action="process.php" method="POST">
						Enter new password :
						<input type="password" data-validation="strength" data-validation-strength="2" name="pass">
						&emsp;&emsp;&emsp;
						Confirm password :
						<input type="password" data-validation="confirmation" data-validation-confirm="pass" data-validation-error-msg="Entered value do not match with your password." name="cnf_pass">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						&emsp;&emsp;
						<button class="btn" type="submit" name="change_pass">Change</button>
					</form>
				</div>
			<?php endif ?>

			<!-- Display message -->
			<?php if (isset($_SESSION['msg'])): ?>
				<div style="padding: 20px 2px;">
					<span class="msg-alert">
						<?php 
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
						?>
					</span>
				</div>
			<?php endif ?>

			<!-- SQL to display patient details -->
			<?php $sql = "SELECT * FROM patients JOIN users ON patients.user_id = users.user_id WHERE patients.user_id = '$user_id'";
			$result = mysqli_query($con,$sql);
			$row = mysqli_fetch_assoc($result); 
			?>

			<!-- Patient Form -->
			<div style="display: flex;">
				<table id="tab-form" class="font-lg">
					<tr>
						<td style="width: 50%;">Patient Name :</td>
						<td><b><?php echo $row['name']; ?></b></td>
					</tr>

					<tr>
						<td>Username :</td>
						<td><?php echo $row['user_name']; ?></td>
					</tr>

					<tr>
						<td>Address :</td>
						<td><?php echo $row['address']; ?></td>
					</tr>

					<tr>
						<td>Mobile number :</td>
						<td><?php echo $row['mobileno']; ?></td>
					</tr>

					<tr>
						<td>Guardian Name :</td>
						<td><?php echo $row['guardian']; ?></td>
					</tr>

					<tr>
						<td>Emergency Contact :</td>
						<td><?php echo $row['emergencycontact']; ?></td>
					</tr>

					<tr>
						<td>Gender :</td>
						<td><?php echo $row['gender']; ?></td>
					</tr>

					<tr>
						<td>Blood group :</td>
						<td><?php echo $row['bgroup']; ?></td>
					</tr>

					<tr>
						<td>Current medication :</td>
						<td><b><?php echo $row['cur_medication']; ?></b></td>
					</tr>

					<tr>
						<td>Email id :</td>
						<td><?php echo $row['email_id']; ?></td>
					</tr>

					<tr>
						<td>Date of registration :</td>
						<td><?php echo $row['date_of_reg']; ?></td>
					</tr>

					<tr>
						<td><b>Account status :</b></td>
						<td><b><?php echo $row['status']; ?></b></td>
					</tr>
				</table>

				<table id="view-form" style="text-align: center;">
					<tr class="bg-white">
						<td colspan="3" style="text-align: left;">
							<h3 style="margin-left: -5px;">Recent bookings</h3>
						</td>
					</tr>
					<tr>
						<th>Doctor</th>
						<th>Department</th>
						<th>Date</th>
					</tr>
					<tbody>
						<?php 
						$sql = "SELECT b.booking_id, d.doc_name, dept.dept_name, DATE_FORMAT(b.date_of_appointment, '%e %b, %Y') AS doa FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN departments dept ON d.dept=dept.dept_id JOIN patients p ON b.patient_id=p.patient_id WHERE p.user_id = '$user_id' ORDER BY b.date_of_appointment DESC LIMIT 10";
						$result = mysqli_query($con,$sql);
						$row2 = mysqli_fetch_assoc($result);
						?>
						<tr>
							<?php if (mysqli_num_rows($result)>=1): ?>
								<td><?php echo $row2['doc_name']; ?></td>
								<td><?php echo $row2['dept_name']; ?></td>
								<td><?php echo $row2['doa']; ?></td>
								<?php else: ?>
									<td colspan="3">No records found</td>
								<?php endif ?>
							</tr>
							<?php if ($_SESSION['log_role']!='doctor' && $_SESSION['log_role']!='laboratorian'): ?>
								<tr class="bg-white">
									<td colspan="2">
										<h4>
											Showing
											<?php echo mysqli_num_rows($result); ?>
											of
											<?php
											$num_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(booking_id) AS num FROM bookings WHERE patient_id='{$row['patient_id']}'"));
											echo $num_bookings['num'];
											?>
										</h4>
									</td>
									<td>
										<a href="bookings.php?id=<?php echo $user_id; ?>" class="btn" style="padding: 4px 8px;">View all bookings</a>
									</td>
								</tr>	
							<?php endif ?>
						</tbody>
					</table>
				</div>
			<?php endif ?>


















			<!-- For laboratorian Profile -->
			<?php if ($row['user_role']=='laboratorian'){ ?>
				<div style="display: flex;">
					<a class="btn-a btn-lg" href="profile.php?edit=<?php echo $user_id; ?>">Edit profile</a>
					<a class="btn-a btn-lg" href="profile.php?id=<?php echo $user_id; ?>&change_pass=1">Change Password</a>
				</div>


				<!-- Display message -->
				<?php if (isset($_SESSION['msg'])): ?>
					<div style="padding: 20px 2px;">
						<span class="msg-alert">
							<?php 
							echo $_SESSION['msg'];
							unset($_SESSION['msg']);
							?>
						</span>
					</div>
				<?php endif ?>

				<!-- SQL to display patient details -->
				<?php $sql = "SELECT * FROM laboratorian JOIN users ON laboratorian.user_id = users.user_id  WHERE laboratorian.user_id = '$user_id'";
				$result = mysqli_query($con,$sql);
				$row = mysqli_fetch_assoc($result);
				?>


				<!-- Change Password -->
				<?php if (isset($_GET['change_pass'])): ?>
					<div class="change-pass">
						<form action="process.php" method="POST">
							Enter new password :
							<input type="password" data-validation="strength" data-validation-strength="2" name="pass">
							&emsp;&emsp;&emsp;
							Confirm password :
							<input type="password" data-validation="confirmation" data-validation-confirm="pass" data-validation-error-msg="Entered value do not match with your password." name="cnf_pass">
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
							&emsp;&emsp;
							<button class="btn" type="submit" name="change_pass">Change</button>
						</form>
					</div>
				<?php endif ?>


				<?php if (isset($_GET['edit'])): ?>
					<?php $json = json_encode(array("user_id"=>$_GET['edit'])); ?>

					<!-- Edit profile -->
					<div class="change-pass" style="display: block; margin-bottom: 20px;">
						<form action="process.php" method="POST">
							<div id="tab-form" style="margin: auto 25%;">

								<div class="form-row">
									<div class="form-col form-label w-50">
										<label for="">Name :</label>
									</div>
									<div class="form-col">
										<input type="text" name="name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" placeholder="Enter your full name" value="<?php echo $row['name']; ?>" autofocus>
									</div>
								</div>


								<div class="form-row">
									<div class="form-col form-label w-50">
										<label for="">Username</label>
									</div>
									<div class="form-col">
										<input type="text" name="user_name" data-validation="required alphanumeric server" data-validation-param-name="edit_uname" data-validation-req-params='<?php echo $json; ?>' data-validation-url="form_validate.php" data-validation-allowing="_" data-sanitize="trim lower" placeholder="Enter username" value="<?php echo $row['user_name']; ?>">
									</div>
								</div>


								<div class="form-row">
									<div class="form-col form-label w-50">
										<label for="">Email id :</label>
									</div>
									<div class="form-col">
										<input type="text" name="email_id" data-validation="email" value="<?php echo $row['email_id']; ?>">
									</div>
								</div>



								<div class="form-row">
									<div class="form-col form-label w-50">
										<label for="">Mobile no:</label>
									</div>
									<div class="form-col">
										<input type="text" maxlength="10" name="phno" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" value="<?php echo $row['ph_no']; ?>">
									</div>
								</div>



								<div class="form-row">
									<div class="form-col form-label w-50">
										<label for="">Date of registration :</label>
									</div>
									<div class="form-col">
										<?php echo $row['date_of_reg']; ?>
									</div>
								</div>


								<div class="form-row">
									<div class="form-col form-btn">
										<input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
										<button class="btn btn-submit" type="submit" name="edit_laboratorian">Submit</button>
									</div>
								</div>


							</div>
						</form>
					</div>

				<?php endif ?>

				<?php if (!isset($_GET['edit'])): ?>
					<table id="tab-form" class="font-lg">
						<tr>
							<td style="width: 20%;">Name :</td>
							<td><b><?php echo $row['name']; ?></b></td>
						</tr>
						<tr>
							<td>Email id :</td>
							<td><?php echo $row['email_id']; ?></td>
						</tr>
						<tr>
							<td>Phone No. :</td>
							<td><?php echo $row['ph_no']; ?></td>
						</tr>
						<tr>
							<td>Username :</td>
							<td><?php echo $row['user_name']; ?></td>
						</tr>
						<tr>
							<td>Date of registration :</td>
							<td><?php echo $row['date_of_reg']; ?></td>
						</tr>
						<tr>
							<td><b>Account status :</b></td>
							<td><b><?php echo $row['status']; ?></b></td>
						</tr>
					</table>	
				<?php endif ?>
				<?php } ?>




				<!-- End of file -->
			</td>
			<?php include 'master/foot.php'; 
			?>