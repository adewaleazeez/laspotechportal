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

	global $start_dates;
	$start_dates = trim($_GET['start_date']);
	if($start_dates == null) $start_dates = "";

	global $selectedoptions;
	$selectedoptions = trim($_GET['selectedoption']);
	if($selectedoptions == null) $selectedoptions = "";

	global $end_dates;
	$end_dates = trim($_GET['end_date']);
	if($end_dates == null) $end_dates = "";

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
			$requestedbys = $GLOBALS['requestedbys'];
			$superapprovedbys = $GLOBALS['superapprovedbys'];
			$approvedbys = $GLOBALS['approvedbys'];
			$releasedbys = $GLOBALS['releasedbys'];
			$start_dates = $GLOBALS['start_dates'];
			$end_dates = $GLOBALS['end_dates'];
			$selectedoptions = $GLOBALS['selectedoptions'];

			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(267,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);

			if($departments!=null && $departments!=""){
				$this->Cell(267,7,'DEPARTMENT: '.$departments,0,0,'L');
				$this->Ln();
			}
			if($requestedbys!=null && $requestedbys!=""){
				$this->Cell(267,7,'REQUESTED-BY: '.$requestedbys,0,0,'L');
				$this->Ln();
			}
			if($superapprovedbys!=null && $superapprovedbys!=""){
				$this->Cell(267,7,'SUPERVISOR APPROVAL-BY: '.$superapprovedbys,0,0,'L');
				$this->Ln();
			}
			if($approvedbys!=null && $approvedbys!=""){
				$this->Cell(267,7,'ACCOUNTS APPROVAL-BY: '.$approvedbys,0,0,'L');
				$this->Ln();
			}
			if($releasedbys!=null && $releasedbys!=""){
				$this->Cell(267,7,'RELEASED-BY: '.$releasedbys,0,0,'L');
				$this->Ln();
			}			
			if($selectedoptions!=null && $selectedoptions!=""){
				$this->Cell(267,7,'TRANSACTION-TYPE: '.$selectedoptions,0,0,'L');
				$this->Ln();
			}			
			if($start_dates!=null && $start_dates!=""){
				$this->Cell(267,7,'START-DATE: '.substr($start_dates, 8, 2).'/'.substr($start_dates, 5, 2).'/'.substr($start_dates, 0, 4),0,0,'L');
				$this->Ln();
			}			
			if($end_dates!=null && $end_dates!=""){
				$this->Cell(267,7,'END-DATE: '.substr($end_dates, 8, 2).'/'.substr($end_dates, 5, 2).'/'.substr($end_dates, 0, 4),0,0,'L');
				$this->Ln();
			}

			$this->SetFont('Times','B',12);
			//$this->Cell(70,7,'',0,0,'C');
			$this->Cell(267,7,'THE REQUISITION SUMMARIES',0,0,'C');
			$this->Ln(10);

			$this->Cell(10,5,'','LRT',0,'R');
			$this->Cell(18,5,'','LRT',0,'C');
			//$this->Cell(30,5,'','LRT',0,'L');
			$this->Cell(23,5,'','LRT',0,'C');
			$this->Cell(23,5,'Supervisor','LRT',0,'C');
			$this->Cell(23,5,'Accounts','LRT',0,'C');
			$this->Cell(23,5,'','LRT',0,'C');
			if($selectedoptions=='Requested' || $selectedoptions=='All Transactions') $this->Cell(21,5,'','LRT',0,'R');
			if($selectedoptions=='SupervisorApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Supervisor','LRT',0,'R');
			if($selectedoptions=='SupervisorDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Supervisor','LRT',0,'R');
			if($selectedoptions=='AccountsApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Accounts','LRT',0,'R');
			if($selectedoptions=='AccountsDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Accounts','LRT',0,'R');
			if($selectedoptions=='ReleaseApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Release','LRT',0,'R');
			if($selectedoptions=='ReleaseDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Release','LRT',0,'R');
			//if($selectedoptions=='' || $selectedoptions=='All Transactions') $this->Cell(21,5,'','LRT',0,'R');
			$this->Cell(17,5,'','LRT',0,'C');
			$this->Ln(5);

			$this->Cell(10,5,'','LR',0,'R');
			$this->Cell(18,5,'Request','LR',0,'C');
			//$this->Cell(30,5,'','LR',0,'L');
			$this->Cell(23,5,'Requested','LR',0,'C');
			$this->Cell(23,5,'Approval','LR',0,'C');
			$this->Cell(23,5,'Approval','LR',0,'C');
			$this->Cell(23,5,'Released','LR',0,'C');
			if($selectedoptions=='Requested' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Requested','LR',0,'R');
			if($selectedoptions=='SupervisorApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Approved','LR',0,'R');
			if($selectedoptions=='SupervisorDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Declined','LR',0,'R');
			if($selectedoptions=='AccountsApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Approved','LR',0,'R');
			if($selectedoptions=='AccountsDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Declined','LR',0,'R');
			if($selectedoptions=='ReleaseApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Approved','LR',0,'R');
			if($selectedoptions=='ReleaseDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Declined','LR',0,'R');
			$this->Cell(17,5,'Trans.','LR',0,'C');
			$this->Ln(5);

			$this->Cell(10,5,'S/No','LRB',0,'R');
			$this->Cell(18,5,'Date','LRB',0,'C');
			//$this->Cell(30,5,'Department','LRB',0,'L');
			$this->Cell(23,5,'By','LRB',0,'C');
			$this->Cell(23,5,'By','LRB',0,'C');
			$this->Cell(23,5,'By','LRB',0,'C');
			$this->Cell(23,5,'By','LRB',0,'C');
			if($selectedoptions=='Requested' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Amount','LRB',0,'R');
			if($selectedoptions=='SupervisorApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Amount','LRB',0,'R');
			if($selectedoptions=='SupervisorDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Amount','LRB',0,'R');
			if($selectedoptions=='AccountsApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Amount','LRB',0,'R');
			if($selectedoptions=='AccountsDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Amount','LRB',0,'R');
			if($selectedoptions=='ReleaseApproved' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Amount','LRB',0,'R');
			if($selectedoptions=='ReleaseDeclined' || $selectedoptions=='All Transactions') $this->Cell(21,5,'Amount','LRB',0,'R');
			$this->Cell(17,5,'Status','LRB',0,'C');
			$this->Ln(5);
		}
		// Page footer
		function Footer(){
			$this->SetY(-10);
			$this->SetFont('Times','B',10);
			$this->Cell(0,5,'* Transaction Status Key: R=Requested, SA=SupervisorApproved, SD=SupervisorDeclined, AA=AccountsApproved, AD=AccountsDeclined, RA=ReleaseApproved, RD=ReleaseDeclined',0,0,'C');
			$this->Ln();
			$this->SetFont('Times','B',8.5);
			$this->Cell(0,5,'Powered By: Immaculate High-Tech Systems Ltd.',0,0,'C');
			//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'R');
		}
	}

	include("data.php"); 
	
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);

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
	if($selectedoptions=="Requested" || $selectedoptions=="SupervisorApproved" || $selectedoptions=="SupervisorDeclined" || $selectedoptions=="AccountsApproved" || $selectedoptions=="AccountsDeclined" || $selectedoptions=="ReleaseApproved" || $selectedoptions=="ReleaseDeclined")
		$query .= " and transtatus='{$selectedoptions}' ";
	if($start_dates!="")
		$query .= " and requisitiondate>='{$start_dates}'";
	if($end_dates!="")
		$query .= " and requisitiondate<='{$end_dates}'";
	$query .= " order by requisitiondate DESC, serialno ";
	$result = mysql_query($query, $connection);

	require_once 'PEAR/Date/Calc.php';

	if(mysql_num_rows($result) > 0){
		$counter=0;
		$sumrequested=0.0;
		$sumSupervisorApproved=0.0;
		$sumSupervisorDeclined=0.0;
		$sumAccountsApproved=0.0;
		$sumAccountsDeclined=0.0;
		$sumReleaseApproved=0.0;
		$sumReleaseDeclined=0.0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$pdf->Cell(10,10,++$counter,1,0,'R');
			$pdf->Cell(18,10,substr($requisitiondate, 8, 2).'/'.substr($requisitiondate, 5, 2).'/'.substr($requisitiondate, 0, 4),1,0,'C');
			//$pdf->Cell(30,10,$department,1,0,'L');
			$pdf->Cell(23,10,$requestedby,1,0,'C');
			$pdf->Cell(23,10,$supervisorapproval,1,0,'C');
			$pdf->Cell(23,10,$approvedby,1,0,'C');
			$pdf->Cell(23,10,$releasedby,1,0,'C');
			if($transtatus=="Requested"){
				$sumrequested += $requestedamount;
			}else if($transtatus=="SupervisorApproved"){
				$sumSupervisorApproved += $requestedamount;
			}else if($transtatus=="SupervisorDeclined"){
				$sumSupervisorDeclined += $requestedamount;
			}else if($transtatus=="AccountsApproved"){
				$sumAccountsApproved += $requestedamount;
			}else if($transtatus=="AccountsDeclined"){
				$sumAccountsDeclined += $requestedamount;
			}else if($transtatus=="ReleaseApproved"){
				$sumReleaseApproved += $requestedamount;
			}else if($transtatus=="ReleaseDeclined"){
				$sumReleaseDeclined += $requestedamount;
			}
			if($selectedoptions=='All Transactions'){
				if($transtatus=="Requested"){
					$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
				}else if($transtatus=='SupervisorApproved'){
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
				}else if($transtatus=='SupervisorDeclined'){
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
				}else if($transtatus=='AccountsApproved'){
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
				}else if($transtatus=='AccountsDeclined'){
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
				}else if($transtatus=='ReleaseApproved'){
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
				}else if($transtatus=='ReleaseDeclined'){
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,'',1,0,'R');
					$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
				}
			}else{
				$pdf->Cell(21,10,number_format($requestedamount,2),1,0,'R');
			}
			$tstatus="";
			if($transtatus=="Requested") $tstatus="R";
			if($transtatus=="SupervisorApproved") $tstatus="SA";
			if($transtatus=="SupervisorDeclined") $tstatus="SD";
			if($transtatus=="AccountsApproved") $tstatus="AA";
			if($transtatus=="AccountsDeclined") $tstatus="AD";
			if($transtatus=="ReleaseApproved") $tstatus="RA";
			if($transtatus=="ReleaseDeclined") $tstatus="RD";
			$pdf->Cell(17,10,$tstatus,1,0,'C');
			$pdf->Ln(10);
		}
	}
	$pdf->Cell(10,10,'',0,0,'R');
	$pdf->Cell(18,10,'',0,0,'C');
	//$pdf->Cell(30,10,'',0,0,'L');
	$pdf->Cell(23,10,'',0,0,'L');
	$pdf->Cell(23,10,'',0,0,'L');
	$pdf->Cell(23,10,'',0,0,'L');
	$pdf->Cell(23,10,'Total: ',1,0,'R');
	if($selectedoptions=='Requested' || $selectedoptions=='All Transactions') $pdf->Cell(21,10,number_format($sumrequested,2),1,0,'R');
	if($selectedoptions=='SupervisorApproved' || $selectedoptions=='All Transactions') $pdf->Cell(21,10,number_format($sumSupervisorApproved,2),1,0,'R');
	if($selectedoptions=='SupervisorDeclined' || $selectedoptions=='All Transactions') $pdf->Cell(21,10,number_format($sumSupervisorDeclined,2),1,0,'R');
	if($selectedoptions=='AccountsApproved' || $selectedoptions=='All Transactions') $pdf->Cell(21,10,number_format($sumAccountsApproved,2),1,0,'R');
	if($selectedoptions=='AccountsDeclined' || $selectedoptions=='All Transactions') $pdf->Cell(21,10,number_format($sumAccountsDeclined,2),1,0,'R');
	if($selectedoptions=='ReleaseApproved' || $selectedoptions=='All Transactions') $pdf->Cell(21,10,number_format($sumReleaseApproved,2),1,0,'R');
	if($selectedoptions=='ReleaseDeclined' || $selectedoptions=='All Transactions') $pdf->Cell(21,10,number_format($sumReleaseDeclined,2),1,0,'R');
	$pdf->Cell(17,10,'',0,0,'C');
	$pdf->Ln(10);

	$pdf->Output();
?>
