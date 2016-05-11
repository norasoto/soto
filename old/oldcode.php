<!DOCTYPE html>
<html>
<head>
<title>Anime Chart Database</title>
<meta charset="utf-8">
<style>
table { border-collapse: collapse; margin: 10px; }
table, tr, th, td { border: 1px solid #000;
	padding: 5px;}
	</style>
	
	
echo "<i>".$row["show_title_rom"]."</i> (".$row["show_title_jpn"].")</td>";

genre ENUM
'Action','Adventure','Comedy','Drama','Fantasy','Food','Games','Historical','Horror','Mecha','Music','Mystery','Parody','Psychological','Romance','School','Sci-Fi','Short','Slice of Life','Sports','Super Powers','Supernatural','Thriller'



$query = "SELECT *,
		GROUP_CONCAT(showgenres.genre_name ORDER BY genre_name ASC)
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

echo "<table><tr><th>Title</th><th>Premiere Date</th><th>Timeslot</th><th>Production Studio</th><th>Episodes</th><th>Source</th><th>Genre</th></tr>";
while ($row = $result->fetch_assoc()) {
	echo '<tr>';
	echo "<td><b><a href=\"viewshow.php?show_id=".$row["show_id"]."\">".$row["show_title_eng"]."</a></b><br>";
	if ($row["show_title_rom"] == $row["show_title_eng"]) {
		echo "(".$row["show_title_jpn"].")"; }
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
	echo "<td>".$row["genre_name"], $row["genre_name"]."</td>";			
	echo '</tr>';
	
	
	Trying to explode genre
	$genre = $row["genre_name"];
	$genres = explode(", ", $genre);
	echo "<td>".$genres[0]."</td>";