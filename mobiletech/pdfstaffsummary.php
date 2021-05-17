<?php
	global $departments;
	$departments = trim($_GET['department']);
	if($departments == null) $departments = "";

	global $levels;
	$levels = trim($_GET['level']);
	if($levels == null) $levels = "";

	global $jobtitles;
	$jobtitles = trim($_GET['jobtitle']);
	if($jobtitles == null) $jobtitles = "";

	global $userids;
	$userids = trim($_GET['userid']);
	if($userids == null) $userids = "";

	global $supervisors;
	$supervisors = trim($_GET['supervisor']);
	if($supervisors == null) $supervisors = "";

	global $birthdates;
	$birthdates = trim($_GET['birthdate']);
	if($birthdates == null) $birthdates = "";

	global $employmentdates;
	$employmentdates = trim($_GET['employmentdate']);
	if($employmentdates == null) $employmentdates = "";

	global $genders;
	$genders = trim($_GET['gender']);
	if($genders == null) $genders = "";

	global $maritalstatuss;
	$maritalstatuss = trim($_GET['maritalstatus']);
	if($maritalstatuss == null) $maritalstatuss = "";

	global $actives;
	$actives = trim($_GET['active']);
	if($actives == null) $actives = "";

	require('fpdf.php');

	class PDF extends FPDF{
		var $B;
		var $I;
		var $U;
		var $HREF;

		function PDF($orientation='L', $unit='mm', $size='A4'){
			// Call parent constructor
			$this->FPDF($orientation,$unit,$size);
			// Initialization
			$this->B = 0;
			$this->I = 0;
			$this->U = 0;
			$this->HREF = '';
		}
		// Page header
		function Header(){
			$departments = $GLOBALS['departments'];
			$levels = $GLOBALS['levels'];
			$jobtitles = $GLOBALS['jobtitles'];
			$userids = $GLOBALS['userids'];
			$supervisors = $GLOBALS['supervisors'];
			$birthdates = $GLOBALS['birthdates'];
			$employmentdates = $GLOBALS['employmentdates'];
			$genders = $GLOBALS['genders'];
			$maritalstatuss = $GLOBALS['maritalstatuss'];
			$actives = $GLOBALS['actives'];

			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(300,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);
			if($departments!=null && $departments!=""){
				$this->Cell(300,7,'DEPARTMENT: '.$departments,0,0,'L');
				$this->Ln();
			}			
			if($levels!=null && $levels!=""){
				$this->Cell(300,7,'STAFF LEVEL: '.$levels,0,0,'L');
				$this->Ln();
			}
			if($jobtitles!=null && $jobtitles!=""){
				$this->Cell(300,7,'JOB TITLE: '.$jobtitles,0,0,'L');
				$this->Ln();
			}
			if($userids!=null && $userids!=""){
				$this->Cell(300,7,'STAFF-ID: '.$userids,0,0,'L');
				$this->Ln();
			}			
			if($supervisors!=null && $supervisors!=""){
				$this->Cell(300,7,'SUPERVISOR: '.$supervisors,0,0,'L');
				$this->Ln();
			}			
			if($birthdates!=null && $birthdates!=""){
				$this->Cell(300,7,'BIRTH-DATE: '.$birthdates,0,0,'L');
				$this->Ln();
			}			
			if($employmentdates!=null && $employmentdates!=""){
				$this->Cell(300,7,'EMPLOYMENY-DATE: '.$employmentdates,0,0,'L');
				$this->Ln();
			}			
			if($genders!=null && $genders!=""){
				$this->Cell(300,7,'GENDER: '.$genders,0,0,'L');
				$this->Ln();
			}			
			if($maritalstatuss!=null && $maritalstatuss!=""){
				$this->Cell(300,7,'MARITAL-STATUS: '.$maritalstatuss,0,0,'L');
				$this->Ln();
			}			
			if($actives=="Yes" || $actives=="No"){
				if($actives=="Yes") $this->Cell(300,7,'STAFF STATUS: Active',0,0,'L');
				if($actives=="No") $this->Cell(300,7,'STAFF STATUS: Inactive',0,0,'L');
				$this->Ln();
			}
			$this->SetFont('Times','B',12);
			$this->Cell(130,7,'',0,0,'C');
			$this->Cell(37,7,'THE STAFF LIST',"B",0,'L');
			$this->Ln();
			$this->Ln(3);

			$this->SetFont('Times','B',10);
			$this->Cell(10,7,'S/No',1,0,'R');
			$this->Cell(25,7,'Staff-ID',1,0,'L');
			$this->Cell(25,7,'Last Name',1,0,'L');
			$this->Cell(25,7,'First Name',1,0,'L');
			$this->Cell(25,7,'Middle Name',1,0,'L');
			$this->Cell(25,7,'Employ Date',1,0,'L');
			$this->Cell(35,7,'Department',1,0,'L');
			$this->Cell(30,7,'Staff Level',1,0,'L');
			$this->Cell(40,7,'Job Title',1,0,'L');
			$this->Cell(20,7,'Picture',1,0,'L');
			$this->Cell(15,7,'Status',1,0,'L');
			$this->Ln();
		}

		// Page footer
		function Footer(){
			$this->SetY(-10);
			$this->SetFont('Times','B',7.5);
			//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			$this->Cell(0,5,'Powered By: Immaculate High-Tech Systems Ltd.',0,0,'C');
		}
	}

	include("data.php"); 
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);

	$query = "select * from stafftable where serialno>0 ";
	if($departments != "") $query .= " and department='{$departments}' "; 
	if($levels != "") $query .= " and level='{$levels}' "; 
	if($jobtitles != "")	$query .= " and jobtitle='{$jobtitles}' ";
	if($userids != "")	$query .= " and staffid='{$userids}' ";
	if($supervisors != "")	$query .= " and supervisorid='{$supervisors}' ";
	if($birthdates != "")	$query .= " and birthdate='{$birthdates}' ";
	if($employmentdates != "")	$query .= " and employmentdate='{$employmentdates}' ";
	if($genders != "")	$query .= " and gender='{$genders}' ";
	if($maritalstatuss != "")	$query .= " and maritalstatus='{$maritalstatuss}' ";
	if($actives == "Yes" || $actives == "No")	$query .= " and active='{$actives}' ";
	$query .= " order by staffid, lastname, firstname ";

//echo $query;
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$pdf->Cell(10,10,++$count,1,0,'R');
			$pdf->Cell(25,10,$staffid,1,0,'L');
			$pdf->Cell(25,10,$lastname,1,0,'L');
			$pdf->Cell(25,10,$firstname,1,0,'L');
			$pdf->Cell(25,10,$middlename,1,0,'L');
			$pdf->Cell(25,10,substr($employmentdate, 8, 2).'/'.substr($employmentdate, 5, 2).'/'.substr($employmentdate, 0, 4),1,0,'L');
			$pdf->Cell(35,10,$department,1,0,'L');
			$pdf->Cell(30,10,$level,1,0,'L');
			$pdf->Cell(40,10,$jobtitle,1,0,'L');
			if($staffPicture!=null && $staffPicture!=""){
				$pdf->Cell(20,10,$pdf->Image('photo\\'.$staffPicture,$pdf->GetX()+5,$pdf->GetY(),10,10),1,0,'L');
			}else{
				$pdf->Cell(20,10,"",1,0,'L');
			}
			if($active=="Yes") $pdf->Cell(15,10,'Active',1,0,'L');
			if($active=="No") $pdf->Cell(15,10,'Inactive',1,0,'L');
			$pdf->Ln();
		}
	}
	$pdf->Output();
?>
