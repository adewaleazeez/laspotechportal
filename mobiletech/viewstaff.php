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
        <title>MobileTech Portal Systems</title>
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

                $("#stafflist").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Staff List - View',
                    height: 440,
                    width: 710,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#stafflist').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#staffdetail").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'Staff Details - View',
                    height: 540,
                    width: 1010,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#staffdetail').dialog('close');
                            $('#stafflist').dialog('open');
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

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="stafflist" style="height:250px; width:700px; overflow:auto;"></div>
		<div id="staffdetail" style="font-size:11px">
			<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:200px; top:100px; left:400px">Loading...<br/><img src="imageloader.gif" /><br/></div>
			<table>
				<tr>
					<td align='right' style=" color: red"><b>Staff_Id:</b></td>
					<td>
						<input type="text" id="staffid" name="staffid" readonly disabled="true" size="20" />
					</td>
					<td align='right' style=" color: red"><b>Last_Name:</b></td>
					<td>
						<input type="text" id="lastname" name="lastname" readonly disabled="true" size="25" />
					</td>
					<td rowspan="13">
						<div id="f1_uploaded_file"><img src="photo/silhouette.jpg" border="1" width="150" height="150" title="Picture" alt="Applicant's Passport"/><br/></div>

						<!--div id="f1_upload_button" onclick="javascript:browseFiles()" style="display:block; margin-left: 15px; width: 105px; padding: 5px 5px; text-align:center; background:#880000; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 17px; width: 82px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold;">Upload</div><br!-->

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
					<td align='right' style=" color: red"><b>First_Name:</b></td>
					<td>
						<input type="text" id="firstname" name="firstname" readonly disabled="true" size="25" />
					</td>
					<td align='right'><b>Middle_Name:</b></td>
					<td>
						<input type="text" id="middlename" name="middlename" readonly disabled="true" size="25" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'style=" color: red"><b>Gender:</b></td>
					<td>
						<select id="gender" readonly disabled="true">
							<option></option>
							<option>Male</option>
							<option>Female</option>
						</select>
					</td>
					<td align='right'><b>Birth_Date:</b></td>
					<td>
						<input type="text" id="birthdate" name="birthdate" readonly disabled="true" size="10" onclick="displayDatePicker('birthdate', false, 'dmy', '/');" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Employment_Date:</b></td>
					<td>
						<input type="text" id="employmentdate" name="employmentdate" readonly disabled="true" size="10" onclick="displayDatePicker('employmentdate', false, 'dmy', '/');" />
					</td>
					<td align='right'><b>Job_Title:</b></td>
					<td>
						<input type="text" id="jobtitle" name="jobtitle" readonly disabled="true" size="20" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Level:</b></td>
					<td>
						<input type="text" id="level" name="level" readonly disabled="true" size="20" />
					</td>
					<td align='right'style=" color: red"><b>Department:</b></td>
					<td>
						<input type="text" id="department" name="department" onkeyup="getRecordlist(this.id,'departmentstable','recordlist');" onclick="getRecordlist(this.id,'departmentstable','recordlist');" readonly disabled="true" size="30" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Supervisor:</b></td>
					<td>
						<input type="text" id="supervisorid" name="supervisorid" onkeyup="getRecordlist(this.id,'stafftable','recordlist');" onclick="getRecordlist(this.id,'stafftable','recordlist');" readonly disabled="true" size="25" />
					</td>
					<td align='right'><b>Previous Contact_Address:</b></td>
					<td>
						<textarea id="previouscontactaddress" name="previouscontactaddress" rows="2" cols="40" readonly disabled="true"></textarea>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>New Contact_Address:</b></td>
					<td>
						<textarea id="newcontactaddress" name="newcontactaddress" rows="2" cols="40" readonly disabled="true"></textarea>
					</td>
					<td align='right'><b>Home Phone_No:</b></td>
					<td>
						<input type="text" id="homephonenumber" name="homephonenumber" readonly disabled="true" size="20" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Mobile_Phone:</b></td>
					<td>
						<input type="text" id="mobilephonenumber" name="mobilephonenumber" readonly disabled="true" size="20" />
					</td>
					<td align='right'><b>Staff_Email:</b></td>
					<td>
						<input type="text" id="emailaddress" name="emailaddress" readonly disabled="true" size="40" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Marital_Status:</b></td>
					<td>
						<select id="maritalstatus" readonly disabled="true">
							<option></option>
							<option>Single</option>
							<option>Married</option>
							<option>Divorced</option>
							<option>Separated</option>
							<option>Widowed</option>
						</select>
					</td>
					<td align='right'><b>Maiden_Name:</b></td>
					<td>
						<input type="text" id="maidenname" name="maidenname" readonly disabled="true" size="40" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Spouse_Name:</b></td>
					<td>
						<input type="text" id="spousename" name="spousename" readonly disabled="true" size="40" />
					</td>
					<td align='right'><b>Spouse Phone_No:</b></td>
					<td>
						<input type="text" id="spousephonenumber" name="spousephonenumber" readonly disabled="true" size="20" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Next_of_Kin:</b></td>
					<td>
						<input type="text" id="nextofkin" name="nextofkin" readonly disabled="true" size="40" />
					</td>
					<td align='right'><b>Next_of_Kin Address:</b></td>
					<td>
						<textarea id="nextofkinaddress" name="nextofkinaddress" rows="2" cols="40"></textarea>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Relationship_With Next_of_Kin:</b></td>
					<td>
						<select id="nextofkinrelationship" readonly disabled="true">
							<option></option>
							<option>Son</option>
							<option>Daughter</option>
							<option>Brother</option>
							<option>Sister</option>
							<option>Wife</option>
							<option>Husband</option>
							<option>Father</option>
							<option>Mother</option>
							<option>Uncle</option>
							<option>Aunt</option>
							<option>Nephew</option>
							<option>Niece</option>
						</select>
					</td>
					<td align='right'><b>Next_of_Kin Phone_No:</b></td>
					<td>
						<input type="text" id="nextofkinphonenumber" name="nextofkinphonenumber" readonly disabled="true" size="20" />
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align='right' style="color: red;"><b>Active:&nbsp;</b></td>
					<td>
						<select id="active" readonly disabled="true">
							<option>Yes</option>
							<option>No</option>
						</select>
						<input type="hidden" name="staffPicture" id="staffPicture" />
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div id='recordlist'></div>
		</div>
    </body>
</html>
<script>
	getRecords('stafftable');
</script>
