<?php
/* User login process, checks if user exists and password is correct */

$email = $mysqli->escape_string($_SESSION['email']);

$result = $mysqli->query("SELECT * FROM  users WHERE email = '$email'");

if ($result->num_rows == 0 ) {
  $_SESSION['message'] = "User with that email doesn't exist";
  header("location:error.php");
}else{
  $users = $result->fetch_assoc();
  if(password_verify($_POST['password'], $users['password'])){
    $_SESSION['email'] = $users['email'];
    $_SESSION['first_name'] = $users['firstname'];
    $_SESSION['last_name'] = $users['lastname'];
    $_SESSION['active'] = $users['active'];

    $_SESSION['logged_in'] = true;

    header("location:profile.php");
  }else{
    $_SESSION['message'] = "You have entered wrong password, please try again!";
    header("location: error.php");
  }
}
