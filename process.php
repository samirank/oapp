<?php
session_start();
include ('master/db.php');



// login Validation
if(isset($_POST['login_submit'])){
    $user_name = mysqli_real_escape_string($con,$_POST['uname']);
    $password = mysqli_real_escape_string($con,$_POST['pass']);

    $sql="SELECT *  from users where user_name='$user_name' and password='$password'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['log_id']=$row['user_id'];
        $_SESSION['log_uname']=$row['user_name'];
        $_SESSION['log_role']=$row['user_role'];
        if (isset($_SESSION['schedule_id']) || isset($_SESSION['test_id'])) {
            header("location: book.php");
        }else{
            header("location: dashboard.php");
        }
    }else{
        $_SESSION['login_err'] = "Incorrect username / password";
        header("location: login.php");
    }
}


// Add Department
if (isset($_POST['add_dept'])) {
    $dept_name = $_POST['dept_name'];
    $sql = "INSERT INTO `departments` (`dept_name`) VALUES ('$dept_name')";
    if (mysqli_query($con,$sql)) {
        $_SESSION['msg']="Department added successfully";
        header("location: add_dept.php");
    } else {
        die(mysqli_error($con));
    }
}
if (isset($_POST['add_lab'])) {
    $lab_name = $_POST['lab_name'];
    $sql = "INSERT INTO `lab_test` (`lab_test`) VALUES ('$lab_name')";
    if (mysqli_query($con,$sql)) {
        $_SESSION['msg']="Lab Test added successfully";
        header("location: add_labtest.php");
    } else {
        die(mysqli_error($con));
    }
}

//Add Doctor
if (isset($_POST['d_submit'])) {
    $name = $_POST['dname'];
    $uname = $_POST['uname'];
    $addr = $_POST['dadd'];
    $phno = $_POST['dphno'];
    $desig = $_POST['d_desig'];
    $dept = $_POST['d_dept'];
    $exp = $_POST['d_exp'];
    $gender = $_POST['d_gen'];
    $password = $_POST['pass'];

    mysqli_autocommit($con,false);
    $sql = "INSERT INTO `users` (`user_name`, `user_role`, `password`, `date_of_reg`) VALUES ('$uname', 'doctor', '$password', now())";
    if(!mysqli_query($con,$sql)){
        echo (mysqli_error($con));
        mysqli_rollback($con);
    }

    $sql = "INSERT INTO `doctors` (`user_id`, `doc_name`, `address`, `ph_no`, `designation`, `dept`, `exp`, `gender`) VALUES (LAST_INSERT_ID(), '$name', '$addr', '$phno', '$desig', '$dept', '$exp', '$gender')";
    if(!mysqli_query($con,$sql)){
        echo (mysqli_error($con));
        mysqli_rollback($con);
    }else{
        mysqli_commit($con);
        $_SESSION['msg'] = "Doctor added successfully";
        header("location: doc_reg.php");
    }
}

// Patient Registration
if(isset($_POST['patientreg'])){
    $uname=$_POST["username"];
    $name=$_POST["name"];
    $address=$_POST["address"];
    $mobileno=$_POST["mobileno"];
    $gname=$_POST["guardian"];
    $ecnumber=$_POST["emcont"];
    $gender=$_POST["gender"];
    $bgroup=$_POST["bgroup"];
    $cur_med=$_POST["cur_medication"];
    $email=$_POST["email_id"];
    $password=$_POST["pass"];

    $sql="INSERT INTO `users`(`user_name`, `user_role`, `password`, `date_of_reg`) VALUES ('$uname', 'patient', '$password', now())";
    mysqli_autocommit($con,false);
    if(!mysqli_query($con, $sql)){
        echo mysqli_error($con);
        mysqli_rollback($con);
    }

    $log_id = mysqli_insert_id($con);

    $sql="INSERT INTO `patients`(`name`, `address`, `mobileno`, `guardian`, `emergencycontact`, `gender`, `bgroup`, `cur_medication`, `email_id`, `user_id`) VALUES ('$name','$address','$mobileno','$gname','$ecnumber','$gender','$bgroup','$cur_med','$email', LAST_INSERT_ID())";
    if(!mysqli_query($con, $sql)){
        echo mysqli_error($con);
        mysqli_rollback($con);
    }
    else{
        mysqli_commit($con);
        $_SESSION['msg']="You are registered.";

        $sql="SELECT *  from users where user_id = $log_id";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result)==1){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['log_id']=$log_id;
            $_SESSION['log_uname']=$row['user_name'];
            $_SESSION['log_role']=$row['user_role'];
            if (isset($_SESSION['schedule_id']) || isset($_SESSION['test_id'])) {
                header("location: book.php");
            }else{
                header("location: dashboard.php");
            }   
        }
    }
}


