<?php
  require_once "pdo.php";
  session_start();

  if ( isset($_POST['cancel']) ) {
    // redirect browser to game.php
    header("Location: index.php");
    return;
  }
  
  if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}

// umsi@umich.edu
// php123

  $salt = 'XyZzy12*_';
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is meow123 [php123]

  $failure = false; // if we have no POST data

  if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
      $_SESSION['error'] = "Username and password are required";
      header("Location: login.php");
      return;
    } elseif (strpos($_POST['email'], '@') === false ) {
      $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: login.php");
      return;
    } else {
      $check = hash('md5', $salt.$_POST['pass']);
      if ( $check == $stored_hash ) {
        // Redirect the browser to view.php
        // print_r($_SESSION);
        $_SESSION['name'] = $_POST['email'];
        header("Location: index.php");
        return;
      } else {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        error_log("Login fail ".$_POST['email']." $check");
        return;

    }
  }

 }

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Matrix Analysis</title>
</head>
<body>
<h1>Please Log In</h1>
  <form method="POST" action="login.php">
    <label for="name">User Name</label>
    <input type="text" name="email" id="name"><br/>
    <label label for="id_1723">Password</label>
    <input type="text" name="pass"><br/>
    <input type="submit" value="Log In">
    <a href="index.php">Cancel</a></p>
</form>
</body>
</html>