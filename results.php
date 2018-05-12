<?php session_start(); ?>
<?php include('master/db.php'); ?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="css/style.css" type="text/css" rel="stylesheet" />
	<link href="css/result.css" type="text/css" rel="stylesheet" />
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
					<?php if (isset($_POST['search_doc'])) { ?>
						<form action="results.php" method="POST">
							<!-- Search Results for doctors -->
							<div class="filters">
								Filter by:

							</div>

							<!-- List of Doctors -->
							<?php
							$sql = "SELECT * FROM doctors JOIN departments ON doctors.dept=departments.dept_id WHERE doctors.dept = '{$_POST['symptom']}'";
							$result = mysqli_query($con,$sql);
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>

								<!-- Container for each doctor -->
								<div class="doc-result-container">
									<img src="<?php echo $row['profile_pic']; ?>" alt="doc_profile_pic">
									<div class="doc-name"><?php echo $row['doc_name']; ?></div>
									<div class="doc_dept"><?php echo $row['dept_name']; ?></div>

								</div>

									<?php }}?>
									<div>

									</div>
								</form>
								<?php } ?>
							</td>
							<?php include('master/foot.php'); ?>