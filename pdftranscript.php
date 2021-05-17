<?php
	if($_COOKIE["currentuser"]==null || $_COOKIE["currentuser"]==""){
		echo '<script>alert("You must login to access this page!!!\n Click Ok to return to Login page.");</script>';
		echo '<script>window.location = "login.php";</script>';
		return true;
	}

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

	global $sessionssA;
	$sessionssA = $sessionss;

	global $semesters;
	$semesters = trim($_GET['semester']);
	if($semesters == null) $semesters = "";

	global $sessionssB;
	$sessionssB = $semesters;

	$matricno = trim($_GET['matricno']);
	if($matricno == null) $matricno = "";

	global $finalyear;
	$finalyear = trim($_GET['finalyear']);
	if($finalyear == null) $finalyear = "";

	global $awardate;
	$awardate = trim($_GET['awardate']);
	if($awardate == null) $awardate = "";

	global $noofcourses;
	global $noofrepeatcourses;
	global $tmp_finalresultstable;
	global $thefirstsession;

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

	$matricno=substr($matricno, 0, strlen($matricno)-2);
	$matricno = explode("][", $matricno);
	$regnolist="";
	foreach($matricno as $code) $regnolist.="'".$code."', ";
	$regnolist=substr($regnolist, 0, strlen($regnolist)-2);

	$tmp_finalresultstable="tmp_".date("Y_m_d_H_i_s")."_finalresultstable";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_finalresultstable}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_finalresultstable="tmp_".date("Y_m_d_H_i_s")."_finalresultstable";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_finalresultstable." select * from finalresultstable limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_finalresultstable."   MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_finalresultstable." SELECT * FROM finalresultstable where registrationnumber IN (".$regnolist.")  ";
	mysql_query($query, $connection);

	$tmp_coursestable="tmp_".date("Y_m_d_H_i_s")."_coursestable";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_coursestable}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_coursestable="tmp_".date("Y_m_d_H_i_s")."_coursestable";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_coursestable." select * from coursestable limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_coursestable." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	// and sessiondescription ='{$sessionss}' and semesterdescription ='{$semesters}' and studentlevel ='{$studentlevels}'
	$query = "insert into ".$tmp_coursestable." SELECT * FROM coursestable where facultycode ='{$facultycodes}' and departmentcode ='{$departmentcodes}' and programmecode ='{$programmecodes}' ";
	mysql_query($query, $connection);

	$tmp_regularstudents="tmp_".date("Y_m_d_H_i_s")."_regularstudents";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_regularstudents}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_regularstudents="tmp_".date("Y_m_d_H_i_s")."_regularstudents";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_regularstudents." select * from regularstudents limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_regularstudents." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_regularstudents." SELECT * FROM regularstudents where regNumber IN (".$regnolist.")  ";
	mysql_query($query, $connection);

	$tmp_registration="tmp_".date("Y_m_d_H_i_s")."_registration";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_registration}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_registration="tmp_".date("Y_m_d_H_i_s")."_registration";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_registration." select * from registration limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_registration." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_registration." SELECT * FROM registration where regNumber IN (".$regnolist.")  ";
	mysql_query($query, $connection);

	$query = "select min(sessions) as firstsession from ".$tmp_registration." where regNumber IN (".$regnolist.")  ";
	$result = mysql_query($query, $connection);
	extract (mysql_fetch_array($result));
	$thefirstsession=$firstsession;

	$tmp_retakecourses="tmp_".date("Y_m_d_H_i_s")."_retakecourses";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_retakecourses}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_retakecourses="tmp_".date("Y_m_d_H_i_s")."_retakecourses";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_retakecourses." select * from retakecourses limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_retakecourses." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_retakecourses." SELECT * FROM retakecourses where registrationnumber IN (".$regnolist.")  ";
	mysql_query($query, $connection);

	$tmp_gradestable="tmp_".date("Y_m_d_H_i_s")."_gradestable";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_gradestable}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_gradestable="tmp_".date("Y_m_d_H_i_s")."_gradestable";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_gradestable." select * from gradestable limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_gradestable." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_gradestable." SELECT * FROM gradestable where sessions='{$sessionss}' ";
	mysql_query($query, $connection);

	$tmp_cgpatable="tmp_".date("Y_m_d_H_i_s")."_cgpatable";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_cgpatable}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_cgpatable="tmp_".date("Y_m_d_H_i_s")."_cgpatable";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_cgpatable." select * from cgpatable limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_cgpatable." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_cgpatable." SELECT * FROM cgpatable where sessions='{$sessionss}' ";
	mysql_query($query, $connection);

	$tmp_remarkstable="tmp_".date("Y_m_d_H_i_s")."_remarkstable";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_remarkstable}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_remarkstable="tmp_".date("Y_m_d_H_i_s")."_remarkstable";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_remarkstable." select * from remarkstable limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_remarkstable." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_remarkstable." SELECT * FROM remarkstable where matricno IN (".$regnolist.")  ";
	mysql_query($query, $connection);

	function getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		include("data.php"); 
		$tmp_finalresultstable = $GLOBALS['tmp_finalresultstable'];
		$tmp_coursestable = $GLOBALS['tmp_coursestable'];
		$tmp_remarkstable = $GLOBALS['tmp_remarkstable'];

		$query = "SELECT * FROM ".$tmp_finalresultstable." where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$matno}' and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by serialno, right(coursecode,3) desc, left(coursecode,3)";
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM ".$tmp_coursestable." where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' ";
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
		$str = $tcp ."][". $tnu ."][". $gpa ."][". $tnup;

		$queryRemark = "update ".$tmp_remarkstable." set currtcp='{$tcp}', currtnu='{$tnu}', currgpa='{$gpa}', currtnup='{$tnup}' where matricno='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
		mysql_query($queryRemark, $connection);

		return $str;
	}

	function getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		include("data.php"); 
		$tmp_finalresultstable = $GLOBALS['tmp_finalresultstable'];
		$tmp_coursestable = $GLOBALS['tmp_coursestable'];
		$tmp_registration = $GLOBALS['tmp_registration'];
		$tmp_remarkstable = $GLOBALS['tmp_remarkstable'];


		$query = "SELECT * FROM ".$tmp_finalresultstable." where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and ((sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$matno}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$matno}' and studentlevel<= '{$studentlevels}') and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by serialno, right(coursecode,3) desc, left(coursecode,3) ";
		$programmecodes = $GLOBALS['programmecodes'];
