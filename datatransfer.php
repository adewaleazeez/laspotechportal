<?php 
	$currentusers = $_COOKIE['currentuser'];
	$param1 = str_replace("'", "`", trim($_GET['param1']));
	$param2 = str_replace("'", "`", trim($_GET['param2']));
	
	$param2=substr($param2, 0, strlen($param2)-3);
	
	$parameter1 = explode("][", $param1);
	for($count=0; $count<count($parameter1); $count++)	$parameter1[$count]=trim($parameter1[$count]);
	$facultycodes=$parameter1[0];
	$departmentcodes=$parameter1[1];
	$programmecodes=$parameter1[2];
	$studentlevels=$parameter1[3];
	$sesionss=$parameter1[4];
	$semesters=$parameter1[5];

	$parameter2 = explode("_~_", $param2);
	for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);

	$host='localhost';
	$dbname='laspotechdb';
	$user='root';
	$pass='aliyah';
	$DBHlocal = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  

	$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=?, report=?  WHERE currentuser=?";
	$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
	$STHlocalCurrentrecord->execute(array('', '', $currentusers));
	$filecounter=0;
	foreach($parameter2 as $code){
		$tablename="";
		$whereclause="";
		$query="";
		if($code=="table0"){
			$tablename='cgpatable';
			$whereclause = " where sessions='{$sesionss}' ";
		}
		if($code=="table1"){
			$tablename='coursestable';
			$whereclause = " where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
			if($facultycodes != "")
				$whereclause .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$whereclause .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$whereclause .= " and studentlevel='{$studentlevels}' "; 
		}
		if($code=="table2"){
			$tablename='departmentstable';
			$whereclause .= " where serialno<>0 "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentdescription='{$departmentcodes}' "; 
		}
		if($code=="table3"){
			$tablename='examresultstable';
			$whereclause=" where sessiondescription='{$sesionss}' and semester='{$semesters}' ";
			if($facultycodes != "")
				$whereclause .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$whereclause .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$whereclause .= " and studentlevel='{$studentlevels}' "; 
		}
		if($code=="table4"){
			$tablename='facultiestable';
			$whereclause .= " where serialno<>0 "; 
			if($facultycodes != "")
				$whereclause .= " and facultydescription='{$facultycodes}' "; 
		}
		if($code=="table5"){
			$tablename='finalresultstable';
			$whereclause=" where sessiondescription='{$sesionss}' and semester='{$semesters}' ";
			if($facultycodes != "")
				$whereclause .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$whereclause .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$whereclause .= " and studentlevel='{$studentlevels}' "; 
		}
		if($code=="table6"){
			$tablename='gradestable';
			$whereclause = " where sessions='{$sesionss}' ";
		}
		if($code=="table7"){
			$tablename='mastereportbackup';
			$whereclause=" where sessions='{$sesionss}' and semester='{$semesters}' ";
			if($facultycodes != "")
				$whereclause .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$whereclause .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$whereclause .= " and studentlevel='{$studentlevels}' "; 
		}
		if($code=="table8"){
			$tablename='pintable';
			$query = "SELECT b.* FROM regularstudents a, pintable b where a.regNumber=b.regNumber ";
			if($facultycodes != "")
				$query .= " and a.facultycode='{$facultycodes}' ";

			if($departmentcodes != "")
				$query .= " and a.departmentcode='{$departmentcodes}' ";

			if($programmecodes != "")
				$query .= " and a.programmecode='{$programmecodes}' "; 

			if($sesionss != "")
				$query .= " and b.sessiondescription='{$sesionss}' ";

			if($semesters != "")
				$query .= " and b.semesterdescription='{$semesters}' ";
		}
		if($code=="table9"){
			$tablename='programmestable';
			$whereclause .= " where serialno<>0 "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' ";

			if($programmecodes != "")
				$whereclause .= " and programmedescription='{$programmecodes}' ";
		}
		if($code=="table10"){
			$tablename='qualificationstable';
		}
		if($code=="table11"){
			$tablename='registration';
			$query = "SELECT b.* FROM regularstudents a, registration b where a.regNumber=b.regNumber ";
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
		}
		if($code=="table12"){
			$tablename='regularstudents';
			$query = "SELECT a.* FROM regularstudents a, registration b where a.regNumber=b.regNumber ";
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
		}
		if($code=="table13"){
			$tablename='remarkstable';
		}
		if($code=="table14"){
			$tablename='retakecourses';
			$whereclause=" where sessiondescription='{$sesionss}' and semester='{$semesters}' ";
			if($facultycodes != "")
				$whereclause .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$whereclause .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$whereclause .= " and studentlevel='{$studentlevels}' "; 
		}
		if($code=="table15"){
			$tablename='schoolinformation';
		}
		if($code=="table16"){
			$tablename='sessionstable';
			$whereclause = " where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
		}
		if($code=="table17"){
			$tablename='studentslevels';
		}
		if($code=="table18"){
			$tablename='summaryreport';
			$whereclause=" where sessions='{$sesionss}' and semester='{$semesters}' ";
			if($facultycodes != "")
				$whereclause .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$whereclause .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$whereclause .= " and studentlevel='{$studentlevels}' "; 
		}
		if($code=="table19"){
			$tablename='unitstable';
			$whereclause = " where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
			if($facultycodes != "")
				$whereclause .= " and facultycode='{$facultycodes}' "; 
			if($departmentcodes != "")
				$whereclause .= " and departmentcode='{$departmentcodes}' "; 
			if($programmecodes != "")
				$whereclause .= " and programmecode='{$programmecodes}' ";
			if($studentlevels != "")
				$whereclause .= " and studentlevel='{$studentlevels}' "; 
		}
		if($code=="table20"){
			$tablename='users';
		}
    
		# creating the statement
		$STHlocal="";
		if($code=="table8" || $code=="table11" || $code=="table12"){
			$STHlocal = $DBHlocal->query($query);
		}else{
			$STHlocal = $DBHlocal->query('SELECT * FROM ' . $tablename . $whereclause);
		}
		$STHlocal->execute();
		$recordcount = $STHlocal->rowCount();
		$sno = 0;
		$currentrecordprocessings="";
		$datavalue='';
		$datavalue.=$tablename.'\n';
		$keyfound=0;
		while($row = $STHlocal->fetch()) {
			$sno++;

            //$GBMemory = memory_get_usage() /1024/1024; 
			$currentrecordprocessings=$code."_-_".$recordcount."_-_".$sno."_-_T_-_"; //.$GBMemory;
			$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=? WHERE currentuser=?";
			$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
			$STHlocalCurrentrecord->execute(array($currentrecordprocessings, $currentusers));
				
			if($keyfound==0){
				foreach($row as $key => $value) {
					if(is_numeric($key)) continue;
					$datavalue.=$key.'\t';
				}
				$datavalue.='\n';
			}
			$keyfound=1;
			foreach($row as $key => $value) {
				if(is_numeric($key)) continue;
				if(is_null($value)) $value='null';
				$datavalue.=$value.'\t';
			}
			$datavalue.='\n';
			if(($sno % 5000)==0){
				$filename='auxilliaryfiles/upload00'.(++$filecounter).'.txt';
				$handle = fopen($filename, 'w');
				fwrite($handle, $datavalue);
				fclose($handle);

				$source_path = $filename;
				$target_path = "/sptsr/".$filename;
				$conn = ftp_connect("immaculatedevelopers.com", 21) or die("Could not connect");
				ftp_login($conn,"azeezadewale","Om0kunmi");
				// turn passive mode on
				ftp_pasv($conn, true);
				ftp_put($conn,$target_path,$source_path,FTP_BINARY);
				//ftp_put($conn,$target_path,$source_path,FTP_ASCII);
				ftp_close($conn);
				unlink($filename);

				$datavalue='';
				$datavalue.=$tablename.'\n';
				$keyfound=0;
			}
		}

		$filename='auxilliaryfiles/upload00'.(++$filecounter).'.txt';
		$handle = fopen($filename, 'w');
		fwrite($handle, $datavalue);
		fclose($handle);

		$source_path = $filename;
		$target_path = "/sptsr/".$filename;
		$conn = ftp_connect("immaculatedevelopers.com", 21) or die("Could not connect");
		ftp_login($conn,"azeezadewale","Om0kunmi");
		// turn passive mode on
		ftp_pasv($conn, true);
		ftp_put($conn,$target_path,$source_path,FTP_BINARY);
		//ftp_put($conn,$target_path,$source_path,FTP_ASCII);
		ftp_close($conn);
		unlink($filename);

        //$GBMemory = memory_get_usage() /1024/1024; 
		$currentrecordprocessings=$code."_-_".$recordcount."_-_".$sno."_-_Y_-_"; //.$GBMemory;
		$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=? WHERE currentuser=?";
		$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
		$STHlocalCurrentrecord->execute(array($currentrecordprocessings, $currentusers));
		while(true){
			$STHLocal = $DBHlocal->prepare("SELECT * FROM currentrecord where currentuser='{$currentusers}' and currentrecordprocessing<>'' ");
			$STHLocal->execute();
			if($STHLocal->rowCount()==0) break;
		}
	}

//extension=php_curl.dll
	//step1
	$cSession = curl_init(); 
	//step2
	curl_setopt($cSession,CURLOPT_URL,"http://www.immaculatedevelopers.com/sptsr/updatetransfer.php");
	//curl_setopt($cSession,CURLOPT_URL,"http://localhost/laspotechportal/updatetransfer.php");
	curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($cSession,CURLOPT_HEADER, false); 
	//step3
	$result=curl_exec($cSession);
	//step4
	curl_close($cSession);
	//step5
	//echo "myStopFunction$result";
	echo "myStopFunction".$result;

?>
