<!-- 
    Document   : login
    Created on : 28-Feb-2011
    Author     : Adewale Azeez
-->

<!--@page contentType="text/html" pageEncoding="UTF-8"-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>MobileTech Portal Systems</title>
		<!-- DEMO styles - specific to this page -->
		<link rel="stylesheet" type="text/css" href="css/complex.css" />
        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
        <link href="css/calendar.css" rel="stylesheet" type="text/css"/>
		<!--[if lte IE 7]>
			<style type="text/css"> body { font-size: 85%; } </style>
		<![endif]-->

        <script type="text/javascript" src="js/calendar.js"></script>
		<script type="text/javascript" src="js/jquery-ui-latest.js"></script>
		<script type="text/javascript" src="js/jquery.layout-latest.js"></script>
		<script type="text/javascript" src="js/complex.js"></script>
		<script type="text/javascript" src="js/setup.js"></script>
		<script type="text/javascript" src="js/utilities.js"></script>
		<script language="javascript" src="js/jquery.marquee.js"></script>

		<link href="css/mycss.css" rel="stylesheet" type="text/css"/>
		<link href="css/westmart.css" rel="stylesheet" type="text/css"/>
		<!--link rel="stylesheet" href="css/main.css" media="screen"-->
		<link rel="stylesheet" href="css/style.css" media="screen">
		<link rel="stylesheet" href="css/colors.css" media="screen">

        <script type="text/javascript">
            checkLogin();
        </script>
        <script type="text/javascript">
			createCookie("ticketform","editticket",false);
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#ticketlist").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Tickets List',
                    height: 430,
                    width: 1010,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#ticketlist').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#ticketsformnew").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'New Ticket Update',
                    height: 430,
                    width: 1010,
                    modal: false,
                    buttons: {
                        Submit_Ticket: function() {
                            saveTicket("addRecord","ticketstable");
                        },
                        Reset_Ticket: function() {
 							getTicketNo();
							document.getElementById('clientid').value ='';
							checkClient();
                        },
                        Close: function() {
                            $('#ticketsformnew').dialog('close');
                            $('#ticketlist').dialog('open');
							//window.location="home.php?pgid=1";
							//getRecords('ticketstable');
							getTickets();
                        }
                    }
                });

                $("#ticketsformupdate").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'Existing Ticket Update',
                    height: 430,
                    width: 1010,
                    modal: false,
                    buttons: {
                        Submit_Ticket: function() {
                            saveTicket("updateRecord","ticketstable");
                        },
                        Close: function() {
                            $('#ticketsformupdate').dialog('close');
                            $('#ticketlist').dialog('open');
							//window.location="home.php?pgid=1";
							//getRecords('ticketstable');
							getTickets();
                        }
                    }
                });

                $("#showPrompt").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Alert!!!',
                    height: 300,
                    width: 300,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $('#showPrompt').dialog('close');
                        }
                    }
                });

                $("#showAlert").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Alert!!!',
                    height: 280,
                    width: 350,
                    modal: true
                });

                $("#showError").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Error Message',
                    height: 300,
                    width: 300,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $('#showError').dialog('close');
                        }
                    }
                });

            });
            function browseFiles2(){
                var txtFile = document.getElementById("txtFile2");
                txtFile.click();
            }

			function submitForm2(){
                var submitButton = document.getElementById("submitButton2");
                submitButton.click();
			}

			function startUpload2(){
				var filename = document.getElementById('txtFile2').value;
				var filenames = filename.split("\\");
				var theDoc = filenames[filenames.length-1];
				createCookie("theDoc",theDoc,false);
				document.getElementById('f1_upload_process').style.visibility = 'visible';
			}

			function stopUpload(success){
				var result = '';
				if(success == 1){
					result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
					//alert("The file was uploaded successfully!");
				}else {
					createCookie("theDoc",null,false);
					result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
					alert("There was an error during file upload!");
				}
				document.getElementById('f1_upload_process').style.visibility = 'hidden';
                var theDoc = readCookie("theDoc");
                var id = readCookie("currentdocid");
                if(theDoc!=null){
                    var actionid = "actionid"+id;
                    var docid = "docid"+id;
                    document.getElementById(docid).value = theDoc;
                    var str = "<a href=javascript:viewDoc('"+theDoc+"')>View</a>&nbsp;&nbsp;<a href=javascript:deleteDoc('"+id+"')>Delete</a>";
                    document.getElementById(actionid).innerHTML = str;
                }
			}

            function browseFiles3(){
                var txtFile = document.getElementById("txtFile3");
                txtFile.click();
            }

			function submitForm3(){
                var submitButton = document.getElementById("submitButton3");
                submitButton.click();
			}

			function startUpload3(){
				var filename = document.getElementById('txtFile3').value;
				var filenames = filename.split("\\");
				var theDoc = filenames[filenames.length-1];
				createCookie("theDoc",theDoc,false);
				document.getElementById('f1_upload_process3').style.visibility = 'visible';
			}

			function storeDepartment(department){
				createCookie("selectedept",document.getElementById(department).value,false);
			}

			function storeClientLocation(client,locations){
				createCookie("selectedclient",document.getElementById(client).value,false);
				createCookie("selectedlocation",document.getElementById(locations).value,false);
			}
			eraseCookie("selectedlocation");
        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="ticketlist" style="font-size:11px">
			<table>
				<tr>
					<td>
						<INPUT type="radio" name="ticket_statusA" style="display:inline" onclick="getTickets()" ><b>All_Tickets</b>
					</td>
					<td>
						<INPUT type="radio" name="ticket_statusA" style="display:inline" onclick="getTickets()" ><b>Open_Tickets</b>
					</td>
					<td>
						<INPUT type="radio" name="ticket_statusA" style="display:inline" onclick="getTickets()" ><b>Closed_Tickets</b>
					</td>
					<td>
						<b>Client-ID:</b>&nbsp;<BR><input type="text" id="clientidA" name="clientidA" style="display:inline" onkeyup="getRecordlist(this.id,'clientstable','recordlist2');" onclick="createCookie('getclient','1',false); this.value=''; getRecordlist(this.id,'clientstable','recordlist2')" size="15" />
					</td>
					<td>
						<b>Location:</b>&nbsp;<BR><input type="text" id="locationA" name="locationA" style="display:inline" onkeyup="getRecordlist(this.id,'locationstable','recordlist2');" onclick="createCookie('getlocationB','1',false); this.value=''; getRecordlist(this.id,'locationstable','recordlist2')" size="15" />
					</td>
					<td>
						<b>Ticket-No:</b>&nbsp;<BR><input type="text" id="ticketnoA" name="ticketnoA" style="display:inline" onkeyup="getRecordlist(this.id,'ticketstable','recordlist2');" onclick="createCookie('geticketnoB','1',false); storeClientLocation('clientidA','locationA'); this.value=''; getRecordlist(this.id,'ticketstable','recordlist2')" size="15" />
					</td>
					<td>
						<b>Client Type:</b>&nbsp;<BR>
						<select id="clienttype" style="display:inline" onchange="getTickets()" >
							<option>Select Client Type</option>
							<option>VPN</option>
							<option>INTERNET</option>
							<option>RETAILERS</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<b>Date_created:</b>&nbsp;<BR><input type="text" style="display:inline" id="ticket_dateA"  name="ticket_dateA" size="10"  onclick="createCookie('getTickets','1',false); displayDatePicker('ticket_dateA', false, 'dmy', '/');" />
						<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getTickets','1',false); displayDatePicker('ticket_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					</td>
					<td>
						<b>Due_Date:</b>&nbsp;<BR><input type="text" style="display:inline" id="due_dateA"  name="due_dateA" size="10"  onclick="createCookie('getTickets','1',false); displayDatePicker('due_dateA', false, 'dmy', '/');" />
						<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getTickets','1',false); displayDatePicker('due_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					</td>
					<td>
						<b>Ticket_Priority:</b>&nbsp;<BR>
						<select id="ticket_priorityA" style="display:inline" onchange="getTickets()" >
							<option>Select Priority</option>
							<option>Low</option>
							<option>Normal</option>
							<option>High</option>
							<option>Emergency</option>
						</select>
					</td>
					<td>
						<b>Help_Topic:</b>&nbsp;<BR>
						<select id="help_topicA" style="display:inline" onchange="getTickets()" >
							<option>Select Topic</option>
							<option>Billing</option>
							<option>Support</option>
						</select>
					</td>
					<td>
						<b>Ticket_Source:</b>&nbsp;<BR>
						<select id="ticket_sourceA" style="display:inline"  onchange="getTickets()" >
							<option>Select Source</option>
							<option>Phone</option>
							<option>Email</option>
							<option>Other</option>
						</select>
					</td>
					<td>
						<BR><input type="button" style="display:inline" onclick="getTicketNo();" value=" New Ticket ">
					</td>
					<td>
						<BR><input type="button" style="display:inline" onclick="getTickets(readCookie('currentuser'));" value=" My Tickets ">
					</td>
				</tr>
			</table>
			<div id='recordlist2'></div>
			<div id='ticketslist'></div>
		</div>
		<div id="ticketsformnew">
			<div id="client_div" width="990px">
				<table style="font-size:11px">
					<tr>
						<td align='right' style=" color: red"><b>Client-ID:</b></td>
						<td>
							<input type="text" id="clientid" name="clientid" onkeyup="getRecordlist(this.id,'clientstable','recordlist');" onclick="createCookie('getclientB','1',false); getRecordlist(this.id,'clientstable','recordlist');" onblur="checkClient();" size="30" style='display:inline' />
							<input type="button" onclick="document.getElementById('clientid').value =''; getRecordlist(this.id,'clientstable','recordlist'); checkClient();" value=" Clear " style='display:inline' >
						</td>
						<td align='right' style=" color: red"><b>Client Name:</b></td>
						<td>
							<input type="text" id="clientname" name="clientname" readonly disabled="true" size="30" />
						</td>
					</tr>
				</table>
				<div id="clientdetails"></div>
			</div>
			<div id="container" width="690px">
				<table style="font-size:11px">
					<tr>
						<td align='right' style=" color: red"><b>Ticket No:</b></td>
						<td>
							<input type="text" id="ticketno" name="ticketno" readonly disabled="true" size="20" />
						</td>
						<td align='right' style=" color: red"><b>Date_Created:</b></td>
						<td>
							<input type="text" style="display:inline" id="ticket_date"  name="ticket_date" size="10" readonly disabled="true" />
						</td>
					</tr>
					<tr>
						<td align='right' style=" color: red"><b>Ticket_Source:</b></td>
						<td>
							<select id="ticket_source">
								<option>Select Source</option>
								<option>Phone</option>
								<option>Email</option>
								<option>Other</option>
							</select>
						</td>
						</td>
						<td align='right' style=" color: red"><b>Help_Topic:</b></td>
						<td>
							<select id="help_topic">
								<option>Select Topic</option>
								<option>Billing</option>
								<option>Support</option>
							</select>
						</td>
						</td>
					</tr>
					<tr>
						<td align='right' style=" color: red"><b>Ticket_Priority:</b></td>
						<td>
							<select id="ticket_priority">
								<option>Select Priority</option>
								<option>Low</option>
								<option>Normal</option>
								<option>High</option>
								<option>Emergency</option>
							</select>
						</td>
						</td>
						<td align='right' style=" color: red"><b>Ticket_Status:</b></td>
						<td colspan="2">
							<select id="ticket_status">
								<option>Select Status</option>
								<option>Open</option>
								<option>Closed</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align='right' style=" color: red"><b>Subject:</b></td>
						<td>
							<input type="text" id="ticket_subject" name="ticket_subject" size="25" />
						</td>
						<td align='right'><b>Due_Date:</b></td>
						<td>
							<input type="text" style="display:inline" id="due_date"  name="due_date" size="10"  onclick="displayDatePicker('due_date', false, 'dmy', '/');" />
							<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: displayDatePicker('due_date', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
						</td>
					</tr>
				</table>
				<table style="font-size:11px" align="center" class="message" cellspacing="0" cellpadding="1" width="100%" border=0>
					<tr>
						<th colspan='4'>
							<div id="assignor"></div>
							<input type="hidden" id="userid" name="userid"/>
							<input type="hidden" id="usertime" name="usertime"/>
							<input type="hidden" id="source_department" name="source_department"/>
						</th>
					</tr>
					<tr>
						<td align='right' style=" color: red"><b>Assign To:</b></td>
						<td>
							<div style='display:inline;color: red'><b>Department:&nbsp;</b></div><input type="text" id="assigned_department" name="assigned_department" onkeyup="getRecordlist(this.id,'departmentstable','recordlist');" onclick="getRecordlist(this.id,'departmentstable','recordlist');" size="20" style='display:inline' /><BR><BR>
							<div style='display:inline;color: red'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff-ID:&nbsp;</b></div><input type="text" id="ticket_assignee" name="ticket_assignee" onkeyup="getRecordlist(this.id,'users','recordlist');" onclick="storeDepartment('assigned_department'); getRecordlist(this.id,'users','recordlist'); createCookie('getclientB','1',false);" onblur="checkClient();" size="20" style='display:inline' /><BR>
						</td>
						<td align='right' style=" color: red"><b>Issue_Summary:</b></td>
						<td>
							<textarea id='ticket_message' name='ticket_message' rows='5' cols='100'></textarea>
						</td>
					</tr>
				</table>
			</div>
			<table>
				<tr>
					<td colspan='4'>
						<div id="supportdocs"></div><BR>
						<input type="button" id="adddocs" onclick="addDoc()" value="Add a Document" />
						<form action="uploadfile.php?ftype=doc" method="post" enctype="multipart/form-data" target="upload_target2" onsubmit="startUpload2();" >
							<div style="visibility: hidden">
								<input type="file" name="txtFile2" id="txtFile2" onchange="javascript:submitForm2();" />
								<INPUT TYPE="submit" id="submitButton2" value="Submit" name="submitButton2" />
							</div>
							<iframe id="upload_target2" name="upload_target2" style="width:0;height:0;border:0px solid #fff;"></iframe>
						</form>
						<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:200px; top:100px; left:400px">Loading...<br/><img src="imageloader.gif" /><br/></div>
					</td>
				</tr>
			</table>
			<div id='recordlist'></div>
		</div>
		<div id="ticketsformupdate">
			<div id="client_div3" width="690px">
				<table style="font-size:11px">
					<tr>
						<td align='right' style=" color: red"><b>Client-ID:</b></td>
						<td>
							<input type="text" id="clientid3" name="clientid3" size="30" readonly disabled="true" />
						</td>
						<td align='right' style=" color: red"><b>Client Name:</b></td>
						<td>
							<input type="text" id="clientname3" name="clientname3" readonly disabled="true" size="30" />
						</td>
					</tr>
					<tr>
						<td align='right' style=' color: red'><b>Contact_Address:</b></td>
						<td>
							<textarea id='contactaddress3' name='contactaddress3' readonly disabled='true' rows='2' cols='30' ></textarea>
						</td>
						<td align='right' style=' color: red'><b>Office_Phone:</b></td>
						<td>
							<input type='text' id='officephone3' name='officephone3' value='"+break_resp[7]+"' readonly disabled='true' size='20' />
						</td>
					</tr>
					<tr>
						<td align='right' style=' color: red'><b>Email:</b></td>
						<td>
							<input type='text' id='emailaddress3' name='emailaddress3' value='"+break_resp[9]+"' readonly disabled='true' size='30' />
						</td>
						<td align='right' style=' color: red'><b>Mobile_Phone:</b></td>
						<td>
							<input type='text' id='mobilephone3' name='mobilephone3' value='"+break_resp[8]+"' readonly disabled='true' size='20' />
						</td>
					</tr>
					<tr>
						<td align='right' style=' color: red'><b>Contact_Person:</b></td>
						<td>
							<input type='text' id='contactperson3' name='contactperson3' value='"+break_resp[13]+"' readonly disabled='true' size='25' />
						</td>
						<td align='right' style=' color: red'><b>Birth_Date:</b></td>
						<td>
							<input type='text' style='display:inline' id='birthdate3' name='birthdate3' readonly disabled='true' size='10' />
						</td>
					</tr>
				</table>
			</div>
			<div id="container2" width="690px">
				<table style="font-size:11px">
					<tr>
						<td align='right' style=" color: red"><b>Ticket No:</b></td>
						<td>
							<input type="text" id="ticketno3" name="ticketno3" readonly disabled="true" size="20" />
						</td>
						<td align='right' style=" color: red"><b>Date_Created:</b></td>
						<td>
							<input type="text" style="display:inline" id="ticket_date3"  name="ticket_date3" size="10" readonly disabled="true" />
						</td>
					</tr>
					<tr>
						<td align='right' style=" color: red"><b>Ticket_Source:</b></td>
						<td>
							<select id="ticket_source3"  readonly disabled="true">
								<option>Select Source</option>
								<option>Phone</option>
								<option>Email</option>
								<option>Other</option>
							</select>
						</td>
						</td>
						<td align='right' style=" color: red"><b>Help_Topic:</b></td>
						<td>
							<select id="help_topic3"  readonly disabled="true">
								<option>Select Topic</option>
								<option>Billing</option>
								<option>Support</option>
							</select>
						</td>
						</td>
					</tr>
					<tr>
						<td align='right' style=" color: red"><b>Ticket_Priority:</b></td>
						<td>
							<select id="ticket_priority3">
								<option>Select Priority</option>
								<option>Low</option>
								<option>Normal</option>
								<option>High</option>
								<option>Emergency</option>
							</select>
						</td>
						</td>
						<td align='right' style=" color: red"><b>Ticket_Status:</b></td>
						<td colspan="2">
							<select id="ticket_status3">
								<option>Select Status</option>
								<option>Open</option>
								<option>Closed</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align='right' style=" color: red"><b>Subject:</b></td>
						<td>
							<input type="text" id="ticket_subject3" name="ticket_subject3" size="25" readonly disabled="true"/>
						</td>
						<td align='right'><b>Due_Date:</b></td>
						<td>
							<input type="text" style="display:inline" id="due_date3"  name="due_date3" size="10"  onclick="displayDatePicker('due_date3', false, 'dmy', '/');" />
							<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: displayDatePicker('due_date3', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
						</td>
					</tr>
				</table>
				<div id="t_history"></div>
				<table style="font-size:11px" align="center" class="response" cellspacing="0" cellpadding="1" width="100%" border=0>
					<tr>
						<th colspan='4'>
							<div id="assignor3"></div>
							<input type="hidden" id="userid3" name="userid3"/>
							<input type="hidden" id="usertime3" name="usertime3"/>
							<input type="hidden" id="source_department3" name="source_department3"/>
						</th>
					</tr>
					<tr>
						<td align='right'><b>Assign To:</b></td>
						<td>
							<div style='display:inline;'><b>Department:&nbsp;</b></div><input type="text" id="assigned_department3" name="assigned_department3" onkeyup="getRecordlist(this.id,'departmentstable','recordlist3');" onclick="getRecordlist(this.id,'departmentstable','recordlist3');" size="20" style='display:inline' /><BR><BR>
							<div style='display:inline;'><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff-ID:&nbsp;</b></div><input type="text" id="ticket_assignee3" name="ticket_assignee3" onkeyup="getRecordlist(this.id,'users','recordlist3');" onclick="storeDepartment('assigned_department3'); getRecordlist(this.id,'users','recordlist3'); createCookie('getclientB','1',false);" onblur="checkClient();" size="20" style='display:inline' /><BR>
						</td>
						<td align='right'><b>Response:</b></td>
						<td>
							<textarea id='ticket_message3' name='ticket_message3' rows='5' cols='100'></textarea>
						</td>
					</tr>
				</table>
			</div>
			<table>
				<tr>
					<td colspan='4'>
						<div id="supportdocs3"></div><BR>
						<input type="button" id="adddocs3" onclick="addDoc()" value="Add a Document" />
						<form action="uploadfile.php?ftype=doc" method="post" enctype="multipart/form-data" target="upload_target3" onsubmit="startUpload3();" >
							<div style="visibility: hidden">
								<input type="file" name="txtFile3" id="txtFile3" onchange="javascript:submitForm3();" />
								<INPUT TYPE="submit" id="submitButton3" value="Submit" name="submitButton3" />
							</div>
							<iframe id="upload_target3" name="upload_target3" style="width:0;height:0;border:0px solid #fff;"></iframe>
						</form>
						<div id="f1_upload_process3" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:200px; top:100px; left:400px">Loading...<br/><img src="imageloader.gif" /><br/></div>
					</td>
				</tr>
			</table>
			<div id='recordlist3'></div>
		</div>
    </body>
</html>
<script>
	getRecords('ticketstable');
</script>
