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
		<h2></h2>
		<form action="register2.php" method="post">
		Name: <input type="text" name="myusername" size="30"><br><br>
		Password: <input type="password" name="mypassword" size="30"><br><br>
		Re-Enter Password: <input type="password" name="mypassword2" size="30"><br><br>
		<fieldset style="width:600px;">
		<legend>Permission</legend>
		<table width=600 border=0>
		<tr>
		<th>Member</th>
		<th>Registraion</th>
		<th>Scanner</th>
		<th>Other</th>
		</tr>
		<tr>
		<td><input type="checkbox" id="perm1" name="perm1" value="MEM_ADD"/><label for="perm1">MEM_ADD</label></td>
		<td><input type="checkbox" id="perm2" name="perm2" value="MEM_REG_ADD"/><label for="perm2">MEM_REG_ADD</label></td>
		<td><input type="checkbox" id="perm3" name="perm3" value="SCAN_ADD"/><label for="perm3">SCAN_ADD</label></td>
		<td><input type="checkbox" id="perm4" name="perm4" value="SEARCH"/><label for="perm4">SEARCH</label></td>
		</tr>
		<tr>
		<td><input type="checkbox" id="perm5" name="perm5" value="MEM_EDIT"/><label for="perm5">MEM_EDIT</label></td>
		<td><input type="checkbox" id="perm6" name="perm6" value="MEM_REG_EDIT"/><label for="perm6">MEM_REG_EDIT</label></td>
		<td></td>
		<td><input type="checkbox" id="perm7" name="perm7" value="REPORT_VIEW"/><label for="perm7">REPORT_VIEW</label></td>
		</tr>
		<tr>
		<td><input type="checkbox" id="perm8" name="perm8" value="MEM_VIEW"/><label for="perm8">MEM_VIEW</label></td>
		<td><input type="checkbox" id="perm9" name="perm8" value="MEM_REG_VIEW"/><label for="perm9">MEM_REG_VIEW</label></td>
		<td><input type="checkbox" id="perm10" name="perm10" value="SCAN_VIEW"/><label for="perm10">SCAN_VIEW</label></td>
		<td><input type="checkbox" id="perm13" name="perm13" value="ADMIN"/><label for="perm13">ADMIN</label></td>
		</tr>
		<tr>
		<td></td>
		<td><input type="checkbox" id="perm11" name="perm11" value="MEM_REG_DEL"/><label for="perm11">MEM_REG_DEL</label></td>
		<td><input type="checkbox" id="perm12" name="perm12" value="SCAN_DEL"/><label for="perm12">SCAN_DEL</label></td>
		<td></td>
		</tr>
		<tr>
		</tr>
		</table>
		</fieldset>
		<input type="submit" value="Register"  onclick='return verify()'>
		</form>
	</div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>