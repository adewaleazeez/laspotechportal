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
		<link rel="stylesheet" href="css/style.css" media="screen">
		<link rel="stylesheet" href="css/colors.css" media="screen">
        <script type="text/javascript">
            checkLogin();
        </script>
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

                $("#dialog").dialog("destroy");

                $("#studentsupdate").dialog({
                    autoOpen: true,
                    position:'center',
                    title: 'Students List/General Update',
                    height: 630,
                    width: 1300,
                    modal: false,
                    buttons: {
                        Add: function() {
                            document.getElementById('olevel').innerHTML="";
                            openStudentDetails();
                        },
                        Close: function() {
                            $('#studentsupdate').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#myupload").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Upload Student Records!!!',
                    height: 300,
                    width: 300,
                    modal: true
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
                        //New: function() {
                          //  resetForm();
                        //},
                        Close: function() {
                            $('#regularstudents').dialog('close');
                            $('#studentsupdate').dialog('open');
                            getRecords('filterbutton','1');
                        }
                    }
                });


                $("#updatematricno").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Update Matric No!!!',
                    height: 200,
                    width: 600,
                    modal: true,
					beforeclose : function() { 
                            $('#updatematricno').dialog('close');
                            $('#regularstudents').dialog('open');
                            getRecords('filterbutton','1');
					},
                    buttons: {
                        Update: function() {
                            updateMatricNo();
                        },
                        Close: function() {
                            $('#updatematricno').dialog('close');
                            $('#regularstudents').dialog('open');
                            getRecords('filterbutton','1');
                        }
                    }
                });

                $("#showPrompt").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Alert!!!',
                    height: 300,
                    width: 600,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $('#showPrompt').dialog('close');
							$('#showAlert').dialog('close');
							$('#showError').dialog('close');
                        }
                    }
                });

                $("#showRecord").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Alert!!!',
                    height: 500,
                    width: 400,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $('#showPrompt').dialog('close');
							$('#showRecord').dialog('close');
							$('#showAlert').dialog('close');
							$('#showError').dialog('close');
                        },
                        Open_Report: function() {
                            $('#showRecord').dialog('close');
							viewMyResult("exceluploadreport");
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
                    width: 500,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $('#showPrompt').dialog('close');
							$('#showRecord').dialog('close');
							$('#showAlert').dialog('close');
							$('#showError').dialog('close');
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
//alert(readCookie('filetype')+"1A");
				if(readCookie("filetype")!="pic") return true;
//alert(readCookie('filetype')+"1B");
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
//alert(readCookie('filetype')+"2A");
				if(readCookie("filetype")!="doc") return true;
//alert(readCookie('filetype')+"2B");
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

            function importRecords(){
				var faculty = document.getElementById("facultycodes").value;
				var department = document.getElementById("departmentcodes").value;
				var programme = document.getElementById("programmecodes").value;
				var studentlevel = document.getElementById("studentlevels").value;
				var sesions = document.getElementById("sesionsA").value;
				var semesters = document.getElementById("semestersA").value;

				var error="";
				if (faculty=="") error += "School must not be blank.<br><br>";
				if (department=="") error += "Department must not be blank.<br><br>";
				if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
				if (programme=="") error += "Programme Code must not be blank.<br><br>";
				if (sesions=="") error += "Session must not be blank.<br><br>";
				if (semesters=="") error += "Semester must not be blank.<br><br>";
				if(error.length >0) {
					error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
					document.getElementById("showError").innerHTML = error;
					$('#showError').dialog('open');
					return true;
				}
				alert("Please ensure that:\n\n\n 1. Only Excel file types must be selected.\n 2. Only Excel files with .xls extension i.e. Excel 97 - Excel 2003 versions are acceptable.\n 3. You can export to Excel to see the structure and format of the import file.\n\n\n\nPlease click ok to continue");
				document.getElementById("myupload").style.visibility = "visible";
				document.getElementById("txtFile3").style.visibility = "visible";
				$('#myupload').dialog('open');
            }

			function startUpload3(){
				var faculty = document.getElementById("facultycodes").value;
				var department = document.getElementById("departmentcodes").value;
				var programme = document.getElementById("programmecodes").value;
				var studentlevel = document.getElementById("studentlevels").value;
				var sesions = document.getElementById("sesionsA").value;
				var semesters = document.getElementById("semestersA").value;
				createCookie('_facultys',faculty,false);
				createCookie('_departments',department,false);
				createCookie('_programmes',programme,false);
				createCookie('_studentlevels',studentlevel,false);
				createCookie('_sessions',sesions,false);
				createCookie('_semesters',semesters,false);
				$('#myupload').dialog('close');
				document.getElementById('f1_upload_process2').style.visibility = 'visible';
//               document.getElementById("showPrompt").innerHTML = "<b>Upload in Progress!!!</b><br><br>Your file upload is in progress.........";
//               $('#showPrompt').dialog('open');
//			}
                document.getElementById("showRecord").innerHTML = "<b>Upload in Progress!!!</b><br><br>Your file upload is in progress.........";
                $('#showRecord').dialog('open');
				myVar=setInterval(function(){myTimer()},1000);
				d=new Date();
				starttime=d.toLocaleTimeString();
			}

			var myVar=null;
			var d=new Date();
			var starttime=d.toLocaleTimeString();
			function myTimer(){
				var url = "/laspotechportal/dataentrybackend.php?option=readCookies2";
				AjaxFunctionDataEntry(url);
			}

			function myStopFunction(){
				clearInterval(myVar);
			}

			function stopUpload3(results){
				myStopFunction();
				$('#showPrompt').dialog('close');
				document.getElementById('f1_upload_process2').style.visibility = 'hidden';
				if(readCookie("filetype")!="excel") return true;
				var resp = readCookie('resp').replace(/%2F/g, '/');
				resp = resp.replace(/_/g, ' ');
				resp = resp.replace(/%2C/g, ',');
				if(readCookie('resp').match("notinsetup")){
					var break_resp = resp.split("notinsetup");
					document.getElementById("showError").innerHTML = "<b>Excel Value Does Not Exist In "+break_resp[2]+" Setup!!!</b><br><br> ["+break_resp[1]+"] you typed in Excel file does not exist in "+break_resp[2]+" setup.";
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("blankfile")){
					document.getElementById("showError").innerHTML = "<b>Blank File!!!</b><br><br>You did not select any file.";
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("wrongformat")){
					resp = resp.replace(/_/g, ' ');
					var break_resp = resp.split("wrongformat");
					document.getElementById("showError").innerHTML = "<b>Wrong File Format Selected!!!</b><br><br>You have selected a wrong file:  <br><br>[ "+break_resp[1]+" ]<br><br>Only Excel files with .xls extension i.e. Excel 97 - Excel 2003 versions are allowed for upload.";
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("wrongexcel")){
					resp = resp.replace(/_/g, ' ');
					var break_resp = resp.split("wrongexcel");
					document.getElementById("showError").innerHTML = "<b>Wrong Excel File Selected!!!</b><br><br>You have selected a wrong excel file:  <br><br>[ "+break_resp[1]+" ]";
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("Excel")){
					document.getElementById("showError").innerHTML = "<b>Excel Value Does Not Match Selected Value!!!</b><br><br>"+resp;
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("invalidmatric")){
					var break_resp = resp.split("invalidmatric");
					document.getElementById("showError").innerHTML = "<b>Alert!!!</b><br><br>Invalid Matric No "+break_resp[1];
					$('#showError').dialog('open');
				}else{
					var response = "<b>Invalid File!!!</b><br><br>Only Excel files with .xls extension i.e. Excel 97 - Excel 2003 versions are allowed for upload.";
					if(results==1 && resp.match("successful") && !resp.match("Not Successful")){
						response = "<b>Upload Successful!!!</b><br><br>Your student records upload is successful."; //+readCookie('resp1')+" |  "+readCookie('resp2');
						document.getElementById("showPrompt").innerHTML = response;
						$('#showPrompt').dialog('open');
						getRecords('filterbutton');
					}else if(resp.match("Matric Numbers are already used")){
						response = "<b>Matric Numbers Already Used!!!</b><br><br><br>"+resp+"<br><br>Please open the report below to see the details.";
						document.getElementById("showError").innerHTML = response;
						$('#showError').dialog('open');
					}else{
						document.getElementById("showError").innerHTML = response;
						$('#showError').dialog('open');
					}
				}
			}

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="showRecord"></div>
		<div id="studentsupdate"><div id='studentslist'></div></div>
		<form id='myupload' action="uploadregularstudents.php?ftype=excel" method="post" enctype="multipart/form-data" target="upload_target3" onsubmit="startUpload3();" style="visibility: hidden" >
			<div id="myform">
				<div id="selectedfile"><b>Please select a file and click Upload button below:</b></div><BR><BR>
				<input type="file" name="txtFile3" id="txtFile3" style="visibility: hidden" /><BR><BR>
				<input type="submit" id="submitButton3" name="submitButton3" value="Upload" style="display:block; margin-left: 15px; width: 105px; padding: 5px 5px; text-align:center; background:#880000; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 27px; width: 82px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold;"/>
			</div>
			<iframe id="upload_target3" name="upload_target3" style="width:0;height:0;border:0px solid #fff;"></iframe>
		</form>
		<div id="updatematricno">
			<table width="100%">
				<tr>
					<td align='right'><b>Old Matric No:</b></td>
					<td>
						<input type="text" id="oldregNumber" name="oldregNumber" size="20" onblur="this.value=capitalize(this.value)" disabled="true" readonly />
					</td>
					<td align='right'><b>New Matric No:</b></td>
					<td>
						<input type="text" id="newregNumber" name="newregNumber" size="20" onblur="this.value=capitalize(this.value)" />
					</td>
				</tr>
			</table>
		</div>
        <table width="100%">
            <tr>
                <td>
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
										<td rowspan="12">
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
											<input type="text" style="display:inline" id="regNumber" name="regNumber" size="20" onblur="this.value=capitalize(this.value)" />
											<INPUT type="button" style="display:inline" id="updatematric" value="Update Matric No" onclick="showUpdateMatric();" />
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
													<td align='right' style=" color: red"><b>Mode of Admission:</b></td>
													<td>
														<input type="text" id="admissiontype" value="PCE" readonly disabled="true" onkeyup="getRecordlist(this.id,'admissiontype','recordlist2');" onclick="getRecordlist(this.id,'admissiontype','recordlist2');" size="50" />
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
												<!--tr>
													<td align='right' style=" color: red"><b>Group Code:</b></td>
													<td>
														<!--input type="text" id="entryyear" name="entryyear" size="10" />
														<input type="text" id="entryyear" onkeyup="getRecordlist(this.id,'sessionstable','recordlist2');" onclick="getRecordlist(this.id,'sessionstable','recordlist2');" size="50" />
													</td>
												</tr-->
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
									 <tr>
										<td align='right'><b>Course(s) to Retake (Separete With Comma):</b></td>
										<td colspan="2">
											<input type="text" id="carryover" size="100" onblur="this.value=capitalize(this.value)"/>
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
											<input type="text" id="nationality" name="nationality" size="20" onblur="this.value=capitalize(this.value)" />
										</td>
									</tr>
									<tr>
										<td align='right'><b>State of Origin:</b></td>
										<td>
											<input type="text" id="originState" name="originState" size="20" onblur="this.value=capitalize(this.value)" />
										</td>
									</tr>
									<tr>
										<td align='right'><b>Local Govt. Area:</b></td>
										<td>
											<input type="text" id="lga" name="lga" size="20" onblur="this.value=capitalize(this.value)" />
										</td>
									</tr>
									<tr>
										<td align='right'><b>Birth Place:</b></td>
										<td>
											<input type="text" id="birthPlace" name="birthPlace" size="20" onblur="this.value=capitalize(this.value)" />
										</td>
									</tr>
									<tr>
										<td align='right'><b>Religion:</b></td>
										<td>
											<input type="text" id="religion" name="religion" size="20" onblur="this.value=capitalize(this.value)" />
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

							<h3><a href="#">Re-Absorption</a></h3>
							<div id="container3" width="690px">
								<div id="reabsurption"></div>
								<table style="font-size:11px" align="center" cellspacing="0" cellpadding="1" width="100%" border=0>
									<tr>
										<td width='15%' align="right"><b>Session For Re-Absorption:</b></td>
										<td width='35%'>
											<input type="text" id="sesionsreabsurption" onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="getRecordlist(this.id,'sessionstable','recordlist3');" size="30" />
										</td>
									</tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
									<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
								</table>
								<div id="recordlist3" style="width:180px; height:180px; overflow:auto;"></div>
							</div>

							<h3><a href="#">Student's History</a></h3>
							<div id="container2" width="690px">
								<div id="student_history"></div>
								<table style="font-size:11px" align="center" class="history_msg" cellspacing="0" cellpadding="1" width="100%" border=0>
									<tr>
										<th>
											<div id="userinfo"></div>
										</th>
									</tr>
									<tr>
										<td>
											<textarea id='student_history_msg' style='display:inline; ' rows='5' cols='150'></textarea><br><br>
											<input id='"+del+"' type='button' style='display:inline' onclick="javascript:saveHistory(document.getElementById('regNumber').value)" value=' SAVE ' />
										</td>
									</tr>
								</table>
							</div>

						</div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	createCookie("myregularstudents", '1', false);
	getRecords('regularstudents','A');
</script>