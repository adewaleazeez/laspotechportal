<?php
	if($_COOKIE["currentuser"]==null || $_COOKIE["currentuser"]==""){
		echo '<script>alert("You must login to access this page!!!\n Click Ok to return to Login page.");</script>';
		echo '<script>window.location = "login.php";</script>';
		return true;
	}
//echo date("Y-m-d H:i:s")." 1<br> <br>";
	global $sessionss;
	$sessionss = trim($_GET['sessions']);
	if($sessionss == null) $sessionss = "";

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

	global $finalyear;
	$finalyear = trim($_GET['finalyear']);
	if($finalyear == null) $finalyear = "";

	global $resultype;
	$resultype = trim($_GET['resultype']);
	if($resultype == null) $resultype = "";

	global $modes;
	$modes = trim($_GET['mode']);
	if($modes == null) $modes = "";

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

	function getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		$resultype = $GLOBALS['resultype'];
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$matno}' and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by serialno, right(coursecode,3) desc, left(coursecode,3) ";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; $row7=0;
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' ";
				//and groupsession='{$groupsessions}' 
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0) $tnup += $row2[1];
				}
			}
		}
		$str="";
		if($tnu>0) $gpa += number_format(($tcp/$tnu),2);
		$str = $tcp ."][". $tnu ."][". $gpa ."][". $tnup;
		return $str;
	}

	function getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		//, $groupsessions
		$resultype = $GLOBALS['resultype'];
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and ((sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$matno}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$matno}' and studentlevel<= '{$studentlevels}') and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by serialno, right(coursecode,3) desc, left(coursecode,3)";
		$programmecodes = $GLOBALS['programmecodes'];
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; $row7=0;
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' and studentlevel='{$row[8]}' "; 
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0) $tnup += $row2[1];
				}
			}
		}
		$str="";
		if($tnu>0) $gpa += number_format(($tcp/$tnu),2);
		$str = $tcp ."][". $tnu ."][". $gpa ."][". $tnup;
//echo $str."    getPreviousGPA<br>";
		return $str;
	}

	$query = "delete from remarkstable";
	mysql_query($query, $connection);

	function getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $regno, $finalyear, $cgpa, $ctnup){
		$resultype = $GLOBALS['resultype'];
		include("data.php"); 

//if($regno!="086141006") return "";

//echo date("Y-m-d H:i:s")."   $regno   <br> <br>";

		$query = "SELECT remark from remarkstable where matricno='{$regno}' ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
			}
			 return $remark;
		}

		$query = "SELECT min(sessions) as firstsession FROM registration where regNumber='{$regno}'  ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

		$query = "SELECT admissiontype FROM regularstudents where regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
			}
		}

		$query = "select max(minimumscore) as minimumscore from coursestable where  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

		$query2 = "SELECT carryover, admissiontype FROM regularstudents  where regNumber='{$regno}' ";
//echo date("Y-m-d H:i:s")."   $query2   <br> <br>";
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
				$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and marksobtained>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result)==0){
					if(!str_in_str($failedcourses,$parameters[$t])) 
						$failedcourses .= $parameters[$t]."~".$minimumscore."][";
				}
			}
		}
//echo $failedcourses." 3 $regno<br><br>";

		if($firstsession>""){
			$query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM coursestable a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Required', 'Compulsory') and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' order by a.serialno, a.coursecode ";
//echo date("Y-m-d H:i:s")."   $query2   <br> <br>";
			$result2 = mysql_query($query2, $connection);
			$usedcourse="";
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				if(str_in_str($usedcourse,$row2[0])) continue;
				$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
//if($regno=="09087038") echo $query."<br><br>";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result)==0){
					if(!str_in_str($failedcourses,$row2[0])){
						$failedcourses .= $row2[0]."~".$row2[2]."][";
					}
				}
				$usedcourse .=  $row2[0];
			}
		}		
//echo $failedcourses." 4 $regno<br><br>";

//if($regno=='CSB0730485') echo $failedcourses." 4 $regno<br><br>";
		if($firstsession>""){
			$foundflag=false;
			$electivegroup="Group 1][Group 2][Group 3][Group 4][Group 5";
			$electivegroups = explode("][", $electivegroup);
			foreach($electivegroups as $groupcode){
				$query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM coursestable a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Elective') and a.coursetypegroup='{$groupcode}' and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' order by a.serialno, a.coursecode ";
//echo date("Y-m-d H:i:s")."   $query2   <br> <br>";
				$result2 = mysql_query($query2, $connection);
				$mycounter=0;
				$usedcourse="";
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					if(str_in_str($usedcourse,$row2[0])) continue;
					$mycounter++;

					$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
//if($regno=='CSB0730485') echo $query." 3 $regno<br><br>";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						$query3 = "SELECT b.*, a.minimumscore FROM coursestable a, retakecourses b  where ((b.sessiondescription='{$sessionss}' and b.semester='{$semesters}') or (b.sessiondescription='{$sessionss}' and b.semester<'{$semesters}') or (b.sessiondescription<'{$sessionss}')) and b.sessiondescription>='{$firstsession}' and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and a.coursetype='Elective'  and a.studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}' ) and b.coursestatus='Ignore PCE'";
//echo date("Y-m-d H:i:s")."   $query3   <br> <br>";
						//and b.groupsession='{$groupsessions}' 
//if($regno=='CSB0730485') echo $query3." 3 $regno<br><br>";
						$result3 = mysql_query($query3, $connection);
						if(mysql_num_rows($result3)==0){
							if(!str_in_str($failedcourses,$row2[0])){

								// Check if course is attempted, if yes, record it
								$query4 = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
//echo date("Y-m-d H:i:s")."   $query4   <br> <br>";
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
					$usedcourse .=  $row2[0];
				}
			}
		}		

//if($regno=='CSB0730485') echo $failedcourses." 5 $regno<br><br>";
//echo $failedcourses." 4 $regno<br><br>";
		$remarks="";
		if($failedcourses>""){
			if($failedcourses!="") 
				$failedcourses = substr($failedcourses, 0, strlen($failedcourses)-2);
			$splitfailedcourses = explode("][", $failedcourses);
			foreach($splitfailedcourses as $code){
				$minimumscore = explode("~", $code);
				$query2 = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
//echo date("Y-m-d H:i:s")."   $query2   <br> <br>";
				//and groupsession='{$groupsessions}' 
				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2) == 0 && !str_in_str($remarks,$minimumscore[0])) 
					$remarks .= $minimumscore[0].",  ";
			}
		}
		if($remarks!="") $remarks = substr($remarks, 0, strlen($remarks)-3);
		
		if($finalyear=="Yes" || str_in_str($studentlevels,"NDIII") || str_in_str($studentlevels,"HNDIII")){
			if($remarks==""){
				$query = "SELECT minimumunit FROM regularstudents where  regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
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
					$query = "SELECT min(qualificationcode) as qualification FROM regularstudents where regNumber='{$regno}' ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
						}
					}
					$query = "SELECT * FROM cgpatable where {$cgpa}>=lowerrange and {$cgpa}<=upperrange and sessions='{$sessionss}' and qualification='{$qualification}'";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
							if($remarks=="") $remarks = "Passed, ".$cgpacode;
						}
					}
				}
			}
		}else{
			if($remarks=="") $remarks="Passed";
			if($firstsession=="")  $remarks="DID NOT SIT FOR EXAM";
		}

		//if($remarks=="Passed"){
		if(str_in_str($remarks,"Passed")){
			$remarks="NR";
		}else{
//if($regno=="086141001") echo $remarks;
			$remarks = explode(", ", $remarks);
			$remarks = "R".trim(count($remarks));
		}
		$str = $remarks."][";
		$query = "insert into remarkstable (matricno, remark) values ('{$regno}','{$str}')";
		mysql_query($query, $connection);

