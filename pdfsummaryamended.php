<?php
	if($_COOKIE["currentuser"]==null || $_COOKIE["currentuser"]==""){
		echo '<script>alert("You must login to access this page!!!\n Click Ok to return to Login page.");</script>';
		echo '<script>window.location = "login.php";</script>';
		return true;
	}
	global $sessions;
	$sessions = trim($_GET['sessions']);
	if($sessions == null) $sessions = "";

	global $semesters;
	$semesters = trim($_GET['semester']);
	if($semesters == null) $semesters = "";

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

	global $groupsessions;
	$groupsessions = trim($_GET['groupsession']);
	if($groupsessions == null) $groupsessions = "";

	global $finalyear;
	$finalyear = trim($_GET['finalyear']);
	if($finalyear == null) $finalyear = "";

	global $suplementary;
	$suplementary = trim($_GET['suplementary']);
	if($suplementary == null) $suplementary = "";

	global $leftsigid;
	$leftsigid = trim($_GET['leftsigid']);
	if($leftsigid == null) $leftsigid = "";

	global $midsigid;
	$midsigid = trim($_GET['midsigid']);
	if($midsigid == null) $midsigid = "";

	global $rightsigid;
	$rightsigid = trim($_GET['rightsigid']);
	if($rightsigid == null) $rightsigid = "";

	global $leftsigname;
	$leftsigname = trim($_GET['leftsigname']);
	if($leftsigname == null) $leftsigname = "";

	global $midsigname;
	$midsigname = trim($_GET['midsigname']);
	if($midsigname == null) $midsigname = "";

	global $rightsigname;
	$rightsigname = trim($_GET['rightsigname']);
	if($rightsigname == null) $rightsigname = "";

	global $thecoursecodes;
	global $header;
	global $courseheader;
	global $summaryheader;

	include("data.php");

	function getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $matno){
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessions}' and semester='{$semesters}' and groupsession='{$groupsessions}' and registrationnumber='{$matno}' order by right(coursecode,3) desc, left(coursecode,3)";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and studentlevel='{$studentlevels}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' ";
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

	function getCurrentGPAmended($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $matno){
		$query = "SELECT a.*, b.amendedmark FROM finalresultstable a, amendedresults b where a.facultycode='{$facultycodes}' and  a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.studentlevel='{$studentlevels}' and a.sessiondescription='{$sessions}' and a.semester='{$semesters}' and a.groupsession='{$groupsessions}' and a.registrationnumber='{$matno}' and a.registrationnumber=b.registrationnumber and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and b.sessiondescription='{$sessions}' and b.semester='{$semesters}' and b.groupsession='{$groupsessions}' order by right(coursecode,3) desc, left(coursecode,3)";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and studentlevel='{$studentlevels}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' ";
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

	function getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $matno){
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and ((sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$matno}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$matno}' and studentlevel<= '{$studentlevels}') order by right(coursecode,3) desc, left(coursecode,3) ";
		$programmecodes = $GLOBALS['programmecodes'];
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$matno}' and studentlevel<= '{$studentlevels}') ";
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

	function getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $regno, $finalyear, $cgpa, $ctnup, $groupsessions){
		include("data.php"); 
		$query = "select max(minimumscore) as minimumscore from coursestable where  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
			}
		}

		$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessions}' and semester='{$semesters}') or (sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$regno}' and marksobtained<$minimumscore  and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') order by right(coursecode,3) desc, left(coursecode,3) ";
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0;
		$failedcourses="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore, coursetype FROM coursestable where coursecode='{$coursecode}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and coursetype in ('Required', 'Compulsory') and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}')";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					if($marksobtained<$minimumscore && $coursetype!="Elective") $failedcourses .= $row2[0]."~".$minimumscore."][";
				}
			}
		}
		$query2 = "SELECT b.*, a.minimumscore FROM coursestable a, retakecourses b  where ((b.sessiondescription='{$sessions}' and b.semester='{$semesters}') or (b.sessiondescription='{$sessions}' and b.semester<'{$semesters}') or (b.sessiondescription<'{$sessions}')) and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.groupsession='{$groupsessions}' and a.coursetype in ('Required', 'Compulsory') and a.studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and b.coursestatus='Retake')";
		$result2 = mysql_query($query2, $connection);
		if(mysql_num_rows($result2)>0){
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessions}' and semester='{$semesters}') or (sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$regno}' and  coursecode='{$row2[3]}' and marksobtained>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result)==0){
					if(!str_in_str($failedcourses,$row2[3])) 
						$failedcourses .= $row2[3]."~".$minimumscore."][";
				}
			}
		}
		$query2 = "SELECT carryover FROM regularstudents  where regNumber='{$regno}' ";
		$result2 = mysql_query($query2, $connection);
		if(mysql_num_rows($result2)>0){
			$retakecourses="";
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				$retakecourses=$row2[0];
			}
			$parameters = explode(",", $retakecourses);
			for($t=0;$t<count($parameters);$t++){
				if(str_in_str($resultype,"Amendment")){
					$query = "SELECT * FROM amendedresults where ((sessiondescription='{$sessions}' and semester='{$semesters}') or (sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and previousmark>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and amendedtitle ='{$resultype}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcourses,$parameters[$t])) 
							$failedcourses .= $parameters[$t]."~".$minimumscore."][";
					}

					$query = "SELECT * FROM amendedresults where ((sessiondescription='{$sessions}' and semester='{$semesters}') or (sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and amendedmark>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and amendedtitle ='{$resultype}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcoursesAmended,$parameters[$t])) 
							$failedcoursesAmended .= $parameters[$t]."~".$minimumscore."][";
					}
				}else{
					$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessions}' and semester='{$semesters}') or (sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and marksobtained>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcourses,$parameters[$t])) 
							$failedcourses .= $parameters[$t]."~".$minimumscore."][";
					}
				}
			}
		}
		$queryE = "SELECT min(sessiondescription) as firstsession FROM finalresultstable where registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and  groupsession='{$groupsessions}' ";
		$resultE = mysql_query($queryE, $connection);
		extract (mysql_fetch_array($resultE));

		if($firstsession>""){
			$query2 = "SELECT coursecode, courseunit, minimumscore, coursetype FROM coursestable where ((sessiondescription='{$sessions}' and semesterdescription='{$semesters}') or (sessiondescription='{$sessions}' and semesterdescription<'{$semesters}') or (sessiondescription<'{$sessions}')) and sessiondescription>='{$firstsession}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and coursetype in ('Required', 'Compulsory') and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}')";
			$result2 = mysql_query($query2, $connection);
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessions}' and semester='{$semesters}') or (sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result)==0){
					$query3 = "SELECT b.*, a.minimumscore FROM coursestable a, retakecourses b  where ((b.sessiondescription='{$sessions}' and b.semester='{$semesters}') or (b.sessiondescription='{$sessions}' and b.semester<'{$semesters}') or (b.sessiondescription<'{$sessions}')) and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.groupsession='{$groupsessions}' and a.coursetype in ('Required', 'Compulsory') and a.studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and b.coursestatus='Ignore DE')";
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3)==0){
						if(!str_in_str($failedcourses,$row2[0])) 
							$failedcourses .= $row2[0]."~".$row2[2]."][";
					}
				}
			}
		}		
		$remarks="";
		if($failedcourses>""){
			$splitfailedcourses = explode("][", $failedcourses);
			foreach($splitfailedcourses as $code){
				$minimumscore = explode("~", $code);
				if($minimumscore[0]==null || $minimumscore[0]=="") break;
				$query2 = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessions}' and semester='{$semesters}') or (sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2) == 0 && !str_in_str($remarks,$minimumscore[0])) $remarks .= $minimumscore[0].",  ";
			}
		}
		if($remarks!="") $remarks = substr($remarks, 0, strlen($remarks)-3);
		
		if($finalyear=="Yes"){
			if($remarks==""){
				$query = "SELECT minimumunit FROM regularstudents where  regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and entryyear='{$groupsessions}'	";
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
					$query = "SELECT * FROM cgpatable where {$cgpa}>=lowerrange and {$cgpa}<=upperrange";
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
			if($firstsession=="")  $remarks="DID NOT SIT FOR EXAM";
		}
		return $remarks;
	}

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
			// Logo
			include("data.php"); 

			$sessions = $GLOBALS['sessions'];
			$semesters = $GLOBALS['semesters'];
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];
			$groupsessions = $GLOBALS['groupsessions'];
			$suplementary = $GLOBALS['suplementary'];
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

			$coursecodes="";
			$noofcourses=0;
			$query = "SELECT coursecode, coursetype FROM coursestable where (sessiondescription='{$sessions}' and semesterdescription='{$semesters}') and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and groupsession='{$groupsessions}'  order by right(coursecode,3) desc, left(coursecode,3)";
			$result = mysql_query($query, $connection);
			$compulsory="";
			$required="";
			$elective="";
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
											$coursecodes .= $row[0] . "][";
											$noofcourses++;
				}
			}
			$coursecodes = substr($coursecodes, 0, strlen($coursecodes)-2);
			$GLOBALS['thecoursecodes'] = explode("][", $coursecodes);
			
			$thecol = 90+count($GLOBALS['thecoursecodes'])*7;
			if($thecol<330) $thecol=330;

			$this->Image('images\logo.png',10,10,40,40);
			$this->SetFont('Times','B',10);
			$this->Cell($thecol,7,$schoolnames,0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,$facultycodes,0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,"DEPARTMENT OF ".$departmentcodes,0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,$programmecodes." PROGRAMME",0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,$sessions." ".$semesters." Semester Examination Amended Results",0,0,'C');
			$this->Ln();
			//if($suplementary=="Yes"){
			//	$this->Cell($thecol,7,"SUPPLEMENTARY MASTER SCORE SHEET",0,0,'C');
			//	$this->Ln();
			//}else{
				$this->Cell($thecol,7,"MASTER SCORE SHEET",0,0,'C');
				$this->Ln();
			//}
			$this->Cell($thecol,7,$studentlevels,0,0,'C');
			$this->Ln();
		}

		// Page footer
		function Footer(){
			include("data.php"); 
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];

			$leftsigid = $GLOBALS['leftsigid'];
			$midsigid = $GLOBALS['midsigid'];
			$rightsigid = $GLOBALS['rightsigid'];

			$leftsigname = $GLOBALS['leftsigname'];
			$midsigname = $GLOBALS['midsigname'];
			$rightsigname = $GLOBALS['rightsigname'];

			// Position at 1.5 cm from bottom
			$this->SetY(-35);
			$this->SetFont('Times','B',7.5);
			if($leftsigid!=""){
				$this->Cell(100,5,"SGD",0,0,'C');
			}else{
				$this->Cell(100,5,"   ",0,0,'C');
			}
			if($midsigid!=""){
				$this->Cell(80,5,"SGD",0,0,'C');
			}else{
				$this->Cell(80,5,"   ",0,0,'C');
			}
			if($rightsigid!=""){
				$this->Cell(100,5,"SGD",0,0,'C');
			}else{
				$this->Cell(100,5,"   ",0,0,'C');
			}
			$this->Ln(10);
			if($leftsigid!=""){
				$this->Cell(100,5,"______________________________",0,0,'C');
			}else{
				$this->Cell(100,5,"                              ",0,0,'C');
			}
			if($midsigid!=""){
				$this->Cell(80,5,"______________________________",0,0,'C');
			}else{
				$this->Cell(80,5,"                              ",0,0,'C');
			}
			if($rightsigid!=""){
				$this->Cell(100,5,"______________________________",0,0,'C');
			}else{
				$this->Cell(100,5,"                              ",0,0,'C');
			}
			$this->Ln();
			if($leftsigname!=""){
				$this->Cell(100,5,$leftsigname,0,0,'C');
			}else{
				$this->Cell(100,5,"                 ",0,0,'C');
			}
			if($midsigname!=""){
				$this->Cell(80,5,$midsigname,0,0,'C');
			}else{
				$this->Cell(80,5,"                 ",0,0,'C');
			}
			if($rightsigname!=""){
				$this->Cell(100,5,$rightsigname,0,0,'C');
			}else{
				$this->Cell(100,5,"                 ",0,0,'C');
			}
			$this->Ln();
			if($rightsigid!=""){
				$this->Cell(100,5,$leftsigid,0,0,'C');
			}else{
				$this->Cell(100,5,"                 ",0,0,'C');
			}
			if($midsigid!=""){
				$this->Cell(80,5,$midsigid,0,0,'C');
			}else{
				$this->Cell(80,5,"                 ",0,0,'C');
			}
			if($rightsigid!=""){
				$this->Cell(100,5,$rightsigid,0,0,'C');
			}else{
				$this->Cell(100,5,"                 ",0,0,'C');
			}
			$this->Ln();
			$this->SetFont('Times','B',10);
			$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}

		function coursesheader(){
			include("data.php"); 
			
			$thecoursecodes = $GLOBALS['thecoursecodes'];
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];
			$sessions = $GLOBALS['sessions'];
			$semesters = $GLOBALS['semesters'];
			$groupsessions = $GLOBALS['groupsessions'];

			$this->SetFont('Times','B',7.5);
			$this->Cell(10,8,"S/NO",1,0,'R');
			$this->Cell(20,8,"MATRIC NO",1,0,'L');
			$this->Cell(50,8,"FULL NAME",1,0,'L');
			$this->Cell(7,8,"SEX",1,0,'L');
			$this->Cell(count($thecoursecodes)*7,8,"COURSES",1,0,'C');
			$this->Ln();
			
			$this->Cell(10,20," ",1,0,'R');
			$this->Cell(20,20," ",1,0,'L');
			$this->Cell(50,20," ",1,0,'L');
			$this->Cell(7,20," ",1,0,'L');
			foreach($thecoursecodes as $code){
				$query = "SELECT * FROM coursestable where coursecode='{$code}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessions}' and semesterdescription='{$semesters}' and groupsession='{$groupsessions}' ";
//echo $code."<br>\n".$query."<br>\n<br>\n";
				$result = mysql_query($query, $connection);
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$codes = explode(" ",$code);
					$ycoordinate =  $this->GetY();
					$xcoordinate =  $this->GetX();
					$this->Cell(7,5,$codes[0],"LTR",2,'C');
					$this->Cell(7,5,$codes[1],"LR",2,'C');
					$this->Cell(7,5,"(".$row[3].")","LR",2,'C');
					$this->Cell(7,5,"(".substr($row[4], 0, 1).")","LBR",0,'C');
					$this->SetY($ycoordinate);
					$this->SetX($xcoordinate+7);
				}
			}
			$this->Ln(10);
		}

		function printsummaryheader(){
			$this->SetFont('Times','B',7.5);
			$this->Cell(10,8,"S/NO",1,0,'R');
			$this->Cell(20,8,"MATRIC NO",1,0,'L');
			$this->Cell(45,8,"FULL NAME",1,0,'L');
			$this->Cell(7,8,"SEX",1,0,'L');
			$this->Cell(30,8,"CURRENT",1,0,'C');
			$this->Cell(30,8,"PREVIOUS",1,0,'C');
			$this->Cell(30,8,"CUMMULATIVE",1,0,'C');
			//$this->Cell(count($GLOBALS['thecoursecodes'])*7-90,8,"REMARKS",1,0,'L');
			$this->Cell(100,8,"REMARKS",1,0,'L');
			$this->Ln();
			$this->Cell(10,8,"",1,0,'R');
			$this->Cell(20,8,"",1,0,'L');
			$this->Cell(45,8,"",1,0,'L');
			$this->Cell(7,8,"",1,0,'L');
			$this->Cell(7,8,"TCP",1,0,'C');
			$this->Cell(7,8,"TNU",1,0,'C');
			$this->Cell(7,8,"GPA",1,0,'C');
			$this->Cell(9,8,"TNUP",1,0,'C');
			$this->Cell(7,8,"TCP",1,0,'C');
			$this->Cell(7,8,"TNU",1,0,'C');
			$this->Cell(7,8,"GPA",1,0,'C');
			$this->Cell(9,8,"TNUP",1,0,'C');
			$this->Cell(7,8,"TCP",1,0,'C');
			$this->Cell(7,8,"TNU",1,0,'C');
			$this->Cell(7,8,"GPA",1,0,'C');
			$this->Cell(9,8,"TNUP",1,0,'C');
			//$this->Cell(count($GLOBALS['thecoursecodes'])*7-90,8,"REPEAT OR RETAKE",1,0,'C');
			$this->Cell(100,8,"REPEAT OR RETAKE",1,0,'L');
			$this->Ln();
		}
	}

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

	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',7.5);

	$students_in_class=0;
	$students_who_sat_for_eaxam=0;
	$students_who_did_not_sit_for_eaxam=0;
	$students_who_passed_exam=0;
	$students_for_commendation=0;
	$students_for_reference=0;
	$students_for_counselling=0;
	$students_for_probation=0;
	$students_for_withdrawal=0;
	$students_for_suspension_of_studentship=0;
	$students_for_determination_of_studentship=0;
	$details="";
	$summary="";

	$query = "SELECT a.*, b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber and b.sessions='{$sessions}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$groupsessions}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes' order by a.regNumber";
