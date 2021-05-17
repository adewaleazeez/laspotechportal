<?php
	$option = str_replace("'", "`", trim($_GET['option']));
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
	$maximumunits = str_replace("'", "`", trim($_GET['maximumunit']));
	if($maximumunits==null) $maximumunits="";
	$qualifications = str_replace("'", "`", trim($_GET['qualification']));
	if($qualifications==null) $qualifications="";
	$userNames = str_replace("'", "`", trim($_GET['userName'])); 
	$serialnos = str_replace("'", "`", trim($_GET['serialno']));
	$accesss = str_replace("'", "`", trim($_GET['access']));
	$pages = str_replace("'", "`", trim($_GET['page']));
	$menus = str_replace("'", "`", trim($_GET['menu']));
	$actives = str_replace("'", "`", trim($_GET['active']));
	$currentusers = str_replace("'", "`", trim($_GET['currentuser']));
	if($currentusers==null || $currentusers=="") $currentusers = $_COOKIE['currentuser'];
	$menuoption = str_replace("'", "`", trim($_GET['menuoption']));
	$access = str_replace("'", "`", trim($_GET['access']));
	$param = str_replace("'", "`", trim($_GET['param']));
	$param2 = str_replace("'", "`", trim($_GET['param2']));
	$table = str_replace("'", "`", trim($_GET['table']));
	$currentobject = str_replace("'", "`", trim($_GET['currentobject']));
	include("data.php");

	/*if($option == "checkAccess"){
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
	}*/
	
	if($option == "checkAccess"){
		$query = "SELECT * FROM usersmenu where userName = '{$currentusers}' and menuOption = '{$menuoption}'";
		$result = mysql_query($query, $connection);
		$resp="checkAccess";
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);

			if($accessible == "Yes"){
				$resp="checkAccessSuccess";
			}else{
				$resp="checkAccessFailed".$menuoption;
			}
		}else{
			$resp="checkAccessFailed".$menuoption;
		}
		echo $resp;
	}

	if($option == "updateLocks"){
		$currentuser = $currentusers;
		$query="select * from usersmenu  where userName='{$currentuser}' and menuOption='Lock Records'";
		$result=mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);
			$accessible=$row[3];
			if($accessible=='No'){
				echo "locknotallowedLock Matches Records";
				return true;
			}
		}
		$parameter = explode("][", $param);
		for($count=0; $count<count($parameter); $count++)	$parameter[$count]=trim($parameter[$count]);
		$serialno=$parameter[0];
		$serialno=$parameter[1];
		$facultycodes = $parameter[2];
		$departmentcodes = $parameter[3];
		$programmecodes = $parameter[4];
		$studentlevels = $parameter[5];
		$sesionss = $parameter[6];
		$semesters = $parameter[7];
		$coursecodes = $parameter[8];
		$query = "update coursestable set recordlock='{$parameter[1]}'  where serialno={$parameter[0]} ";
		mysql_query($query, $connection);

		$usernames = $_COOKIE['currentuser'];
		if($parameter[1]=="1"){
			$activitydescriptions = $usernames." locked courses table for Course Code: ".$coursecodes.", Department: ".$departmentcodes.", Programme: ".$programmecodes.", Session: ".$sesionss.", Semester: ".$semesters;
		}else{
			$activitydescriptions = $usernames." unlocked courses table for Course Code: ".$coursecodes.", Department: ".$departmentcodes.", Programme: ".$programmecodes.", Session: ".$sesionss.", Semester: ".$semesters;
		}
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$option="getAllRecs"; 
		$table="coursestableC";
	}

	if($option == "lockrecords"){
		$param2=substr($param2, 0, strlen($param2)-3);
		$parameter1 = explode("][", $param);
		for($count=0; $count<count($parameter1); $count++)	$parameter1[$count]=trim($parameter1[$count]);
		$parameter2 = explode("_~_", $param2);
		for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);
		$courselist="";
		foreach($parameter2 as $code){
			$parameter3 = explode("!!!", $code);
			for($count=0; $count<count($parameter3); $count++)	$parameter3[$count]=trim($parameter3[$count]);
			
			$query = "SELECT * FROM coursestable where coursecode = '{$parameter3[0]}' and facultycode='{$parameter1[0]}' and departmentcode='{$parameter1[1]}' and programmecode='{$parameter1[2]}' and studentlevel='{$parameter1[3]}' and sessiondescription='{$parameter1[4]}' and semesterdescription='{$parameter1[5]}' ";
			//and groupsession='{$parameter1[6]}'
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 1){
				$query="update coursestable set recordlock='{$parameter3[1]}' where coursecode = '{$parameter3[0]}' and facultycode='{$parameter1[0]}' and departmentcode='{$parameter1[1]}' and programmecode='{$parameter1[2]}' and studentlevel='{$parameter1[3]}' and sessiondescription='{$parameter1[4]}' and semesterdescription='{$parameter1[5]}' ";
				mysql_query($query, $connection);
				$lockststus=(($parameter3[1]=="1") ? "Locked" : "Unlocked");
				$courselist.="[".$parameter3[0].": ".$lockststus."] ";
			}
		}
		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." locked/unlocked courses table for Department: ".$parameter1[1].", Programme: ".$parameter1[2].", Level: ".$parameter1[3].", Session: ".$parameter1[4].", Semester: ".$parameter1[5].", Course List: ".$courselist;
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$option="getAllRecs"; 
		$table="coursestableC";
		$facultycodes=$parameter1[0];
		$departmentcodes=$parameter1[1];
		$programmecodes=$parameter1[2];
		$studentlevels=$parameter1[3];
		$sesionss=$parameter1[4];
		$semesters=$parameter1[5];
	}

	if($option == "checkCourseLock"){
		$parameter = explode("][", $param);
		$query = "select * FROM coursestable where serialno<>0 and coursecode = '{$parameter[0]}' and facultycode='{$parameter[1]}' and departmentcode='{$parameter[2]}' and programmecode='{$parameter[3]}' and studentlevel='{$parameter[4]}' and sessiondescription='{$parameter[5]}' and semesterdescription='{$parameter[6]}' and recordlock='1' "; 
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			echo "recordlocked for $parameter[0] in $parameter[5] $parameter[6] semester";
			return true;
		}
		echo "editCourseCode";
	}

	if($option == "updateCodeChange"){
		$parameter = explode("][", $param);

		$query="select *from coursestable where coursecode = '{$parameter[0]}' and facultycode='{$parameter[2]}' and departmentcode='{$parameter[3]}' and programmecode='{$parameter[4]}' and studentlevel='{$parameter[5]}' and sessiondescription='{$parameter[6]}' and semesterdescription='{$parameter[7]}' ";
		$result=mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			echo "coursecode_exists";
			return true;
		}

		$query="update amendedreasons set coursecode='{$parameter[0]}' where coursecode = '{$parameter[1]}' and facultycode='{$parameter[2]}' and departmentcode='{$parameter[3]}' and programmecode='{$parameter[4]}' and studentlevel='{$parameter[5]}' and sessiondescription='{$parameter[6]}' and semester='{$parameter[7]}' ";
		mysql_query($query, $connection);

		$query="update amendedresults set coursecode='{$parameter[0]}' where coursecode = '{$parameter[1]}' and facultycode='{$parameter[2]}' and departmentcode='{$parameter[3]}' and programmecode='{$parameter[4]}' and studentlevel='{$parameter[5]}' and sessiondescription='{$parameter[6]}' and semester='{$parameter[7]}' ";
		mysql_query($query, $connection);

		$query="update coursesform set coursecode='{$parameter[0]}' where coursecode = '{$parameter[1]}' and sessioncode='{$parameter[6]}' and semester='{$parameter[7]}' ";
		mysql_query($query, $connection);

		$query="update coursestable set coursecode='{$parameter[0]}' where coursecode = '{$parameter[1]}' and facultycode='{$parameter[2]}' and departmentcode='{$parameter[3]}' and programmecode='{$parameter[4]}' and studentlevel='{$parameter[5]}' and sessiondescription='{$parameter[6]}' and semesterdescription='{$parameter[7]}' ";
		mysql_query($query, $connection);

		$query="update examresultstable set coursecode='{$parameter[0]}' where coursecode = '{$parameter[1]}' and facultycode='{$parameter[2]}' and departmentcode='{$parameter[3]}' and programmecode='{$parameter[4]}' and studentlevel='{$parameter[5]}' and sessiondescription='{$parameter[6]}' and semester='{$parameter[7]}' ";
		mysql_query($query, $connection);

		$query="update finalresultstable set coursecode='{$parameter[0]}' where coursecode = '{$parameter[1]}' and facultycode='{$parameter[2]}' and departmentcode='{$parameter[3]}' and programmecode='{$parameter[4]}' and studentlevel='{$parameter[5]}' and sessiondescription='{$parameter[6]}' and semester='{$parameter[7]}' ";
		mysql_query($query, $connection);

		$query="update retakecourses set coursecode='{$parameter[0]}' where coursecode = '{$parameter[1]}' and facultycode='{$parameter[2]}' and departmentcode='{$parameter[3]}' and programmecode='{$parameter[4]}' and studentlevel='{$parameter[5]}' ";
		mysql_query($query, $connection);

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." globally changed course code from ".$parameter[1]." to ".$parameter[0]." for Departmentcode: $parameter[3], Programmecode: $parameter[4], Level: $parameter[5], Session: $parameter[6], Semester: $parameter[7]";
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$option="getAllRecs"; $table="coursestable";
		$facultycodes=$parameter[2];
		$departmentcodes=$parameter[3];
		$programmecodes=$parameter[4];
		$studentlevels=$parameter[5];
		$sesionss=$parameter[6];
		$semesters=$parameter[7];
	}

	if($option == "copyCourses"){
		$param2=substr($param2, 0, strlen($param2)-3);
		$parameter1 = explode("][", $param);
		for($count=0; $count<count($parameter1); $count++)	$parameter1[$count]=trim($parameter1[$count]);

		$parameter2 = explode("_~_", $param2);
		for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);

		$coursecodes="";
		foreach($parameter2 as $code){
			$parameter3 = explode("!!!", $code);
			$coursecodes.=$parameter3[0].", ";
			for($count=0; $count<count($parameter3); $count++)	$parameter3[$count]=trim($parameter3[$count]);
			
			$query = "SELECT * FROM coursestable where coursecode = '{$parameter3[0]}' and facultycode='{$parameter1[0]}' and departmentcode='{$parameter1[1]}' and programmecode='{$parameter1[2]}' and studentlevel='{$parameter1[3]}' and sessiondescription='{$parameter1[4]}' and semesterdescription='{$parameter1[5]}' ";
			//and groupsession='{$parameter1[6]}'
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query="insert into coursestable (coursecode,coursedescription,courseunit,coursetype,minimumscore,facultycode,departmentcode,programmecode,studentlevel,sessiondescription,semesterdescription,groupsession,lecturerid,studentype) values ('{$parameter3[0]}','{$parameter3[1]}',{$parameter3[2]},'{$parameter3[3]}',{$parameter3[4]},'{$parameter1[0]}','{$parameter1[1]}','{$parameter1[2]}','{$parameter1[3]}','{$parameter1[4]}','{$parameter1[5]}','{$parameter1[6]}','','{$parameter1[14]}')";
				mysql_query($query, $connection);
			}
		}

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." inserted into courses table, course codes from ".$coursecodes." for Departmentcode: $parameter1[1], Programmecode: $parameter1[2], Level: $parameter1[3], Session: $parameter1[4], Semester: $parameter1[5]";
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$option="getAllRecs"; $table="coursestable";
		$facultycodes=$parameter1[0];
		$departmentcodes=$parameter1[1];
		$programmecodes=$parameter1[2];
		$studentlevels=$parameter1[3];
		$sesionss=$parameter1[4];
		$semesters=$parameter1[5];
		$entryyears=$parameter1[6];
	}

	if($option == "copyGrades"){
		$param2=substr($param2, 0, strlen($param2)-3);
		$parameter1 = explode("][", $param);
		for($count=0; $count<count($parameter1); $count++)	$parameter1[$count]=trim($parameter1[$count]);

		$parameter2 = explode("_~_", $param2);
		for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);

		$gradecodes="";
		foreach($parameter2 as $code){
			$parameter3 = explode("!!!", $code);
			$gradecodes.=$parameter3[0].", ";
			for($count=0; $count<count($parameter3); $count++)	$parameter3[$count]=trim($parameter3[$count]);

			$query = "SELECT * FROM gradestable where qualification = '{$parameter1[0]}' and sessions='{$parameter1[1]}' and gradecode='{$parameter3[0]}'  order by lowerrange DESC ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query="insert into gradestable (gradecode, lowerrange, upperrange, gradeunit, qualification, sessions) values ('{$parameter3[0]}','{$parameter3[1]}',{$parameter3[2]},'{$parameter3[3]}','{$parameter1[0]}','{$parameter1[1]}')";
				mysql_query($query, $connection);
			}
		}

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." inserted into grades table, grade codes from ".$gradecodes." for Qualification: $parameter1[0], Session: $parameter1[1] ";
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$option="getAllRecs"; $table="gradestable";
		$qualifications=$parameter1[0];
		$sesionss=$parameter1[1];
	}

	if($option == "copyCgpas"){
		$param2=substr($param2, 0, strlen($param2)-3);
		$parameter1 = explode("][", $param);
		for($count=0; $count<count($parameter1); $count++)	$parameter1[$count]=trim($parameter1[$count]);

		$parameter2 = explode("_~_", $param2);
		for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);

		$cgpacodes.="";
		foreach($parameter2 as $code){
			$parameter3 = explode("!!!", $code);
			$cgpacodes.=$parameter3[0].", ";
			for($count=0; $count<count($parameter3); $count++)	$parameter3[$count]=trim($parameter3[$count]);

			$query = "SELECT * FROM cgpatable where qualification = '{$parameter1[0]}' and sessions='{$parameter1[1]}' and cgpacode='{$parameter3[0]}' order by lowerrange DESC ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query="insert into cgpatable (cgpacode, lowerrange, upperrange, qualification, sessions) values ('{$parameter3[0]}','{$parameter3[1]}',{$parameter3[2]},'{$parameter1[0]}','{$parameter1[1]}')";
				mysql_query($query, $connection);
			}
		}

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." inserted into classes of diplomas table, cgpa codes from ".$cgpacodes." for Qualification: $parameter1[0], Session: $parameter1[1] ";
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);

		$option="getAllRecs"; $table="cgpatable";
		$qualifications=$parameter1[0];
		$sesionss=$parameter1[1];
	}

	if($option == "doMaxUnit"){
		$query = "SELECT * FROM unitstable  where maximumunit<>0 ";

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

		$result = mysql_query($query, $connection);
		
		if($access=="get") {
			if(mysql_num_rows($result) > 0){
				$row = mysql_fetch_array($result);
				extract ($row);
				$maximumunit=$row[7];
				echo "showMaxUnit".$maximumunit;
				return true;
			}
		}
		if($access=="add"){
			if(mysql_num_rows($result) == 0){
				$query="insert into unitstable (facultycode, departmentcode, programmecode, studentlevel, sessiondescription, semesterdescription, maximumunit) values ('{$facultycodes}','{$departmentcodes}','{$programmecodes}','{$studentlevels}','{$sesionss}','{$semesters}','{$maximumunits}')";
				mysql_query($query, $connection);

				$usernames = $_COOKIE['currentuser'];
				$activitydescriptions = $usernames." inserted into maximum credit units table, for Department: ".$departmentcodes.", Programme: ".$programmecodes.", Level: ".$studentlevels.", Session: ".$sesionss.", Semester: ".$semesters.", Maximium Unit: ".$maximumunits;
				$activitydates = date("Y-m-d");
				$activitytimes = date("H:i:s");
				$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
				mysql_query($query, $connection);

			}else{
				$query="update unitstable set maximumunit='{$maximumunits}' where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
				mysql_query($query, $connection);

				$usernames = $_COOKIE['currentuser'];
				$activitydescriptions = $usernames." updated into maximum credit units table, for Department: ".$departmentcodes.", Programme: ".$programmecodes.", Level: ".$studentlevels.", Session: ".$sesionss.", Semester: ".$semesters.", Maximium Unit: ".$maximumunits;
				$activitydates = date("Y-m-d");
				$activitytimes = date("H:i:s");
				$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
				mysql_query($query, $connection);

			}
		}
	}

	if($option == "getAllRecs"  || $option=="getRecordlist"  || $option=="getARecord"){
		$query = "SELECT * FROM {$table} ";
		/*if($table=="coursestable"){
			if($option == "getAllRecs" && ($serialnos!=null && $serialnos!="" && $serialnos!="1")) {
				//$serialnos = str_replace("#", " ", $_COOKIE['programme']);
				$query .= " where programmecode='{$serialnos}' ";
			}else{
				if($_COOKIE['programme']!=null ){
					$_prog = str_replace("#", " ", $_COOKIE['programme']);
					$query .= " where programmecode='{$_prog}' ";
				}else{
					$query .= " where serialno='{$serialnos}'";
				}
			}
			//$query .= " order by coursecode";
		}*/
		if(($table=="coursestable" || $table=="coursestableB" || $table=="coursestableC") && $option == "getAllRecs") {
			$query = "SELECT * FROM coursestable ";

			$query .= " where coursecode<>'' ";

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
		
			//if($entryyears != "")
			//	$query .= " and groupsession='{$entryyears}' "; 

			if($access=="") $access = "coursecode";

			$query .= " order by serialno"; //.$access;
			/*if($_COOKIE['sortorder']=="DESC"){
				setcookie("sortorder", "ASC", false);
			}else{
				setcookie("sortorder", "DESC", false);
			}
			if($_COOKIE['ordersort']=="ASC") $query .= " ASC ";*/
		}


		if($table=="departmentstable" && $option == "getAllRecs") {
			$query .= " order by departmentdescription";
		}

		if($table=="facultiestable" && $option == "getAllRecs") {
			$query .= " order by facultydescription";
		}

		if(($table=="gradestable" || $table=="gradestableB") && $option == "getAllRecs") {
			$query = "SELECT * FROM gradestable ";

			$query .= " where gradecode<>'' ";

			if($qualifications != "")
				$query .= " and qualification='{$qualifications}' "; 

			if($sesionss != "")
				$query .= " and sessions='{$sesionss}' "; 
		
			if($access=="") $access = "gradecode";

			$query .= " order by lowerrange DESC "; //.$access;
			/*if($_COOKIE['sortorder']=="DESC"){
				setcookie("sortorder", "ASC", false);
			}else{
				setcookie("sortorder", "DESC", false);
			}
			if($_COOKIE['ordersort']=="ASC") $query .= " ASC ";*/
		}

		if(($table=="cgpatable" || $table=="cgpatableB") && $option == "getAllRecs") {
			$query = "SELECT * FROM cgpatable ";

			$query .= " where cgpacode<>'' ";

			if($qualifications != "")
				$query .= " and qualification='{$qualifications}' "; 

			if($sesionss != "")
				$query .= " and sessions='{$sesionss}' "; 
		
			$query .= " order by lowerrange DESC "; //.$access;
			/*if($access=="") $access = "cgpacode";
			
			if($access=="cgpacode"){
				$query .= " order by lowerrange DESC "; //.$access;
			}else{
				$query .= " order by ".$access;
			}
			if($_COOKIE['sortorder']=="DESC"){
				setcookie("sortorder", "ASC", false);
			}else{
				setcookie("sortorder", "DESC", false);
			}
			if($_COOKIE['ordersort']=="ASC") $query .= " ASC ";*/
		}

		if($table=="programmestable" && $option == "getAllRecs") {
			//$query = "SELECT serialno, departmentcode, programmedescription, courseadvisor from programmestable ";
			$query .= " order by programmedescription desc, departmentcode";
		}

		if($table=="qualificationstable" && $option == "getAllRecs") {
			$query .= " order by serialno, qualificationcode";
		}

		if($table=="sessionstable" && $option == "getAllRecs") {
			$query .= " order by sessiondescription DESC,semesterdescription";
		}

		if($table=="studentslevels" && $option == "getAllRecs") {
			$query .= " order by serialno, leveldescription";
		}

		if($option=="getRecordlist"){
			if(substr($currentobject, 0, 11)=="facultycode")
				$query = "SELECT DISTINCT facultydescription,facultydescription FROM {$table} order by facultydescription";
			//if(substr($currentobject, 0, 14)=="departmentcode")
			//	$query = "SELECT DISTINCT departmentdescription, departmentdescription FROM {$table} order by departmentdescription";
			if(substr($currentobject, 0, 7)=="sesions" || substr($currentobject, 0, 8)=="sessions")
				$query = "SELECT DISTINCT sessiondescription, sessiondescription FROM {$table} order by sessiondescription desc";
			if(substr($currentobject, 0, 8)=="semester" || substr($currentobject, 0, 9)=="semesters")
				$query = "SELECT DISTINCT semesterdescription, semesterdescription FROM {$table} order by semesterdescription";
			if(substr($currentobject, 0, 10)=="coursecode")
				$query = "SELECT DISTINCT coursecode, coursecode FROM {$table} order by coursecode";
			if(substr($currentobject, 0, 15)=="markdescription")
				$query = "SELECT DISTINCT marksdescription, marksdescription FROM {$table} order by marksdescription";
			//if(substr($currentobject, 0, 13)=="programmecode")
			//	$query = "SELECT DISTINCT programmedescription, programmedescription FROM {$table} order by programmedescription";
			//if(substr($currentobject, 0, 12)=="studentlevel")
			//	$query = "SELECT DISTINCT leveldescription, leveldescription FROM {$table} order by leveldescription";
			if(substr($currentobject, 0, 14)=="departmentcode"){
				$faculty=$_COOKIE['parent_obj'];
				$query = "SELECT DISTINCT departmentdescription, departmentdescription FROM {$table} where facultycode='{$faculty}' order by departmentdescription";
			}
			if(substr($currentobject, 0, 13)=="programmecode"){
				$department=$_COOKIE['parent_obj'];
				$query = "SELECT DISTINCT programmedescription, programmedescription FROM {$table} where departmentcode='{$department}' order by programmedescription";
			} 
			if(substr($currentobject, 0, 20)=="programmedescription"){
				$programme=$_COOKIE['parent_obj'];
				$query = "SELECT DISTINCT qualificationdescription, qualificationdescription FROM {$table} order by qualificationdescription desc ";
			}
			if(substr($currentobject, 0, 12)=="studentlevel"){
				$programme=$_COOKIE['parent_obj'];
				$query = "SELECT DISTINCT leveldescription, leveldescription FROM {$table} where substr(leveldescription,1,1)=substr('{$programme}',1,1) order by serialno, leveldescription";
			}
			if($table=="regularstudents")
				$query = "SELECT serialno, regNumber, firstName, lastName FROM {$table} where active='Yes' order by regNumber, firstName";
			if($table=="regularstudents" && substr($currentobject, 0, 5)=="matno")
				$query = "SELECT serialno, regNumber, lastName, firstName FROM {$table} where studentlevel='{$studentlevels}' and active='Yes' order by regNumber, lastName";
			if($table=="regularstudents" && substr($currentobject, 0, 9)=="matricno4")
				$query = "SELECT serialno, regNumber, firstName, lastName FROM {$table} where  facultycode='{$facultycodes}'  and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and entryyear='{$entryyears}'  and active='Yes' order by regNumber, firstName";
			if(substr($currentobject, 0, 9)=="entryyear")
			//	$query = "SELECT DISTINCT entryyear, entryyear FROM {$table} order by entryyear";
				$query = "SELECT DISTINCT sessiondescription, sessiondescription FROM {$table} order by sessiondescription";
		}

		if($option == "getARecord") $query = "SELECT * FROM {$table} where serialno='{$serialnos}'";
		$resp=$option;

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$resp="";
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				foreach($row as $i => $value){
			        if ($option=="getAllRecs" || $option=="getRecordlist") {
		                $resp .= $value."_~_";
	                } else {
						$resp .= "getARecord" . $value;
					}
				}
				if ($option=="getAllRecs" || $option=="getRecordlist") $resp .= $option;
			}
			if ($option=="getAllRecs") $resp = $table . $option . $resp;
			if ($option=="getARecord") $resp = $table . $resp . $option;
        }else{
			if ($option=="getAllRecs") $resp = $table . $option;
		}
		echo $resp;
    }

	if($option == "addRecord"){
		$parameters = explode("][", $param);
		for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);

		if($table=="facultiestable") 
			$query = "SELECT * FROM {$table} where facultydescription ='{$parameters[1]}'";
		if($table=="departmentstable") 
			$query = "SELECT * FROM {$table} where departmentdescription ='{$parameters[1]}' and facultycode='{$parameters[2]}'";
		if($table=="programmestable") 
			$query = "SELECT * FROM {$table} where programmedescription ='{$parameters[1]}' and departmentcode='{$parameters[2]}'";
		if($table=="coursestable")
			$query = "SELECT * FROM {$table} where coursecode ='{$parameters[1]}' and programmecode='{$parameters[6]}' and facultycode='{$parameters[8]}' and departmentcode='{$parameters[9]}' and sessiondescription='{$parameters[10]}' and semesterdescription='{$parameters[11]}' and studentlevel='{$parameters[12]}' ";
		//and groupsession='{$parameters[13]}'
		if($table=="studentslevels") 
			$query = "SELECT * FROM {$table} where leveldescription ='{$parameters[1]}' order by serialno, leveldescription";
		if($table=="qualificationstable") 
			$query = "SELECT * FROM {$table} where qualificationcode ='{$parameters[1]}' order by serialno";
		if($table=="sessionstable") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and  semesterdescription ='{$parameters[2]}'";
		if($table=="gradestable") 
			$query = "SELECT * FROM {$table} where gradecode='{$parameters[1]}' and qualification='{$parameters[5]}' and  sessions='{$parameters[6]}' order by lowerrange DESC ";
		if($table=="cgpatable") 
			$query = "SELECT * FROM {$table} where cgpacode ='{$parameters[1]}' and qualification='{$parameters[4]}' and  sessions='{$parameters[5]}' order by lowerrange DESC ";
		
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
							$record .= $meta->name . "='".$parameters[$count++]."', ";
						}else{
							$count++;
						}
					}
				}
				$record = substr($record, 0, strlen($record)-2);
				$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);
			}

			$usernames = $_COOKIE['currentuser'];
			$activitydescriptions = $usernames." inserted record into table: ".$table." Record: ".str_replace("'", "", trim($record));
			$activitydates = date("Y-m-d");
			$activitytimes = date("H:i:s");
			$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
			mysql_query($query, $connection);

			echo $table."inserted";
		}else {
			echo "recordexists";
		}
	}

	if($option == "updateRecord"){
		$parameters = explode("][", $param);
		for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);

		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		if($table=="facultiestable") 
			$query = "SELECT * FROM {$table} where facultydescription ='{$parameters[1]}'";
		if($table=="departmentstable") 
			$query = "SELECT * FROM {$table} where departmentdescription ='{$parameters[1]}' and facultycode='{$parameters[2]}'";
		if($table=="programmestable") 
			$query = "SELECT * FROM {$table} where programmedescription ='{$parameters[1]}' and departmentcode='{$parameters[2]}'";
		if($table=="coursestable"){
			$query = "select * FROM coursestable where  coursecode ='{$parameters[1]}' and programmecode='{$parameters[6]}' and facultycode='{$parameters[8]}' and departmentcode='{$parameters[9]}' and sessiondescription='{$parameters[10]}' and semesterdescription='{$parameters[11]}' and studentlevel='{$parameters[12]}' and recordlock='1' "; 
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				echo "recordlocked for $parameters[1] in $parameters[10] $parameters[11] semester";
				return true;
			}

			$query = "SELECT * FROM {$table} where coursecode ='{$parameters[1]}' and programmecode='{$parameters[6]}' and facultycode='{$parameters[8]}' and departmentcode='{$parameters[9]}' and sessiondescription='{$parameters[10]}' and semesterdescription='{$parameters[11]}' and studentlevel='{$parameters[12]}' ";
		}
		//and groupsession='{$parameters[13]}'
		if($table=="studentslevels") 
			$query = "SELECT * FROM {$table} where leveldescription ='{$parameters[1]}' order by serialno, leveldescription";
		if($table=="qualificationstable") 
			$query = "SELECT * FROM {$table} where qualificationcode ='{$parameters[1]}' order by serialno";
		if($table=="sessionstable") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and  semesterdescription ='{$parameters[2]}'";
		if($table=="gradestable") 
			$query = "SELECT * FROM {$table} where gradecode='{$parameters[1]}' and qualification='{$parameters[5]}' and  sessions='{$parameters[6]}' order by lowerrange DESC ";
		if($table=="cgpatable") 
			$query = "SELECT * FROM {$table} where cgpacode ='{$parameters[1]}' and qualification='{$parameters[4]}' and  sessions='{$parameters[5]}' order by lowerrange DESC ";

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			if($table=="sessionstable" && $parameters[5]="Yes"){
				$query = "UPDATE {$table} set currentperiod='No'";
				mysql_query($query, $connection);
			}
			$record="";
			$count=0;
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					if($count > 0){
						$record .= $meta->name . "='".$parameters[$count++]."', ";
					}else{
						$count++;
					}
				}
			}
			$record = substr($record, 0, strlen($record)-2);
			$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
			$result = mysql_query($query, $connection);

			$usernames = $_COOKIE['currentuser'];
			$activitydescriptions = $usernames." updated record into table: ".$table." Record: ".str_replace("'", "", trim($record));
			$activitydates = date("Y-m-d");
			$activitytimes = date("H:i:s");
			$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
			mysql_query($query, $connection);

			echo $table."updated";
		} else {
			echo "recordnotexist";
		}
	}

	if($option == "deleteRecord"){
		$parameters = explode("][", $param);
		for($count=0; $count<count($parameters); $count++)	$parameters[$count]=trim($parameters[$count]);

		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		if($table=="facultiestable") 
			$query = "SELECT * FROM {$table} where facultydescription ='{$parameters[1]}'";
		if($table=="departmentstable") 
			$query = "SELECT * FROM {$table} where departmentdescription ='{$parameters[1]}' and facultycode='{$parameters[2]}'";
		if($table=="programmestable") 
			$query = "SELECT * FROM {$table} where programmedescription ='{$parameters[1]}' and departmentcode='{$parameters[2]}'";
		if($table=="coursestable")
			$query = "SELECT * FROM {$table} where coursecode ='{$parameters[1]}' and programmecode='{$parameters[6]}' and facultycode='{$parameters[8]}' and departmentcode='{$parameters[9]}' and sessiondescription='{$parameters[10]}' and semesterdescription='{$parameters[11]}' and studentlevel='{$parameters[12]}' ";
		//and groupsession='{$parameters[13]}'
		if($table=="studentslevels") 
			$query = "SELECT * FROM {$table} where leveldescription ='{$parameters[1]}' order by serialno, leveldescription";
		if($table=="qualificationstable") 
			$query = "SELECT * FROM {$table} where qualificationcode ='{$parameters[1]}' order by serialno";
		if($table=="sessionstable") 
			$query = "SELECT * FROM {$table} where sessiondescription ='{$parameters[1]}' and  semesterdescription ='{$parameters[2]}'";
		if($table=="gradestable") 
			$query = "SELECT * FROM {$table} where gradecode='{$parameters[1]}' and qualification='{$parameters[5]}' and  sessions='{$parameters[6]}' order by lowerrange DESC ";
		if($table=="cgpatable") 
			$query = "SELECT * FROM {$table} where cgpacode ='{$parameters[1]}' and qualification='{$parameters[4]}' and  sessions='{$parameters[5]}' order by lowerrange DESC ";

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			if($table=="facultiestable") 
				$query = "SELECT * FROM regularstudents where facultycode ='{$parameters[1]}'";
			if($table=="departmentstable") 
				$query = "SELECT * FROM regularstudents where departmentcode ='{$parameters[1]}' and facultycode='{$parameters[2]}'";
			if($table=="programmestable") 
				$query = "SELECT * FROM regularstudents where programmecode ='{$parameters[1]}' and departmentcode='{$parameters[2]}'";
			if($table=="coursestable") 
				$query = "SELECT * FROM finalresultstable where coursecode ='{$parameters[1]}' and programmecode='{$parameters[6]}' and facultycode='{$parameters[8]}' and departmentcode='{$parameters[9]}' and sessiondescription='{$parameters[10]}' and semester='{$parameters[11]}' and studentlevel='{$parameters[12]}' ";
			//and groupsession='{$parameters[13]}'
			if($table=="studentslevels") 
				$query = "SELECT * FROM regularstudents where studentlevel ='{$parameters[1]}'";
			if($table=="qualificationstable") 
				$query = "SELECT * FROM regularstudents where qualificationcode ='{$parameters[1]}'";
			if($table=="sessionstable") 
				$query = "SELECT * FROM examresultstable where sessiondescription ='{$parameters[1]}'";
			if($table=="gradestable") 
				$query = "SELECT * FROM finalresultstable where gradecode ='{$parameters[1]}' and  substr(studentlevel,0,2)='{$parameters[5]}' and  sessiondescription='{$parameters[6]}'";
			if($table=="cgpatable") 
				$query = "SELECT * FROM regularstudents where cgpacode ='{$parameters[1]}' ";

			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "DELETE FROM {$table} where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);

				$usernames = $_COOKIE['currentuser'];
				$activitydescriptions = $usernames." deleted record from table: ".$table." Query: ".str_replace("'", "", trim($query));
				$activitydates = date("Y-m-d");
				$activitytimes = date("H:i:s");
				$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
				mysql_query($query, $connection);

				echo $table."deleted";
			}else{
				echo $table."recordused";
			}
		} else {
			echo "recordnotexist";
		}
	}

?>
