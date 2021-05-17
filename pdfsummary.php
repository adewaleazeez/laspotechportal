<?php
	if($_COOKIE["currentuser"]==null || $_COOKIE["currentuser"]==""){
		echo '<script>alert("You must login to access this page!!!\n Click Ok to return to Login page.");</script>';
		echo '<script>window.location = "login.php";</script>';
		return true;
	}
	
	date_default_timezone_set("Africa/Lagos");
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

	global $theremark;

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

	global $header;
	global $footer;
	global $page;
	$GLOBALS['page']=0;

	global $globalfullname;
	$GLOBALS['globalfullname']="";

	global $studentsonroll;
	global $studentsregistered;
	global $studentsnotregistered;
	global $studentswithnooutstanding;
	global $studentswith1outstanding;
	global $studentswith2outstanding;
	global $studentswith3ormoreoutstanding;
	global $studentsonhonour;
	global $studentson1stprobation;
	global $studentson2ndprobation;
	global $studentstowithdraw;
	global $studentsonvoluntarywithdraw;
	global $studentsdismissed;
	global $thefirstsession;
	global $nooflines;
	global $noofcourses;
	global $noofrepeatcourses;
	global $tmp_finalresultstable;
	global $tmp_currentrecord;

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

	$tmp_summaryreport="tmp_".date("Y_m_d_H_i_s")."_summaryreport";
	while (true){
		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_summaryreport}'  ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$tmp_summaryreport="tmp_".date("Y_m_d_H_i_s")."_summaryreport";
		}else{
			break;
		}
	}

	$query = "create table ".$tmp_summaryreport." select * from summaryreport limit 0";
	mysql_query($query, $connection);

	$query = "alter table ".$tmp_summaryreport." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
	mysql_query($query, $connection);

	$query = "insert into ".$tmp_summaryreport." SELECT * FROM summaryreport where facultycode ='{$facultycodes}' and departmentcode ='{$departmentcodes}' and programmecode ='{$programmecodes}' and studentlevel ='{$studentlevels}' and sessions='{$sessionss}' and semester ='{$semesters}' ";
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
		if($tnu>0) $gpa += number_format(($tcp/$tnu),1);
		$str = $tcp ."][". $tnu ."][". $gpa ."][". $tnup;

		$queryRemark = "update ".$tmp_remarkstable." set currtcp='{$tcp}', currtnu='{$tnu}', currgpa='{$gpa}', currtnup='{$tnup}' where matricno='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
		mysql_query($queryRemark, $connection);

		return $str;
	}

	function getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno){
		include("data.php"); 
		$tmp_finalresultstable = $GLOBALS['tmp_finalresultstable'];
		$tmp_currentrecord = $GLOBALS['tmp_currentrecord'];
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
		if($tnu>0) $gpa += number_format(($tcp/$tnu),1);
		$str = $tcp ."][". $tnu ."][". $gpa ."][". $tnup;

		$queryRemark = "update ".$tmp_remarkstable." set prevtcp='{$tcp}', prevtnu='{$tnu}', prevgpa='{$gpa}', prevtnup='{$tnup}' where matricno='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
		mysql_query($queryRemark, $connection);

		return $str;
	}

	$currentusers = $_COOKIE['currentuser'];
	$query = "update currentrecord set currentrecordprocessing='', report='' where currentuser='{$currentusers}'";
	mysql_query($query, $connection);

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
		$globalstudentcounter = $GLOBALS['studentcounter'];
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
			
//if($regno=="126251002") echo date("Y-m-d H:i:s")."   $query2   <br> <br>";
			$result2 = mysql_query($query2, $connection);
			$usedcourse="";
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				if(str_in_str($usedcourse,$row2[0])) continue;
				
				$query = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
				
				if(!$allprevious) $query = "SELECT * FROM ".$tmp_finalresultstable." where registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
//if($regno=="126251002") echo date("Y-m-d H:i:s")."   $query   <br> <br>";
//if($regno=="126251002") echo $query."<br><br>";
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
//if($regno=="126251002") echo date("Y-m-d H:i:s")."   $query2   <br> <br>";
				$result2 = mysql_query($query2, $connection);
				$mycounter=0;
				$usedcourse="";
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					if(str_in_str($usedcourse,$row2[0])) continue;
					$mycounter++;

					$query = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
					
					if(!$allprevious) $query = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and marksobtained>=$row2[2] and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
//if($regno=="126251002") echo date("Y-m-d H:i:s")."   $query   <br> <br>";
//if($regno=='CSB0730485') echo $query." 3 $regno<br><br>";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result)==0){
						$query3 = "SELECT b.*, a.minimumscore FROM ".$tmp_coursestable." a, ".$tmp_retakecourses." b  where ((b.sessiondescription='{$sessionss}' and b.semester='{$semesters}') or (b.sessiondescription='{$sessionss}' and b.semester<'{$semesters}') or (b.sessiondescription<'{$sessionss}')) and b.sessiondescription>='{$firstsession}' and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and a.coursetype='Elective'  and a.studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}' ) and b.coursestatus='Ignore PCE'";
						
						if(!$allprevious) $query3 = "SELECT b.*, a.minimumscore FROM ".$tmp_coursestable." a, ".$tmp_retakecourses." b  where b.sessiondescription='{$sessionss}' and b.semester='{$semesters}' and b.sessiondescription>='{$firstsession}' and b.registrationnumber='{$regno}' and a.coursecode=b.coursecode and b.facultycode='{$facultycodes}' and  b.departmentcode='{$departmentcodes}' and b.programmecode='{$programmecodes}' and a.coursetype='Elective'  and a.studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}' ) and b.coursestatus='Ignore PCE'";
//if($regno=="126251002") echo date("Y-m-d H:i:s")."   $query3   <br> <br>";
						//and b.groupsession='{$groupsessions}' 
