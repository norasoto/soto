<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");

echo "<h3>View Show</h3>";
echo '<p class="lead">Show Information</p>';

if (isset($_GET['show_id'])) {
	$id = sanitizeMySQL($conn, $_GET['show_id']);
	$query = "SELECT *,
			GROUP_CONCAT(showgenres.genre_name ORDER BY genre_name ASC SEPARATOR ', ') AS genre
		FROM shows
			JOIN studios
				ON shows.studio_id=studios.studio_id
			JOIN showgenres
				ON shows.show_id=showgenres.show_id
			JOIN seasons
				ON shows.season_id=seasons.season_id
			LEFT JOIN licensors
				ON shows.licensor_id=licensors.licensor_id
		WHERE shows.show_id=".$id."
		GROUP BY shows.show_id";
	$result = $conn->query($query);
	if (!$result) die ("Invalid Show ID.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "<h4>No Show found with ID of $id.</h4>";
	} else {
		while ($row = $result->fetch_assoc()) {
			echo '<div class="container-fluid">';
				echo '<div class="row">';
					echo '<div class="panel panel-default">';

						# Title
						echo '<div class="panel-heading">';
							if ($row["show_title_eng"] == NULL) {
								echo "<h4><b>".$row["show_title_rom"]."</b></h4>";}
							elseif ($row["show_title_eng"] == $row["show_title_rom"]) {
								echo "<h4><b>".$row["show_title_eng"]."</b></h4>";}
							else {
								echo "<h4><b>".$row["show_title_eng"]."</b></h4>";}
						echo '</div>';
				
						# Body
						echo '<div class="panel-body">';
							echo '<div class="row">';
							
							# Visual
								echo '<div class="col-md-5">';
									echo "<img src='http://localhost/soto/".$row['show_visual']."' height='500'>";
								echo '</div>';
								# Text
								echo '<div class="col-md-7">';
									# Title
									echo "<h6>Title Information</h6>";
									if ($row["show_title_eng"] == NULL) {
										echo "<b>Japanese:</b> <i>".$row["show_title_rom"]."</i> (".$row["show_title_jpn"].")";}
										else {
											echo "<b>English:</b> ".$row["show_title_eng"];
											echo "<br><b>Japanese:</b> <i>".$row["show_title_rom"]."</i> (".$row["show_title_jpn"].")";}

									# Broadcast
									echo "<br><br><h6>Broadcast Information</h6>";
									# Season
									echo "<p><b>Season:</b> ";
									if ($row["season_id"] == "UNKNOWN") {
										echo "TBA";}
										else {
											echo "<a href=\"viewseason.php?season_id=".$row["season_id"]."\">".$row["season_name"]." ".$row["season_year"]."</a>";}									echo "<br><b>Premiere:</b> ";
									if ($row["show_date_premiere"] == NULL) {
										echo "TBA"; }
										else {
											echo $row["show_date_premiere"]." (".$row["channel_id"].")";}
											echo "<br><b>Broadcast:</b> ";
									if ($row["show_date_day"] == NULL OR $row["show_date_time"] == NULL) {
										echo "TBA"; }
										else {
											echo $row["show_date_day"].", ".$row["show_date_time"]." JST";}
									echo "<br><b>Episodes:</b> ";
									if ($row["show_episodes"] == NULL) {
										echo "<i>Unknown</i>"; }
										else {
											echo $row["show_episodes"];}
									echo "<br><b>Studio:</b> <a href=\"viewstudio.php?studio_id=".$row["studio_id"]."\">".$row["studio_name_eng"]."</a>";
									echo "<br><b>Source:</b> ".$row["show_source"];
									echo "<br><b>Genre:</b> ".$row["genre"];
											
									# Web
									echo "<br><br><h6>Links</h6>";
   									echo '<b>Website:</b> <a href="'.$row["show_website"].'">'.$row["show_website"].'</a></li>';
    								if ($row["licensor_id"] == NULL) {
    									echo '<br><b>Streaming:</b> Not licensed</li>';}
    									elseif ($row["show_streaming_website"] == NULL) {
    										echo '<br><b>Streaming:</b> '.$row["licensor_name"].' (TBA)</li>';}
    									else {
    										echo '<br><b>Streaming:</b> <a href="'.$row["show_streaming_website"].'">'.$row["licensor_name"].'</a></li>';}									
								echo "</div>";
							
								
		echo "</div></div></div>";
		}
	}
} else {
	echo "<h4>No Show ID passed.</h4>";
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