<?php
	//header("Content-type: application/x-msdownload"); 
	header("Content-type: application/msword"); 
	//header("Content-Disposition: attachment; filename=excel.xls"); 
	header("Content-Disposition: attachment; filename=msword.doc"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	echo "$header"; 

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

	$matricno = trim($_GET['matricno']);
	if($matricno == null) $matricno = "";

	include("data.php");

	function getCurrentGPA($sesion,$semester,$regno){
		$query = "SELECT * FROM finalresultstable where sessiondescription='{$sesion}' and semester='{$semester}' and registrationnumber='{$regno}' order by coursecode";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$coursecode}'";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0)	$tnup += $row2[1];
				}
			}
		}
		if($tnu>0) $gpa += number_format(($tcp/$tnu),2);
		return $tcp ."][". $tnu ."][". $gpa ."][". $tnup;
	}

	function getPreviousGPA($sesion,$semester,$regno){
		$query = "SELECT * FROM finalresultstable where ((sessiondescription='{$sesion}' and semester<'{$semester}') or (sessiondescription<'{$sesion}')) and registrationnumber='{$regno}' order by coursecode";
		include("data.php"); 
		
		$result = mysql_query($query, $connection);
		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$query2 = "SELECT coursecode, courseunit, minimumscore FROM coursestable where coursecode='{$coursecode}'";
				$result2 = mysql_query($query2, $connection);
				while ($row2 = mysql_fetch_array($result2)) {
					extract ($row2);
					$tcp += $row2[1] * $row[7];
					$tnu += $row2[1];
					if($row[7]>0)	$tnup += $row2[1];
				}
			}
		}
		if($tnu>0) $gpa += number_format(($tcp/$tnu),2);
		return $tcp ."][". $tnu ."][". $gpa ."][". $tnup;
	}

	$schoolnames = "";
	$query = "SELECT * FROM schoolinformation where schoolname<>''";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$schoolnames = $row[1] . ", " . $row[2];
		}
	}

	echo "<table border='3' style='border-color:#000000; border-style:solid; border-width:1px; height:10px; width:100%; background-color:#FFFFFF; margin-top:5px; font-size:10px'>";
	
	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6' align='center'><h3>".$schoolnames."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6' align='center'><h3>".$facultycode."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6' align='center'><h3>DEPARTMENT OF ".$departmentcode."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6' align='center'><h3>".$programmecode." PROGRAMME</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6' align='center'><h5>".$sessions." ".$semester." Examination Results</h5></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6' align='center'><h5>STUDENT TRANSCRIPT</h5></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='6' align='center'><h5>".$studentlevel."</h5></td></tr>";

	$query = "SELECT firstName, lastName, middleName, regNumber FROM regularstudents where regNumber='{$matricno}'";
	$result = mysql_query($query, $connection);
	$fullname = "";
	while ($row = mysql_fetch_array($result)) {
		extract ($row);
		$fullname = "<b>".strtoupper($row[1])."<b>, ".$row[0];
		if($row[2]>"") $fullname .= " ".$row[2];
	}

	echo "<tr style='font-weight:bold; color:#000000'>";
	echo "<td colspan='2' align='left'><h3>MATRIC NO: ".$matricno."</h3></td>";

	echo "<td colspan='4' align='right'><h3>STUDENT NAMES: ".$fullname."</h3></td></tr>";

	echo "<tr style='font-weight:bold; color:#000000'>";
    echo "<td algn='right'>S/NO</td><td>COURSE CODE</td><td>COURSE DESCRIPTION</td>";
	echo "<td>COURSE UNIT</td><td>GRADE</td><td>TCP</td></tr>";

	$query = "SELECT * FROM finalresultstable where sessiondescription='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' AND registrationnumber='{$matricno}'order by registrationnumber, coursecode";
	$result = mysql_query($query, $connection);
	if(mysql_num_rows($result) > 0){
		$count=1;
		$matno="";
		$tunit=0.0; $ttcp=0.0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$query2 = "SELECT coursecode, coursedescription, courseunit, minimumscore FROM coursestable where coursecode='{$coursecode}'";
			$result2 = mysql_query($query2, $connection);
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				$tcp = $row2[2] * $row[7];
				$tunit += doubleval($row2[2]);
				$ttcp += doubleval($tcp);
				echo "<tr style='font-weight:bold; color:#000000'>";
				echo "<td>".$count++.".</td><td>".$row2[0]."</td><td>".$row2[1]."</td>";
				echo "<td align='center'>".$row2[2]."</td><td align='center'>".$row[6]."</td>";
				echo "<td align='center'>".$tcp."</td></tr>";
			}
		}
		echo "<tr style='font-weight:bold; color:#000000'>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='right'>TOTAL</td>";
		echo "<td align='center'>".$tunit."</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>".$ttcp."</td></tr>";

		echo "<tr style='font-weight:bold; color:#000000'>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>&nbsp;</td></tr>";

		echo "<tr style='font-weight:bold; color:#000000'>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='center'>TCP</td>";
		echo "<td align='center'>TNU</td>";
		echo "<td align='center'>GPA</td>";
		echo "<td align='center'>TNUP</td></tr>";

		$curGP = getCurrentGPA($sessions,$semester,$matricno);
		$theCurGPs = explode("][", $curGP);
		echo "<tr style='font-weight:bold; color:#000000'>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='right'>CURRENT</td>";
		echo "<td align='center'>".$theCurGPs[0]."</td>";
		echo "<td align='center'>".$theCurGPs[1]."</td>";
		echo "<td align='center'>".number_format($theCurGPs[2],2)."</td>";
		echo "<td align='center'>".$theCurGPs[3]."</td></tr>";

		$tcp=0.0; $tnu=0.0; $gpa=0.0; $tnup=0.0; 
		$query2 = "SELECT regNumber, tcp, tnu, gpa, tnup FROM regularstudents where regNumber='{$matricno}'";
		$result2 = mysql_query($query2, $connection);
		if(mysql_num_rows($result2) > 0){
			while ($row2 = mysql_fetch_array($result2)) {
				extract ($row2);
				$tcp=$row2[1]; 
				$tnu=$row2[2]; 
				$gpa=$row2[3]; 
				$tnup=$row2[4];
			}
		}

		$cgpa = number_format((doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))/ (doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu)),2);
		$ctnup = (doubleval($theCurGPs[3])+doubleval($thePreGPs[3])+doubleval($tnup));

		$preGP = getPreviousGPA($sessions,$semester,$matricno);
		$thePreGPs = explode("][", $preGP);
		echo "<tr style='font-weight:bold; color:#000000'>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='right'>PREVIOUS</td>";
		echo "<td align='center'>".(doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
		echo "<td align='center'>".(doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
		echo "<td align='center'>".number_format(doubleval($thePreGPs[2])+doubleval($gpa),2)."</td>";
		echo "<td align='center'>".(doubleval($thePreGPs[3])+doubleval($tnup))."</td></tr>";
					
		echo "<tr style='font-weight:bold; color:#000000'>";
		echo "<td align='center'>&nbsp;</td>";
		echo "<td align='right'>CUMMULATIVE</td>";
		echo "<td align='center'>".(doubleval($theCurGPs[0])+doubleval($thePreGPs[0])+doubleval($tcp))."</td>";
		echo "<td align='center'>".(doubleval($theCurGPs[1])+doubleval($thePreGPs[1])+doubleval($tnu))."</td>";
		echo "<td align='center'>".number_format($cgpa,2)."</td>";
		echo "<td align='center'>".$ctnup."</td>";
	}

	echo "</table>";
?>
