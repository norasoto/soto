<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");
?>

<br><div class="container-fluid">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Search Results</h4>
			</div>
				
			<div class="panel-body">
				<p>This is a template for the search results.</p>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'includes/footer.php';
?>