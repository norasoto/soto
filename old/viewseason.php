<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");

if (isset($_GET['season_id'])) {
	$id = sanitizeMySQL($conn, $_GET['season_id']);
	$query = "SELECT * FROM shows WHERE season_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid Season ID.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "No Season found with ID of $id<br>";
	} else {
		while ($row = $result->fetch_assoc()) {
			echo "<h2>Show Information</h2>";
			echo "<h3>".$row["show_title_eng"]."</h3>";
			echo "<h4>Title</h4>";
			echo "<b>English:</b> ".$row["show_title_eng"]."<br>";
			echo "<b>Japanese:</b> ".$row["show_title_jpn"]." <i>".$row["show_title_rom"]."</i><br>";
			echo $row["show_title_eng"]." is a ".$row["show_source"];		
		}
	}
	echo "<p><a href=\"index.php\">Return to homepage</a></p>";
} else {
	echo "No Season ID passed";
}

include_once 'includes/footer.php';

function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}
function sanitizeMySQL($connection, $var)
{
	$var = $connection->real_escape_string($var);
	$var = sanitizeString($var);
	return $var;
}

include_once 'includes/footer.php';
?>