//echo date("Y-m-d H:i:s")."     $regno     <br> <br>";
//echo "------------------------------------------------------------------------------------------------------------    <br> <br><br> <br>";
		return $str;
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

			$sessionss = $GLOBALS['sessionss'];
			$semesters = $GLOBALS['semesters'];
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];
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

			$coursecodes="";
			$noofcourses=0;
			$query = "SELECT distinct coursecode, coursetype FROM coursestable where (sessiondescription='{$sessionss}' and semesterdescription='{$semesters}') and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'  order by serialno, right(coursecode,3) desc, left(coursecode,3)";
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
//echo $coursecodes."<br><br>" ;
			
			$thecol = 90+count($GLOBALS['thecoursecodes'])*7;
			if($thecol<330) $thecol=330;

			$this->Image('images\Schoologo.png',10,10,20,20);

			$query = "SELECT min(a.qualificationcode) as qualification FROM regularstudents a, registration b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
			}

			$this->SetFont('Times','B',5.5);
			//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			$currentY=$this->GetY();
			$this->SetX($this->GetX()+30);
			$this->Cell(75,5,'GRADES TABLE',0,0,'C');
			$this->Ln();
			$query = "SELECT * FROM gradestable where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$this->SetX($this->GetX()+30);
				$this->Cell(20,3,"MARKS RANGE",1,0,'C');
				$this->Cell(20,3,"LETTER GRADE",1,0,'C');
				$this->Cell(20,3,"GRADE POINT",1,0,'C');
				$this->Ln();
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$this->SetX($this->GetX()+30);
					$this->Cell(20,3,$lowerrange."% - ".$upperrange."%",1,0,'C');
					$this->Cell(20,3,$gradecode,1,0,'C');
					$this->Cell(20,3,number_format($gradeunit,2),1,0,'C');
					$this->Ln();
				}
			}
			$this->Ln(2);

			$this->SetY($currentY);
			//$this->SetX($this->GetX()+95);
			$this->SetFont('Times','B',10);
			$this->Cell($thecol,7,$schoolnames,0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,"SCHOOL OF ".$facultycodes,0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,"DEPARTMENT OF ".$departmentcodes,0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,$programmecodes." PROGRAMME",0,0,'C');
			$this->Ln();
			$this->Cell($thecol,7,$sessionss." ".$semesters." Semester Examination Results",0,0,'C');
			$this->Ln();
			if($resultype=="Repeaters Results"){
				$this->Cell($thecol,7,"REPEATERS SPREAD SHEET",0,0,'C');
				$this->Ln();
			}else{
				$this->Cell($thecol,7,"SPREAD SHEET",0,0,'C');
				$this->Ln();
			}
			$this->Cell($thecol,7,$studentlevels,0,0,'C');
			$this->Ln(2);

			if(str_in_str($studentlevels,"III") && $semesters=="2ND"){
				$this->SetFont('Times','B',5.5);
				$this->SetY($currentY);
				$this->SetX($this->GetX()+225);
				$this->Cell(45,5,'CUMMULATIVE GRADE POINT AVERAGE (CGPA)',0,0,'C');
				$this->Ln();
				$query = "SELECT * FROM CGPAtable where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					$this->SetX($this->GetX()+225);
					$this->Cell(25,5,"CLASSIFICATION",1,0,'L');
					$this->Cell(20,5,"RANGE",1,0,'C');
					$this->Ln();
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						$this->SetX($this->GetX()+225);
						$this->Cell(25,5,$cgpacode,1,0,'L');
						$this->Cell(20,5,number_format($lowerrange,2)." - ".number_format($upperrange,2),1,0,'C');
						$this->Ln();
					}
				}
				$this->Ln(13);
			}else{
				$this->Ln(4);
			}
		
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

		function coursesheader($pagecounter,$colstoprintnow,$coursesperline,$mergesummaryheader){
			include("data.php"); 

			$thecoursecodes = $GLOBALS['thecoursecodes'];
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];
			$sessionss = $GLOBALS['sessionss'];
			$semesters = $GLOBALS['semesters'];

			$this->SetFont('Times','B',7.5);
			$this->Cell(10,8,"S/NO",1,0,'C');
			$this->Cell(17,8,"MATRIC NO",1,0,'C');
			$this->Cell(60,8,"FULL NAME",1,0,'L');
			$this->Cell($colstoprintnow*7*3,8,"COURSES",1,0,'C');
			$this->Ln();
			
			$ycoordinate =  $this->GetY();
			$xcoordinate =  $this->GetX()+87;
			$this->Cell(10,5," ",'LR',0,'R');
			$this->Cell(17,5," ",'LR',0,'L');
			$this->Cell(60,5," COURSES",'LR',1,'R');

			$this->Cell(10,5," ",'LR',0,'R');
			$this->Cell(17,5," ",'LR',0,'L');
			$this->Cell(60,5," CODES",'LR',1,'R');

			$this->Cell(10,5," ",'LR',0,'R');
			$this->Cell(17,5," ",'LR',0,'L');
			$this->Cell(60,5," CREDIT UNITS",'LR',1,'R');

			$this->Cell(10,5," ",'LR',0,'R');
			$this->Cell(17,5," ",'LR',0,'L');
			$this->Cell(60,5," ",'LR',1,'R');

			$this->SetY($ycoordinate);
			$this->SetX($xcoordinate);

			$startcol = (($pagecounter - 1) * $coursesperline) + 1;
			$counter1 = 0;
			$counter2 = 0;
			
			$ycoordinate =  $this->GetY();
			$xcoordinate =  $this->GetX();
			foreach($thecoursecodes as $code){
				$query = "SELECT * FROM coursestable where coursecode='{$code}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semesterdescription='{$semesters}' ";
				$result = mysql_query($query, $connection);
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$counter1++;
					if($counter1>=$startcol && ++$counter2<=$colstoprintnow){
						$codes = explode(" ",$code);
						$ycoordinate =  $this->GetY();
						$xcoordinate =  $this->GetX();
						$this->Cell(7*3,5,$codes[0],"LTR",2,'C');
						$this->Cell(7*3,5,$codes[1],"LR",2,'C');
						//$this->Cell(7*3,5,"(".$row[3].")","LBR",2,'C');
						$this->Cell(7*3,5,$row[3],"LBR",2,'C');
						$this->Cell(7,5,"S",1,0,'C');
						$this->Cell(7,5,"G",1,0,'C');
						$this->Cell(7,5,"GP",1,0,'C');
						$this->SetY($ycoordinate);
						$this->SetX($xcoordinate+(7*3));
					}
				}
			}
			if($colstoprintnow<=5){
				$this->SetY($ycoordinate+2);

				$this->Cell(10,20," ",0,0,'R');
				$this->Cell(17,20," ",0,0,'L');
				$this->Cell(60,20," ",0,0,'L');
				for($c=1; $c<=$colstoprintnow; $c++){
					$this->Cell(7,5,"",0,0,'C');
					$this->Cell(7,5,"",0,0,'C');
					$this->Cell(7,5,"",0,0,'C');
				}
				$this->Cell(21,5,"SEMESTER ","LTR",0,'C');
				if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
					$this->Cell(21,5,"PREVIOUS","LTR",0,'C');
				}
				$this->Cell(21,5,"CURRENT","LTR",0,'C');
				$this->Ln();

				$this->Cell(10,20," ",0,0,'R');
				$this->Cell(17,20," ",0,0,'L');
				$this->Cell(60,20," ",0,0,'L');
				for($c=1; $c<=$colstoprintnow; $c++){
					$this->Cell(7,5,"",0,0,'C');
					$this->Cell(7,5,"",0,0,'C');
					$this->Cell(7,5,"",0,0,'C');
				}
				$this->Cell(21,5,"RECORD","LBR",0,'C');
				if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
					$this->Cell(21,5,"CUMULATIVE","LBR",0,'C');
				}
				$this->Cell(21,5,"CUMULATIVE","LBR",0,'C');
				$this->Ln();

				$this->Cell(10,20," ",0,0,'R');
				$this->Cell(17,20," ",0,0,'L');
				$this->Cell(60,20," ",0,0,'L');
				for($c=1; $c<=$colstoprintnow; $c++){
					$this->Cell(7,5,"",0,0,'C');
					$this->Cell(7,5,"",0,0,'C');
					$this->Cell(7,5,"",0,0,'C');
				}
				$this->Cell(7,8,"SGP",1,0,'C');
				$this->Cell(7,8,"SCH",1,0,'C');
				$this->Cell(7,8,"SGPA",1,0,'C');
				if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
					$this->Cell(7,8,"SGP",1,0,'C');
					$this->Cell(7,8,"SCH",1,0,'C');
					$this->Cell(7,8,"SGPA",1,0,'C');
				}
				$this->Cell(7,8,"SGP",1,0,'C');
				$this->Cell(7,8,"SCH",1,0,'C');
				$this->Cell(7,8,"SGPA",1,0,'C');
				$this->Cell(17,8,"REMARKS",1,0,'C');
				$this->SetY($ycoordinate);
				$this->SetX($xcoordinate+($colstoprintnow*7*3));
			}
			$this->Ln(20);
		}

		function printsummaryheader(){
			$this->SetFont('Times','B',7.5);
			$this->Cell(10,5,"",0,0,'R');
			$this->Cell(17,5,"",0,0,'L');
			$this->Cell(60,5,"",0,0,'L');
			$this->Cell(21,5,"SEMESTER","LTR",0,'C');
			if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
				$this->Cell(21,5,"PREVIOUS","LTR",0,'C');
			}
			$this->Cell(21,5,"CURRENT","LTR",0,'C');
			$this->Cell(15,5,"",0,0,'L');
			$this->Ln();
			$this->Cell(10,5,"",0,0,'R');
			$this->Cell(17,5,"",0,0,'L');
			$this->Cell(60,5,"",0,0,'L');
			$this->Cell(21,5,"RECORD","LBR",0,'C');
			if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
				$this->Cell(21,5,"CUMULATIVE","LBR",0,'C');
			}
			$this->Cell(21,5,"CUMULATIVE","LBR",0,'C');
			$this->Cell(15,5,"",0,0,'L');
			$this->Ln();
			$this->Cell(10,8,"S/NO",1,0,'C');
			$this->Cell(17,8,"MATRIC NO",1,0,'C');
			$this->Cell(60,8,"FULL NAME",1,0,'L');
			$this->Cell(7,8,"SGP",1,0,'C');
			$this->Cell(7,8,"SCH",1,0,'C');
			$this->Cell(7,8,"SGPA",1,0,'C');
			if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
				$this->Cell(7,8,"SGP",1,0,'C');
				$this->Cell(7,8,"SCH",1,0,'C');
				$this->Cell(7,8,"SGPA",1,0,'C');
			}
			$this->Cell(7,8,"SGP",1,0,'C');
			$this->Cell(7,8,"SCH",1,0,'C');
			$this->Cell(7,8,"SGPA",1,0,'C');
			$this->Cell(17,8,"REMARKS",1,0,'C');
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

	$facultycodes = $GLOBALS['facultycodes'];
	$departmentcodes = $GLOBALS['departmentcodes'];
	$programmecodes = $GLOBALS['programmecodes'];
	$studentlevels = $GLOBALS['studentlevels'];
	$sessionss = $GLOBALS['sessionss'];
	$semesters = $GLOBALS['semesters'];

	$pagecount=0;
	$tempagecount=1;
	$startpage=1;
	$studentsperpage=20;
	$coursesperline=9;
	$coursesonlinecounter=0;
	$studentscounter=0;
	$reportline="";
	$studentdetail="";
	$tempstudentdetail="";
	$longstudentdetail="";
	$dltstudents="";

	$modes = $GLOBALS['modes'];
