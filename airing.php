<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");

$year = date('Y');

// determine current season for heading
if (date('m') < 4) {
	$currentseason = "Winter $year";
	$selectseason = "201601";}
	elseif (date('m') > 3) {
		$currentseason = "Spring $year";
		$selectseason = "201602";}
	elseif (date('m') > 6) { 
		$currentseason = "Summer $year";
		$selectseason = "201603";}
	elseif (date('m') > 8) { 
		$currentseason = "Fall $year";
		$selectseason = "201604";}

echo '<h3>'.$currentseason.'</h3>';
echo '<p class="lead">Currently Airing</p>';

$group_concat = "SET SESSION group_concat_max_len=15000";
mysql_query($group_concat);

$query = "SELECT *,
		GROUP_CONCAT(showgenres.genre_name ORDER BY genre_name ASC SEPARATOR ', ') AS genre
	FROM shows
		JOIN studios
			ON shows.studio_id=studios.studio_id
		JOIN showgenres
			ON shows.show_id=showgenres.show_id
		LEFT JOIN licensors
			ON shows.licensor_id=licensors.licensor_id
	WHERE season_id='$selectseason'
	GROUP BY shows.show_id
	ORDER BY show_title_eng ASC";
	
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

echo '<div class="container-fixed">';
echo '<div class="row">';
while ($row = $result->fetch_assoc()) {
	echo '<div class="col-md-6">';
	echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">';
			echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_eng"]."</a></b></h6>";
			echo '</div>';
		echo '<div class="panel-body">';
			echo '<div class="row">';
				echo '<div class="col-sm-5">';
					echo "<a href=\"viewshow.php?show_id=".$row["show_id"]."\"><img src='./".$row['show_visual']."' height='250'></a>";
				echo '</div>';
			
				echo '<div class="col-sm-7">';
					echo "<p><b>Japanese Title:</b> ";
						if ($row["show_title_rom"] == $row["show_title_eng"]) {
							echo "".$row["show_title_jpn"]."</p>";}
						else {
							echo "<i>".$row["show_title_rom"]."</i> (".$row["show_title_jpn"].")</p>";}
					echo "<p><b>Premiere:</b> ".$row["show_date_premiere"]." (".$row["channel_id"].")";
					echo "<br><b>Broadcast:</b> ".$row["show_date_day"]." at ".$row["show_date_time"]." JST</p>";
					echo "<p><b>Episodes:</b> ";
						if ($row["show_episodes"] == NULL) {
							echo "<i>Unknown</i>"; }
						else {
							echo $row["show_episodes"];}
					echo "<br><b>Studio:</b> <a href=\"viewstudio.php?studio_id=".$row["studio_id"]."\">".$row["studio_name_eng"]."</a>";
					echo "<br><b>Source:</b> ".$row["show_source"]."</p>";
				echo "</div>";
		echo "</div></div>";
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
	echo "</div></div></div>";
}
echo "</div></div>";


include_once 'includes/footer.php';
?>