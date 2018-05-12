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
        header("location: dashboard.php");
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
    $sql = "INSERT INTO `users` (`user_name`, `user_role`, `password`) VALUES ('$uname', 'doctor', '$password')";
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


    $sql="INSERT INTO `users`(`user_name`, `user_role`, `password`) VALUES ('$uname', 'patient', '$password')";
    mysqli_autocommit($con,false);
    if(!mysqli_query($con, $sql)){
        echo mysqli_error($con);
        mysqli_rollback($con);
    }


    $sql="INSERT INTO `patients`(`name`, `address`, `mobileno`, `guardian`, `emergencycontact`, `gender`, `bgroup`, `cur_medication`, `email_id`, `user_id`) VALUES ('$name','$address','$mobileno','$gname','$ecnumber','$gender','$bgroup','$cur_med','$email', LAST_INSERT_ID())";
    if(!mysqli_query($con, $sql)){
        echo mysqli_error($con);
        mysqli_rollback($con);
    }
    else{
        mysqli_commit($con);
        $_SESSION['msg']="You're registered.";
        header("location: patientreg.php");
    }
}

// View Doctor table action
if (isset($_POST['doc_view_action'])) {
     if ($_POST['action']=="schedule") {
         header("location: manage_schedule.php?doc_id=".$_POST['doc_id']);
     }

     header("location: doc-reg-view.php");
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








 mysqli_close($con);
?>