//echo date("Y-m-d H:i:s")." 2   $modes<br> <br>";
	if($modes=="process"){
		$details="";
		$summary="";
		$details2="";
		$summary2="";

		$query = "SELECT distinct a.*, b.regNumber, b.regNumber, b.studentlevel, b.sessions, b.semester FROM regularstudents AS a JOIN registration AS b ON a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes'  order by a.regNumber";
//echo $query;
		$result = mysql_query($query, $connection);
		$absentstudent="";
		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$queryD = "SELECT min(sessions) as firstsession FROM registration where regNumber='{$regNumber}'  ";
			$resultD = mysql_query($queryD, $connection);
			extract (mysql_fetch_array($resultD));

			$queryD = "SELECT b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.regNumber='{$regNumber}' and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' order by b.sessions, b.semester";
//echo  date("Y-m-d H:i:s")."    <br>$queryD    <br> <br>";
			$resultD = mysql_query($queryD, $connection);
			$thecounter=0;
			$remarkprob="";
			$remarkdnr="";
			if(mysql_num_rows($resultD) > 0){
//echo "----------------------- <br>";
				while ($rowD = mysql_fetch_array($resultD)) {
					extract ($rowD);
					$thecounter++;
					$thegpa = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevel, $sessions, $semester, $regNumber);
					$theCurGPs = explode("][", $thegpa);
//echo $thecounter."  ".number_format($theCurGPs[2],2)."  ".$remarkprob."   $sessions  $semester<br>";
					/*if(intval(number_format($theCurGPs[2],2))<2){
						if($thecounter==1){
							if(intval(number_format($theCurGPs[2],2))<2) $remarkprob="P1";
						}else if($thecounter==2){
							if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
								$remarkprob="P1";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
								$remarkprob="P2";
							}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
								$remarkprob="P2TW";
							}
						}else if($thecounter==3){
							if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
								$remarkprob="P1";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
								$remarkprob="P2";
							}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
								$remarkprob="P2TW";
							}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P2") {
								$remarkprob="P3TW";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P2") {
								$remarkprob="P3TW";
							}
						}else if($thecounter>=4 && str_in_str($remarkprob,"TW")){
							$remarkprob="DLT";
							$dltstudents .= $regNumber."][";
						}
					}else if($thecounter==12){
						$remarkprob="TW";
					}else if($thecounter>12){
							$remarkprob="DLT";
							$dltstudents .= $regNumber."][";
					}else{
						$remarkprob="";
					}*/
					if(str_in_str($remarkprob,"TW")){
						$remarkprob="DLT";
						$dltstudents .= $regNumber."][";
					}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
						$remarkprob="P1";
					}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
						$remarkprob="P2";
					}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
						$remarkprob="P2TW";
					}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P2") {
						$remarkprob="P3TW";
					}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P2") {
						$remarkprob="P3TW";
					}else{
						$remarkprob="";
					}
