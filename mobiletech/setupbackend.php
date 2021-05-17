<?php
	$option = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['option'])));
	$clientids = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['clientid'])));
	if($clientids==null) $clientids="";
	$ticket_statuss = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['ticket_status'])));
	if($ticket_statuss==null) $ticket_statuss="";
	$ticket_dates = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['ticket_date'])));
	if($ticket_dates==null) $ticket_dates="";
	$due_dates = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['due_date'])));
	if($due_dates==null) $due_dates="";
	$start_dates = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['start_date'])));
	if($start_dates==null) $start_dates="";
	$end_dates = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['end_date'])));
	if($end_dates==null) $end_dates="";
	$departments = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['department'])));
	if($departments==null) $departments="";
	$requestedbys = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['requestedby'])));
	if($requestedbys==null) $requestedbys="";
	$superapprovedbys = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['superapprovedby'])));
	if($superapprovedbys==null) $superapprovedbys="";
	$approvedbys = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['approvedby'])));
	if($approvedbys==null) $approvedbys="";
	$releasedbys = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['releasedby'])));
	if($releasedbys==null) $releasedbys="";
	$ticket_prioritys = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['ticket_priority'])));
	if($ticket_prioritys==null) $ticket_prioritys="";
	$help_topics = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['help_topic'])));
	if($help_topics==null) $help_topics="";
	$ticket_sources = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['ticket_source'])));
	if($ticket_sources==null) $ticket_sources="";
	$locations = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['location'])));
	if($locations==null) $locations="";
	$basestations = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['basestation'])));
	if($basestations==null) $basestations="";
	$clientmailtexts = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['clientmailtext'])));
	if($clientmailtexts==null) $clientmailtexts="";
	$clientmailsubjects = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['clientmailsubject'])));
	if($clientmailsubjects==null) $clientmailsubjects="";
	$ticketnos = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['ticketno'])));
	if($ticketnos==null) $ticketnos="";
	$clienttypes = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['clienttype'])));
	if($clienttypes==null) $clienttypes="";
	$equipmentcategorys = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['equipmentcategory'])));
	if($equipmentcategorys==null) $equipmentcategorys="";
	$equipmentcodes = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['equipmentcode'])));
	if($equipmentcodes==null) $equipmentcodes="";
	$userNames = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['userName']))); 
	$serialnos = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['serialno'])));
	$pages = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['page'])));
	$menus = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['menu'])));
	$actives = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['active'])));
	$currentusers = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['currentuser'])));
	if($currentusers==null) $currentusers="";
	$menuoption = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['menuoption'])));
	$access = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['access'])));
	$param = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['param'])));
	$param2 = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['param2'])));
	$table = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['table'])));
	$timestamp = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['timestamp'])));
	$currentobject = str_replace("_amp_", "&", str_replace("'", "`", trim($_GET['currentobject'])));
	include("data.php");

	if($option == "checkAccess"){
		$query = "SELECT * FROM usersmenu where userName = '{$currentusers}' and menuOption = '{$menuoption}'";
		$result = mysql_query($query, $connection);
		$resp="checkAccess";
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);

			if($accessible == "Yes"){
				$resp="checkAccessSuccess".$menuoption;
			}else{
				$resp="checkAccessFailed".$menuoption;
			}
		}else{
			$resp="checkAccessFailed".$menuoption;
		}
		echo $resp;
	}

	if($option == "nextClientNo"){
		$maxid="";
		$query = "SELECT max(clientid) as maxid FROM clientstable where location='{$locations}'";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			extract ($row);
		}
		if($maxid==null){
			$query = "SELECT locationcode as maxid FROM locationstable where locationdescription='{$locations}'";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				$row = mysql_fetch_array($result);
				extract ($row);
			}
		}
		echo $option.$maxid;
	}

	if($table=="clientstable" && $option == "sendClientMail") {
		$query = "SELECT * FROM clientstable where clientid<>'' ";
		if($locations!="")
			$query .= " and location='{$locations}'";
		if($basestations!="")
			$query .= " and basestation='{$basestations}'";
		if($clienttypes!="")
			$query .= " and clienttype='{$clienttypes}'";
		$query .= " order by clientid";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$resp="";
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				/*require_once "Mail.php";
				$from = "KKON Erp <erp@kkontech.com>";
				$to = $row[2]." <".$row[8].">";
				$subject = $clientmailsubjects;
				$body="Dear ".$row[2].",\n\n";
				$body.=$clientmailtexts;
				$body.="\n\n\nMobileTech ERP";
				$host = "41.223.65.120";
				$username = "erp";
				$password = "erp";
				$headers = array ('From' => $from,
				   'To' => $to,
				   'Subject' => $subject);
				$smtp = Mail::factory('smtp',
				   array ('host' => $host,
					 'auth' => true,
					 'username' => $username,
					 'password' => $password));
				 
				$mail = $smtp->send($to, $headers, $body);
				if (PEAR::isError($mail)) {
					echo("<p>" . $mail->getMessage() . "</p>");
				}else {
					echo ("<p>Message successfully sent!</p>");
				}*/

				//Process Email
				require_once('class.phpmailer.php');

				$mail = new phpmailer();  
				$mail->IsSMTP(); // telling the class to use SMTP
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
				$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
				$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
				$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
				$mail->Password   = 'olugbade';            // GMAIL password

				$from_mail = "adewale_azeez@hotmail.com"; 
				$from_name = "Adewale Azeez"; 
				$emailaddress = $from_mail;
				$Ccopy = ""; 
				$Bccopy = ""; 
				$replyto = $from_mail;

				$from = "$from_name <$from_mail>";
				$to = $row[2]." <".$row[8].">";
				$mailto = $row[8];
				$subject = $clientmailsubjects;
				$body="Dear ".$row[2].",\n\n";
				$body.=$clientmailtexts;
				$body.="\n\n\n<br><br><br>MobileTech ERP";
				
				$emailresponse = "";

				$mail->From=$emailaddress;
				$mail->FromName = $from_name;
				$mail->AddReplyTo($emailaddress,$from_name);
				$mail->Subject    = $subject;

				// optional, This is the one that the recipient is going to see if he switches to plain text format.
				$mail->AltBody    = $body; 
				
				//$mail->MsgHTML($body);
				$mail->IsHTML(true);
				$mail->Body=$body;

				//$mail->WordWrap = 50;
				//$mail->AddAttachment("embarassingmoments.jpg");

				//$address = 'adewaleazeez@yahoo.com';
				//$mail->AddAddress($userEmail, $fullname);
				$mail->AddAddress($row[8], $row[2]);
				//$mail->AddAttachment($path);

				if($mailto!=null && $mailto!=""){
					if(!$mail->Send()){
							echo("<p>" . $mail->ErrorInfo . "</p>");
					}else {
						echo ("<p>Message successfully sent!</p>");
					}
				}else{
						echo "<p>No email Address!</p>";
				}
			}
		}
		return true;
	}

	if($option == "getAllRecs"  || $option=="getRecordlist"  || $option=="getARecord"){
		$parameter = explode("][", $param);
		$query = "SELECT * FROM {$table} ";
		if($table=="userstable" && $option == "getAllRecs") {
			$query = "SELECT * FROM users ";
			$query .= " order by lastName, firstName";
		}

		if($table=="stafftable" && $option == "getAllRecs") {
			$query = "SELECT * FROM stafftable ";
			$query .= " order by lastname, firstname";
		}

		if($table=="appraisaltable" && $option == "getAllRecs") {
			$query = "SELECT serialno, staffid, appraisaldate, appraisalstart, appraisalend FROM appraisaltable where serialno<>0 ";
			if($parameter[0]!=null && $parameter[0]!="") $query .= " and staffid='{$parameter[0]}' ";
			if($parameter[3]!=null && $parameter[3]!="") $query .= " and appraisalstartdate>='{$parameter[3]}' ";
			if($parameter[4]!=null && $parameter[4]!="") $query .= " and appraisalenddate<='{$parameter[4]}' ";
			$query .= " order by appraisaldate, appraisalstartdate, serialno, staffid";

			if($parameter[5]!=null && $parameter[5]!="") {
				/*$userfullname = explode(" ", $parameter[5]);
				$myquery = "select staffid from stafftable where firstname='{$userfullname[0]}' and lastname='{$userfullname[1]}' ";
				$myresult = mysql_query($myquery, $connection);
				$mystaffid="";
				if(mysql_num_rows($myresult) > 0){
					while ($myrow = mysql_fetch_row($myresult)) {
						extract ($myrow);
						$mystaffid = $myrow[0];
					}
				}*/
				$query = "SELECT serialno, staffid, appraisaldate, appraisalstart, appraisalend FROM appraisaltable where serialno<>0 ";
				$query .= " and userName='{$parameter[5]}' ";
			}
//setcookie('myquery', $query, false);
		}

		if($table=="leavetable" && $option == "getAllRecs") {
			$query = "SELECT serialno, staffid, leavetype, leavestart, leaveend, supervisorapproval, adminapproval FROM leavetable where serialno<>0 ";
			if($parameter[0]!=null && $parameter[0]!="") $query .= " and staffid='{$parameter[0]}' ";
			if($parameter[1]!=null && $parameter[1]!="") $query .= " and leavetype='{$parameter[1]}' ";
			if($parameter[2]!=null && $parameter[2]!="") $query .= " and leavestart>='{$parameter[2]}' ";
			if($parameter[3]!=null && $parameter[3]!="") $query .= " and leaveend<='{$parameter[3]}' ";
			if($_COOKIE['leaveform']=="leavesetup") $query .= " and supervisorapproval='Pending' and adminapproval='Pending' ";
			if($_COOKIE['leaveform']=="supervisorapproval") $query .= " and supervisorapproval='Pending' and adminapproval='Pending' ";
			if($_COOKIE['leaveform']=="adminapproval") $query .= " and supervisorapproval='Approved' and adminapproval='Pending' ";
			$query .= " order by leavetype, leavestart, serialno, staffid";
			
			if($parameter[4]!=null && $parameter[4]!="") {
				/*$userfullname = explode(" ", $parameter[4]);
				$myquery = "select staffid from stafftable where firstname='{$userfullname[0]}' and lastname='{$userfullname[1]}' ";
				$myresult = mysql_query($myquery, $connection);
				$mystaffid="";
				if(mysql_num_rows($myresult) > 0){
					while ($myrow = mysql_fetch_row($myresult)) {
						extract ($myrow);
						$mystaffid = $myrow[0];
					}
				}*/
				$query = "SELECT serialno, staffid, leavetype, leavestart, leaveend, supervisorapproval, adminapproval FROM leavetable where serialno<>0 ";
				$query .= " and userName='{$parameter[4]}' ";
			}
//setcookie('myquery', $query, false);
		}

		if($table=="clientstable" && $option == "getAllRecs") {
			$query = "SELECT * FROM clientstable where clientid<>'' ";
			if($locations!="")
				$query .= " and location='{$locations}'";
			if($basestations!="")
				$query .= " and basestation='{$basestations}'";
			if($clienttypes!="")
				$query .= " and clienttype='{$clienttypes}'";
			$query .= " order by clientid";
		}

		if($table=="ticketstable" && $option == "getAllRecs") {
			$query = "SELECT a.serialno, a.ticketno, a.clientid, a.ticket_subject, a.ticket_date, (select min(c.ticket_assignor) from ticket_history c where a.ticketno=c.ticketno), (select min(d.ticket_assignee) from ticket_history d where a.ticketno=d.ticketno), a.help_topic, a.ticket_priority, a.ticket_status, b.location, b.clienttype FROM ticketstable a, clientstable b where a.clientid=b.clientid and a.ticketno<>'' ";
			if($ticketnos!="")
				$query .= " and a.ticketno='{$ticketnos}'";
			if($clientids!="")
				$query .= " and a.clientid='{$clientids}'";
			if($ticket_statuss!="")
				$query .= " and a.ticket_status='{$ticket_statuss}'";
			if($ticket_dates!="")
				$query .= " and a.ticket_date='{$ticket_dates}'";
			if($due_dates!="")
				$query .= " and a.due_date='{$due_dates}'";
			if($ticket_prioritys!="")
				$query .= " and a.ticket_priority='{$ticket_prioritys}'";
			if($help_topics!="")
				$query .= " and a.help_topic='{$help_topics}'";
			if($ticket_sources!="")
				$query .= " and a.ticket_source='{$ticket_sources}'";
			if($locations!="")
				$query .= " and b.location='{$locations}'";
			if($clienttypes!="")
				$query .= " and b.clienttype='{$clienttypes}'";
			$query .= " order by a.ticketno DESC";
		}

		if($table=="equipmentstock" && $option == "getAllRecs") {
			if($currentobject=="replenish")
				$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, a.replenishedby, a.location, a.quantityin, a.narration,  b.equipmentcategory, a.macaddress, a.basestation, a.clientid, a.lockrecord FROM equipmentstock a, equipmentstable b where a.location='{$locations}' and a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' and a.replenishedby!='' ";

			if($currentobject=="requisition")
				$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, a.requestedby, a.location, a.quantityout, a.narration,  b.equipmentcategory, a.macaddress, a.basestation, a.clientid, a.lockrecord FROM equipmentstock a, equipmentstable b where a.location='{$locations}' and a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' and a.requestedby!='' ";

			if($currentobject=="approval")
				$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, a.approvedby, a.location, a.quantityout, a.narration,  b.equipmentcategory, a.macaddress, a.basestation, a.clientid, a.lockrecord FROM equipmentstock a, equipmentstable b where a.location='{$locations}' and a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' and (a.approvedby!='' or a.requestedby!='') ";
			
			if($currentobject=="transfer")
				$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, a.transferedby, a.location, a.quantityout, a.narration,  b.equipmentcategory, a.macaddress, a.basestation, a.clientid, a.lockrecord FROM equipmentstock a, equipmentstable b where a.location='{$locations}' and a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' and a.transferedby!='' ";

			if($currentobject=="view")
				$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, '', a.location, '', a.narration,  b.equipmentcategory, a.macaddress, a.balance, a.clientid, a.lockrecord FROM equipmentstock a, equipmentstable b where a.location='{$locations}' and a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' and a.transactiondate in (select max(a.transactiondate) from equipmentstock a group by a.equipmentcode)";

			if($currentobject=="history")
				$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, a.location, a.narration,  b.equipmentcategory, a.macaddress, a.quantityin, a.quantityout, a.balance FROM equipmentstock a, equipmentstable b where a.location='{$locations}' and a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' ";

//SELECT * FROM ticketstable where ticketno in (select max(ticketno) from ticketstable group by clientid)
			if($equipmentcodes!="")
				$query .= " and a.equipmentcode='{$equipmentcodes}'";
			if($equipmentcategorys!="")
				$query .= " and b.equipmentcategory='{$equipmentcategorys}'";
			if($start_dates!="")
				$query .= " and a.start_date>='{$start_dates}'";
			if($end_dates!="")
				$query .= " and a.end_date<='{$end_dates}'";
			$query .= " order by a.location, a.basestation, a.equipmentcode, a.transactiondate, a.serialno ";
		}

		if($table=="requisitiontable" && $option == "getAllRecs") {
			//if($currentobject=="request")
				$query = "SELECT * FROM requisitiontable where requestedby!='' ";

			//if($currentobject=="supervisorapproval")
			//	$query = "SELECT * FROM requisitiontable where requestedby!='' ";
			
			//if($currentobject=="supervisorapproval")
			//	$query = "SELECT * FROM requisitiontable where supervisorapproval!='' ";
			
			//if($currentobject=="accountsapproval")
			//	$query = "SELECT * FROM requisitiontable where supervisorapproval!='' ";
			
			//if($currentobject=="release")
			//	$query = "SELECT * FROM requisitiontable where approvedby!='' ";
			
			if($departments!="")
				$query .= " and department='{$departments}'";
			if($requestedbys!="")
				$query .= " and requestedby='{$requestedbys}'";
			if($superapprovedbys!="")
				$query .= " and supervisorapproval='{$superapprovedbys}'";
			if($approvedbys!="")
				$query .= " and approvedby='{$approvedbys}'";
			if($releasedbys!="")
				$query .= " and releasedby='{$releasedbys}'";
			if($start_dates!="")
				$query .= " and requisitiondate>='{$start_dates}'";
			if($end_dates!="")
				$query .= " and requisitiondate<='{$end_dates}'";

			$myquery = "select * from usersmenu where userName='".$_COOKIE['currentuser']."' and menuOption='View Account' and accessible='Yes' ";
			$myresult = mysql_query($myquery, $connection);
			if(mysql_num_rows($myresult) == 0 && $currentobject=="request")
				$query .= " and requestedby= '".$_COOKIE['currentuser']."' ";
			
			if($currentobject=="request")
				$query .= " and requestedby= '".$_COOKIE['currentuser']."' ";
			if($currentobject=="supervisorapproval")
				$query .= " and transtatus='Requested' ";
			if($currentobject=="accountsapproval")
				$query .= " and transtatus='SupervisorApproved' ";
			if($currentobject=="release")
				$query .= " and transtatus='AccountsApproved' ";

			$query .= " order by requisitiondate DESC, serialno DESC, department, requestedby, approvedby, releasedby";
		}

		if($table=="ticket_history" && $option == "getAllRecs") {
			$query = "SELECT * FROM ticket_history where ticketno='{$serialnos}' ";
		}

		if($table=="departmentstable" && $option == "getAllRecs") {
			$query .= " order by departmentdescription";
		}

		if($table=="basestationstable" && $option == "getAllRecs") {
			$query .= " order by location, basestationdescription";
		}

		if($table=="locationstable" && $option == "getAllRecs") {
			$query .= " order by locationcode";
		}

		if($option=="getRecordlist"){
			if($table=="users") {
				$query = "SELECT serialno, userName, concat(lastName,' ',firstName), userEmail FROM users where serialno>0 ";
				if($_COOKIE['selectedlocation']!=null) $query .= " and location='".$_COOKIE['selectedlocation']."' ";
				if($_COOKIE['selectedept']!=null && $_COOKIE['selectedept']!="") $query .= " and department='".$_COOKIE['selectedept']."' ";
				$query .= " order by userName";
			}

			if($table=="stafftable") {
				$query = "SELECT serialno, staffid, lastname, concat(firstname,' ',middlename) FROM stafftable where serialno>0 and  staffid !='".$_COOKIE['currentuser']."' ";
				$query .= " order by staffid";
			}

			if($table=="staffnametable") {
				$query = "SELECT serialno, concat(lastname,', ',firstname,' ',middlename) FROM stafftable where serialno>0 and  lastname !='".$_COOKIE['currentuser']."' ";
				$query .= " order by staffid";
			}

			if($table=="stafftableA" || $table=="stafftableB") {
				$query = "SELECT serialno, staffid, lastname, concat(firstname,' ',middlename) FROM stafftable where serialno>0 ";
				if($_COOKIE['selectedept']!=null) $query .= " and department='".$_COOKIE['selectedept']."' ";
				if($_COOKIE['selecteuserid']!=null) $query .= " and staffid='".$_COOKIE['selecteuserid']."' ";
				$query .= " order by staffid";
			}

			if($table=="leavetypetable") {
				$query = "SELECT DISTINCT leavetype, leavetype FROM leavetable where serialno>0 ";
				$query .= " order by leavetype";
			}

			if($table=="appraisaltableA") {
				$query = "SELECT DISTINCT substr(appraisalstart,5,4), substr(appraisalstart,5,4) FROM appraisaltable where serialno>0 ";
				$query .= " order by substr(appraisalstart,5,4) DESC";
			}

			if($table=="appraisaltableB") {
				$query = "SELECT DISTINCT substr(appraisalend,5,4), substr(appraisalend,5,4) FROM appraisaltable where serialno>0 ";
				$query .= " order by substr(appraisalend,5,4) DESC";
			}

			if($table=="clientstable") {
				$query = "SELECT * FROM clientstable where serialno>0 ";
				if($_COOKIE['selectedlocation']!=null) $query .= " and location='".$_COOKIE['selectedlocation']."' ";
				$query .= " order by clientid";
			}

			if(substr($currentobject, 0, 22)=="basestationdescription" && $table=="basestationstable") {
				$query = "SELECT DISTINCT basestationdescription, basestationdescription FROM basestationstable where serialno>0 ";
				if($_COOKIE['selectedlocation']!=null) $query .= " and location='".$_COOKIE['selectedlocation']."' ";
				$query .= " order by basestationdescription";
			}

			if($table=="equipmentstable" && substr($currentobject, 0, 17)=="equipmentcategory") {
				$query = "SELECT DISTINCT equipmentcategory, equipmentcategory FROM equipmentstable ";
				$query .= " order by equipmentcategory";
			}

			if($table=="equipmentstable" && substr($currentobject, 0, 13)=="equipmentcode") {
				$query = "SELECT DISTINCT equipmentcode, equipmentcode, equipmentname FROM equipmentstable ";
				$query .= " where equipmentcategory='".$_COOKIE['selectecategory']."' ";
				$query .= " order by equipmentcode";
			}
 
			if(substr($currentobject, 0, 13)=="staffposition")
				$query = "SELECT DISTINCT staffPosition, staffPosition FROM {$table} order by staffPosition";

			if($table=="ticketstable" && substr($currentobject, 0, 9)=="ticketnoA") {
				$query = "SELECT a.serialno, a.ticketno, a.clientid, b.clientname, b.location FROM ticketstable a, clientstable b where a.clientid=b.clientid and a.ticketno<>'' ";
				if($_COOKIE['selectedclient']!=null) $query .= " and a.clientid='".$_COOKIE['selectedclient']."' ";
				if($_COOKIE['selectedlocation']!=null) $query .= " and b.location='".$_COOKIE['selectedlocation']."' ";
				$query .= " order by a.ticketno DESC";
			}

			if($table=="clienttypestable"){
				echo "VPN_~_VPN_~_getRecordlistINTERNET_~_INTERNET_~_getRecordlistRETAILERS_~_RETAILERS_~_getRecordlist";
				return true;
			}

			if(substr($currentobject, 0, 10)=="department")
				$query = "SELECT DISTINCT departmentdescription, departmentdescription FROM {$table} order by departmentdescription";
			
			if(substr($currentobject, 0, 10)=="level")
				$query = "SELECT DISTINCT level, level FROM {$table} order by level";
			
			if(substr($currentobject, 0, 10)=="jobtitle")
				$query = "SELECT DISTINCT jobtitle, jobtitle FROM {$table} order by jobtitle";
			
			if(substr($currentobject, 0, 8)=="location")
				$query = "SELECT DISTINCT locationdescription, locationdescription FROM {$table} order by locationdescription";

		}

		if($option == "getARecord") 
			$query = "SELECT * FROM {$table} where serialno='{$serialnos}'";
		if($option == "getARecord" && ($_COOKIE['getclientB']=="1" || $_COOKIE['getclientB']=="2")&& $table=="clientstable") 
			$query = "SELECT * FROM {$table} where clientid='{$serialnos}'";
		if($option == "getARecord" && $table=="userstable") 
			$query = "SELECT * FROM users where serialno='{$serialnos}'";
		if($option == "getARecord" && ($table=="stafftableA"  || $table=="stafftableB")) 
			$query = "SELECT * FROM stafftable where staffid='{$serialnos}'";
		if($option == "getARecord" && $table=="stafftable") 
			$query = "SELECT * FROM stafftable where serialno='{$serialnos}'";
		if($option == "getARecord" && $table=="appraisaltable") 
			$query = "SELECT * FROM appraisaltable where serialno='{$serialnos}'";
		if($option == "getARecord" && $table=="leavetable") 
			$query = "SELECT * FROM leavetable where serialno='{$serialnos}'";
		if($option == "getARecord" && $table=="ticketno") 
			$query = "SELECT max(ticketno) as ticketno FROM ticketstable ";
		if($option == "getARecord" && $table=="equipmentcode") 
			$query = "SELECT equipmentname FROM equipmentstable where equipmentcode='{$equipmentcodes}'";
		if($option == "getARecord" && $table=="equipmentstock")
			$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, a.replenishedby, a.requestedby, a.approvedby, a.location, a.quantityin, a.quantityout, a.balance, b.equipmentcategory, a.narration, a.lockrecord, a.macaddress, a.transtatus FROM equipmentstock a, equipmentstable b where a.serialno='{$serialnos}' and a.equipmentcode=b.equipmentcode";
			//$query = "SELECT * FROM equipmentstock where serialno='{$serialnos}'";
		$resp=$option;

		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$resp="";
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				if(($table=="appraisaltable" || $table=="leavetable") && $option == "getARecord") {
					$queryA = "SELECT * FROM stafftable where staffid='{$row[1]}' ";
					$resultA = mysql_query($queryA, $connection);
					if(mysql_num_rows($resultA) > 0){
						while ($rowA = mysql_fetch_row($resultA)) {
							extract ($rowA);
							foreach($rowA as $i => $value){
								$resp .= "getARecord" . $value;
							}
						}
					}
				}
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
			        if ($option=="getAllRecs" || $option=="getRecordlist") {
		                $resp .= $value."_~_";
						if(($table=="appraisaltable" || $table=="leavetable") && $option == "getAllRecs" && $meta->name == "staffid") {
							$queryA = "SELECT * FROM stafftable where staffid='{$value}' ";
							$resultA = mysql_query($queryA, $connection);
							if(mysql_num_rows($resultA) > 0){
								while ($rowA = mysql_fetch_row($resultA)) {
									extract ($rowA);
									$resp .= $rowA[2].", ".$rowA[3]." ".$rowA[4]." "."_~_";
								}
							}
						}
	                } else {
						$resp .= "getARecord" . $value;
					}
				}
				if ($option=="getAllRecs" || $option=="getRecordlist") $resp .= $option;
			}
			if ($option=="getAllRecs") $resp = $table . $option . $resp;
			if ($option=="getARecord") $resp = $table . $resp . $option;
        }else{
			if ($option=="getAllRecs") $resp = $table . $option;
		}
