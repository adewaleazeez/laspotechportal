<?php
	if($_COOKIE["currentuser"]==null || $_COOKIE["currentuser"]==""){
		echo '<script>alert("You must login to access this page!!!\n Click Ok to return to Login page.");</script>';
		echo '<script>window.location = "login.php";</script>';
		return true;
	}
	
	date_default_timezone_set("Africa/Lagos");
//echo date("Y-m-d H:i:s")." 0<br> <br>"; //colstoprintnow coursesonlinecounter coursesperline extraline pagestoprintB
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
	global $noofcourses;
	global $noofrepeatcourses;
	global $PrevRemarkSNo;
	global $PrevSession;
	global $thefirstsession;
	global $PrevSemester;
	global $tmp_finalresultstable;
	global $tmp_coursestable;
	global $tmp_regularstudents;
	global $tmp_registration;
	global $tmp_retakecourses ;
	global $tmp_gradestable;
	global $tmp_cgpatable;

	include("data.php");

	$currentusers = $_COOKIE['currentuser'];
	$query = "update currentrecord set currentrecordprocessing='', report='' where currentuser='{$currentusers}'";
	mysql_query($query, $connection);

	$query = "SELECT min(b.regNumber) as firstregnumber, max(b.regNumber) as lastregnumber FROM regularstudents AS a JOIN registration AS b ON a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes' order by a.regNumber"; 
	$result = mysql_query($query, $connection);
	extract (mysql_fetch_array($result));

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

	$query = "insert into ".$tmp_finalresultstable." SELECT * FROM finalresultstable where registrationnumber>='{$firstregnumber}' and registrationnumber<='{$lastregnumber}' ";
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

	$query = "insert into ".$tmp_regularstudents." SELECT * FROM regularstudents where regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}' ";
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

	$query = "insert into ".$tmp_registration." SELECT * FROM registration where regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}' ";
	mysql_query($query, $connection);

	$query = "select min(sessions) as firstsession from ".$tmp_registration." where regNumber='{$firstregnumber}' ";
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

	$query = "insert into ".$tmp_retakecourses." SELECT * FROM retakecourses where registrationnumber>='{$firstregnumber}' and registrationnumber<='{$lastregnumber}' ";
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

	$query = "insert into ".$tmp_remarkstable." SELECT * FROM remarkstable where matricno>='{$firstregnumber}' and matricno<='{$lastregnumber}' ";
	mysql_query($query, $connection);

	$tmp_mastereportbackup="tmp_".date("Y_m_d_H_i_s")."_mastereportbackup";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_mastereportbackup}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_mastereportbackup="tmp_".date("Y_m_d_H_i_s")."_mastereportbackup";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_mastereportbackup." select * from mastereportbackup limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_mastereportbackup." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_mastereportbackup." SELECT * FROM mastereportbackup where facultycode ='{$facultycodes}' and departmentcode ='{$departmentcodes}' and programmecode ='{$programmecodes}' and studentlevel ='{$studentlevels}' and sessions='{$sessionss}' and semester ='{$semesters}' ";
	mysql_query($query, $connection);

	function getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		include("data.php"); 
		$tmp_finalresultstable = $GLOBALS['tmp_finalresultstable'];
		$tmp_coursestable = $GLOBALS['tmp_coursestable'];
		$tmp_remarkstable = $GLOBALS['tmp_remarkstable'];

		$query = "SELECT * FROM ".$tmp_finalresultstable." where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$matno}' and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by serialno, right(coursecode,3) desc, left(coursecode,3) ";
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; $row7=0;
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM ".$tmp_coursestable." where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' ";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0) $tnup += $row2[1];
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

		$query = "SELECT * FROM ".$tmp_finalresultstable." where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and ((sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and registrationnumber='{$matno}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$matno}' and studentlevel<= '{$studentlevels}') and gradecode>'' and (coursestatus='' or coursestatus='Absent') order by serialno, right(coursecode,3) desc, left(coursecode,3)";
		$programmecodes = $GLOBALS['programmecodes'];
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; $row7=0;
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT distinct coursecode, courseunit, minimumscore FROM ".$tmp_coursestable." where coursecode='{$row[3]}' and facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$row[1]}' and semesterdescription='{$row[2]}' and studentlevel='{$row[8]}' "; 
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0) $tnup += $row2[1];
				}
			}
		}
		if($tnu>0) $gpa += number_format(($tcp/$tnu),2);
		$str = $tcp ."][". $tnu ."][". $gpa ."][". $tnup;

		$queryRemark = "update ".$tmp_remarkstable." set prevtcp='{$tcp}', prevtnu='{$tnu}', prevgpa='{$gpa}', prevtnup='{$tnup}' where matricno='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
		mysql_query($queryRemark, $connection);

		return $str;
	}

	global $studentcounter;
	$studentcounter=0;
	function getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $regno, $finalyear, $cgpa, $ctnup){
		$tmp_finalresultstable = $GLOBALS['tmp_finalresultstable'];
		$tmp_coursestable = $GLOBALS['tmp_coursestable'];
		$tmp_regularstudents = $GLOBALS['tmp_regularstudents'];
		$tmp_registration = $GLOBALS['tmp_registration'];
		$tmp_retakecourses  = $GLOBALS['tmp_retakecourses'];
		$tmp_remarkstable = $GLOBALS['tmp_remarkstable'];

		include("data.php"); 

		$currentusers = $_COOKIE['currentuser'];
		$globalfullnames = $GLOBALS['globalfullname'];
		$globalstudentcounter = ++$GLOBALS['studentcounter'];
		$currentrecordprocessings = str_replace(" ","spc", $globalstudentcounter."_-_".$regno."_-_".$globalfullnames);
		$query = "update currentrecord set currentrecordprocessing='{$currentrecordprocessings}', report='' where currentuser='{$currentusers}'";
		mysql_query($query, $connection);

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
//if($regno=="126251002") echo $failedcourses." 3 $regno<br><br>";

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
//if($regno=="126251002") echo $failedcourses." 4 $regno<br><br>";

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
					$query = "SELECT * FROM ".$tmp_cgpatable." where qualification='{$qualification}' and sessions='{$sessionss}'  and {$cgpa}>=lowerrange and {$cgpa}<=upperrange ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
							if($remarks=="") $remarks = "Passed, ".$cgpacode;
							if(str_in_str($cgpacode, "FAIL")) $remarks = "NR (Failed, ".$cgpacode.")";
						}
					}
				}
			}
		}else{
			if($remarks=="") $remarks="Passed";
			if($firstsession=="")  $remarks="DID NOT SIT FOR EXAM";
		}

		//if($remarks=="Passed"){
		$myremarks=$remarks;
		if(str_in_str($remarks,"Passed")){
			$remarks="NR";
		}else{
//if($regno=="086141001") echo $remarks;
			$remarks = explode(", ", $remarks);
			$remarks = "R".trim(count($remarks));
		}
		$str = $remarks."][";
		
		$queryRemark = "update ".$tmp_remarkstable." set remark='{$myremarks}', RR='{$str}' where matricno='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
		mysql_query($queryRemark, $connection);

		return $str;
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

