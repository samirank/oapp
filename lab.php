<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<td class="content">
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="lab.php">Laboratory</a></li>
    </ul>
    <div>
    	<a id="add_dept_btn" class="btn-a" href="add_labtest.php">Add Lab Test</a>
    </div>
    <table id="view-form" cellspacing="0">
            <tr>
            	<th>Sl.No.</th>
                <th>Lab Id</th>
                <th>Lab Name</th>
                <th>Action</th>
            </tr>
            <?php
            $count=1;
            $result = mysqli_query($con,"select * from lab");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["lab_id"] ?></td>
                        <td><?php echo $row["lab_name"] ?></td>
                        <td><a href="" class="btn-d">Delete</a></td>
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