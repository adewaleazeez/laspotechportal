<?php

	global $locations;
	$locations = trim($_GET['location']);
	if($locations == null) $locations = "";

	global $clientids;
	$clientids = trim($_GET['clientid']);
	if($clientids == null) $clientids = "";

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
			$locations = $GLOBALS['locations'];
			$clientids = $GLOBALS['clientids'];
			$actives = $GLOBALS['actives'];
			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(300,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);
			if($locations!=null && $locations!=""){
				$this->Cell(300,7,'CLIENTS LOCATION: '.$locations,0,0,'L');
				$this->Ln();
			}
			if($clientids!=null && $clientids!=""){
				$this->Cell(300,7,'CLIENT-ID: '.$clientids,0,0,'L');
				$this->Ln();
			}			
			if($actives=="Yes" || $actives=="No"){
				if($actives=="Yes") $this->Cell(300,7,'CLIENT STATUS: Active',0,0,'L');
				if($actives=="No") $this->Cell(300,7,'CLIENT STATUS: Inactive',0,0,'L');
				$this->Ln();
			}
			$this->SetFont('Times','B',12);
			$this->Cell(130,7,'',0,0,'C');
			$this->Cell(45,7,'THE CLIENT DETAILS',"B",0,'L');
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
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);

	$query = "select * from clientstable where serialno>0 ";
	if($locations != "") $query .= " and location='{$locations}' "; 
	if($clientids != "")	$query .= " and clientid='{$clientids}' ";
	if($actives == "Yes" || $actives == "No")	$query .= " and active='{$actives}' ";
	$query .= " order by clientid, clientname ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			//if($userPicture!=null && $userPicture!=""){
			//	$pdf->Cell(40,40,$pdf->Image('photo\\'.$userPicture,$pdf->GetX()+5,$pdf->GetY()+5,30,30),1,0,'C');
			//}else{
			//	$pdf->Cell(40,40,"",1,0,'C');
			//}
			//$pdf->Ln();
			$pdf->Cell(50,7,'S/No:',1,0,'L');
			$pdf->Cell(230,7,(++$count),1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Client-Id: ',1,0,'L');
			$pdf->Cell(230,7,$clientid,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Client-Name: ',1,0,'L');
			$pdf->Cell(230,7,$clientname,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Client-Type: ',1,0,'L');
			$pdf->Cell(230,7,$clienttype,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Location: ',1,0,'L');
			$pdf->Cell(230,7,$location,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Contact_Address: ',1,0,'L');
			$pdf->Cell(230,7,$contactaddress,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Mobile Phone: ',1,0,'L');
			$pdf->Cell(230,7,$mobilephone,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Email-Address: ',1,0,'L');
			$pdf->Cell(230,7,$emailaddress,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Bandwidth: ',1,0,'L');
			$pdf->Cell(230,7,$bandwidth,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Instalation-Date: ',1,0,'L');
			$pdf->Cell(230,7,substr($instalationdate, 8, 2).'/'.substr($instalationdate, 5, 2).'/'.substr($instalationdate, 0, 4),1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Birth-Date: ',1,0,'L');
			$pdf->Cell(230,7,substr($birthdate, 8, 2).'/'.substr($birthdate, 5, 2).'/'.substr($birthdate, 0, 4),1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Contact-Person: ',1,0,'L');
			$pdf->Cell(230,7,$contactperson,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'CPE: ',1,0,'L');
			$pdf->Cell(230,7,$cpe,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Radio-IP-Address: ',1,0,'L');
			$pdf->Cell(230,7,$radioipaddress,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'IP-Address: ',1,0,'L');
			$pdf->Cell(230,7,$ipaddress,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Base-Station-IP-Address: ',1,0,'L');
			$pdf->Cell(230,7,$basestationipaddress,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Configuration-Status: ',1,0,'L');
			$pdf->Cell(230,7,$configurationstatus,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(50,7,'Client Status: ',1,0,'L');
			if($active=="Yes") $pdf->Cell(230,7,'Active',1,0,'L');
			if($active=="No") $pdf->Cell(230,7,'Inactive',1,0,'L');
			$pdf->AddPage();
		}
	}
	$pdf->Output();
?>
