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

                $("#userreport").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Users Reports',
                    height: 440,
                    width: 710,
                    modal: false,
                    buttons: {
                        PDF: function() {
                            doUsersReport();
                        },
                        Close: function() {
                            $('#userreport').dialog('close');
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
			function storeLocationDepartment(locations,department){
				createCookie("selectedlocation",document.getElementById(locations).value,false);
				createCookie("selectedept",document.getElementById(department).value,false);
			}

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="userreport">
			<table>
				<tr>
					<td align='right'><b>Location:</b></td>
					<td colspan="2">
						<input type="text" id="location" name="location" onkeyup="getRecordlist(this.id,'locationstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'locationstable','recordlist');" size="30" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>Department:</b></td>
					<td colspan="2">
						<input type="text" id="department" name="department" onkeyup="getRecordlist(this.id,'departmentstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist');" size="30" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>Users-ID:</b></td>
					<td colspan="2">
						<input type="text" id="username" name="username" onkeyup="getRecordlist(this.id,'users','recordlist');" onclick="storeLocationDepartment('location','department'); this.value=''; getRecordlist(this.id,'users','recordlist');" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>Designation:</b></td>
					<td colspan="2">
						<input type="text" id="usersposition" name="usersposition" onkeyup="getRecordlist(this.id,'users','recordlist');" onclick="this.value=''; getRecordlist(this.id,'users','recordlist');" size="25" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>Active:</b></td>
					<td colspan="2">
						<select id="active">
							<option>Yes/No</option>
							<option>Yes</option>
							<option>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td colspan="2">
						<BR><INPUT type="radio" name="userslist" checked><b>Users Summary List</b><BR><BR>
						<INPUT type="radio" name="userslist"><b>Users Details List</b>
					</td>
				</tr>
			</table>
			<div id='recordlist'></div>
		</div>
    </body>
</html>
