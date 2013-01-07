<div id="nav">
	<a href="managemember.php">Manage Members</a>
	<a href="checkin.php">Check-In</a>
	<a href="report.php">Reports</a>
	<a href="manageuser.php">User Accounts</a>
	<a href="logout.php">Logout</a>
	<?="Login as: " . (isset($_SESSION["user"]) ? $_SESSION["user"] : "Guest") . ".";?>
	<hr />
</div> <!-- End of #nav -->