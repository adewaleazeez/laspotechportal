<?php
	if($_COOKIE["currentuser"]==null || $_COOKIE["currentuser"]==""){
		echo '<script>alert("You must login to access this page!!!\n Click Ok to return to Login page.");</script>';
		echo '<script>window.location = "login.php";</script>';
		return true;
	}

	$results = 0;
	setcookie("resp", "", false);
	$resp = "";
	$currentusers = $_COOKIE['currentuser'];
	$ftype = $_GET['ftype'];
	include("data.php");
	//$query = "INSERT INTO activities (userEmail, descriptions, activityDate, activityTime) VALUES ('{$currentusers}', '{$_FILES['txtFile']['type']}', '{$ftype}', '{$results}')";
	//mysql_query($query, $connection);

	//if(ereg("application/vnd.ms-excel", $_FILES['txtFile']['type']) || ereg("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", $_FILES['txtFile']['type'])) {
	//if(str_in_str($_FILES['txtFile']['type'], "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || str_in_str($_FILES['txtFile']['type'], "application/vnd.ms-excel") ){
	
	$target_path = "";
	if($ftype=="pic"){
		$target_path = "photo/" . basename( $_FILES['txtFile']['name']);

		if(@move_uploaded_file($_FILES['txtFile']['tmp_name'], $target_path)) {
			$results = 1;
		}
		sleep(1);
		setcookie("filetype", "pic", false);
	}

	if($ftype=="doc"){
		$target_path = "photo/" . basename( $_FILES['txtFile2']['name']);

		if(substr($target_path, strlen($target_path)-4, strlen($target_path))==".xls"){
			if(@move_uploaded_file($_FILES['txtFile2']['tmp_name'], $target_path)) {
				$results = 1;
			}
		}
		sleep(1);
		setcookie("filetype", "doc", false);
	}

	if($ftype=="excel"){
		$resp ="blankfile";
		if(strlen(basename( $_FILES['txtFile3']['name']))>0) $resp ="wrongformat".basename( $_FILES['txtFile3']['name']);
		if(str_in_str($_FILES['txtFile3']['type'],"sheet") || str_in_str($_FILES['txtFile3']['type'],"excel") ){
			$target_path = "excelfiles/" . basename( $_FILES['txtFile3']['name']);

			if(substr($target_path, strlen($target_path)-4, strlen($target_path))==".xls"){
				if(@move_uploaded_file($_FILES['txtFile3']['tmp_name'], $target_path)) {
					$results = 1;
					$resp = "successful";
				}
			}

			sleep(1);
			setcookie("filetype", "excel", false);

			if($results==1){
				//setcookie("resp", "file uploaded", false);
				require_once 'reader.php';

				$filename=$target_path;
				//parseExcel($filename);
				//$prod=parseExcel($filename);
				//echo"<pre>";
				//print_r($prod);

				//function parseExcel($excel_file_name_with_path){
				$data = new Spreadsheet_Excel_Reader();
				// Set output Encoding.
				$data->setOutputEncoding('CP1251');
				//$data->read($excel_file_name_with_path);
				$data->read($target_path);

				//$colname=array('id','name');
				$faculty = "";
				$department = "";
				$programme = "";
				$level = "";
				$qualifications = "";
				$studentrecords=0;

				$query = "update currentrecord set currentrecordprocessing='', report='Matric No~Last Name~Other Names~Remarks~Comments_~_' where currentuser='{$currentusers}'";
				mysql_query($query, $connection);

				$cookiefacult=str_replace("_", ",", $_COOKIE['_facultys']);
				$cookiedept=str_replace("_", ",", $_COOKIE['_departments']);
				$cookieprog=str_replace("_", ",", $_COOKIE['_programmes']);
				$cookielevel=str_replace("_", ",", $_COOKIE['_levels']);
				$cookiesession=str_replace("_", ",", $_COOKIE['_sessions']);
				$cookiesemester=str_replace("_", ",", $_COOKIE['_semesters']);

				$query = "SELECT min(b.regNumber) as firstregnumber, max(b.regNumber) as lastregnumber FROM regularstudents AS a JOIN registration AS b ON a.regNumber=b.regNumber and b.sessions='{$cookiesession}'  and b.semester='{$cookiesemester}' and a.facultycode='{$cookiefacult}' and a.departmentcode='{$cookiedept}' and a.programmecode='{$cookieprog}' and b.studentlevel='{$cookielevel}' and a.lockrec!='Yes' order by a.regNumber"; 
				$result = mysql_query($query, $connection);
				extract (mysql_fetch_array($result));				
				
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

				//$query = "insert into ".$tmp_regularstudent." SELECT * FROM regularstudents where (regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}') group by regNumber";
				//mysql_query($query, $connection);

				$query="delete from regularstudents where (regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}') ";
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

				//$query = "insert into ".$tmp_registration." SELECT * FROM registration where regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}' and sessions='{$cookiesession}' and semester='{$cookiesemester}' group by regNumber, sessions, semester";
				//mysql_query($query, $connection);

				$query="delete from registration where (regNumber>='{$firstregnumber}' and regNumber<='{$lastregnumber}') and sessions='{$cookiesession}' and semester='{$cookiesemester}' ";
				mysql_query($query, $connection);

//$qry=str_replace("'", "`", $query);
//$query="update currentrecord set report='{$qry}' where currentuser='Admin' ";
//mysql_query($query, $connection);

				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
					$coursetitle = trim($data->sheets[0]['cells'][5][1])."";
					if($coursetitle!="Qualification to Obtain"){
						$resp ="wrongexcel".basename( $_FILES['txtFile3']['name']);
						$process=false;
						//$resp = str_replace(" ", "_", $resp);
						//setcookie("resp", $resp, false);
						$quit=true;
						break;
					}
					for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
						/*if(trim($data->sheets[0]['cells'][$i][$j]).""=="Matric No" || $i>=8){
							$studentrecords=1;
							continue;
						}*/
						if($i==1 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM facultiestable where facultydescription ='{$cellvalue}'";
							$faculty = checkCode($query);
							if($faculty=="notinsetup"){
								$resp = $faculty.$cellvalue."notinsetupSchool";
								break;
							}
							if($cellvalue!=$_COOKIE['_facultys']){
								$resp = "School Code in Excel File - ".trim($cellvalue)." does not match School Code Selected - ".trim($_COOKIE['_facultys']);
								break;
							}
							$faculty=$cellvalue;
						}

						if($i==2 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM departmentstable where departmentdescription ='{$cellvalue}'";
							$department = checkCode($query);
							if($department=="notinsetup"){
								$resp = $department.$cellvalue."notinsetupDepartment";
								break;
							}
							if($cellvalue!=$_COOKIE['_departments']){
								$resp = "Department Code in Excel File - ".trim($cellvalue)." does not match Department Code Selected - ".trim($_COOKIE['_departments']);
								break;
							}
							$department=$cellvalue;
						}
						if($i==3 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM programmestable where programmedescription ='{$cellvalue}'";
							$programme = checkCode($query);
							if($programme=="notinsetup"){
								$resp = $programme.$cellvalue."notinsetupProgramme";
								break;
							}
							if($cellvalue!=$_COOKIE['_programmes']){
								$resp = "Programme Code in Excel File - ".trim($cellvalue)." does not match Programme Code Selected File - ".trim($_COOKIE['_programmes']);
								break;
							}
							$programme=$cellvalue;
						}
						if($i==4 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM studentslevels where leveldescription ='{$cellvalue}'";
							$level = checkCode($query);
							if($level=="notinsetup"){
								$resp = $level.$cellvalue."notinsetupStudent_Level";
								break;
							}
							if($cellvalue!=$_COOKIE['_studentlevels']){
								$resp = "Student_Level in Excel File - ".trim($cellvalue)." does not match Student_Level Selected - ".trim($_COOKIE['_studentlevels']);
								break;
							}
							$level=$cellvalue;
						}
						if($i==5 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM qualificationstable where qualificationcode ='{$cellvalue}'";
							$qualification = checkCode($query);
							if($qualification=="notinsetup"){
								$resp = $qualification.$cellvalue."notinsetupQualification";
								break;
							}
							//if($cellvalue!=$_COOKIE['_studentlevel']){
							//	$resp = "Student_Level in Excel File - ".$cellvalue." does not match Student_Level Selected - ".$_COOKIE['_studentlevel'];
							//	$dobreak=true;
							//	break;
							//}
							$qualification=$cellvalue;
						}
						if($i==6 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM sessionstable where sessiondescription ='{$cellvalue}'";
							$sessions = checkCode($query);
							if($sessions=="notinsetup"){
								$resp = $sessions.$cellvalue."notinsetupSessions";
								break;
							}
							if($cellvalue!=$_COOKIE['_sessions']){
								$resp = "Session Code in Excel File - ".trim($cellvalue)." does not match Session Code Selected -  ".trim($_COOKIE['_sessions']);
								break;
							}
							$sessions=$cellvalue;
						}
						if($i==7 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM sessionstable where semesterdescription ='{$cellvalue}'";
							$semester = checkCode($query);
							if($semester=="notinsetup"){
								$resp = $semester.$cellvalue."notinsetupSessions";
								break;
							}
							if($cellvalue!=$_COOKIE['_semesters']){
								$resp = "Semester Code in Excel File - ".trim($cellvalue)." does not match Semester Code Selected - ".trim($_COOKIE['_semesters']);
								break;
							}
							$semester=$cellvalue;
						}

						$response =  "";
						if($i>9){
							if($j==2) $titles = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $matricnos = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $lastnames = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $firstnames = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $middlenames = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==7) $genders = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==8) $dobs = trim($data->sheets[0]['cells'][$i][$j])."";
							if($dobs==null || $dobs=="") $dobs='0000-00-00';
							if($j==9) $emails = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==10) $phones= trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==11) $units = trim($data->sheets[0]['cells'][$i][$j])."";
							if($units==null || $units=="") $units='0';
							if($j==12) $maidens = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==13) $nations = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==14) $states = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==15) $maritals = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==16) $passports = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==16){
								if($matricnos=="" && $lastnames=="" && ($dobs=="" || $dobs=="0000-00-00") && ($units=="" || $units=="0")) {
									//$resp = "file uploaded";
									break;
								}

								$currentrecordprocessings=str_replace(" ","spc", "1_-_".($i-9)."_-_".$matricnos."_-_".$lastnames."_-_".$firstnames."spc".$middlenames);
								$query = "update currentrecord set currentrecordprocessing='{$currentrecordprocessings}' where currentuser ='{$currentusers}'";
								mysql_query($query, $connection);

								$query = "SELECT * FROM ".$tmp_regularstudent." where regNumber='{$matricnos}'";
								$result = mysql_query($query, $connection);
								$thereport="";
								if($matricnos=="") {
									$response = "Invalid Matric No for ".$firstnames." ".$lastnames." in excel file"; 
									$thereport="Not Successful~".$response;
								}else if(mysql_num_rows($result) == 0 && $matricnos>""){
									$querySNo="select max(serialno)+1 as nextserialno from ".$tmp_regularstudent;
									$resultSNo = mysql_query($querySNo, $connection);
									extract (mysql_fetch_array($resultSNo));

									if($nextserialno<=1){
										$querySNo="select max(serialno)+1 as nextserialno from regularstudents ";
										$resultSNo = mysql_query($querySNo, $connection);
										extract (mysql_fetch_array($resultSNo));
									}

									$querySNo="select regNumber as matno, serialno from regularstudents where regnumber='{$matricnos}' and facultycode='{$faculty}' and departmentcode='{$department}' and programmecode='{$programme}' and studentlevel='{$level}'";
									$resultSNo = mysql_query($querySNo, $connection);
									extract (mysql_fetch_array($resultSNo));

									if($matno==$matricnos) $nextserialno=$serialno;

									$query = "INSERT INTO ".$tmp_regularstudent." (serialno, regNumber, lastName, firstName, middleName, gender, facultycode, departmentcode, programmecode, studentlevel, admissiontype, qualificationcode, minimumunit, userName, active, userType, lockrec, dateOfBirth, userEmail, userPicture, maidenName, nationality, originState, maritalStatus, title, phoneno ) values ('{$nextserialno}', '{$matricnos}', '{$lastnames}', '{$firstnames}', '{$middlenames}', '{$genders}', '{$faculty}', '{$department}', '{$programme}', '{$level}', 'PCE', '{$qualification}', {$units}, '{$matricnos}', 'Yes', 'Student', 'No', '{$dobs}', '{$emails}', '{$passports}', '{$maidens}', '{$nations}', '{$states}', '{$maritals}', '{$titles}',  '{$phones}')";
									$result=mysql_query($query, $connection);
									if(!$result){
										$query2=str_replace("'","`",$query);
										$response = "Insert Failed for ".$matricnos."~".$query2;
										$thereport="Not Successful~".$response;
									}else{
										$thereport="Insert Successful~";
									}
								}else if($matricnos>""){
									$query = "SELECT * FROM ".$tmp_regularstudent." where regNumber='{$matricnos}' and facultycode='{$faculty}' and departmentcode='{$department}' and programmecode='{$programme}'";
									$result = mysql_query($query, $connection);
									if(mysql_num_rows($result) == 1){
										$query = "UPDATE ".$tmp_regularstudent." SET lastName='{$lastnames}', firstName='{$firstnames}', middleName='{$middlenames}', gender='{$genders}', facultycode='{$faculty}', departmentcode='{$department}', programmecode='{$programme}', studentlevel='{$level}', admissiontype='PCE', qualificationcode='{$qualification}', minimumunit={$units}, userName='{$matricnos}', active='Yes', userType='Student', lockrec='No', ignorepay='Yes', dateOfBirth='{$dobs}', userEmail='{$emails}', userPicture='{$passports}', maidenName='{$maidens}', nationality='{$nations}', originState='{$states}', maritalStatus='{$maritals}', title='{$titles}', phoneno='{$phones}' where regNumber ='{$matricnos}'";
										$result=mysql_query($query, $connection);
										if(!$result){
											$query2=str_replace("'","`",$query);
											$response = "Update Failed for ".$matricnos."~".$query2;
											//break;
											$thereport="Not Successful~".$response;
										}else{
											$thereport="Update Successful~";
										}
									}else{
										$query = "SELECT * FROM ".$tmp_regularstudent." where regNumber='{$matricnos}'";
										$result = mysql_query($query, $connection);
										while ($row = mysql_fetch_array($result)) {
											extract ($row);
											//$resp = "matnousedMatric_No_already_used_for_".$regNumber."_".$lastName.",_".$firstName."_".$middleName." Department_".$departmentcode.",_Programme_".$programmecode;
											$response = "Matric No already used for ".$regNumber." ".$lastName." ".$firstName." ".$middleName.", Department:  ".$departmentcode.", Programme: ".$programmecode;
											$thereport="Not Successful~".$response;
											$resp = "Matric Numbers are already used for ".$departmentcode." department, ".$programmecode." programme ".mysql_num_rows($result);
										}
									}
								}
	//$resp.="0  ".$query;
								if(!str_in_str($thereport,"Not Successful")){
									$query = "SELECT * FROM ".$tmp_registration." where regNumber ='{$matricnos}' and studentlevel  ='{$level}' and sessions ='{$sessions}' and semester ='{$semester}'";
									$result = mysql_query($query, $connection);
	//$resp.="  ".mysql_num_rows($result);
									if(mysql_num_rows($result) == 0 && $matricnos>""){
										$querySNo="select max(serialno)+1 as nextserialno from ".$tmp_registration;
										$resultSNo = mysql_query($querySNo, $connection);
										extract (mysql_fetch_array($resultSNo));

										if($nextserialno<=1){
											$querySNo="select max(serialno)+1 as nextserialno from registration ";
											$resultSNo = mysql_query($querySNo, $connection);
											extract (mysql_fetch_array($resultSNo));
										}

										$query = "INSERT INTO ".$tmp_registration." (serialno, regNumber, studentlevel, sessions, semester, registered) VALUES ('{$nextserialno}', '{$matricnos}', '{$level}', '{$sessions}', '{$semester}', 'Yes')";
										$result = mysql_query($query, $connection);
										//setcookie("resp2", $query, false);
									}else{
										$query = "update ".$tmp_registration." set studentlevel='{$level}', sessions='{$sessions}', semester='{$semester}', registered='Yes' where regNumber ='{$matricnos}' ";
										$result = mysql_query($query, $connection);
									}
								}
								$thereport = $matricnos."~".$lastnames."~".$firstnames."~".$thereport;
								$query = "update currentrecord set report=concat(report,'{$thereport}','_~_') where currentuser ='{$currentusers}'";
								mysql_query($query, $connection);
							}
						}
					}
					if($resp != "successful"){
						break;
					}
				}
			}else{
				$results = 0;
				//$resp = "file not uploaded";
			}
		}

		//where B.regNumber<>'' 
		$query = "insert into regularstudents SELECT * FROM ".$tmp_regularstudent." B ON DUPLICATE KEY UPDATE regNumber=B.regNumber, firstName=B.firstName, lastName=B.lastName, middleName=B.middleName, gender=B.gender, dateOfBirth=B.dateOfBirth, userEmail=B.userEmail, title=B.title, phoneno=B.phoneno, minimumunit=B.minimumunit, maidenName=B.maidenName, nationality=B.nationality, originState=B.originState, maritalStatus=B.maritalStatus, userPicture=B.userPicture ";
		mysql_query($query, $connection);

		//where B.regNumber<>'' ON 
		$query = "insert into registration SELECT * FROM ".$tmp_registration." B ON DUPLICATE KEY UPDATE regNumber=B.regNumber, studentlevel=B.studentlevel, sessions=B.sessions, semester=B.semester, registered=B.registered ";
		mysql_query($query, $connection);

		$query = "DROP TABLE IF EXISTS ".$tmp_regularstudent;
		mysql_query($query, $connection);

		$query = "SELECT * FROM information_schema.tables WHERE table_schema = 'laspotechdb' AND table_name LIKE '%tmp_%'  AND table_name LIKE '%_regularstudent%'  ";
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

		$usernames = $_COOKIE['currentuser'];
		$activitydescriptions = $usernames." uploaded student data for Department: ".$department.", Program: ".$programme.", Level: ".$level.", Session: ".$sessions.", Semester: ".$semester;
		$activitydates = date("Y-m-d");
		$activitytimes = date("H:i:s");
		$query = "INSERT INTO activities (username, descriptions, activityDate, activityTime) VALUES ('{$usernames}', '{$activitydescriptions}', '{$activitydates}', '{$activitytimes}')";
		mysql_query($query, $connection);
					
		sleep(1);
		$resp = str_replace(" ", "_", $resp);
		setcookie("resp", $resp, false);
	}

	function IsNaN($phones){
		$resp=false;
		for($k=0; $k<strlen($phones); $k++)	{
			if(strpos("1234567890.",substr($phones,$k,1))===false) {
				$resp=true;
			}
		}
		return $resp;
	}

	function checkCode($query){
		include("data.php"); 
		$result = mysql_query($query, $connection);
		$resp="";
		if(mysql_num_rows($result)==0) $resp .= "notinsetup";
		return $resp;
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

?>

<script language="javascript" type="text/javascript">
	window.top.window.stopUpload(<?php echo $results; ?>);
	window.top.window.stopUpload2(<?php echo $results; ?>);
	window.top.window.stopUpload3(<?php echo $results; ?>);
</script>