//echo $query."<br><br>";
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM ".$tmp_coursestable." where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' and studentlevel='{$row[8]}' "; 
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
		$str = $tcp ."][". $tnu ."][". $gpa ."][". $tnup;

		$queryRemark = "update ".$tmp_remarkstable." set prevtcp='{$tcp}', prevtnu='{$tnu}', prevgpa='{$gpa}', prevtnup='{$tnup}' where matricno='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
		mysql_query($queryRemark, $connection);

		return $str;
	}


//if($regno=='ACC/P.086011024') echo $failedcourses." 5 $regno<br><br>";*/
	//$query = "delete from ".$tmp_remarkstable."";
	mysql_query($query, $connection);

	function getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $regno, $finalyear, $cgpa, $ctnup){
		//, $groupsessions
		$tmp_finalresultstable = $GLOBALS['tmp_finalresultstable'];
		$tmp_coursestable = $GLOBALS['tmp_coursestable'];
		$tmp_regularstudents = $GLOBALS['tmp_regularstudents'];
		$tmp_registration = $GLOBALS['tmp_registration'];
		$tmp_retakecourses  = $GLOBALS['tmp_retakecourses'];
		$tmp_remarkstable = $GLOBALS['tmp_remarkstable'];

		include("data.php"); 

		$query = "SELECT min(sessions) as firstsession FROM ".$tmp_registration." where regNumber='{$regno}'  ";
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

		$query = "SELECT admissiontype FROM ".$tmp_regularstudents." where regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
			}
		}

		$query = "select max(minimumscore) as minimumscore from ".$tmp_coursestable." where  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

		/*$query2 = "SELECT carryover, admissiontype FROM ".$tmp_regularstudents."  where regNumber='{$regno}' ";
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
				$parameters[$t]=trim($parameters[$t]);
				if(str_in_str($resultype,"Amendment")){
					$query = "SELECT * FROM amendedresults where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and previousmark>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and amendedtitle ='{$resultype}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcourses,$parameters[$t])) 
							$failedcourses .= $parameters[$t]."~".$minimumscore."][";
					}

					$query = "SELECT * FROM amendedresults where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and amendedmark>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and amendedtitle ='{$resultype}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcoursesAmended,$parameters[$t])) 
							$failedcoursesAmended .= $parameters[$t]."~".$minimumscore."][";
					}
				}else{
					$query = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and marksobtained>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						if(!str_in_str($failedcourses,$parameters[$t])) 
							$failedcourses .= $parameters[$t]."~".$minimumscore."][";
					}
				}
			}
		}*/

		$queryPrevSession = "SELECT * from ".$tmp_registration." where regnumber='{$regno}' and (sessions<'{$sessionss}' or (sessions='{$sessionss}' and semester<'{$semesters}'))  order by sessions desc, semester desc ";
		$resultPrevSession = mysql_query($queryPrevSession, $connection); 
		$PrevSession="";
		$PrevSemester="";
		$lastserialno=0;
		if(mysql_num_rows($resultPrevSession)>0){
			while ($rowPrevSession = mysql_fetch_array($resultPrevSession)) {
				$PrevSession=$rowPrevSession[3];
				$PrevSemester=$rowPrevSession[4];
				break;
			}
			$queryPrevRemark = "SELECT serialno from ".$tmp_remarkstable." where matricno='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$PrevSession}' and semester='{$PrevSemester}' ";
//echo date("Y-m-d H:i:s")."  $queryPrevRemark<br>";
			$resultPrevRemark = mysql_query($queryPrevRemark, $connection);
			if(mysql_num_rows($resultPrevRemark) > 0){
				extract (mysql_fetch_array($resultPrevRemark));
				$lastserialno=$serialno;
			}
		}

		$query2 = "SELECT remark FROM ".$tmp_remarkstable."  where serialno='{$lastserialno}' ";
