<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<td class="content">
	<ul class="breadcrumb">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li>Departments</li>
    </ul>
    <div>
    	<a class="btn-a btn-lg" href="departments.php?add=1">Add Department</a>
    </div>


    <!-- Display message -->
    <?php if (isset($_SESSION['msg'])): ?>
        <div style="padding: 20px 2px;">
            <span class="msg-alert">
                <?php 
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
                ?>
            </span>
        </div>
    <?php endif ?>


    <!-- Edit department name -->
    <?php if(isset($_GET['edit']) && !isset($_GET['add'])){ ?>
        <div class="edit-dept">
            <?php $result = mysqli_query($con,"SELECT * from departments WHERE dept_id = '{$_GET['edit']}'");
            $row = mysqli_fetch_assoc($result); ?>
            Current name : &nbsp; <span style="font-weight: bold;"><?php echo $row['dept_name']; ?></span>
            <form action="process.php" method="POST">
                <label for="new_name">Enter new name:</label>
                <input type="hidden" name="dept_id" value="<?php echo $row['dept_id']; ?>">
                <input type="text" style="width: unset;" name="new_name" data-validation="required" data-validation-error-msg=" ">
                <button class="btn" type="submit" name="edit_dept_name">Submit</button>
            </form>
        </div>
        <?php } ?>



        <!-- Add department -->
        <?php if(isset($_GET['add']) && !isset($_GET['edit'])){ ?>
            <div class="change-pass" style="display: block; text-align: center; margin-bottom: 20px;">
                <form action="process.php" method="POST">
                 <b> Enter department name:</b>
                 <input style="width: unset;" type="text" name="new_name" data-validation="required" data-validation-error-msg="Required" autofocus>
                 <button class="btn" type="submit" name="add_dept">Submit</button>
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