//echo $regNumber."  ".$thecounter."  ".number_format($theCurGPs[2],2)."  ".$remarkprob."   $sessions  $semester<br><br>";
					/*if($registered!="Yes"){
						if($thecounter==2){
							$remarkdnr="DNR1";
						}else if($thecounter==3){
							if($remarkdnr=="DNR1") $remarkdnr="DNR2";
						}else if($thecounter==4){
							if($remarkdnr=="DNR2") $remarkdnr="DNR3VW";
						}else if($thecounter>=5 && str_in_str($remarkdnr,"VW")){
							$remarkdnr="DLT";
							$dltstudents .= $regNumber."][";
						}
					}else{
						$remarkdnr="";
					}*/
					if($registered!="Yes" && $thecounter>=2){
						if($remarkdnr==""){
							$remarkdnr="DNR1";
						}else if($remarkdnr=="DNR1"){
							$remarkdnr="DNR2";
						}else if($remarkdnr=="DNR2"){
							$remarkdnr="DNR3VW";
						}else if(str_in_str($remarkdnr,"VW")){
							$remarkdnr="DLT";
							//$dltstudents .= $regNumber."][";
						}
					}else{
						$remarkdnr="";
					}
					if($sesionsreabsurption==$sessionss) $remarkdnr="";
				}
			}

			$queryE = "SELECT min(sessiondescription) as firstsession FROM finalresultstable where registrationnumber='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
			$resultE = mysql_query($queryE, $connection);
			extract (mysql_fetch_array($resultE));

			$queryE = "SELECT * FROM sessionstable order by sessiondescription desc, semesterdescription desc";
			$resultE = mysql_query($queryE, $connection);
			$sessionss2="";
			$semesters2="";
			$flag=0;
			while ($rowE = mysql_fetch_array($resultE)) {
				extract ($rowE);
				if($sessiondescription==$sessionss && $semesterdescription==$semesters){
					$flag=1;
					continue;
				}
				if($flag==1){
					if($sessiondescription<$firstsession){
						$sessionss2=$sessionss;
						$semesters2=$semesters;
					}else{
						$sessionss2=$sessiondescription;
						$semesters2=$semesterdescription;
					}
					break;
				}
			}
			$query2="SELECT * FROM registration where sessions='{$sessionss}' and semester='{$semesters}' and regNumber='{$regNumber}' and registered='Yes' ";
//if($regNumber=='106021357' || $regNumber=='106021372' || $regNumber=='106021377' || $regNumber=='106021380') echo $query2."<br>";
			$result2 = mysql_query($query2, $connection);
			if(mysql_num_rows($result2) > 0){
				$query4 = "SELECT *  FROM finalresultstable where sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$regNumber}'";
//if($regNumber=='106021357' || $regNumber=='106021372' || $regNumber=='106021377' || $regNumber=='106021380') echo $query4."<br>";
				$result4 = mysql_query($query4, $connection);
				if(mysql_num_rows($result4)==0){
					$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT SIT FOR EXAM";
				}
			}else{
				$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER";
			}
		}

//echo $absentstudent."<br>";
// 357, 372, 377, 380
		$absentstudents = explode("!!!", $absentstudent);
		$absentcounter=0;

		$dltstudents = substr($dltstudents, 0, strlen($dltstudents)-2);
		$dltstudents = "'".str_replace("][", "','", $dltstudents)."'";
//echo $dltstudents."<br><br>";
		$queryAll = "SELECT a.*, b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes' and a.active='Yes' and a.regNumber not in ($dltstudents) order by a.regNumber";
