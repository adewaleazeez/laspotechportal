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
			$this->Cell(45,7,'THE STOCK SUMMARIES         ',"B",0,'L');
			$this->Ln();
			$this->Ln(10);

			$this->Cell(10,5,'','LRT',0,'R');
			$this->Cell(25,5,'Transaction','LRT',0,'C');
			$this->Cell(53,5,'Equipment','LRT',0,'L');
			$this->Cell(22,5,'Quantity','LRT',0,'R');
			$this->Cell(22,5,'Quantity','LRT',0,'R');
			$this->Cell(22,5,'','LRT',0,'R');
			$this->Cell(25,5,'Replenished','LRT',0,'L');
			$this->Cell(25,5,'Requested','LRT',0,'L');
			$this->Cell(25,5,'Approved','LRT',0,'L');
			$this->Cell(25,5,'Transfered','LRT',0,'L');
			$this->Cell(25,5,'Transaction','LRT',0,'L');
			$this->Ln(5);
			$this->Cell(10,5,'S/No','LRB',0,'R');
			$this->Cell(25,5,'Date','LRB',0,'C');
			$this->Cell(53,5,'    Name','LRB',0,'L');
			$this->Cell(22,5,'In   ','LRB',0,'R');
			$this->Cell(22,5,'Out   ','LRB',0,'R');
			$this->Cell(22,5,'    Balance','LRB',0,'R');
			$this->Cell(25,5,'    By','LRB',0,'L');
			$this->Cell(25,5,'    By','LRB',0,'L');
			$this->Cell(25,5,'    By','LRB',0,'L');
			$this->Cell(25,5,'    By','LRB',0,'L');
			$this->Cell(25,5,'  Status','LRB',0,'L');
			$this->Ln(5);
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
		$counter=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$pdf->Cell(10,10,++$counter,1,0,'R');
			$pdf->Cell(25,10,substr($transactiondate, 8, 2).'/'.substr($transactiondate, 5, 2).'/'.substr($transactiondate, 0, 4),1,0,'C');
			$pdf->Cell(53,10,$equipmentname,1,0,'L');
			$pdf->Cell(22,10,$quantityin,1,0,'R');
			$pdf->Cell(22,10,$quantityout,1,0,'R');
 			$pdf->Cell(22,10,$balance,1,0,'R');
			$pdf->Cell(25,10,$replenishedby,1,0,'L');
			$pdf->Cell(25,10,$requestedby,1,0,'L');
			$pdf->Cell(25,10,$approvedby,1,0,'L');
			$pdf->Cell(25,10,$transferedby,1,0,'L');
			$pdf->Cell(25,10,$transtatus,1,0,'L');
			$pdf->Ln(10);
		}
	}

	$pdf->Output();
?>
