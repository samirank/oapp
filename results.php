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
							$sql = "SELECT * FROM doctors JOIN departments ON doctors.dept=departments.dept_id JOIN users ON doctors.user_id= users.user_id WHERE doctors.dept = '{$_POST['symptom']}' AND users.status='active'";
							$result = mysqli_query($con,$sql);
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>
									<?php 
									if ($row['designation']=="Specialist") {
										$badge="#4ac343";
									}
									elseif ($row['designation']=="Consultant") {
										$badge="#7489fd";
									}
									elseif ($row['designation']=="General Practitioner") {
										$badge="#e6bc44";
									}
									else{
										$badge="#999";
									}
									$sql = "SELECT DISTINCT day FROM schedule WHERE doc_id = '{$row['doc_id']}' AND NOT status='Deleted' ORDER BY CASE WHEN day = 'Sunday' THEN 1 WHEN day = 'Monday' THEN 2 WHEN day = 'Tuesday' THEN 3 WHEN day = 'Wednesday' THEN 4 WHEN day = 'Thursday' THEN 5 WHEN day = 'Friday' THEN 6 WHEN day = 'Saturday' THEN 7 END ASC";
									$result_days = mysqli_query($con,$sql);
									$day = array();
									if (mysqli_num_rows($result_days)>=1) {
										while ($row_days = mysqli_fetch_assoc($result_days)) {
											array_push($day, date('D',strtotime($row_days['day'])));
										}
										$days = implode(",", $day);
									}
									else{
										$days = "N/A";
									}
									?>

									<!-- Container for each doctor -->
									<div class="doc-result-container">
										<div style="background-image: url(<?php echo $row['profile_pic']; ?>);" class="doc_profile">
										</div>
										<div class="doc-name">Dr. <?php echo $row['doc_name']; ?></div>
										<div class="doc_dept">Department : <?php echo $row['dept_name']; ?></div>
										<div class="doc_desig" style="background-color: <?php echo $badge; ?>;"><?php echo $row['designation']; ?></div>
										<div class="doc_days">Days :&nbsp;<span><?php print_r($days); ?></span></div>
										<a href="schedule.php?doc_id=<?php echo $row['doc_id'];?>" class="btn-a">Book Now</a>

									</div>

								<?php }}?>
								<div>

								</div>
							</form>
						<?php } ?>
					</td>
					<?php include('master/foot.php'); ?>