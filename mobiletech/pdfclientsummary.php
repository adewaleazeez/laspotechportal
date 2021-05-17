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
				$this->Cell(300,7,'CLIENT LOCATION: '.$locations,0,0,'L');
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
			$this->Cell(37,7,'THE CLIENT LIST',"B",0,'L');
			$this->Ln();
			$this->Ln(3);

			$this->SetFont('Times','B',10);
			$this->Cell(10,7,'S/No',1,0,'R');
			$this->Cell(18,7,'Client-Id',1,0,'L');
			$this->Cell(41,7,'Client-Name',1,0,'L');
			$this->Cell(23,7,'Client-Type',1,0,'L');
			$this->Cell(58,7,'Email-Address',1,0,'L');
			$this->Cell(30,7,'Office-Phone',1,0,'L');
			$this->Cell(30,7,'Mobile-Phone',1,0,'L');
			$this->Cell(30,7,'Location',1,0,'L');
			$this->Cell(20,7,'Bandwidth',1,0,'L');
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
			$pdf->Cell(10,10,++$count,1,0,'R');
			$pdf->Cell(18,10,$clientid,1,0,'L');
			$pdf->Cell(41,10,$clientname,1,0,'L');
			$pdf->Cell(23,10,$clienttype,1,0,'L');
			$pdf->Cell(58,10,$emailaddress,1,0,'L');
			$pdf->Cell(30,10,$officephone,1,0,'L');
			$pdf->Cell(30,10,$mobilephone,1,0,'L');
			$pdf->Cell(30,10,$location,1,0,'L');
			$pdf->Cell(20,10,$bandwidth,1,0,'L');
			if($active=="Yes") $pdf->Cell(15,10,'Active',1,0,'L');
			if($active=="No") $pdf->Cell(15,10,'Inactive',1,0,'L');
			$pdf->Ln();
		}
	}
	$pdf->Output();
?>
