<?php
	header("Content-type: application/x-msdownload"); 
	//header("Content-type: application/msword"); 
	header("Content-Disposition: attachment; filename=excel.xls"); 
	//header("Content-Disposition: attachment; filename=msword.doc"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	echo "$header"; 

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

	function getCurrentGPA($sesion,$semesters,$regno){
		$query = "SELECT * FROM finalresultstable where sessiondescription='{$sesion}' and semester='{$semesters}' and registrationnumber='{$regno}' order by right(coursecode,3) desc";
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

	function getPreviousGPA($sesion,$semesters,$regno){
		include("data.php"); 
		
		$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sesion}' and semester<'{$semesters}') or (sessiondescription<'{$sesion}')) and registrationnumber='{$regno}' order by right(coursecode,3) desc";
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

	$schoolnames = "";
	$query = "SELECT * FROM schoolinformation where schoolname<>''";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$schoolnames = $row[1] . ", " . $row[2];
		}
	}

	$query = "SELECT DISTINCT  coursecode FROM finalresultstable where sessiondescription='{$sessions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' order by right(coursecode,3) desc";
	$result = mysql_query($query, $connection);
	$coursecodes="";
	$k=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$query2 = "SELECT min(registrationnumber) FROM finalresultstable where coursecode='{$row[0]}' and sessiondescription='{$sessions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' ";
			$result2 = mysql_query($query2, $connection);
			if(mysql_num_rows($result2) > 0){
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$query3 = "SELECT regNumber, facultycode, departmentcode, programmecode FROM regularstudents where regNumber='{$row2[0]}' ";
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3) > 0){
						while ($row3 = mysql_fetch_array($result3)) {
							extract ($row3);
							if($row3[1]==$facultycodes && $row3[2]==$departmentcodes && $row3[3]==$programmecodes){
								$coursecodes .= $row[0] . "][";
								$k++;
								break;
							}
						}
					}
					if($row3[1]==$facultycodes && $row3[2]==$departmentcodes && $row3[3]==$programmecodes){
						break;
					}
				}
			}
		}
	}
	$coursecodes = substr($coursecodes, 0, strlen($coursecodes)-2);
	$thecoursecodes = explode("][", $coursecodes);
	$colspan = $k + 17;

	echo "<table border='3' style='border-color:#000000; border-style:solid; border-width:1px; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'><tr style='font-weight:bold; color:#000000'>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";

	echo "<td colspan='".$colspan."' align='center'><h3>".$schoolnames."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."' align='center'><h3>".$facultycodes."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."' align='center'><h3>DEPARTMENT OF ".$departmentcodes."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."' align='center'><h3>".$programmecodes." PROGRAMME</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."' align='center'><h5>".$sessions." ".$semesters." Semester Examination Results</h5></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."' align='center'><h5>MASTER SCORE SHEET</h5></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."' align='center'><h5>".$studentlevels."</h5></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
    echo "<td algn='right'>S/NO</td><td>MATRIC NO</td><td>FULL NAME</td><td>SEX</td>";
	echo "<td colspan='".$k."' align='center'>COURSES</td>";
	echo "<td colspan='4' align='center'>CURRENT</td><td colspan='4' align='center'>PREVIOUS</td>";
	echo "<td colspan='4' align='center'>CUMMULATIVE</td><td>REMARKS</td></tr>";

    echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	foreach($thecoursecodes as $code){
		$query = "SELECT * FROM coursestable where coursecode='{$code}' and programmecode='{$programmecodes}'";
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$codes = explode(" ",$code);
			echo "<td align='center'>".$codes[0]."<br>".$codes[1];
			echo "<br>`(".$row[3].")<br>(".substr($row[4], 0, 1).")</td>";
		}
	}
    echo "<td>TCP</td><td>TNU</td><td>GPA</td><td>TNUP</td>";
    echo "<td>TCP</td><td>TNU</td><td>GPA</td><td>TNUP</td>";
    echo "<td>TCP</td><td>TNU</td><td>GPA</td><td>TNUP</td><td>REPEAT OR RETAKE</td></tr>";

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

	
	$query = "SELECT *  FROM regularstudents where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'";
	//$query = "SELECT a.*, b.sessions, b.semester FROM regularstudents a, registration b where a.regNumber = b.regNumber and a.facultycode = '{$facultycodes}' and a.departmentcode = '{$departmentcodes}' and a.programmecode = '{$programmecodes}' and a.studentlevel = '{$studentlevels}' and b.sessions  = '{$sessions}' and b.semester='{$semesters}'";
	$result = mysql_query($query, $connection);
	$students_in_class=mysql_num_rows($result);

	$query = "SELECT b.*, a.*  FROM regularstudents AS a INNER JOIN finalresultstable AS b 
	ON (a.regNumber = b.registrationnumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.studentlevel='{$studentlevels}' and b.sessiondescription='{$sessions}' and b.semester='RAIN' and b.studentlevel='{$studentlevels}') order by b.registrationnumber, right(b.coursecode,3) desc";

	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=1;
		$matno="";
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if($row[4] <> $matno){
				$c=0;
				foreach($thecoursecodes as $code){
					if($c++ < $k) continue;
					echo "<td align='center'>&nbsp;</td>";
					$k++;
				}
				if($c <>0 && $matno <>"") {
					$curGP = getCurrentGPA($sessions,$semesters,$matno);
					$theCurGPs = explode("][", $curGP);
					echo "<td align='center'>".$theCurGPs[0]."</td>";
					echo "<td align='center'>".$theCurGPs[1]."</td>";
					echo "<td align='center'>".number_format($theCurGPs[2],2)."</td>";
					echo "<td align='center'>".$theCurGPs[3]."</td>";
					if(doubleval($theCurGPs[2])>=4.50){
						$students_for_commendation++;
					}

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

					$preGP = getPreviousGPA($sessions,$semesters,$matno);
					$thePreGPs = explode("][", $preGP);
					echo "<td align='center'>".(doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
					echo "<td align='center'>".(doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
					echo "<td align='center'>".number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."</td>";
					echo "<td align='center'>".(doubleval($thePreGPs[3])+doubleval($tnup))."</td>";

					$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
					$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
					echo "<td align='center'>".(doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
					echo "<td align='center'>".(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
					echo "<td align='center'>".number_format($cgpa,2)."</td>";
					echo "<td align='center'>".$ctnup."</td>";

					$remarks = getRemarks($sessions,$semesters,$matno,$finalyear,$cgpa,$ctnup,$programmecodes);
					echo "<td>".$remarks."</td></tr>";

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
							$students_for_withdrawal++;
						}
					}
				}
				$matno = $row[4];

				$query2 = "SELECT regNumber, firstName, lastName, middleName, gender FROM regularstudents where regNumber='{$matno}'";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$fullname = strtoupper($row2[2]).", ".$row2[1];
					if($row2[3]>"") $fullname .= " ".$row2[3];
					echo "<tr style='font-weight:bold; color:#000000'>";
					echo "<td align='right'>".$count++.".</td><td>".$row2[0]."</td>";
					echo "<td>".$fullname."</td><td>".$row2[4]."</td>";
					$students_who_sat_for_eaxam++;
				}
				$k=0;
			}
			if($row[4] == $matno){
				$c=0;
				foreach($thecoursecodes as $code){
					if($c++ < $k) continue;
					if($row[3]==$code){
						$score = $row[5]."<br>".$row[6];
						if($row[5]==0) $score = "00<br>".$row[6];
						echo "<td align='center'>".$score."</td>";
						$k++;
						break;
					}else{
						echo "<td align='center'>&nbsp;</td>";
						$k++;
					}
				}
			}
		}
		$c=0;
		foreach($thecoursecodes as $code){
			if($c++ < $k) continue;
			echo "<td align='center'>&nbsp;</td>";
			$k++;
		}
		if($c <>0) {
			$curGP = getCurrentGPA($sessions,$semesters,$matno);
			$theCurGPs = explode("][", $curGP);
			echo "<td align='center'>".$theCurGPs[0]."</td>";
			echo "<td align='center'>".$theCurGPs[1]."</td>";
			echo "<td align='center'>".number_format($theCurGPs[2],2)."</td>";
			echo "<td align='center'>".$theCurGPs[3]."</td>";
			if(doubleval($theCurGPs[2])>=4.50){
				$students_for_commendation++;
			}

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

			$preGP = getPreviousGPA($sessions,$semesters,$matno);
			$thePreGPs = explode("][", $preGP);
			echo "<td align='center'>".(doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
			echo "<td align='center'>".(doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
			echo "<td align='center'>".number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."</td>";
			echo "<td align='center'>".(doubleval($thePreGPs[3])+doubleval($tnup))."</td>";

			$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
			$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
			echo "<td align='center'>".(doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
			echo "<td align='center'>".(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
			echo "<td align='center'>".number_format($cgpa,2)."</td>";
			echo "<td align='center'>".$ctnup."</td>";
			$remarks = getRemarks($sessions,$semesters,$matno,$finalyear,$cgpa,$ctnup,$programmecodes);
			echo "<td>".$remarks."</td></tr>";
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
					$students_for_withdrawal++;
				}
			}
		}
	}

	echo "</table>";
	
	$colspan = $k + 17;

	echo "<table border='3' style='border-color:#000000; border-style:solid; border-width:1px; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'><tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>SUMMARY</td></tr>";

	if($students_in_class==0) $students_in_class="Nill";

	if($students_who_sat_for_eaxam==0) $students_who_sat_for_eaxam="Nill";
	
	$students_who_did_not_sit_for_eaxam=$students_in_class - $students_who_sat_for_eaxam;
	if($students_who_did_not_sit_for_eaxam==0) $students_who_did_not_sit_for_eaxam="Nill";

	if($students_who_passed_exam==0) $students_who_passed_exam="Nill";

	if($students_for_commendation==0) $students_for_commendation="Nill";

	if($students_for_reference==0) $students_for_reference="Nill";

	if($students_for_counselling==0) $students_for_counselling="Nill";

	if($students_for_probation==0) $students_for_probation="Nill";

	if($students_for_withdrawal==0) $students_for_withdrawal="Nill";

	if($students_for_suspension_of_studentship==0) $students_for_suspension_of_studentship="Nill";

	if($students_for_determination_of_studentship==0) $students_for_determination_of_studentship="Nill";

	$colspan--;

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates in Class</td><td>".$students_in_class."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates who sat for Examination</td><td>".$students_who_sat_for_eaxam."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates who did not sit for Examination</td><td>".$students_who_did_not_sit_for_eaxam."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates who Passed the Examination</td><td>".$students_who_passed_exam."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates for Commendation</td><td>".$students_for_commendation."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates with Courses to Take/Repeat</td><td>".$students_for_reference."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates Recommended for School Counselling</td><td>".$students_for_counselling."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates Recommended for University Probation</td><td>".$students_for_probation."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates Recommended for Withdrawal</td><td>".$students_for_withdrawal."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates Recommended for Suspension of Studentship</td><td>".$students_for_suspension_of_studentship."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>Number of Candidates Recommended for Determination of Studentship</td><td>".$students_for_determination_of_studentship."</td></tr>";

	$query = "SELECT coursecode, coursetype FROM coursestable where programmecode='{$programmecodes}' order by coursetype, coursecode";
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
					$query3 = "SELECT regNumber, facultycode, departmentcode, programmecode, studentlevel FROM regularstudents where regNumber='{$row2[0]}'";
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

	$colspan++;

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>&nbsp;</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>STATUS OF COURSES</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>COMPULSORY COURSES:&nbsp;".$compulsory."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>REQUIRED COURSES:&nbsp;".$required."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='".$colspan."'>ELECTIVE COURSES:&nbsp;".$elective."</td></tr></table>";

?>
