<?php
include 'master/head.php';
include 'master/db.php'; 
if ($_SESSION['log_role']=="admin") {
    if (isset($_GET['id'])) {
        $result = mysqli_fetch_array(mysqli_query($con,"SELECT user_role FROM users WHERE user_id = {$_GET['id']}"));
        $role = $result[0];
        if($role!="patient"){
            $user_id = $_GET['id'];
        }
    }
}
if (!isset($user_id)){
    $user_id = $_SESSION['log_id'];
}
$sql = "SELECT * from users where user_id = '$user_id'";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
?>
<td id="content">
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="profile.php<?php if(isset($_GET['id'])){ echo "?id=".$_GET['id']; } ?>">Profile</a></li>
        <li>Edit profile</li>
    </ul>

    <!-- if user not found -->
    <?php 
    if (mysqli_num_rows($result) != 1) {
        echo "User not found.";
    }
    ?>
















    <!-- For admin profile -->
    <?php if ($row['user_role']=='admin'): ?>
        admin
    <?php endif ?>

















    <!-- For doctor Profile -->
    <?php if ($row['user_role']=='doctor'): ?>
        <?php $sql = "SELECT * FROM doctors JOIN departments ON doctors.dept=departments.dept_id JOIN users ON doctors.user_id = users.user_id WHERE doctors.user_id = '$user_id'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result); 
        $json = array('user_id' => $user_id);
        $json = json_encode($json);
        ?>

        <!-- Doctor Form -->
        <div id="tab-form">
           <form action="process,php" method="POST">
            <div class="form-row">
               <div class="form-col form-label w-50">
                   <label for="">Doctor Name</label>
               </div>
               <div class="form-col">
                   <input type="text" name="dname" value="<?php echo $row['doc_name']; ?>" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " placeholder="Enter your full name" autofocus>
               </div>
           </div>


           <div class="form-row">
               <div class="form-col form-label w-50">
                   <label for="">User name</label>
               </div>
               <div class="form-col">
                   <input type="text" name="uname" value="<?php echo $row['user_name']; ?>"  
                   data-validation="required alphanumeric server" 
                   data-validation-url="form_validate.php" 
                   data-validation-param-name="edit_uname" 
                   data-validation-req-params='<?php echo $json; ?>' 
                   data-validation-allowing="_" 
                   data-sanitize="trim lower">
               </div>
           </div>


           <div class="form-row">
            <div class="form-col form-label w-50">
                <label for="">Address</label>
            </div>
            <div class="form-col">
                <textarea data-validation="required" data-validation-error-msg="Please enter your address" name="dadd"><?php echo $row['address']; ?></textarea>
            </div>
        </div>


        <div class="form-row">
            <div class="form-col form-label w-50">
                <label for="">Mobile number</label>
            </div>
            <div class="form-col">
                <input data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="dphno" maxlength="10" value="<?php echo $row['ph_no']; ?>">
            </div>
        </div>


        <div class="form-row">
            <div class="form-col form-label w-50">
                <label for="">Designation</label>
            </div>
            <div class="form-col">
                <select name="d_desig" data-validation="required" data-validation-error-msg="Please select designation">
                 <option value="Junior Doctor" <?php if($row['designation']=="Junior Doctor"){ echo "selected";} ?>>Junior Doctor</option>
                 <option value="General Practitioner" <?php if($row['designation']=="General Practitioner"){ echo "selected";} ?>>General Practitioner</option>
                 <option value="Consultant" <?php if($row['designation']=="Consultant"){ echo "selected";} ?>>Consultant</option>
                 <option value="SAS Doctor" <?php if($row['designation']=="SAS Doctor"){ echo "selected";} ?>>SAS Doctor</option>
                 <option value="Senior Doctor" <?php if($row['designation']=="Senior Doctor"){ echo "selected";} ?>>Senior Doctor</option>
             </select>
         </div>
     </div>


     <div class="form-row">
        <div class="form-col form-label w-50">
            <label for="">Experience </label>
        </div>
        <div class="form-col">
            <span class="muted-inner">years</span>
            <input type="text" name="d_exp" data-validation="number length" data-validation-length="1-2" data-validation-error-msg="Enter valid number of years" value="<?php echo $row['exp']; ?>">
        </div>
    </div>


    <div class="form-row">
        <div class="form-col form-label w-50">
            <label for="">Gender</label>
        </div>
        <div class="form-col">
            <div class="form-radio-btn">
                <input type="radio" name="d_gen" value="male" <?php if($row['gender']=="Male"){ echo "checked";} ?>>
                Male
            </div>
            <div class="form-radio-btn">
                <input type="radio" name="d_gen" value="female" <?php if($row['gender']=="Female"){ echo "checked";} ?>>
                Female
            </div>
            <div class="form-radio-btn">
                <input type="radio" data-validation="required" data-validation-error-msg="Please select an option" name="d_gen" value="other" <?php if($row['gender']=="Others"){ echo "checked";} ?>>
                Others
            </div>
        </div>
    </div>


    <div class="form-row">
       <div class="form-col form-btn">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <button class="btn btn-submit" type="submit" name="change_doc_profile">Submit</button>
    </div>
