<?php include('master/head.php') ?>
<td class="content">
	<ul class="breadcrumb">
		<li><a href="dashboard.php">Dashboard</a></li>
		<li><a href="lab.php">Laboratory</a></li>
		<li><a href="add_labtest.php">Add Lab Test</a></li>
	</ul>
	<div>
		<form action="process.php" method="POST">
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
					<td><label for="lab_name">Laboratory Name :</label></td>
					<td><input type="text" name="lab_name"></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button class="btn" type="submit" name="add_lab">Submit</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</td>
<?php include('master/foot.php') ?>