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
				<h4>Search</h4>
			</div>
				
			<div class="panel-body">
				<form class="form-horizontal" method="POST" action="searchresults.php">
	 				<div class="form-group">
  				 <label class="col-md-2 control-label">Show Title</label>
  					<div class="col-md-8">
 							<input class="form-control" placeholder="Title" type="text">
 						</div>
 					</div>
 					
 					<div class="form-group">
 					<label class="col-md-2 control-label">Production Studio</label>
  					<div class="col-md-8">
							<input class="form-control" placeholder="Studio" type="text">
 						</div>
 					</div>
 					
 					<div class="form-group">
  				 <label class="col-md-2 control-label">Season</label>
  					 <div class="col-md-8">
 						 	<input type="radio" name="season_name" value="winter"> <label>Winter &nbsp;</label>
 						 	<input type="radio" name="season_name" value="spring"> <label>Spring &nbsp;</label>
 						 	<input type="radio" name="season_name" value="summer"> <label>Summer &nbsp;</label>
 						 	<input type="radio" name="season_name" value="fall"> <label>Fall &nbsp;</label>
 						</div>
 					</div>
 					 					
 					<div class="form-group">
  				 <label class="col-md-2 control-label">Year</label>
  					 <div class="col-md-8">
 						 	<input type="radio" name="season_year" value="2015"> <label>2015</label><br>
 						 	<input type="radio" name="season_year" value="2016"> <label>2016</label>
 						</div>
 					</div>
 					
					<div class="form-group">
 					<label class="col-md-2 control-label">Genre</label>
  					<div class="col-md-8">
							<input class="form-control" placeholder="Genre" type="text">
 						</div>
 					</div>
 					
 					
 					<div class="form-group">
  				  <div class="col-md-offset-2 col-md-10">
    				  <button type="submit" class="btn btn-default">Submit</button>
   					 </div>
 					</div>
 					
			</form>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'includes/footer.php';
?>