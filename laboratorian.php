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
    <li>Laboratorian</li>
</ul>

<div>
    <a class="btn-a btn-lg" href="laboratorian.php?add=1">Add Laboratorian</a>
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

<?php if ((isset($_GET['add'])) && !(isset($_GET['edit']))): ?>
<div class="change-pass" style="display: block; margin-bottom: 20px;">
    <form action="process.php" method="POST">
        <table id="tab-form" style="margin: auto 25%;">
            <tr>
                <td>Name :</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Email id :</td>
                <td><input type="text" name="email_id"></td>
            </tr>
            <tr>
                <td>Phone no</td>
                <td><input type="text" maxlength="10" name="phno"></td>
            </tr>
            <tr>
                <td>Username :</td>
                <td><input type="text" name="user_name"></td>
            </tr>
            <tr>
                <td>Password :</td>
                <td><input type="password" name="pass"></td>
            </tr>
            <tr>
                <td>Confirm password :</td>
                <td><input type="password" name="cnf_pass"></td>
            </tr>
            <tr>
                <td colspan="2"><button style="margin-left: 17%;" class="btn" type="submit" name="add_laboratorian">Submit</button></td>
            </tr>
        </table>    
    </form>
</div>
<?php endif ?>


<?php if ((isset($_GET['edit'])) && !(isset($_GET['add']))): ?>
<?php $result = mysqli_query($con,"SELECT * FROM laboratorian JOIN users ON laboratorian.user_id=users.user_id WHERE laboratorian.laboratorian_id = {$_GET['edit']}");
if (mysqli_num_rows($result)==1) {
    $row = mysqli_fetch_assoc($result);
    ?>

<!-- Edit profile -->
    <div class="change-pass" style="display: block; margin-bottom: 20px;">
        <form action="process.php" method="POST">
            <table id="tab-form" style="margin: auto 25%;">
                <tr><td colspan="2"><h3>Edit account</h3></td></tr>
                <tr>
                    <td>Name :</td>
                    <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
                </tr>
                <tr>
                    <td>Email id :</td>
                    <td><input type="text" name="email_id" value="<?php echo $row['email_id']; ?>"></td>
                </tr>
                <tr>
                    <td>Phone no</td>
                    <td><input type="text" maxlength="10" name="phno" value="<?php echo $row['ph_no']; ?>"></td>
                </tr>
                <tr>
                    <td>Username :</td>
                    <td><input type="text" value="<?php echo $row['user_name']; ?>" disabled></td>
                </tr>
                <tr>
                            <td>Date of registration :</td>
                            <td><?php echo $row['date_of_reg']; ?></td>
                        </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                        <button style="margin-left: 17%;" class="btn" type="submit" name="edit_laboratorian">Submit</button>
                    </td>
                </tr>
            </table>    
        </form>
    </div>

<?php } ?>
<?php endif ?>

<table id="view-form" cellspacing="0">
        <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>username</th>
                <th>Phone No</th>
                <th>email</th>
                <th>status</th>
                <?php if ($_SESSION['log_role']=="admin"): ?>
                    <th></th>
                    <th></th>
                <?php endif ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($con,"SELECT * FROM laboratorian JOIN users ON laboratorian.user_id=users.user_id");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row["laboratorian_id"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["user_name"]; ?></td>
                        <td><?php echo $row["ph_no"]; ?></td>
                        <td><?php echo $row["email_id"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <?php if ($_SESSION['log_role']=="admin"): ?>
                            <td>
                                <?php if ($row["status"]=='active'): ?>
                                    <a style="width: 55px; background-color: #777;" class="btn-e" href="process.php?suspend=<?php echo $row['user_id']; ?>">Suspend</a>
                                    <?php else: ?>
                                        <a class="btn-e" href="process.php?activate=<?php echo $row['user_id']; ?>">Activate</a>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <a class="btn-e" href="laboratorian.php?edit=<?php echo $row['laboratorian_id']; ?>">Edit</a>
                                </td>
                            <?php endif ?>
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
<?php
include 'master/foot.php';
?>             