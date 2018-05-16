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
    <?php if(isset($_GET['edit'])){ ?>
        <div class="edit-dept">
            <?php $result = mysqli_query($con,"SELECT * from lab_test WHERE lab_test_id = '{$_GET['edit']}'");
            $row = mysqli_fetch_assoc($result); ?>
            Current name : &nbsp; <span style="font-weight: bold;"><?php echo $row['lab_test']; ?></span>
            <form action="process.php" method="POST">
                <label for="new_name">Enter new name:</label>
                <input type="text" name="lab_test_id" value="<?php echo $row['lab_test_id']; ?>" hidden>
                <input style="width: unset;" type="text" name="new_name">
                <button class="btn" type="submit" name="edit_lab_name">Submit</button>
            </form>
        </div>
        <?php } ?>
    <table id="view-form" cellspacing="0">
            <tr>
            	<th>Sl.No.</th>
                <th>Lab Id</th>
                <th>Lab Name</th>
                <th>Action</th>
            </tr>
            <?php
            $count=1;
            $result = mysqli_query($con,"select * from lab_test");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row["lab_test_id"] ?></td>
                        <td><?php echo $row["lab_test"] ?></td>
                        <td><a href="lab.php?edit=<?php echo $row['lab_test_id'];?>" class="btn-e">Edit</a></td>
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