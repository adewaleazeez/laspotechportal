<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Lagos State Polytechnic Portal Systems</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
        <link href="css/mycss.css" rel="stylesheet" type="text/css"/>
        <link href="css/emsportal.css" rel="stylesheet" type="text/css"/>
        <link href="css/calendar.css" rel="stylesheet" type="text/css"/>

        <script type='text/javascript' src='js/utilities.js'></script>
        <script type='text/javascript' src='js/calendar.js'></script>
        <!--script type='text/javascript' src='js/jqueryFileTree.js'></script>
        <link rel="stylesheet" href="css/jquery-ui-1.8.4.custom.css" type="text/css">
        <link href="css/jqueryFileTree.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/jquery.ui.core.js"></script>
        <script type="text/javascript" src="js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="js/jquery.ui.accordion.js"></script-->
        <script type='text/javascript' src='js/setup.js'></script>
        <script type="text/javascript" src="js/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="js/jquery.bgiframe.min.js"></script>
        <script type="text/javascript" src="js/jquery.bgiframe.pack.js"></script>

        <style type="text/css">
            body { font-size: 60.2%; }
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }

        </style>
        <script type="text/javascript">

            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

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

                $("#menuList").dialog({
                    autoOpen: true,
                    position:'center',
                    title: 'Setup Menu',
                    height: 558,
                    width: 350,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#menuList').dialog('close');
                        }
                    }
                });

                $("#schoolinfo").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'School Information',
                    height: 500,
                    width: 700,
                    modal: false,
                    buttons: {
                        Update: function() {
                            updateSchoolInfo("updateRecord", "schoolinformation");
                        },
                        Close: function() {
                            $('#schoolinfo').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#faculty").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Faculties Setup',
                    height: 450,
                    width: 700,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateFaculty("addRecord", "facultiestable");
                        },
                        Delete: function() {
                            updateFaculty("deleteRecord", "facultiestable");
                        },
                        Update: function() {
                            updateFaculty("updateRecord", "facultiestable");
                        },
                        New: function() {
                            //document.getElementById("facultydescription").value="";
                            //document.getElementById("dof").value="";
                            resetForm();
                        },
                        Close: function() {
                            $('#faculty').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#department").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Departments Setup',
                    height: 450,
                    width: 900,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateDepartment("addRecord", "departmentstable");
                        },
                        Delete: function() {
                            updateDepartment("deleteRecord", "departmentstable");
                        },
                        Update: function() {
                            updateDepartment("updateRecord", "departmentstable");
                        },
                        New: function() {
                            //document.getElementById("facultycode").value="";
                            //document.getElementById("departmentdescription").value="";
                            //document.getElementById("hod").value="";
                            resetForm();
                        },
                        Close: function() {
                            $('#department').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#programme").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Programmes Setup',
                    height: 450,
                    width: 900,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateProgramme("addRecord", "programmestable");
                        },
                        Delete: function() {
                            updateProgramme("deleteRecord", "programmestable");
                        },
                        Update: function() {
                            updateProgramme("updateRecord", "programmestable");
                        },
                        New: function() {
                            //document.getElementById("departmentcode").value="";
                            //document.getElementById("programmedescription").value="";
                            //document.getElementById("courseadvisor").value="";
                            resetForm();
                        },
                        Close: function() {
                            $('#programme').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#coursetable").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Courses Setup',
                    height: 650,
                    width: 900,
                    modal: false,
                    buttons: {
                        /*Save: function() {
                            updateCourseTable("addRecord", "coursestable");
                        },
                        Delete: function() {
                            updateCourseTable("deleteRecord", "coursestable");
                        },
                        Update: function() {
                            updateCourseTable("updateRecord", "coursestable");
                        },
                        New: function() {
                            //document.getElementById("programmecode").value="";
                            //document.getElementById("coursedescription").value="";
                            //document.getElementById("courseunit").value="";
                            //document.getElementById("lecturerid").value="";
                            resetForm();
                        },*/
                        Copy_From_Previous_Session: function() {
                            CopyFromPreviousSession();
                        },
                        Close: function() {
                            $('#coursetable').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#copycoursetable").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Copy Courses',
                    height: 600,
                    width: 800,
                    modal: false,
                    buttons: {
                        Paste_To_Current_Session: function() {
                            PasteToCurrentSession();
                        },
                        Close: function() {
                            $('#copycoursetable').dialog('close');
                        }
                    }
                });

                $("#studentslevel").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Students Levels Setup',
                    height: 450,
                    width: 700,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateStudentsLevel("addRecord", "studentslevels");
                        },
                        Delete: function() {
                            updateStudentsLevel("deleteRecord", "studentslevels");
                        },
                        Update: function() {
                            updateStudentsLevel("updateRecord", "studentslevels");
                        },
                        New: function() {
                            //document.getElementById("leveldescription").value="";
                            //document.getElementById("examofficer").value="";
                            resetForm();
                        },
                        Close: function() {
                            $('#studentslevel').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#qualification").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Students Qualifications Setup',
                    height: 450,
                    width: 700,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateQualifications("addRecord", "qualificationstable");
                        },
                        Delete: function() {
                            updateQualifications("deleteRecord", "qualificationstable");
                        },
                        Update: function() {
                            updateQualifications("updateRecord", "qualificationstable");
                        },
                        New: function() {
                            //document.getElementById("leveldescription").value="";
                            //document.getElementById("examofficer").value="";
                            resetForm();
                        },
                        Close: function() {
                            $('#qualification').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });


                $("#sessions").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Session/Semester Setup',
                    height: 650,
                    width: 750,
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
                            resetForm();
                        },
                        Close: function() {
                            $('#sessions').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#grades").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Examination Grades Setup',
                    height: 450,
                    width: 750,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateGrade("addRecord", "gradestable");
                        },
                        Delete: function() {
                            updateGrade("deleteRecord", "gradestable");
                        },
                        Update: function() {
                            updateGrade("updateRecord", "gradestable");
                        },
                        New: function() {
                            resetForm();
                        },
                        Close: function() {
                            $('#grades').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#cgpas").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Cumulative Grade Point Average Setup',
                    height: 450,
                    width: 750,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateCgpa("addRecord", "cgpatable");
                        },
                        Delete: function() {
                            updateCgpa("deleteRecord", "cgpatable");
                        },
                        Update: function() {
                            updateCgpa("updateRecord", "cgpatable");
                        },
                        New: function() {
                            resetForm();
                        },
                        Close: function() {
                            $('#cgpas').dialog('close');
                            $('#menuList').dialog('open');
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
        <div id="container_id" style="height:250px; overflow:auto;"></div>
        <div id="showError"></div>
        <div id="showPrompt"></div>
        <div id="showAlert"></div>
        <div id="menuList">
		
            <h5><a href="javascript: checkAccess('getRecords', 'School Information','schoolinformation');">School Information</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'Faculties Setup','facultiestable');">Faculties Setup</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'Departments Setup','departmentstable');">Departments Setup</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'Programmes Setup','programmestable');">Programmes Setup</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'Student Levels Setup','studentslevels');">Students Level Setup</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'Session Semester Setup','sessionstable');">Session/Semester Setup</a></h5>
			<h5><a href="javascript: checkAccess('showCourses', 'Courses Setup','coursestable');">Courses Setup</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'Qualifications Setup','qualificationstable');">Qualifications Setup</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'Grades Setup','gradestable');">Grades Setup</a></h5>
            <h5><a href="javascript: checkAccess('getRecords', 'CGPA Setup','cgpatable');">CGPA Setup</a></h5>
        </div>

        <div id="schoolinfo">
            <table>
                <tr>
                    <td><b>School Name:</b></td>
                    <td>
                        <input type="text" id="schoolname" name="schoolname" size="70" onblur="this.value=capitalize(this.value)"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Address:</b></td>
                    <td>
                        <input type="text" id="addressline1" name="addressline1" size="50" onblur="this.value=capitalize(this.value)"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Line2:</b></td>
                    <td>
                        <input type="text" id="addressline2" name="addressline2" size="50" onblur="this.value=capitalize(this.value)"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Line3:</b></td>
                    <td>
                        <input type="text" id="addressline3" name="addressline3" size="50" onblur="this.value=capitalize(this.value)"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Line4:</b></td>
                    <td>
                        <input type="text" id="addressline4" name="addressline4" size="50" onblur="this.value=capitalize(this.value)"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Telephone:</b></td>
                    <td>
                        <input type="text" id="telephonenumber" name="telephonenumber" size="80" />
                    </td>
                </tr>
                <tr>
                    <td><b>Fax:</b></td>
                    <td>
                        <input type="text" id="faxnumber" name="faxnumber" size="30" />
                    </td>
                </tr>
                <tr>
                    <td><b>Email:</b></td>
                    <td>
                        <input type="text" id="emailaddress" name="emailaddress" size="70" />
                    </td>
                </tr>
            </table>
        </div>

        <div id="faculty">
            <table>
                <tr>
                    <td><b>School:</b></td>
                    <td>
                        <input type="text" id="facultydescription" name="facultydescription" size="70" onblur="this.value=capitalize(this.value)" onclick="clearLists('recordlist1');"/>
                    </td>
                </tr>

                <tr>
                    <td><b>Dean of School:</b></td>
                    <td>
                        <input type="text" id="dof" name="dof" size="50" onkeyup="getRecordlist('dof','users','recordlist1');" onclick="clearLists('recordlist1'); getRecordlist('dof','users','recordlist1');" />
                    </td>
                </tr>
            </table>
            <div id="facultylist" style="height:250px; overflow:auto;"></div>
            <div id="recordlist1" style="height:250px; max-width:300px; overflow:auto;"></div>
        </div>

        <div id="department">
            <table>
                <tr>
                    <td><b>School:</b></td>
                    <td>
                        <input type="text" id="facultycode" name="facultycode" size="70" onkeyup="getRecordlist('facultycode','facultiestable','recordlist2');" onclick="clearLists('recordlist2'); getRecordlist('facultycode','facultiestable','recordlist2');" />
                    </td>
                </tr>

                <tr>
                    <td><b>Department:</b></td>
                    <td>
                        <input type="text" id="departmentdescription" name="departmentdescription" size="70" onblur="this.value=capitalize(this.value)" onclick="clearLists('recordlist2');"/>
                    </td>
                </tr>

                <tr>
                    <td><b>Head of Department:</b></td>
                    <td>
                        <input type="text" id="hod" name="hod" size="50" onkeyup="getRecordlist('hod','users','recordlist2');" onclick="clearLists('recordlist2'); getRecordlist('hod','users','recordlist2');" />
                    </td>
                </tr>
            </table>
            <div id="departmentlist" style="height:250px; overflow:auto;"></div>
            <div id="recordlist2" style="height:250px; max-width:300px; overflow:auto;"></div>
        </div>

        <div id="programme">
            <table>
                <tr>
                    <td><b>Department:</b></td>
                    <td>
                        <input type="text" id="departmentcode" name="departmentcode" size="70" onkeyup="getRecordlist('departmentcode','departmentstable','recordlist3');" onclick="clearLists('recordlist3'); getRecordlist('departmentcode','departmentstable','recordlist3');" />
                    </td>
                </tr>

                <tr>
                    <td><b>Programme:</b></td>
                    <td>
                        <input type="text" id="programmedescription" name="programmedescription" size="70" onblur="this.value=capitalize(this.value)" onclick="clearLists('recordlist3');"/>
                    </td>
                </tr>

                <tr>
                    <td><b>Course Advisor:</b></td>
                    <td>
                        <input type="text" id="courseadvisor" name="courseadvisor" size="50" onkeyup="getRecordlist('courseadvisor','users','recordlist3');" onclick="clearLists('recordlist3'); getRecordlist('courseadvisor','users','recordlist3');" />
                    </td>
                </tr>
            </table>
            <div id="programmelist" style="height:250px; overflow:auto;"></div>
            <div id="recordlist3" style="height:250px; max-width:300px; overflow:auto;"></div>
        </div>

        <div id="studentslevel">
            <table>
                <tr>
                    <td><b>Level Code:</b></td>
                    <td>
                        <input type="text" id="leveldescription" name="leveldescription" size="70" onblur="this.value=capitalize(this.value)" onclick="clearLists('recordlist5');"/>
                    </td>
                </tr>

                <tr>
                    <td><b>Examination Officer:</b></td>
                    <td>
                        <input type="text" id="examofficer" name="examofficer" size="50" onkeyup="getRecordlist('examofficer','users','recordlist5');" onclick="clearLists('recordlist5'); getRecordlist('examofficer','users','recordlist5');" />
                    </td>
                </tr>
            </table>
            <div id="studentslevellist" style="height:250px; overflow:auto;"></div>
            <div id="recordlist5" style="height:250px; max-width:300px; overflow:auto;"></div>
        </div>

        <div id="sessions">
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
            <div id="sessionslist" style="height:250px; width:730px; overflow:auto;"></div>
        </div>

        <div id="coursetable">
            <table>
				<tr>
					<td width='15%' align="right"><b>School:</b></td>
					<td width='35%'>
                        <input type="text" id="facultycode2" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist4');" onclick="getRecordlist(this.id,'facultiestable','recordlist4');" />
					</td>
					<td width='15%' align="right"><b>Department:</b></td>
					<td width='35%'>
                        <input type="text" id="departmentcode2" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist4');" onclick="getRecordlist(this.id,'departmentstable','recordlist4');" />
					</td>
				</tr>
				<tr>
					<td align="right"><b>Programme:</b></td>
					<td>
						<input type="text" id="programmecode" onkeyup="getRecordlist(this.id,'programmestable','recordlist4');" onclick="getRecordlist(this.id,'programmestable','recordlist4');" size="50" />
					</td>                        
					<td align="right"><b>Level:</b></td>
					<td>
						<input type="text" id="studentlevel" onkeyup="getRecordlist(this.id,'studentslevels','recordlist4');" onclick="getRecordlist(this.id,'studentslevels','recordlist4');" size="30" />
					</td>                        
				</tr>
				<tr>
					<td width='15%' align="right"><b>Session:</b></td>
					<td width='35%'>
						<input type="text" id="sesions"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist4');" onclick="getRecordlist(this.id,'sessionstable','recordlist4');" size="10" />
					</td>
					<td width='15%' align="right"><b>Semester:</b></td>
					<td width='35%'>
						<input type="text" id="semester" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist4');" onclick="getRecordlist(this.id,'sessionstable','recordlist4');" size="12" />
					</td>
				</tr>
				<tr>
					<td align="right"><b>Group Code:</b></td>
					<td>
						<input type="text" id="entryyear" onkeyup="getRecordlist(this.id,'sessionstable','recordlist4');" onclick="getRecordlist(this.id,'sessionstable','recordlist4');" size="10" />
					</td>
					<td align="right"><b>&nbsp;</b></td>
					<td>
						<input type="button" style="display:inline" id="populatecourses" onclick="populateCourse('coursecode')" value="List Records" />
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div id="coursetablelist" style="height:400px; overflow:auto;"></div>
					</td>
				</tr>
            </table>
            <!--div id="coursetablelist" style="height:330px; overflow:auto;"></div-->
			<div id="msgdiv"></div>
            <div id="recordlist4" style="height:250px; max-width:350px; overflow:auto;"></div>
        </div>

        <div id="copycoursetable">
            <table>
				<tr>
					<td width='15%' align="right"><b>School:</b></td>
					<td width='35%'>
                        <input type="text" id="facultycode2B" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist4B');" onclick="getRecordlist(this.id,'facultiestable','recordlist4B');" />
					</td>
					<td width='15%' align="right"><b>Department:</b></td>
					<td width='35%'>
                        <input type="text" id="departmentcode2B" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist4B');" onclick="getRecordlist(this.id,'departmentstable','recordlist4B');" />
					</td>
				</tr>
				<tr>
					<td align="right"><b>Programme:</b></td>
					<td>
						<input type="text" id="programmecodeB" onkeyup="getRecordlist(this.id,'programmestable','recordlist4B');" onclick="getRecordlist(this.id,'programmestable','recordlist4B');" size="50" />
					</td>                        
					<td align="right"><b>Level:</b></td>
					<td>
						<input type="text" id="studentlevelB" onkeyup="getRecordlist(this.id,'studentslevels','recordlist4B');" onclick="getRecordlist(this.id,'studentslevels','recordlist4B');" size="30" />
					</td>                        
				</tr>
				<tr>
					<td width='15%' align="right"><b>Session:</b></td>
					<td width='35%'>
						<input type="text" id="sesionsB"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist4B');" onclick="getRecordlist(this.id,'sessionstable','recordlist4B');" size="10" />
					</td>
					<td width='15%' align="right"><b>Semester:</b></td>
					<td width='35%'>
						<input type="text" id="semesterB" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist4B');" onclick="getRecordlist(this.id,'sessionstable','recordlist4B');" size="12" />
					</td>
				</tr>
				<tr>
					<td align="right"><b>Group Code:</b></td>
					<td>
						<input type="text" id="entryyearB" onkeyup="getRecordlist(this.id,'sessionstable','recordlist4B');" onclick="getRecordlist(this.id,'sessionstable','recordlist4B');" size="10" />
					</td>
					<td align="right"><b>&nbsp;</b></td>
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
            <!--div id="coursetablelist" style="height:330px; overflow:auto;"></div-->
			<div id="msgdivB"></div>
            <div id="recordlist4B" style="height:250px; max-width:350px; overflow:auto;"></div>
        </div>

        <div id="qualification">
            <table>
                <tr>
                    <td><b>Qualification Code:</b></td>
                    <td>
                        <input type="text" id="qualificationcode" onblur="this.value=capitalize(this.value)"  size="10" />
                    </td>
                </tr>

                <tr>
                    <td><b>Qualification Description:</b></td>
                    <td>
                        <input type="text" id="qualificationdescription" onblur="this.value=capitalize(this.value)"  size="50" />
                    </td>
                </tr>
            </table>
            <div id="qualificationlist" style="height:250px; overflow:auto;"></div>
        </div>

        <div id="grades">
            <table>
                <tr>
                    <td><b>Grade Code:</b></td>
                    <td>
                        <input type="text" id="gradecode" name="gradecode" size="10" onblur="this.value=capitalize(this.value)" />
                    </td>
                </tr>
                <tr>
                    <td><b>Lower Range Score:</b></td>
                    <td>
                        <input type="text" id="glowerrange" name="glowerrange"  size="10"  onblur="this.value=numberFormat(this.value);"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Upper Range Score:</b></td>
                    <td>
                        <input type="text" id="gupperrange" name="gupperrange"  size="10"  onblur="this.value=numberFormat(this.value);"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Grade Unit:</b></td>
                    <td>
                        <input type="text" id="gradeunit" name="gradeunit" size="10"  onblur="this.value=numberFormat(this.value);"/>
                    </td>
                </tr>
            </table>
            <div id="gradeslist" style="height:250px; width:730px; overflow:auto;"></div>
        </div>

        <div id="cgpas">
            <table>
                <tr>
                    <td><b>Cumulative Grade Point Average:</b></td>
                    <td>
                        <input type="text" id="cgpacode" name="cgpacode" size="50" onblur="this.value=capitalize(this.value)" />
                    </td>
                </tr>
                <tr>
                    <td><b>Lower Range Point:</b></td>
                    <td>
                        <input type="text" id="clowerrange" name="clowerrange" size="10"  onblur="this.value=numberFormat(this.value);"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Upper Range Point:</b></td>
                    <td>
                        <input type="text" id="cupperrange" name="cupperrange" size="10"  onblur="this.value=numberFormat(this.value);"/>
                    </td>
                </tr>
            </table>
            <div id="cgpaslist" style="height:250px; width:730px; overflow:auto;"></div>
        </div>

    </body>
</html>
