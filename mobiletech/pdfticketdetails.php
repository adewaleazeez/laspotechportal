<?php

	global $clientids;
	$clientids = trim($_GET['clientid']);
	if($clientids == null) $clientids = "";

	global $locations;
	$locations = trim($_GET['location']);
	if($locations == null) $locations = "";

	global $ticketnos;
	$ticketnos = trim($_GET['ticketno']);
	if($ticketnos == null) $ticketnos = "";

	global $ticket_statuss;
	$ticket_statuss = trim($_GET['ticket_status']);
	if($ticket_statuss == null) $ticket_statuss = "";

	global $ticket_dates;
	$ticket_dates = trim($_GET['ticket_date']);
	if($ticket_dates == null) $ticket_dates = "";

	global $due_dates;
	$due_dates = trim($_GET['due_date']);
	if($due_dates == null) $due_dates = "";

	global $ticket_prioritys;
	$ticket_prioritys = trim($_GET['ticket_priority']);
	if($ticket_prioritys == null) $ticket_prioritys = "";

	global $help_topics;
	$help_topics = trim($_GET['help_topic']);
	if($help_topics == null) $help_topics = "";

	global $ticket_sources;
	$ticket_sources = trim($_GET['ticket_source']);
	if($ticket_sources == null) $ticket_sources = "";

	global $clienttypes;
	$clienttypes = trim($_GET['clienttype']);
	if($clienttypes == null) $clienttypes = "";

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
			$clientids = $GLOBALS['clientids'];
			$locations = $GLOBALS['locations'];
			$ticketnos = $GLOBALS['ticketnos'];
			$ticket_statuss = $GLOBALS['ticket_statuss'];
			$ticket_dates = $GLOBALS['ticket_dates'];
			$due_dates = $GLOBALS['due_dates'];
			$ticket_prioritys = $GLOBALS['ticket_prioritys'];
			$help_topics = $GLOBALS['help_topics'];
			$ticket_sources = $GLOBALS['ticket_sources'];
			$clienttypes = $GLOBALS['clienttypes'];
			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(200,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);
			if($clientids!=null && $clientids!=""){
				$this->Cell(200,7,'CLIENT-ID: '.$clientids,0,0,'L');
				$this->Ln();
			}			
			if($locations!=null && $locations!=""){
				$this->Cell(200,7,'CLIENTS-LOCATION: '.$locations,0,0,'L');
				$this->Ln();
			}
			if($ticketnos!=null && $ticketnos!=""){
				$this->Cell(200,7,'TICKET-NO: '.$ticketnos,0,0,'L');
				$this->Ln();
			}
			if($ticket_statuss!=null && $ticket_statuss!=""){
				$this->Cell(200,7,'TICKET-STATUS: '.$ticket_statuss,0,0,'L');
				$this->Ln();
			}
			if($ticket_dates!=null && $ticket_dates!=""){
				$this->Cell(200,7,'TICKET-DATE: '.substr($ticket_date, 8, 2).'/'.substr($ticket_date, 5, 2).'/'.substr($ticket_date, 0, 4),0,0,'L');
				$this->Ln();
			}			
			if($due_dates!=null && $due_dates!=""){
				$this->Cell(200,7,'DUE-DATE: '.substr($due_dates, 8, 2).'/'.substr($due_dates, 5, 2).'/'.substr($due_dates, 0, 4),0,0,'L');
				$this->Ln();
			}
			if($ticket_prioritys!=null && $ticket_prioritys!=""){
				$this->Cell(200,7,'TICKET-PRIORITY: '.$ticket_prioritys,0,0,'L');
				$this->Ln();
			}
			if($help_topics!=null && $help_topics!=""){
				$this->Cell(200,7,'HELP-TOPIC: '.$help_topics,0,0,'L');
				$this->Ln();
			}			
			if($ticket_sources!=null && $ticket_sources!=""){
				$this->Cell(200,7,'TICKET-SOURCE: '.$ticket_sources,0,0,'L');
				$this->Ln();
			}
			if($clienttypes!=null && $clienttypes!=""){
				$this->Cell(200,7,'CLIENT-TYPE: '.$clienttypes,0,0,'L');
				$this->Ln();
			}
			$this->SetFont('Times','B',12);
			$this->Cell(65,7,'',0,0,'C');
			$this->Cell(45,7,'THE TICKET DETAILS',"B",0,'L');
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

	$query = "SELECT a.*, b.* FROM ticketstable a, clientstable b where a.clientid=b.clientid and a.ticketno<>'' ";
	if($ticketnos!="")
		$query .= " and a.ticketno='{$ticketnos}'";
	if($clientids!="")
		$query .= " and a.clientid='{$clientids}'";
	if($ticket_statuss!="")
		$query .= " and a.ticket_status='{$ticket_statuss}'";
	if($ticket_dates!="")
		$query .= " and a.ticket_date='{$ticket_dates}'";
	if($due_dates!="")
		$query .= " and a.due_date='{$due_dates}'";
	if($ticket_prioritys!="")
		$query .= " and a.ticket_priority='{$ticket_prioritys}'";
	if($help_topics!="")
		$query .= " and a.help_topic='{$help_topics}'";
	if($ticket_sources!="")
		$query .= " and a.ticket_source='{$ticket_sources}'";
	if($locations!="")
		$query .= " and b.location='{$locations}'";
	if($clienttypes!="")
		$query .= " and b.clienttype='{$clienttypes}'";
	$query .= " order by a.ticketno DESC";
	$result = mysql_query($query, $connection);
	require_once 'PEAR/Date/Calc.php';

	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->Cell(50,7,'Client`s Details',1,0,'L');
			$pdf->Ln(8);
			$pdf->Cell(30,7,'Client-Id: ','LT',0,'L');
			$pdf->Cell(65,7,$clientid,'RT',0,'L');
			$pdf->Cell(30,7,'Client-Name: ','LT',0,'L');
			$pdf->Cell(65,7,$clientname,'RT',0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Contact-Address: ','L',0,'L');
			$pdf->Cell(65,7,$contactaddress,'R',0,'L');
			$pdf->Cell(30,7,'Office-Phone: ','L',0,'L');
			$pdf->Cell(65,7,$officephone,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Email-Address: ','L',0,'L');
			$pdf->Cell(65,7,$emailaddress,'R',0,'L');
			$pdf->Cell(30,7,'Mobile-Phone: ','L',0,'L');
			$pdf->Cell(65,7,$mobilephone,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Contact-Person: ','LB',0,'L');
			$pdf->Cell(65,7,$contactperson,'RB',0,'L');
			$pdf->Cell(30,7,'Birth-Date: ','LB ',0,'L');
			$pdf->Cell(65,7,substr($birthdate, 8, 2).'/'.substr($birthdate, 5, 2).'/'.substr($birthdate, 0, 4),'RB',0,'L');
			$pdf->Ln(10);

			$pdf->Cell(50,7,'Ticket`s Details',1,0,'L');
			$pdf->Ln(8);
			$pdf->Cell(30,7,'Ticket-No: ','LT',0,'L');
			$pdf->Cell(65,7,$ticketno,'RT',0,'L');
			$pdf->Cell(30,7,'Date-Created: ','LT',0,'L');
			$pdf->Cell(65,7,substr($ticket_date, 8, 2).'/'.substr($ticket_date, 5, 2).'/'.substr($ticket_date, 0, 4),'RT',0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Ticket-Source: ','L',0,'L');
			$pdf->Cell(65,7,$ticket_source,'R',0,'L');
			$pdf->Cell(30,7,'Help-Topic: ','L',0,'L');
			$pdf->Cell(65,7,$help_topic,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Ticket-Priority: ','L',0,'L');
			$pdf->Cell(65,7,$ticket_priority,'R',0,'L');
			$pdf->Cell(30,7,'Ticket-Status: ','L',0,'L');
			$pdf->Cell(65,7,$ticket_status,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Subject: ','LB',0,'L');
			$pdf->Cell(65,7,substr($ticket_subject,0,40),'RB',0,'L');
			$pdf->Cell(30,7,'Due-Date: ','LB ',0,'L');
			$pdf->Cell(65,7,substr($due_date, 8, 2).'/'.substr($due_date, 5, 2).'/'.substr($due_date, 0, 4),'RB',0,'L');
			$pdf->Ln(10);

			$queryA = "SELECT * FROM ticket_history where ticketno='{$ticketno}'";
			$resultA = mysql_query($queryA, $connection);
			if(mysql_num_rows($resultA) > 0){
				$count=0;
				while ($rowA = mysql_fetch_array($resultA)) {
					extract ($rowA);

					if($count==0){
						$pdf->Cell(50,7,'Ticket`s History',1,0,'L');
						$pdf->Ln(8);
						if($rowA[3]!=null && $rowA[3]!=""){
							$weekday = Date_Calc::getWeekdayAbbrname(substr($usertime, 8, 2),substr($usertime, 5, 2),substr($usertime, 0, 4));
							$monthname = Date_Calc::getMonthAbbrname(substr($usertime, 5, 2),3);
							$getday = substr($usertime, 8, 2);
							$getyear = substr($usertime, 0, 4);
							$assignor = $weekday.", ".$monthname." ".$getday." ".$getyear." ".substr($usertime, 11, 8);
							$assignor .= " - ".$rowA[3]." of ".$rowA[2]." Department";
							$pdf->Cell(190,7,$assignor,1,0,'L');
							$pdf->Ln();
							$str="";
							if($rowA[7]!=null && $rowA[7]!=""){
								$str .="Ticket priority set to ".$rowA[7].", ";
							}
							if($rowA[8]!=null && $rowA[8]!=""){
								$str .="Ticket status set to ".$rowA[8].", ";
							}
							if($rowA[5]!=null && $rowA[5]!=""){
								$str .="Ticket Assigned to ".$rowA[5]." of ".$rowA[4]." Department";
							}
							if($str!=""){
								$pdf->Cell(190,7,$str,1,0,'L');
								$pdf->Ln();
							}
							if($rowA[6]!=null && $rowA[6]!=""){
								if($pdf->GetStringWidth($rowA[6])>120){
									//$pdf->MultiCell(190,7,$rowA[6],1,0,'L');
					$lines = strlen($rowA[6])/120;
					if((strlen($rowA[6]) % 120) > 0) $lines = intval($lines) + 1;
					if(strlen($rowA[6])<=120) $lines = 1;
					$height=7;
					$index=0;
					for(; $lines>1; ){
						$lines--;
						$pdf->Cell(190,$height,substr($rowA[6],$index,120),"LR",2,'L');
						$index += 120;
					}
					$pdf->Cell(190,$height,substr($rowA[6],$index,120),"LBR",0,'L');
									//$pdf->Cell(190,7,$rowA[6],1,0,'L');
								}else{
									$pdf->Cell(190,7,$rowA[6],1,0,'L');
								}
								$pdf->Ln(8);
							}
						}
					}else{
						if($ticket_assignor!=null && $ticket_assignor!=""){
							$weekday = Date_Calc::getWeekdayAbbrname(substr($usertime, 8, 2),substr($usertime, 5, 2),substr($usertime, 0, 4));
							$monthname = Date_Calc::getMonthAbbrname(substr($usertime, 5, 2),3);
							$getday = substr($ticket_date, 8, 2);
							$getyear = substr($ticket_date, 0, 4);
							$assignor = $weekday.", ".$monthname." ".$getday." ".$getyear." ".substr($usertime, 11, 8);
							$assignor .= " - ".$ticket_assignor." of ".$source_department." Department";
							$pdf->Cell(190,7,$assignor,1,0,'L');
							$pdf->Ln();
							$str="";
							if($rowA[7]!=null && $rowA[7]!=""){
								$str .="Ticket priority changed to ".$rowA[7].", ";
							}
							if($rowA[8]!=null && $rowA[8]!=""){
								$str .="Ticket status changed to ".$rowA[8].", ";
							}
							if($rowA[5]!=null && $rowA[5]!=""){
								$str .="Ticket Assigned to ".$rowA[5]." of ".$rowA[4]." Department";
							}
							if($str!=""){
								$pdf->Cell(190,7,$str,1,0,'L');
								$pdf->Ln();
							}
							if($rowA[6]!=null && $rowA[6]!=""){
								if($pdf->GetStringWidth($rowA[6])>120){
									//$pdf->MultiCell(190,7,$rowA[6],1,0,'L');
					$lines = strlen($rowA[6])/120;
					if((strlen($rowA[6]) % 120) > 0) $lines = intval($lines) + 1;
					if(strlen($rowA[6])<=120) $lines = 1;
					$height=7;
					$index=0;
					for(; $lines>1; ){
						$lines--;
						$pdf->Cell(190,$height,substr($rowA[6],$index,120),"LR",2,'L');
						$index += 120;
					}
					$pdf->Cell(190,$height,substr($rowA[6],$index,120),"LBR",0,'L');
									//$pdf->Cell(190,7,$rowA[6],1,0,'L');
								}else{
									$pdf->Cell(190,7,$rowA[6],1,0,'L');
								}
								$pdf->Ln(8);
							}
						}
					}
					$count++;
				}
			}
			//$pdf->Ln(2);
			$param = explode("_~_", $supportdoc);
			for($k=1; $k<count($param); $k++){
				if($param!=null && $param!=""){
					$param2 = explode("~_~", $param[$k]);
					$pdf->AliasNbPages();
					$pdf->AddPage();
					$pdf->Cell(30,7,'Client-Id: ','LT',0,'L');
					$pdf->Cell(65,7,$clientid,'RT',0,'L');
					$pdf->Cell(30,7,'Client-Name: ','LT',0,'L');
					$pdf->Cell(65,7,$clientname,'RT',0,'L');
					$pdf->Ln();
					$pdf->Cell(30,7,'Ticket-No: ','LB',0,'L');
					$pdf->Cell(65,7,$ticketno,'RB',0,'L');
					$pdf->Cell(30,7,'Document-Title: ','LB',0,'L');
					$pdf->Cell(65,7,$param2[1],'RB',0,'L');
					$pdf->Ln(8);
					$pdf->Cell(140,140,$pdf->Image('documents\\'.$param2[0],$pdf->GetX()+5,$pdf->GetY()+5,130,130),1,0,'C');
					//$pdf->Ln(42);
				}
			}
		}
	}

	$pdf->Output();
?>
