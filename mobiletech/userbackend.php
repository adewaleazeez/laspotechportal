<?php
	$option = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['option']))); 
	$userNames = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['userName']))); 
	$serialnos = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['serialno'])));
	$userNames = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['userName']))); 
	$userPasswords = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['userPassword']))); 
	$firstNames = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['firstName']))); 
	$lastNames = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['lastName'])));
	$userTypes = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['userType'])));
	$accesss = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['access'])));
	$pages = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['page'])));
	$param = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['param'])));
	$menus = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['menu'])));
	$actives = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['active'])));
	$currentusers = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['currentuser'])));
	include("data.php");

	if($option == "getUser" || $option == "getPassword"){
		$query = "SELECT * FROM users where userName = '".$userNames."'";
		$result = mysql_query($query, $connection);
		$resp = "invalidusername";
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
            extract ($row);
			if($userNames == $userName){
				$resp = $option . $userName . $option . $firstName . $option . $lastName;
			}
		}
		echo $resp;
	}

	if($option == "loginUser"){
		/*$dates = date("Y-m-d");

		$query = "SELECT pinnumber FROM pintable where pinnumber>''";
		$result = mysql_query($query, $connection);
		$row = mysql_fetch_row($result); 
		extract ($row);

		if(mysql_num_rows($result) > 0){
			$query = "UPDATE pintable set pinnumber='{$dates}' where serialno = '{$serialno}'";
			mysql_query($query, $connection);
		}

		if($dates>="2011-06-30" && mysql_num_rows($result)==0){
			$query = "INSERT INTO pintable (pinnumber) VALUES ('{$dates}')";
			mysql_query($query, $connection);

		}

		$query = "SELECT pinnumber FROM pintable where pinnumber>''";
		$result = mysql_query($query, $connection);
		$row = mysql_fetch_row($result); 
		extract ($row);

		if(mysql_num_rows($result) > 0){
			$resp="licenceexpired";
		}else{*/
			$query = "SELECT * FROM users where userName = '".$userNames."'";
	        $resp = "invalidlogin";
			$result = mysql_query($query, $connection);

			if(mysql_num_rows($result) > 0){
				$row = mysql_fetch_array($result);
			    extract ($row);
				$samePassword = "";
				if($userName == $userNames && $userPassword == $userPasswords){
				//if(strtolower($firstName) == strtolower($userPassword)) $samePassword="true";
					$resp = "validlogin".$active;
					setcookie("currentuserfullname", $firstName." ".$lastName, false);
					setcookie("currentuser", $userName, false);
					setcookie("currentusertype", $userType, false);
					setcookie("currentdepartment", $department, false);
//					setcookie("currentusertype", $userType, time()+3600);
				}
			}
		//}
		echo $resp;
	}
		
	if($option == "logoutUser"){
		setcookie("currentuserfullname", null, false);
		setcookie("currentuser", null, false);
		setcookie("currentusertype", null, false);
		echo $option;
	}

	if($option == "getAllUsers" || $option == "getRecordlist"){
		$query = "SELECT * FROM users order by userName";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$flg = 1;
			$resp = "";
			$counter = 0;
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$resp .= $userName . "~_~" . $firstName . "~_~" . $lastName . "~_~" . $active . $option;
			}
		}
		echo $resp;
	}

	if($option == "insertUser"){
		$query = "SELECT * FROM users where  userName = '{$userNames}'";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) == 0){
			$userPasswords = strtolower($firstNames);
			$query = "INSERT INTO users (firstName, lastName, userName, userPassword, active) VALUES ('{$firstNames}', '{$lastNames}', '{$userNames}', '{$userPasswords}', '{$actives}')";
			$result = mysql_query($query, $connection);

			//$query = "select max(userName) as id from users";
			//$result = mysql_query($query, $connection);
			//$row = mysql_fetch_array($result);
			//extract ($row);
			echo "inserted";
		} else {
			echo "recordexists";
		}
	}

	if($option == "updateUser"){
		$query = "SELECT * FROM users where userName ='{$userNames}'";
		$result = mysql_query($query, $connection);
		$row = mysql_fetch_row($result); 
		extract ($row);
		$record="";
		//foreach($row as $i => $value){
		//	$meta = mysql_fetch_field($result, $i);
		//	$record .= "[".$meta->name. " - " . $value . "] ";
		//}
		//updateRecycleBin("[Table: users] ".$record,"Update",$currentusers);

		if(mysql_num_rows($result) > 0){
			$query = "UPDATE users set firstName='{$firstNames}',  lastName='{$lastNames}', active='{$actives}' where userName = '{$userNames}'";
			$result = mysql_query($query, $connection);

			echo "updated";
		} else {
			echo "recordnotexist";
		}
	}

	if($option == "changePass"){
		$query = "SELECT * FROM users where userName = '".$userNames."'";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
            extract ($row);
			$split_userPasswords = explode("][", $userPasswords);
			if($split_userPasswords[0] == $userPassword){
				$query = "UPDATE users set userPassword='{$split_userPasswords[1]}' where userName = '".$userNames."'";
				$result = mysql_query($query, $connection);
				echo "changePass";
			}else{
				echo "invalidpassword";
			}
		} else {
			echo "invalidusername";
		}
	}

	if($option == "getAllMenus"){
		$query = "select max(serialno) as id from usersmenu";
		$result = mysql_query($query, $connection);
		$row = mysql_fetch_array($result);
		extract ($row);
		$serialnos = $id;

		//$query="SELECT * FROM usersmenu where userName = ''";
		$query="SELECT distinct menuOption, serialno, userName, accessible, indexkey FROM usersmenu";
		$result = mysql_query($query, $connection);

		while ($row = mysql_fetch_array($result)) {
			extract ($row);

			$query2="SELECT * FROM usersmenu where userName = '".$userNames."' and menuOption = '{$menuOption}' ";
			$result2 = mysql_query($query2, $connection);
			if(mysql_num_rows($result2) == 0){
				++$serialnos;
				$query3="insert into usersmenu values ({$serialnos}, '{$userNames}', '{$menuOption}', 'No', {$indexkey})";
				mysql_query($query3, $connection);
			}
		}

		$resp = "getAllMenus";
		$query="SELECT * FROM usersmenu where userName = '".$userNames."' order by indexkey";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$resp .= $row[0] . "_~_" . $row[2] . "_~_" . $row[3] . "row_separator";
			}
		}
		if($userNames == "")  $resp = "getAllMenus";
		echo $resp;
	}

	if($option == "updateMenuLocks"){
		$parameter = explode("][", $param);
		$query = "update usersmenu set accessible='{$parameter[1]}' where serialno={$parameter[0]} and userName='{$parameter[2]}' ";
		mysql_query($query, $connection);

		$resp = "getAllMenus";
		$query="SELECT * FROM usersmenu where userName = '{$parameter[2]}' order by indexkey";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$resp .= $row[0] . "_~_" . $row[2] . "_~_" . $row[3] . "row_separator";
			}
		}
		echo $resp;
	}

	if($option == "changeAccess"){
		$query = "SELECT * FROM usersmenu where serialno = '{$serialnos}'";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);
				$query = "update usersmenu set accessible = '{$accesss}' where serialno = '{$serialnos}'";
				mysql_query($query, $connection);
		} else {
				echo "accessupdatefailed";
		}
	}

	if($option == "checkAccess"){
		$query = "SELECT * FROM usersmenu where userName = '{$currentusers}' and menuOption = '{$menus}'";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);

			if($accessible == "Yes"){
				$resp="checkAccessSuccess";
			}else{
				$resp="checkAccessFailed".$menus;
			}
		}else{
			$resp="checkAccessFailed".$menus;
		}
		echo $resp;
	}

?>
