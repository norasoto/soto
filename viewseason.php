<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");

echo "<h3>View Season</h3>";
echo '<p class="lead">Season Information</p>';

if (isset($_GET['season_id'])) {
	$id = sanitizeMySQL($conn, $_GET['season_id']);
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
		WHERE shows.season_id=".$id."
		GROUP BY shows.show_id
		ORDER BY shows.season_id ASC, show_date_premiere ASC, show_title_eng ASC, show_title_rom ASC";
	$result = $conn->query($query);
	if (!$result) die ("Invalid Season ID.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "<h4>No Season found with ID of $id.</h4>";
	} else {
			echo '<div class="container-fixed">';
			echo '<div class="row">';
			while ($row = $result->fetch_assoc()) {
				echo '<div class="col-md-6">';
					echo '<div class="panel panel-default">';
					
						# Title
						echo '<div class="panel-heading">';
							if ($row["show_title_eng"] == NULL) {
								echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_rom"]."</a></b></h6>";}
							elseif ($row["show_title_eng"] == $row["show_title_rom"]) {
								echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_eng"]."</a></b></h6>";}
							else {
								echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_eng"]."</a></b></h6>";}
						echo '</div>';
				
						# Body
						echo '<div class="panel-body">';
							echo '<div class="row">';
								# Visual
								echo '<div class="col-sm-5">';
									echo "<a href=\"viewshow.php?show_id=".$row["show_id"]."\"><img src='./".$row['show_visual']."' height='250'></a>";
								echo '</div>';
			
								# Text
								echo '<div class="col-sm-7">';
									# Title
									echo "<p><b>Japanese Title:</b> ";
										if ($row["show_title_rom"] == $row["show_title_eng"]) {
											echo "".$row["show_title_jpn"]."</p>";}
										else {
											echo "<i>".$row["show_title_rom"]."</i> (".$row["show_title_jpn"].")</p>";}
						
									# Season
									echo "<p><b>Season: </b> <a href=\"viewseason.php?season_id=".$row["season_id"]."\">".$row["season_name"]." ".$row["season_year"]."</a>";
						
									# Date and Time
									echo "<br><b>Premiere:</b> ";
									if ($row["show_date_premiere"] == NULL) {
										echo "TBA"; }
										else {
											echo $row["show_date_premiere"]." (".$row["channel_id"].")";}
											echo "<br><b>Broadcast:</b> ";
									if ($row["show_date_day"] == NULL OR $row["show_date_time"] == NULL) {
										echo "TBA"; }
										else {
											echo $row["show_date_day"].", ".$row["show_date_time"]." JST</p>";}
						
									# Episodes, Studio, Source
									echo "<p><b>Episodes:</b> ";
									if ($row["show_episodes"] == NULL) {
										echo "<i>Unknown</i>"; }
										else {
											echo $row["show_episodes"];}
									echo "<br><b>Studio:</b> <a href=\"viewstudio.php?studio_id=".$row["studio_id"]."\">".$row["studio_name_eng"]."</a>";
									echo "<br><b>Source:</b> ".$row["show_source"]."</p>";
								echo "</div>";
						
							echo "</div></div>"; # End Body / Row
						
						echo '<ul class="list-group">
   						<li class="list-group-item"><b>Website:</b> <a href="'.$row["show_website"].'">'.$row["show_website"].'</a></li>';
    					if ($row["licensor_id"] == NULL) {
    						echo '<li class="list-group-item"><b>Streaming:</b> Not licensed</li>';}
    						elseif ($row["show_streaming_website"] == NULL) {
    							echo '<li class="list-group-item"><b>Streaming:</b> '.$row["licensor_name"].' (TBA)</li>';}
    						else {
    							echo '<li class="list-group-item"><b>Streaming:</b> <a href="'.$row["show_streaming_website"].'">'.$row["licensor_name"].'</a></li>';}
 						echo '</ul>';
						
						echo '<div class="panel-footer">';
							echo "<b>Genre:</b> ".$row["genre"];
						echo "</div></div></div>";}
			echo "</div></div>";
	}
} else {
	echo "<h4>No Season ID passed.</h4>";
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