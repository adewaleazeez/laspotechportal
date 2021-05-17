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

                $("#programme").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Programmes Setup',
                    height: 500,
                    width: 700,
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
                            resetForm("programmestable");
                        },
                        Close: function() {
                            $('#programme').dialog('close');
							window.location="home.php?pgid=0";
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
                    <div style="font-size:65%; height:235px; width:415px; top:5px; left:10px" id="programme">
						<table>
							<tr>
								<td><b>School:</b></td>
								<td>
									<input type="text" id="facultycode" name="facultycode" size="70" onkeyup="getRecordlist('facultycode','facultiestable','recordlist3');" onclick="this.value=''; clearLists('recordlist3'); getRecordlist('facultycode','facultiestable','recordlist3');" />
								</td>
							</tr>

							<tr>
								<td><b>Department:</b></td>
								<td>
									<input type="text" id="departmentcode" name="departmentcode" size="70" onkeyup="getRecordlist('departmentcode','departmentstable','recordlist3');" onclick="this.value=''; clearLists('recordlist3'); getRecordlist('departmentcode','departmentstable','recordlist3');" />
								</td>
							</tr>

							<tr>
								<td><b>Programme:</b></td>
								<td>
									<input type="text" id="programmedescription" name="programmedescription" size="70" onblur="this.value=capitalize(this.value)" onclick="this.value=''; clearLists('recordlist3'); getRecordlist(this.id,'qualificationstable','recordlist3');"/>
								</td>
							</tr>

							<tr>
								<td><b>Course Advisor:</b></td>
								<td>
									<input type="text" id="courseadvisor" name="courseadvisor" size="50" /> <!--onkeyup="getRecordlist('courseadvisor','users','recordlist3');" onclick="clearLists('recordlist3'); getRecordlist('courseadvisor','users','recordlist3');" /-->
								</td>
							</tr>
						</table>
						<div id="programmelist" style="height:250px; overflow:auto;"></div>
						<div id="recordlist3" style="height:250px; max-width:300px; overflow:auto;"></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	getRecords('programmestable');
</script>