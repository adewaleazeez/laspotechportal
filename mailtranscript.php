<?php

	global $facultycodes;
	$facultycodes = trim($_GET['facultycode']);
	if($facultycodes == null) $facultycodes = "";

	global $departmentcodes;
	$departmentcodes = trim($_GET['departmentcode']);
	if($departmentcodes == null) $departmentcodes = "";

	global $programmecodes;
	$programmecodes = trim($_GET['programmecode']);
	if($programmecodes == null) $programmecodes = "";

	global $studentlevels;
	$studentlevels = trim($_GET['studentlevel']);
	if($studentlevels == null) $studentlevels = "";

	global $sessionss;
	$sessionss = trim($_GET['sessions']);
	if($sessionss == null) $sessionss = "";

	global $semesters;
	$semesters = trim($_GET['semester']);
	if($semesters == null) $semesters = "";

	$matricno = trim($_GET['matricno']);
	if($matricno == null) $matricno = "";

	global $finalyear;
	$finalyear = trim($_GET['finalyear']);
	if($finalyear == null) $finalyear = "";

	global $awardate;
	$awardate = trim($_GET['awardate']);
	if($awardate == null) $awardate = "";

	include("data.php");

	function str_in_str($str,$token){
		$retunrtype=false;
		for($k=0; $k<=(strlen($str)-strlen($token)); $k++){
			if(substr($str, $k, strlen($token))==$token){
				$retunrtype=true;
				break;
			}
		}
		return $retunrtype;
	}

	function getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$matno}' order by right(coursecode,3) desc, left(coursecode,3)";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' ";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0)	$tnup += $row2[1];
				}
			}
		}
		if($tnu>0) $gpa += number_format(($tcp/$tnu),2);
		return $tcp ."][". $tnu ."][". $gpa ."][". $tnup;
	}

	function getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and ((sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$matno}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$matno}' and studentlevel<= '{$studentlevels}') order by right(coursecode,3) desc, left(coursecode,3) ";
		$programmecodes = $GLOBALS['programmecodes'];
		include("data.php"); 
//echo $query."<br><br>";
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' and studentlevel='{$row[8]}' "; 
//echo $query2."<br><br>";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0)	$tnup += $row2[1];
//if($row[7]>0) echo $row2[1]."   $row[3]<br><br>";
				}
			}
		}
		if($tnu>0) $gpa += number_format(($tcp/$tnu),2);
//echo $tcp ."][". $tnu ."][". $gpa ."][". $tnup."<br><br>";
		return $tcp ."][". $tnu ."][". $gpa ."][". $tnup;
	}


//if($regno=='ACC/P.086011024') echo $failedcourses." 5 $regno<br><br>";*/
	$query = "delete from remarkstable";
	mysql_query($query, $connection);

	function getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $regno, $finalyear, $cgpa, $ctnup){
		//, $groupsessions
		$resultype = $GLOBALS['resultype'];
		include("data.php"); 

		$query = "SELECT remark from remarkstable where matricno='{$regno}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
			}
			 return $remark;
		}

		$query = "SELECT min(sessions) as firstsession FROM registration where regNumber='{$regno}'  ";
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

		$query = "SELECT admissiontype FROM regularstudents where regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
		$result = mysql_query($query, $connection);
		//extract (mysql_fetch_array($result));
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
			}
		}

		$query = "select max(minimumscore) as minimumscore from coursestable where  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

//echo $failedcourses." 2 $regno<br><br>";

		$query2 = "SELECT carryover, admissiontype FROM regularstudents  where regNumber='{$regno}' ";
		$result2 = mysql_query($query2, $connection);
		$studentypes="";
		if(mysql_num_rows($result2)>0){
			$retakecourses="";
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				$retakecourses=$row2[0];
				$studentypes=$row2[1];
			}
			$parameters = explode(",", $retakecourses);
			for($t=0;$t<count($parameters);$t++){
				if(str_in_str($resultype,"Amendment")){
					$query = "SELECT * FROM amendedresults where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and previousmark>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and amendedtitle ='{$resultype}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcourses,$parameters[$t])) 
							$failedcourses .= $parameters[$t]."~".$minimumscore."][";
					}

					$query = "SELECT * FROM amendedresults where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and amendedmark>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and amendedtitle ='{$resultype}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcoursesAmended,$parameters[$t])) 
							$failedcoursesAmended .= $parameters[$t]."~".$minimumscore."][";
					}
				}else{
					$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and marksobtained>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcourses,$parameters[$t])) 
							$failedcourses .= $parameters[$t]."~".$minimumscore."][";
					}
				}
			}
		}
