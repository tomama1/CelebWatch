<?php
include("../include/dconn.php");

// if login info not entered or not in database go back to main
if (!isset($_POST['loginEmail']) or !isset($_POST['loginPassword']) or (checklogin($_POST['loginEmail'],$_POST['loginPassword'])==0)){
	header("Location: ../celebwatchmain.php");
}
else{
	setcookie('loginCookieUser', $_POST['loginEmail']);
	header("Location: memberpage.php");
}

// checklogin sees if the information is in Users table
function checklogin($email, $pass){
	$dbc = connect_to_db("hanav");
	$securepass = sha1($pass);
	$query = "SELECT * FROM Users WHERE Email='$email' AND Password='$securepass';";
	$result = perform_query($dbc, $query);
	$match = mysqli_num_rows($result);
	disconnect_from_db($dbc, $result);
	return $match;
}
?>