//if($regno=='CSB0730485') echo $query3." 3 $regno<br><br>";
						$result3 = mysql_query($query3, $connection);
						if(mysql_num_rows($result3)==0){
							if(!str_in_str($failedcourses,$row2[0])){

								// Check if course is attempted, if yes, record it
								$query4 = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
								
								if(!$allprevious) $query4 = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and sessiondescription>='{$firstsession}' and registrationnumber='{$regno}' and  coursecode='{$row2[0]}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
//if($regno=="126251002") echo date("Y-m-d H:i:s")."   $query4   <br> <br>";
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
				$query2 = "SELECT * FROM ".$tmp_finalresultstable." where ((sessiondescription='{$sessionss}' and semester='{$semesters}') or (sessiondescription='{$sessionss}' and semester<'{$semesters}') or (sessiondescription<'{$sessionss}')) and coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel in (SELECT distinct studentlevel FROM ".$tmp_registration." where regNumber='{$regno}' and studentlevel<= '{$studentlevels}') ";
				
				if(!$allprevious) $query2 = "SELECT * FROM ".$tmp_finalresultstable." where sessiondescription='{$sessionss}' and semester='{$semesters}' and coursecode='{$minimumscore[0]}' and marksobtained>=$minimumscore[1] and registrationnumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
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
				$query = "SELECT minimumunit FROM ".$tmp_regularstudents." where  regNumber='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' ";
				//and entryyear='{$groupsessions}'	
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
					$query = "SELECT min(a.qualificationcode) as qualification FROM ".$tmp_regularstudents." a, ".$tmp_registration." b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
						}
					}
					$query = "SELECT * FROM ".$tmp_cgpatable." where {$cgpa}>=lowerrange and {$cgpa}<=upperrange and sessions='{$sessionss}' and qualification='{$qualification}'";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_array($result)) {
							extract ($row);
							$remarks = $cgpacode;
						}
					}
				}
				$theremark="NR";
			}else{
				$remk = explode(", ", $remarks);
				$theremark = "R".trim(count($remk));
			}
		}else{
			if($remarks=="") $remarks="Passed";
			if($firstsession=="")  $remarks="DID NOT SIT FOR EXAM";
			if(str_in_str($remarks,"Passed")){
				$theremark="NR";
			}else{
				$remk = explode(", ", $remarks);
				$theremark = "R".trim(count($remk));
			}
		}
		$GLOBALS['theremark']=$theremark;
		//$query = "insert into ".$tmp_remarkstable." (matricno, remark) values ('{$regno}','{$remarks}')";
		//mysql_query($query, $connection);
		$str = $theremark."][";
		$queryRemark = "update ".$tmp_remarkstable." set remark='{$remarks}', RR='{$str}' where matricno='{$regno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
