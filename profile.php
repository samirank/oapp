<?php
include 'master/head.php';
include 'master/db.php'; 
if ($_SESSION['log_role']=="admin") {
	if (isset($_GET['id'])) {
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
	<div style="display: flex;">
		<a class="btn-a btn-lg" href="edit_profile.php?id=<?php echo $user_id; ?>">Edit Account</a>
		<a class="btn-a btn-lg" href="profile.php?id=<?php echo $user_id; ?>&change_pass=1">Change Password</a>
		<?php if ($_SESSION['log_role']=="admin"): ?>
			<?php if ($row['status']!="active"): ?>
				<a class="btn-a btn-lg" href="process.php?activate=<?php echo $row['user_id']; ?>">Activate account</a>
				<?php else: ?>
					<a class="btn-a btn-lg" href="process.php?suspend_doc=<?php echo $row['user_id']; ?>">Suspend Account</a>
				<?php endif ?>
			<?php endif ?>
		</div>

		<!-- To display doctor details -->
		<?php $sql = "SELECT * FROM doctors JOIN departments ON doctors.dept=departments.dept_id JOIN users ON doctors.user_id = users.user_id WHERE doctors.user_id = '$user_id'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_assoc($result); ?>
		
		<!-- Change Password -->
		<?php if (isset($_GET['change_pass'])): ?>
			<div class="change-pass">
				<form action="process.php" method="POST">
					Enter new password :
					<input type="password" autofocus name="pass">
					&emsp;&emsp;&emsp;
					Confirm password :
					<input type="password" name="cnf_pass">
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
			<tr>
				<td>User name</td>
				<td><input type="text" name="uname" value="<?php echo $row['user_name']; ?>" disabled></td>
			</tr>
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
		</table>
	<?php endif ?>



	<!-- For patient Profile -->
	<?php if ($row['user_role']=='patient'): ?>

		<!-- Header buttons -->
		<div style="display: flex;">
			<?php if ($_SESSION['log_role']=="patient"): ?>
				<a class="btn-a btn-lg" href="edit_profile.php?id=<?php echo $user_id; ?>">Edit Account</a>
				<a class="btn-a btn-lg" href="profile.php?id=<?php echo $user_id; ?>&change_pass=1">Change Password</a>
			<?php endif ?>
			<?php if ($_SESSION['log_role']=="admin"): ?>
				<?php if ($row['status']!="active"): ?>
					<a class="btn-a btn-lg" href="process.php?activate=<?php echo $row['user_id']; ?>">Activate account</a>
					<?php else: ?>
						<a class="btn-a btn-lg" href="process.php?suspend_doc=<?php echo $row['user_id']; ?>">Suspend Account</a>
					<?php endif ?>
				<?php endif ?>
			</div>

			<!-- Change Password -->
			<?php if (isset($_GET['change_pass'])): ?>
				<div class="change-pass">
					<form action="process.php" method="POST">
						Enter new password :
						<input type="password" autofocus name="pass">
						&emsp;&emsp;&emsp;
						Confirm password :
						<input type="password" name="cnf_pass">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						&emsp;&emsp;
						<button class="btn" type="submit" name="change_pass">Change</button>
					</form>
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
						<td><?php echo $row['name']; ?></td>
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
						<td><?php echo $row['cur_medication']; ?></td>
					</tr>

					<tr>
						<td>Email id :</td>
						<td><?php echo $row['email_id']; ?></td>
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
						</tbody>
					</table>
				</div>
			<?php endif ?>



			<!-- For laboratorian Profile -->
			<?php if ($row['user_role']=='laboratorian'): ?>

			<?php endif ?>
		</td>
		<?php include 'master/foot.php'; 
		?>