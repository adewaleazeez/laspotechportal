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

                $("#coursetable").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Courses Setup',
                    height: 440,
                    width: 1010,
                    modal: false,
                    buttons: {
                        Copy_From_Previous_Session: function() {
                            CopyCourseFromPreviousSession();
                        },
                        Close: function() {
                            $('#coursetable').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#copycoursetable").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Copy Courses',
                    height: 450,
                    width: 1000,
                    modal: false,
                    buttons: {
                        Paste_To_Current_Session: function() {
                            PasteCourseToCurrentSession();
                        },
                        Close: function() {
                            $('#copycoursetable').dialog('close');
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
				createCookie('programme',document.getElementById("programmecode2").value.replace(/ /g,'#'), false);
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
					<div style="font-size:11px;" id="coursetable">
						<table>
							<tr>
								<td width='15%' align="right"><b>School:</b></td>
								<td width='35%'>
									<input type="text" id="facultycode2" onkeyup="getRecordlist(this.id,'facultiestable','recordlist4');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist4'); createCookie('getunit','1',false);" size="50" />
								</td>
								<td width='15%' align="right"><b>Department:</b></td>
								<td width='35%'>
									<input type="text" id="departmentcode2" onkeyup="getRecordlist(this.id,'departmentstable','recordlist4');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist4'); createCookie('getunit','1',false);" size="50" />
								</td>
							</tr>
							<tr>
								<td align="right"><b>Programme:</b></td>
								<td>
									<input type="text" id="programmecode2" onkeyup="getRecordlist(this.id,'programmestable','recordlist4');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist4'); createCookie('getunit','1',false);" size="50" />
								</td>                        
								<td align="right"><b>Level:</b></td>
								<td>
									<input type="text" id="studentlevel2" onkeyup="getRecordlist(this.id,'studentslevels','recordlist4');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist4'); createCookie('getunit','1',false);" size="30" />
								</td>                        
							</tr>
							<tr>
								<td width='15%' align="right"><b>Session:</b></td>
								<td width='35%'>
									<input type="text" id="sesions"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist4');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist4'); createCookie('getunit','1',false);" size="10" />
								</td>
								<td width='15%' align="right"><b>Semester:</b></td>
								<td width='35%'>
									<input type="text" id="semester" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist4');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist4'); createCookie('getunit','1',false);" size="12" />
								</td>
							</tr>
							<tr>
								<td align="right"><b>Maximum Units:</b></td>
								<td>
									<input type="text" id="maximumunit" onblur="doMaxUnit('add');" size="10" />
								</td>
								<td><b>&nbsp;</b></td>
								<td>
									<input type="button" style="display:inline" id="populatecourses" onclick="createCookie('ordersort','ASC',false); populateCourse('coursecode')" value=" List Records " />
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="coursetablelist" style="width:950px; height:210px; overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdiv"></div>
						<div id="recordlist4" style="overflow:auto;"></div>
						<!--height:250px; width:250px; -->
					</div>

                    <div style="font-size:11px" id="copycoursetable">
						<table>
							<tr>
								<td width='15%' align="right"><b>School:</b></td>
								<td width='35%'>
									<input type="text" id="facultycode2B" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist4B');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist4B')" />
								</td>
								<td width='15%' align="right"><b>Department:</b></td>
								<td width='35%'>
									<input type="text" id="departmentcode2B" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist4B');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist4B')" />
								</td>
							</tr>
							<tr>
								<td align="right"><b>Programme:</b></td>
								<td>
									<input type="text" id="programmecode2B" onkeyup="getRecordlist(this.id,'programmestable','recordlist4B');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist4B')" size="50" />
								</td>                        
								<td align="right"><b>Level:</b></td>
								<td>
									<input type="text" id="studentlevel2B" onkeyup="getRecordlist(this.id,'studentslevels','recordlist4B');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist4B')" size="30" />
								</td>                        
							</tr>
							<tr>
								<td width='15%' align="right"><b>Session:</b></td>
								<td width='35%'>
									<input type="text" id="sesionsB"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist4B');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist4B')" size="10" />
								</td>
								<td width='15%' align="right"><b>Semester:</b></td>
								<td width='35%'>
									<input type="text" id="semesterB" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist4B');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist4B')" size="12" />
								</td>
							</tr>
							<tr>
								<!--td align="right"><b>Group Code:</b></td>
								<td>
									<input type="text" id="entryyearB" onkeyup="getRecordlist(this.id,'sessionstable','recordlist4B');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist4B');" size="10" />
								</td-->
								<td colspan="3" align="right"><b>&nbsp;</b></td>
								<td>
									<input type="button" style="display:inline" id="populatecoursesB" onclick="populateCopyCourse('coursecode')" value="List Records" />
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="coursetablelistB" style="height:400px; overflow:auto;"></div>
								</td>
							</tr>
						</table>
						<div id="msgdivB"></div>
						<div id="recordlist4B" style="overflow:auto;"></div>
						<!--height:250px; width:250px; -->
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	document.getElementById("facultycode2").value=readCookie("_faculty_");
	document.getElementById("departmentcode2").value=readCookie("_department_");
	document.getElementById("programmecode2").value=readCookie("_programme_");
	document.getElementById("studentlevel2").value=readCookie("_level_");
	document.getElementById("sesions").value=readCookie("_session_");
	document.getElementById("semester").value=readCookie("_semester_");

	document.getElementById("facultycode2B").value=readCookie("_faculty_");
	document.getElementById("departmentcode2B").value=readCookie("_department_");
	document.getElementById("programmecode2B").value=readCookie("_programme_");
	document.getElementById("studentlevel2B").value=readCookie("_level_");
	document.getElementById("sesionsB").value=readCookie("_session_");
	document.getElementById("semesterB").value=readCookie("_semester_");
	doMaxUnit('get');
</script>