<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");
?>

<h3>About</h3>
<p class="lead">About the Site</p>

<div class="panel panel-default">
  <div class="panel-body">
    <p>This database was created by Nora Soto as a fulfillment of LIS 697: Web Development.</p>
    <p>The CSS is based on the <a href="http://getbootstrap.com">Bootstrap</a> framework, and uses the <a href="https://bootswatch.com/paper/">Paper Theme</a> designed by <a href="http://thomaspark.co/">Thomas Park</a>.</p>
    <p>My top three shows of the season:</p>
    <?php
    	$query = "SELECT * FROM shows WHERE show_id in (1,7,9) ORDER BY studio_id ASC";
    	$result = $conn->query($query);
			if (!$result) die ("Database access failed: " . $conn->error);
			$rows = $result->num_rows;
			echo '<div class="container-fluid"><div class="row">';
			while ($row = $result->fetch_assoc()) {
				echo '<div class="col-md-4">';
				echo "<a href=\"viewshow.php?show_id=".$row["show_id"]."\"><img src='./".$row['show_visual']."' height='375'></a>";
				echo '</div>';}
			echo '</div></div>';
    ?>
  </div>
</div>

<?php
include_once 'includes/footer.php';
?>