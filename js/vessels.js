/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var curr_obj = null;
var curr_table = null;
var temp_table = "";
var temp_serialno = 0;
var curr_obj=null;
var curr_object=null;
var list_obj=null;

function checkAccess(access, menuoption){
	createCookie("access",access,false);
    var arg = "&currentuser="+readCookie("currentuser")+"&menu="+menuoption;
    var url = "/laspotechportal/userbackend.php?option=checkAccess"+arg;
    AjaxFunctionVessel(url);
}

function vesselReport(option){
	var arrivaldate1 = document.getElementById('arrivaldate1').value;
	var arrivaldate2 = document.getElementById('arrivaldate2').value;
	var departuredate1 = document.getElementById('departuredate1').value;
	var departuredate2 = document.getElementById('departuredate2').value;
	var bertheddate1 = document.getElementById('bertheddate1').value;
	var bertheddate2 = document.getElementById('bertheddate2').value;
	var completiondate1 = document.getElementById('completiondate1').value;
	var completiondate2 = document.getElementById('completiondate2').value;
	var productcode2 = document.getElementById('productcode2').value;
	var portcode2 = document.getElementById('portcode2').value;
	var jettycode2 = document.getElementById('jettycode2').value;
	var vesselcode2 = document.getElementById('vesselcode2').value;
	var operation2 = document.getElementById('operation2').value;
	var charterercode2 = document.getElementById('charterercode2').value;
	var agentcode2 = document.getElementById('agentcode2').value;
	var receivercode2 = document.getElementById('receivercode2').value;

	arrivaldate1 = arrivaldate1.substr(6,4)+'-'+arrivaldate1.substr(3,2)+'-'+arrivaldate1.substr(0,2);
	arrivaldate2 = arrivaldate2.substr(6,4)+'-'+arrivaldate2.substr(3,2)+'-'+arrivaldate2.substr(0,2);
	departuredate1 = departuredate1.substr(6,4)+'-'+departuredate1.substr(3,2)+'-'+departuredate1.substr(0,2);
	departuredate2 = departuredate2.substr(6,4)+'-'+departuredate2.substr(3,2)+'-'+departuredate2.substr(0,2);
	bertheddate1 = bertheddate1.substr(6,4)+'-'+bertheddate1.substr(3,2)+'-'+bertheddate1.substr(0,2);
	bertheddate2 = bertheddate2.substr(6,4)+'-'+bertheddate2.substr(3,2)+'-'+bertheddate2.substr(0,2);
	completiondate1 = completiondate1.substr(6,4)+'-'+completiondate1.substr(3,2)+'-'+completiondate1.substr(0,2);
	completiondate2 = completiondate2.substr(6,4)+'-'+completiondate2.substr(3,2)+'-'+completiondate2.substr(0,2);

	var param = "?option="+option+"&arrivaldate1="+arrivaldate1+"&arrivaldate2="+arrivaldate2;
	param +="&departuredate1="+departuredate1+"&departuredate2="+departuredate2+"&bertheddate1="+bertheddate1;
	param +="&bertheddate2="+bertheddate2+"&completiondate1="+completiondate1+"&completiondate2="+completiondate2;
	param +="&productcode2="+productcode2+"&portcode2="+portcode2+"&jettycode2="+jettycode2+"&vesselcode2="+vesselcode2;
	param +="&operation2="+operation2+"&charterercode2="+charterercode2+"&agentcode2="+agentcode2+"&receivercode2="+receivercode2;

	var oWin = null;
	if(option=="excel"){
		oWin = window.open("vesselsreportexcel.php"+param, "_blank", "directories=0,scrollbars=1,resizable=0,location=0,status=0,toolbar=0,menubar=0,width=1000,height=600,left=10,top=70");
	}else{
		oWin = window.open("vesselsreportdisplay.php"+param, "_blank", "directories=0,scrollbars=1,resizable=0,location=0,status=0,toolbar=0,menubar=0,width=1000,height=600,left=10,top=70");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
		alert("Popup must be enabled on this browser to see the report");
	}
}

function getCode(id){
	var id2 = id+"2";
	if(!document.getElementById(id2).value.match(document.getElementById(id).value)){
		document.getElementById(id2).value += document.getElementById(id).value + " ";
	}
	document.getElementById(id).value = "";
}

