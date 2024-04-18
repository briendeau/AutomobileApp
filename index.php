<?php
require_once "pdo.php";
session_start();

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}


if (!isset($_SESSION['name'])) {
    echo "<html><title>Matrix Analysis</title><h1>Welcome to the Automobiles Database</h1>";
    echo "<br><a href='login.php'>Please log in</a></html>";
} else {
    echo('<html><title>Matrix Analysis</title><table border="1">'."\n");
    $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      if ($row === false) {
        echo "No rows";
        break;
      }
        // echo "looping";
        echo "<tr><td>";
        echo(htmlentities($row['make']));
        echo("</td><td>");
        echo(htmlentities($row['model']));
        echo("</td><td>");
        echo(htmlentities($row['year']));
        echo("</td><td>");
        echo(htmlentities($row['mileage']));
        echo("</td><td>");
        echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
        echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
        echo("</td></tr>\n");
        // echo $row['autos_id'];

    }


  }
    ?>
</table></html> <br />

<?php 
 if (isset($row)) {
  echo "<a href='add.php'>Add New Entry</a> <br /> <br />";
  echo "<a href='logout.php'>Logout</a>";

 }
?>



