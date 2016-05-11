<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");

$year = "2016";
?>

<div class="row"><div class="col-lg-8 col-md-7 col-sm-6">

<?php
	echo "<h3>$year</h3>";
	echo '<p class="lead">All Seasons</p>';
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
		LEFT JOIN licensors
			ON shows.licensor_id=licensors.licensor_id
	WHERE season_id LIKE '".$year."%'
	GROUP BY shows.show_id
	ORDER BY season_id ASC, show_date_premiere ASC, show_title_eng ASC, show_title_rom ASC";
		
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;

//$winter = WHERE season_id LIKE "


echo '<table class="table table-condensed table-hover">';
echo "<thead><tr><th>Title</th><th>Premiere</th><th>Timeslot</th><th>Studio</th><th>Episodes</th><th>Source</th><th>Genre</th></tr></thead>";
while ($row = $result->fetch_assoc()) {
	echo '<tbody><tr>';
	# Title
	if ($row["show_title_eng"] == NULL) {
			echo '<td class="title">';
			echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_rom"]."</a></b></h6>";
			echo "(".$row["show_title_jpn"].")</td>";}
		elseif ($row["show_title_eng"] == $row["show_title_rom"]) {
			echo '<td class="title">';
			echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_eng"]."</a></b></h6>";
			echo "(".$row["show_title_jpn"].")</td>";}
		else {
			echo '<td class="title">';
			echo "<h6><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_eng"]."</a></b></h6>";
			echo "<i>".$row["show_title_rom"]."</i> (".$row["show_title_jpn"].")</td>";}
	
	# Date and Time
	if ($row["show_date_premiere"] == NULL) {
			echo "<td>TBA</td>"; }
		else {
			echo "<td>".$row["show_date_premiere"]."</td>";}
	if ($row["show_date_day"] == NULL OR $row["show_date_time"] == NULL) {
			echo "<td>TBA</td>"; }
		else {
			echo "<td>".$row["show_date_day"].", ".$row["show_date_time"]." JST</td>";}
	
	# Studio
	echo "<td>".$row["studio_name_eng"]."</td>";
	
	# Episodes
	if ($row["show_episodes"] == NULL) {
			echo "<td>Unknown</td>"; }
		else {
			echo "<td>".$row["show_episodes"]."</td>";}
			
	# Source
	echo "<td>".$row["show_source"]."</td>";
	
	#Genre
	echo "<td>".$row["genre"]."</td>";
	echo '</tr></tbody>';
}
echo "</table>";

include_once 'includes/footer.php';
?>