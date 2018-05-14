<?php include 'master/head.php'; ?>
<?php include 'master/db.php'; ?>
<td id="content">
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="doctors.php">Doctors</a></li>
        <li>Doctor Registration</li>
    </ul>
    <form action="process.php" method="post">
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
                <td>Doctor Name :</td>
                <td><input type="text" name="dname"></td>
            </tr>
            <tr>
                <td>User name</td>
                <td><input type="text" name="uname"></td>
            </tr>
            <tr>
                <td>Address :</td>
                <td><textarea name="dadd"></textarea></td>
            </tr>
            <tr>
                <td>Phone Number :</td>
                <td><input type="text" name="dphno" maxlength="10"></td>
            </tr>
            <tr>
                <td>Designation :</td>
                <td><select name="d_desig">
                    <option selected disabled>Select</option>
                    <option value="Junior Doctor">Junior Doctor</option>
                    <option value="General Practitioner">General Practitioner</option>
                    <option value="Consultant">Consultant</option>
                    <option value="SAS Doctor">SAS Doctor</option>
                    <option value="Senior Doctor">Senior Doctor</option>
                </select></td>
            </tr>
            <tr>
                <td>Department :</td>
                <td>
                    <select name="d_dept">
                        <option value="" disabled selected>Select</option>
                        <?php $result = mysqli_query($con,"select * from departments");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <option value="<?php echo $row['dept_id']; ?>"><?php echo $row['dept_name']; ?></option>
                                <?php }}?>                       
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Experience :</td>
                        <td><input type="text" name="d_exp"></td>
                    </tr>
                    <tr>
                        <td>Gender :</td>
                        <td>
                            <input type="radio" name="d_gen" value="Male"> Male &emsp;
                            <input type="radio" name="d_gen" value="Female"> Female &emsp;
                            <input type="radio" name="d_gen" value="Other"> Other
                        </td>
                    </tr>
                    <!-- <tr>
                        <td>Email</td>
                        <td>
                            <input type="text" name="email">
                        </td>
                    </tr> -->
                    <tr>
                        <td>Password</td>
                        <td>
                            <input type="password" name="pass">
                        </td>
                    </tr>
                    <tr>
                        <td>Confirm password</td>
                        <td>
                            <input type="password" name="cnf_pass">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button class="btn" type="submit" name="d_submit">Submit</button>
                            <button class="btn" type="reset">Reset</button>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
        <?php include 'master/foot.php'; ?>             