//echo $query."<br><br>";
	$result = mysql_query($query, $connection);
	$students_in_class=mysql_num_rows($result);
	$absentstudent="";
	while ($row = mysql_fetch_array($result)) {
		extract ($row);

		$queryE = "SELECT min(sessiondescription) as firstsession FROM finalresultstable where registrationnumber='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and  groupsession='{$groupsessions}' ";
		$resultE = mysql_query($queryE, $connection);
		extract (mysql_fetch_array($resultE));

		$queryE = "SELECT * FROM sessionstable order by sessiondescription desc, semesterdescription desc";
		$resultE = mysql_query($queryE, $connection);
		$sessions2="";
		$semesters2="";
		$flag=0;
		while ($rowE = mysql_fetch_array($resultE)) {
			extract ($rowE);
			if($sessiondescription==$sessions && $semesterdescription==$semesters){
				$flag=1;
				continue;
			}
			if($flag==1){
				if($sessiondescription<$firstsession){
					$sessions2=$sessions;
					$semesters2=$semesters;
				}else{
					$sessions2=$sessiondescription;
					$semesters2=$semesterdescription;
				}
				break;
			}
		}
		$query2 = "SELECT * FROM registration where sessions='{$sessions}' and semester='{$semesters}' and regNumber='{$regNumber}'";
		$result2 = mysql_query($query2, $connection);
		if(mysql_num_rows($result2) > 0){
			$query3 = "SELECT * FROM registration where sessions='{$sessions2}' and semester='{$semesters2}' and regNumber='{$regNumber}'";
			$result3 = mysql_query($query3, $connection);
			if(mysql_num_rows($result3) > 0){
				$query4 = "SELECT *  FROM finalresultstable where sessiondescription='{$sessions}' and semester='{$semesters}' and registrationnumber='{$regNumber}'";
				$result4 = mysql_query($query4, $connection);
				if(mysql_num_rows($result4)==0){
					$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT SIT FOR EXAM";
				}
			}else{
				$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER";
			}
		}else{
			$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER";
		}
	}
	$absentstudents = explode("!!!", $absentstudent);
	$absentcounter=1;
	$currentabsent = explode("~~",$absentstudents[$absentcounter]);

	$thecoursecodes = $GLOBALS['thecoursecodes'];
	$query = "SELECT b.*, a.* FROM regularstudents AS a INNER JOIN finalresultstable AS b 
	ON (a.regNumber = b.registrationnumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and  a.entryyear='{$groupsessions}' and a.lockrec!='Yes' and b.sessiondescription='{$sessions}' and b.semester='{$semesters}' and a.active='Yes' and b.facultycode='{$facultycodes}' and b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and b.groupsession='{$groupsessions}') order by b.registrationnumber, right(b.coursecode,3) desc, left(b.coursecode,3)";
	$result = mysql_query($query, $connection);
