<?php session_start();
if(isset($_SESSION['log_id'])){
	header("location: dashboard.php");
}
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="css/style.css" type="text/css" rel="stylesheet" />
	<link href="css/login.css" type="text/css" rel="stylesheet" />
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
						<li><a href="index.php">Home</a></li>
						<li><a href="about.php">About</a></li>
						<li><a class="menu-item-active" href="login.php">Login</a></li>
						<li></li>
					</ul>
				</td>
			</tr>
			<tr>
				<td id="content">
					<div class="login-wrap">
						<div class="login-box">
							<form action="process.php" method="POST">
								<input type="text" name="uname" placeholder="username">
								<input type="password" name="pass" placeholder="password">
								<span id="login-error">
									<?php if(isset($_SESSION['login_err'])){
										echo $_SESSION['login_err'];
										unset($_SESSION['login_err']);
									} ?>
								</span>
								<button type="submit" name=login_submit>Login</button>
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