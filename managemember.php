<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("MEM_VIEW");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<script type="text/javascript" language="JavaScript">
	function youthidsearch()
	{
		var youthid = document.getElementById("idsearch").value;
		parent.location = "managemember_data.php?youthid=" + youthid;
		return false;
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
		<h2>Manage Members</h2>
		<h3>New Member</h3>
		<form action="managemember_new.php" method="post">
		Name (First Last):<br /><input type="text" name="first"><input type="text" name="last"><input type="submit" value="Create">
		</form>
		<h3>Member Look-Up</h3>
		<form action="managemember_search.php" method="post">
		Name: <input type="text" name="search"><input type="submit" value="Search">
		</form>
		<form action="managemember_data.php" method="get">
		Youth ID: <input type="text" name="youthid" /><input type="submit" value="Search">
		<h3>Full List</h3>
		</form>
		<a href="managemember_fulllist.php">link</a>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>