//echo $queryAll."<br><br>" ;
		$resultAll = mysql_query($queryAll, $connection);
		$count=1;
		$matno="";
		$thecoursecodes = $GLOBALS['thecoursecodes'];
		while ($rowAll = mysql_fetch_array($resultAll)) {
			extract ($rowAll);

			$matno=$rowAll[1];
			$fullname = strtoupper($rowAll[3]).", ".$rowAll[2];
			if($rowAll[11]>"") $fullname .= " ".$rowAll[11];
			$tempstudentdetail=$studentdetail;
			$studentdetail=$count++."._~_10!~~!".$rowAll[1]."_~_17!~~!".substr($fullname,0,27)."_~_60!~~!"; //.substr($rowAll[7],0,1)."_~_7!~~!";
			$tempstudentdetail=$studentdetail;
			$studentscounter++;
			if((($studentscounter-1) % $studentsperpage)==0 && $studentscounter>0) $startpage=$tempagecount;
			$pagecount=$startpage;
			$details .= substr($fullname,0,27)."_~_60!~~!"; //.substr($rowAll[4],0,1)."_~_7!~~!";

			$cgpa = 0; $ctnup = 0;
			$query = "SELECT a.*, b.serialno FROM finalresultstable a, coursestable b where (a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.sessiondescription='{$sessionss}' and a.semester='{$semesters}' and a.registrationnumber='{$rowAll[1]}' and a.studentlevel='{$studentlevels}' and b.facultycode='{$facultycodes}' and b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.sessiondescription='{$sessionss}' and b.semesterdescription='{$semesters}') and a.coursecode=b.coursecode order by b.serialno, right(a.coursecode,3) desc, left(a.coursecode,3)";
//echo "$query----------------------- <br><br><br>";
			$result = mysql_query($query, $connection);
//echo $query."<br><br>";
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);

					$score="";
					foreach($thecoursecodes as $code){
//echo $registrationnumber."  -  ".$row[3]."  -  ".strlen($row[3])."  -  ".$code."  -  ".strlen($code)."<br>";
						if(trim($row[3])==trim($code)){
							$score = $row[5]."~~_".$row[6]."~~_".number_format($row[14],2);
							if($row[5]==0 || $row[5]==null){
								if($row[10]=="Sick"){
									$score = "S~~_".$row[6]."~~_".number_format($row[14],2);
								}else if($row[10]=="Absent"){
									$score = "ABS~~_".$row[6]."~~_".number_format($row[14],2);
								}else if($row[10]=="Did Not Register"){
									$score = "DNR~~_".$row[6]."~~_".number_format($row[14],2);
								}else if($row[10]=="Incomplete"){
									$score = "I~~_".$row[6]."~~_".number_format($row[14],2);
								}else{
									$score = "00~~_".$row[6]."~~_".number_format($row[14],2);
								}
							}
//echo $studentdetail."  -  ".$registrationnumber."<br>";
							$row = mysql_fetch_array($result);
						}else{
							$score="~~_~~_";
						}
						$studentdetail .= $score."_~_7!~~!";
						if((++$coursesonlinecounter)==$coursesperline){
							$coursesonlinecounter=0;

//echo $dltstudents."  -  ".$registrationnumber."<br>";
					
							//if(str_in_str($dltstudents,$registrationnumber)) continue;
							++$pagecount;
							$repline = substr("00000", 0, 5-strlen($pagecount)).$pagecount."[]".$registrationnumber."][".$studentdetail."~!!~";
							$longstudentdetail .= $repline;
//echo $longstudentdetail."  -  ".$row[3]."  -  ".$code."  -  ".$row[5]."  -  ".$row[6]."<br>";
							$studentdetail = $tempstudentdetail;
						}
					}
//echo $studentdetail."  -  ".$registrationnumber."<br><br>";
					
					if($coursesonlinecounter>5){
//echo $dltstudents."  -  ".$registrationnumber."<br>";;
						//if(str_in_str($dltstudents,$registrationnumber)) continue;
						++$pagecount;
						$repline = substr("00000", 0, 5-strlen($pagecount)).$pagecount."[]".$registrationnumber."][".$studentdetail."~!!~";
						$longstudentdetail .= $repline;
						$studentdetail = $tempstudentdetail;
					}
					$coursesonlinecounter=0;

					$matno=$registrationnumber;
					$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$theCurGPs = explode("][", $curGP);
					$studentdetail .=  number_format($theCurGPs[0],2)."_~_7!~~!".$theCurGPs[1]."_~_7!~~!";
					$studentdetail .=  number_format($theCurGPs[2],2)."_~_7!~~!";

					$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
					$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
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
					if($tcp==null) $tcp=0;
					if($tnu==null) $tnu=0;
					if($gpa==null) $gpa=0;
					if($tnup==null) $tnup=0;
					$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$thePreGPs = explode("][", $preGP);
					$studentdetail .=  number_format((doubleval($thePreGPs[0])+doubleval($tcp)),2)."_~_7!~~!";
					$studentdetail .=  (doubleval($thePreGPs[1])+doubleval($tnu))."_~_7!~~!";
					if(doubleval($thePreGPs[0])+doubleval($tcp)==0 || doubleval($thePreGPs[1])+doubleval($tnu)==0){
						$previousgp = 0;
					}else{
						$previousgp = ((doubleval($thePreGPs[0])+doubleval($tcp))/((doubleval($thePreGPs[1])+doubleval($tnu))));
					}
					$studentdetail .=  number_format($previousgp,2)."_~_7!~~!";
					if((($theCurGPs[0]+$thePreGPs[0]+$tcp)==0) || 
						(($theCurGPs[1]+$thePreGPs[1]+$tnu)==0)){
						$cgpa = 0;
					}else{
						$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
					}
					$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
					$studentdetail .=  number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp)),2)."_~_7!~~!";
					$studentdetail .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7!~~!";
					$studentdetail .=  number_format($cgpa,2)."_~_7!~~!"; //.$ctnup."_~_9!~~!";

					$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno, $finalyear, $cgpa, $ctnup);
//echo date("Y-m-d H:i:s")."   $remarks    $matno   <br> <br>";
//echo date("Y-m-d H:i:s")."   $remark    $regno  remark <br> <br>";
					$queryD = "SELECT min(sessions) as firstsession FROM registration where regNumber='{$regNumber}'  ";
					$resultD = mysql_query($queryD, $connection);
					extract (mysql_fetch_array($resultD));

					$queryD = "SELECT b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.regNumber='{$registrationnumber}' and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' order by b.sessions, b.semester";
					$resultD = mysql_query($queryD, $connection);
					$thecounter=0;
					$remarkprob="";
					$remarkdnr="";
					if(mysql_num_rows($resultD) > 0){
//echo "$queryD----------------------- <br><br><br>";
						while ($rowD = mysql_fetch_array($resultD)) {
							extract ($rowD);
							$thecounter++;
							$thegpa = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevel, $sessions, $semester, $regNumber);
							$theCurGPs = explode("][", $thegpa);
//echo $thecounter."  ".number_format($theCurGPs[2],2)."  ".$remarkprob."   $sessions  $semester<br>";
							/*if(intval(number_format($theCurGPs[2],2))<2){
								if($thecounter==1){
									if(intval(number_format($theCurGPs[2],2))<2) $remarkprob="P1";
								}else if($thecounter==2){
									if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
										$remarkprob="P1";
									}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
										$remarkprob="P2";
									}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
										$remarkprob="P2TW";
									}
								}else if($thecounter==3){
									if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
										$remarkprob="P1";
									}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
										$remarkprob="P2";
									}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
										$remarkprob="P2TW";
									}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P2") {
										$remarkprob="P3TW";
									}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P2") {
										$remarkprob="P3TW";
									}
								}else if($thecounter>=4 && str_in_str($remarkprob,"TW")){
									$remarkprob="DLT";
									//$dltstudents .= $regNumber."][";
								}
							}else if($thecounter==12){
								$remarkprob="TW";
							}else if($thecounter>12){
									$remarkprob="DLT";
									//$dltstudents .= $regNumber."][";
							}else{
								$remarkprob="";
							}*/
							if(str_in_str($remarkprob,"TW")){
								$remarkprob="DLT";
								$dltstudents .= $regNumber."][";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
								$remarkprob="P1";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
								$remarkprob="P2";
							}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
								$remarkprob="P2TW";
							}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P2") {
								$remarkprob="P3TW";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P2") {
								$remarkprob="P3TW";
							}else{
								$remarkprob="";
							}