require('fpdf.php');

class PDF extends FPDF {

	var $B;
	var $I;
	var $U;
	var $HREF;

	function PDF($orientation ='L', $unit='mm', $size='A4'){
		// Call parent constructor
		$this -> FPDF($orientation, $unit, $size);
        // Initialization
        $this -> B = 0;
        $this -> I = 0;
        $this -> U = 0;
        $this -> HREF = '';
	}

		// Page header
    function Header() {
        // Logo
        include("data.php");

        $sessionss = $GLOBALS['sessionss'];
			$semesters = $GLOBALS['semesters'];
			$facultycodes = $GLOBALS['facultycodes'];
			$departmentcodes = $GLOBALS['departmentcodes'];
			$programmecodes = $GLOBALS['programmecodes'];
			$studentlevels = $GLOBALS['studentlevels'];
			$resultype = $GLOBALS['resultype'];
			$tmp_coursestable = $GLOBALS['tmp_coursestable'];
			$tmp_regularstudents = $GLOBALS['tmp_regularstudents'];
			$tmp_registration = $GLOBALS['tmp_registration'];
			$tmp_gradestable = $GLOBALS['tmp_gradestable'];
			$tmp_cgpatable = $GLOBALS['tmp_cgpatable'];

			include("data.php");

        $schoolnames = "";
        $query = "SELECT * FROM schoolinformation where schoolname<>''";
        $result = mysql_query($query, $connection);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_array($result)) {
                extract($row);
                $schoolnames = $row[1] . ", " . $row[2];
            }
        }

        $coursecodes = "";
        $compulsory = "";
        $required = "";
        $elective = "";
			//$GLOBALS['noofcourses']=0;
        //$GLOBALS['noofrepeatcourses']=0;
        $query = "SELECT distinct coursecode, coursetype FROM ".$tmp_coursestable.
        " where (sessiondescription='{$sessionss}' and semesterdescription='{$semesters}') and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'  order by serialno, right(coursecode,3) desc, left(coursecode,3)";
			$result = mysql_query($query, $connection);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_array($result)) {
                extract($row);
                $coursecodes .= $row[0] . "][";
					/*$query2 = "SELECT distinct coursecode FROM ".$tmp_coursestable." where (sessiondescription<'{$sessionss}' or (sessiondescription='{$sessionss}' and semesterdescription<'{$semesters}')) and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel!='{$studentlevels}' and coursecode='{$row[0]}' ";
					$result2 = mysql_query($query2, $connection);
					if(mysql_num_rows($result2)>0) {
						$GLOBALS['noofrepeatcourses']++;
					}
					$GLOBALS['noofcourses']++;*/
				}
			}
			$coursecodes = substr($coursecodes, 0, strlen($coursecodes) - 2);
        $GLOBALS['thecoursecodes'] = explode("][", $coursecodes);
