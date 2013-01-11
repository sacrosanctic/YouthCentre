<?php
	require_once("./include/session.php");
	require_once("./include/function.php");
	check_permission("MEM_PRINT");

	if(!$_GET)
	{
		echo "No ID selected.";
		exit;
	}

	$sql = "
		SELECT
			*,
			UPPER(DATE_FORMAT(birthdate,'%d/%b/%Y')) AS birthdate,
			CONCAT(f_name , ' ' , l_name) AS fullname
		FROM 
			tbl_youth 
		WHERE 
			youthID = $_GET[youthid]";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	require_once("./include/fpdf/fpdf.php");
	
	//Label Width
	$lw = 40;
	//Line Height
	$lh = 5;
	
	$pdf = new FPDF('P','mm','Letter');
	$pdf->AddPage();
	$pdf->SetTitle('Registration Form - Youth');
	$pdf->SetCreator('Youth Centre Database');
	$pdf->SetAuthor('Collingwood Youth Services');
	$pdf->SetFont('Arial','B',24);
	$pdf->Cell(0,5,'CNH Youth Drop-In',0,1,'C');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(0,5,'Registration Form',0,1,'C');
	$pdf->Ln(10);
	//echo $pdf->GetX() . ' ' . $pdf->GetY();
	$pdf->Cell(0,5,'Personal Information');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell($lw,5,'Name:');
	$pdf->Cell($lw,5,$row['fullname']);
	$pdf->Ln($lh);
	$pdf->Cell($lw,5,'Gender:');
	$pdf->Cell($lw,5,$row['gender']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Date of Birth:');
	$pdf->Cell($lw,5,$row['birthdate']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Address:');
	$pdf->Cell($lw,5,$row['address']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'City:');
	$pdf->Cell($lw,5,$row['city']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Postal Code:');
	$pdf->Cell($lw,5,$row['postal_code']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Home Phone:');
	$pdf->Cell($lw,5,$row['home']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Applicant\'s Cell Phone:');
	$pdf->Cell($lw,5,$row['cell']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'E-mail:');
	$pdf->Cell($lw,5,$row['email']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'School Attending:');
	$pdf->Cell($lw,5,$row['school']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Grade:');
	$pdf->Cell($lw,5,$row['grade']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Parent/Guardian name:');
	$pdf->Cell($lw,5,$row['parent']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Mobile/Work:');
	$pdf->Cell($lw,5,$row['parent_num']);
	$pdf->Ln(10);
	$pdf->SetLeftMargin(10.00125+100);
	$pdf->SetX(10.00125+100);
	$pdf->SetY(40.00125);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell($lw,5,'Emergency Contact',0,1,'L');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell($lw,5,'Name (FIRST, LAST):');
	$pdf->Cell($lw,5,$row['ec_name']);
	$pdf->Ln($lh);
	$pdf->Cell($lw,5,'Phone Number:');
	$pdf->Cell($lw,5,$row['ec_num']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Relationship:');
	$pdf->Cell($lw,5,$row['ec_relationship']);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell($lw,5,'Medical Information',0,1,'L');
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell($lw,5,'Care Card Number:');
	$pdf->Cell($lw,5,$row['care_card']);
	$pdf->Ln($lh);
	$pdf->Cell($lw,5,'Doctor\'s Name:');
	$pdf->Cell($lw,5,$row['doctor']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Phone Number:');
	$pdf->Cell($lw,5,$row['doctor_num']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Allergies and');
	$pdf->Cell($lw,5,$row['allergy']);
	$pdf->Ln();
	$pdf->Cell($lw,5,'Medical Concerns:');
	$pdf->Output('test.pdf','I');
?>