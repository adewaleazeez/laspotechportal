<?php
//error_reporting(E_ALL); 
//error_reporting(E_ALL & ~E_NOTICE | E_STRICT); // Warns on good coding standards
//ini_set("display_errors", "1");
	global $exam_reportablename;
	global $final_reportablename;
	global $firstregnumber;
	global $lastregnumber;

	$option = str_replace("'", "`", trim($_GET['option'])); 
	$serialnos = str_replace("'", "`", trim($_GET['serialno']));
	$currentusers = str_replace("'", "`", trim($_GET['currentuser']));
	if($currentusers==null || $currentusers=="") $currentusers = $_COOKIE['currentuser'];
	$menuoption = str_replace("'", "`", trim($_GET['menuoption']));
	$access = str_replace("'", "`", trim($_GET['access']));
	$aparam = str_replace("'", "`", trim($_GET['aparam']));
	$param = str_replace("'", "`", trim($_GET['param']));
	$param2 = str_replace("'", "`", trim($_GET['param2']));
	$sortorder = str_replace("'", "`", trim($_GET['sortorder']));
	$table = str_replace("'", "`", trim($_GET['table']));
	$facultycodes = str_replace("'", "`", trim($_GET['facultycode']));
	if($facultycodes==null) $facultycodes="";
	$departmentcodes = str_replace("'", "`", trim($_GET['departmentcode']));
	if($departmentcodes==null) $departmentcodes="";
	$programmecodes = str_replace("'", "`", trim($_GET['programmecode']));
	if($programmecodes==null) $programmecodes="";
	$studentlevels = str_replace("'", "`", trim($_GET['studentlevel']));
	if($studentlevels==null) $studentlevels="";
	$sesionss = str_replace("'", "`", trim($_GET['sesions']));
	if($sesionss==null) $sesionss="";
	$semesters = str_replace("'", "`", trim($_GET['semester']));
	if($semesters==null) $semesters="";
	$entryyears = str_replace("'", "`", trim($_GET['entryyear']));
	if($entryyears==null) $entryyears="";
	$regNumbers = str_replace("'", "`", trim($_GET['regNumber']));
	if($regNumbers==null) $regNumbers="";
	$matricno = str_replace("'", "`", trim($_GET['matricno']));
	if($matricno==null) $matricno="";
	$actives = str_replace("'", "`", trim($_GET['active']));
	if($actives==null) $actives="Yes";
	$coursecodes = str_replace("'", "`", trim($_GET['coursecode']));
	if($coursecodes==null) $coursecodes="";
	$markdescriptions = str_replace("'", "`", trim($_GET['markdescription']));
	if($amendedtitles==null) $amendedtitles="";
	$amendedtitles = str_replace("'", "`", trim($_GET['amendedtitle']));
	if($markdescriptions==null) $markdescriptions="";
	$codeid = str_replace("'", "`", trim($_GET['codeid']));
	if($codeid==null) $codeid="";
	$codevalue = str_replace("'", "`", trim($_GET['codevalue']));
	if($codevalue==null) $codevalue="";
	$currentobject = str_replace("'", "`", trim($_GET['currentobject']));
	$phones = str_replace("'", "`", trim($_GET['phone']));
	$sms = str_replace("'", "`", trim($_GET['sms']));
	$senderids = str_replace("'", "`", trim($_GET['senderid']));
	$msgcount = str_replace("'", "`", trim($_GET['msgcount']));
	$passwords = str_replace("'", "`", trim($_GET['password']));
	include("data.php");


	function updateFinalMarks($sesionss, $semesters, $course, $regno, $level, $programme, $cstatus, $faculty, $department, $ca, $exam){
		$exam_reportablename = $GLOBALS['exam_reportablename'];
		$final_reportablename = $GLOBALS['final_reportablename'];
		$firstregnumber = $GLOBALS['firstregnumber'];
		$lastregnumber = $GLOBALS['lastregnumber'];
		include("data.php"); 
		$query = "SELECT qualificationcode FROM regularstudents where regNumber='{$regno}'";
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
		}

		$query = "SELECT courseunit, minimumscore FROM coursestable where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and coursecode='{$course}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and studentlevel ='{$level}' ";
		$result = mysql_query($query, $connection);
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
		}

		$query = "SELECT * FROM ".$exam_reportablename." where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and studentlevel ='{$level}' order by sessiondescription, semester, coursecode, registrationnumber";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$obtained = 0.0;
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				if($marksobtained!=null) $obtained += (doubleval($marksobtained) * doubleval($percentage))/doubleval($marksobtainable);
			}
			//$obtained = number_format($obtained,2);

			if($obtained>100){
				echo "invalidmark".$obtained."_For ".$regno; 
				return true;
			}

			$query = "select * from gradestable where {$obtained}>=lowerrange and {$obtained}<=upperrange and sessions='{$sesionss}' and qualification='{$qualificationcode}' order by lowerrange DESC ";
			$result = mysql_query($query, $connection);
			$gcode="";
			$gunit="";
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$gcode=$row[1];
					$gunit=$row[4];
				}
			}else{
				echo "gradenotsetup".$sesionss."_Session "; 
				return true;
			}
			if($gunit=="") $gunit="0";
			$gradepoints=$gunit * $courseunit;
			$query = "SELECT * FROM finalresultstable where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
			if($cstatus=="Sick") $gcode="S";
			if($cstatus=="Did Not Register") $gcode="DNR";
			if($cstatus=="Incomplete") $gcode="I";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				if($cstatus=="Sick" || $cstatus=="Did Not Register" || $cstatus=="Incomplete"){ 
					$query = "update finalresultstable set gradecode='{$gcode}', gradeunit=null, coursestatus='{$cstatus}', gradepoint=null, cascore=null, examscore=null, markobtained=null, currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
					mysql_query($query, $connection);
				}else{
					$query = "update finalresultstable set gradecode='{$gcode}', gradeunit='{$gunit}', coursestatus='{$cstatus}', gradepoint='{$gradepoints}', currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
					mysql_query($query, $connection);
					if($obtained>0){
						$query = "update finalresultstable set marksobtained='{$obtained}', gradecode='{$gcode}', gradeunit='{$gunit}', coursestatus='{$cstatus}', gradepoint='{$gradepoints}', currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
						mysql_query($query, $connection);
					}
					if($ca>0){
						$query = "update finalresultstable set gradecode='{$gcode}', gradeunit='{$gunit}', coursestatus='{$cstatus}', gradepoint='{$gradepoints}', cascore='{$ca}', currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
						mysql_query($query, $connection);
					}
					if($exam>0){
						$query = "update finalresultstable set gradecode='{$gcode}', gradeunit='{$gunit}', coursestatus='{$cstatus}', gradepoint='{$gradepoints}',examscore='{$exam}', currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
						mysql_query($query, $connection);
					}
				}

				$usernames = $_COOKIE['currentuser'];
				$activitydescriptions = $usernames." updated mark for ".$regno.", Course Code: ".$course.", Department: ".$department.", Session: ".$sesionss.", Semester: ".$semesters;
				$activitydates = date("Y-m-d");
				$activitytimes = date("H:i:s");
				$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
				mysql_query($query, $connection);
					
			}else{
				$query = "SELECT * FROM ".$final_reportablename." where (sessiondescription<>'{$sesionss}' || semester<>'{$semesters}' || studentlevel<>'{$level}') and  coursecode ='{$coursecode}' and registrationnumber ='{$regno}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and marksobtained>='{$minimumscore}'";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 0){
					if($cstatus=="Sick" || $cstatus=="Did Not Register" || $cstatus=="Incomplete"){ 
						$query = "insert into finalresultstable (sessiondescription, semester, coursecode, registrationnumber, gradecode, gradeunit, studentlevel, programmecode, coursestatus, facultycode, departmentcode, gradepoint, currentuser) values ('{$sesionss}', '{$semesters}', '{$course}', '{$regno}', '{$gcode}', null, '{$level}', '{$programme}', '{$cstatus}', '{$faculty}', '{$department}', null,'{$currentusers}')";
						mysql_query($query, $connection);
					}else{
						$query = "insert into finalresultstable (sessiondescription, semester, coursecode, registrationnumber, gradecode, gradeunit, studentlevel, programmecode, coursestatus, facultycode, departmentcode, gradepoint, currentuser) values ('{$sesionss}', '{$semesters}', '{$course}', '{$regno}', '{$gcode}', '{$gunit}', '{$level}', '{$programme}', '{$cstatus}', '{$faculty}', '{$department}', '{$gradepoints}','{$currentusers}')";
						mysql_query($query, $connection);
						if($obtained>0){
							$query = "update finalresultstable set marksobtained='{$obtained}', currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
							mysql_query($query, $connection);
						}
						if($ca>0){
							$query = "update finalresultstable set cascore='{$ca}', currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
							mysql_query($query, $connection);
						}
						if($exam>0){
							$query = "update finalresultstable set examscore='{$exam}', currentuser='{$currentusers}' where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' ";
							mysql_query($query, $connection);
						}

						$usernames = $_COOKIE['currentuser'];
						$activitydescriptions = $usernames." inserted mark for ".$regno.", Course Code: ".$course.", Department: ".$department.", Session: ".$sesionss.", Semester: ".$semesters;
						$activitydates = date("Y-m-d");
						$activitytimes = date("H:i:s");
						$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
						mysql_query($query, $connection);

					}
				}else{
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
					}
					$query = "DELETE FROM examresultstable where sessiondescription='{$sesionss}' and semester='{$semesters}' and coursecode='{$course}' and registrationnumber='{$regno}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and studentlevel ='{$level}' ";
					mysql_query($query, $connection);

					echo $regno." already passed ".$coursecode." in ".$sessiondescription.", ".$semester." Semester";
				}
			}
		}
		return true;
	}

	function checkCode($table,$codeid,$codevalue){
		include("data.php"); 
		$query = "SELECT * FROM {$table} where BINARY {$codeid} ='{$codevalue}'";
		$result = mysql_query($query, $connection);
		$resp="";
		if(mysql_num_rows($result)==0) $resp .= "notinsetup";
		return $resp;
	}

	if($_POST['submitButton']!=null){
		if(($_FILES["file"]["type"] == "image/gif") 
		|| ($_FILES["file"]["type"] == "image/jpeg") 
		|| ($_FILES["file"]["type"] == "image/pjpeg") 
		|| ($_FILES["file"]["type"] == "image/bmp")){
			if($_FILES["file"]["error"] > 0){
				setcookie("uploadresponse", "errorcode" . $_FILES["file"]["error"], false);
				//echo "errorcode" . $_FILES["file"]["error"] . "<br />";
			}else{
				if($_FILES["file"]["size"] / 1024 < 20000){
					if(file_exists("upload/" . $_FILES["file"]["name"])){
						setcookie("uploadresponse", "uploadexists" . $_FILES["file"]["name"], false);
						//echo "uploadexists" . $_FILES["file"]["name"];
					}else{
						move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
						$resp = "uploadsuccessful";
						$resp .= "Upload: " . $_FILES["file"]["name"] . "<br />";
						$resp .= "Type: " . $_FILES["file"]["type"] . "<br />";
						$resp .= "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
						$resp .= "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
						setcookie("uploadresponse", $resp, false);
					}
				}else{
					setcookie("uploadresponse", "uploadtoolarge" . $_FILES["file"]["size"] / 1024 . " Kb", false);
					//echo "uploadtoolarge" . $_FILES["file"]["size"] / 1024 . " Kb";
				}
			}
		}else{
			setcookie("uploadresponse", "Invalidfile", false);
			//echo "Invalidfile";
		}
		define("dataentry", "dataentry.php");
		echo '<meta http-equiv="Refresh" content="0; url=' . dataentry . '" />';
	}

	/*if($option == "checkCode"){
		$query = "SELECT * FROM {$table} where {$codeid} ='{$codevalue}'";
		$result = mysql_query($query, $connection);
		$resp=$option;
		if(mysql_num_rows($result)==0) $resp .= "codenotfound".$access."codenotfound".$codevalue;
		echo $resp;
	}*/

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

	if($option == "sendSms"){
		$gatewayURL = "www.immaculatedevelopers.com/bulksms/userbackend.php?option=sendSms&phone=".$recipients."&senderid=".$senderid;
		$gatewayURL .= "&sms=".$smsmessage."&currentuser=".$currentuser."&msgcount=".$msgcount."&password=".$password."&serialno=".$serialno;
		
		//Open the URL to send the message ";

		$url =  $gatewayURL;  

		$response = @fopen($url, 'r');
		if (!$response) {
			echo "sendsmsfailed - SMS failed: can not connect server";
		}else{
			echo $response;
		}
	}

	if($option == "allocatePins"){
		$array = array(); //define the array
		$msg="pinallocationfailed";
		$query = "select uniquereferencenumber from uniquereferencenumbers where  sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and useflag='open' order by serialno";
		$result = mysql_query($query, $connection);
		$i=0;
		if(mysql_num_rows($result)> 0){
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$array[$i++] = $row[0];
			}
		}
		$matricno=substr($matricno, 0, strlen($matricno)-2);
		$matricno = explode("][", $matricno);
		for($count=0; $count<count($matricno); $count++)	$matricno[$count]=trim($matricno[$count]);
		$regno="";
		foreach($matricno as $code){
			$randomindex = GenerateRandomNumber(0, count($array));
			$urn = $array[$randomindex];
			$query = "select * from pintable where regNumber='{$code}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "select * from uniquereferencenumbers where uniquereferencenumber='{$urn}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and useflag='open' ";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 1){
					$query = "update uniquereferencenumbers set useflag='{$code}' where uniquereferencenumber='{$urn}' and sessiondescription='{$sesionss}' and  semesterdescription='{$semesters}' ";
					mysql_query($query, $connection);
					$pincreaters=$_COOKIE["currentuser"];
					$pinamounts=0;
					$pindate=Date('YmdHis');
					$query = "insert into pintable (regNumber, sessiondescription, semesterdescription, pinnumber, pincreater, pinamount, pindate) values ('{$code}', '{$sesionss}', '{$semesters}', '{$urn}', '{$pincreaters}', {$pinamounts}, '{$pindate}') ";
					mysql_query($query, $connection);
					$regno.=$code.", ";
					$msg="pinallocationsuccess";
				}
			}else{
				continue;
			}
		}

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." allocated pin numbers to ".$regno;
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		echo $msg;
	}

	function GenerateRandomNumber($minNum, $maxNum){
	   return round(rand($minNum, $maxNum));
	}

	if($option == "generatePins"){
		$array = array(); //define the array

		$param = explode("][", $param);
		for($count=0; $count<count($param); $count++)	$param[$count]=trim($param[$count]);
		$sesionss=$param[0];
		$semesters=$param[1];

		//set random # range
		$minNum = 0;
		$maxNum = 0;
		$maxSno = 0;
		$maxPerBatch = 10000;

		$query = "select count(serialno) as maxserialno from uniquereferencenumbers where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) == 0){
			$minNum = 1111567890;
			$maxNum = 1112567890;
		}else{
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$maxSno=$row[0];
			}
			$modulusMaxNo = $maxSno % 10000;
			if($modulusMaxNo==0){
				$query = "select count(serialno) as maxserialno from uniquereferencenumbers where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and useflag='open' ";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					echo "pinsavailable";
					return true;
				}
			}
			$maxPerBatch = 10000 - $modulusMaxNo;
			$minNum = 1111567890 + (intval(($maxSno * 100) / 1000000) * 1000000);
			$maxNum = $minNum + 1000000;
		}
		$query = "select uniquereferencenumber from uniquereferencenumbers where  sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and uniquereferencenumber between $minNum and  $maxNum order by serialno";
		$result = mysql_query($query, $connection);
		$i=0;
		if(mysql_num_rows($result)> 0){
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$array[$i++] = $row[0];
			}
		}

		for($i = 1; $i <= $maxPerBatch; $i++){
			$num1 = GenerateRandomNumber($minNum, $maxNum);   
			while(in_array($num1, $array)){
				$num1 = GenerateRandomNumber($minNum, $maxNum);
			}   
			$query = "SELECT uniquereferencenumber FROM uniquereferencenumbers where uniquereferencenumber = '{$num1}' and  sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "INSERT INTO uniquereferencenumbers (uniquereferencenumber, sessiondescription, semesterdescription) VALUES ('{$num1}', '{$sesionss}', '{$semesters}')";
				mysql_query($query, $connection);
			}else{
				--$i;
				continue;
			}
			$array[$i] = $num1;
		}

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." generated pin numbers ";
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		echo "pingeneratesuccess";
	}

	if(substr($option,0,11) == "readCookies"){
		$currentusers = $_COOKIE['currentuser'];
		$query = "SELECT currentrecordprocessing FROM currentrecord where currentuser ='{$currentusers}' ";
		$result = mysql_query($query, $connection);
		$currentrecordprocessings="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$currentrecordprocessings=$currentrecordprocessing;
			}
		}
		echo $option.$currentrecordprocessings;
	}

	if($option== "clearCurrentRecord"){
		$query = "update currentrecord set currentrecordprocessing='', report='' where currentuser ='{$currentusers}' ";
		mysql_query($query, $connection);
	}

	if($option == "onlineUpload"){
		$param = explode("][", $param);
		for($count=0; $count<count($param); $count++)	$param[$count]=trim($param[$count]);
		$sesionss=$param[0];
		$semesters=$param[1];
		$tables = "finalresultstable][coursestable][registration][retakecourses][regularstudents][";
		$tables .= "cgpatable][schoolinformation][gradestable][qualificationstable][sessionstable";
		$tables = explode("][", $tables);
		for($count=0; $count<count($tables); $count++)	$tables[$count]=trim($tables[$count]);
		for($j=0; $j<count($tables); $j++){
			$table=$tables[$j];
			$query = "SELECT * FROM {$table} ";
			if($table=="finalresultstable")	
				$query .= " where sessiondescription='{$sesionss}' and semester='{$semesters}'";
			if($table=="coursestable")	
				$query .= " where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}'";
			if($table=="registration")	
				$query .= " where sessions='{$sesionss}' and semester='{$semesters}'";
			if($table=="retakecourses")	
				$query .= " where sessiondescription='{$sesionss}' and semester='{$semesters}'";
			if($table=="gradestable")	
				$query .= " where sessions='{$sesionss}'";
			if($table=="cgpatable")	
				$query .= " where sessions='{$sesionss}'";
			if($table=="sessionstable")	
				$query .= " where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$record="";
					$count=0;
					foreach($row as $i => $value){
						$meta = mysql_fetch_field($result, $i);
						if($value!=null && ($count++ % 2)==0)
							$record .= $meta->name . "='".$value."', ";
					}
					$record = substr($record, 0, strlen($record)-2);
					include("dataonline.php");
					$queryOnline = "SELECT * FROM {$table} where serialno={$row[0]}";
					$resultOnline = mysql_query($queryOnline, $connectionOnline);
					if(mysql_num_rows($resultOnline)==0){
						if($table=="finalresultstable" || $table=="examresultstable"){
							$queryOnline = "INSERT INTO {$table} (serialno, currentuser) VALUES ({$row[0]},'{$currentusers}')";
						}else{
							$queryOnline = "INSERT INTO {$table} (serialno) VALUES ({$row[0]})";
						}
						//mysql_query($queryOnline, $connectionOnline);
					}else{
						if($table=="finalresultstable" || $table=="examresultstable"){
							$queryOnline = "UPDATE {$table} set ".$record.", currentuser='{$currentusers}' where serialno ={$row[0]}";
						}else{
							$queryOnline = "UPDATE {$table} set ".$record." where serialno ={$row[0]}";
						}
					}
					mysql_query($queryOnline, $connectionOnline);
					include("data.php");
				}
			}
		}
		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." uploaded data online ";
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		echo "onlineuploadsuccess";
	}


	if($option == "updateStudentHistory"){
		$parameter = explode("][", $param);
		for($count=0; $count<count($parameter); $count++)	$parameter[$count]=trim($parameter[$count]);
		$currentuser=$parameter[0];
		$historydate=$parameter[1];
		$historymsg=$parameter[2];
		$regnumber=$parameter[3];
		$processoption=$parameter[4];

		$new_student_history = "_~_".$currentuser."~!!~".$historydate."~!!~".$historymsg;
		
		$query = "SELECT studenthistory FROM regularstudents where regNumber='{$regnumber}'";
		$result = mysql_query($query, $connection);
		$student_history="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$student_history=$studenthistory;
			}
		}
		if($processoption=="SAVE"){
			$student_history .= $new_student_history;
		}else if($processoption=="UPDATE"){
			$rows = explode("_~_", $student_history);
			for($count=0; $count<count($rows); $count++)	$rows[$count]=trim($rows[$count]);
			$student_history="";
			for($j=1; $j<count($rows); $j++){
				$col = explode("~!!~", $rows[$j]);
				for($count=0; $count<count($col); $count++)	$col[$count]=trim($col[$count]);
				if($col[0]==$currentuser && $col[1]==$historydate){
					$student_history .= $new_student_history;
				}else{
					$student_history .= ("_~_".$col[0]."~!!~".$col[1]."~!!~".$col[2]);
				}
			}
		}else if($processoption=="DELETE"){
			$rows = explode("_~_", $student_history);
			for($count=0; $count<count($rows); $count++)	$rows[$count]=trim($rows[$count]);
			$student_history="";
			for($j=1; $j<count($rows); $j++){
				$col = explode("~!!~", $rows[$j]);
				for($count=0; $count<count($col); $count++)	$col[$count]=trim($col[$count]);
				if(!($col[0]==$currentuser && $col[1]==$historydate)){
					$student_history .= ("_~_".$col[0]."~!!~".$col[1]."~!!~".$col[2]);
				}
			}
		}
		$query = "update regularstudents set studenthistory='{$student_history}' where regNumber='{$regnumber}'";
		mysql_query($query, $connection);

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." updated student history for ".$regnumber;
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$query = "SELECT studenthistory FROM regularstudents where regNumber='{$regnumber}'";
		$result = mysql_query($query, $connection);
		$student_history="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$student_history=$studenthistory;
			}
		}
		echo $option."~_~".$student_history."~_~".$regnumber;
	}

	if($option == "updateMatricNo"){
		$param = explode("][", $param);
		for($count=0; $count<count($param); $count++)	$param[$count]=trim($param[$count]);
		$oldregnumber=$param[0];
		$newregnumber=$param[1];
		$query = "SELECT regNumber FROM regularstudents where regNumber='{$newregnumber}'";
		$result = mysql_query($query, $connection);
		if($newregnumber==null || $newregnumber==""){
			echo "regblank";
		}else if(mysql_num_rows($result) == 0){
			$query = "update regularstudents set regNumber='{$newregnumber}' where regNumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update amendedresults set registrationnumber='{$newregnumber}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update coursesform set registrationnumber='{$newregnumber}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update examresultstable set registrationnumber='{$newregnumber}', currentuser='{$currentusers}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update finalresultstable set registrationnumber='{$newregnumber}', currentuser='{$currentusers}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update paymentstable set registrationnumber='{$newregnumber}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update post_ume set regNumber='{$newregnumber}' where regNumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update registration set regNumber='{$newregnumber}' where regNumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update retakecourses set registrationnumber='{$newregnumber}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update specialfeatures set registrationnumber='{$newregnumber}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$usernames = $_COOKIE['currentuser'];
			$activitydescriptions = $usernames." globally updated matric number from ".$oldregnumber." to ".$newregnumber;
			$activitydates = date("Y-m-d");
			$activitytimes = date("H:i:s");
			$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
			mysql_query($query, $connection);

			echo "regupdated";
		}else{
			echo "regexists";
		}
	}

	if($option == "updateGeneral"){
		$queryG="";
		if(str_in_str($menuoption,"Selected")){

			$param=substr($param, 0, strlen($param)-2);
			$parameter = explode("][", $param);
			for($count=0; $count<count($parameter); $count++)	$parameter[$count]=trim($parameter[$count]);
			$regnolist="";
			foreach($parameter as $code) $regnolist.="'".$code."', ";
			$regnolist=substr($regnolist, 0, strlen($regnolist)-2);
			$queryG="select * from regularstudents WHERE regNumber IN (".$regnolist.") ";
		}else{
			$queryG = "SELECT a.*, b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber and b.sessions='{$sesionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' order by a.regNumber";//and a.entryyear='{entryyears}'
		}
		$query="";
		if(str_in_str($codeid,"sesion")){
			$para = explode("!!!", $codeid);
			for($count=0; $count<count($para); $count++)	$para[$count]=trim($para[$count]);
			$thesesion = explode("][", $para[0]);
			for($count=0; $count<count($thesesion); $count++)	$thesesion[$count]=trim($thesesion[$count]);
			$thesemester = explode("][", $para[1]);
			for($count=0; $count<count($thesemester); $count++)	$thesemester[$count]=trim($thesemester[$count]);
			$thelevel = explode("][", $para[2]);
			for($count=0; $count<count($thelevel); $count++)	$thelevel[$count]=trim($thelevel[$count]);
			$resultG = mysql_query($queryG, $connection);
			if(mysql_num_rows($resultG) > 0){
				/*$priodexistflag=false;
				while ($rowG = mysql_fetch_array($resultG)) {
					extract ($rowG);
					$regNumberG=$regNumber;
					$query = "SELECT * FROM registration where regNumber ='{$regNumberG}' and ((studentlevel ='{$thelevel[1]}' and sessions!='{$thesesion[1]}') or (studentlevel !='{$thelevel[1]}' and sessions='{$thesesion[1]}')) ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						extract (mysql_fetch_array($result));
						$option.="periodused".$regNumberG." - ".$firstName." ".$lastName." ".$sesionss." ".$studentlevel;
						$priodexistflag=true;
					}
				}*/

				$regnolist="";
				while ($rowG = mysql_fetch_array($resultG)) {
					//if($priodexistflag) break;
					extract ($rowG);
					$regNumberG=$regNumber;
					$regnolist.=$regNumberG.", ";
					if(str_in_str($menuoption,"Update")){
						$query = "SELECT * FROM registration where regNumber ='{$regNumberG}' and studentlevel ='{$thelevel[1]}' and sessions='{$thesesion[1]}' and semester='{$thesemester[1]}'";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result) == 0){
							$query = "INSERT INTO registration (regNumber, studentlevel, sessions, semester, registered) VALUES ('{$regNumberG}', '{$thelevel[1]}', '{$thesesion[1]}', '{$thesemester[1]}', 'Yes')";
							mysql_query($query, $connection);
						}else{
							$query="delete from registration where regNumber ='{$regNumberG}' and studentlevel ='{$thelevel[1]}' and sessions='{$thesesion[1]}' and semester='{$thesemester[1]}'";
							mysql_query($query, $connection);

							$query = "INSERT INTO registration (regNumber, studentlevel, sessions, semester, registered) VALUES ('{$regNumberG}', '{$thelevel[1]}', '{$thesesion[1]}', '{$thesemester[1]}', 'Yes')";
							mysql_query($query, $connection);

							//$query="update registration set sessions='{$thesesion[1]}', semester='{$thesemester[1]}', studentlevel='{$thelevel[1]}' ";
							//$query.=" where regNumber='{$regNumberG}' ";
							//mysql_query($query, $connection);
						}
						$query="update regularstudents set studentlevel='{$thelevel[1]}' ";
						$query.=" where regNumber='{$regNumberG}' ";
						$option.="studentsupdated".$regNumberG." - ".$firstName." ".$lastName;
						mysql_query($query, $connection);
					}
					if(str_in_str($menuoption,"Delete")){
						$query="select * from ".$final_reportablename." where registrationnumber ='{$regNumberG}' and  sessiondescription='{$thesesion[1]}' and semester='{$thesemester[1]}' and studentlevel ='{$thelevel[1]}' ";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result) == 0){

							$query="delete from registration where sessions='{$thesesion[1]}' and  semester='{$thesemester[1]}' and studentlevel ='{$thelevel[1]}' ";
							$query.=" and regNumber='{$regNumberG}' ";
							mysql_query($query, $connection);

							$query = "select max(studentlevel) as studentlevel from registration where regNumber='{$regNumbers}'";
							$result = mysql_query($query, $connection);
							if(mysql_num_rows($result) > 0){
								while ($row = mysql_fetch_row($result)) {
									extract ($row);
								}
							}else{
								$studentlevel="";
							}
							$query="update regularstudents set studentlevel='{$studentlevel}' ";
							$query.=" where regNumber='{$regNumberG}' ";
							mysql_query($query, $connection);
							$option.="studentsdeleted".$regNumberG." - ".$firstName." ".$lastName;
						}else{
							$option.="periodexists".$regNumberG." - ".$firstName." ".$lastName;
						}
					}
				}
			}
		}else{
			$resultG = mysql_query($queryG, $connection);
			if(mysql_num_rows($resultG) > 0){
				$regnolist="";
				while ($rowG = mysql_fetch_array($resultG)) {
					extract ($rowG);
					$regNumberG=$regNumber;
					$regnolist.=$regNumberG.", ";
					$query="update regularstudents ";

					if(str_in_str($menuoption,"Activate") && $menuoption!="Deactivate"){
						$query.=" set active='Yes' ";
						$option.="studentsactivated".$regNumberG." - ".$firstName." ".$lastName;
					}
					if(str_in_str($menuoption,"Deactivate") && $menuoption!="Activate"){
						$query.=" set active='No' ";
						$option.="studentsdeactivated".$regNumberG." - ".$firstName." ".$lastName;
					}

					if(str_in_str($menuoption,"Lock") && $menuoption!="Unlock"){
						$query.=" set lockrec='Yes' ";
						$option.="studentslocked".$regNumberG." - ".$firstName." ".$lastName;
					}
					if(str_in_str($menuoption,"Unlock") && $menuoption!="Lock"){
						$query.=" set lockrec='No' ";
						$option.="studentsunlocked".$regNumberG." - ".$firstName." ".$lastName;
					}
					$query.=" where regNumber='{$regNumberG}' ";
					
					if(str_in_str($menuoption,"Register") && $menuoption!="Deregister"){
						$query="update registration ";
						$query.=" set registered='Yes' ";
						$query.=" where regNumber='{$regNumberG}' and sessions='{$sesionss}' and semester='{$semesters}' and studentlevel ='{$studentlevels}' ";
						$option.="studentsregistered".$regNumberG." - ".$firstName." ".$lastName;
					}
					if(str_in_str($menuoption,"Deregister") && $menuoption!="Register"){
						$query="select * from ".$final_reportablename." where registrationnumber ='{$regNumberG}' and  sessiondescription='{$sesionss}' and semester='{$semesters}' and studentlevel ='{$studentlevels}' ";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result) == 0){
							$query="update registration ";
							$query.=" set registered='No' ";
							$query.=" where regNumber='{$regNumberG}' and sessions='{$sesionss}' and semester='{$semesters}' and studentlevel='{$studentlevels}' ";
							$option.="studentsderegistered".$regNumberG." - ".$firstName." ".$lastName."<br><br>";
						}else{
							$option.="examexists".$regNumberG." - ".$firstName." ".$lastName;
						}
					}
					mysql_query($query, $connection);
				}
			}
		}
		
		$regnolist=substr($regnolist, 0, strlen($regnolist)-2);
		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." general update [".$menuoption."] for students: ".$regnolist;
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		echo $option;
	}

	if($option == "checkAccess"){
		setcookie("sortorder", "ASC", false);
		$query = "SELECT * FROM usersmenu where userName = '{$currentusers}' and menuOption = '{$menuoption}'";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);

			if($accessible == "Yes"){
				$resp = $menuoption."checkAccessSuccess".$access."checkAccessSuccess".$param;
			}else{
				$resp="checkAccessFailed".$menuoption;
			}
		}else{
			$resp="checkAccessFailed".$menuoption;
		}
		echo $resp;
	}

	if($option == "uploadExcel"){
		$query = "select * FROM coursestable where serialno<>0 ";
		if($facultycodes != "")
			$query .= " and facultycode='{$facultycodes}' "; 
		if($departmentcodes != "")
			$query .= " and departmentcode='{$departmentcodes}' "; 
		if($programmecodes != "")
			$query .= " and programmecode='{$programmecodes}' ";
		if($studentlevels != "")
			$query .= " and studentlevel='{$studentlevels}' "; 
		if($sesionss != "")
			$query .= " and sessiondescription='{$sesionss}' "; 
		if($semesters != "")
			$query .= " and semesterdescription='{$semesters}' "; 
		if($coursecodes != "")
			$query .= " and coursecode='{$coursecodes}' "; 
		$query .= " and recordlock='1' "; 
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			echo "uploadlocked for $coursecodes in $sesionss $semesters semester";
		}else{
			echo "uploadopen";
		}
		return true;
	}

	if($option == "deleteMarks"){
		$query = "select * FROM coursestable where serialno<>0 ";
		if($facultycodes != "")
			$query .= " and facultycode='{$facultycodes}' "; 
		if($departmentcodes != "")
			$query .= " and departmentcode='{$departmentcodes}' "; 
		if($programmecodes != "")
			$query .= " and programmecode='{$programmecodes}' ";
		if($studentlevels != "")
			$query .= " and studentlevel='{$studentlevels}' "; 
		if($sesionss != "")
			$query .= " and sessiondescription='{$sesionss}' "; 
		if($semesters != "")
			$query .= " and semesterdescription='{$semesters}' "; 
		if($coursecodes != "")
			$query .= " and coursecode='{$coursecodes}' "; 
			$query .= " and recordlock='1' "; 
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			echo "recordlocked for $coursecodes in $sesionss $semesters semester";
			return true;
		}

		$query = "delete FROM examresultstable where serialno<>0 ";
		if($facultycodes != "")
			$query .= " and facultycode='{$facultycodes}' "; 
		if($departmentcodes != "")
			$query .= " and departmentcode='{$departmentcodes}' "; 
		if($programmecodes != "")
			$query .= " and programmecode='{$programmecodes}' ";
		if($studentlevels != "")
			$query .= " and studentlevel='{$studentlevels}' "; 
		if($sesionss != "")
			$query .= " and sessiondescription='{$sesionss}' "; 
		if($semesters != "")
			$query .= " and semester='{$semesters}' "; 
		if($coursecodes != "")
			$query .= " and coursecode='{$coursecodes}' "; 
		if($markdescriptions != "")
			$query .= " and marksdescription='{$markdescriptions}' "; 
		if($regNumbers != "")
			$query .= " and registrationnumber='{$regNumbers}' "; 
		mysql_query($query, $connection);
		$query = "delete FROM finalresultstable where serialno<>0 ";
		if($facultycodes != "")
			$query .= " and facultycode='{$facultycodes}' "; 
		if($departmentcodes != "")
			$query .= " and departmentcode='{$departmentcodes}' "; 
		if($programmecodes != "")
			$query .= " and programmecode='{$programmecodes}' ";
		if($studentlevels != "")
			$query .= " and studentlevel='{$studentlevels}' "; 
		if($sesionss != "")
			$query .= " and sessiondescription='{$sesionss}' "; 
		if($semesters != "")
			$query .= " and semester='{$semesters}' "; 
		if($coursecodes != "")
			$query .= " and coursecode='{$coursecodes}' "; 
		if($regNumbers != "")
			$query .= " and registrationnumber='{$regNumbers}' "; 
		mysql_query($query, $connection);
		$query = "delete FROM retakecourses where serialno<>0 ";
		if($facultycodes != "")
			$query .= " and facultycode='{$facultycodes}' "; 
		if($departmentcodes != "")
			$query .= " and departmentcode='{$departmentcodes}' "; 
		if($programmecodes != "")
			$query .= " and programmecode='{$programmecodes}' ";
		if($studentlevels != "")
			$query .= " and studentlevel='{$studentlevels}' "; 
		if($sesionss != "")
			$query .= " and sessiondescription='{$sesionss}' "; 
		if($semesters != "")
			$query .= " and semester='{$semesters}' "; 
		if($coursecodes != "")
			$query .= " and coursecode='{$coursecodes}' "; 
		if($regNumbers != "")
			$query .= " and registrationnumber='{$regNumbers}' "; 
		mysql_query($query, $connection);
		
		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." delete marks for ".$regNumbers.", Course Code: ".$coursecodes.", Department: ".$departmentcodes.", Session: ".$sesionss.", Semester: ".$semesters;
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		echo $option;
	}

	if($option == "deleteStudents"){
		$parameter = explode("][", $param);

		$query="delete from amendedreasons where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessiondescription='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$query="delete from amendedresults where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessiondescription='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		//$query="delete from coursestable where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessiondescription='{$parameter[4]}' and semesterdescription='{$parameter[5]}' ";
		//mysql_query($query, $connection);

		$query="delete from examresultstable where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessiondescription='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$query="delete from finalresultstable where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessiondescription='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$query="delete from mastereportbackup where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessions='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$query="delete from remarkstable where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessions='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$query = "SELECT min(b.regNumber) as firstregnumber, max(b.regNumber) as lastregnumber, min(a.qualificationcode) as qualifications FROM regularstudents AS a JOIN registration AS b ON a.regNumber=b.regNumber and b.sessions='{$parameter[4]}'  and b.semester='{$parameter[5]}' and a.facultycode='{$parameter[0]}' and a.departmentcode='{$parameter[1]}' and a.programmecode='{$parameter[2]}' and b.studentlevel='{$parameter[3]}' and a.lockrec!='Yes' order by a.regNumber"; 
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

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

		$query = "insert into ".$tmp_registration." SELECT * FROM registration where (regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}')  and sessions='{$parameter[4]}'  and semester='{$parameter[5]}' group by regNumber, sessions, semester";
		mysql_query($query, $connection);

//$qry=str_replace("'", "`", $query)."   $firstregnumber   $lastregnumber    $qualifications";
//$query="update currentrecord set report='{$qry}'  where currentuser='Admin' ";
//mysql_query($query, $connection);

		$query="delete from registration where (regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}') and sessions='{$parameter[4]}'  and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$query = "insert into registration SELECT * FROM ".$tmp_registration." B ON DUPLICATE KEY UPDATE regNumber=B.regNumber, studentlevel=B.studentlevel, sessions=B.sessions, semester=B.semester, registered=B.registered ";
		mysql_query($query, $connection);

		$query = "DROP TABLE IF EXISTS ".$tmp_registration;
		mysql_query($query, $connection);

		//$query="delete from registration WHERE regNumber IN (".$regnolist.") and sessions=`{$parameter[4]}` and semester=`{$parameter[5]}` and studentlevel=`{$parameter[3]}` ";
		//$queryQ="update currentrecord set report='{$query}' ";
		//mysql_query($queryQ, $connection);
		//return true;
		
		$tmp_regularstudent="tmp_".date("Y_m_d_H_i_s")."_regularstudent";
		while (true){
			$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$tmp_regularstudent}'  ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$tmp_regularstudent="tmp_".date("Y_m_d_H_i_s")."_regularstudent";
			}else{
				break;
			}
		}

		$query = "create table ".$tmp_regularstudent." select * from regularstudents limit 0";
		mysql_query($query, $connection);

		$query = "alter table ".$tmp_regularstudent." MODIFY COLUMN `serialno` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT, add PRIMARY KEY (`serialno`)";
		mysql_query($query, $connection);

		$query = "insert into ".$tmp_regularstudent." SELECT * FROM regularstudents where regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}'  and facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' group by regNumber";
		mysql_query($query, $connection);

		$query="delete from regularstudents where regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}' and regNumber<='{$lastregnumber}' and facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' ";
		mysql_query($query, $connection);

		$query = "insert into regularstudents SELECT * FROM ".$tmp_regularstudent." B ON DUPLICATE KEY UPDATE regNumber=B.regNumber, firstName=B.firstName, lastName=B.lastName, middleName=B.middleName, gender=B.gender, dateOfBirth=B.dateOfBirth, userEmail=B.userEmail, title=B.title, phoneno=B.phoneno, minimumunit=B.minimumunit, maidenName=B.maidenName, nationality=B.nationality, originState=B.originState, maritalStatus=B.maritalStatus, userPicture=B.userPicture ";
		mysql_query($query, $connection);

		$query = "DROP TABLE IF EXISTS ".$tmp_regularstudent;
		mysql_query($query, $connection);


		$query="delete from retakecourses where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' ";
		mysql_query($query, $connection);

		$query="delete from specialfeatures where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessiondescription='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$query="delete from summaryreport where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessions='{$parameter[4]}' and semester='{$parameter[5]}' ";
		mysql_query($query, $connection);

		//$query="delete from unitstable where facultycode='{$parameter[0]}' and departmentcode='{$parameter[1]}' and programmecode='{$parameter[2]}' and studentlevel='{$parameter[3]}' and sessiondescription='{$parameter[4]}' and semesterdescription='{$parameter[5]}' ";
		//mysql_query($query, $connection);

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." delete all students and marks for: Department: ".$parameter[1].", Programme: ".$parameter[2].", Level: ".$parameter[3].", Session: ".$parameter[4].", Semester: ".$parameter[5];
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$option="getAllRecs"; $table="regularstudents";
		$facultycodes=$parameter[2];
		$departmentcodes=$parameter[3];
		$programmecodes=$parameter[4];
		$studentlevels=$parameter[5];
		$sesionss=$parameter[6];
		$semesters=$parameter[7];
	}

	if($option == "getAllRecs"  || $option=="getRecordlist"  || $option=="getARecord"){
		$query = "SELECT min(b.regNumber) as firstregnumber, max(b.regNumber) as lastregnumber FROM regularstudents AS a JOIN registration AS b ON a.regNumber=b.regNumber and b.sessions='{$sesionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and a.lockrec!='Yes' order by a.regNumber"; 
		$result = mysql_query($query, $connection);
		extract (mysql_fetch_array($result));

		$exam_reportablename="tmp_".date("Y_m_d_H_i_s")."_examresultstable";
		while (true){
			$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$exam_reportablename}'  ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$exam_reportablename="tmp_".date("Y_m_d_H_i_s")."_examresultstable";
			}else{
				break;
			}
		}

		$final_reportablename="tmp_".date("Y_m_d_H_i_s")."_finalresultstable";
		while (true){
			$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name ='{$final_reportablename}'  ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$final_reportablename="tmp_".date("Y_m_d_H_i_s")."_finalresultstable";
			}else{
				break;
			}
		}

		$query = "CREATE TABLE ".$exam_reportablename." (
		  `serialno` int(10) unsigned NOT NULL auto_increment,
		  `sessiondescription` varchar(50) default NULL,
		  `semester` varchar(50) default NULL,
		  `coursecode` varchar(10) default NULL,
		  `registrationnumber` varchar(30) default NULL,
		  `marksdescription` varchar(100) default NULL,
		  `marksobtained` double default NULL,
		  `marksobtainable` double default NULL,
		  `percentage` double default NULL,
		  `studentlevel` varchar(50) default NULL,
		  `programmecode` varchar(100) default NULL,
		  `facultycode` varchar(100) default NULL,
		  `departmentcode` varchar(100) default NULL,
		  `groupsession` varchar(10) default NULL,
		  `currentuser` varchar(45) default NULL,
		  PRIMARY KEY  (`serialno`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		mysql_query($query, $connection);

		$query = "insert into ".$exam_reportablename." SELECT * FROM examresultstable where registrationnumber>='{$firstregnumber}' and registrationnumber<='{$lastregnumber}' ";
		mysql_query($query, $connection);

		$query = "CREATE TABLE ".$final_reportablename." (
		  `serialno` int(10) unsigned NOT NULL auto_increment,
		  `sessiondescription` varchar(10) default NULL,
		  `semester` varchar(50) default NULL,
		  `coursecode` varchar(10) default NULL,
		  `registrationnumber` varchar(30) default NULL,
		  `marksobtained` double default NULL,
		  `gradecode` varchar(10) default NULL,
		  `gradeunit` double default NULL,
		  `studentlevel` varchar(50) default NULL,
		  `programmecode` varchar(100) default NULL,
		  `coursestatus` varchar(20) default NULL,
		  `facultycode` varchar(100) default NULL,
		  `departmentcode` varchar(100) default NULL,
		  `groupsession` varchar(10) default NULL,
		  `gradepoint` double default NULL,
		  `cascore` varchar(30) default NULL,
		  `examscore` varchar(30) default NULL,
		  `currentuser` varchar(45) default NULL,
		  PRIMARY KEY  (`serialno`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		mysql_query($query, $connection);

		$query = "insert into ".$final_reportablename." SELECT * FROM finalresultstable where registrationnumber>='{$firstregnumber}' and registrationnumber<='{$lastregnumber}' ";
		mysql_query($query, $connection);

		$query = "SELECT * FROM {$table} ";
		if($table=="uniquereferencenumbers" && $option == "getAllRecs") {
						$regnolist="";

			if($facultycodes != "" && $departmentcodes != "" && $programmecodes != "" && $studentlevels){
				$query = "SELECT distinct a.regNumber FROM regularstudents a, registration b where a.serialno<>0 ";
				if($facultycodes != "")
					$query .= " and a.facultycode='{$facultycodes}' ";

				if($departmentcodes != "")
					$query .= " and a.departmentcode='{$departmentcodes}' ";

				if($programmecodes != "")
					$query .= " and a.programmecode='{$programmecodes}' "; 

				if($studentlevels != "")
					$query .= " and b.studentlevel='{$studentlevels}' "; 

				if($sesionss != "")
					$query .= " and b.sessions='{$sesionss}' ";

				if($semesters != "")
					$query .= " and b.semester='{$semesters}' ";

				$result = mysql_query($query, $connection);

				if(mysql_num_rows($result) > 0){
					$parameter="";
					while ($row = mysql_fetch_row($result)) {
						extract ($row);
						$parameter .= $row[0]."][";
					}
				}
				$parameter=substr($parameter, 0, strlen($parameter)-2);
				$parameter = explode("][", $parameter);
				for($count=0; $count<count($parameter); $count++)	$parameter[$count]=trim($parameter[$count]);
				foreach($parameter as $code) $regnolist.="'".$code."', ";
				$regnolist=substr($regnolist, 0, strlen($regnolist)-2);
			}

			if($regnolist!=''){
				$query = "SELECT serialno, uniquereferencenumber, useflag FROM uniquereferencenumbers where serialno<>0 and useflag IN (".$regnolist.") ";
			}else{
				$query = "SELECT serialno, uniquereferencenumber, useflag FROM uniquereferencenumbers where serialno<>0 ";
			}
			if($access == "All")
				$query .= " and useflag<>'' ";

			if($access == "Open")
				$query .= " and useflag='open' ";

			if($access == "Used")
				$query .= " and useflag<>'open' ";

			if($sesionss != "")
				$query .= " and sessiondescription='{$sesionss}' ";

			if($semesters != "")
				$query .= " and semesterdescription='{$semesters}' ";

			$query .= " order by uniquereferencenumber ";
		}

		if($table=="regularstudents" && $option == "getAllRecs") {
			$query = "SELECT a.*, b.sessions, b.semester, b.registered, b.studentlevel FROM regularstudents As a left JOIN registration AS b ON a.regNumber=b.regNumber";

			if($actives=="Yes/No"){
				$query .= " where a.active<>'' ";
			}else{
				$query .= " where a.active='{$actives}' ";
			}

			if($sesionss != "")
				$query .= " and b.sessions='{$sesionss}' "; 

			if($semesters != "")
				$query .= " and b.semester='{$semesters}' "; 

			//if($entryyears != "")
			//	$query .= " and a.entryyear='{$entryyears}' "; 

			if($facultycodes != ""){
				$query .= " and a.facultycode='{$facultycodes}' ";
			}

			if($departmentcodes != ""){
				$query .= " and a.departmentcode='{$departmentcodes}' ";
			}

			if($programmecodes != ""){
				$query .= " and a.programmecode='{$programmecodes}' "; 
			}
			if($studentlevels != ""){
				$query .= " and b.studentlevel='{$studentlevels}' "; 
			}
			if($regNumbers != ""){
				$query .= " and a.regNumber='{$regNumbers}' "; 
			}
			if($serialnos=='A') {
				setcookie("firstentry", "1", false);
				$query .= " and a.regNumber='0' "; 
			}
			$query .= " group by a.regNumber order by a.facultycode, a.departmentcode, a.programmecode, a.regNumber, a.firstName, a.lastName";
		}

		if($table=="regularstudentsA" && $option == "getAllRecs") {
			$query = "SELECT distinct a.serialno, a.regNumber, concat(a.lastName,' ',a.firstName), a.userEmail, a.phoneno FROM regularstudents a, registration b where a.active='Yes' and a.regNumber=b.regNumber";

			if($facultycodes != ""){
				$query .= " and a.facultycode='{$facultycodes}' ";
			}

			if($departmentcodes != ""){
				$query .= " and a.departmentcode='{$departmentcodes}' ";
			}

			if($programmecodes != ""){
				$query .= " and a.programmecode='{$programmecodes}' "; 
			}

			if($studentlevels != ""){
				$query .= " and b.studentlevel='{$studentlevels}' "; 
			}

			if($sesionss != "")
				$query .= " and b.sessions='{$sesionss}' "; 

			/*if($serialnos=='A') {
				setcookie("firstentry", "1", false);
				$query .= " and a.regNumber='0' "; 
			}*/
			$query .= " order by a.facultycode, a.departmentcode, a.programmecode, a.regNumber, a.lastName, a.firstName";
		}

		if($table=="regularstudentsB" && $option == "getAllRecs") {
			$query = "SELECT distinct a.serialno, a.regNumber, concat(a.lastName,' ',a.firstName), a.userEmail, a.phoneno, (select c.uniquereferencenumber FROM uniquereferencenumbers c where a.regNumber=c.useflag) as urn FROM regularstudents a, registration b where a.active='Yes' and a.regNumber=b.regNumber";

			if($facultycodes != ""){
				$query .= " and a.facultycode='{$facultycodes}' ";
			}

			if($departmentcodes != ""){
				$query .= " and a.departmentcode='{$departmentcodes}' ";
			}

			if($programmecodes != ""){
				$query .= " and a.programmecode='{$programmecodes}' "; 
			}

			if($studentlevels != ""){
				$query .= " and b.studentlevel='{$studentlevels}' "; 
			}

			if($sesionss != "")
				$query .= " and b.sessions='{$sesionss}' "; 

			/*if($serialnos=='A') {
				setcookie("firstentry", "1", false);
				$query .= " and a.regNumber='0' "; 
			}*/
			$query .= " order by a.facultycode, a.departmentcode, a.programmecode, a.regNumber, a.lastName, a.firstName";
		}

		if($table=="examresultstable" && $option == "getAllRecs") {
			$query = "select * FROM coursestable where serialno<>0 ";
			if($facultycodes != "")
				$query .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$query .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$query .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$query .= " and studentlevel='{$studentlevels}' "; 
			if($sesionss != "")
				$query .= " and sessiondescription='{$sesionss}' "; 
			if($semesters != "")
				$query .= " and semesterdescription='{$semesters}' "; 
			if($coursecodes != "")
				$query .= " and coursecode='{$coursecodes}' "; 
				$query .= " and recordlock='1' "; 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				echo "recordlocked for $coursecodes in $sesionss $semesters semester";
				return true;
			}

			$query = "SELECT coursecode FROM coursestable where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}'";
			//and groupsession='{$entryyears}' 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "coursenotsetup{$coursecodes}coursenotsetup{$facultycodes}coursenotsetup{$departmentcodes}coursenotsetup{$programmecodes}coursenotsetup{$studentlevels}coursenotsetup{$sesionss}coursenotsetup{$semesters}";//coursenotsetup{$entryyears}
				return true;
			}
			$query = "SELECT a.*, b.* FROM regularstudents a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.regNumber=b.regNumber and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}'";
			// and a.entryyear='{$entryyears}'
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "studentnotsetup{$facultycodes}studentnotsetup{$departmentcodes}studentnotsetup{$programmecodes}studentnotsetup{$studentlevels}studentnotsetup{$sesionss}studentnotsetup{$semesters}";
				//studentnotsetup{$entryyears}
				return true;
			}
			$query = "select distinct a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b where a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' and active='Yes' ";
			//and a.entryyear='{$entryyears}' 

			if($access=="") $access = "a.regNumber";
			$query .= " order by ".$access;

			if($sortorder==""){
				if($_COOKIE['sortorder']==null || $_COOKIE['sortorder']=='DESC')
					setcookie('sortorder', 'ASC', false);
				else{
					setcookie('sortorder', 'DESC', false);
				}
				$sortorder=$_COOKIE['sortorder'];
			}else if($sortorder=="DESC"){
				$sortorder = "ASC";
			}else{
				$sortorder = "DESC";
			}
			$query .= " ".$sortorder;
		}

		if($table=="amendedresults" && $option == "getAllRecs") {
			$query = "select * FROM coursestable where serialno<>0 ";
			if($facultycodes != "")
				$query .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$query .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$query .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$query .= " and studentlevel='{$studentlevels}' "; 
			if($sesionss != "")
				$query .= " and sessiondescription='{$sesionss}' "; 
			if($semesters != "")
				$query .= " and semesterdescription='{$semesters}' "; 
			if($coursecodes != "")
				$query .= " and coursecode='{$coursecodes}' "; 
				$query .= " and recordlock='1' "; 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				echo "recordlocked for $coursecodes in $sesionss $semesters semester";
				return true;
			}

			$query = "SELECT coursecode FROM coursestable where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}'";
			//and groupsession='{$entryyears}' 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "coursenotsetup{$coursecodes}coursenotsetup{$facultycodes}coursenotsetup{$departmentcodes}coursenotsetup{$programmecodes}coursenotsetup{$studentlevels}coursenotsetup{$sesionss}coursenotsetup{$semesters}";
				//coursenotsetup{$entryyears}
				return true;
			}
			$query = "SELECT a.*, b.* FROM regularstudents a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.regNumber=b.regNumber and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}'";
			// and a.entryyear='{$entryyears}'
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "studentnotsetup{$facultycodes}studentnotsetup{$departmentcodes}studentnotsetup{$programmecodes}studentnotsetup{$studentlevels}studentnotsetup{$sesionss}studentnotsetup{$semesters}";
				//studentnotsetup{$entryyears}
				return true;
			}
			$query = "select distinct a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b where a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' and active='Yes' ";
			// and a.entryyear='{$entryyears}'
			if($access=="") $access = "a.regNumber";
			$query .= " order by ".$access;

			if($_COOKIE['sortorder']=="DESC"){
				setcookie("sortorder", "ASC", false);
			}else{
				setcookie("sortorder", "DESC", false);
			}
			if($sortorder=="DESC") setcookie("sortorder", "ASC", false);
			$query .= " ".$_COOKIE['sortorder'];
		}

		if($table=="specialfeatures" && $option == "getAllRecs") {
			$query = "SELECT a.*, b.* FROM regularstudents a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.regNumber=b.regNumber and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}'";
			// and a.entryyear='{$entryyears}'
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "studentnotsetup{$facultycodes}studentnotsetup{$departmentcodes}studentnotsetup{$programmecodes}studentnotsetup{$studentlevels}studentnotsetup{$sesionss}studentnotsetup{$semesters}";
				//studentnotsetup{$entryyears}
				return true;
			}
			$query = "select a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b  where  a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.active='Yes' and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' ";
			// and a.entryyear='{$entryyears}'

			if($access=="") $access = "a.regNumber";
			$query .= " order by ".$access;

			if($_COOKIE['sortorder']=="DESC"){
				setcookie("sortorder", "ASC", false);
			}else{
				setcookie("sortorder", "DESC", false);
			}
			$query .= " ".$_COOKIE['sortorder'];
		}

		if($table=="coursestable" && $option == "getAllRecs") {
			$query .= " order by coursecode";
		}

		if($table=="departmentstable" && $option == "getAllRecs") {
			$query .= " order by departmentdescription";
		}

		if($table=="facultiestable" && $option == "getAllRecs") {
			$query .= " order by facultydescription";
		}

		if($table=="gradestable" && $option == "getAllRecs") {
			$query .= " order by lowerrange DESC ";
		}

		if($table=="programmestable" && $option == "getAllRecs") {
			$query .= " order by programmedescription";
		}

		if($table=="qualificationstable" && $option == "getAllRecs") {
			$query .= " order by qualificationcode";
		}

		if($table=="sessionstable" && $option == "getAllRecs") {
			$query .= " order by sessiondescription,semesterdescription";
		}

		if($table=="studentslevels" && $option == "getAllRecs") {
			$query .= " order by serialno, leveldescription";
		}

		if($option=="getRecordlist"){
			if(substr($currentobject, 0, 9)=="resultype")
				$query = "SELECT DISTINCT amendedtitle,amendedtitle FROM {$table} order by amendedtitle";
			if(substr($currentobject, 0, 12)=="amendedtitle")
				$query = "SELECT DISTINCT amendedtitle,amendedtitle FROM {$table} order by amendedtitle";
			if(substr($currentobject, 0, 11)=="facultycode")
				$query = "SELECT DISTINCT facultydescription,facultydescription FROM {$table} order by facultydescription";
			if(substr($currentobject, 0, 14)=="departmentcode"){
				$faculty=$_COOKIE['parent_obj'];
				$query = "SELECT DISTINCT departmentdescription, departmentdescription FROM {$table} where facultycode='{$faculty}' order by departmentdescription";
			}
			if(substr($currentobject, 0, 13)=="programmecode"){
				$department=$_COOKIE['parent_obj'];
				$query = "SELECT DISTINCT programmedescription, programmedescription FROM {$table} where departmentcode='{$department}' order by programmedescription";
			}
			if(substr($currentobject, 0, 12)=="studentlevel"){
				$programme=$_COOKIE['parent_obj'];
				$query = "SELECT DISTINCT leveldescription, leveldescription FROM {$table} where substr(leveldescription,1,1)=substr('{$programme}',1,1) order by serialno, leveldescription";
			}
			if(substr($currentobject, 0, 7)=="sesions" || substr($currentobject, 0, 8)=="sessions")
				$query = "SELECT DISTINCT sessiondescription, sessiondescription FROM {$table} order by sessiondescription DESC";
			if(substr($currentobject, 0, 8)=="semester" || substr($currentobject, 0, 9)=="semesters")
				$query = "SELECT DISTINCT semesterdescription, semesterdescription FROM {$table} order by semesterdescription";
			if(substr($currentobject, 0, 10)=="coursecode")
				$query = "SELECT DISTINCT coursecode, coursecode FROM {$table} where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}'  order by coursecode";
			//and groupsession='{$entryyears}'
			if(substr($currentobject, 0, 15)=="markdescription")
				$query = "SELECT DISTINCT marksdescription, marksdescription FROM {$table} order by marksdescription";
			//if(substr($currentobject, 4, 5)=="sigid")
			if($table=="signatoriestable")
				$query = "SELECT DISTINCT serialno, signatoryposition, signatoryname FROM {$table} order by signatoryposition";
			if($table=="regularstudents")
				$query = "SELECT serialno, regNumber, firstName, lastName FROM {$table} where active='Yes' order by regNumber, firstName";
			if($table=="regularstudents" && substr($currentobject, 0, 5)=="matno")
				$query = "SELECT serialno, regNumber, lastName, firstName FROM {$table} where studentlevel='{$studentlevels}' and active='Yes' order by regNumber, lastName";
			if($table=="regularstudents" && substr($currentobject, 0, 9)=="matricno4")
				//$query = "SELECT serialno, regNumber, firstName, lastName FROM {$table} where  facultycode='{$facultycodes}'  and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and entryyear='{$entryyears}'  and active='Yes' order by regNumber, firstName";
				// and studentlevel='{$studentlevels}'
				//echo "getRecordlist".$query;
				$query = "select DISTINCT a.serialno, a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b  where  a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.active='Yes' and b.studentlevel='{$studentlevels}' order by a.regNumber, a.lastName ";
				//and a.entryyear='{$entryyears}' 
			if($table=="regularstudents" && substr($currentobject, 0, 8)=="students"){
				$query = "select DISTINCT a.serialno, a.regNumber, a.firstName, a.lastName from regularstudents a, registration b where a.regNumber=b.regNumber";
				if($facultycodes != "")
					$query .= " and a.facultycode='{$facultycodes}' ";
				if($departmentcodes != "")
					$query .= " and a.departmentcode='{$departmentcodes}' ";
				if($programmecodes != "")
					$query .= " and a.programmecode='{$programmecodes}' "; 
				if($studentlevels != "")
					$query .= " and b.studentlevel='{$studentlevels}' "; 
				//if($entryyears != "")
				//	$query .= " and a.entryyear='{$entryyears}' "; 
				if($regNumbers != "")
					$query .= " and (a.regNumber='{$regNumbers}' or a.lastName='{$regNumbers}' or a.firstName='{$regNumbers}' or a.middleName='{$regNumbers}' or a.userEmail='{$regNumbers}') "; 
				if($actives != "")
					$query .= " and a.active='{$actives}' ";
				$query .= " order by a.regNumber, a.lastName ";
				//$query = "select DISTINCT a.serialno, a.regNumber, a.firstName, a.lastName from regularstudents a, registration b  where  a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and a.active='{$actives}' and b.studentlevel='{$studentlevels}' order by a.regNumber, a.lastName ";
				setcookie("myquery", $query, false);
			}
			if(substr($currentobject, 0, 9)=="entryyear")
			//	$query = "SELECT DISTINCT entryyear, entryyear FROM {$table} order by entryyear";
				$query = "SELECT DISTINCT sessiondescription, sessiondescription FROM {$table} order by sessiondescription DESC";
		}

		$flag=1;
		if($option == "getARecord"){
			$query = "SELECT * FROM {$table} where serialno='{$serialnos}' ";
			if($table=="amendedreasons"){
				$query = "SELECT  amendreason, amendedtitle FROM {$table} where sessiondescription ='{$sesionss}' and semester ='{$semesters}' and coursecode ='{$coursecodes}' and facultycode ='{$facultycodes}' and departmentcode ='{$departmentcodes}' and programmecode ='{$programmecodes}' and studentlevel ='{$studentlevels}' and amendedtitle='{$amendedtitles}'";
				// and groupsession ='{$entryyears}'
			}
			if($table=="regularstudents"){
				$flg=0;
				if($sesionss != "" && $semesters != ""){
					$query = "SELECT a.*, b.sessions, b.semester FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.regNumber='{$regNumbers}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' "; 
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) == 1) $flg=1;
				}
				if($flg == 0){
					$query = "select sessions,semester from registration where regNumber='{$regNumbers}' order by sessions,semester desc";
					$maxsession="";
					$maxsemester="";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) > 0){
						while ($row = mysql_fetch_row($result)) {
							extract ($row);
							$maxsession=$row[0];
							$maxsemester=$row[1];
							break;
						}
						$query = "SELECT a.*, b.sessions, b.semester FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.regNumber='{$regNumbers}' and b.sessions='{$maxsession}' and b.semester='{$maxsemester}' ";
					}else{
						$query = "SELECT * FROM {$table} where serialno='{$serialnos}' ";
						$flag=0;
					}
				}
			}
		}

		$resp="";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$resp="";
			while ($row = mysql_fetch_row($result)) {
				extract ($row);

				if($option == "getAllRecs"  && $table=="examresultstable"){
					$query3 = "SELECT b.* FROM ".$exam_reportablename." b where b.registrationnumber='{$row[0]}' ";
					if($facultycodes != "")
						$query3 .= " and b.facultycode='{$facultycodes}' "; 
					if($departmentcodes != "")
						$query3 .= " and b.departmentcode='{$departmentcodes}' "; 
					if($programmecodes != "")
						$query3 .= " and b.programmecode='{$programmecodes}' ";
					if($studentlevels != "")
						$query3 .= " and b.studentlevel='{$studentlevels}' "; 
					if($sesionss != "")
						$query3 .= " and b.sessiondescription='{$sesionss}' "; 
					if($semesters != "")
						$query3 .= " and b.semester='{$semesters}' "; 
					//if($entryyears != "")
					//	$query3 .= " and b.groupsession='{$entryyears}' "; 
					if($coursecodes != "")
						$query3 .= " and b.coursecode='{$coursecodes}' "; 
					if($markdescriptions != "")
						$query3 .= " and b.marksdescription='{$markdescriptions}' "; 
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3) > 0){
						while ($row3 = mysql_fetch_row($result3)) {
							extract ($row3);
							foreach($row3 as $i => $value){
								$resp .= $value."!!!";
							}
						}
					}else{
						$resp .= "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
					}
				}

				if($option == "getAllRecs"  && $table=="amendedresults"){
					$query3a = "SELECT b.* FROM amendedresults b where b.registrationnumber='{$row[0]}' ";
					if($facultycodes != "")
						$query3a .= " and b.facultycode='{$facultycodes}' "; 
					if($departmentcodes != "")
						$query3a .= " and b.departmentcode='{$departmentcodes}' "; 
					if($programmecodes != "")
						$query3a .= " and b.programmecode='{$programmecodes}' ";
					if($studentlevels != "")
						$query3a .= " and b.studentlevel='{$studentlevels}' "; 
					if($sesionss != "")
						$query3a .= " and b.sessiondescription='{$sesionss}' "; 
					if($semesters != "")
						$query3a .= " and b.semester='{$semesters}' "; 
					//if($entryyears != "")
					//	$query3a .= " and b.groupsession='{$entryyears}' "; 
					if($coursecodes != "")
						$query3a .= " and b.coursecode='{$coursecodes}' "; 
					if($markdescriptions != "")
						$query3a .= " and b.marksdescription='{$markdescriptions}' "; 
					if($amendedtitles != "")
						$query3a .= " and b.amendedtitle='{$amendedtitles}' "; 
					$result3a = mysql_query($query3a, $connection);
					if(mysql_num_rows($result3a) > 0){
						while ($row3a = mysql_fetch_row($result3a)) {
							extract ($row3a);
							foreach($row3a as $i => $value){
								$resp .= $value."!!!";
							}
						}
					}else{
						$previoustitles="";
						$query3a = "SELECT max(amendedtitle) as previoustitles FROM {$table} where sessiondescription ='{$sesionss}' and semester ='{$semesters}' and coursecode ='{$coursecodes}' and registrationnumber ='{$row[0]}' and marksdescription ='{$markdescriptions}' and facultycode ='{$facultycodes}' and departmentcode ='{$departmentcodes}' and programmecode ='{$programmecodes}' and studentlevel ='{$studentlevels}' and amendedtitle<'{$amendedtitles}'";
						//and groupsession ='{$entryyears}' 
						$result3a = mysql_query($query3a, $connection);
						if(mysql_num_rows($result3a) > 0){
							while ($row3a = mysql_fetch_row($result3a)) {
								extract ($row3a);
								$previoustitles=$row3a[0];
							}
						}

						$query3a = "SELECT b.* FROM amendedresults b where b.registrationnumber='{$row[0]}' ";
						if($facultycodes != "")
							$query3a .= " and b.facultycode='{$facultycodes}' "; 
						if($departmentcodes != "")
							$query3a .= " and b.departmentcode='{$departmentcodes}' "; 
						if($programmecodes != "")
							$query3a .= " and b.programmecode='{$programmecodes}' ";
						if($studentlevels != "")
							$query3a .= " and b.studentlevel='{$studentlevels}' "; 
						if($sesionss != "")
							$query3a .= " and b.sessiondescription='{$sesionss}' "; 
						if($semesters != "")
							$query3a .= " and b.semester='{$semesters}' "; 
						//if($entryyears != "")
						//	$query3a .= " and b.groupsession='{$entryyears}' "; 
						if($coursecodes != "")
							$query3a .= " and b.coursecode='{$coursecodes}' "; 
						if($markdescriptions != "")
							$query3a .= " and b.marksdescription='{$markdescriptions}' "; 
						if($previoustitles != "")
							$query3a .= " and b.amendedtitle='{$previoustitles}' "; 
						$result3a = mysql_query($query3a, $connection);
						if(mysql_num_rows($result3a) > 0){
							while ($row3a = mysql_fetch_row($result3a)) {
								extract ($row3a);
								foreach($row3a as $i => $value){
									$meta = mysql_fetch_field($result3a, $i);
									if($meta->name=="previousmark"){
										//$resp .= $value."!!!";
									}else if($meta->name=="amendedmark"){
										$resp .= $value."!!!!!!";
									}else{
										$resp .= $value."!!!";
									}
								}
							}
						}else{

							$query3b = "SELECT b.* FROM ".$exam_reportablename." b where b.registrationnumber='{$row[0]}' ";
							if($facultycodes != "")
								$query3b .= " and b.facultycode='{$facultycodes}' "; 
							if($departmentcodes != "")
								$query3b .= " and b.departmentcode='{$departmentcodes}' "; 
							if($programmecodes != "")
								$query3b .= " and b.programmecode='{$programmecodes}' ";
							if($studentlevels != "")
								$query3b .= " and b.studentlevel='{$studentlevels}' "; 
							if($sesionss != "")
								$query3b .= " and b.sessiondescription='{$sesionss}' "; 
							if($semesters != "")
								$query3b .= " and b.semester='{$semesters}' "; 
							//if($entryyears != "")
							//	$query3b .= " and b.groupsession='{$entryyears}' "; 
							if($coursecodes != "")
								$query3b .= " and b.coursecode='{$coursecodes}' "; 
							if($markdescriptions != "")
								$query3b .= " and b.marksdescription='{$markdescriptions}' "; 
							$result3b = mysql_query($query3b, $connection);
							if(mysql_num_rows($result3b) > 0){
								while ($row3b = mysql_fetch_row($result3b)) {
									extract ($row3b);
									foreach($row3b as $i => $value){
										$resp .= $value."!!!";
									}
									$resp .= "!!!!!!!!!!!!!!!!!!!!!!!!!!!";
								}
							}else{
								$resp .= "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
							}
					
						}
					}
//echo $query3a."<br>\n";
				}

				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					if ($option=="getAllRecs" || $option=="getRecordlist") {
						if($meta->name == 'useflag' && $value<>'open' && $option=="getAllRecs"  && $table=="uniquereferencenumbers"){
							$resp .= "used!!!";
						}else{
							$resp .= $value."!!!";
						}
					} else {
						$resp .= "getARecord" . $value;
					}
				}

				if($option == "getAllRecs"  && $table=="uniquereferencenumbers") {
					$query3 = "SELECT a.regNumber, concat(a.lastName,' ',a.firstName) as names, a.facultycode, a.departmentcode, a.programmecode, b.studentlevel FROM regularstudents a, registration b where a.regNumber='{$row[2]}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' ";
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3) > 0){
						while ($row3 = mysql_fetch_row($result3)) {
							extract ($row3);
							foreach($row3 as $i => $valueb){
								$resp .= $valueb."!!!";
							}
						}
					}else{
						$resp .= "!!!!!!!!!!!!!!!!!!";
					}
				}

				if($option == "getAllRecs"  && $table=="specialfeatures"){
					$query3 = "SELECT b.* FROM specialfeatures b where b.registrationnumber='{$row[0]}' ";

					if($facultycodes != "")
						$query3 .= " and b.facultycode='{$facultycodes}' "; 
					if($departmentcodes != "")
						$query3 .= " and b.departmentcode='{$departmentcodes}' "; 
					if($sesionss != "")
						$query3 .= " and b.sessiondescription='{$sesionss}' "; 

					if($semesters != "")
						$query3 .= " and b.semester='{$semesters}' "; 
				
					//if($entryyears != "")
					//	$query3 .= " and b.groupsession='{$entryyears}' "; 

					if($studentlevels != "")
						$query3 .= " and b.studentlevel='{$studentlevels}' "; 

					if($programmecodes != "")
						$query3 .= " and b.programmecode='{$programmecodes}' ";
					
					$result3 = mysql_query($query3, $connection);
					if(mysql_num_rows($result3) > 0){
						while ($row3 = mysql_fetch_row($result3)) {
							extract ($row3);
							foreach($row3 as $i => $value){
								$resp .= $value."!!!";
							}
						}
					}else{
						$resp .= "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
					}
				}

				if($option == "getAllRecs"  && $table=="examresultstable"){
					$query2 = "SELECT coursestatus FROM retakecourses where registrationnumber='{$row[0]}' and sessiondescription='{$sesionss}'  and semester='{$semesters}'  and coursecode='{$coursecodes}' ";
					$result2 = mysql_query($query2, $connection);

					if(mysql_num_rows($result2) > 0){
						while ($row2 = mysql_fetch_row($result2)) {
							extract ($row2);
							$resp .= $row2[0]."!!!";
						}
					}else{
						$resp .= "!!!";
					}

					$query2 = "SELECT cascore,examscore FROM ".$final_reportablename." where registrationnumber='{$row[0]}' and sessiondescription='{$sesionss}'  and semester='{$semesters}'  and coursecode='{$coursecodes}' ";
					$result2 = mysql_query($query2, $connection);

					if(mysql_num_rows($result2) > 0){
						while ($row2 = mysql_fetch_row($result2)) {
							extract ($row2);
							$resp .= $row2[0]."!!!".$row2[1]."!!!";
						}
					}else{
						$resp .= "!!!!!!";
					}

				}
				if ($option=="getAllRecs" || $option=="getRecordlist") $resp .= $option;
			}
		}else{
			if($table=="admissiontype"){
				$resp = "PCE!!!PCE!!!" . $option . "UTME!!!UTME!!!" . $option;
			}
		}
		if($option=="getRecordlist" && substr($currentobject, 0, 9)=="resultype")
			//$resp = "Normal Results!!!Normal Results!!!" . $option . "Supplemenrary Results!!!Supplemenrary Results!!!" . $option . $resp;
			$resp = "Normal Results!!!Normal Results!!!" . $option . "Repeaters Results!!!Repeaters Results!!!" . $option . $resp;
		if($table=="regularstudents" && $flag==0 && $option=="getARecord") $resp .= "getARecordgetARecord";
		if ($option=="getAllRecs") $resp = $table . $option . $resp;
		if ($option=="getARecord"){
			$resp = $table . $resp . $option;
			if($table=="regularstudents"){
				$query="SELECT * FROM registration where regNumber='{$regNumbers}' order by studentlevel,sessions,semester "; 
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					while ($row = mysql_fetch_row($result)) {
						extract ($row);
						$resp .= $row[2]."~_~".$row[3]."~_~".$row[4]."~_~".$row[5]."!!!";
					}
					$resp .= $option;
				}
			}
		}

		
		$query = "DROP TABLE IF EXISTS ".$exam_reportablename;
		mysql_query($query, $connection);

		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_examresultstable%'  ";
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

		$query = "DROP TABLE IF EXISTS ".$final_reportablename;
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


		echo $resp;
		//if ($option=="getAllRecs") echo $query;
		//if ($option=="getRecordlist") echo $query;
    }

	$query = "SELECT qualificationcode FROM regularstudents where regNumber='{$regno}'";
	$result = mysql_query($query, $connection);
	while ($row = mysql_fetch_array($result)) {
		extract ($row);
	}

	if($option == "addRecord"){
		$parameters = explode("][", $param);
		for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
		if($table=="signatoriestable") 
			$query = "SELECT * FROM {$table} where signatoryposition ='{$parameters[1]}'";
		if($table=="regularstudents"){
			$faculty = checkCode("facultiestable","facultydescription",$parameters[4]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[4]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[5]);
			if($department=="notinsetup"){
				echo $department.$parameters[5]."notinsetupDepartment";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[6]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[6]."notinsetupProgramme";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[40]);
			if($level=="notinsetup"){
				echo $level.$parameters[40]."notinsetupStudent_Level";
				return true;
			}
			$qualification = checkCode("qualificationstable","qualificationcode",$parameters[44]);
			if($qualification=="notinsetup"){
				echo $qualification.$parameters[44]."notinsetupQualification";
				return true;
			}

			$parameter2 = explode("][", $param2);
			for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);
			$sesionss = checkCode("sessionstable","sessiondescription",$parameter2[2]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameter2[2]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameter2[3]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameter2[3]."notinsetupSessions";
				return true;
			}
		}
		if($table=="examresultstable"){
			$parameters = explode("][", $param);
			for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($department=="notinsetup"){
				echo $department.$parameters[12]."notinsetupDepartment";
				return true;
			}
			$sesionss = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameters[2]."notinsetupSessions";
				return true;
			}
			$coursecode = checkCode("coursestable","coursecode",$parameters[3]);
			if($coursecode=="notinsetup"){
				echo $coursecode.$parameters[3]."notinsetupCourse_Code";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[9]);
			if($level=="notinsetup"){
				echo $level.$parameters[9]."notinsetupStudent_Level";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[10]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[10]."notinsetupProgramme";
				return true;
			}

			$maximumunits=0;
			$query = "SELECT distinct maximumunit FROM unitstable  where facultycode='{$parameters[11]}' and departmentcode='{$parameters[12]}' and programmecode='{$parameters[10]}' and studentlevel='{$parameters[9]}' and sessiondescription='{$parameters[1]}' and semesterdescription='{$parameters[2]}' "; 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$row = mysql_fetch_array($result);
				extract ($row);
				$maximumunits=$row[0];
			}

			$totalunits=0;
			$query = "SELECT sum(courseunit) FROM coursestable  where facultycode='{$parameters[11]}' and departmentcode='{$parameters[12]}' and programmecode='{$parameters[10]}' and studentlevel='{$parameters[9]}' and sessiondescription='{$parameters[1]}' and semesterdescription='{$parameters[2]}'  and coursecode!='{$parameters[3]}'  and coursecode in (SELECT b.coursecode FROM finalresultstable b where b.facultycode='{$parameters[11]}' and b.departmentcode='{$parameters[12]}' and b.programmecode='{$parameters[10]}' and b.studentlevel='{$parameters[9]}' and b.sessiondescription='{$parameters[1]}' and b.semester='{$parameters[2]}' and b.registrationnumber='{$parameters[4]}') "; 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$row = mysql_fetch_array($result);
				extract ($row);
				$totalunits=$row[0];
			}

			$coursesunit=0;
			$query = "SELECT courseunit FROM coursestable  where facultycode='{$parameters[11]}' and departmentcode='{$parameters[12]}' and programmecode='{$parameters[10]}' and studentlevel='{$parameters[9]}' and sessiondescription='{$parameters[1]}' and semesterdescription='{$parameters[2]}' and coursecode='{$parameters[3]}' "; 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$row = mysql_fetch_array($result);
				extract ($row);
				$coursesunit=$row[0];
			}

			if(($coursesunit+$totalunits) > $maximumunits){
				echo $parameters[4]."_exceeded_maximum_unit_of_(".$maximumunits."_units_)_in_".$parameters[2]."_semester_of_".$parameters[1]."_session_exceedmaximumunits";
				return true;
			}

			$query = "SELECT * FROM registration where sessions ='{$parameters[1]}' and semester ='{$parameters[2]}' and regNumber ='{$parameters[4]}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				echo "notinregister" . $parameters[1] . "notinregister" . $parameters[2] . "notinregister" . $parameters[4] . "notinregisterRegistration";
				return true;
			}
		}

		if($table=="amendedresults"){
			$parameters = explode("][", $param);
			for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($department=="notinsetup"){
				echo $department.$parameters[12]."notinsetupDepartment";
				return true;
			}
			$sesionss = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameters[2]."notinsetupSessions";
				return true;
			}
			$coursecode = checkCode("coursestable","coursecode",$parameters[3]);
			if($coursecode=="notinsetup"){
				echo $coursecode.$parameters[3]."notinsetupCourse_Code";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[9]);
			if($level=="notinsetup"){
				echo $level.$parameters[9]."notinsetupStudent_Level";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[10]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[10]."notinsetupProgramme";
				return true;
			}

			$query = "SELECT * FROM registration where sessions ='{$parameters[1]}' and semester ='{$parameters[2]}' and regNumber ='{$parameters[4]}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				echo "notinregister" . $parameters[1] . "notinregister" . $parameters[2] . "notinregister" . $parameters[4] . "notinregisterRegistration";
				return true;
			}
		}

		if($table=="specialfeatures"){
			$parameters = explode("][", $param);
			for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[5]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[5]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[6]);
			if($department=="notinsetup"){
				echo $department.$parameters[6]."notinsetupDepartment";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[7]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[7]."notinsetupProgramme";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[8]);
			if($level=="notinsetup"){
				echo $level.$parameters[8]."notinsetupStudent_Level";
				return true;
			}
			$sesionss = checkCode("sessionstable","sessiondescription",$parameters[2]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameters[2]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameters[3]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameters[3]."notinsetupSessions";
				return true;
			}
			/*$query = "SELECT * FROM registration where sessions ='{$parameters[1]}' and semester ='{$parameters[2]}' and regNumber ='{$parameters[1]}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				echo "notinregister" . $parameters[2] . "notinregister" . $parameters[3] . "notinregister" . $parameters[4] . "notinregisterRegistration";
				return true;
			}*/
		}

		$parameters = explode("][", $param);
		for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
		$parameters3 = explode("][", $param2);
		for($count=0; $count<count($parameters3); $count++)	$parameters3[$count]=trim($parameters3[$count]);
		if($table=="regularstudents"){
			$query = "SELECT * FROM {$table} where regNumber ='{$parameters[1]}'";
		}
		if($table=="examresultstable"){
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
		}
		if($table=="amendedresults"){
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and amendedtitle ='{$parameters3[8]}'";
		}
		if($table=="specialfeatures"){
			$query = "SELECT * FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' ";
		}
		if($table=="retakecourses"){
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}'  and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
		}
		
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) == 0){
			$query = "select max(serialno) as id from {$table}";
			$result = mysql_query($query, $connection);
			$row = mysql_fetch_array($result);
			extract ($row);
			$serialnos = intval($id)+1;

			if($table=="finalresultstable" || $table=="examresultstable"){
				$query = "INSERT INTO {$table} (serialno, currentuser) VALUES ({$serialnos},'{$currentusers}')";
			}else{
				$query = "INSERT INTO {$table} (serialno) VALUES ({$serialnos})";
			}
			$result = mysql_query($query, $connection);

			$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
			$result = mysql_query($query, $connection);

			if(mysql_num_rows($result) > 0){
				$record="";
				$count=0;
				while ($row = mysql_fetch_row($result)) {
					extract ($row);
					foreach($row as $i => $value){
						$meta = mysql_fetch_field($result, $i);
						if($count > 0){
							if($parameters[$count]!=null && $parameters[$count]!="")
								$record .= $meta->name . "='".$parameters[$count]."', ";
							$count++;
						}else{
							$count++;
						}
					}
				}
				$record = substr($record, 0, strlen($record)-2);

				if($table=="finalresultstable" || $table=="examresultstable"){
					$query = "UPDATE {$table} set ".$record.", currentuser='{$currentusers}' where serialno ={$serialnos}";
				}else{
					$query = "UPDATE {$table} set ".$record." where serialno ={$serialnos}";
				}
				if($table=="retakecourses"){
					$query = "UPDATE {$table}  set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', coursestatus = '{$param2}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}',  programmecode = '{$parameters[10]}',  studentlevel = '{$parameters[9]}' where serialno ='{$serialnos}'";
					$result = mysql_query($query, $connection);
					
					$query = "UPDATE examresultstable set marksobtained=null, currentuser='{$currentusers}' where sessiondescription = '{$parameters[1]}' and semester = '{$parameters[2]}' and coursecode = '{$parameters[3]}' and registrationnumber = '{$parameters[4]}' and coursestatus = '{$param2}' and facultycode = '{$parameters[11]}' and departmentcode = '{$parameters[12]}' and programmecode = '{$parameters[10]}' and studentlevel = '{$parameters[9]}' ";
					$result = mysql_query($query, $connection);
					
					$query = "UPDATE finalresultstable set cascore=null, examscore=null, marksobtained=null, currentuser='{$currentusers}' where sessiondescription = '{$parameters[1]}' and semester = '{$parameters[2]}' and coursecode = '{$parameters[3]}' and registrationnumber = '{$parameters[4]}' and coursestatus = '{$param2}' and facultycode = '{$parameters[11]}' and departmentcode = '{$parameters[12]}' and programmecode = '{$parameters[10]}' and studentlevel = '{$parameters[9]}' ";
					$result = mysql_query($query, $connection);
				}

				if($table=="examresultstable"){
					$resp=updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[14], $parameters[15]);
					if(str_in_str($resp,"already passed")){
						echo $resp;
						return true;
					}
					$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and coursestatus='' ";
					mysql_query($query, $connection);
				}

				if($table=="amendedresults"){
					$parameters3 = explode("][", $param2);
					for($count=0; $count<count($parameters3); $count++)	$parameters3[$count]=trim($parameters3[$count]);

					$previousmarks=$parameters[15];
					$amendedmarks=$parameters[16];

					$amendedgradecodes="";
					$amendedgradeunits=0;
					$amendedtitles=$parameters3[8];

					$previousgradecodes="";
					$previousgradeunits=0;
					$query = "SELECT max(amendedtitle) as previoustitles FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and amendedtitle<'{$amendedtitles}'";
					$result = mysql_query($query, $connection);
					extract (mysql_fetch_array($result));
					if($previoustitles==null) $previoustitles="";

					$query = "select * from gradestable where {$amendedmarks}>=lowerrange and {$amendedmarks}<=upperrange and sessions='{$parameters[1]}' and qualification='{$qualificationcode}' order by lowerrange DESC ";
					$result = mysql_query($query, $connection);
					$gcode="";
					$gunit="";
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						$amendedgradecodes=$row[1];
						$amendedgradeunits=$row[4];
					}

					$query = "select * from gradestable where {$previousmarks}>=lowerrange and {$previousmarks}<=upperrange and sessions='{$parameters[1]}' and qualification='{$qualificationcode}' order by lowerrange DESC ";
					$result = mysql_query($query, $connection);
					$gcode="";
					$gunit="";
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						$previousgradecodes=$row[1];
						$previousgradeunits=$row[4];
					}

					$query = "update {$table} set amendedgradecode='{$amendedgradecodes}', amendedgradeunit={$amendedgradeunits}, amendedtitle='{$amendedtitles}', previousgradecode='{$previousgradecodes}', previousgradeunit={$previousgradeunits}, previoustitle='{$previoustitles}' where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and serialno ='{$serialnos}' ";
					$result = mysql_query($query, $connection);

					$query = "SELECT * FROM amendedreasons where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) == 0){
						$query = "insert into amendedreasons (amendreason, facultycode, departmentcode, programmecode, studentlevel, sessiondescription, semester, coursecode, amendedtitle) values ('{$parameters3[9]}', '{$parameters3[0]}', '{$parameters3[1]}', '{$parameters3[2]}', '{$parameters3[4]}', '{$parameters3[5]}', '{$parameters3[6]}', '{$parameters3[7]}', '{$parameters3[8]}') ";
						//, groupsession  '{$parameters3[3]}', 
					}else{
						$query = "update amendedreasons set amendreason='{$parameters3[9]}' where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
						// and groupsession ='{$parameters3[3]}'
					}
					mysql_query($query, $connection);

					$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
					//and groupsession ='{$parameters[13]}'
					mysql_query($query, $connection);
				} 

				if($table=="retakecourses" && ($param2=="Sick" || $param2=="Absent" || $param2=="Did Not Register" || $param2=="Incomplete")){
					//$parameter2 = explode("][", $param2);
					$query = "SELECT * FROM examresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
					//and groupsession ='{$parameters[13]}'
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) == 0){
						$query = "INSERT INTO examresultstable (sessiondescription, semester, coursecode, registrationnumber, marksdescription,  marksobtainable, percentage, studentlevel, programmecode, facultycode, departmentcode, currentuser) VALUES ('{$parameters[1]}', '{$parameters[2]}', '{$parameters[3]}', '{$parameters[4]}', '{$parameters[5]}', {$parameters[7]}, {$parameters[8]}, '{$parameters[9]}', '{$parameters[10]}', '{$parameters[11]}', '{$parameters[12]}','{$currentusers}')";
						$result = mysql_query($query, $connection);
					}else{
						while ($row = mysql_fetch_row($result)) {
							extract ($row);
							$serialnos = $serialno;
						}
						$query = "update examresultstable set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', marksdescription = '{$parameters[5]}', marksobtainable = {$parameters[7]}, percentage = {$parameters[8]}, studentlevel = '{$parameters[9]}',  programmecode = '{$parameters[10]}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}', currentuser='{$currentusers}' where serialno ='{$serialnos}'";
						//, groupsession = '{$parameters[13]}'
						$result = mysql_query($query, $connection);
					}
					$resp=updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[14], $parameters[15]);
					if(str_in_str($resp,"already passed")){
						echo $resp;
						return true;
					}
				}

				if($table=="regularstudents"){
					$parameter2 = explode("][", $param2);
					for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);
					$query = "SELECT * FROM registration where regNumber ='{$parameter2[0]}' and studentlevel  ='{$parameter2[1]}' and sessions ='{$parameter2[2]}' and semester ='{$parameter2[3]}'";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) == 0){
						$query = "INSERT INTO registration (regNumber, studentlevel, sessions, semester, registered) VALUES ('{$parameter2[0]}', '{$parameter2[1]}', '{$parameter2[2]}', '{$parameter2[3]}', 'Yes')";
						$result = mysql_query($query, $connection);
					}
				}
			}

			$usernames = $_COOKIE['currentuser'];
			$activitydescriptions = $usernames." inserted record into table: ".$table." Record: ".str_replace("'", "", trim($record));
			$activitydates = date("Y-m-d");
			$activitytimes = date("H:i:s");
			$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
			mysql_query($query, $connection);

			echo $table."inserted";
		}else {
			if($table=="examresultstable" || $table=="amendedresults" || $table=="specialfeatures"){
				$result = mysql_query($query, $connection);
				$row = mysql_fetch_array($result);
				extract ($row);
				$serialnos = intval($row[0]);
				$option = "updateRecord";
			}else{
				echo "recordexists";
			}
		}
	}

	if($option == "updateRecord"){
		$parameters = explode("][", $param);
		for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
		if($table=="regularstudents"){
/*amendedresults registrationnumber
coursesform registrationnumber
examresultstable registrationnumber
finalresultstable registrationnumber
registration regNumber
regularstudents regNumber
retakecourses registrationnumber
specialfeatures registrationnumber*/
			$faculty = checkCode("facultiestable","facultydescription",$parameters[4]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[4]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[5]);
			if($department=="notinsetup"){
				echo $department.$parameters[5]."notinsetupDepartment";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[6]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[6]."notinsetupProgramme";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[40]);
			if($level=="notinsetup"){
				echo $level.$parameters[40]."notinsetupStudent_Level";
				return true;
			}
			$qualification = checkCode("qualificationstable","qualificationcode",$parameters[44]);
			if($qualification=="notinsetup"){
				echo $qualification.$parameters[44]."notinsetupQualification";
				return true;
			}

			$parameter2 = explode("][", $param2);
			for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);
			$sesionss = checkCode("sessionstable","sessiondescription",$parameter2[2]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameter2[2]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameter2[3]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameter2[3]."notinsetupSessions";
				return true;
			}
		}
		if($table=="examresultstable"){
			$parameters = explode("][", $param);
			for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($department=="notinsetup"){
				echo $department.$parameters[12]."notinsetupDepartment";
				return true;
			}
			$sesionss = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameters[2]."notinsetupSessions";
				return true;
			}
			$coursecode = checkCode("coursestable","coursecode",$parameters[3]);
			if($coursecode=="notinsetup"){
				echo $coursecode.$parameters[3]."notinsetupCourse_Code";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[9]);
			if($level=="notinsetup"){
				echo $level.$parameters[9]."notinsetupStudent_Level";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[10]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[10]."notinsetupProgramme";
				return true;
			}
		}
		if($table=="amendedresults"){
			$parameters = explode("][", $param);
			for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($department=="notinsetup"){
				echo $department.$parameters[12]."notinsetupDepartment";
				return true;
			}
			$sesionss = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameters[2]."notinsetupSessions";
				return true;
			}
			$coursecode = checkCode("coursestable","coursecode",$parameters[3]);
			if($coursecode=="notinsetup"){
				echo $coursecode.$parameters[3]."notinsetupCourse_Code";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[9]);
			if($level=="notinsetup"){
				echo $level.$parameters[9]."notinsetupStudent_Level";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[10]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[10]."notinsetupProgramme";
				return true;
			}
		}
		if($table=="specialfeatures"){
			$parameters = explode("][", $param);
			for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[5]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[5]."notinsetupFaculty";
				return true;
			}
			$department = checkCode("departmentstable","departmentdescription",$parameters[6]);
			if($department=="notinsetup"){
				echo $department.$parameters[6]."notinsetupDepartment";
				return true;
			}
			$programme = checkCode("programmestable","programmedescription",$parameters[7]);
			if($programme=="notinsetup"){
				echo $programme.$parameters[7]."notinsetupProgramme";
				return true;
			}
			$level = checkCode("studentslevels","leveldescription",$parameters[8]);
			if($level=="notinsetup"){
				echo $level.$parameters[8]."notinsetupStudent_Level";
				return true;
			}
			$sesionss = checkCode("sessionstable","sessiondescription",$parameters[2]);
			if($sesionss=="notinsetup"){
				echo $sesionss.$parameters[2]."notinsetupSessions";
				return true;
			}
			$semesters = checkCode("sessionstable","semesterdescription",$parameters[3]);
			if($semesters=="notinsetup"){
				echo $semesters.$parameters[3]."notinsetupSessions";
				return true;
			}
		}

		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		if($table=="examresultstable") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
		//and groupsession ='{$parameters[13]}'

		if($table=="amendedresults") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
		//and groupsession ='{$parameters[13]}'

		if($table=="specialfeatures") 
			$query = "SELECT * FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' ";
		//and groupsession ='{$parameters[9]}'

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$record="";
			$count=0;
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					if($count > 0){
						//$record .= $meta->name . "='".$parameters[$count++]."', ";
						if($parameters[$count]!=null && $parameters[$count]!="")
							$record .= $meta->name . "='".$parameters[$count]."', ";
						$count++;
					}else{
						$count++;
					}
				}
			}
			$record = substr($record, 0, strlen($record)-2);

			if($table=="finalresultstable" || $table=="examresultstable"){
				$query = "UPDATE {$table} set ".$record.", currentuser='{$currentusers}' where serialno ={$serialnos}";
			}else{
				$query = "UPDATE {$table} set ".$record." where serialno ={$serialnos}";
			}
			if($table=="retakecourses")
				$query = "UPDATE {$table}  set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', coursestatus = '{$param2}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}',  programmecode = '{$parameters[10]}',  studentlevel = '{$parameters[9]}' where serialno ='{$serialnos}'";
			//, groupsession = '{$parameters[13]}'

			if($table=="examresultstable")
				$query = "UPDATE {$table} set ".$record.", currentuser='{$currentusers}' where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
			//and groupsession ='{$parameters[13]}'

			if($table=="amendedresults"){
				//$query = "update examresultstable set marksobtained='{$parameters[16]}' where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				//mysql_query($query, $connection);

				$query = "UPDATE {$table} set ".$record." where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and serialno='{$serialnos}'";
				//and groupsession ='{$parameters[13]}' 
			}
			if($table=="specialfeatures") 
				$query = "UPDATE {$table} set feature = '{$parameters[4]}' where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' ";
			//and groupsession ='{$parameters[9]}' 

			$result = mysql_query($query, $connection);

			if($table=="retakecourses" && ($param2=="Sick" || $param2=="Absent" || $param2=="Did Not Register" || $param2=="Incomplete")){
				$query = "SELECT * FROM examresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				//and groupsession ='{$parameters[13]}'
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 0){
					$query = "INSERT INTO examresultstable (sessiondescription, semester, coursecode, registrationnumber, marksdescription, marksobtainable, percentage, studentlevel, programmecode, facultycode, departmentcode, currentuser) VALUES ('{$parameters[1]}', '{$parameters[2]}', '{$parameters[3]}', '{$parameters[4]}', '{$parameters[5]}', {$parameters[7]}, {$parameters[8]}, '{$parameters[9]}', '{$parameters[10]}', '{$parameters[11]}', '{$parameters[12]}', '{$currentusers}')";
					$result = mysql_query($query, $connection);
				}else{
					while ($row = mysql_fetch_row($result)) {
						extract ($row);
						$serialnos = $serialno;
					}
					$query = "update examresultstable set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', marksdescription = '{$parameters[5]}', marksobtainable = {$parameters[7]}, percentage = {$parameters[8]}, studentlevel = '{$parameters[9]}',  programmecode = '{$parameters[10]}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}', currentuser='{$currentusers}' where serialno ='{$serialnos}'";
					$result = mysql_query($query, $connection);
				}
				$resp=updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[14], $parameters[15]);
				if(str_in_str($resp,"already passed")){
					echo $resp;
					return true;
				}
			}

			if($table=="examresultstable"){
				$resp=updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[14], $parameters[15]);
				if(str_in_str($resp,"already passed")){
					echo $resp;
					return true;
				}
				$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				mysql_query($query, $connection);
			}

			if($table=="amendedresults"){
				$parameters3 = explode("][", $param2);
				for($count=0; $count<count($parameters3); $count++)	$parameters3[$count]=trim($parameters3[$count]);

				$previousmarks=$parameters[15];
				$amendedmarks=$parameters[16];

				$amendedgradecodes="";
				$amendedgradeunits=0;
				$amendedtitles=$parameters3[8];

				$previousgradecodes="";
				$previousgradeunits=0;
				$query = "SELECT max(amendedtitle) as previoustitles FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and amendedtitle<'{$amendedtitles}'";
				$result = mysql_query($query, $connection);
				extract (mysql_fetch_array($result));
				if($previoustitles==null) $previoustitles="";

				$query = "select * from gradestable where {$amendedmarks}>=lowerrange and {$amendedmarks}<=upperrange and sessions='{$parameters[1]}' and qualification='{$qualificationcode}' order by lowerrange DESC ";
				$result = mysql_query($query, $connection);
				$gcode="";
				$gunit="";
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$amendedgradecodes=$row[1];
					$amendedgradeunits=$row[4];
				}

				$query = "select * from gradestable where {$previousmarks}>=lowerrange and {$previousmarks}<=upperrange and sessions='{$parameters[1]}' and qualification='{$qualificationcode}' order by lowerrange DESC ";
				$result = mysql_query($query, $connection);
				$gcode="";
				$gunit="";
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$previousgradecodes=$row[1];
					$previousgradeunits=$row[4];
				}

				$query = "update {$table} set amendedgradecode='{$amendedgradecodes}', amendedgradeunit={$amendedgradeunits}, amendedtitle='{$amendedtitles}', previousgradecode='{$previousgradecodes}', previousgradeunit={$previousgradeunits}, previoustitle='{$previoustitles}' where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and serialno='{$serialnos}'";
				$result = mysql_query($query, $connection);

				$query = "SELECT * FROM amendedreasons where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 0){
					$query = "insert into amendedreasons (amendreason, facultycode, departmentcode, programmecode, studentlevel, sessiondescription, semester, coursecode, amendedtitle) values ('{$parameters3[9]}', '{$parameters3[0]}', '{$parameters3[1]}', '{$parameters3[2]}', '{$parameters3[4]}', '{$parameters3[5]}', '{$parameters3[6]}', '{$parameters3[7]}', '{$parameters3[8]}') ";
				}else{
					$query = "update amendedreasons set amendreason='{$parameters3[9]}' where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
				}
				mysql_query($query, $connection);

				$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				mysql_query($query, $connection);
			}

			if($table=="regularstudents"){
				$parameter2 = explode("][", $param2);
				for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);
				$query = "SELECT * FROM registration where regNumber = '{$parameter2[0]}' and studentlevel  = '{$parameter2[1]}' and sessions = '{$parameter2[2]}' and semester = '{$parameter2[3]}'";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 0){
					$query = "INSERT INTO registration (regNumber, studentlevel, sessions, semester, registered) VALUES ('{$parameter2[0]}', '{$parameter2[1]}', '{$parameter2[2]}', '{$parameter2[3]}', 'Yes')";
					$result = mysql_query($query, $connection);
				}
			}

			$usernames = $_COOKIE['currentuser'];
			$activitydescriptions = $usernames." updated record into table: ".$table." Record: ".str_replace("'", "", trim($record));
			$activitydates = date("Y-m-d");
			$activitytimes = date("H:i:s");
			$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
			mysql_query($query, $connection);

			echo $table."updated";
		} else {
			if($table=="examresultstable" || $table=="amendedresults" || $table=="specialfeatures"){
				return true;
			}else{
				echo "recordnotexist";
			}
		}
	}

	if($option == "deleteRecord"){
		$parameters = explode("][", $param);
		for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);
		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";

		if($table=="examresultstable") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";

		if($table=="amendedresults") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";

		if($table=="specialfeatures") 
			$query = "SELECT * FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' ";

		if($table=="retakecourses") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$query = "DELETE FROM {$table} where serialno ='{$serialnos}'";
			$allquery = "";
			if($table=="examresultstable") {
				$query = "DELETE FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				$allquery .= $query.", ";
				mysql_query($query, $connection);
				$query = "DELETE FROM finalresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				$allquery .= $query.", ";
			}

			if($table=="amendedresults") {
				$query = "DELETE FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				$allquery .= $query.", ";
				mysql_query($query, $connection);
			}

			if($table=="specialfeatures") {
				$query = "DELETE FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' ";
				$allquery .= $query.", ";
			}

			if($table=="retakecourses") {
				$query = "DELETE FROM {$table} where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				$allquery .= $query.", ";
				mysql_query($query, $connection);
				$query = "DELETE FROM examresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				$allquery .= $query.", ";
				mysql_query($query, $connection);
				$query = "DELETE FROM finalresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' ";
				$allquery .= $query.", ";
			}
			mysql_query($query, $connection);

			$usernames = $_COOKIE['currentuser'];
			$activitydescriptions = $usernames." deleted record from table: ".$table." Queries: ".str_replace("'", "", trim($allquery));
			$activitydates = date("Y-m-d");
			$activitytimes = date("H:i:s");
			$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
			mysql_query($query, $connection);

			echo $table."deleted";
			//}else{
			//	if($table=="examresultstable"){
			//		return true;
			//	}else{
			//		echo "recordnotexist";
			//	}
			//}
		} else {
			if($table=="examresultstable" || $table=="amendedresults" || $table=="specialfeatures"){
				return true;
			}else{
				echo "recordnotexist";
			}
		}
	}

?>
