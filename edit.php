<?php
require_once "pdo.php";
session_start();


if  (!isset($_SESSION['name']) ) {
  die("ACCESS DENIED");
}


// skip this code when first coming to the page on a GET request.
if ( isset($_POST['make']) && isset($_POST['model'])
  && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id']) ) {

  // Data validation
  if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || 
       strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
    $_SESSION['error'] = 'All fields are required';
    header("Location: edit.php?autos_id=".$_POST['autos_id']);
    return;
  }

    // if ( strpos($_POST['email'],'@') === false ) {
    //     $_SESSION['error'] = 'Bad data';
    //     header("Location: edit.php?user_id=".$_POST['user_id']);
    //     return;
    // }
                    // make sure your commas are not missing or at the end of vars or this will BLOW UP
    $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// start GET request check here.
// Guardian: Make sure that autos_id is present from the index page.
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
  echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
  unset($_SESSION['error']);
}


$stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}


$m = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Matrix Analysis</title>
</head>
<body>
    <p>Edit Automobile</p>
    <form method="post">
    <p>Make:
    <input type="text" name="make" value="<?= $m ?>"></p>
    <p>Model:
    <input type="text" name="model" value="<?= $mo ?>"></p>
    <p>Year:
    <input type="text" name="year" value="<?= $y ?>"></p>
    <p>Mileage:
    <input type="text" name="mileage" value="<?= $mi ?>"></p>
    <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
    <p><input type="submit" value="Save"/>
    <a href="index.php">Cancel</a></p>
    </form>

</body>
</html>