//if($regno=='126101001' || $regno=='126101011') echo $remarks." 5      $queryRemark<br><br>";
		mysql_query($queryRemark, $connection);

		return $remarks;
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

	/*$GLOBALS['noofcourses']=0;
	$GLOBALS['noofrepeatcourses']=0;
	$query = "SELECT distinct coursecode, coursetype FROM ".$tmp_coursestable." where (sessiondescription='{$sessionss}' and semesterdescription='{$semesters}') and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'  order by serialno, right(coursecode,3) desc, left(coursecode,3)";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$query2 = "SELECT distinct coursecode FROM ".$tmp_coursestable." where (sessiondescription<'{$sessionss}' or (sessiondescription='{$sessionss}' and semesterdescription<'{$semesters}')) and  facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel!='{$studentlevels}' and coursecode='{$row[0]}' ";
			$result2 = mysql_query($query2, $connection);
			if(mysql_num_rows($result2)>0) {
				$GLOBALS['noofrepeatcourses']++;
			}
			$GLOBALS['noofcourses']++;
		}
	}*/

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
			$tmp_cgpatable = $GLOBALS['tmp_cgpatable'];

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
			//$this->SetY($currentY);
			$this->SetFont('Times','B',10);
			$this->Cell(285,7,$schoolnames,0,0,'C');
			$this->Ln();
			$this->Cell(285,7,"SCHOOL OF ".$facultycodes,0,0,'C');
			$this->Ln();
			$this->Cell(285,7,"DEPARTMENT OF ".$departmentcodes,0,0,'C');
			$this->Ln();
			$this->Cell(285,7,$programmecodes." PROGRAMME",0,0,'C');
			$this->Ln();
			$this->Cell(285,7,$sessionss." ".$semesters." Semester Examination Results",0,0,'C');
			$this->Ln();
			if($this->PageNo()>2){
				if($resultype=="Repeaters Results"){
					$this->Cell(285,7,"REPEATERS LIST OF OUTSTANDING COURSES",0,0,'C');
				}else{
					$this->Cell(285,7,"LIST OF OUTSTANDING COURSES",0,0,'C');
				}
				$this->Ln();
			}
			$this->Cell(285,7,$studentlevels,0,0,'C');
			$this->Ln(7);

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
			if($this->PageNo()==1){
				$this->Cell(400,5,"Name: ___________________________________________________        Sign/Date: ____________________________________                         Sign: ___________________________________________________        Date: __________________________",0,0,'L');
				$this->Ln();
				//$this->Cell(150,5,"                                                Director/Assistant Director",0,0,'L');
				$this->Cell(400,5,"                                                Programme Coordinator                                                                                                                                                                                 Director/Assistant Director",0,0,'L');
				$this->Ln(15);
				$theDate=date("d/m/Y");
				$theHour=date("H");
				$theMins=date("i");
				$theSecs=date("s");
				$theAmPm=" AM";
				$theHour=intval($theHour)-1;
				if($theHour > 12){
					$theHour-=12;
					$theAmPm=" PM";
				}
				$this->Cell(150,5,"Academid Board Approval: Sign ________________________________________________________        Date: __________________________                                                                                                                                 Printed: ".date("d/m/Y  "),0,0,'L');
				//.$theHour.":".$theMins.":".$theSecs.$theAmPm
				$this->Ln();
				$this->Cell(150,5,"                                                                                   Rector/Deputy Rector",0,0,'L');
				$this->Ln();
			}
			if($this->PageNo()==2){
				$this->Ln(18);
				$this->Cell(150,5,"ACB Approval: Sign ________________________________________________________        Date: __________________________",0,0,'L');
				$this->Ln();
				$this->Cell(150,5,"                                                                    Rector/Deputy Rector",0,0,'L');
				$this->Ln();
			}
			if($this->PageNo()>2){
				$this->Ln(18);
				$this->Cell(150,5,"ACB Approval: Sign ________________________________________________________        Date: __________________________",0,0,'L');
				$this->Ln();
				$this->Cell(150,5,"                                                                    Rector/Deputy Rector",0,0,'L');
				$this->Ln();
				$this->SetFont('Times','B',10);
				$noofpagesA = intval($GLOBALS['nooflines'] / 25);
				$noofpagesB = $GLOBALS['nooflines'] % 25;
				$noofpages = $noofpagesA;
				if($noofpagesB>0) ++$noofpages;
				$this->Cell(0,5,'Page '.(($this->PageNo())-2).'/'.$noofpages,0,0,'C');
			}
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

	global $globalrepoline;
	$GLOBALS['globalrepoline']="";
	global $studentcounter;

	function displayReport($sessionss,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear){
		$resultype = $GLOBALS['resultype'];
		$tmp_regularstudents = $GLOBALS['tmp_regularstudents'];
		$tmp_registration = $GLOBALS['tmp_registration'];
		$tmp_remarkstable = $GLOBALS['tmp_remarkstable'];
		$tmp_finalresultstable = $GLOBALS['tmp_finalresultstable'];


		include("data.php"); 

		$dltstudents="";

		$modes = $GLOBALS['modes'];
//echo date("Y-m-d H:i:s")." 2   $modes<br> <br>";
		$query = "SELECT distinct a.*, b.regNumber, b.regNumber, b.studentlevel, b.sessions, b.semester FROM ".$tmp_regularstudents." AS a JOIN ".$tmp_registration." AS b ON a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes'  order by a.regNumber";
		$result = mysql_query($query, $connection);
		$absentstudent="";
		$totalDNRcourses=0; $totalIncomplete=0; $totalSick=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$regNumber=$row[1];

			$currentusers = $_COOKIE['currentuser'];
			$globalfullnames = $GLOBALS['globalfullname'];
			$globalstudentcounter = ++$GLOBALS['studentcounter'];
			$currentrecordprocessings = str_replace(" ","spc", $globalstudentcounter."_-_".$regno."_-_".$globalfullnames);
			$queryZ = "update currentrecord set currentrecordprocessing='{$currentrecordprocessings}', report='' where currentuser='{$currentusers}'";
			mysql_query($queryZ, $connection);

			$queryRemark = "SELECT remark, remarkprob, remarkdnr  from ".$tmp_remarkstable." where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
//if($regNumber>='126101001' && $regNumber<='126101011') echo "  A   $queryRemark<br><br>";
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
//if($regNumber>='126101004' && $regNumber<='126101005') echo "  B   $queryPrevRemark<br><br>";
//echo date("Y-m-d H:i:s")."  $queryPrevRemark<br>";
				$resultPrevRemark = mysql_query($queryPrevRemark, $connection);
				if(mysql_num_rows($resultPrevRemark) > 0){
					extract (mysql_fetch_array($resultPrevRemark));
					$GLOBALS['PrevRemarkSNo']=$serialno;
					$GLOBALS['PrevSession']=$PrevSession;
					$GLOBALS['PrevSemester']=$PrevSemester;
				}
			}

			$queryD = "SELECT min(sessions) as firstsession FROM ".$tmp_registration." where regNumber='{$regNumber}'  ";
			$resultD = mysql_query($queryD, $connection);
			extract (mysql_fetch_array($resultD));

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
//if($regNumber>='126101004' && $regNumber<='126101005') echo "   $queryPrevRemark   <br><br>";
				$resultPrevRemark = mysql_query($queryPrevRemark, $connection);
				extract (mysql_fetch_array($resultPrevRemark));

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
					if(doubleval(number_format($cgpa,1))<0.5 && $remarkprob=="P1") {
						$remarkprob="P2TW";
						if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
					}else if(doubleval(number_format($cgpa,1))<0.5 && $remarkprob=="P2") {
						$remarkprob="P3TW";
						if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
					}else if(doubleval(number_format($cgpa,1))<1.0 && $remarkprob=="") {
						$remarkprob="P1";
						if(str_in_str($remarkdnr,"DNR")) $remarkprob="";
					}else if(doubleval(number_format($cgpa,1))<1.0 && $remarkprob=="P1") {
						$remarkprob="P2";
						if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
					}else if(doubleval(number_format($cgpa,1))<1.0 && $remarkprob=="P2") {
						$remarkprob="P3TW";
						if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
					}else{
						$remarkprob="";
					}
				}
//if($regNumber>='126101004' && $regNumber<='126101005') echo "B  $remarkprob<br><br>";

				$queryRemark = "update ".$tmp_remarkstable." set remarkprob='{$remarkprob}', remarkdnr='{$remarkdnr}' where matricno='{$regNumber}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
				mysql_query($queryRemark, $connection);

