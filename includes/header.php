<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Nora Soto" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Bootstrap core CSS -->
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap theme -->
  <link href="./css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="./css/theme.css" rel="stylesheet">
	
	<!-- <link rel="stylesheet" type="text/css" href="./css/bootstrap.css" media="screen"> -->
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <title>Anime Chart Database</title>
</head>
	
<body>
	<?php
		header('Content-Type: text/html; charset=utf-8');
		$year = date('Y');
	?>
	
	<div id="top"></div>
	
	<nav class="navbar navbar-inverse navbar-fixed-top">
  	<div class="container-fluid">
   		<div class="navbar-header">
    		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
      		<span class="sr-only">Toggle navigation</span>
    	    <span class="icon-bar"></span>
        	<span class="icon-bar"></span>
        	<span class="icon-bar"></span>
      	</button>
      	<a class="navbar-brand" href="./index.php">Anime Chart Database</a>
    	</div>
    	
    	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      	<ul class="nav navbar-nav">
        	<li class="active"><a href="./airing.php">Currently Airing<span class="sr-only">(current)</span></a></li>
    		 	<li class="dropdown">
          	<a href="./seasons.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo "$year";?> Seasons <span class="caret"></span></a>
          	<ul class="dropdown-menu" role="menu">
            	<li><a href="./viewseason.php?season_id=201601">Winter <?php echo "$year";?></a></li>
            	<li><a href="./viewseason.php?season_id=201602">Spring <?php echo "$year";?></a></li>
            	<li><a href="./viewseason.php?season_id=201603">Summer <?php echo "$year";?></a></li>
            	<li><a href="./viewseason.php?season_id=201604">Fall <?php echo "$year";?></a></li>
           		<li class="divider"></li>
            	<li><a href="./seasons.php">All seasons</a></li>
          	</ul>
        	</li>
        	<li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Past Years <span class="caret"></span></a>
          	<ul class="dropdown-menu" role="menu">
            	<li><a href="./2016.php">2016</a></li>
            	<li><a href="./2015.php">2015</a></li>
          	</ul>
        	</li>
     		</ul>
      	<form class="navbar-form navbar-left" role="search" method="POST" action="searchresults.php">

        	<div class="form-group">
          	<input type="text" class="form-control" placeholder="Search">
        	</div>
        	<button type="submit" class="btn btn-default">Submit</button>
      	</form>
      	<ul class="nav navbar-nav navbar-right">
      		<li><a href="./search.php">Advanced Search</a></li>
        	<li><a href="./about.php">About</a></li>
      	</ul>
    	</div>
  	</div>
	</nav>

	
	<div class="container">