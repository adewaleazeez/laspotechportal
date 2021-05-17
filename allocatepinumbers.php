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
        <script type='text/javascript' src='js/dataentry.js'></script>
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

                $("#transcriptsheet").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Allocate Pin Numbers',
                    height: 440,
                    width: 1030,
                    modal: false,
                    buttons: {
                        Allocate_Pins: function() {
                            allocatePins();
                        },
                        Email_Pins: function() {
                            emailPins();
                        },
                        Close: function() {
                            $('#transcriptsheet').dialog('close');
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
					<div id="transcriptsheet">
						<table width='100%' style='font-size:10px;'>
							<tr>
								<td align='right'><b>School:</b></td>
								<td>
									<input type="text" id="facultycode4" onkeyup="getRecordlist(this.id,'facultiestable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist8');" size="45" />
								</td>
								<td align='right'><b>Department:</b></td>
								<td>
									<input type="text" id="departmentcode4" onkeyup="getRecordlist(this.id,'departmentstable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist8');" size="45" />
								</td>
							</tr>
							<tr>
								<td align='right'><b>Programme:</b></td>
								<td>
									<input type="text" id="programmecode4" onkeyup="getRecordlist(this.id,'programmestable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist8');" size="45" />
								</td>
								<td align='right'><b>Student Level:</b></td>
								<td>
									<input type="text" id="studentlevel4" onkeyup="getRecordlist(this.id,'studentslevels','recordlist7');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist8');" size="45" />
								</td>
							</tr>
							<tr>
								<td align='right'><b>Session:</b></td>
								<td>
									<input type="text" id="sesions4" onkeyup="getRecordlist(this.id,'sessionstable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist8');" size="45" />
								</td>
								<td align="right"><b>Semester:</b></td>
								<td>
									<input type="text" id="semester4" onkeyup="getRecordlist(this.id,'sessionstable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist8');" size="45" />
								</td>
							</tr>
							<tr>
								<!--td align='right'><b>Final Year:</b></td>
								<td>
									<select style="display:inline" id="finalyear1" onchange="showAwarDate()">
										<option>No</option>
										<option>Yes</option>
									</select>
									&nbsp;&nbsp;&nbsp;
								</td-->
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>
									<!--div id="awardatecover" style="display:inline; visibility: hidden"></div>								
									<div style="display:inline; font-weight:bold;">SMS</div>&nbsp;<input type='checkbox' onclick='doShowSMS()' style="display:inline" id='selectsms'
									&nbsp;&nbsp;&nbsp;-->
									<input type="button" style="display:inline" id="list4pins" onclick="getRecords(this.id)"  value=" List Students " />
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:400px; top:100px; left:400px">Sending......<br/><img src="imageloader.gif" /><br/></div>
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<table width="100%">
										<tr>
											<td width="65%">
												<div id="studentslist" style="height:200px; width:800px; overflow: auto;"></div>
											</td>
											<td>&nbsp;</td>
											<!--td width="35%">
												<div id="smsboxcover" style="visibility: hidden" style="height:250px; overflow:auto;">
													SMS Message:<br>
													<textarea id="smsbox" cols="25" rows="10"></textarea>
												</div>
											</td-->
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<div id='recordlist8'></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	document.getElementById("facultycode4").value=readCookie("_facultys_");
	document.getElementById("departmentcode4").value=readCookie("_departments_");
	document.getElementById("programmecode4").value=readCookie("_programmes_");
	document.getElementById("studentlevel4").value=readCookie("_levels_");
	document.getElementById("sesions4").value=readCookie("_sessions_");
	document.getElementById("semester4").value=readCookie("_semester_");
</script>
