<?php
$errors = array();
if(isset($_POST['submit'])) {
  $min = 4;
  $max = 10;
  $username = $_POST['user_name'];
  $password = $_POST['user_password'];
  $email = $_POST['user_email'];



    if(strlen($username) < $min) {
      $errors['username_4'] =   "<p class='error'>* username has to be more than 4 characters</p>";
    }

    if(strlen($username) > $max) {
      $errors['username_10'] =    "<p class='error'>* username cant be more then 10 characters</p>";
    }


    if(empty($email)) {
      $errors['email'] = "<p class='error'>* please enter your email address</p>" ;
    }


    if($password != 'password') {
      $errors['password_error'] = "<p class='error'>* Please enter the correct Password.</p>";
    } else {
      $errors['password_success'] = "<p class='success'> Password is Correct</p>";
    }


  $connection = mysqli_connect('localhost', 'root', '', 'signup');
    if($connection) {
      echo "we are connected";
    } else {
      die("Database connection failed");
    }

    $hashFormat = "$2y$10$";
    $salt = "iusesomecrazystrings22";
    $hashF_and_salt = $hashFormat . $salt;

    $password = crypt($password, $hashF_and_salt);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    $query = "INSERT INTO user(Name, Email, Password)";
    $query .= "VALUES ('$username', '$email', '$password')";

    $result = mysqli_query($connection, $query);

    if(!$result) {
      die('QUERY FAILED');
    }
}

?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sign Up Form</title>
        <link href='http://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>
        <link href="Css/styles.css" rel="stylesheet">
    </head>
    <body>

      <form action="form_create.php" method="post">
        <p><?php echo "Today is" ." ". date("l") . "." ?></p>
        <h1>Sign Up</h1>

            <label for="name">Name:</label>
            <?php
              if (isset($errors['username_4'])) {
                print $errors['username_4'];
              }
              if (isset($errors['username_10'])) {
                print $errors['username_10'];
              }

            ?>

            <input type="text" id="name" name="user_name">


            <label for="mail">Email:</label>
            <?php
            if (isset($errors['email'])) {
              print $errors['email'];
            }

             ?>
            <input type="email" id="mail" name="user_email">


            <label for="password">Password:</label>
            <?php
            if (isset($errors['password_error'])) {
              print $errors['password_error'];
            }

            if (isset($errors['password_success'])) {
              print $errors['password_success'];
            }
            ?>
            <input type="password" id="password" name="user_password">
            <input type="submit" name="submit">
      </form>

    </body>
</html>
