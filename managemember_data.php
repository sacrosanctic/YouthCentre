<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("MEM_VIEW");

	if(!$_POST)
	{
		if($_GET)
		{
			$sql = "SELECT * FROM tbl_youth WHERE youthID=$_GET[youthid];";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$name = $row["f_name"] . " " . $row["l_name"];
			log_event("MEM_VIEW",$_SESSION["userid"],$_GET["youthid"]);

			//check weather this member has paid
			$sql = "
				SELECT
					*
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
				WHERE 
					registration_date + INTERVAL 1 YEAR  > now() AND 
					tbl_youth.youthid = $_GET[youthid]";
			$result = mysql_query($sql);
			if(mysql_num_rows($result) == 1)
			{
				$paid = true;
			}
			else
			{
				$paid = false;
			}
		}
		else
		{
			echo "missing Youth ID.";
			exit;
		}
	}
	else
	{
		check_permission("MEM_EDIT");
		$photo = "./photo/" . $_POST["youthID"] . ".jpg";
		switch ($_POST['submit']) {
			case 'Save':
				switch ($_FILES["file"]["error"]) {
					//success
					case 0:
						if (ereg("^image/(jpg|jpeg|pjpeg)$",$_FILES["file"]["type"]))
						{
							move_uploaded_file($_FILES['file']['tmp_name'],$photo);
						}
						else
						{
							echo "Photo: invalid file type. [" . $_FILES["file"]['type'] . "]";
						}
						break;
					//size limit exceeded
					case 1:
					case 2:
						echo "Photo: Files size greater than 4mb.<br />";
						break;
					//no file was uploaded
					case 4:
						break;
					//problem with file
					default:
						echo "Photo: Unable to upload file.<br />";
				}
				$sql = "
					UPDATE `tbl_youth`
					SET f_name          ='" . make_safe($_POST['f_name']) . "',
						l_name          ='" . make_safe($_POST['l_name']) . "',
						gender          ='" . make_safe($_POST['gender']) . "',
						birthdate       ='" . dateformat2(make_safe($_POST['birthdate'])) . "',
						grade           ='" . make_safe($_POST['grade']) . "',
						address         ='" . make_safe($_POST['address']) . "',
						city            ='" . make_safe($_POST['city']) . "',
						postal_code     ='" . make_safe($_POST['postal_code']) . "',
						home            ='" . make_safe($_POST['home']) . "',
						cell            ='" . make_safe($_POST['cell']) . "',
						email           ='" . make_safe($_POST['email']) . "',
						school          ='" . make_safe($_POST['school']) . "',
						parent          ='" . make_safe($_POST['parent']) . "',
						parent_num      ='" . make_safe($_POST['parent_num']) . "',
						ec_name         ='" . make_safe($_POST['ec_name']) . "',
						ec_num          ='" . make_safe($_POST['ec_num']) . "',
						ec_relationship ='" . make_safe($_POST['ec_relationship']) . "',
						doctor          ='" . make_safe($_POST['doctor']) . "',
						doctor_num      ='" . make_safe($_POST['doctor_num']) . "',
						care_card       ='" . make_safe($_POST['care_card']) . "',
						allergy         ='" . make_safe($_POST['allergy']) . "',
						stat_1          ='" . make_safe($_POST['stat_1']) . "',
						stat_2          ='" . ($_POST['stat_1'] == "yes" ? make_safe($_POST['stat_2']) : "" ) . "',
						stat_3          ='" . ($_POST['stat_1'] == "yes" ? make_safe($_POST['stat_3']) : "" ) . "',
						stat_4          ='" . make_safe($_POST['stat_4']) . "',
						last_modified	=NOW()
					WHERE youthID       ='" . make_safe($_POST['youthID']) . "';";
				if(!mysql_query($sql))
				{
					die('Error: ' . mysql_error());
				}
				log_event("MEM_EDIT",$_SESSION["userid"],$_POST["youthID"]);
				header("location:managemember_data.php?youthid=" . make_safe($_POST['youthID']));
				break;
			case 'Delete':
				$sql = "UPDATE tbl_youth SET tbl_youth.delete=1 WHERE youthID=" . $_POST["youthID"];
				if(!mysql_query($sql))
				{
					die("Error: " . mysql_error());
				}
				log_event("MEM_DEL",$_SESSION["userid"],$_POST["youthID"]);
				header("location:managemember.php");
				break;
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href="css/default.css" />
	<script type="text/javascript" language="JavaScript">
	function doublecheck()
	{
		var temp = confirm("Are you sure you want to remove <?php echo $name; ?>?");
		return (temp == true) ? true : false;
	}
	</script>
	<style type="text/css">
	div#content div label
	{
		display:block;
	}
	div#content div input
	{
		width:200px;
	}
	div#content div select
	{
		width:203px;
	}
	</style>
</head>
<body>
	<div id="wrapper">
	<?php require_once("./include/header.php"); ?>
	<?php require_once("./include/nav.php"); ?>
	<div id="content">
		<h2>Manage Members - <?php echo $name; ?></h2>
		<p>
			<a href="managemember_payment.php?youthid=<?=$row["youthID"]?>"><input type="button" value="Payment"></a>
			<a href="checkin.php?youthid=<?=$row["youthID"]?>"><input type="button" value="Check-In"></a>
			<a href="managemember_form.php?youthid=<?=$row["youthID"]?>" target="_blank"><input type="button" value="Print"></a>
		</p>
		<p>
			Status: <?=($paid?"Paid":"Unpaid");?>
		</p>
		<form name="editmember" action="<?=$_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data">
			<input type="submit" name="submit" value="Save">
			<a href="managemember.php"><input type="button" name="cancel" value="Cancel"></a>
			<input type="submit" name="submit" value="Delete" onclick="return doublecheck();">
			<div id="photowrapper">
				<?php
					$photo = "./photo/" . $row["youthID"] . ".jpg";
					$temp = (file_exists($photo) ? $photo : "images/noimage.gif");
				?>
				<img src="<?php echo $temp; ?>" alt="" id="photo" style="width:100px;border:1px black solid;"><br />
				<input name="file" type="file" value="Add photo">
			</div>
			<div>
			<label for="yid">youth ID:</label>
			<input type="text" name="youthID" id="yid" value="<?php echo $row["youthID"]; ?>" readonly="readonly">
			</div>
			<div>
			<label for="fname">First Name:</label>
			<input type="text" name="f_name" id="fname" value="<?php echo $row["f_name"]; ?>">
			</div>
			<div>
			<label for="lname">Last name:</label>
			<input type="text" name="l_name" id="lname" value="<?php echo $row["l_name"]; ?>">
			</div>
			<div>
			<label for="gender">Gender:</label>
			<select name="gender" id="gender">
				<option value=""<?php echo ($row["gender"] == "" ? ' selected="yes"':""); ?>></option>
				<option value="Male"<?php echo ($row["gender"] == "Male" ? ' selected="yes"':""); ?>>Male</option>
				<option value="Female"<?php echo ($row["gender"] == "Female" ? ' selected="yes"':""); ?>>Female</option>
			</select>
			</div>
			<div>
            <label for="bdate">Birthdate (mm/dd/yyyy):</label>
            <input type="text" name="birthdate" id="bdate" value="<?php echo dateformat($row["birthdate"]); ?>">
			</div>
			<div>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo $row["address"]; ?>">
			</div>
			<div>
            <label for="city">City:</label>
            <select name="city" id="city">
				<option value=""></option>
				<?php
				//city listing
				$sql = "SELECT * from ref_city order by city";
				$result = mysql_query($sql);
				while($temp = mysql_fetch_array($result))
				{
					echo '<option value="' . $temp["cityID"] . '"'. ($row["city"] == $temp["cityID"] ? ' selected="yes"' : "") .'>' . $temp["city"] . '</option>';
				}
				?>
            </select>
			</div>
			<div>
            <label for="postalcode">Postal Code:</label>
            <input type="text" name="postal_code" id="postalcode" value="<?php echo $row["postal_code"]; ?>">
			</div>
			<div>
            <label for="homenum">Home Phone:</label>
            <input type="text" name="home" id="homenum" value="<?php echo $row["home"]; ?>">
			</div>
			<div>
            <label for="cellnum">Cell Phone:</label>
            <input type="text" name="cell" id="cellnum" value="<?php echo $row["cell"]; ?>">
			</div>
			<div>
            <label for="email">E-mail:</label>
            <input type="text" name="email" id="email" value="<?php echo $row["email"]; ?>">
			</div>
			<div>
            <label for="school">school attending:</label>
            <select name="school" id="school">
                <option value=""></option>
				<?php
				//school listing
				$sql = "SELECT * from ref_school order by school";
				$result = mysql_query($sql);
				while($temp = mysql_fetch_array($result))
				{
					echo '<option value="' . $temp["schoolID"] . '"'. ($row["school"] == $temp["schoolID"] ? ' selected="yes"' : "") .'>' . $temp["school"] . '</option>';
				}
				?>
            </select>
			</div>
			<div>
            <label for="grade">Grade:</label>
            <input type="text" name="grade" id="grade" value="<?php echo $row["grade"]; ?>">
			</div>
			<div>
            <label for="parent">Parent/Guardian:</label>
            <input type="text" name="parent" id="parent" value="<?php echo $row["parent"]; ?>">
			</div>
			<div>
            <label for="contactnum">Contact #:</label>
            <input type="text" name="parent_num" id="contactnum" value="<?php echo $row["parent_num"]; ?>">
			</div>
			<div>
            <label for="ecname">Name:</label>
            <input type="text" name="ec_name" id="ecname" value="<?php echo $row["ec_name"]; ?>">
			</div>
			<div>
            <label for="ecnum">Contact #:</label>
            <input type="text" name="ec_num" id="ecnum" value="<?php echo $row["ec_num"]; ?>">
			</div>
			<div>
            <label for="ecrelation">Relationship:</label>
            <input type="text" name="ec_relationship" id="ecrelation" value="<?php echo $row["ec_relationship"]; ?>">
			</div>
			<div>
            <label for="carecard">Care Card #:</label>
            <input type="text" name="care_card" id="carecard" value="<?php echo $row["care_card"]; ?>">
			</div>
			<div>
            <label for="drname">Doctor:</label>
            <input type="text" name="doctor" id="drname" value="<?php echo $row["doctor"]; ?>">
			</div>
			<div>
            <label for="drnum">Contact #:</label>
            <input type="text" name="doctor_num" id="drnum" value="<?php echo $row["doctor_num"]; ?>">
			</div>
			<div>
            <label for="allergies">Allergies and Medical Concerns:</label>
            <input type="text" name="allergy" id="allergies" value="<?php echo $row["allergy"]; ?>">
			</div>
			<div>
            <label for="immigrant">Canadian Immigrant:</label>
            <select name="stat_1" id="immigrant">
                <option value=""<?php echo ($row["stat_1"] == "" ? ' selected="yes"':""); ?>></option>
                <option value="Yes"<?php echo ($row["stat_1"] == "Yes" ? ' selected="yes"':""); ?>>Yes</option>
                <option value="No"<?php echo ($row["stat_1"] == "No" ? ' selected="yes"':""); ?>>No</option>
            </select>
			</div>
			<div>
            <label for="country">Country of Origin:</label>
            <select name="stat_2" id="country">
                <option value=""></option>
				<?php
				//school listing
				$sql = "SELECT * FROM ref_country ORDER BY country";
				$result = mysql_query($sql);
				while($temp = mysql_fetch_array($result))
				{
					echo '<option value="' . $temp["countryID"] . '"'. ($row["stat_2"] == $temp["countryID"] ? ' selected="yes"' : "") .'>' . $temp["country"] . '</option>';
				}
				?>
            </select>
			</div>
			<div>
            <label for="canada">Years in Canada:</label>
            <input type="text" name="stat_3" id="canada" value="<?php echo $row["stat_3"]; ?>">
			</div>
			<div>
            <label for="aboriginal">Aboriginal Youth:</label>
            <select name="stat_4" id="aboriginal">
                <option value=""<?php echo ($row["stat_4"] == "" ? ' selected="yes"':""); ?>></option>
                <option value="Yes"<?php echo ($row["stat_4"] == "Yes" ? ' selected="yes"':""); ?>>Yes</option>
                <option value="No"<?php echo ($row["stat_4"] == "No" ? ' selected="yes"':""); ?>>No</option>
            </select>
			</div>
		</form>
    </div>
	<?php require_once("./include/footer.php"); ?>
	</div>
</body>
</html>