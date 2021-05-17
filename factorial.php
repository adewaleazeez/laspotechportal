<?php 
	$number =5;
	
	echo $number." factorial is ".factorial($number);

	function factorial($number){
		if($number==1) {
			return $number;
		}else{
			return factorial($number - 1) * $number;
		}
	}
?>
