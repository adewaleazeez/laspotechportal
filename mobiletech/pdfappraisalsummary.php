<?php
	global $staffids;
	$staffids = trim($_GET['staffid']);
	if($staffids == null) $staffids = "";

	global $appraisalstarts;
	$appraisalstarts = trim($_GET['appraisalstart']);
	if($appraisalstarts == null) $appraisalstarts = "";

	global $appraisalends;
	$appraisalends = trim($_GET['appraisalend']);
	if($appraisalends == null) $appraisalends = "";

	global $appraisalstartdates;
	$appraisalstartdates = trim($_GET['appraisalstartdate']);
	if($appraisalstartdates == null) $appraisalstartdates = "";

	global $appraisalenddates;
	$appraisalenddates = trim($_GET['appraisalenddate']);
	if($appraisalenddates == null) $appraisalenddates = "";

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
			$appraisalstarts = $GLOBALS['appraisalstarts'];
			$appraisalends = $GLOBALS['appraisalends'];

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
			if($appraisalstarts!=null && $appraisalstarts!=""){
				$this->Cell(300,7,'APPRAISAL START PERIOD: '.$appraisalstarts,0,0,'L');
				$this->Ln();
			}			
			if($appraisalends!=null && $appraisalends!=""){
				$this->Cell(300,7,'APPRAISAL END PERIOD: '.$appraisalends,0,0,'L');
				$this->Ln();
			}
			$this->SetFont('Times','B',12);
			$this->Cell(130,7,'',0,0,'C');
			$this->Cell(37,7,'THE APPRAISAL LIST',"B",0,'L');
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
			$this->Cell(25,7,'Appraisal Date',1,0,'L');
			$this->Cell(25,7,'Start Period',1,0,'L');
			$this->Cell(25,7,'End Period',1,0,'L');
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

	$query = "select a.*, b.* from appraisaltable a, stafftable b where a.serialno>0 ";
	if($staffids != "")	$query .= " and a.staffid='{$staffids}' ";
	if($appraisalstarts != "") $query .= " and a.appraisalstartdate>='{$appraisalstartdates}' "; 
	if($appraisalends != "") $query .= " and a.appraisalenddate<='{$appraisalenddates}' "; 
	$query .= " order by a.staffid, a.appraisaldate, a.appraisalstartdate ";
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
			$pdf->Cell(25,10,substr($appraisaldate, 8, 2).'/'.substr($appraisaldate, 5, 2).'/'.substr($appraisaldate, 0, 4),1,0,'L');
			$pdf->Cell(25,10,$appraisalstart,1,0,'L');
			$pdf->Cell(25,10,$appraisalend,1,0,'L');
			$pdf->Ln();
		}
	}
	$pdf->Output();
?>
