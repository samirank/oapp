<?php
include 'master/head.php';
include 'master/db.php';
?>
<td id="content">
    <style>
    #view-form td, #view-form th {
        white-space: initial;
    }
    #view-form td{
        padding: unset;
    }
</style>
<ul class="breadcrumb">
    <li><a href="dashboard.php">Dashboard</a></li>
    <li>Doctors</li>
</ul>
<div>
    <a class="btn-a btn-lg" href="doc_reg.php">Add Doctor</a>
</div>
<table id="view-form" cellspacing="0">
        <thead>
            <tr>
                <th>Slno</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Phone No</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Status</th>                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count=1;
            $result = mysqli_query($con,"SELECT * FROM doctors JOIN departments ON doctors.dept=departments.dept_id JOIN users ON doctors.user_id=users.user_id");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["doc_name"]; ?></td>
                        <td><?php echo $row["gender"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>
                        <td><?php echo $row["ph_no"]; ?></td>
                        <td><?php echo $row["designation"]; ?></td>
                        <td><?php echo $row["dept_name"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td>
                            <a class="doc-anchor font-10" href="manage_schedule.php?doc_id=<?php echo $row['doc_id']; ?>">Manage Schedule</a>
                            <a class="doc-anchor font-10" href="profile.php?id=<?php echo $row['user_id']; ?>">View Profile</a>
                        </td>
                    </tr>
                    <?php
                    $count++;
                }
            } else {
                echo '<tr><td colspan="10" style="text-align:center;">No records found !</td></tr>';
            }
            ?>
        </tbody>
    </table>
</td>
<?php
include 'master/foot.php';
?>             