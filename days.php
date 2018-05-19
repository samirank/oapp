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

<!-- Test Name -->
<div style="font-size: 16; font-weight: bold;">
	Test Name :

	<?php 
		// Print test name from the database
	$sql = "SELECT * from lab_test where lab_test_id = '{$_GET['edit']}'";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($result);
		// Print test name
	echo $row['lab_test'];
		// print_r($row);		
	?>
</div>
<div style="padding: 20px 0px;">
	Available days :&nbsp;<span style="    color: #e84393; font-weight: bold;"><?php echo $row['days']; ?></span>
</div>
<div>
	<form action="process.php" method="POST">
		<select name="day" data-validation="required" data-validation-error-msg="Required">
			<option value="" selected disabled>Select a day</option>
			<option value="Mon">Monday</option>
			<option value="Tue">Tuesday</option>
			<option value="Wed">Wednesday</option>
			<option value="Thu">Thursday</option>
			<option value="Fri">Friday</option>
			<option value="Sat">Saturday</option>
			<option value="Sun">Sunday</option>
		</select>
		<select name="action" data-validation="required" data-validation-message="Select">
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