//echo $thecounter."  ".number_format($theCurGPs[2],2)."  ".$remarkprob."   $sessions  $semester<br><br>";
							/*if($registered!="Yes"){
								if($thecounter==2){
									$remarkdnr="DNR1";
								}else if($thecounter==3){
									if($remarkdnr=="DNR1") $remarkdnr="DNR2";
								}else if($thecounter==4){
									if($remarkdnr=="DNR2") $remarkdnr="DNR3VW";
								}else if($thecounter>=5 && str_in_str($remarkdnr,"VW")){
									$remarkdnr="DLT";
									$dltstudents .= $regNumber."][";
								}
							}else{
								$remarkdnr="";
							}*/
							if($registered!="Yes" && $thecounter>=2){
								if($remarkdnr==""){
									$remarkdnr="DNR1";
								}else if($remarkdnr=="DNR1"){
									$remarkdnr="DNR2";
								}else if($remarkdnr=="DNR2"){
									$remarkdnr="DNR3VW";
								}else if(str_in_str($remarkdnr,"VW")){
									$remarkdnr="DLT";
									//$dltstudents .= $regNumber."][";
								}
							}else{
								$remarkdnr="";
							}
							if($sesionsreabsurption==$sessionss) $remarkdnr="";
						}
					}

					$remcol = 17;
					$remarks = explode("][", $remarks);
					$studentdetail .= $remarks[0]." ".$remarkprob." ".$remarkdnr."_~_$remcol";

//echo $dltstudents."  -  ".$registrationnumber."<br>";;
					//if(str_in_str($dltstudents,$registrationnumber)) continue;
					++$pagecount;
					$repline = substr("00000", 0, 5-strlen($pagecount)).$pagecount."[]".$registrationnumber."][".$studentdetail."~!!~";
					$longstudentdetail .= $repline;
					$tempagecount=$pagecount;
					$studentdetail = "";
				}
			}else{
				if(str_in_str($absentstudent,$rowAll[1])){
					$matno=$rowAll[1];
					
					$linesperstudent=intval(count($thecoursecodes) / $coursesperline);
					$extraline=count($thecoursecodes) % $coursesperline;
					$currentabsent="";
					for(;$absentcounter<count($absentstudents); ++$absentcounter){
						$currentabsent = explode("~~",$absentstudents[$absentcounter]);
						if($currentabsent[0] > $matno){
							$absentcounter=0;
							continue;
						}
						if($currentabsent[0]==$matno){
							break;
						}
					}
					for($counter=1; $counter<=$linesperstudent; $counter++){
						$studentdetail .= $currentabsent[3]."_~_".($coursesperline*7*3)."~!!~";

//echo $dltstudents."  -  ".$currentabsent[0]."<br>";;
						//if(str_in_str($dltstudents,$currentabsent[0])) continue;
						++$pagecount;
						$repline = substr("00000", 0, 5-strlen($pagecount)).$pagecount."[]".$currentabsent[0]."][".$studentdetail."~!!~";
						$longstudentdetail .= $repline;
						$studentdetail = $tempstudentdetail;
					}
					if($extraline>5){
						$studentdetail .= $currentabsent[3]."_~_".($extraline*7*3)."~!!~";

//echo $dltstudents."  -  ".$currentabsent[0]."<br>";;
						//if(str_in_str($dltstudents,$currentabsent[0])) continue;
						++$pagecount;
						$repline = substr("00000", 0, 5-strlen($pagecount)).$pagecount."[]".$currentabsent[0]."][".$studentdetail."~!!~";
						$longstudentdetail .= $repline;
						$studentdetail = $tempstudentdetail;
					}else{
						$studentdetail .= $currentabsent[3]."_~_".($extraline*7*3)."!~~!";
					}
	//echo $matno."     ".$linesperstudent."     ".$extraline."<br><br>";

					$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$theCurGPs = explode("][", $curGP);
					$studentdetail .=  $theCurGPs[0]."_~_7!~~!".$theCurGPs[1]."_~_7!~~!";
					$studentdetail .=  number_format($theCurGPs[2],2)."_~_7!~~!";

					$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
					$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";

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
					if($tcp==null) $tcp=0;
					if($tnu==null) $tnu=0;
					if($gpa==null) $gpa=0;
					if($tnup==null) $tnup=0;
					$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$thePreGPs = explode("][", $preGP);
					$studentdetail .=  (doubleval($thePreGPs[0])+doubleval($tcp))."_~_7!~~!";
					$studentdetail .=  (doubleval($thePreGPs[1])+doubleval($tnu))."_~_7!~~!";
					if(doubleval($thePreGPs[0])+doubleval($tcp)==0 || doubleval($thePreGPs[1])+doubleval($tnu)==0){
						$previousgp = 0;
					}else{
						$previousgp = ((doubleval($thePreGPs[0])+doubleval($tcp))/((doubleval($thePreGPs[1])+doubleval($tnu))));
					}
					$studentdetail .=  number_format($previousgp,2)."_~_7!~~!";
					if((($theCurGPs[0]+$thePreGPs[0]+$tcp)==0) || 
						(($theCurGPs[1]+$thePreGPs[1]+$tnu)==0)){
						$cgpa = 0;
					}else{
						$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
					}
					$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
					$studentdetail .=  (doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."_~_7!~~!";
					$studentdetail .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7!~~!";
					$studentdetail .=  number_format($cgpa,2)."_~_7!~~!"; //.$ctnup."_~_9!~~!";

					$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno, $finalyear, $cgpa, $ctnup);
//echo date("Y-m-d H:i:s")."   $remarks    $matno   <br> <br>";
					$queryD = "SELECT min(sessions) as firstsession FROM registration where regNumber='{$regNumber}'  ";
					$resultD = mysql_query($queryD, $connection);
					extract (mysql_fetch_array($resultD));

					$queryD = "SELECT b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.regNumber='{$regNumber}' and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' order by b.sessions, b.semester";
//echo $queryD."<br><br><br>";
					$resultD = mysql_query($queryD, $connection);
					$thecounter=0;
					$remarkprob="";
					$remarkdnr="";
					if(mysql_num_rows($resultD) > 0){
//echo "----------------------- <br>";
						while ($rowD = mysql_fetch_array($resultD)) {
							extract ($rowD);
							$thecounter++;
							$thegpa = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevel, $sessions, $semester, $regNumber);
							$theCurGPs = explode("][", $thegpa);
//if($regNumber=="086141009") echo $thecounter."  ".number_format($theCurGPs[2],2)."  ".$remarkprob."   $sessions  $semester<br>";
							/*if(intval(number_format($theCurGPs[2],2))<2){
								if($thecounter==1){
									if(intval(number_format($theCurGPs[2],2))<2) $remarkprob="P1";
								}else if($thecounter==2){
									if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
										$remarkprob="P1";
									}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
										$remarkprob="P2";
									}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
										$remarkprob="P2TW";
									}
								}else if($thecounter==3){
									if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
										$remarkprob="P1";
									}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
										$remarkprob="P2";
									}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
										$remarkprob="P2TW";
									}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P2") {
										$remarkprob="P3TW";
									}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P2") {
										$remarkprob="P3TW";
									}
								}else if($thecounter>=4 && str_in_str($remarkprob,"TW")){
									$remarkprob="DLT";
									//$dltstudents .= $regNumber."][";
								}
							}else if($thecounter==12){
								$remarkprob="TW";
							}else if($thecounter>12){
									$remarkprob="DLT";
									//$dltstudents .= $regNumber."][";
							}else{
								$remarkprob="";
							}*/
							if(str_in_str($remarkprob,"TW")){
								$remarkprob="DLT";
								$dltstudents .= $regNumber."][";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="") {
								$remarkprob="P1";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P1") {
								$remarkprob="P2";
							}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P1") {
								$remarkprob="P2TW";
							}else if(intval(number_format($theCurGPs[2],2))<1 && $remarkprob=="P2") {
								$remarkprob="P3TW";
							}else if(intval(number_format($theCurGPs[2],2))<2 && $remarkprob=="P2") {
								$remarkprob="P3TW";
							}else{
								$remarkprob="";
							}
//echo $thecounter."  ".number_format($theCurGPs[2],2)."  ".$remarkprob."   $sessions  $semester<br><br>";
							/*if($registered!="Yes"){
								if($thecounter==2){
									$remarkdnr="DNR1";
								}else if($thecounter==3){
									if($remarkdnr=="DNR1") $remarkdnr="DNR2";
								}else if($thecounter==4){
									if($remarkdnr=="DNR2") $remarkdnr="DNR3VW";
								}else if($thecounter>=5 && str_in_str($remarkdnr,"VW")){
									$remarkdnr="DLT";
									$dltstudents .= $regNumber."][";
								}
							}else{
								$remarkdnr="";
							}*/
							if($registered!="Yes" && $thecounter>=2){
								if($remarkdnr==""){
									$remarkdnr="DNR1";
								}else if($remarkdnr=="DNR1"){
									$remarkdnr="DNR2";
								}else if($remarkdnr=="DNR2"){
									$remarkdnr="DNR3VW";
								}else if(str_in_str($remarkdnr,"VW")){
									$remarkdnr="DLT";
									//$dltstudents .= $regNumber."][";
								}
							}else{
								$remarkdnr="";
							}
							if($sesionsreabsurption==$sessionss) $remarkdnr="";
						}
					}
					$remcol = 17;
					$remarks = explode("][", $remarks);
					$studentdetail .= $remarks[0]." ".$remarkprob." ".$remarkdnr."_~_$remcol";

