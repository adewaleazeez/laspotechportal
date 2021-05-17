<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Lagos State Polytechnic Portal Systems</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
        <link href="css/mycss.css" rel="stylesheet" type="text/css"/>
        <link href="css/emsportal.css" rel="stylesheet" type="text/css"/>
        <link href="css/calendar.css" rel="stylesheet" type="text/css"/>
		<!--link href="style/style.css" rel="stylesheet" type="text/css" /-->

		<script type='text/javascript' src='js/utilities.js'></script>
		<script type='text/javascript' src='js/dataentry.js'></script>
        <script type='text/javascript' src='js/calendar.js'></script>
        <script type="text/javascript" src="js/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="js/jquery.bgiframe.min.js"></script>
        <script type="text/javascript" src="js/jquery.bgiframe.pack.js"></script>
        <script type="text/javascript">

            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $(document).ready(function(){
                    $("#infolist").accordion({
                        autoHeight: false
                    });
                });

                $(document).ready(function(){
                    $("#updatestudent").accordion({
                        autoHeight: false
                    });
                });

                $(document).ready(function(){
                    $("#updatemarks").accordion({
                        autoHeight: false
                    });
                });

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
                    height: 350,
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
                    title: 'Data Entry/Report',
                    height: 600,
                    width: 350,
                    modal: false,
                    buttons: {
                        Close: function() {
                            //$('#menuList').dialog('close');
                        }
                    }
                });

                $("#studentsupdate").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Students List/General Update',
                    height: 630,
                    width: 1020,
                    modal: false,
					beforeclose : function() { 
                        //$('#menuList').dialog('open');
					},
                    buttons: {
                        Add: function() {
                            document.getElementById('olevel').innerHTML="";
                            openStudentDetails();
                        },
                        Close: function() {
                            $('#studentsupdate').dialog('close');
                            //$('#menuList').dialog('open');
                        }
                    }
                });

                $("#regularstudents").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Student Details - Items with RED colour labels are mandatory',
                    height: 600,
                    width: 1000,
                    modal: false,
					beforeclose : function() { 
                        $('#studentsupdate').dialog('open');
                        getRecords('filterbutton','1');
					},
                    buttons: {
                        Save: function() {
							createCookie("serialno",null,false);
                            updateRegularStudent("addRecord", "regularstudents");
                        },
                        Update: function() {
                            updateRegularStudent("updateRecord", "regularstudents");
                        },
                        New: function() {
                            resetForm();
                        },
                        Close: function() {
                            $('#regularstudents').dialog('close');
                            $('#studentsupdate').dialog('open');
                            getRecords('filterbutton','1');
                        }
                    }
                });

                $("#uploadresult").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Update/Upload Student Results',
                    height: 600,
                    width: 1000,
                    modal: false,
					beforeclose : function() { 
						$('#recordlist4border').dialog('close'); $("#uploadresult").dialog('option','width',950);
					},
                    buttons: {
                        Close: function() {
							$("#uploadresult").dialog('option','width',950);
                            $('#recordlist4border').dialog('close');
                            $('#uploadresult').dialog('close');
                        }
                    }
                });

                $("#mastersheet").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Master Score Sheets',
                    height: 500,
                    width: 950,
                    modal: false,
					beforeclose : function() { 
                        //$('#menuList').dialog('open');
					},
                    buttons: {
                        /*HTML: function() {
                            viewMyResult("viewhtmlmaster");
                        },
                        Excel: function() {
                            viewMyResult("viewexcelmaster");
                        },
                        MS_Word: function() {
                            viewMyResult("viewwordmaster");
                        },*/
                        PDF_Report: function() {
                            viewMyResult("viewpdfmaster");
                        },
                        Close: function() {
                            $('#mastersheet').dialog('close');
                            //$('#menuList').dialog('open');
                        }
                    }
                });

                $("#summarysheet").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Summary of Results',
                    height: 500,
                    width: 950,
                    modal: false,
					beforeclose : function() { 
                        //$('#menuList').dialog('open');
					},
                    buttons: {
                        /*HTML: function() {
                            viewMyResult("viewhtmlsummary");
                        },
                        Excel: function() {
                            viewMyResult("viewexcelsummary");
                        },
                        MS_Word: function() {
                            viewMyResult("viewwordsummary");
                        },*/
                        PDF_Report: function() {
                            viewMyResult("viewpdfsummary");
                        },
                        Close: function() {
                            $('#summarysheet').dialog('close');
                            //$('#menuList').dialog('open');
                        }
                    }
                });

                $("#transcriptsheet").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Student Transcripts',
                    height: 500,
                    width: 950,
                    modal: false,
					beforeclose : function() { 
                        //$('#menuList').dialog('open');
					},
                    buttons: {
                        /*HTML: function() {
                            viewMyResult("viewhtmltranscript");
                        },
                        Excel: function() {
                            viewMyResult("viewexceltranscript");
                        },
                        MS_Word: function() {
                            viewMyResult("viewwordtranscript");
                        },*/
                        PDF_Report: function() {
                            viewMyResult("viewpdftranscript");
                        },
                        Close: function() {
                            $('#transcriptsheet').dialog('close');
                            //$('#menuList').dialog('open');
                        }
                    }
                });

                $("#recordlist4border").dialog({
                    autoOpen: false,
                    position:[800,0],
                    title: 'Students List',
                    height: 600,
                    width: 200,
                    modal: false,
					beforeclose : function() { 
						$("#uploadresult").dialog('option','width',950);
					},
                    buttons: {
                        Close: function() {
							$("#uploadresult").dialog('option','width',950);
                            $('#recordlist4border').dialog('close');
                        }
                    }
                });

                $("#signatory").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Signatories Setup',
                    height: 450,
                    width: 700,
                    modal: true,
                    buttons: {
                        Save: function() {
                            updateSignatories("addRecord", "signatoriestable");
                        },
                        Delete: function() {
                            updateSignatories("deleteRecord", "signatoriestable");
                        },
                        Update: function() {
                            updateSignatories("updateRecord", "signatoriestable");
                        },
                        New: function() {
                            //document.getElementById("leveldescription").value="";
                            //document.getElementById("examofficer").value="";
                            resetForm();
                        },
                        Close: function() {
                            $('#signatory').dialog('close');
                        }
                    }
                });

            });

			function getGPA(){
				var tcp = document.getElementById("tcp").value;
				var tnu = document.getElementById("tnu").value;
				var error = "";
				if (isNaN(parseFloat(tcp)) && tcp.trim().length>0){
					error += "TCP must be numeric\n";
					document.getElementById("tcp").value='';
				}
				if (isNaN(parseFloat(tnu)) && tnu.trim().length>0){
					error += "TNU must be numeric\n";
					document.getElementById("tnu").value='';
				}
			    if(error.length >0) {
			        //alert("Please correct the following: \n\n" + error);
			        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
					document.getElementById("showError").innerHTML = error;
					$('#showError').dialog('open');
				}else{
					var gpa = parseFloat(tcp) / parseFloat(tnu);
					if(isNaN(gpa)){
						document.getElementById("gpa").value = '';
					}else{
						document.getElementById("gpa").value=numberFormat(gpa+"");
					}
				}
			}

            function browseFiles(){
                var txtFile = document.getElementById("txtFile");
                txtFile.click();
            }

			function submitForm(){
                var submitButton = document.getElementById("submitButton");
                submitButton.click();
			}

			function startUpload(){
				var filename = document.getElementById('txtFile').value;
				var filenames = filename.split("\\");
				var theImage = filenames[filenames.length-1];
				createCookie("theImage",theImage,false);
				document.getElementById('f1_upload_process').style.visibility = 'visible';
				document.getElementById('f1_upload_form').style.visibility = 'hidden';
				document.getElementById('f1_upload_button').style.visibility = 'hidden';
				document.getElementById('f1_uploaded_file').style.visibility = 'hidden';
			}

			function stopUpload(success){
				var result = '';
				if(success == 1){
					result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
					//alert("The file was uploaded successfully!");
				}else {
					createCookie("theImage",null,false);
					result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
					alert("There was an error during file upload!");
				}
				document.getElementById('f1_upload_process').style.visibility = 'hidden';
				var theImage = readCookie("theImage");
				document.getElementById('f1_uploaded_file').innerHTML = "<img src='photo/"+theImage+"'  border='1' width='150' height='150' title='Picture' alt='Applicant`s Passport'/>";
				document.getElementById('f1_upload_form').style.visibility = 'visible';      
				document.getElementById('f1_upload_button').style.visibility = 'visible';      
				document.getElementById('f1_uploaded_file').style.visibility = 'visible';      
				return true;   
			}

			function loadImage(imageID){
				document.getElementById('f1_uploaded_file').innerHTML = "<img src='photo/"+imageID+"'  border='1' width='150' height='150' title='Picture' alt='Applicant`s Passport'/>";
			}

		
		
            function browseFiles2(){
                var txtFile = document.getElementById("txtFile2");
                txtFile.click();
            }

			function submitForm2(){
                var submitButton = document.getElementById("submitButton2");
                submitButton.click();
			}

			function startUpload2(){
				var filename = document.getElementById('txtFile2').value;
				var filenames = filename.split("\\");
				var theDoc = filenames[filenames.length-1];
				createCookie("theDoc",theDoc,false);
				document.getElementById('f1_upload_process').style.visibility = 'visible';
			}

			function stopUpload2(success){
				var result = '';
				if(success == 1){
					result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
					//alert("The file was uploaded successfully!");
				}else {
					createCookie("theDoc",null,false);
					result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
					alert("There was an error during file upload!");
				}
				document.getElementById('f1_upload_process').style.visibility = 'hidden';
                var theDoc = readCookie("theDoc");
                var id = readCookie("currentdocid");
                if(theDoc!=null){
                    var actionid = "actionid"+id;
                    var docid = "docid"+id;
                    document.getElementById(docid).value = theDoc;
                    var str = "<a href=javascript:viewDoc('"+theDoc+"')>View</a>&nbsp;&nbsp;<a href=javascript:deleteDoc('"+id+"')>Delete</a>";
                    document.getElementById(actionid).innerHTML = str;
                }
			}

			function checkPosition(id){
				if(document.getElementById(id).value==""){
					var nameid = id.replace(/sigid/g,'signame');
					document.getElementById(nameid).value="";
				}
			}
		</script>
    </head>
    <body>
        <div id="showError"></div>
        <div id="showPrompt"></div>
        <div id="showAlert"></div>
        <div id="menuList">
            <h5><a href="javascript: checkAccess('getRecords', 'Student Details Update','regularstudents');">Student Details Update</a></h5>
            <h5><a href="javascript: checkAccess('showMarks', 'Update Student Marks','examresultstable');">Update Student Marks</a></h5>
            <h5><a href="javascript: checkAccess('viewMasterResults', 'Master Score Sheet','');">Master Score Sheets</a></h5>
            <h5><a href="javascript: checkAccess('viewSummaryResults', 'Summary of Results','');">Summary of Results</a></h5>
            <h5><a href="javascript: checkAccess('viewTranscriptResults', 'Student Transcript','');">Student Transcripts</a></h5>
        </div>

        <div id="studentsupdate">
				<div id='studentslist'></div>
		</div>
        <!--div id="studentsupdate">
            <div id="infolist">
                <h3><a href="#">Students List</a></h3>
				<div id='studentslist' style="height:420px; overflow:auto;"></div>
				
                <h3><a href="#">General Update</a></h3>
				<div id='recordlist5' style="height:420px; overflow:auto;"></div>
			</div>
		</div-->

        <div id="regularstudents">
			<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:400px; top:100px; left:400px">Loading...<br/><img src="imageloader.gif" /><br/></div>
            <div id="updatestudent">
                <h3><a href="#">Personal Information</a></h3>

                <div>
                    <table style='font-size:10px;'>
                        <tr>
                            <td align='right'><b>Title:</b></td>
                            <td>
                                <select id="title">
                                    <option></option>
                                    <option>Mr</option>
                                    <option>Miss</option>
                                    <option>Mrs</option>
                                    <option>Madam</option>
                                    <option>Dr</option>
                                    <option>Sir</option>
                                </select>
                            </td>
                            <td rowspan="9">
								<div id="f1_uploaded_file"><img src="photo/silhouette.jpg" border="1" width="150" height="150" title="Picture" alt="Applicant's Passport"/><br/></div>

								<div id="f1_upload_button" onclick="javascript:browseFiles()" style="display:block; margin-left: 15px; width: 105px; padding: 5px 5px; text-align:center; background:#880000; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 17px; width: 82px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold;">Upload</div><br>

								<form action="uploadfile.php?ftype=pic" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
								
									<div id="f1_upload_form" style="font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; color: #666666; height:100px;" align="center"><br/>
										
										<div style="visibility: hidden">
											<input type="file" name="txtFile" id="txtFile" onchange="javascript:submitForm();" />
											<INPUT TYPE="submit" id="submitButton" value="Submit" name="submitButton" />
										</div>
										<iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;"></iframe>
									</div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td align='right' style="color: red"><b>Matric No:</b></td>
                            <td>
                                <input type="text" id="regNumber" name="regNumber" size="20" onblur="this.value=capitalize(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b style=" color: red">Last Name:</b></td>
                            <td>
                                <input type="text" id="lastName" name="lastName" size="20" onblur="this.value=capitalize(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right' style=" color: red"><b>First Name:</b></td>
                            <td>
                                <input type="text" id="firstName" name="firstName" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Middle Name:</b></td>
                            <td>
                                <input type="text" id="middleName" name="middleName" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right' style=" color: red"><b>Gender:</b></td>
                            <td>
                                <select id="gender">
                                    <option></option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <!--td style=" color: red"><b>Date of birth:</b></td-->
                            <td align='right'><b>Date of birth:</b></td>
                            <td>
                                <input type="text" style="display:inline" id="dateOfBirth"  name="dateOfBirth" size="10"  onclick="displayDatePicker('dateOfBirth', false, 'dmy', '/');" />
                                <a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: displayDatePicker('dateOfBirth', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Email:</b></td>
                            <td>
                                <input type="text" id="userEmail" name="userEmail" size="50" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Phone No:</b></td>
                            <td>
                                <input type="text" id="phoneno" name="phoneno" size="15" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right' style=" color: red"><b>Active:</b></td>
                            <td>
                                <select id="active">
                                    <option>Yes</option>
                                    <option>No</option>
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <!--td style=" color: red"><b>Ignore Payment:</b></td-->
                            <td align='right'><b>Ignore Payment:</b></td>
                            <td>
                                <select id="ignorepay">
                                    <option>No</option>
                                    <option>Yes</option>
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <!--td style=" color: red"><b>Lock Record:</b></td-->
                            <td align='right'><b>Lock Result:</b></td>
                            <td>
                                <select id="lockrec">
                                    <option>No</option>
                                    <option>Yes</option>
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br clear="all">
                </div>

                <h3><a href="#">School/Department</a></h3>
                <div>
                    <table style='font-size:10px;'>
                        <tr>
							<td>
								<table>
									<tr>
										<td align='right' style=" color: red"><b>School:</b></td>
										<td>
											<input type="text" id="facultycode" onkeyup="getRecordlist(this.id,'facultiestable','recordlist2');" 
											onclick="getRecordlist(this.id,'facultiestable','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td align='right' style=" color: red"><b>Department:</b></td>
										<td>
											<input type="text" id="departmentcode" onkeyup="getRecordlist(this.id,'departmentstable','recordlist2');" onclick="getRecordlist(this.id,'departmentstable','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td align='right' style=" color: red"><b>Programme:</b></td>
										<td>
											<input type="text" id="programmecode" onkeyup="getRecordlist(this.id,'programmestable','recordlist2');" onclick="getRecordlist(this.id,'programmestable','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td align='right' style=" color: red"><b>Student Level:</b></td>
										<td>
											<input type="text" id="studentlevel" onkeyup="getRecordlist(this.id,'studentslevels','recordlist2');" onclick="getRecordlist(this.id,'studentslevels','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td align='right' style=" color: red"><b>Current Session:</b></td>
										<td>
											<input type="text" id="sessionss" onkeyup="getRecordlist(this.id,'sessionstable','recordlist2');" onclick="getRecordlist(this.id,'sessionstable','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td align='right' style=" color: red"><b>Semester:</b></td>
										<td>
											<input type="text" id="semesterss" onkeyup="getRecordlist(this.id,'sessionstable','recordlist2');" onclick="getRecordlist(this.id,'sessionstable','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td align='right' style=" color: red"><b>Qualification To Obtain:</b></td>
										<td>
											<input type="text" id="qualification" onkeyup="getRecordlist(this.id,'qualificationstable','recordlist2');" onclick="getRecordlist(this.id,'qualificationstable','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td align='right' style=" color: red"><b>Group Code:</b></td>
										<td>
											<!--input type="text" id="entryyear" name="entryyear" size="10" /-->
											<input type="text" id="entryyear" onkeyup="getRecordlist(this.id,'sessionstable','recordlist2');" onclick="getRecordlist(this.id,'sessionstable','recordlist2');" size="50" />
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td>
									</tr>
								</table>
							</td>
							<td><div id='registrationlist'></div></td>
						</tr>
					</table>
                    <div id='recordlist2'></div>
                    <br clear="all">
                </div>

                <h3><a href="#">Previous TCP/TNU/GPA/TNUP & Units Required to Pass</a></h3>
                <div>
                    <table style='font-size:10px;'>
                       <tr>
                            <!--td style=" color: red"><b>Previous TCP:</b></td-->
                            <td align='right'><b>Previous TCP:</b></td>
                            <td colspan="2">
                                <input type="text" id="tcp" size="10" />
                            </td>
                        </tr>
                        <tr>
                            <!--td style=" color: red"><b>Previous TNU:</b></td-->
                            <td align='right'><b>Previous TNU:</b></td>
                            <td colspan="2">
                                <input type="text" id="tnu" size="10" />
                            </td>
                        </tr>
                        <tr>
                            <!--td style=" color: red"><b>Previous GPA:</b></td-->
                            <td align='right'><b>Previous GPA:</b></td>
                            <td>
								<!--onfocus="javascript:getGPA();" -->
                                <input type="text" id="gpa" size="10" />
                            </td>
                        </tr>
                        <tr>
                            <!--td style=" color: red"><b>Previous TNUP:</b></td-->
                            <td align='right'><b>Previous TNUP:</b></td>
                            <td>
                                <input type="text" id="tnup" size="10" />
                            </td>
                        </tr>
                         <tr>
                            <td align='right' style=" color: red"><b>Minimum Unit to Pass:</b></td>
                            <td colspan="2">
                                <input type="text" id="minimumunit" size="10" />
                            </td>
                        </tr>
					</table>
				</div>

                <h3><a href="#">Contact Details</a></h3>
                <div>
                    <table style='font-size:10px;'>
                        <tr>
                            <td align='right'><b>Permanent Address:</b></td>
                            <td colspan="2">
                                <textarea rows="3" cols="40" id="userAddress" name="userAddress" onblur="this.value=capAdd(this.value)"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Contact Address:</b></td>
                            <td colspan="2">
                                <textarea rows="3" cols="40" id="contactAddress" name="contactAddress" onblur="this.value=capAdd(this.value)"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Nationality:</b></td>
                            <td>
                                <input type="text" id="nationality" name="nationality" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>State of Origin:</b></td>
                            <td>
                                <input type="text" id="originState" name="originState" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Local Govt. Area:</b></td>
                            <td>
                                <input type="text" id="lga" name="lga" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Birth Place:</b></td>
                            <td>
                                <input type="text" id="birthPlace" name="birthPlace" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Religion:</b></td>
                            <td>
                                <input type="text" id="religion" name="religion" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Disability:</b></td>
                            <td colspan="2">
                                <textarea rows="3" cols="40" id="disability" name="disability"></textarea>
                            </td>
                        </tr>
                    </table>
                    <br clear="all">
                </div>

                <h3><a href="#">Guardian/Spouse</a></h3>
                <div>
                    <table style='font-size:10px;'>
                        <tr>
                            <td align='right'><b>Marital Status:</b></td>
                            <td>
                                <select id="maritalStatus">
                                    <option></option>
                                    <option>Single</option>
                                    <option>Married</option>
                                    <option>Divorced</option>
                                    <option>Widowed</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Maiden Name:</b></td>
                            <td>
                                <input type="text" id="maidenName" name="maidenName" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Spouse Name:</b></td>
                            <td>
                                <input type="text" id="spouseName" name="spouseName" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Guardian Name:</b></td>
                            <td>
                                <input type="text" id="guardianName" name="guardianName" size="20" onblur="this.value=capAdd(this.value)" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Guardian Email:</b></td>
                            <td>
                                <input type="text" id="guardianEmail" name="userEmail" size="50" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Guardian Phone No:</b></td>
                            <td>
                                <input type="text" id="guardianphoneno" name="guardianphoneno" size="15" />
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Guardian Address:</b></td>
                            <td colspan="2">
                                <textarea rows="3" cols="40" id="guardianAddress" name="guardianAddress" onblur="this.value=capAdd(this.value)"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'><b>Guardian Relationship:</b></td>
                            <td>
                                <select id="guardianRelationship" name="guardianRelationship">
                                    <option></option>
                                    <option>Husband</option>
                                    <option>Wife</option>
                                    <option>Father</option>
                                    <option>Mother</option>
                                    <option>Son</option>
                                    <option>Daughter</option>
                                    <option>Uncle</option>
                                    <option>Aunt</option>
                                    <option>Niece</option>
                                    <option>Nephew</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br clear="all">
                </div>

                <h3><a href="#">O' Level Results</a></h3>
                <div>
                    <table style='font-size:10px;'>
                        <tr>
                            <td align='right'><b>Examination No:</b></td>
                            <td><input type="text" id="examno" size="40" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="olevel"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="button" id="addsubject" onclick="addOLevel()" value="Add a Subject" />
                            </td>
                        </tr>
                    </table>
                    <br clear="all">
                </div>

                <h3><a href="#">Supporting Documents</a></h3>
                <div>
                    <table style='font-size:10px;'>
                        <tr>
                            <td>
                                <div id="supportdocs"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="button" id="adddocs" onclick="addDoc()" value="Add a Document" />
								<form action="uploadfile.php?ftype=doc" method="post" enctype="multipart/form-data" target="upload_target2" onsubmit="startUpload2();" >
									<div style="visibility: hidden">
										<input type="file" name="txtFile2" id="txtFile2" onchange="javascript:submitForm2();" />
										<INPUT TYPE="submit" id="submitButton2" value="Submit" name="submitButton2" />
									</div>
									<iframe id="upload_target2" name="upload_target2" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                </form>

                            </td>
                        </tr>
                    </table>
                    <br clear="all">
                </div>

            </div>
        </div>

        <div id="uploadresult">
            <div id="updatemarks">
                
				<h3><a href="#">Update Student Marks</a></h3>
                <div>
					<table width='100%' style='font-size:10px;'>
						<tr>
							<td align="right"><b>School:</b></td>
							<td>
								<input type="text" id="facultycode5" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist3');" onclick="getRecordlist(this.id,'facultiestable','recordlist3');" />
							</td>
							<td align="right"><b>Department:</b></td>
							<td>
								<input type="text" id="departmentcode5" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist3');" onclick="getRecordlist(this.id,'departmentstable','recordlist3');" />
							</td>
						</tr>
						<tr>
							<td align="right"><b>Programme:</b></td>
							<td>
								<input type="text" id="programmecode5" onkeyup="getRecordlist(this.id,'programmestable','recordlist3');" onclick="getRecordlist(this.id,'programmestable','recordlist3');" size="50" />
							</td>                        
							<td align="right"><b>Level:</b></td>
							<td>
								<input type="text" id="studentlevel4" onkeyup="getRecordlist(this.id,'studentslevels','recordlist3');" onclick="getRecordlist(this.id,'studentslevels','recordlist3');" size="30" />
							</td>                        
						</tr>
						<tr>
							<td width='15%' align="right"><b>Session:</b></td>
							<td width='35%'>
								<input type="text" id="sesions"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="getRecordlist(this.id,'sessionstable','recordlist3');" size="10" />
							</td>
							<td width='15%' align="right"><b>Semester:</b></td>
							<td width='35%'>
								<input type="text" id="semester" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="getRecordlist(this.id,'sessionstable','recordlist3');" size="12" />
							</td>
						</tr>
						<tr>
							<td align="right"><b>Group Code:</b></td>
							<td>
								<input type="text" id="entryyear0" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="getRecordlist(this.id,'sessionstable','recordlist3');" size="10" />
							</td>
							<td align="right"><b>Course Code:</b></td>
							<td>
								<input type="text" id="coursecode5" onkeyup="getRecordlist(this.id,'coursestable','recordlist3');" onclick="getRecordlist(this.id,'coursestable','recordlist3');" size="12" />
							</td>
						</tr>
						<tr>
							<td align="right"><b>Mark Description:</b></td>
							<td>
								<input type="text" id="markdescription" onkeyup="getRecordlist(this.id,'examresultstable','recordlist3');" onclick="getRecordlist(this.id,'examresultstable','recordlist3');" size="10" />
							</td>
							<td align="right"><b>&nbsp;</b></td>
							<td>
								<input type="button" style="display:inline" id="populatemarks" onclick="populateMark('a.regNumber')" value="List Records" />
							</td>
						</tr>
						<!--tr>
							<td align="right"><b>Percentage_Overall:</b></td>
							<td>
								<input type="hidden" id="percentage" onblur="this.value=numberFormat(this.value);" size="10" value='100.00' />
							</td>
							<td align="right"><b>Max_Mark_Obtainable:</b></td>
							<td>
								<input type="hidden" style="display:inline" id="obtainable" onblur="this.value=numberFormat(this.value);" size="10" value='100.00' />
							</td>
						</tr-->
						<tr>
							<td colspan="4">
								<div id="markslist" style="height:250px; overflow:auto;"></div>
							</td>
						</tr>
					</table>
					<div id="msgdiv"></div>
					<div id='recordlist3'></div>
					<!--div id='recordlist4border'><div id='recordlist4'></div></div-->
					<input type="hidden" id="percentage" onblur="this.value=numberFormat(this.value);" size="10" value='100.00' />
					<input type="hidden" style="display:inline" id="obtainable" onblur="this.value=numberFormat(this.value);" size="10" value='100.00' />
				</div>

				<h3><a href="#">Special Features Requiring Senate Attention</a></h3>
                <div>
					<table width='100%' style='font-size:10px;'>
						<tr>
							<td align="right"><b>School:</b></td>
							<td>
								<input type="text" id="facultycode6" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist9');" onclick="getRecordlist(this.id,'facultiestable','recordlist9');" />
							</td>
							<td align="right"><b>Department:</b></td>
							<td>
								<input type="text" id="departmentcode6" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist9');" onclick="getRecordlist(this.id,'departmentstable','recordlist9');" />
							</td>
						</tr>
						<tr>
							<td align="right"><b>Programme:</b></td>
							<td>
								<input type="text" id="programmecode6" onkeyup="getRecordlist(this.id,'programmestable','recordlist9');" onclick="getRecordlist(this.id,'programmestable','recordlist9');" size="50" />
							</td>                        
							<td align="right"><b>Level:</b></td>
							<td>
								<input type="text" id="studentlevel6" onkeyup="getRecordlist(this.id,'studentslevels','recordlist9');" onclick="getRecordlist(this.id,'studentslevels','recordlist9');" size="30" />
							</td>                        
						</tr>
						<tr>
							<td align="right"><b>Session:</b></td>
							<td>
								<input type="text" id="sesions5"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist9');" onclick="getRecordlist(this.id,'sessionstable','recordlist9');" size="10" />
							</td>
							<td align="right"><b>Semester:</b></td>
							<td>
								<input type="text" id="semester5" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist9');" onclick="getRecordlist(this.id,'sessionstable','recordlist9');" size="12" />
							</td>
						</tr>
						<tr>
							<td align="right"><b>Group Code:</b></td>
							<td>
								<input type="text" id="entryyear5" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist9');" onclick="getRecordlist(this.id,'sessionstable','recordlist9');" size="10" />
							</td>
							<td align="right"><b>&nbsp;</b></td>
							<td>
								<input type="button" style="display:inline" id="populatefeatureshhh" onclick="populateFeature('a.regNumber')" value="List Records" />
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<div id="featureslist" style="height:300px; overflow:auto;"></div>
							</td>
						</tr>
					</table>
					<div id="msgdiv2"></div>
					<div id='recordlist9'></div>

				</div>
			</div>
		</div>

        <div id="mastersheet">
            <table width='100%' style='font-size:10px;'>
                <tr>
                    <td align='right'><b>School:</b></td>
                    <td>
                        <input type="text" id="facultycode2" onkeyup="getRecordlist(this.id,'facultiestable','recordlist6');" onclick="getRecordlist(this.id,'facultiestable','recordlist6');" size="50" />
                    </td>
                    <td align='right'><b>Department:</b></td>
                    <td>
                        <input type="text" id="departmentcode2" onkeyup="getRecordlist(this.id,'departmentstable','recordlist6');" onclick="getRecordlist(this.id,'departmentstable','recordlist6');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Programme:</b></td>
                    <td>
                        <input type="text" id="programmecode2" onkeyup="getRecordlist(this.id,'programmestable','recordlist6');" onclick="getRecordlist(this.id,'programmestable','recordlist6');" size="50" />
                    </td>
                    <td align='right'><b>Student Level:</b></td>
                    <td>
                        <input type="text" id="studentlevel2" onkeyup="getRecordlist(this.id,'studentslevels','recordlist6');" onclick="getRecordlist(this.id,'studentslevels','recordlist6');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Session:</b></td>
                    <td>
                        <input type="text" id="sesions2" onkeyup="getRecordlist(this.id,'sessionstable','recordlist6');" onclick="getRecordlist(this.id,'sessionstable','recordlist6');" size="50" />
                    </td>
                    <td align="right"><b>Semester:</b></td>
                    <td>
                        <input type="text" id="semester2" onkeyup="getRecordlist(this.id,'sessionstable','recordlist6');" onclick="getRecordlist(this.id,'sessionstable','recordlist6');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Final Year:</b></td>
                    <td>
						<select style="display:inline" id="finalyear1">
                            <option>No</option>
							<option>Yes</option>
                        </select>
						<div style="display:inline"><b>&nbsp;&nbsp;&nbsp;&nbsp;Supplemenrary List</b></div>
						<select style="display:inline" id="suplemetaryA">
                            <option>No</option>
							<option>Yes</option>
                        </select>
					</td>
                    <td align='right'><b>Group Code:</b></td>
					<td>                        
						<input type="text" id="entryyear1" onkeyup="getRecordlist(this.id,'sessionstable','recordlist6');" onclick="getRecordlist(this.id,'sessionstable','recordlist6');" size="50" />
					</td>
                </tr>
                <tr>
                    <td colspan='4'>
						<table  style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#FF9900;margin-top:5px;font-size:10px;' width='100%'>
							<tr>
								<td align='center'><b>Left Signatory</b></td>
								<td align='center'><b>Mid Signatory</b></td>
								<td align='center'><b>Right Signatory</b></td>
							</tr>
							<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
								<td>
									<b>Position:</b><input type="text" id="leftsigidA" onkeyup="getRecordlist(this.id,'signatoriestable','siglistA');" onclick="getRecordlist(this.id,'signatoriestable','siglistA');" onblur="checkPosition(this.id);" size="50" />
								</td>
								<td>
									<b>Position:</b><input type="text" id="midsigidA" onkeyup="getRecordlist(this.id,'signatoriestable','siglistA');" onclick="getRecordlist(this.id,'signatoriestable','siglistA');" onblur="checkPosition(this.id);" size="50" />
								</td>
								<td>
									<b>Position:</b><input type="text" id="rightsigidA" onkeyup="getRecordlist(this.id,'signatoriestable','siglistA');" onclick="getRecordlist(this.id,'signatoriestable','siglistA');" onblur="checkPosition(this.id);" size="50" />
								</td>
							</tr>
							<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
								<td>
									<b>Name:</b><input type="text" id="leftsignameA" readonly size="50" />
								</td>
								<td>
									<b>Name:</b><input type="text" id="midsignameA" readonly size="50" />
								</td>
								<td>
									<b>Name:</b><input type="text" id="rightsignameA" readonly size="50" />
									
								</td>
							</tr>
							<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
								<td colspan='2'>&nbsp;</td>
								<td align='right'>
									<INPUT TYPE="button" style='font-weight:bold; font-size:10px; color:black;background-color:FFFFFF;' onclick='doSignatories();' value='Signatories Update'>
								</td>
							</tr>
						</table>
					</td>
                </tr>
            </table>
            <div id='recordlist6'></div>
            <div id='siglistA'></div>
        </div>

        <div id="summarysheet">
            <table width='100%' style='font-size:10px;'>
                <tr>
                    <td align='right'><b>School:</b></td>
                    <td>
                        <input type="text" id="facultycode3" onkeyup="getRecordlist(this.id,'facultiestable','recordlist7');" onclick="getRecordlist(this.id,'facultiestable','recordlist7');" size="50" />
                    </td>
                    <td align='right'><b>Department:</b></td>
                    <td>
                        <input type="text" id="departmentcode3" onkeyup="getRecordlist(this.id,'departmentstable','recordlist7');" onclick="getRecordlist(this.id,'departmentstable','recordlist7');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Programme:</b></td>
                    <td>
                        <input type="text" id="programmecode3" onkeyup="getRecordlist(this.id,'programmestable','recordlist7');" onclick="getRecordlist(this.id,'programmestable','recordlist7');" size="50" />
                    </td>
                    <td align='right'><b>Student Level:</b></td>
                    <td>
                        <input type="text" id="studentlevel3" onkeyup="getRecordlist(this.id,'studentslevels','recordlist7');" onclick="getRecordlist(this.id,'studentslevels','recordlist7');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Session:</b></td>
                    <td>
                        <input type="text" id="sesions3" onkeyup="getRecordlist(this.id,'sessionstable','recordlist7');" onclick="getRecordlist(this.id,'sessionstable','recordlist7');" size="50" />
                    </td>
                    <td align="right"><b>Semester:</b></td>
                    <td>
                        <input type="text" id="semester3" onkeyup="getRecordlist(this.id,'sessionstable','recordlist7');" onclick="getRecordlist(this.id,'sessionstable','recordlist7');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Final Year:</b></td>
                    <td>
						<select style="display:inline" id="finalyear2">
                            <option>No</option>
							<option>Yes</option>
                        </select>
						<div style="display:inline"><b>&nbsp;&nbsp;&nbsp;&nbsp;Supplemenrary List</b></div>
						<select style="display:inline" id="suplemetaryB">
                            <option>No</option>
							<option>Yes</option>
                        </select>
					</td>
                    <td align='right'><b>Group Code:</b></td>
					<td>
						<!--input type="text" id="entryyear2" onkeyup="getRecordlist(this.id,'regularstudents','recordlist7');" onclick="getRecordlist(this.id,'regularstudents','recordlist7');" size="10" /-->
						<input type="text" id="entryyear2" onkeyup="getRecordlist(this.id,'sessionstable','recordlist7');" onclick="getRecordlist(this.id,'sessionstable','recordlist7');" size="50" />
					</td>
                </tr>
                <tr>
                    <td colspan='4'>
						<table  style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#FF9900;margin-top:5px;font-size:10px;' width='100%'>
							<tr>
								<td align='center'><b>Left Signatory</b></td>
								<td align='center'><b>Mid Signatory</b></td>
								<td align='center'><b>Right Signatory</b></td>
							</tr>
							<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
								<td>
									<b>Position:</b><input type="text" id="leftsigidB" onkeyup="getRecordlist(this.id,'signatoriestable','siglistB');" onclick="getRecordlist(this.id,'signatoriestable','siglistB');" onblur="checkPosition(this.id);" size="50" />
								</td>
								<td>
									<b>Position:</b><input type="text" id="midsigidB" onkeyup="getRecordlist(this.id,'signatoriestable','siglistB');" onclick="getRecordlist(this.id,'signatoriestable','siglistB');" onblur="checkPosition(this.id);" size="50" />
								</td>
								<td>
									<b>Position:</b><input type="text" id="rightsigidB" onkeyup="getRecordlist(this.id,'signatoriestable','siglistB');" onclick="getRecordlist(this.id,'signatoriestable','siglistB');" onblur="checkPosition(this.id);" size="50" />
								</td>
							</tr>
							<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
								<td>
									<b>Name:</b><input type="text" id="leftsignameB" readonly size="50" />
								</td>
								<td>
									<b>Name:</b><input type="text" id="midsignameB" readonly size="50" />
								</td>
								<td>
									<b>Name:</b><input type="text" id="rightsignameB" readonly size="50" />
									
								</td>
							</tr>
							<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
								<td colspan='2'>&nbsp;</td>
								<td align='right'>
									<INPUT TYPE="button" style='font-weight:bold; font-size:10px; color:black;background-color:FFFFFF;' onclick='doSignatories();' value='Signatories Update'>
								</td>
							</tr>
						</table>
					</td>
                </tr>
            </table>
            <div id='recordlist7'></div>
            <div id='siglistB'></div>
        </div>

		<div id="transcriptsheet">
            <table width='100%' style='font-size:10px;'>
                <tr>
                    <td align='right'><b>School:</b></td>
                    <td>
                        <input type="text" id="facultycode4" onkeyup="getRecordlist(this.id,'facultiestable','recordlist8');" onclick="getRecordlist(this.id,'facultiestable','recordlist8');" size="50" />
                    </td>
                    <td align='right'><b>Department:</b></td>
                    <td>
                        <input type="text" id="departmentcode4" onkeyup="getRecordlist(this.id,'departmentstable','recordlist8');" onclick="getRecordlist(this.id,'departmentstable','recordlist8');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Programme:</b></td>
                    <td>
                        <input type="text" id="programmecode4" onkeyup="getRecordlist(this.id,'programmestable','recordlist8');" onclick="getRecordlist(this.id,'programmestable','recordlist8');" size="50" />
                    </td>
                    <td align='right'><b>Student Level:</b></td>
                    <td>
                        <input type="text" id="studentlevel5" onkeyup="getRecordlist(this.id,'studentslevels','recordlist8');" onclick="getRecordlist(this.id,'studentslevels','recordlist8');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Session:</b></td>
                    <td>
                        <input type="text" id="sesions4" onkeyup="getRecordlist(this.id,'sessionstable','recordlist8');" onclick="getRecordlist(this.id,'sessionstable','recordlist8');" size="50" />
                    </td>
                    <td align="right"><b>Semester:</b></td>
                    <td>
                        <input type="text" id="semester4" onkeyup="getRecordlist(this.id,'sessionstable','recordlist8');" onclick="getRecordlist(this.id,'sessionstable','recordlist8');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td align='right'><b>Group Code:</b></td>
					<td>
						<input type="text" id="entryyear3" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist8');" onclick="getRecordlist(this.id,'sessionstable','recordlist8');" size="50" />
						<div style="display:inline"><b>&nbsp;&nbsp;&nbsp;&nbsp;Supplemenrary List</b></div>
						<select style="display:inline" id="suplemetaryC">
                            <option>No</option>
							<option>Yes</option>
                        </select>
					</td>
                    <td align='right'><b>Matric Number:</b></td>
                    <td>
                        <input type="text" id="matricno4" onkeyup="getRecordlist(this.id,'regularstudents','recordlist8');" onclick="getRecordlist(this.id,'regularstudents','recordlist8');" size="50" />
                    </td>
                </tr>
                <tr>
                    <td colspan='4'>
						<table  style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#FF9900;margin-top:5px;font-size:10px;' width='100%'>
							<tr>
								<td align='center'><b>&nbsp;</b></td>
								<td align='center'><b>&nbsp;</b></td>
								<td align='center'><b>&nbsp;</b></td>
							</tr>
							<!--tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
								<td>
									<b>Position:</b><input type="text" id="leftsigidC" onkeyup="getRecordlist(this.id,'signatoriestable','siglistC');" onclick="getRecordlist(this.id,'signatoriestable','siglistC');" size="50" />
								</td>
								<td>
									<b>Position:</b><input type="text" id="midsigidC" onkeyup="getRecordlist(this.id,'signatoriestable','siglistC');" onclick="getRecordlist(this.id,'signatoriestable','siglistC');" size="50" />
								</td>
								<td>
									<b>Position:</b><input type="text" id="rightsigidC" onkeyup="getRecordlist(this.id,'signatoriestable','siglistC');" onclick="getRecordlist(this.id,'signatoriestable','siglistC');" size="50" />
								</td>
							</tr>
							<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
								<td>
									<b>Name:</b><input type="text" id="leftsignameC" readonly size="50" />
								</td>
								<td>
									<b>Name:</b><input type="text" id="midsignameC" readonly size="50" />
								</td>
								<td>
									<b>Name:</b><input type="text" id="rightsignameC" readonly size="50" />
									
								</td>
							</tr>
							<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
								<td colspan='2'>&nbsp;</td>
								<td align='right'>
									<INPUT TYPE="button" style='font-weight:bold; font-size:10px; color:black;background-color:FFFFFF;' onclick='doSignatories();' value='Signatories Update'>
								</td>
							</tr-->
						</table>
					</td>
				</tr>
            </table>
            <div id='recordlist8'></div>
            <div id='siglistC'></div>
        </div>
        <div id="signatory">
            <table width='100%' style='font-size:10px;'>
                <tr>
                    <td><b>Position:</b></td>
                    <td>
                        <input type="text" id="signatoryposition" onblur="this.value=capitalize(this.value)"  size="50" />
                    </td>
                </tr>

                <tr>
                    <td><b>Name:</b></td>
                    <td>
                        <input type="text" id="signatoryname" onblur="this.value=capitalize(this.value)"  size="50" />
                    </td>
                </tr>
            </table>
            <div id="signatorylist" style="height:250px; overflow:auto;"></div>
        </div>

    </body>
</html>
<script>
	if(document.getElementById("markslist").innerHTML.length==0)
		document.getElementById("markslist").innerHTML="<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>";
	if(document.getElementById("featureslist").innerHTML.length==0)
		document.getElementById("featureslist").innerHTML="<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>";
</script>

