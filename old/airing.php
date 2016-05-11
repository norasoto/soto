<?php
header('Content-Type: text/html; charset=utf-8');
include_once '../includes/header.php';
require_once '../includes/login.php';

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
?>

<div class="row"><div class="col-lg-8 col-md-7 col-sm-6">

<?php
	echo '<h3>'.$currentseason.'</h3>';
	echo '<p class="lead">Currently Airing</p>';
?>

</div></div>

<?php
$group_concat = "SET SESSION group_concat_max_len=15000";
mysql_query($group_concat);

$query = "SELECT *,
		GROUP_CONCAT(showgenres.genre_name ORDER BY genre_name ASC SEPARATOR ', ') AS genre
	FROM shows
		JOIN studios
			ON shows.studio_id=studios.studio_id
		JOIN showgenres
			ON shows.show_id=showgenres.show_id
	WHERE season_id='$selectseason'
	GROUP BY shows.show_id
	ORDER BY show_title_eng ASC";
	
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

echo '<table class="table table-condensed table-hover">';
echo "<thead><tr><th>Title</th><th>Premiere</th><th>Timeslot</th><th>Studio</th><th>Episodes</th><th>Source</th><th>Genre</th></tr></thead>";
while ($row = $result->fetch_assoc()) {
	echo "<tbody><tr>";
	echo '<td class="title">';
	echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_eng"]."</a></b></h6>";
	if ($row["show_title_rom"] == $row["show_title_eng"]) {
		echo "(".$row["show_title_jpn"].")</td>";}
		else {
			echo "<i>".$row["show_title_rom"]."</i> (".$row["show_title_jpn"].")</td>";}
	echo "<td>".$row["show_date_premiere"]."</td>";
	echo "<td>".$row["show_date_day"]." at ".$row["show_date_time"]." JST</td>";
	echo "<td>".$row["studio_name_eng"]."</td>";
	if ($row["show_episodes"] == NULL) {
		echo "<td>Unknown</td>"; }
		else {
			echo "<td>".$row["show_episodes"]."</td>";}
	echo "<td>".$row["show_source"]."</td>";
	echo "<td>".$row["genre"]."</td>";
	echo "</tr></tbody>";
}
echo "</table>";

include_once '../includes/footer.php';
?>