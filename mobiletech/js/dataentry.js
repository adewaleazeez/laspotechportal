/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var curr_obj=null;
var list_obj=null;
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

function showUpdateMatric(){
	document.getElementById("oldregNumber").value=document.getElementById("regNumber").value;
	if(document.getElementById("oldregNumber").value==null || document.getElementById("oldregNumber").value==""){
        var error = "<br><b>Please correct the following error:</b><br><br><br>Select a Student with Matric No";
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
		return true;
	}
	$('#updatematricno').dialog('open');
}

function updateMatricNo(){
	var oldregnumber=document.getElementById("oldregNumber").value;
	var newregnumber=document.getElementById("newregNumber").value;
	var error="";
    if (newregnumber=="") error += "New Reg. No must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&param="+oldregnumber+"]["+newregnumber;
    var url = "/mobiletech/dataentrybackend.php?option=updateMatricNo"+param;
    AjaxFunctionDataEntry(url);
}

function showOnlineUpload(){
	$('#uploadresult').dialog('close');
	$('#onlineupload').dialog('open');
}

function onlineUpload(){
	var session=document.getElementById("sesionsA").value;
	var semester=document.getElementById("semesterA").value;
	var error="";
    if (session=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Online Upload in progress..........";
    $('#showAlert').dialog('open');
    var param = "&param="+session+"]["+semester;
    var url = "/mobiletech/dataentrybackend.php?option=onlineUpload"+param;
    AjaxFunctionDataEntry(url);
}

function doShowSMS(){
	if(document.getElementById('selectsms').checked==true){
		document.getElementById('smsboxcover').style.visibility = 'visible';
	}else{
		document.getElementById('smsboxcover').style.visibility = 'hidden';
	}
}

function showAwarDate(){
	var selectoption=document.getElementById("finalyear1");
	var finalyear=selectoption.options[selectoption.selectedIndex].text;
	if(finalyear=="Yes"){
		document.getElementById('awardatecover').style.visibility = 'visible';
	}else{
		document.getElementById('awardatecover').style.visibility = 'hidden';
	}
}

function checkAccess(access, menuoption){
	createCookie("access",access,false);
    var arg = "&currentuser="+readCookie("currentuser")+"&menuoption="+menuoption;
    var url = "/mobiletech/setupbackend.php?option=checkAccess"+arg;
    AjaxFunctionDataEntry(url);
}

function doSignatories(){
    $('#signatory').dialog('open');
	getRecords('signatoriestable',1);
}

function updateSignatories(option, table){
    var position = document.getElementById("signatoryposition").value;
    var name = document.getElementById("signatoryname").value;
    var error = "";
    if (position==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Position must not be blank.<br><br>";
        }
    }
    if(name=="") error += "Name must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        //return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+position+"]["+name;
    var url = "/mobiletech/dataentrybackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionDataEntry(url);
}

