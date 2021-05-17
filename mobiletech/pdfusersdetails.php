<?php

	global $locations;
	$locations = trim($_GET['location']);
	if($locations == null) $locations = "";

	global $departments;
	$departments = trim($_GET['department']);
	if($departments == null) $departments = "";

	global $staffpositions;
	$staffpositions = trim($_GET['staffposition']);
	if($staffpositions == null) $staffpositions = "";

	global $usernames;
	$usernames = trim($_GET['username']);
	if($usernames == null) $usernames = "";

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
			$departments = $GLOBALS['departments'];
			$staffpositions = $GLOBALS['staffpositions'];
			$usernames = $GLOBALS['usernames'];
			$actives = $GLOBALS['actives'];
			$this->Image('images\Company_Logo.jpg',10,10,35,7);
			$this->SetFont('Times','B',20);
			$this->Ln(3);
			$this->Cell(300,7,'KKON Technologies Limited.',0,0,'C');
			$this->Ln(14);
			$this->SetFont('Times','B',10);
			if($locations!=null && $locations!=""){
				$this->Cell(300,7,'STAFF LOCATION: '.$locations,0,0,'L');
				$this->Ln();
			}
			if($departments!=null && $departments!=""){
				$this->Cell(300,7,'DEPARTMENT: '.$departments,0,0,'L');
				$this->Ln();
			}			
			if($staffpositions!=null && $staffpositions!=""){
				$this->Cell(300,7,'DESIGNATION: '.$staffpositions,0,0,'L');
				$this->Ln();
			}
			if($usernames!=null && $usernames!=""){
				$this->Cell(300,7,'USER-NAME: '.$usernames,0,0,'L');
				$this->Ln();
			}			
			if($actives=="Yes" || $actives=="No"){
				if($actives=="Yes") $this->Cell(300,7,'STAFF STATUS: Active',0,0,'L');
				if($actives=="No") $this->Cell(300,7,'STAFF STATUS: Inactive',0,0,'L');
				$this->Ln();
			}
			$this->SetFont('Times','B',12);
			$this->Cell(130,7,'',0,0,'C');
			$this->Cell(45,7,'THE USERS DETAILS',"B",0,'L');
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
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);

	$query = "select * from users where serialno>0 ";
	if($locations != "") $query .= " and location='{$locations}' "; 
	if($departments != "") $query .= " and department='{$departments}' "; 
	if($staffpositions != "")	$query .= " and staffPosition='{$staffpositions}' ";
	if($usernames != "")	$query .= " and username='{$usernames}' ";
	if($actives == "Yes" || $actives == "No")	$query .= " and active='{$actives}' ";
	$query .= " order by userName, lastName, firstName ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if($userPicture!=null && $userPicture!=""){
				$pdf->Cell(40,40,$pdf->Image('photo\\'.$userPicture,$pdf->GetX()+5,$pdf->GetY()+5,30,30),1,0,'C');
			}else{
				$pdf->Cell(40,40,"",1,0,'C');
			}
			$pdf->Ln();
			$pdf->Cell(30,7,'S/No:',1,0,'L');
			$pdf->Cell(80,7,(++$count),1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Username: ',1,0,'L');
			$pdf->Cell(80,7,$userName,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Lastname: ',1,0,'L');
			$pdf->Cell(80,7,$lastName,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Firstname: ',1,0,'L');
			$pdf->Cell(80,7,$firstName,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'User Email: ',1,0,'L');
			$pdf->Cell(80,7,$userEmail,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Mobile Phone: ',1,0,'L');
			$pdf->Cell(80,7,$mobilephone,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Office Phone: ',1,0,'L');
			$pdf->Cell(80,7,$officephone,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Department: ',1,0,'L');
			$pdf->Cell(80,7,$department,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Location: ',1,0,'L');
			$pdf->Cell(80,7,$location,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Designation: ',1,0,'L');
			$pdf->Cell(80,7,$staffPosition,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Home Address: ',1,0,'L');
			$pdf->Cell(80,7,$homeaddress,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Group Email: ',1,0,'L');
			$pdf->Cell(80,7,$groupEmail,1,0,'L');
			$pdf->Ln();
			$pdf->Cell(30,7,'Staff Status: ',1,0,'L');
			if($active=="Yes") $pdf->Cell(80,7,'Active',1,0,'L');
			if($active=="No") $pdf->Cell(80,7,'Inactive',1,0,'L');
			$pdf->AddPage();
		}
	}
	$pdf->Output();
?>