//echo $failedcourses." 3 $regno<br><br>";

		if($firstsession>""){
			$query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM coursestable a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Required', 'Compulsory') and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' order by a.coursecode ";
//echo $query2." 3 $regno<br><br>";
			$result2 = mysql_query($query2, $connection);
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
//echo $query2A."   ".mysql_num_rows($result2A)." 3 $regno    $coursecode<br><br>";

				$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
//if($regno=="09087038") echo $query."<br><br>";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result)==0){
//echo $query3." 3 $regno<br><br>";
					/*$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3)==0){*/
						if(!str_in_str($failedcourses,$row2[0])){
							$failedcourses .= $row2[0]."~".$row2[2]."][";
							if(str_in_str($resultype,"Amendment")){
								if(!str_in_str($failedcoursesAmended,$row2[0]))
									$failedcoursesAmended .= $row2[0]."~".$row2[2]."][";
							}
						}
					//}
				}
			}
		}		
//echo $failedcourses." 4 $regno<br><br>";

//if($regno=='CSB0730485') echo $failedcourses." 4 $regno<br><br>";
		if($firstsession>""){
			$foundflag=false;
			$electivegroup="Group 1][Group 2][Group 3][Group 4][Group 5";
			$electivegroups = explode("][", $electivegroup);
			foreach($electivegroups as $groupcode){
				$query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM coursestable a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Elective') and a.coursetypegroup='{$groupcode}' and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' order by a.coursecode ";
//if($regno=='09087038') echo $query2." 3 $regno<br><br>";
				$result2 = mysql_query($query2, $connection);
				$mycounter=0;
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$mycounter++;
//if($regno=='CSB0730485') echo $query2A."   ".mysql_num_rows($result2A)." 3 $regno    $coursecode<br><br>";

					$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					//and groupsession='{$groupsessions}' 
//if($regno=='CSB0730485') echo $query." 3 $regno<br><br>";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						$query3 = "SELECT b.*, a.minimumscore FROM coursestable a, retakecourses b  where ((b.sessiondescription='{$sessionss}' and b.semester='{$semesters}') or (b.sessiondescription='{$sessionss}' and b.semester<'{$semesters}') or (b.sessiondescription<'{$sessionss}')) and b.sessiondescription>='{$firstsession}' and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and a.coursetype='Elective'  and a.studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}' ) and b.coursestatus='Ignore PCE'";
						//and b.groupsession='{$groupsessions}' 
//if($regno=='CSB0730485') echo $query3." 3 $regno<br><br>";
						$result3 = mysql_query($query3, $connection);
						if(mysql_num_rows($result3)==0){
							if(!str_in_str($failedcourses,$row2[0])){
								if(str_in_str($resultype,"Amendment")){
									if(!str_in_str($failedcoursesAmended,$row2[0]))
										$failedcoursesAmended .= $row2[0]."~".$row2[2]."][";
								}

								// Check if course is attempted, if yes, record it
								$query4 = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
								$result4 = mysql_query($query4, $connection);
								if(mysql_num_rows($result4)>0 && $foundflag==false){
									 $failedcourses .= $row2[0]."~".$row2[2]."][";
									 $foundflag=true;
								}
								if(mysql_num_rows($result2)==$mycounter && $foundflag==false) $failedcourses .= $row2[0]."~".$row2[2]."][";
//if($regno=='CSB0730485') echo (mysql_num_rows($result2)."     ".$mycounter)." $regno<br><br>";
							}
						}
					}else{
						break;
					}
				}
			}
		}		

//if($regno=='CSB0730485') echo $failedcourses." 5 $regno<br><br>";
		$remarks="";
