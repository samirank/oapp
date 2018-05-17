<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<?php if ($_SESSION['log_role']=="laboratorian"): ?>
    <?php header("location: lab_bookings.php") ?>
<?php endif ?>
<td class="content">
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li>Bookings</li>
    </ul>
    <?php if ($_SESSION['log_role']!="doctor"): ?>
        <div>
            <a class="btn-a btn-lg" href="lab_bookings.php<?php if(isset($_GET['id'])) echo "?id=".$_GET['id']; ?>">Lab bookings</a>
        </div>
    <?php endif ?>
    <table id="view-form" cellspacing="0">
        <thead>
            <tr>
                <th>Booking id</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Department</th>
                <th>Date of booking</th>
                <th>Date of appointment</th>
                <?php if ($_SESSION['log_role']=='patient') { ?>
                    <th></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($_SESSION['log_role']=="admin") {
                $sql = "SELECT b.booking_id, b.status, p.name AS 'patient_name', p.user_id, d.doc_name, d.user_id AS 'doc_user_id', dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id";
                if (isset($_GET['id'])) {
                    $result = mysqli_query($con,"SELECT * from users where user_id='{$_GET['id']}'");
                    $row = mysqli_fetch_assoc($result);
                    if ($row['user_role']=="doctor") {
                        $sql = "SELECT b.booking_id, b.status, p.name AS 'patient_name', p.user_id, d.doc_name, d.user_id AS 'doc_user_id', dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id WHERE d.user_id = {$_GET['id']}";
                    }
                    if ($row['user_role']=="patient") {
                        $sql = "SELECT b.booking_id, b.status, p.name AS 'patient_name', p.user_id, d.doc_name, d.user_id AS 'doc_user_id', dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id WHERE p.user_id = {$_GET['id']}";
                    }
                }
            }
            if ($_SESSION['log_role']=="patient") {
                $sql = "SELECT b.booking_id, b.status, p.name AS 'patient_name', p.user_id, d.doc_name, d.user_id AS 'doc_user_id', dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id WHERE p.user_id = {$_SESSION['log_id']}";
            }
            if ($_SESSION['log_role']=="doctor") {
                $sql = "SELECT b.booking_id, b.status, p.name AS 'patient_name', p.user_id, d.doc_name, d.user_id AS 'doc_user_id', dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id WHERE d.user_id = {$_SESSION['log_id']}";
            }
            $result = mysqli_query($con,$sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row["booking_id"] ?></td>
                        <td><a style="color: #6c5ce7;" href="profile.php?id=<?php echo $row['user_id']; ?>"><?php echo $row["patient_name"] ?></a></td>
                        <td><a style="color: #6c5ce7;" href="profile.php?id=<?php echo $row['doc_user_id']; ?>"><?php echo $row["doc_name"] ?></a></td>
                        <td><?php echo $row["dept_name"] ?></td>
                        <td><?php echo $row["date_of_booking"] ?></td>
                        <td><?php echo $row["date_of_appointment"] ?></td>
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