//echo $query."<br><br>";

	if(mysql_num_rows($result) > 0){
		$count=1;
		$matno="";
		$noofstudents=0;
		$pdf->coursesheader();
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$queryE = "SELECT registrationnumber FROM amendedresults where registrationnumber='{$registrationnumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and  groupsession='{$groupsessions}' and  sessiondescription='{$sessions}' and  semester='{$semesters}' ";
			$resultE = mysql_query($queryE, $connection);
			if(mysql_num_rows($resultE) == 0) continue;
		
			if($registrationnumber <> $matno){
				$c=0;
				foreach($thecoursecodes as $code){
					if($c++ < $noofcourses) continue;
					if($matno>"") $details .= "_~_7<td>";
					$noofcourses++;
				}
				if($details != "") $details = substr($details, 0, strlen($details)-4)."<tr>";
				if($c <>0 && $matno <>"") {
					$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $matno);
					$theCurGPs = explode("][", $curGP);
					$summary .=  $theCurGPs[0]."_~_7<td>".$theCurGPs[1]."_~_7<td>";
					$summary .=  number_format($theCurGPs[2],2)."_~_7<td>";
					$summary .=  $theCurGPs[3]."_~_9<td>";
					if(doubleval($theCurGPs[2])>=4.50){
						$students_for_commendation++;
					}

					$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
					$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and entryyear='{$groupsessions}' ";
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

					$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $matno);
					$thePreGPs = explode("][", $preGP);
					$summary .=  (doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
					$summary .=  (doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
					$summary .=  number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."_~_7<td>";
					$summary .=  (doubleval($thePreGPs[3])+doubleval($tnup))."_~_9<td>";

					if((($theCurGPs[0]+$thePreGPs[0]+$tcp)==0) || 
						(($theCurGPs[1]+$thePreGPs[1]+$tnu)==0)){
						$cgpa = 0;
					}else{
						$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
					}
					$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
					$summary .=  (doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
					$summary .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
					$summary .=  number_format($cgpa,2)."_~_7<td>".$ctnup."_~_9<td>";

					$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $matno, $finalyear, $cgpa, $ctnup, $groupsessions);
					//$remcol = count($GLOBALS['thecoursecodes'])*7-90;
					$remcol = 100;
					$summary .= $remarks."_~_$remcol<tr>";

					if(str_in_str($remarks,"Passed")){
						$students_who_passed_exam++;
					}
					if(!str_in_str($remarks,"Passed")){
						$students_for_reference++;
					}
					if(doubleval($theCurGPs[2])<1.0){
						$students_for_counselling++;
					}
					if(doubleval($cgpa)<1.0){
						$students_for_probation++;
					}
					if(doubleval($theCurGPs[2])<1.0){
						$queryE = "SELECT min(sessiondescription) as firstsession FROM finalresultstable where registrationnumber='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' ";
						$resultE = mysql_query($queryE, $connection);
						$resultE = mysql_query($queryE, $connection);
						extract (mysql_fetch_array($resultE));

						$queryE = "SELECT * FROM sessionstable order by sessiondescription desc, semesterdescription desc";
						$resultE = mysql_query($queryE, $connection);
						$sessions2="";
						$semesters2="";
						$flag=0;
						while ($rowE = mysql_fetch_array($resultE)) {
							extract ($rowE);
							if($sessiondescription==$sessions && $semesterdescription==$semesters){
								$flag=1;
								continue;
							}
							if($flag==1){
								if($sessiondescription<$firstsession){
									$sessions2=$sessions;
									$semesters2=$semesters;
								}else{
									$sessions2=$sessiondescription;
									$semesters2=$semesterdescription;
								}
								break;
							}
						}

						$curGP2 = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions2, $semesters2, $groupsessions, $matno);
						$theCurGPs2 = explode("][", $curGP2);

						if(doubleval($theCurGPs2[2])<1.0){
							$students_for_withdrawal++;
						}
					}
				}
				$matno = $registrationnumber;

				$query2 = "SELECT regNumber, firstName, lastName, middleName, gender FROM regularstudents where regNumber='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and entryyear='{$groupsessions}' ";
				$result2 = mysql_query($query2, $connection);

				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					for(; $currentabsent[0]<$row2[0] && $absentcounter<count($absentstudents);){
						$currentabsent = explode("~~",$absentstudents[$absentcounter]);
						if($currentabsent[0]<$row2[0]){
							$details .= $count++."._~_10<td>".$currentabsent[0]."_~_20<td>";
							$details .= $currentabsent[1]."_~_50<td>".substr($currentabsent[2],0,1)."_~_7<td>";
							$details .= $currentabsent[3]."_~_".(count($thecoursecodes)*7)."<tr>";;
							$summary .= ($count-1)."._~_10<td>".$currentabsent[0]."_~_20<td>";
							$summary .= $currentabsent[1]."_~_45<td>".substr($currentabsent[2],0,1)."_~_7<td>";
							//$summary .= $currentabsent[3]."_~_190<tr>";
							$absentcounter++;
							$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $currentabsent[0]);
							$theCurGPs = explode("][", $curGP);
							$summary .=  $theCurGPs[0]."_~_7<td>".$theCurGPs[1]."_~_7<td>";
							$summary .=  number_format($theCurGPs[2],2)."_~_7<td>".$theCurGPs[3]."_~_9<td>";
							if(doubleval($theCurGPs[2])>=4.50){
								$students_for_commendation++;
							}

							$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
							$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$currentabsent[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and entryyear='{$groupsessions}' ";
							$result5 = mysql_query($query2, $connection);
							if(mysql_num_rows($result5) > 0){
								while ($row5 = mysql_fetch_array($result5)) {
									extract ($row5);
									$tcp=$row5[1]; 
									$tnu=$row5[2]; 
									$gpa=$row5[3]; 
									$tnup=$row5[4];
								}
							}

							$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $currentabsent[0]);
							$thePreGPs = explode("][", $preGP);
							$summary .=  (doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
							$summary .=  (doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
							$summary .=  number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."_~_7<td>";
							$summary .=  (doubleval($thePreGPs[3])+doubleval($tnup))."_~_9<td>";

							if(($theCurGPs[0]==0 && $thePreGPs[0]==0 && $tcp==0) || 
								($theCurGPs[1]==0 && $thePreGPs[1]==0 && $tnu==0)){
								$cgpa = 0;
							}else{
								$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
							}
							$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
							$summary .=  (doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
							$summary .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
							$summary .=  number_format($cgpa,2)."_~_7<td>".$ctnup."_~_9<td>";
							$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $currentabsent[0], $finalyear, $cgpa, $ctnup, $groupsessions);
							//$remcol = count($GLOBALS['thecoursecodes'])*7-90;
							$remcol = 100;
							$summary .=  $remarks."_~_$remcol<tr>";
						}
					}
					$fullname = strtoupper($row2[2]).", ".$row2[1];
					if($row2[3]>"") $fullname .= " ".$row2[3];
					$details .= $count++."._~_10<td>".$row2[0]."_~_20<td>";
					$details .= $fullname."_~_50<td>".substr($row2[4],0,1)."_~_7<td>";
					$summary .= ($count-1)."._~_10<td>".$row2[0]."_~_20<td>";
					$summary .= $fullname."_~_45<td>".substr($row2[4],0,1)."_~_7<td>";
					$students_who_sat_for_eaxam++;

				}
				$noofcourses=0;
			}
			if($registrationnumber == $matno){
				$noofstudents++;
				$c=0;
				foreach($thecoursecodes as $code){
					if($c++ < $noofcourses) continue;
					if($row[3]==$code){
						$score = $row[5]."~~_".$row[6];
						if($row[5]==0){
							if($row[10]=="Absent"){
								$score = "AB~~_".$row[6];
							}else{
								$score = "00~~_".$row[6];
							}
						}
						$details .= $score."_~_7<td>";
						$noofcourses++;
						break;
					}else{
						$details .= " _~_7<td>";
						$noofcourses++;
					}
				}
			}
		}
		$c=0;
		foreach($thecoursecodes as $code){
			if($c++ < $noofcourses) continue;
			$details .= " _~_7<td>";
			$noofcourses++;
		}
		$details = substr($details, 0, strlen($details)-4)."<tr>";
		if($c <>0) {
			$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $matno);
			$theCurGPs = explode("][", $curGP);
			$summary .=  $theCurGPs[0]."_~_7<td>".$theCurGPs[1]."_~_7<td>";
			$summary .=  number_format($theCurGPs[2],2)."_~_7<td>".$theCurGPs[3]."_~_9<td>";
			if(doubleval($theCurGPs[2])>=4.50){
				$students_for_commendation++;
			}

			$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
			$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and entryyear='{$groupsessions}' ";
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

			$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $matno);
			$thePreGPs = explode("][", $preGP);
			$summary .=  (doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
			$summary .=  (doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
			$summary .=  number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."_~_7<td>";
			$summary .=  (doubleval($thePreGPs[3])+doubleval($tnup))."_~_9<td>";

			if(($theCurGPs[0]==0 && $thePreGPs[0]==0 && $tcp==0) || 
				($theCurGPs[1]==0 && $thePreGPs[1]==0 && $tnu==0)){
				$cgpa = 0;
			}else{
				$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
			}
			$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
			$summary .=  (doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
			$summary .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
			$summary .=  number_format($cgpa,2)."_~_7<td>".$ctnup."_~_9<td>";
			$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $matno, $finalyear, $cgpa, $ctnup, $groupsessions);
			//$remcol = count($GLOBALS['thecoursecodes'])*7-90;
			$remcol = 100;
			$summary .=  $remarks."_~_$remcol<tr>";

			if(str_in_str($remarks,"Passed")){
				$students_who_passed_exam++;
			}
			if(!str_in_str($remarks,"Passed")){
				$students_for_reference++;
			}
			if(doubleval($theCurGPs[2])<1.0){
				$students_for_counselling++;
			}
			if(doubleval($cgpa)<1.0){
				$students_for_probation++;
			}
			if(doubleval($theCurGPs[2])<1.0){
				$queryE = "SELECT min(sessiondescription) as firstsession FROM finalresultstable where registrationnumber='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and groupsession='{$groupsessions}' ";
				$resultE = mysql_query($queryE, $connection);
				extract (mysql_fetch_array($resultE));

				$queryE = "SELECT * FROM sessionstable order by sessiondescription desc, semesterdescription desc";
				$resultE = mysql_query($queryE, $connection);
				$sessions2="";
				$semesters2="";
				$flag=0;
				while ($rowE = mysql_fetch_array($resultE)) {
					extract ($rowE);
					if($sessiondescription==$sessions && $semesterdescription==$semesters){
						$flag=1;
						continue;
					}
					if($flag==1){
						if($sessiondescription<$firstsession){
							$sessions2=$sessions;
							$semesters2=$semesters;
						}else{
							$sessions2=$sessiondescription;
							$semesters2=$semesterdescription;
						}
						break;
					}
				}

				$curGP2 = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions2, $semesters2, $groupsessions, $matno);
				$theCurGPs2 = explode("][", $curGP2);

				if(doubleval($theCurGPs2[2])<1.0){
					$students_for_withdrawal++;
				}
			}
		}
	}

	for(; $absentcounter<count($absentstudents);){
		$currentabsent = explode("~~",$absentstudents[$absentcounter]);
		$details .= $count++."._~_10<td>".$currentabsent[0]."_~_20<td>";
		$details .= $currentabsent[1]."_~_50<td>".substr($currentabsent[2],0,1)."_~_7<td>";
		$details .= $currentabsent[3]."_~_".(count($thecoursecodes)*7)."<tr>";;
		$summary .= ($count-1)."._~_10<td>".$currentabsent[0]."_~_20<td>";
		$summary .= $currentabsent[1]."_~_45<td>".substr($currentabsent[2],0,1)."_~_7<td>";
		//$summary .= $currentabsent[3]."_~_190<tr>";
		$absentcounter++;
		$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $currentabsent[0]);
		$theCurGPs = explode("][", $curGP);
		$summary .=  $theCurGPs[0]."_~_7<td>".$theCurGPs[1]."_~_7<td>";
		$summary .=  number_format($theCurGPs[2],2)."_~_7<td>".$theCurGPs[3]."_~_9<td>";
		if(doubleval($theCurGPs[2])>=4.50){
			$students_for_commendation++;
		}

		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$currentabsent[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and entryyear='{$groupsessions}' ";
		$result5 = mysql_query($query2, $connection);
		if(mysql_num_rows($result5) > 0){
			while ($row5 = mysql_fetch_array($result5)) {
				extract ($row5);
				$tcp=$row5[1]; 
				$tnu=$row5[2]; 
				$gpa=$row5[3]; 
				$tnup=$row5[4];
			}
		}

		$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions, $currentabsent[0]);
		$thePreGPs = explode("][", $preGP);
		$summary .=  (doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
		$summary .=  (doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
		$summary .=  number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."_~_7<td>";
		$summary .=  (doubleval($thePreGPs[3])+doubleval($tnup))."_~_9<td>";

		if(($theCurGPs[0]==0 && $thePreGPs[0]==0 && $tcp==0) || 
			($theCurGPs[1]==0 && $thePreGPs[1]==0 && $tnu==0)){
			$cgpa = 0;
		}else{
			$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
		}
		$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
		$summary .=  (doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."_~_7<td>";
		$summary .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7<td>";
		$summary .=  number_format($cgpa,2)."_~_7<td>".$ctnup."_~_9<td>";
		$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $currentabsent[0], $finalyear, $cgpa, $ctnup, $groupsessions);
		//$remcol = count($GLOBALS['thecoursecodes'])*7-90;
		$remcol = 100;
		$summary .=  $remarks."_~_$remcol<tr>";
	}

	$details=substr($details, 0, strlen($details)-4);
	$summary=substr($summary, 0, strlen($summary)-4);

	$details = explode("<tr>", $details);
	$summary = explode("<tr>", $summary);

	$pdf->Ln(10);
	$header = $GLOBALS['header'];
	$courseheader = $GLOBALS['courseheader'];
	$summaryheader = $GLOBALS['summaryheader'];

	$count = ($count -1) * 2;
	$lastpage= intval($count/10);
	++$lastpage;
	if(($count % 10)>0) ++$lastpage;
	$counter1=0;
	$counter2=0;
	$summarylinecount=0;
	$page=0;
	for($i=0; $i<count($details); $i++){
		$counter1++;
		if(((($counter1-1) % 10)==0) && $counter1>=10){
			$pdf->AddPage();
			$pdf->printsummaryheader();
			for($j=($i-10); $j<count($summary); $j++){
				$counter2++;
				$summarylinecount++;
				if(((($counter2-1) % 10)==0) && $counter2>=10){
					$counter2=0;
					$summarylinecount=0;
					break;
				}
				//if(((($summarylinecount-1) % 10)==0) && $summarylinecount>=10){
				//	$summarylinecount=0;
				//	$pdf->AddPage();
				//	$pdf->printsummaryheader();
				//}
						if($summarylinecount>=14 && $thecount<count($summary)){
							$summarylinecount=0;
							$pdf->AddPage();
							$pdf->printsummaryheader();
						}
				$summarycol = explode("<td>", $summary[$j]);
				$mycol = explode("_~_", $summarycol[16]);
				$lines = strlen($mycol[0])/80;
				if((strlen($mycol[0]) % 80) > 0) $lines = intval($lines) + 1;
				if(strlen($mycol[0])<=80) $lines = 1;
				$height=8;
				if($lines>1) $height=6;
				$thecount=0;
				foreach($summarycol as $col){
					$mycol = explode("_~_", $col);
					$thecount++;
					if($thecount<=4){
						$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'L');
					}else if($thecount>16){
						$index=0;
						if($lines>1) $summarylinecount+= ($lines-1);
						for(;$lines>1;){
							$pdf->Cell(intval($mycol[1]), $height,substr($mycol[0], $index, 80), "LR", 2, 'L');
							$index += 80;
							$lines--;
						}
						$pdf->Cell(intval($mycol[1]), $height, substr($mycol[0], $index, 80) ,"LBR",0,'L');
					}else{
						$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'C');
					}
				}
				$pdf->Ln($height);
			}
			if($i<=count($details)-1){
				$pdf->AddPage();
				$pdf->coursesheader();
				$pdf->Ln(10);
			}
		}
		$detailscol = explode("<td>", $details[$i]);
		foreach($detailscol as $col){
			$mycol = explode("_~_", $col);
			if(str_in_str($mycol[0],"DID NOT")){
				$pdf->Cell(intval($mycol[1]),8,$mycol[0],1,0,'L');
			}else if(str_in_str($mycol[0],"~~_")){
				$mycol1 = explode("~~_",$mycol[0]);
				$ycoordinate =  $pdf->GetY();
				$xcoordinate =  $pdf->GetX();
				$pdf->Cell(7,4,$mycol1[0],"LTR",2,'C');
				$pdf->Cell(7,4,$mycol1[1],"LBR",0,'C');
				$pdf->SetY($ycoordinate);
				$pdf->SetX($xcoordinate+7);
			}else{
				$pdf->Cell(intval($mycol[1]),8,$mycol[0],1,0,'L');
			}
		}
		$pdf->Ln(8);
	}
	$lines = 0;
	if(($counter1 % 10)>0) $lines = 10 - ($counter1 % 10);
	$pdf->AddPage();
	$pdf->printsummaryheader();

	if($j==null || $j=="") $j=0;
	for(; $j<count($summary); $j++){
		$counter2++;
		$summarylinecount++;
		if(((($counter2-1) % 10)==0) && $counter2>=10){
			$counter2=0;
			$summarylinecount=0;
			break;
		}
		//if(((($summarylinecount-1) % 10)==0) && $summarylinecount>=10){
		//	$summarylinecount=0;
		//	$pdf->AddPage();
		//	$pdf->printsummaryheader();
		//}
		if($summarylinecount>=14 && $thecount<count($summary)){
			$summarylinecount=0;
			$pdf->AddPage();
			$pdf->printsummaryheader();
		}
		$summarycol = explode("<td>", $summary[$j]);
		$mycol = explode("_~_", $summarycol[16]);
		$lines = strlen($mycol[0])/80;
		if((strlen($mycol[0]) % 80) > 0) $lines = intval($lines) + 1;
		if(strlen($mycol[0])<=80) $lines = 1;
		$height=8;
		if($lines>1) $height=6;
		$thecount=0;
		foreach($summarycol as $col){
			$mycol = explode("_~_", $col);
			$thecount++;
			if($thecount<=4){
				$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'L');
			}else if($thecount>16){
				$index=0;
				if($lines>1) $summarylinecount+= ($lines-1);
				for(;$lines>1;){
					$lines--;
					$pdf->Cell(intval($mycol[1]), $height, substr($mycol[0], $index, 80), "LR", 2, 'L');
					$index += 80;
				}
				$pdf->Cell(intval($mycol[1]), $height, substr($mycol[0], $index, 80) ,"LBR",0,'L');
			}else{
				$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'C');
			}
		}
		$pdf->Ln($height);
	}

	function courseList($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions){
		include("data.php"); 
		$query = "SELECT coursecode, coursetype FROM coursestable where (sessiondescription='{$sessions}' and semesterdescription='{$semesters}') and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and groupsession='{$groupsessions}' order by coursetype, coursecode";
		$result = mysql_query($query, $connection);
		$compulsory="";
		$required="";
		$elective="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				if($row[1]=="Compulsory") $compulsory .= $row[0].", ";
				if($row[1]=="Required") $required .= $row[0].", ";
				if($row[1]=="Elective") $elective .= $row[0].", ";
			}
		}
		return $compulsory."][".$required."][".$elective;
	}
	
	$courselist =  courseList($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessions, $semesters, $groupsessions);
	$courselist = explode("][", $courselist);
	$compulsory=$courselist[0];
	$required=$courselist[1];
	$elective=$courselist[2];
	$compulsory=substr($compulsory, 0, strlen($compulsory)-2);
	$required=substr($required, 0, strlen($required)-2);
	$elective=substr($elective, 0, strlen($elective)-2);
