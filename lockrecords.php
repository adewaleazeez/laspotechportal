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

                $("#lockcourses").dialog({
                    autoOpen: true,
                    position:'center',
                    title: 'Lock Records by Courses',
                    height: 610,
                    width: 1200,
                    modal: false,
                    buttons: {
                        //Lock_Records: function() {
                          //  lockRecords();
                        //},
                        Close: function() {
                            $('#lockcourses').dialog('close');
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
			function storeProgramme(){
				createCookie('programme',document.getElementById("programmecode").value.replace(/ /g,'#'), false);
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
                    <div style="font-size:11px" id="lockcourses">
						<table>
							<tr>
								<td width='15%' align="right"><b>Faculty:</b></td>
								<td width='35%'>
									<input type="text" id="facultycode" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist')" />
								</td>
								<td width='15%' align="right"><b>Department:</b></td>
								<td width='35%'>
									<input type="text" id="departmentcode" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist')" />
								</td>
							</tr>
							<tr>
								<td align="right"><b>Programme:</b></td>
								<td>
									<input type="text" id="programmecode" onkeyup="getRecordlist(this.id,'programmestable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist')" size="50" />
								</td>                        
								<td align="right"><b>Level:</b></td>
								<td>
									<input type="text" id="studentlevel" onkeyup="getRecordlist(this.id,'studentslevels','recordlist');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist')" size="30" />
								</td>                        
							</tr>
							<tr>
								<td width='15%' align="right"><b>Session:</b></td>
								<td width='35%'>
									<input type="text" id="sesions"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist')" size="10" />
								</td>
								<td width='15%' align="right"><b>Semester:</b></td>
								<td width='35%'>
									<input type="text" id="semester" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist')" size="12" />
								</td>
							</tr>
							<tr>
								<!--td align="right"><b>Group Code:</b></td>
								<td>
									<input type="text" id="entryyear" onkeyup="getRecordlist(this.id,'sessionstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist');" size="10" />
								</td-->
								<td colspan="3" align="right"><b>&nbsp;</b></td>
								<td>
									<input type="button" style="display:inline" id="populatecourses" onclick="populateLockCourse('coursecode','ASC')" value=" List Records " />
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="coursetablelist" style="height:400px; overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdiv"></div>
						<div id="recordlist" style="overflow:auto;"></div>
						<!--height:250px; width:250px; -->
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	document.getElementById("facultycode").value=readCookie("_faculty_").replace(/_/g, ',');
	document.getElementById("departmentcode").value=readCookie("_department_").replace(/_/g, ',');
	document.getElementById("programmecode").value=readCookie("_programme_").replace(/_/g, ',');
	document.getElementById("studentlevel").value=readCookie("_level_").replace(/_/g, ',');
	document.getElementById("sesions").value=readCookie("_session_").replace(/_/g, ',');
	document.getElementById("semester").value=readCookie("_semester_").replace(/_/g, ',');
</script>