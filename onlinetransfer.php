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

                $("#datatransfer").dialog({
                    autoOpen: true,
                    position:'center',
                    title: 'Online Data Upload',
                    height: 640,
                    width: 900,
                    modal: false,
                    buttons: {
                        Upload: function() {
							myVar=setInterval(function(){myTimer()},100);
							d=new Date();
							starttime=d.toLocaleTimeString();
                            uploadRecords();
                        },
                        Close: function() {
							myStopFunction();
                            $('#datatransfer').dialog('close');
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
			initializeOnlineVariable();

			var myVar=null;
			var d=new Date();
			var starttime=d.toLocaleTimeString();
			function myTimer(){
				var url = "/laspotechportal/dataentrybackend.php?option=readCookies";
				AjaxFunctionSetup(url);
			}

			function myStopFunction(){
				clearInterval(myVar);
alert(myVar);
			}
			clearCurrentRecord();
        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <tr>
                <td>
                    <div style="font-size:11px" id="datatransfer">
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
									<input type="button" id="clearall" style="display:inline" onclick="document.getElementById('facultycode').value=''; document.getElementById('departmentcode').value=''; document.getElementById('programmecode').value=''; document.getElementById('studentlevel').value='';"  value=" Clear Form " />
									<!-- document.getElementById('sesions').value=''; document.getElementById('semester').value=''; -->
								</td>
							</tr>
							<tr>
								<td colspan="4">
									<div id="tablelist" style="height:450px; overflow:auto;">
										<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;' border="0">
											<tr style='font-weight:bold; color:#FFFFFF'>
												<td width="5%" align="right">S/No</td><td width="20%">Table Name</td>
												<td width="15%" align="center">Select/Unselect All<br><input type='checkbox' id='selectall' onclick='doCheckboxes();'></td>
												<td width="50%">Upload Status</td>
											</tr>
											<!--tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">0</td><td>&nbsp;</td>
												<td align="center"><input type='checkbox' id='box000'></td>
												<td><div id="table000"></div></td>
											</tr-->
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">1</td><td>Diploma Classes Table</td>
												<td align="center"><input type='checkbox' id='box0'></td>
												<td><div id="table0"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">2</td><td>Courses Table</td>
												<td align="center"><input type='checkbox' id='box1'></td>
												<td><div id="table1"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">3</td><td>Departments Table</td>
												<td align="center"><input type='checkbox' id='box2'></td>
												<td><div id="table2"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">4</td><td>Examresults Table</td>
												<td align="center"><input type='checkbox' id='box3'></td>
												<td><div id="table3"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">5</td><td>Schools Table</td>
												<td align="center"><input type='checkbox' id='box4'></td>
												<td><div id="table4"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">6</td><td>Finalresults Table</td>
												<td align="center"><input type='checkbox' id='box5'></td>
												<td><div id="table5"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">7</td><td>Grades Table</td>
												<td align="center"><input type='checkbox' id='box6'></td>
												<td><div id="table6"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">8</td><td>Spreadsheet Report Table</td>
												<td align="center"><input type='checkbox' id='box7'></td>
												<td><div id="table7"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">9</td><td>Pin Numbers Table</td>
												<td align="center"><input type='checkbox' id='box8'></td>
												<td><div id="table8"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">10</td><td>Programmes Table</td>
												<td align="center"><input type='checkbox' id='box9'></td>
												<td><div id="table9"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">11</td><td>Qualifications Table</td>
												<td align="center"><input type='checkbox' id='box10'></td>
												<td><div id="table10"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">12</td><td>Registrations Table</td>
												<td align="center"><input type='checkbox' id='box11'></td>
												<td><div id="table11"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">13</td><td>Students Table</td>
												<td align="center"><input type='checkbox' id='box12'></td>
												<td><div id="table12"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">14</td><td>Remarks Table</td>
												<td align="center"><input type='checkbox' id='box13'></td>
												<td><div id="table13"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">15</td><td>Outstanding Courses Table</td>
												<td align="center"><input type='checkbox' id='box14'></td>
												<td><div id="table14"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">16</td><td>School Information Table</td>
												<td align="center"><input type='checkbox' id='box15'></td>
												<td><div id="table15"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">17</td><td>Sessions Table</td>
												<td align="center"><input type='checkbox' id='box16'></td>
												<td><div id="table16"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">18</td><td>Student Levels Table</td>
												<td align="center"><input type='checkbox' id='box17'></td>
												<td><div id="table17"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">19</td><td>Summary Reports Table</td>
												<td align="center"><input type='checkbox' id='box18'></td>
												<td><div id="table18"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
												<td align="right">20</td><td>Units Table</td>
												<td align="center"><input type='checkbox' id='box19'></td>
												<td><div id="table19"></div></td>
											</tr>
											<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
												<td align="right">21</td><td>Users Table</td>
												<td align="center"><input type='checkbox' id='box20'></td>
												<td><div id="table20"></div></td>
											</tr>
										</table>
									</div>
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