function getRecordlist(code,list){
	curr_object = code;
	curr_obj = document.getElementById(code);
    list_obj = 'recordlist';
    if(list!=null) list_obj = list;
    clearLists(list_obj);
	var table = "";
    if(code=='productcode' || code=='productcode1') table = 'product';
    if(code=='portcode') table = 'port';
    if(code=='jettycode') table = 'jetty';
    if(code=='vesselcode') table = 'vessel';
    if(code=='operation') table = 'operation';
    if(code=='charterercode') table = 'charterer';
    if(code=='agentcode') table = 'agent';
    if(code=='receivercode') table = 'receiver';
    curr_table = table;
    var url = "/laspotechportal/vesselsbackend.php?option=getRecordlist&table="+table;
    AjaxFunctionVessel(url);
}

function updateTransaction(option){
    var quantity = document.getElementById("quantity").value;
    var charterercode = document.getElementById("charterercode").value;
    var agentcode = document.getElementById("agentcode").value;
    var receivercode = document.getElementById("receivercode").value;
    var productcode = document.getElementById("productcode").value;
    var portcode = document.getElementById("portcode").value;
    var jettycode = document.getElementById("jettycode").value;
    var vesselcode = document.getElementById("vesselcode").value;
    var arrivaldate = document.getElementById("arrivaldate").value;
    var departuredate = document.getElementById("departuredate").value;
    var bertheddate = document.getElementById("bertheddate").value;
    var completiondate = document.getElementById("completiondate").value;
    var operation = document.getElementById("operation").value;
    var eta = document.getElementById("eta").value;
    var etb = document.getElementById("etb").value;
    var ets = document.getElementById("ets").value;

	var error = "";
    if (quantity=="") error += "Quantity must not be blank.<br><br>";
    if (charterercode=="") error += "Charterer must not be blank.<br><br>";
    if (agentcode=="") error += "Agent must not be blank.<br><br>";
    if (productcode=="") error += "Product must not be blank.<br><br>";
    if (portcode=="") error += "Port must not be blank.<br><br>";
    if (jettycode=="") error += "Jetty must not be blank.<br><br>";
    if (vesselcode=="") error += "Vessel must not be blank.<br><br>";
    if (arrivaldate=="") error += "Arrival date must not be blank.<br><br>";
    if (departuredate=="") error += "Departure date must not be blank.<br><br>";
    if (bertheddate=="") error += "Berthed date must not be blank.<br><br>";
    if (operation=="") error += "Type of operation must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
	arrivaldate = arrivaldate.substr(6,4)+'-'+arrivaldate.substr(3,2)+'-'+arrivaldate.substr(0,2);
	departuredate = departuredate.substr(6,4)+'-'+departuredate.substr(3,2)+'-'+departuredate.substr(0,2);
	bertheddate = bertheddate.substr(6,4)+'-'+bertheddate.substr(3,2)+'-'+bertheddate.substr(0,2);
	completiondate = completiondate.substr(6,4)+'-'+completiondate.substr(3,2)+'-'+completiondate.substr(0,2);
	
	temp_table = "vessels";
    
	var param = "&serialno="+serialno+"&quantity="+quantity+"&charterercode="+charterercode+"&agentcode="+agentcode;
    param += "&receivercode="+receivercode+"&productcode="+productcode+"&portcode="+portcode+"&jettycode="+jettycode;
    param += "&vesselcode="+vesselcode+"&arrivaldate="+arrivaldate+"&departuredate="+departuredate+"&bertheddate="+bertheddate;
    param += "&completiondate="+completiondate+"&operation="+operation+"&eta="+eta+"&etb="+etb+"&ets="+ets;
    var url = "/laspotechportal/vesselsbackend.php?option="+option+"&table=vessels"+param;
    AjaxFunctionVessel(url);
}

