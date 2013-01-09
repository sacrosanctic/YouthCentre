<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("ADMIN");
	
	$message = "";
	if($_POST)
	{
		//$_POST data
		$username	= $_POST['username'];
		$password	= $_POST['password'];
		$password2	= $_POST['password2'];
		$permission = "";
		for($i=1;$i<=7;$i++)
		{
			$permission .= (isset($_POST['perm'.$i]) ? $_POST['perm'.$i].";" : "");
		}
		//check input
		($username == '' or $username == NULL ? exit("Bad username.") : "");
		($password == '' or $password == NULL ? exit("Bad password.") : "");
		($password2 == '' or $password2 == NULL ? exit("Bad password.") : "");
		//check password match
		($password != $password2 ? exit("password mismatch.") : "");
		//to proteect MySQL injection
		$username = mysql_real_escape_string(stripslashes($username));
		$password = mysql_real_escape_string(stripslashes($password));
		$password = md5($password . file_get_contents("./include/salt.txt"));
		
		$sql = "SELECT * FROM tbl_user WHERE username = '$username'";
		$q = mysql_query($sql) or die (mysql_error());
		$r = mysql_num_rows($q);
		
		($r > 0 ? exit("Username already taken."): "");
		$sql = "INSERT INTO tbl_user (username,password,user_type) VALUES ('$username','$password','$permission')";
		mysql_query($sql) or die (mysql_error()); // Inserts the user.
		$message = "$username is registered.";
		log_event("USER_ADD",$_SESSION["userid"],-1,$username);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<script type="text/javascript" language="JavaScript">
	</script>
	<style type="text/css">
	</style>
</head>
<body>
	<div id="wrapper">
	<?php require_once("./include/header.php"); ?>
	<?php require_once("./include/nav.php"); ?>
	<div id="content">
		<h2>User Accounts</h2>
		<h3>New User</h3>
		<?=$message?>
		<form action="<?=$_SERVER["PHP_SELF"];?>" method="post" class="frmuser">
		<input type="submit" value="Create" />
		<label for="username" class="block">Name:</label><input type="text" name="username" />
		<label for="password" class="block">Password:</label><input type="password" name="password" />
		<label for="password2" class="block">Re-Enter Password:</label><input type="password" name="password2" />
		<fieldset style="width:600px;">
		<legend>Permission</legend>
		<table>
		<tr><td>
		<input type="checkbox" id="perm1" name="perm1" value="MEM_EDIT" /><label for="perm1">Member Add/Edit</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm2" name="perm2" value="MEM_VIEW" /><label for="perm2">Member View</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm3" name="perm3" value="MEM_PAYMENT" /><label for="perm3">Member Payment</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm4" name="perm4" value="CHECK_IN" /><label for="perm4">Member Check-In</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm5" name="perm5" value="REPORT_VIEW" /><label for="perm5">Report View</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm6" name="perm6" value="ADMIN" /><label for="perm6">ADMIN</label>
		</td></tr></table>
		</fieldset>
		</form>
		<h3>Full List</h3>
		<?php
			$sql = "SELECT * FROM tbl_user ORDER BY username;";
			$result = mysql_query($sql);
			$i = 0;
			echo "<p>";
			while($row = mysql_fetch_array($result))
			{
				$i++;
				echo '<a href="manageuser_data.php?userid=' . $row["userID"] . '">';
				echo "$row[username]";
				echo '</a>';
				echo ($i%10 == 0 ? "</p><p>" : " | " );
			}
			echo "</p>";
		?>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>