//echo $dltstudents."  -  ".$currentabsent[0]."<br>";
					//if(str_in_str($dltstudents,$currentabsent[0])) continue;
					++$pagecount;
					$repline = substr("00000", 0, 5-strlen($pagecount)).$pagecount."[]".$currentabsent[0]."][".$studentdetail."~!!~";
					$longstudentdetail .= $repline;
					$tempagecount=$pagecount;
					$studentdetail = "";
				}
			}
		}
	}else{
		$query="select * from mastereportbackup where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and reportline not like '%DLT%'";
//echo $query;
		$result=mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(strlen(trim($reportline))>0) $longstudentdetail .= $reportline."~!!~";
		}
	}

//echo $longstudentdetail;
	$longstudentdetail = str_replace("~!!~~!!~", "~!!~", $longstudentdetail);
	$longstudentdetail = substr($longstudentdetail, 0, strlen($longstudentdetail)-4);
	$longstudentdetails = explode("~!!~", $longstudentdetail);
	$swap="";
	for($loop1=0; $loop1<count($longstudentdetails)-1; $loop1++){
		for($loop2=0; $loop2<count($longstudentdetails)-1; $loop2++){
			$first=explode("][", $longstudentdetails[$loop2]);
			$second=explode("][", $longstudentdetails[$loop2+1]);
			if($first[0]>$second[0]){
				$swap=$longstudentdetails[$loop2];
				$longstudentdetails[$loop2]=$longstudentdetails[$loop2+1];
				$longstudentdetails[$loop2+1]=$swap;
			}
		}
	}
	
	//for($loop1=0; $loop1<count($longstudentdetails); $loop1++){
	//	echo $longstudentdetails[$loop1]."<br><br>";
	//}
	
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','B',7.5);
		
	$height=5;
	$pagenumber=2;
	$lines=1;
	$thecoursecodes = $GLOBALS['thecoursecodes'];
	$pagecounter=1;
	$colstoprintnow=0;
	$mergesummaryheader=false;
	$pagestoprint=0;
	$pagestoprintA = 0;
	$pagestoprintB = 0;
	if(count($thecoursecodes)>=$coursesperline){
		$pagestoprintA = intval(count($thecoursecodes)/$coursesperline);
	}
	$colstoprintarray = "";
	for($counter=0; $counter<$pagestoprintA; $counter++) $colstoprintarray .= "~_~".$coursesperline;
	$pagestoprint = $pagestoprintA;
	$pagestoprintB = (count($thecoursecodes) % $coursesperline);
	if($pagestoprintB <= 5 && $pagestoprintB <> 0) {
		$pagestoprint++;
		$colstoprintarray .= "~_~".$pagestoprintB;
		$mergesummaryheader=true;
	}
	if($pagestoprintB > 5) {
		$pagestoprint++;
		$pagestoprint++;
		$colstoprintarray .= "~_~".$pagestoprintB;
		$colstoprintarray .= "~_~0";
	}
	if($pagestoprintB == 0) {
		$pagestoprint++;
		$colstoprintarray .= "~_~0";
	}
	
	$colstoprintarray = explode("~_~", $colstoprintarray);
	$colstoprintnow = intval($colstoprintarray[$pagecounter]);

	$modes = $GLOBALS['modes'];

	$pdf->coursesheader($pagecounter,$colstoprintnow,$coursesperline,$mergesummaryheader);

	if($modes=="process"){
		$query="delete from mastereportbackup where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' ";
		mysql_query($query, $connection);
	}

	foreach($longstudentdetails as $row){
		//$thecol = explode("][", $row);
		//$thereg = explode("[]", $thecol[0]);
		//if(str_in_str($dltstudents,$thereg[1])) continue;
		if($modes=="process"){
			$query="select reportline from mastereportbackup where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and reportline='{$row}' ";
			$result=mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				if(strlen(trim($row))>0){
					$query="insert into mastereportbackup (sessions, semester, facultycode, departmentcode, programmecode, studentlevel, reportline) values ('{$sessionss}', '{$semesters}', '{$facultycodes}', '{$departmentcodes}', '{$programmecodes}', '{$studentlevels}', '{$row}' )";
					mysql_query($query, $connection);
				}else{
					$query="UPDATE mastereportbackup SET sessions='{$sessionss}', semester='{$semesters}', facultycode='{$facultycodes}', departmentcode='{$departmentcodes}', programmecode='{$programmecodes}', studentlevel='{$studentlevels}', reportline='{$row}' ";
					mysql_query($query, $connection);
					//continue;
				}
			}
		}
		$detail = explode("][", $row);
		$pagenum = explode("[]", $detail[0]);
