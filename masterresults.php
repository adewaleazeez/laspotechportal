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

                $("#dialog").dialog("destroy");

                $("#mastersheet").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Spread Sheets',
                    height: 420,
                    width: 910,
                    modal: false,
                    buttons: {
                        Process_Report: function() {
                            viewMyResult("viewpdfmaster","process");
							myVar=setInterval(function(){myTimer()},1000);
							d=new Date();
							starttime=d.toLocaleTimeString();
                        },
                        Print_Report: function() {
                            viewMyResult("viewpdfmaster","print");
                        },
                        /*Statistical_Graph: function() {
                            viewMyResult('graph');
                        },*/
						Close: function() {
                            $('#mastersheet').dialog('close');
							window.location="home.php?pgid=0";
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
                            document.getElementById("signatoryposition").value="";
                            document.getElementById("signatoryname").value="";
                        },
                        Close: function() {
                            $('#signatory').dialog('close');
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

                $("#showRecord").dialog({
                    autoOpen: false,
                    position:[1100,70],
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
                        }
                    }
                });

            });

			var myVar=null;
			var d=new Date();
			var starttime=d.toLocaleTimeString();
			function myTimer(){
				var url = "/laspotechportal/dataentrybackend.php?option=readCookies3";
				AjaxFunctionDataEntry(url);
			}

			function myStopFunction(){
				clearInterval(myVar);
			}


        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <div id="showRecord"></div>
            <tr>
                <td>
					<div id="mastersheet">
						<table width='100%' style='font-size:10px;'>
							<tr>
								<td align='right'><b>School:</b></td>
								<td>
									<input type="text" id="facultycode2" onkeyup="getRecordlist(this.id,'facultiestable','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'facultiestable','recordlist6');" size="45" />
								</td>
								<td align='right'><b>Department:</b></td>
								<td>
									<input type="text" id="departmentcode2" onkeyup="getRecordlist(this.id,'departmentstable','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'departmentstable','recordlist6');" size="45" />
								</td>
							</tr>
							<tr>
								<td align='right'><b>Programme:</b></td>
								<td>
									<input type="text" id="programmecode2" onkeyup="getRecordlist(this.id,'programmestable','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'programmestable','recordlist6');" size="45" />
								</td>
								<td align='right'><b>Student Level:</b></td>
								<td>
									<input type="text" id="studentlevel2" onkeyup="getRecordlist(this.id,'studentslevels','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'studentslevels','recordlist6');" size="45" />
								</td>
							</tr>
							<tr>
								<td align='right'><b>Session:</b></td>
								<td>
									<input type="text" id="sesions2" onkeyup="getRecordlist(this.id,'sessionstable','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist6');" size="45" />
								</td>
								<td align="right"><b>Semester:</b></td>
								<td>
									<input type="text" id="semester2" onkeyup="getRecordlist(this.id,'sessionstable','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist6');" size="45" />
								</td>
							</tr>
							<tr>
								<!--td align='right'><b>Final Semester:</b></td>
								<td>
									<select style="display:inline" id="finalyear1">
										<option>No</option>
										<option>Yes</option>
									</select>
									<div style="display:inline"><b>&nbsp;&nbsp;&nbsp;&nbsp;Supplemenrary List</b></div>
									<select style="display:inline" id="suplementaryA">
										<option>No</option>
										<option>Yes</option>
									</select>
								</td-->
								<td align='right'><b>Final Semester:</b></td>
								<td>
									<select style="display:inline" id="finalyear1">
										<option>No</option>
										<option>Yes</option>
									</select>
								</td>
								<td align='right'><b>Result Type:</b></td>
								<td>                        
									<input type="text" id="resultype" style="display:inline" onkeyup="getRecordlist(this.id,'amendedresults','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'amendedresults','recordlist6');" value='Normal Results' size="21" />
								</td>
								<!--td align='right'><b>Group Code:</b></td>
								<td>                        
									<input type="text" id="entryyear1" onkeyup="getRecordlist(this.id,'sessionstable','recordlist6');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist6');" size="45" />
								</td-->
							</tr>
							<!--tr>
								<td colspan='4'>
									<table  style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;font-size:10px;' width='100%'>
										<tr>
											<td style='color:white' align='center'><b>Left Signatory</b></td>
											<td style='color:white' align='center'><b>Mid Signatory</b></td>
											<td style='color:white' align='center'><b>Right Signatory</b></td>
										</tr>
										<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>
											<td>
												<b>Position:</b><input type="text" id="leftsigidA" readonly disabled="true" onkeyup="getRecordlist(this.id,'signatoriestable','siglistA');" onclick="this.value=''; getRecordlist(this.id,'signatoriestable','siglistA');" onblur="checkPosition(this.id);" size="25" />
											</td>
											<td>
												<b>Position:</b><input type="text" id="midsigidA" readonly  disabled="true" onkeyup="getRecordlist(this.id,'signatoriestable','siglistA');" onclick="this.value=''; getRecordlist(this.id,'signatoriestable','siglistA');" onblur="checkPosition(this.id);" size="25" />
											</td>
											<td>
												<b>Position:</b><input type="text" id="rightsigidA" readonly  disabled="true" onkeyup="getRecordlist(this.id,'signatoriestable','siglistA');" onclick="this.value=''; getRecordlist(this.id,'signatoriestable','siglistA');" onblur="checkPosition(this.id);" size="25" />
											</td>
										</tr>
										<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>
											<td>
												<b>&nbsp;&nbsp;&nbsp;&nbsp;Name:</b><input type="text" id="leftsignameA" readonly size="25" />
											</td>
											<td>
												<b>&nbsp;&nbsp;&nbsp;&nbsp;Name:</b><input type="text" id="midsignameA" readonly size="25" />
											</td>
											<td>
												<b>&nbsp;&nbsp;&nbsp;&nbsp;Name:</b><input type="text" id="rightsignameA" readonly size="25" />
												
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
							</tr-->
						</table>
						<div id='recordlist6'></div>
						<div id='siglistA'></div>
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
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	document.getElementById("facultycode2").value=readCookie("_facultys_");
	document.getElementById("departmentcode2").value=readCookie("_departments_");
	document.getElementById("programmecode2").value=readCookie("_programmes_");
	document.getElementById("studentlevel2").value=readCookie("_levels_");
	document.getElementById("sesions2").value=readCookie("_sessions_");
	document.getElementById("semester2").value=readCookie("_semesters_");
	document.getElementById("entryyear1").value=readCookie("_groupcode_");
</script>
