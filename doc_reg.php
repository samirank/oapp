<?php include 'master/head.php'; ?>
<?php include 'master/db.php'; ?>
<td id="content">
<ul class="breadcrumb">
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="doctors.php">Doctors</a></li>
<li>Doctor Registration</li>
</ul>
<?php if (isset($_SESSION['msg'])): ?>
<div style="padding:20px 2px;text-align:center">
<span class="msg-alert">
<?php 
echo $_SESSION['msg'];
unset($_SESSION['msg']);
?>
</span>
</div>
<?php endif ?>
<form action="process.php" method="post">
<div id="tab-form">
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Doctor Name</label>
</div>
<div class="form-col">
<input type="text" name="dname" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize" data-validation-allowing=" " placeholder="Enter your full name" autofocus>
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">User name</label>
</div>
<div class="form-col">
<input type="text" name="uname" data-validation="required alphanumeric server" data-validation-url="form_validate.php" data-validation-param-name="username" data-validation-allowing="_" data-sanitize="trim lower" placeholder="Enter username">
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Address</label>
</div>
<div class="form-col">
<textarea data-validation="required" data-validation-error-msg="Please enter your address" name="dadd"></textarea>
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Mobile number</label>
</div>
<div class="form-col">
<input data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="dphno" maxlength="10">
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Designation</label>
</div>
<div class="form-col">
<select name="d_desig" data-validation="required" data-validation-error-msg="Please select designation">
<option selected disabled>Select</option>
<option value="Junior Doctor">Junior Doctor</option>
<option value="General Practitioner">General Practitioner</option>
<option value="Consultant">Consultant</option>
<option value="Specialist">Specialist</option>
</select>
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Department</label>
</div>
<div class="form-col">
<select name="d_dept" data-validation="required" data-validation-error-msg="Please select department">
<option value="" disabled selected>Select</option>
<?php $result = mysqli_query($con,"select * from departments");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { ?>
<option value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
<?php }}?>
</select>
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Experience </label>
</div>
<div class="form-col">
<span class="muted-inner">years</span>
<input type="text" name="d_exp" data-validation="number length" data-validation-length="1-2" data-validation-error-msg="Enter valid number of years">
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Gender</label>
</div>
<div class="form-col">
<div class="form-radio-btn">
<input type="radio" name="d_gen" value="Male">
male
</div>
<div class="form-radio-btn">
<input type="radio" name="d_gen" value="Female">
female
</div>
<div class="form-radio-btn">
<input type="radio" data-validation="required" data-validation-error-msg="Please select an option" name="d_gen" value="Others">
Others
</div>
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Password</label>
</div>
<div class="form-col">
<input type="password" data-validation="strength" data-validation-strength="2" name="pass">
</div>
</div>
<div class="form-row">
<div class="form-col form-label w-50">
<label for="">Confirm password</label>
</div>
<div class="form-col">
<input type="password" data-validation="confirmation" data-validation-confirm="pass" data-validation-error-msg="Entered value do not match with your password." name="cnf_pass">
</div>
</div>
<div class="form-row">
<div class="form-col form-btn">
<button class="btn btn-submit" type="submit" name="d_submit">Submit</button>
<button class="btn btn-submit" type="reset">Reset</button>
</div>
</div>
</div>
</form>
</td>
<?php include 'master/foot.php'; ?>