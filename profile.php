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
		Patient
	<?php endif ?>



	<!-- For laboratorian Profile -->
	<?php if ($row['user_role']=='laboratorian'): ?>

	<?php endif ?>
</td>
<?php include 'master/foot.php'; 
?>