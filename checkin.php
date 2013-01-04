<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("ADMIN");
	
	if($_GET)
	{
		if(!empty($_GET["youthid"]))
		{
			$sql = "INSERT INTO `tbl_youth_time_sheet`(youthID,time_in) VALUES ('" . $_GET["youthid"] . "',NOW());";
			if(!mysql_query($sql))
			{
				die('Error: ' . mysql_error());
			}
			$message = "success!";
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<script type="text/javascript" language="JavaScript">
	window.onload = function () {
		document.getElementById("youthID").focus();
	}
	</script>
	<style type="text/css">
	</style>
</head>
<body>
	<div id="wrapper">
	<?php require_once("./include/header.php"); ?>
	<?php require_once("./include/nav.php"); ?>
	<div id="content">
		<h2>Check-In</h2>
		<?php echo (isset($message) ? $message : null); ?>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="get">
		<input type="text" name="youthid" id="youthID">
		</form>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>