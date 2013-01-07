<?php
	//prevents sql injections
	function make_safe($variable)
	{
		$variable = mysql_real_escape_string(trim($variable));
		return $variable;
	}
	//converts this 9999-12-31 to this 12/31/9999
	function dateformat($date)
	{
	$filename = explode("-",$date);
	$date = $filename[1] . "/" . $filename[2] . "/" . $filename[0];
		
		return $date;
	}
	//converts this 12/31/9999 to this 9999-12-31
	function dateformat2($date)
	{
		$filename = explode("/",$date);
		$date = $filename[2] . "-" . $filename[0] . "-" . $filename[1];
		
		return $date;
	}
	//create function str_ireplace if doesnt exist
	if(!function_exists('str_ireplace'))
	{
		function str_ireplace($search,$replace,$subject)
		{
			if($search != '')
			{
				$token = chr(1);
				$haystack = strtolower($subject);
				$needle = strtolower($search);
				while (($pos=strpos($haystack,$needle))!==FALSE)
				{
					$subject = substr_replace($subject,$token,$pos,strlen($search));
					$haystack = substr_replace($haystack,$token,$pos,strlen($search));
				}
				$subject = str_replace($token,$replace,$subject);
				return $subject;
			}
			else
			{
				return $search;
			}
		}
	}
	function check_permission($permission)
	{
		$sql = "SELECT * FROM `tbl_user` WHERE userID = '$_SESSION[userid]' AND (user_type = 'ADMIN' OR user_type LIKE '%$permission;%')";
		$result = mysql_query($sql);
		//Mysql_num_row is counting table row
		$count = mysql_num_rows($result);
		if($count!=1 || $permission == "")
		{
			echo 'Permission denied. [<a href="' . (isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:"index.php") . '">Back</a>]';
			exit();
		}
	}
	function log_error()
	{}
	function log_event($event,$userid,$youthid,$note="")
	{
		//$userid = 0
		//$youthid = 0
		//$event = 
		//$success = true|false
		$sql = "
			INSERT INTO
				`tbl_user_activity`
				(
					userID,
					timestamp,
					youthID,
					activity_type,
					note
				)
			VALUES
				(
					$userid,
					NOW(),
					$youthid,
					'$event',
					'$note'
				);";
		if(!mysql_query($sql))
		{
			die("Error: " . mysql_error());
		}
	}
?>