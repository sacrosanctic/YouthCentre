<?php
	require_once("./include/dbconnect.php");

	// username and password sent from form
	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword'];
	
	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	$mypassword = md5($mypassword . file_get_contents("./include/salt.txt"));
	
	
	//accreditation check
	$sql = "SELECT * FROM tbl_user WHERE username='$myusername' and password='$mypassword'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	// Mysql_num_row is counting table row
	$count = mysql_num_rows($result);

	//accreditation check
	$sql = "SELECT * FROM tbl_user WHERE username='$myusername'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	$userid = (mysql_num_rows($result) > 0 ? $row["userID"] : -1);
	
	$sql = "INSERT into tbl_user_login (ip,timestamp,user,pass) values ('" . $_SERVER['REMOTE_ADDR'] . "',NOW(),'$userid', '$count')";
	mysql_query($sql);
	
	// If result matched $myusername and $mypassword, table row must be 1 row
	//session_start();
	if($count==1)
	{
		//store the username in a session var
		$_SESSION["user"] = $row["username"];
		$_SESSION["userid"] = $row["userID"];
		$_SESSION["lastactivity"] = time();
		$login_msg = 'Welcome, ' . $_SESSION["user"] . '!';
	}
	else
	{
		session_destroy();
		$login_msg = "Wrong Username or Password";
	}
?>