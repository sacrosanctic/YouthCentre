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
				UPPER(DATE_FORMAT(birthdate,'%d/%b/%Y')) AS birthdate,
				CONCAT(f_name , ' ' , l_name) AS fullname
			FROM 
				tbl_youth 
			WHERE 
				youthID = $_GET[youthid]";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
	}
	
	//Label Width
	$lw = 40;
	//Line Height
	$lh = 5;
	
	$pdf = new FPDF('P','mm','Letter');
	$pdf->AddPage();
	//start of title
	$pdf->SetTitle('Registration Form - Youth');
	$pdf->SetCreator('Youth Centre Database');
	$pdf->SetAuthor('Collingwood Youth Services');
	$pdf->Image('./images/test.jpg',23,null,164);
	$pdf->SetFont('Arial','B',24);
	$pdf->Cell(0,5,'CNH Youth Drop-In',0,1,'C');
	$pdf->Ln(2);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(0,5,'Registration Form',0,1,'C');
	$pdf->Ln(10);
	//end of title
	//start of info
	$topy = 30;
	$pdf->SetLeftMargin(20.00125);
	$pdf->SetXY(20.00125,$topy);
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
	$pdf->SetLeftMargin(20.00125+100);
	$pdf->SetXY(20.00125+100,$topy);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(0,5,'Emergency Contact');
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(10);
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
	$pdf->Cell($lw,5,'Medical Information');
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
	$pdf->Ln();
	$pdf->Cell($lw,5,'Medical Concerns:');
	$pdf->MultiCell(0,5,$row['allergy'],0,'L');
	//end of info
	$pdf->SetLeftMargin(10.00125);
	$pdf->SetXY(10.00125,110.00125);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell($lw,5,'Parent/Guardian Agreement',0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(5);
	$pdf->write(5,'I,______________________________, the parent/guardian, give permission for my son/daughter, ______________________________, to participate in various CNH Youth Drop-In and Recreational Programs. I understand that there exists an element of person injury in attending these programs. I willingly assume these risk and waive Collingwood Neighbourhood House of any and all liability in regards to any resulting injury(s) as a condition of my child\'s participation. I am aware that my child may leave the premises as they choose and that Youth will only be supervised while in the building. I am also aware that my child may, at any time, be asked to leave the premise in the event of serious misconduct. I understand that pictures may be taken of my child while participating in programs and allow Collingwood Neighbourhood House to use these pictures as both promotional material and for identification purposes.');
	$pdf->Ln();
	$pdf->Cell(0,5,'Parent/Guardian Signature:______________________________');
	$pdf->Cell(0,5,'Date:______________________________',0,1,'R');
	$pdf->Ln();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell($lw,5,'Youth Agreement',0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(5);
	$pdf->write(5,'!,______________________________, understand that while participating in CNH Youth Programs I must follow the following rules: 1) Respec for Staff, Volunteers and Other Youth; 2) Respect for the Building and Equipment; 3) No Swearing, Fighting, Bullying or Intimidation; 4) Clean Up After Yourself; 5) Absolutely NO Alcohol, Drugs or Possession of Illegal or sexually explicit Materials. I also understand that any violation of these rules may result in me being sent home and further violations may mean that I no longer can attend any of the youth programs at CNH. (Youth are always welcome to book an appointment with staff to discuss any issues outside of Youth Centre hours.');
	$pdf->Ln();
	$pdf->Cell(0,5,'Youth Signature:______________________________');
	$pdf->Cell(0,5,'Date:______________________________',0,1,'R');
	$pdf->Ln();
	$pdf->SetXY(10.00125,220.00125);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(0,5,'For Office Use Only',0,1,'C');
	$pdf->SetFont('Arial','',12);
	$pdf->Ln(2);
	$pdf->Rect(10,218,195,42);
	$lw2 = 80;
	$linelength = 6.5;
	$pdf->Cell(50,5,'Membership Card:');
	$pdf->Cell(30,5,'_____');
	$pdf->Cell(35,5,'Registration Date:');
	$pdf->Cell(0,5,'_________________________');
	$pdf->Ln($linelength);
	$pdf->Cell(50,5,'Annual Fee:');
	$pdf->Cell(30,5,'_____');
	$pdf->Cell(35,5,'Collected by:');
	$pdf->Cell(0,5,'_________________________');
	$pdf->Ln($linelength);
	$pdf->Cell(50,5,'Form Completion:');
	$pdf->Cell(30,5,'_____');
	$pdf->Cell(35,5,'Phone Verification:');
	$pdf->Cell(0,5,'_________________________');
	$pdf->Ln($linelength);
	$pdf->Cell(26,5,'Comments:');
	$pdf->Cell(0,5,'_______________________________________________________________');
	$pdf->Ln($linelength);
	$pdf->Cell(50,5,'Member ID:');
	$pdf->Cell(30,5,'_____');
	$pdf->Cell(35,5,'Database Date:');
	$pdf->Cell($lw2,5,'_________________________');
	$pdf->Output('test.pdf','I');
?>