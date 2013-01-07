<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("MEM_EDIT");

	if($_POST["first"] == "" || $_POST["last"] == "")
	{
		echo "empty values";
		exit;
	}
	$sql = "INSERT INTO `tbl_youth`(f_name,l_name,creation_date) VALUES ('" . ucfirst(strtolower($_POST["first"])) . "','" . ucfirst(strtolower($_POST["last"])) . "',NOW());";
	if(!mysql_query($sql))
	{
		die('Error: ' . mysql_error());
	}
	$sql = "select LAST_INSERT_ID()";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$ID = $row[0];
	log_event("MEM_ADD",$_SESSION["userid"],$ID);
	header("location:managemember_data.php?youthid=$ID");
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
		<h2></h2>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>