//echo $coursecodes."<br><br>" ;

        $thecol = 90 + count($GLOBALS['thecoursecodes'])*7;
		if ($thecol < 330) {
            $thecol = 330;
        }
        $this -> Image('images\Schoologo.png',10,10,20,20);

			$query = "SELECT min(a.qualificationcode) as qualification FROM ".$tmp_regularstudents." a,".$tmp_registration." b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' ";
			$result = mysql_query($query, $connection);
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_array($result)) {
                extract($row);
            }
        }
        $this -> SetFont('Times','B',5.5);
			//$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			$currentY = $this -> GetY();
        $this -> SetX($this -> GetX() + 30);
        $this -> Cell(75, 5,'GRADES TABLE',0,0,'C');
		$this -> Ln();
        $query = "SELECT * FROM ".$tmp_gradestable." where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC";
		$result = mysql_query($query, $connection);
        if (mysql_num_rows($result) > 0) {
            $this -> SetX($this -> GetX() + 30);
            $this -> Cell(20, 3, "MARKS RANGE", 1, 0, 'C');
            $this -> Cell(20, 3, "LETTER GRADE", 1, 0, 'C');
            $this -> Cell(20, 3, "GRADE POINT", 1, 0, 'C');
            $this -> Ln();
            while ($row = mysql_fetch_array($result)) {
                extract($row);
                $this -> SetX($this -> GetX() + 30);
                $this -> Cell(20, 3, $lowerrange."% - ".$upperrange."%",1,0,'C');
					$this -> Cell(20, 3, $gradecode, 1, 0, 'C');
                $this -> Cell(20, 3, number_format($gradeunit, 1), 1, 0, 'C');
                $this -> Ln();
            }
        }
        $this -> Ln(2);
        $this -> SetY($currentY);
        //$this->SetX($this->GetX()+95);
        $this -> SetFont('Times','B',10);
			$this -> Cell($thecol, 7, $schoolnames, 0, 0, 'C');
        $this -> Ln();
        $this -> Cell($thecol, 7, "SCHOOL OF ".$facultycodes, 0, 0, 'C');
        $this -> Ln();
        $this -> Cell($thecol, 7, "DEPARTMENT OF ".$departmentcodes, 0, 0, 'C');
        $this -> Ln();
        $this -> Cell($thecol, 7, $programmecodes." PROGRAMME",0,0,'C');
			$this -> Ln();
        $this -> Cell($thecol, 7, $sessionss." ".$semesters." Semester Examination Results",0,0,'C');
			$this -> Ln();
        if ($resultype == "Repeaters Results") {
            $this -> Cell($thecol, 7, "REPEATERS SPREAD SHEET", 0, 0, 'C');
            $this -> Ln();
        } else {
            $this -> Cell($thecol, 7, "SPREAD SHEET", 0, 0, 'C');
            $this -> Ln();
        }
        $this -> Cell($thecol, 7, $studentlevels, 0, 0, 'C');
        $this -> Ln(2);

        if (str_in_str($studentlevels, "III") && $semesters == "2ND") {
            $this -> SetFont('Times','B',5.5);
			$this -> SetY($currentY);
            $this -> SetX($this -> GetX() + 225);
            $this -> Cell(45, 5,'CUMMULATIVE GRADE POINT AVERAGE (CGPA)',0,0,'C');
			$this -> Ln();
            $query = "SELECT * FROM ".$tmp_cgpatable." where sessions='{$sessionss}' and qualification='{$qualification}' order by lowerrange DESC";
			$result = mysql_query($query, $connection);
            if (mysql_num_rows($result) > 0) {
                $this -> SetX($this -> GetX() + 225);
                $this -> Cell(25, 5, "CLASSIFICATION", 1, 0, 'L');
                $this -> Cell(20, 5, "RANGE", 1, 0, 'C');
                $this -> Ln();
                while ($row = mysql_fetch_array($result)) {
                    extract($row);
                    $this -> SetX($this -> GetX() + 225);
                    $this -> Cell(25, 5, $cgpacode, 1, 0, 'L');
                    $this -> Cell(20, 5, number_format($lowerrange, 1)." - ".number_format($upperrange, 1),1,0,'C');
					$this -> Ln();
                }
            }
            $this -> Ln(13);
        } else {
            $this -> Ln(4);
        }

    }

    // Page footer
    function Footer() {
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
		$this -> SetY(-35);
        $this -> SetFont('Times','B',7.5);
		$this -> Ln(18);
        if ($this -> PageNo() == 1) {
            $theDate = date("d/m/Y");
            $theHour = date("H");
            $theMins = date("i");
            $theSecs = date("s");
            $theAmPm = " AM";
            $theHour = intval($theHour) - 1;
            if ($theHour > 12) {
                $theHour -= 12;
                $theAmPm = " PM";
            }
            $this -> Cell(150, 5, "ACB Approval: Sign ________________________________________________________        Date: __________________________                                                                               Printed: ".date("d/m/Y  "), 0, 0, 'L');
            //.$theHour.":".$theMins.":".$theSecs.$theAmPm
            $this -> Ln();
            $this -> Cell(150, 5, "                                                                    Rector/Deputy Rector", 0, 0, 'L');
            $this -> Ln();
            $this -> SetFont('Times','B',10);
				$this -> Cell(0, 5,'Page '.$this -> PageNo().
            '/{nb}',0,0,'C');
        } else {
            $this -> Cell(150, 5, "ACB Approval: Sign ________________________________________________________        Date: __________________________", 0, 0, 'L');
            $this -> Ln();
            $this -> Cell(150, 5, "                                                                    Rector/Deputy Rector", 0, 0, 'L');
            $this -> Ln();
            $this -> SetFont('Times','B',10);
				$this -> Cell(0, 5,'Page '.$this -> PageNo().
            '/{nb}',0,0,'C');
        }
    }

    function coursesheader($pagecounter, $colstoprintnow, $coursesperline, $mergesummaryheader) {
        include("data.php");
        $tmp_coursestable = $GLOBALS['tmp_coursestable'];

		$thecoursecodes = $GLOBALS['thecoursecodes'];
		$facultycodes = $GLOBALS['facultycodes'];
		$departmentcodes = $GLOBALS['departmentcodes'];
		$programmecodes = $GLOBALS['programmecodes'];
		$studentlevels = $GLOBALS['studentlevels'];
		$sessionss = $GLOBALS['sessionss'];
		$semesters = $GLOBALS['semesters'];

		$this -> SetFont('Times','B',7.5);
		$this -> Cell(10, 8, "S/NO", 1, 0, 'C');
        $this -> Cell(17, 8, "MATRIC NO", 1, 0, 'C');
        $this -> Cell(60, 8, "FULL NAME", 1, 0, 'L');
        $this -> Cell($colstoprintnow * 7 * 3, 8, "COURSES", 1, 0, 'C');
        $this -> Ln();

        $ycoordinate = $this -> GetY();
        $xcoordinate = $this -> GetX() + 87;
        $this -> Cell(10, 5, " ",'LR',0,'R');
		$this -> Cell(17, 5, " ",'LR',0,'L');
		$this -> Cell(60, 5, " COURSES",'LR',1,'R');

		$this -> Cell(10, 5, " ",'LR',0,'R');
		$this -> Cell(17, 5, " ",'LR',0,'L');
		$this -> Cell(60, 5, " CODES",'LR',1,'R');

		$this -> Cell(10, 5, " ",'LR',0,'R');
		$this -> Cell(17, 5, " ",'LR',0,'L');
		$this -> Cell(60, 5, " CREDIT UNITS",'LR',1,'R');

		$this -> Cell(10, 5, " ",'LR',0,'R');
		$this -> Cell(17, 5, " ",'LR',0,'L');
		$this -> Cell(60, 5, " ",'LR',1,'R');

		$this -> SetY($ycoordinate);
        $this -> SetX($xcoordinate);

        $startcol = (($pagecounter - 1) * $coursesperline) + 1;
        $counter1 = 0;
        $counter2 = 0;

        $ycoordinate = $this -> GetY();
        $xcoordinate = $this -> GetX();
        foreach($thecoursecodes as $code){
			$query = "SELECT * FROM ".$tmp_coursestable." where coursecode='{$code}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}' and semesterdescription='{$semesters}' ";
			$result = mysql_query($query, $connection);
            while ($row = mysql_fetch_array($result)) {
                extract($row);
                $counter1++;
                if ($counter1 >= $startcol && ++$counter2 <= $colstoprintnow) {
                    $codes = explode(" ", $code);
                    $ycoordinate = $this -> GetY();
                    $xcoordinate = $this -> GetX();
                    $this -> Cell(7 * 3, 5, $codes[0], "LTR", 2, 'C');
                    $this -> Cell(7 * 3, 5, $codes[1], "LR", 2, 'C');
                    //$this->Cell(7*3,5,"(".$row[3].")","LBR",2,'C');
                    $this -> Cell(7 * 3, 5, $row[3], "LBR", 2, 'C');
                    $this -> Cell(7, 5, "S", 1, 0, 'C');
                    $this -> Cell(7, 5, "G", 1, 0, 'C');
                    $this -> Cell(7, 5, "GP", 1, 0, 'C');
                    $this -> SetY($ycoordinate);
                    $this -> SetX($xcoordinate + (7 * 3));
                }
            }
        }
        if ($colstoprintnow <= $GLOBALS['maxcoursesperline']){
			$this -> SetY($ycoordinate + 2);
            $this -> Cell(10, 20, " ", 0, 0, 'R');
            $this -> Cell(17, 20, " ", 0, 0, 'L');
            $this -> Cell(60, 20, " ", 0, 0, 'L');
            for ($c = 1; $c <= $colstoprintnow; $c++) {
                $this -> Cell(7, 5, "", 0, 0, 'C');
                $this -> Cell(7, 5, "", 0, 0, 'C');
                $this -> Cell(7, 5, "", 0, 0, 'C');
            }
            $this -> Cell(21, 5, "SEMESTER ", "LTR", 0, 'C');
            if (!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
				$this -> Cell(21, 5, "PREVIOUS", "LTR", 0, 'C');
            }
            $this -> Cell(21, 5, "CURRENT", "LTR", 0, 'C');
            $this -> Ln();
            $this -> Cell(10, 20, " ", 0, 0, 'R');
            $this -> Cell(17, 20, " ", 0, 0, 'L');
            $this -> Cell(60, 20, " ", 0, 0, 'L');
            for ($c = 1; $c <= $colstoprintnow; $c++) {
                $this -> Cell(7, 5, "", 0, 0, 'C');
                $this -> Cell(7, 5, "", 0, 0, 'C');
                $this -> Cell(7, 5, "", 0, 0, 'C');
            }
            $this -> Cell(21, 5, "RECORD", "LBR", 0, 'C');
            if (!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
				$this -> Cell(21, 5, "CUMULATIVE", "LBR", 0, 'C');
            }
            $this -> Cell(21, 5, "CUMULATIVE", "LBR", 0, 'C');
            $this -> Ln();
            $this -> Cell(10, 20, " ", 0, 0, 'R');
            $this -> Cell(17, 20, " ", 0, 0, 'L');
            $this -> Cell(60, 20, " ", 0, 0, 'L');
            for ($c = 1; $c <= $colstoprintnow; $c++) {
                $this -> Cell(7, 5, "", 0, 0, 'C');
                $this -> Cell(7, 5, "", 0, 0, 'C');
                $this -> Cell(7, 5, "", 0, 0, 'C');
            }
            $this -> Cell(7, 8, "SGP", 1, 0, 'C');
            $this -> Cell(7, 8, "SCH", 1, 0, 'C');
            $this -> Cell(7, 8, "SGPA", 1, 0, 'C');
            if (!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
				$this -> Cell(7, 8, "SGP", 1, 0, 'C');
                $this -> Cell(7, 8, "SCH", 1, 0, 'C');
                $this -> Cell(7, 8, "SGPA", 1, 0, 'C');
            }
            $this -> Cell(7, 8, "SGP", 1, 0, 'C');
            $this -> Cell(7, 8, "SCH", 1, 0, 'C');
            $this -> Cell(7, 8, "SGPA", 1, 0, 'C');
            $this -> Cell(27, 8, "REMARKS", 1, 0, 'C');
            $this -> SetY($ycoordinate);
            $this -> SetX($xcoordinate + ($colstoprintnow * 7 * 3));
        }
        $this -> Ln(20);
    }

    function printsummaryheader() {
        $this -> SetFont('Times','B',7.5);
		$this -> Cell(10, 5, "", 0, 0, 'R');
        $this -> Cell(17, 5, "", 0, 0, 'L');
        $this -> Cell(60, 5, "", 0, 0, 'L');
        $this -> Cell(21, 5, "SEMESTER", "LTR", 0, 'C');
        if (!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
				$this -> Cell(21, 5, "PREVIOUS", "LTR", 0, 'C');
        }
        $this -> Cell(21, 5, "CURRENT", "LTR", 0, 'C');
        $this -> Cell(15, 5, "", 0, 0, 'L');
        $this -> Ln();
        $this -> Cell(10, 5, "", 0, 0, 'R');
        $this -> Cell(17, 5, "", 0, 0, 'L');
        $this -> Cell(60, 5, "", 0, 0, 'L');
        $this -> Cell(21, 5, "RECORD", "LBR", 0, 'C');
        if (!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
			$this -> Cell(21, 5, "CUMULATIVE", "LBR", 0, 'C');
        }
        $this -> Cell(21, 5, "CUMULATIVE", "LBR", 0, 'C');
        $this -> Cell(15, 5, "", 0, 0, 'L');
        $this -> Ln();
        $this -> Cell(10, 8, "S/NO", 1, 0, 'C');
        $this -> Cell(17, 8, "MATRIC NO", 1, 0, 'C');
        $this -> Cell(60, 8, "FULL NAME", 1, 0, 'L');
        $this -> Cell(7, 8, "SGP", 1, 0, 'C');
        $this -> Cell(7, 8, "SCH", 1, 0, 'C');
        $this -> Cell(7, 8, "SGPA", 1, 0, 'C');
        if (!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
			$this -> Cell(7, 8, "SGP", 1, 0, 'C');
            $this -> Cell(7, 8, "SCH", 1, 0, 'C');
            $this -> Cell(7, 8, "SGPA", 1, 0, 'C');
        }
        $this -> Cell(7, 8, "SGP", 1, 0, 'C');
        $this -> Cell(7, 8, "SCH", 1, 0, 'C');
        $this -> Cell(7, 8, "SGPA", 1, 0, 'C');
        $this -> Cell(27, 8, "REMARKS", 1, 0, 'C');
        $this -> Ln();
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
	global $maxcoursesperline;
	$GLOBALS['maxcoursesperline']=5;

	global $globalfullname;
	$GLOBALS['globalfullname']="";

	$modes = $GLOBALS['modes'];
	if($modes=="process"){
		$details="";
		$summary="";
		$details2="";
		$summary2="";

		$query = "SELECT distinct a.*, b.regNumber, b.studentlevel, b.sessions, b.semester FROM ".$tmp_regularstudents." AS a JOIN ".$tmp_registration." AS b ON a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes' order by a.regNumber"; 
// group by a.regNumber order by a.facultycode, a.departmentcode, a.programmecode, a.regNumber, a.firstName, a.lastName
//serialno, matricno, remark, sessions, semesters, facultycode, departmentcode, programmecode, studentlevel, RR, PP, DNRVW, prevgp, prevunit, curgp, curunit 		

		$result = mysql_query($query, $connection);
		$absentstudent="";
//echo date("Y-m-d H:i:s")." 1 <br> <br>";
		$totalCoursesAttempted=0; $totalDNRcourses=0; $totalIncomplete=0; $totalSick=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$regNumber=$row[1];
//echo date("Y-m-d H:i:s")." 0   $regNumber<br> <br>";

			$currentusers = $_COOKIE['currentuser'];
			$globalfullnames = $GLOBALS['globalfullname'];
			$globalstudentcounter = ++$GLOBALS['studentcounter'];
			$currentrecordprocessings = str_replace(" ","spc", $globalstudentcounter."_-_".$regNumber."_-_".$globalfullnames);
			$query = "update currentrecord set currentrecordprocessing='{$currentrecordprocessings}', report='' where currentuser='{$currentusers}'";
			mysql_query($query, $connection);

			$queryRemark = "SELECT remark, remarkprob, remarkdnr  from ".$tmp_remarkstable." where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
			$resultRemark = mysql_query($queryRemark, $connection);
			if(mysql_num_rows($resultRemark) == 0){
				$querySNo="select max(serialno)+1 as nextserialno from ".$tmp_remarkstable;
				$resultSNo = mysql_query($querySNo, $connection);
				extract (mysql_fetch_array($resultSNo));

				if($nextserialno<=1){
					$querySNo="select max(serialno)+1 as nextserialno from remarkstable ";
					$resultSNo = mysql_query($querySNo, $connection);
					extract (mysql_fetch_array($resultSNo));
				}

				$queryRemark = "insert into ".$tmp_remarkstable." (serialno, matricno, facultycode, departmentcode, programmecode, studentlevel, sessions, semester) values ('{$nextserialno}', '{$regNumber}', '{$facultycodes}', '{$departmentcodes}', '{$programmecodes}', '{$studentlevels}', '{$sessionss}', '{$semesters}' )";
				mysql_query($queryRemark, $connection);
			}else{
				extract (mysql_fetch_array($resultRemark));
			}

			$queryPrevSession = "SELECT * from ".$tmp_registration." where regnumber='{$regNumber}' and (sessions<'{$sessionss}' or (sessions='{$sessionss}' and semester<'{$semesters}'))  order by sessions desc, semester desc ";
			$resultPrevSession = mysql_query($queryPrevSession, $connection); 
			$PrevSession="";
			$PrevSemester="";
			if(mysql_num_rows($resultPrevSession)>0){
				while ($rowPrevSession = mysql_fetch_array($resultPrevSession)) {
					$PrevSession=$rowPrevSession[3];
					$PrevSemester=$rowPrevSession[4];
					break;
				}
				$queryPrevRemark = "SELECT serialno from ".$tmp_remarkstable." where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$PrevSession}' and semester='{$PrevSemester}' ";
//echo date("Y-m-d H:i:s")."  $queryPrevRemark<br>";
				$resultPrevRemark = mysql_query($queryPrevRemark, $connection);
				if(mysql_num_rows($resultPrevRemark) > 0){
					extract (mysql_fetch_array($resultPrevRemark));
					$GLOBALS['PrevRemarkSNo']=$serialno;
					$GLOBALS['PrevSession']=$PrevSession;
					$GLOBALS['PrevSemester']=$PrevSemester;
				}
			}

			//extract ($row);
//echo date("Y-m-d H:i:s")."  <br>";

			$queryD = "SELECT min(sessions) as firstsession FROM ".$tmp_registration." where regNumber='{$regNumber}'  ";
			$resultD = mysql_query($queryD, $connection);
			extract (mysql_fetch_array($resultD));

//if($regNumber>='126251001' && $regNumber<='126251013') echo $GLOBALS['PrevRemarkSNo']."     GLOBALS['PrevRemarkSNo']<br>";
			//if($remarkprob==null && $remarkdnr==null){
			$totalCoursesAttempted=0; $totalDNRcourses=0; $totalIncomplete=0; $totalSick=0;
			$query4 = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$regNumber}' ";
			$result4 = mysql_query($query4, $connection);
			while ($row4 = mysql_fetch_array($result4)) {
				extract ($row4);
				$totalCoursesAttempted++;
				if($row4[6]=='DNR') ++$totalDNRcourses;
				if($row4[6]=='I') ++$totalIncomplete;
				if($row4[6]=='S') ++$totalSick;
			}
			doCoursesCount($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters);

			if($GLOBALS['PrevRemarkSNo']!=null && $GLOBALS['PrevRemarkSNo']!="" && $GLOBALS['PrevRemarkSNo']>0){
				$PrevRemarkSNo = $GLOBALS['PrevRemarkSNo'];
				$queryPrevRemark = "SELECT * from ".$tmp_remarkstable." where serialno='{$PrevRemarkSNo}' ";
				$resultPrevRemark = mysql_query($queryPrevRemark, $connection);
				extract (mysql_fetch_array($resultPrevRemark));
//if($regNumber=='126121013' || $regNumber=='126121027' || $regNumber=='126121033' || $regNumber=='126121053' || $regNumber=='126121086') echo $queryPrevRemark."   A <br>";
//echo $totalDNRcourses."  ==(".$GLOBALS['noofcourses']."   - ".$GLOBALS['noofrepeatcourses'].")      $regNumber      A<br><br>";
				if($totalDNRcourses==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalDNRcourses==$totalCoursesAttempted){
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

				$curGP =  getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevel, $sessionss, $semesters, $regNumber);
				$theCurGPs = explode("][", $curGP);
				$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevel, $sessionss, $semesters, $regNumber);
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

//if($regNumber>='126101004' && $regNumber<='126101005') echo number_format($cgpa,1)."  $curGP    $preGP  A  $remarkprob<br><br>";
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
					//if($regNumber=='126111005') echo  
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
					}else if(doubleval(number_format($cgpa,0))<1.00 && $remarkprob=="P2") {
						$remarkprob="P3TW";
						if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
					}else{
						$remarkprob="";
					}
				}
