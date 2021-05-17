<?php
/*	header("Content-type: application/x-msdownload"); 
	//header("Content-type: application/msword"); 
	header("Content-Disposition: attachment; filename=excel.xls"); 
	//header("Content-Disposition: attachment; filename=msword.doc"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	echo "$header"; 

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="excelexport.xls"');
header('Cache-Control: max-age=0'); */ 

	/** Include PHPExcel */
	require_once 'Classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();

	$sessions = trim($_GET['sessions']);
	if($sessions == null) $sessions = "";


	$semester = trim($_GET['semester']);
	if($semester == null) $semester = "";

	$facultycode = trim($_GET['facultycode']);
	if($facultycode == null) $facultycode = "";

	$departmentcode = trim($_GET['departmentcode']);
	if($departmentcode == null) $departmentcode = "";

	$programmecode = trim($_GET['programmecode']);
	if($programmecode == null) $programmecode = "";

	$studentlevel = trim($_GET['studentlevel']);
	if($studentlevel == null) $studentlevel = "";

	$coursecode = trim($_GET['matricno']);
	if($coursecode == null) $coursecode = "";

	include("data.php");

	$coursequery="";
	if(strtoupper($coursecode)=="ALL" || trim($coursecode)==""){
		$coursequery="select coursecode from coursestable where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semesterdescription='{$semester}' and studentlevel='{$studentlevel}'";
	}else{
		$coursequery="select coursecode from coursestable where coursecode='{$coursecode}' and facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semesterdescription='{$semester}' and studentlevel='{$studentlevel}'";
	}

	$courseresult = mysql_query($coursequery, $connection);
	if(mysql_num_rows($courseresult) > 0){
		$sheet = 0;
		$objPHPExcel->removeSheetByIndex(0);
		while ($courserow = mysql_fetch_array($courseresult)) {
			extract ($courserow);

			// Add new sheet
			$objWorkSheet = $objPHPExcel->createSheet($sheet); //Setting index when creating
			++$sheet;

			$objWorkSheet->setTitle($courserow['coursecode']);

			$objWorkSheet->setCellValueByColumnAndRow(0, 1, "School");
			$objWorkSheet->setCellValueByColumnAndRow(1, 1, $facultycode);

			$objWorkSheet->setCellValueByColumnAndRow(0, 2, "Department");
			$objWorkSheet->setCellValueByColumnAndRow(1, 2, $departmentcode);

			$objWorkSheet->setCellValueByColumnAndRow(0, 3, "Programme");
			$objWorkSheet->setCellValueByColumnAndRow(1, 3, $programmecode);

			$objWorkSheet->setCellValueByColumnAndRow(0, 4, "Level");
			$objWorkSheet->setCellValueByColumnAndRow(1, 4, $studentlevel);

			$objWorkSheet->setCellValueByColumnAndRow(0, 5, "Course Code");
			$objWorkSheet->setCellValueByColumnAndRow(1, 5, $courserow['coursecode']);

			$objWorkSheet->setCellValueByColumnAndRow(0, 6, "Session");
			$objWorkSheet->setCellValueByColumnAndRow(1, 6, $sessions);

			$objWorkSheet->setCellValueByColumnAndRow(0, 7, "Semester");
			$objWorkSheet->setCellValueByColumnAndRow(1, 7, $semester);

			$objWorkSheet->setCellValueByColumnAndRow(0, 9, "S/No");
			$objWorkSheet->setCellValueByColumnAndRow(1, 9, "Last Name");
			$objWorkSheet->setCellValueByColumnAndRow(2, 9, "Other Name");
			$objWorkSheet->setCellValueByColumnAndRow(3, 9, "Matric No");
			$objWorkSheet->setCellValueByColumnAndRow(4, 9, "CA Score");
			$objWorkSheet->setCellValueByColumnAndRow(5, 9, "Exam Score");
			$objWorkSheet->setCellValueByColumnAndRow(6, 9, "Total Score");

			$query = "SELECT a.*, (select b.lastName from regularstudents b where a.registrationnumber=b.regNumber) as surname, (select concat(b.firstName, ' ', b.middleName) from regularstudents b where a.registrationnumber=b.regNumber) as othername FROM finalresultstable a where a.registrationnumber>'' and a.facultycode='{$facultycode}' and a.departmentcode='{$departmentcode}' and a.programmecode='{$programmecode}' and a.sessiondescription='{$sessions}' and a.semester='{$semester}' and a.studentlevel='{$studentlevel}' and a.coursecode='".$courserow['coursecode']."'  order by a.registrationnumber ";

			$rows=9;
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$sno=0;
				while ($row = mysql_fetch_array($result)) {
					extract ($row);
					if($coursestatus=="Sick"){
						$marksobtained="S";
						$examscore="S";
					}
					if($coursestatus=="Absent"){
						$marksobtained="ABS";
						$examscore="ABS";
					}
					if($coursestatus=="Did Not Register"){
						$marksobtained="DNR";
						$examscore="DNR";
					}
					if($coursestatus=="Incomplete"){
						$marksobtained="I";
						$examscore="I";
					}
					$cols=0; ++$rows; ++$sno;
					$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $sno); ++$cols;
					$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $surname); ++$cols;
					$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $othername); ++$cols;
					$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $registrationnumber); ++$cols;
					$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $cascore); ++$cols;
					$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $examscore); ++$cols;
					$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $marksobtained);
				}
			}else{

				$query = "SELECT a.lastName as surname, concat(a.firstName, ' ', a.middleName) as othername, a.regNumber FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.facultycode='{$facultycode}' and a.departmentcode='{$departmentcode}' and a.programmecode='{$programmecode}' and b.sessions='{$sessions}' and b.semester='{$semester}' and b.studentlevel='{$studentlevel}' order by a.regNumber ";

				$result = mysql_query($query, $connection);

				if(mysql_num_rows($result) > 0){
					$sno=0;
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						$cols=0; ++$rows; ++$sno;
						$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $sno); ++$cols;
						$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $surname); ++$cols;
						$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $othername); ++$cols;
						$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $registrationnumber); ++$cols;
						$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $cascore); ++$cols;
						$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $examscore); ++$cols;
						$objWorkSheet->setCellValueByColumnAndRow($cols, $rows, $marksobtained);
					}
				}

			}
		}
	}

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save(str_replace('.php', '.xls', __FILE__));
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
	//$objWriter->save('php://output');
	//exit;
	
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
	//$objWriter->save('php://output');
?>
<script language="javascript" type="text/javascript">
  	var oWin = window.open("excelexport.xls");
	if (oWin==null || typeof(oWin)=="undefined"){
		alert("Popup must be enabled on this browser to see the report");
    }
</script>