//echo $failedcourses." 4 $regno<br><br>";
		if($failedcourses>""){
			$failedcourses = substr($failedcourses, 0, strlen($failedcourses)-2);
			$splitfailedcourses = explode("][", $failedcourses);
			foreach($splitfailedcourses as $code){
				$minimumscore = explode("~", $code);
				if($minimumscore[0]==null || $minimumscore[0]=="") break;
				$query2 = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2) == 0 && !str_in_str($remarks,$minimumscore[0]))		$remarks .= $minimumscore[0].",  ";
			}
		}
		if($remarks!="") $remarks = substr($remarks, 0, strlen($remarks)-3);
		if($finalyear=="Yes"){
			if($remarks==""){
				$query = "SELECT minimumunit,qualificationcode FROM regularstudents where  regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
				$result = mysql_query($query, $connection);
				$outstandingunits=0;
				if(mysql_num_rows($result) > 0){
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						$outstandingunits = $minimumunit - $ctnup;
					}
				}
				if($outstandingunits>0){
					if($remarks=="") $remarks = $outstandingunits . " Unit(s) Outstanding";
				}else{
					$query = "SELECT * FROM cgpatable where qualification = '{$qualificationcode}' and sessions='{$sessionss}' and {$cgpa}>=lowerrange and {$cgpa}<=upperrange";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
							$remarks = "Passed, ".$cgpacode;
						}
					}
				}
			}
		}else{
			if($remarks=="") $remarks="Passed";
			//if($firstsession=="")  $remarks="DID NOT SIT FOR EXAM";
		}
		$GLOBALS['theremark']=$theremark;
		$query = "insert into remarkstable (matricno, remark) values ('{$regno}','{$remarks}')";
		mysql_query($query, $connection);
		return $remarks;
	}

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
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];
			include("data.php"); 
			
			$schoolnames = "";
			$query = "SELECT * FROM schoolinformation where schoolname<>''";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$schoolnames = $row[1] . ", " . $row[2];
				}
			}

			$this->Image('images\Schoologo.png',10,10,20,20);
			$this->SetFont('Times','B',10);
			$this->Cell(220,7,$schoolnames,0,0,'C');
			$this->Ln();
			$this->Cell(220,7,$facultycodes,0,0,'C');
			$this->Ln();
			$this->Cell(220,7,"DEPARTMENT OF ".$departmentcodes,0,0,'C');
			$this->Ln();
			$this->Cell(220,7,$programmecodes." PROGRAMME",0,0,'C');
			$this->Ln();
			$this->Cell(220,7,$studentlevels,0,0,'C');
			$this->Ln();
			$this->Cell(220,7,"STUDENT'S STATEMENT OF RESULTS",0,0,'C');
			$this->Ln();
		}

		// Page footer
		function Footer(){
			include("data.php"); 
			$sessionss = $GLOBALS['sessionss'];
			//$semesters = $GLOBALS['semesters'];
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];

			$query = "SELECT min(a.qualificationcode) as qualification FROM regularstudents a, registration b where a.regNumber=b.regNumber and b.sessions='{$sessionss}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' ";
			//and b.semester='{$semesters}' 
