<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<td class="content">
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="departments.php">Departments</a></li>
    </ul>
    <div>
    	<a id="add_dept_btn" class="btn-a" href="add_dept.php">Add Department</a>
    </div>
    <table id="view-form" cellspacing="0">
            <tr>
            	<th>Sl.No.</th>
                <th>Dept id</th>
                <th>Dept Name</th>
                <th>Action</th>
            </tr>
            <?php
            $count=1;
            $result = mysqli_query($con,"select * from departments");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["dept_id"] ?></td>
                        <td><?php echo $row["dept_name"] ?></td>
                        <td><a href="">Delete</a></td>
                    </tr>
                    <?php
                    $count++;
                }
            } else {
                echo '<tr><td colspan="11" style="text-align:center;">No records found !</td></tr>';
            }
            ?>
        </table>
</td>
<?php include('master/foot.php'); ?>