//if($regNumber>='126101004' && $regNumber<='126101005') echo "B  $remarkprob<br><br>";

				$queryRemark = "update ".$tmp_remarkstable." set remarkprob='{$remarkprob}', remarkdnr='{$remarkdnr}' where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
				mysql_query($queryRemark, $connection);

			}else{
				$queryD = "SELECT b.* FROM ".$tmp_regularstudents." a, ".$tmp_registration." b where a.regNumber=b.regNumber and a.regNumber='{$regNumber}' and ((b.sessions='{$sessionss}' and b.semester='{$semesters}') or (b.sessions='{$sessionss}' and b.semester<'{$semesters}') or (b.sessions<'{$sessionss}')) and b.sessions>='{$firstsession}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' order by b.sessions, b.semester ";
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
//echo  date("Y-m-d H:i:s")."  $query4  1<br> <br> <br>";
						while ($row4 = mysql_fetch_array($result4)) {
							extract ($row4);
							if($row4[6]=='DNR') ++$totalDNRcourses;
							if($row4[6]=='I') ++$totalIncomplete;
							if($row4[6]=='S') ++$totalSick;
							$totalCoursesAttempted++;
						}
						doCoursesCount($facultycodes, $departmentcodes, $programmecodes, $level, $sessions, $semester);

//echo $regNumber.'      '.$totalDNRcourses.'      '.$GLOBALS['noofcourses'].'<br><br>';
//if($regNumber>='126101009' && $regNumber<='126101009') echo "B   $sessions  $semester  ".$totalDNRcourses."   ".$GLOBALS['noofcourses']."  ".$GLOBALS['noofrepeatcourses']."   <br><br>";
//echo $totalDNRcourses."  ==(".$GLOBALS['noofcourses']."   - ".$GLOBALS['noofrepeatcourses'].")      $regNumber      B<br><br>";
//if($regNumber=='126121013' || $regNumber=='126121027' || $regNumber=='126121033' || $regNumber=='126121053' || $regNumber=='126121086') echo $regNumber."     $remarkdnr      $remarkprob<br>";
						if($totalDNRcourses==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalDNRcourses==$totalCoursesAttempted){ //&& $thecounter>=2
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
	//echo $remarkdnr.'   A<br>';
						if($sesionsreabsurption==$sessionss) $remarkdnr="";

	//echo  date("Y-m-d H:i:s")."    A<br> <br> <br>";
						$curGP =  getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevel, $sessions, $semester, $regNumber);
	//echo  date("Y-m-d H:i:s")."    B<br> <br> <br>";
						$theCurGPs = explode("][", $curGP);
						$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevel, $sessions, $semester, $regNumber);
	//echo  date("Y-m-d H:i:s")."    C<br> <br> <br>";
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
					}
					$queryRemark = "update ".$tmp_remarkstable." set remarkprob='{$remarkprob}', remarkdnr='{$remarkdnr}' where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
					mysql_query($queryRemark, $connection);
				}
			}
			//}