//echo $counter1."<br><br>";

	if(($counter1 % 10) >= 7){
		$pdf->AddPage();
	}else{
		$pdf->Ln();
	}
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(250,10,"STATUS OF COURSES",1,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Times','B',9);

	$lines = strlen($compulsory)/116;
	if((strlen($compulsory) % 116) > 0) $lines = intval($lines) + 1;
	if(strlen($compulsory)<=116) $lines = 1;
	$pdf->Cell(50,8 * $lines,"COMPULSORY COURSES: ",1,0,'L');
	$index=0;
	for($k=1; $k<$lines; $k++){
		$pdf->Cell(200,8,substr($compulsory,$index,$index+115),"LR",2,'L');
		$index += 116;
	}
	$pdf->Cell(200,8,substr($compulsory,$index,$index+115),"LBR",0,'L');
	$pdf->Ln();

	$lines = strlen($required)/116;
	if((strlen($required) % 116) > 0) $lines = intval($lines) + 1;
	if(strlen($required)<=116) $lines = 1;
	$pdf->Cell(50,8 * $lines,"REQUIRED COURSES: ",1,0,'L');
	$index=0;
	for($k=1; $k<$lines; $k++){
		$pdf->Cell(200,8,substr($required,$index,$index+115),"LR",2,'L');
		$index += 116;
	}
	$pdf->Cell(200,8,substr($required,$index,$index+115),"LBR",0,'L');
	$pdf->Ln();

	$lines = strlen($elective)/116;
	if((strlen($elective) % 116) > 0) $lines = intval($lines) + 1;
	if(strlen($elective)<=116) $lines = 1;
	$pdf->Cell(50,8 * $lines,"ELECTIVE COURSES: ",1,0,'L');
	$index=0;
	for($k=1; $k<$lines; $k++){
		$pdf->Cell(200,8,substr($elective,$index,$index+115),"LR",2,'L');
		$index += 116;
	}
	$pdf->Cell(200,8,substr($elective,$index,$index+115),"LBR",0,'L');
	$pdf->Ln();

	$pdf->Output();


/*	global $pdf;
	
	global $sessions;
	$sessions = trim($_GET['sessions']);
	if($sessions == null) $sessions = "";

	global $semesters;
	$semesters = trim($_GET['semester']);
	if($semesters == null) $semesters = "";

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

	global $groupsessions;
	$groupsessions = trim($_GET['groupsession']);
	if($groupsessions == null) $groupsessions = "";

	global $finalyear;
	$finalyear = trim($_GET['finalyear']);
	if($finalyear == null) $finalyear = "";

	global $resultype;
	$resultype = trim($_GET['resultype']);
	if($resultype == null) $resultype = "";

	global $leftsigid;
	$leftsigid = trim($_GET['leftsigid']);
	if($leftsigid == null) $leftsigid = "";

	global $midsigid;
	$midsigid = trim($_GET['midsigid']);
	if($midsigid == null) $midsigid = "";

	global $rightsigid;
	$rightsigid = trim($_GET['rightsigid']);
	if($rightsigid == null) $rightsigid = "";

	global $leftsigname;
	$leftsigname = trim($_GET['leftsigname']);
	if($leftsigname == null) $leftsigname = "";

	global $midsigname;
	$midsigname = trim($_GET['midsigname']);
	if($midsigname == null) $midsigname = "";

	global $rightsigname;
	$rightsigname = trim($_GET['rightsigname']);
	if($rightsigname == null) $rightsigname = "";

	global $header;
	global $footer;
	global $page;
	$GLOBALS['page']=0;

	include("data.php");
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
			include("data.php"); 

			$sessions = $GLOBALS['sessions'];
			$semesters = $GLOBALS['semesters'];
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];
			$groupsessions = $GLOBALS['groupsessions'];
			$resultype = $GLOBALS['resultype'];

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


			$this->Image('images\logo.png',10,10,35,35);
			$this->SetFont('Times','B',10);
			$this->Cell(190,7,$schoolnames,0,0,'C');
			$this->Ln();
			$this->Cell(190,7,$facultycodes,0,0,'C');
			$this->Ln();
			$this->Cell(190,7,"DEPARTMENT OF ".$departmentcodes,0,0,'C');
			$this->Ln();
			$this->Cell(190,7,$programmecodes." PROGRAMME",0,0,'C');
			$this->Ln();
			$this->Cell(190,7,$sessions." ".$semesters." Semester Examination Results",0,0,'C');
			$this->Ln();
			if($resultype=="Supplemenrary Results"){
				$this->Cell(190,7,"SUPPLEMENTARY SUMMARY OF RESULTS",0,0,'C');
				$this->Ln();
			}else if($resultype=="Normal Results"){
				$this->Cell(190,7,"SUMMARY OF RESULTS",0,0,'C');
				$this->Ln();
			}else if($resultype=="Amended Results"){
				$this->Cell(190,7,"AMENDED RESULTS",0,0,'C');
				$this->Ln();
			}
			$this->Cell(190,7,$studentlevels,0,0,'C');
			$this->Ln();
		}

		// Page footer
		function Footer(){
			include("data.php"); 
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];

			$leftsigid = $GLOBALS['leftsigid'];
			$midsigid = $GLOBALS['midsigid'];
			$rightsigid = $GLOBALS['rightsigid'];

			$leftsigname = $GLOBALS['leftsigname'];
			$midsigname = $GLOBALS['midsigname'];
			$rightsigname = $GLOBALS['rightsigname'];

			$this->SetY(-35);
			$this->SetFont('Times','B',7.5);
			if($leftsigid!=""){
				$this->Cell(65,5,"SGD",0,0,'C');
			}else{
				$this->Cell(65,5,"   ",0,0,'C');
			}
			if($midsigid!=""){
				$this->Cell(60,5,"SGD",0,0,'C');
			}else{
				$this->Cell(60,5,"   ",0,0,'C');
			}
			if($rightsigid!=""){
				$this->Cell(65,5,"SGD",0,0,'C');
			}else{
				$this->Cell(65,5,"   ",0,0,'C');
			}
			$this->Ln(10);
			if($leftsigid!=""){
				$this->Cell(65,5,"______________________________",0,0,'C');
			}else{
				$this->Cell(65,5,"                              ",0,0,'C');
			}
			if($midsigid!=""){
				$this->Cell(60,5,"______________________________",0,0,'C');
			}else{
				$this->Cell(60,5,"                              ",0,0,'C');
			}
			if($rightsigid!=""){
				$this->Cell(65,5,"______________________________",0,0,'C');
			}else{
				$this->Cell(65,5,"                              ",0,0,'C');
			}
			$this->Ln();
			if($leftsigname!=""){
				$this->Cell(65,5,$leftsigname,0,0,'C');
			}else{
				$this->Cell(65,5,"                 ",0,0,'C');
			}
			if($midsigname!=""){
				$this->Cell(60,5,$midsigname,0,0,'C');
			}else{
				$this->Cell(60,5,"                 ",0,0,'C');
			}
			if($rightsigname!=""){
				$this->Cell(65,5,$rightsigname,0,0,'C');
			}else{
				$this->Cell(65,5,"                 ",0,0,'C');
			}
			$this->Ln();
			if($rightsigid!=""){
				$this->Cell(65,5,$leftsigid,0,0,'C');
			}else{
				$this->Cell(65,5,"                 ",0,0,'C');
			}
			if($midsigid!=""){
				$this->Cell(60,5,$midsigid,0,0,'C');
			}else{
				$this->Cell(60,5,"                 ",0,0,'C');
			}
			if($rightsigid!=""){
				$this->Cell(65,5,$rightsigid,0,0,'C');
			}else{
				$this->Cell(65,5,"                 ",0,0,'C');
			}
			$this->Ln();
			$this->SetFont('Times','B',10);
			$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}

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


	function displayAmendedResults($sessions,$semesters,$facultycodes,
		$departmentcodes,$programmecodes,$studentlevels,$finalyear,$groupsessions){

		include("data.php"); 
	
		$query = "SELECT b.*, a.* FROM regularstudents AS a INNER JOIN amendedresults AS b ON (a.regNumber = b.registrationnumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$groupsessions}' and a.lockrec!='Yes' and b.sessiondescription='{$sessions}' and b.semester='{$semesters}' and a.active='Yes' and b.facultycode='{$facultycodes}' and b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and b.groupsession='{$groupsessions}') order by b.registrationnumber, right(b.coursecode,3) desc, left(b.coursecode,3)";
		$result = mysql_query($query, $connection);

		if(mysql_num_rows($result) > 0){

			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->SetFont('Times','B',7.5);
			$pdf->AddPage();

			$pdf->Cell(10,8,"S/NO",1,0,'L');
			$pdf->Cell(20,8,"MATRIC NO",1,0,'L');
			$pdf->Cell(45,8,"FULL NAME",1,0,'L');
			$pdf->Cell(7,8,"SEX",1,0,'L');
			$pdf->Cell(25,8,"COURSE CODE",1,0,'C');
			$pdf->Cell(25,8,"PREVIOUS MARK",1,0,'C');
			$pdf->Cell(25,8,"AMENDED MARK",1,0,'L');
			$pdf->Cell(85,8,"REASON FOR AMENDMENT",1,0,'L');
			$pdf->Ln(8);

			$count=0;
			$matno="";
			$therepoline="";
			$matnofullnamegender="";
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$pdf->Cell(10,8,++$count,1,0,'L');
				$pdf->Cell(20,8,$regNumber,1,0,'L');
				$pdf->Cell(45,8,$lastName." ".$firstName,1,0,'L');
				$pdf->Cell(7,8,substr($gender,0,1),1,0,'L');
				$pdf->Cell(25,8,$coursecode,1,0,'C');
				$pdf->Cell(25,8,$previousmark,1,0,'C');
				$pdf->Cell(25,8,$amendedmark,1,0,'C');
				$pdf->Cell(85,8,$amendreason,1,0,'L');
				$pdf->Ln(8);
				if(($count % 10)==0){
					$pdf->AddPage();

					$pdf->Cell(10,8,"S/NO",1,0,'L');
					$pdf->Cell(20,8,"MATRIC NO",1,0,'L');
					$pdf->Cell(45,8,"FULL NAME",1,0,'L');
					$pdf->Cell(7,8,"SEX",1,0,'L');
					$pdf->Cell(25,8,"COURSE CODE",1,0,'C');
					$pdf->Cell(25,8,"PREVIOUS MARK",1,0,'C');
					$pdf->Cell(25,8,"AMENDED MARK",1,0,'L');
					$pdf->Cell(85,8,"REASON FOR AMENDMENT",1,0,'L');
					$pdf->Ln(8);
				}
			}
			$pdf->Output();
		}
	}
	displayAmendedResults($sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear,$groupsessions);*/

?>