//echo date("Y-m-d H:i:s")."   $query2   <br> <br>";
		$result2 = mysql_query($query2, $connection);
		$allprevious=true;
		if(mysql_num_rows($result2)>0){
			$retakecourses="";
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				$retakecourses=$row2[0];
			}
//echo $retakecourses." $lastserialno    1    $regno<br><br>";
			if($retakecourses!=null && $retakecourses!="Passed" && strlen($retakecourses)>0){
				$allprevious=false;
				$parameters = explode(",", $retakecourses);
				for($t=0;$t<count($parameters);$t++){
					$parameters[$t]=trim($parameters[$t]);
					$query = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and marksobtained>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					if(!$allprevious) $query = "SELECT * FROM ".$tmp_finalresultstable." where registrationnumber='{$regno}' and  coursecode='{$parameters[$t]}' and marksobtained>=$minimumscore and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
//echo date("Y-m-d H:i:s")."   $query   <br> <br>";
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
			if($allprevious) $query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM ".$tmp_coursestable." a, ".$tmp_registration." b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Required', 'Compulsory') and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' order by a.serialno, a.coursecode ";
			
			if(!$allprevious) $query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM ".$tmp_coursestable." a, ".$tmp_registration." b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Required', 'Compulsory') and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and b.sessions='{$sessionss}' and b.semester='{$semesters}' and b.sessions>='{$firstsession}' order by a.serialno, a.coursecode ";
			$result2 = mysql_query($query2, $connection);
			$usedcourse="";
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				if(str_in_str($usedcourse,$row2[0])) continue;
				
				$query = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";

				if(!$allprevious) $query = "SELECT * FROM ".$tmp_finalresultstable." where registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
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
				$query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM ".$tmp_coursestable." a, ".$tmp_registration." b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Elective') and a.coursetypegroup='{$groupcode}' and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' order by a.serialno, a.coursecode ";

				if(!$allprevious) $query2 = "SELECT a.coursecode, a.courseunit, a.minimumscore, a.coursetype, a.studentlevel, a.sessiondescription, a.semesterdescription FROM ".$tmp_coursestable." a, ".$tmp_registration." b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.coursetype in ('Elective') and a.coursetypegroup='{$groupcode}' and a.studentlevel=b.studentlevel and a.sessiondescription=b.sessions  and a.semesterdescription=b.semester and b.regNumber='{$regno}' and a.studentype in ('PCE', 'Both') and b.sessions='{$sessionss}' and b.semester='{$semesters}' and b.sessions>='{$firstsession}' order by a.serialno, a.coursecode ";
				$result2 = mysql_query($query2, $connection);
				$mycounter=0;
				$usedcourse="";
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					if(str_in_str($usedcourse,$row2[0])) continue;
					$mycounter++;

					$query = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";

					if(!$allprevious) $query = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";

					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						$query3 = "SELECT b.*, a.minimumscore FROM ".$tmp_coursestable." a, ".$tmp_retakecourses." b  where ((b.sessiondescription='{$sessionss}' and b.semester='{$semesters}') or (b.sessiondescription='{$sessionss}' and b.semester<'{$semesters}') or (b.sessiondescription<'{$sessionss}')) and b.sessiondescription>='{$firstsession}' and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and a.coursetype='Elective'  and a.studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}' ) and b.coursestatus='Ignore PCE'";

						if(!$allprevious) $query3 = "SELECT b.*, a.minimumscore FROM ".$tmp_coursestable." a, ".$tmp_retakecourses." b  where b.sessiondescription='{$sessionss}' and b.semester='{$semesters}' and b.sessiondescription>='{$firstsession}' and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and a.coursetype='Elective'  and a.studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}' ) and b.coursestatus='Ignore PCE'";

						$result3 = mysql_query($query3, $connection);
						if(mysql_num_rows($result3)==0){
							if(!str_in_str($failedcourses,$row2[0])){

								// Check if course is attempted, if yes, record it
								$query4 = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";

								if(!$allprevious) $query4 = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";

								$result4 = mysql_query($query4, $connection);
								if(mysql_num_rows($result4)>0 && $foundflag==false){
									 $failedcourses .= $row2[0]."~".$row2[2]."][";
									 $foundflag=true;
								}
								if(mysql_num_rows($result2)==$mycounter && $foundflag==false) $failedcourses .= $row2[0]."~".$row2[2]."][";
							}
						}
					}else{
						break;
					}
					$usedcourse .=  $row2[0];
				}
			}
		}		
