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
			createCookie("stockform","transfer",false);
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#stocktransfer").dialog({
                    autoOpen: true,
                    position:[280,70],
                    title: 'Stock Transfer',
                    height: 440,
                    width: 910,
                    modal: false,
                    buttons: {
                        Transfer: function() {
							doTransfer();
                        },
                        Close: function() {
                            $('#stocktransfer').dialog('close');
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
							window.location="home.php?pgid=0";
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
		<div id="stocktransfer">
			<table style="font-size:11px">
				<tr>
					<td align='right'><b>Origin_Location:</b></td>
					<td>
						<input type="text" id="locations1" name="locations1" style="display:inline" onkeyup="getRecordlist(this.id,'locationstable','recordlist2');" onclick="createCookie('getlocationStock','1',false); this.value=''; getRecordlist(this.id,'locationstable','recordlist2')" size="15" />					
					</td>
					<td align='right'><b>Target_Location:</b></td>
					<td>
						<input type="text" id="locations2" name="locations2" style="display:inline" onkeyup="getRecordlist(this.id,'locationstable','recordlist2');" onclick="createCookie('getlocationStock','1',false); this.value=''; getRecordlist(this.id,'locationstable','recordlist2')" size="15" />					
					</td>
				</tr>
				<tr>
					<td align='right'><b>Equipment_Category:</b></td>
					<td>
						<input type="text" id="equipmentcategory2" name="equipmentcategory2" style="display:inline" onkeyup="getRecordlist(this.id,'equipmentstable','recordlist2');" onclick="createCookie('getequipmentcategory','1',false); this.value=''; getRecordlist(this.id,'equipmentstable','recordlist2')" size="15" />					
					</td>
					<td align='right'><b>Transfer_Date:</b></td>
					<td>
						<input type="text" style="display:inline" id="transactiondate2"  name="transactiondate2" size="10" readonly disabled="true" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>Equipment_Code:</b></td>
					<td>
						<input type="text" id="equipmentcode2" name="equipmentcode2" style="display:inline" onkeyup="getRecordlist(this.id,'equipmentstable','recordlist2');" onclick="createCookie('getequipmentcode','equipmentcategory2',false); storeCategory('equipmentcategory2'); this.value=''; getRecordlist(this.id,'equipmentstable','recordlist2')" size="15" />
					</td>
					<td align='right'><b>Equipment_Name:</b></td>
					<td>
						<input type="text" id="equipmentname2" name="equipmentname2" readonly disabled="true" size="20" />
					</td>
				</tr>
				<tr>
					<td align='right'><b>Quantity_To_Transfer:</b></td>
					<td>
						<input type="text" id="quantityout2" name="quantityout2" size="25" style="text-align:right;" />
					</td>
					<td align='right'><b>Mac_Address:</b></td>
					<td>
						<textarea id="macaddress2" name="macaddress2" rows="2" cols="40"></textarea>
					</td>
				</tr>
				<tr>
					<td align='right'><b>Tranfered_By:</b></td>
					<td>
						<input type="text" style="display:inline" id="transferedby2"  name="transferedby2" size="30" readonly disabled="true" />
					</td>
					<td align='right'><b>Narration:</b></td>
					<td>
						<textarea id="narration2" name="narration2" rows="3" cols="40"></textarea>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div id='recordlist2'></div>
		</div>
    </body>
</html>
<script>
	var d = new Date();
	var month = d.getMonth()+1;
	var day  = "";
	var mon  = "";
	var year  = "";

	date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
	day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
	mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
	year = date_split[2];
	var today = day+"/"+mon+"/"+year;
	document.getElementById('transactiondate2').value=today;
	document.getElementById('transferedby2').value=readCookie('currentuser');
</script>
