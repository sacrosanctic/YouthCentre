<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("CHECK_IN");
	
	if($_GET)
	{
		if(!empty($_GET["youthid"]))
		{
			$message = "";
			//check for valid membership
			$sql = "
				SELECT
					MAX(registration_date)
				FROM
					tbl_youth
					INNER JOIN tbl_youth_registration
					ON tbl_youth.youthid = tbl_youth_registration.youthid
				WHERE
					tbl_youth.youthid = $_GET[youthid] AND 
					registration_date + INTERVAL 1 YEAR  > now() AND 
					tbl_youth.delete = 0 
				GROUP BY 
					registration_date";
			$result = mysql_query($sql);
			if(mysql_num_rows($result) == 0)
			{
				$message = "Invalid Membership.";
			}
			else
			{
				//check for double tap
				$sql = "SELECT * FROM tbl_youth_time_sheet WHERE youthid = $_GET[youthid] AND date(time_in)=date(now())";
				$result = mysql_query($sql);
				if(mysql_num_rows($result) > 0)
				{
					$message = "already checked in.";
				}
				else
				{
					//register as checked in
					$sql = "INSERT INTO `tbl_youth_time_sheet`(youthID,time_in) VALUES ('" . $_GET["youthid"] . "',NOW());";
					if(!mysql_query($sql))
					{
						die('Error: ' . mysql_error());
					}
					$sql = "SELECT * FROM tbl_youth WHERE youthID =$_GET[youthid]";
					$result = mysql_query($sql);
					$row = mysql_fetch_array($result);
					$message = "$row[f_name] $row[l_name] has been checked in.";
					log_event("CHECK_IN",$_SESSION["userid"],$_GET["youthid"]);
				}
			}
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