<?php
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");


echo '<br><div class="jumbotron">';
  echo "<h1>Welcome</h1>";
  echo '<p>This website organizes airing and upcoming anime by season.</p>
  <p><a class="btn btn-primary btn-lg" href="./airing.php">Currently Airing</a></p>
</div>';

include_once 'includes/footer.php';
?>
