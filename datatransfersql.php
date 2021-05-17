<?php 
	$currentusers = $_COOKIE['currentuser'];
//echo "uploadRecords".$currentusers;
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

	//$host='sptsr.db.5533865.hostedresource.com';
	//$dbname='sptsr';
	//$user='sptsr';
	//$pass='Oy1nd@m0l@';
	//$DBHonline = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  

	$host='localhost';
	$dbname='laspotechonline';
	$user='root';
	$pass='aliyah';
	$DBHonline = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  

	$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=?, report=?  WHERE currentuser=?";
	$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
	$STHlocalCurrentrecord->execute(array('', '', $currentusers));
	//setcookie("currentreport", "", false);

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
			if($departmentcodes != "")
				$whereclause .= " where departmentdescription='{$departmentcodes}' "; 
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
			if($facultycodes != "")
				$whereclause .= " where facultydescription='{$facultycodes}' "; 
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
			if($programmecodes != "")
				$whereclause .= " where programmedescription='{$programmecodes}' ";
		}
		if($code=="table10"){
			$tablename='qualificationstable';
		}
		if($code=="table11"){
			$tablename='registration';
			//$whereclause=" where sessions='{$sesionss}' and semester='{$semesters}' ";
			//if($studentlevels != "")
			//	$whereclause .= " and studentlevel='{$studentlevels}' "; 
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
		while($row = $STHlocal->fetch()) {
			$sno++;

			$currentrecordprocessings=$code."_-_".$recordcount."_-_".$sno;
			$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=? WHERE currentuser=?";
			$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
			$STHlocalCurrentrecord->execute(array($currentrecordprocessings,$currentusers));
				
			$fields="";
			$datavalue="";
			$arraydata="";
			$sql="";
			$recordfound=0;
			foreach($row as $key => $value) {
				if(is_numeric($key)) continue;
				if(!is_null($value)){
					$STHonline = $DBHonline->prepare('SELECT * FROM $tablename where serialno=$row[$count] ');
					$STHonline->execute();
					if($STHonline->rowCount()==1){
						$recordfound=1;
						$fields.="$key=?, ";
						//$arraydata.="'$value', ";
						$$key='$value';
					}else{
						$fields.="$key, ";
						$datavalue.=":$key, ";
						$arraydata[$key]=$value;
					}
				}
			}
			if($recordfound==1){
				$fields=substr($fields, 0, strlen($fields)-2);
				$arraydata.="$row[$count] ";
				$sql="update $tablename set $fields where serialno=? ";
			}else{
				$fields=substr($fields, 0, strlen($fields)-2);
				$datavalue=substr($datavalue, 0, strlen($datavalue)-2);
				$sql="INSERT INTO $tablename ($fields) VALUES ($datavalue) ";
			}
			$STHonlinecommit=$DBHonline->prepare($sql);
			$STHonlinecommit->execute($arraydata);
		}
		$currentrecordprocessings=$code."_-_".$recordcount."_-_".$sno."_-_Y";
		//if($recordcount==$sno) $currentrecordprocessings .= "Y";
		$sqlCurrentrecord = "UPDATE currentrecord SET currentrecordprocessing=? WHERE currentuser=?";
		$STHlocalCurrentrecord = $DBHlocal->prepare($sqlCurrentrecord);
		$STHlocalCurrentrecord->execute(array($currentrecordprocessings, $currentusers));
		echo "readCookies".$currentrecordprocessings;
		while(true){
			$STHonline = $DBHlocal->prepare("SELECT * FROM currentrecord where currentuser='{$currentusers}' and currentrecordprocessing<>'' ");
			$STHonline->execute();
			if($STHonline->rowCount()==0) break;
		}
	}
	echo "myStopFunction";

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


/*$sql = "INSERT INTO unitstable (serialno, facultycode, departmentcode, programmecode, studentlevel, sessiondescription, semesterdescription, maximumunit) VALUES (:serialno, :facultycode, :departmentcode, :programmecode, :studentlevel, :sessiondescription, :semesterdescription, :maximumunit) ";
$STHonlinecommit = $DBHonline->prepare($sql);
$STHonlinecommit->execute(array(':serialno'=>'1', ':facultycode'=>'PART-TIME STUDIES (REGULAR)', ':departmentcode'=>'BUILDING TECHNOLOGY', ':programmecode'=>'NATIONAL DIPLOMA', ':studentlevel'=>'NDI', ':sessiondescription'=>'2008/2009', ':semesterdescription'=>'1ST', ':maximumunit'=>'19'));

//$STHonlinecommit=$DBHonline->prepare($sql);
//$STHonlinecommit->execute(array($arraydata));

	$sql = "INSERT INTO books (title,author) VALUES (:title,:author)";
$q = $conn->prepare($sql);
$q->execute(array(':author'=>$author,':title'=>$title));

$title = 'PHP Pattern';
$author = 'Imanda';
$id = 3;
// query
$sql = "UPDATE books 
        SET title=?, author=?
        WHERE id=?";
$q = $conn->prepare($sql);
$q->execute(array($title,$author,$id));

# showing the results  
	while($row = $STH->fetch()) {  
		echo $row->serialno . "\n";  
		echo $row->regNumber . "\n";  
		echo $row->lastName . "\n";  
		echo $row->firstName . "\n\n\n<br>";  
# the data we want to insert  
$data = array( 'name' => 'Cathy', 'addr' => '9 Dark and Twisty', 'city' => 'Cardiff' );  
  
# the shortcut!  
$STH = $DBH->("INSERT INTO folks (name, addr, city) value (:name, :addr, :city)");  
$STH->execute($data);  

}*/



	//$query = "SELECT * FROM regularstudents '";
	//$result = mysql_query($query, $connectiononline);
	//echo mysql_num_rows($result);

?>