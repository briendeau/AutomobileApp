<?php
include_once("pdo.php");
session_start();

if  (!isset($_SESSION['name']) ) {
  die("ACCESS DENIED");
}

if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}

if ( isset($_POST['cancel'])) {
  header("Location: index.php");
  return;
}

if (isset($_POST['add'])) {
  if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: ./add.php");
    return;
  } else if ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
    $_SESSION['error'] = "Year and Mileage must be numeric";
    header("Location: ./add.php");
    return;
  } else  {
    // echo "<h1>Test</h1>";
    // print_r($_POST);
    $stmt = $pdo->prepare('INSERT INTO autos
    (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');

    $stmt->execute(array(
    ':mk' => $_POST['make'],
    ':md' => $_POST['model'],
    ':yr' => $_POST['year'],
    ':mi' => $_POST['mileage'])
  );
  
  $_SESSION['success'] = 'Record added';
  header('Location: index.php');
  return;
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
  <h1>Add a new automobile below</h1>
  <form method="POST">
    <p>
      <label for="make">Make:</label>
      <input type="text" name="make" id="make">
    </p>
    <p>
      <label for="model">Model:</label>
      <input type="text" name="model" id="model">
    </p>
    <p>
      <label for="year">Year:</label>
      <input type="text" name="year" id="year">
    </p>
    <p>
      <label for="mileage">Mileage:</label>
      <input type="text" name="mileage" id="mileage">
    </p>
    <input type="submit" value="Add" name="add">
    <input type="submit" value="Cancel" name="cancel">
  </form>

  
</body>
</html>