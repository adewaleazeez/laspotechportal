<?php
	$option = str_replace("'", "`", trim($_GET['option'])); 
	$host='sptsr.db.5533865.hostedresource.com';
	$dbname='sptsr';
	$user='sptsr';
	$pass='Oy1nd@m0l@';
	//$DBHServer = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
	$connection = mysql_pconnect($host,$user,$pass); 
	mysql_select_db($dbname);
	if(substr($option,0,17) == "readCookiesonline"){
		$query = "SELECT * FROM currentrecord where serialno=1 ";
		$result = mysql_query($query, $connection);
		$currentrecordprocessings="";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$currentrecordprocessings=$row['currentrecordprocessing'];
			}
		}
		echo $option.$currentrecordprocessings;

		/*$STHCurrentrecord = $DBHServer->query("SELECT * FROM currentrecord where serialno=1 ");
		$STHCurrentrecord->execute();
		$recordcount = $STHCurrentrecord->rowCount();
		$currentrecordprocessings="";
		if($recordcount > 0){
			while($row = $STHCurrentrecord->fetch()) {
				extract ($row);
				$currentrecordprocessings=$row['currentrecordprocessing'];
			}
		}
		echo $option.$currentrecordprocessings;*/
	}
?>