//echo $failedcourses." 5 $regno<br><br>";

		$remarks="";
		if($failedcourses>""){
			if($failedcourses!="") 
				$failedcourses = substr($failedcourses, 0, strlen($failedcourses)-2);
			$splitfailedcourses = explode("][", $failedcourses);
			foreach($splitfailedcourses as $code){
				$minimumscore = explode("~", $code);
				//if($minimumscore[0]==null || $minimumscore[0]=="") break;
				$query2 = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";

				if(!$allprevious) $query2 = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";

				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2) == 0 && !str_in_str($remarks,$minimumscore[0]))		
					$remarks .= $minimumscore[0].",  ";
			}
		}
		if($remarks!="") $remarks = substr($remarks, 0, strlen($remarks)-3);

		$myremarks=$remarks;
		if($finalyear=="Yes" || str_in_str($studentlevels,"NDIII") || str_in_str($studentlevels,"HNDIII")){
			if($remarks==""){
				$query = "SELECT minimumunit,qualificationcode FROM ".$tmp_regularstudents." where  regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";

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
					$query = "SELECT min(qualificationcode) as qualification FROM ".$tmp_regularstudents." where regNumber='{$regno}' ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
						}
					}
					$query = "SELECT * FROM ".$tmp_cgpatable." where qualification = '{$qualification}' and sessions='{$sessionss}' and {$cgpa}>=lowerrange and {$cgpa}<=upperrange";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
							$remarks = "NR (Passed, ".$cgpacode.")";
							if(str_in_str($cgpacode, "FAIL")) $remarks = "NR (Failed, ".$cgpacode.")";
						}
					}
				}
			}else{
				$remk = explode(", ", $remarks);
				$theremark = "R".trim(count($remk));
				$remarks = $theremark." ()".$remarks;
			}
		}else{
			if($remarks=="") {
				$remarks="NR (Passed)";
			}else{
				$remk = explode(", ", $remarks);
				$theremark = "R".trim(count($remk));
				$remarks = $theremark." ()".$remarks;
			}
		}
		$GLOBALS['theremark']=$theremark;

		$queryRemark = "update ".$tmp_remarkstable." set remark='{$myremarks}', RR='{$str}' where matricno='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
		mysql_query($queryRemark, $connection);

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
			$this->Cell(220,7,"SCHOOL OF ".$facultycodes,0,0,'C');
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
			$tmp_regularstudents = $GLOBALS['tmp_regularstudents'];
			$tmp_registration = $GLOBALS['tmp_registration'];
			$tmp_gradestable = $GLOBALS['tmp_gradestable'];
			$tmp_cgpatable = $GLOBALS['tmp_cgpatable'];


			$query = "SELECT min(a.qualificationcode) as qualification FROM ".$tmp_regularstudents." a, ".$tmp_registration." b where a.regNumber=b.regNumber and b.sessions='{$sessionss}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' ";
			//and b.semester='{$semesters}' 
//echo $query.'<br><br>';
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
				}
			}

			$this->SetY(-42);
			$this->SetFont('Times','B',5.5);
			//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			$currentY=$this->GetY();
			$this->Cell(60,3,'GRADES TABLE',0,0,'C');
			$this->Ln();
			$query = "SELECT * FROM ".$tmp_gradestable." where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC ";
//echo $query.'<br><br>';
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$this->Cell(20,3,"MARKS RANGE",1,0,'C');
				$this->Cell(20,3,"LETTER GRADE",1,0,'C');
				$this->Cell(20,3,"CREDIT POINT",1,0,'C');
				$this->Ln();
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$this->Cell(20,3,$lowerrange."% - ".$upperrange."%",1,0,'C');
					$this->Cell(20,3,$gradecode,1,0,'C');
					$this->Cell(20,3,number_format($gradeunit,1),1,0,'C');
					$this->Ln();
				}
			}
			//$this->Ln(2);
			//$this->Cell(25,3,'*Delete as appropriate',0,0,'L');
			
			$this->SetY($currentY);
			$this->SetX($this->GetX()+140);
			$this->Cell(45,3,'CUMMULATIVE GRADE POINT AVERAGE (CGPA)',0,0,'C');
			$this->Ln();
			$query = "SELECT * FROM ".$tmp_cgpatable." where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC";
