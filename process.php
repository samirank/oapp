<?php
session_start();
include ('master/db.php');
if(isset($_POST["d_submit"])){
    $dname=$_POST['dname'];
    $dadd=$_POST['dadd'];
    $dphno=$_POST['dphno'];
    $d_desig=$_POST['d_desig'];
    $d_dept=$_POST['d_dept'];
    $d_spec=$_POST['d_spec'];
    $d_exp=$_POST['d_exp'];
    $d_gen=$_POST['d_gen'];

    $result=mysql_query("INSERT INTO `oapp`.`doctors` (`doc_name`, `address`, `ph_no`, `designation`, `dept`, `specialisation`, `expr`, `gender`) VALUES ('$dname', '$dadd', '$dphno', '$d_desig', '$d_dept', '$d_spec', '$d_exp', '$d_gen')");
    if($result){
        echo 'Data Saved Successfully !';
    }else{
        echo 'Data Failed !';
    }
}



// login Validation
if(isset($_POST['login_submit'])){
    $user_name = mysqli_real_escape_string($con,$_POST['uname']);
    $password = mysqli_real_escape_string($con,$_POST['pass']);

    $sql="SELECT *  from users where user_name='$user_name' and password='$password'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1){
        mysqli_close($con);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['log_id']=$row['user_id'];
        $_SESSION['log_uname']=$row['user_name'];
        $_SESSION['log_role']=$row['user_role'];
        header("location: dashboard.php");
    }else{
        mysqli_close($con);
        $_SESSION['login_err'] = "Incorrect username / password";
        header("location: login.php");
    }
}


// Add Department
if (isset($_POST['add_dept'])) {
    $dept_name = $_POST['dept_name'];
    $sql = "INSERT INTO `departments` (`dept_name`) VALUES ('$dept_name')";
    if (mysqli_query($con,$sql)) {
        mysqli_close($con);
        $_SESSION['msg']="Department added successfully";
        header("location: add_dept.php");
    } else {
        die(mysqli_error($con));
    }
}



?>