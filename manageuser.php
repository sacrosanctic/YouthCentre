<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("ADMIN");
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
		<H2>User Accounts</h2>
		<form action="manageuser_processor.php" method="post">
			<input id="add" type="submit" name="manage" value="add" />
			<br />
			<select></select>
			<input id="edit" type="submit" name="manage" value="edit" />
			<input id="delete" type="submit" name="manage" value="delete" />
		</form>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>