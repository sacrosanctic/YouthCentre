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
	</script>
	<style type="text/css">
	</style>
</head>
<body>
	<div id="wrapper">
	<?php require_once("./include/header.php"); ?>
	<?php require_once("./include/nav.php"); ?>
	<div id="content">
		<H2>Manage Members - Full List</h2>
		<?php
			$sql = "SELECT * FROM tbl_youth WHERE tbl_youth.delete=0 ORDER BY f_name;";
			$result = mysql_query($sql);
			$i = 0;
			echo "<p>";
			while($row = mysql_fetch_array($result))
			{
				$i++;
				echo '<a href="managemember_data.php?youthid=' . $row["youthID"] . '">';
				echo "$row[f_name] $row[l_name]";
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