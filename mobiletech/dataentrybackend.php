<?php
	$option =  str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['option'])));
	$serialnos = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['serialno'])));
	$currentusers = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['currentuser'])));
	$menuoption = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['menuoption'])));
	$access = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['access'])));
	$param = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['param'])));
	$param2 = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['param2'])));
	$sortorder = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['sortorder'])));
	$table = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['table'])));
	$facultycodes = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['facultycode'])));
	if($facultycodes==null) $facultycodes="";
	$departmentcodes = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['departmentcode'])));
	if($departmentcodes==null) $departmentcodes="";
	$programmecodes = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['programmecode'])));
	if($programmecodes==null) $programmecodes="";
	$studentlevels = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['studentlevel'])));
	if($studentlevels==null) $studentlevels="";
	$sesionss = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['sesions'])));
	if($sesionss==null) $sesionss="";
	$semesters = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['semester'])));
	if($semesters==null) $semesters="";
	$entryyears = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['entryyear'])));
	if($entryyears==null) $entryyears="";
	$regNumbers = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['regNumber'])));
	if($regNumbers==null) $regNumbers="";
	$actives = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['active'])));
	if($actives==null) $actives="Yes";
	$coursecodes = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['coursecode'])));
	if($coursecodes==null) $coursecodes="";
	$markdescriptions = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['markdescription'])));
	if($amendedtitles==null) $amendedtitles="";
	$amendedtitles = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['amendedtitle'])));
	if($markdescriptions==null) $markdescriptions="";
	$codeid = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['codeid'])));
	if($codeid==null) $codeid="";
	$codevalue = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['codevalue'])));
	if($codevalue==null) $codevalue="";
	$currentobject = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['currentobject'])));
	$phones = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['phone'])));
	$sms = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['sms'])));
	$senderids = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['senderid'])));
	$msgcount = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['msgcount'])));
	$passwords = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['password'])));
	include("data.php");

	function updateFinalMarks($sesion, $semester, $course, $regno, $level, $programme, $cstatus, $faculty, $department, $groupsession){
		$query = "SELECT * FROM examresultstable where sessiondescription='{$sesion}' and semester='{$semester}' and coursecode='{$course}' and registrationnumber='{$regno}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and studentlevel ='{$level}' and groupsession ='{$groupsession}' order by sessiondescription, semester, coursecode, registrationnumber";
		include("data.php"); 
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$obtained = 0.0;
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$obtained += (doubleval($marksobtained) * doubleval($percentage))/doubleval($marksobtainable);
			}
			//$obtained = number_format($obtained,2);

			$query = "select * from gradestable where {$obtained}>=lowerrange and {$obtained}<=upperrange";
			$result = mysql_query($query, $connection);
			$gcode="";
			$gunit="";
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$gcode=$row[1];
				$gunit=$row[4];
			}
			$query = "SELECT * FROM finalresultstable where sessiondescription='{$sesion}' and semester='{$semester}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and groupsession ='{$groupsession}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$query = "update finalresultstable set marksobtained='{$obtained}', gradecode='{$gcode}', gradeunit='{$gunit}', coursestatus='{$cstatus}' where sessiondescription='{$sesion}' and semester='{$semester}' and coursecode='{$course}' and registrationnumber='{$regno}' and studentlevel='{$level}' and programmecode='{$programme}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and groupsession ='{$groupsession}'";
			}else{
				$query = "insert into finalresultstable (sessiondescription, semester, coursecode, registrationnumber, marksobtained, gradecode, gradeunit, studentlevel, programmecode, coursestatus, facultycode, departmentcode, groupsession) values ('{$sesion}', '{$semester}', '{$course}', '{$regno}', '{$obtained}', '{$gcode}', '{$gunit}', '{$level}', '{$programme}', '{$cstatus}', '{$faculty}', '{$department}', '{$groupsession}')";
			}
			mysql_query($query, $connection);
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

	if($option == "onlineUpload"){
		$param = explode("][", $param);
		$sesions=$param[0];
		$semesters=$param[1];
		$tables = "finalresultstable][coursestable][registration][retakecourses][regularstudents][";
		$tables .= "cgpatable][schoolinformation][gradestable][qualificationstable][sessionstable";
		$tables = explode("][", $tables);
		for($j=0; $j<count($tables); $j++){
			$table=$tables[$j];
			$query = "SELECT * FROM {$table} ";
			if($table=="finalresultstable")	
				$query .= " where sessiondescription='{$sesions}' and semester='{$semesters}'";
			if($table=="coursestable")	
				$query .= " where sessiondescription='{$sesions}' and semesterdescription='{$semesters}'";
			if($table=="registration")	
				$query .= " where sessions='{$sesions}' and semester='{$semesters}'";
			if($table=="retakecourses")	
				$query .= " where sessiondescription='{$sesions}' and semester='{$semesters}'";
			if($table=="sessionstable")	
				$query .= " where sessiondescription='{$sesions}' and semesterdescription='{$semesters}'";
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
						$queryOnline = "INSERT INTO {$table} (serialno) VALUES ({$row[0]})";
						mysql_query($queryOnline, $connectionOnline);
					}
					$queryOnline = "UPDATE {$table} set ".$record." where serialno ={$row[0]}";
					mysql_query($queryOnline, $connectionOnline);
					include("data.php");
				}
			}
		}
		echo "onlineuploadsuccess";
	}

	if($option == "updateMatricNo"){
		$param = explode("][", $param);
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

			$query = "update examresultstable set registrationnumber='{$newregnumber}' where registrationnumber ='{$oldregnumber}' ";
			mysql_query($query, $connection);

			$query = "update finalresultstable set registrationnumber='{$newregnumber}' where registrationnumber ='{$oldregnumber}' ";
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
			echo "regupdated";
		}else{
			echo "regexists";
		}
	}

	if($option == "updateGeneral"){
		$queryG="";
		if(str_in_str($menuoption,"Selected")){
			$param=substr($param, 0, strlen($param)-2);
			$param = explode("][", $param);
			$regnolist="";
			foreach($param as $code) $regnolist.="'".$code."', ";
			$regnolist=substr($regnolist, 0, strlen($regnolist)-2);
			$queryG="select * from regularstudents WHERE regNumber IN (".$regnolist.")";
		}else{
			$queryG = "SELECT a.*, b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber and b.sessions='{$sesionss}'  and b.semester='{$semesters}' and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{entryyears}' and b.studentlevel='{$studentlevels}' order by a.regNumber";
		}
		$query="";
		if(str_in_str($codeid,"sesion")){
			$para = explode("!!!", $codeid);
			$thesesion = explode("][", $para[0]);
			$thesemester = explode("][", $para[1]);
			$thelevel = explode("][", $para[2]);
			$resultG = mysql_query($queryG, $connection);
			if(mysql_num_rows($resultG) > 0){
				while ($rowG = mysql_fetch_array($resultG)) {
					extract ($rowG);
					$regNumberG=$regNumber;
					if(str_in_str($menuoption,"Update")){
						$query = "SELECT * FROM registration where regNumber ='{$regNumberG}' and studentlevel ='{$thelevel[1]}' and sessions='{$thesesion[1]}' and semester='{$thesemester[1]}'";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result) == 0){
							$query = "INSERT INTO registration (regNumber, studentlevel, sessions, semester) VALUES ('{$regNumberG}', '{$thelevel[1]}', '{$thesesion[1]}', '{$thesemester[1]}')";
							mysql_query($query, $connection);
						}else{
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
						$query="select * from finalresultstable where registrationnumber ='{$regNumberG}' and  sessiondescription='{$thesesion[1]}' and semester='{$thesemester[1]}' and studentlevel ='{$thelevel[1]}' ";
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
				while ($rowG = mysql_fetch_array($resultG)) {
					extract ($rowG);
					$regNumberG=$regNumber;
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
					mysql_query($query, $connection);
				}
			}
		}
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

	if($option == "getAllRecs"  || $option=="getRecordlist"  || $option=="getARecord"){
		$query = "SELECT * FROM {$table} ";
		
		if($table=="regularstudents" && $option == "getAllRecs") {
			$query = "SELECT a.*, b.sessions, b.semester FROM regularstudents As a left JOIN registration AS b ON a.regNumber=b.regNumber";

			if($actives=="Yes/No"){
				$query .= " where a.active<>'' ";
			}else{
				$query .= " where a.active='{$actives}' ";
			}

			if($sesionss != "")
				$query .= " and b.sessions='{$sesionss}' "; 

			if($semesters != "")
				$query .= " and b.semester='{$semesters}' "; 

			if($entryyears != "")
				$query .= " and a.entryyear='{$entryyears}' "; 

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
			$query = "SELECT serialno, regNumber, concat(lastName,' ',firstName), userEmail, phoneno  FROM regularstudents where regNumber<>''";

			if($entryyears != "")
				$query .= " and entryyear='{$entryyears}' "; 

			if($facultycodes != ""){
				$query .= " and facultycode='{$facultycodes}' ";
			}

			if($departmentcodes != ""){
				$query .= " and departmentcode='{$departmentcodes}' ";
			}

			if($programmecodes != ""){
				$query .= " and programmecode='{$programmecodes}' "; 
			}
			/*if($serialnos=='A') {
				setcookie("firstentry", "1", false);
				$query .= " and a.regNumber='0' "; 
			}*/
			$query .= " order by facultycode, departmentcode, programmecode, regNumber, lastName, firstName";
		}

		if($table=="examresultstable" && $option == "getAllRecs") {
			$query = "SELECT coursecode FROM coursestable where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and groupsession='{$entryyears}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "coursenotsetup{$coursecodes}coursenotsetup{$facultycodes}coursenotsetup{$departmentcodes}coursenotsetup{$programmecodes}coursenotsetup{$studentlevels}coursenotsetup{$sesionss}coursenotsetup{$semesters}coursenotsetup{$entryyears}";
				return true;
			}
			$query = "SELECT a.*, b.* FROM regularstudents a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and a.regNumber=b.regNumber and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "studentnotsetup{$facultycodes}studentnotsetup{$departmentcodes}studentnotsetup{$programmecodes}studentnotsetup{$studentlevels}studentnotsetup{$sesionss}studentnotsetup{$semesters}studentnotsetup{$entryyears}";
				return true;
			}
			$query = "select distinct a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b where a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' and active='Yes' ";

			if($access=="") $access = "a.regNumber";
			$query .= " order by ".$access;

			if($_COOKIE['sortorder']=="DESC"){
				setcookie("sortorder", "ASC", false);
			}else{
				setcookie("sortorder", "DESC", false);
			}
			$query .= " ".$_COOKIE['sortorder'];
		}

		if($table=="amendedresults" && $option == "getAllRecs") {
			$query = "SELECT coursecode FROM coursestable where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and groupsession='{$entryyears}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "coursenotsetup{$coursecodes}coursenotsetup{$facultycodes}coursenotsetup{$departmentcodes}coursenotsetup{$programmecodes}coursenotsetup{$studentlevels}coursenotsetup{$sesionss}coursenotsetup{$semesters}coursenotsetup{$entryyears}";
				return true;
			}
			$query = "SELECT a.*, b.* FROM regularstudents a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and a.regNumber=b.regNumber and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "studentnotsetup{$facultycodes}studentnotsetup{$departmentcodes}studentnotsetup{$programmecodes}studentnotsetup{$studentlevels}studentnotsetup{$sesionss}studentnotsetup{$semesters}studentnotsetup{$entryyears}";
				return true;
			}
			$query = "select distinct a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b where a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' and active='Yes' ";

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
			$query = "SELECT a.*, b.* FROM regularstudents a, registration b where a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and a.regNumber=b.regNumber and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0) {
				echo "studentnotsetup{$facultycodes}studentnotsetup{$departmentcodes}studentnotsetup{$programmecodes}studentnotsetup{$studentlevels}studentnotsetup{$sesionss}studentnotsetup{$semesters}studentnotsetup{$entryyears}";
				return true;
			}
			$query = "select a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b  where  a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and a.active='Yes' and b.studentlevel='{$studentlevels}' and b.sessions='{$sesionss}' and b.semester='{$semesters}' ";

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
			$query .= " order by gradecode";
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
			$query .= " order by leveldescription";
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
			if(substr($currentobject, 0, 12)=="studentlevel")
				$query = "SELECT DISTINCT leveldescription, leveldescription FROM {$table} order by leveldescription";
			if(substr($currentobject, 0, 7)=="sesions" || substr($currentobject, 0, 8)=="sessions")
				$query = "SELECT DISTINCT sessiondescription, sessiondescription FROM {$table} order by sessiondescription DESC";
			if(substr($currentobject, 0, 8)=="semester" || substr($currentobject, 0, 9)=="semesters")
				$query = "SELECT DISTINCT semesterdescription, semesterdescription FROM {$table} order by semesterdescription";
			if(substr($currentobject, 0, 10)=="coursecode")
				$query = "SELECT DISTINCT coursecode, coursecode FROM {$table} where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and groupsession='{$entryyears}' order by coursecode";
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
				$query = "select DISTINCT a.serialno, a.regNumber, a.lastName, a.firstName, a.middleName, a.active from regularstudents a, registration b  where  a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and a.active='Yes' and b.studentlevel='{$studentlevels}' order by a.regNumber, a.lastName ";
			if($table=="regularstudents" && substr($currentobject, 0, 8)=="students"){
				$query = "select DISTINCT a.serialno, a.regNumber, a.firstName, a.lastName from regularstudents a, registration b  where  a.regNumber=b.regNumber";
				if($facultycodes != "")
					$query .= " and a.facultycode='{$facultycodes}' ";
				if($departmentcodes != "")
					$query .= " and a.departmentcode='{$departmentcodes}' ";
				if($programmecodes != "")
					$query .= " and a.programmecode='{$programmecodes}' "; 
				if($studentlevels != "")
					$query .= " and b.studentlevel='{$studentlevels}' "; 
				if($entryyears != "")
					$query .= " and a.entryyear='{$entryyears}' "; 
				if($regNumbers != "")
					$query .= " and a.regNumber='{$regNumbers}' "; 
				if($actives != "")
					$query .= " and a.active='{$actives}' ";
				$query .= " order by a.regNumber, a.lastName ";
				//$query = "select DISTINCT a.serialno, a.regNumber, a.firstName, a.lastName from regularstudents a, registration b  where  a.regNumber=b.regNumber and a.facultycode='{$facultycodes}' and a.departmentcode='{$departmentcodes}' and a.programmecode='{$programmecodes}' and a.entryyear='{$entryyears}' and a.active='{$actives}' and b.studentlevel='{$studentlevels}' order by a.regNumber, a.lastName ";
			}
			if(substr($currentobject, 0, 9)=="entryyear")
			//	$query = "SELECT DISTINCT entryyear, entryyear FROM {$table} order by entryyear";
				$query = "SELECT DISTINCT sessiondescription, sessiondescription FROM {$table} order by sessiondescription";
		}

		$flag=1;
		if($option == "getARecord"){
			$query = "SELECT * FROM {$table} where serialno='{$serialnos}' ";
			if($table=="amendedreasons"){
				$query = "SELECT  amendreason, amendedtitle FROM {$table} where sessiondescription ='{$sesionss}' and semester ='{$semesters}' and coursecode ='{$coursecodes}' and facultycode ='{$facultycodes}' and departmentcode ='{$departmentcodes}' and programmecode ='{$programmecodes}' and studentlevel ='{$studentlevels}' and groupsession ='{$entryyears}' and amendedtitle='{$amendedtitles}'";
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
					$query3 = "SELECT b.* FROM examresultstable b where b.registrationnumber='{$row[0]}' ";
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
					if($entryyears != "")
						$query3 .= " and b.groupsession='{$entryyears}' "; 
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
					if($entryyears != "")
						$query3a .= " and b.groupsession='{$entryyears}' "; 
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
						$query3a = "SELECT max(amendedtitle) as previoustitles FROM {$table} where sessiondescription ='{$sesionss}' and semester ='{$semesters}' and coursecode ='{$coursecodes}' and registrationnumber ='{$row[0]}' and marksdescription ='{$markdescriptions}' and facultycode ='{$facultycodes}' and departmentcode ='{$departmentcodes}' and programmecode ='{$programmecodes}' and studentlevel ='{$studentlevels}' and groupsession ='{$entryyears}' and amendedtitle<'{$amendedtitles}'";
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
						if($entryyears != "")
							$query3a .= " and b.groupsession='{$entryyears}' "; 
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

							$query3b = "SELECT b.* FROM examresultstable b where b.registrationnumber='{$row[0]}' ";
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
							if($entryyears != "")
								$query3b .= " and b.groupsession='{$entryyears}' "; 
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
					//$meta = mysql_fetch_field($result, $i);
					//if($meta->name == 'serialno' && $value == null) break;
					if ($option=="getAllRecs" || $option=="getRecordlist") {
						$resp .= $value."!!!";
					} else {
						$resp .= "getARecord" . $value;
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
				
					if($entryyears != "")
						$query3 .= " and b.groupsession='{$entryyears}' "; 

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
				}
				if ($option=="getAllRecs" || $option=="getRecordlist") $resp .= $option;
			}
		}else{
			if($table=="admissiontype"){
				$resp = "DE!!!DE!!!" . $option . "UME!!!UME!!!" . $option;
			}
		}
		if($option=="getRecordlist" && substr($currentobject, 0, 9)=="resultype")
			$resp = "Normal Results!!!Normal Results!!!" . $option . "Supplemenrary Results!!!Supplemenrary Results!!!" . $option . $resp;
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
						$resp .= $row[2]."~_~".$row[3]."~_~".$row[4]."!!!";
					}
					$resp .= $option;
				}
			}
		}
		echo $resp;
		//if ($option=="getAllRecs") echo $query;
		//if ($option=="getRecordlist") echo $query;
    }

	if($option == "addRecord"){
		$parameters = explode("][", $param);
		if($table=="signatoriestable") 
			$query = "SELECT * FROM {$table} where signatoryposition ='{$parameters[1]}'";
		if($table=="regularstudents"){
			$faculty = checkCode("facultiestable","facultydescription",$parameters[4]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[4]."notinsetupFaculty";
				return true;
			}
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[5]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[5]."notinsetupDepertment";
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
			$sessions = checkCode("sessionstable","sessiondescription",$parameter2[2]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameter2[2]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameter2[3]);
			if($semester=="notinsetup"){
				echo $semester.$parameter2[3]."notinsetupSessions";
				return true;
			}
		}
		if($table=="examresultstable"){
			$parameters = explode("][", $param);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[12]."notinsetupDepertment";
				return true;
			}
			$sessions = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semester=="notinsetup"){
				echo $semester.$parameters[2]."notinsetupSessions";
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

		if($table=="amendedresults"){
			$parameters = explode("][", $param);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[12]."notinsetupDepertment";
				return true;
			}
			$sessions = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semester=="notinsetup"){
				echo $semester.$parameters[2]."notinsetupSessions";
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
			$faculty = checkCode("facultiestable","facultydescription",$parameters[5]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[5]."notinsetupFaculty";
				return true;
			}
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[6]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[6]."notinsetupDepertment";
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
			$sessions = checkCode("sessionstable","sessiondescription",$parameters[2]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameters[2]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameters[3]);
			if($semester=="notinsetup"){
				echo $semester.$parameters[3]."notinsetupSessions";
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
		$parameters3 = explode("][", $param2);
		if($table=="regularstudents"){
			$query = "SELECT * FROM {$table} where regNumber ='{$parameters[1]}'";
		}
		if($table=="examresultstable"){
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
		}
		if($table=="amendedresults"){
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}' and amendedtitle ='{$parameters3[8]}'";
		}
		if($table=="specialfeatures"){
			$query = "SELECT * FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' and groupsession ='{$parameters[9]}' ";
		}
		if($table=="retakecourses"){
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}'  and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
		}
		
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) == 0){
			$query = "select max(serialno) as id from {$table}";
			$result = mysql_query($query, $connection);
			$row = mysql_fetch_array($result);
			extract ($row);
			$serialnos = intval($id)+1;

			$query = "INSERT INTO {$table} (serialno) VALUES ('{$serialnos}')";
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

				$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
				if($table=="retakecourses")
					$query = "UPDATE {$table}  set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', coursestatus = '{$param2}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}',  programmecode = '{$parameters[10]}',  studentlevel = '{$parameters[9]}', groupsession = '{$parameters[13]}' where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);

				if($table=="examresultstable"){
					updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[13]);
					$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
					mysql_query($query, $connection);
				}

				if($table=="amendedresults"){
					$parameters3 = explode("][", $param2);

					$previousmarks=$parameters[15];
					$amendedmarks=$parameters[16];

					$amendedgradecodes="";
					$amendedgradeunits=0;
					$amendedtitles=$parameters3[8];

					$previousgradecodes="";
					$previousgradeunits=0;
					$query = "SELECT max(amendedtitle) as previoustitles FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}' and amendedtitle<'{$amendedtitles}'";
					$result = mysql_query($query, $connection);
					extract (mysql_fetch_array($result));
					if($previoustitles==null) $previoustitles="";

					$query = "select * from gradestable where {$amendedmarks}>=lowerrange and {$amendedmarks}<=upperrange";
					$result = mysql_query($query, $connection);
					$gcode="";
					$gunit="";
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						$amendedgradecodes=$row[1];
						$amendedgradeunits=$row[4];
					}

					$query = "select * from gradestable where {$previousmarks}>=lowerrange and {$previousmarks}<=upperrange";
					$result = mysql_query($query, $connection);
					$gcode="";
					$gunit="";
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						$previousgradecodes=$row[1];
						$previousgradeunits=$row[4];
					}

					$query = "update {$table} set amendedgradecode='{$amendedgradecodes}', amendedgradeunit={$amendedgradeunits}, amendedtitle='{$amendedtitles}', previousgradecode='{$previousgradecodes}', previousgradeunit={$previousgradeunits}, previoustitle='{$previoustitles}' where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}' and serialno ='{$serialnos}' ";
					$result = mysql_query($query, $connection);

					$query = "SELECT * FROM amendedreasons where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and groupsession ='{$parameters3[3]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) == 0){
						$query = "insert into amendedreasons (amendreason, facultycode, departmentcode, programmecode, groupsession, studentlevel, sessiondescription, semester, coursecode, amendedtitle) values ('{$parameters3[9]}', '{$parameters3[0]}', '{$parameters3[1]}', '{$parameters3[2]}', '{$parameters3[3]}', '{$parameters3[4]}', '{$parameters3[5]}', '{$parameters3[6]}', '{$parameters3[7]}', '{$parameters3[8]}') ";
					}else{
						$query = "update amendedreasons set amendreason='{$parameters3[9]}' where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and groupsession ='{$parameters3[3]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
					}
					mysql_query($query, $connection);

					$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
					mysql_query($query, $connection);
				}

				if($table=="retakecourses" && $param2=="Absent"){
					//$parameter2 = explode("][", $param2);
					$query = "SELECT * FROM examresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) == 0){
						$query = "INSERT INTO examresultstable (sessiondescription, semester, coursecode, registrationnumber, marksdescription, marksobtained, marksobtainable, percentage, studentlevel, programmecode, facultycode, departmentcode, groupsession) VALUES ('{$parameters[1]}', '{$parameters[2]}', '{$parameters[3]}', '{$parameters[4]}', '{$parameters[5]}', '{$parameters[6]}', '{$parameters[7]}', '{$parameters[8]}', '{$parameters[9]}', '{$parameters[10]}', '{$parameters[11]}', '{$parameters[12]}', '{$parameters[13]}')";
						$result = mysql_query($query, $connection);
					}else{
						while ($row = mysql_fetch_row($result)) {
							extract ($row);
							$serialnos = $serialno;
						}
						$query = "update examresultstable set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', marksdescription = '{$parameters[5]}', marksobtained = '{$parameters[6]}', marksobtainable = '{$parameters[7]}', percentage = '{$parameters[8]}', studentlevel = '{$parameters[9]}',  programmecode = '{$parameters[10]}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}', groupsession = '{$parameters[13]}' where serialno ='{$serialnos}'";
						$result = mysql_query($query, $connection);
					}
					updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[13]);
				}

				if($table=="regularstudents"){
					$parameter2 = explode("][", $param2);
					$query = "SELECT * FROM registration where regNumber ='{$parameter2[0]}' and studentlevel  ='{$parameter2[1]}' and sessions ='{$parameter2[2]}' and semester ='{$parameter2[3]}'";
					$result = mysql_query($query, $connection);
					if(mysql_num_rows($result) == 0){
						$query = "INSERT INTO registration (regNumber, studentlevel, sessions, semester) VALUES ('{$parameter2[0]}', '{$parameter2[1]}', '{$parameter2[2]}', '{$parameter2[3]}')";
						$result = mysql_query($query, $connection);
					}
				}
			}

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
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[5]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[5]."notinsetupDepertment";
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
			$sessions = checkCode("sessionstable","sessiondescription",$parameter2[2]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameter2[2]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameter2[3]);
			if($semester=="notinsetup"){
				echo $semester.$parameter2[3]."notinsetupSessions";
				return true;
			}
		}
		if($table=="examresultstable"){
			$parameters = explode("][", $param);
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[12]."notinsetupDepertment";
				return true;
			}
			$sessions = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semester=="notinsetup"){
				echo $semester.$parameters[2]."notinsetupSessions";
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
			$faculty = checkCode("facultiestable","facultydescription",$parameters[11]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[11]."notinsetupFaculty";
				return true;
			}
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[12]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[12]."notinsetupDepertment";
				return true;
			}
			$sessions = checkCode("sessionstable","sessiondescription",$parameters[1]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameters[1]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameters[2]);
			if($semester=="notinsetup"){
				echo $semester.$parameters[2]."notinsetupSessions";
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
			$faculty = checkCode("facultiestable","facultydescription",$parameters[5]);
			if($faculty=="notinsetup"){
				echo $faculty.$parameters[5]."notinsetupFaculty";
				return true;
			}
			$depertment = checkCode("departmentstable","departmentdescription",$parameters[6]);
			if($depertment=="notinsetup"){
				echo $depertment.$parameters[6]."notinsetupDepertment";
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
			$sessions = checkCode("sessionstable","sessiondescription",$parameters[2]);
			if($sessions=="notinsetup"){
				echo $sessions.$parameters[2]."notinsetupSessions";
				return true;
			}
			$semester = checkCode("sessionstable","semesterdescription",$parameters[3]);
			if($semester=="notinsetup"){
				echo $semester.$parameters[3]."notinsetupSessions";
				return true;
			}
		}

		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		if($table=="examresultstable") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";

		if($table=="amendedresults") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";

		if($table=="specialfeatures") 
			$query = "SELECT * FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' and groupsession ='{$parameters[9]}'";

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

			$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
			if($table=="retakecourses")
				$query = "UPDATE {$table}  set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', coursestatus = '{$param2}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}',  programmecode = '{$parameters[10]}',  studentlevel = '{$parameters[9]}', groupsession = '{$parameters[13]}' where serialno ='{$serialnos}'";

			if($table=="examresultstable")
				$query = "UPDATE {$table} set ".$record." where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";

			if($table=="amendedresults"){
				//$query = "update examresultstable set marksobtained='{$parameters[16]}' where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				//mysql_query($query, $connection);

				$query = "UPDATE {$table} set ".$record." where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}' and serialno='{$serialnos}'";
			}
			if($table=="specialfeatures") 
				$query = "UPDATE {$table} set feature = '{$parameters[4]}' where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' and groupsession ='{$parameters[9]}' ";

			$result = mysql_query($query, $connection);

			if($table=="retakecourses" && $param2=="Absent"){
				$query = "SELECT * FROM examresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 0){
					$query = "INSERT INTO examresultstable (sessiondescription, semester, coursecode, registrationnumber, marksdescription, marksobtained, marksobtainable, percentage, studentlevel, programmecode, facultycode, departmentcode, groupsession) VALUES ('{$parameters[1]}', '{$parameters[2]}', '{$parameters[3]}', '{$parameters[4]}', '{$parameters[5]}', '{$parameters[6]}', '{$parameters[7]}', '{$parameters[8]}', '{$parameters[9]}', '{$parameters[10]}', '{$parameters[11]}', '{$parameters[12]}', '{$parameters[13]}')";
					$result = mysql_query($query, $connection);
				}else{
					while ($row = mysql_fetch_row($result)) {
						extract ($row);
						$serialnos = $serialno;
					}
					$query = "update examresultstable set sessiondescription = '{$parameters[1]}', semester = '{$parameters[2]}', coursecode = '{$parameters[3]}', registrationnumber = '{$parameters[4]}', marksdescription = '{$parameters[5]}', marksobtained = '{$parameters[6]}', marksobtainable = '{$parameters[7]}', percentage = '{$parameters[8]}', studentlevel = '{$parameters[9]}',  programmecode = '{$parameters[10]}', facultycode = '{$parameters[11]}', departmentcode = '{$parameters[12]}', groupsession = '{$parameters[13]}' where serialno ='{$serialnos}'";
					$result = mysql_query($query, $connection);
				}
				updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[13]);
			}

			if($table=="examresultstable"){
				updateFinalMarks($parameters[1], $parameters[2], $parameters[3], $parameters[4], $parameters[9], $parameters[10], $param2, $parameters[11], $parameters[12], $parameters[13]);
				$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				mysql_query($query, $connection);
			}

			if($table=="amendedresults"){
				$parameters3 = explode("][", $param2);

				$previousmarks=$parameters[15];
				$amendedmarks=$parameters[16];

				$amendedgradecodes="";
				$amendedgradeunits=0;
				$amendedtitles=$parameters3[8];

				$previousgradecodes="";
				$previousgradeunits=0;
				$query = "SELECT max(amendedtitle) as previoustitles FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}' and amendedtitle<'{$amendedtitles}'";
				$result = mysql_query($query, $connection);
				extract (mysql_fetch_array($result));
				if($previoustitles==null) $previoustitles="";

				$query = "select * from gradestable where {$amendedmarks}>=lowerrange and {$amendedmarks}<=upperrange";
				$result = mysql_query($query, $connection);
				$gcode="";
				$gunit="";
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$amendedgradecodes=$row[1];
					$amendedgradeunits=$row[4];
				}

				$query = "select * from gradestable where {$previousmarks}>=lowerrange and {$previousmarks}<=upperrange";
				$result = mysql_query($query, $connection);
				$gcode="";
				$gunit="";
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					$previousgradecodes=$row[1];
					$previousgradeunits=$row[4];
				}

				$query = "update {$table} set amendedgradecode='{$amendedgradecodes}', amendedgradeunit={$amendedgradeunits}, amendedtitle='{$amendedtitles}', previousgradecode='{$previousgradecodes}', previousgradeunit={$previousgradeunits}, previoustitle='{$previoustitles}' where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}' and serialno='{$serialnos}'";
				$result = mysql_query($query, $connection);

				$query = "SELECT * FROM amendedreasons where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and groupsession ='{$parameters3[3]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 0){
					$query = "insert into amendedreasons (amendreason, facultycode, departmentcode, programmecode, groupsession, studentlevel, sessiondescription, semester, coursecode, amendedtitle) values ('{$parameters3[9]}', '{$parameters3[0]}', '{$parameters3[1]}', '{$parameters3[2]}', '{$parameters3[3]}', '{$parameters3[4]}', '{$parameters3[5]}', '{$parameters3[6]}', '{$parameters3[7]}', '{$parameters3[8]}') ";
				}else{
					$query = "update amendedreasons set amendreason='{$parameters3[9]}' where facultycode ='{$parameters3[0]}' and departmentcode ='{$parameters3[1]}' and programmecode ='{$parameters3[2]}' and groupsession ='{$parameters3[3]}' and studentlevel ='{$parameters3[4]}' and sessiondescription ='{$parameters3[5]}' and semester ='{$parameters3[6]}' and coursecode ='{$parameters3[7]}' and amendedtitle ='{$parameters3[8]}' ";
				}
				mysql_query($query, $connection);

				$query = "DELETE FROM retakecourses where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				mysql_query($query, $connection);
			}

			if($table=="regularstudents"){
				$parameter2 = explode("][", $param2);
				$query = "SELECT * FROM registration where regNumber = '{$parameter2[0]}' and studentlevel  = '{$parameter2[1]}' and sessions = '{$parameter2[2]}' and semester = '{$parameter2[3]}'";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) == 0){
					$query = "INSERT INTO registration (regNumber, studentlevel, sessions, semester) VALUES ('{$parameter2[0]}', '{$parameter2[1]}', '{$parameter2[2]}', '{$parameter2[3]}')";
					$result = mysql_query($query, $connection);
				}
			}

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
		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";

		if($table=="examresultstable") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";

		if($table=="amendedresults") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";

		if($table=="specialfeatures") 
			$query = "SELECT * FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' and groupsession ='{$parameters[9]}' ";

		if($table=="retakecourses") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$query = "DELETE FROM {$table} where serialno ='{$serialnos}'";
				
			if($table=="examresultstable") {
				$query = "DELETE FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				mysql_query($query, $connection);
				$query = "DELETE FROM finalresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
			}

			if($table=="amendedresults") {
				$query = "DELETE FROM {$table} where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				mysql_query($query, $connection);
			}

			if($table=="specialfeatures") {
				$query = "DELETE FROM {$table} where registrationnumber ='{$parameters[1]}' and sessiondescription ='{$parameters[2]}' and semester ='{$parameters[3]}' and facultycode ='{$parameters[5]}' and departmentcode ='{$parameters[6]}' and programmecode ='{$parameters[7]}' and studentlevel ='{$parameters[8]}' and groupsession ='{$parameters[9]}' ";
			}

			if($table=="retakecourses") {
				$query = "DELETE FROM {$table} where sessiondescription='{$parameters[1]}' and semester='{$parameters[2]}' and coursecode='{$parameters[3]}' and registrationnumber='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				mysql_query($query, $connection);
				$query = "DELETE FROM examresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and marksdescription ='{$parameters[5]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
				mysql_query($query, $connection);
				$query = "DELETE FROM finalresultstable where sessiondescription ='{$parameters[1]}' and semester ='{$parameters[2]}' and coursecode ='{$parameters[3]}' and registrationnumber ='{$parameters[4]}' and facultycode ='{$parameters[11]}' and departmentcode ='{$parameters[12]}' and programmecode ='{$parameters[10]}' and studentlevel ='{$parameters[9]}' and groupsession ='{$parameters[13]}'";
			}

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
