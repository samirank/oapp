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
					<h1>Select Schedule</h1>
					<table id="view-form" cellspacing="0">
						<tr>
							<th>Day</th>
							<th>Time</th>                
							<th>Action</th>
						</tr>
						<?php
						$sql = "SELECT * FROM schedule WHERE doc_id = '{$_GET['doc_id']}'";
						$result = mysqli_query($con,$sql);
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) { ?>
								<tr>
									<td><?php echo $row['day']; ?></td>
									<td><?php echo $row['time_from']." - ".$row['time_from']; ?></td>
									<td><a class="btn-e" href="">Book</a></td>
								</tr>

								<?php }}
								else {
									echo '<tr><td colspan="3" style="text-align:center;">No records found !</td></tr>';
								}?>
							</table>
						</td>
						<?php include('master/foot.php'); ?>