function getRecords(table,flg){
	temp_table = table;
    if(table!='vessels') $('#menuList').dialog('close');
    if(table=='product') $('product').dialog('open');
    if(table=='jetty') $('jetty').dialog('open');
    if(table=='port') $('port').dialog('open');
    if(table=='vessel') $('vessel').dialog('open');
    if(table=='operation') $('operation').dialog('open');
    if(table=='charterer') $('charterer').dialog('open');
    if(table=='agent') $('#agent').dialog('open');
    if(table=='receiver') $('receiver').dialog('open');
    
	if(table=='vessels'){
        var d = new Date();
        var month = d.getMonth()+1;
        var day  = "";
        var mon  = "";
        var year  = "";

        if(fromdate == null || fromdate.trim().length == 0){
            while((d.getMonth()+1) == month){
                d.setDate(d.getDate()-1);
            }
            d.setDate(d.getDate()+1);
            date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
            day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
            mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
            year = date_split[2];
            fromdate = day+"/"+mon+"/"+year;
        }

        if(todate == null || todate.trim().length == 0){
            while((d.getMonth()+1) == month){
                d.setDate(d.getDate()+1);
            }
            d.setDate(d.getDate()-1);
			//d = new Date();
            date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
            day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
            mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
            year = date_split[2];
            todate = day+"/"+mon+"/"+year;
        }
		createCookie("fromdate",fromdate,false);
		createCookie("todate",todate,false);
		fromdate = fromdate.substr(6,4)+'-'+fromdate.substr(3,2)+'-'+fromdate.substr(0,2);
		todate = todate.substr(6,4)+'-'+todate.substr(3,2)+'-'+todate.substr(0,2);
		table = "vessels&fromdate="+fromdate+"&todate="+todate;
	}
    
	if(table=='filterbutton'){
	    var fromdate = document.getElementById("fromdate").value;
		var todate = document.getElementById("todate").value;
		createCookie("fromdate",fromdate,false);
		createCookie("todate",todate,false);
		fromdate = fromdate.substr(6,4)+'-'+fromdate.substr(3,2)+'-'+fromdate.substr(0,2);
		todate = todate.substr(6,4)+'-'+todate.substr(3,2)+'-'+todate.substr(0,2);
		table = "vessels&fromdate="+fromdate+"&todate="+todate;
	}
	if(flg == null || flg == 'undefined'){
		var productcode1 = document.getElementById("productcode1").value;
		table +="&productcode1="+productcode1;
	}
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your records.";
    $('#showAlert').dialog('open');
    var url = "/laspotechportal/vesselsbackend.php?option=getAllRecs"+"&table="+table;
    AjaxFunctionVessel(url);
    
}


function addRec(operation, table, param){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your records.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    param += "&serialno="+serialno;
    var url = "/laspotechportal/vesselsbackend.php?option="+operation+"&table="+table+param;
    AjaxFunctionVessel(url);
}

function clearLists(list_obj){
	if(list_obj == null) list_obj = "codelist";
    document.getElementById(list_obj).innerHTML = "";
}

function populateRecords(serialno, table){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
	createCookie("serialno",serialno,false);
    var url = "/laspotechportal/vesselsbackend.php?option=getARecord"+"&table="+table+"&serialno="+serialno;
    AjaxFunctionVessel(url);
}

function populateCode(code){
    curr_obj.value = code;
    clearLists(list_obj);
	if(list_obj=="codelist"){
		getCode(curr_object);
	}
}

function getAllRecords(){
    var url = "/laspotechportal/vesselsbackend.php?option=getAllRecords";
    AjaxFunctionVessel(url);
}

function resetVesselForm(){
    document.getElementById("productcode").value="";
    document.getElementById("arrivaldate").value="";
    document.getElementById("departuredate").value="";
    document.getElementById("bertheddate").value="";
    document.getElementById("completiondate").value="";
    document.getElementById("portcode").value="";
    document.getElementById("jettycode").value="";
    document.getElementById("operation").value="";
    document.getElementById("charterercode").value="";
    document.getElementById("agentcode").value="";
    document.getElementById("receivercode").value="";
    document.getElementById("vesselcode").value="";
    document.getElementById("quantity").value="";
    document.getElementById("eta").value="";
    document.getElementById("etb").value="";
    document.getElementById("ets").value="";
    getRecords(temp_table,'0');
}

