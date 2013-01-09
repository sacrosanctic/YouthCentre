<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("ADMIN");
	
	function checkdefault($needle,$haystack)
	{
		return (!strpos($haystack,$needle) ? "" : " checked=checked");
	}

	if(!$_POST)
	{
		if($_GET)
		{
			$sql = "SELECT * FROM tbl_user WHERE userID=$_GET[userid];";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			log_event("USER_VIEW",$_SESSION["userid"],$_GET["userid"]);
		}
		else
		{
			echo "missing User ID.";
			exit;
		}
	}
	else
	{

		$password	= $_POST['password'];
		$permission = "";
		for($i=1;$i<=7;$i++)
		{
			$permission .= (isset($_POST['perm'.$i]) ? $_POST['perm'.$i].";" : "");
		}
		if($password != "")
		{
			$password = mysql_real_escape_string(stripslashes($password));
			$password = "password ='" . md5($password . file_get_contents("./include/salt.txt")) . "',";
		}
		
		$sql = "
			UPDATE 
				`tbl_user`
			SET 
				" . $password . "
				user_type ='" . $permission . "'
			WHERE userID ='" . make_safe($_POST['userid']) . "';";
		mysql_query($sql) or die (mysql_error()); // Inserts the user.
		log_event("USER_EDIT",$_SESSION["userid"],$_POST['userid']);
		header("location:manageuser_data.php?userid=" . make_safe($_POST['userid']));
	
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
		<h2>Manage User - <?=$row["username"];?></h2>
		<form action="<?=$_SERVER["PHP_SELF"];?>" method="post" class="frmuser">
		<input type="submit" value="Save" />
		<label for="userid" class="block">User ID:</label><input type="text" name="userid" value="<?=$row["userID"];?>" readonly=readonly />
		<label for="username" class="block">Name:</label><input type="text" name="username" value="<?=$row["username"];?>" readonly=readonly />
		<label for="password" class="block">Password:</label><input type="password" name="password" />
		<fieldset style="width:600px;">
		<legend>Permission</legend>
		<table>
		<tr><td>
		<input type="checkbox" id="perm1" name="perm1" value="MEM_EDIT"<?=(strpos($row["user_type"],"MEM_EDIT") === false ? "" : " checked=checked");?> /><label for="perm1">Member Add/Edit</label>
		
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm2" name="perm2" value="MEM_VIEW"<?=(strpos($row["user_type"],"MEM_VIEW") === false ? "" : " checked=checked");?> /><label for="perm2">Member View</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm3" name="perm3" value="MEM_PAYMENT"<?=(strpos($row["user_type"],"MEM_PAYMENT") === false ? "" : " checked=checked");?> /><label for="perm3">Member Payment</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm4" name="perm4" value="CHECK_IN"<?=(strpos($row["user_type"],"CHECK_IN") === false ? "" : " checked=checked");?> /><label for="perm4">Member Check-In</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm5" name="perm5" value="REPORT_VIEW"<?=(strpos($row["user_type"],"REPORT_VIEW") === false ? "" : " checked=checked");?> /><label for="perm5">Report View</label>
		</td></tr>
		<tr><td>
		<input type="checkbox" id="perm6" name="perm6" value="ADMIN" checked=checked  <?=(strpos($row["user_type"],"ADMIN") === false ? "" : " checked=checked");?>/><label for="perm6">ADMIN</label>
		</td></tr></table>
		</fieldset>
		</form>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>