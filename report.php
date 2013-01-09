<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("REPORT_VIEW");
	
	log_event("REPORT_VIEW",$_SESSION["userid"],-1)
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
		<h2>Report</h2>
		Current Active Members:
		<?php
			$sql = "
				SELECT
					count(*)
				FROM `tbl_youth` 
				LEFT JOIN (
					SELECT 
						registrationid,
						youthid, 
						fee,
						paid,
						MAX(registration_date) AS registration_date 
					FROM `tbl_youth_registration`
					GROUP BY youthid
					) AS table2
				ON tbl_youth.youthid = table2.youthid 
				WHERE registration_date + INTERVAL 1 YEAR  > now() AND
				tbl_youth.delete=0";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			echo $row[0];
		
		?>
		<table border="1">
			<tr>
				<th>year</th>
				<th># of registration</th>
				<th>male</th>
				<th>female</th>
				<th>membership (new)</th>
				<th>membership (renewal)</th>
			</tr>
			<?php
			$sql = "
				SELECT 
					YEAR(registration_date) AS 'colYear',
					COUNT(*) AS 'Total',
					SUM(CASE WHEN gender='Male' THEN 1 ELSE 0 END) AS 'Male',
					SUM(CASE WHEN gender='Female' THEN 1 ELSE 0 END) AS 'Female'
				FROM 
					`tbl_youth`
					INNER JOIN `tbl_youth_registration`
					ON tbl_youth.youthid = tbl_youth_registration.youthid
				WHERE
					tbl_youth.delete=0
				GROUP BY 
					colYear
				ORDER BY
					colYear DESC";
			$result = mysql_query($sql);
			while($row=mysql_fetch_array($result))
			{
				echo '<tr>';
				echo '<td>' . $row[0] . '</td>';
				echo '<td>' . $row[1] . '</td>';
				echo '<td>' . $row[2] . '</td>';
				echo '<td>' . $row[3] . '</td>';
				echo '<td></td>';
				echo '<td></td>';
				echo '</tr>';
			}
			?>
		</table>
		
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>