function resetForm(arg){
    document.getElementById("productcode").value="";
    document.getElementById("productname").value="";
    document.getElementById("portcode").value="";
    document.getElementById("portname").value="";
    document.getElementById("jettycode").value="";
    document.getElementById("jettyname").value="";
    document.getElementById("vesselcode").value="";
    document.getElementById("vesselname").value="";
    document.getElementById("operationcode").value="";
    document.getElementById("operationname").value="";
    document.getElementById("charterercode").value="";
    document.getElementById("charterername").value="";
    document.getElementById("chartereraddress").value="";
    document.getElementById("charterercontactno").value="";
    document.getElementById("agentcode").value="";
    document.getElementById("agentname").value="";
    document.getElementById("agentaddress").value="";
    document.getElementById("agentcontactno").value="";
    document.getElementById("receivercode").value="";
    document.getElementById("receivername").value="";
    document.getElementById("receiveraddress").value="";
    document.getElementById("receivercontactno").value="";
    getRecords(temp_table,'0');
}

function toDate(){
    displayDatePicker('todate', false, 'dmy', '/');
}

function fromToDate(){
    displayDatePicker('fromdate', false, 'dmy', '/');
}

var xmlhttp

function AjaxFunctionVessel(arg){
    xmlhttp=GetXmlHttpObject();
    if(xmlhttp == null){
        alert ("Your browser does not support XMLHTTP!");
        return true;
    }

    var timestamp = new Date().getTime();
    var url = arg+"&timestamp="+timestamp;

    xmlhttp.onreadystatechange=stateChangedSetup;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
    
}

