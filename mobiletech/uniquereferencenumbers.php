<?php

/*echo '0 % 10000 = ';
echo 0 % 10000;
echo '<br>';
echo '9854 % 10000 = ';
echo 9854 % 10000;
echo '<br>';
echo '12314 % 10000 = ';
echo 12314 % 10000;
echo '<br>';
echo '12314 / 10000 = ';
echo intval(12314 / 10000);
return true;*/
	include("data.php");
	$array = array(); //define the array

	//set random # range
	$minNum = 0;
	$maxNum = 0;
	$maxSno = 0;
	$maxPerBatch = 10000;

	$query = "select max(serialno) as maxserialno from uniquereferencenumbers ";
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
		$maxPerBatch = 10000 - $modulusMaxNo;
		$minNum = 1111567890 + (intval(($maxSno * 100) / 1000000) * 1000000);
		$maxNum = $minNum + 1000000;
	}
	$query = "select uniquereferencenumber from uniquereferencenumbers where uniquereferencenumber between $minNum and  $maxNum ";
	$result = mysql_query($query, $connection);
	$i=0;
	if(mysql_num_rows($result)> 0){
		while ($row = mysql_fetch_row($result)) {
			extract ($row);
			$array[$i++] = $row[0];
		}
	}

	function GenerateRandomNumber($minNum, $maxNum){
	   return round(rand($minNum, $maxNum));
	}

	$date1 = time();
	echo $date1.'     time1<br>';
	echo $maxPerBatch.'    maxPerBatch<br>';
	echo $minNum.'    minNum<br>';
	echo $maxNum.'    maxNum<br>';
	echo '<ol>';
	for($i = 1; $i <= $maxPerBatch; $i++){
		$num1 = GenerateRandomNumber($minNum, $maxNum);   
		while(in_array($num1, $array)){
			$num1 = GenerateRandomNumber($minNum, $maxNum);
		}   
		$query = "SELECT uniquereferencenumber FROM uniquereferencenumbers where uniquereferencenumber = '{$num1}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) == 0){
			$query = "INSERT INTO uniquereferencenumbers (uniquereferencenumber) VALUES ('{$num1}')";
			mysql_query($query, $connection);
		}else{
			--$i;
			continue;
		}
		echo '<li>';
		echo '     '.$num1;
		echo '</li>';
		$array[$i] = $num1;
	}
	echo '</ol>';

	$date2 = time();
	echo $date2.'   time2<br>';
	$mins = ($date2 - $date1) / 60;
	echo 'time taken:   '.$mins.'minutes';

	/*asort($array); //just want to sort the array
	//sleep(2000);

	//this simply prints the list of #s in list style
	echo '<ol>';
	foreach ($array as $var){
		echo '<li>';
		echo $var;
		echo '</li>';
	}
	echo '</ol>';*/


?>