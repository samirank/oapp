<?php include 'master/head.php'; ?>
<?php include 'master/db.php'; ?>
<td id="content">
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="doc-reg.php">Doctor Registration</a></li>
    </ul>
    <form action="process.php" method="post">
        <table id="tab-form">
            <tr>
                <td>Doctor Name :</td>
                <td><input type="text" name="dname"></td>
            </tr>
            <tr>
                <td>Address :</td>
                <td><textarea name="dadd"></textarea></td>
            </tr>
            <tr>
                <td>Phone Number :</td>
                <td><input type="text" name="dphno"></td>
            </tr>
            <tr>
                <td>Designation :</td>
                <td><input type="text" name="d_desig"></td>
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
                        <input type="radio" name="d_gen"> Male &emsp;
                        <input type="radio" name="d_gen"> Female
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