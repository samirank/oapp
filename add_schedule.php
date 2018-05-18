<?php include('master/head.php'); ?>
<td class="content">
	<div>
		<form action="process.php" method="POST">
			<table id="tab-form">
				<tr>
					<td><label for="day">Select day :</label></td>
					<td>
						<select name="day" data-validation="required">
							<option value="" selected disabled>Select</option>
							<option value="Sunday">Sunday</option>
							<option value="Monday">Monday</option>
							<option value="Tuesday">Tuesday</option>
							<option value="Wednesday">Wednesday</option>
							<option value="Thursday">Thursday</option>
							<option value="Friday">Friday</option>
							<option value="Saturday">Saturday</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="">Timing :</label></td>
					<td>
						From:
						<input type="time" name="time_from">
						&emsp;
						To:
						<input type="time" name="time_to">
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="text" value="<?php echo $_GET['doc_id']; ?>" name="doc_id" hidden>
						<button class="btn" type="submit" name="add_schedule">Submit</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</td>
<?php include('master/foot.php') ?>