//echo $query.'<br><br>';
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$this->SetX($this->GetX()+140);
				$this->Cell(25,3,"CLASSIFICATION",1,0,'L');
				$this->Cell(20,3,"RANGE",1,0,'C');
				$this->Ln();
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$this->SetX($this->GetX()+140);
					$this->Cell(25,3,$cgpacode,1,0,'L');
					$this->Cell(20,3,number_format($lowerrange,1)." - ".number_format($upperrange,1),1,0,'C');
					$this->Ln();
				}
			}
			$this->Ln(12);
			$this->SetX($this->GetX()+117);
			$this->Cell(70,3,'CERTIFIED BY REGISTRAR','T',0,'C');
		}
	}

	$coursecount = "";
	function doCoursesCount($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters){
		$GLOBALS['noofcourses']=0;
		$GLOBALS['noofrepeatcourses']=0;
		$tmp_coursestable = $GLOBALS['tmp_coursestable'];
		$thefirstsession = $GLOBALS['thefirstsession'];

		$key=$facultycodes.$departmentcodes.$programmecodes.$studentlevels.$sessionss.$semesters;
		if(strpos($coursecount,$key)){
			$splitcoursecount = explode("|!|",$coursecount);
			foreach($splitcoursecount as $code){
				$coursecountsplit = explode("!|!", $code);
				if($coursecountsplit[0]==$key){
					$GLOBALS['noofcourses']=$coursecount[$key][0];
					$GLOBALS['noofrepeatcourses']=$coursecount[$key][1];
					return true;
				}
			}
		}
		include("data.php"); 
		$query = "SELECT distinct coursecode, coursetype FROM ".$tmp_coursestable." where (sessiondescription='{$sessionss}' and semesterdescription='{$semesters}') and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'  order by serialno, right(coursecode,3) desc, left(coursecode,3)";
		$result = mysql_query($query, $connection);
	//echo "A   ".$query."   <br><br>";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode FROM ".$tmp_coursestable." where (sessiondescription<'{$sessionss}' or (sessiondescription='{$sessionss}' and semesterdescription<'{$semesters}')) and sessiondescription>'{$thefirstsession}' and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel!='{$studentlevels}' and coursecode='{$row[0]}' ";
	//echo "A1   ".$query2."   <br><br>";
				$result2 = mysql_query($query2, $connection);
				if(mysql_num_rows($result2)>0) {
					$GLOBALS['noofrepeatcourses']++;
				}
				$GLOBALS['noofcourses']++;
			}
		}
		$coursecount.=$key."!|!".$GLOBALS['noofcourses']."!|!".$GLOBALS['noofrepeatcourses']."|!|";
	}

	$pdf = new PDF();
	/*$today = date("Y-m-d");
	if($today>="2012-07-01"){
		$pdf->SetFont('Times','B',15);
		$pdf->Cell(250,15,"REPORTS HAVE BEEN DEACTIVATED PLEASE CONTACT THE PROGRAM VENDOR",1,0,'C');
		$pdf->Output();
		return true;
	}*/

	$query1="select * from ".$tmp_regularstudents." WHERE regNumber IN (".$regnolist.") ";  // and regNumber='126062001'
