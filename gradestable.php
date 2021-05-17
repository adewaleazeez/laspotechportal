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

                $("#gradestable").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Examination Grades Setup',
                    height: 440,
                    width: 1010,
                    modal: false,
                    buttons: {
                        Copy_From_Previous_Session: function() {
                            CopyGradeFromPreviousSession();
                        },
                        Close: function() {
                            $('#gradestable').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#copygradestable").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Copy Examination Grades',
                    height: 440,
                    width: 910,
                    modal: false,
                    buttons: {
                        Paste_To_Current_Session: function() {
                            PasteGradeToCurrentSession();
                        },
                        Close: function() {
                            $('#copygradestable').dialog('close');
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
        </script>
    </head>
    <body>
        <table width="100%">
            <div id="showError"></div>
            <div id="showAlert"></div>
            <div id="showPrompt"></div>
            <tr>
                <td>
                    <div style="font-size:85%;" id="gradestable">
						<table>
							<tr>
								<td align="right"><b>Qualification:</b></td>
								<td>
									<input type="text" id="qualification" style="display:inline" onkeyup="getRecordlist(this.id,'qualificationstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'qualificationstable','recordlist')" size="30" />
								</td>
								<td align="right"><b>Session:</b></td>
								<td>
									<input type="text" id="sesions"  onkeyup="getRecordlist(this.id,'sessionstable','recordlist');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlist')" size="10" />
								</td>
								<td>
									<input type="button" style="display:inline" id="populategrades" onclick="createCookie('ordersort','ASC',false); populateGrade('gradecode')" value="List Records" />
								</td>
							</tr>
						</table>
						<div id="gradeslist" style="font-size:85%; overflow:auto;"></div>
						<div id="recordlist" style="overflow:auto; height:300px; width:200px; "></div>
					</div>
                    <div style="font-size:85%;" id="copygradestable">
						<table>
							<tr>
								<td align="right"><b>Qualification:</b></td>
								<td>
									<input type="text" id="qualificationB" style="display:inline" onkeyup="getRecordlist(this.id,'qualificationstable','recordlistB');" onclick="this.value=''; getRecordlist(this.id,'qualificationstable','recordlistB')" size="30" />
								</td>
								<td align="right"><b>Session:</b></td>
								<td>
									<input type="text" id="sesionsB"  onkeyup="getRecordlist(this.id,'sessionstable','recordlistB');" onclick="this.value=''; getRecordlist(this.id,'sessionstable','recordlistB')" size="10" />
								</td>
								<td>
									<input type="button" style="display:inline" id="populategradesB" onclick="createCookie('ordersort','ASC',false); populateCopyGrade('gradecode')" value="List Records" />
								</td>
							</tr>
						</table>
						<div id="gradeslistB" style="font-size:85%; overflow:auto;"></div>
						<div id="recordlistB" style="overflow:auto; height:300px; width:200px; "></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	document.getElementById("qualification").value=readCookie("_gradequlification_");
	document.getElementById("sesions").value=readCookie("_gradesession_");

	document.getElementById("qualificationB").value=readCookie("_gradequlification_");
	document.getElementById("sesionsB").value=readCookie("_gradesession_");
</script>