var temp_resp="";
function stateChangedSetup(){
    if (xmlhttp.readyState==4){
        var resp = xmlhttp.responseText;
        var break_resp = "";
        $('#showAlert').dialog('close');
        if(resp.match("getAllRecs")){
            break_resp = resp.split("getAllRecs");
            var allrecords = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;max-width:700px;background-color:#6666FF;margin-top:5px;'>";
            allrecords += "<tr style='font-weight:bold; color:white'>";
            if(break_resp[0]=="charterer" || break_resp[0] == "agent" || break_resp[0] == "receiver"){
                allrecords += "<td width='5%'>S/No</td><td width='10%'>Codes</td><td width='15%'>Names</td><td width='30%'>Address</td><td width='20%'>Contact No</td></tr>";
            }else if(break_resp[0]=="vessels"){
                allrecords = "<table border='0' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;max-width:650px;background-color:#6666FF;margin-top:5px;'>";
	            allrecords += "<tr style='font-weight:bold; color:white'>";
		        allrecords += "<td width='150px'>Filter by Arrival Date:</td><td width='50px' align='right'>From:</td>";
				allrecords += "<td align='left'><input type='text' onclick='fromToDate()' id='fromdate' name='fromdate' size='10' class='textField' /></td>";
			    allrecords += "<td width='40px' align='right'>To:</td><td width='100px' align='left'><input type='text' onclick='toDate()' id='todate' name='todate' size='10' class='textField' /></td>";
				allrecords += "<td width='50px' align='right'><b>Product:</b></td>";
				allrecords += "<td width='150px' align='left'><input type='text' id='productcode1' onkeyup='getRecordlist(this.id)' onfocus='getRecordlist(this.id)' size='20' /></td>";
				allrecords += "<td><input type='button' id='filterbutton' onclick='getRecords(this.id)' value='Filter' /></td></tr></table>";
                allrecords += "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;max-width:700px;background-color:#6666FF;margin-top:5px;'>";
				allrecords += "<tr style='font-weight:bold; color:white'>";
                allrecords += "<td>S/No</td><td>Product</td><td>Arrival</td><td>Departure</td><td>Berth</td><td>Completion</td><td>Port</td><td>Jetty</td><td>Operation</td><td>Chaterer</td><td>Agent</td><td>Receiver</td><td>Vessel</td><td align='right'>Quantity</td><td>ETA</td><td>ETB</td><td>ETS</td></tr>";
            }else{
                allrecords += "<td width='5%'>S/No</td><td width='10%'>Codes</td><td width='15%'>Names</td></tr>";
            }

            var recordlist = null;
            if(break_resp[0]=="product"){
				$('#product').dialog('open');
				recordlist = document.getElementById('productlist');
			}
            if(break_resp[0]=="jetty"){
				$('#jetty').dialog('open');
				recordlist = document.getElementById('jettylist');
			}
            if(break_resp[0]=="port"){
				$('#port').dialog('open');
				recordlist = document.getElementById('portlist');
			}
            if(break_resp[0]=="vessel"){
				$('#vessel').dialog('open');
				recordlist = document.getElementById('vessellist');
			}
            if(break_resp[0]=="operation"){
				$('#operation').dialog('open');
				recordlist = document.getElementById('operationlist');
			}
            if(break_resp[0]=="charterer"){
				$('#charterer').dialog('open');
				recordlist = document.getElementById('chartererlist');
			}
            if(break_resp[0]=="agent"){
				$('#agent').dialog('open');
				recordlist = document.getElementById('agentlist');
			}
            if(break_resp[0]=="receiver"){
				$('#receiver').dialog('open');
				recordlist = document.getElementById('receiverlist');
			}
            if(break_resp[0]=="vessels"){
				recordlist = document.getElementById('vesselslist');
			}
            var counter = 0;
            var rsp = "";
            var flg = 0;
            var break_row = "";
            for(var i=1; i < (break_resp.length-1); i++){
                if(temp_table == break_resp[i].trim()) {
                    continue;
                }
                break_row = break_resp[i].split("_~_");
				if(break_resp[0]=="vessels"){
					break_row[2] = break_row[2].substr(8,2)+'/'+break_row[2].substr(5,2)+'/'+break_row[2].substr(0,4);
					break_row[3] = break_row[3].substr(8,2)+'/'+break_row[3].substr(5,2)+'/'+break_row[3].substr(0,4);
					break_row[4] = break_row[4].substr(8,2)+'/'+break_row[4].substr(5,2)+'/'+break_row[4].substr(0,4);
					break_row[5] = break_row[5].substr(8,2)+'/'+break_row[5].substr(5,2)+'/'+break_row[5].substr(0,4);
				}
                if (flg == 1) {
                    flg = 0;
                    rsp += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
                    rsp += "<td align='right'>" + (++counter) + ".</td>";
                    rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[1] + "</a></td>";
                    rsp += "<td>" + break_row[2] + "</td>";
					if(break_resp[0]=="charterer" || break_resp[0] == "agent" || break_resp[0] == "receiver"){
						rsp += "<td>" + break_row[3] + "</td><td>" + break_row[4] + "</td>";
					}
					if(break_resp[0]=="vessels"){
						rsp += "<td>" + break_row[3] + "</td><td>" + break_row[4] + "</td>";
						rsp += "<td>" + break_row[5] + "</td><td>" + break_row[6] + "</td>";
						rsp += "<td>" + break_row[7] + "</td><td>" + break_row[8] + "</td>";
						rsp += "<td>" + break_row[9] + "</td><td>" + break_row[10] + "</td>";
						rsp += "<td>" + break_row[11] + "</td><td>" + break_row[12] + "</td>";
						rsp += "<td align='right'>" + numberFormat(break_row[13]) + "</td>";
						rsp += "<td>" + break_row[14] + "</td><td>" + break_row[15] + "</td><td>" + break_row[16] + "</td>";
					}
					rsp += "</tr>";
                } else {
                    flg = 1;
                    rsp += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
                    rsp += "<td align='right'>" + (++counter) + ".</td>";
                    rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[1] + "</a></td>";
                    rsp += "<td>" + break_row[2] + "</td>";
					if(break_resp[0]=="charterer" || break_resp[0] == "agent" || break_resp[0] == "receiver"){
						rsp += "<td>" + break_row[3] + "</td><td>" + break_row[4] + "</td>";
					}
					if(break_resp[0]=="vessels"){
						rsp += "<td>" + break_row[3] + "</td><td>" + break_row[4] + "</td>";
						rsp += "<td>" + break_row[5] + "</td><td>" + break_row[6] + "</td>";
						rsp += "<td>" + break_row[7] + "</td><td>" + break_row[8] + "</td>";
						rsp += "<td>" + break_row[9] + "</td><td>" + break_row[10] + "</td>";
						rsp += "<td>" + break_row[11] + "</td><td>" + break_row[12] + "</td>";
						rsp += "<td align='right'>" + numberFormat(break_row[13]) + "</td>";
						rsp += "<td>" + break_row[14] + "</td><td>" + break_row[15] + "</td><td>" + break_row[16] + "</td>";
					}
					rsp += "</tr>";
                }
            }
            recordlist.innerHTML = allrecords+rsp+"</table>";
			if(readCookie("fromdate") !=null){
				document.getElementById("fromdate").value=readCookie("fromdate");
				document.getElementById("todate").value=readCookie("todate");
			}
        }

        if(resp.match("getRecordlist")){
            var keyword = curr_obj.value;
            var allCodes = resp.split("getRecordlist");
            var inner_codeslist = "";
            if(navigator.appName == "Microsoft Internet Explorer"){
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:30%;background-color:#6666FF;margin-top:5px;'>";
            }else{
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
            }
            inner_codeslist += "<tr style='font-weight:bold; color:white'>";
            inner_codeslist += "<td>S/No</td><td>Codes</td><td>Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td align='right'><a title='Close' style='font-weight:bold; font-size:20px; color:white;background-color:red;' href=javascript:clearLists()>X</a></td></tr>";

            var codeslist = document.getElementById(list_obj);
            codeslist.style.zIndex = 100;
            codeslist.style.position = "absolute";

            if(navigator.appName=="Microsoft Internet Explorer"){
                codeslist.style.top = '200px';
                codeslist.style.left ='200px';
                codeslist.style.top = (findPosY(curr_obj) - 52 + curr_obj.clientHeight) + 'px';
                codeslist.style.left = (findPosX(curr_obj) - 340) + 'px';
            }else{
                codeslist.style.top = ($(curr_obj).position().top + 23) + 'px';
                codeslist.style.left = ($(curr_obj).position().left) + 'px';
            }

            var token = "";
            var colorflag = 0;
			var count=0;
            var k=0;
            if(keyword.trim().length==0){
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0){
                        token = allCodes[k].split("_~_");
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;'><td align='right'>"+(++count)+".</td><td><a href=javascript:populateCode('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'><td align='right'>"+(++count)+".</td><td><a href=javascript:populateCode('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
                        }
                    }
                }
            } else {
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0 && (allCodes[k].toUpperCase().match(keyword.toUpperCase()))){
                        token = allCodes[k].split("_~_");
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;'><td align='right'>"+(++count)+".</td><td><a href=javascript:populateCode('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'><td align='right'>"+(++count)+".</td><td><a href=javascript:populateCode('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
                        }
                    }
                }
            }
            inner_codeslist += "</table>";
            codeslist.style.zIndex = 100;
            codeslist.innerHTML = "";
            codeslist.innerHTML = inner_codeslist;
            return true;
        }

        if(resp.match("getARecord")){
            break_row = resp.split("getARecord");
            break_resp = break_row[0].split("_~_");
            createCookie("serialno",break_resp[1],false)
            if(break_resp[0]=="product"){
                document.getElementById("productcode").value = break_resp[2];
                document.getElementById("productname").value = break_resp[3];
            }
            if(break_resp[0]=="port"){
                document.getElementById("portcode").value = break_resp[2];
                document.getElementById("portname").value = break_resp[3];
            }
            if(break_resp[0]=="jetty"){
                document.getElementById("jettycode").value = break_resp[2];
                document.getElementById("jettyname").value = break_resp[3];
            }
            if(break_resp[0]=="vessel"){
                document.getElementById("vesselcode").value = break_resp[2];
                document.getElementById("vesselname").value = break_resp[3];
            }
            if(break_resp[0]=="operation"){
                document.getElementById("operationcode").value = break_resp[2];
                document.getElementById("operationname").value = break_resp[3];
            }
            if(break_resp[0]=="charterer"){
                document.getElementById("charterercode").value = break_resp[2];
                document.getElementById("charterername").value = break_resp[3];
                document.getElementById("chartereraddress").value = break_resp[4];
                document.getElementById("charterercontactno").value = break_resp[5];
            }
            if(break_resp[0]=="agent"){
                document.getElementById("agentcode").value = break_resp[2];
                document.getElementById("agentname").value = break_resp[3];
                document.getElementById("agentaddress").value = break_resp[4];
                document.getElementById("agentcontactno").value = break_resp[5];
            }
            if(break_resp[0]=="receiver"){
                document.getElementById("receivercode").value = break_resp[2];
                document.getElementById("receivername").value = break_resp[3];
                document.getElementById("receiveraddress").value = break_resp[4];
                document.getElementById("receivercontactno").value = break_resp[5];
            }
            if(break_resp[0]=="vessels"){
                document.getElementById("productcode").value = break_resp[2];
                document.getElementById("arrivaldate").value = break_resp[3].substr(8,2)+'/'+break_resp[3].substr(5,2)+'/'+break_resp[3].substr(0,4);
                document.getElementById("departuredate").value = break_resp[4].substr(8,2)+'/'+break_resp[4].substr(5,2)+'/'+break_resp[4].substr(0,4);
                document.getElementById("bertheddate").value = break_resp[5].substr(8,2)+'/'+break_resp[5].substr(5,2)+'/'+break_resp[5].substr(0,4);
                document.getElementById("completiondate").value = break_resp[6].substr(8,2)+'/'+break_resp[6].substr(5,2)+'/'+break_resp[6].substr(0,4);
                document.getElementById("portcode").value = break_resp[7];
                document.getElementById("jettycode").value = break_resp[8];
                document.getElementById("operation").value = break_resp[9];
                document.getElementById("charterercode").value = break_resp[10];
                document.getElementById("agentcode").value = break_resp[11];
                document.getElementById("receivercode").value = break_resp[12];
                document.getElementById("vesselcode").value = break_resp[13];
                document.getElementById("quantity").value = numberFormat(break_resp[14]);
                document.getElementById("eta").value = break_resp[15];
                document.getElementById("etb").value = break_resp[16];
                document.getElementById("ets").value = break_resp[17];
            }
            return true;
        }

        if(resp.match("checkAccess")){
            if(resp.match("checkAccessSuccess")){
				if(readCookie("access")=="vesselsentry"){
					window.location = "vessels.php";
				}else if(readCookie("access")=="vesselsreport"){
					
					window.location = "vessels_report.php";
				}else{
					getRecords(readCookie("access"),'0');
				}
            }else{
                break_resp = resp.split("checkAccessFailed");
                resp = "<b>Access Denied!!!</b><br><br>Menu ["+break_resp[1]+"] not accessible by "+readCookie("currentuser");
                document.getElementById("showPrompt").innerHTML = resp;
                $('#showPrompt').dialog('open');
            }
            return true;
        }

        if(resp.match("added")){
            document.getElementById("showPrompt").innerHTML = "<b>Record Added!!!</b><br><br>Your record was successfully added.";
            $('#showPrompt').dialog('open');
			if(temp_table == "vessels"){
				resetVesselForm();
			}else{
	            resetForm(temp_table);
			}
            return true;
        }

        if(resp.match("updated")){
            document.getElementById("showPrompt").innerHTML = "<b>Record Updated!!!</b><br><br>Your record was successfully updated.";
            $('#showPrompt').dialog('open');
			if(temp_table == "vessels"){
				resetVesselForm();
			}else{
	            resetForm(temp_table);
			}
            return true;
        }

        if(resp.match("deleted")){
            document.getElementById("showPrompt").innerHTML = "<b>Record Deleted!!!</b><br><br>Your record was successfully deleted.";
            $('#showPrompt').dialog('open');
			if(temp_table == "vessels"){
				resetVesselForm();
			}else{
	            resetForm(temp_table);
			}
            return true;
        }

        if(resp.match("recexists")){
            document.getElementById("showError").innerHTML = "<b>Record Exists!!!</b><br><br>The record already exists.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recexistintrans")){
            document.getElementById("showError").innerHTML = "<b>Record Exists!!!</b><br><br>The record already exists in transaction table.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recnotexist")){
            document.getElementById("showError").innerHTML = "<b>Record Not Existing!!!</b><br><br>The record does not exist.";
            $('#showError').dialog('open');
            return true;
        }

    }
    return true;
}

function GetXmlHttpObject(){
    if (window.XMLHttpRequest){
        // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest();
    }

    if (window.ActiveXObject){
        // code for IE6, IE5
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
