<?php
	$results = 0;

	$currentusers = $_COOKIE['currentuser'];
	$ftype = $_GET['ftype'];
	$target_path = "";
	if($ftype=="pic"){
		$target_path = "photo/" . basename( $_FILES['txtFile']['name']);

		if(@move_uploaded_file($_FILES['txtFile']['tmp_name'], $target_path)) {
			$results = 1;
		}
		sleep(1);
	}

	if($ftype=="doc"){
		if($_COOKIE['updateticket']=="Yes"){
			$target_path = "documents/" . basename( $_FILES['txtFile3']['name']);

			if(@move_uploaded_file($_FILES['txtFile3']['tmp_name'], $target_path)) {
				$results = 1;
			}
		}else{
			$target_path = "documents/" . basename( $_FILES['txtFile2']['name']);

			if(@move_uploaded_file($_FILES['txtFile2']['tmp_name'], $target_path)) {
				$results = 1;
			}
		}
		sleep(1);
	}

	include("data.php");
	if($ftype=="excel"){
		if(str_in_str($_FILES['txtFile']['type'],"sheet") || str_in_str($_FILES['txtFile']['type'],"excel") ){
			$target_path = "excelfiles/" . basename( $_FILES['txtFile']['name']);

			if(@move_uploaded_file($_FILES['txtFile']['tmp_name'], $target_path)) {
				$results = 1;
			}


			sleep(1);

			if($results==1){


				setcookie("resp", "file uploaded", false);





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
				$sessions = "";
				$semester = "";
				$groupsession = "";
				$coursecode = "";
				$marksdescription = $_COOKIE['_markdescription'];
				$marksobtainable = 100.0;
				$percentage = 100.0;
				$matricno = "";
				$marksobtained = "";
				$resp = "successful";
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
					for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {

						if($i==1 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM facultiestable where facultydescription ='{$cellvalue}'";
							$faculty = checkCode($query);
							if($faculty=="notinsetup"){
								$resp = $faculty.$cellvalue."notinsetupFaculty";
								break;
							}
							if($cellvalue!=$_COOKIE['_faculty']){
								$resp = "Faculty Code in Excel File - ".$cellvalue." does not match Faculty Code Selected - ".$_COOKIE['_faculty'];
								break;
							}
							$faculty=$cellvalue;
						}
						if($i==2 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM departmentstable where departmentdescription ='{$cellvalue}'";
							$department = checkCode($query);
							if($department=="notinsetup"){
								$resp = $department.$cellvalue."notinsetupDepartment";
								break;
							}
							if($cellvalue!=$_COOKIE['_department']){
								$resp = "Department Code in Excel File - ".$cellvalue." does not match Department Code Selected - ".$_COOKIE['_department'];
								break;
							}
							$department=$cellvalue;
						}
						if($i==3 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM programmestable where programmedescription ='{$cellvalue}'";
							$programme = checkCode($query);
							if($programme=="notinsetup"){
								$resp = $programme.$cellvalue."notinsetupProgramme";
								break;
							}
							if($cellvalue!=$_COOKIE['_programme']){
								$resp = "Programme Code in Excel File - ".$cellvalue." does not match Programme Code Selected File - ".$_COOKIE['_programme'];
								break;
							}
							$programme=$cellvalue;
						}
						if($i==4 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM studentslevels where leveldescription ='{$cellvalue}'";
							$level = checkCode($query);
							if($level=="notinsetup"){
								$resp = $level.$cellvalue."notinsetupStudent_Level";
								break;
							}
							if($cellvalue!=$_COOKIE['_studentlevel']){
								$resp = "Student_Level in Excel File - ".$cellvalue." does not match Student_Level Selected - ".$_COOKIE['_studentlevel'];
								break;
							}
							$level=$cellvalue;
						}
						if($i==5 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM sessionstable where sessiondescription ='{$cellvalue}'";
							$sessions = checkCode($query);
							if($sessions=="notinsetup"){
								$resp = $sessions.$cellvalue."notinsetupSessions";
								break;
							}
							if($cellvalue!=$_COOKIE['_sesions']){
								$resp = "Session Code in Excel File - ".$cellvalue." does not match Session Code Selected -  ".$_COOKIE['_sesions'];
								break;
							}
							$sessions=$cellvalue;
						}
						if($i==6 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM sessionstable where semesterdescription ='{$cellvalue}'";
							$semester = checkCode($query);
							if($semester=="notinsetup"){
								$resp = $semester.$cellvalue."notinsetupSessions";
								break;
							}
							if($cellvalue!=$_COOKIE['_semester']){
								$resp = "Semester Code in Excel File - ".$cellvalue." does not match Semester Code Selected - ".$_COOKIE['_semester'];
								break;
							}
							$semester=$cellvalue;
						}
						if($i==7 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM regularstudents where entryyear ='{$cellvalue}'";
							$groupsession = checkCode($query);
							if($groupsession=="notinsetup"){
								$resp = $groupsession.$cellvalue."notinsetupStudents_Details";
								break;
							}
							if($cellvalue!=$_COOKIE['_groupsession']){
								$resp = "Group Code in Excel File - ".$cellvalue." does not match Group Code Selected - ".$_COOKIE['_groupsession'];
								break;
							}
							$groupsession=$cellvalue;
						}
						if($i==8 && $j==1){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM coursestable where coursecode ='{$cellvalue}'";
							$coursecode = checkCode($query);
							if($coursecode=="notinsetup"){
								$resp = $coursecode.$cellvalue."notinsetupCourse_Code";
								break;
							}
							if($cellvalue!=$_COOKIE['_coursecode']){
								$resp = "Course_Code in Excel File - ".$cellvalue." does not match Course_Code Selected - ".$_COOKIE['_coursecode'];
								break;
							}
							$coursecode=$cellvalue;
						}
						if($i>8){
							if($j==1) $matricno = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM regularstudents where regNumber ='{$matricno}'";
							$result = mysql_query($query, $connection);
							if(mysql_num_rows($result) == 0 && $matricno>""){
								$resp = "Invalid_Matric No in Excel File - ".$matricno;
								break;
							}
							if($j==2){
								$marksobtained = trim($data->sheets[0]['cells'][$i][$j])."";
								if(IsNaN($marksobtained)){
									$resp = "The mark [".$marksobtained."] for $matricno must be numeric"; 
									break;
								}
								$marksobtained = doubleval($marksobtained);
								$query = "SELECT * FROM examresultstable where sessiondescription ='{$sessions}' and semester ='{$semester}' and coursecode ='{$coursecode}' and registrationnumber ='{$matricno}' and marksdescription ='{$marksdescription}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and studentlevel ='{$level}' and groupsession ='{$groupsession}'";
								$result = mysql_query($query, $connection);
								if(mysql_num_rows($result) == 0){
									$query = "INSERT INTO examresultstable (sessiondescription, semester, coursecode, registrationnumber, marksdescription, marksobtained, marksobtainable, percentage, studentlevel, programmecode, facultycode, departmentcode, groupsession) VALUES ('{$sessions}', '{$semester}', '{$coursecode}', '{$matricno}', '{$marksdescription}', '{$marksobtained}', '{$marksobtainable}', '{$percentage}', '{$level}', '{$programme}', '{$faculty}', '{$department}', '{$groupsession}')";
								}else{
									$query = "UPDATE examresultstable set marksobtained='{$marksobtained}' where sessiondescription ='{$sessions}' and semester ='{$semester}' and coursecode ='{$coursecode}' and registrationnumber ='{$matricno}' and marksdescription ='{$marksdescription}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and studentlevel ='{$level}' and groupsession ='{$groupsession}'";
								}
								$result = mysql_query($query, $connection);

								updateFinalMarks($sessions, $semester, $coursecode, $matricno, $level, $programme, "", $faculty, $department, $groupsession);
								$query = "DELETE FROM retakecourses where sessiondescription='{$sessions}' and semester='{$semester}' and coursecode='{$coursecode}' and registrationnumber='{$matricno}' and facultycode ='{$faculty}' and departmentcode ='{$department}' and programmecode ='{$programme}' and studentlevel ='{$level}' and groupsession ='{$groupsession}'";
								mysql_query($query, $connection);
							}
						}
					}
								
					if($resp != "successful") break;
				}
			}else{
				$results = 0;
				$resp = "file not uploaded";
			}
			sleep(1);
			$resp = str_replace(" ", "_", $resp);
			setcookie("resp", $resp, false);
		}
	}
					//$query = "INSERT INTO activities (userEmail, descriptions, activityDate, activityTime) VALUES ('{$currentusers}', '{$_FILES['txtFile']['type']}', '{$ftype}', '{$results}')";
					//mysql_query($query, $connection);

	//if(ereg("application/vnd.ms-excel", $_FILES['txtFile']['type']) || ereg("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", $_FILES['txtFile']['type'])) {
	//if(str_in_str($_FILES['txtFile']['type'], "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || str_in_str($_FILES['txtFile']['type'], "application/vnd.ms-excel") ){

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
$success="1";
?>
<script language="javascript" type="text/javascript">
	window.top.window.stopUpload(<?php echo $results; ?>);
</script>
