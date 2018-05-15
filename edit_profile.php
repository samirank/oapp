<?php
include 'master/head.php';
include 'master/db.php'; 
if ($_SESSION['log_role']=="admin") {
    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];
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
        <li>Doctors</li>
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
                    <td><input type="text" name="uname" value="<?php echo $row['user_name']; ?>"></td>
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
        Patient
    <?php endif ?>



    <!-- For laboratorian Profile -->
    <?php if ($row['user_role']=='laboratorian'): ?>

    <?php endif ?>
</td>
<?php include 'master/foot.php'; 
?>