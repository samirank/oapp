<?php include('master/head.php'); ?>
<td class="content">
	<style>
		.form-radio-btn>span.help-block.form-error{
			display: none;
		}
	</style>
	<form action="process.php" method="POST">
		<div id="tab-form">

			<div class="form-row">
				<div class="form-col form-label w-50">
					<label for="">Select day :</label>
				</div>
				<div class="form-col" ">
					<select name="day" data-validation="required" data-validation-error-msg="Select day">
						<option value="" selected disabled>Select</option>
						<option value="Sunday">Sunday</option>
						<option value="Monday">Monday</option>
						<option value="Tuesday">Tuesday</option>
						<option value="Wednesday">Wednesday</option>
						<option value="Thursday">Thursday</option>
						<option value="Friday">Friday</option>
						<option value="Saturday">Saturday</option>
					</select>
				</div>
			</div>


			<div class="form-row">
				<div class="form-col form-label w-50">
					<label for="">Timing :</label>
				</div>
				<div class="form-col">
					<div class="form-radio-btn">
						From
						<input type="time" name="time_from" data-validation="required">
					</div>
					<div class="form-radio-btn">
						To
						<input type="time" name="time_to" data-validation="required">
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="form-col">
					<input type="text" value="<?php echo $_GET['doc_id']; ?>" name="doc_id" hidden>
					<button class="btn" type="submit" name="add_schedule">Submit</button>
				</div>
			</div>


		</form>
	</div>
</td>
<?php include('master/foot.php') ?>