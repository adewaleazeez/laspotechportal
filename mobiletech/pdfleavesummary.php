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
			$this->Cell(37,7,'THE LEAVE LIST',"B",0,'L');
			$this->Ln();
			$this->Ln(3);

			$this->SetFont('Times','B',10);
			$this->Cell(10,7,'S/No',1,0,'R');
			$this->Cell(25,7,'Staff-ID',1,0,'L');
			$this->Cell(30,7,'Last Name',1,0,'L');
			$this->Cell(30,7,'First Name',1,0,'L');
			$this->Cell(30,7,'Entitlement',1,0,'L');
			$this->Cell(25,7,'Super. Approv.',1,0,'L');
			$this->Cell(25,7,'Admin Approv.',1,0,'L');
			$this->Cell(25,7,'Approve Date',1,0,'L');
			$this->Cell(25,7,'Leave Type ',1,0,'L');
			$this->Cell(25,7,'Start Date',1,0,'L');
			$this->Cell(25,7,'End Date',1,0,'L');
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

	$query = "select a.*, b.* from leavetable a, stafftable b where a.serialno>0 ";
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
			$pdf->Cell(10,10,++$count,1,0,'R');
			$pdf->Cell(25,10,$staffid,1,0,'L');
			$pdf->Cell(30,10,$lastname,1,0,'L');
			$pdf->Cell(30,10,$firstname,1,0,'L');
			$pdf->Cell(30,10,number_format($entitlement,2),1,0,'L');
			$pdf->Cell(25,10,$supervisorapproval,1,0,'L');
			$pdf->Cell(25,10,$adminapproval,1,0,'L');
			$pdf->Cell(25,10,substr($leaveapprovedate, 8, 2).'/'.substr($leaveapprovedate, 5, 2).'/'.substr($leaveapprovedate, 0, 4),1,0,'L');
			$pdf->Cell(25,10,$leavetype,1,0,'L');
			$pdf->Cell(25,10,substr($leavestart, 8, 2).'/'.substr($leavestart, 5, 2).'/'.substr($leavestart, 0, 4),1,0,'L');
			$pdf->Cell(25,10,substr($leaveend, 8, 2).'/'.substr($leaveend, 5, 2).'/'.substr($leaveend, 0, 4),1,0,'L');
			$pdf->Ln();
		}
	}
	$pdf->Output();
?>
