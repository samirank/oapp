<?php
include 'master/head.php';
include 'master/db.php';
?>
<td id="content">
    <ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li>Patients</li>
    </ul>
    <table id="view-form" cellspacing="0">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Ph. No.</th>
                    <th>Gender</th>
                    <th>B Group</th>
                    <th>Status</th>
                    <th>Action</th>                
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($con,"SELECT * FROM patients JOIN users ON patients.user_id=users.user_id");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row["patient_id"]; ?></td>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["address"]; ?></td>
                            <td><?php echo $row["mobileno"]; ?></td>
                            <td><?php echo $row["gender"]; ?></td>
                            <td><?php echo $row["bgroup"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <form action="process.php" method="POST"></form>
                            <td>
                                <a class="doc-anchor" href="bookings.php?id=<?php echo $row['user_id']; ?>">View Bookings</a>
                                <a class="doc-anchor" href="profile.php?id=<?php echo $row['user_id']; ?>">View Profile</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="10" style="text-align:center;">No records found !</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </td>
<?php include 'master/foot.php'; ?>             