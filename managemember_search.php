<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("MEM_VIEW");

	log_event("MEM_SEARCH",$_SESSION["userid"],-1,$_POST["search"]);
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
		<h2>Manage Members - Search "<?php echo $_POST["search"]; ?>"</h2>
		<form action="<?=$_SERVER["PHP_SELF"]?>" method="post">
		<input type="text" name="search" value="<?php echo $_POST["search"]; ?>"><input type="submit" value="Search">
		</form><br />
		<?php
			$sql = "
				SELECT 
					youthID, 
					f_name,
					l_name
				FROM `tbl_youth` 
				WHERE 
					concat(f_name,' ',l_name) like '%" . $_POST["search"] . "%' AND
					tbl_youth.delete=0
				ORDER BY
					f_name,
					l_name
			";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result))
			{
				echo '<a href="managemember_data.php?youthid=' . $row["youthID"] . '">';
				echo "$row[f_name] $row[l_name]";
				echo '</a><br />';
			}
		?>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>