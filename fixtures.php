<?php
$noofclubs = 6;
$noofmatches = $noofclubs * ($noofclubs -1);
$noofweeks = ($noofclubs -1) * 2;
$fixtures="";
$fixtures=array();
for($k=0; $k<$noofmatches; $k++)$fixtures[$k] = array(array(""),array(""),array(""));
$count=0;
$k=0;
for($k=0; $k<($noofclubs/2); $k++){
	$fixtures[$k][0] = ++$count;
	$fixtures[$k][1] = ++$count;
	$fixtures[$k][2] = 1;
}

for($j=2; $j<=($noofweeks/2) ; $j++){
	if(($j % 2)==0){
		for($l=0; $l<(($noofclubs/2)-1); $l++){
			$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
			$fixtures[$k][1] = $fixtures[($k-($noofclubs/2))+1][0];
			$fixtures[$k][2] = $j;
			$k++;
		}
		$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
		$fixtures[$k][1] = $fixtures[$k-($noofclubs/2)-(($noofclubs/2)-1)][0];
		$fixtures[$k][2] = $j;
		$k++;
	}else{
		$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
		$fixtures[$k][1] = $fixtures[$k-1][1];
		$fixtures[$k][2] = $j;
		$k++;
		for($l=1; $l<(($noofclubs/2)-1); $l++){
			$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)][1];
			$fixtures[$k][1] = $fixtures[$k-($noofclubs/2)-1][0];
			$fixtures[$k][2] = $j;
			$k++;
		}
		$fixtures[$k][0] = $fixtures[$k-($noofclubs/2)-1][0];
		$fixtures[$k][1] = $fixtures[$k-($noofclubs/2)][0];
		$fixtures[$k][2] = $j;
		$k++;
	}
}

$m=0;
for(; $k<($noofmatches); $k++){
	$fixtures[$k][0] = $fixtures[$m][1];
	$fixtures[$k][1] = $fixtures[$m][0];
	$fixtures[$k][2] = intval($fixtures[$m][2])+($noofclubs -1);
	$m++;
}

for($k=0; $k<count($fixtures); $k++){
	echo $fixtures[$k][0].", ".$fixtures[$k][1].", ".$fixtures[$k][2]."   $k<br>\n";
}
?>
