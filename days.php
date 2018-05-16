<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<?php 
	if (!(isset($_GET['edit']) && $_SESSION['log_role']=="admin")) {
		header("location: dashboard.php");
	}
?>
<td id="content">
	<style>
	select {
		width: unset;
	}
	</style>
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="lab.php">Laboratory</a></li>
        <li>Days</li>
    </ul>
	
	<!-- Test Name -->
	<div>
		Test Name :

		<?php 
		// Print test name from the database
		$sql = "SELECT * from lab_test where lab_test_id = '{$_GET['edit']}'";
		$result = mysqli_query($con,$sql);
		$row = mysqli_fetch_assoc($result);
		// Print test name
		echo $row['lab_test'];
		print_r($row);		
		 ?>
	</div>
	<div>
		Available days :<?php echo $row['days']; ?>
	</div>
	<div>
		<form action="process.php" method="POST">
			<select name="day">
				<option value="" selected disabled>Select a day</option>
				<option value="Mon">Monday</option>
				<option value="Tue">Tuesday</option>
				<option value="Wed">Wednesday</option>
				<option value="Thu">Thursday</option>
				<option value="Fri">Friday</option>
				<option value="Sat">Saturday</option>
				<option value="Sun">Sunday</option>
			</select>
			<select name="action">
				<option value="" selected disabled>add/delete</option>
				<option value="add">Add</option>
				<option value="del">Delete</option>
			</select>
			<input type="hidden" value="<?php echo $row['lab_test_id']; ?>" name="test_id">
			<button type="submit" class="btn" name="test_day">Go</button>
		</form>
	</div>
</td>
<?php include('master/foot.php'); 