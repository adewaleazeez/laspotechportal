<?php
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

	global $resultype;
	$resultype = trim($_GET['resultype']);
	if($resultype == null) $resultype = "";

	include("../FusionCharts/Includes/FusionCharts.php");
	include("data.php"); 
	
	//$currentuser = $_COOKIE['currentuser'];
	//$query .= "delete from leaguetable where username='{$currentuser}'";
	//mysql_query($query, $connection);

	function getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		$resultype = $GLOBALS['resultype'];
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$matno}' and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by right(coursecode,3) desc, left(coursecode,3) and gradecode>'' ";
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
		$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and ((sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$matno}' and studentlevel in (SELECT distinct studentlevel FROM registration where regNumber='{$matno}' and studentlevel<= '{$studentlevels}') and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by right(coursecode,3) desc, left(coursecode,3) and gradecode>''";
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

	$coursecodes="";
	$noofcourses=0;
	$query = "SELECT distinct coursecode, coursedescription FROM coursestable where (sessiondescription='{$sessionss}' and semesterdescription='{$semesters}') and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'  order by right(coursecode,3) desc, left(coursecode,3)";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$coursecodes .= $row[0] . "[]" . $row[1] . "][";
			$noofcourses++;
		}
	}
	$coursecodes = substr($coursecodes, 0, strlen($coursecodes)-2);
	$thecoursecodes = explode("][", $coursecodes);

	$query = "SELECT min(a.qualificationcode) as qualification FROM regularstudents a, registration b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
		}
	}
	$gradecodes="";
	$noofgrades=0;
	$query = "SELECT gradecode FROM gradestable where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$gradecodes .= $row[0] . "][";
			$noofgrades++;
		}
	}
	$gradecodes .= "ABS][S][DNR][I" ;
	//$gradecodes = substr($gradecodes, 0, strlen($gradecodes)-2);
	$thegradecodes = explode("][", $gradecodes);
	
	$schoolnames = "";
	$query = "SELECT * FROM schoolinformation where schoolname<>''";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$schoolnames = $row[1] . ", " . $row[2];
		}
	}

	echo "<TABLE border='0'>";
	echo "<TR><TD width='10%' rowspan='7' align='left' style='font-size:30px'><img src='images/Schoologo.png' width='100' height='100' title='School Logo' alt='School Logo'/></td></TR>";
	echo "<TR><TD width='90%' colspan='2' align='center' style='font-size:20px'>".$schoolnames."</td></TR>";
	echo "<TR><TD colspan='2' align='center' style='font-size:20px'>SCHOOL OF ".$facultycodes."</TD></TR>";
	echo "<TR><TD colspan='2' align='center' style='font-size:20px'>DEPARTMENT OF ".$departmentcodes."</TD></TR>";
	echo "<TR><TD colspan='2' align='center' style='font-size:20px'>".$programmecodes." PROGRAMME</TD></TR>";
	echo "<TR><TD colspan='2' align='center' style='font-size:20px'>".$sessionss." ".$semesters." Semester Graphical Reports</TD></TR>";
	echo "<TR><TD colspan='2' align='center' style='font-size:20px'>".$studentlevels."</TD></TR></TABLE><TABLE>";

	//$sumA=0; $sumB=0; 
	$count=0;
	foreach($thecoursecodes as $mycoursecode){
		$mycoursecode = explode("[]", $mycoursecode);
		$coursecode=$mycoursecode[0];
		$coursedescription=$mycoursecode[1];
		$currentcoursecode = str_replace(" ", "", $coursecode);

		$barXMLString= "barXMLString".$currentcoursecode;
		global $$barXMLString;
		$$barXMLString = "";
		$$barXMLString .= "<graph caption='Column Chart Showing Student`s Performance in ".$coursecode." [".$coursedescription."]' xAxisName='Grades' yAxisName='No of Students' decimalPrecision='0'  formatNumberScale='0' rotateNames='0' bgcolor='F1f1f1' numberSuffix=''>";
		
		$pieXMLString= "pieXMLString".$currentcoursecode;
		global $$pieXMLString;
		$$pieXMLString = "";
		$$pieXMLString .= "<graph caption='Pie Chart Showing Student`s Performance in ".$coursecode." [".$coursedescription."]' bgColor='F1f1f1' decimalPrecision='0' showPercentageValues='1' showNames='1' numberprefix='' numbersuffix='' showValues='1' showPercentageInLabel='1' pieYScale='55' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='120'>";

		foreach($thegradecodes as $gradecode){
			$variable= $currentcoursecode.$gradecode;
			global $$variable;
			$$variable=0;

			$query = "SELECT count(*) as total FROM finalresultstable where (facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessionss}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and gradecode='{$gradecode}' and coursecode='{$coursecode}' )";
			$result = mysql_query($query, $connection);
			extract (mysql_fetch_array($result));
			$$variable=$total;

			//$sumB += $total;
			//$sumA += $total;

			$count++;
			$curcolor="";
			if($count==1) $curcolor="F6BD0F";
			if($count==2) $curcolor="8BBA00";
			if($count==3) $curcolor="FF8E46";
			if($count==4) $curcolor="008E8E";
			if($count==5) $curcolor="D64646";
			if($count==6) $curcolor="8E468E";
			if($count==7) $curcolor="588526";
			if($count==8) $curcolor="B3AA00";
			if($count==9) $curcolor="008ED6";
			if($count==10) $curcolor="9D080D";
			if($count==11) $curcolor="A186BE";
			if($count==12) $curcolor="AFD8F8";
			if($count==13) $curcolor="66FFFF";
			if($count==14) $curcolor="FFFF33";
			if($count==15) $curcolor="CC0000";
			if($count==16) $curcolor="6600FF";
			if($count==17) $curcolor="333366";
			if($count==18) $curcolor="FF0000";
			if($count==19) $curcolor="FFFF99";
			if($count==20) {
				$curcolor="000099";
				$count=1;
			}

			$$barXMLString .= "<set name='".$gradecode."' value='".$$variable."' color='".$curcolor."' />";
			if($$variable>0) $$pieXMLString  .= "<set name='".$gradecode."' value='".$$variable."' color='".$curcolor."' />";
		}
		//$sumB=0;
		$$barXMLString .= "</graph>";
		$$pieXMLString .= "</graph>";

		echo "<TR><TD width='47%'>" . renderChartHTML("../FusionCharts/FCF_Column3D.swf", "", $$barXMLString, "myNext", 620, 180) . "</TD>";
		echo "<TD width='6%'>&nbsp;</TD>";
		echo "<TD width='47%'>" . renderChartHTML("../FusionCharts/FCF_Pie3D.swf", "", $$pieXMLString, "myNext", 620, 270) . "</TD></TR>";
		echo "<TR><TD colspan='2'>&nbsp;</TD></TR>";
	}
	echo "</TABLE>";
?>
