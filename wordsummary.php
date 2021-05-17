<?php
	header("Content-type: application/msword"); 
	header("Content-Disposition: attachment; filename=msword.doc"); 
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

	global $header;
	global $footer;
	global $page;
	$GLOBALS['page']=0;

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

	global $globalrepoline;
	$GLOBALS['globalrepoline']="";
	function displayReport($repotype,$sessions,$semesters,$facultycodes,
		$departmentcodes,$programmecodes,$studentlevels,$finalyear){

		include("data.php"); 
		

		$reportline = array();
		
		$query = "SELECT b.*, a.*  FROM regularstudents AS a INNER JOIN finalresultstable AS b 
		ON (a.regNumber = b.registrationnumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.sessiondescription='{$sessions}' and b.semester='{$semesters}' and b.studentlevel='{$studentlevels}' and a.active='Yes')  order by b.registrationnumber, b.coursecode";

		$result = mysql_query($query, $connection);

		if(mysql_num_rows($result) > 0){
			$count=1;
			$matno="";
			$therepoline="";
			$matnofullnamegender="";
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

						if($repotype=="1PASSES"){
							if(str_in_str($remarks,"Passed")){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="2COMMENDATION"){
							if(doubleval($theCurGPs[2])>=4.50){
								$therepoline .= "<td align='center'>".number_format($theCurGPs[2],2)."</td><td align='center'>".$theCurGPs[3]."</td><td>".$remarks."</td></tr>";
								$GLOBALS['globalrepoline'] .= $matnofullnamegender.$theCurGPs[2]."][".$theCurGPs[3]."][".$remarks."][$repotype~_~";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="3REFERENCES"){
							if(!str_in_str($remarks,"Passed")){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="4COUNSELLING"){
							if(doubleval($theCurGPs[2])<1.0){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="5PROBATION"){
							if($cgpa<1.0){
								$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
								$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
								$reportline[]=array('line'=>$therepoline,);
							}else{
								--$count;
							}
						}
						if($repotype=="6WITHDRAWAL"){
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
									$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
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
						$matnofullnamegender = $row2[0]."][".$fullname."][".$row2[4]."][";
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
			if($repotype=="1PASSES"){
				if(str_in_str($remarks,"Passed")){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="2COMMENDATION"){
				if(doubleval($theCurGPs[2])>=4.50){
					$therepoline .= "<td align='center'>".number_format($theCurGPs[2],2)."</td><td align='center'>".$theCurGPs[3]."</td><td>".$remarks."</td></tr>";
					$GLOBALS['globalrepoline'] .= $matnofullnamegender.$theCurGPs[2]."][".$theCurGPs[3]."][".$remarks."][$repotype~_~";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="3REFERENCES"){
				if(!str_in_str($remarks,"Passed")){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="4COUNSELLING"){
				if(doubleval($theCurGPs[2])<1.0){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="5PROBATION"){
				if($cgpa<1.0){
					$therepoline .= "<td align='center'>".number_format($cgpa,2)."</td><td align='center'>".$ctnup."</td><td>".$remarks."</td></tr>";
					$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
					$reportline[]=array('line'=>$therepoline,);
				}else{
					--$count;
				}
			}
			if($repotype=="6WITHDRAWAL"){
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
						$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype~_~";
						$reportline[]=array('line'=>$therepoline,);
					}
				}else{
					--$count;
				}
			}
		}

		$counter=--$count;
		if($counter<=0) $counter="";
		$groupheader="";

		$counting=0;

	}

	function getSuspended($repotype,$sessions,$semesters,$facultycodes,
		$departmentcodes,$programmecodes,$studentlevels,$finalyear){
		
		include("data.php"); 
		
		$reportline = array();
		$therepoline="";
		$count=0;
	
		$query = "SELECT regNumber, firstName, lastName, middleName, gender, gpa, tnup FROM regularstudents where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' order by gpa, regNumber";
		$result = mysql_query($query, $connection);
		global $numberofcandidatesinclass;
		$numberofcandidatesinclass = mysql_num_rows($result);

		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			if($repotype=="7SUSPENSION"){ // If the student didn't register for semester then.
				$query2 = "SELECT * FROM finalresultstable where registrationnumber='{$row[0]}' and sessiondescription='{$sessions}' and studentlevel='{$studentlevels}'";
				$result2 = mysql_query($query2, $connection);
				// If the student also didn't register for session then don't print.
				if(mysql_num_rows($result2) <= 0) continue;

				$query2 = "SELECT * FROM finalresultstable where registrationnumber='{$row[0]}' and sessiondescription='{$sessions}' and semester='{$semesters}' and studentlevel='{$studentlevels}'";
			}

			if($repotype=="8DETERMINATION"){
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
				$GLOBALS['globalrepoline'] .= $row[0]."][".$fullname."][".$row[4]."][".$gpa."][".$tnup."][".$remarks."][$repotype~_~";
			}
		}
		$counter=$count;
		$groupheader="";
		if($counter<=0) $counter="";
		$counting=0;
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


		$colspan = 7;
		$GLOBALS['header'] =  "<table border='3' style='border-color:#000000; border-style:solid; border-width:1px; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";

		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>".$schoolnames."</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>".$facultycodes."</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>DEPARTMENT OF ".$departmentcodes."</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h3>".$programmecodes." PROGRAMME</h3></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h5>".$sessions." ".$semesters." Semester Examination Results</h5></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h5>SUMMARY OF RESULTS</h5></td></tr>";

		$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['header'] .=  "<td colspan='".$colspan."' align='center'><h5>".$studentlevels."</h5></td></tr>";
	}

	function printheadersummary($gheader,$recordno){
		//$GLOBALS['header'] = "<tr><td colspan='7'>&nbsp;</td></tr>";
		$GLOBALS['header'] = "";
		if($gheader=="1PASSES"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>A. PASSES</td></tr>";

			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The following ".$recordno." Candidate(s) have Passed all the Compulsory/Required Courses and have Fulfilled all other University Requirements";
			global $numberofcandidateswhopassedexam;
			$numberofcandidateswhopassedexam = $recordno;
		}

		if($gheader=="2COMMENDATION"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>B. RECOMMENDED FOR COMMENDATION</td></tr>";
			
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The following ".$recordno." Candidate(s) are Recommended for University Commendation for having a Current GPA of 4.50 and above";
			global $numberofcandidatesforcommendation;
			$numberofcandidatesforcommendation = $recordno;
		}

		if($gheader=="3REFERENCES"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>C. REFERENCES</td></tr>";

			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The following ".$recordno." Candidate(s) have Course(s) listed against their names to take or repeat at the next available opportunity";
			global $numberofcandidateswithreference;
			$numberofcandidateswithreference = $recordno;
		}

		if($gheader=="4COUNSELLING"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>D. RECOMMENDED FOR FACULTY COUNSELLING</td></tr>";

			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The following ".$recordno." Candidate(s) are Recommended for School Counselling for having a Current GPA of less than 1.00 in the Semester";
			global $numberofcandidatesforcounselling;
			$numberofcandidatesforcounselling = $recordno;
		}

		if($gheader=="5PROBATION"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>E. RECOMMENDED FOR UNIVERSITY PROBATION</td></tr>";

			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The following ".$recordno." Candidate(s) are Recommended for University Probation for having a Cummulative GPA of less than 1.00 in the Semester";
			global $numberofcandidatesforprobation;
			$numberofcandidatesforprobation = $recordno;
		}

		if($gheader=="6WITHDRAWAL"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>F. RECOMMENDED FOR WITHDRAWAL</td></tr>";

			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The following ".$recordno." Candidate(s) are Recommended for Withdrawal for having a Cummulative GPA of less than 1.00 in two Consecutive Semesters";
			global $numberofcandidatesforwithdrawal;
			$numberofcandidatesforwithdrawal = $recordno;
		}

		if($gheader=="7SUSPENSION"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>G. RECOMMENDED FOR SUSPENSION OF STUDENTSHIP</td></tr>";

			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The Studentship of the following ".$recordno." Candidate(s) is Recommended for Suspension for failing to Register for the Semester";
			global $numberofcandidatesforsuspension;
			$numberofcandidatesforsuspension = $recordno;
		}

		if($gheader=="8DETERMINATION"){
			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>H. RECOMMENDED FOR DETERMINATION OF STUDENTSHIP</td></tr>";

			$GLOBALS['header'] .= "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .= "<td colspan='7'>The Studentship of the following ".$recordno." Candidate(s) are Recommended for Determination for failing to Register for the Session";
			global $numberofcandidatesfordetermination;
			$numberofcandidatesfordetermination = $recordno;
		}

		if($recordno==0){
			$GLOBALS['header'] .=  "&nbsp;Nil</td></tr>";
			$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .=  "<td colspan='7'>&nbsp;</td></tr>";
		}else{
			$GLOBALS['header'] .=  "</td></tr>";
			$GLOBALS['header'] .=  "<tr style='font-weight:bold; color:#000000'>";
			$GLOBALS['header'] .=  "<td align='right'>S/NO</td><td>MATRIC NO</td><td>FULL NAME</td>";
			$GLOBALS['header'] .=  "<td>SEX</td><td align='center'>CGPA</td><td align='center'>CTNUP</td>";
			$GLOBALS['header'] .=  "<td>REMARKS</td></tr>";
		}
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
		$lines = ($lines) + 3;
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
		if($GLOBALS['finalyear']=="Yes"){
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>SGD</td>";
		}else{
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		}
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>SGD</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>______________________________</td>";
		if($GLOBALS['finalyear']=="Yes"){
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>______________________________</td>";
		}else{
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		}
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>______________________________</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>".$hods."</td>";
		if($GLOBALS['finalyear']=="Yes"){
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>".$courseadvisors."</td>";
		}else{
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		}
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>".$dofs."</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>HOD GRP</td>";
		if($GLOBALS['finalyear']=="Yes"){
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>EXTERNAL EXAMINER</td>";
		}else{
			$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		}
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>DEAN FSMS</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr></table>";

		$GLOBALS['footer'] .=  "<table border='0' style='border-color:#000000; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'>";
		
		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='30%' align='center'>&nbsp;</td>";
		$GLOBALS['footer'] .=  "<td width='5%' align='center'>&nbsp;</td></tr>";

		$GLOBALS['footer'] .=  "<tr style='font-weight:bold; color:#000000'>";
		$GLOBALS['footer'] .=  "<td width='100%' align='right'>Page ".$page." of ".$lastpage."</td></tr></table>";

		if($page<$lastpage)
			$GLOBALS['footer'] .=  "<br clear=all style='mso-special-character:line-break;page-break-before:always'>";
	}
		
	displayReport("1PASSES",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("2COMMENDATION",$sessions,$semesters,$facultycodes,$departmentcodes,
	$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("3REFERENCES",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("4COUNSELLING",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("5PROBATION",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	displayReport("6WITHDRAWAL",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	getSuspended("7SUSPENSION",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	getSuspended("8DETERMINATION",$sessions,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>&nbsp;</td></tr>";

	//echo "<tr style='font-weight:bold; color:#000000'>";
	//echo "<td colspan='7'>SUMMARY</td></tr>";



//foreach($reportline as $code) {
//	echo $code['line'];


	$query = "delete from summaryreport";
	mysql_query($query, $connection);

	$GLOBALS['globalrepoline'] = substr($GLOBALS['globalrepoline'],0,strlen($GLOBALS['globalrepoline'])-3);
	$globalarray = explode("~_~", $GLOBALS['globalrepoline']);
	$reportline = array();
	for($k=0; $k<count($globalarray); $k++){
		$glb = explode("][", $globalarray[$k]);
		$query = "insert into summaryreport (matricno,fullname,gender,cgpa,ctnup,remark,reporttype) values ('{$glb[0]}','{$glb[1]}','{$glb[2]}',{$glb[3]},{$glb[4]},'{$glb[5]}','{$glb[6]}')";
		mysql_query($query, $connection);
	}

	function countRecords($reporttype){
		include("data.php"); 
		
		$query = "select count(*) as noofrows from summaryreport where reporttype='{$reporttype}'";
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
		}
		return $noofrows;
	}

	//$query = "select distinct reporttype from summaryreport order by reporttype";
	//$result = mysql_query($query, $connection);
	//$headerlines = (8 - mysql_num_rows($result)) * 3;

	$query = "select * from summaryreport order by reporttype, cgpa desc";
	$result = mysql_query($query, $connection);
	$reportines = mysql_num_rows($result);

	//$totalines = $headerlines + $reportines;
	$totalines = 24 + $reportines;

	$lastpage= intval($totalines/23);
	++$lastpage;
	if(($totalines % 23)>0) ++$lastpage;
	
	$repotype="";
	$page=0;
	$counter=0; //for all lines
		
	$repotypes = "1PASSES~_~2COMMENDATION~_~3REFERENCES~_~4COUNSELLING~_~5PROBATION~_~6WITHDRAWAL~_~";
	$repotypes .= "7SUSPENSION~_~8DETERMINATION";
	$therepotypes = explode("~_~",$repotypes);

	for($k=0; $k<count($therepotypes); $k++){

		$query = "select distinct reporttype from summaryreport where reporttype='{$therepotypes[$k]}'";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$query = "select * from summaryreport where reporttype='{$therepotypes[$k]}' order by reporttype, cgpa desc";
			$result = mysql_query($query, $connection);

			if(mysql_num_rows($result) > 0){
				if($counter == 0){
					$counter=3;
					printheader();
					$header = $GLOBALS['header'];
					echo $header;
					printheadersummary($therepotypes[$k],mysql_num_rows($result));
					$header = $GLOBALS['header'];
					echo $header;
				/*}else if(($counter + 3) == 23){
					$counter=0;
					printheadersummary($therepotypes[$k],mysql_num_rows($result));
					$header = $GLOBALS['header'];
					echo $header;
					printfooter(++$page,$lastpage,0);
					$footer = $GLOBALS['footer'];
					echo $footer;*/
				}else if(($counter + 3) < 23){
					$counter += 3;
					printheadersummary($therepotypes[$k],mysql_num_rows($result));
					$header = $GLOBALS['header'];
					echo $header;
				}else if(($counter + 3) >= 23){
					if($count <= $reportines){
						printfooter(++$page,$lastpage,0);
						$footer = $GLOBALS['footer'];
						echo $footer;
					}
					$counter=3;
					printheader();
					$header = $GLOBALS['header'];
					echo $header;
					printheadersummary($therepotypes[$k],mysql_num_rows($result));
					$header = $GLOBALS['header'];
					echo $header;
				}
				$count=0;
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					/*if($reporttype>$repotype){
						$noofrows=countRecords($reporttype);
						printheadersummary($reporttype,$noofrows);
						$header = $GLOBALS['header'];
						echo $header;
						$repotype = $reporttype;
						$counter=3; //for header
					}*/
					echo "<tr style='font-weight:bold; color:#000000'>";
					echo "<td align='right'>".++$count.".</td><td>".$row[1]."</td>";
					echo "<td>".$row[2]."</td><td>".$row[3]."</td>";
					echo "<td align='center'>".number_format($row[4],2)."</td>";
					echo "<td align='center'>".number_format($row[5])."</td><td>".$row[6]."</td></tr>";
					$counter++;
					if(((($counter) % 23)==0)){
						$counter=0;
						printfooter(++$page,$lastpage,0);
						$footer = $GLOBALS['footer'];
						echo $footer;
						if($page<($lastpage-1) && $count < $reportines){
							printheader();
							//printheadersummary($reporttype,$noofrows);
							$header = $GLOBALS['header'];
							echo $header;
							echo "<tr><td colspan='7'>&nbsp;</td></tr>";
							echo "<tr style='font-weight:bold; color:#000000'>";
							echo "<td align='right'>S/NO</td><td>MATRIC NO</td><td>FULL NAME</td>";
							echo "<td>SEX</td><td align='center'>CGPA</td><td align='center'>CTNUP</td>";
							echo "<td>REMARKS</td></tr>";
						}
					}
				}
			}
		}else{
			if($counter == 0){
				$counter=3;
				printheader();
					$header = $GLOBALS['header'];
					echo $header;
				printheadersummary($therepotypes[$k],"");
				$header = $GLOBALS['header'];
				echo $header;
			}else if(($counter + 3) == 23){
				$counter=0;
				printheadersummary($therepotypes[$k],"");
				$header = $GLOBALS['header'];
				echo $header;
				printfooter(++$page,$lastpage,0);
				$footer = $GLOBALS['footer'];
				echo $footer;
			}else if(($counter + 3) < 23){
				$counter += 3;
				printheadersummary($therepotypes[$k],"");
				$header = $GLOBALS['header'];
				echo $header;
			}else if(($counter + 3) > 23){
				//if($count <= $reportines){
					printfooter(++$page,$lastpage,0);
					$footer = $GLOBALS['footer'];
					echo $footer;
				//}
				$counter=3;
				printheader();
					$header = $GLOBALS['header'];
					echo $header;
				printheadersummary($therepotypes[$k],"");
				$header = $GLOBALS['header'];
				echo $header;
			}
		}
	}
	//echo $header;
	printfooter(++$page,$lastpage,0);
	$footer = $GLOBALS['footer'];
	echo $footer;


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

	printheader();
	$header = $GLOBALS['header'];
	echo $header;
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

	printfooter(++$page,$lastpage,-2);
	$footer = $GLOBALS['footer'];
	echo $footer;
	//}else{
	//	echo "<table><tr><td>Sorry!!! No records found</td></tr></table>";
	//}
?>
