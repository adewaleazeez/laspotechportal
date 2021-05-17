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
			$this->Cell(45,7,'APPRAISAL DETAILS',"B",0,'L');
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
	$pdf->AliasNbPages();
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
			if($serialno>0) $pdf->AddPage();
			$col = $pdf->GetX();
			$row = $pdf->GetY();
			if($staffPicture!=null && $staffPicture!=""){
				$pdf->Cell(40,39,$pdf->Image('photo\\'.$staffPicture,$pdf->GetX()+3,$pdf->GetY()+3,33,33),1,0,'C');
			}else{
				$pdf->Cell(40,39,"",1,0,'C');
			}
			//$pdf->Ln();
			//$pdf->SetX($pdf->GetX()+39);
			//$pdf->SetY($row);
			$pdf->Cell(30,7,'S/No: '.(++$count),1,0,'L');
			$pdf->Cell(50,7,'Satff-ID: '.$staffid,1,0,'L');
			$pdf->Cell(120,7,'Satff Name: '.$lastname.", ".$firstname." ".$middlename,1,0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(60,7,'Appraisal Date: '.substr($appraisaldate, 8, 2).'/'.substr($appraisaldate, 5, 2).'/'.substr($appraisaldate, 0, 4),1,0,'L');
			$pdf->Cell(70,7,'Appraisal start Period: '.$appraisalstart,1,0,'L');
			$pdf->Cell(70,7,'Appraisal End Period: '.$appraisalend,1,0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(75,7,'Department: '.$department,1,0,'L');
			$pdf->Cell(75,7,'Job Title: '.$jobtitle,1,0,'L');
			$pdf->Cell(50,7,'Staff Level: '.$level,1,0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(80,7,'Supervisor: '.$supervisorid,1,0,'L');
			$pdf->Cell(50,7,'Employment Date: '.substr($employmentdate, 8, 2).'/'.substr($employmentdate, 5, 2).'/'.substr($employmentdate, 0, 4),1,0,'L');
			$pdf->Cell(30,7,'Gender: '.$gender,1,0,'L');
			$pdf->Cell(40,7,'Birth Date: '.substr($birthdate, 8, 2).'/'.substr($birthdate, 5, 2).'/'.substr($birthdate, 0, 4),1,0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,'Your Understanding of your main duties and responsibilities:  ','LTR',1,'L');$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,$duties,'LBR',0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,'What part of your job do you find most difficult? ','LTR',1,'L');$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,$difficultduties,'LBR',0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,'What part of your job interest you the most? ','LTR',1,'L');$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,$interestingduties,'LBR',0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,'What action could be taken to improve your performance in your present position? ','LTR',1,'L');$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,$performanceimprove,'LBR',0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,'Have you ever been queried or suspended or had any disciplinary action within the last 6mths? If Yes, why?','LTR',1,'L');$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,$queryorsuspension,'LBR',0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,'Have you attended any training in the last 6mths? (Yes/No) If Yes, State: ','LTR',1,'L');$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,$training,'LBR',0,'L');
			$pdf->Ln();$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,'Most successful job accomplishment since last performance period:  ','LTR',1,'L');$pdf->SetX($pdf->GetX()+40);
			$pdf->Cell(200,7,$accomplishments,'LBR',0,'L');
		}
	}
	$pdf->Output();
?>
