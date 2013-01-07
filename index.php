<?php
	require_once("./include/dbconnect.php");
	session_start();
	if($_POST)
	{
		require_once("./include/login.php");
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style type="text/css">
	<script src="js/index.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/default.css">
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
		<H2>Home</h2>
		<?php
		echo ($_POST ? $login_msg : null);
		if(!isset($_SESSION["user"]))
		{
		?>
		<div id="notice"></div>
		<div id="login">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
				<label for="myusername">Username:</label><input type="text" id="myusername" name="myusername" size="32" value="<?php echo isset($myusername)?$myusername:null?>" /><BR>
				<label for="mypassword">Password:</label><input type="password" id="mypassword" name="mypassword" size="32" value="" /><BR>
				<input class="loginbutton" id="submit" type="submit" name="submit" value="Login" />
			</form>
		</div>
		<?php
		}
		?>
	</div>
	<?php require_once("./include/footer.php"); ?>
</div>
</body>
</html>