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
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#accountreport").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Account Reports',
                    height: 420,
                    width: 1050,
                    modal: false,
                    buttons: {
                        PDF: function() {
                            doAccountReport();
                        },
                        Close: function() {
                            $('#accountreport').dialog('close');
							window.location="home.php?pgid=0";
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
		<div id="accountreport" style="font-size:11px">
			<table>
				<tr>
					<td>
						<b>Department:</b>&nbsp;<BR><input type="text" id="departmentA" name="departmentA" onkeyup="getRecordlist(this.id,'departmentstable','recordlist');" onclick="createCookie('getRquisition','1',false); this.value=''; getRecordlist(this.id,'departmentstable','recordlist');" onblur="document.getElementById('requestedbyA').value='' " size="20" />
					</td>
					<td>
						<b>Requested-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="requestedbyA"  name="requestedbyA" onkeyup="getRecordlist(this.id,'users','recordlist');" onclick="createCookie('getRquisition','1',false); this.value=''; storeDepartment('departmentA'); getRecordlist(this.id,'users','recordlist');" size="30" />
					</td>
					<td>
						<b>Supervisor Approval-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="superapprovedbyA"  name="superapprovedbyA" onkeyup="getRecordlist(this.id,'users','recordlist');" onclick="createCookie('getRquisition','1',false); this.value=''; createCookie('selectedept','',false); getRecordlist(this.id,'users','recordlist');" size="25" />
					</td>
					<td>
						<b>Accounts Approval-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="approvedbyA"  name="approvedbyA" onkeyup="getRecordlist(this.id,'users','recordlist');" onclick="createCookie('getRquisition','1',false); this.value=''; createCookie('selectedept','',false); getRecordlist(this.id,'users','recordlist');" size="25" />
					</td>
					<td>
						<b>Released-By:</b>&nbsp;<BR><input type="text" style="display:inline" id="releasedbyA"  name="releasedbyA" onkeyup="getRecordlist(this.id,'users','recordlist');" onclick="createCookie('getRquisition','1',false); this.value=''; createCookie('selectedept','',false); getRecordlist(this.id,'users','recordlist');" size="30" />
					</td>
					<td>
						<b>Start_Date:</b>&nbsp;<BR><input type="text" style="display:inline" id="start_dateA"  name="start_dateA" size="10"  onclick="createCookie('getRquisition','1',false); displayDatePicker('start_dateA', false, 'dmy', '/');" />
						<!--a title="Click here for calendar" style="display:inline; background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getStocks','1',false); displayDatePicker('start_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a-->
					</td>
					<td>
						<b>End_Date:</b>&nbsp;<BR><input type="text" style="display:inline" id="end_dateA"  name="end_dateA" size="10"  onclick="createCookie('getRquisition','1',false); displayDatePicker('end_dateA', false, 'dmy', '/');" />
						<!--a title="Click here for calendar" style="display:inline; background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getStocks','1',false); displayDatePicker('end_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a-->
					</td>
				</tr>
				<tr>
					<td><div style='display:inline'><b>Transaction Type:&nbsp;</b></div>
						<select id='selectedoption' style='display:inline'>
							<option>All Transactions</option>
							<option>Requested</option>
							<option>SupervisorApproved</option>
							<option>SupervisorDeclined</option>
							<option>AccountsApproved</option>
							<option>AccountsDeclined</option>
							<option>ReleaseApproved</option>
							<option>ReleaseDeclined</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<BR><INPUT type="radio" name="accountbutton" checked><b>Accounts Summary List</b><BR><BR>
						<INPUT type="radio" name="accountbutton"><b>Accounts Details List</b>
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div id='recordlist'></div>
		</div>
    </body>
</html>
