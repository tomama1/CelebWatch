<?php
include("../include/dconn.php");
if (isset($_COOKIE['loginCookieUser'])){
	$dbc = connect_to_db("hanav");
	$email = $_COOKIE['loginCookieUser'];
	$query = "SELECT * FROM Users WHERE Email='$email';";
	$result = perform_query($dbc, $query);
	$obj = mysqli_fetch_object($result);
	disconnect_from_db($dbc, $result);
	if ($obj->Admin == "no"){
		header("Location: celebwatchmain.php");
	}
}
else if (!isset($_COOKIE['loginCookieUser'])){
	header("Location: ../celebwatchmain.php");
}
if(isset($_GET['deleterequest']))
	deleteRequest();
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>CelebWatch | Admin</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/lumen/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href= "../css/stylesheet.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script type = "text/javascript" src = "../js/celebValidate.js"></script>
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
	        <li><a href="memberpage.php">MemberPage</a></li>
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
		<div class="page-header container-fluid">
			<h1>Hello, Admin</h1>
		</div>
		<br>
<?php
		if (isset($_POST['submitnewceleb'])){ ?>
			<script>
			if (validate() == true )
			</script>
				<?php	handleNewCeleb();
			} ?>
			
		<!-- REQUESTS TABLE -->

		<?php
			displayRequestTable();
			?>
			
		<!-- NEW CELEBRITY FORM -->
		<div class="container">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Insert New Celebrity</h3>
				</div>
				<div class="panel-body">
					<form method="post" name="newceleb" class="form-horizontal" onsubmit="return validate();">
						<fieldset>
							<!-- Celeb Name -->
							<div class="form-group" id="celebname">
								<label for="celebName" class="col-lg-2 control-label">Celebrity Name</label> <span class="text-danger" id="celebnameerror"></span>
								<div class="col-lg-10">
									<input type="text" class="form-control" name="celebName" id="celebName" placeholder="Celebrity Name">
								</div>
							</div>
							<!-- Occupation -->
							<div class="form-group" id="occupation">
								<label for="Occupation" class="col-lg-2 control-label">Occupation</label> <span class="text-danger" id = "occuperror"></span> 
								<div class="col-lg-10">
									<div class="radio">
										<label>
											<input type="radio" name="occupations" id="music" value="music">
											Music
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="occupations" id="filmtv" value="filmtv">
											Film/TV
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="occupations" id="sports" value="sports">
											Sports
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="occupations" id="comedy" value="comedy">
											Comedy
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="occupations" id="model" value="model">
											Modeling
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="occupations" id="other" value="other">
											Other
										</label>
									</div>
								</div>
							</div>
							<!-- Birthday -->
							<div class="form-group" id="birthdaydiv">
						      <label for="Birthday" class="col-lg-2 control-label">Birthday</label> <span class="text-danger" id="birtherror"></span>
						      <div class="col-lg-10">
						        <input type="text" class="form-control" name="birthday" id="birthday" placeholder="yyyymmdd">
						      </div> 
						    </div>
						    <!-- Wikipedia -->
						    <div class="form-group" id="wikidiv">
						      <label for="celebWiki" class="col-lg-2 control-label">Wikipedia</label> <span class="text-danger" id="wikierror"></span>
						      <div class="col-lg-10">
						        <input type="text" class="form-control" name="wiki" id="wiki" placeholder="https://en.wikipedia.org/wiki/celebrity">
						      </div>
						    </div>
						    <!-- Wiki ID -->
						    <div class="form-group" id="wikiIDdiv">
						      <label for="celebTwitterID" class="col-lg-2 control-label">Wiki ID</label> <span class="text-danger" id="wikiIDerror"></span>
						      <div class="col-lg-10">
						        <input type="text" class="form-control" name="wikiID" id="wikiID" placeholder="celebrity">
						      </div>
						    </div>
						    <!-- Twitter -->
						    <div class="form-group" id="twitterdiv">
						      <label for="celebTwitter" class="col-lg-2 control-label">Twitter</label> <span class="text-danger" id="twittererror"></span>
						      <div class="col-lg-10">
						        <input type="text" class="form-control" name="twitter" id="twitter" placeholder="https://twitter.com/celebrity">
						      </div>
						    </div>
						    <!-- Twitter ID -->
						    <div class="form-group" id="twitterIDdiv">
						      <label for="celebTwitterID" class="col-lg-2 control-label">Twitter ID</label> <span class="text-danger" id="twitterIDerror"></span>
						      <div class="col-lg-10">
						        <input type="text" class="form-control" name="twitterID" id="twitterID" placeholder="00000000">
						      </div>
						    </div>
						    <!-- Instagram -->
						    <div class="form-group" id="instadiv">
						      <label for="celebInsta" class="col-lg-2 control-label">Instagram</label> <span class="text-danger" id="instaerror"></span>
						      <div class="col-lg-10">
						        <input type="text" class="form-control" name="insta" id="insta" placeholder="https://www.instagram.com/celebrity">
						      </div>
						    </div>
						    <!-- Submit -->
						    <div class="form-group">
						    	<div class="col-lg-10 col-lg-offset-2">
							        <button class="btn btn-default" onclick="admin.php">Cancel</button>
							        <button type="submit" class="btn btn-info" name="submitnewceleb">Submit</button>
						    	</div>
						    </div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<br>
		<br>
	</body>