//echo intval($pagenum[0])." - ".$pagenumber."<br>";
		if(intval($pagenum[0])>$pagenumber){
			$pagenumber=intval($pagenum[0]);
			$pdf->AddPage();
			$pagecounter++;
			if($pagecounter>$pagestoprint) $pagecounter = 1;
			$colstoprintnow = intval($colstoprintarray[$pagecounter]);

			if($colstoprintnow==0){
				$pdf->printsummaryheader();
			}else{
				$pdf->coursesheader($pagecounter,$colstoprintnow,$coursesperline,$mergesummaryheader);
			}
		}

		if((substr($detail[1], strlen($detail[1])-4, strlen($detail[1])))=="!~~!")
			$detail[1] = substr($detail[1], 0, strlen($detail[1])-4);
		$details = explode("!~~!", $detail[1]);

		$theregno = explode("_~_", $details[1]);

		$thecount=0;
		foreach($details as $col){
			$mycol = explode("_~_", $col);
			$thecount++;
			
			if(str_in_str($mycol[0],"DID NOT SIT FOR EXAM") || str_in_str($mycol[0],"DID NOT REGISTER")){
				if($colstoprintnow==0){
					$mycol[0]="";
				}else if($colstoprintnow==1){
					$mycol[0]="ABSENT";
					$pdf->Cell($colstoprintnow * 7 * 3,$height,$mycol[0],1,0,'C');
				}else{
					$pdf->Cell($colstoprintnow * 7 * 3,$height,$mycol[0],1,0,'C');
				}
			}else if(str_in_str($mycol[0],"~~_")){
				$mycol1 = explode("~~_",$mycol[0]);
				$pdf->Cell(7,$height,$mycol1[0],1,0,'C');
				$pdf->Cell(7,$height,$mycol1[1],1,0,'C');
				$pdf->Cell(7,$height,$mycol1[2],1,0,'C');
			}else if($thecount==1){
				$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'C');
			}else if($thecount==2){
				$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'C');
			}else if($thecount==3){
				$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'L');
			}else{
				//$pdf->Cell(intval($mycol[1]),$height * $lines,($mycol[0]=="0") ? " " : $mycol[0],1,0,'C');
				if(($thecount==count($details)-4 || $thecount==count($details)-5 || $thecount==count($details)-6) && ($studentlevels=="HNDI" || $studentlevels=="NDI") && $semesters=="1ST") {
					//$pdf->Cell(intval($mycol[1]),$height * $lines,"",1,0,'C');
				}else{
					$pdf->Cell(intval($mycol[1]),$height * $lines,$mycol[0],1,0,'C');
				}
				//$pdf->Cell(intval($mycol[1])+40,$height * $lines,'A'.$details[$thecount-2]."  B".$details[$thecount-1]."  C".$mycol[0]."  D".$details[$thecount],1,0,'C');
			}
		}
		$pdf->Ln($height);
	}


	/*if($pdf->GetY() <= 167){
		$pdf->Ln();
	}else{
		$pdf->AddPage();
	}

	$pdf->SetFont('Times','B',7.5);
	$pdf->Cell(170,6,"DESCRIPTION OF CODES AND CREDIT UNITS",1,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Times','B',9);

	$pdf->Cell(10,6,"S/No",1,0,'C');
	$pdf->Cell(30,6,"COURSE CODES",1,0,'C');
	$pdf->Cell(100,6,"COURSE TITLES",1,0,'L');
	$pdf->Cell(30,6,"CREDIT UNITS",1,0,'C');
	$pdf->Ln(6);

	$query = "SELECT * FROM coursestable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}'and semesterdescription='{$semesters}' order by a.serialno ";
	$result=mysql_query($query, $connection);
	$count=0;
	while ($row = mysql_fetch_array($result)) {
		extract ($row);
		$ycoordinate =  $pdf->GetY();
		$pdf->Cell(10,6,++$count,1,0,'C');
		$pdf->Cell(30,6,$coursecode,1,0,'C');
		$pdf->Cell(100,6,$coursedescription,1,0,'L');
		$pdf->Cell(30,6,number_format($courseunit,1),1,0,'C');
		if($pdf->GetY()>=178 && $count<mysql_fetch_array($result)){
			$pdf->AddPage();
			$pdf->Cell(140,6,"",0,1,'L');
			$pdf->SetFont('Times','B',7.5);
			$pdf->Cell(170,6,"LIST OF COURSES Continued........",1,0,'C');
			$pdf->Ln();
			$pdf->SetFont('Times','B',9);

			$pdf->Cell(10,6,"S/No",1,0,'C');
			$pdf->Cell(30,6,"COURSE CODES",1,0,'C');
			$pdf->Cell(100,6,"COURSE TITLES",1,0,'L');
			$pdf->Cell(30,6,"COURSE UNITS",1,0,'C');
			$pdf->Ln(6);
		}else{
			$pdf->Ln(6);
		}
	}

	$pdf->Ln();*/

	$pdf->Output();
?>
