<?php
	$host="localhost"; // Host name
	$username="php"; // Mysql username
	$password="oJzVunsi^@*YQG5N!3dn"; // Mysql password
	$db_name="cnh"; // Database name
	
	// Connect to server and select databse.
	$con = mysql_connect("$host", "$username", "$password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");
?>