//echo $query;
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
			}

			$this->SetY(-70);
			$this->SetFont('Times','B',7.5);
			//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			$currentY=$this->GetY();
			$this->Cell(75,5,'GRADES TABLE',0,0,'C');
			$this->Ln();
			$query = "SELECT * FROM gradestable where sessions='{$sessionss}' and qualification='{$qualification}' order by gradecode ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$this->Cell(25,5,"LETTER GRADE",1,0,'C');
				$this->Cell(25,5,"MARKS RANGE",1,0,'C');
				$this->Cell(25,5,"CREDIT POINT",1,0,'C');
				$this->Ln();
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$this->Cell(25,5,$gradecode,1,0,'C');
					$this->Cell(25,5,$lowerrange."% - ".$upperrange."%",1,0,'C');
					$this->Cell(25,5,$gradeunit,1,0,'C');
					$this->Ln();
				}
			}
			$this->Ln(2);
			$this->Cell(25,5,'*Delete as appropriate',0,0,'L');
			
			$this->SetY($currentY);
			$this->SetX($this->GetX()+95);
			$this->Cell(97,5,'CLASSES OF DIPLOMA TABLE',0,0,'C');
			$this->Ln();
			$query = "SELECT * FROM CGPAtable where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$this->SetX($this->GetX()+95);
				$this->Cell(47,5,"DIPLOMA CLASSES",1,0,'L');
				$this->Cell(25,5,"LOWER RANGE",1,0,'C');
				$this->Cell(25,5,"UPPER RANGE",1,0,'C');
				$this->Ln();
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$this->SetX($this->GetX()+95);
					$this->Cell(47,5,$cgpacode,1,0,'L');
					$this->Cell(25,5,number_format($lowerrange,2),1,0,'C');
					$this->Cell(25,5,number_format($upperrange,2),1,0,'C');
					$this->Ln();
				}
			}
			$this->Ln(15);
			$this->SetX($this->GetX()+117);
			$this->Cell(50,5,'CERTIFIED BY REGISTRAR','T',0,'C');
		}
	}

	$pdf = new PDF();
	/*$today = date("Y-m-d");
	if($today>="2012-07-01"){
		$pdf->SetFont('Times','B',15);
		$pdf->Cell(250,15,"REPORTS HAVE BEEN DEACTIVATED PLEASE CONTACT THE PROGRAM VENDOR",1,0,'C');
		$pdf->Output();
		return true;
	}*/
	$matricno=substr($matricno, 0, strlen($matricno)-2);
	$matricno = explode("][", $matricno);
	$regnolist="";
	foreach($matricno as $code) $regnolist.="'".$code."', ";
	$regnolist=substr($regnolist, 0, strlen($regnolist)-2);
	$query1="select * from regularstudents WHERE regNumber IN (".$regnolist.")";
	$result1 = mysql_query($query1, $connection);
	if(mysql_num_rows($result1) > 0){
		$fullname = "";
		while ($row1 = mysql_fetch_array($result1)) {
			extract ($row1);

			$fullname = strtoupper($row1[3]).", ".$row1[2];
			if($row1[11]>"") $fullname .= " ".$row1[11];

			$query = "SELECT * FROM finalresultstable where sessiondescription='{$sessionss}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and registrationnumber='{$regNumber}'  ";
			if($semesters!=null && $semesters!="") $query .= " and semester='{$semesters}' ";
			$query .= "order by registrationnumber, sessiondescription, semester, coursecode";
//echo $query."<br><br>";
			$thesession="";
			$thesemester="";
			$prevsemester="";
			$result = mysql_query($query, $connection);
			
			if(mysql_num_rows($result) > 0){
				$count=1;
				$matno="";
				$tunit=0.0; $ttcp=0.0;
				while ($row = mysql_fetch_array($result)) {
					$prevsemester=$semester;
					extract ($row);

					$GLOBALS['studentlevels']=$studentlevel;
					$semesters=$semester;

					if($sessiondescription>$thesession){
						$thesession=$sessiondescription;
						$pdf->AliasNbPages();
						$pdf->AddPage();
						$pdf->Ln(5);
						$pdf->SetFont('Times','B',7.5);
						$currentY=$pdf->GetY();
						$pdf->Cell(36,5,"MATRIC NO",1,1,'L');
						$pdf->Cell(36,5,$regNumber,1,1,'L');
						
						$pdf->SetY($currentY);
						$pdf->SetX($pdf->GetX()+38);
						$pdf->Cell(60,5,"STUDENT'S NAMES",1,1,'L');
						$pdf->SetX($pdf->GetX()+38);
						$pdf->Cell(60,5,$fullname,1,1,'L');
						
						$pdf->SetY($currentY);
						$pdf->SetX($pdf->GetX()+100);
						$pdf->Cell(13,5,"SEX",1,1,'L');
						$pdf->SetX($pdf->GetX()+100);
						$pdf->Cell(13,5,$gender,1,1,'L');
						
						$pdf->SetY($currentY);
						$pdf->SetX($pdf->GetX()+115);
						$pdf->Cell(26,5,"BIRTH DATE",1,1,'L');
						$pdf->SetX($pdf->GetX()+115);
						$birthdate=substr($dateOfBirth,8,2)."/".substr($dateOfBirth,5,2)."/".substr($dateOfBirth,0,4);
						$pdf->Cell(26,5,$birthdate,1,1,'L');
						
						$pdf->SetY($currentY);
						$pdf->SetX($pdf->GetX()+143);
						$pdf->Cell(47,5,"RELIGION",1,1,'L');
						$pdf->SetX($pdf->GetX()+143);
						$pdf->Cell(47,5,$religion,1,2,'L');
						
						//----------Next Line
						$pdf->Ln(2);

						$currentY=$pdf->GetY();
						$pdf->Cell(36,5,"NATIONALITY",1,1,'L');
						$pdf->Cell(36,5,$nationality,1,1,'L');
						
						$pdf->SetY($currentY);
						$pdf->SetX($pdf->GetX()+38);
						$pdf->Cell(60,5,"STATE OF ORIGIN",1,1,'L');
						$pdf->SetX($pdf->GetX()+38);
						$pdf->Cell(60,5,$originState,1,1,'L');

						$pdf->SetY($currentY);
						$pdf->SetX($pdf->GetX()+143);
						$pdf->Cell(47,5,"MODE OF ADMISSION",1,1,'L');
						$pdf->SetX($pdf->GetX()+143);
						//$pdf->Cell(47,5,(($admissiontype=="PCE")?"DIRECT ENTRY" : "UME"),1,2,'L');
						$pdf->Cell(47,5,$admissiontype,1,2,'L');

						//----------Next Line
						$pdf->Ln(2);

						$pdf->Ln(0);
						$pdf->SetFont('Times','B',7.5);
						$pdf->Cell(10,5,"S/NO",1,0,'R');
						$pdf->Cell(20,5,"COURSE CODE",1,0,'C');
						$pdf->Cell(95,5,"COURSE TITLE",1,0,'C');
						$pdf->Cell(20,5,"COURSE UNIT",1,0,'C');
						$pdf->Cell(15,5,"SCORE",1,0,'C');
						$pdf->Cell(15,5,"GRADE",1,0,'C');
						$pdf->Cell(15,5,"TCP",1,0,'C');
						$pdf->Ln(5);

					}

					if($semester>$thesemester){
						if($thesemester!=""){
							$pdf->Cell(10,5,"",1,0,'L');
							$pdf->Cell(20,5,"",1,0,'L');
							$pdf->Cell(95,5,"",1,0,'L');
							$pdf->Cell(20,5,"TCP",1,0,'C');
							$pdf->Cell(15,5,"TNU",1,0,'C');
							$pdf->Cell(15,5,"GPA",1,0,'C');
							$pdf->Cell(15,5,"TNUP",1,0,'C');
							$pdf->Ln(5);

							$curGP = getCurrentGPA($facultycode, $departmentcode, $programmecode, $studentlevels, $sessiondescription, $thesemester, $registrationnumber);//, $groupsession
							$theCurGPs = explode("][", $curGP);
							$pdf->Cell(10,5,"",1,0,'L');
							$pdf->Cell(20,5,"",1,0,'R');
							$pdf->Cell(55,5,"SESSION: ".$sessiondescription,"TB",0,'L');
							$pdf->Cell(40,5,"CURRENT","TB",0,'R');
							$pdf->Cell(20,5,$theCurGPs[0],1,0,'C');
							$pdf->Cell(15,5,$theCurGPs[1],1,0,'C');
							$pdf->Cell(15,5,number_format($theCurGPs[2],2),1,0,'C');
							$pdf->Cell(15,5,$theCurGPs[3],1,0,'C');
							$pdf->Ln(5);

							$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
							$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matricno}'";
							$result2 = mysql_query($query2, $connection);
							if(mysql_num_rows($result2) > 0){
								while ($row2 = mysql_fetch_array($result2)) {
									extract ($row2);
									$tcp=$row2[1]; 
									$tnu=$row2[2]; 
									$gpa=$row2[3]; 
									$tnup=$row2[4];
								}
							}

							$preGP = getPreviousGPA($facultycode, $departmentcode, $programmecode, $studentlevels, $sessiondescription, $thesemester, $registrationnumber);
							//, $groupsession
							$thePreGPs = explode("][", $preGP);
							$pdf->Cell(10,5,"",1,0,'L');
							$pdf->Cell(20,5,"",1,0,'R');
							$pdf->Cell(55,5,"SEMESTER: ".$prevsemester,"TB",0,'L');
							$pdf->Cell(40,5,"PREVIOUS","TB",0,'R');
							if((doubleval($thePreGPs[0])+doubleval($tcp))==0){
								$pdf->Cell(20,5,"-",1,0,'C');
							}else{
								$pdf->Cell(20,5,(doubleval($thePreGPs[0])+doubleval($tcp)),1,0,'C');
							}
							
							if((doubleval($thePreGPs[1])+doubleval($tnu))==0){
								$pdf->Cell(15,5,"-",1,0,'C');
							}else{
								$pdf->Cell(15,5,(doubleval($thePreGPs[1])+doubleval($tnu)),1,0,'C');
							}
							
							if((doubleval($thePreGPs[2])+doubleval($gpa))==0){
								$pdf->Cell(15,5,"-",1,0,'C');
							}else{
								$pdf->Cell(15,5,number_format(doubleval($thePreGPs[2]) + doubleval($gpa),2),1,0,'C');
							}
							
							if((doubleval($thePreGPs[3])+doubleval($tnup))==0){
								$pdf->Cell(15,5,"-",1,0,'C');
							}else{
								$pdf->Cell(15,5,(doubleval($thePreGPs[3])+doubleval($tnup)),1,0,'C');
							}
							$pdf->Ln(5);
							if((($theCurGPs[0]+$thePreGPs[0]+$tcp)==0) || 
								(($theCurGPs[1]+$thePreGPs[1]+$tnu)==0)){
								$cgpa = 0;
							}else{
								$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
							}
							$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));

							$pdf->Cell(10,5,"",1,0,'L');
							$pdf->Cell(20,5,"",1,0,'R');
							$pdf->Cell(95,5,"CUMMULATIVE",1,0,'R');
							$pdf->Cell(20,5,(doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp)),1,0,'C');
							$pdf->Cell(15,5,(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),1,0,'C');
							$pdf->Cell(15,5,number_format($cgpa,2),1,0,'C');
							$pdf->Cell(15,5,$ctnup,1,0,'C');
							$pdf->Ln(5);
							
							$remarks = getRemarks($facultycode, $departmentcode, $programmecode, $studentlevels, $sessiondescription, $thesemester, $registrationnumber, $finalyear, $cgpa, $ctnup);
							//$pdf->Ln(5);
							$pdf->Cell(75,5,'REMARKS: '.$remarks,0,0,'L');
							//if($count>10){
								$pdf->AliasNbPages();
								$pdf->AddPage();
								$pdf->Ln(5);
								$pdf->SetFont('Times','B',7.5);
								$currentY=$pdf->GetY();
								$pdf->Cell(36,5,"MATRIC NO",1,1,'L');
								$pdf->Cell(36,5,$regNumber,1,1,'L');
								
								$pdf->SetY($currentY);
								$pdf->SetX($pdf->GetX()+38);
								$pdf->Cell(60,5,"STUDENT'S NAMES",1,1,'L');
								$pdf->SetX($pdf->GetX()+38);
								$pdf->Cell(60,5,$fullname,1,1,'L');
								
								$pdf->SetY($currentY);
								$pdf->SetX($pdf->GetX()+100);
								$pdf->Cell(13,5,"SEX",1,1,'L');
								$pdf->SetX($pdf->GetX()+100);
								$pdf->Cell(13,5,$gender,1,1,'L');
								
								$pdf->SetY($currentY);
								$pdf->SetX($pdf->GetX()+115);
								$pdf->Cell(26,5,"BIRTH DATE",1,1,'L');
								$pdf->SetX($pdf->GetX()+115);
								$birthdate=substr($dateOfBirth,8,2)."/".substr($dateOfBirth,5,2)."/".substr($dateOfBirth,0,4);
								$pdf->Cell(26,5,$birthdate,1,1,'L');
								
								$pdf->SetY($currentY);
								$pdf->SetX($pdf->GetX()+143);
								$pdf->Cell(47,5,"RELIGION",1,1,'L');
								$pdf->SetX($pdf->GetX()+143);
								$pdf->Cell(47,5,$religion,1,2,'L');
								
								//----------Next Line
								$pdf->Ln(2);

								$currentY=$pdf->GetY();
								$pdf->Cell(36,5,"NATIONALITY",1,1,'L');
								$pdf->Cell(36,5,$nationality,1,1,'L');
								
								$pdf->SetY($currentY);
								$pdf->SetX($pdf->GetX()+38);
								$pdf->Cell(60,5,"STATE OF ORIGIN",1,1,'L');
								$pdf->SetX($pdf->GetX()+38);
								$pdf->Cell(60,5,$originState,1,1,'L');

								$pdf->SetY($currentY);
								$pdf->SetX($pdf->GetX()+143);
								$pdf->Cell(47,5,"MODE OF ADMISSION",1,1,'L');
								$pdf->SetX($pdf->GetX()+143);
								//$pdf->Cell(47,5,(($admissiontype=="PCE")?"DIRECT ENTRY" : "UME"),1,2,'L');
								$pdf->Cell(47,5,$admissiontype,1,2,'L');

								//----------Next Line
								$pdf->Ln(2);

								$pdf->Ln(0);
								$pdf->SetFont('Times','B',7.5);
								$pdf->Cell(10,5,"S/NO",1,0,'R');
								$pdf->Cell(20,5,"COURSE CODE",1,0,'C');
								$pdf->Cell(95,5,"COURSE TITLE",1,0,'C');
								$pdf->Cell(20,5,"COURSE UNIT",1,0,'C');
								$pdf->Cell(15,5,"SCORE",1,0,'C');
								$pdf->Cell(15,5,"GRADE",1,0,'C');
								$pdf->Cell(15,5,"TCP",1,0,'C');
								$pdf->Ln(5);
							/*}else{
								$pdf->Ln(10);
								$pdf->SetFont('Times','B',7.5);
								$pdf->Cell(10,5,"S/NO",1,0,'R');
								$pdf->Cell(20,5,"COURSE CODE",1,0,'C');
								$pdf->Cell(95,5,"COURSE TITLE",1,0,'C');
								$pdf->Cell(20,5,"COURSE UNIT",1,0,'C');
								$pdf->Cell(15,5,"SCORE",1,0,'C');
								$pdf->Cell(15,5,"GRADE",1,0,'C');
								$pdf->Cell(15,5,"TCP",1,0,'C');
								$pdf->Ln(5);
							}*/
						}

						$thesemester=$semester;
						$count=1;
					}

					$query2 = "SELECT distinct coursecode, coursedescription, courseunit, minimumscore FROM coursestable where coursecode='{$coursecode}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semesterdescription='{$semesters}' ";
