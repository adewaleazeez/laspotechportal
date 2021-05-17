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

                $("#backup").dialog({
					autoOpen: true,
                    position:'center',
                    title: 'Data Backup/Restore',
                    height: 600,
                    width: 1000,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#backup').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#myupload").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Restor Marks From Excel!!!',
                    height: 300,
                    width: 300,
                    modal: true
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
                    width: 400,
                    modal: true,
                    buttons: {
                        Ok: function() {
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

				var error="";
				if (faculty=="") error += "School must not be blank.<br><br>";
				if (department=="") error += "Department must not be blank.<br><br>";
				if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
				if (programme=="") error += "Programme Code must not be blank.<br><br>";
				if (sesions=="") error += "Session must not be blank.<br><br>";
				if (semester=="") error += "Semester must not be blank.<br><br>";
				if(error.length >0) {
					error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
					document.getElementById("showError").innerHTML = error;
					$('#showError').dialog('open');
					return true;
				}
				alert("Please ensure that:\n\n\n 1. Only Excel file types must be selected.\n 2. Only Excel files with .xls extension i.e. Excel 97 - Excel 2003 versions are acceptable.\n 3. Make sure you select a valid backup file.\n\n\n\nPlease click ok to continue");
				document.getElementById("myupload").style.visibility = "visible";
				document.getElementById("txtFile").style.visibility = "visible";
				$('#myupload').dialog('open');
            }

			function startUpload(){
				var faculty = document.getElementById("facultycode5").value;
				var department = document.getElementById("departmentcode5").value;
				var programme = document.getElementById("programmecode5").value;
				var studentlevel = document.getElementById("studentlevel5").value;
				var sesions = document.getElementById("sesions").value;
				var semester = document.getElementById("semester").value;
				createCookie('_faculty',faculty.replace(/,/g, '_coma'),false);
				createCookie('_department',department.replace(/,/g, '_coma'),false);
				createCookie('_programme',programme.replace(/,/g, '_coma'),false);
				createCookie('_studentlevel',studentlevel.replace(/,/g, '_coma'),false);
				createCookie('_sesions',sesions.replace(/,/g, '_coma'),false);
				createCookie('_semester',semester.replace(/,/g, '_coma'),false);
				$('#myupload').dialog('close');
				document.getElementById('f1_upload_process').style.visibility = 'visible';
			}

			function stopUpload(results){
					//document.getElementById("showPrompt").innerHTML = readCookie('rsp')+results;
					//$('#showPrompt').dialog('open');
					//return true;
				document.getElementById('f1_upload_process').style.visibility = 'hidden';
				if(readCookie('resp').match("notinsetup")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					var break_resp = resp.split("notinsetup");
					document.getElementById("showError").innerHTML = "<b>Excel Value Does Not Exist In "+break_resp[2]+" Setup!!!</b><br><br> ["+break_resp[1]+"] you typed in Excel file does not exist in "+break_resp[2]+" setup.";
					$('#showError').dialog('open');
				}else if(readCookie('resp').match("Excel")){
					var resp = readCookie('resp').replace(/_/g, ' ');
					document.getElementById("showError").innerHTML = "<b>Excel Value Does Not Match Selected Value!!!</b><br><br>"+resp;
					$('#showError').dialog('open');
				}else{
					var response = "<b>Invalid File!!!</b><br><br>Only Excel files are allowed for upload.";
					if(results==1) response = "<b>Datya Restore Successful!!!</b><br><br>Your data restore is successful.";
					document.getElementById("showPrompt").innerHTML = response;
					$('#showPrompt').dialog('open');
				}
			}

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
        <table width="100%">
            <tr>
                <td>
					<form id='myupload' action="uploadrestore.php?ftype=excel" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" style="visibility: hidden" >
						<div id="myform">
							<div id="selectedfile"><b>Please select a file and click Restore button below:</b></div><BR><BR>
							<input type="file" name="txtFile" id="txtFile" style="visibility: hidden" /><BR><BR>
							<input type="submit" id="submitButton" name="submitButton" value="Restore" style="display:block; margin-left: 15px; width: 105px; padding: 5px 5px; text-align:center; background:#880000; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 27px; width: 82px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold;"/>
						</div>
						<iframe id="upload_target" name="upload_target" style="width:0;height:0;border:0px solid #fff;"></iframe>
					</form>
					<div id="backup">
						<div>
							<table width='100%' style='font-size:10px;'>
								<tr>
									<td colspan="4">
										<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:50px; top:10px; left:250px"><b>Restoring........</b><br/>
										<img src="imageloader.gif" /><br/></div><BR>
									</td>
								</tr>
								<tr>
									<td colspan="4">&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><b>School:</b></td>
									<td>
										<input type="text" id="facultycode5" size="50" onkeyup="getRecordlist(this.id,'facultiestable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist3');" />
									</td>
									<td align="right"><b>Department:</b></td>
									<td>
										<input type="text" id="departmentcode5" size="50" onkeyup="getRecordlist(this.id,'departmentstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist3');" />
									</td>
								</tr>
								<tr>
									<td align="right"><b>Programme:</b></td>
									<td>
										<input type="text" id="programmecode5" onkeyup="getRecordlist(this.id,'programmestable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist3');" size="50" />
									</td>                        
									<td align="right"><b>Level:</b></td>
									<td>
										<input type="text" id="studentlevel5" onkeyup="getRecordlist(this.id,'studentslevels','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist3');" size="50" />
									</td>                        
								</tr>
								<tr>
									<td width='15%' align="right"><b>Session:</b></td>
									<td width='35%'>
										<input type="text" id="sesions"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist3');" size="50" />
									</td>
									<td width='15%' align="right"><b>Semester:</b></td>
									<td width='35%'>
										<input type="text" id="semester" style="display:inline" onkeyup="getRecordlist(this.id,'sessionstable','recordlist3');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist3');" size="50" />
									</td>
								</tr>
								<tr>
									<td align="right">&nbsp;</td>
									<td align="right">&nbsp;</td>
									<td align="right">&nbsp;</td>
									<td>
										<input type="button" style="display:inline" id="excelexport" onclick="viewMyResult('excelbackup')" value=" Backup To Excel " />
										<input type="button" style="display:inline" id="excelupload" onclick="browseFiles();" value=" Restore From Excel " />
									</td>
								</tr>
							</table>
							<div id="msgdiv"></div>
							<div id='recordlist3'></div>
						</div>

					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	document.getElementById("facultycode5").value=readCookie("_faculty").replace(/_coma/g, ',');
	document.getElementById("departmentcode5").value=readCookie("_department").replace(/_coma/g, ',');
	document.getElementById("programmecode5").value=readCookie("_programme").replace(/_coma/g, ',');
	document.getElementById("studentlevel5").value=readCookie("_studentlevel").replace(/_coma/g, ',');
	document.getElementById("sesions").value=readCookie("_sesions").replace(/_coma/g, ',');
	document.getElementById("semester").value=readCookie("_semester").replace(/_coma/g, ',');
</script>
