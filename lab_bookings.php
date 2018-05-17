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
            <a class="btn-a btn-lg" style="width: 200px;" href="bookings.php<?php if(isset($_GET['id'])) echo "?id=".$_GET['id']; ?>">View doctor bookings</a>
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
                <th></th>
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
                    if ($row['status']=='active') {
                       if ((strtotime($row['date_of_test']) - strtotime('today'))<=0) {
                        $row['status'] = "completed";
                        mysqli_query($con,"UPDATE lab_bookings SET `status`='completed' WHERE booking_id = {$row['booking_id']}");
                    }
                }
                ?>
                <tr>
                    <td><?php echo $row["booking_id"] ?></td>
                    <td><a style="color: #6c5ce7;" href="profile.php?id=<?php echo $row['user_id']; ?>"><?php echo $row["name"] ?></a></td>
                    <td><?php echo $row["lab_test"] ?></td>
                    <td><?php echo $row["date_of_booking"] ?></td>
                    <td><?php echo $row["date_of_test"] ?></td>
                    <?php if ($_SESSION['log_role']=='patient') { ?>
                        <td>
                            <?php if ($row['status'] == "active"): ?>
                                <a class="btn-d" style="width: 55px;" href="process.php?cancel_lab=<?php echo $row['booking_id']; ?>">cancel</a>
                                <?php else: ?>
                                    <button class="btn-e" style="width: auto; cursor: default; background-color: #<?php echo ($row['status']=="completed" ? "6bbf72": "777"); ?>;" disabled> <?php echo $row['status']; ?> </button>
                                <?php endif ?>
                            </td>
                        <?php }else{ ?>
                            <td>
                                <button class="btn-e" style="width: 60px; cursor: default; background-color: #<?php echo ($row['status']=="completed" ? "6bbf72": ($row['status']=="active" ? "6c5ce7": "777")); ?>;" disabled> <?php echo $row['status']; ?> </button>
                            </td>
                        <?php } ?>
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