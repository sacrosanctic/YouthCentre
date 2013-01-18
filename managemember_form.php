<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	require_once("./include/fpdf/fpdf.php");
	check_permission("MEM_PRINT");

	if(!$_GET)
	{
		//echo "No ID selected.";
		//exit;
		error_reporting(E_ALL & ~E_NOTICE);
	}
	else
	{
		$sql = "
			SELECT
				*,
				DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(birthdate, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(birthdate, '00-%m-%d')) AS age,
				UPPER(DATE_FORMAT(birthdate,'%d/%b/%Y')) AS birthdate,
				CONCAT(f_name , ' ' , l_name) AS fullname
			FROM 
				tbl_youth 
			WHERE 
				youthID = $_GET[youthid]";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
	}
	
	//Text Height
	$th = 6;
	$border = 0;
	
	$pdf = new FPDF('P','mm','Letter');
	$pdf->AddPage();
	//start of title
	$pdf->SetTitle('Registration Form - Youth');
	$pdf->SetCreator('Youth Centre Database');
	$pdf->SetAuthor('Collingwood Youth Services');
	$pdf->SetFont('Arial','',14);
	//start of page one
	$pdf->Image('./images/form_p1_v3.6.jpg',0,0,215.9);
	$pdf->SetXY(65,86);
	$pdf->Cell(95,$th,$row['fullname'],$border,0,'C');
	switch ($row['gender'])
	{
		case 'Male': 
			$pdf->SetXY(165,86);
			$pdf->Cell(4.5,$th,'',1,0,'C');
			break;
		case 'Female': 
			$pdf->SetXY(172,86);
			$pdf->Cell(4.5,$th,'',1,0,'C');
			break;
		default: 
			break;
	}
	$pdf->SetXY(83,95);
	$pdf->Cell(53,$th,$row['birthdate'],$border,0,'C');
	$pdf->SetXY(156,95);
	$pdf->Cell(32,$th,$row['age'],$border,0,'C');
	$pdf->SetXY(49,105);
	$pdf->Cell(141,$th,$row['address'],$border,0,'C');
	$pdf->SetXY(42,114);
	$pdf->Cell(76,$th,$row['city'],$border,0,'C');
	$pdf->SetXY(162,114);
	$pdf->Cell(28,$th,$row['postal_code'],$border,0,'C');
	$pdf->SetXY(58,123);
	$pdf->Cell(43,$th,$row['home'],$border,0,'C');
	$pdf->SetXY(145,123);
	$pdf->Cell(43,$th,$row['cell'],$border,0,'C');
	$pdf->SetXY(61,132.5);
	$pdf->Cell(129,$th,$row['email'],$border,0,'C');
	$pdf->SetXY(66,142);
	$pdf->Cell(58,$th,$row['school'],$border,0,'C');
	$pdf->SetXY(149,142);
	$pdf->Cell(41,$th,$row['grade'],$border,0,'C');
	$pdf->SetXY(77,151);
	$pdf->Cell(49,$th,$row['parent'],$border,0,'C');
	$pdf->SetXY(155,151);
	$pdf->Cell(37,$th,$row['parent_num'],$border,0,'C');
	$pdf->SetXY(64,170);
	$pdf->Cell(123,$th,$row['ec_name'],$border,0,'C');
	$pdf->SetXY(53,179);
	$pdf->Cell(43,$th,$row['ec_num'],$border,0,'C');
	$pdf->SetXY(125,179);
	$pdf->Cell(60,$th,$row['ec_relationship'],$border,0,'C');
	$pdf->SetXY(67,200);
	$pdf->Cell(53,$th,$row['care_card'],$border,0,'C');
	$pdf->SetXY(60,207);
	$pdf->Cell(42,$th,$row['doctor'],$border,0,'C');
	$pdf->SetXY(125,207);
	$pdf->Cell(43,$th,$row['doctor_num'],$border,0,'C');
	$pdf->SetXY(90,214.6);
	$pdf->Cell(101,$th,$row['allergy'],$border,0,'C');
	$pdf->addpage();
	//start of page 2
	$pdf->Image('./images/form_p2_v3.6.jpg',0,0,215.9);
	$pdf->SetXY(36,106.5);
	$pdf->Cell(58,$th,$row['fullname'],$border,0,'C');
	$pdf->SetXY(169,208.5);
	$pdf->Cell(21,$th,$row['youthID'],$border,0,'C');
	$pdf->SetXY(123,219);
	$pdf->Cell(67,$th,$row['creation_date'],$border,0,'C');
	$pdf->Output('test.pdf','I');
?>