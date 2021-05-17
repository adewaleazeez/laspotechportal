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

                $("#appraisalreport").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Appraisal Reports',
                    height: 440,
                    width: 860,
                    modal: false,
                    buttons: {
                        PDF: function() {
                            doAppraisalReport();
                        },
                        Close: function() {
                            $('#appraisalreport').dialog('close');
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
			/*function storeDepartment(department){
				createCookie("selectedept",document.getElementById(department).value,false);
			}

			function storeUserid(userid){
				createCookie("selecteuserid",document.getElementById(userid).value,false);
			}*/

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="appraisalreport">
			<table>
				<tr>
					<td>
						<b>Staff Id:</b>&nbsp;
						<input type="text" id="staffid" name="staffid" onkeyup="getRecordlist(this.id,'stafftable','recordlist2');" onclick="createCookie('getstaffB','1',false); getRecordlist(this.id,'stafftable','recordlist2');" size="15" />
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
				</tr>
				<tr>
					<td>
						<BR><INPUT type="radio" name="appraisallist" checked><b>Appraisal Summary List</b><BR><BR>
						<INPUT type="radio" name="appraisallist"><b>Appraisal Details List</b>
					</td>
				</tr>
			</table>
			<div id='recordlist2'></div>
		</div>
    </body>
</html>
