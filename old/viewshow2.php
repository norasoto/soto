<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");

if (isset($_GET['show_id'])) {
	$id = sanitizeMySQL($conn, $_GET['show_id']);
	$query = "SELECT * FROM shows WHERE show_id=".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid Show ID.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "No Show found with ID of $id<br>";
	} else {
		while ($row = $result->fetch_assoc()) {
			echo "<h3>Show Information</h3>";
			echo "<img src='http://localhost/soto/".$row['show_visual']."' height='350'>";
			echo "<h3>".$row["show_title_eng"]."</h3>";
			echo "<h6>Title</h6>";
			echo "<b>English:</b> ".$row["show_title_eng"]."<br>";
			echo "<b>Japanese:</b> ".$row["show_title_jpn"]." <i>".$row["show_title_rom"]."</i><br>";
			echo $row["show_title_eng"]." is a ".$row["show_source"];		
		}
	}
	echo "<p><a href=\"index.php\">Return to homepage</a></p>";
} else {
	echo "No Show ID passed";
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