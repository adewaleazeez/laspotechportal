<?php 
ini_set('memory_limit', '9500M');
	/** Include PHPExcel */
	require_once 'Classes/PHPExcel.php';


	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);

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

	$rowcounter=1;
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "School:");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $facultycodes);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Department:");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $departmentcodes);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Programme:");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $programmecodes);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Level:");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $studentlevels);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Session:");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $sesionss);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Semester:");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $semesters);

	$parameter2 = explode("_~_", $param2);
	for($count=0; $count<count($parameter2); $count++)	$parameter2[$count]=trim($parameter2[$count]);

	$host='localhost';
	$dbname='laspotechdb';
	$user='root';
	$pass='aliyah';
	$DBHlocal = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  

	//$host='sptsr.db.5533865.hostedresource.com';
	//$dbname='sptsr';
	//$user='sptsr';
	//$pass='Oy1nd@m0l@';
	//$DBHonline = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  

	//$host='localhost';
	//$dbname='laspotechonline';
	//$user='root';
	//$pass='aliyah';
	//$DBHonline = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  

	$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=?, report=?  WHERE currentuser=?";
	$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
	$STHlocalCurrentrecord->execute(array('', '', $currentusers));
	//setcookie("currentreport", "", false);
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
			//$whereclause = " where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
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
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Table Name:");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $tablename);
		$keyfound=0;
		while($row = $STHlocal->fetch()) {
			$sno++;

            $GBMemory = memory_get_usage() /1024/1024; 
			$currentrecordprocessings=$code."_-_".$recordcount."_-_".$sno."_-_T_-_".$GBMemory;
			$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=? WHERE currentuser=?";
			$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
			$STHlocalCurrentrecord->execute(array($currentrecordprocessings, $currentusers));
				
			$fields="";
			$datavalue="";
			$arraydata="";
			$sql="";
			$recordfound=0;
			$colcounter=0;
			if($keyfound==0){
				foreach($row as $key => $value) {
					if(is_numeric($key)) continue;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colcounter++, $rowcounter, $key);
				}
			}
			$keyfound=1;
			$rowcounter++;

			$colcounter=0;
			$serialnos='';
			foreach($row as $key => $value) {
				if(is_numeric($key)) continue;
				if(is_null($value)) $value="";
				if($value=="0") $value="'0";
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colcounter++, $rowcounter, $value);
			}
		}
		$rowcounter++;

        $GBMemory = memory_get_usage() /1024/1024; 

		/*if($GBMemory>=125){
			$filecounter++;
			$filename='File00'.$filecounter.'.xls';
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			//$objWriter->save('excelfiles/upload.xls');
			$objWriter->save('excelfiles/'.$filename);

			//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			//$objWriter->save('excelfiles/upload.xls');

			//$source_path = "excelfiles/upload.xls";
			$source_path = "excelfiles/".$filename;
			//$target_path = "/sptsr/excelfiles/upload.xls";
			$target_path = "/sptsr/excelfiles/".$filename;
			$conn = ftp_connect("immaculatedevelopers.com", 21) or die("Could not connect");
			ftp_login($conn,"azeezadewale","Om0kunmi");
			// turn passive mode on
			ftp_pasv($conn, true);
			ftp_put($conn,$target_path,$source_path,FTP_BINARY);
			ftp_close($conn);




			// Create new PHPExcel object
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);

			$rowcounter=1;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "School:");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $facultycodes);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Department:");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $departmentcodes);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Programme:");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $programmecodes);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Level:");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $studentlevels);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Session:");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $sesionss);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Semester:");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $semesters);

			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowcounter, "Table Name:");
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowcounter++, $tablename);
			$keyfound=0;
		}*/


		$currentrecordprocessings=$code."_-_".$recordcount."_-_".$sno."_-_Y_-_".$GBMemory;
		$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=? WHERE currentuser=?";
		$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
		$STHlocalCurrentrecord->execute(array($currentrecordprocessings, $currentusers));
		//echo "readCookies".$currentrecordprocessings;
		while(true){
			$STHLocal = $DBHlocal->prepare("SELECT * FROM currentrecord where currentuser='{$currentusers}' and currentrecordprocessing<>'' ");
			$STHLocal->execute();
			if($STHLocal->rowCount()==0) break;
		}
	}

	$filecounter++;
	$filename='File00'.$filecounter.'.xls';
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	//$objWriter->save('excelfiles/upload.xls');
	$objWriter->save('excelfiles/'.$filename);

	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	//$objWriter->save('excelfiles/upload.xls');

	//$source_path = "excelfiles/upload.xls";
	$source_path = "excelfiles/".$filename;
	//$target_path = "/sptsr/excelfiles/upload.xls";
	$target_path = "/sptsr/excelfiles/".$filename;
	$conn = ftp_connect("immaculatedevelopers.com", 21) or die("Could not connect");
	ftp_login($conn,"azeezadewale","Om0kunmi");
	// turn passive mode on
	ftp_pasv($conn, true);
	ftp_put($conn,$target_path,$source_path,FTP_BINARY);
	ftp_close($conn);

	echo "myStopFunction";

?>