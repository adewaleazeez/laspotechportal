<html>
    <title>Lagos State Polytechnic Portal Systems - Press Ctrl + P to Print</title>
    <head>
	    <!--meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"-->
    </head>
    <body>
<?php
	$sessions = trim($_GET['sessions']);
	if($sessions == null) $sessions = "";


	$semesters = trim($_GET['semester']);
	if($semesters == null) $semesters = "";

	$facultycodes = trim($_GET['facultycode']);
	if($facultycodes == null) $facultycodes = "";

	$departmentcodes = trim($_GET['departmentcode']);
	if($departmentcodes == null) $departmentcodes = "";

	$programmecodes = trim($_GET['programmecode']);
	if($programmecodes == null) $programmecodes = "";

	$studentlevels = trim($_GET['studentlevel']);
	if($studentlevels == null) $studentlevels = "";

	$finalyear = trim($_GET['finalyear']);
	if($finalyear == null) $finalyear = "";

	include("data.php");

	function getCurrentGPA($sessions,$semesters,$regno){
		$query = "SELECT * FROM finalresultstable where sessiondescription='{$sessions}' and semester='{$semesters}' and registrationnumber='{$regno}' order by right(coursecode,3) desc";
		include("data.php"); 
		$programmecodes = $GLOBALS['programmecodes'];
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$coursecode}' and programmecode='{$programmecodes}'";
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

	function getPreviousGPA($sessions,$semesters,$regno){
		$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sessions}' and semester<'{$semesters}') or (sessiondescription<'{$sessions}')) and registrationnumber='{$regno}' order by right(coursecode,3) desc";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$coursecode}'";
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

	function getRemarks($sesion,$semesters,$regno,$finalyear,$cgpa,$ctnup,$programmecodes){
		$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sesion}' and semester='{$semesters}') or (sessiondescription='{$sesion}' and semester<'{$semesters}') or (sessiondescription<'{$sesion}'))and registrationnumber='{$regno}' and marksobtained<40 order by right(coursecode,3) desc";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0;
		$failedcourses="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore, coursetype FROM coursestable where coursecode='{$coursecode}' and programmecode='{$programmecodes}'";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					if($marksobtained<$minimumscore && $coursetype!="Elective") $failedcourses .= $row2[0]."~".$minimumscore."][";
				}

			}
		}

		$query2 = "SELECT b.*, a.minimumscore FROM coursestable a, retakecourses b  where b.registrationnumber='{$regno}' and a.coursecode=b.coursecode ";
		$result2 = mysql_query($query2, $connection);
		while ($row2 = mysql_fetch_array($result2)) {
			extract ($row2);
			$query = "SELECT * FROM finalresultstable where registrationnumber='{$regno}' and  coursecode='{$row2[3]}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result)==0){
				if(!str_in_str($failedcourses,$row2[3])) 
					$failedcourses .= $row2[3]."~".$minimumscore."][";
			}
		}

		$remarks="";
		if($failedcourses>""){
			$splitfailedcourses = explode("][", $failedcourses);
			foreach($splitfailedcourses as $code){
				$minimumscore = explode("~", $code);
				if($minimumscore[0]==null || $minimumscore[0]=="") break;
				$query2 = "SELECT * FROM finalresultstable where coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}'";
				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2) == 0) $remarks .= $minimumscore[0].",  ";
			}
		}
		$remarks = substr($remarks, 0, strlen($remarks)-3);
		
		if($finalyear=="Yes"){
			$query = "SELECT minimumunit FROM regularstudents where  regNumber='{$regno}'";
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
		}else{
			if($remarks=="") $remarks="Passed";
		}
		return $remarks;
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

	function displayReport($repotype,$sessions,$semesters,$facultycodes,
		$departmentcodes,$programmecodes,$studentlevels,$finalyear){
		
		include("data.php"); 
		

		$reportline = array();
		
		$query = "SELECT b.*, a.*  FROM regularstudents AS a INNER JOIN finalresultstable AS b 
		ON (a.regNumber = b.registrationnumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.sessiondescription='{$sessions}' and b.semester='{$semesters}' and b.studentlevel='{$studentlevels}') order by b.registrationnumber, b.coursecode";

		$result = mysql_query($query, $connection);

		if(mysql_num_rows($result) > 0){
			$count=1;
			$matno="";
			$therepoline="";
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				if($row[4] <> $matno){
					if($therepoline>""){
						$curGP = getCurrentGPA($sessions,$semesters,$matno);
						$theCurGPs = explode("][", $curGP);

						$preGP = getPreviousGPA($sessions,$semesters,$matno);
						$thePreGPs = explode("][", $preGP);
					
						$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
						$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matno}'";
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
						$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);

						$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
						$remarks = getRemarks($sessions,$semesters,$matno,$finalyear,$cgpa,$ctnup,$programmecodes);

						if($repotype=="PASSES"){
							if(str_in_str($remarks,"Passed")){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="COMMENDATION"){
							if(doubleval($theCurGPs[2])>=4.50){
								$therepoline .= "<td align='center'>".number_format($theCurGPs[2],2)."</td><td align='center'>".$theCurGPs[3]."</td><td>".$remarks."</td></tr>";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="REFERENCES"){
							if(!str_in_str($remarks,"Passed")){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="COUNSELLING"){
							if(doubleval($theCurGPs[2])<1.0){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="PROBATION"){
							if($cgpa<1.0){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="WITHDRAWAL"){
							if(doubleval($theCurGPs[2])<1.0){
								$query="SELECT * FROM sessionstable order by sessiondescription, semesterdescription";
								$sessions2="";
								$semesters2="";
								
								$result = mysql_query($query, $connection);

								if(mysql_num_rows($result) > 0){
									while ($row = mysql_fetch_array($result)) {
										extract ($row);
										if($sessions==$row[1] && $semesters==$row[2]) break;
										$sessions2=$row[1];
										$semesters2=$row[2];
									}
								}

								$curGP2 = getCurrentGPA($sessions2,$semesters2,$matno);
								$theCurGPs2 = explode("][", $curGP2);

								if(doubleval($theCurGPs2[2])<1.0){
									$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
									$reportline[]=array('line'=>$therepoline,);
								}
							}else{
								--$count;
							}
						}
					}
					$therepoline="";
					$matno = $row[4];

					$query2 = "SELECT regNumber, firstName, lastName, middleName, gender FROM regularstudents where regNumber='{$matno}'";
					$result2 = mysql_query($query2, $connection);
					while ($row2 = mysql_fetch_array($result2)) {
						extract ($row2);
						$fullname = strtoupper($row2[2]).", ".$row2[1];
						if($row2[3]>"") $fullname .= " ".$row2[3];
						$therepoline .= "<tr style='font-weight:bold; color:#000000'>";
						$therepoline .= "<td align='right'>".$count++.".</td><td>".$row2[0]."</td>";
						$therepoline .= "<td>".$fullname."</td><td>".$row2[4]."</td>";
					}
					$k=0;
				}
			}
			$curGP = getCurrentGPA($sessions,$semesters,$matno);
			$theCurGPs = explode("][", $curGP);

			$preGP = getPreviousGPA($sessions,$semesters,$matno);
			$thePreGPs = explode("][", $preGP);

			$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
			$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matno}'";
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
			$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);

			$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
			$remarks = getRemarks($sessions,$semesters,$matno,$finalyear,$cgpa,$ctnup,$programmecodes);
			if($repotype=="PASSES"){
				if(str_in_str($remarks,"Passed")){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="COMMENDATION"){
				if(doubleval($theCurGPs[2])>=4.50){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="REFERENCES"){
				if(!str_in_str($remarks,"Passed")){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="COUNSELLING"){
				if(doubleval($theCurGPs[2])<1.0){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="PROBATION"){
				if($cgpa<1.0){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="WITHDRAWAL"){
				if(doubleval($theCurGPs[2])<1.0){
					$query="SELECT * FROM sessionstable order by sessiondescription, semesterdescription";
					$sessions2="";
					$semesters2="";
								
					$result = mysql_query($query, $connection);

					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
							if($sessions==$row[1] && $semesters==$row[2]) break;
							$sessions2=$row[1];
							$semesters2=$row[2];
						}
					}

					$curGP2 = getCurrentGPA($sessions2,$semesters2,$matno);
					$theCurGPs2 = explode("][", $curGP2);

					if(doubleval($theCurGPs2[2])<1.0){
						$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
						$reportline[]=array('line'=>$therepoline,);
					}
				}else{
					--$count;
				}
			}
		}

		$counter=--$count;
		if($counter<=0) $counter="";

		if($repotype=="PASSES"){
			global $numberofcandidateswhopassedexam;
			$numberofcandidateswhopassedexam = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>A. PASSES</td></tr>";

			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The following ".$counter." Candidate(s) have passed all the Compulsory/Required Courses and have fulfilled all other University Requirements.</td></tr>";
		}

		if($repotype=="COMMENDATION"){
			global $numberofcandidatesforcommendation;
			$numberofcandidatesforcommendation = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>B. RECOMMENDED FOR COMMENDATION</td></tr>";
			
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The following ".$counter." Candidate(s) are recommended for University Commendation for having a current GPA of 4.50 and above.</td></tr>";
		}

		if($repotype=="REFERENCES"){
			global $numberofcandidateswithreference;
			$numberofcandidateswithreference = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>C. REFERENCES</td></tr>";

			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The following ".$counter." Candidate(s) have Course(s) listed against their names to take or repeat at the next available opportunity.</td></tr>";
		}

		if($repotype=="COUNSELLING"){
			global $numberofcandidatesforcounselling;
			$numberofcandidatesforcounselling = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>D. RECOMMENDED FOR FACULTY COUNSELLING</td></tr>";

			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The following ".$counter." Candidate(s) are Recommended for School Counselling for having a Current GPA of less than 1.00 in the Semester.</td></tr>";
		}

		if($repotype=="PROBATION"){
			global $numberofcandidatesforprobation;
			$numberofcandidatesforprobation = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>E. RECOMMENDED FOR UNIVERSITY PROBATION</td></tr>";

			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The following ".$counter." Candidate(s) are Recommended for University Probation for having a Cummulative GPA of less than 1.00 in the Semester.</td></tr>";
		}

		if($repotype=="WITHDRAWAL"){
			global $numberofcandidatesforwithdrawal;
			$numberofcandidatesforwithdrawal = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>F. RECOMMENDED FOR WITHDRAWAL</td></tr>";

			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The following ".$counter." Candidate(s) are Recommended for Withdrawal for having a Cummulative GPA of less than 1.00 in two Consecutive Semesters.</td></tr>";
		}

		if($counter>""){
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td align='right'>S/NO</td><td>MATRIC NO</td><td>FULL NAME</td><td>SEX</td>";
			echo "<td align='center'>CGPA</td><td align='center'>CTNUP</td><td>REMARKS</td></tr>";
			foreach($reportline as $code) echo $code['line'];
		}


	}

	function getSuspended($repotype,$sessions,$semesters,$facultycodes,
		$departmentcodes,$programmecodes,$studentlevels,$finalyear){
		
		include("data.php"); 
		
		$reportline = array();
		$therepoline="";
		$count=0;
	
		$query = "SELECT regNumber, firstName, lastName, middleName, gender, gpa, tnup FROM regularstudents where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' order by gpa, regNumber";
		//$query = "SELECT a.*, b.sessions, b.semester FROM regularstudents a, registration b where a.regNumber = b.regNumber and a.facultycode = '{$facultycodes}' and a.departmentcode = '{$departmentcodes}' and a.programmecode = '{$programmecodes}' and a.studentlevel = '{$studentlevels}' and b.sessions  = '{$sessions}' and b.semester='{$semesters}'";
		$result = mysql_query($query, $connection);
		global $numberofcandidatesinclass;
		$numberofcandidatesinclass = mysql_num_rows($result);

		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			if($repotype=="SUSPENSION"){ // If the student didn't register for semester then.
				$query2 = "SELECT * FROM finalresultstable where registrationnumber='{$row[0]}' and sessiondescription='{$sessions}' and studentlevel='{$studentlevels}'";
				$result2 = mysql_query($query2, $connection);
				// If the student also didn't register for session then don't print.
				if(mysql_num_rows($result2) <= 0) continue;

				$query2 = "SELECT * FROM finalresultstable where registrationnumber='{$row[0]}' and sessiondescription='{$sessions}' and semester='{$semesters}' and studentlevel='{$studentlevels}'";
			}

			if($repotype=="DETERMINATION"){
				$query2 = "SELECT * FROM finalresultstable where registrationnumber='{$row[0]}' and sessiondescription='{$sessions}' and studentlevel='{$studentlevels}'";
			}
			$result2 = mysql_query($query2, $connection);
			if(mysql_num_rows($result2) <= 0){
				$remarks = getRemarks($sessions,$semesters,$row[0],$finalyear,$gpa,$tnup,$programmecodes);
				$fullname = strtoupper($row[2]).", ".$row[1];
				if($row[3]>"") $fullname .= " ".$row[3];
				$therepoline = "<tr style='font-weight:bold; color:#000000'>";
				$therepoline .= "<td align='right'>".++$count.".</td><td>".$row[0]."</td>";
				$therepoline .= "<td>".$fullname."</td><td>".$row[4]."</td>"; //<td colspan='3'>&nbsp;</td>";
				$therepoline .= "<td align='center'>".number_format($gpa,2)."</td>";
				$therepoline .= "<td align='center'>".$tnup."</td><td>".$remarks."</td></tr>";
				$reportline[]=array('line'=>$therepoline,);
			}
		}
		$counter=$count;
		if($counter<=0) $counter="";
		if($repotype=="SUSPENSION"){
			global $numberofcandidatesforsuspension;
			$numberofcandidatesforsuspension = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>G. RECOMMENDED FOR SUSPENSION OF STUDENTSHIP</td></tr>";

			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The Studentship of the following ".$counter." Candidate(s) is Recommended for Suspension for failing to Register for the Semester.</td></tr>";
		}

		if($repotype=="DETERMINATION"){
			global $numberofcandidatesfordetermination;
			$numberofcandidatesfordetermination = $counter;
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>H. RECOMMENDED FOR DETERMINATION OF STUDENTSHIP</td></tr>";

			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td colspan='7'>The Studentship of the following ".$counter." Candidate(s) is Recommended for Suspension for failing to Register for the Session.</td></tr>";
		}
		if($count>0){
			echo "<tr style='font-weight:bold; color:#000000'>";
			echo "<td align='right'>S/NO</td><td>MATRIC NO</td><td>FULL NAME</td><td>SEX</td>";
			echo "<td align='center'>CGPA</td><td align='center'>CTNUP</td><td>REMARKS</td></tr>";
			foreach($reportline as $code) echo $code['line'];
		}
	}


	$schoolnames = "";
	$query = "SELECT * FROM schoolinformation where schoolname<>''";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$schoolnames = $row[1] . ", " . $row[2];
		}
	}

	echo "<table border='3' style='border-color:#000000; border-style:solid; border-width:1px; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'><tr style='font-weight:bold; color:#000000'>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7' align='center'><h3>".$schoolnames."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7' align='center'><h3>".$facultycodes."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7' align='center'><h3>DEPARTMENT OF ".$departmentcodes."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7' align='center'><h3>".$programmecodes." PROGRAMME</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7' align='center'><h5>".$sessions." ".$semesters." Semester Examination Results</h5></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7' align='center'><h5>".$studentlevels."</h5></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7' align='center'><h5>SUMMARY OF RESULTS</h5></td></tr>";

	displayReport("PASSES",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("COMMENDATION",$sessions,$semesters,$facultycodes,$departmentcodes,
	$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("REFERENCES",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("COUNSELLING",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("PROBATION",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("WITHDRAWAL",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	getSuspended("SUSPENSION",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	getSuspended("DETERMINATION",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>SUMMARY</td></tr>";

	global $numberofcandidateswhosatforexam;
	$numberofcandidateswhosatforexam = intval($GLOBALS['numberofcandidateswhopassedexam']) + intval($GLOBALS['numberofcandidateswithreference']);

	global $numberofcandidateswhodidnotsitforexam;
	$numberofcandidateswhodidnotsitforexam= intval($GLOBALS['numberofcandidatesinclass']) - intval($GLOBALS['numberofcandidateswhosatforexam']);

	if($GLOBALS['numberofcandidatesinclass']==null || $GLOBALS['numberofcandidatesinclass']=="")
		$GLOBALS['numberofcandidatesinclass']="Nill";

	if($GLOBALS['numberofcandidateswhosatforexam']==null || $GLOBALS['numberofcandidateswhosatforexam']=="")
		$GLOBALS['numberofcandidateswhosatforexam']="Nill";

	if($GLOBALS['numberofcandidateswhodidnotsitforexam']==null || $GLOBALS['numberofcandidateswhodidnotsitforexam']=="")
		$GLOBALS['numberofcandidateswhodidnotsitforexam']="Nill";

	if($GLOBALS['numberofcandidateswhopassedexam']==null || $GLOBALS['numberofcandidateswhopassedexam']=="")
		$GLOBALS['numberofcandidateswhopassedexam']="Nill";

	if($GLOBALS['numberofcandidatesforcommendation']==null || $GLOBALS['numberofcandidatesforcommendation']=="")
		$numberofcandidatesforcommendation="Nill";

	if($GLOBALS['numberofcandidateswithreference']==null || $GLOBALS['numberofcandidateswithreference']=="")
		$GLOBALS['numberofcandidateswithreference']="Nill";

	if($GLOBALS['numberofcandidatesforcounselling']==null || $GLOBALS['numberofcandidatesforcounselling']=="")
		$GLOBALS['numberofcandidatesforcounselling']="Nill";

	if($GLOBALS['numberofcandidatesforprobation']==null || $GLOBALS['numberofcandidatesforprobation']=="")
		$GLOBALS['numberofcandidatesforprobation']="Nill";

	if($GLOBALS['numberofcandidatesforwithdrawal']==null || $GLOBALS['numberofcandidatesforwithdrawal']=="")
		$GLOBALS['numberofcandidatesforwithdrawal']="Nill";

	if($GLOBALS['numberofcandidatesforsuspension']==null || $GLOBALS['numberofcandidatesforsuspension']=="")
		$GLOBALS['numberofcandidatesforsuspension']="Nill";

	if($GLOBALS['numberofcandidatesfordetermination']==null || $GLOBALS['numberofcandidatesfordetermination']=="")
		$GLOBALS['numberofcandidatesfordetermination']="Nill";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates in Class</td><td>".$GLOBALS['numberofcandidatesinclass']."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates who sat for Examination</td><td>".$GLOBALS['numberofcandidateswhosatforexam']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates who did not sit for Examination</td><td>".$numberofcandidateswhodidnotsitforexam."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates who Passed the Examination</td><td>".$GLOBALS['numberofcandidateswhopassedexam']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates for Commendation</td><td>".$GLOBALS['numberofcandidatesforcommendation']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates with Courses to Take/Repeat</td><td>".$GLOBALS['numberofcandidateswithreference']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for School Counselling</td><td>".$GLOBALS['numberofcandidatesforcounselling']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for University Probation</td><td>".$GLOBALS['numberofcandidatesforprobation']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for Withdrawal</td><td>".$GLOBALS['numberofcandidatesforwithdrawal']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for Suspension of Studentship</td><td>".$GLOBALS['numberofcandidatesforsuspension']."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for Determination of Studentship</td><td>".$GLOBALS['numberofcandidatesfordetermination']."</td></tr>";

	$query = "SELECT coursecode, coursetype FROM coursestable order by coursetype, coursecode";
	$result = mysql_query($query, $connection);
	$compulsory="";
	$required="";
	$elective="";
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$query2 = "SELECT DISTINCT registrationnumber FROM finalresultstable where coursecode='{$row[0]}' ";
			$result2 = mysql_query($query2, $connection);
			if(mysql_num_rows($result2) > 0){
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$query3 = "SELECT regNumber, facultycode, departmentcode, programmecode, studentlevel FROM regularstudents where regNumber='{$row2[0]}' ";
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3) > 0){
						while ($row3 = mysql_fetch_array($result3)) {
							extract ($row3);
							if($row3[1]==$facultycodes && $row3[2]==$departmentcodes && $row3[3]==$programmecodes && $row3[4]==$studentlevels){
								if($row[1]=="Compulsory") $compulsory .= $row[0].", ";
								if($row[1]=="Required") $required .= $row[0].", ";
								if($row[1]=="Elective") $elective .= $row[0].", ";
								break;
							}
						}
					}
					if($row3[1]==$facultycodes && $row3[2]==$departmentcodes && $row3[3]==$programmecodes && $row3[4]==$studentlevels){
						break;
					}
				}
			}
		}
	}

	$compulsory=substr($compulsory, 0, strlen($compulsory)-2);
	$required=substr($required, 0, strlen($required)-2);
	$elective=substr($elective, 0, strlen($elective)-2);

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>&nbsp;</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>STATUS OF COURSES</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>COMPULSORY COURSES:&nbsp;".$compulsory."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>REQUIRED COURSES:&nbsp;".$required."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='7'>ELECTIVE COURSES:&nbsp;".$elective."</td></tr>";

	echo "</table>";
?>
                                                                             
</BODY>
</HTML>
