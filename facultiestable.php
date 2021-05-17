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

                $("#faculty").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Schools Setup',
                    height: 440,
                    width: 710,
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
                            resetForm("facultiestable");
                        },
                        Close: function() {
                            $('#faculty').dialog('close');
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
                    <div style="font-size:65%; height:235px; width:415px; top:5px; left:10px" id="faculty">
						<table>
							<tr>
								<td><b>School:</b></td>
								<td>
									<input type="text" id="facultydescription" name="facultydescription" size="70" onblur="this.value=capitalize(this.value)" onclick="this.value=''; clearLists('recordlist1');"/>
								</td>
							</tr>

							<tr>
								<td><b>Director of School:</b></td>
								<td>
									<input type="text" id="dof" name="dof" size="50" /> <!--onkeyup="getRecordlist('dof','users','recordlist1');" onclick="clearLists('recordlist1'); getRecordlist('dof','users','recordlist1');" /-->
								</td>
							</tr>
						</table>
						<div id="facultylist" style="height:250px; overflow:auto;"></div>
						<div id="recordlist1" style="height:250px; max-width:300px; overflow:auto;"></div>
					</div>
                </td>
            </tr>
        </table>
    </body>
</html>
<script>
	getRecords('facultiestable');
</script>