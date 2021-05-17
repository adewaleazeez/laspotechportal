<?php

	global $locations;
	$locations = trim($_GET['location']);
	if($locations == null) $locations = "";

	global $equipmentcategorys;
	$equipmentcategorys = trim($_GET['equipmentcategory']);
	if($equipmentcategorys == null) $equipmentcategorys = "";

	global $equipmentcodes;
	$equipmentcodes = trim($_GET['equipmentcode']);
	if($equipmentcodes == null) $equipmentcodes = "";

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
			$locations = $GLOBALS['locations'];
			$equipmentcategorys = $GLOBALS['equipmentcategorys'];
			$equipmentcodes = $GLOBALS['equipmentcodes'];
			$start_dates = $GLOBALS['start_dates'];
			$end_dates = $GLOBALS['end_dates'];

			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(200,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);
			if($locations!=null && $locations!=""){
				$this->Cell(200,7,'EQUIPMENT-LOCATION: '.$locations,0,0,'L');
				$this->Ln();
			}
			if($equipmentcategorys!=null && $equipmentcategorys!=""){
				$this->Cell(200,7,'EQUIPMENT-CATEGORY: '.$equipmentcategorys,0,0,'L');
				$this->Ln();
			}
			if($equipmentcodes!=null && $equipmentcodes!=""){
				$this->Cell(200,7,'EQUIPMENT-CODE: '.$equipmentcodes,0,0,'L');
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
			$this->Cell(45,7,'THE STOCK DETAILS',"B",0,'L');
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

	$query = "SELECT a.*, b.* FROM equipmentstock a, equipmentstable b where a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' ";
	if($locations!="")
		$query .= " and a.location='{$locations}'";
	if($equipmentcategorys!="")
		$query .= " and a.equipmentcategory='{$equipmentcategorys}'";
	if($equipmentcodes!="")
		$query .= " and a.equipmentcode='{$equipmentcodes}'";
	if($start_dates!="")
		$query .= " and a.transactiondate>='{$start_dates}'";
	if($end_dates!="")
		$query .= " and a.transactiondate<='{$end_dates}'";
	$query .= " order by a.transactiondate DESC, a.equipmentcode, a.location ";
	$result = mysql_query($query, $connection);

	require_once 'PEAR/Date/Calc.php';

	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			$pdf->AliasNbPages();
			$pdf->AddPage();
			extract ($row);

			$queryClient = "SELECT * FROM clientstable where clientid='{$clientid}' ";
			$resultClient = mysql_query($queryClient, $connection);
			if(mysql_num_rows($resultClient) > 0){
				while ($rowClient = mysql_fetch_array($resultClient)) {
					extract ($rowClient);
					$pdf->Cell(50,7,'Client`s Details',1,0,'L');
					$pdf->Ln(8);
					$pdf->Cell(25,7,'Client-Id: ','LT',0,'L');
					$pdf->Cell(60,7,$equipmentcode,'RT',0,'L');
					$pdf->Cell(25,7,'Client-Name: ','LT',0,'L');
					$pdf->Cell(60,7,$clientname,'RT',0,'L');
					$pdf->Ln();
					$pdf->Cell(25,7,'Contact-Address: ','L',0,'L');
					$pdf->Cell(60,7,$contactaddress,'R',0,'L');
					$pdf->Cell(25,7,'Office-Phone: ','L',0,'L');
					$pdf->Cell(60,7,$officephone,'R',0,'L');
					$pdf->Ln();
					$pdf->Cell(25,7,'Email-Address: ','L',0,'L');
					$pdf->Cell(60,7,$emailaddress,'R',0,'L');
					$pdf->Cell(25,7,'Mobile-Phone: ','L',0,'L');
					$pdf->Cell(60,7,$mobilephone,'R',0,'L');
					$pdf->Ln();
					$pdf->Cell(25,7,'Contact-Person: ','LB',0,'L');
					$pdf->Cell(60,7,$contactperson,'RB',0,'L');
					$pdf->Cell(25,7,'Birth-Date: ','LB ',0,'L');
					$pdf->Cell(60,7,substr($birthdate, 8, 2).'/'.substr($birthdate, 5, 2).'/'.substr($birthdate, 0, 4),'RB',0,'L');
					$pdf->Ln(10);
				}
			}

			$pdf->Cell(50,7,'Equipment`s Details',1,0,'L');
			$pdf->Ln(8);
			$pdf->Cell(40,7,'Equipment-Category: ','LT',0,'L');
			$pdf->Cell(55,7,$equipmentcategory,'RT',0,'L');
			$pdf->Cell(40,7,'Equipment-Code: ','LT',0,'L');
			$pdf->Cell(55,7,$equipmentcode,'RT',0,'L');
			$pdf->Ln();
			$pdf->Cell(40,7,'Equipment-Name: ','LB',0,'L');
			$pdf->Cell(55,7,$equipmentname,'RB',0,'L');
			$pdf->Cell(40,7,'Equipment-Description: ','LB',0,'L');
			$pdf->Cell(55,7,substr($equipmentdescription,0,25),'RB',0,'L');
			$pdf->Ln(10);

			$pdf->Cell(50,7,'Stock`s Details',1,0,'L');
			$pdf->Ln(8);
			$pdf->Cell(40,7,'Transaction-Date: ','LT',0,'L');
			$pdf->Cell(55,7,substr($transactiondate, 8, 2).'/'.substr($transactiondate, 5, 2).'/'.substr($transactiondate, 0, 4),'RT',0,'L');
			$pdf->Cell(40,7,'Replenished-By: ','LT',0,'L');
			$pdf->Cell(55,7,$replenishedby,'RT',0,'L');
			$pdf->Ln();
			$pdf->Cell(40,7,'Requested-By: ','L',0,'L');
			$pdf->Cell(55,7,$requestedby,'R',0,'L');
			$pdf->Cell(40,7,'Approved-By: ','L',0,'L');
			$pdf->Cell(55,7,$approvedby,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(40,7,'Transfered-By: ','L',0,'L');
			$pdf->Cell(55,7,$transferedby,'R',0,'L');
			$pdf->Cell(40,7,'Location: ','L',0,'L');
			$pdf->Cell(55,7,$location,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(40,7,'Quantity-In: ','L',0,'L');
			$pdf->Cell(55,7,$quantityin,'R',0,'L');
			$pdf->Cell(40,7,'Quantity-Out: ','L',0,'L');
			$pdf->Cell(55,7,$quantityout,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(40,7,'Balance: ','L',0,'L');
			$pdf->Cell(55,7,$balance,'R',0,'L');
			$pdf->Cell(40,7,'Narration: ','L',0,'L');
			$pdf->Cell(55,7,$narration,'R',0,'L');
			$pdf->Ln();
			$pdf->Cell(40,7,'Mac-Address: ','LB',0,'L');
			$pdf->Cell(55,7,$macaddress,'RB',0,'L');
			$pdf->Cell(40,7,'Transaction-Status: ','LB',0,'L');
			$pdf->Cell(55,7,$transtatus,'RB',0,'L');
			$pdf->Ln(10);
		}
	}

	$pdf->Output();
?>
