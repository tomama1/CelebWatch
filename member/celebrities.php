<?php
include("../include/dconn.php");
if (!isset($_COOKIE['loginCookieUser'])){
	header("Location: notloggedin.html");
}
if (isset($_GET['celebbutton'])){
	setcookie('CelebID', $_GET['celebid']);
	header("Location: celebprofile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>CelebWatch | Celebrities</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/lumen/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href= "../css/stylesheet.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</head>

<!-- NAVIGATION BAR -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="../celebwatchmain.php">CelebWatch</a>
	    </div>

	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li><a href="memberpage.php">MemberPage <span class="sr-only">(current)</span></a></li>
	        <li class="active"><a href="celebrities.php">Browse</a></li>
	      </ul>
	      <form method="get" name="search" class="navbar-form navbar-left" role="search" action="celebrities.php">
	        <div class="form-group">
	          <input type="text" class="form-control" name="searchedterm" placeholder="Search A Celeb!">
	        </div>
	        <button type="submit" name="searchsubmit" class="btn btn-default">Submit</button>
	      </form>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="logout.php">Logout</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>

<!-- BODY -->
	<body>
		<div class="container">
			<!-- Header -->
			<h1>Celebrity Database</h1>
			<br>

			<!-- Celebrities Table -->
			<?php 
			if (isset($_GET['favebutton']))
				addFave();
			if (isset($_GET['searchedterm']))
				displayCelebsTable($_GET['searchedterm']);
			else
				displayCelebsTable("");
			?>

		</div>
	</body>

<!-- BOTTOM NAVBAR -->
	<nav class="navbar navbar-default navbar-fixed-bottom">
		<div class="container-fluid">
			<ul class="navbar-form navbar-left">
				<p>&copy; 2016 Angela Han, Eunice Kang, Matthew Toma.</p>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			    <li><a href="admin.php">Admin</a></li>
			</ul>
		</div>
	</nav>

<?php
function displayCelebsTable($str){
	$dbc = connect_to_db("hanav");
	// for search cookie
	$searching = $str == '' ? 'false' : 'true';
	$query = $str == '' ? "SELECT * FROM Celebrities" : 
	"SELECT * FROM Celebrities WHERE 
	(
	CelebName LIKE '%$str%' OR 
	Occupation LIKE '%$str%' OR 
	Birthday LIKE '%$str%' OR 
	Wikipedia LIKE '%$str%' 
	OR Twitter LIKE '%$str%' 
	OR Instagram LIKE '%$str%'
	)";

	$result = perform_query($dbc, $query);
	$rowsFound = mysqli_num_rows($result);
	echo "<div class=\"panel panel-info\">
				<div class=\"panel-heading\">
					<h3 class=\"panel-title\">Celebrities</h3>
				</div>
				<div class=\"panel-body\">
					<table class=\"table table-striped table-hover\">
					  <thead>
					    <tr>
					      <th>Name</th>
					      <th>Occupation</th>
					      <th>Birthday</th>
					      <th>Social Media</th>
					      <th> </th>
					    </tr>
					  </thead>
					  <tbody>";
	while (@extract(mysqli_fetch_array($result, MYSQLI_ASSOC))) {
		echo "<tr>
				<form method='get' name='celeb'>
				<td>$CelebName</td>
			    <td>$Occupation</td>
			    <td>$Birthday</td>
			    <td>
			    	<ul>
			    		<li><a href='$Wikipedia'>$Wikipedia</a></li>
			    		<li><a href='$Twitter'>$Twitter</a></li>
			    		<li><a href='$Instagram'>$Instagram</a></li>
			    	</ul>
			    </td>
			    <td>
			    	<input type='hidden' name='celebid' value=$ID>
			    	<button type='submit' name='favebutton' class='btn btn-primary btn-xs'>Favorite</button><br>
			    	<button type='submit' name='celebbutton' class='btn btn-info btn-xs'>Profile</button>
			    </td>
			    </form>
			  </tr>";
	}
	echo "</table></div></div>";
}

function addFave(){
	$dbc = connect_to_db("hanav");
	$CelebID = $_GET['celebid'];
	$UserEmail = $_COOKIE['loginCookieUser'];
	$userquery = "SELECT * FROM Users WHERE Email='$UserEmail';";
	$userresult = perform_query($dbc, $userquery);
	$obj = mysqli_fetch_object($userresult);
	$UserID = ($obj->ID);
	// Check if Celeb is already in Favorites
	$checkquery = "SELECT * FROM MyCelebs WHERE CelebID='$CelebID' AND UserID='$UserID'";
	$checkresult = perform_query($dbc, $checkquery);
	if ($checkresult->num_rows == 0){
		$favequery = "INSERT INTO MyCelebs (CelebID, UserID) VALUES ($CelebID, $UserID)";
		$insertfave = perform_query($dbc, $favequery);
		disconnect_from_db($dbc, $insertfave);
	}
	else{
		echo "<div class='alert alert-dismissible alert-danger' role='alert'>";
		echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		echo "<strong>Error!</strong> Already in Favorites.</div>";
		disconnect_from_db($dbc, $checkresult);
	}
}

?>

</html>