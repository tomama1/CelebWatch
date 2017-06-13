<?php
include("include/dconn.php");
?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>CelebWatch</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/lumen/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href= "css/cwstylesheet.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script type = "text/javascript" src= "js/validateSignup.js"></script>
		<script type = "text/javascript" src = "js/validatelogin.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Advent+Pro' rel='stylesheet' type='text/css'>
	</head>

	<!-- NAVIGATION BAR -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="celebwatchmain.php">CelebWatch</a>
	    </div>

	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li><a href="member/memberpage.php">MemberPage</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="member/logout.php">Logout</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>

<!-- BODY -->
	<body>
		<div class="text-center">
			<h1>CELEBWATCH</h1><br>
			<div class="text-center">
				<form method="get" name= "button">
					<input type="submit" class="btn btn-info btn-lg" name="signup" value="Sign Up Here">
					<input type="submit" class="btn btn-info btn-lg" name="login" value="Already a member? Login">
				</form>
			</div>
		</div>
		<br>
<?php
		// if the signup button is pressed show the signup form
			if (isset($_GET['signup'])){
				displaySignup();
			}
			if (isset($_POST['submitsignup'])){ ?>
				<script>
					if(validate() == true)
				</script>
				<?php	handleSignup();
			}
			if (isset($_GET['login'])){
				displayLogin();
			}
?>
	</body>

<!-- BOTTOM NAV BAR -->
	<nav class="navbar navbar-default navbar-fixed-bottom">
		<div class="container-fluid">
			<ul class="navbar-form navbar-left">
				<p>&copy; 2016 Angela Han, Eunice Kang, Matthew Toma.</p>
				<p><a href="privacypolicy.html">Privacy Policy</a> and <a href="useterms.html">Terms of Use</a></p>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			    <li><a href="member/admin.php">Admin</a></li>
			</ul>
		</div>
	</nav>

<!-- FUNCTION TO DISPLAY SIGNUP FORM -->

<?php
	function displaySignup(){
?>
	<div class="container" id="signupform">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Sign-up Form</h3>
			</div>
			<div class="panel-body">
				<form method="post" name="signup" class="form-horizontal" onsubmit="return validate();">
					<fieldset>
						<!-- Name -->
						<div class="form-group" id="signupname">
							<label for="inputName" class="col-lg-2 control-label">Name</label> <span class="text-danger" id="nameerror"></span>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="name" id="inputName" placeholder="Full Name">
							</div>
						</div>
						<!-- Email -->
						<div class="form-group" id="signupemail">
							<label for="inputEmail" class="col-lg-2 control-label">Email</label> <span class="text-danger" id="emailerror"></span>
							<div class="col-lg-10">
								<input type="email" class="form-control" name="email" id="inputEmail" placeholder="youremail@domain.com">
							</div> 
						</div>
						<!-- Password -->
						<div class="form-group" id="signuppass">
					      <label for="inputPassword" class="col-lg-2 control-label">Password</label> <span class="text-danger" id="pwerror"></span>
					      <div class="col-lg-10">
					        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
					      </div>
					    </div>
					    <!-- Password Verification -->
					    <div class="form-group" id="checkpass">
					      <label for="verifyPassword" class="col-lg-2 control-label">Verify Password</label> <span class="text-danger" id="pwchkerror"></span>
					      <div class="col-lg-10">
					        <input type="password" class="form-control" name="verifyp" id="verifyPassword" placeholder="Retype Password">
					      </div>
					    </div>
					    <!-- Agree and Read -->
					    <div class="checkbox" id="termscond">
					    	<div class="error" id = "termerror"></div>
					    	<label>
					    		<input type="checkbox" name="agree" value="agreed" id="terms"> I agree to the Terms and Conditions and have read the <a href="privacypolicy.html">Privacy Policy</a>.
					    	</label>
					    </div>
					    <input type="hidden" name="admin" value="no">
					    <!-- Submit -->
					    <div class="form-group">
					    	<div class="col-lg-10 col-lg-offset-2">
						        <button class="btn btn-default" onclick="celebwatchmain.php">Cancel</button>
						        <button type="submit" class="btn btn-info" name="submitsignup">Submit</button>
					    	</div>
					    </div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
<?php
	}
?>
<!-- FUNCTION TO HANDLE THE SIGNUP FORM -->
<?php
	function handleSignup(){
		$dbc = connect_to_db("hanav");
		$join_name =  $_POST['name'];
		$join_email = $_POST['email'];
		$join_password = $_POST['password'];
		$join_verifypass = $_POST['verifyp'];
		$notadmin = $_POST['admin'];

		if ($join_password == $join_verifypass){
			$emailcheck = "SELECT `Email` FROM `Users` WHERE `Email`='$join_email';";
			$result = perform_query($dbc, $emailcheck);
			if ($result->num_rows == 0){
				$join_securepw = sha1($join_password);
				$query = "INSERT INTO `Users` (`UserName`,`Password`,`Email`) VALUES ( '$join_name', '$join_securepw', '$join_email')";
				$adding = perform_query($dbc, $query);
				disconnect_from_db($dbc, $adding);
			}
			else{
				// want to make the errors appear in alert boxes
				echo "<div class='container'>";
				echo "<div class='alert alert-dismissible alert-danger' role='alert'>";
				echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
				echo "<strong>Error!</strong> Already existing email.</div></div>";
				disconnect_from_db($dbc, $result);
			}
		}
		else{
			echo "<div class='container'>";
			echo "<div class='alert alert-dismissible alert-danger' role='alert'>";
			echo "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
			echo "<strong>Error!</strong> Passwords don't match.</div></div>";
		}
	}
?>

<!-- FUNCTION TO DISPLAY LOGIN FORM -->

<?php
	function displayLogin(){
?>
	<div class="container" id="loginform">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Log-in</h3>
			</div>
			<div class="panel-body">
				<form method="post" name="loginform" class="form-horizontal" action="member/login.php" onsubmit = "return validatelogIn();">
					<fieldset>
						<!-- Email -->
						<div class="form-group" id="emaildiv">
							<label for="loginEmail" class="col-lg-2 control-label">Email</label> <span class="text-danger" id="loginemailerror"></span>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="loginEmail" id="loginEmail" placeholder="Email">
							</div>
						</div>
						<!-- Password -->
						<div class="form-group" id="passdiv">
						    <label for="loginPassword" class="col-lg-2 control-label">Password</label> <span class="text-danger" id="loginpwerror"></span>
						    <div class="col-lg-10">
						    <input type="password" class="form-control" name="loginPassword" id="loginPassword" placeholder="Password">
						    </div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>

<?php
}
?>
</html>