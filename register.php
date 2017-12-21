<?php
/* Registration process, inserts user info into the database
   and sends account confirmation email message
 */

 //TODO: store user data in session variable for usning in different page
 $_SESSION['email'] = $_POST['email'];
 $_SESSION['first_name'] = $_POST['firstname'];
 $_SESSION['last_name'] = $_POST['lastname'];

 //TODO: Escape all $_POST variables to protect against sql injection
 $first_name = $mysqli->escape_string($_POST['firsname']);
 $last_name = $mysqli->escape_string($_POST['lastname']);
 $email = $mysqli->escape_string($_POST['email']);
 $password = $mysqli->escape_string(password_hash($_POST['firsname'], PASSWORD_BCRYPT)) ;
$hash = $mysqli->escape_string(md5(rand(0, 1000)));

 //TODO: check user already exist through query
 $result = $mysqli->query("SELECT * FROM users WHERE email= $email");

 //TODO: If exist, then redirect to error page with a message
 if ($result->num_rows > 0) {
   $_SESSION['message'] = "User with this email already exist";
   header("location:error.php");
 }
 //TODO: If not exist, then insert user data in database and send verification email
else
{
  $sql = "INSERT INTO users (first_name, last_name, email, password, hash)"
          . " VALUES('$first_name', '$last_name', '$email', '$password', '$hash')";

    if ($mysqli->query($sql)) {
      $_SESSION['active'] = 0; // 0 until user verify their Email
      $_SESSION['logged_in'] = true; // so we know the user has logged in
      $_SESSION['message'] =
                      "Confirmation link has been sent to $email, please verify
                      your account by clicking on the link in the message!";

      //send registration confirmation link
      $to = $email;
      $subject = 'Account Verification';
      $message_body = '
      Hello '. $first_name. ',

      Thank you for signing up!

      Please click this link to activate your Account:

      http://localhost/php-login-system/verify.php?email='.$email.'&hash='.$hash;
      mail($to, $subject, $message_body);
      header("location:profile.php");
    }else{
      $_SESSION['message'] = 'Registration failed!';
      header("location:error.php");
    }
}
