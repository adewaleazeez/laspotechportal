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
		<!--link rel="stylesheet" href="css/main.css" media="screen"-->
		<link rel="stylesheet" href="css/style.css" media="screen">
		<link rel="stylesheet" href="css/colors.css" media="screen">

        <script type="text/javascript">
            checkLogin();
        </script>
        <script type="text/javascript">
			createCookie("stockform","approval",false);
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#stocklist").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Stocks List - Approval Form',
                    height: 430,
                    width: 1000,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#stocklist').dialog('close');
							window.location="home.php?pgid=0";
                        }
                    }
                });

                $("#stockapprovalupdate").dialog({
                    autoOpen: false,
                    position:[280,70],
                    title: 'Stock Requisition Approval',
                    height: 440,
                    width: 710,
                    modal: false,
                    buttons: {
                        Approve: function() {
							var locations = document.getElementById('locations2').value;
							var equipmentcode = document.getElementById('equipmentcode2').value;
                            getStockBalance(locations, equipmentcode);
                        },
                        Clear: function() {
							document.getElementById('quantityout2').value ='';
							document.getElementById('narration2').value ='';
                        },
                        Close: function() {
                            $('#stockapprovalupdate').dialog('close');
                            $('#stocklist').dialog('open');
							getStocks();
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

			function storeCategory(category){
				createCookie("selectecategory",document.getElementById(category).value,false);
			}

        </script>
    </head>
    <body>
		<div id="showError"></div>
		<div id="showAlert"></div>
		<div id="showPrompt"></div>
		<div id="stocklist" style="font-size:11px">
			<table>
				<tr>
					<td>
						<b>Location:</b>&nbsp;<BR><input type="text" id="locationA" name="locationA" style="display:inline" onkeyup="getRecordlist(this.id,'locationstable','recordlist2');" onclick="createCookie('getlocationStock','1',false); this.value=''; getRecordlist(this.id,'locationstable','recordlist2')" size="15" />
					</td>
					<td>
						<b>Equipment-Category:</b>&nbsp;<BR><input type="text" id="equipmentcategoryA" name="equipmentcategoryA" style="display:inline" onkeyup="getRecordlist(this.id,'equipmentstable','recordlist2');" onclick="createCookie('getequipmentcategory','1',false); this.value=''; getRecordlist(this.id,'equipmentstable','recordlist2')" size="15" />
					</td>
					<td>
						<b>Equipment-Code:</b>&nbsp;<BR><input type="text" id="equipmentcodeA" name="equipmentcodeA" style="display:inline" onkeyup="getRecordlist(this.id,'equipmentstable','recordlist2');" onclick="createCookie('getequipmentcode','1',false); storeCategory('equipmentcategoryA'); this.value=''; getRecordlist(this.id,'equipmentstable','recordlist2')" size="15" />
					</td>
					<td>
						<b>Start_Date:</b>&nbsp;<BR><input type="text" style="display:inline" id="start_dateA"  name="start_dateA" size="10"  onclick="createCookie('getStocks','1',false); displayDatePicker('start_dateA', false, 'dmy', '/');" />
						<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getStocks','1',false); displayDatePicker('start_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					</td>
					<td>
						<b>End_Date:</b>&nbsp;<BR><input type="text" style="display:inline" id="end_dateA"  name="end_dateA" size="10"  onclick="createCookie('getStocks','1',false); displayDatePicker('end_dateA', false, 'dmy', '/');" />
						<a title="Click here for calendar" style=" background-color: #663399; background-image: url('images/calendar.gif');" href="javascript: createCookie('getStocks','1',false); displayDatePicker('end_dateA', false, 'dmy', '/');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div id='recordlist2'></div>
			<div id='stockslist'></div>
		</div>
		<div id="stockapprovalupdate">
			<table style="font-size:11px">
				<tr>
					<td align='right' style=" color: red"><b>Location:</b></td>
					<td>
						<input type="text" id="locations2" name="locations2" readonly disabled="true" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Equipment Category:</b></td>
					<td>
						<input type="text" id="equipmentcategory2" name="equipmentcategory2" readonly disabled="true" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Equipment Code:</b></td>
					<td>
						<input type="text" id="equipmentcode2" name="equipmentcode2" readonly disabled="true" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Equipment Name:</b></td>
					<td>
						<input type="text" id="equipmentname2" name="equipmentname2" readonly disabled="true" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Transaction Date:</b></td>
					<td>
						<input type="text" style="display:inline" id="transactiondate2"  name="transactiondate2" size="10" readonly disabled="true" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Approved By:</b></td>
					<td>
						<input type="hidden" id="requestedby2"  name="requestedby2" />
						<input type="hidden" id="lockrec"  name="lockrec" />
						<input type="text" style="display:inline" id="approvedby2"  name="approvedby2" size="30" readonly disabled="true" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Mac Address:</b></td>
					<td>
						<textarea id="macaddress2" name="macaddress2" rows="2" cols="70"></textarea>
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Quantity:</b></td>
					<td>
						<input type="text" id="quantityout2" name="quantityout2" size="25" style="text-align:right;" />
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Narration:</b></td>
					<td>
						<textarea id="narration2" name="narration2" rows="3" cols="70"></textarea>
					</td>
				</tr>
				<tr>
					<td align='right' style=" color: red"><b>Transaction Status:</b></td>
					<td colspan="2">
						<select id="transtatus">
							<option>Pending</option>
							<option>Denied</option>
							<option>Approved</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
    </body>
</html>
<script>
	getStocks();
</script>
