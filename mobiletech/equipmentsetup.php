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

                $("#equipmentslist").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Equipments List',
                    height: 430,
                    width: 710,
                    modal: false,
                    buttons: {
                        Add: function() {
							document.getElementById("equipmentcode").disabled = false;
                            resetForm("equipmentstable");
                            $('#equipmentsdetail').dialog('open');
                            $('#equipmentslist').dialog('close');
                        },
                        Close: function() {
                            $('#equipmentslist').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#equipmentsdetail").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'Equipments Details Setup - Items with RED colour labels are mandatory',
                    height: 430,
                    width: 710,
                    modal: false,
                    buttons: {
                        Save: function() {
                            updateEquipment("addRecord", "equipmentstable");
                        },
                        Update: function() {
                            updateEquipment("updateRecord", "equipmentstable");
                        },
                        New: function() {
                            resetForm("equipmentstable");
                        },
                        Close: function() {
                            $('#equipmentsdetail').dialog('close');
                            $('#equipmentslist').dialog('open');
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
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="equipmentslist" style="height:250px; width:700px; overflow:auto;"></div>
		<div id="equipmentsdetail">
			<table>
				<tr>
					<td align='right' style=" color: red"><b>Equipment Code:</b></td>
					<td colspan="2">
						<input type="text" id="equipmentcode" name="equipmentcode" size="30" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Equipment Name:</b></td>
					<td colspan="2">
						<input type="text" id="equipmentname" name="equipmentname" size="50" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Equipment Type:</b></td>
					<td colspan="2">
						<input type="text" id="equipmenttype" name="equipmenttype" size="30" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Equipment Description:</b></td>
					<td colspan="2">
						<textarea id="equipmentdescription" rows="3" cols="70"></textarea>
					</td>
				</tr>
			</table>
			<div id='recordlist'></div>
		</div>
    </body>
</html>
<script>
	getRecords('equipmentstable');
</script>