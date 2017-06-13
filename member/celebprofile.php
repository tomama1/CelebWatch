<?php
include("../include/dconn.php");
if (!isset($_COOKIE['loginCookieUser'])){
	header("Location: notloggedin.html");
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
		<!-- Twitter -->
		<script>window.twttr = (function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0],
				    t = window.twttr || {};
				  if (d.getElementById(id)) return t;
				  js = d.createElement(s);
				  js.id = id;
				  js.src = "https://platform.twitter.com/widgets.js";
				  fjs.parentNode.insertBefore(js, fjs);
				 
				  t._e = [];
				  t.ready = function(f) {
				    t._e.push(f);
				  };
				 
				  return t;
				}(document, "script", "twitter-wjs"));</script>

		</script>

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
			<h1><?php displayCelebName(); ?></h1>
			<?php wikiAPI(); ?>
		</div>
		<br>

		<!-- Twitter -->
		<?php displayTwitter(); ?>

		<!-- INSTAGRAM -->
		<?php
			// $instaID = instaID();
			// can only get from self because not authorized
			$instaurl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=14496402.0b6aa59.f0e189b1a07b4677aeac0b14aa93e9b4";
			$instaresult = fetchData($instaurl);
			$instaresult = json_decode($instaresult);

			echo "<div class='container col-md-8'>";
			foreach ($instaresult->data as $post) {
				$imgurl = $post->images->standard_resolution->url;
				$imgthumbnail = $post->images->thumbnail->url;
				echo "<a href='$imgurl'><img src='$imgthumbnail'></a>";
			}
			echo "</div>";
	?>
	<?php
	function wikiAPI (){
		$WikiID = getWikiID();
		$url = "https://en.wikipedia.org/w/api.php?action=parse&page=".$WikiID."&prop=text&format=json";
		$ch = curl_init($url);

		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT, "TestScript"); // required by wikipedia.org server; use YOUR user agent with YOUR contact information. (otherwise your IP might get blocked)
		$c = curl_exec($ch);

		$json = json_decode($c);
		echo "<div class='container-fluid'>";
		$content = $json->{'parse'}->{'text'}->{'*'}; // get the main text content of the query (it's parsed HTML)

		// pattern for first match of a paragraph
		$pattern = '#<p>(.*)</p>#Us'; 
		if(preg_match($pattern, $content, $matches))
		{
		    // print $matches[0]; // content of the first paragraph (including wrapping <p> tag)
		    echo strip_tags($matches[1]); // Content of the first paragraph without the HTML tags.
		}
		echo "</div>";
	}
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

function displayCelebName(){
	$dbc = connect_to_db("hanav");
	$celebid = $_COOKIE['CelebID'];
	$query = "SELECT * FROM Celebrities WHERE ID='$celebid';";
	$result = perform_query($dbc, $query);
	$obj = mysqli_fetch_object($result);
	disconnect_from_db($dbc, $result);
	echo ($obj->CelebName);
}

function displayTwitter(){
	// Get CelebID
	$dbc = connect_to_db("hanav");
	$celebid = $_COOKIE['CelebID'];
	$query = "SELECT * FROM Celebrities WHERE ID='$celebid';";
	$result = perform_query($dbc, $query);
	$obj = mysqli_fetch_object($result);
	$twitter = ($obj->Twitter);
	$twitid = ($obj->TwitterID);
	$celebName = ($obj->CelebName);
	disconnect_from_db($dbc, $result);
	echo "<div class=\"container col-md-4\">
		<a class=\"twitter-timeline\" href=\"$twitter\" data-widget-id=\"$twitid\">Tweets by @$celebName</a>
		</div>";
}
function getWikiID(){
	$dbc = connect_to_db("hanav");
	$celebid = $_COOKIE['CelebID'];
	$query = "SELECT * FROM Celebrities WHERE ID='$celebid';";
	$result = perform_query($dbc, $query);
	$obj = mysqli_fetch_object($result);
	$WikiID = ($obj->WikiID);
	disconnect_from_db($dbc, $result);
	return $WikiID;
}


// Fetching JSON Data 
function fetchData($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

?>
</html>