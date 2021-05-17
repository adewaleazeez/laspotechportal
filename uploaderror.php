<?php
	header("Content-type: application/x-msdownload"); 
	//header("Content-type: application/msword"); 
	header("Content-Disposition: attachment; filename=excel.xls"); 
	//header("Content-Disposition: attachment; filename=msword.doc"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	echo "$header"; 
	include("data.php"); 

	$currentusers = $_COOKIE['currentuser'];

	$query = "select report from currentrecord where currentuser ='{$currentusers}'";

	$result=mysql_query($query, $connection);
	$reports="";
	if(mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_array($result)) {
			extract ($row);
			$reports=$report;
		}
		echo "<table border='1'>";

		$reports=substr($reports,0,strlen($reports)-3);
		$rows = explode("_~_", $reports);
		foreach($rows as $row){
			$cols = explode("~", $row);
			$detail="<tr>";
			foreach($cols as $col){
				$detail.="<td>".$col."</td>";
			}
			$detail.="</tr>";
			echo $detail;
		}
		echo "</table>";
	}

?>