//if($regNumber>='126101001' && $regNumber<='126101011') echo $queryRemark."  1   queryRemark<br><br>";
			}else{
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
						if(($totalDNRcourses==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses']) || $totalDNRcourses==$totalCoursesAttempted) && $thecounter>=2){
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
							if(doubleval(number_format($cgpa,1))<0.5 && $remarkprob=="P1") {
								$remarkprob="P2TW";
								if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
							}else if(doubleval(number_format($cgpa,1))<0.5 && $remarkprob=="P2") {
								$remarkprob="P3TW";
								if(str_in_str($remarkdnr,"DNR")) $remarkprob="P2";
							}else if(doubleval(number_format($cgpa,1))<1.0 && $remarkprob=="") {
								$remarkprob="P1";
								if(str_in_str($remarkdnr,"DNR")) $remarkprob="";
							}else if(doubleval(number_format($cgpa,1))<1.0 && $remarkprob=="P1") {
								$remarkprob="P2";
								if(str_in_str($remarkdnr,"DNR")) $remarkprob="P1";
							}else if(doubleval(number_format($cgpa,1))<1.0 && $remarkprob=="P2") {
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
			}

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
					if($totalSick==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses'])){
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

					if($totalIncomplete==($GLOBALS['noofcourses'] - $GLOBALS['noofrepeatcourses'])){
						$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~INCOMPLETE";
					}
				}
			}else{
				$absentstudent .="!!!".$row[1]."~~".$row[3].", ".$row[2]." ".$row[11]."~~".$row[7]."~~DID NOT REGISTER";
			}
		}
		$GLOBALS['studentcounter']=0;

//echo $absentstudent."<br>";
// 357, 372, 377, 380
		$absentstudents = explode("!!!", $absentstudent);
		$absentcounter=0;

		$dltstudents = substr($dltstudents, 0, strlen($dltstudents)-2);
		$dltstudents = "'".str_replace("][", "','", $dltstudents)."'";
//echo $dltstudents."<br><br>";
		$query = "SELECT a.*, b.* FROM ".$tmp_regularstudents." a, ".$tmp_registration." b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes' and a.active='Yes' and a.regNumber not in ($dltstudents) order by a.regNumber";
//echo $query."<br>"; //  -- and a.regNumber<='ACC/P.086011050' ;
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$count=1;
			$matno="";
			$matnofullnamegender="";
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				if($regNumber <> $matno){
					$matno = $regNumber;

					$queryRemark = "SELECT remarkprob, remarkdnr from ".$tmp_remarkstable." where matricno='{$matno}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessions='{$sessionss}' and semester='{$semesters}' ";
					$resultRemark = mysql_query($queryRemark, $connection);
					if(mysql_num_rows($resultRemark) > 0){
						extract (mysql_fetch_array($resultRemark));
					}

					//$fullname = strtoupper($lastName).", ".$firstName;
					$fullname = $lastName.", ".$firstName;
					$GLOBALS['globalfullname']=$fullname;
					if($middleName>"") $fullname .= " ".$middleName;
					$matnofullnamegender = $regNumber."][".$fullname."][".$row4[4]."][";

					$currentusers = $_COOKIE['currentuser'];
					$globalfullnames = $GLOBALS['globalfullname'];
					$globalstudentcounter = ++$GLOBALS['studentcounter'];
					$currentrecordprocessings = str_replace(" ","spc", $globalstudentcounter."_-_".$regNumber."_-_".$globalfullnames);
					$query = "update currentrecord set currentrecordprocessing='{$currentrecordprocessings}', report='' where currentuser='{$currentusers}'";
					mysql_query($query, $connection);


					$curGP = getCurrentGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$theCurGPs = explode("][", $curGP);

					$preGP = getPreviousGPA($facultycodes, $departmentcodes, $programmecodes, $studentlevels, $sessionss, $semesters, $matno);
					$thePreGPs = explode("][", $preGP);
				
					if((($theCurGPs[0]+$thePreGPs[0]+$tcp)==0) || 
						(($theCurGPs[1]+$thePreGPs[1]+$tnu)==0)){
						$cgpa = 0;
					}else{
						$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
					}
					$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));
					$remarks = getRemarks($facultycodes,$departmentcodes,$programmecodes,$studentlevels,$sessionss,$semesters,$matno,$finalyear,$cgpa,$ctnup);
//echo $sessionss."    ".$semesters."    ".$matno."    ".$remarks."<br><br>";							
					$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks."][$repotype][".$GLOBALS['theremark']." ".$remarkprob." ".$remarkdnr."~_~";
