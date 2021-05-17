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

                $("#ticketreport").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Tickets Reports',
                    height: 440,
                    width: 1010,
                    modal: false,
                    buttons: {
                        PDF: function() {
                            doTicketReport();
                        },
                        Close: function() {
                            $('#ticketreport').dialog('close');
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
			function storeLocation(locations){
				createCookie("selectedlocation",document.getElementById(locations).value,false);
			}

			function storeClientLocation(client,locations){
				createCookie("selectedclient",document.getElementById(client).value,false);
				createCookie("selectedlocation",document.getElementById(locations).value,false);
			}

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="ticketreport" style="font-size:11px">
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
						<b>Client-ID:</b>&nbsp;<BR><input type="text" id="clientidA" name="clientidA" style="display:inline" onkeyup="getRecordlist(this.id,'clientstable','recordlist');" onclick="createCookie('getclient','1',false); this.value=''; getRecordlist(this.id,'clientstable','recordlist')" size="15" />
					</td>
					<td>
						<b>Location:</b>&nbsp;<BR><input type="text" id="locationA" name="locationA" style="display:inline" onkeyup="getRecordlist(this.id,'locationstable','recordlist');" onclick="createCookie('getlocationB','1',false); this.value=''; getRecordlist(this.id,'locationstable','recordlist')" size="15" />
					</td>
					<td>
						<b>Ticket-No:</b>&nbsp;<BR><input type="text" id="ticketnoA" name="ticketnoA" style="display:inline" onkeyup="getRecordlist(this.id,'ticketstable','recordlist');" onclick="storeClientLocation('clientidA','locationA'); this.value=''; getRecordlist(this.id,'ticketstable','recordlist')" size="15" />
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
					<td colspan="2">
						<BR><INPUT type="radio" name="ticketlist" checked><b>Ticket Summary List</b><BR><BR>
						<INPUT type="radio" name="ticketlist"><b>Ticket Details List</b>
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div id='recordlist'></div>
		</div>
    </body>
</html>
