/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

var curr_obj=null;
var temp_table=null;
var list_obj=null;

/*function checkAccess(access, menuoption, param){
	createCookie("access",access,false);
    var arg = "&currentuser="+readCookie("currentuser")+"&menuoption="+menuoption+"&access="+access+"&param="+param;
    var url = "/mobiletech/setupbackend.php?option=checkAccess"+arg;
	AjaxFunctionSetup(url);
}*/

function logoutUser(){
    var url = "/mobiletech/userbackend.php?option=logoutUser";
	AjaxFunctionSetup(url);
}

function checkAccess(access, menuoption){
	createCookie("access",access,false);
    var arg = "&currentuser="+readCookie("currentuser")+"&menuoption="+menuoption;
    var url = "/mobiletech/setupbackend.php?option=checkAccess"+arg;
	AjaxFunctionSetup(url);
}

function doUsersReport(){
	var locations = document.getElementById("location").value;
	var department = document.getElementById("department").value;
	var usersposition = document.getElementById("usersposition").value;
	var username = document.getElementById("username").value;
	var selectoption = document.getElementById("active");
	var active = selectoption.options[selectoption.selectedIndex].text;
	var param = "?location="+locations+"&department="+department+"&usersposition="+usersposition+"&active="+active+"&username="+username;
	var oWin = null;
	if(document.getElementsByName("userslist").item(0).checked){
		oWin = window.open("pdfusersummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("userslist").item(1).checked){
		oWin = window.open("pdfusersdetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
	eraseCookie("selectedlocation");
	eraseCookie("selectedept");
}

function doAppraisalReport(){
    var appraisalstartyear = document.getElementById("appraisalstartyear").value;
    var appraisalendyear = document.getElementById("appraisalendyear").value;
    var selectoption=document.getElementById("appraisalstartmonth");
    var appraisalstartmonth=selectoption.options[selectoption.selectedIndex].text;
    selectoption=document.getElementById("appraisalendmonth");
    var appraisalendmonth=selectoption.options[selectoption.selectedIndex].text;
	var staffid = document.getElementById("staffid").value;

	var appraisalstart = appraisalstartmonth+" "+appraisalstartyear;
	var appraisalend = appraisalendmonth+" "+appraisalendyear;
	
	var appraisalstartdate = "";
	var appraisalenddate = "";
	if(appraisalstartmonth=="Jan") appraisalstartdate = appraisalstartyear+"01";
	if(appraisalstartmonth=="Feb") appraisalstartdate = appraisalstartyear+"02";
	if(appraisalstartmonth=="Mar") appraisalstartdate = appraisalstartyear+"03";
	if(appraisalstartmonth=="Apr") appraisalstartdate = appraisalstartyear+"04";
	if(appraisalstartmonth=="May") appraisalstartdate = appraisalstartyear+"05";
	if(appraisalstartmonth=="Jun") appraisalstartdate = appraisalstartyear+"06";
	if(appraisalstartmonth=="Jul") appraisalstartdate = appraisalstartyear+"07";
	if(appraisalstartmonth=="Aug") appraisalstartdate = appraisalstartyear+"08";
	if(appraisalstartmonth=="Sep") appraisalstartdate = appraisalstartyear+"09";
	if(appraisalstartmonth=="Oct") appraisalstartdate = appraisalstartyear+"10";
	if(appraisalstartmonth=="Nov") appraisalstartdate = appraisalstartyear+"11";
	if(appraisalstartmonth=="Dec") appraisalstartdate = appraisalstartyear+"12";

	if(appraisalendmonth=="Jan") appraisalenddate = appraisalendyear+"01";
	if(appraisalendmonth=="Feb") appraisalenddate = appraisalendyear+"02";
	if(appraisalendmonth=="Mar") appraisalenddate = appraisalendyear+"03";
	if(appraisalendmonth=="Apr") appraisalenddate = appraisalendyear+"04";
	if(appraisalendmonth=="May") appraisalenddate = appraisalendyear+"05";
	if(appraisalendmonth=="Jun") appraisalenddate = appraisalendyear+"06";
	if(appraisalendmonth=="Jul") appraisalenddate = appraisalendyear+"07";
	if(appraisalendmonth=="Aug") appraisalenddate = appraisalendyear+"08";
	if(appraisalendmonth=="Sep") appraisalenddate = appraisalendyear+"09";
	if(appraisalendmonth=="Oct") appraisalenddate = appraisalendyear+"10";
	if(appraisalendmonth=="Nov") appraisalenddate = appraisalendyear+"11";
	if(appraisalendmonth=="Dec") appraisalenddate = appraisalendyear+"12";
	
	var param = "?staffid="+staffid+"&appraisalstart="+appraisalstart+"&appraisalend="+appraisalend+"&appraisalstartdate="+appraisalstartdate+"&appraisalenddate="+appraisalenddate;
	var oWin = null;
	if(document.getElementsByName("appraisallist").item(0).checked){
		oWin = window.open("pdfappraisalsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("appraisallist").item(1).checked){
		oWin = window.open("pdfappraisaldetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function doLeaveReport(){
	var staffid = document.getElementById("staffid").value;
	var selectoption=document.getElementById("supervisorapproval");
	var supervisorapproval=selectoption.options[selectoption.selectedIndex].text;
	selectoption=document.getElementById("adminapproval");
	var adminapproval=selectoption.options[selectoption.selectedIndex].text;
    var leavetype = document.getElementById("leavetype").value;
    var leavestart = document.getElementById("leavestart").value;
    if(leavestart!=null && leavestart!="") {
		leavestart = leavestart.substr(6,4)+'-'+leavestart.substr(3,2)+'-'+leavestart.substr(0,2);
	}
    var leaveend = document.getElementById("leaveend").value;
    if(leaveend!=null && leaveend!="") {
		leaveend = leaveend.substr(6,4)+'-'+leaveend.substr(3,2)+'-'+leaveend.substr(0,2);
	}

	var param = "?leavetype="+leavetype+"&leavestart="+leavestart+"&leaveend="+leaveend+"&supervisorapproval="+supervisorapproval+"&adminapproval="+adminapproval+"&staffid="+staffid;
	var oWin = null;
	if(document.getElementsByName("leavelist").item(0).checked){
		oWin = window.open("pdfleavesummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("leavelist").item(1).checked){
		oWin = window.open("pdfleavedetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function doStaffReport(){
	var department = document.getElementById("department").value;
	var level = document.getElementById("level").value;
	var jobtitle = document.getElementById("jobtitle").value;
	var userid = document.getElementById("userid").value;
	var supervisor = document.getElementById("supervisor").value;
	var birthdate = document.getElementById("birthdate").value;
    if(birthdate!=null && birthdate!="") {
		birthdate = birthdate.substr(6,4)+'-'+birthdate.substr(3,2)+'-'+birthdate.substr(0,2);
	}
	var employmentdate = document.getElementById("employmentdate").value;
    if(employmentdate!=null && employmentdate!="") {
		employmentdate = employmentdate.substr(6,4)+'-'+employmentdate.substr(3,2)+'-'+employmentdate.substr(0,2);
	}
	var selectoption = document.getElementById("gender");
	var gender = selectoption.options[selectoption.selectedIndex].text;
	selectoption = document.getElementById("maritalstatus");
	var maritalstatus = selectoption.options[selectoption.selectedIndex].text;
	selectoption = document.getElementById("active");
	var active = selectoption.options[selectoption.selectedIndex].text;
	var param = "?department="+department+"&level="+level+"&jobtitle="+jobtitle+"&userid="+userid+"&supervisor="+supervisor+"&birthdate="+birthdate;
	 param += "&employmentdate="+employmentdate+"&gender="+gender+"&maritalstatus="+maritalstatus+"&active="+active;
	var oWin = null;
	if(document.getElementsByName("stafflist").item(0).checked){
		oWin = window.open("pdfstaffsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("stafflist").item(1).checked){
		oWin = window.open("pdfstaffdetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function doClientReport(){
	var locations = document.getElementById("location").value;
	var clientid = document.getElementById("clientid").value;
	var selectoption = document.getElementById("active");
	var active = selectoption.options[selectoption.selectedIndex].text;
	var param = "?location="+locations+"&active="+active+"&clientid="+clientid;
	var oWin = null;
	if(document.getElementsByName("clientlist").item(0).checked){
		oWin = window.open("pdfclientsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("clientlist").item(1).checked){
		oWin = window.open("pdfclientdetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
	eraseCookie("selectedlocation");
}

function doTicketReport(){
	var clientidA = document.getElementById("clientidA").value;
	var locationA = document.getElementById("locationA").value;
	var ticketnoA = document.getElementById("ticketnoA").value;
	var ticket_dateA = document.getElementById("ticket_dateA").value;
    if(ticket_dateA!=null && ticket_dateA!="") {
		ticket_dateA = ticket_dateA.substr(6,4)+'-'+ticket_dateA.substr(3,2)+'-'+ticket_dateA.substr(0,2);
	}
	var due_dateA = document.getElementById("due_dateA").value;
    if(due_dateA!=null && due_dateA!="") {
		due_dateA = due_dateA.substr(6,4)+'-'+due_dateA.substr(3,2)+'-'+due_dateA.substr(0,2);
	}
    var selectoption=document.getElementById("ticket_priorityA");
    var ticket_priorityA=selectoption.options[selectoption.selectedIndex].text;
	if(ticket_priorityA=="Select Priority") ticket_priorityA="";
    selectoption=document.getElementById("help_topicA");
    var help_topicA=selectoption.options[selectoption.selectedIndex].text;
	if(help_topicA=="Select Topic") help_topicA="";
    selectoption=document.getElementById("ticket_sourceA");
    var ticket_sourceA=selectoption.options[selectoption.selectedIndex].text;
	if(ticket_sourceA=="Select Source") ticket_sourceA="";
    selectoption=document.getElementById("clienttype");
    var clienttype=selectoption.options[selectoption.selectedIndex].text;
	if(clienttype=="Select Client Type") clienttype="";

	var ticket_statusB="";
	if (document.getElementsByName("ticket_statusA").item(0).checked){
		ticket_statusB="";
	}else if(document.getElementsByName("ticket_statusA").item(1).checked){
		ticket_statusB="Open";
	}else if(document.getElementsByName("ticket_statusA").item(2).checked){
		ticket_statusB="Closed";
	}

    var param = "?clientid="+clientidA+"&location="+locationA+"&ticketno="+ticketnoA+"&ticket_status="+ticket_statusB;
	param += "&ticket_date="+ticket_dateA+"&due_date="+due_dateA+"&ticket_priority="+ticket_priorityA;
	param += "&help_topic="+help_topicA+"&ticket_source="+ticket_sourceA+"&clienttype="+clienttype;

	var oWin = null;
	if(document.getElementsByName("ticketlist").item(0).checked){
		oWin = window.open("pdfticketsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("ticketlist").item(1).checked){
		oWin = window.open("pdfticketdetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
	eraseCookie("selectedlocation");
}

function doStockReport(){
	var locationA = document.getElementById("locationA").value;
	var equipmentcategoryA = document.getElementById("equipmentcategoryA").value;
	var equipmentcodeA = document.getElementById("equipmentcodeA").value;
	var start_dateA = document.getElementById("start_dateA").value;
    if(start_dateA!=null && start_dateA!="") {
		start_dateA = start_dateA.substr(6,4)+'-'+start_dateA.substr(3,2)+'-'+start_dateA.substr(0,2);
	}
	var end_dateA = document.getElementById("end_dateA").value;
    if(end_dateA!=null && end_dateA!="") {
		end_dateA = end_dateA.substr(6,4)+'-'+end_dateA.substr(3,2)+'-'+end_dateA.substr(0,2);
	}

    var param = "?location="+locationA+"&equipmentcategory="+equipmentcategoryA+"&equipmentcode="+equipmentcodeA;
	param += "&start_date="+start_dateA+"&end_date="+end_dateA;
	var oWin = null;
	if(document.getElementsByName("stockbutton").item(0).checked){
		oWin = window.open("pdfstocksummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("stockbutton").item(1).checked){
		oWin = window.open("pdfstockdetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
	eraseCookie("selectecategory");
}

function doAccountReport(){
	var departmentA = document.getElementById("departmentA").value;
	var requestedbyA = document.getElementById("requestedbyA").value;
	var superapprovedbyA = document.getElementById("superapprovedbyA").value;
	var approvedbyA = document.getElementById("approvedbyA").value;
	var releasedbyA = document.getElementById("releasedbyA").value;

    var selectoption=document.getElementById("selectedoption");
    var selectedoption=selectoption.options[selectoption.selectedIndex].text;

	var start_dateA = document.getElementById("start_dateA").value;
    if(start_dateA!=null && start_dateA!="") {
		start_dateA = start_dateA.substr(6,4)+'-'+start_dateA.substr(3,2)+'-'+start_dateA.substr(0,2);
	}
	var end_dateA = document.getElementById("end_dateA").value;
    if(end_dateA!=null && end_dateA!="") {
		end_dateA = end_dateA.substr(6,4)+'-'+end_dateA.substr(3,2)+'-'+end_dateA.substr(0,2);
	}

    var param = "?department="+departmentA+"&requestedby="+requestedbyA+"&superapprovedby="+superapprovedbyA+"&approvedby="+approvedbyA;
	param += "&releasedby="+releasedbyA+"&start_date="+start_dateA+"&end_date="+end_dateA+"&selectedoption="+selectedoption;

	var oWin = null;
	if(document.getElementsByName("accountbutton").item(0).checked){
		oWin = window.open("pdfaccountsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(document.getElementsByName("accountbutton").item(1).checked){
		oWin = window.open("pdfaccountdetails.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}
	if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
	eraseCookie("selectecategory");
}

function getClients(){
	var locations = document.getElementById("locations").value;
	document.getElementById("locationB").value=locations;
	var basestation = document.getElementById("basestationdescription").value;

	var clienttypeB="";
	if (document.getElementsByName("clienttypeA").item(0).checked){
		clienttypeB="VPN";
	}else if(document.getElementsByName("clienttypeA").item(1).checked){
		clienttypeB="INTERNET";
	}else if(document.getElementsByName("clienttypeA").item(2).checked){
		clienttypeB="RETAILERS";
	}

    var param = "&table=clientstable&location="+locations+"&basestation="+basestation+"&clienttype="+clienttypeB;
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function sendClientMail(){
	var error = "";
	if(document.getElementById("clientmailbox").checked==true){
		var clientmailsubject = document.getElementById("clientmailsubject").value;
		var clientmailtext = document.getElementById("clientmailtext").value;
		//if only table header is available for clientlist div.
		if (document.getElementById("clientlist").innerHTML=='<table border="1" style="border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;"><tbody><tr style="font-weight:bold; color:white"><td align="right">S/No</td><td>Client-Id</td><td>Client Name</td><td>Contact Address</td><td>Active</td></tr></tbody></table>')
			error += "No Client is selected.<br><br>"; 
		if (clientmailsubject=="") error += "Mail Subject must not be blank.<br><br>";
		if (clientmailtext=="") error += "Mail Body must not be blank.<br><br>";
		var locations = document.getElementById("locations").value;
		var basestation = document.getElementById("basestationdescription").value;
		var clientmailtext = document.getElementById("clientmailtext").value;
		document.getElementById("locationB").value=locations;
		var clienttypeB="";
		if (document.getElementsByName("clienttypeA").item(0).checked){
			clienttypeB="VPN";
		}else if(document.getElementsByName("clienttypeA").item(1).checked){
			clienttypeB="INTERNET";
		}else if(document.getElementsByName("clienttypeA").item(2).checked){
			clienttypeB="RETAILERS";
		}
		var param = "&table=clientstable&location="+locations+"&basestation="+basestation+"&clientmailtext="+clientmailtext+"&clienttype="+clienttypeB+"&clientmailsubject="+clientmailsubject;
		var url = "/mobiletech/setupbackend.php?option=sendClientMail"+param;
		if(error=="") AjaxFunctionSetup(url);
	}else{
		error += "Make sure you check the Compose Mail checkbox and type the mail to send.<br><br>";
	}
	if(error.length >0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
}

function checkClient(){
	var clientid = document.getElementById("clientid").value;
	if(clientid==null || clientid==""){
		document.getElementById("clientname").value="";
		document.getElementById("clientdetails").innerHTML="";
	}
}

function getMyClient(code){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/mobiletech/setupbackend.php?option=getARecord"+"&table=clientstable&serialno="+code;
	AjaxFunctionSetup(url);
}

function getTicketHstory(code){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+"&table=ticket_history&serialno="+code;
	AjaxFunctionSetup(url);
}

var docrow = 1;
var docflag = 0;
function addDoc(){
    if(docrow>1){
        var docid = "docid"+(docrow-1);
        if(document.getElementById(docid).value==null || document.getElementById(docid).value==""){
            document.getElementById("showError").innerHTML = "<b>Document not added</b><br><br>Please complete the last document before uploading a new one.";
            $('#showError').dialog('open');
            return true;
        }
    }
    docrow++;
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Description</td><td></td></tr>';
    var flag=0;
    docid="";
    var docidvalue="";
    var docdesc="";
    var docdescvalue="";
    var actionid="";
    
    for(var k=1; k<docrow; k++){
		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        docid = "docid"+k;
        docidvalue="";
        docdesc = "docdesc"+k;
        docdescvalue="";
        actionid = "actionid"+k;
        if((k<(docrow-1)) && docflag>0){
            docidvalue = document.getElementById(docid).value;
            docdescvalue = document.getElementById(docdesc).value;
        }
        docflag = 1;
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' value='"+docdescvalue+"' id='"+docdesc+"' onblur='this.value=capAdd(this.value)' size='50' />";
        str += "<input type='hidden' value='"+docidvalue+"' id='"+docid+"' /></td>";
        if(docdescvalue.length>0){
            str += "<td><div id='"+actionid+"'><a href=javascript:viewDoc('"+docid+"')>View</a>&nbsp;&nbsp;<a href=javascript:deleteDoc('"+k+"')>Delete</a></div></td>";
        }else{
            str += "<td><div id='"+actionid+"'><a href=javascript:uploadDoc('"+k+"')>Upload new document</a></div></td>";
        }
    }
    str += "</tr></table>";
	if(readCookie("updateticket")=="Yes"){
		document.getElementById('supportdocs3').innerHTML=str;
	}else{
		document.getElementById('supportdocs').innerHTML=str;
	}
}

function viewDoc(arg){
    createCookie("theDoc",arg,false);
    var oWin = window.open("viewdocument.php", "_blank", "directories=0,scrollbars=1,resizable=0,location=0,status=0,toolbar=0,menubar=0,width=500,height=600,left=50,top=50");
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}

function uploadDoc(arg){
    createCookie("currentdocid",arg,false);
    var docdesc = "docdesc"+(arg);
    if(document.getElementById(docdesc).value==null || document.getElementById(docdesc).value==""){
        document.getElementById("showError").innerHTML = "<b>Document not added</b><br><br>Please complete the document description before uploading.";
        $('#showError').dialog('open');
        return true;
    }
	if(readCookie("updateticket")=="Yes"){
		browseFiles3();
	}else{
		browseFiles2();
	}
}
function deleteDoc(arg){
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Description</td></tr>';
    var flag=0;
    var docid="";
    var docdesc="";
    var tempdocid="";
    var tempdocdesc="";
    var docidvalue="";
    var docdescvalue="";
    var actionid="";
    var temp = 0;
    deleteflag = 0;
    for(var k=1; k<docrow; k++){
        if(k==arg && deleteflag==0){
            deleteflag=1;
            docrow--;
            k--;
            temp++;
            continue;
        }
		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        docid = "docid"+k;
        tempdocid = "docid"+(k+temp);
        docdesc = "docdesc"+k;
        actionid = "actionid"+k;
        tempdocdesc = "docdesc"+(k+temp);
        docidvalue="";
        docdescvalue="";
        if((k<(docrow))){
            docidvalue = document.getElementById(tempdocid).value;
            docdescvalue = document.getElementById(tempdocdesc).value;
        }
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' value='"+docdescvalue+"' id='"+docdesc+"' onblur='this.value=capAdd(this.value)' size='50' />";
        str += "<input type='hidden' value='"+docidvalue+"' id='"+docid+"' /></td>";
        if(docdescvalue.length>0){
            str += "<td><div id='"+actionid+"'><a href=javascript:viewDoc('"+docid+"')>View</a>&nbsp;&nbsp;<a href=javascript:deleteDoc('"+k+"')>Delete</a></div></td>";
        }else{
            str += "<td><div id='"+actionid+"'><a href=javascript:uploadDoc('"+k+"')>Upload new document</a></div></td>";
        }
    }
    str += "</tr></table>";
	if(readCookie("updateticket")=="Yes"){
		document.getElementById('supportdocs3').innerHTML=str;
	}else{
		document.getElementById('supportdocs').innerHTML=str;
	}
}

function populateDoc(arg,client){
    var row_split = arg.split('_~_');
    //document.getElementById('examno').value = row_split[0];
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Description</td></tr>';
    var flag=0;
    var docid="";
    var docdesc="";
    var docidvalue="";
    var docdescvalue="";
    var actionid="";
    docrow = 1;
    var col_split = "";
    for(var k=1; k<row_split.length; k++){
        col_split = row_split[k].split('~_~');
		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        docid = "docid"+k;
        docdesc = "docdesc"+k;
        actionid = "actionid"+k;
        docrow++;
        docidvalue = col_split[0];
        docdescvalue = col_split[1];

        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' value='"+docdescvalue+"' id='"+docdesc+"' onblur='this.value=capAdd(this.value)' size='50' />";
        str += "<input type='hidden' value='"+docidvalue+"' id='"+docid+"' /></td>";
        if(docdescvalue.length>0){
            str += "<td><div id='"+actionid+"'><a href=javascript:viewDoc('"+docidvalue.replace(/ /g,'#')+"')>View</a>";
			if(readCookie("ticketform")!="viewticket") str += "&nbsp;&nbsp;<a href=javascript:deleteDoc('"+k+"')>Delete</a>";
			str += "</div></td>";
        }else{
            str += "<td><div id='"+actionid+"'><a href=javascript:uploadDoc('"+k+"')>Upload new document</a></div></td>";
        }
    }
    str += "</tr></table>";
	if(readCookie("updateticket")=="Yes"){
		document.getElementById('supportdocs3').innerHTML=str;
		getTicketHstory(client);
	}else{
		document.getElementById('supportdocs').innerHTML=str;
	}
    docflag = 1;
}

function populateTicketHistory(arg){
    var row_split = arg.split('getAllRecs');
	var str = "";
	var docs = "";
    var col_split = "";
    var count=0;
	for(var k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
		var date = col_split[10];
		var day  = parseInt(date.substring(8,10),10);
		var mon  = parseInt(date.substring(5,7),10);
		var year  = parseInt(date.substring(0,4),10);
		var hour  = date.substring(11,13);
		var min  = date.substring(14,16);
		var sec  = date.substring(17,19);
		d = new Date(year, mon-1, day);

		date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
		day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
		mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
		year = date_split[2];
		var today = day+"/"+mon+"/"+year;
		//document.getElementById("ticket_date3").value = today;
		var assignor = "";
		if(d.getDay()==0) assignor += "Sun, ";
		if(d.getDay()==1) assignor += "Mon, ";
		if(d.getDay()==2) assignor += "Tue, ";
		if(d.getDay()==3) assignor += "Wed, ";
		if(d.getDay()==4) assignor += "Thur, ";
		if(d.getDay()==5) assignor += "Fri, ";
		if(d.getDay()==6) assignor += "Sat, ";
		if(d.getMonth()==0) assignor += "Jan ";
		if(d.getMonth()==1) assignor += "Feb ";
		if(d.getMonth()==2) assignor += "Mar ";
		if(d.getMonth()==3) assignor += "Apr ";
		if(d.getMonth()==4) assignor += "May ";
		if(d.getMonth()==5) assignor += "Jun ";
		if(d.getMonth()==6) assignor += "Jul ";
		if(d.getMonth()==7) assignor += "Aug ";
		if(d.getMonth()==8) assignor += "Sep ";
		if(d.getMonth()==9) assignor += "Oct ";
		if(d.getMonth()==10) assignor += "Nov ";
		if(d.getMonth()==11) assignor += "Dec ";
		//time_split = (d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()).split(':');
		//hour = ((time_split[0].length < 2) ? "0" : "") + time_split[0];
		//min = ((time_split[1].length < 2) ? "0" : "") + time_split[1];
		//sec = ((time_split[2].length < 2) ? "0" : "") + time_split[2];
		hour = ((hour.length < 2) ? "0" : "") + hour;
		min = ((min.length < 2) ? "0" : "") + min;
		sec = ((sec.length < 2) ? "0" : "") + sec;
		if(k==1){
			if(col_split[2]!=null && col_split[2]!=""){
				str += "<table style='font-size:11px' align='center' class='message' cellspacing='0' cellpadding='1' width='100%' border=0>";
				assignor += d.getDate()+" "+d.getFullYear()+" "+hour+":"+min+":"+sec;
				assignor += " - "+col_split[3]+" of "+col_split[2]+" Department";
				str +="<tr><th colspan='4'><div style='font-size:12px; font-weight:bold'>"+assignor+"</div></th></tr>";
				str +="<tr><td>";
				if(col_split[7]!=null && col_split[7]!=""){
					str +="Ticket priority set to "+col_split[7]+", ";
				}
				if(col_split[8]!=null && col_split[8]!=""){
					str +="Ticket status set to "+col_split[8]+", ";
				}
				if(col_split[5]!=null && col_split[5]!=""){
					str +="Ticket Assigned to "+col_split[5]+" of "+col_split[4]+" Department<br><br>";
				}
				if(col_split[6]!=null && col_split[6]!=""){
					str +=col_split[6]+"<br>";
				}
				str +="</td></tr></table><br>";
				if(col_split[9]!=null && col_split[9]!="") docs += col_split[9];
			}
		}else{
			if(col_split[2]!=null && col_split[2]!=""){
				str += "<table style='font-size:11px' align='center' class='response' cellspacing='0' cellpadding='1' width='100%' border=0>";
				assignor += d.getDate() + " " + d.getFullYear() + " " + hour + ":" + min + ":" + sec;
				assignor += " - "+col_split[3]+" of "+col_split[2]+" Department";
				str +="<tr><th colspan='4'><div style='font-size:12px; font-weight:bold'>"+assignor+"</div></th></tr>";
				str +="<tr><td>";
				if(col_split[7]!=null && col_split[7]!=""){
					str +="Ticket priority changed to "+col_split[7]+", ";
				}
				if(col_split[8]!=null && col_split[8]!=""){
					str +="Ticket status changed to "+col_split[8]+", ";
				}
				if(col_split[5]!=null && col_split[5]!=""){
					str +="Ticket Assigned to "+col_split[5]+" of "+col_split[4]+" Department<br><br>";
				}
				if(col_split[6]!=null && col_split[6]!=""){
					str +=col_split[6]+"<br>";
				}
				str +="</td></tr></table><br>";
				if(col_split[9]!=null && col_split[9]!="") docs += col_split[9];
			}
		}
    }
    document.getElementById('t_history').innerHTML=str;
	var d = new Date();
	var month = d.getMonth()+1;
	var day  = "";
	var mon  = "";
	var year  = "";
	var hour  = "";
	var min  = "";
	var sec  = "";

	/*while((d.getMonth()+1) == month){
		d.setDate(d.getDate()-1);
	}
	d.setDate(d.getDate()+1);*/
	date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
	day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
	mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
	year = date_split[2];
	var today = day+"/"+mon+"/"+year;
	if(readCookie("ticketform")!="viewticket") document.getElementById("ticket_date").value = today;
	var assignor = "";
	if(d.getDay()==0) assignor += "Sun, ";
	if(d.getDay()==1) assignor += "Mon, ";
	if(d.getDay()==2) assignor += "Tue, ";
	if(d.getDay()==3) assignor += "Wed, ";
	if(d.getDay()==4) assignor += "Thur, ";
	if(d.getDay()==5) assignor += "Fri, ";
	if(d.getDay()==6) assignor += "Sat, ";
	if(d.getMonth()==0) assignor += "Jan ";
	if(d.getMonth()==1) assignor += "Feb ";
	if(d.getMonth()==2) assignor += "Mar ";
	if(d.getMonth()==3) assignor += "Apr ";
	if(d.getMonth()==4) assignor += "May ";
	if(d.getMonth()==5) assignor += "Jun ";
	if(d.getMonth()==6) assignor += "Jul ";
	if(d.getMonth()==7) assignor += "Aug ";
	if(d.getMonth()==8) assignor += "Sep ";
	if(d.getMonth()==9) assignor += "Oct ";
	if(d.getMonth()==10) assignor += "Nov ";
	if(d.getMonth()==11) assignor += "Dec ";
	time_split = (d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()).split(':');
	hour = ((time_split[0].length < 2) ? "0" : "") + time_split[0];
	min = ((time_split[1].length < 2) ? "0" : "") + time_split[1];
	sec = ((time_split[2].length < 2) ? "0" : "") + time_split[2];
	assignor += d.getDate() + " " + d.getFullYear() + " " + hour + ":" + min + ":" + sec;
	assignor += " - " + readCookie("currentuser")+" of "+readCookie("currentdepartment")+" Department";
	document.getElementById("assignor3").innerHTML = "<div style='font-size:12px; font-weight:bold'>"+assignor+"</div>";
	document.getElementById("userid3").value = readCookie("currentuser");
	var thedate = year + "-" + mon + "-" + day + " " + hour + ":" + min + ":" + sec;
	document.getElementById("usertime3").value = thedate;
	document.getElementById("source_department3").value = readCookie("currentdepartment");
	createCookie("getclientB","2",false);
	//if(docs!=""){
	//	populateDoc(docs,clientid);
	//}else{
		getMyClient(readCookie("currentclient"));
	//}
}

function nextClientNo(locations){
    var url = "/mobiletech/setupbackend.php?option=nextClientNo&location="+locations;
	AjaxFunctionSetup(url);
}

function getTicketNo(){
	$('#ticketsform').dialog('open');
	$('#ticketlist').dialog('close');
	document.getElementById("clientid").value="";
	document.getElementById("supportdocs").innerHTML="";
	docrow=1;
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/mobiletech/setupbackend.php?option=getARecord&table=ticketno";
	AjaxFunctionSetup(url);
}

function doStocks(){
	var locations = document.getElementById("locationA").value;
	var equipmentcategory = document.getElementById("equipmentcategoryA").value;
	var equipmentcode = document.getElementById("equipmentcodeA").value;
    var error = "";
    if (locations=="") error += "Location must not be blank.<br><br>";
    if (equipmentcategory=="") error += "Equipment Category must not be blank.<br><br>";
    if (equipmentcode=="") error += "Equipment Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
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

	document.getElementById("locations").value=locations;
	document.getElementById("equipmentcategory").value=equipmentcategory;
	document.getElementById("equipmentcode").value=equipmentcode;
	document.getElementById("transactiondate").value=today;
	if(readCookie("stockform")=="replenish")	document.getElementById("replenishedby").value=readCookie("currentuser");
	if(readCookie("stockform")=="requisition")	document.getElementById("requestedby").value=readCookie("currentuser");
	if(readCookie("stockform")=="approval")	document.getElementById("approvedby").value=readCookie("currentuser");

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/mobiletech/setupbackend.php?option=getARecord"+"&table=equipmentcode&equipmentcode="+equipmentcode;
	
	$('#stocklist').dialog('close');
	if(readCookie("stockform")=="replenish"){
		$('#stockreplenish').dialog('open');
	}else if(readCookie("stockform")=="requisition"){
		$('#stockrequisition').dialog('open');
	}else if(readCookie("stockform")=="approval"){
		$('#stockapproval').dialog('open');
	}
	AjaxFunctionSetup(url);
}

function getTickets(currentuser){
	createCookie("mytickets",currentuser,false);
	var clientidA = document.getElementById("clientidA").value;
	var locationA = document.getElementById("locationA").value;
	var ticketnoA = document.getElementById("ticketnoA").value;
	var ticket_dateA = document.getElementById("ticket_dateA").value;
    if(ticket_dateA!=null && ticket_dateA!="") {
		ticket_dateA = ticket_dateA.substr(6,4)+'-'+ticket_dateA.substr(3,2)+'-'+ticket_dateA.substr(0,2);
	}else{
		ticket_dateA = "";
		var d = new Date();
		var month = d.getMonth()+1;
		var day  = "";
		var mon  = "";
		var year  = "";
		var hour  = "";
		var min  = "";
		var sec  = "";

		/*while((d.getMonth()+1) == month){
			d.setDate(d.getDate()-1);
		}
		d.setDate(d.getDate()+1);*/
		date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
		day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
		mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
		year = date_split[2];
		//ticket_dateA = year+"-"+mon+"-"+day;
	}
	var due_dateA = document.getElementById("due_dateA").value;
    if(due_dateA!=null && due_dateA!="") {
		due_dateA = due_dateA.substr(6,4)+'-'+due_dateA.substr(3,2)+'-'+due_dateA.substr(0,2);
	}else{
		due_dateA = "";
	}
    var selectoption=document.getElementById("ticket_priorityA");
    var ticket_priorityA=selectoption.options[selectoption.selectedIndex].text;
	if(ticket_priorityA=="Select Priority") ticket_priorityA="";
    selectoption=document.getElementById("help_topicA");
    var help_topicA=selectoption.options[selectoption.selectedIndex].text;
	if(help_topicA=="Select Topic") help_topicA="";
    selectoption=document.getElementById("ticket_sourceA");
    var ticket_sourceA=selectoption.options[selectoption.selectedIndex].text;
	if(ticket_sourceA=="Select Source") ticket_sourceA="";
    selectoption=document.getElementById("clienttype");
    var clienttype=selectoption.options[selectoption.selectedIndex].text;
	if(clienttype=="Select Client Type") clienttype="";

	var ticket_statusB="";
	if (document.getElementsByName("ticket_statusA").item(0).checked){
		ticket_statusB="";
	}else if(document.getElementsByName("ticket_statusA").item(1).checked){
		ticket_statusB="Open";
	}else if(document.getElementsByName("ticket_statusA").item(2).checked){
		ticket_statusB="Closed";
	}
    var param = "&table=ticketstable&clientid="+clientidA+"&location="+locationA+"&ticketno="+ticketnoA+"&ticket_status="+ticket_statusB;
	param += "&ticket_date="+ticket_dateA+"&due_date="+due_dateA+"&ticket_priority="+ticket_priorityA;
	param += "&help_topic="+help_topicA+"&ticket_source="+ticket_sourceA+"&clienttype="+clienttype+"&currentuser="+currentuser;
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function getStocks(currentobject){
	var locationA = document.getElementById("locationA").value;
	var equipmentcategoryA = document.getElementById("equipmentcategoryA").value;
	var equipmentcodeA = document.getElementById("equipmentcodeA").value;
	var start_dateA = document.getElementById("start_dateA").value;
	var end_dateA = document.getElementById("end_dateA").value;
    if(start_dateA!=null && start_dateA!="") {
		start_dateA = start_dateA.substr(6,4)+'-'+start_dateA.substr(3,2)+'-'+start_dateA.substr(0,2);
	}else{
		start_dateA = "";
	}
	var end_dateA = document.getElementById("end_dateA").value;
    if(end_dateA!=null && end_dateA!="") {
		end_dateA = end_dateA.substr(6,4)+'-'+end_dateA.substr(3,2)+'-'+end_dateA.substr(0,2);
	}else{
		end_dateA = "";
	}
    var param = "&table=equipmentstock&location="+locationA+"&equipmentcategory="+equipmentcategoryA+"&equipmentcode="+equipmentcodeA;
	param += "&start_date="+start_dateA+"&end_date="+end_dateA+"&currentobject="+readCookie('stockform');
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function getAccountsRequisition(currentobject){
	var departmentA = document.getElementById("departmentA").value;
	var requestedbyA = document.getElementById("requestedbyA").value;
	var superapprovedbyA = document.getElementById("superapprovedbyA").value;
	var approvedbyA = document.getElementById("approvedbyA").value;
	var releasedbyA = document.getElementById("releasedbyA").value;
	var start_dateA = document.getElementById("start_dateA").value;
	var end_dateA = document.getElementById("end_dateA").value;
    if(start_dateA!=null && start_dateA!="") {
		start_dateA = start_dateA.substr(6,4)+'-'+start_dateA.substr(3,2)+'-'+start_dateA.substr(0,2);
	}else{
		start_dateA = "";
	}
	var end_dateA = document.getElementById("end_dateA").value;
    if(end_dateA!=null && end_dateA!="") {
		end_dateA = end_dateA.substr(6,4)+'-'+end_dateA.substr(3,2)+'-'+end_dateA.substr(0,2);
	}else{
		end_dateA = "";
	}
    var param = "&table=requisitiontable&department="+departmentA+"&requestedby="+requestedbyA+"&superapprovedby="+superapprovedbyA+"&approvedby="+approvedbyA;
	param += "&releasedby="+releasedbyA+"&start_date="+start_dateA+"&end_date="+end_dateA+"&currentobject="+readCookie('requisitionform');
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function updateUser(option, table){
	var username = document.getElementById("username").value;
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
    var useremail = document.getElementById("useremail").value;
    var mobilephone = document.getElementById("mobilephone").value;
    var officephone = document.getElementById("officephone").value;
    var department = document.getElementById("department").value;
    var locations = document.getElementById("location").value;
    var usersposition = document.getElementById("usersposition").value;
    var userPicture = document.getElementById("txtFile").value;
	if(userPicture.match("fakepath")) {
		var pic = userPicture.split("fakepath");
		userPicture=pic[1];
	}
    var homeaddress = document.getElementById("homeaddress").value;
    var selectoption=document.getElementById("active");
    var active=selectoption.options[selectoption.selectedIndex].text;
    var groupemail = document.getElementById("groupemail").value;

    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    var error = "";
    if (username=="") error += "User Id must not be blank.<br><br>";
    if (firstname=="") error += "First Name must not be blank.<br><br>";
    if (lastname=="") error += "Last Name must not be blank.<br><br>";
    if (mobilephone=="") error += "Mobile Phone must not be blank.<br><br>";
    if (officephone=="") error += "Office Phone must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (locations=="") error += "Location must not be blank.<br><br>";
    if (usersposition=="") error += "Designation must not be blank.<br><br>";
    if (homeaddress=="") error += "Home Address must not be blank.<br><br>";
    if (useremail > "") {
        if (useremail.match(illegalChars)) {
            error += "The email address contains illegal characters.<br><br>";
        } else if (!emailFilter.test(useremail)) {              //test email for illegal characters
            error += "Enter a valid email address or select username option.<br><br>";
        }
    }
    if (groupemail > "") {
        if (groupemail.match(illegalChars)) {
            error += "The group email address contains illegal characters.<br><br>";
        } else if (!emailFilter.test(groupemail)) {              //test email for illegal characters
            error += "Enter a valid group email address or select username option.<br><br>";
        }
    }
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+username+"][]["+firstname+"]["+lastname+"]["+useremail+"]["+mobilephone;
    param += "]["+officephone+"]["+department+"]["+locations+"]["+usersposition+"]["+userPicture+"]["+homeaddress+"]["+active+"]["+groupemail;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;	
	AjaxFunctionSetup(url);
}

function listAppraisal(arg){
	var staffid = document.getElementById("staffid").value;
    var appraisalstartyear = document.getElementById("appraisalstartyear").value;
    var appraisalendyear = document.getElementById("appraisalendyear").value;
    var selectoption=document.getElementById("appraisalstartmonth");
    var appraisalstartmonth=selectoption.options[selectoption.selectedIndex].text;
    selectoption=document.getElementById("appraisalendmonth");
    var appraisalendmonth=selectoption.options[selectoption.selectedIndex].text;
    //var appraisaldate = document.getElementById("appraisaldate").value;
    //if(appraisaldate!=null && appraisaldate!="") {
	//	appraisaldate = appraisaldate.substr(6,4)+'-'+appraisaldate.substr(3,2)+'-'+appraisaldate.substr(0,2);
	//}
	var appraisalstart = appraisalstartmonth+" "+appraisalstartyear;
	var appraisalend = appraisalendmonth+" "+appraisalendyear;

	var appraisalstartdate = "";
	var appraisalenddate = "";
	if(appraisalstartmonth=="Jan") appraisalstartdate = appraisalstartyear+"01";
	if(appraisalstartmonth=="Feb") appraisalstartdate = appraisalstartyear+"02";
	if(appraisalstartmonth=="Mar") appraisalstartdate = appraisalstartyear+"03";
	if(appraisalstartmonth=="Apr") appraisalstartdate = appraisalstartyear+"04";
	if(appraisalstartmonth=="May") appraisalstartdate = appraisalstartyear+"05";
	if(appraisalstartmonth=="Jun") appraisalstartdate = appraisalstartyear+"06";
	if(appraisalstartmonth=="Jul") appraisalstartdate = appraisalstartyear+"07";
	if(appraisalstartmonth=="Aug") appraisalstartdate = appraisalstartyear+"08";
	if(appraisalstartmonth=="Sep") appraisalstartdate = appraisalstartyear+"09";
	if(appraisalstartmonth=="Oct") appraisalstartdate = appraisalstartyear+"10";
	if(appraisalstartmonth=="Nov") appraisalstartdate = appraisalstartyear+"11";
	if(appraisalstartmonth=="Dec") appraisalstartdate = appraisalstartyear+"12";

	if(appraisalendmonth=="Jan") appraisalenddate = appraisalendyear+"01";
	if(appraisalendmonth=="Feb") appraisalenddate = appraisalendyear+"02";
	if(appraisalendmonth=="Mar") appraisalenddate = appraisalendyear+"03";
	if(appraisalendmonth=="Apr") appraisalenddate = appraisalendyear+"04";
	if(appraisalendmonth=="May") appraisalenddate = appraisalendyear+"05";
	if(appraisalendmonth=="Jun") appraisalenddate = appraisalendyear+"06";
	if(appraisalendmonth=="Jul") appraisalenddate = appraisalendyear+"07";
	if(appraisalendmonth=="Aug") appraisalenddate = appraisalendyear+"08";
	if(appraisalendmonth=="Sep") appraisalenddate = appraisalendyear+"09";
	if(appraisalendmonth=="Oct") appraisalenddate = appraisalendyear+"10";
	if(appraisalendmonth=="Nov") appraisalenddate = appraisalendyear+"11";
	if(appraisalendmonth=="Dec") appraisalenddate = appraisalendyear+"12";

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+staffid+"]["+trim(appraisalstart)+"]["+trim(appraisalend)+"]["+trim(appraisalstartdate)+"]["+trim(appraisalenddate)+"]["+arg;
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+"&table=appraisaltable"+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function listLeave(arg){
	var staffid = document.getElementById("staffid").value;
    var leavetype = document.getElementById("leavetype").value;
    var leavestart = document.getElementById("leavestart").value;
    if(leavestart!=null && leavestart!="") {
		leavestart = leavestart.substr(6,4)+'-'+leavestart.substr(3,2)+'-'+leavestart.substr(0,2);
	}
    var leaveend = document.getElementById("leaveend").value;
    if(leaveend!=null && leaveend!="") {
		leaveend = leaveend.substr(6,4)+'-'+leaveend.substr(3,2)+'-'+leaveend.substr(0,2);
	}

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+staffid+"]["+leavetype+"]["+leavestart+"]["+leavetype+"]["+arg;
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+"&table=leavetable"+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateAppraisal(option, table){
	var userName="";
	if(option=="addRecord"){
		userName = readCookie('currentuser');
	}else{
		userName = document.getElementById("userName").value;
	}
	var staffid = document.getElementById("staffid2").value;
    var duties = document.getElementById("duties").value;
    var difficultduties = document.getElementById("difficultduties").value;
    var interestingduties = document.getElementById("interestingduties").value;
    var performanceimprove = document.getElementById("performanceimprove").value;
    var queryorsuspension = document.getElementById("queryorsuspension").value;
    var training = document.getElementById("training").value;
    var accomplishments = document.getElementById("accomplishments").value;
    var appraisalstartyear = document.getElementById("appraisalstartyear").value;
    var appraisalendyear = document.getElementById("appraisalendyear").value;
    var selectoption=document.getElementById("appraisalstartmonth");
    var appraisalstartmonth=selectoption.options[selectoption.selectedIndex].text;
    selectoption=document.getElementById("appraisalendmonth");
    var appraisalendmonth=selectoption.options[selectoption.selectedIndex].text;
    var appraisaldate = document.getElementById("appraisaldate").value;
    if(appraisaldate!=null && appraisaldate!="") {
		appraisaldate = appraisaldate.substr(6,4)+'-'+appraisaldate.substr(3,2)+'-'+appraisaldate.substr(0,2);
	}else{
		appraisaldate = "0000-00-00";
	}
    var error = "";
    if (staffid=="") error += "Staff Id must not be blank.<br><br>";
    if (duties=="") error += "Main duties and responsibilities must not be blank.<br><br>";
    if (difficultduties=="") error += "Part of your job that you find the most difficult must not be blank.<br><br>";
    if (interestingduties=="") error += "Part of your job that interests you the most must not be blank.<br><br>";
    if (performanceimprove=="") error += "Actions that could be taken to improve your performance must not be blank.<br><br>";
    //if (queryorsuspension=="") error += "New Contact Address must not be blank.<br><br>";
    //if (training=="") error += "New Contact Address must not be blank.<br><br>";
    //if (accomplishments=="") error += "New Contact Address must not be blank.<br><br>";
	var appraisalstart = appraisalstartmonth+" "+appraisalstartyear;
	var appraisalend = appraisalendmonth+" "+appraisalendyear;

	var appraisalstartdate = "";
	var appraisalenddate = "";
	if(appraisalstartmonth=="Jan") appraisalstartdate = appraisalstartyear+"01";
	if(appraisalstartmonth=="Feb") appraisalstartdate = appraisalstartyear+"02";
	if(appraisalstartmonth=="Mar") appraisalstartdate = appraisalstartyear+"03";
	if(appraisalstartmonth=="Apr") appraisalstartdate = appraisalstartyear+"04";
	if(appraisalstartmonth=="May") appraisalstartdate = appraisalstartyear+"05";
	if(appraisalstartmonth=="Jun") appraisalstartdate = appraisalstartyear+"06";
	if(appraisalstartmonth=="Jul") appraisalstartdate = appraisalstartyear+"07";
	if(appraisalstartmonth=="Aug") appraisalstartdate = appraisalstartyear+"08";
	if(appraisalstartmonth=="Sep") appraisalstartdate = appraisalstartyear+"09";
	if(appraisalstartmonth=="Oct") appraisalstartdate = appraisalstartyear+"10";
	if(appraisalstartmonth=="Nov") appraisalstartdate = appraisalstartyear+"11";
	if(appraisalstartmonth=="Dec") appraisalstartdate = appraisalstartyear+"12";

	if(appraisalendmonth=="Jan") appraisalenddate = appraisalendyear+"01";
	if(appraisalendmonth=="Feb") appraisalenddate = appraisalendyear+"02";
	if(appraisalendmonth=="Mar") appraisalenddate = appraisalendyear+"03";
	if(appraisalendmonth=="Apr") appraisalenddate = appraisalendyear+"04";
	if(appraisalendmonth=="May") appraisalenddate = appraisalendyear+"05";
	if(appraisalendmonth=="Jun") appraisalenddate = appraisalendyear+"06";
	if(appraisalendmonth=="Jul") appraisalenddate = appraisalendyear+"07";
	if(appraisalendmonth=="Aug") appraisalenddate = appraisalendyear+"08";
	if(appraisalendmonth=="Sep") appraisalenddate = appraisalendyear+"09";
	if(appraisalendmonth=="Oct") appraisalenddate = appraisalendyear+"10";
	if(appraisalendmonth=="Nov") appraisalenddate = appraisalendyear+"11";
	if(appraisalendmonth=="Dec") appraisalenddate = appraisalendyear+"12";

	if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+staffid+"]["+duties+"]["+difficultduties+"]["+interestingduties+"]["+performanceimprove+"]["+queryorsuspension;
    param += "]["+training+"]["+accomplishments+"]["+appraisaldate+"]["+appraisalstart+"]["+appraisalend+"]["+appraisalstartdate+"]["+appraisalenddate+"]["+userName;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateLeave(option, table){
	var userName="";
	var supervisor = "";
	var adminid = "";
	var staffid = document.getElementById("staffid2").value;
    var leaveapplydate = document.getElementById("leaveapplydate").value;
    if(leaveapplydate!=null && leaveapplydate!="") {
		leaveapplydate = leaveapplydate.substr(6,4)+'-'+leaveapplydate.substr(3,2)+'-'+leaveapplydate.substr(0,2);
	}else{
		leaveapplydate = "0000-00-00";
	}
    var entitlement = document.getElementById("entitlement").value;
    var resumptiondate = document.getElementById("resumptiondate").value;
    if(resumptiondate!=null && resumptiondate!="") {
		resumptiondate = resumptiondate.substr(6,4)+'-'+resumptiondate.substr(3,2)+'-'+resumptiondate.substr(0,2);
	}else{
		resumptiondate = "0000-00-00";
	}
	if(readCookie("leaveform")=="leavesetup"){
		userName = readCookie('currentuser');
		supervisor = document.getElementById("supervisor").value;
		var supervisorapproval = "Pending"; //document.getElementById("supervisorapproval").value;
		var adminid = document.getElementById("adminid").value;
		var adminapproval = "Pending"; //document.getElementById("adminapproval").value;
		var leaveapprovedate = document.getElementById("leaveapprovedate").value;
		if(leaveapprovedate!=null && leaveapprovedate!="") {
			leaveapprovedate = leaveapprovedate.substr(6,4)+'-'+leaveapprovedate.substr(3,2)+'-'+leaveapprovedate.substr(0,2);
		}else{
			leaveapprovedate = "0000-00-00";
		}
	}
	if(readCookie("leaveform")=="supervisorapproval"){
		userName = document.getElementById("userName").value;
		var selectoption=document.getElementById("supervisorapproval");
		var supervisorapproval=selectoption.options[selectoption.selectedIndex].text;
		if(supervisorapproval!="Pending"){
			supervisor = document.getElementById("supervisorid").value;
		}else{
			supervisor = document.getElementById("supervisor").value;
		}
		adminid = document.getElementById("adminid").value;
		var adminapproval = "Pending"; //document.getElementById("adminapproval").value;
		var leaveapprovedate = document.getElementById("leaveapprovedate").value;
		if(leaveapprovedate!=null && leaveapprovedate!="") {
			leaveapprovedate = leaveapprovedate.substr(6,4)+'-'+leaveapprovedate.substr(3,2)+'-'+leaveapprovedate.substr(0,2);
		}else{
			leaveapprovedate = "0000-00-00";
		}
	}
	if(readCookie("leaveform")=="adminapproval"){
		userName = document.getElementById("userName").value;
		supervisor = document.getElementById("supervisor").value;
		var supervisorapproval = document.getElementById("supervisorapproval").value;
		var selectoption=document.getElementById("adminapproval");
		var adminapproval=selectoption.options[selectoption.selectedIndex].text;
		if(adminapproval!="Pending"){
			adminid = document.getElementById("adminid").value;
		}
		var leaveapprovedate = document.getElementById("leaveapprovedate").value;
		if(leaveapprovedate!=null && leaveapprovedate!="") {
			leaveapprovedate = leaveapprovedate.substr(6,4)+'-'+leaveapprovedate.substr(3,2)+'-'+leaveapprovedate.substr(0,2);
		}else{
			leaveapprovedate = "0000-00-00";
		}
	}
	var leavetype = document.getElementById("leavetype2").value;
    var leavestart = document.getElementById("leavestart2").value;
	leavestart = leavestart.substr(6,4)+'-'+leavestart.substr(3,2)+'-'+leavestart.substr(0,2);
    var leaveend = document.getElementById("leaveend2").value;
	leaveend = leaveend.substr(6,4)+'-'+leaveend.substr(3,2)+'-'+leaveend.substr(0,2);

	var error = "";
    if (staffid=="") error += "Staff Id must not be blank.<br><br>";
    if (leaveapplydate=="0000-00-00") error += "Leave application date must be selected.<br><br>";
    if(isNaN(entitlement) && entitlement!="") error += "Leave entitlement must be numeric.<br><br>";
    if (resumptiondate=="0000-00-00") error += "Leave resumption date must be selected.<br><br>";

	if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+staffid+"]["+leavetype+"]["+leavestart+"]["+leaveend+"]["+supervisor+"]["+supervisorapproval;
    param += "]["+leaveapplydate+"]["+entitlement+"]["+resumptiondate+"]["+adminid+"]["+adminapproval+"]["+leaveapprovedate+"]["+userName;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateStaff(option, table){
	var staffid = document.getElementById("staffid").value;
    var lastname = document.getElementById("lastname").value;
    var firstname = document.getElementById("firstname").value;
    var middlename = document.getElementById("middlename").value;
    var selectoption=document.getElementById("active");
    var active=selectoption.options[selectoption.selectedIndex].text;
    selectoption=document.getElementById("gender");
    var gender=selectoption.options[selectoption.selectedIndex].text;
    var jobtitle = document.getElementById("jobtitle").value;
    var department = document.getElementById("department").value;
    var supervisorid = document.getElementById("supervisorid").value;
    var level = document.getElementById("level").value;
    var staffPicture = document.getElementById("txtFile").value;
    var employmentdate = document.getElementById("employmentdate").value;
    if(employmentdate!=null && employmentdate!="") {
		employmentdate = employmentdate.substr(6,4)+'-'+employmentdate.substr(3,2)+'-'+employmentdate.substr(0,2);
	}else{
		employmentdate = "0000-00-00";
	}
    var previouscontactaddress = document.getElementById("previouscontactaddress").value;
    var newcontactaddress = document.getElementById("newcontactaddress").value;
    var mobilephonenumber = document.getElementById("mobilephonenumber").value;
    var homephonenumber = document.getElementById("homephonenumber").value;
    var birthdate = document.getElementById("birthdate").value;
    if(birthdate!=null && birthdate!="") {
		birthdate = birthdate.substr(6,4)+'-'+birthdate.substr(3,2)+'-'+birthdate.substr(0,2);
	}else{
		birthdate = "0000-00-00";
	}
    var emailaddress = document.getElementById("emailaddress").value;
    selectoption=document.getElementById("maritalstatus");
    var maritalstatus=selectoption.options[selectoption.selectedIndex].text;
    var maidenname = document.getElementById("maidenname").value;
    var spousename = document.getElementById("spousename").value;
    var spousephonenumber = document.getElementById("spousephonenumber").value;
    var nextofkin = document.getElementById("nextofkin").value;
    var nextofkinaddress = document.getElementById("nextofkinaddress").value;
    selectoption=document.getElementById("nextofkinrelationship");
    var nextofkinrelationship=selectoption.options[selectoption.selectedIndex].text;
    var nextofkinphonenumber = document.getElementById("nextofkinphonenumber").value;
	if(staffPicture.match("fakepath")) {
		var pic = staffPicture.split("fakepath");
		staffPicture=pic[1];
	}
    if(staffPicture==null || staffPicture=="") staffPicture = document.getElementById("staffPicture").value;
	if(staffPicture==null) staffPicture="";

    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    var error = "";
    if (staffid=="") error += "Staff Id must not be blank.<br><br>";
    if (lastname=="") error += "Last Name must not be blank.<br><br>";
    if (firstname=="") error += "First Name must not be blank.<br><br>";
    //if (gender=="") error += "Gender must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    //if (supervisorid=="") error += "Office Phone must not be blank.<br><br>";
    if (newcontactaddress=="") error += "New Contact Address must not be blank.<br><br>";
    if (emailaddress > "") {
        if (emailaddress.match(illegalChars)) {
            error += "The email address contains illegal characters.<br><br>";
        } else if (!emailFilter.test(emailaddress)) {              //test email for illegal characters
            error += "Enter a valid email address or select username option.<br><br>";
        }
    }
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+staffid+"]["+lastname+"]["+firstname+"]["+middlename+"]["+active+"]["+gender+"]["+jobtitle+"]["+department;
    param += "]["+supervisorid+"]["+level+"]["+employmentdate+"]["+previouscontactaddress+"]["+newcontactaddress+"]["+mobilephonenumber+"]["+homephonenumber;
    param += "]["+birthdate+"]["+emailaddress+"]["+maritalstatus+"]["+maidenname+"]["+spousename+"]["+spousephonenumber;
    param += "]["+nextofkin+"]["+nextofkinaddress+"]["+nextofkinrelationship+"]["+nextofkinphonenumber+"]["+staffPicture;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateEquipment(option, table){
	var equipmentcode = document.getElementById("equipmentcode").value;
    var equipmentname = document.getElementById("equipmentname").value;
    var equipmenttype = document.getElementById("equipmenttype").value;
    var equipmentdescription = document.getElementById("equipmentdescription").value;
    var error = "";
    if (equipmentcode=="") error += "Equipment Code must not be blank.<br><br>";
    if (equipmentname=="") error += "Equipment Name must not be blank.<br><br>";
    if (equipmenttype=="") error += "Equipment Type must not be blank.<br><br>";
    if (equipmentdescription=="") error += "Equipment Description must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+equipmentcode+"]["+equipmentname+"]["+equipmenttype+"]["+equipmentdescription;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateClient(option, table){
	var clienttypeB = document.getElementById("clienttypeB").value;
    var locationB = document.getElementById("locationB").value;
	var basestation = document.getElementById("basestationdescriptionB").value;
    var clientid = document.getElementById("clientid").value;
	var clientname = document.getElementById("clientname").value;
    var contactaddress = document.getElementById("contactaddress").value;
    var officephone = document.getElementById("officephone").value;
    var emailaddress = document.getElementById("emailaddress").value;
    var mobilephone = document.getElementById("mobilephone").value;
    var bandwidth = document.getElementById("bandwidth").value;
    var instalationdate = document.getElementById("instalationdate").value;
    var contactperson = document.getElementById("contactperson").value;
    var birthdate = document.getElementById("birthdate").value;
    var cpe = document.getElementById("cpe").value;
    var radioipaddress = document.getElementById("radioipaddress").value;
    var ipaddress = document.getElementById("ipaddress").value;
    var basestationipaddress = document.getElementById("basestationipaddress").value;
    var configurationstatus = document.getElementById("configurationstatus").value;
    var selectoption=document.getElementById("active");
    var active=selectoption.options[selectoption.selectedIndex].text;

    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    var error = "";
    if (clienttypeB=="") error += "Client Type must not be blank.<br><br>";
    if (locationB=="") error += "Client Location must not be blank.<br><br>";
    if (basestation=="") error += "Base Station must not be blank.<br><br>";
    if (clientid=="") error += "Client ID must not be blank.<br><br>";
    if (clientname=="") error += "Client Name must not be blank.<br><br>";
    if (contactaddress=="") error += "Client Contact Address must not be blank.<br><br>";
    if (officephone=="") error += "Client Office Phone must not be blank.<br><br>";
    if (emailaddress > "") {
        if (emailaddress.match(illegalChars)) {
            error += "The client email address contains illegal characters.<br><br>";
        } else if (!emailFilter.test(emailaddress)) {              //test email for illegal characters
            error += "Enter a valid email address or select username option.<br><br>";
        }
    }
    if (mobilephone=="") error += "Client Mobile Phone must not be blank.<br><br>";
    if (bandwidth=="") error += "Client Bandwidth must not be blank.<br><br>";
    //if (instalationdate=="") error += "Client Installation Date must not be blank.<br><br>";
    if(instalationdate!=null && instalationdate!="") {
		instalationdate = instalationdate.substr(6,4)+'-'+instalationdate.substr(3,2)+'-'+instalationdate.substr(0,2);
	}else{
		instalationdate = "0000-00-00";
	}
    if (contactperson=="") error += "Client Contact Person must not be blank.<br><br>";
    //if (birthdate=="") error += "Client Birth Date must not be blank.<br><br>";
    if(birthdate!=null && birthdate!="") {
		birthdate = birthdate.substr(6,4)+'-'+birthdate.substr(3,2)+'-'+birthdate.substr(0,2);
	}else{
		birthdate = "0000-00-00";
	}
    //if (cpe=="") error += "Client CPE must not be blank.<br><br>";
    //if (radioipaddress=="") error += "Client Radio IP Address must not be blank.<br><br>";
    //if (ipaddress=="") error += "Client IP Address must not be blank.<br><br>";
    //if (basestationipaddress=="") error += "Client Base Station IP Address must not be blank.<br><br>";
    //if (configurationstatus=="") error += "Client Configuration status must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+clientid+"]["+clientname+"]["+clienttypeB+"]["+locationB+"]["+contactaddress;
    param += "]["+officephone+"]["+mobilephone+"]["+emailaddress+"]["+bandwidth+"]["+instalationdate+"]["+birthdate;
    param += "]["+contactperson+"]["+cpe+"]["+radioipaddress+"]["+ipaddress+"]["+basestationipaddress+"]["+configurationstatus+"]["+active+"]["+basestation;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function getStockBalance(locations, equipmentcode){
	var quantityout = document.getElementById("quantityout2").value;
    var url = "/mobiletech/setupbackend.php?option=getStockBalance&location="+locations+"&equipmentcode="+equipmentcode+"&serialno="+quantityout;
	AjaxFunctionSetup(url);
}

function saveTicket(option, table){
	var ticketno=""; var clientid=""; var ticket_subject=""; var ticket_date=""; var due_date=""; 
	var selectoption=""; var ticket_source=""; var help_topic=""; var ticket_priority=""; var ticket_status=""; 
	var source_department=""; var ticket_assignor=""; var assigned_department=""; var ticket_assignee=""; 
	var ticket_message=""; var userid=""; var usertime=""; var supportdocs = ""; var docid="";	var docdesc="";	
	var docidvalue=""; var docdescvalue="";
	if(option=="addRecord"){
		ticketno = document.getElementById("ticketno").value;
		clientid = document.getElementById("clientid").value;
		ticket_subject = document.getElementById("ticket_subject").value;
		ticket_date = document.getElementById("ticket_date").value;
		due_date = document.getElementById("due_date").value;
		selectoption=document.getElementById("ticket_source");
		ticket_source=selectoption.options[selectoption.selectedIndex].text;
		selectoption=document.getElementById("help_topic");
		help_topic=selectoption.options[selectoption.selectedIndex].text;
		selectoption=document.getElementById("ticket_priority");
		ticket_priority=selectoption.options[selectoption.selectedIndex].text;
		selectoption=document.getElementById("ticket_status");
		ticket_status=selectoption.options[selectoption.selectedIndex].text;

		source_department = document.getElementById("source_department").value;
		ticket_assignor = document.getElementById("userid").value;
		assigned_department = document.getElementById("assigned_department").value;
		ticket_assignee = document.getElementById("ticket_assignee").value;
		ticket_message = document.getElementById("ticket_message").value;
		userid = document.getElementById("userid").value;
		usertime = document.getElementById("usertime").value;
		
		for(k=1; k<docrow; k++){
			docid = "docid"+k;
			docdesc = "docdesc"+k;
			if((k<(docrow))){
				docidvalue = document.getElementById(docid).value;
				docdescvalue = document.getElementById(docdesc).value;
			}
			supportdocs += "_~_" + docidvalue + "~_~" + docdescvalue;
		}
	}
	if(option=="updateRecord"){
		ticketno = document.getElementById("ticketno3").value;
		clientid = document.getElementById("clientid3").value;
		ticket_subject = document.getElementById("ticket_subject3").value;
		ticket_date = document.getElementById("ticket_date3").value;
		due_date = document.getElementById("due_date3").value;
		selectoption=document.getElementById("ticket_source3");
		ticket_source=selectoption.options[selectoption.selectedIndex].text;
		selectoption=document.getElementById("help_topic3");
		help_topic=selectoption.options[selectoption.selectedIndex].text;
		selectoption=document.getElementById("ticket_priority3");
		ticket_priority=selectoption.options[selectoption.selectedIndex].text;
		selectoption=document.getElementById("ticket_status3");
		ticket_status=selectoption.options[selectoption.selectedIndex].text;

		source_department = document.getElementById("source_department3").value;
		ticket_assignor = document.getElementById("userid3").value;
		assigned_department = document.getElementById("assigned_department3").value;
		ticket_assignee = document.getElementById("ticket_assignee3").value;
		ticket_message = document.getElementById("ticket_message3").value;
		userid = document.getElementById("userid3").value;
		usertime = document.getElementById("usertime3").value;
		
		for(k=1; k<docrow; k++){
			docid = "docid"+k;
			docdesc = "docdesc"+k;
			if((k<(docrow))){
				docidvalue = document.getElementById(docid).value;
				docdescvalue = document.getElementById(docdesc).value;
			}
			supportdocs += "_~_" + docidvalue + "~_~" + docdescvalue;
		}
	}

    var error = "";
	if (ticketno=="") error += "Ticket No must not be blank.<br><br>";
    if (clientid=="") error += "Client ID must not be blank.<br><br>";
    if (ticket_subject=="") error += "Ticket Subject must not be blank.<br><br>";
    //if (assigned_department=="") error += "Ticket must be assigned to a department.<br><br>";
    //if (ticket_assignee=="") error += "Ticket must be assigned to a staff.<br><br>";
    if (ticket_source=="Select Source") error += "Select a valid Ticket Source.<br><br>";
    if (help_topic=="Select Topic") error += "Select a valid Help Topic.<br><br>";
    if (ticket_priority=="Select Priority") error += "Select a valid Ticket Priority.<br><br>";
    if (ticket_status=="Select Status") error += "Select a valid Ticket Status.<br><br>";
    if (ticket_message=="") error += "Issue Summary must not be blank.<br><br>";
    if(ticket_date!=null && ticket_date!="") {
		ticket_date = ticket_date.substr(6,4)+'-'+ticket_date.substr(3,2)+'-'+ticket_date.substr(0,2);
	}else{
		ticket_date = "0000-00-00";
	}
    if(due_date!=null && due_date!="") {
		due_date = due_date.substr(6,4)+'-'+due_date.substr(3,2)+'-'+due_date.substr(0,2);
	}else{
		due_date = "0000-00-00";
	}
    
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+ticketno+"]["+clientid+"]["+ticket_subject+"]["+ticket_date+"]["+due_date;
    param += "]["+ticket_source+"]["+help_topic+"]["+ticket_priority+"]["+ticket_status+"]["+supportdocs;
	
	var param2 = "&param2="+serialno+"]["+ticketno+"]["+source_department+"]["+ticket_assignor;
    param2 += "]["+assigned_department+"]["+ticket_assignee+"]["+ticket_message+"]["+ticket_priority+"]["+ticket_status+"]["+userid+"]["+usertime;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+param2+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function saveStock(option, table){
	var equipmentcode=""; var transactiondate=""; var replenishedby=""; var requestedby=""; var approvedby=""; 
	var locations=""; var quantityin="0"; var quantityout="0"; var balance="0"; var narration=""; var lockrecord="No"; 
	var macaddress=""; var transtatus=""; 
	if(option=="addRecord"){
		equipmentcode = document.getElementById("equipmentcode").value;
		transactiondate = document.getElementById("transactiondate").value;
		if(readCookie("stockform")=="replenish") replenishedby = document.getElementById("replenishedby").value;
		if(readCookie("stockform")=="replenish") transtatus = "Replenished";
		if(readCookie("stockform")=="requisition") requestedby = document.getElementById("requestedby").value;
		if(readCookie("stockform")=="requisition") transtatus = "Pending";
		if(readCookie("stockform")=="approval") approvedby = document.getElementById("approvedby").value;
		if(readCookie("stockform")=="approval"){
			var selectoption=document.getElementById("transtatus");
			transtatus=selectoption.options[selectoption.selectedIndex].text;
		}
		locations = document.getElementById("locations").value;
		if(readCookie("stockform")=="replenish") quantityin = document.getElementById("quantityin").value;
		if(readCookie("stockform")=="requisition") quantityout = document.getElementById("quantityout").value;
		if(readCookie("stockform")=="approval") quantityout = document.getElementById("quantityout").value;
		narration=document.getElementById("narration").value;
		macaddress=document.getElementById("macaddress").value;
	}
	if(option=="updateRecord"){
		equipmentcode = document.getElementById("equipmentcode2").value;
		transactiondate = document.getElementById("transactiondate2").value;
		if(readCookie("stockform")=="replenish") replenishedby = document.getElementById("replenishedby2").value;
		if(readCookie("stockform")=="replenish") transtatus = "Replenished";
		if(readCookie("stockform")=="requisition" || readCookie("stockform")=="approval") requestedby = document.getElementById("requestedby2").value;
		if(readCookie("stockform")=="requisition") transtatus = "Pending";
		if(readCookie("stockform")=="approval") approvedby = document.getElementById("approvedby2").value;
		if(readCookie("stockform")=="approval"){
			var selectoption=document.getElementById("transtatus");
			transtatus=selectoption.options[selectoption.selectedIndex].text;
		}
		locations = document.getElementById("locations2").value;
		if(readCookie("stockform")=="replenish") quantityin = document.getElementById("quantityin2").value;
		if(readCookie("stockform")=="requisition") quantityout = document.getElementById("quantityout2").value;
		if(readCookie("stockform")=="approval") quantityout = document.getElementById("quantityout2").value;
		narration=document.getElementById("narration2").value;
		macaddress=document.getElementById("macaddress2").value;
	}

    var error = "";
	if (equipmentcode=="") error += "Equipment Code must not be blank.<br><br>";
    if(readCookie("stockform")=="replenish") if (replenishedby=="") error += "Replenished By must not be blank.<br><br>";
    if(readCookie("stockform")=="requisition") if (requestedby=="") error += "Approved By must not be blank.<br><br>";
    if(readCookie("stockform")=="approval") if (approvedby=="") error += "Requested By must not be blank.<br><br>";
    if (locations=="") error += "Location must not be blank.<br><br>";
    if(readCookie("stockform")=="replenish") if (quantityin=="") error += "Quantity In must not be blank.<br><br>";
    if(readCookie("stockform")=="requisition") if (quantityout=="") error += "Quantity Out must not be blank.<br><br>";
    if(readCookie("stockform")=="approval") if (quantityout=="") error += "Quantity Out must not be blank.<br><br>";
    if (narration=="") error += "Narration must not be blank.<br><br>";
    if (macaddress=="") error += "Mac Address must not be blank.<br><br>";
    if(transactiondate!=null && transactiondate!="") {
		transactiondate = transactiondate.substr(6,4)+'-'+transactiondate.substr(3,2)+'-'+transactiondate.substr(0,2);
	}else{
		transactiondate = "0000-00-00";
	}
    
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
	var param = "&param="+serialno+"]["+equipmentcode+"]["+transactiondate+"]["+replenishedby+"]["+requestedby+"]["+approvedby;
    param += "]["+locations+"]["+quantityin+"]["+quantityout+"]["+balance+"]["+narration+"]["+lockrecord+"]["+macaddress+"]["+transtatus;
	
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function saveAccountsRequisition(option, table, approvestatus){
	var department=""; var requisitiondate=""; var requestedby=""; var requestedamount="0"; var purpose=""; 
	var approvedby=""; var releasedby=""; var transtatus=approvestatus; var lockrecord=""; var superapprovedby=""; var reason="";
	     
	if(option=="addRecord"){
		department = document.getElementById("department").value;
		requisitiondate = document.getElementById("requisitiondate").value;
		//if(readCookie("requisitionform")=="request") transtatus = "Requested";
		if(readCookie("requisitionform")=="request") requestedby = document.getElementById("requestedby").value;
		requestedamount = document.getElementById("requestedamount").value;
		purpose=document.getElementById("purpose").value;
		createCookie("serialno", null, false);
	}
	if(option=="updateRecord"){
		department = document.getElementById("department2").value;
		requisitiondate = document.getElementById("requisitiondate2").value;
		//if(readCookie("requisitionform")=="request") transtatus = "Requested";
		requestedby = document.getElementById("requestedby2").value;
		//if(readCookie("requisitionform")=="supervisorapproval") transtatus = "SupervisorApproved";
		if(readCookie("requisitionform")=="supervisorapproval") superapprovedby = readCookie("currentuser");
		//if(readCookie("requisitionform")=="accountsapproval") transtatus = "AccountsApproved";
		if(readCookie("requisitionform")=="accountsapproval"){
			approvedby = readCookie("currentuser");
			superapprovedby = document.getElementById("superapprove").value;
		}
		//if(readCookie("requisitionform")=="release") transtatus = "Released";
		if(readCookie("requisitionform")=="release"){
			releasedby = readCookie("currentuser");
			approvedby = document.getElementById("approvedby2").value;
			superapprovedby = document.getElementById("superapprove").value;
		}
		requestedamount = document.getElementById("requestedamount2").value;
		purpose = document.getElementById("purpose2").value;
	}
	reason=document.getElementById("reason").value;

    var error = "";
	if (department=="") error += "Department must not be blank.<br><br>";
    if (requestedby=="") error += "Requested By must not be blank.<br><br>";
    if (purpose=="") error += "Purpose must not be blank.<br><br>";
    if (requestedamount=="" || isNaN(parseInt(requestedamount,10))) error += "Requested Amount must be numeric.<br><br>";
    if(requisitiondate!=null && requisitiondate!="") {
		requisitiondate = requisitiondate.substr(6,4)+'-'+requisitiondate.substr(3,2)+'-'+requisitiondate.substr(0,2);
	}else{
		requisitiondate = "0000-00-00";
	}
	if(approvestatus.match("Declined") ){
		if(reason==null || reason=="")  error += "Reason(s) for decline must not be blank.<br><br>";
    }

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    //document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    //$('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
	var param = "&param="+serialno+"]["+requisitiondate+"]["+department+"]["+requestedby+"]["+requestedamount+"]["+purpose;
    param += "]["+approvedby+"]["+releasedby+"]["+transtatus+"]["+lockrecord+"]["+superapprovedby+"]["+reason;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function doTransfer(){
	var originlocation = document.getElementById("locations1").value;
	var targetlocation = document.getElementById("locations2").value;
	var macaddress = document.getElementById("macaddress2").value;
	var quantity = document.getElementById("quantityout2").value;
	var transferedby = document.getElementById("transferedby2").value;
	var narration = document.getElementById("narration2").value;
	var equipmentcode = document.getElementById("equipmentcode2").value;
	var transactiondate = document.getElementById("transactiondate2").value;
    if(transactiondate!=null && transactiondate!="") {
		transactiondate = transactiondate.substr(6,4)+'-'+transactiondate.substr(3,2)+'-'+transactiondate.substr(0,2);
	}else{
		transactiondate = "0000-00-00";
	}

	var error="";
    if (originlocation=="") error += "Origin Location must not be blank.<br><br>";
    if (targetlocation=="") error += "Target Location must not be blank.<br><br>";
    if (originlocation==targetlocation) error += "Origin Location must be different from Target Location.<br><br>";
	if (equipmentcode=="") error += "Equipment Code must not be blank.<br><br>";
	if (quantity=="") error += "Quantity to ttransfer must not be blank.<br><br>";
	if (isNaN(parseInt(quantity,10)) && quantity.trim().length>0) error += "Quantity to ttransfer must be numeric.<br><br>";

	if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');

	var param = "&param="+originlocation+"]["+targetlocation+"]["+macaddress+"]["+quantity+"]["+transferedby+"]["+narration+"]["+equipmentcode+"]["+transactiondate;
	
    var url = "/mobiletech/setupbackend.php?option=stocktransfer&table=equipmentstock"+param;
	AjaxFunctionSetup(url);
}

function updateDepartment(option, table){
    var departmentdescription = document.getElementById("departmentdescription").value;
    var error = "";
    if (departmentdescription==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Department must not be blank.<br><br>";
        }
    }
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+departmentdescription;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateBasestation(option, table){
    var locations = document.getElementById("locations").value;
    var error = "";
    if (locations==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Location must not be blank.<br><br>";
        }
    }
    var basestationdescription = document.getElementById("basestationdescription").value;
	if (locations=="")error += "Base Station must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+basestationdescription+"]["+locations;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateLocation(option, table){
    var locationcode = document.getElementById("locationcode").value;
    var locationdescription = document.getElementById("locationdescription").value;
    var error = "";
    if (locationcode==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Location Code must not be blank.<br><br>";
        }
    }
    if (locationdescription=="") error += "Location must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+locationcode+"]["+locationdescription;
    var url = "/mobiletech/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

var myCheckboxes=0;
function doCheckboxes(){
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		if(document.getElementById('selectall').checked==true){
			document.getElementById(checkboxid).checked=true;
		}else{
			document.getElementById(checkboxid).checked=false;
		}
	}

}

function getRecords(table,serialno){
    if(serialno == null || serialno.length == 0) serialno = "1";
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/mobiletech/setupbackend.php?option=getAllRecs"+"&table="+table+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function populateRecords(serialno, table){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/mobiletech/setupbackend.php?option=getARecord"+"&table="+table+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function getRecordlist(arg2,arg3,arg4){
    curr_obj = document.getElementById(arg2);
    temp_table = arg3;
    list_obj = arg4;
    var url = "/mobiletech/setupbackend.php?option=getRecordlist&table="+arg3+"&currentobject="+arg2;
	AjaxFunctionSetup(url);
}

function populateCode(code){
	var vals = code.split("][");
	code = vals[0].replace(/#/g,' ');
	var name = "";
	var othername = "";
	if(vals[1]!=null) name = vals[1].replace(/#/g,' ');
	if(vals[2]!=null) othername = vals[2].replace(/#/g,' ');

    curr_obj.value = code;
    clearLists(list_obj);
	if(curr_obj.id=="locations" && readCookie('getlocation')=="1") {
		eraseCookie('getlocation');
		getClients();
	}
	if(curr_obj.id=="basestationdescription" && readCookie('getbasestation')=="1") {
		eraseCookie('getbasestation');
		getClients();
	}
	if(curr_obj.id=="clientidA" && readCookie('getclient')=="1") {
		eraseCookie('getclient');
		getTickets();
	}
	if(curr_obj.id=="staffid" && readCookie('getstaffB')=="1") {
		eraseCookie('getstaffB');
		document.getElementById("staffname").value = name + ", " + othername;
	}
	if(curr_obj.id=="locationA" && readCookie('getlocationB')=="1") {
		eraseCookie('getlocationB');
		getTickets();
	}
	if(curr_obj.id=="ticketnoA" && readCookie('geticketnoB')=="1") {
		eraseCookie('geticketnoB');
		getTickets();
	}
	if(curr_obj.id=="clientid" && readCookie('getclientB')=="1") {
		getMyClient(code);
	}
	if(curr_obj.id=="locationA" && readCookie('getlocationStock')=="1") {
		eraseCookie('getlocationStock');
		getStocks();
	}
	if(curr_obj.id=="equipmentcategoryA" && readCookie('getequipmentcategory')=="1") {
		eraseCookie('getequipmentcategory');
		getStocks();
	}
	if(curr_obj.id=="equipmentcodeA" && readCookie('getequipmentcode')=="1") {
		eraseCookie('getequipmentcode');
		getStocks();
	}
	if(curr_obj.id=="equipmentcode2" && readCookie('getequipmentcode')=="equipmentcategory2") {
		eraseCookie('getequipmentcode');
		document.getElementById("equipmentname2").value = name;
	}
	if((curr_obj.id=="departmentA" || curr_obj.id=="requestedbyA" || curr_obj.id=="superapprovedbyA" || curr_obj.id=="approvedbyA" || curr_obj.id=="releasedbyA") && readCookie('getRquisition')=="1") {
		eraseCookie('getRquisition');
		getAccountsRequisition(readCookie("requisitionform"));
	}
}

function clearLists(arg){
    if(arg==null) arg=list_obj;
    document.getElementById(arg).innerHTML = "";
}

function resetForm(table){
	if(table=="userstable"){
		document.getElementById("username").value = "";
		document.getElementById("firstname").value = "";
		document.getElementById("lastname").value = "";
		document.getElementById("useremail").value = "";
		document.getElementById("mobilephone").value = "";
		document.getElementById("officephone").value = "";
		document.getElementById("department").value = "";
		document.getElementById("location").value = "";
		document.getElementById("usersposition").value = "";
		loadImage("silhouette.JPG");
		document.getElementById("homeaddress").value = "";
		document.getElementById("groupemail").value = "";
    }
	if(table=="stafftable"){
		document.getElementById("staffid").value = "";
		document.getElementById("lastname").value = "";
		document.getElementById("firstname").value = "";
		document.getElementById("middlename").value = "";
		var selectoption=document.getElementById("active");
		selectoption.selectedIndex = 0;
		selectoption=document.getElementById("gender");
		selectoption.selectedIndex = 0;
		document.getElementById("jobtitle").value = "";
		document.getElementById("department").value = "";
		document.getElementById("supervisorid").value = "";
		document.getElementById("level").value = "";
		document.getElementById("employmentdate").value = "";
		document.getElementById("previouscontactaddress").value = "";
		document.getElementById("newcontactaddress").value = "";
		document.getElementById("mobilephonenumber").value = "";
		document.getElementById("homephonenumber").value = "";
		document.getElementById("birthdate").value = "";
		document.getElementById("emailaddress").value = "";
		selectoption=document.getElementById("maritalstatus");
		selectoption.selectedIndex = 0;
		document.getElementById("maidenname").value = "";
		document.getElementById("spousename").value = "";
		document.getElementById("spousephonenumber").value = "";
		document.getElementById("nextofkin").value = "";
		document.getElementById("nextofkinaddress").value = "";
		selectoption=document.getElementById("nextofkinrelationship");
		selectoption.selectedIndex = 0;
		document.getElementById("nextofkinphonenumber").value = "";
		loadImage("silhouette.JPG");
    }
	if(table=="appraisaltable"){
		document.getElementById("staffid2").value = "";
		document.getElementById("staffname2").value = "";
		var selectoption=document.getElementById("gender");
		selectoption.selectedIndex = 0;
		document.getElementById("jobtitle").value = "";
		document.getElementById("department").value = "";
		document.getElementById("supervisorid").value = "";
		document.getElementById("level").value = "";
		document.getElementById("employmentdate").value = "";
		document.getElementById("birthdate").value = "";
		document.getElementById("duties").value = "";
		document.getElementById("difficultduties").value = "";
		document.getElementById("interestingduties").value = "";
		document.getElementById("performanceimprove").value = "";
		document.getElementById("queryorsuspension").value = "";
		document.getElementById("training").value = "";
		document.getElementById("accomplishments").value = "";
		loadImage("silhouette.JPG");
	}
	if(table=="leavetable"){
		document.getElementById("staffid2").value = "";
		document.getElementById("lastname").value = "";
		document.getElementById("othernames").value = "";
		var selectoption=document.getElementById("gender");
		selectoption.selectedIndex = 0;
		document.getElementById("jobtitle").value = "";
		document.getElementById("department").value = "";
		document.getElementById("supervisorid").value = "";
		document.getElementById("level").value = "";
		document.getElementById("employmentdate").value = "";
		document.getElementById("birthdate").value = "";
		document.getElementById("leaveapplydate").value = "";
		document.getElementById("entitlement").value = "";
		document.getElementById("resumptiondate").value = "";
		document.getElementById("supervisor").value = "";
		document.getElementById("supervisorapproval").value = "";
		document.getElementById("adminid").value = "";
		document.getElementById("adminapproval").value = "";
		document.getElementById("leaveapprovedate").value = "";
		//document.getElementById("leavetype2").value = "";
		//document.getElementById("leavestart2").value = "";
		//document.getElementById("leaveend2").value = "";
		loadImage("silhouette.JPG");
	}
	if(table=="clientstable"){
		//document.getElementById("clientid").value = "";
		document.getElementById("clientname").value = "";
		document.getElementById("contactaddress").value = "";
		document.getElementById("officephone").value = "";
		document.getElementById("mobilephone").value = "";
		document.getElementById("emailaddress").value = "";
		document.getElementById("bandwidth").value = "";
		document.getElementById("instalationdate").value = "";
		document.getElementById("birthdate").value = "";
		document.getElementById("contactperson").value = "";
		document.getElementById("cpe").value = "";
		document.getElementById("radioipaddress").value = "";
		document.getElementById("ipaddress").value = "";
		document.getElementById("basestationipaddress").value = "";
		document.getElementById("configurationstatus").value = "";
    }
	if(table=="ticketstable"){
		//$('#ticketsform').dialog().title('Existing Ticket');
		document.getElementById("clientid").value = "";
		document.getElementById("ticket_subject").value = "";
		document.getElementById("due_date").value = "";
		document.getElementById("assigned_department").value = "";
		document.getElementById("ticket_assignee").value = "";
		document.getElementById("ticket_message").value = "";
		var selectoption=document.getElementById("ticket_source");
		selectoption.selectedIndex = 0;
		selectoption=document.getElementById("help_topic");
		selectoption.selectedIndex = 0;
		selectoption=document.getElementById("ticket_priority");
		selectoption.selectedIndex = 0;
		selectoption=document.getElementById("ticket_status");
		selectoption.selectedIndex = 0;
    }
	if(table=="departmentstable"){
		document.getElementById("departmentdescription").value="";
	}
	if(table=="basestationstable"){
		document.getElementById("basestationdescription").value="";
		document.getElementById("locations").value="";
	}
	if(table=="locationstable"){
		document.getElementById("locationcode").value="";
		document.getElementById("locationdescription").value="";
	}
	if(table=="equipmentstable"){
		document.getElementById("equipmentcode").value="";
		document.getElementById("equipmentname").value="";
		document.getElementById("equipmenttype").value="";
		document.getElementById("equipmentdescription").value="";
	}
}

function updateRecLocks(serialno, lock){
	if(lock=="No"){
		lock="Yes";
	}else{
		lock="No";
	}
    var param = "&param="+serialno+"]["+lock;
    var url = "/mobiletech/setupbackend.php?option=updateRecLocks"+param;
	AjaxFunctionSetup(url);
}

function updateSuperApproval(serialno, lock){
	if(lock==""){
		lock=readCookie("currentuser");
	}else{
		lock="";
	}
    var param = "&param="+serialno+"]["+lock;
    var url = "/mobiletech/setupbackend.php?option=updateSuperApproval"+param;
	AjaxFunctionSetup(url);
}

function updateApproval(serialno, lock){
	if(lock==""){
		lock=readCookie("currentuser");
	}else{
		lock="";
	}
    var param = "&param="+serialno+"]["+lock;
    var url = "/mobiletech/setupbackend.php?option=updateApproval"+param;
	AjaxFunctionSetup(url);
}

function updateRelease(serialno, lock){
	if(lock==""){
		lock=readCookie("currentuser");
	}else{
		lock="";
	}
    var param = "&param="+serialno+"]["+lock;
    var url = "/mobiletech/setupbackend.php?option=updateRelease"+param;
	AjaxFunctionSetup(url);
}

function viewMenu(access){
	createCookie("access",access,false);
	window.location="home.php?pgid=1";
}

var xmlhttp

function AjaxFunctionSetup(arg){
	arg = arg.replace(/ & /g,'_amp_');
	//var str = '~!@#$%^&*(){}[]=:/,;?+\'"\\';
	//alert(str+"   "+encodeURIComponent(str));
	//alert(str+"   "+encodeURI(str));
	//alert(str+"   "+escape(str));

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
        if(resp.match("copyCourses")){
			//alert(resp);
		}
        if(resp.match("checkAccess")){
            if(resp.match("checkAccessSuccess")){
                break_resp = resp.split("checkAccessSuccess");
				if(break_resp[1].match("View Leave")){
					listLeave('');
				}else if(break_resp[1].match("View Appraisal")){
					listAppraisal('');
				}else{
					window.location="home.php?pgid=1";
				}
            }else{
                break_resp = resp.split("checkAccessFailed");
                resp = "<b>Access Denied!!!</b><br><br>Menu ["+break_resp[1]+"] not accessible by "+readCookie("currentuser");
                document.getElementById("showError").innerHTML = resp;
                $('#showError').dialog('open');
            }
        }

        if(resp.match("nextClientNo")){
            break_resp = resp.split("nextClientNo");
			var code = break_resp[1].substr(0,3);
			var num = "";
			if(break_resp[1].substr(3)==null || break_resp[1].substr(3)==""){
				num = "1";
			}else if(break_resp[1].substr(3,3)=="000"){
				num = (parseInt(break_resp[1].substr(6),10)+1)+"";
			}else if(break_resp[1].substr(3,2)=="00"){
				num = (parseInt(break_resp[1].substr(5),10)+1)+"";
			}else if(break_resp[1].substr(3,1)=="0"){
				num = (parseInt(break_resp[1].substr(4),10)+1)+"";
			}else if(break_resp[1].substr(3,1)!="0"){
				num = (parseInt(break_resp[1].substr(3),10)+1)+"";
			}
			if(num<"9999"){
				var len = num.length;
				num="000".substr(0,4-len)+num;
			}
			document.getElementById("clientid").value=code+num;
		}
        if(resp.match("getAllRecs")){
//document.getElementById("showPrompt").innerHTML = readCookie("myquery");
//$('#showPrompt').dialog('open'); 
            break_resp = resp.split("getAllRecs");
            var allrecords = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
            allrecords += "<tr style='font-weight:bold; color:white'>";
            if(break_resp[0]=="userstable"){
                allrecords += "<td align='right'>S/No</td><td>User-Id</td><td>Last Name</td><td>First Name</td><td>Active</td></tr>";
            }else if(break_resp[0]=="stafftable"){
                allrecords += "<td align='right'>S/No</td><td>Staff-Id</td><td>Last Name</td><td>First Name</td><td>Active</td></tr>";
            }else if(break_resp[0]=="appraisaltable"){
                allrecords += "<td align='right'>S/No</td><td>Staff-Id</td><td>Staff Name</td><td>Appraisal_Date</td><td>Appraisal_From</td><td>Appraisal_To</td></tr>";
            }else if(break_resp[0]=="leavetable"){
                allrecords += "<td align='right'>S/No</td><td>Staff-Id</td><td>Staff Name</td><td>Leave_Type</td><td>Leave_Start</td><td>Leave_End</td><td>Supervisor_Approval</td><td>Admin_Approval</td></tr>";
            }else if(break_resp[0]=="clientstable"){
                allrecords += "<td align='right'>S/No</td><td>Client-Id</td><td>Client Name</td><td>Contact Address</td><td>Active</td></tr>";
            }else if(break_resp[0]=="ticketstable"){
                allrecords += "<td align='right'>S/No</td><td>Ticket No</td><td>Client_Id</td><td>Subject</td><td>Date_Created</td><td>Ticket_Author</td>";
				allrecords += "<td>Assigned_To</td><td>Help_Topic</td><td>Priority</td><td>Location</td><td>Client_Type</td><td>Status</td></tr>";
            }else if(break_resp[0]=="equipmentstock" && readCookie("stockform")=="history"){
                allrecords += "<td align='right'>S/No</td><td>Code</td><td>Name</td><td>Date</td><td>Location</td><td>Narration</td><td>Category</td>";
				allrecords += "<td>Mac Address</td><td align='right'>Quantity-In</td><td align='right'>Quantity-Out</td><td align='right'>Balance</td></tr>";
            }else if(break_resp[0]=="equipmentstock"){
                allrecords += "<td align='right'>S/No</td><td>Code</td><td>Name</td><td>Date</td><td>Author</td><td>Location</td><td align='right'>Quantity</td><td>Narration</td>";
				allrecords += "<td>Category</td>";
				if(readCookie("stockform")!="rquisition") allrecords += "<td>Mac Address</td>";
				if(readCookie("stockform")=="approval") allrecords += "<td>Base Station</td>";
				if(readCookie("stockform")=="approval") allrecords += "<td>Client ID</td>";
				if(readCookie("stockform")=="view") allrecords += "<td align='right'>Balance</td>";
				if(readCookie("stockform")=="lockrec") allrecords += "<td>Lock Status</td>";
				allrecords += "</tr>";
			}else if(break_resp[0]=="ticket_history"){
                populateTicketHistory(resp);
				return true;
            }else if(break_resp[0]=="departmentstable"){
                allrecords += "<td width='10%' align='right'>S/No</td><td>Departments</td></tr>";
            }else if(break_resp[0]=="basestationstable"){
                allrecords += "<td width='10%' align='right'>S/No</td><td>Base Stations</td><td>Locations</td></tr>";
            }else if(break_resp[0]=="locationstable"){
                allrecords += "<td width='10%' align='right'>S/No</td><td>Code</td><td>Location</td></tr>";
            }else if(break_resp[0]=="equipmentstable"){
                allrecords += "<td width='10%' align='right'>S/No</td><td>Code</td><td>Name</td><td>Type</td><td>Description</td></tr>";
            }else if(break_resp[0]=="requisitiontable"){
                allrecords += "<td width='10%' align='right'>S/No</td><td>Date</td><td>Department</td><td>Staff</td><td align='right'>Amount</td><td>Purpose</td><td>Status</td>";
				if(readCookie("requisitionform")=="supervisorapproval")
					allrecords += "<td>Approval</td>";
				if(readCookie("requisitionform")=="accountsapproval")
					allrecords += "<td>Approval</td>";
				if(readCookie("requisitionform")=="release")
					allrecords += "<td>Release</td>";
				if(readCookie("requisitionform")=="view")
					allrecords += "<td>Approval/Release</td>";
				allrecords += "</tr>";
            }
            var recordlist = null;
            if(break_resp[0]=="userstable") recordlist = document.getElementById('userslist');
            if(break_resp[0]=="stafftable") recordlist = document.getElementById('stafflist');
            if(break_resp[0]=="appraisaltable") recordlist = document.getElementById('appraisallist');
            if(break_resp[0]=="leavetable") recordlist = document.getElementById('leavelist');
            if(break_resp[0]=="clientstable") recordlist = document.getElementById('clientlist');
            if(break_resp[0]=="ticketstable") recordlist = document.getElementById('ticketslist');
            if(break_resp[0]=="departmentstable") recordlist = document.getElementById('departmentlist');
            if(break_resp[0]=="basestationstable") recordlist = document.getElementById('basestationlist');
            if(break_resp[0]=="locationstable") recordlist = document.getElementById('locationlist');
            if(break_resp[0]=="equipmentstable") recordlist = document.getElementById('equipmentslist');
            if(break_resp[0]=="equipmentstock") recordlist = document.getElementById('stockslist');
            if(break_resp[0]=="requisitiontable") recordlist = document.getElementById('requisitionslist');
            var counter = 0;
            var rsp = "";
			//serialno, requisitiondate, department, requestedby, requestedamount, purpose, approvedby, releasedby

            var flg = 0;
            var break_row = "";
            var compare0 = "userstable stafftable appraisaltable leavetable clientstable ticketstable equipmentstable equipmentstock locationstable basestationstable requisitiontable ";
            var compare1 = "userstable stafftable appraisaltable leavetable clientstable ticketstable equipmentstable equipmentstock requisitiontable ";
            var compare2 = "userstable stafftable appraisaltable leavetable clientstable ticketstable equipmentstable equipmentstock requisitiontable ";
            var compare3 = "appraisaltable leavetable ticketstable equipmentstock requisitiontable ";
            var compare4 = "leavetable ticketstable equipmentstock requisitiontable ";
            var compare5 = "leavetable ticketstable equipmentstock requisitiontable ";
            var compare6 = "ticketstable equipmentstock ";
            var compare7 = "ticketstable equipmentstock ";
            var compare8 = "ticketstable equipmentstock ";
            var compare9 = "ticketstable equipmentstock ";
            var compare10 = "equipmentstock ";
            for(var i=1; i < (break_resp.length-1); i++){
                break_row = break_resp[i].split("_~_");
				if(readCookie("mytickets")!=null)
					if(readCookie("mytickets")==readCookie("currentuser"))
						if(readCookie("mytickets")!=break_row[5]) continue;
                if (flg == 1) {
                    flg = 0;
                    rsp += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
                } else {
                    flg = 1;
                    rsp += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
                }
				rsp += "<td align='right'>" + (++counter) + ".</td>";
				if(break_resp[0]=="equipmentstock"){
					var clickable=true;
					//if(readCookie("stockform")=="replenish" && break_row[5]>"") clickable=false;
					//if(readCookie("stockform")=="replenish" && break_row[4]>"") clickable=true;
					//if(readCookie("stockform")=="requisition" && break_row[4]>"") clickable=false;
					//if(readCookie("stockform")=="requisition" && break_row[5]>"") clickable=true;
					//if(readCookie("stockform")=="approval" && break_row[4]>"") clickable=false;
					//if(readCookie("stockform")=="approval" && break_row[5]>"") clickable=true;
					//if(readCookie("stockform")=="view") clickable=true;
					if(readCookie("stockform")=="lockrec") clickable=false;
					if(readCookie("stockform")=="view") clickable=false;
					if(clickable){
						rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[1] + "</a></td>";
					}else{
						rsp += "<td>" + break_row[1] + "</a></td>";
					}
				}else if(break_resp[0]=="requisitiontable"){
					if(break_row[1]==null || break_row[1]=="" || break_row[1]=="0000-00-00"){
						break_row[1]="";
					}else{
						break_row[1] = break_row[1].substr(8,2)+"/"+break_row[1].substr(5,2)+"/"+break_row[1].substr(0,4);
					}
					if((readCookie("requisitionform")=="request" && break_row[8]!="Requested") 
						|| (readCookie("requisitionform")=="supervisorapproval" && break_row[8]!="Requested") 
						|| (readCookie("requisitionform")=="accountsapproval" && break_row[8]!="SupervisorApproved") 
						|| (readCookie("requisitionform")=="release" && break_row[8]!="AccountsApproved") 
						|| (break_row[8].match("Declined") && readCookie("requisitionform")!="view") ){
						rsp += "<td>" + break_row[1] + "</td>";
					}else{
						rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[1] + "</a></td>";
					}
				}else{
					rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[1] + "</a></td>";
				}
				if(compare0.match(break_resp[0])){
					if(break_resp[0]=="userstable"){
						rsp += "<td>" + break_row[4] + "</td>";
					}else if(break_resp[0]=="stafftable"){
						rsp += "<td>" + break_row[3] + "</td>";
					}else if(break_resp[0]=="clientstable"){
						rsp += "<td>" + break_row[2] + "</td>";
					}else{
						rsp += "<td>" + break_row[2] + "</td>";
					}
				}
				if(compare1.match(break_resp[0])){
					if(break_resp[0]=="userstable"){
						rsp += "<td>" + break_row[3] + "</td>";
					}else if(break_resp[0]=="stafftable"){
						rsp += "<td>" + break_row[2] + "</td>";
					}else if(break_resp[0]=="clientstable"){
						rsp += "<td>" + break_row[5] + "</td>";
					}else if(break_resp[0]=="equipmentstock" || break_resp[0]=="appraisaltable"){
						if(break_row[3]==null || break_row[3]=="" || break_row[3]=="0000-00-00"){
							break_row[3]="";
						}else{
							break_row[3]=break_row[3].substr(8,2)+"/"+break_row[3].substr(5,2)+"/"+break_row[3].substr(0,4);
						}
						rsp += "<td>" + break_row[3] + "</td>";
					}else{
						rsp += "<td>" + break_row[3] + "</td>";
					}
				}
//$query = "SELECT a.serialno, a.equipmentcode, b.equipmentname, a.transactiondate, '', a.location, '', a.narration,  
//b.equipmentcategory, a.macaddress, a.quantityin, a.quantityout, a.balance FROM equipmentstock a, equipmentstable b where a.location='{$locations}' and a.equipmentcode=b.equipmentcode and a.equipmentcode<>'' order by a.location, a.equipmentcode, a.transactiondate, a.serialno ";
				if(compare2.match(break_resp[0])){
					if(break_resp[0]=="userstable"){
						rsp += "<td>" + break_row[13] + "</td>";
					}else if(break_resp[0]=="stafftable"){
						rsp += "<td>" + break_row[5] + "</td>";
					}else if(break_resp[0]=="clientstable"){
						rsp += "<td>" + break_row[18] + "</td>";
					}else if(break_resp[0]=="requisitiontable"){
						rsp += "<td align='right'>" + numberFormat(break_row[4]) + "</td>";
					}else if(break_resp[0]=="ticketstable" || break_resp[0]=="leavetable"){
						if(break_row[4]==null || break_row[4]=="" || break_row[4]=="0000-00-00"){
							break_row[4]="";
						}else{
							break_row[4]=break_row[4].substr(8,2)+"/"+break_row[4].substr(5,2)+"/"+break_row[4].substr(0,4);
						}
						rsp += "<td>" + break_row[4] + "</td>";
					}else{
						rsp += "<td>" + break_row[4] + "</td>";
					}
				}
				if(compare3.match(break_resp[0])){
					if(break_resp[0]=="requisitiontable"){
						rsp += "<td>" + break_row[5].substr(0,50) + "</td>";
					}else if(break_resp[0]=="leavetable"){
						if(break_row[5]==null || break_row[5]=="" || break_row[5]=="0000-00-00"){
							break_row[5]="";
						}else{
							break_row[5]=break_row[5].substr(8,2)+"/"+break_row[5].substr(5,2)+"/"+break_row[5].substr(0,4);
						}
						rsp += "<td>" + break_row[5] + "</td>";
					}else{
						rsp += "<td>" + break_row[5] + "</td>";
					}
				}
				if(compare4.match(break_resp[0])){
					if(break_resp[0]=="equipmentstock" && readCookie("stockform")!="view" && readCookie("stockform")!="history"){
						rsp += "<td align='right'>" + (break_row[6]) + "</td>";
					}else if(break_resp[0]=="requisitiontable"){
						// && readCookie("requisitionform")=="request"
						rsp += "<td>" + (break_row[8]) + "</td>";
					}else {
						rsp += "<td>" + break_row[6] + "</td>";
					}
				}
				if(compare5.match(break_resp[0])){
					if(break_resp[0]=="requisitiontable" && readCookie("requisitionform")=="supervisorapproval"){
						var lock = break_row[8];
						var lockid="lockid"+i;
						if (lock == "Requested") {
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' onClick=updateSuperApproval('"+break_row[0]+"','"+lock+"') >&nbsp;[Open]</td>";
						} else {
							if(break_row[10]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[10]+"</td>";
							}else if(break_row[6]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[6]+"</td>";
							}else if(break_row[7]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[7]+"</td>";
							}
						}
					}else if(break_resp[0]=="requisitiontable" && readCookie("requisitionform")=="accountsapproval"){
						var lock = break_row[8];
						var lockid="lockid"+i;
						if (lock=="SupervisorApproved") {
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[10]+"</td>";
						} else {
							if( lock == "Requested"){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[3]+"</td>";
							}else if(break_row[10]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[10]+"</td>";
							}else if(break_row[6]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[6]+"</td>";
							}else if(break_row[7]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[7]+"</td>";
							}
						}
					}else if(break_resp[0]=="requisitiontable" && readCookie("requisitionform")=="release"){
						var lock = break_row[8];
						var lockid="lockid"+i;
						if (lock=="AccountsApproved") {
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' onClick=updateRelease('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[6]+"</td>";
						} else {
							if( lock == "Requested"){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[3]+"</td>";
							}else if(break_row[10]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[10]+"</td>";
							}else if(break_row[6]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[6]+"</td>";
							}else if(break_row[7]!=""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[7]+"</td>";
							}
						}
					}else if(break_resp[0]=="requisitiontable" && readCookie("requisitionform")=="view"){
						var lock = break_row[8];
						var lockid="lockid"+i;
						/*if(break_row[7]!=""){
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;Released By "+break_row[7]+"</td>";
						}else if(break_row[6]!=""){
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;Accounts Approval By "+break_row[6]+"</td>";
						}else{
							if(break_row[10]==""){
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;[Open]</td>";
							}else{
								rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateSuperApproval('"+break_row[0]+"','"+lock+"') >&nbsp;Accounts Approval By "+break_row[10]+"</td>";
							}
						}*/
						if( lock == "Requested"){
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[3]+"</td>";
						}else if(break_row[10]!=""){
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[10]+"</td>";
						}else if(break_row[6]!=""){
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[6]+"</td>";
						}else if(break_row[7]!=""){
							rsp += "<td><input type='checkbox' id='"+lockid+"' disabled='true' checked onClick=updateApproval('"+break_row[0]+"','"+lock+"') >&nbsp;"+break_row[8]+" By "+break_row[7]+"</td>";
						}
					}else if(break_resp[0]=="requisitiontable" && readCookie("requisitionform")=="request"){
						//do nothing
					}else {
						rsp += "<td>" + break_row[7] + "</td>";
					}
				}
				if(compare6.match(break_resp[0])){
					if(break_resp[0]=="equipmentstock" && readCookie("stockform")=="history"){
						rsp += "<td align='right'>" + break_row[8] + "</td>";
					}else{
						rsp += "<td>" + break_row[8] + "</td>";
					}
				}
				if(compare7.match(break_resp[0])){
					if(break_resp[0]=="ticketstable"){
						rsp += "<td>" + break_row[10] + "</td>";
					}else if(break_resp[0]=="equipmentstock" && readCookie("stockform")=="history"){
						rsp += "<td align='right'>" + (break_row[9]) + "</td>";
					}else if(break_resp[0]=="equipmentstock" && readCookie("stockform")!="rquisition"){
						rsp += "<td>" + (break_row[9]) + "</td>";
					}else{
						rsp += "<td>" + break_row[9] + "</td>";
					}
				}
				if(compare8.match(break_resp[0])){
					if(break_resp[0]=="ticketstable"){
						rsp += "<td>" + break_row[11] + "</td>";
					}else if(break_resp[0]=="equipmentstock" && readCookie("stockform")=="approval"){
						rsp += "<td>" + break_row[10] + "</td>";
					}else if(break_resp[0]=="equipmentstock" && readCookie("stockform")=="view"){
						rsp += "<td align='right'>" + break_row[10] + "</td>";
					}else if(break_resp[0]=="equipmentstock" && readCookie("stockform")=="history"){
						rsp += "<td align='right'>" + (break_row[10]) + "</td>";
					}else{
						rsp += "<td>" + break_row[10] + "</td>";
					}
				}
				if(compare9.match(break_resp[0])){
					if(break_resp[0]=="ticketstable"){
						rsp += "<td>" + break_row[9] + "</td>";
					}else if(break_resp[0]=="equipmentstock" && readCookie("stockform")=="approval"){
						rsp += "<td>" + break_row[11] + "</td>";
					}else{
						rsp += "<td>" + break_row[11] + "</td>";
					}
				}
				if(compare10.match(break_resp[0])){
					if(break_resp[0]=="equipmentstock"){
						if(readCookie("stockform")=="lockrec"){
							var lock = break_row[12];
							var lockid="lockid"+i;
							if (lock == "No") {
								rsp += "<td><input type='checkbox' id='"+lockid+"' onClick=updateRecLocks('"+break_row[0]+"','"+lock+"') >&nbsp;[Open]</td>";
							} else {
								rsp += "<td><input type='checkbox' id='"+lockid+"' checked onClick=updateRecLocks('"+break_row[0]+"','"+lock+"') >&nbsp;[Locked]</td>";
							}
						}
					}else{
						rsp += "<td>" + break_row[12] + "</td>";
					}
				}
				rsp += "</tr>";
            }
            recordlist.innerHTML = allrecords+rsp+"</table>";
			eraseCookie("mytickets");
        }

        if(resp.match("updateRecLocks")) getStocks();

        if(resp.match("updateSuperApproval")) getAccountsRequisition(readCookie("requisitionform"));

		if(resp.match("updateApproval")) getAccountsRequisition(readCookie("requisitionform"));

        if(resp.match("updateRelease")) getAccountsRequisition(readCookie("requisitionform"));

        if(resp.match("getRecordlist")){
//document.getElementById("showPrompt").innerHTML = readCookie('myquery');
//$('#showPrompt').dialog('open');

            var keyword = curr_obj.value;
            var allCodes = resp.split("getRecordlist");
            var inner_codeslist = "";
            if(navigator.appName == "Microsoft Internet Explorer"){
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:60%;background-color:#336699;margin-top:5px;'>";
            }else{
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
            }
            inner_codeslist += "<tr style='font-weight:bold; color:white'>";
            inner_codeslist += "<td colspan='3' align='right'><a title='Close' style='font-weight:bold; font-size:20px; color:white;background-color:red;' href='javascript:clearLists()'>X</a></td></tr>";

            var codeslist = document.getElementById(list_obj);
            codeslist.style.zIndex = 100;
            codeslist.style.position = "absolute";

			codeslist.style.top = ($(curr_obj).position().top + 23) + 'px';
            codeslist.style.left = ($(curr_obj).position().left) + 'px';
			
			if(curr_obj.id=='assigned_department' || curr_obj.id=='assigned_department3' || curr_obj.id=='ticket_assignee' || curr_obj.id=='ticket_assignee3'){
				codeslist.style.top = (findPosY(curr_obj) - 85) + 'px';
				codeslist.style.left = (findPosX(curr_obj) - 285) + 'px';
			}
            var token = "";
            var tokensent = "";
            counter = 1;
            var colorflag = 0;
            var k=0;

            if(keyword.trim().length==0){
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0){
                        token = allCodes[k].split("_~_");
                        tokensent = token[1].replace(/ /g,'#');
                        if(token[2]!=null && token[2]!="") tokensent += "][" + token[2].replace(/ /g,'#');
                        if(token[3]!=null && token[3]!="") tokensent += "][" + token[3].replace(/ /g,'#');
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
                        inner_codeslist += "<td align='right'>"+(counter++)+".</td><td><a href=javascript:populateCode('"+tokensent+"')>"+token[1]+"</a></td>";
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
                        if(token[3]!=null && token[3]!="") inner_codeslist += "<td>"+token[3]+"</td>";
                        if(token[4]!=null && token[4]!="") inner_codeslist += "<td>"+token[4]+"</td>";
                        if(token[5]!=null && token[5]!="") inner_codeslist += "<td>"+token[5]+"</td>";
                        inner_codeslist += "</tr>";
                    }
                }
            } else {
                for(k=0; k<allCodes.length; k++){
                    if(curr_obj.id=='lecturerid' && !allCodes[k].match("Staff")) continue;
                    if(allCodes[k].trim().length>0 && (allCodes[k].toUpperCase().match(keyword.toUpperCase()))){
                        token = allCodes[k].split("_~_");
                        tokensent = token[1].replace(/ /g,'#');
                        if(token[2]!=null && token[2]!="") tokensent += "][" + token[2].replace(/ /g,'#');
                        if(token[3]!=null && token[3]!="") tokensent += "][" + token[3].replace(/ /g,'#');
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
                        inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+tokensent+"')>"+token[1]+"</a></td>";
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
                        if(token[3]!=null && token[3]!="") inner_codeslist += "<td>"+token[3]+"</td>";
                        if(token[4]!=null && token[4]!="") inner_codeslist += "<td>"+token[4]+"</td>";
                        if(token[5]!=null && token[5]!="") inner_codeslist += "<td>"+token[5]+"</td>";
                        inner_codeslist += "</tr>";
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
//document.getElementById("showPrompt").innerHTML = resp;
//$('#showPrompt').dialog('open'); 
            break_resp = resp.split("getARecord");
            createCookie("serialno",break_resp[1],false)
            var selectoption = null;

            if(break_resp[0]=="equipmentcode"){
                document.getElementById("equipmentname").value = break_resp[1];
			}
            if(break_resp[0]=="equipmentstable"){
                document.getElementById("equipmentcode").disabled = true;
                document.getElementById("equipmentcode").value = break_resp[2];
                document.getElementById("equipmentname").value = break_resp[3];
                document.getElementById("equipmenttype").value = break_resp[4];
                document.getElementById("equipmentdescription").value = break_resp[5];
				$('#equipmentsdetail').dialog('open');
				$('#equipmentslist').dialog('close');
			}
            if(break_resp[0]=="equipmentstock"){
				if(break_resp[14]=="Yes"){
					document.getElementById("showError").innerHTML = "<b>Record Locked!!!<b><br><br>This record can not be edited, it has been locked.";
					$('#showError').dialog('open');
					return true;
				}
                document.getElementById("locations2").value = break_resp[8];
                document.getElementById("equipmentcategory2").value = break_resp[12];
                document.getElementById("equipmentcode2").value = break_resp[2];
                document.getElementById("equipmentname2").value = break_resp[3];
				if(break_resp[4]==null || break_resp[4]=="" || break_resp[4]=="0000-00-00"){
					document.getElementById("transactiondate2").value="";
				}else{
					document.getElementById("transactiondate2").value = break_resp[4].substr(8,2)+"/"+break_resp[4].substr(5,2)+"/"+break_resp[4].substr(0,4);
				}
                if(readCookie("stockform")=="replenish") document.getElementById("replenishedby2").value = break_resp[5];
                if(readCookie("stockform")=="replenish") document.getElementById("quantityin2").value = (break_resp[9]);
                if(readCookie("stockform")=="requisition" || readCookie("stockform")=="approval") document.getElementById("requestedby2").value = break_resp[6];
                if(readCookie("stockform")=="requisition") document.getElementById("quantityout2").value = (break_resp[10]);
                if(readCookie("stockform")=="approval") document.getElementById("approvedby2").value = readCookie("currentuser");
                if(readCookie("stockform")=="approval") document.getElementById("quantityout2").value = (break_resp[10]);

				if(readCookie("stockform")=="view") document.getElementById("replenishedby2").value = break_resp[5];
                if(readCookie("stockform")=="view") document.getElementById("requestedby2").value = break_resp[6];
                if(readCookie("stockform")=="view") document.getElementById("approvedby2").value = break_resp[7];
                if(readCookie("stockform")=="view") document.getElementById("quantityin2").value = (break_resp[9]);
                if(readCookie("stockform")=="view") document.getElementById("quantityout2").value = (break_resp[10]);
                if(readCookie("stockform")=="view") document.getElementById("balance2").value = (break_resp[11]);
                if(readCookie("stockform")=="view") document.getElementById("transtatus2").value = break_resp[16];
                document.getElementById("narration2").value = break_resp[13];
				document.getElementById("lockrec").value = break_resp[14];
				document.getElementById("macaddress2").value = break_resp[15];
				if(readCookie("stockform")=="approval"){
					var selectoption = document.getElementById("transtatus");
					for(k=0; selectoption.options[k].text != null; k++){
						if(selectoption.options[k].text == break_resp[16]){
							selectoption.selectedIndex = k;
							break;
						}
					}
				}else{
					document.getElementById("transtatus").value=break_resp[16];
				}
				if(readCookie("stockform")=="replenish") $('#stockreplenishupdate').dialog('open');
				if(readCookie("stockform")=="requisition") $('#stockrequestupdate').dialog('open');
				if(readCookie("stockform")=="approval") $('#stockapprovalupdate').dialog('open');
				if(readCookie("stockform")=="view") $('#stockview').dialog('open');
				$('#stocklist').dialog('close');
			}
            if(break_resp[0]=="requisitiontable"){
				if(break_resp[10]=="Yes" && readCookie("requisitionform")!="view"){
					document.getElementById("showError").innerHTML = "<b>Record Locked!!!<b><br><br>This record can not be edited, it has been locked.";
					$('#showError').dialog('open');
					return true;
				}
				if(readCookie("requisitionform")=="request" && break_resp[7] != ""){
					document.getElementById("showError").innerHTML = "<b>Record Approved!!!<b><br><br>This record can not be edited, it has been approved.";
					$('#showError').dialog('open');
					return true;
				}
                document.getElementById("requisitiondate2").value = "";
                document.getElementById("department2").value = "";
                document.getElementById("requestedby2").value = "";
                document.getElementById("requestedamount2").value = "";
                document.getElementById("purpose2").value = "";
				document.getElementById("superapprove").value = "";
				document.getElementById("approvedby2").value = "";
				document.getElementById("releasedby2").value = "";
				document.getElementById("transtatus").value = "";
				document.getElementById("lockrec").value = "";
				document.getElementById("reason").value = "";

				if(break_resp[2]==null || break_resp[2]=="" || break_resp[2]=="0000-00-00"){
					document.getElementById("requisitiondate2").value="";
				}else{
					document.getElementById("requisitiondate2").value = break_resp[2].substr(8,2)+"/"+break_resp[2].substr(5,2)+"/"+break_resp[2].substr(0,4);
				}
                document.getElementById("department2").value = break_resp[3];
                document.getElementById("requestedby2").value = break_resp[4];
                document.getElementById("requestedamount2").value = numberFormat(break_resp[5]);
                document.getElementById("purpose2").value = break_resp[6];
                
				if(readCookie("requisitionform")=="supervisorapproval") {
					// && break_resp[7]!=""
					document.getElementById("approvedby2").value = break_resp[11];
					if(document.getElementById("approvedby2").value =="") 
						document.getElementById("approvedby2").value = readCookie("currentuser");
				}
				if(readCookie("requisitionform")=="accountsapproval"){
					// && break_resp[7]!=""
					document.getElementById("approvedby2").value = break_resp[7];
					document.getElementById("superapprove").value = break_resp[11];
					if(document.getElementById("approvedby2").value =="") 
						document.getElementById("approvedby2").value = readCookie("currentuser");
				}
                if(readCookie("requisitionform")=="release") {
					// && break_resp[8]!=""
					document.getElementById("releasedby2").value = break_resp[8];
					document.getElementById("approvedby2").value = break_resp[7];
					document.getElementById("superapprove").value = break_resp[11];
					if(document.getElementById("releasedby2").value =="") 
						document.getElementById("releasedby2").value = readCookie("currentuser");
				}
				if(readCookie("requisitionform")=="view"){
					document.getElementById("approvedby2").value = break_resp[7];
					document.getElementById("releasedby2").value = break_resp[8];
					document.getElementById("transtatus").value = break_resp[9];
					document.getElementById("superapprove").value = break_resp[11];
				}
				if(readCookie("requisitionform")=="request"){
					document.getElementById("transtatus").value = break_resp[9];
					document.getElementById("lockrec").value = break_resp[10];
				}
				if(break_resp[12]==""){
					//document.getElementById("reason").value = break_resp[9];
				}else{
					document.getElementById("reason").value = break_resp[12];
				}

				$('#requisitionlist').dialog('close');
				if(readCookie("requisitionform")=="request") $('#accountsrequisitionupdate').dialog('open');
				if(readCookie("requisitionform")=="supervisorapproval") $('#supervisorapprovalupdate').dialog('open');
				if(readCookie("requisitionform")=="accountsapproval") $('#accountsapprovalupdate').dialog('open');
				if(readCookie("requisitionform")=="release") $('#accountsreleaseupdate').dialog('open');
				if(readCookie("requisitionform")=="view") $('#accountsviewupdate').dialog('open');
			}
            if(break_resp[0]=="ticketno"){
				document.getElementById("assigned_department").value = "";
				document.getElementById("ticket_assignee").value = "";
				document.getElementById("ticket_message").value = "";
				$('#ticketsformnew').dialog('open');
				$('#ticketlist').dialog('close');
				if(break_resp[1]==null || break_resp[1]=="") break_resp[1]="0";
				var ticketno=(parseInt(break_resp[1],10)+1)+"";
				if(ticketno.length<10)
					ticketno = "0000000000".substring(0, 10-ticketno.length)+ticketno;
                document.getElementById("ticketno").value = ticketno;
				var d = new Date();
				var month = d.getMonth()+1;
				var day  = "";
				var mon  = "";
				var year  = "";
				var hour  = "";
				var min  = "";
				var sec  = "";

				/*while((d.getMonth()+1) == month){
					d.setDate(d.getDate()-1);
				}
				d.setDate(d.getDate()+1);*/
				date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
				day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
				mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
				year = date_split[2];
				var today = day+"/"+mon+"/"+year;
                document.getElementById("ticket_date").value = today;
				var assignor = "";
				if(d.getDay()==0) assignor += "Sun, ";
				if(d.getDay()==1) assignor += "Mon, ";
				if(d.getDay()==2) assignor += "Tue, ";
				if(d.getDay()==3) assignor += "Wed, ";
				if(d.getDay()==4) assignor += "Thur, ";
				if(d.getDay()==5) assignor += "Fri, ";
				if(d.getDay()==6) assignor += "Sat, ";
				if(d.getMonth()==0) assignor += "Jan ";
				if(d.getMonth()==1) assignor += "Feb ";
				if(d.getMonth()==2) assignor += "Mar ";
				if(d.getMonth()==3) assignor += "Apr ";
				if(d.getMonth()==4) assignor += "May ";
				if(d.getMonth()==5) assignor += "Jun ";
				if(d.getMonth()==6) assignor += "Jul ";
				if(d.getMonth()==7) assignor += "Aug ";
				if(d.getMonth()==8) assignor += "Sep ";
				if(d.getMonth()==9) assignor += "Oct ";
				if(d.getMonth()==10) assignor += "Nov ";
				if(d.getMonth()==11) assignor += "Dec ";
				time_split = (d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()).split(':');
				hour = ((time_split[0].length < 2) ? "0" : "") + time_split[0];
				min = ((time_split[1].length < 2) ? "0" : "") + time_split[1];
				sec = ((time_split[2].length < 2) ? "0" : "") + time_split[2];
				assignor += d.getDate() + " " + d.getFullYear() + " " + hour + ":" + min + ":" + sec;
                assignor += " - " + readCookie("currentuser")+" of "+readCookie("currentdepartment")+" Department";
				document.getElementById("assignor").innerHTML = "<div style='font-size:12px; font-weight:bold'>"+assignor+"</div>";
                document.getElementById("userid").value = readCookie("currentuser");
				var thedate = year + "-" + mon + "-" + day + " " + hour + ":" + min + ":" + sec;
                document.getElementById("usertime").value = thedate;
                document.getElementById("source_department").value = readCookie("currentdepartment");
				createCookie("updateticket","No",false);
			}
            if(break_resp[0]=="userstable"){
                $('#userslist').dialog('close');
                $('#usersdetail').dialog('open');
                document.getElementById("username").value = break_resp[2];
                document.getElementById("firstname").value = break_resp[4];
                document.getElementById("lastname").value = break_resp[5];
                document.getElementById("useremail").value = break_resp[6];
                document.getElementById("mobilephone").value = break_resp[7];
                document.getElementById("officephone").value = break_resp[8];
                document.getElementById("department").value = break_resp[9];
                document.getElementById("location").value = break_resp[10];
                document.getElementById("usersposition").value = break_resp[11];
				if(break_resp[12]!=null && break_resp[12]!=""){
					//document.getElementById("userPicture").value = break_resp[12];
					//createCookie("theImage",break_resp[12],false);
					loadImage(break_resp[12]);
				}
                document.getElementById("homeaddress").value = break_resp[13];
                selectoption = document.getElementById("active");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[14]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("groupemail").value = break_resp[15];
            }
            if(break_resp[0]=="stafftableA"){
                $('#stafflist').dialog('close');
                $('#staffdetail').dialog('open');
                document.getElementById("staffid2").value = break_resp[2];
                document.getElementById("staffname2").value = break_resp[3]+", "+ break_resp[4]+((break_resp[5]!=null && break_resp[5]!="") ? " "+break_resp[5]:"");
                var selectoption = document.getElementById("gender");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[7]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("jobtitle").value = break_resp[8];
                document.getElementById("department").value = break_resp[9];
				document.getElementById('supervisorid').value=break_resp[10]; //readCookie("currentuser");
                document.getElementById("level").value = break_resp[11];
				if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
					document.getElementById("employmentdate").value="";
				}else{
					document.getElementById("employmentdate").value = break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4);
				}
				if(break_resp[17]==null || break_resp[17]=="" || break_resp[17]=="0000-00-00"){
					document.getElementById("birthdate").value="";
				}else{
					document.getElementById("birthdate").value = break_resp[17].substr(8,2)+"/"+break_resp[17].substr(5,2)+"/"+break_resp[17].substr(0,4);
				}
				if(break_resp[27]!=null && break_resp[27]!=""){
					loadImage(break_resp[27]);
				}
			}
            if(break_resp[0]=="appraisaltable"){
                $('#listappraisal').dialog('close');
                $('#appraisaldetail').dialog('open');
                document.getElementById("staffid2").value = break_resp[2];
                document.getElementById("staffname2").value = break_resp[3]+", "+ break_resp[4]+((break_resp[5]!=null && break_resp[5]!="") ? " "+break_resp[5]:"");
                var selectoption = document.getElementById("gender");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[7]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("jobtitle").value = break_resp[8];
                document.getElementById("department").value = break_resp[9];
				document.getElementById('supervisorid').value=readCookie("currentuser");
                document.getElementById("level").value = break_resp[11];
				if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
					document.getElementById("employmentdate").value="";
				}else{
					document.getElementById("employmentdate").value = break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4);
				}
				if(break_resp[17]==null || break_resp[17]=="" || break_resp[17]=="0000-00-00"){
					document.getElementById("birthdate").value="";
				}else{
					document.getElementById("birthdate").value = break_resp[17].substr(8,2)+"/"+break_resp[17].substr(5,2)+"/"+break_resp[17].substr(0,4);
				}
				if(break_resp[27]!=null && break_resp[27]!=""){
					loadImage(break_resp[27]);
				}
                document.getElementById("duties").value = break_resp[30];
                document.getElementById("difficultduties").value = break_resp[31];
                document.getElementById("interestingduties").value = break_resp[32];
                document.getElementById("performanceimprove").value = break_resp[33];
                document.getElementById("queryorsuspension").value = break_resp[34];
                document.getElementById("training").value = break_resp[35];
                document.getElementById("accomplishments").value = break_resp[36];
				if(break_resp[37]==null || break_resp[37]=="" || break_resp[37]=="0000-00-00"){
					document.getElementById("appraisaldate").value="";
				}else{
					document.getElementById("appraisaldate").value = break_resp[37].substr(8,2)+"/"+break_resp[37].substr(5,2)+"/"+break_resp[37].substr(0,4);
				}
                document.getElementById("appraisalstart").value = break_resp[38];
                document.getElementById("appraisalend").value = break_resp[39];
                document.getElementById("userName").value = break_resp[42];
				populateRecords( break_resp[2], "stafftableA")
			}

            if(break_resp[0]=="stafftableB"){
                $('#stafflist').dialog('close');
                $('#staffdetail').dialog('open');
                document.getElementById("staffid2").value = break_resp[2];
                document.getElementById("lastname").value = break_resp[3];
                document.getElementById("othernames").value = break_resp[4]+((break_resp[5]!=null && break_resp[5]!="") ? " "+break_resp[5]:"");
                var selectoption = document.getElementById("gender");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[7]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("jobtitle").value = break_resp[8];
                document.getElementById("department").value = break_resp[9];
				document.getElementById('supervisorid').value=break_resp[10]; //readCookie("currentuser");
                document.getElementById("level").value = break_resp[11];
				if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
					document.getElementById("employmentdate").value="";
				}else{
					document.getElementById("employmentdate").value = break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4);
				}
				if(break_resp[17]==null || break_resp[17]=="" || break_resp[17]=="0000-00-00"){
					document.getElementById("birthdate").value="";
				}else{
					document.getElementById("birthdate").value = break_resp[17].substr(8,2)+"/"+break_resp[17].substr(5,2)+"/"+break_resp[17].substr(0,4);
				}
				if(break_resp[27]!=null && break_resp[27]!=""){
					loadImage(break_resp[27]);
				}
			}
            if(break_resp[0]=="leavetable"){
                $('#listleave').dialog('close');
                $('#leavedetail').dialog('open');
                document.getElementById("staffid2").value = break_resp[2];
                document.getElementById("lastname").value = break_resp[3];
                document.getElementById("othernames").value = break_resp[4]+((break_resp[5]!=null && break_resp[5]!="") ? ", "+break_resp[5]:"");
                var selectoption = document.getElementById("gender");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[7]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("jobtitle").value = break_resp[8];
                document.getElementById("department").value = break_resp[9];
				document.getElementById('supervisorid').value=readCookie("currentuser");
                document.getElementById("level").value = break_resp[11];
				if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
					document.getElementById("employmentdate").value="";
				}else{
					document.getElementById("employmentdate").value = break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4);
				}
				if(break_resp[17]==null || break_resp[17]=="" || break_resp[17]=="0000-00-00"){
					document.getElementById("birthdate").value="";
				}else{
					document.getElementById("birthdate").value = break_resp[17].substr(8,2)+"/"+break_resp[17].substr(5,2)+"/"+break_resp[17].substr(0,4);
				}
				if(break_resp[27]!=null && break_resp[27]!=""){
					loadImage(break_resp[27]);
				}          
				document.getElementById("leavetype2").value = break_resp[30];
				if(break_resp[31]==null || break_resp[31]=="" || break_resp[31]=="0000-00-00"){
					document.getElementById("leavestart2").value="";
				}else{
					document.getElementById("leavestart2").value = break_resp[31].substr(8,2)+"/"+break_resp[31].substr(5,2)+"/"+break_resp[31].substr(0,4);
				}
				if(break_resp[32]==null || break_resp[32]=="" || break_resp[32]=="0000-00-00"){
					document.getElementById("leaveend2").value="";
				}else{
					document.getElementById("leaveend2").value = break_resp[32].substr(8,2)+"/"+break_resp[32].substr(5,2)+"/"+break_resp[32].substr(0,4);
				}
                document.getElementById("supervisor").value = break_resp[33];
                document.getElementById("supervisorapproval").value = break_resp[34];
				if(break_resp[35]==null || break_resp[35]=="" || break_resp[35]=="0000-00-00"){
					document.getElementById("leaveapplydate").value="";
				}else{
					document.getElementById("leaveapplydate").value = break_resp[35].substr(8,2)+"/"+break_resp[35].substr(5,2)+"/"+break_resp[35].substr(0,4);
				}
                document.getElementById("entitlement").value = numberFormat(break_resp[36]);
				if(break_resp[37]==null || break_resp[37]=="" || break_resp[37]=="0000-00-00"){
					document.getElementById("resumptiondate").value="";
				}else{
					document.getElementById("resumptiondate").value = break_resp[37].substr(8,2)+"/"+break_resp[37].substr(5,2)+"/"+break_resp[37].substr(0,4);
				}
                document.getElementById("adminid").value = break_resp[38];
                document.getElementById("adminapproval").value = break_resp[39];
				if(break_resp[40]==null || break_resp[40]=="" || break_resp[40]=="0000-00-00"){
					document.getElementById("leaveapprovedate").value="";
				}else{
					document.getElementById("leaveapprovedate").value = break_resp[40].substr(8,2)+"/"+break_resp[40].substr(5,2)+"/"+break_resp[40].substr(0,4);
				}
				if(readCookie("leaveform")=="supervisorapproval" || readCookie("leaveform")=="viewleave"){
					document.getElementById('supervisorid').value=readCookie("currentuser");
					selectoption = document.getElementById("supervisorapproval");
					for(k=0; selectoption.options[k].text != null; k++){
						if(selectoption.options[k].text == break_resp[34]){
							selectoption.selectedIndex = k;
							break;
						}
					}
				}
				if(readCookie("leaveform")=="adminapproval" || readCookie("leaveform")=="viewleave"){
					var d = new Date();
					var date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
					day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
					mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
					year = date_split[2];
					document.getElementById('leaveapprovedate').value=day+"/"+mon+"/"+year;
					if(readCookie("leaveform")=="adminapproval") document.getElementById('adminid').value=readCookie("currentuser");
					selectoption = document.getElementById("adminapproval");
					for(k=0; selectoption.options[k].text != null; k++){
						if(selectoption.options[k].text == break_resp[39]){
							selectoption.selectedIndex = k;
							break;
						}
					}
				}
                document.getElementById("userName").value = break_resp[40];
			}

			if(break_resp[0]=="stafftable"){
                $('#stafflist').dialog('close');
                $('#staffdetail').dialog('open');
                document.getElementById("staffid").value = break_resp[2];
                document.getElementById("lastname").value = break_resp[3];
                document.getElementById("firstname").value = break_resp[4];
                document.getElementById("middlename").value = break_resp[5];
                var selectoption = document.getElementById("active");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[6]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                selectoption = document.getElementById("gender");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[7]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("jobtitle").value = break_resp[8];
                document.getElementById("department").value = break_resp[9];
                //document.getElementById("department").value = break_resp[10];
                document.getElementById("supervisorid").value = break_resp[10];
                document.getElementById("level").value = break_resp[11];
				if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
					document.getElementById("employmentdate").value="";
				}else{
					document.getElementById("employmentdate").value = break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4);
				}
                document.getElementById("previouscontactaddress").value = break_resp[13];
                document.getElementById("newcontactaddress").value = break_resp[14];
                document.getElementById("mobilephonenumber").value = break_resp[15];
                document.getElementById("homephonenumber").value = break_resp[16];
				if(break_resp[17]==null || break_resp[17]=="" || break_resp[17]=="0000-00-00"){
					document.getElementById("birthdate").value="";
				}else{
					document.getElementById("birthdate").value = break_resp[17].substr(8,2)+"/"+break_resp[17].substr(5,2)+"/"+break_resp[17].substr(0,4);
				}
				document.getElementById("emailaddress").value = break_resp[18];
                selectoption = document.getElementById("maritalstatus");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[19]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("maidenname").value = break_resp[20];
                document.getElementById("spousename").value = break_resp[21];
                document.getElementById("spousephonenumber").value = break_resp[22];
                document.getElementById("nextofkin").value = break_resp[23];
                document.getElementById("nextofkinaddress").value = break_resp[24];
                selectoption = document.getElementById("nextofkinrelationship");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[25]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("nextofkinphonenumber").value = break_resp[26];
                document.getElementById("staffPicture").value = break_resp[27];
				if(break_resp[27]!=null && break_resp[27]!=""){
					loadImage(break_resp[27]);
				}
            }

			if(break_resp[0]=="clientstable"){
				if(readCookie('getclientB')=="1"){
					eraseCookie('getclientB');
					document.getElementById("clientname").value = break_resp[3];
					var clientdetails = "<div id='client_div2' width='690px'><table style='font-size:11px'>";
					clientdetails += "<tr><td align='right' style=' color: red'><b>Contact_Address:</b></td>";
					clientdetails += "<td><textarea id='contactaddress' name='contactaddress' readonly disabled='true' rows='2' cols='30' >"+break_resp[6]+"</textarea></td>";
					clientdetails += "<td align='right' style=' color: red'><b>Office_Phone:</b></td>";
					clientdetails += "<td><input type='text' id='officephone' name='officephone' value='"+break_resp[7]+"' readonly disabled='true' size='20' /></td></tr>";
					clientdetails += "<tr><td align='right' style=' color: red'><b>Email:</b></td>";
					clientdetails += "<td><input type='text' id='emailaddress' name='emailaddress' value='"+break_resp[9]+"' readonly disabled='true' size='30' /></td>";
					clientdetails += "<td align='right' style=' color: red'><b>Mobile_Phone:</b></td>";
					clientdetails += "<td><input type='text' id='mobilephone' name='mobilephone' value='"+break_resp[8]+"' readonly disabled='true' size='20' /></td></tr>";
					clientdetails += "<tr><td align='right' style=' color: red'><b>Contact_Person:</b></td>";
					clientdetails += "<td><input type='text' id='contactperson' name='contactperson' value='"+break_resp[13]+"' readonly disabled='true' size='25' /></td>";
					clientdetails += "<td align='right' style=' color: red'><b>Birth_Date:</b></td>";
					if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
						clientdetails += "<td><input type='text' style='display:inline' id='birthdate' value='' readonly disabled='true' name='birthdate' size='10' /></td></tr></table></div>";
					}else{
						clientdetails += "<td><input type='text' style='display:inline' id='birthdate' value='"+break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4)+"' readonly disabled='true' name='birthdate' size='10' /></td></tr></table></div>";
					}
					document.getElementById("clientdetails").innerHTML=clientdetails;
				}else if(readCookie('getclientB')=="2"){
					eraseCookie('getclientB');
					document.getElementById("clientid3").value = break_resp[2];
					document.getElementById("clientname3").value = break_resp[3];
					document.getElementById("contactaddress3").value = break_resp[6];
					document.getElementById("officephone3").value = break_resp[7];
					document.getElementById("emailaddress3").value = break_resp[9];
					document.getElementById("mobilephone3").value = break_resp[8];
					document.getElementById("contactperson3").value = break_resp[13];0
					if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
						document.getElementById("birthdate3").value="";
					}else{
						document.getElementById("birthdate3").value = break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4);
					}
				}else{
					document.getElementById("locationB").disabled=false;
					document.getElementById("basestationdescriptionB").disabled=false;
					document.getElementById("clienttypeB").disabled=false;
					$('#listclient').dialog('close');
					$('#clientdetail').dialog('open');
					document.getElementById("clientid").value = break_resp[2];
					document.getElementById("clientname").value = break_resp[3];
					document.getElementById("clienttypeB").value = break_resp[4];
					document.getElementById("locationB").value = break_resp[5];
					document.getElementById("contactaddress").value = break_resp[6];
					document.getElementById("officephone").value = break_resp[7];
					document.getElementById("mobilephone").value = break_resp[8];
					document.getElementById("emailaddress").value = break_resp[9];
					document.getElementById("bandwidth").value = break_resp[10];
					if(break_resp[11]==null || break_resp[11]=="" || break_resp[11]=="0000-00-00"){
						document.getElementById("instalationdate").value="";
					}else{
						document.getElementById("instalationdate").value = break_resp[11].substr(8,2)+"/"+break_resp[11].substr(5,2)+"/"+break_resp[11].substr(0,4);
					}
					if(break_resp[12]==null || break_resp[12]=="" || break_resp[12]=="0000-00-00"){
						document.getElementById("birthdate").value="";
					}else{
						document.getElementById("birthdate").value = break_resp[12].substr(8,2)+"/"+break_resp[12].substr(5,2)+"/"+break_resp[12].substr(0,4);
					}
					document.getElementById("contactperson").value = break_resp[13];
					document.getElementById("cpe").value = break_resp[14];
					document.getElementById("radioipaddress").value = break_resp[15];
					document.getElementById("ipaddress").value = break_resp[16];
					document.getElementById("basestationipaddress").value = break_resp[17];
					document.getElementById("configurationstatus").value = break_resp[18];
					selectoption = document.getElementById("active");
					for(k=0; selectoption.options[k].text != null; k++){
						if(selectoption.options[k].text == break_resp[19]){
							selectoption.selectedIndex = k;
							break;
						}
					}
					document.getElementById("basestationdescriptionB").value = break_resp[20];
				}
			}
			if(break_resp[0]=="ticketstable"){
				if(break_resp[10]=="Closed"){
					document.getElementById("showError").innerHTML = "<b>Tiocket Closed!!!<b><br><br>This ticket can not be edited, it has been closed.";
					$('#showError').dialog('open');
					return true;
				}
				document.getElementById("assigned_department3").value = "";
				document.getElementById("ticket_assignee3").value = "";
				document.getElementById("ticket_message3").value = "";
				$('#ticketsformupdate').dialog('open');
				$('#ticketlist').dialog('close');
                document.getElementById("ticketno3").value = break_resp[2];
                document.getElementById("clientid3").value = break_resp[3];
				createCookie("currentclient",break_resp[3],false);
                document.getElementById("ticket_subject3").value = break_resp[4];
				if(break_resp[5]==null || break_resp[5]=="" || break_resp[5]=="0000-00-00"){
					document.getElementById("ticket_date3").value="";
				}else{
					document.getElementById("ticket_date3").value = break_resp[5].substr(8,2)+"/"+break_resp[5].substr(5,2)+"/"+break_resp[5].substr(0,4);
				}
				if(break_resp[6]==null || break_resp[6]=="" || break_resp[6]=="0000-00-00"){
					document.getElementById("due_date3").value="";
				}else{
					document.getElementById("due_date3").value = break_resp[6].substr(8,2)+"/"+break_resp[6].substr(5,2)+"/"+break_resp[6].substr(0,4);
				}
                var selectoption = document.getElementById("ticket_source3");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[7]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                var selectoption = document.getElementById("help_topic3");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[8]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                var selectoption = document.getElementById("ticket_priority3");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[9]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                var selectoption = document.getElementById("ticket_status3");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[10]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
				createCookie("updateticket","Yes",false);
				populateDoc(break_resp[11],break_resp[2]);
            }
			if(break_resp[0]=="departmentstable"){
                document.getElementById("departmentdescription").value = break_resp[2];
            }
			if(break_resp[0]=="basestationstable"){
                document.getElementById("basestationdescription").value = break_resp[2];
                document.getElementById("locations").value = break_resp[3];
            }
            if(break_resp[0]=="locationstable"){
                document.getElementById("locationcode").value = break_resp[2];
                document.getElementById("locationdescription").value = break_resp[3];
            }
            return true;
        }

        if(resp.match("inserted")){
            break_resp = resp.split("inserted");
			if(break_resp[0]=="userstable" || break_resp[0]=="clientstable"){
			}else if(break_resp[0]=="ticketstable"){
				getRecords(break_resp[0],"1");
			}else if(break_resp[0]=="requisitiontable"){
				$('#requisitionlist').dialog('open');
				$('#accountsrequisitionform').dialog('close');
				$('#accountsrequisitionupdate').dialog('close');
				getAccountsRequisition(readCookie("requisitionform"));
				return true;
			}else if(break_resp[0]=="stafftable"){
				$('#staffdetail').dialog('close');
				$('#stafflist').dialog('open');
				getRecords(break_resp[0],"1");
				return true;
			}else if(break_resp[0]=="appraisaltable"){
				$('#appraisaldetail').dialog('close');
				$('#listappraisal').dialog('open');
				getRecords(break_resp[0],"1");
				return true;
			}else if(break_resp[0]=="leavetable"){
				$('#leavedetail').dialog('close');
				$('#listleave').dialog('open');
				getRecords(break_resp[0],"1");
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Added!!!</b><br><br>Your record was successfully added.";
            $('#showPrompt').dialog('open');
       }

        if(resp.match("updated")){
            break_resp = resp.split("updated");
			if(break_resp[0]=="userstable" || break_resp[0]=="clientstable"){
			}else if(break_resp[0]=="ticketstable"){
				getRecords(break_resp[0],"1");
			}else if(break_resp[0]=="requisitiontable"){
				$('#requisitionlist').dialog('open');
				$('#accountsrequisitionform').dialog('close');
				$('#accountsrequisitionupdate').dialog('close');
				getAccountsRequisition(readCookie("requisitionform"));
				return true;
			}else if(break_resp[0]=="stafftable"){
				$('#staffdetail').dialog('close');
				$('#stafflist').dialog('open');
				getRecords(break_resp[0],"1");
				return true;
			}else if(break_resp[0]=="appraisaltable"){
				$('#appraisaldetail').dialog('close');
				$('#listappraisal').dialog('open');
				getRecords(break_resp[0],"1");
				return true;
			}else if(break_resp[0]=="leavetable"){
				$('#leavedetail').dialog('close');
				$('#listleave').dialog('open');
				getRecords(break_resp[0],"1");
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Updated!!!</b><br><br>Your record was successfully updated.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("transfersuccessful")){
            document.getElementById("showPrompt").innerHTML = "<b>Equipment Transfer Successful!!!</b><br><br>Your equipment was successfully transfered.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("deleted")){
            break_resp = resp.split("deleted");
			if(break_resp[0]=="userstable" || break_resp[0]=="clientstable"){
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Deleted!!!</b><br><br>Your record was successfully deleted.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("exists_in")){
            resp = resp.replace(/_/g, ' ');
            document.getElementById("showError").innerHTML = "<b>Recode Exists!!!</b><br><br>The "+resp+".";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recordexists")){
            document.getElementById("showError").innerHTML = "<b>Record Exists!!!</b><br><br>The record already exists.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recordused")){
            document.getElementById("showError").innerHTML = "<b>Record Used!!!</b><br><br>The record has been used in another table.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("recordnotexist")){
            document.getElementById("showError").innerHTML = "<b>Record Not Existing!!!</b><br><br>The record does not exist.";
            $('#showError').dialog('open');
            return true;
        }
        if(resp.match("logoutUser")){
			window.location = "login.php";
		}
        if(resp.match("restricted")){
            break_resp = resp.split("restricted");
            document.getElementById("showError").innerHTML = "<b>User Restricted!!!</b><br><br>"+break_resp[1];
            $('#showError').dialog('open');
            return true;
        }
        if(resp.match("Message successfully sent!")){
            document.getElementById("showPrompt").innerHTML = resp;
            $('#showPrompt').dialog('open');
            return true;
        }
        if(resp.match("Failed to connect")){ // || resp.match("error")
            document.getElementById("showError").innerHTML = resp;
            $('#showError').dialog('open');
            return true;
        }
        if(resp.match("getStockBalance")){
            break_resp = resp.split("getStockBalance");
			if(break_resp[1]=="yestockbalance"){
				saveStock("updateRecord","equipmentstock");
			}else{
				document.getElementById("showError").innerHTML = "<b>Insufficient Stock Balance!!!</b><br><br>Current Stock Balance: "+break_resp[2]+"<br><br>Quantity to Remove: "+break_resp[3]+"<br><br>Stock Value Required: "+(parseInt(break_resp[3],10)-parseInt(break_resp[2],10));
				$('#showError').dialog('open');
			}
			return true;
		}

    }
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
