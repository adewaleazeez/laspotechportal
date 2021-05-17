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
                $(document).ready(function(){
                    $("#updatemarks").accordion({
                        autoHeight: false
                    });
                });

                $("#dialog").dialog("destroy");

                $("#uploadresult").dialog({
					autoOpen: true,
                    position:'center',
                    title: 'Student Marks Update',
                    height: 600,
                    width: 1010,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#uploadresult').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#myupload").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Upload Marks From Excel!!!',
                    height: 300,
                    width: 300,
                    modal: true
                });

                $("#onlineupload").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Online Result Upload!!!',
                    height: 500,
                    width: 650,
                    modal: false,
					//beforeClose : function() { 
					//	$('#onlineupload').dialog('close');
					//	$('#uploadresult').dialog('open');
					//},
                    buttons: {
                        Upload: function() {
                            onlineUpload();
                        },
                        Close: function() {
                            $('#onlineupload').dialog('close');
                            $('#uploadresult').dialog('open');
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
                            $('#showRecord').dialog('close');
                        },
                        Open_Report: function() {
							$('#showRecord').dialog('close');
                            $('#showPrompt').dialog('close');
							$('#showAlert').dialog('close');
							$('#showError').dialog('close');
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

            function browseFiles(){
				var faculty = document.getElementById("facultycode5").value;
				var department = document.getElementById("departmentcode5").value;
				var programme = document.getElementById("programmecode5").value;
				var studentlevel = document.getElementById("studentlevel5").value;
				var sesions = document.getElementById("sesions").value;
				var semester = document.getElementById("semester").value;
				//var groupsession = document.getElementById("entryyear0").value;
				var coursecode = document.getElementById("coursecode5").value;
				var markdescription = document.getElementById("markdescription").value;
				var maximumunit = document.getElementById("maximumunit").value;
				//var percentage = document.getElementById("percentage").value;
				//var obtainable = document.getElementById("obtainable").value;

				var error="";
				if (faculty=="") error += "School must not be blank.<br><br>";
				if (department=="") error += "Department must not be blank.<br><br>";
				if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
				if (programme=="") error += "Programme Code must not be blank.<br><br>";
				if (sesions=="") error += "Session must not be blank.<br><br>";
				if (semester=="") error += "Semester must not be blank.<br><br>";
				//if (groupsession=="") error += "Group Code must not be blank.<br><br>";
				//if (coursecode=="") error += "course Code must not be blank.<br><br>";
				if (markdescription=="") error += "Marks Description must not be blank.<br><br>";
				if (maximumunit=="") error += "Maximum Unit must not be blank.<br><br>";
				//if (percentage=="") error += "Percentage Overall must not be blank.<br><br>";
				//if (obtainable=="") error += "Marks Obtainable must not be blank.<br><br>";
				//if (isNaN(percentage)) error += "Percentage Overall must be numeric.<br><br>";
				//if (isNaN(obtainable)) error += "Marks Obtainable must be numeric.<br><br>";
				if(error.length >0) {
					error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
					document.getElementById("showError").innerHTML = error;
					$('#showError').dialog('open');
					return true;
				}

				var param = "&table=coursestable&sesions="+sesions+"&semester="+semester+"&coursecode="+coursecode+"&studentlevel="+studentlevel;
				param += "&programmecode="+programme+"&facultycode="+faculty+"&departmentcode="+department;
				var url = "/laspotechportal/dataentrybackend.php?option=uploadExcel"+param;
				AjaxFunctionDataEntry(url);
            }

			function startUpload(){
				var faculty = document.getElementById("facultycode5").value;
				var department = document.getElementById("departmentcode5").value;
				var programme = document.getElementById("programmecode5").value;
				var studentlevel = document.getElementById("studentlevel5").value;
				var sesions = document.getElementById("sesions").value;
				var semester = document.getElementById("semester").value;
				//var groupsession = document.getElementById("entryyear0").value;
				var coursecode = document.getElementById("coursecode5").value;
				var markdescription = document.getElementById("markdescription").value;
				createCookie('_faculty',faculty,false);
				createCookie('_department',department,false);
				createCookie('_programme',programme,false);
				createCookie('_studentlevel',studentlevel,false);
				createCookie('_session',sesions,false);
				createCookie('_semester',semester,false);
				//createCookie('_groupsession',groupsession,false);
				createCookie('_coursecode',coursecode,false);
				createCookie('_markdescription',markdescription,false);
				$('#myupload').dialog('close');
				document.getElementById('f1_upload_process').style.visibility = 'visible';
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
				var url = "/laspotechportal/dataentrybackend.php?option=readCookies1";
				AjaxFunctionDataEntry(url);
			}

			function myStopFunction(){
				clearInterval(myVar);
			}

			function stopUpload(results){
				myStopFunction();
                //document.getElementById("showRecord").innerHTML = readCookie("azeez");
                //$('#showRecord').dialog('open');
				if(readCookie("filetype")!="excel") return true;
				document.getElementById('f1_upload_process').style.visibility = 'hidden';
				var resp = readCookie('resp').replace(/%2F/g, '/');
				resp = resp.replace(/_/g, ' ');
				if(readCookie('resp').match("recordlocked")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					var break_resp = resp.split("recordlocked");
					document.getElementById("showError").innerHTML = "<b>Records Locked!!!</b><br><br>The records you are trying to access are locked "+break_resp[1];
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("notinsetup")){
					var resp = readCookie('resp').replace(/_/g, ' ');
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
				}else if(readCookie('resp').match("coursecodeduplicate")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					var break_resp = resp.split("coursecodeduplicate");
					document.getElementById("showError").innerHTML = "<b>Duplicate Courese Code  !!!</b><br><br> ["+break_resp[0]+"] is duplicated in Sheet "+break_resp[1]+"  of the Excel File.";
					$('#showError').dialog('open');
					return true;
				}else if(readCookie('resp').match("Excel")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					document.getElementById("showError").innerHTML = "<b>Excel Value Does Not Match Selected Value!!!</b><br><br>"+resp;
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("already passed")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					document.getElementById("showError").innerHTML = "<b>Alert!!!</b><br><br>"+resp;
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("invalidmark")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					var break_resp = resp.split("invalidmark");
					document.getElementById("showError").innerHTML = "<b>Alert!!!</b><br><br>Invalid Mark "+break_resp[1];
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("matnoused")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					var resp = resp.replace(/_/g, ' ');
					var break_resp = resp.split("matnoused");
					document.getElementById("showError").innerHTML = "<b>Alert!!!</b><br><br>Matric No Used <br><br>"+break_resp[1];
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("gradenotsetup")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					var resp = resp.replace(/_/g, ' ');
					var break_resp = resp.split("gradenotsetup");
					document.getElementById("showError").innerHTML = "<b>Alert!!!</b><br><br>No Grade Codes setup exists in the system for "+break_resp[1];
					$('#showError').dialog('open');
				}else{
					var response = ""
					if(results==0){
						response = "<b>Invalid File!!!</b><br><br>Only Excel files with .xls extension i.e. Excel 97 - Excel 2003 versions are allowed for upload.";
						document.getElementById("showError").innerHTML = response;
						$('#showError').dialog('open');
					}
					if(results==1){
						/*if(readCookie('responses')!=null && readCookie('responses')!=""){
							$('#showPrompt').dialog('close');
							alert(readCookie('responses'));
							resp = readCookie('responses').replace(/_/g, ' ');
							resp = resp.replace(/~_~/g, '<br>');
							resp = resp.replace(/~~/g, '     ');
							resp = resp.replace(/`/g, ':');
							response = "Your marks upload is successful.\n\nClick Ok to open the Error report file.";
							alert(response);
							//var oWin = window.open("uploaderror.php?msg="+resp, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
							//if (oWin==null || typeof(oWin)=="undefined"){
							//	alert("Popup must be enabled on this browser to see the report");
							//}
							document.getElementById("showPrompt").innerHTML = resp;
							$('#showPrompt').dialog('open');
						}else{*/
							response = "<b>Upload Successful!!!</b><br><br>Your marks upload is successful.";
							document.getElementById("showPrompt").innerHTML = response;
							$('#showPrompt').dialog('open');
						//}
					}

					if(resp.match("studentnotsetup")){
						resp = resp.replace(/_/g, ' ');
						resp = resp.replace(/%28/g, '(');
						resp = resp.replace(/%29/g, ')');
						break_resp = resp.split("studentnotsetup");
						document.getElementById("showError").innerHTML = "<b>No Student Registered!!!</b><br><br> No Student was registered for: <br><b>School - </b>"+break_resp[1]+"<br><b>Department - </b>"+break_resp[2]+"<br><b>Programme - </b>"+break_resp[3]+"<br><b>Level - </b>"+break_resp[4]+"<br><b>Session - </b>"+break_resp[5]+"<br><b>Semester - </b>"+break_resp[6]; //+"<br><b>Group Code - </b>"+break_resp[7];
						$('#showError').dialog('open');
						return true;
					}

					if(results==2){
					    resp = readCookie('resp').replace(/_/g, ' ');
					    resp = resp.replace(/%28/g, '(');
					    resp = resp.replace(/%29/g, ')');
					    resp = resp.replace(/%2F/g, '/');
						break_resp = resp.split("exceedmaximumunits");
						document.getElementById("showError").innerHTML = "<b>Maximum Units Exceeded!!!</b><br><br> "+break_resp[0];
						$('#showError').dialog('open');
						$('#showPrompt').dialog('close');

						//return true;
						//response = readCookie('resp').replace(/\%2F/g, '/');
						//document.getElementById("showPrompt").innerHTML = response;
						//$('#showPrompt').dialog('open');
					}
				}
				if(results==1) populateMark('a.regNumber','DESC');
			}
			Window.Open("/xampp/htdocs/laspotechportal/excelexport.xls");
			function openExcel(){
alert("/xampp/htdocs/laspotechportal/excelexport.xls");
				var Excel = new ActiveXObject("Excel.Application");
				Excel.Visible = true;
				Excel.Workbooks.Open("/xampp/htdocs/laspotechportal/excelexport.xls");
			}
        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="showRecord"></div>
		<div id="onlineupload">
			<table width="100%">
				<tr>
					<td align='right'><b>Session:</b></td>
					<td>
						<input type="text" id="sesionsA" name="sesionsA" onkeyup="getRecordlist(this.id,'sessionstable','recordlist2');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist2');" size="30" />
					</td>
					<td align='right'><b>Semester:</b></td>
					<td>
						<input type="text" id="semesterA" name="semesterA" onkeyup="getRecordlist(this.id,'sessionstable','recordlist2');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist2');" size="30" />
					</td>
				</tr>
			</table>
			<div id='recordlist2'></div>
		</div>
        <table width="100%">
            <tr>
                <td>
					<form id='myupload' action="uploadfile.php?ftype=excel" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" style="visibility: hidden" >
						<div id="myform">
							<div id="selectedfile"><b>Please select a file and click Upload button below:</b></div><BR><BR>
							<input type="file" name="txtFile" id="txtFile" style="visibility: hidden" /><BR><BR>
							<input type="submit" id="submitButton" name="submitButton" value="Upload" style="display:block; margin-left: 15px; width: 105px; padding: 5px 5px; text-align:center; background:#880000; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 27px; width: 82px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold;"/>
						</div>
						<iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;"></iframe>
					</form>
					<div id="uploadresult">
						<div id="updatemarks">
							
							<h3><a href="#">Student Marks Update</a></h3>
							<div>
								<table width='100%' style='font-size:10px;'>
									<tr>
										<td colspan="4">
											<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:50px; top:10px; left:250px"><b>Uploading........</b><br/>
											<img src="imageloader.gif" /><br/></div><BR>
										</td>
									</tr>
									<tr>
										<td align="right"><b>School:</b></td>
										<td>
											<input type="text" id="facultycode5" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist3'); createCookie('getunit','1',false);" />
										</td>
										<td align="right"><b>Department:</b></td>
										<td>
											<input type="text" id="departmentcode5" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist3'); createCookie('getunit','1',false);" />
										</td>
									</tr>
									<tr>
										<td align="right"><b>Programme:</b></td>
										<td>
											<input type="text" id="programmecode5" onkeyup="getRecordlist(this.id,'programmestable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist3'); createCookie('getunit','1',false);" size="50" />
										</td>                        
										<td align="right"><b>Level:</b></td>
										<td>
											<input type="text" id="studentlevel5" onkeyup="getRecordlist(this.id,'studentslevels','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist3'); createCookie('getunit','1',false);" size="50" />
										</td>                        
									</tr>
									<tr>
										<td width='15%' align="right"><b>Session:</b></td>
										<td width='35%'>
											<input type="text" id="sesions"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist3'); createCookie('getunit','1',false);" size="50" />
										</td>
										<td width='15%' align="right"><b>Semester:</b></td>
										<td width='35%'>
											<input type="text" id="semester" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist3'); createCookie('getunit','1',false);" size="50" />
										</td>
									</tr>
									<tr>
										<td align="right"><b>Course Code:</b></td>
										<td>
											<input type="text" id="coursecode5" onkeyup="getRecordlist(this.id,'coursestable','recordlist3');" onclick="this.value=''; document.getElementById('markslist').innerHTML=''; getRecordlist(this.id,'coursestable','recordlist3');" size="50" />
										</td>
										<td align="right"><b>Maximum Units:</b></td>
										<td>
											<input type="text" id="maximumunit" readonly disabled="true" size="10" />
										</td>
										<td><b>&nbsp;</b></td>
										<!--td align="right"><b>Group Code:</b></td>
										<td>
											<input type="text" id="entryyear0" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist3');" size="50" />
										</td-->
									</tr>
									<tr>
										<!--td align="right"><b>Mark Description:</b></td>
										<td>
											<input type="text" id="markdescription" onkeyup="getRecordlist(this.id,'examresultstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'examresultstable','recordlist3');" size="50" />
										</td-->
										<td align="right"><b>&nbsp;</b></td>
										<td align="right"><b>&nbsp;</b></td>
										<!--td align="right"><b>&nbsp;</b></td-->
										<td colspan="2">
											<input type="button" style="display:inline" id="populatemarks" onclick="populateMark('a.regNumber','DESC')" value=" List Records " />
											<input type="button" style="display:inline" id="excelupload" onclick="browseFiles();" value=" Excel Upload " />
											<input type="button" style="display:inline" id="excelexport" onclick="viewMyResult('excelexport')" value=" Excel Export " />
											<input type="button" style="display:inline" id="deletemarks" onclick="deleteMarks()" value=" Delete All Marks " />
											<!--input type="button" style="display:inline" id="uploadonline" onclick="showOnlineUpload()" value="Online Upload" /-->
										</td>
									</tr>
									<tr>
										<td colspan="4">
											<div id="markslist" style="height:250px; overflow:auto;"></div>
										</td>
									</tr>
								</table>
								<div id="msgdiv"></div>
								<div id='recordlist3'></div>
								<input type="hidden" id="markdescription" size="10" value='Exam' />
								<input type="hidden" id="percentage" onblur="this.value=numberFormat(this.value);" size="10" value='100.00' />
								<input type="hidden" style="display:inline" id="obtainable" onblur="this.value=numberFormat(this.value);" size="10" value='100.00' />
							</div>

							<!--h3><a href="#">Student Marks Amendment</a></h3>
							<div>
								<table width='100%' style='font-size:10px;'>
									<tr>
										<td align="right"><b>School:</b></td>
										<td>
											<input type="text" id="facultycode1" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist1');" />
										</td>
										<td align="right"><b>Department:</b></td>
										<td>
											<input type="text" id="departmentcode1" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist1');" />
										</td>
									</tr>
									<tr>
										<td align="right"><b>Programme:</b></td>
										<td>
											<input type="text" id="programmecode1" onkeyup="getRecordlist(this.id,'programmestable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist1');" size="50" />
										</td>                        
										<td align="right"><b>Level:</b></td>
										<td>
											<input type="text" id="studentlevel1" onkeyup="getRecordlist(this.id,'studentslevels','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist1');" size="50" />
										</td>                        
									</tr>
									<tr>
										<td width='15%' align="right"><b>Session:</b></td>
										<td width='35%'>
											<input type="text" id="sesions1"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist1');" size="50" />
										</td>
										<td width='15%' align="right"><b>Semester:</b></td>
										<td width='35%'>
											<input type="text" id="semester1" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist1');" size="50" />
										</td>
									</tr>
									<tr>
										<td align="right"><b>Course Code:</b></td>
										<td>
											<input type="text" id="coursecode1" onkeyup="getRecordlist(this.id,'coursestable','recordlist1');" onclick="this.value=''; document.getElementById('markslist1').innerHTML='';  getRecordlist(this.id,'coursestable','recordlist1');" size="50" />
										</td>
										<td align="right"><b>Amendment Title:</b></td>
										<td>
											<input type="text" id="amendedtitle" onkeyup="getRecordlist(this.id,'amendedresults','recordlist1');" onclick="this.value=''; getRecordlist(this.id,'amendedresults','recordlist1');" size="50" />
										</td>
									</tr>
									<tr>
										<td align="right"><b>&nbsp;</b></td>
										<td align="right"><b>&nbsp;</b></td>
										<td align="right"><b>&nbsp;</b></td>
										<td>
											<input type="button" style="display:inline" id="populateamended" onclick="populateAmended('a.regNumber','DESC')" value=" List Records " />
										</td>
									</tr>
									<tr>
										<td colspan="4">
											<div id="markslist1" style="height:180px; overflow:auto;"></div>
										</td>
									</tr>
									<tr>
										<td align="right"><b>Reason for Amendment:</b></td>
										<td colspan="3">
											<textarea id="amendreason" rows='2' cols='130'></textarea>
										</td>
									</tr>
								</table>
								<div id="msgdiv"></div>
								<div id='recordlist1'></div>
								<input type="hidden" id="markdescription1" size="10" value='Exam' />
								<input type="hidden" id="percentage1" size="10" value='100.00' />
								<input type="hidden" id="obtainable1" size="10" value='100.00' />
							</div>

							<h3><a href="#">Special Features Requiring Senate Attention</a></h3>
							<div>
								<table width='100%' style='font-size:10px;'>
									<tr>
										<td align="right"><b>School:</b></td>
										<td>
											<input type="text" id="facultycode6" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist9');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist9');" />
										</td>
										<td align="right"><b>Department:</b></td>
										<td>
											<input type="text" id="departmentcode6" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist9');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist9');" />
										</td>
									</tr>
									<tr>
										<td align="right"><b>Programme:</b></td>
										<td>
											<input type="text" id="programmecode6" onkeyup="getRecordlist(this.id,'programmestable','recordlist9');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist9');" size="50" />
										</td>                        
										<td align="right"><b>Level:</b></td>
										<td>
											<input type="text" id="studentlevel6" onkeyup="getRecordlist(this.id,'studentslevels','recordlist9');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist9');" size="50" />
										</td>                        
									</tr>
									<tr>
										<td align="right"><b>Session:</b></td>
										<td>
											<input type="text" id="sesions5"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist9');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist9');" size="50" />
										</td>
										<td align="right"><b>Semester:</b></td>
										<td>
											<input type="text" id="semester5" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist9');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist9');" size="50" />
										</td>
									</tr>
									<tr>
										<td align="right"><b>&nbsp;</b></td>
										<td align="right"><b>&nbsp;</b></td>
										<td align="right"><b>&nbsp;</b></td>
										<td>
											<input type="button" style="display:inline" id="populatefeatures" onclick="populateFeature('a.regNumber')" value=" List Records " />
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
							</div-->

						</div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	if(document.getElementById("markslist").innerHTML.length==0)
		document.getElementById("markslist").innerHTML="<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>";
	/*if(document.getElementById("markslist1").innerHTML.length==0)
		document.getElementById("markslist1").innerHTML="<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>";
	if(document.getElementById("featureslist").innerHTML.length==0)
		document.getElementById("featureslist").innerHTML="<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>";*/
 
	document.getElementById("facultycode5").value=readCookie("_facultys");
	document.getElementById("departmentcode5").value=readCookie("_departments");
	document.getElementById("programmecode5").value=readCookie("_programmes");
	document.getElementById("studentlevel5").value=readCookie("_levels");
	document.getElementById("sesions").value=readCookie("_sessions");
	document.getElementById("semester").value=readCookie("_semesters");
	document.getElementById("coursecode5").value=readCookie("_coursecodes");

	/*document.getElementById("facultycode1").value=readCookie("_facultys");
	document.getElementById("departmentcode1").value=readCookie("_departments");
	document.getElementById("programmecode1").value=readCookie("_programmes");
	document.getElementById("coursecode1").value=readCookie("_coursecodes");
	document.getElementById("studentlevel1").value=readCookie("_levels");
	document.getElementById("sesions1").value=readCookie("_sessions");
	document.getElementById("semester1").value=readCookie("_semesters");
	document.getElementById("amendedtitle").value=readCookie("_amendedtitle");

	document.getElementById("facultycode6").value=readCookie("_facultys");
	document.getElementById("departmentcode6").value=readCookie("_departments");
	document.getElementById("programmecode6").value=readCookie("_programmes");
	document.getElementById("studentlevel6").value=readCookie("_levels");
	document.getElementById("sesions5").value=readCookie("_sessions");
	document.getElementById("semester5").value=readCookie("_semesters");*/
	//document.getElementById("entryyear5").value=readCookie("_entryyears");
	doMaxUnit('get');
</script>

