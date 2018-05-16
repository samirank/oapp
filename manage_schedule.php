<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<td id="content">
	<div>
		<a class="btn-a btn-lg" href="add_schedule.php?doc_id=<?php echo $_GET['doc_id']; ?>">Add Schedule</a>
	</div>
	<table id="view-form" cellspacing="0">
		<tr>
			<td colspan="4">
				<span class="msg-alert">
					<?php if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					} ?>
				</span>
			</td>
		</tr>
		<tr>
			<th>Schedule_id</th>
			<th>Day</th>
			<th>Time</th>                
			<th>Action</th>
		</tr>
		<?php
		$sql = "SELECT * FROM schedule WHERE doc_id = '{$_GET['doc_id']}' AND status='active'";
		$result = mysqli_query($con,$sql);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) { ?>
				<tr>
					<td><?php echo $row['schedule_id']; ?></td>
					<td><?php echo $row['day']; ?></td>
					<td><?php echo $row['time_from']." - ".$row['time_to']; ?></td>
					<td><a href="process.php?delete_schedule=<?php echo $row['schedule_id']; ?>&doc_id=<?php echo $_GET['doc_id'] ?>" class="btn-d">Delete</a></td>
				</tr>

				<?php }}
				else {
					echo '<tr><td colspan="4" style="text-align:center;">No records found !</td></tr>';
				}?>
			</table>
		</td>
		<?php include('master/foot.php'); ?>