</div>
</form>
</div>
<?php endif ?>






















<!-- For patient Profile -->
<?php if ($row['user_role']=='patient'): ?>
    <?php $user = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM patients WHERE user_id = '$user_id'")); ?>
    <table id="tab-form">
        <form action="process.php" method="POST">
            <tr>
                <td>Name :</td>
                <td><input type="text" value="<?php echo $user['name']; ?>" name="name"></td>
            </tr>
            <tr>
                <td>Address :</td>
                <td><input type="text" value="<?php echo $user['address']; ?>" name="address"></td>
            </tr>
            <tr>
                <td>Mobile No. :</td>
                <td><input type="text" maxlength="10"> value="<?php echo $user['mobileno']; ?>" name="mobileno"></td>
            </tr>
            <tr>
                <td>Guardian name :</td>
                <td><input type="text" value="<?php echo $user['guardian']; ?>" name="guardian"></td>
            </tr>
            <tr>
                <td>Emergency contact :</td>
                <td><input type="text" maxlength="10"> value="<?php echo $user['emergencycontact']; ?>" name="emergencycontact"></td>
            </tr>
            <tr>
                <td>Blood group :</td>
                <td>
                    <select name="bgroup">
                        <option value="A+" <?php if($user['bgroup']=="A+"){ echo "selected"; } ?>>A+</option>
                        <option value="A-" <?php if($user['bgroup']=="A-"){ echo "selected"; } ?>>A-</option>
                        <option value="B+" <?php if($user['bgroup']=="B+"){ echo "selected"; } ?>>B+</option>
                        <option value="B-" <?php if($user['bgroup']=="B-"){ echo "selected"; } ?>>B-</option>
                        <option value="AB+" <?php if($user['bgroup']=="AB+"){ echo "selected"; } ?>>AB+</option>
                        <option value="AB-" <?php if($user['bgroup']=="AB-"){ echo "selected"; } ?>>AB-</option>
                        <option value="O+" <?php if($user['bgroup']=="O+"){ echo "selected"; } ?>>O+</option>
                        <option value="O-" <?php if($user['bgroup']=="A-"){ echo "selected"; } ?>>O-</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Current mdeication :</td>
                <td><input type="text" value="<?php echo $user['cur_medication']; ?>" name="cur_medication"></td>
            </tr>
            <tr>
                <td>Email id :</td>
                <td><input type="text" value="<?php echo $user['email_id']; ?>" name="email_id"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="hidden" value="<?php echo $user['user_id']; ?>" name="user_id">
                    <button class="btn" type="submit" name="edit_patient">Submit</button>
                </td>
            </tr>
        </form>
    </table>
<?php endif ?>



















<!-- For laboratorian Profile -->
<?php if ($row['user_role']=='laboratorian'): ?>

<?php endif ?>
</td>
<?php include 'master/foot.php'; 
?>