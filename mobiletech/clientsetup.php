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
        <script type="text/javascript">
            checkLogin();
        </script>
        <script type="text/javascript">
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#listclient").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Clients List',
                    height: 420,
                    width: 910,
                    modal: false,
                    buttons: {
                        Add: function() {
							var locations = document.getElementById("locations").value;
							var basestation = document.getElementById("basestationdescription").value;
							var error = "";
							if (locations=="")error += "Location must not be blank.<br><br>";
							if (basestation=="")error += "Base Station must not be blank.<br><br>";
							if (!document.getElementsByName("clienttypeA").item(0).checked 
								&& !document.getElementsByName("clienttypeA").item(1).checked 
								&& !document.getElementsByName("clienttypeA").item(2).checked) 
									error += "Select VPN, INTERNET or RETAILERS.<br><br>";
							if(error.length >0) {
								error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
								document.getElementById("showError").innerHTML = error;
								$('#showError').dialog('open');
								return true;
							}
							document.getElementById("locationB").value=locations;
							document.getElementById("basestationdescriptionB").value=basestation;
							if (document.getElementsByName("clienttypeA").item(0).checked){
								document.getElementById("clienttypeB").value="VPN";
							}else if(document.getElementsByName("clienttypeA").item(1).checked){
								document.getElementById("clienttypeB").value="INTERNET";
							}else if(document.getElementsByName("clienttypeA").item(2).checked){
								document.getElementById("clienttypeB").value="RETAILERS";
							}
							document.getElementById("locationB").disabled=true;
							document.getElementById("basestationdescriptionB").disabled=true;
							document.getElementById("clienttypeB").disabled=true;
                            resetForm("clientstable");
							nextClientNo(locations);
                            $('#clientdetail').dialog('open');
                            $('#listclient').dialog('close');
                        },
                        Send_Mail: function() {
                            sendClientMail();
                        },
                        Close: function() {
                            $('#listclient').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#clientdetail").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'Client Details Setup - Items with RED colour labels are mandatory',
                    height: 420,
                    width: 910,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateClient("addRecord", "clientstable");
                        },
                        Update: function() {
                            updateClient("updateRecord", "clientstable");
                        },
                        New: function() {
                            resetForm("clientstable");
                        },
                        Close: function() {
                            $('#clientdetail').dialog('close');
                            $('#listclient').dialog('open');
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

			function openClientMail(){
				if(document.getElementById("clientmailbox").checked==true){
					document.getElementById("clintmaildiv").innerHTML="Mail Subject:&nbsp;<input type='text' id='clientmailsubject'  size='51'><BR><BR>Mail Body:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id='clientmailtext' rows='4' cols='50'></textarea>";
				}else{
					document.getElementById("clintmaildiv").innerHTML="";
				}
			}
        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="listclient" style="font-size:11px">
			<div id="locationid">
				<table>
					<tr>
						<td align='right'><b>Location:</b></td>
						<td>
							<input type="text" id="locations" name="locations" onkeyup="getRecordlist(this.id,'locationstable','recordlist');" onclick="createCookie('getlocation','1',false); this.value=''; getRecordlist(this.id,'locationstable','recordlist')" size="20" />
						</td>
						<td rowspan='4' id="clintmaildiv"><div></div></td>
					</tr>
					<tr>
						<td align='right'><b>Base Station:</b></td>
						<td>
							<input type="text" id="basestationdescription" name="basestationdescription" onkeyup="getRecordlist(this.id,'basestationstable','recordlist');" onclick="createCookie('getbasestation','1',false); createCookie('selectedlocation',document.getElementById('locations').value,false); this.value=''; getRecordlist(this.id,'basestationstable','recordlist')" size="30" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='3'>
							<INPUT type="radio" name="clienttypeA" style="display:inline" onclick="getClients()" ><b>VPN</b>
							&nbsp;&nbsp;&nbsp;
							<INPUT type="radio" name="clienttypeA" style="display:inline" onclick="getClients()" ><b>INTERNET</b>
							&nbsp;&nbsp;&nbsp;
							<INPUT type="radio" name="clienttypeA" style="display:inline" onclick="getClients()" ><b>RETAILERS</b>
						</td>
					</tr>
					<tr>
						<td colspan='3'>
							<INPUT type="checkbox" id="clientmailbox" style="display:inline" onclick="openClientMail()" >&nbsp;<b>Compose Mail</b>
						</td>
					</tr>
				</table>
				<div id='recordlist'></div>
			</div>
			<div id='clientlist'></div>
		</div>
		<div id="clientdetail" style="font-size:11px">
			<table>
				<tr>
					<td align='right' style=" color: red"><b>Client-Id:</b></td>
					<td>
						<input type="text" id="clientid" name="clientid"  readonly disabled='true' size="20" />
					</td>
					<td align='right' style=" color: red"><b>Client Name:</b></td>
					<td>
						<input type="text" id="clientname" name="clientname" onblur="this.value=capAdd(this.value)" size="25" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Client-Type:</b></td>
					<td>
						<input type="text" id="clienttypeB" name="clienttypeB" onkeyup="getRecordlist(this.id,'clienttypestable','recordlist2');" onclick="createCookie('getlocation','1',false); this.value=''; getRecordlist(this.id,'clienttypestable','recordlist2')" size="20" />
					</td>
					<td align='right' style=" color: red"><b>Location:</b></td>
					<td>
						<input type="text" id="locationB" name="locationB" onkeyup="getRecordlist(this.id,'locationstable','recordlist2');" onclick="createCookie('getlocation','1',false); this.value=''; getRecordlist(this.id,'locationstable','recordlist2')" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Contact_Address:</b></td>
					<td rowspan='2'>
						<textarea id="contactaddress" name="contactaddress" rows="3" cols="30" onblur="this.value=capAdd(this.value)" ></textarea>
					</td>
					<td align='right' style=" color: red"><b>Base_Station:</b></td>
					<td>
						<input type="text" id="basestationdescriptionB" name="basestationdescriptionB" onkeyup="getRecordlist(this.id,'basestationstable','recordlist2');" onclick="createCookie('getbasestation','1',false); createCookie('selectedlocation',document.getElementById('locationB').value,false); this.value=''; getRecordlist(this.id,'basestationstable','recordlist2')" size="30" />
					</td>
				</tr>
				<tr>
					<td colspan='3' align='right' style=" color: red"><b>Office_Phone:</b></td>
					<td>
						<input type="text" id="officephone" name="officephone" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Email:</b></td>
					<td>
						<input type="text" id="emailaddress" name="emailaddress" size="30" />
					</td>
					<td align='right' style=" color: red"><b>Mobile_Phone:</b></td>
					<td>
						<input type="text" id="mobilephone" name="mobilephone" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Bandwidth:</b></td>
					<td>
						<input type="text" id="bandwidth" name="bandwidth" size="30" />
					</td>
					<td align='right'><b>Instalation_Date:</b></td>
					<td>
						<input type="text" style="display:inline" id="instalationdate"  name="instalationdate" size="10"  onclick="displayDatePicker('instalationdate', false, 'dmy', '/');" />
						<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: displayDatePicker('instalationdate', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Contact_Person:</b></td>
					<td>
						<input type="text" id="contactperson" name="contactperson" size="25" onblur="this.value=capAdd(this.value)" />
					</td>
					<td align='right'><b>Birth_Date:</b></td>
					<td>
						<input type="text" style="display:inline" id="birthdate"  name="birthdate" size="10"  onclick="displayDatePicker('birthdate', false, 'dmy', '/');" />
						<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: displayDatePicker('birthdate', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					</td>
				</tr>
				<tr>
					<td align='right'><b>CPE:</b></td>
					<td>
						<input type="text" id="cpe" name="cpe" size="20" />
					</td>
					<td align='right'><b>Radio_IP_Address:</b></td>
					<td>
						<input type="text" id="radioipaddress" name="radioipaddress" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>IP_Address:</b></td>
					<td>
						<input type="text" id="ipaddress" name="ipaddress" size="20" />
					</td>
					<td align='right'><b>Base_Station_IP_Address:</b></td>
					<td>
						<input type="text" id="basestationipaddress" name="basestationipaddress" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>Configuration_Status:</b></td>
					<td>
						<textarea id="configurationstatus" name="configurationstatus" rows="3" cols="30"></textarea>
					</td>
					<td align='right' style=" color: red"><b>Active:</b></td>
					<td>
						<select id="active">
							<option>Yes</option>
							<option>No</option>
						</select>
					</td>
				</tr>
			</table>
			<div id='recordlist2'></div>
		</div>
    </body>
</html>
<script>
	getRecords('clientstable');
</script>