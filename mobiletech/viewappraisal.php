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

                $("#listappraisal").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Appraisal List - View',
                    height: 440,
                    width: 1050,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#listappraisal').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#appraisaldetail").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'Appraisal Details View',
                    height: 620,
                    width: 1020,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#appraisaldetail').dialog('close');
                            $('#listappraisal').dialog('open');
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
		<div id="listappraisal" style="height:250px; width:700px; overflow:auto;">
			<table>
				<tr>
					<td>
						<b>Staff Id:</b>&nbsp;
						<input type="text" id="staffid" name="staffid" onkeyup="getRecordlist(this.id,'stafftable','recordlist2');" onclick="this.value=''; document.getElementById('staffname').value=''; createCookie('getstaffB','1',false); getRecordlist(this.id,'stafftable','recordlist2');" size="15" />
						<input type="text" id="staffname" name="staffname" size="30" readonly disabled="true" />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<b>From:</b>&nbsp;
						<select id="appraisalstartmonth" style="display:inline">
							<option></option>
							<option>Jan</option>
							<option>Feb</option>
							<option>Mar</option>
							<option>Apr</option>
							<option>May</option>
							<option>Jun</option>
							<option>Jul</option>
							<option>Aug</option>
							<option>Sep</option>
							<option>Oct</option>
							<option>Nov</option>
							<option>Dec</option>
						</select>
						<input type="text" id="appraisalstartyear" name="appraisalstartyear" size="4" style="display:inline" onfocus="this.value=''" onkeyup="getRecordlist(this.id,'appraisaltableA','recordlist2');" onclick="getRecordlist(this.id,'appraisaltableA','recordlist2');" />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<b>To:</b>&nbsp;
						<select id="appraisalendmonth" style="display:inline">
							<option></option>
							<option>Jan</option>
							<option>Feb</option>
							<option>Mar</option>
							<option>Apr</option>
							<option>May</option>
							<option>Jun</option>
							<option>Jul</option>
							<option>Aug</option>
							<option>Sep</option>
							<option>Oct</option>
							<option>Nov</option>
							<option>Dec</option>
						</select>
						<input type="text" id="appraisalendyear" name="appraisalendyear" size="4" style="display:inline" onfocus="this.value=''" onkeyup="getRecordlist(this.id,'appraisaltableB','recordlist2');" onclick="getRecordlist(this.id,'appraisaltableB','recordlist2');" />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<input type="button" id="listappraisal" name="listappraisal" value="List Appraisals" 
						onclick="checkAccess('viewappraisal.php', 'View Appraisal');" style="display:inline" />
						<input type="button" id="myappraisal" name="myappraisal" value=" My Appraisals " onclick="listAppraisal(readCookie('currentuser'));" style="display:inline" />
					<td>
				</tr>
			</table>
			<div id='recordlist2'></div>
			<div id="appraisallist" style="height:250px; width:700px; overflow:auto;"></div>
		</div>
		<div id="appraisaldetail" style="font-size:11px">
			<div id="f1_upload_process" style="z-index:100; visibility:hidden; position:absolute; text-align:center; width:200px; top:100px; left:400px">Loading...<br/><img src="imageloader.gif" /><br/></div>
			<table>
				<tr>
					<td align='right'><b>Staff_Id:</b></td>
					<td>
						<input type="text" id="staffid2" name="staffid2" size="20" readonly disabled="true" />
						<input type="hidden" id="userName" name="userName" />
						<!--onfocus="this.value=''" onkeyup="getRecordlist(this.id,'stafftable','recordlist');" onclick="createCookie('getstaffB','1',false); getRecordlist(this.id,'stafftable','recordlist');" -->
					</td>
					<td align='right'><b>Appraisal Date:</b></td>
					<td>
						<input type="text" id="appraisaldate" name="appraisaldate" size="10" readonly disabled="true" />
					</td>
					<td rowspan="7" colspan="2">
						<div id="f1_uploaded_file"><img src="photo/silhouette.jpg" border="1" width="150" height="150" title="Picture" alt="Applicant's Passport"/><br/></div>

						<!--div id="f1_upload_button" onclick="javascript:browseFiles()" style="display:block; margin-left: 15px; width: 105px; padding: 5px 5px; text-align:center; background:#880000; border-bottom:1px solid #ddd;color:#fff; cursor: pointer; border:1px solid #000033;   height: 17px; width: 82px; font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold;">Upload</div><br-->

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
					<td align='right'><b>Staff_Name:</b></td>
					<td>
						<input type="text" id="staffname2" name="staffname2" size="35" readonly disabled="true" />
					</td>
					<td align='right'><b>Employment_Date:</b></td>
					<td>
						<input type="text" id="employmentdate" name="employmentdate" size="10" onclick="displayDatePicker('employmentdate', false, 'dmy', '/');" readonly disabled="true" />
					</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Job_Title:</b></td>
					<td>
						<input type="text" id="jobtitle" name="jobtitle" size="20" readonly disabled="true" />
					</td>
					<td align='right'><b>Level:</b></td>
					<td>
						<input type="text" id="level" name="level" size="20" readonly disabled="true" />
					</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Department:</b></td>
					<td>
						<input type="text" id="department" name="department" size="30" readonly disabled="true" />
					</td>
					<td align='right'><b>Supervisor:</b></td>
					<td>
						<input type="text" id="supervisorid" name="supervisorid" size="25" readonly disabled="true" />
					</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Gender:</b></td>
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
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align='right'><b>Appraisal Start Period:</b></td>
					<td>
						<input type="text" id="appraisalstart" name="appraisalstart" size="15" style="display:inline" readonly disabled="true" />
					</td>
					<td align='right'><b>Appraisal End Period:</b></td>
					<td>
						<input type="text" id="appraisalend" name="appraisalend" size="10" style="display:inline" readonly disabled="true" />
					</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2"><b>State Your Understanding of your main duties and responsibilities:</b></br>
						<textarea id="duties" name="duties" rows="4" cols="50" readonly disabled="true"></textarea>
					</td>
					<td colspan="2"><b>What part of your job do you find most difficult?</b></br>
						<textarea id="difficultduties" name="difficultduties" rows="4" cols="50" readonly disabled="true"></textarea>
					</td>
					<td colspan="2"><b>What part of your job interest you the most?</b></br>
						<textarea id="interestingduties" name="interestingduties" rows="4" cols="50" readonly disabled="true"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2"><b>What action could be taken to improve your performance in your present position?</b></br>
						<textarea id="performanceimprove" name="performanceimprove" rows="4" cols="50" readonly disabled="true"></textarea>
					</td>
					<td colspan="2" ><b>Have you ever been queried or suspended or had any disciplinary action taken against you within the last 6mths? If Yes, why?</b></br>
						<textarea id="queryorsuspension" name="queryorsuspension" rows="4" cols="50" readonly disabled="true"></textarea>
					</td>
					<td colspan="2"><b>Have you attended any training in the last 6mths? (Yes/No) If Yes, State: i) Course, ii) Date, iii) Location</b></br>
						<textarea id="training" name="training" rows="4" cols="60" readonly disabled="true"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td colspan="2"><b>State the most successful job accomplishment since last performance period?</b></br>
						<textarea id="accomplishments" name="accomplishments" rows="4" cols="50" readonly disabled="true"></textarea>
					</td>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
			<div id='recordlist'></div>
		</div>
    </body>
</html>
<script>
	/*var d = new Date();
	var date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
	day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
	mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
	year = date_split[2];
	document.getElementById('appraisalstartyear').value=year;
	document.getElementById('appraisalendyear').value=year;
	var endmonth="";
		if(d.getMonth()==0) endmonth += "Jan";
		if(d.getMonth()==1) endmonth += "Feb";
		if(d.getMonth()==2) endmonth += "Mar";
		if(d.getMonth()==3) endmonth += "Apr";
		if(d.getMonth()==4) endmonth += "May";
		if(d.getMonth()==5) endmonth += "Jun";
		if(d.getMonth()==6) endmonth += "Jul";
		if(d.getMonth()==7) endmonth += "Aug";
		if(d.getMonth()==8) endmonth += "Sep";
		if(d.getMonth()==9) endmonth += "Oct";
		if(d.getMonth()==10) endmonth += "Nov";
		if(d.getMonth()==11) endmonth += "Dec";
	var selectoption = document.getElementById("appraisalendmonth");
	for(var k=0; selectoption.options[k].text != null; k++){
		if(selectoption.options[k].text == endmonth){
			selectoption.selectedIndex = k;
			break;
		}
	}*/
	document.getElementById('supervisorid').value=readCookie("currentuser");
	
</script>
