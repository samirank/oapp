<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<td class="content">
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li>Departments</li>
    </ul>
    <div>
    	<a id="btn-lg" class="btn-a" href="add_dept.php">Add Department</a>
    </div>
    <?php if(isset($_GET['edit'])){ ?>
        <div class="edit-dept">
            <?php $result = mysqli_query($con,"SELECT * from departments WHERE dept_id = '{$_GET['edit']}'");
            $row = mysqli_fetch_assoc($result); ?>
            Current name : &nbsp; <span style="font-weight: bold;"><?php echo $row['dept_name']; ?></span>
            <form action="process.php" method="POST">
                <label for="new_name">Enter new name:</label>
                <input type="text" name="dept_id" value="<?php echo $row['dept_id']; ?>" hidden>
                <input style="width: unset;" type="text" name="new_name">
                <button class="btn" type="submit" name="edit_dept_name">Submit</button>
            </form>
        </div>
        <?php } ?>
        <table id="view-form" cellspacing="0">
           <thead>
            <tr>
               <th>Sl.No.</th>
               <th>Dept id</th>
               <th>Dept Name</th>
               <th>Action</th>
           </tr>
       </thead>
       <tbody>
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
                    <td>
                        <a style="width: 60px;" href="departments.php?edit=<?php echo $row['dept_id']; ?>" class="btn-e">Edit name</a>
                    </td>
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