function updateGeneral(id){
	var facultys = document.getElementById("facultycodes").value;
	var departments = document.getElementById("departmentcodes").value;
	var programmes = document.getElementById("programmecodes").value;
	var levels = document.getElementById("studentlevels").value;
	var sessions = document.getElementById("sesionsA").value;
	var semesters = document.getElementById("semestersA").value;
	var entryyears = document.getElementById("entryyearsA").value;

	var selectoption=document.getElementById(id);
	var selectedoption=selectoption.options[selectoption.selectedIndex].text;

	var error = "";
	var arg = "";
	var param = "";
	if(selectedoption.match("All")){
		if (facultys=="") error += "Faculty must not be blank.<br><br>";
		if (departments=="") error += "Department must not be blank.<br><br>";
		if (programmes=="") error += "Programme must not be blank.<br><br>";
		if (levels=="") error += "Student level must not be blank.<br><br>";
		if (sessions=="") error += "Session must not be blank.<br><br>";
		if (semesters=="") error += "Semester must not be blank.<br><br>";
		if (entryyears=="") error += "Entry session must not be blank.<br><br>";
		
		if(error.length >0) {
			error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
			document.getElementById("showError").innerHTML = error;
			$('#showError').dialog('open');
			return true;
		}

		if(facultys!="") arg +="&facultycode="+facultys;
		if(departments!="") arg +="&departmentcode="+departments;
		if(programmes!="") arg +="&programmecode="+programmes;
		if(levels!="") arg +="&studentlevel="+levels;
		if(sessions!="") arg +="&sesions="+sessions;
		if(semesters!="") arg +="&semester="+semesters;
		if(entryyears!="") arg +="&entryyear="+entryyears;
	}else if(selectedoption.match("Selected")){
		param="";
		for(var i=0; i < myCheckboxes; i++){
			var checkboxid="box"+(i);
			var hiddenid="hidden"+(i);
			if(document.getElementById(checkboxid).checked==true){
				 param +=document.getElementById(hiddenid).value+"][";
			}
		}
		if(param.length==0) {
			error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some students to use this option: "+selectedoption;
			document.getElementById("showError").innerHTML = error;
			$('#showError').dialog('open');
			return true;
		}
		param = "&param="+param;
	}else{
		error = "<br><b>Invalid Options</b> <br><br><br>"+option+" is a not a valid option<br><br>Select a valid option to update.";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
	var sessions2a = document.getElementById("sessions2a").value;
	var semesters2a = document.getElementById("semesters2a").value;
	var levels2a = document.getElementById("levels2a").value;
	if(id=="selectalpha"){
		if(sessions2a=="" || semesters2a=="" || levels2a==""){
			error = "Current Session, Current Semester, and Current Level must be selected for update";
		}
		if(error!=""){
			error = "<br><b>Invalid Options</b> <br><br><br>" + error;
			document.getElementById("showError").innerHTML = error;
			$('#showError').dialog('open');
			return true;
		}
		
		/*if(levels2a>""){
			arg += "&codeid=level]["+levels2a;
		}else{
			if(sessions2a==""){
				error = "Current Session must not be blank";
			}
			if(semesters2a==""){
				error = "Current Semester must not be blank ";
			}
			if(error!=""){
				error = "<br><b>Invalid Options</b> <br><br><br>" + error;
				document.getElementById("showError").innerHTML = error;
				$('#showError').dialog('open');
				return true;
			}
			arg += "&codeid=sesion]["+sessions2a+"!!!semester]["+semesters2a+"!!!level]["+levels2a;
		}*/
		arg += "&codeid=sesion]["+sessions2a+"!!!semester]["+semesters2a+"!!!level]["+levels2a;
	}
	
	if(id=="selectactivate"){
		selectactivate=document.getElementById(id);
		selectactivate=selectactivate.options[selectactivate.selectedIndex].text;
		arg += "&codeid=active]["+selectactivate;
	}
	if(id=="selectlock"){
		selectlock=document.getElementById(id);
		selectlock=selectlock.options[selectlock.selectedIndex].text;
		arg += "&codeid=lockrec]["+selectlock
	}
	arg = "?option=updateGeneral&menuoption="+selectedoption+arg
    var url = "/mobiletech/dataentrybackend.php"+arg+param;
    AjaxFunctionDataEntry(url);
}

/*function checkAccess(access, menuoption, param){
    var arg = "&currentuser="+readCookie("currentuser")+"&menuoption="+menuoption+"&access="+access+"&param="+param;
    var url = "/mobiletech/dataentrybackend.php?option=checkAccess"+arg;
    AjaxFunctionDataEntry(url);
}*/

function viewMasterResults(){
    $('#menuList').dialog('close');
    $('#mastersheet').dialog('open');
}

function viewSummaryResults(){
    $('#menuList').dialog('close');
    $('#summarysheet').dialog('open');
}

function viewTranscriptResults(){
    $('#menuList').dialog('close');
    $('#transcriptsheet').dialog('open');
}

function viewMyResult(repotype){
    var error="";
	var param ="";
	var selectoption="";
	var facultycode="";
	var departmentcode="";
	var programmecode="";
	var studentlevel="";
	var sessions="";
	var semester="";
	var groupsession="";
	var matricno="";
	var finalyear="";
	var resultype="";
	var leftsigid="";
	var midsigid="";
	var rightsigid="";
	var leftsigname="";
	var midsigname="";
	var rightsigname="";

	if(repotype=="viewhtmlmaster" || repotype=="viewexcelmaster" || repotype=="viewwordmaster" || repotype=="viewpdfmaster"){
		facultycode = document.getElementById("facultycode2").value;
		departmentcode = document.getElementById("departmentcode2").value;
		programmecode = document.getElementById("programmecode2").value;
		studentlevel = document.getElementById("studentlevel2").value;
	    sessions = document.getElementById("sesions2").value;
		semester = document.getElementById("semester2").value;
		groupsession = document.getElementById("entryyear1").value;
		leftsigid = document.getElementById("leftsigidA").value;
		midsigid = document.getElementById("midsigidA").value;
		rightsigid = document.getElementById("rightsigidA").value;
		leftsigname = document.getElementById("leftsignameA").value;
		midsigname = document.getElementById("midsignameA").value;
		rightsigname = document.getElementById("rightsignameA").value;
	    selectoption=document.getElementById("finalyear1");
		finalyear=selectoption.options[selectoption.selectedIndex].text;
	    //selectoption=document.getElementById("suplementaryA");
		//suplementary=selectoption.options[selectoption.selectedIndex].text;
	    //selectoption=document.getElementById("resultype");
		//resultype=selectoption.options[selectoption.selectedIndex].text;
	    resultype=document.getElementById("resultype").value;
	}

	if(repotype=="viewhtmlsummary" || repotype=="viewexcelsummary" || repotype=="viewwordsummary" || repotype=="viewpdfsummary"){
		facultycode = document.getElementById("facultycode3").value;
		departmentcode = document.getElementById("departmentcode3").value;
		programmecode = document.getElementById("programmecode3").value;
		studentlevel = document.getElementById("studentlevel3").value;
	    sessions = document.getElementById("sesions3").value;
		semester = document.getElementById("semester3").value;
		groupsession = document.getElementById("entryyear2").value;
		leftsigid = document.getElementById("leftsigidB").value;
		midsigid = document.getElementById("midsigidB").value;
		rightsigid = document.getElementById("rightsigidB").value;
		leftsigname = document.getElementById("leftsignameB").value;
		midsigname = document.getElementById("midsignameB").value;
		rightsigname = document.getElementById("rightsignameB").value;
	    selectoption=document.getElementById("finalyear2");
		finalyear=selectoption.options[selectoption.selectedIndex].text;
	    //selectoption=document.getElementById("resultype");
		//resultype=selectoption.options[selectoption.selectedIndex].text;
	    resultype=document.getElementById("resultype").value;
	}

	var param2="";
	var awardate="";
	//if(repotype=="viewhtmltranscript" || repotype=="viewexceltranscript" || repotype=="viewwordtranscript" || repotype=="viewpdftranscript"){
	if(repotype=="emailtranscript" || repotype=="viewpdftranscript"){
		facultycode = document.getElementById("facultycode4").value;
		departmentcode = document.getElementById("departmentcode4").value;
		programmecode = document.getElementById("programmecode4").value;
	    sessionsA = document.getElementById("sesions4a").value;
	    sessionsB = document.getElementById("sesions4b").value;
		groupsession = document.getElementById("entryyear3").value;
	    selectoption=document.getElementById("finalyear1");
		finalyear=selectoption.options[selectoption.selectedIndex].text;
	    awardate=document.getElementById("awardate").value;
		matricno="";
		for(var i=0; i < myCheckboxes; i++){
			var checkboxid="box"+(i);
			var hiddenid="hidden"+(i);
			if(document.getElementById(checkboxid).checked==true){
				 matricno +=document.getElementById(hiddenid).value+"][";
			}
		}
		if(matricno.length==0) error = "Please select some students to use this option.<br><br>";
		if(sessionsA>sessionsB)	error = "Please ensure that Session_(From) is less than Session_(To).<br><br>";
		if (sessionsA=="" && (repotype=="viewpdftranscript" || repotype=="emailtranscript")) error += "Session_(From) must not be blank.<br><br>";
		if (sessionsB=="" && (repotype=="viewpdftranscript" || repotype=="emailtranscript")) error += "Session_(To) must not be blank.<br><br>";
		if (finalyear=="Yes" && (awardate==null || awardate=="")) error += "Award Date must not be blank if final year is yes.<br><br>";
		param2 = "&sessionsA="+sessionsB+"&sessionsB="+sessionsB+"&awardate="+awardate;
	}

	if(repotype=="excelexport"){
		facultycode = document.getElementById("facultycode5").value;
		departmentcode = document.getElementById("departmentcode5").value;
		programmecode = document.getElementById("programmecode5").value;
		studentlevel = document.getElementById("studentlevel4").value;
	    sessions = document.getElementById("sesions").value;
		semester = document.getElementById("semester").value;
		groupsession = document.getElementById("entryyear0").value;
		matricno = document.getElementById("coursecode5").value;
		if (matricno=="") error += "Course Code must not be blank.<br><br>";
	}

	if (facultycode=="") error += "Faculty must not be blank.<br><br>";
	if (departmentcode=="") error += "Department must not be blank.<br><br>";
	if (programmecode=="") error += "Programme must not be blank.<br><br>";
	if (studentlevel=="" && (repotype!="viewpdftranscript" && repotype!="emailtranscript")) error += "Student level must not be blank.<br><br>";
	if (sessions=="" && (repotype!="viewpdftranscript" && repotype!="emailtranscript")) error += "Session must not be blank.<br><br>";
	if (semester=="" && (repotype!="viewpdftranscript" && repotype!="emailtranscript")) error += "Semester must not be blank.<br><br>";
	if (groupsession=="") error += "Group Code must not be blank.<br><br>";
	
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	createCookie("_facultys_",facultycode,365);
	createCookie("_departments_",departmentcode,365);
	createCookie("_programmes_",programmecode,365);
	createCookie("_levels_",studentlevel,365);
	createCookie("_sessions_",sessions,365);
	createCookie("_semesters_",semester,365);
	createCookie("_groupcode_",groupsession,365);

	param = "?sessions="+sessions+"&semester="+semester+"&facultycode="+facultycode+"&departmentcode="+departmentcode;
	param +="&programmecode="+programmecode+"&studentlevel="+studentlevel+"&finalyear="+finalyear+"&matricno="+matricno+"&groupsession="+groupsession;
	param +="&resultype="+resultype+"&leftsigid="+leftsigid+"&midsigid="+midsigid+"&rightsigid="+rightsigid+"&leftsigname="+leftsigname+"&midsigname="+midsigname+"&rightsigname="+rightsigname+param2;

	var oWin = null;
	if(repotype=="viewhtmlmaster"){
        oWin = window.open("htmlmaster.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewexcelmaster"){
        oWin = window.open("excelmaster.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewwordmaster"){
        oWin = window.open("wordmaster.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewpdfmaster"){
        oWin = window.open("pdfmaster.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewhtmlsummary"){
	    oWin = window.open("htmlsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewexcelsummary"){
        oWin = window.open("excelsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewwordsummary"){
        oWin = window.open("wordsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewpdfsummary"){
		if(resultype=="Amended Results"){
	        oWin = window.open("pdfsummaryamended.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
		}else{
	        oWin = window.open("pdfsummary.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
		}
    }else if(repotype=="viewhtmltranscript"){
        oWin = window.open("htmltranscript.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewexceltranscript"){
        oWin = window.open("exceltranscript.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewwordtranscript"){
        oWin = window.open("wordtranscript.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    }else if(repotype=="viewpdftranscript"){
        oWin = window.open("pdftranscript.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}else if(repotype=="emailtranscript"){
        //oWin = window.open("mailtranscript.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
		document.getElementById('f1_upload_process').style.visibility = 'visible';
        document.getElementById("showAlert").innerHTML = "<b>Sending Transcripts to students!!!</b><br><br>Wait while transcripts are mailed to students";
        $('#showAlert').dialog('open');
		var url = "/mobiletech/mailtranscript.php"+param;
		AjaxFunctionDataEntry(url);
        return true;
	
	}else if(repotype=="excelexport"){
		oWin = window.open("excelexport.php"+param, "_blank", "directories=0,scrollbars=1,resizable=1,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
	}

	if (oWin==null || typeof(oWin)=="undefined"){
		alert("Popup must be enabled on this browser to see the report");
    }
}

function sendSMS(){
	document.getElementById('f1_upload_process').style.visibility = 'visible';
	//var recipients = "";
	//for(var i=0; i < (myRecipients.length); i++){
	//	recipients += "~_~"+myRecipients[i][3]+"_"+myRecipients[i][4]+"_"+myRecipients[i][5];
	//}
	recipients="";
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		var hiddenidB="hiddenB"+(i);
		if(document.getElementById(checkboxid).checked==true){
			 recipients += "~_~"+document.getElementById(hiddenidB).value;
		}
	}
	var serialno = readCookie("serialno");
	var password = "0m0kunmi"; //readCookie("password");
	var currentuser = "adewaleazeez@yahoo.co.uk"; //readCookie("currentuser");
	var senderid = "OOUResults"; //document.getElementById("senderid").value;
	var sms = document.getElementById("smsbox").value;
    var error = "";
    if (senderid.length == 0) error += "Sender Id must not be blank<br><br>";
    if (sms.length == 0) error += "SMS message must not be blank<br><br>";
    if (recipients.length == 0) error += "No recipient is selected<br><br>";
    if(error.length > 0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
		document.getElementById('f1_upload_process').style.visibility = 'hidden';
        return true;
    }
	var smsmessage = "";
	for(k=0; k<sms.length; k++){
		var chr = sms.charCodeAt(k);
		if(chr == 10){ //if generated character code is equal to ascii 10 (if line feed)
			smsmessage += "~_~";
		} else if(chr == 32){ //if generated character code is equal to ascii 32 (if space)
			smsmessage +="_~_";
		/*} else if(chr == 126){ //if generated character code is equal to ascii 126 (if ~)
			smsmessage +="_tilde_";
		} else if(chr == 33){ //if generated character code is equal to ascii 33 (if !)
			smsmessage +="_exclm_";
		} else if(chr == 64){ //if generated character code is equal to ascii 64 (if @)
			smsmessage +="_at_";*/
		} else if(chr == 35){ //if generated character code is equal to ascii 35 (if #)
			smsmessage +="_hash_";
		/*} else if(chr == 36){ //if generated character code is equal to ascii 36 (if $)
			smsmessage +="_dollar_";
		} else if(chr == 37){ //if generated character code is equal to ascii 37 (if %)
			smsmessage +="_percent_";
		} else if(chr == 94){ //if generated character code is equal to ascii 94 (if ^)
			smsmessage +="_caret_";*/
		} else if(chr == 38){ //if generated character code is equal to ascii 38 (if &)
			smsmessage +="_ampersand_";
		/*} else if(chr == 42){ //if generated character code is equal to ascii 42 (if *)
			smsmessage +="_asterisk_";
		} else if(chr == 47){ //if generated character code is equal to ascii 47 (if /)
			smsmessage +="_fslash_";
		} else if(chr == 92){ //if generated character code is equal to ascii 92 (if \)
			smsmessage +="_bslash_";
		} else if(chr == 40){ //if generated character code is equal to ascii 40 (if ( )
			smsmessage +="_obracket_";
		} else if(chr == 41){ //if generated character code is equal to ascii 41 (if ) )
			smsmessage +="_cbracket_";
		} else if(chr == 95){ //if generated character code is equal to ascii 95 (if -)
			smsmessage +="_minus_";*/
		} else if(chr == 43){ //if generated character code is equal to ascii 43 (if +)
			smsmessage +="_plus_";
		/*} else if(chr == 96){ //if generated character code is equal to ascii 96 (if `)
			smsmessage +="_invertedcoma_";
		} else if(chr == 39){ //if generated character code is equal to ascii 39 (if ')
			smsmessage +="_squote_";
		} else if(chr == 34){ //if generated character code is equal to ascii 34 (if ")
			smsmessage +="_dquote_";
		} else if(chr == 124){ //if generated character code is equal to ascii 124 (if |)
			smsmessage +="_pipe_";
		} else if(chr == 123){ //if generated character code is equal to ascii 123 (if { )
			smsmessage +="_ocbracket_";
		} else if(chr == 125){ //if generated character code is equal to ascii 125 (if } )
			smsmessage +="_ccbracket_";
		} else if(chr == 91){ //if generated character code is equal to ascii 91 (if [ )
			smsmessage +="_osbracket_";
		} else if(chr == 93){ //if generated character code is equal to ascii 93 (if ] )
			smsmessage +="_csbracket_";
		} else if(chr == 58){ //if generated character code is equal to ascii 58 (if : )
			smsmessage +="_colon_";*/
		} else {
			smsmessage +=sms.substr(k,1);
		}
	}
	var msgcount = sms.length; //document.getElementById("msg").value; //message count = msg.
    //var url = "www.immaculatedevelopers.com/bulksms/userbackend.php?option=sendSms&phone="+recipients+"&senderid="+senderid;
    //var url = "/mobiletech/dataentrybackend.php?option=approveMark"+param;
    var url = "/mobiletech/dataentrybackend.php?option=sendSms&phone="+recipients+"&senderid="+senderid;
	url += "&sms="+smsmessage+"&currentuser="+currentuser+"&msgcount="+msgcount+"&password="+password+"&serialno="+serialno;
	//if(document.getElementById("scheduleflag").checked==true){
	//	var scheduledate = document.getElementById("scheduledate").value;
	//	var scheduletime = document.getElementById("scheduletime").value;
	//	scheduledate = scheduledate.substr(6,4)+'-'+scheduledate.substr(3,2)+'-'+scheduledate.substr(0,2);
	//	url += "&scheduledate="+scheduledate+"&scheduletime="+scheduletime+"&scheduler=true";
	//}
	AjaxFunctionDataEntry(url);
}

function approveResults(){
    $('#menuList').dialog('close');
    $('#approveresult').dialog('open');
}

function approveMarks(){
    var sessions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var coursecode = document.getElementById("coursecode").value;

    var error="";
    if (sessions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester No must not be blank.<br><br>";
    if (coursecode=="") error += "Course code must not be blank.<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var param = "&sessiondescription="+sessions+"&semesterdescription="+semester+"&coursecode="+coursecode;

    var url = "/mobiletech/dataentrybackend.php?option=approveMark"+param;
    AjaxFunctionDataEntry(url);
}

function reverseMarks(){
    var sessions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var coursecode = document.getElementById("coursecode").value;

    var error="";
    if (sessions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester No must not be blank.<br><br>";
    if (coursecode=="") error += "Course code must not be blank.<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var param = "&sessiondescription="+sessions+"&semesterdescription="+semester+"&coursecode="+coursecode;

    var url = "/mobiletech/dataentrybackend.php?option=reverseMark"+param;
    AjaxFunctionDataEntry(url);
}

function checkPin(){
    var pinno = document.getElementById("pinno").value;
    var currentuser = readCookie("currentuser");
    var url = "/mobiletech/dataentrybackend.php?option=checkPin"+"&pinno="+pinno+"&currentUser="+currentuser;
    AjaxFunctionDataEntry(url);
}

/*function checkCode(id,table,codeid){
	codevalue = document.getElementById(id).value;
	if(codevalue!=null && codevalue!=""){
		var url = "/mobiletech/dataentrybackend.php?option=checkCode"+"&table="+table+"&codeid="+codeid+"&codevalue="+codevalue+"&access="+id;
		AjaxFunctionDataEntry(url);
	}
}*/

function checkReceipt(){
    var receiptno = document.getElementById("receiptno").value;
    var confirmno = document.getElementById("confirmno").value;
    var currentuser = readCookie("currentuser");
    var url = "/mobiletech/dataentrybackend.php?option=checkReceipt"+"&receiptno="+receiptno+"&confirmno="+confirmno+"&currentUser="+currentuser;
    AjaxFunctionDataEntry(url);
}

var wascrow = 1;
var valueflag = 0;
function addOLevel(){
    if(document.getElementById("examno").value==null || document.getElementById("examno").value==""){
        document.getElementById("showError").innerHTML = "<b>Examination Number is blank</b><br><br>Please enter an Examination Number before adding a new subject.";
        $('#showError').dialog('open');
        return true;
    }
    if(wascrow>1){
        var temp_subject = "subject"+(wascrow-1);
        var temp_grade = "grade"+(wascrow-1);
        if(document.getElementById(temp_subject).value==null || document.getElementById(temp_subject).value=="" || document.getElementById(temp_grade).value==null || document.getElementById(temp_grade).value==""){
            document.getElementById("showError").innerHTML = "<b>Subject not added</b><br><br>Please complete the last subject before adding a new one.";
            $('#showError').dialog('open');
            return true;
        }
    }
    wascrow++;
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Subject</td><td>Grade</td></tr>';
    var flag=0;
    var subjectid="";
    var gradeid="";
    var subjectvalue="";
    var gradevalue="";
    
    for(var k=1; k<wascrow; k++){
		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        subjectid = "subject"+k;
        gradeid = "grade"+k;
        subjectvalue="";
        gradevalue="";
        if((k<(wascrow-1)) && valueflag>0){
            subjectvalue = document.getElementById(subjectid).value;
            gradevalue = document.getElementById(gradeid).value;
        }
        valueflag = 1;
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' value='"+subjectvalue+"' id='"+subjectid+"' onblur='this.value=capAdd(this.value)' size='50' /></td>";
        str += "<td width='10%'><input type='text' value='"+gradevalue+"' id='"+gradeid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='button' id=deletesubject' value='Delete' onclick=deleteOLevel('"+k+"') /></td></tr>";
    }
    str += "</table>";
    document.getElementById('olevel').innerHTML=str;
}

function deleteOLevel(arg){
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Subject</td><td>Grade</td></tr>';
    var flag=0;
    var subjectid="";
    var gradeid="";
    var tempsubjectid="";
    var tempgradeid="";
    var subjectvalue="";
    var gradevalue="";
    var temp = 0;
    deleteflag = 0;
    for(var k=1; k<wascrow; k++){
        if(k==arg && deleteflag==0){
            deleteflag=1;
            wascrow--;
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
        subjectid = "subject"+k;
        tempsubjectid = "subject"+(k+temp);
        gradeid = "grade"+k;
        tempgradeid = "grade"+(k+temp);
        subjectvalue="";
        gradevalue="";
        if((k<(wascrow))){
            subjectvalue = document.getElementById(tempsubjectid).value;
            gradevalue = document.getElementById(tempgradeid).value;
        }
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' value='"+subjectvalue+"' id='"+subjectid+"' onblur='this.value=capAdd(this.value)' size='50' /></td>";
        str += "<td width='10%'><input type='text' value='"+gradevalue+"' id='"+gradeid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='button' id=deletesubject' value='Delete' onclick=deleteOLevel('"+k+"') /></td></tr>";
    }
    str += "</table>";
    document.getElementById('olevel').innerHTML=str;
}

function populateOLevel(arg){
    var row_split = arg.split('_~_');
    document.getElementById('examno').value = row_split[0];
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Subject</td><td>Grade</td></tr>';
    var flag=0;
    var subjectid="";
    var gradeid="";
    var subjectvalue="";
    var gradevalue="";
    wascrow = 1;
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
        subjectid = "subject"+k;
        gradeid = "grade"+k;
        wascrow++;
        subjectvalue = col_split[0];
        gradevalue = col_split[1];

        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' value='"+subjectvalue+"' id='"+subjectid+"' onblur='this.value=capAdd(this.value)' size='50' /></td>";
        str += "<td width='10%'><input type='text' value='"+gradevalue+"' id='"+gradeid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='button' id=deletesubject' value='Delete' onclick=deleteOLevel('"+k+"') /></td></tr>";
    }
    str += "</table>";
    document.getElementById('olevel').innerHTML=str;
    valueflag = 1;
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
    document.getElementById('supportdocs').innerHTML=str;
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
    browseFiles2();

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
    document.getElementById('supportdocs').innerHTML=str;
}

function populateDoc(arg){
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
            str += "<td><div id='"+actionid+"'><a href=javascript:viewDoc('"+docidvalue+"')>View</a>&nbsp;&nbsp;<a href=javascript:deleteDoc('"+k+"')>Delete</a></div></td>";
        }else{
            str += "<td><div id='"+actionid+"'><a href=javascript:uploadDoc('"+k+"')>Upload new document</a></div></td>";
        }
    }
    str += "</tr></table>";
    document.getElementById('supportdocs').innerHTML=str;
    docflag = 1;
}

function updateRegularStudent(option, table){
    var selectoption=document.getElementById("title");
    var title=selectoption.options[selectoption.selectedIndex].text;
    var userPicture = readCookie("theImage");
    if(userPicture==null) userPicture = "";
    var regNumber = document.getElementById("regNumber").value;
    var firstName = document.getElementById("firstName").value;
    var middleName = document.getElementById("middleName").value;
    var lastName = document.getElementById("lastName").value;
    var userName = document.getElementById("regNumber").value;
    var userEmail = document.getElementById("userEmail").value;
    var phoneno = document.getElementById("phoneno").value;
    selectoption=document.getElementById("gender");
    var gender=selectoption.options[selectoption.selectedIndex].text;
    var dateOfBirth = document.getElementById("dateOfBirth").value;
    if(dateOfBirth!=null && dateOfBirth!="") {
		dateOfBirth = dateOfBirth.substr(6,4)+'-'+dateOfBirth.substr(3,2)+'-'+dateOfBirth.substr(0,2);
	}else{
		dateOfBirth = "0000-00-00";
	}
    selectoption=document.getElementById("active");
    var active=selectoption.options[selectoption.selectedIndex].text;
    selectoption=document.getElementById("ignorepay");
    var ignorepay=selectoption.options[selectoption.selectedIndex].text;
    selectoption=document.getElementById("lockrec");
    var lockrec=selectoption.options[selectoption.selectedIndex].text;
    var userAddress = document.getElementById("userAddress").value;
    var contactAddress = document.getElementById("contactAddress").value;
    var nationality = document.getElementById("nationality").value;
    var originState = document.getElementById("originState").value;
    var lga = document.getElementById("lga").value;
    var birthPlace = document.getElementById("birthPlace").value;
    var religion = document.getElementById("religion").value;
    selectoption=document.getElementById("maritalStatus");
    var maritalStatus=selectoption.options[selectoption.selectedIndex].text;
    var maidenName = document.getElementById("maidenName").value;
    var spouseName = document.getElementById("spouseName").value;
    var guardianName = document.getElementById("guardianName").value;
    var guardianEmail = document.getElementById("guardianEmail").value;
    var guardianphoneno = document.getElementById("guardianphoneno").value;
    var guardianAddress = document.getElementById("guardianAddress").value;
    selectoption=document.getElementById("guardianRelationship");
    var guardianRelationship=selectoption.options[selectoption.selectedIndex].text;
    var facultycode = document.getElementById("facultycode").value;
    var departmentcode = document.getElementById("departmentcode").value;
    var programmecode = document.getElementById("programmecode").value;
    var studentlevel = document.getElementById("studentlevel").value;
    var admissiontype = document.getElementById("admissiontype").value;
    var sessionss = document.getElementById("sessionss").value;
    var semesterss = document.getElementById("semesterss").value;
    var qualification = document.getElementById("qualification").value;
    var entryyear = document.getElementById("entryyear").value;
    var disability = document.getElementById("disability").value;
    var minimumunit = document.getElementById("minimumunit").value;
    var tcp = document.getElementById("tcp").value;
    var tnu = document.getElementById("tnu").value;
    var gpa = document.getElementById("gpa").value;
    var tnup = document.getElementById("tnup").value;

	var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    var error = "";
    if (regNumber=="") error += "Registration Number must not be blank.<br><br>";
    if (firstName=="") error += "First Name line1 must not be blank.<br><br>";
    if (lastName=="") error += "Last Name must not be blank.<br><br>";
    //if (dateOfBirth=="") error += "Date Of Birth must not be blank.<br><br>";
    if (gender=="") error += "Gender must not be blank.<br><br>";
    if (active=="") error += "Active must not be blank.<br><br>";
    //if (ignorepay=="") error += "Ignore payment must not be blank.<br><br>";
    //if (lockrec=="") error += "Lock Record must not be blank.<br><br>";
	if (active==null) active="";
	if (ignorepay==null) ignorepay="";
	if (lockrec==null) lockrec="";
    if (facultycode=="") error += "Student faculty line1 must not be blank.<br><br>";
    if (departmentcode=="") error += "Student department must not be blank.<br><br>";
    if (programmecode=="") error += "Student programme must not be blank.<br><br>";
    if (studentlevel=="") error += "Student level must not be blank.<br><br>";
    if (admissiontype=="") error += "Mode of Admission must not be blank.<br><br>";
    if (sessionss=="") error += "Session must not be blank.<br><br>";
    if (semesterss=="") error += "Semester must not be blank.<br><br>";
    if (qualification=="") error += "Student qualification to obtain must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if (minimumunit=="") error += "Minimum Unit to pass must not be blank.<br><br>";
    /*if (tcp=="") error += "TCP must not be blank.<br><br>";
    if (tnu=="") error += "TNU must not be blank.<br><br>";
    if (gpa=="") error += "GPA must not be blank.<br><br>";
    if (tnup=="") error += "TNUP must not be blank.<br><br>";
	if (isNaN(parseFloat(tcp)) && tcp.trim().length>0) error += "TCP must be numeric\n";
	if (isNaN(parseFloat(tnu)) && tnu.trim().length>0) error += "TNU must be numeric\n";
	if (isNaN(parseFloat(gpa)) && gpa.trim().length>0) error += "GPA must be numeric\n";
	if (isNaN(parseFloat(tnup)) && tnup.trim().length>0) error += "TNUP must be numeric\n";
    if (userEmail > "") {
        if (userEmail.match(illegalChars)) {
            error += "The email address contains illegal characters.<br><br>";
        } else if (!emailFilter.test(userEmail)) {              //test email for illegal characters
            error += "Enter a valid email address or select username option.<br><br>";
        }
    }
    if (guardianEmail > "") {
        if (guardianEmail.match(illegalChars)) {
            error += "The email address contains illegal characters.<br><br>";
        } else if (!emailFilter.test(guardianEmail)) {              //test email for illegal characters
            error += "Enter a valid email address or select username option.<br><br>";
        }
    }*/
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

	var wascresults = document.getElementById("examno").value;
    var subjectid="";
    var gradeid="";
    var subjectvalue="";
    var gradevalue="";
    for(var k=1; k<wascrow; k++){
        subjectid = "subject"+k;
        gradeid = "grade"+k;
        if((k<(wascrow))){
            subjectvalue = document.getElementById(subjectid).value;
            gradevalue = document.getElementById(gradeid).value;
        }
        wascresults += "_~_" + subjectvalue + "~_~" + gradevalue;
    }

    var supportdocs = "";
    var docid="";
    var docdesc="";
    var docidvalue="";
    var docdescvalue="";
    for(k=1; k<docrow; k++){
        docid = "docid"+k;
        docdesc = "docdesc"+k;
        if((k<(docrow))){
            docidvalue = document.getElementById(docid).value;
            docdescvalue = document.getElementById(docdesc).value;
        }
        supportdocs += "_~_" + docidvalue + "~_~" + docdescvalue;
    }
   
    var param = "&param="+serialno+"]["+regNumber+"]["+firstName+"]["+lastName+"]["+facultycode+"]["+departmentcode;
	param += "]["+programmecode+"]["+gender+"]["+dateOfBirth+"]["+userName+"][]["+middleName+"]["+userEmail;
	param += "]["+userAddress+"][]["+userPicture+"][Student]["+active;
	param += "][][][][][]["+maidenName+"]["+contactAddress+"]["+nationality+"]["+originState;
	param += "]["+lga+"]["+birthPlace+"]["+maritalStatus+"]["+religion+"]["+spouseName+"]["+title;
	param += "]["+guardianName+"]["+guardianAddress+"]["+guardianRelationship+"]["+disability;
	param += "]["+wascresults+"][]["+supportdocs+"]["+studentlevel+"]["+guardianEmail+"]["+ignorepay;
	param += "]["+lockrec+"]["+qualification+"]["+minimumunit+"]["+tcp+"]["+tnu+"]["+gpa+"]["+tnup+"]["+entryyear+"]["+phoneno+"]["+guardianphoneno+"]["+admissiontype;
	var param2 = "&param2="+regNumber+"]["+studentlevel+"]["+sessionss+"]["+semesterss;
    var url = "/mobiletech/dataentrybackend.php?option="+option+"&table="+table+param+param2+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionDataEntry(url);
}

function updateCourseStatus(statusid,matno,markid){
    var faculty = document.getElementById("facultycode5").value;
    var department = document.getElementById("departmentcode5").value;
    var programme = document.getElementById("programmecode5").value;
    var studentlevel = document.getElementById("studentlevel4").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var entryyear = document.getElementById("entryyear0").value;
    var coursecode = document.getElementById("coursecode5").value;
    var markdescription = document.getElementById("markdescription").value;
    var selectoption=document.getElementById(statusid);
    var cstatus=selectoption.options[selectoption.selectedIndex].text;
    var percentage = document.getElementById("percentage").value;
    var obtainable = document.getElementById("obtainable").value;
	if (cstatus=="Absent"){
		document.getElementById(markid).value=0;
	}else{
		document.getElementById(markid).value="";
	}
    mark = document.getElementById(markid).value;

	var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Prograame Code must not be blank.<br><br>";
    if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if (coursecode=="") error += "course Code must not be blank.<br><br>";
    if (markdescription=="") error += "Marks Description must not be blank.<br><br>";
    if (percentage=="") error += "Percentage Overall must not be blank.<br><br>";
    if (obtainable=="") error += "Marks Obtainable must not be blank.<br><br>";
    if (matno=="") error += "Matric number must not be blank.<br><br>";
    if (parseFloat(mark)>parseFloat(obtainable)){
		error += "Mark must be less than Maximum Marks Obtainable.<br><br>";
		document.getElementById(markid).value="";
	}
    if (isNaN(percentage)) error += "Percentage Overall must be numeric.<br><br>";
    if (isNaN(obtainable)) error += "Marks Obtainable must be numeric.<br><br>";
    if (isNaN(mark)) error += "Marks_Obtained must be numeric.<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	var serialno = 0;
    var param2 = "&param2="+cstatus;
	var param = "&param="+serialno+"]["+sesions+"]["+semester+"]["+coursecode+"]["+matno+"]["+markdescription;
	param += "]["+mark+"]["+obtainable+"]["+percentage+"]["+studentlevel+"]["+programme+"]["+faculty+"]["+department+"]["+entryyear;
	var option = "addRecord";
	if(cstatus==null || cstatus=="") option = "deleteRecord";
    var url = "/mobiletech/dataentrybackend.php?option="+option+"&table=retakecourses"+param+param2+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionDataEntry(url);
}

/*var marksrow = 1;
var valueflag = 0;
function addMarks(){
    if(marksrow>1){
        var temp_matno = "matno"+(marksrow-1);
        var temp_mark = "mark"+(marksrow-1);
        if(document.getElementById(temp_matno).value==null || document.getElementById(temp_matno).value=="" || document.getElementById(temp_mark).value==null || document.getElementById(temp_mark).value==""){
            document.getElementById("showError").innerHTML = "<b>Matric Number not added</b><br><br>Please save the last record before adding a new one.";
            $('#showError').dialog('open');
            return true;
        }
    }
    marksrow++;
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Matric_Numbers</td><td>Marks_Obtained</td></tr>';
    var flag=0;
    var matnoid="";
    var markid="";
    var serialnoid="";
    var matnovalue="";
    var markvalue="";
    var serialnovalue="";

    for(var k=1; k<marksrow; k++){
		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        matnoid = "matno"+k;
        markid = "mark"+k;
        serialnoid = "serialno"+k;
        matnovalue="";
        markvalue="";
        serialnovalue="";
        if((k<(marksrow-1)) && valueflag>0){
            matnovalue = document.getElementById(matnoid).value;
            markvalue = document.getElementById(markid).value;
            serialnovalue = document.getElementById(serialnoid).value;
        }
        valueflag = 1;
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' onkeyup=getRecordlist(this.id,'regularstudents','recordlist4') onfocus=getRecordlist(this.id,'regularstudents','recordlist4') value='"+matnovalue+"' id='"+matnoid+"' size='15' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td width='10%'><input type='text' value='"+markvalue+"' id='"+markid+"' onblur='this.value=numberFormat(this.value);' size='10' /></td>";
        if(matnovalue.length>0){
            str += "<td><a href=javascript:updateMark('"+serialnoid+"','"+matnoid+"','"+markid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateMark('"+serialnoid+"','"+matnoid+"','"+markid+"','deleteRecord')>Delete</a></td></tr>";
        }else{
            str += "<td><a href=javascript:updateMark('"+serialnoid+"','"+matnoid+"','"+markid+"','addRecord')>Save</a>&nbsp;&nbsp;<a href=javascript:clearMark('"+k+"')>Clear</a></td></tr>";
        }
    }
    str += "</table>";
    document.getElementById('markslist').innerHTML=str;
}*/

//function showMarks(){
//	$('#uploadresult').dialog('open');
//}

//var popmark = null;
function populateMark(arg){
	//createCookie("sortby",arg,false);
    var faculty = document.getElementById("facultycode5").value;
    var department = document.getElementById("departmentcode5").value;
    var programmecode = document.getElementById("programmecode5").value;
    var studentlevel = document.getElementById("studentlevel4").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var entryyear = document.getElementById("entryyear0").value;
    var coursecode = document.getElementById("coursecode5").value;
    var markdescription = document.getElementById("markdescription").value;
    //var percentage = document.getElementById("percentage").value;
    //var obtainable = document.getElementById("obtainable").value;

    var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
    if (programmecode=="") error += "Programme Code must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if (coursecode=="") error += "course Code must not be blank.<br><br>";
    if (markdescription=="") error += "Marks Description must not be blank.<br><br>";
    //if (percentage=="") error += "Percentage Overall must not be blank.<br><br>";
    //if (obtainable=="") error += "Marks Obtainable must not be blank.<br><br>";
    //if (isNaN(percentage)) error += "Percentage Overall must be numeric.<br><br>";
    //if (isNaN(obtainable)) error += "Marks Obtainable must be numeric.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_facultys",faculty,365);
	createCookie("_departments",department,365);
	createCookie("_programmes",programmecode,365);
	createCookie("_levels",studentlevel,365);
	createCookie("_sessions",sesions,365);
	createCookie("_semesters",semester,365);
	createCookie("_entryyears",entryyear,365);
	createCookie("_coursecodes",coursecode,365);

    var param = "&table=examresultstable&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear+"&access="+arg;
    param += "&coursecode="+coursecode+"&markdescription="+markdescription+"&studentlevel="+studentlevel;
	param += "&programmecode="+programmecode+"&facultycode="+faculty+"&departmentcode="+department;
    var url = "/mobiletech/dataentrybackend.php?option=getAllRecs"+param;
    //popmark = "1";
	AjaxFunctionDataEntry(url);
}

function populateMarks(arg){
//        document.getElementById("showError").innerHTML = arg;
//        $('#showError').dialog('open');
    var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += "<td>S/No</td><td><a style='color:white' href=javascript:populateMark('a.regNumber') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Reg_No',event) onmouseout=toolTip('msgdiv','',event)>Reg_No</a></td>";
	str += "<td><a style='color:white' href=javascript:populateMark('a.lastName') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Names',event) onmouseout=toolTip('msgdiv','',event)>Names</a></td>";
	str += "<td>Marks_Obtained</td><td>Retake_Status</td></tr>";
	//<a href=javascript:populateMark('b.marksobtained') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Marks',event) onmouseout=toolTip('msgdiv','',event)></a>
    var flag=0;
    var matnoid="";
    var markid="";
    var serialnoid="";
    var statusid="";
    var matnovalue="";
    var markvalue="";
    var serialnovalue="";
    //marksrow = 1;
    var col_split = "";
    var count=0;
	for(var k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('!!!');
		/*if(col_split[14] == null || col_split[15] == null || col_split[14] == "" || col_split[15] == "" || 
			col_split[14] != document.getElementById("studentlevel4").value || 
			col_split[15] != document.getElementById("programmecode5").value || 
			col_split[17] != document.getElementById("entryyear0").value || 
			col_split[16]!='Yes')
			continue;*/

		if(col_split[7]>"")document.getElementById("obtainable").value=col_split[7];
		if(col_split[8]>"")document.getElementById("percentage").value=col_split[8];
		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        matnoid = "matno"+k;
        markid = "mark"+k;
        serialnoid = "serialno"+k;
        statusid = "retakestatusid"+k;
        //marksrow++;
        matnovalue = col_split[14];
        markvalue = col_split[6];
        serialnovalue = col_split[0];
		var fullname = col_split[15].toUpperCase()+", "+col_split[16];
		if(col_split[17]>"") fullname += " "+col_split[17];

		str += "<td width='5%' align='right'>"+(++count)+".</td>";
        //str += "<td width='30%'><input type='text' value='"+matnovalue+"' id='"+matnoid+"' size='15' />";
        str += "<td width='30%'>"+matnovalue;
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td width='40%'>"+fullname+"</td>";
        str += "<td width='10%'><input type='text' value='"+markvalue+"' id='"+markid+"' onblur=updateMark('"+serialnovalue+"','"+matnovalue+"','"+markid+"','addRecord','"+statusid+"') size='10' /></td>";
		if(col_split[19]==null || col_split[19]==""){
			str += "<td><select id='"+statusid+"' onchange=updateCourseStatus('"+statusid+"','"+col_split[14]+"','"+markid+"')><option selected></option><option>Absent</option><option>Ignore DE</option><option>Retake</option></select></td></tr>";
		}else if(col_split[19]=="Absent"){
			str += "<td><select id='"+statusid+"' onchange=updateCourseStatus('"+statusid+"','"+col_split[14]+"','"+markid+"')><option></option><option selected>Absent</option><option>Ignore DE</option><option>Retake</option></select></td></tr>";
		}else if(col_split[19]=="Ignore DE"){
			str += "<td><select id='"+statusid+"' onchange=updateCourseStatus('"+statusid+"','"+col_split[14]+"','"+markid+"')><option></option><option>Absent</option><option selected>Ignore DE</option><option>Retake</option></select></td></tr>";
		}else if(col_split[19]=="Retake"){
			str += "<td><select id='"+statusid+"' onchange=updateCourseStatus('"+statusid+"','"+col_split[14]+"','"+markid+"')><option></option><option>Absent</option><option>Ignore DE</option><option selected>Retake</option></select></td></tr>";
		}
        //str += "<td><a href=javascript:updateMark('"+serialnoid+"','"+matnoid+"','"+markid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateMark('"+serialnoid+"','"+matnoid+"','"+markid+"','deleteRecord')>Delete</a></td></tr>";
    }
    str += "</table>";
    document.getElementById('markslist').innerHTML=str;
}

function updateMark(serialno,matno,markid,option,statusid){
	//matno = document.getElementById(matno).value;
    mark = document.getElementById(markid).value;
    var faculty = document.getElementById("facultycode5").value;
    var department = document.getElementById("departmentcode5").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var coursecode = document.getElementById("coursecode5").value;
    var markdescription = document.getElementById("markdescription").value;
    var percentage = document.getElementById("percentage").value;
    var obtainable = document.getElementById("obtainable").value;
    var studentlevel = document.getElementById("studentlevel4").value;
    var programme = document.getElementById("programmecode5").value;
    var entryyear = document.getElementById("entryyear0").value;
    var selectoption=document.getElementById(statusid);
	if(mark>0) selectoption.selectedIndex = 0;
	var cstatus=selectoption.options[selectoption.selectedIndex].text;
	var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Prograame Code must not be blank.<br><br>";
    if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if (coursecode=="") error += "course Code must not be blank.<br><br>";
    if (markdescription=="") error += "Marks Description must not be blank.<br><br>";
    if (percentage=="") error += "Percentage Overall must not be blank.<br><br>";
    if (obtainable=="") error += "Marks Obtainable must not be blank.<br><br>";
    if (matno=="") error += "Matric number must not be blank.<br><br>";
    //if (mark=="") error += "Marks_Obtained must not be blank.<br><br>";
    if (parseFloat(mark)>parseFloat(obtainable)){
		error += "Mark must be less than Maximum Marks Obtainable.<br><br>";
		document.getElementById(markid).value="";
	}
    if (isNaN(percentage)) error += "Percentage Overall must be numeric.<br><br>";
    if (isNaN(obtainable)) error += "Marks Obtainable must be numeric.<br><br>";
    if (isNaN(mark)) error += "Marks_Obtained must be numeric.<br><br>";

	//if (mark=="" && serialno=="") return true;
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	//if(serialno=="") option = "addRecord";
	if(mark=="") option = "deleteRecord";
    //if(option != "addRecord") serialno = document.getElementById(serialno).value;
    //if(serialno==null) serialno="";

	//if(option != "addRecord") serialno = document.getElementById(serialno).value;
    //if(serialno==null) serialno="";
    var table ="examresultstable";
    var param2 = "&param2="+cstatus;
	var param = "&param="+serialno+"]["+sesions+"]["+semester+"]["+coursecode+"]["+matno+"]["+markdescription;
	param += "]["+mark+"]["+obtainable+"]["+percentage+"]["+studentlevel+"]["+programme+"]["+faculty+"]["+department+"]["+entryyear;

    var url = "/mobiletech/dataentrybackend.php?option="+option+"&table="+table+param+param2+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionDataEntry(url);
}

function updateAmendMark(serialno,matno,markid,newmarkid,option,reasonid){
	//matno = document.getElementById(matno).value;
    var mark = document.getElementById(markid).value;
    var newmark = document.getElementById(newmarkid).value;
    //var reason = document.getElementById(reasonid).value;
    var reason = "";
    var faculty = document.getElementById("facultycode1").value;
    var department = document.getElementById("departmentcode1").value;
    var sesions = document.getElementById("sesions1").value;
    var semester = document.getElementById("semester1").value;
    var coursecode = document.getElementById("coursecode1").value;
    var markdescription = document.getElementById("markdescription1").value;
    var percentage = document.getElementById("percentage1").value;
    var obtainable = document.getElementById("obtainable1").value;
    var studentlevel = document.getElementById("studentlevel1").value;
    var programme = document.getElementById("programmecode1").value;
    var entryyear = document.getElementById("entryyear1").value;
    var amendedtitle = document.getElementById("amendedtitle").value;
    var amendreason = document.getElementById("amendreason").value;

	var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Prograame Code must not be blank.<br><br>";
    if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if (coursecode=="") error += "Course Code must not be blank.<br><br>";
    if (amendedtitle=="") error += "Title for Amendment must not be blank.<br><br>";
    if (amendreason=="") error += "Reason for Amendment must not be blank.<br><br>";
    if (markdescription=="") error += "Marks Description must not be blank.<br><br>";
    if (percentage=="") error += "Percentage Overall must not be blank.<br><br>";
    if (obtainable=="") error += "Marks Obtainable must not be blank.<br><br>";
    if (matno=="") error += "Matric number must not be blank.<br><br>";
    //if (mark=="") error += "Marks_Obtained must not be blank.<br><br>";
    if (parseFloat(mark)>parseFloat(obtainable)){
		error += "Mark must be less than Maximum Marks Obtainable.<br><br>";
		document.getElementById(markid).value="";
	}
    if (parseFloat(newmark)>parseFloat(obtainable)){
		error += "Amended Mark must be less than Maximum Marks Obtainable.<br><br>";
		document.getElementById(newmarkid).value="";
	}
    if (isNaN(percentage)) error += "Percentage Overall must be numeric.<br><br>";
    if (isNaN(obtainable)) error += "Marks Obtainable must be numeric.<br><br>";
    if (isNaN(mark)) error += "Previous Mark must be numeric.<br><br>";
    if (isNaN(newmark)) error += "Amended Mark must be numeric.<br><br>";
    //if (reason=="") error += "Amendment reason must not be blank.<br><br>";
    if (reason!="" && newmark=="") error += "Amended Mark must not be blank.<br><br>";
    //if (newmark!="" && reason=="") error += "Amendment reason must not be blank.<br><br>";

	//if (mark=="" && serialno=="") return true;
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	//if(serialno=="") option = "addRecord";
	if(newmark=="" && reason=="") option = "deleteRecord";
    //if(option != "addRecord") serialno = document.getElementById(serialno).value;
    //if(serialno==null) serialno="";

	//if(option != "addRecord") serialno = document.getElementById(serialno).value;
    //if(serialno==null) serialno="";
    var table ="amendedresults";
    //var param2 = "&param2="+cstatus;
	var param = "&param="+serialno+"]["+sesions+"]["+semester+"]["+coursecode+"]["+matno+"]["+markdescription;
	param += "]["+mark+"]["+obtainable+"]["+percentage+"]["+studentlevel+"]["+programme+"]["+faculty+"]["+department;
	param += "]["+entryyear+"]["+reason+"]["+mark+"]["+newmark;
	var param2 = "&param2="+faculty+"]["+department+"]["+programme+"]["+entryyear+"]["+studentlevel+"]["+sesions+"]["+semester+"]["+coursecode+"]["+amendedtitle+"]["+amendreason;
    var url = "/mobiletech/dataentrybackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno+param2;
	AjaxFunctionDataEntry(url);
}

/*function clearMark(arg){
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td>Matric_Numbers</td><td>Marks_Obtained</td></tr>';
    var flag=0;
    var matnoid="";
    var markid="";
    var tempmatnoid="";
    var tempmarkid="";
    var matnovalue="";
    var markvalue="";
    var temp = 0;
    deleteflag = 0;
    for(var k=1; k<marksrow; k++){
        if(k==arg && deleteflag==0){
            deleteflag=1;
            marksrow--;
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
        matnoid = "matno"+k;
        tempmatnoid = "matno"+(k+temp);
        markid = "mark"+k;
        tempmarkid = "mark"+(k+temp);
        matnovalue="";
        markvalue="";
        if((k<(marksrow))){
            matnovalue = document.getElementById(tempmatnoid).value;
            markvalue = document.getElementById(tempmarkid).value;
        }
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='30%'><input type='text' value='"+matnovalue+"' id='"+matnoid+"' size='15' /></td>";
        str += "<td width='10%'><input type='text' value='"+markvalue+"' id='"+markid+"' onblur='this.value=numberFormat(this.value);' size='10' /></td>";
        str += "<td><a href=javascript:updateMark('"+matnoid+"','"+markid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateMark('"+matnoid+"','"+markid+"','deleteRecord')>Delete</a></td></tr>";
    }
    str += "</table>";
    document.getElementById('markslist').innerHTML=str;
	populateMark('regNumber');
}*/

function populateAmended(arg,sortorder){
	if(sortorder==null) sortorder="";
    var faculty = document.getElementById("facultycode1").value;
    var department = document.getElementById("departmentcode1").value;
    var programmecode = document.getElementById("programmecode1").value;
    var studentlevel = document.getElementById("studentlevel1").value;
    var coursecode = document.getElementById("coursecode1").value;
    var sesions = document.getElementById("sesions1").value;
    var semester = document.getElementById("semester1").value;
    var entryyear = document.getElementById("entryyear1").value;
    var markdescription = document.getElementById("markdescription").value;
    var amendedtitle = document.getElementById("amendedtitle").value;

    var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programmecode=="") error += "Programme Code must not be blank.<br><br>";
    if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
    if (coursecode=="") error += "course Code must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if (markdescription=="") error += "Marks Description must not be blank.<br><br>";
    if (amendedtitle=="") error += "Amendment Title must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_facultys",faculty,365);
	createCookie("_departments",department,365);
	createCookie("_programmes",programmecode,365);
	createCookie("_levels",studentlevel,365);
	createCookie("_sessions",sesions,365);
	createCookie("_semesters",semester,365);
	createCookie("_entryyears",entryyear,365);
	createCookie("_amendedtitles",amendedtitle,365);
	createCookie("_coursecodes",coursecode,365);

    var param = "&table=amendedresults&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear+"&access="+arg;
    param += "&coursecode="+coursecode+"&markdescription="+markdescription+"&amendedtitle="+amendedtitle+"&studentlevel="+studentlevel;
	param += "&programmecode="+programmecode+"&facultycode="+faculty+"&departmentcode="+department;
    var url = "/mobiletech/dataentrybackend.php?option=getAllRecs"+param+"&sortorder="+sortorder;

	
	//var param = "&table=amendedresults&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear;
    //param += "&facultycode="+faculty+"&departmentcode="+department+"&programmecode="+programmecode+"&studentlevel="+studentlevel+"&access="+arg;
    //var url = "/mobiletech/dataentrybackend.php?option=getAllRecs"+param;
	AjaxFunctionDataEntry(url);
}

function populateAmendeds(arg){
	//document.getElementById("showError").innerHTML = arg;
	//$('#showError').dialog('open');
    var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += "<td>S/No</td><td><a style='color:white' href=javascript:populateAmended('a.regNumber') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Reg_No',event) onmouseout=toolTip('msgdiv','',event)>Reg_No</a></td>";
	str += "<td><a style='color:white' href=javascript:populateAmended('a.lastName') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Names',event) onmouseout=toolTip('msgdiv','',event)>Names</a></td>";
	str += "<td>Previous_Marks</td><td>Amended_Marks</td></tr>";
	//<td>Amendment_Reasons</td>
	//<a href=javascript:populateMark('b.marksobtained') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Marks',event) onmouseout=toolTip('msgdiv','',event)></a>
    var flag=0;
    var matnoid="";
    var markid="";
    var newmarkid="";
    var serialnoid="";
    //var reasonid="";
    var matnovalue="";
    var markvalue="";
    var newmarkvalue="";
    var serialnovalue="";
    //var reasonvalue="";
    //marksrow = 1;
    var col_split = "";
    var count=0;
	for(var k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('!!!');
		/*if(col_split[14] == null || col_split[15] == null || col_split[14] == "" || col_split[15] == "" || 
			col_split[14] != document.getElementById("studentlevel4").value || 
			col_split[15] != document.getElementById("programmecode5").value || 
			col_split[17] != document.getElementById("entryyear0").value || 
			col_split[16]!='Yes')
			continue;*/

		if(col_split[7]>"")document.getElementById("obtainable").value=col_split[7];
		if(col_split[8]>"")document.getElementById("percentage").value=col_split[8];
		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        matnoid = "matno"+k;
        markid = "mark"+k;
        newmarkid = "newmark"+k;
        serialnoid = "serialno"+k;
        //reasonid = "reasonid"+k;
        //marksrow++;
        matnovalue = col_split[23];
        markvalue = col_split[15];
		if(col_split[15]==null || col_split[15]=="") markvalue = col_split[6];
        newmarkvalue = col_split[16];
		//reasonvalue = col_split[14];
        serialnovalue = col_split[0];
		var fullname = col_split[24].toUpperCase()+", "+col_split[25];
		if(col_split[26]>"") fullname += " "+col_split[26];

		str += "<td width='5%' align='right'>"+(++count)+".</td>";
        //str += "<td width='30%'><input type='text' value='"+matnovalue+"' id='"+matnoid+"' size='15' />";
        str += "<td>"+matnovalue;
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td>"+fullname+"</td>";
        str += "<td><input type='text' readonly value='"+markvalue+"' id='"+markid+"' size='10' /></td>";
        str += "<td><input type='text' value='"+newmarkvalue+"' id='"+newmarkid+"' size='10' onblur=updateAmendMark('"+serialnovalue+"','"+matnovalue+"','"+markid+"','"+newmarkid+"','addRecord','') /></td>";
        //str += "<td><input type='text' value='"+reasonvalue+"' id='"+reasonid+"' onblur=updateAmendMark('"+serialnovalue+"','"+matnovalue+"','"+markid+"','"+newmarkid+"','addRecord','"+reasonid+"') size='60' /></td></tr>";
        str += "</tr>";
		/*if(col_split[19]==null || col_split[19]==""){
			str += "<td><select id='"+reasonid+"' onchange=updateCourseStatus('"+reasonid+"','"+col_split[14]+"','"+markid+"')><option selected></option><option>Absent</option><option>Ignore DE</option><option>Retake</option></select></td></tr>";
		}else if(col_split[19]=="Absent"){
			str += "<td><select id='"+reasonid+"' onchange=updateCourseStatus('"+reasonid+"','"+col_split[14]+"','"+markid+"')><option></option><option selected>Absent</option><option>Ignore DE</option><option>Retake</option></select></td></tr>";
		}else if(col_split[19]=="Ignore DE"){
			str += "<td><select id='"+reasonid+"' onchange=updateCourseStatus('"+reasonid+"','"+col_split[14]+"','"+markid+"')><option></option><option>Absent</option><option selected>Ignore DE</option><option>Retake</option></select></td></tr>";
		}else if(col_split[19]=="Retake"){
			str += "<td><select id='"+reasonid+"' onchange=updateCourseStatus('"+reasonid+"','"+col_split[14]+"','"+markid+"')><option></option><option>Absent</option><option>Ignore DE</option><option selected>Retake</option></select></td></tr>";
		}*/
        //str += "<td><a href=javascript:updateMark('"+serialnoid+"','"+matnoid+"','"+markid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateMark('"+serialnoid+"','"+matnoid+"','"+markid+"','deleteRecord')>Delete</a></td></tr>";
    }
    str += "</table>";
    document.getElementById('markslist1').innerHTML=str;
	getAmendReason();
}

function getAmendReason(){
    var faculty = document.getElementById("facultycode1").value;
    var department = document.getElementById("departmentcode1").value;
    var programmecode = document.getElementById("programmecode1").value;
    var studentlevel = document.getElementById("studentlevel1").value;
    var coursecode = document.getElementById("coursecode1").value;
    var sesions = document.getElementById("sesions1").value;
    var semester = document.getElementById("semester1").value;
    var entryyear = document.getElementById("entryyear1").value;
    var amendedtitle = document.getElementById("amendedtitle").value;

    var param = "&table=amendedreasons&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear;
    param += "&coursecode="+coursecode+"&amendedtitle="+amendedtitle+"&studentlevel="+studentlevel;
	param += "&programmecode="+programmecode+"&facultycode="+faculty+"&departmentcode="+department;
    var url = "/mobiletech/dataentrybackend.php?option=getARecord"+param;
	AjaxFunctionDataEntry(url);
}

function populateFeature(arg){
    var faculty = document.getElementById("facultycode6").value;
    var department = document.getElementById("departmentcode6").value;
    var programmecode = document.getElementById("programmecode6").value;
    var studentlevel = document.getElementById("studentlevel6").value;
    var sesions = document.getElementById("sesions5").value;
    var semester = document.getElementById("semester5").value;
    var entryyear = document.getElementById("entryyear5").value;

    var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programmecode=="") error += "Programme Code must not be blank.<br><br>";
    if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_facultys",faculty,365);
	createCookie("_departments",department,365);
	createCookie("_programmes",programmecode,365);
	createCookie("_levels",studentlevel,365);
	createCookie("_sessions",sesions,365);
	createCookie("_semesters",semester,365);
	createCookie("_entryyears",entryyear,365);
    var param = "&table=specialfeatures&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear;
    param += "&facultycode="+faculty+"&departmentcode="+department+"&programmecode="+programmecode+"&studentlevel="+studentlevel+"&access="+arg;
    var url = "/mobiletech/dataentrybackend.php?option=getAllRecs"+param;
	AjaxFunctionDataEntry(url);
}

function populateFeatures(arg){
    var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += "<td>S/No</td><td><a style='color:white' href=javascript:populateFeature('a.regNumber') onmouseover=toolTip('msgdiv2','Click_here_to_sort_by_Reg_No',event) onmouseout=toolTip('msgdiv2','',event)>Reg_No</a></td>";
	str += "<td><a style='color:white' href=javascript:populateFeature('a.lastName') onmouseover=toolTip('msgdiv2','Click_here_to_sort_by_Names',event) onmouseout=toolTip('msgdiv2','',event)>Names</a></td>";
	str += "<td>Special Features</td></tr>";
	//<a href=javascript:populateFeature('b.feature') onmouseover=toolTip('msgdiv2','Click_here_to_sort_by_Features',event) onmouseout=toolTip('msgdiv2','',event)></a>
    var flag=0;
    var matnoid="";
    var featureid="";
    var serialnoid="";
    var matnovalue="";
    var featurevalue="";
    var serialnovalue="";
    featuresrow = 1;
    var col_split = "";
    var count=0;
	for(var k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('!!!');
		//if(col_split[4] == null || col_split[5] == null || col_split[4] == "" || col_split[5] == "" || 
		//	col_split[4] != document.getElementById("studentlevel6").value || 
		//	col_split[5] != document.getElementById("programmecode6").value || 
		//	col_split[7] != document.getElementById("entryyear5").value || 
		//	col_split[6]!='Yes')
		//	continue;

		if(flag==0){
			str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
		}else{
			str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
		}
        matnoid = "matno"+k;
        featureid = "feature"+k;
        serialnoid = "serialno"+k;
        featuresrow++;
        matnovalue = col_split[0];
        featurevalue = col_split[9];
        serialnovalue = col_split[0];
		var fullname = col_split[1].toUpperCase()+", "+col_split[2];
		if(col_split[13]>"") fullname += " "+col_split[3];

		str += "<td width='5%' align='right'>"+(++count)+".</td>";
        str += "<td width='30%'>"+matnovalue;
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td width='30%'>"+fullname+"</td>";
        str += "<td width='10%'><input type='text' value='"+featurevalue+"' id='"+featureid+"' onblur=updateFeature('"+serialnovalue+"','"+matnovalue+"','"+featureid+"','addRecord') size='80' /></td></tr>";
    }
    str += "</table>";
    document.getElementById('featureslist').innerHTML=str;
}

function updateFeature(serialno,matno,featureid,option){
    var faculty = document.getElementById("facultycode6").value;
    var department = document.getElementById("departmentcode6").value;
    var programmecode = document.getElementById("programmecode6").value;
    var studentlevel = document.getElementById("studentlevel6").value;
    var sesions = document.getElementById("sesions5").value;
    var semester = document.getElementById("semester5").value;
    var entryyear = document.getElementById("entryyear5").value;
	document.getElementById(featureid).value=capAdd(document.getElementById(featureid).value)
	var feature = document.getElementById(featureid).value;

    var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programmecode=="") error += "Programme Code must not be blank.<br><br>";
    if (studentlevel=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

	if(feature=="") option = "deleteRecord";
    var table ="specialfeatures";
    
	var param = "&param="+serialno+"]["+matno+"]["+sesions+"]["+semester+"]["+feature+"][";
	param += faculty+"]["+department+"]["+programmecode+"]["+studentlevel+"]["+entryyear;

    var url = "/mobiletech/dataentrybackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionDataEntry(url);
}

function resetForm(){
    createCookie("theImage",null,false);
    var selectoption = document.getElementById("active");
    selectoption.selectedIndex = 0;
    selectoption = document.getElementById("ignorepay");
    selectoption.selectedIndex = 0;
    selectoption = document.getElementById("lockrec");
    selectoption.selectedIndex = 0;
    selectoption = document.getElementById("title");
    selectoption.selectedIndex = 0;
    selectoption = document.getElementById("maritalStatus");
    selectoption.selectedIndex = 0;
    selectoption = document.getElementById("gender");
    selectoption.selectedIndex = 0;
    selectoption = document.getElementById("guardianRelationship");
    selectoption.selectedIndex = 0;
    document.getElementById("regNumber").value="";
    document.getElementById("firstName").value="";
    document.getElementById("middleName").value="";
    document.getElementById("lastName").value="";
    document.getElementById("regNumber").value="";
    document.getElementById("userEmail").value="";
    document.getElementById("phoneno").value="";
    document.getElementById("guardianphoneno").value="";
    document.getElementById("dateOfBirth").value="";
    document.getElementById("userAddress").value="";
    document.getElementById("contactAddress").value="";
    document.getElementById("nationality").value="";
    document.getElementById("originState").value="";
    document.getElementById("lga").value="";
    document.getElementById("birthPlace").value="";
    document.getElementById("religion").value="";
    document.getElementById("maidenName").value="";
    document.getElementById("spouseName").value="";
    document.getElementById("guardianName").value="";
    document.getElementById("guardianEmail").value="";
    document.getElementById("guardianAddress").value="";
    document.getElementById("facultycode").value="";
    document.getElementById("departmentcode").value="";
    document.getElementById("programmecode").value="";
    document.getElementById("studentlevel").value="";
    document.getElementById("admissiontype").value="";
    document.getElementById("qualification").value="";
    document.getElementById("entryyear").value="";
    document.getElementById("disability").value="";
    document.getElementById("minimumunit").value="";
    document.getElementById("tcp").value="";
    document.getElementById("tnu").value="";
    document.getElementById("gpa").value="";
    document.getElementById("tnup").value="";
    document.getElementById("examno").value="";
    document.getElementById("supportdocs").value="";
    document.getElementById("signatoryposition").value="";
    document.getElementById("signatoryname").value="";
    /*document.getElementById("sessiondescription").value=readCookie("currentsession");
    document.getElementById("sessiondescription").disabled=true;
    document.getElementById("facultycode2").value="";
    document.getElementById("departmentcode2").value="";
    document.getElementById("programmecode2").value="";
    document.getElementById("studentlevel2").value="";
    document.getElementById("amountdue").value="";
    document.getElementById("minimumpayment").value="";
    document.getElementById("sessiondescription2").value=readCookie("currentsession");
    document.getElementById("matricno").value="";
    document.getElementById("amountpaid").value="";*/
}

function openStudentDetails(){
    //resetForm();
    $('#studentsupdate').dialog('close');
    $('#regularstudents').dialog('open');
	loadImage("silhouette.jpg");
}

function getRecords(table,serialno){
	//resetForm();
    if(serialno == null || serialno.length == 0) serialno = "1";
    //$('#menuList').dialog('close');
    //resetForm();
    if(table=='regularstudents') {
        $('#studentsupdate').dialog('open');
    }

/*    if(table=='studentfees') {
        $('#studentfees').dialog('open');
    }

    if(table=='studentpays') {
        $('#studentpays').dialog('open');
    }*/

    var param = "";
    if(table=='filterbutton') {
        table='regularstudents';

        var facultys = document.getElementById("facultycodes").value;
        var departments = document.getElementById("departmentcodes").value;
        var programmes = document.getElementById("programmecodes").value;
		var levels = document.getElementById("studentlevels").value;
		var sessions = document.getElementById("sesionsA").value;
		var semesters = document.getElementById("semestersA").value;
		var entryyears = document.getElementById("entryyearsA").value;
		var studentno = document.getElementById("students").value;
	    var selectoption=document.getElementById("selectactive");
		var active=selectoption.options[selectoption.selectedIndex].text;

		createCookie("_facultys",facultys,365);
		createCookie("_departments",departments,365);
		createCookie("_programmes",programmes,365);
		createCookie("_levels",levels,365);
		createCookie("_sessions",sessions,365);
		createCookie("_semesters",semesters,365);
		createCookie("_entryyears",entryyears,365);
		createCookie("_selectactive",active,365);
		createCookie("_studentno",studentno,365);

        param += "&facultycode="+facultys+"&departmentcode="+departments+"&programmecode="+programmes;
        param += "&studentlevel="+levels+"&sesions="+sessions+"&semester="+semesters+"&entryyear="+entryyears;
		param += "&regNumber="+studentno+"&active="+active;
    }
    if(table=='listrecords') {
        table='regularstudentsA';

        var facultys = document.getElementById("facultycode4").value;
        var departments = document.getElementById("departmentcode4").value;
        var programmes = document.getElementById("programmecode4").value;
		var entryyears = document.getElementById("entryyear3").value;

		createCookie("_facultys",facultys,365);
		createCookie("_departments",departments,365);
		createCookie("_programmes",programmes,365);
		createCookie("_entryyears",entryyears,365);

		param += "&facultycode="+facultys+"&departmentcode="+departments+"&programmecode="+programmes;
        param += "&entryyear="+entryyears;
        
		facultycode = document.getElementById("facultycode4").value;
		departmentcode = document.getElementById("departmentcode4").value;
		programmecode = document.getElementById("programmecode4").value;
	    sessionsA = document.getElementById("sesions4a").value;
	    sessionsB = document.getElementById("sesions4b").value;
		groupsession = document.getElementById("entryyear3").value;
	    selectoption=document.getElementById("finalyear1");
		finalyear=selectoption.options[selectoption.selectedIndex].text;
		var error="";
		if(sessionsA>sessionsB)	error = "Please ensure that Session_(From) is less than Session_(To).<br><br>";
		if (sessionsA=="") error += "Session_(From) must not be blank.<br><br>";
		if (sessionsB=="") error += "Session_(To) must not be blank.<br><br>";
		var awardate="";
		if (finalyear=="Yes"){
			awardate=document.getElementById("awardate").value;
			if(awardate==null || awardate=="") error += "Award Date must not be blank if final year is yes.<br><br>";
		}
		if (facultycode=="") error += "Faculty must not be blank.<br><br>";
		if (departmentcode=="") error += "Department must not be blank.<br><br>";
		if (programmecode=="") error += "Programme must not be blank.<br><br>";
		if (groupsession=="") error += "Group Code must not be blank.<br><br>";
		
		if(error.length >0) {
			error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
			document.getElementById("showError").innerHTML = error;
			$('#showError').dialog('open');
			return true;
		}
    }
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.......";
    $('#showAlert').dialog('open');
    var url = "/mobiletech/dataentrybackend.php?option=getAllRecs"+"&table="+table+"&serialno="+serialno+param;
	AjaxFunctionDataEntry(url);
}

function getUser(email){
    document.getElementById("showAlert").innerHTML = "<br><br><b>Please wait...</b><br><br>Authenticating your Email.";
    $('#showAlert').dialog('open');
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    var error = "";
    if (email == "") {
        error += "Enter an email address.<br><br>";
    } else if (email.match(illegalChars)) {
        error += "The email address contains illegal characters.<br><br>";
    } else if (!emailFilter.test(email)) {              //test email for illegal characters
        error += "Enter a valid email address.<br><br>";
    }
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        //alert("Please correct the following: <br><br>" + error);
        return error;
    }
    var url = "/mobiletech/dataentrybackend.php?option=getUser&userEmail="+email;
    AjaxFunctionDataEntry(url);
}

function populateRecords(serialno, table, regnum){
	createCookie("serialno",serialno,false);
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
	var param="";
	if(table=="regularstudents"){
		var sessions = document.getElementById("sesionsA").value;
		var semesters = document.getElementById("semestersA").value;
		param += "&regNumber="+regnum+"&sesions="+sessions+"&semester="+semesters;
	}
    var url = "/mobiletech/dataentrybackend.php?option=getARecord"+"&table="+table+"&serialno="+serialno+param;
    AjaxFunctionDataEntry(url);
}

function getRecordlist(arg2,arg3,arg4){
   curr_obj = document.getElementById(arg2);
    temp_table = arg3;
    list_obj = arg4;
	createCookie("list_obj",list_obj,false);
	var param="";
	if(arg2=="departmentcodes"){
		var facultycode=document.getElementById("facultycodes").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on Faculty selected.\nPlease select a faculty");
			document.getElementById("facultycodes").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecodes"){
		var departmentcode=document.getElementById("departmentcodes").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcodes").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="departmentcode1"){
		var facultycode=document.getElementById("facultycode1").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on Faculty selected.\nPlease select a faculty");
			document.getElementById("facultycode1").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode1"){
		var departmentcode=document.getElementById("departmentcode1").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode1").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="departmentcode2"){
		var facultycode=document.getElementById("facultycode2").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on Faculty selected.\nPlease select a faculty");
			document.getElementById("facultycode2").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode2"){
		var departmentcode=document.getElementById("departmentcode2").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode2").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="departmentcode3"){
		var facultycode=document.getElementById("facultycode3").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on Faculty selected.\nPlease select a faculty");
			document.getElementById("facultycode3").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode3"){
		var departmentcode=document.getElementById("departmentcode3").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode3").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="departmentcode4"){
		var facultycode=document.getElementById("facultycode4").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on Faculty selected.\nPlease select a faculty");
			document.getElementById("facultycode4").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode4"){
		var departmentcode=document.getElementById("departmentcode4").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode4").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="departmentcode5"){
		var facultycode=document.getElementById("facultycode5").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on Faculty selected.\nPlease select a faculty");
			document.getElementById("facultycode5").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode5"){
		var departmentcode=document.getElementById("departmentcode5").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode5").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="departmentcode6"){
		var facultycode=document.getElementById("facultycode6").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on Faculty selected.\nPlease select a faculty");
			document.getElementById("facultycode6").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode6"){
		var departmentcode=document.getElementById("departmentcode6").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode6").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2.substr(0,5)=="matno"){
		param="";
		param += "&studentlevel="+document.getElementById("studentlevel4").value;
	}
	if(arg2.substr(0,9)=="matricno4"){
		param="";
		param += "&facultycode="+document.getElementById("facultycode4").value;
		param += "&departmentcode="+document.getElementById("departmentcode4").value;
		param += "&programmecode="+document.getElementById("programmecode4").value;
		param += "&studentlevel="+document.getElementById("studentlevel5").value;
		param += "&entryyear="+document.getElementById("entryyear3").value;
	}
	if(arg2.substr(0,11)=="coursecode5"){
		param="";
		param += "&facultycode="+document.getElementById("facultycode5").value;
		param += "&departmentcode="+document.getElementById("departmentcode5").value;
		param += "&programmecode="+document.getElementById("programmecode5").value;
		param += "&studentlevel="+document.getElementById("studentlevel4").value;
		param += "&sesions="+document.getElementById("sesions").value;
		param += "&semester="+document.getElementById("semester").value;
		param += "&entryyear="+document.getElementById("entryyear0").value;
	}
	if(arg2.substr(0,11)=="coursecode1"){
		param="";
		param += "&facultycode="+document.getElementById("facultycode1").value;
		param += "&departmentcode="+document.getElementById("departmentcode1").value;
		param += "&programmecode="+document.getElementById("programmecode1").value;
		param += "&studentlevel="+document.getElementById("studentlevel1").value;
		param += "&sesions="+document.getElementById("sesions1").value;
		param += "&semester="+document.getElementById("semester1").value;
		param += "&entryyear="+document.getElementById("entryyear1").value;
	}
	if(arg2.substr(0,8)=="students"){
		param="";
		param += "&facultycode="+document.getElementById("facultycodes").value;
		param += "&departmentcode="+document.getElementById("departmentcodes").value;
		param += "&programmecode="+document.getElementById("programmecodes").value;
		param += "&studentlevel="+document.getElementById("studentlevels").value;
		param += "&entryyear="+document.getElementById("entryyearsA").value;
		param += "&regNumber="+document.getElementById("students").value;
	    var selectoption=document.getElementById("selectactive");
		var active=selectoption.options[selectoption.selectedIndex].text;
		param += "&active="+active;
	}
    var url = "/mobiletech/dataentrybackend.php?option=getRecordlist&table="+arg3+"&currentobject="+arg2+param;
	AjaxFunctionDataEntry(url);
}

function populateCode(code){
    curr_obj.value = code.replace(/#/g,' ');
    clearLists(readCookie("list_obj"));
	if(readCookie("list_obj")=="recordlist4") {
		$('#recordlist4border').dialog('close');
		$("#uploadresult").dialog('option','width',950);
	}
	if(curr_obj.id.substr(0,7)=="faculty") {
		createCookie("facultycookie",curr_obj.value,true);
	}
	if(curr_obj.id.substr(0,7)=="department") {
		createCookie("departmentcookie",curr_obj.value,true);
	}
	if(curr_obj.id.substr(0,7)=="programme") {
		createCookie("programmecookie",curr_obj.value,true);
	}
	if(curr_obj.id.substr(0,7)=="studentlevel") {
		createCookie("studentlevelcookie",curr_obj.value,true);
	}
	if(curr_obj.id.substr(0,7)=="sesion") {
		createCookie("sesioncookie",curr_obj.value,true);
	}
	if(curr_obj.id.substr(0,7)=="semester") {
		createCookie("semestercookie",curr_obj.value,true);
	}
	/*if(curr_obj.id=="sessions2a") {
		document.getElementById("semesters2a").value="";
		document.getElementById("levels2a").value="";
	}
	if(curr_obj.id=="semesters2a") {
		document.getElementById("sessions2a").value="";
		document.getElementById("levels2a").value="";
	}
	if(curr_obj.id=="levels2a") {
		document.getElementById("sessions2a").value="";
		document.getElementById("semesters2a").value="";
	}else{
		document.getElementById("levels2a").value="";
	}*/
	
}

function populateCodeB(codeA,codeB){
	if(curr_obj.id=="leftsigidA"){
		document.getElementById("leftsigidA").value = codeA.replace(/#/g,' ');
		document.getElementById("leftsignameA").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="midsigidA"){
		document.getElementById("midsigidA").value = codeA.replace(/#/g,' ');
		document.getElementById("midsignameA").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="rightsigidA"){
		document.getElementById("rightsigidA").value = codeA.replace(/#/g,' ');
		document.getElementById("rightsignameA").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="leftsigidB"){
		document.getElementById("leftsigidB").value = codeA.replace(/#/g,' ');
		document.getElementById("leftsignameB").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="midsigidB"){
		document.getElementById("midsigidB").value = codeA.replace(/#/g,' ');
		document.getElementById("midsignameB").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="rightsigidB"){
		document.getElementById("rightsigidB").value = codeA.replace(/#/g,' ');
		document.getElementById("rightsignameB").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="leftsigidC"){
		document.getElementById("leftsigidC").value = codeA.replace(/#/g,' ');
		document.getElementById("leftsignameC").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="midsigidC"){
		document.getElementById("midsigidC").value = codeA.replace(/#/g,' ');
		document.getElementById("midsignameC").value = codeB.replace(/#/g,' ');
	}
	if(curr_obj.id=="rightsigidC"){
		document.getElementById("rightsigidC").value = codeA.replace(/#/g,' ');
		document.getElementById("rightsignameC").value = codeB.replace(/#/g,' ');
	}
    clearLists(readCookie("list_obj"));
}

function clearLists(arg){
    if(arg==null) arg=readCookie("list_obj");
    document.getElementById(arg).innerHTML = "";
}

var xmlhttp

function AjaxFunctionDataEntry(arg){
	arg = arg.replace(/ & /g,'_amp_')

    xmlhttp=GetXmlHttpObject();
    if(xmlhttp == null){
        alert ("Your browser does not support XMLHTTP!");
        return true;
    }

    var timestamp = new Date().getTime();
    var url = window.location+"";
    var break_url = url.split("/mobiletech");
    url = break_url[0] + arg+"&timestamp="+timestamp+"&url="+break_url[0];

	xmlhttp.onreadystatechange=stateChangedAmins;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
    
}

function stateChangedAmins(){
    if (xmlhttp.readyState==4){
        var resp = xmlhttp.responseText;
        var break_resp = "";
        $('#showAlert').dialog('close');

        //if(resp.match("Whatsgwan")){
		//	alert(resp);
		//}

        if(resp.match("checkAccess")){
            if(resp.match("checkAccessSuccess")){
//alert(readCookie('access'));
				window.location="home.php?pgid=1";
            }else{
                break_resp = resp.split("checkAccessFailed");
                resp = "Access Denied!!!\n\nMenu ["+break_resp[1]+"] not accessible by "+readCookie("currentuser");
				alert(resp);
				window.location="home.php?pgid";
            }
        }

        if(resp.match("getAllRecs")){
//document.getElementById("showPrompt").innerHTML = resp;
//$('#showPrompt').dialog('open');
            break_resp = resp.split("getAllRecs");
            var allrecords = "<table border='0' style='border-color:#fff;border-style:solid;border-width:1px;height:10px; width:100%;background-color:#336699;margin-top:1px;font-size:10px;'>";
            allrecords += "<tr style='height:32px; font-weight:bold; color:white'>";
			if(resp.match("Warning")){
				resp = "<b>No Match Found!!!</b><br><br>No record(s) found that match the criteria.";
				document.getElementById("showPrompt").innerHTML = resp;
				$('#showPrompt').dialog('open');
				return true;
			}

			if((break_resp[1]==null || break_resp[1]=="") && readCookie("firstentry")=="0"){
				resp = "<b>No Match Found!!!</b><br><br>No record(s) found that match the criteria.";
				document.getElementById("showPrompt").innerHTML = resp;
				$('#showPrompt').dialog('open');
			}
			if(readCookie("firstentry")=="1"){
				createCookie("firstentry","0",false);
			}
			if(break_resp[0]=="examresultstable"){
                populateMarks(resp);
			}else if(break_resp[0]=="amendedresults"){
                populateAmendeds(resp);
			}else if(break_resp[0]=="specialfeatures"){
                populateFeatures(resp);
            }else if(break_resp[0]=="signatoriestable"){
                allrecords += "<td width='5%'>S/No</td><td width='40%'>Position</td><td width='40%'>Name</td></tr>";
            }else if(break_resp[0]=="regularstudents"){
                allrecords += "<td>Faculty:</td>";
                allrecords += "<td><input type='text' id='facultycodes' onkeyup=getRecordlist(this.id,'facultiestable','recordlist') onfocus=getRecordlist(this.id,'facultiestable','recordlist') size='50' /></td>";

				allrecords += "<td>Department:</td>";
                allrecords += "<td><input type='text' id='departmentcodes' onkeyup=getRecordlist(this.id,'departmentstable','recordlist') onfocus=getRecordlist(this.id,'departmentstable','recordlist') size='50' /></td></tr>";

                allrecords += "<tr style='height:32px; font-weight:bold; color:white'>";
                allrecords += "<td>Programme:</td>";
                allrecords += "<td><input type='text' id='programmecodes' onkeyup=getRecordlist(this.id,'programmestable','recordlist') onfocus=getRecordlist(this.id,'programmestable','recordlist') size='50' /></td>";

				allrecords += "<td>Level:</td>";
                allrecords += "<td><input type='text' id='studentlevels' onkeyup=getRecordlist(this.id,'studentslevels','recordlist') onfocus=getRecordlist(this.id,'studentslevels','recordlist') size='50' /></td></tr>";

                allrecords += "<tr style='height:32px; font-weight:bold; color:white'>";
                allrecords += "<td>Session:</td>";
                allrecords += "<td><input type='text' id='sesionsA' onkeyup=getRecordlist(this.id,'sessionstable','recordlist') onfocus=getRecordlist(this.id,'sessionstable','recordlist') size='50' /></td>";

				allrecords += "<td>Semester:</td>";
                allrecords += "<td><input style='display:inline' type='text' id='semestersA' onkeyup=getRecordlist(this.id,'sessionstable','recordlist') onfocus=getRecordlist(this.id,'sessionstable','recordlist') size='50' /></td>";
				
				//allrecords += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Group Code:&nbsp;&nbsp;<input style='display:inline' type='text' id='entryyearsA' onkeyup=getRecordlist(this.id,'sessionstable','recordlist') onfocus=getRecordlist(this.id,'sessionstable','recordlist') size='10' /></td></tr>";
				//"<input style='display:inline' type='text' id='entryyears' onkeyup=getRecordlist(this.id,'regularstudents','recordlist') onfocus=getRecordlist(this.id,'regularstudents','recordlist')  size='10' />"
                allrecords += "<tr style='height:32px; font-weight:bold; color:white'>";
				allrecords += "<td>Group Code:</td>";
                allrecords += "<td><input style='display:inline' type='text' id='entryyearsA' onkeyup=getRecordlist(this.id,'sessionstable','recordlist') onfocus=getRecordlist(this.id,'sessionstable','recordlist') size='50' /></td>";

				allrecords += "<td>Active:</td>";
                allrecords += "<td><Select style='display:inline' id='selectactive'><option></option><option>Yes</option><option>No</option><option>Yes/No</option></select></td>";

				allrecords += "<tr style='height:32px; font-weight:bold; color:white'>";
				allrecords += "<td>Names/Email/Matric No:</td>";
                allrecords += "<td><input type='text' id='students' onkeyup=getRecordlist(this.id,'regularstudents','recordlist') onfocus=getRecordlist(this.id,'regularstudents','recordlist') size='50' /></td>";

				allrecords += "<td>&nbsp;</td>";
                allrecords += "<td><input type='button' style='display:inline' id='filterbutton' onclick=getRecords(this.id) value='List Records' /></td>";

                allrecords += "</tr></table>";
                
				allrecords += "<table border='0' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;font-size:10px;'>";
                allrecords += "<tr style='font-weight:bold; color:white'>";
                allrecords += "<td width='5%'>S/No</td><td width='10%'>Matric_No</td><td width='10%'>Names</td><td width='10%'>Faculty</td>";
                allrecords += "<td width='10%'>Department</td><td width='10%'>Programme</td><td width='10%'>Current Session</td>";
				allrecords += "<td width='10%'>Current Semester</td><td width='10%'>Current Level</td><td align='center' width='10%'>Active</td><td align='center' width='10%'>Lock Result</td><td width='10%'>Select All</td></tr>";
				//<td width='10%'>Entry Year</td><td>&nbsp;</td><td>&nbsp;</td>

                allrecords += "<tr style='font-weight:bold; color:white'>";
                allrecords += "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
                allrecords += "<td>&nbsp;</td><td>&nbsp;</td>";
				allrecords += "<td><input type='text' id='sessions2a' onkeyup=getRecordlist(this.id,'sessionstable','recordlist') onfocus=getRecordlist(this.id,'sessionstable','recordlist') size='8' /></td>";
				allrecords += "<td><input type='text' id='semesters2a' onkeyup=getRecordlist(this.id,'sessionstable','recordlist') onfocus=getRecordlist(this.id,'sessionstable','recordlist') size='10' /></td>";
				allrecords += "<td><input type='text' id='levels2a' onkeyup=getRecordlist(this.id,'studentslevels','recordlist') onfocus=getRecordlist(this.id,'studentslevels','recordlist') size='8' /></td>";
				allrecords += "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";

                allrecords += "<tr style='font-weight:bold; color:white'>";
                allrecords += "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
                allrecords += "<td>&nbsp;</td><td>&nbsp;</td>";
				allrecords += "<td align='center' colspan='3'><Select id='selectalpha' onchange='updateGeneral(this.id);'><option>--------------Select Options--------------</option><option>Update Selected</option><option>Delete Selected</option></select></td>";
				allrecords += "<td><Select id='selectactivate' onchange='updateGeneral(this.id);'><option>--Select Options--</option><option>Activate Selected</option><option>Deactivate Selected</option></select></td>";
				allrecords += "<td><Select id='selectlock' onchange='updateGeneral(this.id);'><option>--Select Options--</option><option>Lock Selected</option><option>Unlock Selected</option></select></td>";
				allrecords += "<td><input type='checkbox' id='selectall' onclick='doCheckboxes();'></td></tr>";
				//<option>Update All</option><option>Delete All</option>
				//<option>Activate All</option><option>Deactivate All</option>
				//<option>Lock All</option><option>Unlock All</option>
            }else if(break_resp[0]=="regularstudentsA"){
                allrecords += "<td width='5%'>S/No</td><td>Matric_No</td><td>Names</td><td>Email</td>";
                allrecords += "<td>Phone_No</td><td>Select_All&nbsp;&nbsp;<input type='checkbox' id='selectall' onclick='doCheckboxes();'></td></tr>";
			}
            var recordlist = null;
            if(break_resp[0]=="regularstudents") document.getElementById('studentslist').innerHTML = "";
            if(break_resp[0]=="regularstudents") recordlist = document.getElementById('studentslist');
            if(break_resp[0]=="regularstudentsA") recordlist = document.getElementById('studentslist');
            if(break_resp[0]=="signatoriestable") recordlist = document.getElementById('signatorylist');

            var counter = 0;
            var rsp = "";
            var flg = 0;
            var break_row = "";
            var compare1 = "regularstudents regularstudentsA studentfees studentpays signatoriestable";
            var compare2 = "regularstudents regularstudentsA studentfees studentpays ";
            var compare3 = "regularstudents regularstudentsA studentfees studentpays ";
            var compare4 = "regularstudents studentfees ";
            var compare5 = "regularstudents studentfees ";
            var compare6 = "regularstudents ";
            var compare7 = "regularstudents ";
            var compare8 = "regularstudents ";
            var compare9 = "regularstudents ";
            var compare10 = "regularstudents ";
            var compare11 = "regularstudents ";
			myCheckboxes=0;
            for(var i=1; i < (break_resp.length-1); i++){
                break_row = break_resp[i].split("!!!");
                if (flg == 1) {
                    flg = 0;
                    rsp += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
                } else {
                    flg = 1;
					rsp += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
				}
				rsp += "<td width='5%' align='right'>" + (++counter) + ".</td>";
				rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "','" + break_row[1].replace(/ /g,'#') + "')>" + break_row[1] + "</a></td>";
				if(break_resp[0]=="regularstudents"){
					rsp += "<td>" + break_row[3]+" " + break_row[2] + "</td>";
				}else{
					rsp += "<td>" + break_row[2] + "</td>";
				}
				if(compare1.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						rsp += "<td>" + break_row[4] + "</td>";
					}else{
						rsp += "<td>" + break_row[3] + "</td>";
					}
				}
				if(compare2.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						rsp += "<td>" + break_row[5] + "</td>";
					}else{
						rsp += "<td>" + break_row[4] + "</td>";
					}
				}
				if(compare3.match(break_resp[0])){
					if(break_resp[0]=="regularstudentsA"){
						var checkboxid="box"+(i-1);
						var hiddenid="hidden"+(i-1);
						var hiddenidB="hiddenB"+(i-1);
						myCheckboxes++;
						rsp += "<td><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+break_row[1]+"'>";
						rsp += "<input type='hidden' id='"+hiddenidB+"' value='"+break_row[4]+"_"+break_row[2]+"_"+break_row[1]+"'></td>";
					}else if(break_resp[0]=="regularstudents"){
						rsp += "<td>" + break_row[6] + "</td>";
					}else{
						rsp += "<td>" + break_row[5] + "</td>";
					}
				}
				if(compare4.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						rsp += "<td>" + break_row[50] + "</td>";
					}else{
						rsp += "<td>" + break_row[6] + "</td>";
					}
				}
				if(compare5.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						//rsp += "<td>" + break_row[51] + "</td>";
					}else{
						rsp += "<td>" + break_row[7] + "</td>";
					}
				}
				if(compare6.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						rsp += "<td>" + break_row[52] + "</td>";
					}else{
						rsp += "<td>" + break_row[8] + "</td>";
					}
				}
				if(compare7.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						rsp += "<td>" + break_row[40] + "</td>";
					}else{
						rsp += "<td>" + break_row[9] + "</td>";
					}
				}
				if(compare8.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						rsp += "<td align='center'>" + break_row[17] + "</td>";
					}else{
						rsp += "<td>" + break_row[10] + "</td>";
					}
				}
				if(compare9.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						rsp += "<td align='center'>" + break_row[43] + "</td>";
					}else{
						rsp += "<td>" + break_row[11] + "</td>";
					}
				}
				if(compare10.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
//						break_row[8] = break_row[8].substr(8,2)+'/'+break_row[8].substr(5,2)+'/'+break_row[8].substr(0,4);
						//break_row[15] = "<img src='photo/"+break_row[15]+"' width='70' height='70' />";
						//rsp += "<td>" + break_row[15] + "</td>";
					}else{
						rsp += "<td>" + break_row[12] + "</td>";
					}
					//var dob = break_row[8].substr(8,2)+'/'+break_row[8].substr(5,2)+'/'+break_row[8].substr(0,4);
					//rsp += "<td>" + dob + "</td>";
				}
				if(compare11.match(break_resp[0])){
					if(break_resp[0]=="regularstudents"){
						var checkboxid="box"+(i-1);
						var hiddenid="hidden"+(i-1);
						myCheckboxes++;
						rsp += "<td><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+break_row[1]+"'></td>";
					}else{
						rsp += "<td>" + break_row[13] + "</td>";
					}
				}
				rsp += "</tr>";

					
					
					
					/*rsp += "<td width='5%' align='right'>" + (++counter) + ".</td>";
                    rsp += "<td><a href=javascript:populateRecords('" + break_row[0] + "','" + break_resp[0] + "')>" + break_row[1] + "</a></td>";
                    rsp += "<td>" + break_row[2] + "</td>";
                    if(compare1.match(break_resp[0])){
                        rsp += "<td>" + break_row[3] + "</td>";
                    }
                    if(compare2.match(break_resp[0])){
                        rsp += "<td>" + break_row[4] + "</td>";
                    }
                    if(compare3.match(break_resp[0])){
                        rsp += "<td>" + break_row[5] + "</td>";
                    }
                    if(compare4.match(break_resp[0])){
                        rsp += "<td>" + break_row[6] + "</td>";
                    }
                    if(compare5.match(break_resp[0])){
                        rsp += "<td>" + break_row[7] + "</td>";
                    }
                    if(compare6.match(break_resp[0])){
						var dob = break_row[8].substr(8,2)+'/'+break_row[8].substr(5,2)+'/'+break_row[8].substr(0,4);
                        rsp += "<td>" + dob + "</td>";
                    }
                    rsp += "</tr>";*/
            }

            recordlist.innerHTML = allrecords+rsp+"</table><div id='recordlist'></div>";

			if(break_resp[0]=="regularstudents"){
				document.getElementById("facultycodes").value=readCookie("_facultys");
				document.getElementById("departmentcodes").value=readCookie("_departments");
				document.getElementById("programmecodes").value=readCookie("_programmes");
				document.getElementById("studentlevels").value=readCookie("_levels");
				document.getElementById("sesionsA").value=readCookie("_sessions");
				document.getElementById("semestersA").value=readCookie("_semesters");
				document.getElementById("entryyearsA").value=readCookie("_entryyears");
				var selectoption=document.getElementById("selectactive");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == readCookie("_selectactive")){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
				document.getElementById("students").value=readCookie("_studentno");
			}
			if(break_resp[0]=="regularstudentsA"){
				document.getElementById("facultycode4").value=readCookie("_facultys");
				document.getElementById("departmentcode4").value=readCookie("_departments");
				document.getElementById("programmecode4").value=readCookie("_programmes");
				document.getElementById("entryyear3").value=readCookie("_entryyears");
			}
        }
        if(resp.match("getRecordlist")){
//document.getElementById("showPrompt").innerHTML = allCodes;
//$('#showPrompt').dialog('open');
            var keyword = curr_obj.value;
            var allCodes = resp.split("getRecordlist");
            var inner_codeslist = "";
            if(navigator.appName == "Microsoft Internet Explorer"){
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:40%;background-color:#336699;margin-top:5px;'>";
            }else{
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
            }
            inner_codeslist += "<tr style='font-weight:bold; color:white'>";
            inner_codeslist += "<td colspan='4' align='right'><a title='Close' style='font-weight:bold; font-size:20px; color:white;background-color:red;' href='javascript:clearLists()'>X</a></td></tr>";

			var codeslist = document.getElementById(readCookie("list_obj"));

            codeslist.style.zIndex = 100;
            codeslist.style.position = "absolute";

            codeslist.style.top = ($(curr_obj).position().top + 23) + 'px';
            codeslist.style.left = ($(curr_obj).position().left) + 'px';

            var token = "";
            var tokensent = "";
            counter = 1;
            var colorflag = 0;
            var k=0;
            if(keyword.trim().length==0){
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0){
                        token = allCodes[k].split("!!!");
                        tokensent = token[1].replace(/ /g,'#');
						if(token[1].match(inner_codeslist)) continue;
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
						if(readCookie("list_obj").match("siglist")){
	                        tokensentA = token[1].replace(/ /g,'#');
		                    tokensentB = token[2].replace(/ /g,'#');
							inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCodeB('"+tokensentA+"','"+tokensentB+"')>"+token[1]+"</a></td>";
						}else{
							inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+tokensent+"')>"+token[1]+"</a></td>";
						}
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
                        if(token[3]!=null && token[3]!="") inner_codeslist += "<td>"+token[3]+"</td>";
                        inner_codeslist += "</tr>";
                    }
                }
            } else {
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0 && (allCodes[k].toUpperCase().match(keyword.toUpperCase()))){
                        token = allCodes[k].split("!!!");
                        tokensent = token[1].replace(/ /g,'#');
						if(token[1].match(inner_codeslist)) continue;
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
						if(readCookie("list_obj").match("siglist")){
	                        tokensentA = token[1].replace(/ /g,'#');
		                    tokensentB = token[2].replace(/ /g,'#');
							inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCodeB('"+tokensentA+"','"+tokensentB+"')>"+token[1]+"</a></td>";
						}else{
							inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+tokensent+"')>"+token[1]+"</a></td>";
						}
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
                        if(token[3]!=null && token[3]!="") inner_codeslist += "<td>"+token[3]+"</td>";
                        inner_codeslist += "</tr>";
                    }
                }
            }
            inner_codeslist += "</table>";
            codeslist.style.zIndex = 100;
			if(readCookie("list_obj")=="recordlist4"){
		        codeslist.style.top = '0px';
	            codeslist.style.left = '0px';
				$("#uploadresult").dialog('option','width',750);
				$('#recordlist4border').dialog('open');
			}
            codeslist.innerHTML = "";
            codeslist.innerHTML = inner_codeslist;
		}

        if(resp.match("updateGeneral")){
			var sno=0;
			if(resp.match("periodexists")){
	            break_resp = resp.split("periodexists");
				var studentslist = "";
				for(k=1; k<break_resp.length; k++) studentslist += (++sno)+". "+break_resp[k] + "<br>";
				var str="The Session, Semester and Level have been used to update Examinations table for the following students:<br><br>"+studentslist;
				document.getElementById("showPrompt").innerHTML = "<b>Deletion Not Allowed!!!</b><br><br>"+str;
				$('#showPrompt').dialog('open');
				return true;
			}else if(resp.match("studentsupdated")){
	            break_resp = resp.split("studentsupdated");
				var studentslist = "";
				for(k=1; k<break_resp.length; k++) studentslist += (++sno)+". "+break_resp[k] + "<br>";
				var str="The Session, Semester and Level have been updated for the following students:<br><br>"+studentslist;
				document.getElementById("showPrompt").innerHTML = "<b>Session, Semester and Level Updated!!!</b><br><br>"+str;
				$('#showPrompt').dialog('open');
			}else if(resp.match("studentsdeleted")){
	            break_resp = resp.split("studentsdeleted");
				var studentslist = "";
				for(k=1; k<break_resp.length; k++) studentslist += (++sno)+". "+break_resp[k] + "<br>";
				var str="The Session, Semester and Level have been deleted for the following students:<br><br>"+studentslist;
				document.getElementById("showPrompt").innerHTML = "<b>Session, Semester and Level Deleted!!!</b><br><br>"+str;
				$('#showPrompt').dialog('open');
			}else if(resp.match("studentsactivated")){
	            break_resp = resp.split("studentsactivated");
				var studentslist = "";
				for(k=1; k<break_resp.length; k++) studentslist += (++sno)+". "+break_resp[k] + "<br>";
				var str="The following students have been activated:<br><br>"+studentslist;
				document.getElementById("showPrompt").innerHTML = "<b>Students Activated!!!</b><br><br>"+str;
				$('#showPrompt').dialog('open');
			}else if(resp.match("studentsdeactivated")){
	            break_resp = resp.split("studentsdeactivated");
				var studentslist = "";
				for(k=1; k<break_resp.length; k++) studentslist += (++sno)+". "+break_resp[k] + "<br>";
				var str="The following students have been deactivated:<br><br>"+studentslist;
				document.getElementById("showPrompt").innerHTML = "<b>Students Deactivated!!!</b><br><br>"+str;
				$('#showPrompt').dialog('open');
			}else if(resp.match("studentslocked")){
	            break_resp = resp.split("studentslocked");
				var studentslist = "";
				for(k=1; k<break_resp.length; k++) studentslist += (++sno)+". "+break_resp[k] + "<br>";
				var str="The following students have been locked:<br><br>"+studentslist;
				document.getElementById("showPrompt").innerHTML = "<b>Students Locked!!!</b><br><br>"+str;
				$('#showPrompt').dialog('open');
			}else if(resp.match("studentsunlocked")){
	            break_resp = resp.split("studentsunlocked");
				var studentslist = "";
				for(k=1; k<break_resp.length; k++) studentslist += (++sno)+". "+break_resp[k] + "<br>";
				var str="The following students have been unlocked:<br><br>"+studentslist;
				document.getElementById("showPrompt").innerHTML = "<b>Students Unlocked!!!</b><br><br>"+str;
				$('#showPrompt').dialog('open');
			}else{
			}
			getRecords("filterbutton",1);
			return true;
		}

        if(resp.match("getARecord")){
            break_resp = resp.split("getARecord");
            createCookie("serialno",break_resp[1],false)
            var selectoption = null;
            if(break_resp[0]=="regularstudents"){
                document.getElementById("regNumber").value = break_resp[2];
                document.getElementById("firstName").value = break_resp[3];
                document.getElementById("lastName").value = break_resp[4];
                document.getElementById("facultycode").value = break_resp[5];
                document.getElementById("departmentcode").value = break_resp[6];
                document.getElementById("programmecode").value = break_resp[7];
                selectoption = document.getElementById("gender");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[8]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("dateOfBirth").value = break_resp[9].substr(8,2)+"/"+break_resp[9].substr(5,2)+"/"+break_resp[9].substr(0,4);
                //document.getElementById("userName").value = break_resp[10];
                //document.getElementById("userPassword").value = break_resp[11];
                document.getElementById("middleName").value = break_resp[12];
                document.getElementById("userEmail").value = break_resp[13];
                document.getElementById("userAddress").value = break_resp[14];
                //document.getElementById("postCode").value = break_resp[15];
                //document.getElementById("userPicture").value = break_resp[16];
                createCookie("theImage",break_resp[16],false);
                loadImage(break_resp[16]);
                //document.getElementById("userType").value = break_resp[17];
                selectoption = document.getElementById("active");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[18]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                //document.getElementById("validate").value = break_resp[19];
                //document.getElementById("receiptNo").value = break_resp[20];
                //document.getElementById("pinNo").value = break_resp[21];
                //document.getElementById("confirmNo").value = break_resp[22];
                //document.getElementById("payApproved").value = break_resp[23];
                document.getElementById("maidenName").value = break_resp[24];
                document.getElementById("contactAddress").value = break_resp[25];
                document.getElementById("nationality").value = break_resp[26];
                document.getElementById("originState").value = break_resp[27];
                document.getElementById("lga").value = break_resp[28];
                document.getElementById("birthPlace").value = break_resp[29];
                selectoption = document.getElementById("maritalStatus");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[30]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("religion").value = break_resp[31];
                document.getElementById("spouseName").value = break_resp[32];
                selectoption = document.getElementById("title");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[33]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("guardianName").value = break_resp[34];
                document.getElementById("guardianAddress").value = break_resp[35];
                selectoption = document.getElementById("guardianRelationship");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[36]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("disability").value = break_resp[37];
                //document.getElementById("wascresults").value = break_resp[38];
                populateOLevel(break_resp[38]);
                //document.getElementById("cgpacode").value = break_resp[39];
                //document.getElementById("supportindocuments").value = break_resp[40];
                populateDoc(break_resp[40]);
                document.getElementById("studentlevel").value = break_resp[41];
                document.getElementById("guardianEmail").value = break_resp[42];
                selectoption = document.getElementById("ignorepay");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[43]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                selectoption = document.getElementById("lockrec");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[44]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                document.getElementById("qualification").value = break_resp[45];
                document.getElementById("minimumunit").value = break_resp[46];
                document.getElementById("tcp").value = break_resp[47];
                document.getElementById("tnu").value = break_resp[48];
                document.getElementById("gpa").value = break_resp[49];
                document.getElementById("tnup").value = break_resp[50];
                document.getElementById("entryyear").value = break_resp[51];
                document.getElementById("phoneno").value = break_resp[52];
                document.getElementById("guardianphoneno").value = break_resp[53];
                document.getElementById("admissiontype").value = break_resp[54];
                if(break_resp[51]!=null) document.getElementById("sessionss").value = break_resp[55];
                if(break_resp[52]!=null) document.getElementById("semesterss").value = break_resp[56];
				break_reg = break_resp[57].split("!!!");
				//var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
				var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
				str += "<tr style='font-weight:bold; color:white'><td colspan='4' align='center'>REGISTERED SESSIONS/SEMESTERS</td></tr>";
				str += "<tr style='font-weight:bold; color:white'>";
				str += "<td width='10%'>S/No</td><td width='30%'>LEVEL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td width='15%'>SESSION</td><td width='15%'>SEMESTER</td></tr>";
				flag=0;count=0;
				for(var k=0; k<(break_reg.length-1); k++){
					break_col = break_reg[k].split("~_~");
					if(flag==0){
						str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
						flag=1;
					}else{
						str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
						flag=0;
					}
					str += "<td align='right'>"+(++count)+".</td>"+"<td>"+break_col[0]+"</td>"+"<td>"+break_col[1]+"</td>"+"<td>"+break_col[2]+"</td></tr>";
				}
				str += "</table>";
                document.getElementById("registrationlist").innerHTML= str;

                $('#studentsupdate').dialog('close');
                $('#regularstudents').dialog('open');
            }
            if(break_resp[0]=="signatoriestable"){
                document.getElementById("signatoryposition").value= break_resp[2];
                document.getElementById("signatoryname").value = break_resp[3];
            }
            if(break_resp[0]=="studentfees"){
                document.getElementById("sessiondescription").value= break_resp[2];
                document.getElementById("facultycode2").value = break_resp[3];
                document.getElementById("departmentcode2").value = break_resp[4];
                document.getElementById("programmecode2").value = break_resp[5];
                document.getElementById("studentlevel2").value= break_resp[6];
                document.getElementById("amountdue").value= numberFormat(break_resp[7]);
                document.getElementById("minimumpayment").value= numberFormat(break_resp[8]);
            }
            if(break_resp[0]=="studentpays"){
                if(break_resp[6]=="DR"){
                    resetForm();
                    document.getElementById("showPrompt").innerHTML = "<b>Record Not Editable!!!</b><br><br>Your You can not edit this system generated record.";
                    $('#showPrompt').dialog('open');
                }else{
                    document.getElementById("sessiondescription2").value= break_resp[2];
                    document.getElementById("matricno").value = break_resp[3];
                    document.getElementById("amountpaid").value = numberFormat(break_resp[4]);
                }
            }
            if(break_resp[0]=="amendedreasons"){
                document.getElementById("amendreason").value= break_resp[1];
            }
        }

        /*if(resp.match("checkCode")){
            if(resp.match("codenotfound")){
                break_resp = resp.split("codenotfound");
				if(trim(document.getElementById(break_resp[1]).value)==trim(break_resp[2])){
					document.getElementById(break_resp[1]).value="";
					resp = "<b>Code Not Found!!!</b><br><br>The code you typed does not exist <br>Please select a valid code.";
					document.getElementById("showPrompt").innerHTML = resp;
					$('#showPrompt').dialog('open');
				}
			}
			return true;
		}

        if(resp.match("checkAccess")){
            if(resp.match("checkAccessSuccess")){
                break_resp = resp.split("checkAccessSuccess");
                if(break_resp[2]!=null && break_resp[2]!=""){
                    var prg = break_resp[1]+"('"+break_resp[2]+"','1')";
                    eval(prg);
                }
                if(break_resp[2]==null || break_resp[2]==""){
                    var prg = break_resp[1]+"()";
                    eval(prg);
                }
                //if(break_resp[1].match(".jsp?")){
                //    window.location=break_resp[1];
                //}
            }else{
                break_resp = resp.split("checkAccessFailed");
                resp = "<b>Access Denied!!!</b><br><br>Menu ["+break_resp[1]+"] not accessible by "+readCookie("currentuser");
                document.getElementById("showPrompt").innerHTML = resp;
                $('#showPrompt').dialog('open');
            }
        }*/


        if(resp.match("approve")){
            break_resp = resp.split("approve");
            var str = "";
            for(k=0; k<break_resp.length; k++){
                str += break_resp[k]+"<br><br>";
            }
            document.getElementById("showPrompt").innerHTML = "<b>Approval attempted on the following!!!</b><br><br>"+str;
            $('#showPrompt').dialog('open');
        }

        if(resp.match("reverse")){
            break_resp = resp.split("reverse");
            str = "";
            for(k=0; k<break_resp.length; k++){
                str += break_resp[k]+"<br><br>";
            }
            document.getElementById("showPrompt").innerHTML = "<b>Reversal attempted on the following!!!</b><br><br>"+str;
            $('#showPrompt').dialog('open');
        }

        if(resp.match("reversal")){
            break_resp = resp.split("reversal");
            str = "";
            for(k=0; k<break_resp.length; k++){
                str += break_resp[k]+"<br><br>";
            }
            document.getElementById("showPrompt").innerHTML = "<b>NO RECORD EXISTS!!!</b><br><br>"+str;
            $('#showPrompt').dialog('open');
        }

        if(resp.match("transcriptsent")){
			document.getElementById('f1_upload_process').style.visibility = 'hidden';
			break_resp = resp.split("transcriptsent");
            $('#showAlert').dialog('close');
            document.getElementById("showPrompt").innerHTML = "<h3>Transcript Email Response!</h3><br><br><b>Your attempt to send transcripts by email to your students produced the following response:</b><br><br><br>"+break_resp[1];
            $('#showPrompt').dialog('open');
            return true;
        }

        if(resp.match("inserted")){
            document.getElementById("showPrompt").innerHTML = "<b>Record Added!!!</b><br><br>Your record was successfully added.";
            break_resp = resp.split("inserted");

            if(break_resp[0]=='examresultstable' || break_resp[0]=='amendedresults' || break_resp[0]=='retakecourses' || break_resp[0]=='specialfeatures') {
                //populateMark(readCookie("sortby"));
            }else if(break_resp[0]=='signatoriestable'){
				resetForm();
				getRecords(break_resp[0],"1");
            }else{
				$('#showPrompt').dialog('open');
			}
        }

        if(resp.match("updated")){
            document.getElementById("showPrompt").innerHTML = "<b>Record Updated!!!</b><br><br>Your record was successfully updated.";
            break_resp = resp.split("updated");

            if(break_resp[0]=='examresultstable' || break_resp[0]=='amendedresults' || break_resp[0]=='retakecourses' || break_resp[0]=='specialfeatures') {
                //populateMark(readCookie("sortby"));
            }else if(break_resp[0]=='signatoriestable'){
				resetForm();
				getRecords(break_resp[0],"1");
            }else{
				$('#showPrompt').dialog('open');
			}
        }

        if(resp.match("deleted")){
            document.getElementById("showPrompt").innerHTML = "<b>Record Deleted!!!</b><br><br>Your record was successfully deleted.";
            break_resp = resp.split("deleted");
            if(break_resp[0]=='examresultstable' || break_resp[0]=='retakecourses' || break_resp[0]=='specialfeatures') {
                //populateMark(readCookie("sortby"));
            }else if(break_resp[0]=='signatoriestable'){
				resetForm();
				getRecords(break_resp[0],"1");
            }else{
				$('#showPrompt').dialog('open');
			}
        }

        if(resp.match("sendsmssuccessful")){
			document.getElementById('f1_upload_process').style.visibility = 'hidden';
			break_resp = resp.split("sendsmssuccessful");
            resp = "<br><b>SMS Status!!!</b><br><br>Your message(s) were successfully sent to the following Recipient(s):<br><br>";
			for(k=0; k<(break_resp.length); k++){
				resp += break_resp[k]+"<br>";
			}
            resp += "<br><br>Thank you.";
            document.getElementById("showPrompt").innerHTML = resp;
            $('#showPrompt').dialog('open');
		}
        if(resp.match("sendsmsfailed")){
			document.getElementById('f1_upload_process').style.visibility = 'hidden';
			break_resp = resp.split("sendsmsfailed");
            resp = "<br><b>SMS Status!!!</b><br><br>Your message(s) were not sent to the following Recipient(s):<br><br>";
			for(k=0; k<(break_resp.length); k++){
				resp += break_resp[k]+"<br>";
			}
            resp += "<br><br>Thank you.";
            document.getElementById("showPrompt").innerHTML = resp;
            $('#showPrompt').dialog('open');
		}
        if(resp.match("sendsmsinvalid")){
			document.getElementById('f1_upload_process').style.visibility = 'hidden';
			break_resp = resp.split("sendsmsinvalid");
            resp = "<br><b>"+break_resp[1]+"<br><br>";
            document.getElementById("showPrompt").innerHTML = resp;
            $('#showPrompt').dialog('open');
		}
        if(resp.match("sendsmsscheduled")){
			document.getElementById('f1_upload_process').style.visibility = 'hidden';
            document.getElementById("showPrompt").innerHTML = "<h4>SMS has been scheduled as requested</h4>";
            $('#showPrompt').dialog('open');
		}
        if(resp.match("sendsmsremoved")){
			document.getElementById('f1_upload_process').style.visibility = 'hidden';
            document.getElementById("showPrompt").innerHTML = "<h4>SMS has been deleted as requested</h4>";
            $('#showPrompt').dialog('open');
		}
        if(resp.match("insufficientcredit")){
			break_resp = resp.split("insufficientcredit");
            resp = "<br><b>Insufficient Credit!!!</b><br><br>sorry, you do not have sufficient funds to send your message(s)";
            resp += "<br><br>Your available balance is =N="+numberFormat(break_resp[2])+"k but you need =N="+numberFormat(break_resp[1])+"k to send the mesaage(s).";
            resp += "<br><br><br><br>Thank you.";
            document.getElementById("showPrompt").innerHTML = resp;
            $('#showPrompt').dialog('open');
		}
        if(resp.match("nofixedrate")){
            resp = "<br><b>No Fixed Rate!!!</b><br><br>sorry, no rate has been fixed for you, please contact the administrator about this.";
            resp += "<br><br><br><br>Thank you.";
            document.getElementById("showPrompt").innerHTML = resp;
            $('#showPrompt').dialog('open');
		}
        if(resp.match("coursenotsetup")){
            resp = resp.replace(/_/g, ' ');
            break_resp = resp.split("coursenotsetup");
            document.getElementById("showError").innerHTML = "<b>Course Code Not Setup!!!</b><br><br> "+break_resp[1]+" not setup for: <br><b>Faculty - </b>"+break_resp[2]+"<br><b>Department - </b>"+break_resp[3]+"<br><b>Programme - </b>"+break_resp[4]+"<br><b>Level - </b>"+break_resp[5]+"<br><b>Session - </b>"+break_resp[6]+"<br><b>Semester - </b>"+break_resp[7]+"<br><b>Group Code - </b>"+break_resp[8];
			$('#showError').dialog('open');
        }

        if(resp.match("studentnotsetup")){
            resp = resp.replace(/_/g, ' ');
            break_resp = resp.split("studentnotsetup");
            document.getElementById("showError").innerHTML = "<b>No Student Registered!!!</b><br><br> No Student was registered for: <br><b>Faculty - </b>"+break_resp[1]+"<br><b>Department - </b>"+break_resp[2]+"<br><b>Programme - </b>"+break_resp[3]+"<br><b>Level - </b>"+break_resp[4]+"<br><b>Session - </b>"+break_resp[5]+"<br><b>Semester - </b>"+break_resp[6]+"<br><b>Group Code - </b>"+break_resp[7];
			$('#showError').dialog('open');
        }

        if(resp.match("notinsetup")){
            resp = resp.replace(/_/g, ' ');
            break_resp = resp.split("notinsetup");
            document.getElementById("showError").innerHTML = "<b>Code Not Exist In "+break_resp[2]+" Setup!!!</b><br><br> "+break_resp[1]+" does not exist in "+break_resp[2]+" setup.";
			$('#showError').dialog('open');
        }

        if(resp.match("Invalid_Matric")){
            resp = resp.replace(/_/g, ' ');
            document.getElementById("showError").innerHTML = "<b>Invalid Matric No!!!</b><br><br> "+resp;
			$('#showError').dialog('open');
        }

        if(resp.match("notinregister")){
            resp = resp.replace(/_/g, ' ');
            break_resp = resp.split("notinregister");
            document.getElementById("showError").innerHTML = "<b>Student Not Exist In "+break_resp[4]+" Table!!!</b><br><br> "+break_resp[3]+" is not registered for "+break_resp[1]+" Session "+break_resp[2]+" Semester.";
			$('#showError').dialog('open');
        }

        if(resp.match("exists_in")){
            resp = resp.replace(/_/g, ' ');
            document.getElementById("showError").innerHTML = "<b>Record Exists!!!</b><br><br>The "+resp+".";
            $('#showError').dialog('open');
        }

        if(resp.match("recordused")){
            document.getElementById("showError").innerHTML = "<b>Record Used!!!</b><br><br>The record has been used in another table.";
            $('#showError').dialog('open');
        }

        if(resp.match("recordexists")){
            document.getElementById("showError").innerHTML = "<b>Record Exists!!!</b><br><br>The record already exists.";
            $('#showError').dialog('open');
        }

        if(resp.match("recordnotexist")){
            document.getElementById("showError").innerHTML = "<b>Record Not Existing!!!</b><br><br>The record does not exist.";
            $('#showError').dialog('open');
        }
        
        if(resp.match("errorcode")){
            break_resp = resp.split("errorcode");
            document.getElementById("showPrompt").innerHTML = "<b>Error Code!!!</b><br><br>Your upload generated the following error.<br><br>"+break_resp[1];
            $('#showPrompt').dialog('open');
        }

        if(resp.match("uploadsuccessful")){
            break_resp = resp.split("uploadsuccessful");
            document.getElementById("showPrompt").innerHTML = "<b>Upload Successful!!!</b><br><br><br>"+break_resp[1];
            $('#showPrompt').dialog('open');
        }

        if(resp.match("uploadtoolarge")){
            break_resp = resp.split("uploadtoolarge");
            document.getElementById("showPrompt").innerHTML = "<b>Upload Too Large!!!</b><br><br>Your upload is too large.<br><br>File size: "+break_resp[1];
            $('#showPrompt').dialog('open');
        }

        if(resp.match("uploadexists")){
            break_resp = resp.split("uploadexists");
            document.getElementById("showPrompt").innerHTML = "<b>Upload Exists!!!</b><br><br>Your upload file: "+break_resp[1]+" already exists.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("regupdated")){
			var oldregnumber=document.getElementById("oldregNumber").value;
			var newregnumber=document.getElementById("newregNumber").value;
			document.getElementById("regNumber").value=newregnumber;
            document.getElementById("showPrompt").innerHTML = "<b>Matric No Updated!!!</b><br><br>All "+oldregnumber+" have been successfully replaced with "+newregnumber+" in the entire database.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("regexists")){
			var newregnumber=document.getElementById("newregNumber").value;
            document.getElementById("showPrompt").innerHTML = "<b>Matric No Exists!!!</b><br><br>The new Matric No "+newregnumber+" already exists for a student in the database.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("regblank")){
			var newregnumber=document.getElementById("newregNumber").value;
            document.getElementById("showPrompt").innerHTML = "<b>Blank Matric No!!!</b><br><br>The new Matric No "+newregnumber+" is blank and can not be updated in the database.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("onlineuploadsuccess")){
            document.getElementById("showPrompt").innerHTML = "<b>Online Upload Successful!!!</b><br><br>Results online upload is successful.";
            $('#showPrompt').dialog('open');
        }

		if(resp.match("Invalidfile")){
            break_resp = resp.split("Invalidfile");
            document.getElementById("showPrompt").innerHTML = "<b>Invalid file!!!</b><br><br>The following file type is not allowed for upload: "+break_resp[1]+".<br><br> Try the following types: <br>gif <br>jpeg <br>pjpeg <br>bmp";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("checkPin")){
            $('#showAlert').dialog('close');
            break_resp = resp.split("checkPin");
            var pinno = document.getElementById("pinno").value;
            if(break_resp[1]==pinno && pinno.length>0){
                var pin = document.getElementById("pinno").value;
                createCookie("pinNo",pin,false);
                $('#pinEntry').dialog('close');
                $('#postUMEReg').dialog('open');
                getUser(readCookie("currentuser"));
            }else{
                document.getElementById("showError").innerHTML = "<b>Invalid Pin No!!!</b><br><br>Please enter another Pin No and try again.";
                $('#showError').dialog('open');
            }
        }

        if(resp.match("checkReceipt")){
            $('#showAlert').dialog('close');
            break_resp = resp.split("checkReceipt");
            var receiptno = document.getElementById("receiptno").value;
            var confirmno = document.getElementById("confirmno").value;
            if(break_resp[1]==receiptno+confirmno && receiptno.length>0){
                var receipt = document.getElementById("receiptno").value;
                var confirm = document.getElementById("confirmno").value;
                createCookie("receiptNo",receipt,false);
                createCookie("confirmNo",confirm,false);
                $('#pinEntry').dialog('close');
                $('#postUMEReg').dialog('open');
                getUser(readCookie("currentuser"));
            }else{
                document.getElementById("showError").innerHTML = "<b>Invalid Receipt/Confirm No!!!</b><br><br>Please enter another Receipt/Confirm No and try again.";
                $('#showError').dialog('open');
            }
        }

        if(resp.match("getUser")){
            break_resp = resp.split("getUser");
            document.getElementById("firstname").value = break_resp[1];
            document.getElementById("lastname").value = break_resp[2];
            document.getElementById("email").value = break_resp[3];
            $('#showAlert').dialog('close');
        }

        if(resp.match("invalidpin")){
            $('#showAlert').dialog('close');
            document.getElementById("showError").innerHTML = "<b>Invalid Pin No!!!</b><br><br>Please enter another Pin No and try again.";
            $('#showError').dialog('open');
        }

        if(resp.match("invalidreceipt")){
            $('#showAlert').dialog('close');
            document.getElementById("showError").innerHTML = "<b>Invalid Receipt/Confirm No!!!</b><br><br>Please enter another Receipt/Confirm No and try again.";
            $('#showError').dialog('open');
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