//echo date("Y-m-d H:i:s")." 1    $regNumber<br> <br>";
			$query2="SELECT * FROM ".$tmp_registration." where sessions='{$sessionss}' and semester='{$semesters}' and regNumber='{$regNumber}' and registered='Yes' ";
//if($regNumber>='126251001' && $regNumber<='126251013') echo $query2."<br>";
			$result2 = mysql_query($query2, $connection);
			if(mysql_num_rows($result2) > 0){
				if(mysql_num_rows($result2) > 1){
					$query3="SELECT max(serialno) as snodelete FROM ".$tmp_registration." where sessions='{$sessionss}' and semester='{$semesters}' and regNumber='{$regNumber}' and registered='Yes' ";
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3) > 0){
						extract (mysql_fetch_array($result3));
						$query3="delete FROM ".$tmp_registration." where serialno='{$snodelete}' ";
						mysql_query($query3, $connection);
					}
				}
				$query4 = "SELECT *  FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$regNumber}'";
//if($regNumber>='126251001' && $regNumber<='126251013') echo $query4."<br>";
				$result4 = mysql_query($query4, $connection);
				if(mysql_num_rows($result4)==0){
					$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT SIT FOR EXAM";
				}else{
					if($totalSick==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalSick==$totalCoursesAttempted){
						$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~S I C K";
					}

					if($remarkdnr=="DNR1"){
						$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER I";
					}
					if($remarkdnr=="DNR2"){
						$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER II";
					}
					if($remarkdnr=="DNR3VW"){
						$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER III";
					}

					if($totalIncomplete==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalIncomplete==$totalCoursesAttempted){
						$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~INCOMPLETE";
					}
				}
			}else{
				$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER";
			}