//echo $matnofullnamegender.$cgpa."][".$ctnup."][".$remarks.$remarkprob.$remarkdnr."][$repotype][".$GLOBALS['theremark']."~_~<br><br>";
					
				}
			}
		}
		//echo $dltstudents;
	}

	$modes = $GLOBALS['modes'];
	if($modes=="process"){
		$GLOBALS['studentcounter']=0;
		displayReport($sessionss,$semesters,$facultycodes,$departmentcodes,$programmecodes,$studentlevels,$finalyear);
	}else{
		$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup!='NR' and ctnup not like '%DLT%' ";
		$result=mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$matnofullnamegender = $matricno."][".$fullname."][".$gender."][";
			$GLOBALS['theremark'].=$PI.$PII.$TW;
			$GLOBALS['globalrepoline'] .= $matnofullnamegender.$cgpa."][".$ctnup."][".$remark."][$repotype][".$ctnup."~_~";
		}
	}
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->SetFont('Times','B',7.5);

	$modes = $GLOBALS['modes'];
	if($modes=="process"){
		$query = "delete from  ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'";
		mysql_query($query, $connection);

		$query = "delete from summaryreport where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'";
		mysql_query($query, $connection);
	}

	$GLOBALS['globalrepoline'] = substr($GLOBALS['globalrepoline'],0,strlen($GLOBALS['globalrepoline'])-3);
	$globalarray = explode("~_~", $GLOBALS['globalrepoline']);

	for($k=0; $k<count($globalarray); $k++){
		$glb = explode("][", $globalarray[$k]);
		if($modes=="process"){
			$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and matricno='{$glb[0]}' ";
			$result=mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "select * from ".$tmp_remarkstable." where matricno='{$glb[0]}' and sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
					}
				}

				$querySNo="select max(serialno)+1 as nextserialno from ".$tmp_summaryreport;
				$resultSNo = mysql_query($querySNo, $connection);
				extract (mysql_fetch_array($resultSNo));

				if($nextserialno<=1){
					$querySNo="select max(serialno)+1 as nextserialno from summaryreport ";
					$resultSNo = mysql_query($querySNo, $connection);
					extract (mysql_fetch_array($resultSNo));
				}

				$query = "insert into ".$tmp_summaryreport." (sessions,semester,facultycode,departmentcode,programmecode,studentlevel, matricno,fullname,gender,cgpa,ctnup,remark,reporttype) values ('{$sessionss}','{$semesters}','{$facultycodes}','{$departmentcodes}','{$programmecodes}','{$studentlevels}','{$glb[0]}','{$glb[1]}','{$glb[2]}',{$glb[3]},'{$glb[7]}','{$remark}','{$glb[6]}')";
				mysql_query($query, $connection);
			}
		}
	}

	$query = "SELECT min(a.qualificationcode) as qualification FROM ".$tmp_regularstudents." a, ".$tmp_registration." b where a.regNumber=b.regNumber and b.sessions='{$sessionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' ";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
		}
	}

	$query = "SELECT * FROM ".$tmp_cgpatable." where sessions='{$sessionss}' and qualification='{$qualification}'";
	$result = mysql_query($query, $connection);
	$honourgrade=0;
	$passgrade=0;
	$failgrade=0;
	$distinctionA=0;
	$distinctionB=0;
	$upperA=0;
	$upperB=0;
	$lowerA=0;
	$lowerB=0;
	$passA=0;
	$passB=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			if($cgpacode=="DISTINCTION"){ $distinctionA=$lowerrange; $distinctionB=$upperrange; $honourgrade=$lowerrange; }
			if($cgpacode=="UPPER CREDIT"){ $upperA=$lowerrange; $upperB=$upperrange; }
			if($cgpacode=="LOWER CREDIT"){ $lowerA=$lowerrange; $lowerB=$upperrange; }
			if($cgpacode=="PASS"){ $passA=$lowerrange; $passB=$upperrange; $passgrade=$lowerrange; }
		}
	}
	
	$honourgrade=3.25;
	//$passgrade=2.0;
	//$failgrade=1.0;
	$passgrade=1.0;
	$failgrade=0.5;

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and cgpa>={$honourgrade} ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentsonhonour']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like '%P1%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentson1stprobation']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like '%P2%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentson2ndprobation']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and (ctnup like '%TW%' or ctnup like  '%VW%') ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentstowithdraw']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup not like '%DLT%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentsonroll']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like  '%VW%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentsonvoluntarywithdraw']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like '%DLT%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentsdismissed']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup = 'NR' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentswithnooutstanding']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like '%R1 %' and ctnup not like '%DLT%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentswith1outstanding']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like '%R2 %' and ctnup not like '%DLT%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentswith2outstanding']=mysql_num_rows($result);

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and remark<>'Passed' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['nooflines']=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			++$GLOBALS['nooflines'];
			extract ($row);
			$nooffailedcourses = explode(",", $row[6]);
			$nooffailedcourses = count($nooffailedcourses);
			$lines4studentA = intval($nooffailedcourses / 14);
			$lines4studentB = $nooffailedcourses % 14;
			if($lines4studentA >= 1) --$lines4studentA;
			if($nooffailedcourses > 14 && $lines4studentB > 0) ++$lines4studentA;
			$GLOBALS['nooflines'] += $lines4studentA;
		}
	}

	$query="select count(*) as totalDNRstudents from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like '%DNR%' ";
	$result=mysql_query($query, $connection);
	extract (mysql_fetch_array($result));
	$GLOBALS['studentsnotregistered']=$totalDNRstudents;
	$GLOBALS['studentsregistered'] = $GLOBALS['studentsonroll'] - $GLOBALS['studentsnotregistered'];

	$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup like '%R%' and ctnup not like '%NR%' and ctnup not like '%R1 %' and ctnup not like '%R2 %' and ctnup not like '%DLT%' ";
	$result=mysql_query($query, $connection);
	$GLOBALS['studentswith3ormoreoutstanding']=mysql_num_rows($result)+ $GLOBALS['studentsnotregistered'];

	if($GLOBALS['studentsonroll']==null || $GLOBALS['studentsonroll']=="" || $GLOBALS['studentsonroll']==0) 
		$GLOBALS['studentsonroll']="Nil";

	if($GLOBALS['studentsregistered']==null || $GLOBALS['studentsregistered']=="" || $GLOBALS['studentsregistered']==0) 
		$GLOBALS['studentsregistered']="Nil";

	if($GLOBALS['studentsnotregistered']==null || $GLOBALS['studentsnotregistered']=="" || $GLOBALS['studentsnotregistered']==0) 
		$GLOBALS['studentsnotregistered']="Nil";

	if($GLOBALS['studentswithnooutstanding']==null || $GLOBALS['studentswithnooutstanding']=="" || $GLOBALS['studentswithnooutstanding']==0) 
		$GLOBALS['studentswithnooutstanding']="Nil";

	if($GLOBALS['studentswith1outstanding']==null || $GLOBALS['studentswith1outstanding']=="" || $GLOBALS['studentswith1outstanding']==0) 
		$GLOBALS['studentswith1outstanding']="Nil";

	if($GLOBALS['studentswith2outstanding']==null || $GLOBALS['studentswith2outstanding']=="" || $GLOBALS['studentswith2outstanding']==0) 
		$GLOBALS['studentswith2outstanding']="Nil";

	if($GLOBALS['studentswith3ormoreoutstanding']==null || $GLOBALS['studentswith3ormoreoutstanding']=="" || $GLOBALS['studentswith3ormoreoutstanding']==0) 
		$GLOBALS['studentswith3ormoreoutstanding']="Nil";

	if($GLOBALS['studentsonhonour']==null || $GLOBALS['studentsonhonour']=="" || $GLOBALS['studentsonhonour']==0) 
		$GLOBALS['studentsonhonour']="Nil";

	if($GLOBALS['studentson1stprobation']==null || $GLOBALS['studentson1stprobation']=="" || $GLOBALS['studentson1stprobation']==0) 
		$GLOBALS['studentson1stprobation']="Nil";

	if($GLOBALS['studentson2ndprobation']==null || $GLOBALS['studentson2ndprobation']=="" || $GLOBALS['studentson2ndprobation']==0) 
		$GLOBALS['studentson2ndprobation']="Nil";

	if($GLOBALS['studentstowithdraw']==null || $GLOBALS['studentstowithdraw']=="" || $GLOBALS['studentstowithdraw']==0) 
		$GLOBALS['studentstowithdraw']="Nil";

	if($GLOBALS['studentsonvoluntarywithdraw']==null || $GLOBALS['studentsonvoluntarywithdraw']=="" || $GLOBALS['studentsonvoluntarywithdraw']==0) 
		$GLOBALS['studentsonvoluntarywithdraw']="Nil";

	if($GLOBALS['studentsdismissed']==null || $GLOBALS['studentsdismissed']=="" || $GLOBALS['studentsdismissed']==0) 
		$GLOBALS['studentsdismissed']="Nil";

	$numberofallgraduatingstudents=0;
	$numberofgraduatingstudentswithdistinction=0;
	$numberofgraduatingstudentswithuppercredit=0;
	$numberofgraduatingstudentswithlowercredit=0;
	$numberofgraduatingstudentswithpass=0;
		
	if($GLOBALS['semesters']=="2ND" && ($finalyear=="Yes" || str_in_str($GLOBALS['studentlevels'],"NDIII"))){
//echo $distinctionA."  ".$distinctionB."  ".$upperA."  ".$upperB."  ".$lowerA."  ".$lowerB."  ".$passA."  ".$passB."<br>";
		$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' order by cgpa DESC, matricno";
//echo $query."<br>";
		$result=mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				if($cgpa>=$distinctionA && $cgpa<=$distinctionB) $numberofgraduatingstudentswithdistinction++;
				if($cgpa>=$upperA && $cgpa<=$upperB) $numberofgraduatingstudentswithuppercredit++;
				if($cgpa>=$lowerA && $cgpa<=$lowerB) $numberofgraduatingstudentswithlowercredit++;
				if($cgpa>=$passA && $cgpa<=$passB) $numberofgraduatingstudentswithpass++;
			}
		}
		
		$query="select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup='NR' order by cgpa DESC, matricno";
