<?php

	global $departments;
	$departments = trim($_GET['department']);
	if($departments == null) $departments = "";

	global $requestedbys;
	$requestedbys = trim($_GET['requestedby']);
	if($requestedbys == null) $requestedbys = "";

	global $superapprovedbys;
	$superapprovedbys = trim($_GET['superapprovedby']);
	if($superapprovedbys == null) $superapprovedbys = "";

	global $approvedbys;
	$approvedbys = trim($_GET['approvedby']);
	if($approvedbys == null) $approvedbys = "";

	global $releasedbys;
	$releasedbys = trim($_GET['releasedby']);
	if($releasedbys == null) $releasedbys = "";

	global $selectedoptions;
	$selectedoptions = trim($_GET['selectedoption']);
	if($selectedoptions == null) $selectedoptions = "";

	global $start_dates;
	$start_dates = trim($_GET['start_date']);
	if($start_dates == null) $start_dates = "";

	global $end_dates;
	$end_dates = trim($_GET['end_date']);
	if($end_dates == null) $end_dates = "";

	require('fpdf.php');

	class PDF extends FPDF{
		var $B;
		var $I;
		var $U;
		var $HREF;

		function PDF($orientation='P', $unit='mm', $size='A4'){
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
			$requestedbys = $GLOBALS['requestedbys'];
			$superapprovedbys = $GLOBALS['superapprovedbys'];
			$approvedbys = $GLOBALS['approvedbys'];
			$releasedbys = $GLOBALS['releasedbys'];
			$start_dates = $GLOBALS['start_dates'];
			$end_dates = $GLOBALS['end_dates'];

			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(200,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);

			if($departments!=null && $departments!=""){
				$this->Cell(200,7,'DEPARTMENT: '.$departments,0,0,'L');
				$this->Ln();
			}
			if($requestedbys!=null && $requestedbys!=""){
				$this->Cell(200,7,'REQUESTED-BY: '.$requestedbys,0,0,'L');
				$this->Ln();
			}
			if($superapprovedbys!=null && $superapprovedbys!=""){
				$this->Cell(200,7,'SUPERVISOR APPROVAL-BY: '.$superapprovedbys,0,0,'L');
				$this->Ln();
			}
			if($approvedbys!=null && $approvedbys!=""){
				$this->Cell(200,7,'ACCOUNTS APPROVAL-BY: '.$approvedbys,0,0,'L');
				$this->Ln();
			}
			if($releasedbys!=null && $releasedbys!=""){
				$this->Cell(200,7,'RELEASED-BY: '.$releasedbys,0,0,'L');
				$this->Ln();
			}			
			if($selectedoptions!=null && $selectedoptions!=""){
				$this->Cell(200,7,'TRANSACTION-TYPE: '.$selectedoptions,0,0,'L');
				$this->Ln();
			}			
			if($start_dates!=null && $start_dates!=""){
				$this->Cell(200,7,'START-DATE: '.substr($start_dates, 8, 2).'/'.substr($start_dates, 5, 2).'/'.substr($start_dates, 0, 4),0,0,'L');
				$this->Ln();
			}			
			if($end_dates!=null && $end_dates!=""){
				$this->Cell(200,7,'END-DATE: '.substr($end_dates, 8, 2).'/'.substr($end_dates, 5, 2).'/'.substr($end_dates, 0, 4),0,0,'L');
				$this->Ln();
			}

			$this->SetFont('Times','B',12);
			$this->Cell(70,7,'',0,0,'C');
			$this->Cell(45,7,'THE REQUISITION DETAILS',"B",0,'L');
			$this->Ln();
			$this->Ln(10);

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
	$pdf->SetFont('Times','B',10);
	$pdf->AliasNbPages();
	$pdf->AddPage();

	$query = "SELECT * FROM requisitiontable where requestedby<>'' ";
	if($departments!="")
		$query .= " and department='{$departments}'";
	if($requestedbys!="")
		$query .= " and requestedby='{$requestedbys}'";
	if($superapprovedbys!="")
		$query .= " and supervisorapproval='{$superapprovedbys}'";
	if($approvedbys!="")
		$query .= " and approvedby='{$approvedbys}'";
	if($releasedbys!="")
		$query .= " and releasedby='{$releasedbys}'";
	if($selectedoptions=="Requested" || $selectedoptions=="Approved" || $selectedoptions=="Released")
		$query .= " and transtatus='{$selectedoptions}' ";
	if($start_dates!="")
		$query .= " and requisitiondate>='{$start_dates}'";
	if($end_dates!="")
		$query .= " and requisitiondate<='{$end_dates}'";
	$query .= " order by requisitiondate DESC, serialno ";
	$result = mysql_query($query, $connection);

	require_once 'PEAR/Date/Calc.php';

	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$pdf->Cell(50,7,'Requisition Details',1,0,'L');
			$pdf->Ln(8);
			$pdf->Cell(95,7,'Requisitiondate-Date: '.substr($requisitiondate, 8, 2).'/'.substr($requisitiondate, 5, 2).'/'.substr($requisitiondate, 0, 4),1,0,'L');
			$pdf->Cell(95,7,'Department: '.$department,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(95,7,'Requested-By: '.$requestedby,1,0,'L');
			$pdf->Cell(95,7,'Supervisor Approval-By: '.$supervisorapproval,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(95,7,'Accounts Approval-By: '.$approvedby,1,0,'L');
			$pdf->Cell(95,7,'Released-By: '.$releasedby,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(95,7,'Amount-Requested: '.$requestedamount,1,0,'L');
			$pdf->Cell(95,7,'Purpose: '.$purpose,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(95,7,'Transaction-Status: '.$transtatus,1,0,'L');
			$pdf->Cell(95,7,'','RB',0,'L');
			$pdf->Ln(15);
		}
	}

	$pdf->Output();
?>