//echo date("Y-m-d H:i:s")." 2    $regNumber<br> <br>";
		}
//echo $absentstudent."<br>";
// 357, 372, 377, 380
		$absentstudents = explode("!!!", $absentstudent);
		$absentcounter=0;
		$GLOBALS['studentcounter']=0;
		$dltstudents = substr($dltstudents, 0, strlen($dltstudents)-2);
		$dltstudents = "'".str_replace("][", "','", $dltstudents)."'";
//echo $dltstudents."<br><br>";
		$queryAll = "SELECT a.*, b.* FROM ".$tmp_regularstudents." a, ".$tmp_registration." b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes' and a.active='Yes' and a.regNumber not in ($dltstudents) order by a.regNumber";
//echo $queryAll."<br><br>" ;
		$resultAll = mysql_query($queryAll, $connection);
		$count=1;
		$matno="";
		$thecoursecodes = $GLOBALS['thecoursecodes'];
		while ($rowAll = mysql_fetch_array($resultAll)) {
			extract ($rowAll);
			$matno=$rowAll[1];
//echo  date("Y-m-d H:i:s")."    $matno A<br> <br> <br>";


			$queryRemark = "SELECT remarkprob, remarkdnr from ".$tmp_remarkstable." where matricno='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
			$resultRemark = mysql_query($queryRemark, $connection);
			if(mysql_num_rows($resultRemark) > 0){
				extract (mysql_fetch_array($resultRemark));
			}

			//$fullname = strtoupper($rowAll[3]).", ".$rowAll[2];
			$fullname = $rowAll[3].", ".$rowAll[2];
			if($rowAll[11]>"") $fullname .= " ".$rowAll[11];
			$tempstudentdetail=$studentdetail;
			$studentdetail=$count++."._~_10!~~!".$rowAll[1]."_~_17!~~!".substr($fullname,0,35)."_~_60!~~!"; //.substr($rowAll[7],0,1)."_~_7!~~!";
			$tempstudentdetail=$studentdetail;
			$studentscounter++;
			if((($studentscounter-1) % $studentsperpage)==0 && $studentscounter>0) $startpage=$tempagecount;
			$pagecount=$startpage;
			$details .= substr($fullname,0,35)."_~_60!~~!"; //.substr($rowAll[4],0,1)."_~_7!~~!";
			$GLOBALS['globalfullname']=$fullname;

			$cgpa = 0; $ctnup = 0;
			$query = "SELECT a.*, b.serialno FROM ".$tmp_finalresultstable." a, ".$tmp_coursestable." b where (a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.sessiondescription='{$sessionss}' and a.semester='{$semesters}' and a.registrationnumber='{$matno}' and a.studentlevel='{$studentlevels}' and b.facultycode='{$facultycodes}' and b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and b.sessiondescription='{$sessionss}' and b.semesterdescription='{$semesters}' and b.studentlevel='{$studentlevels}') and a.coursecode=b.coursecode order by b.serialno, right(a.coursecode,3) desc, left(a.coursecode,3)";
//echo "$query----------------------- <br><br><br>"; //
			$result = mysql_query($query, $connection);
//echo $absentstudent."<br><br>";
//return true;
//echo date("Y-m-d H:i:s")."    $matno B <br> <br>";
			if(mysql_num_rows($result) > 0 && !str_in_str($absentstudent,$rowAll[1])){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);

//echo date("Y-m-d H:i:s")."    $matno 1 <br> <br>";
					$score="";
					foreach($thecoursecodes as $code){
//echo $registrationnumber."  -  ".$row[3]."  -  ".strlen($row[3])."  -  ".$code."  -  ".strlen($code)."<br>";
						if(trim($row[3])==trim($code)){
							$score = $row[5]."~~_".$row[6]."~~_".number_format($row[14],1);
							if($row[5]==0 || $row[5]==null){
								if($row[10]=="Sick"){
									//$score = "S~~_".$row[6]."~~_".number_format($row[14],1);
									$score = "~~_Sick~~_";
								}else if($row[10]=="Absent"){
									$score = "ABS~~_".$row[6]."~~_".number_format($row[14],1);
								}else if($row[10]=="Did Not Register"){
									//$score = "DNR~~_".$row[6]."~~_".number_format($row[14],1);
									$score = "~~_DNR~~_";
								}else if($row[10]=="Incomplete"){
									//$score = "I~~_".$row[6]."~~_".number_format($row[14],1);
									$score = "~~_I~~_";
								}else{
									$score = "00~~_".$row[6]."~~_".number_format($row[14],1);
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
//echo date("Y-m-d H:i:s")."    $matno 2 <br> <br>";
//echo $studentdetail."  -  ".$registrationnumber."<br><br>";
					
					if($coursesonlinecounter>$GLOBALS['maxcoursesperline']){
//echo $dltstudents."  -  ".$registrationnumber."<br>";;
						//if(str_in_str($dltstudents,$registrationnumber)) continue;
						++$pagecount;
						$repline = substr("00000", 0, 5-strlen($pagecount)).$pagecount."[]".$registrationnumber."][".$studentdetail."~!!~";
						$longstudentdetail .= $repline;
						$studentdetail = $tempstudentdetail;
					}
					$coursesonlinecounter=0;

					$matno=$registrationnumber;
//echo date("Y-m-d H:i:s")."4 <br> <br>";
//echo date("Y-m-d H:i:s")."    $matno 3 <br> <br>";
					$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$theCurGPs = explode("][", $curGP);
					$studentdetail .=  number_format($theCurGPs[0],1)."_~_7!~~!".$theCurGPs[1]."_~_7!~~!";
					$studentdetail .=  number_format($theCurGPs[2],2)."_~_7!~~!";

					$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
					$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM ".$tmp_regularstudents." where regNumber='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
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
//echo date("Y-m-d H:i:s")."5 <br> <br>";
//echo date("Y-m-d H:i:s")."    $matno 4 <br> <br>";
					$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$thePreGPs = explode("][", $preGP);
					$studentdetail .=  number_format((doubleval($thePreGPs[0])+doubleval($tcp)),1)."_~_7!~~!";
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
					$studentdetail .=  number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp)),1)."_~_7!~~!";
					$studentdetail .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7!~~!";
					$studentdetail .=  number_format($cgpa,2)."_~_7!~~!"; //.$ctnup."_~_9!~~!";
//echo $matno." A ".$cgpa."<br>";

//echo date("Y-m-d H:i:s")."6 <br> <br><br> <br>";
//echo date("Y-m-d H:i:s")."    $matno 5 <br> <br>";
					$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno, $finalyear, $cgpa, $ctnup);
//echo date("Y-m-d H:i:s")."   $remarks    $matno   <br> <br>";
//echo date("Y-m-d H:i:s")."   $remark    $regno  remark <br> <br>";
/* ----   A    ------*/
					$remcol = 27;
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
//echo date("Y-m-d H:i:s")."    $matno 6 <br> <br>";
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
					if($extraline>$GLOBALS['maxcoursesperline']){
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
					$studentdetail .=   number_format($theCurGPs[0],1)."_~_7!~~!".$theCurGPs[1]."_~_7!~~!";
					$studentdetail .=  number_format($theCurGPs[2],2)."_~_7!~~!";

					$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
					$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM ".$tmp_regularstudents." where regNumber='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";

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
					$studentdetail .=   number_format((doubleval($thePreGPs[0])+doubleval($tcp)),1)."_~_7!~~!";
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
					$studentdetail .=   number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp)),1)."_~_7!~~!";
					$studentdetail .=  (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."_~_7!~~!";
					$studentdetail .=  number_format($cgpa,2)."_~_7!~~!"; //.$ctnup."_~_9!~~!";
//echo $matno." B ".$cgpa."<br>";

					$remarks = getRemarks($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno, $finalyear, $cgpa, $ctnup);
//echo date("Y-m-d H:i:s")."   $remarks    $matno   <br> <br>";
/* ----   B    ------*/
					$remcol = 27;
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
//echo date("Y-m-d H:i:s")."    $matno C <br> <br>";
//echo $regNumber." ".$remarkprob." ".$remarkdnr."<br>";
		}
	}else{
		$query="select * from ".$tmp_mastereportbackup." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and reportline not like '%DLT%'";
//echo $query;
		$result=mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if(strlen(trim($reportline))>0) $longstudentdetail .= $reportline."~!!~";
		}
	}

