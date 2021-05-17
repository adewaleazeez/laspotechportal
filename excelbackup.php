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
	
	echo "<tr><td>Schoo:</td><td>".$facultycode."</td></tr>";

	echo "<tr><td>Department:</td><td>".$departmentcode."</td></tr>";

	echo "<tr><td>Programme:</td><td>".$programmecode."</td></tr>";

	echo "<tr><td>Level:</td><td>".$studentlevel."</td></tr>";

	echo "<tr><td>Session</td><td>".$sessions."</td></tr>";

	echo "<tr><td>Semester:</td><td>".$semester."</td></tr>";

	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM amendedreasons where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>amendedreasons</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM amendedresults where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>amendedresults</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM cgpatable where sessions='{$sessions}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>cgpatable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM coursestable where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semesterdescription='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>coursestable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM departmentstable where facultycode='{$facultycode}' and departmentdescription='{$departmentcode}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>departmentstable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM examresultstable where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>examresultstable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM facultiestable where facultydescription='{$facultycode}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>facultiestable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM finalresultstable where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>finalresultstable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM gradestable where sessions='{$sessions}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>gradestable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM mastereportbackup where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessions='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>mastereportbackup</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM programmestable where departmentcode='{$departmentcode}' and programmedescription='{$programmecode}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>programmestable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM qualificationstable ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>qualificationstable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM registration where sessions='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>registration</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM regularstudents where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' ";
	// and studentlevel='{$studentlevel}'
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>regularstudents</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM remarkstable ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>remarkstable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM retakecourses where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>retakecourses</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM schoolinformation ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>schoolinformation</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM sessionstable ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>sessionstable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM signatoriestable ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>signatoriestable</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM specialfeatures where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessiondescription='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>specialfeatures</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM studentslevels ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>studentslevels</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	$query = "SELECT * FROM summaryreport where facultycode='{$facultycode}' and departmentcode='{$departmentcode}' and programmecode='{$programmecode}' and sessions='{$sessions}' and semester='{$semester}' and studentlevel='{$studentlevel}' ";
	$result = mysql_query($query, $connection);
	echo "<tr><td>Table Name:</td><td>summaryreport</td></tr>";
	$theheader=0;
	$colcount=0;
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			if($theheader==0){
				$theheader=1;
				echo "<tr>";
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					echo "<td>".$meta->name."</td>";
					$colcount++;
				}
				echo "</tr>";
			}
			echo "<tr>";
			for($x=0; $x<$colcount; $x++){
				if(substr($row[$x],0,1)=='0'){
					echo "<td>'".$row[$x]."</td>";
				}else{
					echo "<td>".$row[$x]."</td>";
				}
			}
			echo "</tr>";
		}
	}
	//echo "<tr><td>&nbsp;</td></tr>";

	echo "</table>";




?>
