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
        <title>Lagos State Polytechnic Portal Systems</title>
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

                $("#sessions").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Session/Semester Setup',
                    height: 440,
                    width: 710,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateSession("addRecord", "sessionstable");
                        },
                        Delete: function() {
                            updateSession("deleteRecord", "sessionstable");
                        },
                        Update: function() {
                            updateSession("updateRecord", "sessionstable");
                        },
                        New: function() {
                            resetForm("sessionstable");
                        },
                        Close: function() {
                            $('#sessions').dialog('close');
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
        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <tr>
                <td>
                    <div style="font-size:65%; height:235px; width:415px; top:5px; left:10px" id="sessions">
						<table>
							<tr>
								<td><b>Session:</b></td>
								<td>
									<input type="text" id="sessiondescription" name="sessiondescription" size="50" onblur="this.value=capitalize(this.value)" />
								</td>
							</tr>
							<tr>
								<td><b>Semester:</b></td>
								<td>
									<input type="text" id="semesterdescription" name="semesterdescription" size="50" onblur="this.value=capitalize(this.value)" />
								</td>
							</tr>
							<tr>
								<td><b>Semester Start-Date:</b></td>
								<td>
									<input type="text" id="semesterstartdate" name="semesterstartdate" onclick="displayDatePicker('semesterstartdate', false, 'dmy', '/');" title="Click here to display calendar" size="10" />
								</td>
							</tr>
							<tr>
								<td><b>Semester End-Date:</b></td>
								<td>
									<input type="text" id="semesterenddate" name="semesterenddate" onclick="displayDatePicker('semesterenddate', false, 'dmy', '/');" title="Click here to display calendar" size="10" />
								</td>
							</tr>
							<tr>
								<td><b>Current Period:</b></td>
								<td>
									<SELECT ID="currentperiod">
										<OPTION ></OPTION>
										<OPTION >No</OPTION>
										<OPTION >Yes</OPTION>
									</SELECT>
								</td>
							</tr>
						</table>
						<div id="sessionslist" style="height:210px; width:680px; overflow:auto;"></div>
					</div>

                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	getRecords('sessionstable');
</script>