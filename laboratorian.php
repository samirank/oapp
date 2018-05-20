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


<!-- Change Password -->
<?php if (isset($_GET['change_pass'])): ?>
    <?php $username = mysqli_fetch_array(mysqli_query($con,"SELECT user_name FROM users WHERE user_id='{$_GET['change_pass']}'")); 
    $username = $username[0]; ?>
    <div class="change-pass" style="margin-bottom: 20px;">
        <form action="process.php" method="POST">
            <div class="change-pass-header">Changing password for <b><?php echo $username; ?></b></div>
            Enter new password :
            <input type="password" data-validation="strength" data-validation-strength="2" name="pass">
            &emsp;&emsp;&emsp;
            Confirm password :
            <input type="password" data-validation="confirmation" data-validation-confirm="pass" data-validation-error-msg="Entered value do not match with your password." name="cnf_pass">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            &emsp;&emsp;
            <button class="btn" type="submit" name="change_pass">Change</button>
        </form>
    </div>
<?php endif ?>


<!-- Add laboratorian -->
<?php if ((isset($_GET['add'])) && !(isset($_GET['edit']))): ?>
<div class="change-pass" style="display: block; margin-bottom: 20px;">
    <form action="process.php" method="POST">
        <div id="tab-form" style="margin: auto 25%;">

            <div class="form-row">
                <div class="form-col form-label w-50">
                    <label for="">Name :</label>
                </div>
                <div class="form-col">
                    <input type="text" name="name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" placeholder="Enter your full name" autofocus>
                </div>
            </div>


            <div class="form-row">
                <div class="form-col form-label w-50">
                    <label for="">Username</label>
                </div>
                <div class="form-col">
                    <input type="text" name="user_name" data-validation="required alphanumeric server" data-validation-param-name="username" data-validation-url="form_validate.php" data-validation-allowing="_" data-sanitize="trim lower" placeholder="Enter username">
                </div>
            </div>


            <div class="form-row">
                <div class="form-col form-label w-50">
                    <label for="">Email id :</label>
                </div>
                <div class="form-col">
                    <input type="text" name="email_id" data-validation="email">
                </div>
            </div>



            <div class="form-row">
                <div class="form-col form-label w-50">
                    <label for="">Mobile no:</label>
                </div>
                <div class="form-col">
                 <input type="text" maxlength="10" name="phno" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number">
             </div>
         </div>


         <div class="form-row">
            <div class="form-col form-label w-50">
                <label for="">Password</label>
            </div>
            <div class="form-col">
                <input type="password" data-validation="strength" data-validation-strength="2" name="pass">
            </div>
        </div>


        <div class="form-row">
            <div class="form-col form-label w-50">
                <label for="">Confirm password</label>
            </div>
            <div class="form-col">
                <input type="password" data-validation="confirmation" data-validation-confirm="pass" data-validation-error-msg="Entered value do not match with your password." name="cnf_pass">
            </div>
        </div>


        <div class="form-row">
            <div class="form-col form-btn">
                <button class="btn btn-submit" type="submit" name="add_laboratorian">Submit</button>
            </div>
        </div>


    </div>
</form>
</div>
<?php endif ?>


<?php if ((isset($_GET['edit'])) && !(isset($_GET['add']))): ?>
<?php $result = mysqli_query($con,"SELECT * FROM laboratorian JOIN users ON laboratorian.user_id=users.user_id WHERE laboratorian.laboratorian_id = {$_GET['edit']}");
if (mysqli_num_rows($result)==1) {
    $row = mysqli_fetch_assoc($result);
    $json = json_encode(array("user_id"=>$row['user_id']));
    ?>

    <!-- Edit profile -->
    <div class="change-pass" style="display: block; margin-bottom: 20px;">
        <form action="process.php" method="POST">
            <div id="tab-form" style="margin: auto 25%;">

                <div class="form-row">
                    <div class="form-col form-label w-50">
                        <label for="">Name :</label>
                    </div>
                    <div class="form-col">
                        <input type="text" name="name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" placeholder="Enter your full name" value="<?php echo $row['name']; ?>" autofocus>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-col form-label w-50">
                        <label for="">Username</label>
                    </div>
                    <div class="form-col">
                        <input type="text" name="user_name" data-validation="required alphanumeric server" data-validation-param-name="edit_uname" data-validation-req-params='<?php echo $json; ?>' data-validation-url="form_validate.php" data-validation-allowing="_" data-sanitize="trim lower" placeholder="Enter username" value="<?php echo $row['user_name']; ?>">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-col form-label w-50">
                        <label for="">Email id :</label>
                    </div>
                    <div class="form-col">
                        <input type="text" name="email_id" data-validation="email" value="<?php echo $row['email_id']; ?>">
                    </div>
                </div>



                <div class="form-row">
                    <div class="form-col form-label w-50">
                        <label for="">Mobile no:</label>
                    </div>
                    <div class="form-col">
                     <input type="text" maxlength="10" name="phno" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" value="<?php echo $row['ph_no']; ?>">
                 </div>
             </div>



             <div class="form-row">
                <div class="form-col form-label w-50">
                    <label for="">Date of registration :</label>
                </div>
                <div class="form-col">
                    <?php echo $row['date_of_reg']; ?>
                </div>
            </div>


            <div class="form-row">
                <div class="form-col form-btn">
                    <a class="btn btn-submit" href="laboratorian.php?change_pass=<?php echo $row['user_id']; ?>">Change pasword</a>
                    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                    <button class="btn btn-submit" type="submit" name="edit_laboratorian">Submit</button>
                </div>
            </div>


        </div>
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