<?php
include('master/db.php');
/*Can be used in various modules to validate form data*/
if (isset($_POST['username'])) {
  $response = array(
    'valid' => false,
    'message' => 'Post argument "username" is missing.'
  );


  // Check user from database
  $row = mysqli_query($con,"SELECT user_id FROM users WHERE user_name='{$_POST['username']}'");
  if (mysqli_num_rows($row)==1) {
    $user = true;
  }else{
    $user = false;
  }

  if ($user) {
    // User name is registered on another account
    $response = array(
      'valid' => false,
      'message' => 'User name '.$_POST['username'].' is already registered.'
    );
  }
  else {
    // User name is available
    $response = array(
      'valid' => true
    );
  }
  echo json_encode($response);
}



if (isset($_POST['edit_uname'])) {
  $response = array(
    'valid' => false,
    'message' => 'Post argument "username" is missing.'
  );

  if (isset($_POST['user_id'])) {
  // Check user from database

    $row = mysqli_query($con,"SELECT user_id FROM users WHERE user_name='{$_POST['edit_uname']}' AND NOT user_id='{$_POST['user_id']}'");
    if (mysqli_num_rows($row)==1) {
      $user = true;
    }else{
      $user = false;
    }

    if ($user) {
    // User name is registered on another account
      $response = array(
        'valid' => false,
        'message' => 'User name '.$_POST['edit_uname'].' is already registered.'
      );
    }
    else {
    // User name is available
      $response = array(
        'valid' => true
      );
    }
  }
  echo json_encode($response);
}
?>