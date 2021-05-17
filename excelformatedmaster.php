<?php
	header("Content-type: application/x-msdownload"); 
	//header("Content-type: application/msword"); 
	header("Content-Disposition: attachment; filename=excel.xls"); 
	//header("Content-Disposition: attachment; filename=msword.doc"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	echo "$header"; 

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

	global $finalyear;
	$finalyear = trim($_GET['finalyear']);
	if($finalyear == null) $finalyear = "";

	global $thecoursecodes;
	global $header;
	global $courseheader;
	global $summaryheader;
	global $footer;

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
		$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sesion}' and semester<'{$semesters}') or (sessiondescription<'{$sesion}')) and registrationnumber='{$regno}' order by right(coursecode,3) desc";
		$programmecodes = $GLOBALS['programmecodes'];
		include("data.php"); 
		
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

	function getRemarks($sesion,$semesters,$regno,$finalyear,$cgpa,$ctnup,$programmecodes){
		$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sesion}' and semester='{$semesters}') or (sessiondescription='{$sesion}' and semester<'{$semesters}') or (sessiondescription<'{$sesion}'))and registrationnumber='{$regno}' and marksobtained<40 order by right(coursecode,3) desc";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0;
		$failedcourses="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$coursecode}'";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					if($marksobtained<$minimumscore) $failedcourses .= $row2[0]."~".$minimumscore."][";
				}

			}
		}

		$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where programmecode='{$programmecodes}' and (coursetype='Compulsory' or coursetype='Required') ";
		$result2 = mysql_query($query2, $connection);
		while ($row2 = mysql_fetch_array($result2)) {
			extract ($row2);
			$query = "SELECT * FROM finalresultstable where registrationnumber='{$regno}' and  coursecode='{$row2[0]}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result)==0 && !str_in_str($failedcourses,$row2[0])) 
				$failedcourses .= $row2[0]."~".$minimumscore."][";
		}

		$remarks="";
		if($failedcourses>""){
			$splitfailedcourses = explode("][", $failedcourses);
			foreach($splitfailedcourses as $code){
				$minimumscore = explode("~", $code);
				if($minimumscore[0]==null || $minimumscore[0]=="") break;
				$query2 = "SELECT * FROM finalresultstable where coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}'";
				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2) == 0) $remarks .= $minimumscore[0]."  ";
			}
		}
		
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
	
	function printheader(){
		$sessions = $GLOBALS['sessions'];
		$semesters = $GLOBALS['semesters'];
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

		$query = "SELECT DISTINCT  coursecode FROM finalresultstable where sessiondescription='{$sessions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' order by right(coursecode,3) desc";

		$result = mysql_query($query, $connection);
		$coursecodes="";
		$noofcourses=0;
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT min(registrationnumber) FROM finalresultstable where coursecode='{$row[0]}'  and sessiondescription='{$sessions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' ";
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
									$noofcourses++;
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
		$GLOBALS['thecoursecodes'] = explode("][", $coursecodes);

		$colspan = $noofcourses + 4;
		
		$GLOBALS['header'] .=  "<table border='3' style='border-color:#000000; border-style:solid; border-width:1px; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";

		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>".$schoolnames."</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>".$facultycodes."</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>DEPARTMENT OF ".$departmentcodes."</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>".$programmecodes." PROGRAMME</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h5>".$sessions." ".$semesters." Examination Results</h5></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h5>MASTER SCORE SHEET</h5></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h5>".$studentlevels."</h5></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td algn='right'>S/NO</td><td>MATRIC NO</td><td>FULL NAME</td><td>SEX</td>";

		return $noofcourses;
	}

	function printfooter($page,$lastpage,$lines){
		include("data.php"); 
		
		$facultycodes = $GLOBALS['facultycodes'];
		$departmentcodes = $GLOBALS['departmentcodes'];
		$programmecodes = $GLOBALS['programmecodes'];

		$dofs="";
		$query = "SELECT * FROM facultiestable where facultydescription='{$facultycodes}'";
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$dofs=$dof;
		}

		$hods="";
		$query = "SELECT * FROM departmentstable where departmentdescription='{$departmentcodes}'";
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$hods=$hod;
		}

		$courseadvisors="";
		$query = "SELECT * FROM programmestable where programmedescription='{$programmecodes}'";
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$courseadvisors=$courseadvisor;
		}

		$GLOBALS['footer'] =  "</table><table border='0' style='border-color:#000000; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'>";
		//$lines = ($lines) + 3;
		for($i=0; $i<$lines;$i++){
			$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;<BR>&nbsp;</td>";
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;<BR>&nbsp;</td>";
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;<BR>&nbsp;</td>";
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;<BR>&nbsp;</td>";
			$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;<BR>&nbsp;</td></tr>";
		}

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>SGD</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>SGD</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>SGD</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		//$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		//$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>______________________________</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>______________________________</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>______________________________</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>".$hods."</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>".$courseadvisors."</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>".$dofs."</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>HOD GRP</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>EXTERNAL EXAMINER</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>DEAN FSMS</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr></table>";

		$GLOBALS['footer'] .=  "<table border='0' style='border-color:#000000; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'>";
		
		//$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		//$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		//$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='100%' align='right'>Page ".$page." of ".$lastpage."</td></tr></table>";
		if($page<$lastpage)
			$GLOBALS['footer'] .=  "<br clear=all style='mso-special-character:line-break;page-break-before:always'>";

	}
		
	function coursesheader($noofcourses){
		include("data.php"); 
		
		$thecoursecodes = $GLOBALS['thecoursecodes'];
		$programmecodes = $GLOBALS['programmecodes'];
		$GLOBALS['courseheader'] .=  "<td colspan='".$noofcourses."' align='center'>COURSES</td></tr>";

		$GLOBALS['courseheader'] .=  "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
		foreach($thecoursecodes as $code){
			$query = "SELECT * FROM coursestable where coursecode='{$code}' and programmecode='{$programmecodes}'";
			$result = mysql_query($query, $connection);
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$codes = explode(" ",$code);
				$GLOBALS['courseheader'] .=  "<td align='center'>".$codes[0]."<br>".$codes[1];
				$GLOBALS['courseheader'] .=  "<br>`(".$row[3].")<br>(".substr($row[4], 0, 1).")</td>";
			}
		}
		$GLOBALS['courseheader'] .=  "</tr>";
	}

	function printsummary(){
		$GLOBALS['summaryheader'] .=  "<td colspan='4' align='center'>CURRENT</td><td colspan='4' align='center'>PREVIOUS</td>";
		$GLOBALS['summaryheader'] .=  "<td colspan='4' align='center'>CUMMULATIVE</td><td>REMARKS</td></tr>";

		$GLOBALS['summaryheader'] .=  "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
		$GLOBALS['summaryheader'] .=  "<td>TCP</td><td>TNU</td><td>GPA</td><td>TNUP</td>";
		$GLOBALS['summaryheader'] .=  "<td>TCP</td><td>TNU</td><td>GPA</td><td>TNUP</td>";
		$GLOBALS['summaryheader'] .=  "<td>TCP</td><td>TNU</td><td>GPA</td><td>TNUP</td><td colspan='5'>REPEAT OR RETAKE<BR>&nbsp;<BR>&nbsp;</td></tr>";
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

	
	$query = "SELECT *  FROM regularstudents where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'";
	$result = mysql_query($query, $connection);
	$students_in_class=mysql_num_rows($result);

	$thecoursecodes = $GLOBALS['thecoursecodes'];
	$query = "SELECT b.*, a.*  FROM regularstudents AS a INNER JOIN finalresultstable AS b 
	ON (a.regNumber = b.registrationnumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.studentlevel='{$studentlevels}' and b.sessiondescription='{$sessions}' and b.semester='{$semesters}' and b.studentlevel='{$studentlevels}' and a.active='Yes') order by b.registrationnumber, right(b.coursecode,3) desc";

	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=1;
		$matno="";
		$noofstudents=0;
		$noofcourses = printheader();
		coursesheader($noofcourses);
		printsummary();
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if($row[4] <> $matno){
				//if(substr($noofstudents, strlen($noofstudents)-1, strlen($noofstudents))==0 && $noofstudents>0){
				//	$details .= "</tr>~_~";
				//	$noofcourses = printheader($coursenum);
				//	coursesheader($noofcourses);
				//}
				$c=0;
				foreach($thecoursecodes as $code){
					if($c++ < $noofcourses) continue;
					$details .= "<td align='center'>&nbsp;</td>";
					$noofcourses++;
				}
				if($details != "") $details .= "</tr>~_~";
				if($c <>0 && $matno <>"") {
					$curGP = getCurrentGPA($sessions,$semesters,$matno);
					$theCurGPs = explode("][", $curGP);
					$summary .=  "<td align='center'>".$theCurGPs[0]."</td>";
					$summary .=  "<td align='center'>".$theCurGPs[1]."</td>";
					$summary .=  "<td align='center'>".number_format($theCurGPs[2],2)."</td>";
					$summary .=  "<td align='center'>".$theCurGPs[3]."</td>";

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
					$summary .=  "<td align='center'>".(doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
					$summary .=  "<td align='center'>".(doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
					$summary .=  "<td align='center'>".number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."</td>";
					$summary .=  "<td align='center'>".(doubleval($thePreGPs[3])+doubleval($tnup))."</td>";

					$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
					$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
					$summary .=  "<td align='center'>".(doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
					$summary .=  "<td align='center'>".(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
					$summary .=  "<td align='center'>".number_format($cgpa,2)."</td>";
					$summary .=  "<td align='center'>".$ctnup."</td>";

					$remarks = getRemarks($sessions,$semesters,$matno,$finalyear,$cgpa,$ctnup,$programmecodes);
					$summary .=  "<td colspan='5'>".$remarks."<BR>&nbsp;</td></tr>~_~";

					if(str_in_str($remarks,"Passed")){
						$students_who_passed_exam++;
					}
					if(doubleval($cgpa)>=4.50){
						$students_for_commendation++;
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
					$details .= "<tr style='font-weight:bold; color:#000000'>";
					$details .= "<td align='right'>".$count++.".</td><td>".$row2[0]."</td>";
					$details .= "<td>".$fullname."</td><td>".$row2[4]."</td>";
					$summary .= "<tr style='font-weight:bold; color:#000000'>";
					$summary .= "<td align='right'>".($count-1).".</td><td>".$row2[0]."</td>";
					$summary .= "<td>".$fullname."</td><td>".$row2[4]."</td>";
					$students_who_sat_for_eaxam++;
				}
				$noofcourses=0;
			}
			if($row[4] == $matno){
				$noofstudents++;
				$c=0;
				foreach($thecoursecodes as $code){
					if($c++ < $noofcourses) continue;
					if($row[3]==$code){
						$score = $row[5]."<br>".$row[6];
						if($row[5]==0) $score = "00<br>".$row[6];
						$details .= "<td align='center'>".$score."</td>";
						$noofcourses++;
						break;
					}else{
						$details .= "<td align='center'>&nbsp;</td>";
						$noofcourses++;
					}
				}
			}
		}
		$c=0;
		foreach($thecoursecodes as $code){
			if($c++ < $noofcourses) continue;
			$details .= "<td align='center'>&nbsp;</td>";
			$noofcourses++;
		}
		$details .= "</tr>";
		if($c <>0) {
			$curGP = getCurrentGPA($sessions,$semesters,$matno);
			$theCurGPs = explode("][", $curGP);
			$summary .=  "<td align='center'>".$theCurGPs[0]."</td>";
			$summary .=  "<td align='center'>".$theCurGPs[1]."</td>";
			$summary .=  "<td align='center'>".number_format($theCurGPs[2],2)."</td>";
			$summary .=  "<td align='center'>".$theCurGPs[3]."</td>";

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
			$summary .=  "<td align='center'>".(doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
			$summary .=  "<td align='center'>".(doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
			$summary .=  "<td align='center'>".number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."</td>";
			$summary .=  "<td align='center'>".(doubleval($thePreGPs[3])+doubleval($tnup))."</td>";

			$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
			$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
			$summary .=  "<td align='center'>".(doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
			$summary .=  "<td align='center'>".(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
			$summary .=  "<td align='center'>".number_format($cgpa,2)."</td>";
			$summary .=  "<td align='center'>".$ctnup."</td>";
			$remarks = getRemarks($sessions,$semesters,$matno,$finalyear,$cgpa,$ctnup,$programmecodes);
			$summary .=  "<td colspan='5'>".$remarks."<BR>&nbsp;</td></tr>";
		
			if(str_in_str($remarks,"Passed")){
				$students_who_passed_exam++;
			}
			if(doubleval($cgpa)>=4.50){
				$students_for_commendation++;
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
	
	$details = explode("~_~", $details);
	$summary = explode("~_~", $summary);

	$header = $GLOBALS['header'];
	$courseheader = $GLOBALS['courseheader'];
	$summaryheader = $GLOBALS['summaryheader'];
	$footer = $GLOBALS['footer'];

	$count = ($count -1) * 2;
	$lastpage= intval($count/10);
	++$lastpage;
	if(($count % 10)>0) ++$lastpage;
	echo $header;
	echo $courseheader;
	$counter1=0;
	$counter2=0;
	$page=0;
	for($i=0; $i<count($details); $i++){
		$counter1++;
		if(((($counter1-1) % 10)==0) && $counter1>=10){
			printfooter(++$page,$lastpage,0);
			$footer = $GLOBALS['footer'];
			echo $footer;
			echo $header;
			echo $summaryheader;
			for($j=($i-10); $j<count($summary); $j++){
				$counter2++;
				if(((($counter2-1) % 10)==0) && $counter2>=10){
					$counter2=0;
					printfooter(++$page,$lastpage,0);
					$footer = $GLOBALS['footer'];
					echo $footer;
					break;
				}
				echo $summary[$j];
			}
			if($i<count($details)-1){
				echo $header;
				echo $courseheader;
			}
		}
		echo $details[$i];
	}
	$lines = 0;
	if(($counter1 % 10)>0) $lines = 10 - ($counter1 % 10);
	printfooter(++$page,$lastpage,$lines);
	$footer = $GLOBALS['footer'];
	echo $footer;
	echo $header;
	echo $summaryheader;
	for(; $j<count($summary); $j++){
		$counter2++;
		if(((($counter2-1) % 10)==0) && $counter2>=10){
			$counter2=0;
			printfooter(++$page,$lastpage,(10 - ($counter1 % 10)));
			$footer = $GLOBALS['footer'];
			echo $footer;
			break;
		}
		echo $summary[$j];
	}
	printfooter(++$page,$lastpage,$lines);
	$footer = $GLOBALS['footer'];
	echo $footer;

	echo "<table border='3' style='border-color:#000000; border-style:solid; border-width:1px; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'>";
	echo "<tr style='font-weight:bold; color:#000000'><td colspan='7'>SUMMARY</td></tr>";
	
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


	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates in Class</td><td>".$students_in_class."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates who sat for Examination</td><td>".$students_who_sat_for_eaxam."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates who did not sit for Examination</td><td>".$students_who_did_not_sit_for_eaxam."</td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates who Passed the Examination</td><td>".$students_who_passed_exam."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates for Commendation</td><td>".$students_for_commendation."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates with Courses to Take/Repeat</td><td>".$students_for_reference."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for School Counselling</td><td>".$students_for_counselling."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for University Probation</td><td>".$students_for_probation."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for Withdrawal</td><td>".$students_for_withdrawal."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for Suspension of Studentship</td><td>".$students_for_suspension_of_studentship."</td></tr>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6'>Number of Candidates Recommended for Determination of Studentship</td><td>".$students_for_determination_of_studentship."</td></tr>";

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
					$query3 = "SELECT regNumber, facultycode, departmentcode, programmecode FROM regularstudents where regNumber='{$row2[0]}'";
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3) > 0){
						while ($row3 = mysql_fetch_array($result3)) {
							extract ($row3);
							if($row3[1]==$facultycodes && $row3[2]==$departmentcodes && $row3[3]==$programmecodes){
								if($row[1]=="Compulsory") $compulsory .= $row[0].", ";
								if($row[1]=="Required") $required .= $row[0].", ";
								if($row[1]=="Elective") $elective .= $row[0].", ";
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
	echo "<td colspan='7'>ELECTIVE COURSES:&nbsp;".$elective."</td></tr></table>";
	printfooter(++$page,$lastpage,5);
	$footer = $GLOBALS['footer'];
	echo $footer;

?>