//setcookie('myquery', $resp, false);
		echo $resp;

    }

	if($option == "updateRecLocks"){
		$parameter = explode("][", $param);
		$query = "update equipmentstock set lockrecord='{$parameter[1]}' where serialno={$parameter[0]} ";
		mysql_query($query, $connection);

		$resp = "updateRecLocks";
		echo $resp;
	}

	if($option == "updateSuperApproval"){
		$parameter = explode("][", $param);
		if($parameter[1]!=""){
			$query = "update requisitiontable set supervisorapproval='{$parameter[1]}', transtatus='SupervisorApproved' where serialno={$parameter[0]} ";
		}else{
			$query = "update requisitiontable set supervisorapproval='{$parameter[1]}', transtatus='Requested' where serialno={$parameter[0]} ";
		}
		mysql_query($query, $connection);

		$resp = "updateSuperApproval";
		echo $resp;
	}

	if($option == "updateApproval"){
		$parameter = explode("][", $param);
		if($parameter[1]!=""){
			$query = "update requisitiontable set approvedby='{$parameter[1]}', transtatus='AccountsApproved' where serialno={$parameter[0]} ";
		}else{
			$query = "update requisitiontable set approvedby='{$parameter[1]}', transtatus='SupervisorApproved' where serialno={$parameter[0]} ";
		}
		mysql_query($query, $connection);

		$resp = "updateApproval";
		echo $resp;
	}

	if($option == "updateRelease"){
		$parameter = explode("][", $param);
		$query = "update requisitiontable set releasedby='{$parameter[1]}', transtatus='ReleaseApproved', lockrecord='Yes' where serialno={$parameter[0]} ";
		mysql_query($query, $connection);

		$resp = "updateRelease";
		echo $resp;
	}

	if($option == "getStockBalance"){
		$query = "SELECT * FROM equipmentstock where location='{$locations}' and equipmentcode='{$equipmentcodes}' ";
		$result = mysql_query($query, $connection);
		$stockbalance=0.0;
		$resp = "getStockBalance";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$stockbalance=$row[9];
			}
			if(intval($stockbalance)>=intval($serialnos)){
				$resp .= "yestockbalance";
			}else{
				$resp .= "nostockbalancegetStockBalance".$stockbalance."getStockBalance".$serialnos;
			}
		}
		echo $resp;
	}

	if($option == "stocktransfer"){
		$parameters = explode("][", $param);
		
		$query = "SELECT * FROM equipmentstock where location='{$locations}' and equipmentcode='{$equipmentcodes}' ";
		$result = mysql_query($query, $connection);
		$stockbalance=0.0;
		$resp = "getStockBalance";
		if(mysql_num_rows($result) > 0){
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				$stockbalance=$row[9];
			}
			if(intval($stockbalance)<intval($parameters[3])){
				echo "nostockbalancegetStockBalance".$stockbalance."getStockBalance".$parameters[3];
				return true;
			}
		}
		$query = "insert into equipmentstock (location, macaddress, quantityout, transferedby, narration, equipmentcode, transactiondate) values ('{$parameters[0]}', '{$parameters[2]}', '{$parameters[3]}', '{$parameters[4]}', '{$parameters[5]}', '{$parameters[6]}', '{$parameters[7]}' ) ";
		mysql_query($query, $connection);	
		$query = "SELECT * FROM equipmentstock where equipmentcode = '{$parameters[6]}' and location = '{$parameters[0]}' order by location, equipmentcode, transactiondate, serialno";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$balances = 0;
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$balances = $balances + $row[7] - $row[8];
				$query2 = "update equipmentstock set balance='{$balances}' where serialno='{$serialno}'";
				mysql_query($query2, $connection);
			}
		}
	
		$query = "insert into equipmentstock (location, macaddress, quantityin, transferedby, narration, equipmentcode, transactiondate) values ('{$parameters[1]}', '{$parameters[2]}', '{$parameters[3]}', '{$parameters[4]}', '{$parameters[5]}', '{$parameters[6]}', '{$parameters[7]}' ) ";
		mysql_query($query, $connection);
		$query = "SELECT * FROM equipmentstock where equipmentcode = '{$parameters[6]}' and location = '{$parameters[1]}' order by location, equipmentcode, transactiondate, serialno";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			$balances = 0;
			while ($row = mysql_fetch_array($result)) {
				extract ($row);
				$balances = $balances + $row[7] - $row[8];
				$query2 = "update equipmentstock set balance='{$balances}' where serialno='{$serialno}'";
				mysql_query($query2, $connection);
			}
		}
		echo "transfersuccessful";
		//originlocation+"]["+targetlocation+"]["+macaddress+"]["+quantity+"]["+transferedby+"]["+narration+"]["+equipmentcode+"]["+transactiondate;
	}
	
	if($option == "addRecord"){
		$parameters = explode("][", $param);
		if($table=="userstable"){
			$table="users";
			$query = "SELECT * FROM users where userName ='{$parameters[1]}'";
			$parameters[2]=$timestamp;
		}
		if($table=="stafftable"){
			$table="stafftable";
			$query = "SELECT * FROM stafftable where staffid ='{$parameters[1]}'";
		}
		if($table=="appraisaltable"){
			$table="appraisaltable";
			$query = "SELECT * FROM appraisaltable where staffid ='{$parameters[1]}' and appraisaldate ='{$parameters[9]}'";
		}
		if($table=="leavetable"){
			$table="leavetable";
			$query = "SELECT * FROM leavetable where staffid ='{$parameters[1]}' and leavetype ='{$parameters[2]}' and leavestart ='{$parameters[3]}'";
		}
		if($table=="clientstable") 
			$query = "SELECT * FROM {$table} where clientid ='{$parameters[1]}' ";
		if($table=="ticketstable") {
			$restricted="";
			$query = "SELECT * FROM {$table} where ticketno ='{$parameters[1]}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_row($result)) {
					extract ($row);
					$ticketpriority=$row[8];
					$ticketstatus=$row[9];
				}
				$parameters2 = explode("][", $param2);
				if($parameters2[5]!=null && $parameters2[5]!=""){
					$queryB = "SELECT accessible FROM usersmenu where userName ='".$_COOKIE['currentuser']."' and menuOption='Assign Tickets'";
					$resultB = mysql_query($queryB, $connection);
					while ($rowB = mysql_fetch_row($resultB)) {extract ($rowB); $accessibility=$rowB[0]; }
					if($accessibility=="No" || mysql_num_rows($resultB)==0) $restricted .= $_COOKIE['currentuser']." is not allowed to assign tickets to other users<br><br>";
				}
				if($ticketpriority!=$parameters[8]){
					$queryB = "SELECT accessible FROM usersmenu where userName ='".$_COOKIE['currentuser']."' and menuOption='Change Ticket Priority'";
					$resultB = mysql_query($queryB, $connection);
					while ($rowB = mysql_fetch_row($resultB)) {extract ($rowB); $accessibility=$rowB[0]; }
					if($accessibility=="No" || mysql_num_rows($resultB)==0) $restricted .= $_COOKIE['currentuser']." is not allowed to change tickets` priorities<br><br>";
				}
				if($ticketstatus!=$parameters[9]){
					$queryB = "SELECT accessible FROM usersmenu where userName ='".$_COOKIE['currentuser']."' and menuOption='Change Ticket Status'";
					$resultB = mysql_query($queryB, $connection);
					while ($rowB = mysql_fetch_row($resultB)) {extract ($rowB); $accessibility=$rowB[0]; }
					if($accessibility=="No" || mysql_num_rows($resultB)==0) $restricted .= $_COOKIE['currentuser']." is not allowed to change tickets` status<br><br>";
				}
				if($restricted!=""){
					echo "restricted".$restricted;
					return true;
				}
			}
			$query = "SELECT * FROM {$table} where ticketno ='{$parameters[1]}' ";
		}
		if($table=="departmentstable") 
			$query = "SELECT * FROM {$table} where departmentdescription ='{$parameters[1]}' ";
		if($table=="basestationstable") 
			$query = "SELECT * FROM {$table} where basestationdescription ='{$parameters[1]}' ";
		if($table=="locationstable") 
			$query = "SELECT * FROM {$table} where locationdescription ='{$parameters[1]}' ";
		if($table=="equipmentstable") 
			$query = "SELECT * FROM {$table} where equipmentcode ='{$parameters[1]}' ";
		if($table=="equipmentstock") 
			$query = "SELECT * FROM {$table} where serialno ='{$parameters[0]}' ";
		if($table=="requisitiontable") 
			$query = "SELECT * FROM {$table} where serialno ='{$parameters[0]}' ";
		$result = mysql_query($query, $connection);

		if(mysql_num_rows($result) == 0){
			$query = "select max(serialno) as id from {$table}";
			$result = mysql_query($query, $connection);
			$row = mysql_fetch_array($result);
			extract ($row);
			$serialnos = intval($id)+1;

			$query = "INSERT INTO {$table} (serialno) VALUES ('{$serialnos}')";
			$result = mysql_query($query, $connection);

			$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
			$result = mysql_query($query, $connection);

			if(mysql_num_rows($result) > 0){
				$record="";
				$count=0;
				while ($row = mysql_fetch_row($result)) {
					extract ($row);
					foreach($row as $i => $value){
						$meta = mysql_fetch_field($result, $i);
						if($count > 0){
							$record .= $meta->name . "='".$parameters[$count++]."', ";
						}else{
							$count++;
						}
					}
				}
				$record = substr($record, 0, strlen($record)-2);
				$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);
			}
			if($table=="equipmentstock" && $_COOKIE['stockform']!="requisition"){
				$query = "SELECT * FROM equipmentstock where equipmentcode = '{$parameters[1]}' and location = '{$parameters[6]}' order by location, equipmentcode, transactiondate, serialno";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					$balances = 0;
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						if(!($row[4]>"" && $row[5]=="")){
							$balances = $balances + $row[7] - $row[8];

							$query2 = "update equipmentstock set balance='{$balances}' where serialno='{$serialno}'";
							mysql_query($query2, $connection);
						}
					}
				}
			}
			if($table=="equipmentstock"){
				if($parameters[13]=="Pending" || $parameters[13]=="Denied" || $parameters[13]=="Approved"){
					$to_split="";
					$row3="";
					$row4="";
					if($parameters[13]=="Pending"){
						$to_split="logistics@kkontech.com";
						$row3="Stock";
						$row4="Admin";

					}else if($parameters[13]=="Denied" || $parameters[13]=="Approved"){
						$query = "SELECT * FROM users where userName ='{$parameters[4]}'";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result)> 0){
							$row = mysql_fetch_array($result);
							extract ($row);
							$to_split=$row[14];
							$row3=$row[3];
							$row4=$row[4];
						}
					}

					/*require_once "Mail.php";
					$from = "KKON Erp <erp@kkontech.com>";
					$to_splited = explode("@", $to_split);
					$to = $to_splited[0]." <".$to_split.">";
					$subject = "Stock Requisition ".$parameters[13]."!!!";
					$body="Dear ".$row3." ".$row4.",\n\n";
					$body.="Requisition for Equipment: ".$parameters[1]." by ".$parameters[4]." is ";
					$body.=$parameters[13].", Kindly logon to view more details.";
					$body.="\n\n\nMobileTech ERP";
					$host = "41.223.65.120";
					$username = "erp";
					$password = "erp";
					$headers = array ('From' => $from,
					   'To' => $to,
					   'Subject' => $subject);
					$smtp = Mail::factory('smtp',
					   array ('host' => $host,
						 'auth' => true,
						 'username' => $username,
						 'password' => $password));
					 
					$mail = $smtp->send($to, $headers, $body);
					if (PEAR::isError($mail)) {
						echo("<p>" . $mail->getMessage() . "</p>");
					}else {
						echo ("<p>Message successfully sent!</p>");
					}*/


					//Process Email
					require_once('class.phpmailer.php');

					$mail = new phpmailer();  
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
					$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
					$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
					$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
					$mail->Password   = 'olugbade';            // GMAIL password

					$from_mail = "adewale_azeez@hotmail.com"; 
					$from_name = "Adewale Azeez"; 
					$emailaddress = $from_mail;
					$Ccopy = ""; 
					$Bccopy = ""; 
					$replyto = $from_mail;

					$from = "$from_name <$from_mail>";
					$to_splited = explode("@", $to_split);
					$to = $to_splited[0]." <".$to_split.">";
					$mailto = $to_split;
					$subject = "Stock Requisition ".$parameters[13]."!!!";
					$body="Dear ".$row3." ".$row4.",\n\n";
					$body.="Requisition for Equipment: ".$parameters[1]." by ".$parameters[4]." is ";
					$body.=$parameters[13].", Kindly logon to view more details.";
					$body.="\n\n\n<br><br><br>MobileTech ERP";

					
					$emailresponse = "";

					$mail->From=$emailaddress;
					$mail->FromName = $from_name;
					$mail->AddReplyTo($emailaddress,$from_name);
					$mail->Subject    = $subject;

					// optional, This is the one that the recipient is going to see if he switches to plain text format.
					$mail->AltBody    = $body; 
					
					//$mail->MsgHTML($body);
					$mail->IsHTML(true);
					$mail->Body=$body;

					//$mail->WordWrap = 50;
					//$mail->AddAttachment("embarassingmoments.jpg");

					//$address = 'adewaleazeez@yahoo.com';
					//$mail->AddAddress($userEmail, $fullname);
					$mail->AddAddress($to_split, $to_splited[0]);
					//$mail->AddAttachment($path);

					if($mailto!=null && $mailto!=""){
						if(!$mail->Send()){
								echo("<p>" . $mail->ErrorInfo . "</p>");
						}else {
							echo ("<p>Message successfully sent!</p>");
						}
					}else{
							echo "<p>No email Address!</p>";
					}


				}
			}
			if($table=="ticketstable"){
				$query = "SELECT * FROM ticket_history where ticketno ={$parameters[1]} ";
				$result = mysql_query($query, $connection);

				if(mysql_num_rows($result) == 0){
					$parameters = explode("][", $param2);
					$query = "select max(serialno) as id from ticket_history";
					$result = mysql_query($query, $connection);
					$row = mysql_fetch_array($result);
					extract ($row);
					$serialnos = intval($id)+1;

					$query = "INSERT INTO ticket_history (serialno) VALUES ('{$serialnos}')";
					$result = mysql_query($query, $connection);

					$query = "SELECT * FROM ticket_history where serialno ='{$serialnos}'";
					$result = mysql_query($query, $connection);

					if(mysql_num_rows($result) > 0){
						$record="";
						$count=0;
						while ($row = mysql_fetch_row($result)) {
							extract ($row);
							foreach($row as $i => $value){
								$meta = mysql_fetch_field($result, $i);
								if($count > 0){
									$record .= $meta->name . "='".$parameters[$count++]."', ";
								}else{
									$count++;
								}
							}
						}
						$record = substr($record, 0, strlen($record)-2);
						$query = "UPDATE ticket_history set ".$record." where serialno ='{$serialnos}'";
						$result = mysql_query($query, $connection);

						if($parameters[5]>""){
							$query = "SELECT * FROM users where userName ='{$parameters[5]}'";
							$result = mysql_query($query, $connection);
							if(mysql_num_rows($result) > 0){
								$row = mysql_fetch_array($result);
								extract ($row);

								/*require_once "Mail.php";
								$from = "KKON ERP <erp@kkontech.com>";
								$to = $row[8]." <".$row[14].">";
								$subject = "Ticket Assignment!!!";
								$body="Dear ".$row[3]." ".$row[4].",\n\n";
								$body.="Ticket No ".$parameters[1]." has been assigned to you, Kindly logon to view more details.";
								$body.="\n\n\nMobileTech ERP";
								 
								$host = "41.223.65.120";
								$username = "erp";
								$password = "erp";
								 
								$headers = array ('From' => $from,
								   'To' => $to,
								   'Subject' => $subject);
								$smtp = Mail::factory('smtp',
								   array ('host' => $host,
									 'auth' => true,
									 'username' => $username,
									 'password' => $password));
								 
								$mail = $smtp->send($to, $headers, $body);
								if (PEAR::isError($mail)) {
									echo("<p>" . $mail->getMessage() . "</p>");
								}else {
									echo ("<p>Message successfully sent!</p>");
								}*/

							
								//Process Email
								require_once('class.phpmailer.php');

								$mail = new phpmailer();  
								$mail->IsSMTP(); // telling the class to use SMTP
								$mail->SMTPAuth   = true;                  // enable SMTP authentication
								$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
								$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
								$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
								$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
								$mail->Password   = 'olugbade';            // GMAIL password

								$from_mail = "adewale_azeez@hotmail.com"; 
								$from_name = "Adewale Azeez"; 
								$emailaddress = $from_mail;
								$Ccopy = ""; 
								$Bccopy = ""; 
								$replyto = $from_mail;
								$subject = "STATEMENT OF RESULTS";
								$body = "Dear ".$firstName."\nPlease find attached to this mail a copy of your statement of results.";

								$from = "$from_name <$from_mail>";
								
								$emailresponse = "";

								$to = $row[8]." <".$row[14].">";
								$mailto = $row[14];
								$subject = "Ticket Assignment!!!";
								$body="Dear ".$row[3]." ".$row[4].",\n\n";
								$body.="Ticket No ".$parameters[1]." has been assigned to you, Kindly logon to view more details.";
								$body.="\n\n\n<br><br><br>MobileTech ERP";

								$mail->From=$emailaddress;
								$mail->FromName = $from_name;
								$mail->AddReplyTo($emailaddress,$from_name);
								$mail->Subject    = $subject;

								// optional, This is the one that the recipient is going to see if he switches to plain text format.
								$mail->AltBody    = $body; 
								
								//$mail->MsgHTML($body);
								$mail->IsHTML(true);
								$mail->Body=$body;

								//$mail->WordWrap = 50;
								//$mail->AddAttachment("embarassingmoments.jpg");

								//$address = 'adewaleazeez@yahoo.com';
								//$mail->AddAddress($userEmail, $fullname);
								$mail->AddAddress($row[14], $row[8]);
								//$mail->AddAttachment($path);

								if($mailto!=null && $mailto!=""){
									if(!$mail->Send()){
											echo("<p>" . $mail->ErrorInfo . "</p>");
									}else {
										echo ("<p>Message successfully sent!</p>");
									}
								}else{
										echo "<p>No email Address!</p>";
								}
							
							
							
							}
						}
					
					}
				}
			}
			if($table=="users"){
				$query = "SELECT * FROM users where userName ='{$parameters[1]}'";

				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					$row = mysql_fetch_array($result);
					extract ($row);

					/*require_once "Mail.php";
					$from = "KKON ERP <erp@kkontech.com>";
					$to = $row[3]." ".$row[4]." <".$row[5].">";
					$subject = "Your Login Details!!!";
					$body="Dear ".$parameters[3].",\n\n";
					$body.="Your user details has just been created, your User-Id is: ".$parameters[1]." \n and your password is: ".$parameters[2];
					$body.="\n\n\nPlease click the following link to login to the application: ";
					$body.="www.kkontech.com/kkontech";
                    $body.="\n\nYou can change your Password on User Management";
					$body.="\n\n\nMobileTech ERP";
					 
					$host = "41.223.65.120";
					$username = "erp";
					$password = "erp";
					 
					$headers = array ('From' => $from,
					   'To' => $to,
					   'Subject' => $subject);
					$smtp = Mail::factory('smtp',
					   array ('host' => $host,
						 'auth' => true,
						 'username' => $username,
						 'password' => $password));
					 
					$mail = $smtp->send($to, $headers, $body);
					if (PEAR::isError($mail)) {
						echo("<p>" . $mail->getMessage() . "</p>");
					}else {
						echo ("<p>Message successfully sent!</p>");
					}*/


					//Process Email
					require_once('class.phpmailer.php');

					$mail = new phpmailer();  
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
					$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
					$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
					$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
					$mail->Password   = 'olugbade';            // GMAIL password

					$from_mail = "adewale_azeez@hotmail.com"; 
					$from_name = "Adewale Azeez"; 
					$emailaddress = $from_mail;
					$Ccopy = ""; 
					$Bccopy = ""; 
					$replyto = $from_mail;

					$from = "$from_name <$from_mail>";
					$to = $row[3]." ".$row[4]." <".$row[5].">";
					$mailto = $row[5];
					$subject = "Your Login Details!!!";
					$body="Dear ".$parameters[3].",\n\n";
					$body.="Your user details has just been created, your User-Id is: ".$parameters[1]." \n and your password is: ".$parameters[2];
					$body.="\n\n\nPlease click the following link to login to the application: ";
					$body.="www.kkontech.com/kkontech";
                    $body.="\n\nYou can change your Password on User Management";
					$body.="\n\n\n<br><br><br>MobileTech ERP";
					
					$emailresponse = "";


					$mail->From=$emailaddress;
					$mail->FromName = $from_name;
					$mail->AddReplyTo($emailaddress,$from_name);
					$mail->Subject    = $subject;

					// optional, This is the one that the recipient is going to see if he switches to plain text format.
					$mail->AltBody    = $body; 
					
					//$mail->MsgHTML($body);
					$mail->IsHTML(true);
					$mail->Body=$body;

					//$mail->WordWrap = 50;
					//$mail->AddAttachment("embarassingmoments.jpg");

					//$address = 'adewaleazeez@yahoo.com';
					//$mail->AddAddress($userEmail, $fullname);
					$mail->AddAddress($row[5], $row[3]." ".$row[4]);
					//$mail->AddAttachment($path);

					if($mailto!=null && $mailto!=""){
						if(!$mail->Send()){
								echo("<p>" . $mail->ErrorInfo . "</p>");
						}else {
							echo ("<p>Message successfully sent!</p>");
						}
					}else{
							echo "<p>No email Address!</p>";
					}
				
				
				}
			}

			echo $table."inserted";
		}else {
			echo "recordexists";
		}
	}

	if($option == "updateRecord"){
		$parameters = explode("][", $param);
		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		if($table=="userstable"){
			$table="users";
			$query = "SELECT * FROM users where userName ='{$parameters[1]}'";
			$parameters[2]=$timestamp;
			//$result = mysql_query($query, $connection);
			//if(mysql_num_rows($result) > 0){
			//	$row = mysql_fetch_array($result);
			//	extract ($row);
			//	$parameters[2]=$row[2];
			//}
		}
		if($table=="stafftable"){
			$table="stafftable";
			$query = "SELECT * FROM stafftable where staffid ='{$parameters[1]}'";
		}
		if($table=="appraisaltable"){
			$table="appraisaltable";
			$query = "SELECT * FROM appraisaltable where staffid ='{$parameters[1]}' and appraisaldate ='{$parameters[9]}'";
		}
		if($table=="leavetable"){
			$table="leavetable";
			$query = "SELECT * FROM leavetable where staffid ='{$parameters[1]}' and leavetype ='{$parameters[2]}' and leavestart ='{$parameters[3]}'";
//setcookie("myquery",$param,false);		
		}
		if($table=="clientstable") 
			$query = "SELECT * FROM {$table} where clientid ='{$parameters[1]}' ";
		if($table=="ticketstable") {
			$restricted="";
			$query = "SELECT * FROM {$table} where ticketno ='{$parameters[1]}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) > 0){
				while ($row = mysql_fetch_row($result)) {
					extract ($row);
					$ticketpriority=$row[8];
					$ticketstatus=$row[9];
				}
				if($ticketstatus=="Closed" && $parameters[9]!="Open"){
					$restricted .= "This ticket can not be edited because it has been closed<br><br>";
					echo "restricted".$restricted;
					return true;
				}
				$parameters2 = explode("][", $param2);
				if($parameters2[5]!=null && $parameters2[5]!=""){
					$queryB = "SELECT accessible FROM usersmenu where userName ='".$_COOKIE['currentuser']."' and menuOption='Assign Tickets'";
					$resultB = mysql_query($queryB, $connection);
					while ($rowB = mysql_fetch_row($resultB)) {extract ($rowB); $accessibility=$rowB[0]; }
					if($accessibility=="No" || mysql_num_rows($resultB)==0) $restricted .= $_COOKIE['currentuser']." is not allowed to assign tickets to other users<br><br>";
				}
				if($ticketpriority!=$parameters[8]){
					$queryB = "SELECT accessible FROM usersmenu where userName ='".$_COOKIE['currentuser']."' and menuOption='Change Ticket Priority'";
					$resultB = mysql_query($queryB, $connection);
					while ($rowB = mysql_fetch_row($resultB)) {extract ($rowB); $accessibility=$rowB[0]; }
					if($accessibility=="No" || mysql_num_rows($resultB)==0) $restricted .= $_COOKIE['currentuser']." is not allowed to change tickets` priorities<br><br>";
				}
				if($ticketstatus!=$parameters[9]){
					$queryB = "SELECT accessible FROM usersmenu where userName ='".$_COOKIE['currentuser']."' and menuOption='Change Ticket Status'";
					$resultB = mysql_query($queryB, $connection);
					while ($rowB = mysql_fetch_row($resultB)) {extract ($rowB); $accessibility=$rowB[0]; }
					if($accessibility=="No" || mysql_num_rows($resultB)==0) $restricted .= $_COOKIE['currentuser']." is not allowed to change tickets` status<br><br>";
				}
				if($restricted!=""){
					echo "restricted".$restricted;
					return true;
				}
			}
			$query = "SELECT * FROM {$table} where ticketno ='{$parameters[1]}' ";
		}
		$ticketpriority="";
		$ticketstatus="";
		if($table=="departmentstable") 
			$query = "SELECT * FROM {$table} where departmentdescription ='{$parameters[1]}' ";
		if($table=="basestationstable") 
			$query = "SELECT * FROM {$table} where basestationdescription ='{$parameters[1]}' ";
		if($table=="locationstable") 
			$query = "SELECT * FROM {$table} where locationdescription ='{$parameters[1]}' ";
		if($table=="equipmentstable") 
			$query = "SELECT * FROM {$table} where equipmentcode ='{$parameters[1]}' ";
		if($table=="equipmentstock") 
			$query = "SELECT * FROM {$table} where serialno ='{$parameters[0]}' ";
		if($table=="requisitiontable") 
			$query = "SELECT * FROM {$table} where serialno ='{$parameters[0]}' ";
		$result = mysql_query($query, $connection);