<!-- BOTTOM NAVBAR -->
	<nav class="navbar navbar-default navbar-fixed-bottom">
		<div class="container-fluid">
			<ul class="navbar-form navbar-left">
				<p>&copy; 2016 Angela Han, Eunice Kang, Matthew Toma.</p>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			    <li class="active"><a href="admin.php">Admin</a></li>
			</ul>
		</div>
	</nav>

<?php
	function handleNewCeleb(){
		$dbc = connect_to_db("hanav");
		$celebname = $_POST['celebName'];
		$occupation = $_POST['occupations'];
		$celebbirthday = $_POST['birthday'];
		$celebwiki = $_POST['wiki'];
		$celebwikiid = $_POST['wikiID'];
		$celebtwitter = $_POST['twitter'];
		$celebtwitterid = $_POST['twitterID'];
		$celebinsta = $_POST['insta'];
		
		$celebCheck = "SELECT `CelebName` FROM `Celebrities` WHERE `CelebName` = '$celebname' AND 'Birthday' = '$celebbirthday';";

	$celebCheck_result = perform_query($dbc, $celebCheck);
	$celebCheck_duplicate = mysqli_fetch_array($celebCheck_result, MYSQLI_ASSOC);

	if (mysqli_num_rows($celebCheck_result) == 0)
	{
		$query = "INSERT INTO `Celebrities`(CelebName, Occupation, Birthday, Wikipedia, WikiID, Twitter, TwitterID, Instagram) VALUES ( '$celebname', '$occupation', '$celebbirthday', '$celebwiki' , '$celebwikiid', '$celebtwitter' , '$celebtwitterid', '$celebinsta' )";
		// insert($dbc, $query);
		$adding = perform_query($dbc, $query);
		disconnect_from_db($dbc, $adding);
	}
	else
	{
		echo "<div class='container'>";
		echo "<div class='alert alert-dismissible alert-danger' role='alert'>";
		echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		echo "This celebrity is already in the database.</div></div>";
		disconnect_from_db($dbc, $celebCheck_result);
			}
	
	}
function displayRequestTable(){
	$dbc = connect_to_db("hanav");
	$query = "SELECT * FROM `Requests` JOIN `Users` ON `Requests`.UserID = `Users`.ID ORDER BY `RequestTime`";
	$result = perform_query($dbc, $query);
	$rowsFound = mysqli_num_rows($result);
	echo "<div class=\"container\">
			<div class=\"panel panel-info\">
				<div class=\"panel-heading\">
					<h3 class=\"panel-title\">Requests</h3>
				</div>
				<div class=\"panel-body\">
					<table class=\"table table-striped table-hover\">
					  <thead>
					    <tr>
					      <th>Celebrity Name</th>
					      <th>User Name</th>
					      <th>Request Time</th>
					      <th>Description</th>
					      <th> </th>
					    </tr>
					  </thead>
					  <tbody>";
	while (@extract(mysqli_fetch_array($result, MYSQLI_ASSOC))) {
		echo "<tr>
				<form method='get' name='request'>
				<td>$Celeb</td>
			    <td>$UserName</td>
			    <td>$RequestTime</td>
			    <td>$Descrp</td>
			    <td>
			    	<input type='hidden' name='requesttime' value='$RequestTime'>
			    	<input type='hidden' name='userid' value='$UserID'>
			    	<button type='submit' name='deleterequest' class='btn btn-danger btn-xs'>Done?</button>
			    </td>
			    </form>
			  </tr>";
	}
	echo "</table></div></div></div>";
}

function deleteRequest(){
	$dbc = connect_to_db("hanav");
	$Rtime = $_GET['requesttime'];
	$UserID = $_GET['userid'];
	$deletequery = "DELETE FROM Requests WHERE RequestTime='$Rtime' AND UserID='$UserID';";
	$deleterequest = perform_query($dbc, $deletequery);
	disconnect_from_db($dbc, $deleterequest);
	header("Refresh: 5; url=admin.php");
}
?>
</html>