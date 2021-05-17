<?php
	include("data.php");
		$array = array(); //define the array
		$param = explode("][", $param);
		$sesionss=$param[0];
		$semesters=$param[1];
$sesionss="2008/2009";
$semesters="1ST";

		//set random # range
		$minNum = 0;
		$maxNum = 0;
		$maxSno = 0;
		$maxPerBatch = 10000;

		$query = "select count(serialno) as maxserialno from uniquereferencenumbers where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) == 0){
			$minNum = 1111567890;
			$maxNum = 1112567890;
		}else{
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$maxSno=$row[0];
			}
			$modulusMaxNo = $maxSno % 10000;
echo $modulusMaxNo."   modulusMaxNo<br>";
			if($modulusMaxNo==0){
				$query = "select max(serialno) as maxserialno from uniquereferencenumbers where sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and useflag='open' ";
echo $query."   query<br>";
				$result = mysql_query($query, $connection);
echo mysql_num_rows($result)."    mysql_num_rows<br>";
				if(mysql_num_rows($result) > 0){
					echo "pinsavailable";
					return true;
				}
			}
			$maxPerBatch = 10000 - $modulusMaxNo;
			$minNum = 1111567890 + (intval(($maxSno * 100) / 1000000) * 1000000);
			$maxNum = $minNum + 1000000;
		}
		$query = "select uniquereferencenumber from uniquereferencenumbers where  sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' and uniquereferencenumber between $minNum and  $maxNum ";
		$result = mysql_query($query, $connection);
		$i=0;
		if(mysql_num_rows($result)> 0){
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$array[$i++] = $row[0];
			}
		}

		for($i = 1; $i <= $maxPerBatch; $i++){
			$num1 = GenerateRandomNumber($minNum, $maxNum);   
			while(in_array($num1, $array)){
				$num1 = GenerateRandomNumber($minNum, $maxNum);
			}   
			$query = "SELECT uniquereferencenumber FROM uniquereferencenumbers where uniquereferencenumber = '{$num1}' and  sessiondescription='{$sesionss}' and semesterdescription='{$semesters}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "INSERT INTO uniquereferencenumbers (uniquereferencenumber, sessiondescription, semesterdescription) VALUES ('{$num1}', '{$sesionss}', '{$semesters}')";
				mysql_query($query, $connection);
			}else{
				--$i;
				continue;
			}
			$array[$i] = $num1;
		}
?>
