<?php include('master/head.php'); ?>
<?php include('master/db.php'); ?>
<td class="content">
    <style>
    .edit-dept span.help-block.form-error {
        margin-top: -57px;
        margin-left: 125px;
        font-size: 12px;
    }
</style>
<ul class="breadcrumb">
    <li><a href="dashboard.php">Dashboard</a></li>
    <li>Laboratory</li>
</ul>
<div>
   <a class="btn-a btn-lg" href="lab.php?add=1">Add Lab Test</a>
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


<!-- Edit test name -->
<?php if(isset($_GET['edit']) && !isset($_GET['add'])){ ?>
    <div class="edit-dept">
        <?php $result = mysqli_query($con,"SELECT * from lab_test WHERE lab_test_id = '{$_GET['edit']}'");
        $row = mysqli_fetch_assoc($result); ?>
        Current name : &nbsp; <span style="font-weight: bold;"><?php echo $row['lab_test']; ?></span>
        <form action="process.php" method="POST">
            <label for="new_name">Enter new name:</label>
            <input type="text" name="lab_test_id" value="<?php echo $row['lab_test_id']; ?>" hidden>
            <input style="width: unset;" type="text" name="new_name" data-validation="required custom" data-validation-regexp="^([A-Za-z]+)$" data-sanitize="trim capitalize" autofocus>
            <button class="btn" type="submit" name="edit_lab_name">Submit</button>
        </form>
    </div>
<?php } ?>


<!-- Add test -->
<?php if(isset($_GET['add']) && !isset($_GET['edit'])){ ?>
    <div class="change-pass" style="display: block; text-align: center; margin-bottom: 20px;">
        <form action="process.php" method="POST">
           <b> Enter test name:</b>
           <input style="width: unset;" type="text" name="lab_name" data-validation="required custom" data-validation-regexp="^([A-Za-z-\s]+)$" data-sanitize="trim capitalize" autofocus>
           <button class="btn" type="submit" name="add_lab">Submit</button>
       </form>
   </div>
<?php } ?>




<table id="view-form" cellspacing="0">
    <tr>
        <th>Lab Id</th>
        <th>Lab Name</th>
        <th>Days</th>
        <th colspan="2">Action</th>
    </tr>
    <?php
    $result = mysqli_query($con,"select * from lab_test");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row["lab_test_id"] ?></td>
                <td><?php echo $row["lab_test"] ?></td>
                <td style="color: blue;"><?php echo $row["days"] ?></td>
                <td><a style="width: 85px; background-color: #e84393;" href="days.php?edit=<?php echo $row['lab_test_id'];?>" class="btn-e">Manage days</a></td>
                <td><a style="width: 60px;" href="lab.php?edit=<?php echo $row['lab_test_id'];?>" class="btn-e">Edit name</a></td>
            </tr>
            <?php
        }
    } else {
        echo '<tr><td colspan="11" style="text-align:center;">No records found !</td></tr>';
    }
    ?>
</table>
</td>
<?php include('master/foot.php'); ?>