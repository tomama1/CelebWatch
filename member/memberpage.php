<?php
include("../include/dconn.php");
if (!isset($_COOKIE['loginCookieUser'])){
	header("Location: notloggedin.html");
}
if (isset($_GET['deletebutton'])){
	deleteFave();
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
		<title>CelebWatch | MemberPage</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/lumen/bootstrap.min.css">
		<Link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script type = "text/javascript" src = "../js/validaterequest.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Advent+Pro' rel='stylesheet' type='text/css'>

	</head>

<!-- NAVIGATION BAR -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="../celebwatchmain.php">CelebWatch</a>
	    </div>

	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="memberpage.php">MemberPage <span class="sr-only">(current)</span></a></li>
	        <li><a href="celebrities.php">Browse</a></li>
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
			<!-- Header -->
		<div class="page-header container-fluid">
			<h1>Welcome <?php memberName(); ?>!</h1>
		</div>
		<br>

			<!-- Favorites Table -->
			<?php
				displayFaves();
			?>
			<!-- Handle new request -->
			<?php
			if (isset($_POST['requestnewceleb'])){ ?>
			<script>
				if (validate() == true)
			</script>
				<?php	handleNewCelebRequest();
			} ?>
			
			<!-- Request Form -->
			<?php
				displayRequestForm();
			?>
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
function memberName(){
	$dbc = connect_to_db("hanav");
	$email = $_COOKIE['loginCookieUser'];
	$query = "SELECT * FROM Users WHERE Email='$email';";
	$result = perform_query($dbc, $query);
	$obj = mysqli_fetch_object($result);
	disconnect_from_db($dbc, $result);
	echo ($obj->UserName);
}

function displayFaves(){
	$dbc = connect_to_db("hanav");
	$useremail = $_COOKIE['loginCookieUser'];
	$userquery = "SELECT * FROM Users WHERE Email='$useremail';";
	$userresult = perform_query($dbc,$userquery);
	$obj = mysqli_fetch_object($userresult);
	$userid = ($obj->ID);
	$query = "SELECT * FROM `Celebrities` JOIN `MyCelebs` ON `Celebrities`.`ID`=`MyCelebs`.`CelebID` JOIN `Users` ON `Users`.`ID` = `MyCelebs`.`UserID` WHERE `UserID`='$userid';";
	$result = perform_query($dbc, $query);
	$rowsFound = mysqli_num_rows($result);
	echo "<div class=\"container\">
			<div class=\"panel panel-info\">
				<div class=\"panel-heading\">
					<h3 class=\"panel-title\">Favorites</h3>
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
				<form method='get' name='favecelebs'>
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
			    	<input type='hidden' name='celebid' value=$CelebID>
			    	<button type='submit' name='deletebutton' class='btn btn-danger btn-xs'>Delete</button><br>
			    	<button type='submit' name='celebbutton' class='btn btn-info btn-xs'>Profile</button>
			    </td>
			    </form>
			  </tr>";
	}
	echo "</table></div></div></div>";
}

function deleteFave(){
	$dbc = connect_to_db("hanav");
	$CelebID = $_GET['celebid'];
	$UserEmail = $_COOKIE['loginCookieUser'];
	$userquery = "SELECT * FROM Users WHERE Email='$UserEmail';";
	$userresult = perform_query($dbc, $userquery);
	$obj = mysqli_fetch_object($userresult);
	$UserID = ($obj->ID);
	$deletequery = "DELETE FROM MyCelebs WHERE CelebID='$CelebID' AND UserID='$UserID';";
	$deletefave = perform_query($dbc, $deletequery);
	disconnect_from_db($dbc, $deletefave);
	header("Refresh: 5; url=memberpage.php");
}

function displayRequestForm(){
	echo "<div class=\"container\">
			<div class=\"panel panel-info\">
				<div class=\"panel-heading\">
					<h3 class=\"panel-title\">Request a Celebrity</h3>
				</div>
				<div class=\"panel-body\">
					<form method=\"post\" name=\"newrequest\" class=\"form-horizontal\" onsubmit=\"return validate();\">
						<fieldset>
							<div class=\"form-group\" id=\"requestcelebname\">
								<label for=\"celebName\" class=\"col-lg-2 control-label\">Celebrity Name:</label>
								<span class=\"text-danger\" id=\"celebnameerror\"></span>
								<div class=\"col-lg-10\">
									<input type=\"text\" class=\"form-control\" name=\"celebName\" id=\"celebName\" placeholder=\"Celebrity Name\">
								</div>
							</div>
							<div class=\"form-group\" id=\"requestdescription\">
								<label for=\"textArea\" class=\"col-lg-2 control-label\">Description:</label>
								<span class=\"text-danger\" id = \"descriptionerror\"></span>
								<div class=\"col-lg-10\">
									<textarea rows=\"3\" class=\"form-control\" name=\"description\" id=\"textArea\">Briefly describe this celebrity.</textarea>
								</div>
							</div>
							<div class=\"form-group\">
						    	<div class=\"col-lg-10 col-lg-offset-2\">
							        <button class=\"btn btn-default\" onclick=\"memberpage.php\">Cancel</button>
							        <button type=\"submit\" class=\"btn btn-info\" name=\"requestnewceleb\">Submit</button>
						    	</div>";
	echo
							"</div>
							</fieldset>
							</form>
					</div>
					</div>
					</div>";
}

function handleNewCelebRequest(){

		$dbc = connect_to_db("hanav");
		$celebname = $_POST['celebName'];
		$description = $_POST['description'];
		$UserEmail = $_COOKIE['loginCookieUser'];
		$userquery = "SELECT * FROM Users WHERE Email='$UserEmail';";
		$userresult = perform_query($dbc, $userquery);
		$obj = mysqli_fetch_object($userresult);
			
		$UserID = ($obj->ID);
		
		$celebCheck = "SELECT `Celeb` FROM `Requests` WHERE `Celeb` = '$celebname';";

	$celebCheck_result = perform_query($dbc, $celebCheck);
	$celebCheck_duplicate = mysqli_fetch_array($celebCheck_result, MYSQLI_ASSOC);

	if (mysqli_num_rows($celebCheck_result) == 0)
	{
		$query = "INSERT INTO `Requests`(Celeb, UserID, RequestTime, Descrp) VALUES ('$celebname', '$UserID', NOW(), '$description')";
		// insert($dbc, $query);
		$adding = perform_query($dbc, $query);
		disconnect_from_db($dbc, $adding);
	}
	else
	{
		echo "<div class='container'>";
		echo "<div class='alert alert-dismissible alert-danger' role='alert'>";
		echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		echo "This celebrity is already requested.</div></div>";
		disconnect_from_db($dbc, $celebCheck_result);
			}
	}
?>
</html>