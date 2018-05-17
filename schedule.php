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
					<h1>Select Time</h1>
					<table id="view-form" cellspacing="0">

						<?php
						// To display doc schedule
						if (isset($_GET['doc_id'])): ?>
							<tr>
								<th>Day</th>
								<th>Date</th>
								<th>Time</th>                
								<th>Action</th>
							</tr>
							<?php
							$sql = "SELECT s.day, s.time_from, s.time_to, s.schedule_id FROM schedule s JOIN doctors d ON s.doc_id=d.doc_id JOIN users u ON d.user_id=u.user_id WHERE s.doc_id = '{$_GET['doc_id']}' AND s.status = 'active' AND u.status= 'active';";
							$result = mysqli_query($con,$sql);
							if (mysqli_num_rows($result) > 0) {
								while ($row = mysqli_fetch_assoc($result)) { ?>
									<tr>
										<td><?php echo $row['day']; ?></td>
										<td><?php echo date('d-M-Y',strtotime("next {$row['day']}")); ?></td>
										<td><?php echo $row['time_from']." - ".$row['time_to']; ?></td>
										<td><a class="btn-e" href="book.php?schedule_id=<?php echo $row['schedule_id']; ?>">Book</a></td>
									</tr>

								<?php }}
								else {
									echo '<tr><td colspan="3" style="text-align:center;">No records found !</td></tr>';
								}?>
							<?php endif ?>

							<?php 
							// To display test schedule
							if (isset($_GET['test_id'])): ?>
								
								<tr>
									<th>Day</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
								<?php
								$sql = "SELECT * FROM lab_test WHERE lab_test_id = '{$_GET['test_id']}'";
								$result = mysqli_query($con,$sql);
								$row = mysqli_fetch_assoc($result);

								if (!empty($row['days'])) {
									$days = explode(",", $row['days']);
									foreach ($days as $key => $value) {
										?>
										<tr>
											<td><?php echo date('l',strtotime($value)); ?></td>
											<td><?php echo date('d-M-Y',strtotime("next {$value}")); ?></td>
											<td><a class="btn-e" href="book.php?test_id=<?php echo $row['lab_test_id']; ?>&day=<?php echo $value; ?>">Book</a></td>
										</tr>	
									<?php	}
								}
								else {
									echo '<tr><td colspan="3" style="text-align:center;">No records found !</td></tr>';
								}?>									

							<?php endif ?>



						</table>
					</td>
					<?php include('master/foot.php'); ?>