//Add new schdeule
if (isset($_POST['add_schedule'])) {
   $doc_id = $_POST['doc_id'];
   $day = $_POST['day'];
   $time_from =  strtotime($_POST['time_from']);
   $time_to =  strtotime($_POST['time_to']);
   $time_from = date("g:i a", $time_from);
   $time_to = date("g:i a", $time_to);

   $sql = "INSERT INTO `schedule` (`doc_id`, `day`, `time_from`, `time_to`) VALUES ('$doc_id', '$day', '$time_from', '$time_to')";
   if (mysqli_query($con,$sql)) {
    $_SESSION['msg']="Schedule added";
    header("location: manage_schedule.php?doc_id=".$doc_id);
} else {
    die(mysqli_error($con));
} 
}


// Cancel appointment
if (isset($_POST['cancel_appointment'])) {
    $booking_id = $_POST['booking_id'];
    $sql = "UPDATE `bookings` SET `status` = 'cancelled' WHERE `bookings`.`booking_id` = '$booking_id'";
    if (mysqli_query($con,$sql)) {
        header("location: bookings.php");
    }else{
        die(mysqli_error($con));
    }
}

// edit department name
if (isset($_POST['edit_dept_name'])) {
    $dept_id = $_POST['dept_id'];
    $name = $_POST['new_name'];
    $sql = "UPDATE `departments` SET `dept_name` = '$name' WHERE `departments`.`dept_id` = '$dept_id'";
    if (mysqli_query($con,$sql)) {
        header("location: departments.php");
    }else{
        die(mysqli_error($con));
    }
}

//Edit test name
if (isset($_POST['edit_lab_name'])) {
    $labtest_id = $_POST['lab_test_id'];
    $name = $_POST['new_name'];
    $sql = "UPDATE `lab_test` SET `lab_test` = '$name' WHERE `lab_test`.`lab_test_id` = '$labtest_id'";
    if (mysqli_query($con,$sql)) {
        header("location: lab.php");
    }else{
        die(mysqli_error($con));
    }
}

// Change password
if (isset($_POST['change_pass'])) {
    $user_id =  $_POST['user_id'];
    $pass = $_POST['pass'];

    $sql = "UPDATE `users` SET `password` = '$pass' WHERE `users`.`user_id` = '$user_id'";
    if (mysqli_query($con,$sql)) {
        $_SESSION['msg'] = "Password Changed";
        header("location: profile.php?id=$user_id");
    }else{
       die(mysqli_error($con));
   }
}

// Edit Doctor profile
if (isset($_POST['change_doc_profile'])) {
    print_r($_POST);
    $dname = $_POST['dname'];
    $uname = $_POST['uname'];
    $dadd = $_POST['dadd'];
    $dphno = $_POST['dphno'];
    $d_desig = $_POST['d_desig'];
    $d_exp = $_POST['d_exp'];
    $d_gen = $_POST['d_gen'];
    $user_id = $_POST['user_id'];
    
    $sql = "UPDATE `doctors` SET `doc_name`='$dname',`address`='$dadd',`ph_no`='$dphno',`designation`='$d_desig',`exp`='$d_exp',`gender`='$d_gen' WHERE user_id = '$user_id'";

    if (mysqli_query($con,$sql)) {
        $_SESSION['msg'] = "Profile Updated";
        header("location: profile.php?id=$user_id");
    }else{
       die(mysqli_error($con));
   }
}

// Suspend account
if (isset($_GET['suspend'])) {
    $user_id = $_GET['suspend'];
    $sql = "UPDATE `users` SET `status` = 'suspended' WHERE `users`.`user_id` = '$user_id'";
    if (mysqli_query($con,$sql)) {
        $_SESSION['msg'] = "Account suspended";
        header("location: profile.php?id=$user_id");
    }else{
       die(mysqli_error($con));
   }
}


// Activate account
if (isset($_GET['activate'])) {
    $user_id = $_GET['activate'];
    $sql = "UPDATE `users` SET `status` = 'active' WHERE `users`.`user_id` = '$user_id'";
    if (mysqli_query($con,$sql)) {
        $_SESSION['msg'] = "Account activated";
        header("location: profile.php?id=$user_id");
    }else{
       die(mysqli_error($con));
   }
}


// Delete Schedule
if (isset($_GET['delete_schedule'])) {
    $schedule_id = $_GET['delete_schedule'];
    $sql = "UPDATE `schedule` SET `status` = 'deleted' WHERE `schedule_id` = '$schedule_id'";
    if (mysqli_query($con,$sql)) {
        header("location: manage_schedule.php?doc_id={$_GET['doc_id']}");
    }else{
       die(mysqli_error($con));
   }
}











