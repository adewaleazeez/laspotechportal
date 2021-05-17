<?php 
	/*$host='localhost';
	$dbname='laspotechdb';
	$user='root';
	$pass='aliyah';
	$DBHServer = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);*/

	$host='sptsr.db.5533865.hostedresource.com';
	$dbname='sptsr';
	$user='sptsr';
	$pass='Oy1nd@m0l@';
	$DBHServer = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
	$files = scandir('auxilliaryfiles/');
	$a=0;
    foreach($files as $a_file) { 
        if($a_file === '.' || $a_file === '..') continue;
		$filename='auxilliaryfiles/'.$a_file;
		$a_file = file_get_contents($filename);
		$a_file=substr($a_file, 0, strlen($a_file)-2);

		$rows = explode('\n', $a_file);
		$new_table=true;
		$header_row=true;
		$arraydata="";
		$column_list="";
		$tablename='';
$s=0;
$start=date("H:i:s");
		foreach($rows as $a_row) { 
			$fields="";
			$arraydata="";
			$datavalue="";
			$cols = explode('\t', $a_row);
			if($new_table){
				$tablename=$cols[0];
				$new_table=false;
				continue;
			}

			if($header_row){
				$a_row=substr($a_row, 0, strlen($a_row)-2);
				$cols = explode('\t', $a_row);
				foreach($cols as $key) {
					$column_list.=$key.'~';
				}
				$column_list=substr($column_list, 0, strlen($column_list)-1);
				$column_list = explode('~', $column_list);
				$header_row=false;
				continue;
			}

			$column_count=0;
			$recordfound=0;
			$serialno=0;
			$STHServer = $DBHServer->prepare("SELECT * FROM {$tablename} where serialno={$cols[0]} ");
			$STHServer->execute();
			$a_row=substr($a_row, 0, strlen($a_row)-2);
			$cols = explode('\t', $a_row);
			foreach($cols as $a_col) {
				//$meta[] = $DBHServer->getColumnMeta($a_col);
				if($a_col=='null') {
					//$a_col=null;
					$column_count++;
					continue;
				}
				if($serialno==0) $serialno=$a_col;
				if($STHServer->rowCount()==1){
					$recordfound=1;
					$arraydata[$column_count]=isset($a_col) ? $a_col : null;  //trim($a_col);
					$fields.=trim($column_list[$column_count]).'=?, ';
					$column_count++;
				}else{
					$fields.=trim($column_list[$column_count]).', ';
					$datavalue.=':'.trim($column_list[$column_count]).', ';
					$arraydata[trim($column_list[$column_count])]=isset($a_col) ? $a_col : null; //trim($a_col);
					$column_count++;
				}
			}

			$sql='';
			if($recordfound==1){
				$fields=substr($fields, 0, strlen($fields)-2);
				$arraydata[$column_count]=$serialno;
				$sql="update $tablename set $fields where serialno=? ";
			}else{
				$fields=substr($fields, 0, strlen($fields)-2);
				$datavalue=substr($datavalue, 0, strlen($datavalue)-2);
				$sql="INSERT INTO $tablename ($fields) VALUES ($datavalue) ";
			}
//echo 'A_column_list';
//print_r( $column_list).'   <br>';
print_r($arraydata).'   A';
echo $fields.'  B<br>';
echo $datavalue.'  C<br>';
echo (++$s).' '.'   '.$sql.'    D<br><br>';
//if(($s % 50)==0) echo '<br><br>';
//++$s;
			$STHServer=$DBHServer->prepare($sql);
			$STHServer->execute($arraydata);
//echo 'E_arraydata';
		}
		//unlink($filename);

		echo ++$a.'  '.$tablename.'  '.$filename.'  '.$start.'  '.Date("H:i:s").'   '.$s.' <br><br>';
    } 

?>