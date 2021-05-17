<?php
setcookie("rsp", "", false);
	$results = 0;
	$ftype = $_GET['ftype'];
	include("data.php");
	$target_path = "";

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
				$sessions="";
				$semester="";
				$tablename="";
				$resp = "successful";
				$headerline="";
				$valueline="";
				setcookie('rsp', "", false);

				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
					if(trim($data->sheets[0]['cells'][$i][1]).""=="") break;
					for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {

						if(trim($data->sheets[0]['cells'][$i][$j]).""=="Table Name:"){
							$tablename=trim($data->sheets[0]['cells'][$i][2]);
							$i++; //skipp table header in excel
							$headerline="";
							$valueline="";
							break;
						}
						if($i==1 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM facultiestable where facultydescription ='{$cellvalue}'";
							$faculty = checkCode($query);
							if($faculty=="notinsetup"){
								$resp = $faculty.$cellvalue."notinsetupSchool";
								break;
							}
							if($cellvalue!=str_replace('_coma', ',',$_COOKIE['_faculty'])){
								$resp = "School Code in Excel File ".trim($cellvalue)." does not match School Code Selected ".str_replace('_coma', ',',trim($_COOKIE['_faculty']));
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
							if($cellvalue!=str_replace('_coma', ',',$_COOKIE['_department'])){
								$resp = "Department Code in Excel File ".trim($cellvalue)." does not match Department Code Selected ".str_replace('_coma', ',',trim($_COOKIE['_department']));
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
							if($cellvalue!=str_replace('_coma', ',',$_COOKIE['_programme'])){
								$resp = "Programme Code in Excel File ".trim($cellvalue)." does not match Programme Code Selected File ".str_replace('_coma', ',',trim($_COOKIE['_programme']));
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
							if($cellvalue!=str_replace('_coma', ',',$_COOKIE['_studentlevel'])){
								$resp = "Student_Level in Excel File ".trim($cellvalue)." does not match Student_Level Selected ".str_replace('_coma', ',',trim($_COOKIE['_studentlevel']));
								break;
							}
							$level=$cellvalue;
						}
						if($i==5 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM sessionstable where sessiondescription ='{$cellvalue}'";
							$sessions = checkCode($query);
							if($sessions=="notinsetup"){
								$resp = str_replace("/"," ",$sessions).str_replace("/"," ",$cellvalue).$cellvalue."notinsetupSessions";
								break;
							}
							if($cellvalue!=str_replace('_coma', ',',$_COOKIE['_sesions'])){
								$resp = "Session Code in Excel File ".trim(str_replace("/"," ",$cellvalue))." does not match Session Code Selected  ".str_replace('_coma', ',',trim(str_replace("/"," ",$_COOKIE['_sesions'])));
								break;
							}
							$sessions=$cellvalue;
						}
						if($i==6 && $j==2){
							$cellvalue = trim($data->sheets[0]['cells'][$i][$j])."";
							$query = "SELECT * FROM sessionstable where semesterdescription ='{$cellvalue}'";
							$semester = checkCode($query);
							if($semester=="notinsetup"){
								$resp = $semester.$cellvalue."notinsetupSemester";
								break;
							}
							if($cellvalue!=str_replace('_coma', ',',$_COOKIE['_semester'])){
								$resp = "Semester Code in Excel File ".trim($cellvalue)." does not match Semester Code Selected ".str_replace('_coma', ',',trim($_COOKIE['_semester']));
								break;
							}
							$semester=$cellvalue;
						}

						if($tablename=="amendedreasons"){
							$headerline = "serialno**facultycode**departmentcode**programmecode**groupsession**studentlevel**sessiondescription**semester**coursecode**amendedtitle**amendreason";
							$colcount=11;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==7) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==8) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==9) $coursecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==10) $amendedtitles = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM amendedreasons where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}' and amendedtitle='{$amendedtitles}' ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO amendedreasons (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE amendedreasons set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}' and amendedtitle='{$amendedtitles}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="amendedresults"){
							$headerline = "serialno**sessiondescription**semester**coursecode**registrationnumber**marksdescription**marksobtained**marksobtainable**percentage**studentlevel**programmecode**facultycode**departmentcode**groupsession**amendreason**previousmark**amendedmark**amendedgradecode**amendedgradeunit**amendedtitle**previousgradecode**previousgradeunit**previoustitle";
							$colcount=23;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==12) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==13) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==11) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==2) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $coursecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $registrationnumbers = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($registrationnumbers,0,1)=="'") $registrationnumbers = substr($registrationnumbers,1);
							if($j==10) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";

	
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM amendedresults where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO amendedresults (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE amendedresults set (".$record.")s where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="cgpatable"){
							$headerline = "serialno**cgpacode**lowerrange**upperrange**qualification**sessions";
							$colcount=6;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $cgpacodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $qualifications = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $sessionss = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM cgpatable where cgpacode='{$cgpacodes}' and qualification='{$qualifications}' and sessions='{$sessionss}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO cgpatable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE cgpatable set (".$record.") where cgpacode='{$cgpacodes}' and qualification='{$qualifications}' and sessions='{$sessionss}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="coursestable"){
							$headerline = "serialno**coursecode**coursedescription**courseunit**coursetype**minimumscore**programmecode**lecturerid**facultycode**departmentcode**sessiondescription**semesterdescription**studentlevel**groupsession**studentype**coursetypegroup";
							$colcount=14;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==9) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==10) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==7) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==11) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==12) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==13) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==2) $coursecodes = trim($data->sheets[0]['cells'][$i][$j])."";

							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM coursestable where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semesterdescription='{$semesters}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}' ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO coursestable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE coursestable set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semesterdescription='{$semesters}' and studentlevel='{$studentlevels}' and coursecode='{$coursecodes}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="departmentstable"){
							$headerline = "serialno**departmentdescription**facultycode**hod";
							$colcount=4;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $departmentdescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM departmentstable where departmentdescription='{$departmentdescriptions}' and facultycode='{$facultycodes}'";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO departmentstable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE departmentstable set (".$record.") where departmentdescription='{$departmentdescriptions}' and facultycode='{$facultycodes}'";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="examresultstable"){
							$headerline = "serialno**sessiondescription**semester**coursecode**registrationnumber**marksdescription**marksobtained**marksobtainable**percentage**studentlevel**programmecode**facultycode**departmentcode**groupsession";
							$colcount=14;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==12) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==13) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==11) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==2) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $coursecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $registrationnumbers = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($registrationnumbers,0,1)=="'") $registrationnumbers = substr($registrationnumbers,1);
							if($j==10) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";

							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM examresultstable where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO examresultstable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE examresultstable set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="facultiestable"){
							$headerline = "serialno**facultydescription**dof";
							$colcount=3;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $facultydescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM facultiestable where facultydescription='{$facultydescriptions}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO facultiestable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE facultiestable set (".$record.") where facultydescription='{$facultydescriptions}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="finalresultstable"){
							$headerline = "serialno**sessiondescription**semester**coursecode**registrationnumber**marksobtained**gradecode**gradeunit**studentlevel**programmecode**coursestatus**facultycode**departmentcode**groupsession";
							$colcount=14;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==12) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==13) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==10) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==2) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $coursecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $registrationnumbers = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($registrationnumbers,0,1)=="'") $registrationnumbers = substr($registrationnumbers,1);
							if($j==9) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";

							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM finalresultstable where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO finalresultstable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE finalresultstable set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="gradestable"){
							$headerline = "serialno**gradecode**lowerrange**upperrange**gradeunit**qualification**sessions";
							$colcount=7;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $gradecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $qualifications = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==7) $sessionss = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM gradestable where gradecode='{$gradecodes}' and qualification='{$qualifications}' and sessions='{$sessionss}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO gradestable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE gradestable set (".$record.") where gradecode='{$gradecodes}' and qualification='{$qualifications}' and sessions='{$sessionss}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="mastereportbackup"){
							$headerline = "serialno**sessions**semester**facultycode**departmentcode**programmecode**studentlevel**reportline";
							$colcount=8;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $sessionss = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==7) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==8) $reportlines = substr(trim($data->sheets[0]['cells'][$i][$j]),0,51)."";
							if(substr($reportlines,0,1)=="'") $reportlines = substr($reportlines,1);
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM mastereportbackup where sessions='{$sessionss}' and semester='{$semesters}' and facultycode='{$facultycodes}'  and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}'  and substr(reportline,1,50)='{$reportlines}'  ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";

								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO mastereportbackup (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE mastereportbackup set (".$record.") where sessions='{$sessionss}' and semester='{$semesters}' and facultycode='{$facultycodes}'  and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and studentlevel='{$studentlevels}' and reportline='{$reportlines}'  ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="programmestable"){
							$headerline = "serialno**programmedescription**departmentcode**courseadvisor";
							$colcount=4;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $facultydescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM programmestable where facultydescription='{$facultydescriptions}' and departmentcode='{$departmentcodes}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO programmestable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE programmestable set (".$record.") where facultydescription='{$facultydescriptions}' and departmentcode='{$departmentcodes}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="qualificationstable"){
							$headerline = "serialno**qualificationcode**qualificationdescription";
							$colcount=3;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $qualificationcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM qualificationstable where qualificationcode='{$qualificationcodes}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO qualificationstable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE qualificationstable set (".$record.") where qualificationcode='{$qualificationcodes}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="registration"){
							$headerline = "serialno**regNumber**studentlevel**sessions**semester**registered";
							$colcount=6;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $regNumbers = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($regNumbers,0,1)=="'") $regNumbers = substr($regNumbers,1);
							if($j==3) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $sessionss = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $registereds = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM registration where sessions='{$sessionss}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and regNumber='{$regNumbers}' and registered='{$registereds}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO registration (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE registration set (".$record.") where sessions='{$sessionss}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and regNumber='{$regNumbers}' and registered='{$registereds}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="regularstudents"){
							$headerline = "serialno**regNumber**firstName**lastName**facultycode**departmentcode**programmecode**gender**dateOfBirth**userName**userPassword**middleName**userEmail**userAddress**postCode**userPicture**userType**active**validate**receiptNo**pinNo**confirmNo**payApproved**maidenName**contactAddress**nationality**originState**lga**birthPlace**maritalStatus**religion**spouseName**title**guardianName**guardianAddress**guardianRelationship**disability**wascresults**cgpacode**supportindocuments**studentlevel**guardianEmail**ignorepay**lockrec**qualificationcode**minimumunit**tcp**tnu**gpa**tnup**entryyear**phoneno**guardianphoneno**admissiontype**carryover";
							$colcount=55;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $regNumbers = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($regNumbers,0,1)=="'") $regNumbers = substr($regNumbers,1);
							if($j==5) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==7) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM regularstudents where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and regNumber='{$regNumbers}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO regularstudents (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE regularstudents set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and regNumber='{$regNumbers}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="remarkstable"){
							$headerline = "serialno**matricno**remark";
							$colcount=3;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $matricnos = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($matricnos,0,1)=="'") $matricnos = substr($matricnos,1);
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM remarkstable where matricno='{$matricnos}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO remarkstable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE remarkstable set (".$record.") where matricno='{$matricnos}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="retakecourses"){
							$headerline = "serialno**sessiondescription**semester**coursecode**registrationnumber**coursestatus**facultycode**departmentcode**programmecode**studentlevel**groupsession";
							$colcount=11;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $coursecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==5) $registrationnumbers = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($registrationnumbers,0,1)=="'") $registrationnumbers = substr($registrationnumbers,1);
							if($j==7) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==8) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==9) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==10) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";

							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM retakecourses where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO retakecourses (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE retakecourses set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' and coursecode='{$coursecodes}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="schoolinformation"){
							$headerline = "serialno**schoolname**addressline1**addressline2**addressline3**addressline4**telephonenumber**faxnumber**emailaddress";
							$colcount=9;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $schoolnames = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM schoolinformation where schoolname='{$schoolnames}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO schoolinformation (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE schoolinformation set (".$record.") where schoolname='{$schoolnames}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="sessionstable"){
							$headerline = "serialno**sessiondescription**semesterdescription**semesterstartdate**semesterenddate**currentperiod";
							$colcount=6;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $semesterdescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM sessionstable where sessiondescription='{$sessiondescriptions}' and semesterdescription='{$semesterdescriptions}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO sessionstable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE sessionstable set (".$record.") where sessiondescription='{$sessiondescriptions}' and semesterdescription='{$semesterdescriptions}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="signatoriestable"){
							$headerline = "serialno**signatoryposition**signatoryname";
							$colcount=3;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $signatorypositions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $signatorynames = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM signatoriestable where signatoryposition='{$signatorypositions}' and signatoryname='{$signatorynames}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO signatoriestable (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE signatoriestable set (".$record.") where signatoryposition='{$signatorypositions}' and signatoryname='{$signatorynames}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="specialfeatures"){
							$headerline = "serialno**registrationnumber**sessiondescription**semester**feature**facultycode**departmentcode**programmecode**studentlevel**groupsession";
							$colcount=10;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $registrationnumbers = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($registrationnumbers,0,1)=="'") $registrationnumbers = substr($registrationnumbers,1);
							if($j==3) $sessiondescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==4) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==6) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==7) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==8) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==9) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";

							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM specialfeatures where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' ";
								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO specialfeatures (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE specialfeatures set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessiondescription='{$sessiondescriptions}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and registrationnumber='{$registrationnumbers}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="studentslevels"){
							$headerline = "serialno**leveldescription**examofficer";
							$colcount=3;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $leveldescriptions = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==3) $examofficers = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM studentslevels where leveldescription='{$leveldescriptions}' and examofficer='{$examofficers}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO studentslevels (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE studentslevels set (".$record.") where leveldescription='{$leveldescriptions}' and examofficer='{$examofficers}' ";
								}
								mysql_query($query, $connection);
								break;
							}
						}

						if($tablename=="summaryreport"){
							$headerline = "serialno**matricno**fullname**gender**cgpa**ctnup**remark**reporttype**sessions**semester**facultycode**departmentcode**programmecode**studentlevel";
							$colcount=14;
							$datavalue = trim($data->sheets[0]['cells'][$i][$j])."**";
							if(substr($datavalue,0,1)=="'") $datavalue = substr($datavalue,1);
							$valueline .= $datavalue;
							if($j==2) $matricnos = trim($data->sheets[0]['cells'][$i][$j])."";
							if(substr($matricnos,0,1)=="'") $matricnos = substr($matricnos,1);
							if($j==9) $sessionss = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==10) $semesters = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==11) $facultycodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==12) $departmentcodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==13) $programmecodes = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==14) $studentlevels = trim($data->sheets[0]['cells'][$i][$j])."";
							if($j==$colcount){
								$valueline = substr($valueline, 0, strlen($valueline)-2);
								$headerlines = explode("**", $headerline);
								$valuelines = explode("**", $valueline);
								$query = "SELECT * FROM summaryreport where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessions='{$sessionss}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and matricno='{$matricnos}' ";

								$result = mysql_query($query, $connection);
								$headerline="";
								$valueline="";
								$record="";
								if(mysql_num_rows($result) == 0){
									for($x=1; $x<count($headerlines); $x++){
										$headerline .= $headerlines[$x].", ";
										$valueline .= "'".$valuelines[$x]."', ";
									}
									$headerline = substr($headerline, 0, strlen($headerline)-2);
									$valueline = substr($valueline, 0, strlen($valueline)-2);
									$query = "INSERT INTO summaryreport (".$headerline.") values (".$valueline.")";
								}else{
									for($x=1; $x<count($headerlines); $x++){
										$record .= $headerlines[$x] . "='".$valuelines[$x]."', ";
									}
									$record = substr($record, 0, strlen($record)-2);
									$query = "UPDATE summaryreport set (".$record.") where facultycode='{$facultycodes}' and departmentcode='{$departmentcodes}' and programmecode='{$programmecodes}' and sessions='{$sessionss}' and semester='{$semesters}' and studentlevel='{$studentlevels}' and matricno='{$matricnos}' ";
								}
								mysql_query($query, $connection);
								break;
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

	function getHeader($tablename){
		$query = "SELECT * FROM {$tablename} ";
		$result = mysql_query($query, $connection);
		$headerline="";
		$row = mysql_fetch_row($result);
		foreach($row as $i => $values){
			$meta = mysql_fetch_field($result, $i);
			$headerline .= $meta->name."][";
		}
		return $headerline;
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
</script>
