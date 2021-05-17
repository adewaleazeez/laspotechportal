<?php

	global $staffids;
	$staffids = trim($_GET['staffid']);
	if($staffids == null) $staffids = "";

	global $leavetypes;
	$leavetypes = trim($_GET['leavetype']);
	if($leavetypes == null) $leavetypes = "";

	global $leavestarts;
	$leavestarts = trim($_GET['leavestart']);
	if($leavestarts == null) $leavestarts = "";

	global $leaveends;
	$leaveends = trim($_GET['leaveend']);
	if($leaveends == null) $leaveends = "";

	global $supervisorapprovals;
	$supervisorapprovals = trim($_GET['supervisorapproval']);
	if($supervisorapprovals == null) $supervisorapprovals = "";

	global $adminapprovals;
	$adminapprovals = trim($_GET['adminapproval']);
	if($adminapprovals == null) $adminapprovals = "";

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
			$staffids = $GLOBALS['staffids'];
			$leavetypes = $GLOBALS['leavetypes'];
			$leavestarts = $GLOBALS['leavestarts'];
			$leaveends = $GLOBALS['leaveends'];
			$supervisorapprovals = $GLOBALS['supervisorapprovals'];
			$adminapprovals = $GLOBALS['adminapprovals'];

			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(300,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);
			if($staffids!=null && $staffids!=""){
				$this->Cell(300,7,'STAFF ID: '.$staffids,0,0,'L');
				$this->Ln();
			}			
			if($leavetypes!=null && $leavetypes!=""){
				$this->Cell(300,7,'LEAVE TYPE: '.$leavetypes,0,0,'L');
				$this->Ln();
			}			
			if($leavestarts!=null && $leavestarts!=""){
				$this->Cell(300,7,'LEAVE START DATE: '.$leavestarts,0,0,'L');
				$this->Ln();
			}			
			if($leaveends!=null && $leaveends!=""){
				$this->Cell(300,7,'LEAVE END DATE: '.$leaveends,0,0,'L');
				$this->Ln();
			}
			if($supervisorapprovals!=null && $supervisorapprovals!=""){
				$this->Cell(300,7,'SUPERVISOR APPROVAL STATUS: '.$supervisorapprovals,0,0,'L');
				$this->Ln();
			}
			if($adminapprovals!=null && $adminapprovals!=""){
				$this->Cell(300,7,'ADMIN APPROVAL STATUS: '.$adminapprovals,0,0,'L');
				$this->Ln();
			}
			$this->SetFont('Times','B',12);
			$this->Cell(130,7,'',0,0,'C');
			$this->Cell(45,7,'LEAVE DETAILS',"B",0,'L');
			$this->Ln();
			$this->Ln(3);

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
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetFont('Times','B',10);

	$query = "select a.*, b.lastname, b.firstname, b.middlename, b.department, b.jobtitle, b.level, b.birthdate, b.supervisorid as supervisor, b.employmentdate, b.gender, b.staffPicture from leavetable a, stafftable b where a.serialno>0 ";
	if($staffids != "")	$query .= " and a.staffid='{$staffids}' ";
	if($leavetypes != "")	$query .= " and a.leavetype='{$leavetypes}' ";
	if($leavestarts != "") $query .= " and a.leavestart='{$leavestarts}' "; 
	if($leaveends != "") $query .= " and a.leaveend='{$leaveends}' "; 
	if($supervisorapprovals != "") $query .= " and a.supervisorapproval='{$supervisorapprovals}' "; 
	if($adminapprovals != "") $query .= " and a.adminapproval='{$adminapprovals}' "; 
	$query .= " order by a.staffid, a.leavetype, a.leavestart ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if($staffPicture!=null && $staffPicture!=""){
				$pdf->Cell(30,29,$pdf->Image('photo\\'.$staffPicture,$pdf->GetX()+3,$pdf->GetY()+3,23,23),1,0,'C');
			}else{
				$pdf->Cell(30,29,"",1,0,'C');
			}
			$pdf->Ln();
			$pdf->Cell(20,7,'S/No: '.(++$count),1,0,'L');
			$pdf->Cell(50,7,'Satff-ID: '.$staffid,1,0,'L');
			$pdf->Cell(130,7,'Satff Name: '.$lastname.", ".$firstname." ".$middlename,1,0,'L');
			$pdf->Cell(50,7,'Leave Type: '.$leavetype,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(70,7,'Department: '.$department,1,0,'L');
			$pdf->Cell(70,7,'Job Title: '.$jobtitle,1,0,'L');
			$pdf->Cell(60,7,'Staff Level: '.$level,1,0,'L');
			$pdf->Cell(50,7,'Birth Date: '.substr($birthdate, 8, 2).'/'.substr($birthdate, 5, 2).'/'.substr($birthdate, 0, 4),1,0,'L');
			$pdf->Ln();
			$pdf->Cell(160,7,'Supervisor: '.$supervisor,1,0,'L');
			$pdf->Cell(50,7,'Employment Date: '.substr($employmentdate, 8, 2).'/'.substr($employmentdate, 5, 2).'/'.substr($employmentdate, 0, 4),1,0,'L');
			$pdf->Cell(40,7,'Gender: '.$gender,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(135,7,'Approving Supervisor: '.$supervisorid,1,0,'L');
			$pdf->Cell(65,7,'Supervisor Approval Status: '.$supervisorapproval,1,0,'L');
			$pdf->Cell(50,7,'Leave Start Date: '.substr($leavestart, 8, 2).'/'.substr($leavestart, 5, 2).'/'.substr($leavestart, 0, 4),1,0,'L');
			$pdf->Ln();
			$pdf->Cell(135,7,'Approving Admin: '.$adminid,1,0,'L');
			$pdf->Cell(65,7,'Admin Approval Status: '.$adminapproval,1,0,'L');
			$pdf->Cell(50,7,'Leave End Date: '.substr($leaveend, 8, 2).'/'.substr($leaveend, 5, 2).'/'.substr($leaveend, 0, 4),1,0,'L');
			$pdf->Ln();
			$pdf->Cell(65,7,'Leave Entitlement: '.number_format($entitlement,2),1,0,'L');
			$pdf->Cell(65,7,'Leave Application Date: '.substr($leaveapplydate, 8, 2).'/'.substr($leaveapplydate, 5, 2).'/'.substr($leaveapplydate, 0, 4),1,0,'L');
			$pdf->Cell(60,7,'Leave Resumption Date: '.substr($resumptiondate, 8, 2).'/'.substr($resumptiondate, 5, 2).'/'.substr($resumptiondate, 0, 4),1,0,'L');
			$pdf->Cell(60,7,'Leave Approval Date: '.substr($leaveapprovedate, 8, 2).'/'.substr($leaveapprovedate, 5, 2).'/'.substr($leaveapprovedate, 0, 4),1,0,'L');
			$pdf->Ln(10);		
		}
	}
	$pdf->Output();
?>
