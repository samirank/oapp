<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<td class="content">
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="bookings.php">Bookings</a></li>
    </ul>
    <table id="view-form" cellspacing="0">
        <thead>
            <tr>
                <th>Sl.No.</th>
                <th>Booking id</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Department</th>
                <th>Date of booking</th>
                <th>Date of appointment</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count=1;
            if ($_SESSION['log_role']=="admin") {
                $sql = "SELECT b.booking_id, p.name AS 'patient_name', d.doc_name, dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id";
            }
            if ($_SESSION['log_role']=="patient") {
                $sql = "SELECT b.booking_id, p.name AS 'patient_name', d.doc_name, dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id WHERE p.user_id = {$_SESSION['log_id']}";
            }
            if ($_SESSION['log_role']=="doctor") {
                $sql = "SELECT b.booking_id, p.name AS 'patient_name', d.doc_name, dp.dept_name, b.date_of_booking, b.date_of_appointment FROM bookings b JOIN schedule s ON b.schedule_id=s.schedule_id JOIN doctors d ON s.doc_id=d.doc_id JOIN patients p ON b.patient_id = p.patient_id JOIN departments dp ON d.dept=dp.dept_id WHERE d.user_id = {$_SESSION['log_id']}";
            }
            $result = mysqli_query($con,$sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["booking_id"] ?></td>
                        <td><?php echo $row["patient_name"] ?></td>
                        <td><?php echo $row["doc_name"] ?></td>
                        <td><?php echo $row["dept_name"] ?></td>
                        <td><?php echo $row["date_of_booking"] ?></td>
                        <td><?php echo $row["date_of_appointment"] ?></td>
                    </tr>
                    <?php
                    $count++;
                }
            } else {
                echo '<tr><td colspan="11" style="text-align:center;">No records found !</td></tr>';
            }
            ?>
        </tbody>
    </table>
</td>
<?php include('master/foot.php'); ?>