//echo $query."<br>";
		$result=mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$pdf->AddPage();
			$pdf->Cell(175,8,"",0,1,'L');
			$pdf->SetFont('Times','B',7.5);
			$pdf->Cell(175,6,"LIST OF GRADUATING STUDENTS",1,0,'C');
			$pdf->Ln();
			$pdf->SetFont('Times','B',9);

			$pdf->Cell(10,6,"S/No",1,0,'R');
			$pdf->Cell(30,6,"MATRIC NO",1,0,'L');
			$pdf->Cell(65,6,"NAMES",1,0,'L');
			$pdf->Cell(15,6,"CGPA",1,0,'C');
			$pdf->Cell(55,6,"CLASSIFICATION",1,0,'L');
			$pdf->Ln(6);
			$count=0;
			$numberofallgraduatingstudents=mysql_num_rows($result);
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$pdf->Cell(10,6,++$count,1,0,'R');
				$pdf->Cell(30,6,$matricno,1,0,'L');
				$queryNames="select concat(mid(firstName, 1, 1), LOWER(mid(firstName,2)),' ',mid(middleName, 1, 1), LOWER(mid(middleName,2)), ', ', UPPER(lastName)) as fullnames from ".$tmp_regularstudents." where regNumber='{$matricno}' ";
				$resultNames=mysql_query($queryNames, $connection);
				extract (mysql_fetch_array($resultNames));

				$pdf->Cell(65,6,$fullnames,1,0,'L');
				$pdf->Cell(15,6,number_format($cgpa,2),1,0,'C');
				$pdf->Cell(55,6,$remark,1,0,'L');
				if($pdf->GetY()>=241.00125){
					$pdf->AddPage();
					$pdf->Cell(175,8,"",0,1,'L');
					$pdf->SetFont('Times','B',7.5);
					$pdf->Cell(175,6,"LIST OF GRADUATING STUDENTS",1,0,'C');
					$pdf->Ln();
					$pdf->SetFont('Times','B',9);

					$pdf->Cell(10,6,"S/No",1,0,'R');
					$pdf->Cell(30,6,"MATRIC NO",1,0,'L');
					$pdf->Cell(65,6,"NAMES",1,0,'L');
					$pdf->Cell(15,6,"CGPA",1,0,'C');
					$pdf->Cell(55,6,"CLASSIFICATION",1,0,'L');
					$pdf->Ln(6);
				}else{
					$pdf->Ln(6);
				}
			}
		}
	}

	//if(($pdf->GetY() + 20) < 285){
	//	$pdf->Ln();
	//}else{
		$pdf->AddPage();
	//}
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(190,6,"SUMMARY OF RESULTS",1,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Times','B',9);

	if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
		$pdf->Cell(130,6,"NUMBER OF STUDENTS ON ROLL",1,0,'L');
		$pdf->Cell(60,6,$GLOBALS['studentsonroll'],1,0,'L');
		$pdf->Ln();
	}
	$pdf->Cell(130,6,"NUMBER OF STUDENTS REGISTERED",1,0,'L');
	$pdf->Cell(60,6,$GLOBALS['studentsregistered'],1,0,'L');
	$pdf->Ln();
	
	if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
		$pdf->Cell(130,6,"NUMBER OF STUDENTS DID NOT REGISTER",1,0,'L');
		$pdf->Cell(60,6,$GLOBALS['studentsnotregistered'],1,0,'L');
		$pdf->Ln();
	}

	if($GLOBALS['semesters']=="2ND" && ($finalyear=="Yes" || str_in_str($GLOBALS['studentlevels'],"NDIII") || str_in_str($GLOBALS['studentlevels'],"HNDIII"))){
		$pdf->Cell(130,6,"NUMBER OF STUDENTS GRADUATING ",1,0,'L');
		$pdf->Cell(60,6,$numberofallgraduatingstudents,1,0,'L');
		$pdf->Ln(6);
		$pdf->Cell(130,6,"NUMBER OF STUDENTS GRADUATING WITH DISTINCTION (CGPA ".number_format($distinctionA,2)." - ".number_format($distinctionB,2).")",1,0,'L');
		$pdf->Cell(60,6,$numberofgraduatingstudentswithdistinction,1,0,'L');
		$pdf->Ln(6);
		$pdf->Cell(130,6,"NUMBER OF STUDENTS GRADUATING WITH UPPER CREDIT (CGPA ".number_format($upperA,2)." - ".number_format($upperB,2).")",1,0,'L');
		$pdf->Cell(60,6,$numberofgraduatingstudentswithuppercredit,1,0,'L');
		$pdf->Ln(6);
		$pdf->Cell(130,6,"NUMBER OF STUDENTS GRADUATING WITH LOWER CREDIT (CGPA ".number_format($lowerA,2)." - ".number_format($lowerB,2).")",1,0,'L');
		$pdf->Cell(60,6,$numberofgraduatingstudentswithlowercredit,1,0,'L');
		$pdf->Ln(6);
		$pdf->Cell(130,6,"NUMBER OF STUDENTS GRADUATING WITH PASS (CGPA ".number_format($passA,2)." - ".number_format($passB,2).")",1,0,'L');
		$pdf->Cell(60,6,$numberofgraduatingstudentswithpass,1,0,'L');
		$pdf->Ln(6);
	}else{
		$pdf->Cell(130,6,"NUMBER OF STUDENTS WITH NO OUTSTANDING COURSE",1,0,'L');
		$pdf->Cell(60,6,$GLOBALS['studentswithnooutstanding'],1,0,'L');
		$pdf->Ln();
	}
	//if($GLOBALS['sessions'] > $GLOBALS['thefirstsession'] || ($GLOBALS['studentlevels']!="NDI" && $GLOBALS['studentlevels']!="HNDI")){
	$pdf->Cell(130,6,"NUMBER OF STUDENTS WITH ONE OUTSTANDING COURSE",1,0,'L');
	$pdf->Cell(60,6,$GLOBALS['studentswith1outstanding'],1,0,'L');
	$pdf->Ln();
	
	$pdf->Cell(130,6,"NUMBER OF STUDENTS WITH TWO OUTSTANDING COURSES",1,0,'L');
	$pdf->Cell(60,6,$GLOBALS['studentswith2outstanding'],1,0,'L');
	$pdf->Ln();
	
	$pdf->Cell(130,6,"NUMBER OF STUDENTS WITH THREE OR MORE OUTSTANDING COURSES",1,0,'L');
	$pdf->Cell(60,6,$GLOBALS['studentswith3ormoreoutstanding'],1,0,'L');
	$pdf->Ln();
	
	if($GLOBALS['semesters']=="2ND"){
		$pdf->Cell(130,6,"NUMBER OF STUDENTS ON HONOUR'S ROLL (WITH CGPA ".number_format($honourgrade,2)." AND ABOVE)",1,0,'L');
		$pdf->Cell(60,6,$GLOBALS['studentsonhonour'],1,0,'L');
		$pdf->Ln();
	}

	$pdf->Cell(130,6,"NUMBER OF STUDENTS ON 1ST PROBATION (WITH CGPA BELOW ".number_format($passgrade,2).")",1,0,'L');
	$pdf->Cell(60,6,$GLOBALS['studentson1stprobation'],1,0,'L');
	$pdf->Ln();

	//if($GLOBALS['sessions'] > $GLOBALS['thefirstsession'] || ($GLOBALS['studentlevels']!="NDI" && $GLOBALS['studentlevels']!="HNDI")){
	if(!($GLOBALS['semesters']=="1ST" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
		$pdf->Cell(130,6,"NUMBER OF STUDENTS ON 2ND PROBATION (WITH CGPA BELOW ".number_format($passgrade,2).")",1,0,'L');
		$pdf->Cell(60,6,$GLOBALS['studentson2ndprobation'],1,0,'L');
		$pdf->Ln();
		
		if(($GLOBALS['semesters']=="2ND" && ($GLOBALS['studentlevels']=="NDI" || $GLOBALS['studentlevels']=="HNDI"))){
			$pdf->Cell(130,6,"NUMBER OF STUDENTS TO WITHDRAW (WITH CGPA BELOW ".number_format($failgrade,2).")",1,0,'L');
			$pdf->Cell(60,6,$GLOBALS['studentstowithdraw'],1,0,'L');
			$pdf->Ln();
		}else{
			$pdf->Cell(130,6,"NUMBER OF STUDENTS TO WITHDRAW",1,0,'L');
			$pdf->Cell(60,6,$GLOBALS['studentstowithdraw'],1,0,'L');
			$pdf->Ln();
		}

		$pdf->Cell(130,6,"NUMBER OF STUDENTS ON VOLUNTARY WITHDRAWAL",1,0,'L');
		$pdf->Cell(60,6,$GLOBALS['studentsonvoluntarywithdraw'],1,0,'L');
		$pdf->Ln();
	}
	$pdf->Cell(130,6,"NUMBER OF STUDENTS DISMISSED",1,0,'L');
	$pdf->Cell(60,6,$GLOBALS['studentsdismissed'],1,0,'L');
	$pdf->Ln();

	//if($pdf->GetY()>=41.00125){
	//	$pdf->AddPage();
	//}else{
	//	$pdf->Ln(6);
	//}
	//if($pdf->GetY() <= 253){
	//	$pdf->Ln();
	//}else{
		$pdf->AddPage();
	//}
	//$pdf->Cell(140,6,"",0,1,'L');
	$pdf->SetFont('Times','B',7.5);
	$pdf->Cell(220,6,"DESCRIPTION OF CODES AND CREDIT UNITS ",1,0,'C');
	$pdf->Ln();
	$pdf->SetFont('Times','B',9);

	$pdf->Cell(10,6,"S/No",1,0,'R');
	$pdf->Cell(30,6,"COURSE CODES",1,0,'L');
	$pdf->Cell(150,6,"COURSE TITLES",1,0,'L');
	$pdf->Cell(30,6,"CREDIT UNITS",1,0,'C');
	$pdf->Ln(6);

	$query = "SELECT * FROM ".$tmp_coursestable." where facultycode='{$facultycodes}' and  departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sessionss}'and semesterdescription='{$semesters}' order by serialno ";
//echo $query;	
	$result=mysql_query($query, $connection);
	$count=0;
	while ($row = mysql_fetch_array($result)) {
		extract ($row);
		$pdf->Cell(10,6,++$count,1,0,'C');
		$pdf->Cell(30,6,$coursecode,1,0,'C');
		$pdf->Cell(150,6,$coursedescription,1,0,'L');
		$pdf->Cell(30,6,number_format($courseunit,0),1,0,'C');
		if($pdf->GetY()>=265 && $count<mysql_fetch_array($result)){
			$pdf->AddPage();
			$pdf->Cell(140,6,"",0,1,'L');
			$pdf->SetFont('Times','B',7.5);
			$pdf->Cell(170,6,"LIST OF COURSES Continued.......",1,0,'C');
			$pdf->Ln();
			$pdf->SetFont('Times','B',9);

			$pdf->Cell(10,6,"S/No",1,0,'C');
			$pdf->Cell(30,6,"COURSE CODES",1,0,'C');
			$pdf->Cell(150,6,"COURSE TITLES",1,0,'L');
			$pdf->Cell(30,6,"COURSE UNITS",1,0,'C');
			$pdf->Ln(6);
		}else{
			$pdf->Ln(6);
		}
	}

	$pdf->Ln();

	$query = "select * from ".$tmp_summaryreport." where sessions='{$sessionss}'  and semester='{$semesters}' and facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and ctnup!='NR' and ctnup not like '%DLT%' order by matricno";
//ECHO $query;
	$result = mysql_query($query, $connection);
	$pdf->AddPage();
	$pdf->SetFont('Times','B',7);
	$pdf->Cell(10,4,"S/NO",1,0,'C');
	$pdf->Cell(17,4,"MATRIC NO",1,0,'C');
	$pdf->Cell(50,4,"FULL NAME",1,0,'L');
	//$pdf->Cell(20,4,"COURSES","LBR",0,'C');
	$pdf->Cell(30,4,"REMARKS",1,0,'C');
	$pdf->Cell(160,4,"OUTSTANDING COURSES",1,0,'L');
	$pdf->Ln(4);
	$count=0;
	$lines=0;
	while ($row = mysql_fetch_array($result)) {
		extract ($row);
		$lines = strlen($row[6])/140;
		if((strlen($row[6]) % 140) > 0) $lines = intval($lines) + 1;
		if(strlen($row[6])<=140) $lines = 1;
		$height=5;
		//if($lines>1) $height=6;
		$pdf->Cell(10,$height * $lines,++$count,1,0,'C');
		$pdf->Cell(17,$height * $lines,$row[1],1,0,'C');
		$pdf->Cell(50,$height * $lines,substr($row[2],0,30),1,0,'L');
		$pdf->Cell(30,$height * $lines,$row[5],1,0,'C');
		$index=0;
		if($lines>1) $counter+= ($lines-1);
		for(; $lines>1; ){
			$lines--;
			$pdf->Cell(160,$height,substr($row[6],$index,140),"LR",2,'L');
			$index += 140;
		}
		$pdf->Cell(160,$height,substr($row[6],$index,140),"LBR",0,'L');
		if($lines>1) $counter+= ($lines);
		$pdf->Ln($height);
		$counter++;

		//if($pdf->GetY() >= 260){
		if($pdf->GetY() >= 183.00125){
			$counter=0;
			$pdf->AddPage();
			$pdf->Cell(10,4,"S/NO",1,0,'C');
			$pdf->Cell(17,4,"MATRIC NO",1,0,'C');
			$pdf->Cell(50,4,"FULL NAME",1,0,'L');
			$pdf->Cell(30,4,"REMARKS",1,0,'C');
			$pdf->Cell(160,4,"OUTSTANDING COURSES",1,0,'L');
			$pdf->Ln(4);
		}
	}


	$query = "insert into remarkstable SELECT * FROM ".$tmp_remarkstable." B ON DUPLICATE KEY UPDATE matricno=B.matricno, remark=B.remark, sessions=B.sessions, semester=B.semester, facultycode=B.facultycode, departmentcode=B.departmentcode, programmecode=B.programmecode, studentlevel=B.studentlevel, RR=B.RR, remarkprob=B.remarkprob, remarkdnr=B.remarkdnr, prevtcp=B.prevtcp, prevtnu=B.prevtnu, prevgpa=B.prevgpa, prevtnup=B.prevtnup, currtcp=B.currtcp, currtnu=B.currtnu, currgpa=B.currgpa, currtnup=B.currtnup ";
	mysql_query($query, $connection);

	//where B.sessions='{$sessionss}' and B.semester='{$semesters}' 
	$query = "insert into summaryreport SELECT * FROM ".$tmp_summaryreport." B ON DUPLICATE KEY UPDATE matricno=B.matricno, fullname=B.fullname, gender=B.gender, cgpa=B.cgpa, ctnup=B.ctnup, remark=B.remark, reporttype=B.reporttype, sessions=B.sessions, semester=B.semester, facultycode=B.facultycode, departmentcode=B.departmentcode, programmecode=B.programmecode, studentlevel=B.studentlevel ";
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

	$query = "DROP TABLE IF EXISTS ".$tmp_summaryreport;
	mysql_query($query, $connection);

	$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_summaryreport%'  ";
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