//echo $query1;
	$result1 = mysql_query($query1, $connection);
	if(mysql_num_rows($result1) > 0){
		$fullname = "";
		while ($row1 = mysql_fetch_array($result1)) {
			extract ($row1);

			//$fullname = strtoupper($row1[3]).", ".$row1[2];
			$fullname = $row1[3].", ".$row1[2];
			if($row1[11]>"") $fullname .= " ".$row1[11];

			$querySession = "SELECT * FROM sessionstable where sessiondescription>='{$sessionssA}' and sessiondescription<='{$sessionssB}' order by sessiondescription, semesterdescription ";
//echo $querySession."<br><br>";
			$resultSession = mysql_query($querySession, $connection);
			if(mysql_num_rows($resultSession) > 0){
				while ($rowSession = mysql_fetch_array($resultSession)) {
					extract ($rowSession);

					$sessionss=$sessiondescription;
					$semesters=$semesterdescription;

					$query = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and registrationnumber='{$regNumber}'  ";
					//and studentlevel='{$studentlevels}' and a.studentlevel='{$studentlevels}' order by registrationnumber, sessiondescription, semester, coursecode
					$query = "SELECT a.*, b.serialno FROM ".$tmp_finalresultstable." a, ".$tmp_coursestable." b where (a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.sessiondescription='{$sessionss}' and a.registrationnumber='{$regNumber}' and b.facultycode='{$facultycodes}' and b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.sessiondescription='{$sessionss}' and a.coursecode=b.coursecode ";
					if($semesters!=null && $semesters!="") 
						$query .= " and a.semester='{$semesters}' and b.semesterdescription='{$semesters}') ";
					$query .= " order by b.serialno, right(a.coursecode,3) desc, left(a.coursecode,3)";
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
								
								//$pdf->SetY($currentY);
								//$pdf->SetX($pdf->GetX()+38);
								//$pdf->Cell(60,5,"STATE OF ORIGIN",1,1,'L');
								//$pdf->SetX($pdf->GetX()+38);
								//$pdf->Cell(60,5,$originState,1,1,'L');

								$pdf->SetY($currentY);
								$pdf->SetX($pdf->GetX()+143);
								$pdf->Cell(47,5,"STATE OF ORIGIN",1,1,'L');
								$pdf->SetX($pdf->GetX()+143);
								$pdf->Cell(47,5,$originState,1,1,'L');

								//$pdf->SetY($currentY);
								//$pdf->SetX($pdf->GetX()+143);
								//$pdf->Cell(47,5,"MODE OF ADMISSION",1,1,'L');
								//$pdf->SetX($pdf->GetX()+143);
								//$pdf->Cell(47,5,$admissiontype,1,2,'L');

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
									$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM ".$tmp_regularstudents." where regNumber='{$matricno}'";
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
										$cgpa = (doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu));
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

								$thesemester=$semester;
								$count=1;
							}

							$query2 = "SELECT distinct coursecode, coursedescription, courseunit, minimumscore FROM ".$tmp_coursestable." where coursecode='{$coursecode}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semesterdescription='{$semesters}' order by serialno ";
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
								//$pdf->Cell(15,5,$row[5],1,0,'C');
								if($row[10]=="Sick"){
									$pdf->Cell(15,5,"S",1,0,'C');
								}else if($row[10]=="Did Not Register"){
									$pdf->Cell(15,5,"DNR",1,0,'C');
								}else if($row[10]=="Incomplete"){
									$pdf->Cell(15,5,"I",1,0,'C');
								}else if($row[10]=="Absent"){
									$pdf->Cell(15,5,"ABS",1,0,'C');
								}else{
									$pdf->Cell(15,5,$row[5],1,0,'C');
								}
								if($row[10]=="Sick"){
									$pdf->Cell(15,5,"S",1,0,'C');
								}else if($row[10]=="Did Not Register"){
									$pdf->Cell(15,5,"DNR",1,0,'C');
								}else if($row[10]=="Incomplete"){
									$pdf->Cell(15,5,"I",1,0,'C');
								}else{
									$pdf->Cell(15,5,$row[6],1,0,'C');
								}
								$pdf->Cell(15,5,number_format($tcp,1),1,0,'C');
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
						$pdf->Cell(20,5,number_format($theCurGPs[0],1),1,0,'C');
						$pdf->Cell(15,5,$theCurGPs[1],1,0,'C');
						$pdf->Cell(15,5,number_format($theCurGPs[2],2),1,0,'C');
						$pdf->Cell(15,5,$theCurGPs[3],1,0,'C');
						$pdf->Ln(5);

						$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
						$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM ".$tmp_regularstudents." where regNumber='{$matricno}'";
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
							$pdf->Cell(20,5,number_format((doubleval($thePreGPs[0])+doubleval($tcp)),1),1,0,'C');
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
						$pdf->Cell(20,5,number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp)),1),1,0,'C');
						$pdf->Cell(15,5,(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),1,0,'C');
						$pdf->Cell(15,5,number_format($cgpa,2),1,0,'C');
						$pdf->Cell(15,5,$ctnup,1,0,'C');


						$queryRemark = "SELECT remark, remarkprob, remarkdnr  from ".$tmp_remarkstable." where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
						$resultRemark = mysql_query($queryRemark, $connection);
						if(mysql_num_rows($resultRemark) != 0){
							$queryD = "SELECT min(sessions) as firstsession FROM ".$tmp_registration." where regNumber='{$regNumber}'  ";
							$resultD = mysql_query($queryD, $connection);
							extract (mysql_fetch_array($resultD));

							$queryD = "SELECT b.* FROM ".$tmp_regularstudents." a, ".$tmp_registration." b where a.regNumber=b.regNumber and a.regNumber='{$regNumber}' and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' order by b.sessions, b.semester";
				//echo  date("Y-m-d H:i:s")."    <br>$queryD    <br> <br>";
							$resultD = mysql_query($queryD, $connection);
							$thecounter=0;
							$remarkprob="";
							$remarkdnr="";
							if(mysql_num_rows($resultD) > 0){
				//echo "----------------------- <br>";
								while ($rowD = mysql_fetch_array($resultD)) {
									extract ($rowD);
									$regNumber=$rowD[1];
									$level=$rowD[2];
									$thecounter++;

									$totalCoursesAttempted=0; $totalDNRcourses=0; $totalIncomplete=0; $totalSick=0;
									$query4 = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessions}' and semester='{$semester}' and registrationnumber='{$regNumber}' ";
									$result4 = mysql_query($query4, $connection);
									while ($row4 = mysql_fetch_array($result4)) {
										extract ($row4);
										$totalCoursesAttempted++;
										if($row4[6]=='DNR') ++$totalDNRcourses;
										if($row4[6]=='I') ++$totalIncomplete;
										if($row4[6]=='S') ++$totalSick;
									}
									doCoursesCount($facultycodes, $departmentcodes, $programmecodes, $level, $sessions, $semester);
 
									//if($registered!="Yes" && $thecounter>=2){
									if($totalDNRcourses==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalDNRcourses==$totalCoursesAttempted){
									//if(($totalDNRcourses==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalDNRcourses==$totalCoursesAttempted)){ //&& $thecounter>=2
										if($remarkdnr==""){
											$remarkdnr="DNR1";
										}else if($remarkdnr=="DNR1"){
											$remarkdnr="DNR2";
										}else if($remarkdnr=="DNR2"){
											$remarkdnr="DNR3VW";
										}else if(str_in_str($remarkdnr,"VW") || str_in_str($remarkdnr,"DLT")){
											$remarkdnr="DLT";
											$dltstudents .= $regNumber."][";
										}
									}else{
										$remarkdnr="";
									}

									if($sesionsreabsurption==$sessionss) $remarkdnr="";
									$curGP =  getCurrentGPA($facultycode, $departmentcode, $programmecode, $studentlevel, $sessions, $semester, $regNumber);
									$theCurGPs = explode("][", $curGP);
									$preGP = getPreviousGPA($facultycode, $departmentcodes, $programmecode, $studentlevel, $sessions, $semester, $regNumber);
									$thePreGPs = explode("][", $preGP);
									$tcp=0.0; $cgpa=0;
									$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM ".$tmp_regularstudents." where regNumber='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
									$result2 = mysql_query($query2, $connection);
									if(mysql_num_rows($result2) > 0){
										while ($row2 = mysql_fetch_array($result2)) {
											extract ($row2);
											$tcp=$row2[1]; 
											$tnu=$row2[2]; 
										}
									}
									if($tcp==null) $tcp=0;
									if($tnu==null) $tnu=0;
									if((($theCurGPs[0]+$thePreGPs[0]+$tcp)==0) || 
										(($theCurGPs[1]+$thePreGPs[1]+$tnu)==0)){
										$cgpa = 0;
									}else{
										$cgpa = (doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu));
									}

			//if($regNumber>='126101004' && $regNumber<='126101005') echo "A  $remarkprob<br><br>";
									if(str_in_str($remarkprob,"TW") || str_in_str($remarkprob,"DLT")){
											$remarkprob="DLT";
											$dltstudents .= $regNumber."][";
									}else if(!($totalDNRcourses==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalIncomplete==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalSick==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']))){
										/*if(intval(number_format($cgpa,1))<1 && $remarkprob=="P1") {
											$remarkprob="P2TW";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
										}else if(intval(number_format($cgpa,1))<1 && $remarkprob=="P2") {
											$remarkprob="P3TW";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
										}else if(intval(number_format($cgpa,1))<2 && $remarkprob=="") {
											$remarkprob="P1";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="";
										}else if(intval(number_format($cgpa,1))<2 && $remarkprob=="P1") {
											$remarkprob="P2";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
										}else if(intval(number_format($cgpa,1))<2 && $remarkprob=="P2") {
											$remarkprob="P3TW";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
										}else{
											$remarkprob="";
										}*/
										if(doubleval(number_format($cgpa,2))<0.50 && $remarkprob=="P1") {
											$remarkprob="P2TW";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
										}else if(doubleval(number_format($cgpa,2))<0.50 && $remarkprob=="P2") {
											$remarkprob="P3TW";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
										}else if(doubleval(number_format($cgpa,2))<1.00 && $remarkprob=="") {
											$remarkprob="P1";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="";
										}else if(doubleval(number_format($cgpa,2))<1.00 && $remarkprob=="P1") {
											$remarkprob="P2";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
										}else if(doubleval(number_format($cgpa,2))<1.00 && $remarkprob=="P2") {
											$remarkprob="P3TW";
											if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
										}else{
											$remarkprob="";
										}
									}
			//if($regNumber>='126101004' && $regNumber<='126101005') echo "B  $remarkprob<br><br>";
								}
								$queryRemark = "update ".$tmp_remarkstable." set remarkprob='{$remarkprob}', remarkdnr='{$remarkdnr}' where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
								mysql_query($queryRemark, $connection);
			//if($regNumber>='126101001' && $regNumber<='126101011') echo $queryRemark."  2   queryRemark<br><br>";
							}
						}else{
							//echo $queryRemark;
							extract (mysql_fetch_array($resultRemark));
						}

						if(($finalyear=="Yes" || str_in_str($studentlevels,"NDIII") || str_in_str($studentlevels,"HNDIII")) && $semesters=="2ND"){
							$remarks = getRemarks($facultycode, $departmentcode, $programmecode, $studentlevels, $sessionss, $semesters, $regNumber, $finalyear, $cgpa, $ctnup);
							$diploma = "";
							$department = "";
							$queryB = "SELECT * FROM ".$tmp_regularstudents." where regNumber='{$registrationnumber}'";
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
							if(str_in_str($remarks, "Passed")){
								$pdf->Ln(5);
								$pdf->Cell(75,5,'DIPLOMA AWARDED: '.$diploma.' IN '.$department,0,0,'L');
								$pdf->Ln(5);
								$pdf->Cell(75,5,'CLASS OF DIPLOMA: '.$remarks,0,0,'L');
								$pdf->Ln(5);
								$pdf->Cell(75,5,'DATE OF AWARD: '.$awardate,0,0,'L');
							}else{
								if($remarkprob > "" || $remarkdnr > ""){
									$pdf->Ln(5);
									$pdf->Cell(strlen('REMARKS: '.$remarkprob.$remarkdnr." ")+9,5,'REMARKS: '.$remarkprob.$remarkdnr." ",0,0,'L');
								}
								$remk = explode("()", $remarks);
								if($remarkprob == "" && $remarkdnr == "") {
									$pdf->Ln(5);
									$pdf->Cell(strlen('REMARKS: '.$remk[0]." (")+7,5,'REMARKS: '.$remk[0]." (",0,0,'L');
								}else{
									$pdf->Cell(strlen($remk[0]." (")+1,5,$remk[0]." (",0,0,'L');
								}
								$index=0;
								$remarks=$remk[1];
								for(; $index<strlen($remarks); ){
									if(($index + 120)>=strlen($remarks)){
										$pdf->Cell(strlen(trim(substr($remarks,$index,120)).")")+7,5,trim(substr($remarks,$index,120)).")",0,2,'L');
									}else{
										$pdf->Cell(strlen(trim(substr($remarks,$index,120)))+7,5,trim(substr($remarks,$index,120)),0,2,'L');
									}
									$index += 120;
								}
							}
						}else{
							$remarks = getRemarks($facultycode, $departmentcode, $programmecode, $studentlevels, $sessionss, $semesters, $regNumber, $finalyear, $cgpa, $ctnup);
							$pdf->Ln(5);
							if(str_in_str($remarks, "Passed")){
								$pdf->Cell(75,5,'REMARKS: '.$remarks,0,0,'L');
							}else{
								$pdf->Ln(5);
								$pdf->Cell(strlen('REMARKS: ')+6,5,'REMARKS: ',0,0,'L');
								$remk = explode("()", $remarks);
								if($remk[0]!=null && $remk[0]!="") {
									$pdf->Cell(strlen($remk[0]." "),5,$remk[0]." ",0,0,'L');
								}
								if($remarkprob > ""){
									$pdf->Cell(strlen($remarkprob." ")+2,5,$remarkprob." ",0,0,'L');
								}
								if($remarkdnr > ""){
									$pdf->Cell(strlen($remarkdnr." ")+3,5,$remarkdnr." ",0,0,'L');
								}
								$pdf->Cell(strlen("("),5,"(",0,0,'L');
								$index=0;
								$remarks=$remk[1];
								for(; $index<strlen($remarks); ){
									if(($index + 120)>=strlen($remarks)){
										$pdf->Cell(strlen(trim(substr($remarks,$index,120)).")")+7,5,trim(substr($remarks,$index,120)).")",0,2,'L');
									}else{
										$pdf->Cell(strlen(trim(substr($remarks,$index,120)))+7,5,trim(substr($remarks,$index,120)),0,2,'L');
									}
									$index += 120;
								}
							}
						}
					}
				}
			}
		}
	}

	$pdf->Output();
	//$pdf->Output('c:/doc.pdf','F');

	$query = "insert into remarkstable SELECT * FROM ".$tmp_remarkstable." B ON DUPLICATE KEY UPDATE matricno=B.matricno, remark=B.remark, sessions=B.sessions, semester=B.semester, facultycode=B.facultycode, departmentcode=B.departmentcode, programmecode=B.programmecode, studentlevel=B.studentlevel, RR=B.RR, remarkprob=B.remarkprob, remarkdnr=B.remarkdnr, prevtcp=B.prevtcp, prevtnu=B.prevtnu, prevgpa=B.prevgpa, prevtnup=B.prevtnup, currtcp=B.currtcp, currtnu=B.currtnu, currgpa=B.currgpa, currtnup=B.currtnup ";
	mysql_query($query, $connection);

	$query = "DROP TABLE IF EXISTS ".$tmp_finalresultstable;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_finalresultstable%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_coursestable;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_coursestable%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_regularstudents;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_regularstudents%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_registration;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_registration%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_gradestable;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_gradestable%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_cgpatable;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_cgpatable%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_retakecourses;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_retakecourses%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_remarkstable;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_remarkstable%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

	$query = "DROP TABLE IF EXISTS ".$tmp_mastereportbackup;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_mastereportbackup%'  ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(substr($row[2],4,10)<date("Y_m_d")){
				$queryDrop = "DROP TABLE IF EXISTS ".$row[2];
				mysql_query($queryDrop, $connection);
			}
		}
	}

?>
