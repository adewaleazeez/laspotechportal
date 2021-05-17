<?php
	header("Content-type: application/x-msdownload"); 
	//header("Content-type: application/msword"); 
	header("Content-Disposition: attachment; filename=excel.xls"); 
	//header("Content-Disposition: attachment; filename=msword.doc"); 
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

	include("data.php");


	echo "<table border='1'>";
	
	echo "<tr><td>School</td><td colspan='2'>".$facultycode."</td></tr>";

	echo "<tr><td>Department</td><td colspan='2'>".$departmentcode."</td></tr>";

	echo "<tr><td>Programme</td><td colspan='2'>".$programmecode."</td></tr>";

	echo "<tr><td>Level</td><td colspan='2'>".$studentlevel."</td></tr>";

	$query = "SELECT distinct a.qualificationcode FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.facultycode='{$facultycode}' and a.departmentcode='{$departmentcode}' and a.programmecode='{$programmecode}' and b.sessions='{$sessions}' and b.semester='{$semester}' and b.studentlevel='{$studentlevel}' order by a.regNumber ";
	$result = mysql_query($query, $connection);
	$qualification="";
	if(mysql_num_rows($result) > 0){
		$sno=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$qualification=$qualificationcode;
		}
	}
	echo "<tr><td>Qualification to Obtain</td><td colspan='2'>".$qualification."</td></tr>";

	echo "<tr><td>Session</td><td colspan='2'>".$sessions."</td></tr>";

	echo "<tr><td>Semester</td><td colspan='2'>".$semester."</td></tr>";

	echo "<tr><td colspan='3'></td></tr>";

	echo "<tr><td>S/No</td><td>Title</td><td>Matric No</td><td>Surname</td><td>Firstname</td><td>Middle Name</td><td>Gender</td><td>Birth Date</td><td>Email Address</td><td>Phone No</td><td>Minimum Unit</td><td>Maiden Name</td><td>Nationality</td><td>Origin State</td><td>Marital Status</td><td>Passport Photo</td></tr>";


	$query = "SELECT a.*, b.sessions, b.semester, b.studentlevel FROM regularstudents a, registration b where a.regNumber=b.regNumber and a.facultycode='{$facultycode}' and a.departmentcode='{$departmentcode}' and a.programmecode='{$programmecode}' and b.sessions='{$sessions}' and b.semester='{$semester}' and b.studentlevel='{$studentlevel}' order by a.regNumber ";
	$result = mysql_query($query, $connection);

	if(mysql_num_rows($result) > 0){
		$sno=0;
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			echo "<tr><td>".++$sno."</td><td>".$title."</td><td>".$regNumber."</td><td>".$lastName."</td><td>".$firstName."</td><td>".$middleName."</td><td>".$gender."</td><td>".$dateOfBirth."</td><td>".$userEmail."</td><td>".$phoneno."</td><td>".$minimumunit."</td><td>".$maidenName."</td><td>".$nationality."</td><td>".$originState."</td><td>".$maritalStatus."</td><td>".$userPicture."</td></tr>";
		}
	}
	echo "</table>";
?>






