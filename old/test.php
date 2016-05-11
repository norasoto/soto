<?php
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die($conn->connect_error);
$conn->set_charset("utf8");
?>

<div class="tables">

<ul class="nav nav-pills nav-justified">
  <li class="active"><a data-toggle="tab" href="#top">All Seasons</a></li>
  <li><a href="#">Winter</a></li>
  <li><a href="#">Spring</a></li>
  <li><a href="#">Summer</a></li>
  <li><a href="#">Fall</a></li>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
      Dropdown <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li><a href="#">Action</a></li>
      <li><a href="#">Another action</a></li>
      <li><a href="#">Something else here</a></li>
      <li class="divider"></li>
      <li><a href="#">Separated link</a></li>
    </ul>
  </li>
</ul>


<div class="row">
<div class="col-lg-4">
<ul class="nav nav-tabs nav-justified">
  <li class="active"><a href="#all" data-toggle="tab" aria-expanded="true">All Seasons</a></li>
  <li><a href="#winter" data-toggle="tab" aria-expanded="false">Winter</a></li>
  <li class=""><a href="#spring" data-toggle="tab" aria-expanded="false">Spring</a></li>
  <li class=""><a href="#summer" data-toggle="tab" aria-expanded="false">Summer</a></li>
  <li class=""><a href="#fall" data-toggle="tab" aria-expanded="false">Fall</a></li>
    </a>
    <ul class="dropdown-menu">
      <li class=""><a href="#dropdown1" data-toggle="tab" aria-expanded="false">Action</a></li>
      <li class="divider"></li>
      <li><a href="#dropdown2" data-toggle="tab" aria-expanded="false">Another action</a></li>
    </ul>
  </li>
</ul>
<div id="myTabContent" class="tab-content">
  <div class="tab-pane fade active in" id="all">
    <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
  </div>
  <div class="tab-pane fade" id="winter">
    <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
  </div>
</div>


<div class="container">
  <h2>Dynamic Tabs</h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
    <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>


</div>
<?php

$imagequery = "SELECT show_visual FROM shows";

$result = $conn->query($imagequery);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;
$row = $result->fetch_assoc();

# images
			$imagequery = "SELECT show_visual FROM shows WHERE show_id=".$row["show_id"];
			$imageresult = $conn->query($imagequery);
				if (!$imageresult) die ("Database access failed: " . $conn->error);
				$imagerows = $imageresult->num_rows;
				$imagerow = $imageresult->fetch_assoc();
				echo "<td><a href=\"viewshow.php?show_id=".$row["show_id"]."\"><img src='http://localhost/soto/".$imagerow['show_visual']."' height='200'></a></td>";

//while ($row = $result->fetch_assoc()) {
	//print_r($row);}
	
echo "<img src='http://localhost/soto/".$row['show_visual']."' height='250'>";
	
?>