// Add/delete test days
if (isset($_POST['test_day'])) {

    // Insertion sort
    function insertion_sort($array){
        for($i=0;$i<count($array);$i++){
            $val = $array[$i];
            $j = $i-1;
            while($j>=0 && $array[$j] > $val){
                $array[$j+1] = $array[$j];
                $j--;
            }
            $array[$j+1] = $val;
        }
        return $array;
    }

    // Function to convert days to number
    function days_to_num($array){
        foreach ($array as $key => $value){
            $array[$key] = date('N',strtotime($value));
        }
        return $array;
    }

    // Function to convert numbers to days
    function num_to_days($array){
        foreach ($array as $key => $value){
            $array[$key] = date('D', strtotime("Sunday +{$value} days"));
        }
        return $array;
    }

    // Funtion to run update query
    function update_days($con,$test_id,$days){
        $sql = "UPDATE `lab_test` SET `days` = '$days'  WHERE `lab_test_id` = '$test_id'";
        if(mysqli_query($con,$sql)){
            $_SESSION['msg'] = "days updated successfully";
            header("location: days.php?edit=$test_id");   
        }else{
            echo mysqli_error($con);
        }
    }
    $day = $_POST['day'];
    $action = $_POST['action'];
    $test_id  = $_POST['test_id'];

    // get current date string from lab_test.days
    $result = mysqli_fetch_array(mysqli_query($con,"SELECT days from lab_test WHERE lab_test_id = '$test_id'"));

    // Pre-existing days string in database
    $db_days = $result[0];

    // look for the new day in the string of days from database
    if (strpos($db_days, $day)===false) {
        // Code to add new day goes here
        // Check if the action is set to 'add'
        if ($action == "add") {

            // Run algorithm to add the date
            $arr_days = explode(",", $db_days);

            // If no days found in database
            if (empty($db_days)) {
                $arr_days = array($day);
            }else{
                array_push($arr_days,$day);
            }

            if(count($arr_days)>1){
                // Convert days to numbers
                $arr_days = days_to_num($arr_days);
                // Sort days using insertion sort
                $arr_days = insertion_sort($arr_days);
                // Convert numeric days to alphabetic days
                $arr_days = num_to_days($arr_days);
            }
            // Convert array of days to string
            $new_days = implode(",", $arr_days);

            // SQL to insert new days in db
            update_days($con,$test_id,$new_days);

        }else{
            // If action is not "add".
            // redirect with error message
         $_SESSION['msg'] = "Couldn't update. Test already unavailable on $day";
         header("location: days.php?edit=$test_id");
     }
 }else{
        // If day already exist in database
        // Delete code goes here
        // Check whether action is set to "del"
    if ($action == "del"){
     $arr_days = explode(",", $db_days);
     if (($key = array_search($day, $arr_days)) !== false){
        unset($arr_days[$key]);
        $new_days = implode(",", $arr_days);
        echo $new_days;
            // SQL to insert new days in db
        update_days($con,$test_id,$new_days);
    }else{
     $_SESSION['msg'] = "Couldn't update. Test already unavailable on $day";
     header("location: days.php?edit=$test_id");
 }
}else{
                // Redirect with an error message
 $_SESSION['msg'] = "Test already available on $day";
 header("location: days.php?edit=$test_id");
}
}
}




// Add new laboratorian
if (isset($_POST['add_laboratorian'])) {
    print_r($_POST);
    $name = $_POST['name'];
    $email_id = $_POST['email_id'];
    $phno = $_POST['phno'];
    $user_name = $_POST['user_name'];
    $pass = $_POST['pass'];

    mysqli_autocommit($con,false);
    $sql = "INSERT INTO `users` (`user_name`, `user_role`, `password`, `date_of_reg`) VALUES ('$user_name', 'laboratorian', '$pass', now())";
    if(!mysqli_query($con,$sql)){
        echo (mysqli_error($con));
        mysqli_rollback($con);
    }

    $sql = "INSERT INTO `laboratorian` (`user_id`, `name`, `email_id`, `ph_no`) VALUES (LAST_INSERT_ID(), '$name', '$email_id', '$phno')";
    if(!mysqli_query($con,$sql)){
        echo (mysqli_error($con));
        mysqli_rollback($con);
    }else{
        mysqli_commit($con);
        $_SESSION['msg'] = "Laboratorian added successfully";
        header("location: laboratorian.php");
    }
}

// Edit laboratorian profile
if (isset($_POST['edit_laboratorian'])) {
    $name = $_POST['name'];
    $email_id = $_POST['email_id'];
    $phno = $_POST['phno'];
    $user_id = $_POST['id'];

    $sql = "UPDATE `laboratorian` SET `name`='$name',`email_id`='$email_id',`ph_no`='$phno' WHERE user_id = '$user_id'";
     if (mysqli_query($con,$sql)) {
        $_SESSION['msg'] = "Profile Updated";
        header("location: profile.php?id=$user_id");
    }else{
       die(mysqli_error($con));
   }
}

// Close Mysqli connection
mysqli_close($con);
?>