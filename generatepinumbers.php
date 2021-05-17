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

                $("#generatepinumber").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Generate Pin Numbers',
                    height: 550,
                    width: 1100,
                    modal: false,
                    buttons: {
                        Generate_Pins: function() {
                            generatePins();
                        },
                        Close: function() {
                            $('#generatepinumber').dialog('close');
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

			function clearForm(){
				document.getElementById('facultycode4').value='';
				document.getElementById('departmentcode4').value='';
				document.getElementById('programmecode4').value='';
				document.getElementById('studentlevel4').value='';
				document.getElementById('pinslist').innerHTML="<table border='0' style='border-color:#fff;border-style:solid;border-width:1px;height:10px; width:100%;background-color:#336699;margin-top:1px;font-size:10px;'><tr style='height:32px; font-weight:bold; color:white'><td width='5%'>S/No</td><td>Pin Numbers</td><td>Pin Status</td><td>Matric No</td><td>Names</td><td>School</td><td>Departments</td><td>Programmes</td><td>Levels</td></tr>";
			}

        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <tr>
                <td>
					<div id="generatepinumber">
						<table width='100%' style='font-size:10px;'>
							<tr>
								<td align="right"><b>School:</b></td>
								<td>
									<input type="text" id="facultycode4" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist8');" />
								</td>
								<td align="right"><b>Department:</b></td>
								<td>
									<input type="text" id="departmentcode4" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist8');" />
								</td>
							</tr>
							<tr>
								<td align="right"><b>Programme:</b></td>
								<td>
									<input type="text" id="programmecode4" onkeyup="getRecordlist(this.id,'programmestable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist8');" size="50" />
								</td>                        
								<td align="right"><b>Level:</b></td>
								<td>
									<input type="text" id="studentlevel4" onkeyup="getRecordlist(this.id,'studentslevels','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist8');" size="50" />
								</td>                        
							</tr>
							<tr>
								<td align='right'><b>Session:</b></td>
								<td>
									<input type="text" id="sesions4" onkeyup="getRecordlist(this.id,'sessionstable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist8');" size="30" />
								</td>
								<td align="right"><b>Semester:</b></td>
								<td>
									<input type="text" id="semester4" onkeyup="getRecordlist(this.id,'sessionstable','recordlist8');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist8');" size="20" />
								</td>
							</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
								<td>
									<select style="display:inline" id="pintype" onchange="getRecords('listpins',this.id)">
										<option>All</option>
										<option>Open</option>
										<option>Used</option>
									</select>
									<input style="display:inline" type="button" id="listpins" onclick="getRecords(this.id,'pintype')" value=" List Pin Numbers " />
									<input style="display:inline" type="button" id="clearform" onclick="clearForm()" value=" Clear Form " />
								</td>
							</tr>
							<tr>
								<td colspan="4" width="65%">
									<div id="pinslist" style="height:300px; width:1050px; overflow: auto;"></div>
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
	document.getElementById("facultycode4").value=readCookie("_faculty_");
	document.getElementById("departmentcode4").value=readCookie("_department_");
	document.getElementById("programmecode4").value=readCookie("_programme_");
	document.getElementById("studentlevel4").value=readCookie("_studentlevel_");
	document.getElementById("sesions4").value=readCookie("_sessions_");
	document.getElementById("semester4").value=readCookie("_semester_");
</script>