//echo date("Y-m-d H:i:s")." 3 <br> <br>";
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
	if($pagestoprintB <= $GLOBALS['maxcoursesperline'] && $pagestoprintB <> 0) {
		$pagestoprint++;
		$colstoprintarray .= "~_~".$pagestoprintB;
		$mergesummaryheader=true;
	}
	if($pagestoprintB > $GLOBALS['maxcoursesperline']) {
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
		$query="delete from ".$tmp_mastereportbackup." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' ";
		mysql_query($query, $connection);

		$query="delete from mastereportbackup where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' ";
		mysql_query($query, $connection);
	}

	foreach($longstudentdetails as $row){
		if($modes=="process"){
			$query="select reportline from ".$tmp_mastereportbackup." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and reportline='{$row}' ";
			$result=mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				if(strlen(trim($row))>0){
					$querySNo="select max(serialno)+1 as nextserialno from ".$tmp_mastereportbackup;
					$resultSNo = mysql_query($querySNo, $connection);
					extract (mysql_fetch_array($resultSNo));

					if($nextserialno<=1){
						$querySNo="select max(serialno)+1 as nextserialno from mastereportbackup ";
						$resultSNo = mysql_query($querySNo, $connection);
						extract (mysql_fetch_array($resultSNo));
					}

					$query="insert into ".$tmp_mastereportbackup." (serialno, sessions, semester, facultycode, departmentcode, programmecode, studentlevel, reportline) values ('{$nextserialno}', '{$sessionss}', '{$semesters}', '{$facultycodes}', '{$departmentcodes}', '{$programmecodes}', '{$studentlevels}', '{$row}' )";
					mysql_query($query, $connection);
				}else{
					$query="UPDATE ".$tmp_mastereportbackup." SET sessions='{$sessionss}', semester='{$semesters}', facultycode='{$facultycodes}', departmentcode='{$departmentcodes}', programmecode='{$programmecodes}', studentlevel='{$studentlevels}', reportline='{$row}' ";
					mysql_query($query, $connection);
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
			
			if(str_in_str($mycol[0],"DID NOT SIT FOR EXAM") || str_in_str($mycol[0],"S I C K") || str_in_str($mycol[0],"DID NOT REGISTER") || str_in_str($mycol[0],"INCOMPLETE")){
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
			}
		}
		$pdf->Ln($height);
	}
	
	//where B.sessions='{$sessionss}' and B.semester='{$semesters}' 
	$query = "insert into remarkstable SELECT * FROM ".$tmp_remarkstable." B ON DUPLICATE KEY UPDATE matricno=B.matricno, remark=B.remark, sessions=B.sessions, semester=B.semester, facultycode=B.facultycode, departmentcode=B.departmentcode, programmecode=B.programmecode, studentlevel=B.studentlevel, RR=B.RR, remarkprob=B.remarkprob, remarkdnr=B.remarkdnr, prevtcp=B.prevtcp, prevtnu=B.prevtnu, prevgpa=B.prevgpa, prevtnup=B.prevtnup, currtcp=B.currtcp, currtnu=B.currtnu, currgpa=B.currgpa, currtnup=B.currtnup ";
	mysql_query($query, $connection);

	//where B.sessions='{$sessionss}' and B.semester='{$semesters}' 
	$query = "insert into mastereportbackup SELECT * FROM ".$tmp_mastereportbackup." B ON DUPLICATE KEY UPDATE sessions=B.sessions, semester=B.semester, facultycode=B.facultycode, departmentcode=B.departmentcode, programmecode=B.programmecode, studentlevel=B.studentlevel, reportline=B.reportline ";
	mysql_query($query, $connection);

	$currentusers = $_COOKIE['currentuser'];
	$query = "update currentrecord set currentrecordprocessing='stop_-_stop_-_stop', report='' where currentuser='{$currentusers}'";
	mysql_query($query, $connection);

	$pdf->Output();
	//$pdf->Output('c:/doc.pdf','F');

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
