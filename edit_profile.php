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
        $row = mysqli_fetch_assoc($result); ?>

        <!-- Doctor Form -->
        <table id="tab-form">
            <form action="process.php" method="POST">
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
                    <td>Doctor Name :</td>
                    <td><input type="text" name="dname" value="<?php echo $row['doc_name']; ?>"></td>
                </tr>
                <tr>
                    <td>User name</td>
                    <td><input type="text" name="uname" value="<?php echo $row['user_name']; ?>" disabled></td>
                </tr>
                <tr>
                    <td>Address :</td>
                    <td><textarea name="dadd"><?php echo $row['address']; ?></textarea></td>
                </tr>
                <tr>
                    <td>Phone Number :</td>
                    <td><input type="text" name="dphno" maxlength="10" value="<?php echo $row['ph_no']; ?>"></td>
                </tr>
                <tr>
                    <td>Designation :</td>
                    <td><select name="d_desig">
                        <option>Select</option>
                        <option value="Junior Doctor" <?php if($row['designation']=="Junior Doctor"){ echo "selected";} ?>>Junior Doctor</option>
                        <option value="General Practitioner" <?php if($row['designation']=="General Practitioner"){ echo "selected";} ?>>General Practitioner</option>
                        <option value="Consultant" <?php if($row['designation']=="Consultant"){ echo "selected";} ?>>Consultant</option>
                        <option value="SAS Doctor" <?php if($row['designation']=="SAS Doctor"){ echo "selected";} ?>>SAS Doctor</option>
                        <option value="Senior Doctor" <?php if($row['designation']=="Senior Doctor"){ echo "selected";} ?>>Senior Doctor</option>
                    </select></td>
                </tr>
                
                <tr>
                    <td>Experience (years) :</td>
                    <td><input type="text" name="d_exp" value="<?php echo $row['exp']; ?>"></td>
                </tr>
                <tr>
                    <td>Gender :</td>
                    <td>
                        <input type="radio" name="d_gen" value="Male" <?php if($row['gender']=="Male"){ echo "checked";} ?>> Male &emsp;
                        <input type="radio" name="d_gen" value="Female" <?php if($row['gender']=="Female"){ echo "checked";} ?>> Female &emsp;
                        <input type="radio" name="d_gen" value="Other" <?php if($row['gender']=="Other"){ echo "checked";} ?>> Other
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <button style="width: 125px;" class="btn" type="submit" name="change_doc_profile">Save Changes</button>
                    </td>
                </tr>
            </form>
        </table>
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