//echo $query2."<br><br>";
					$result2 = mysql_query($query2, $connection);
					while ($row2 = mysql_fetch_array($result2)) {
						extract ($row2);
						$tcp = $row2[2] * $row[7];
						$tunit += doubleval($row2[2]);
						$ttcp += doubleval($tcp);
						$pdf->Cell(10,5,$count++.".",1,0,'R');
						$pdf->Cell(20,5,$row2[0],1,0,'C');
						$pdf->Cell(95,5,$row2[1],1,0,'L');
						$pdf->Cell(20,5,$row2[2],1,0,'C');
						$pdf->Cell(15,5,$row[5],1,0,'C');
						$pdf->Cell(15,5,$row[6],1,0,'C');
						$pdf->Cell(15,5,$tcp,1,0,'C');
						$pdf->Ln(5);

					}

				}

				$pdf->Cell(10,5,"",1,0,'L');
				$pdf->Cell(20,5,"",1,0,'L');
				$pdf->Cell(95,5,"",1,0,'L');
				$pdf->Cell(20,5,"TCP",1,0,'C');
				$pdf->Cell(15,5,"TNU",1,0,'C');
				$pdf->Cell(15,5,"GPA",1,0,'C');
				$pdf->Cell(15,5,"TNUP",1,0,'C');
				$pdf->Ln(5);

				$curGP = getCurrentGPA($facultycode, $departmentcode, $programmecode, $studentlevels, $sessiondescription, $thesemester, $registrationnumber);//, $groupsession
				$theCurGPs = explode("][", $curGP);
				$pdf->Cell(10,5,"",1,0,'L');
				$pdf->Cell(20,5,"",1,0,'R');
				$pdf->Cell(55,5,"SESSION: ".$sessiondescription,"TB",0,'L');
				$pdf->Cell(40,5,"CURRENT","TB",0,'R');
				$pdf->Cell(20,5,$theCurGPs[0],1,0,'C');
				$pdf->Cell(15,5,$theCurGPs[1],1,0,'C');
				$pdf->Cell(15,5,number_format($theCurGPs[2],2),1,0,'C');
				$pdf->Cell(15,5,$theCurGPs[3],1,0,'C');
				$pdf->Ln(5);

				$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
				$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matricno}'";
				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2) > 0){
					while ($row2 = mysql_fetch_array($result2)) {
						extract ($row2);
						$tcp=$row2[1]; 
						$tnu=$row2[2]; 
						$gpa=$row2[3]; 
						$tnup=$row2[4];
					}
				}

				$preGP = getPreviousGPA($facultycode, $departmentcode, $programmecode, $studentlevels, $sessiondescription, $thesemester, $registrationnumber);//, $groupsession
				$thePreGPs = explode("][", $preGP);
				$pdf->Cell(10,5,"",1,0,'L');
				$pdf->Cell(20,5,"",1,0,'R');
				$pdf->Cell(55,5,"SEMESTER: ".$prevsemester,"TB",0,'L');
				$pdf->Cell(40,5,"PREVIOUS","TB",0,'R');
				if((doubleval($thePreGPs[0])+doubleval($tcp))==0){
					$pdf->Cell(20,5,"-",1,0,'C');
				}else{
					$pdf->Cell(20,5,(doubleval($thePreGPs[0])+doubleval($tcp)),1,0,'C');
				}
				
				if((doubleval($thePreGPs[1])+doubleval($tnu))==0){
					$pdf->Cell(15,5,"-",1,0,'C');
				}else{
					$pdf->Cell(15,5,(doubleval($thePreGPs[1])+doubleval($tnu)),1,0,'C');
				}
				
				if((doubleval($thePreGPs[2])+doubleval($gpa))==0){
					$pdf->Cell(15,5,"-",1,0,'C');
				}else{
					$pdf->Cell(15,5,number_format(doubleval($thePreGPs[2]) + doubleval($gpa),2),1,0,'C');
				}
				
				if((doubleval($thePreGPs[3])+doubleval($tnup))==0){
					$pdf->Cell(15,5,"-",1,0,'C');
				}else{
					$pdf->Cell(15,5,(doubleval($thePreGPs[3])+doubleval($tnup)),1,0,'C');
				}
				$pdf->Ln(5);

				if((($theCurGPs[0]+$thePreGPs[0]+$tcp)==0) || 
					(($theCurGPs[1]+$thePreGPs[1]+$tnu)==0)){
					$cgpa = 0;
				}else{
					$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
				}
				$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));

				$pdf->Cell(10,5,"",1,0,'L');
				$pdf->Cell(20,5,"",1,0,'R');
				$pdf->Cell(95,5,"CUMMULATIVE",1,0,'R');
				$pdf->Cell(20,5,(doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp)),1,0,'C');
				$pdf->Cell(15,5,(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),1,0,'C');
				$pdf->Cell(15,5,number_format($cgpa,2),1,0,'C');
				$pdf->Cell(15,5,$ctnup,1,0,'C');
			
				if($finalyear=="Yes"){
					$remarks = getRemarks($facultycode, $departmentcode, $programmecode, $studentlevels, $sessionss, $semesters, $regNumber, $finalyear, $cgpa, $ctnup);
					$diploma = "";
					$department = "";
					$queryB = "SELECT * FROM regularstudents where regNumber='{$registrationnumber}'";
					$resultB = mysql_query($queryB, $connection);
					if(mysql_num_rows($resultB) > 0){
						while ($rowB = mysql_fetch_array($resultB)) {
							extract ($rowB);
							$diploma = $qualificationcode;
							$department = $departmentcode;
						}
					}
					$queryB = "SELECT * FROM qualificationstable where qualificationcode='{$diploma}'";
					$resultB = mysql_query($queryB, $connection);
					if(mysql_num_rows($resultB) > 0){
						while ($rowB = mysql_fetch_array($resultB)) {
							extract ($rowB);
							$diploma = $qualificationdescription;
						}
					}
					$pdf->Ln(5);
					$pdf->Cell(75,5,'DIPLOMA AWARDED.....'.$diploma.' IN '.$department,0,0,'L');
					$pdf->Ln(5);
					if(str_in_str($remarks,",")){
						$pdf->Cell(75,5,'CARRY OVER.....'.$remarks,0,0,'L');
					}else{
						$pdf->Cell(75,5,'CLASS OF DIPLOMA.....'.$remarks,0,0,'L');
					}
					$pdf->Ln(5);
					$pdf->Cell(75,5,'DATE OF AWARD.....'.$awardate,0,0,'L');
					$pdf->Ln(5);
				}else{
					$remarks = getRemarks($facultycode, $departmentcode, $programmecode, $studentlevels, $sessionss, $semesters, $regNumber, $finalyear, $cgpa, $ctnup);
					$pdf->Ln(5);
					$pdf->Cell(75,5,'REMARKS: '.$remarks,0,0,'L');
					$pdf->Ln(5);
				}
			}
			$attachments_path = $_SERVER['DOCUMENT_ROOT']."/attachments/";
			$filename = $registrationnumber."_".str_replace("/","_",$sessionss).".pdf";
			$path = $attachments_path.$filename; 
			$pdf->Output($path,'F');

			//Process Email
			require_once('class.phpmailer.php');

			$mail = new phpmailer();  
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
			$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
			$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
			$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
			$mail->Password   = 'olugbade';            // GMAIL password

			//$to = filter_var($to, FILTER_VALIDATE_EMAIL);  // ensure email valid
			//if ('' == $to) exit('Invalid email address!');


			$mailto = $userEmail;
			$from_mail = "adewale_azeez@hotmail.com"; 
			$from_name = "Adewale Azeez"; 
			$Ccopy = ""; 
			$Bccopy = ""; 
			$replyto = $from_mail;
			$subject = "STATEMENT OF RESULTS";
			$body = "Dear ".$firstName."\nPlease find attached to this mail a copy of your statement of results.";

			$emailresponse = "";

			$mail->From=$emailaddress;
			$mail->FromName = $schoolname;
			$mail->AddReplyTo($emailaddress,$schoolname);
			$mail->Subject    = $subject;

			// optional, This is the one that the recipient is going to see if he switches to plain text format.
			$mail->AltBody    = $body; 
			
			//$mail->MsgHTML($body);
			$mail->IsHTML(true);
			$mail->Body=$body;

			//$mail->WordWrap = 50;
			//$mail->AddAttachment("embarassingmoments.jpg");

			//$address = 'adewaleazeez@yahoo.com';
			$mail->AddAddress($userEmail, $fullname);
			$mail->AddAttachment($path);

			if($mailto!=null && $mailto!=""){
				if(!$mail->Send()){
					$emailresponse = $mail->ErrorInfo." connectionerror";
				}else{
					$emailresponse = "emailsuccessfully";
				}
			}else{
					$emailresponse = "noemailaddress";
			}
		}
	}
	echo $emailresponse;




			/*$url = "http://www.immaculatedevelopers.com/bulksms/sendmail.php?filename=" . $filename . "&path=" . $path . "&mailto=" . $mailto . "&from_mail=" . $from_mail . "&Ccopy=" . $Ccopy . "&Bccopy=" . $Bccopy . "&from_name=" . $from_name . "&replyto=" . $replyto . "&vsubject=" . $subject . "&message=" . $message;
			
			$request = new HttpRequest($url, HTTP_METH_GET);
			$response = $request->send();
			if ($response==null || !$response || $response=="") {
				echo "transcriptsent - Email failed: can not connect server - ".$response;
			}else{
				echo "transcriptsent" . $response;
			}*/
		
			/*$gatewayURL = "http://www.immaculatedevelopers.com/bulksms/sendmail.php?filename=" . $filename . "&path=" . $attachments_path . "&mailto=" . $mailto . "&from_mail=" . $from_mail . "&Ccopy=" . $Ccopy . "&Bccopy=" . $Bccopy . "&from_name=" . $from_name . "&replyto=" . $replyto . "&vsubject=" . $subject . "&message=" . $message;
			
			//Open the URL to send the message ";

			$url =  $gatewayURL;  

			$response = @fopen($url, 'r');
			if (!$response) {
				echo "transcriptsent - Email failed: can not connect server - ".$response;
			}else{
				echo "transcriptsent" . $response;
			}
		}
	}else{
		echo "transcriptsentNo Recipient Found!!!";
	}*/






?>
