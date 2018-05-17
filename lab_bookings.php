<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<?php if ($_SESSION['log_role']=="doctor"): ?>
    <?php header("location: bookings.php") ?>
<?php endif ?>
<td class="content">
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li>Lab bookings</li>
    </ul>
    <?php if ($_SESSION['log_role']!="laboratorian"): ?>
        <div>
            <a class="btn-a btn-lg" href="bookings.php<?php if(isset($_GET['id'])) echo "?id=".$_GET['id']; ?>">Doctor bookings</a>
        </div>
    <?php endif ?>
    <table id="view-form" cellspacing="0">
        <thead>
            <tr>
                <th>Booking id</th>
                <th>Patient</th>
                <th>Test name</th>
                <th>Date of booking</th>
                <th>Date of appointment</th>
                <th>status</th>
                <?php if (($_SESSION['log_role']=='patient') || ($_SESSION['log_role']=='laboratorian')){ ?>
                    <th></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($_SESSION['log_role']=="patient") {
                $sql = "SELECT b.booking_id, b.date_of_booking, b.date_of_test,b.status ,t.lab_test,p.name,p.user_id FROM lab_bookings b JOIN patients p on b.patient_id=p.patient_id JOIN lab_test t ON b.test_id=t.lab_test_id WHERE p.user_id = {$_SESSION['log_id']}";
            }else{
                $sql = "SELECT b.booking_id, b.date_of_booking, b.date_of_test,b.status ,t.lab_test,p.name,p.user_id FROM lab_bookings b JOIN patients p on b.patient_id=p.patient_id JOIN lab_test t ON b.test_id=t.lab_test_id";
                if (isset($_GET['id'])) {
                    $result = mysqli_query($con,"SELECT * from users where user_id='{$_GET['id']}'");
                    $row = mysqli_fetch_assoc($result);
                    if ($row['user_role']=="patient") {
                        $sql = "SELECT b.booking_id, b.date_of_booking, b.date_of_test,b.status ,t.lab_test,p.name,p.user_id FROM lab_bookings b JOIN patients p on b.patient_id=p.patient_id JOIN lab_test t ON b.test_id=t.lab_test_id WHERE p.user_id = {$_GET['id']}";
                    }
                }
            }
            $result = mysqli_query($con,$sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row["booking_id"] ?></td>
                        <td><a style="color: #6c5ce7;" href="profile.php?id=<?php echo $row['user_id']; ?>"><?php echo $row["name"] ?></a></td>
                        <td><?php echo $row["lab_test"] ?></td>
                        <td><?php echo $row["date_of_booking"] ?></td>
                        <td><?php echo $row["date_of_test"] ?></td>
                        <td><?php echo $row["status"] ?></td>
                        <form action="process.php" method="POST">
                            <?php if ($_SESSION['log_role']=='patient') { ?>
                                <td>
                                    <input type="text" name="booking_id" value="<?php echo $row['booking_id']; ?>" hidden>
                                    <button class="btn-d" style="width: 55px;" type="submit" name="cancel_appointment" <?php if ($row['status'] != "active") { echo "disabled"; } ?>><?php if ($row['status'] == "active") { echo "cancel"; }else{ echo $row['status'];} ?></button>
                                <?php } ?>
                            </td>
                        </form>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="11" style="text-align:center;">No records found !</td></tr>';
            }
            ?>
        </tbody>
    </table>
</td>
<?php include('master/foot.php'); ?>