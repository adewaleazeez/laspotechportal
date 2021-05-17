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
			createCookie("requisitionform","release",false);
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#requisitionlist").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Accounts - Release List',
                    height: 430,
                    width: 1050,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#requisitionlist').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#accountsreleaseupdate").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'Accounts - Release Update',
                    height: 440,
                    width: 710,
                    modal: false,
                    buttons: {
                        Release: function() {
                            saveAccountsRequisition("updateRecord","requisitiontable","ReleaseApproved");
                        },
                        Decline: function() {
                            saveAccountsRequisition("updateRecord","requisitiontable","ReleaseDeclined");
                        },
                        Clear: function() {
							document.getElementById('department2').value ='';
							document.getElementById('requestedby2').value ='';
							document.getElementById('requestedamount2').value ='';
							document.getElementById('purpose2').value ='';
                        },
                        Close: function() {
							$('#requisitionlist').dialog('open');
							$('#accountsreleaseupdate').dialog('close');
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

			function storeDepartment(department){
				createCookie("selectedept",document.getElementById(department).value,false);
			}

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="requisitionlist" style="font-size:11px">
			<table>
				<tr>
					<td>
						<b>Department:</b>&nbsp;<BR><input type="text" id="departmentA" name="departmentA" onkeyup="getRecordlist(this.id,'departmentstable','recordlistA');" onclick="createCookie('getRquisition','1',false); this.value=''; getRecordlist(this.id,'departmentstable','recordlistA');" onblur="document.getElementById('requestedbyA').value='' " size="20" />
					</td>
					<td>
						<b>Requested-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="requestedbyA"  name="requestedbyA" onkeyup="getRecordlist(this.id,'users','recordlistA');" onclick="createCookie('getRquisition','1',false); this.value=''; storeDepartment('departmentA'); getRecordlist(this.id,'users','recordlistA');" size="25" />
					</td>
					<td>
						<b>Supervisor Approval-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="superapprovedbyA"  name="superapprovedbyA" onkeyup="getRecordlist(this.id,'users','recordlistA');" onclick="createCookie('getRquisition','1',false); this.value=''; createCookie('selectedept','',false); getRecordlist(this.id,'users','recordlistA');" size="25" />
					</td>
					<td>
						<b>Accounts Approval-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="approvedbyA"  name="approvedbyA" onkeyup="getRecordlist(this.id,'users','recordlistA');" onclick="createCookie('getRquisition','1',false); this.value=''; createCookie('selectedept','',false); getRecordlist(this.id,'users','recordlistA');" size="25" />
					</td>
					<td>
						<b>Released-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="releasedbyA"  name="releasedbyA" onkeyup="getRecordlist(this.id,'users','recordlistA');" onclick="createCookie('getRquisition','1',false); this.value=''; createCookie('selectedept','',false); getRecordlist(this.id,'users','recordlistA');" size="25" />
					</td>
					<td>
						<b>Start_Date:</b>&nbsp;<BR><input type="text" style="display:inline" id="start_dateA"  name="start_dateA" size="10"  onclick="createCookie('getRquisition','1',false); displayDatePicker('start_dateA', false, 'dmy', '/');" />
						<!--a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getStocks','1',false); displayDatePicker('start_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a-->
					</td>
					<td>
						<b>End_Date:</b>&nbsp;<BR><input type="text" style="display:inline" id="end_dateA"  name="end_dateA" size="10"  onclick="createCookie('getRquisition','1',false); displayDatePicker('end_dateA', false, 'dmy', '/');" />
						<!--a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getStocks','1',false); displayDatePicker('end_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a-->
					</td>
				</tr>
			</table>
			<div id='recordlistA'></div>
			<div id='requisitionslist'></div>
		</div>
		<div id="accountsreleaseupdate">
			<table style="font-size:11px">
				<tr>
					<td align='right' style=" color: red"><b>Requisition Date:</b></td>
					<td>
						<input type="text" id="requisitiondate2" name="requisitiondate2" readonly disabled="true" size="10" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Department:</b></td>
					<td>
						<input type="text" id="department2" name="department2" readonly disabled="true" size="20" />
						<!--onkeyup="getRecordlist(this.id,'departmentstable','recordlist2');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist2');" onblur="document.getElementById('requestedby2').value='' "-->
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Requested By:</b></td>
					<td>
						<input type="text" id="requestedby2" name="requestedby2" readonly disabled="true" size="30" />
						<!-- onkeyup="getRecordlist(this.id,'users','recordlist2');" onclick="this.value=''; storeDepartment('department2'); getRecordlist(this.id,'users','recordlist2');" -->
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Amount Requested:</b></td>
					<td>
						<input type="text" id="requestedamount2" name="requestedamount2" size="25" style="text-align:right;" onblur="this.value=numberFormat(this.value)" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Purpose:</b></td>
					<td>
						<input type="hidden" id="transtatus"  name="transtatus" />
						<input type="hidden" id="lockrec"  name="lockrec" />
						<textarea id="purpose2" name="purpose2" rows="3" cols="70"></textarea>
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Supervisor Approval By:</b></td>
					<td>
						<input type="text" id="superapprove" name="superapprove" readonly disabled="true" size="30" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Accounts Approval By:</b></td>
					<td>
						<input type="text" id="approvedby2" name="approvedby2" readonly disabled="true" size="30" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Released By:</b></td>
					<td>
						<input type="text" id="releasedby2" name="releasedby2" readonly disabled="true" size="30" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>If Declining Give Reason(s):</b></td>
					<td>
						<textarea id="reason" name="reason" rows="5" cols="70"></textarea>
					</td>
				</tr>
			</table>
			<div id='recordlist2'></div>
		</div>
    </body>
</html>
<script>
	getAccountsRequisition(readCookie("requisitionform"));
</script>