//echo $query."<br><br>";
		if(mysql_num_rows($result) > 0){
			if($table=="sessionstable" && $parameters[5]="Yes"){
				$query = "UPDATE {$table} set currentperiod='No'";
				mysql_query($query, $connection);
			}
			$record="";
			$count=0;
			while ($row = mysql_fetch_row($result)) {
				extract ($row);
				if($table=="ticketstable"){
				$ticketpriority=$row[8];
				$ticketstatus=$row[9];
				}
				$serialnos=$row[0];
				foreach($row as $i => $value){
					$meta = mysql_fetch_field($result, $i);
					if($count > 0){
						$record .= $meta->name . "='".$parameters[$count++]."', ";
					}else{
						$count++;
					}
				}
			}
			$record = substr($record, 0, strlen($record)-2);
			$query = "UPDATE {$table} set ".$record." where serialno ='{$serialnos}'";
			$result = mysql_query($query, $connection);
//echo $query."<br><br>";
			if($table=="equipmentstock" && $_COOKIE['stockform']!="requisition"){
				$query = "SELECT * FROM equipmentstock where equipmentcode = '{$parameters[1]}' and location = '{$parameters[6]}' order by location, equipmentcode, transactiondate, serialno";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					$balances = 0;
					while ($row = mysql_fetch_array($result)) {
						extract ($row);
						if(!($row[4]>"" && $row[5]=="")){
							$balances = $balances + $row[7] - $row[8];

							$query2 = "update equipmentstock set balance='{$balances}' where serialno='{$serialno}'";
							mysql_query($query2, $connection);
						}
					}
				}
			}
			if($table=="equipmentstock"){
				if($parameters[13]=="Pending" || $parameters[13]=="Denied" || $parameters[13]=="Approved"){
					$to_split="";
					$row3="";
					$row4="";
					if($parameters[13]=="Pending"){
						$to_split="logistics@kkontech.com";
						$row3="Stock";
						$row4="Admin";

					}else if($parameters[13]=="Denied" || $parameters[13]=="Approved"){
						$query = "SELECT * FROM users where userName ='{$parameters[4]}'";
						$result = mysql_query($query, $connection);
						if(mysql_num_rows($result)> 0){
							$row = mysql_fetch_array($result);
							extract ($row);
							$to_split=$row[14];
							$row3=$row[3];
							$row4=$row[4];
						}
					}

					/*require_once "Mail.php";
					$from = "KKON ERP <erp@kkontech.com>";
					$to_splited = explode("@", $to_split);
					$to = $to_splited[0]." <".$to_split.">";
					$subject = "Stock Requisition ".$parameters[13]."!!!";
					$body="Dear ".$row3." ".$row4.",\n\n";
					$body.="Requisition for Equipment: ".$parameters[1]." by ".$parameters[4]." is ";
					$body.=$parameters[13].", Kindly logon to view more details.";
					$body.="\n\n\nMobileTech ERP";
					$host = "41.223.65.120";
					$username = "erp";
					$password = "erp";
					$headers = array ('From' => $from,
					   'To' => $to,
					   'Subject' => $subject);
					$smtp = Mail::factory('smtp',
					   array ('host' => $host,
						 'auth' => true,
						 'username' => $username,
						 'password' => $password));
					 
					$mail = $smtp->send($to, $headers, $body);
					if (PEAR::isError($mail)) {
						echo("<p>" . $mail->getMessage() . "</p>");
					}else {
						echo ("<p>Message successfully sent!</p>");
					}*/

					//Process Email
					require_once('class.phpmailer.php');

					$mail = new phpmailer();  
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
					$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
					$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
					$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
					$mail->Password   = 'olugbade';            // GMAIL password

					//$to = filter_var($to, FILTER_VALIDATE_EMAIL);  // ensure email valid
					//if ('' == $to) exit('Invalid email address!');


					$from_mail = "adewale_azeez@hotmail.com"; 
					$from_name = "Adewale Azeez"; 
					$emailaddress = $from_mail;
					$Ccopy = ""; 
					$Bccopy = ""; 
					$replyto = $from_mail;

					$from = "$from_name <$from_mail>";
					$to_splited = explode("@", $to_split);
					$to = $to_splited[0]." <".$to_split.">";
					$mailto = $to_split;
					$subject = "Stock Requisition ".$parameters[13]."!!!";
					$body="Dear ".$row3." ".$row4.",\n\n";
					$body.="Requisition for Equipment: ".$parameters[1]." by ".$parameters[4]." is ";
					$body.=$parameters[13].", Kindly logon to view more details.";
					$body.="\n\n\n<br><br><br>MobileTech ERP";
					
					$emailresponse = "";

					$mail->From=$emailaddress;
					$mail->FromName = $from_name;
					$mail->AddReplyTo($emailaddress,$from_name);
					$mail->Subject    = $subject;

					// optional, This is the one that the recipient is going to see if he switches to plain text format.
					$mail->AltBody    = $body; 
					
					//$mail->MsgHTML($body);
					$mail->IsHTML(true);
					$mail->Body=$body;

					//$mail->WordWrap = 50;
					//$mail->AddAttachment("embarassingmoments.jpg");

					//$address = 'adewaleazeez@yahoo.com';
					//$mail->AddAddress($userEmail, $fullname);
					$mail->AddAddress($to_split, $to_splited[0]);
					//$mail->AddAttachment($path);

					if($mailto!=null && $mailto!=""){
						if(!$mail->Send()){
								echo("<p>" . $mail->ErrorInfo . "</p>");
						}else {
							echo ("<p>Message successfully sent!</p>");
						}
					}else{
							echo "<p>No email Address!</p>";
					}


				}
			}
			if($table=="ticketstable"){
				//$query = "SELECT * FROM ticket_history where ticketno ={$parameters[1]} ";
				//$result = mysql_query($query, $connection);

				//if(mysql_num_rows($result) == 0){
					$parameters = explode("][", $param2);
					$query = "select max(serialno) as id from ticket_history";
					$result = mysql_query($query, $connection);
					$row = mysql_fetch_array($result);
					extract ($row);
					$serialnos = intval($id)+1;

					$query = "INSERT INTO ticket_history (serialno) VALUES ('{$serialnos}')";
					$result = mysql_query($query, $connection);

					$query = "SELECT * FROM ticket_history where serialno ='{$serialnos}'";
					$result = mysql_query($query, $connection);

					if(mysql_num_rows($result) > 0){
						$record="";
						$count=0;
						while ($row = mysql_fetch_row($result)) {
							extract ($row);
							foreach($row as $i => $value){
								$meta = mysql_fetch_field($result, $i);
								if($count > 0){
									$record .= $meta->name . "='".$parameters[$count++]."', ";
								}else{
									$count++;
								}
							}
						}
						$record = substr($record, 0, strlen($record)-2);
						$query = "UPDATE ticket_history set ".$record." where serialno ='{$serialnos}'";
						$result = mysql_query($query, $connection);

						$query = "UPDATE ticket_history set ticket_priority='' where ticket_priority='{$ticketpriority}' and serialno ='{$serialnos}'";
						$result = mysql_query($query, $connection);
						
						$query = "UPDATE ticket_history set ticket_status='' where ticket_status='{$ticketstatus}' and serialno ='{$serialnos}'";
						$result = mysql_query($query, $connection);
						
						if($parameters[5]>""){
							$query = "SELECT * FROM users where userName ='{$parameters[5]}'";
							$result = mysql_query($query, $connection);
							if(mysql_num_rows($result)> 0){
								$row = mysql_fetch_array($result);
								extract ($row);

								/*require_once "Mail.php";
								$from = "KKON ERP <erp@kkontech.com>";
								$to_splited = explode("@", $row[14]);
								$to = $to_splited[0]." <".$row[14].">";
								$subject = "Ticket Assignment!!!";
								$body="Dear ".$row[3]." ".$row[4].",\n\n";
								$body.="Ticket No ".$parameters[1]." has been assigned to you, Kindly logon to view more details.";
								$body.="\n\n\nMobileTech ERP";
								$host = "41.223.65.120";
								$username = "erp";
								$password = "erp";
								 
								$headers = array ('From' => $from,
								   'To' => $to,
								   'Subject' => $subject);
								$smtp = Mail::factory('smtp',
								   array ('host' => $host,
									 'auth' => true,
									 'username' => $username,
									 'password' => $password));
								 
								$mail = $smtp->send($to, $headers, $body);
								if (PEAR::isError($mail)) {
									echo("<p>" . $mail->getMessage() . "</p>");
								}else {
									echo ("<p>Message successfully sent!</p>");
								}*/

								//Process Email
								require_once('class.phpmailer.php');

								$mail = new phpmailer();  
								$mail->IsSMTP(); // telling the class to use SMTP
								$mail->SMTPAuth   = true;                  // enable SMTP authentication
								$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
								$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
								$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
								$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
								$mail->Password   = 'olugbade';            // GMAIL password

								$from_mail = "adewale_azeez@hotmail.com"; 
								$from_name = "Adewale Azeez"; 
								$emailaddress = $from_mail;
								$Ccopy = ""; 
								$Bccopy = ""; 
								$replyto = $from_mail;

								$from = "$from_name <$from_mail>";
								$to_splited = explode("@", $row[14]);
								$to = $to_splited[0]." <".$row[14].">";
								$mailto = $row[14];
								$subject = "Ticket Assignment!!!";
								$body="Dear ".$row[3]." ".$row[4].",\n\n";
								$body.="Ticket No ".$parameters[1]." has been assigned to you, Kindly logon to view more details.";
								$body.="\n\n\n<br><br><br>MobileTech ERP";
					
								$emailresponse = "";


								$mail->From=$emailaddress;
								$mail->FromName = $from_name;
								$mail->AddReplyTo($emailaddress,$from_name);
								$mail->Subject    = $subject;

								// optional, This is the one that the recipient is going to see if he switches to plain text format.
								$mail->AltBody    = $body; 
								
								//$mail->MsgHTML($body);
								$mail->IsHTML(true);
								$mail->Body=$body;

								//$mail->WordWrap = 50;
								//$mail->AddAttachment("embarassingmoments.jpg");

								//$address = 'adewaleazeez@yahoo.com';
								//$mail->AddAddress($userEmail, $fullname);
								$mail->AddAddress($row[14], $to_splited[0]);
								//$mail->AddAttachment($path);

								if($mailto!=null && $mailto!=""){
									if(!$mail->Send()){
											echo("<p>" . $mail->ErrorInfo . "</p>");
									}else {
										echo ("<p>Message successfully sent!</p>");
									}
								}else{
										echo "<p>No email Address!</p>";
								}


							}
						}
					}
//echo $query."<br><br>";
				//}
			}
			if($table=="users"){
				$query = "SELECT * FROM users where userName ='{$parameters[1]}'";
				$result = mysql_query($query, $connection);
				if(mysql_num_rows($result) > 0){
					$row = mysql_fetch_array($result);
					extract ($row);

					/*require_once "Mail.php";
					$from = "KKON ERP <erp@kkontech.com>";
					$to = $row[3]." ".$row[4]." <".$row[5].">";
					$subject = "Your New Password!!!";
					$body="Dear ".$parameters[3].",\n\n";
					$body.="Your user details has just been updated, your User-Id is: ".$parameters[1]." \n and your password is: ".$parameters[2];
					$body.="\n\n\nPlease click the following link to login to the application: ";
					$body.="www.kkontech.com/kkontech";
                    $body.="\n\nYou can change your Password on User Management";

					$body.="\n\n\nMobileTech ERP";
					 
					$host = "41.223.65.120";
					$username = "erp";
					$password = "erp";
					 
					$headers = array ('From' => $from,
					   'To' => $to,
					   'Subject' => $subject);
					$smtp = Mail::factory('smtp',
					   array ('host' => $host,
						 'auth' => true,
						 'username' => $username,
						 'password' => $password));
					 
					$mail = $smtp->send($to, $headers, $body);
					if (PEAR::isError($mail)) {
						echo("<p>" . $mail->getMessage() . "</p>");
					}else {
						echo ("<p>Message successfully sent!</p>");
					}*/


					//Process Email
					require_once('class.phpmailer.php');

					$mail = new phpmailer();  
					$mail->IsSMTP(); // telling the class to use SMTP
					$mail->SMTPAuth   = true;                  // enable SMTP authentication
					$mail->SMTPSecure = 'tls';                 // sets the prefix to the servier
					$mail->Host       = 'smtp.gmail.com';      // sets GMAIL as the SMTP server
					$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
					$mail->Username   = 'adewaleazeez@gmail.com';  // GMAIL username
					$mail->Password   = 'olugbade';            // GMAIL password

					//$to = filter_var($to, FILTER_VALIDATE_EMAIL);  // ensure email valid
					//if ('' == $to) exit('Invalid email address!');


					$from_mail = "adewale_azeez@hotmail.com"; 
					$from_name = "Adewale Azeez"; 
					$emailaddress = $from_mail;
					$Ccopy = ""; 
					$Bccopy = ""; 
					$replyto = $from_mail;

					$from = "$from_name <$from_mail>";
					$to = $row[3]." ".$row[4]." <".$row[5].">";
					$mailto = $row[5];
					$subject = "Your New Password!!!";
					$body="Dear ".$parameters[3].",\n\n";
					$body.="Your user details has just been updated, your User-Id is: ".$parameters[1]." \n and your password is: ".$parameters[2];
					$body.="\n\n\nPlease click the following link to login to the application: ";
					$body.="www.kkontech.com/kkontech";
                    $body.="\n\nYou can change your Password on User Management";
					$body.="\n\n\n<br><br><br>MobileTech ERP";
					
					$emailresponse = "";

					$mail->From=$emailaddress;
					$mail->FromName = $from_name;
					$mail->AddReplyTo($emailaddress,$from_name);
					$mail->Subject    = $subject;

					// optional, This is the one that the recipient is going to see if he switches to plain text format.
					$mail->AltBody    = $body; 
					
					//$mail->MsgHTML($body);
					$mail->IsHTML(true);
					$mail->Body=$body;

					//$mail->WordWrap = 50;
					//$mail->AddAttachment("embarassingmoments.jpg");

					//$address = 'adewaleazeez@yahoo.com';
					//$mail->AddAddress($userEmail, $fullname);
					$mail->AddAddress($row[5], $row[3]." ".$row[4]);
					//$mail->AddAttachment($path);

					if($mailto!=null && $mailto!=""){
						if(!$mail->Send()){
								echo("<p>" . $mail->ErrorInfo . "</p>");
						}else {
							echo ("<p>Message successfully sent!</p>");
						}
					}else{
							echo "<p>No email Address!</p>";
					}


				}
			}

			echo $table."updated";
		} else {
			echo "recordnotexist";
		}
	}

	if($option == "deleteRecord"){
		$parameters = explode("][", $param);
		$query = "SELECT * FROM {$table} where serialno ='{$serialnos}'";
		if($table=="departmentstable") 
			$query = "SELECT * FROM {$table} where departmentdescription ='{$parameters[1]}' ";
		if($table=="basestationstable") 
			$query = "SELECT * FROM {$table} where basestationdescription ='{$parameters[1]}' ";
		if($table=="locationstable") 
			$query = "SELECT * FROM {$table} where locationdescription ='{$parameters[1]}' ";
		$result = mysql_query($query, $connection);
		if(mysql_num_rows($result) > 0){
			if($table=="departmentstable") 
				$query = "SELECT * FROM users where department ='{$parameters[1]}' ";
			if($table=="basestationstable") 
				$query = "SELECT * FROM clientstable where basestation ='{$parameters[1]}' ";
			if($table=="locationstable") 
				$query = "SELECT * FROM users where location ='{$parameters[1]}' ";
			$result = mysql_query($query, $connection);
			if(mysql_num_rows($result) == 0){
				$query = "DELETE FROM {$table} where serialno ='{$serialnos}'";
				$result = mysql_query($query, $connection);
				echo $table."deleted";
			}else{
				echo $table."recordused";
			}
		} else {
			echo "recordnotexist";
		}
	}

?>

