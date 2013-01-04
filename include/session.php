<?php
require_once("./include/dbconnect.php");
/*
// path for cookies
$cookie_path = "/";

// timeout value for the cookie
$cookie_timeout = 60 * 15; // in seconds

// timeout value for the garbage collector
//   we add 300 seconds, just in case the user's computer clock
//   was synchronized meanwhile; 600 secs (10 minutes) should be
//   enough - just to ensure there is session data until the
//   cookie expires
$garbage_timeout = $cookie_timeout + 600; // in seconds

// set the PHP session id (PHPSESSID) cookie to a custom value
session_set_cookie_params($cookie_timeout, $cookie_path);

// set the garbage collector - who will clean the session files -
//   to our custom timeout
ini_set('session.gc_maxlifetime', $garbage_timeout);
*/
session_start();
//if user doesnt exist or have been inactive for over 30 minutes
if(!isset($_SESSION["user"]))
{
	session_destroy();
	header("location:index.php");
}
else
{
	$timeout_min = 30;
	$timeout_length = $timeout_min * 60;
	if((time() - $_SESSION["lastactivity"]) > $timeout_length)
	{
		$sql = "INSERT INTO tbl_user_activity (userID,timestamp,activity_type) VALUES ('" . $_SESSION['userid'] . "','" . $_SESSION['lastactivity'] . "','access time')";
		mysql_query($sql);
		mysql_close($con);
		session_destroy();
		header("location:index.php");
	}
	else
	{
		//echo time() - $_SESSION["lastactivity"] . ">" . $timeout_length;
		$_SESSION["lastactivity"] = time();
	}
}
/*
//error handler function
function customError($errno, $errstr, $errfile, $errline)
{ 
	echo "<b>Error:</b> [$errno] $errstr on line <b>$errline</b><br />";
	echo "This will be logged, if this happens again, please notify the admin";
	error_log("\nError: [$errno] $errstr - $errfile on line $errline",0);
}

//set error handler
set_error_handler("customError");
*/
?>