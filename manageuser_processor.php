<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("ADMIN");
	
	switch ($_POST['manage']) {
		case 'add':
			echo "hello";
			break;
		case 'edit':
			break;
		case 'delete':
			break;
	}
?>