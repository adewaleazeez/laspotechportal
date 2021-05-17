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
    var url = "/laspotechportal/setupbackend.php?option=checkAccess"+arg;
	AjaxFunctionSetup(url);
}*/

function logoutUser(){
    var url = "/laspotechportal/userbackend.php?option=logoutUser";
	AjaxFunctionSetup(url);
}

function checkAccess(access, menuoption){
	createCookie("access",access,false);
    var arg = "&currentuser="+readCookie("currentuser")+"&menuoption="+menuoption;
    var url = "/laspotechportal/setupbackend.php?option=checkAccess"+arg;
    AjaxFunctionSetup(url);
}

function updateSchoolInfo(option, table){
    var schoolname = document.getElementById("schoolname").value;
    var addressline1 = document.getElementById("addressline1").value;
    var addressline2 = document.getElementById("addressline2").value;
    var addressline3 = document.getElementById("addressline3").value;
    var addressline4 = document.getElementById("addressline4").value;
    var telephonenumber = document.getElementById("telephonenumber").value;
    var faxnumber = document.getElementById("faxnumber").value;
    var emailaddress = document.getElementById("emailaddress").value;

    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    var error = "";
    if (schoolname=="") error += "School name must not be blank.<br><br>";
    if (addressline1=="") error += "School address line1 must not be blank.<br><br>";
    if (addressline2=="") error += "School address line2 must not be blank.<br><br>";
    if (emailaddress > "") {
        if (emailaddress.match(illegalChars)) {
            error += "The email address contains illegal characters.<br><br>";
        } else if (!emailFilter.test(emailaddress)) {              //test email for illegal characters
            error += "Enter a valid email address or select username option.<br><br>";
        }
    }
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
    var param = "&param="+serialno+"]["+schoolname+"]["+addressline1+"]["+addressline2;
    param += "]["+addressline3+"]["+addressline4+"]["+telephonenumber+"]["+faxnumber+"]["+emailaddress;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function updateFaculty(option, table){
    var facultydescription = document.getElementById("facultydescription").value;
    var dof = document.getElementById("dof").value;
    var error = "";
    if (facultydescription==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "School must not be blank.<br><br>";
        }
    }
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
    var param = "&param="+serialno+"]["+facultydescription+"]["+dof;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function updateDepartment(option, table){
    var facultycode = document.getElementById("facultycode").value;
    var departmentdescription = document.getElementById("departmentdescription").value;
    var hod = document.getElementById("hod").value;
    var error = "";
    if (facultycode==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "School must not be blank.<br><br>";
        }
    }
    if (departmentdescription=="") error += "Department must not be blank.<br><br>";
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
    var param = "&param="+serialno+"]["+departmentdescription+"]["+facultycode+"]["+hod;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function updateProgramme(option, table){
    var departmentcode = document.getElementById("departmentcode").value;
    var programmedescription = document.getElementById("programmedescription").value;
    var courseadvisor = document.getElementById("courseadvisor").value;
    var error = "";
    if (departmentcode==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Department must not be blank.<br><br>";
        }
    }
    if (programmedescription=="") error += "Programme must not be blank.<br><br>";
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
    var param = "&param="+serialno+"]["+programmedescription+"]["+departmentcode+"]["+courseadvisor;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function doMaxUnit(arg){
	var faculty = document.getElementById("facultycode2").value;
    var department = document.getElementById("departmentcode2").value;
    var programme = document.getElementById("programmecode2").value;
    var level = document.getElementById("studentlevel2").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var maximumunit = document.getElementById("maximumunit").value;

    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    //if (maximumunit=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        //error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        //document.getElementById("showError").innerHTML = error;
        //$('#showError').dialog('open');
        return true;
    }
	createCookie("_faculty_",faculty,365);
	createCookie("_department_",department,365);
	createCookie("_programme_",programme,365);
	createCookie("_level_",level,365);
	createCookie("_session_",sesions,365);
	createCookie("_semester_",semester,365);
    var param = "&table=unitstable&facultycode="+faculty+"&departmentcode="+department+"&programmecode="+programme+"&studentlevel="+level;
	param += "&sesions="+sesions+"&semester="+semester+"&maximumunit="+maximumunit+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=doMaxUnit"+param;
	AjaxFunctionSetup(url);
}

function showCourses(){
	$('#coursetable').dialog('open');
}

function populateCourse(arg){
	createCookie("sortby",arg,false);
    var faculty = document.getElementById("facultycode2").value;
    var department = document.getElementById("departmentcode2").value;
    var programme = document.getElementById("programmecode2").value;
    var level = document.getElementById("studentlevel2").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    //var entryyear = document.getElementById("entryyear").value;
	var entryyear = "";
    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    //if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_faculty_",faculty,365);
	createCookie("_department_",department,365);
	createCookie("_programme_",programme,365);
	createCookie("_level_",level,365);
	createCookie("_session_",sesions,365);
	createCookie("_semester_",semester,365);
    var param = "&table=coursestable&facultycode="+faculty+"&departmentcode="+department+"&programmecode="+programme+"&studentlevel="+level;
	param += "&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
    AjaxFunctionSetup(url);
}

var currentCodeid='';
var currentCountid='';
function checkCourseLock(k){
	currentCodeid='codeid'+k;
	currentCountid=k;
	var currentcoursecode=document.getElementById(currentCodeid).value;
	var faculty = document.getElementById("facultycode2").value;
    var department = document.getElementById("departmentcode2").value;
    var programme = document.getElementById("programmecode2").value;
    var level = document.getElementById("studentlevel2").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_faculty_",faculty,365);
	createCookie("_department_",department,365);
	createCookie("_programme_",programme,365);
	createCookie("_level_",level,365);
	createCookie("_session_",sesions,365);
	createCookie("_semester_",semester,365);

	var param='&param='+currentcoursecode+']['+faculty+']['+department+']['+programme+']['+level+']['+sesions+']['+semester;
    var url = "/laspotechportal/setupbackend.php?option=checkCourseLock"+param;
    AjaxFunctionSetup(url);
}

function editCourseCode(){
	checkAccess('divcodechangeid'+currentCountid, 'Edit Course Code');
}

function updateCodeChange(newid){
	var currentcoursecode=document.getElementById(currentCodeid).value;
	var newcoursecode = document.getElementById(newid).value.trim();
	newcoursecode=capitalize(newcoursecode);
	//insert a space in course code
	var token = "";
	var str = "";
	for(var k=0; k<newcoursecode.length; k++){
		token = newcoursecode.substring(k,k+1);
		if(token == " "){
			break;
		}
		if(isNaN(token)){
			str += token;
		}else{
			newcoursecode = str + " " + newcoursecode.substring(k);
			break;
		}
	}

	var faculty = document.getElementById("facultycode2").value;
    var department = document.getElementById("departmentcode2").value;
    var programme = document.getElementById("programmecode2").value;
    var level = document.getElementById("studentlevel2").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if (newcoursecode=="") error += "New Course Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_faculty_",faculty,365);
	createCookie("_department_",department,365);
	createCookie("_programme_",programme,365);
	createCookie("_level_",level,365);
	createCookie("_session_",sesions,365);
	createCookie("_semester_",semester,365);

	var param='&param='+newcoursecode+']['+currentcoursecode+']['+faculty+']['+department+']['+programme+']['+level+']['+sesions+']['+semester;
    var url = "/laspotechportal/setupbackend.php?option=updateCodeChange"+param;
    AjaxFunctionSetup(url);
}

function populateCourses(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a href=javascript:populateCourse('coursecode') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Course_Code',event) onmouseout=toolTip('msgdiv','',event)>Course_Code</a></td>";
	str += "<td>Course_Description</td><td>Course_unit</td>";
	str += "<td><a href=javascript:populateCourse('coursetype') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Course_Type',event) onmouseout=toolTip('msgdiv','',event)>Course_Type</a></td>";
	str += "<td>&nbsp;</td><td>Minimum_Score</td><td>&nbsp;</td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var codeid="";
    var codevalue="";
    var descid="";
    var descvalue="";
    var unitid="";
    var unitvalue="";
    var typeid="";
    var typevalue="";
    var coursetypegroupid="";
    var coursetypegroupvalue="";
    var scoreid="";
    var scorevalue="";
    var col_split = "";
    var count=0;
	var mycoursetypegroupid="";
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		codeid="codeid"+k;
		codevalue=col_split[1];
		descid="descid"+k;
		descvalue=col_split[2];
		unitid="unitid"+k;
		unitvalue=col_split[3];
		typeid="typeid"+k;
		typevalue=col_split[4];
		scoreid="scoreid"+k;
		scorevalue=col_split[5];
		coursetypegroupid="coursetypegroupid"+k;
		coursetypegroupvalue=col_split[15];
		mycoursetypegroupid="mycoursetypegroupid"+k;
		divcodechangeid="divcodechangeid"+k;
		codechangeid="codechangeid"+k;
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input  style='display:inline' type='text' readonly disabled='true' value='"+codevalue+"' id='"+codeid+"' onblur='this.value=capitalize(this.value)' size='10' />";
		str += "&nbsp;<div style='display:inline' id='"+divcodechangeid+"'><input type='button' id='"+codechangeid+"' value='...' style='display:inline' onclick=checkCourseLock('"+k+"') /></div></td>";
        str += "<td><input type='text' value='"+descvalue+"' id='"+descid+"' onblur='this.value=capitalize(this.value)' size='40' /></td>";
        str += "<td><input type='text' value='"+unitvalue+"' id='"+unitid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
		if(col_split[4]==null || col_split[4]==""){
			str += "<td><select id='"+typeid+"' onchange=checkGroup('"+coursetypegroupid+"','"+typeid+"','"+mycoursetypegroupid+"')><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
			str += "<td><div id='"+mycoursetypegroupid+"'></div></td>";
		}else if(col_split[4]=="Compulsory"){
			str += "<td><select id='"+typeid+"' onchange=checkGroup('"+coursetypegroupid+"','"+typeid+"','"+mycoursetypegroupid+"')><option></option><option selected>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
			str += "<td><div id='"+mycoursetypegroupid+"'></div></td>";
		}else if(col_split[4]=="Required"){
			str += "<td><select id='"+typeid+"' onchange=checkGroup('"+coursetypegroupid+"','"+typeid+"','"+mycoursetypegroupid+"')><option></option><option>Compulsory</option><option selected>Required</option><option>Elective</option></select></td>";
			str += "<td><div id='"+mycoursetypegroupid+"'></div></td>";
		}else if(col_split[4]=="Elective"){
			str += "<td><select id='"+typeid+"' onchange=checkGroup('"+coursetypegroupid+"','"+typeid+"','"+mycoursetypegroupid+"')><option></option><option>Compulsory</option><option>Required</option><option selected>Elective</option></select></td>";
			str += "<td><div id='"+mycoursetypegroupid+"'>";
			if(coursetypegroupvalue==""){
				str += "<select id='"+coursetypegroupid+"'><option selected></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 1"){
				str += "<select id='"+coursetypegroupid+"'><option></option><option selected>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 2"){
				str += "<select id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option selected>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 3"){
				str += "<select id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option selected>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 4"){
				str += "<select id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option selected>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 5"){
				str += "<select id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option selected>Group 5</option></select>";
			}
			str += "</div></td>";
		}
		/*if(col_split[4]==null || col_split[4]==""){
			str += "<td><select id='"+typeid+"'><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Compulsory"){
			str += "<td><select id='"+typeid+"'><option></option><option selected>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Required"){
			str += "<td><select id='"+typeid+"'><option></option><option>Compulsory</option><option selected>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Elective"){
			str += "<td><select id='"+typeid+"'><option></option><option>Compulsory</option><option>Required</option><option selected>Elective</option></select></td>";
		}*/
        str += "<td><input type='text' value='"+scorevalue+"' id='"+scoreid+"' size='10' /></td>";
        //str += "<td><a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','deleteRecord')>Delete</a></td></tr>";
        str += "<td><a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','"+coursetypegroupid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','"+coursetypegroupid+"','deleteRecord')>Delete</a></td></tr>";
		//onblur=updateMark('"+serialnovalue+"','"+matnovalue+"','"+markid+"','addRecord','"+statusid+"')
		//onchange=updateCourseStatus('"+statusid+"','"+col_split[10]+"','"+markid+"')
    }
	if(flag==0){
		str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
		flag=1;
	}else{
		str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
		flag=0;
	}
	serialnoid="serialnoid"+k;
	serialnovalue="";
	codeid="codeid"+k;
	codevalue="";
	descid="descid"+k;
	descvalue="";
	unitid="unitid"+k;
	unitvalue="";
	typeid="typeid"+k;
	typevalue="";
	coursetypegroupid="coursetypegroupid"+k;
	coursetypegroupvalue="";
	scoreid="scoreid"+k;
	scorevalue="";
	mycoursetypegroupid="mycoursetypegroupid"+k;
	
	str += "<td align='right'>"+(++count)+".</td>";
	str += "<td><input type='text' value='"+codevalue+"' id='"+codeid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
	str += "<td><input type='text' value='"+descvalue+"' id='"+descid+"' onblur='this.value=capitalize(this.value)' size='40' /></td>";
	str += "<td><input type='text' value='"+unitvalue+"' id='"+unitid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
	str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
	str += "<td><select id='"+typeid+"' onchange=checkGroup('"+coursetypegroupid+"','"+typeid+"','"+mycoursetypegroupid+"')><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
	str += "<td><div id='"+mycoursetypegroupid+"'></div></td>";
	//str += "<td><select id='"+typeid+"'><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
	str += "<td><input type='text' value='"+scorevalue+"' id='"+scoreid+"' size='10' /></td>";
	//str += "<td><a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','addRecord')>Save</a></td></tr>";
	str += "<td><a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','"+coursetypegroupid+"','addRecord')>Save</a></td></tr>";
    str += "</table>";
    document.getElementById('coursetablelist').innerHTML=str;
    document.getElementById(codeid).focus();
}

function checkGroup(coursetypegroupid,typeid,mycoursetypegroupid){
    var selectoption=document.getElementById(typeid);
    var coursetype=selectoption.options[selectoption.selectedIndex].text;
	if(coursetype=="Elective"){
		str = "<select id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
		document.getElementById(mycoursetypegroupid).innerHTML=str;
	}else{
		document.getElementById(mycoursetypegroupid).innerHTML="<td>&nbsp;</td>";
	}
}

//function updateCourse(serialno,codeid,descid,unitid,typeid,scoreid,option){
function updateCourse(serialno,codeid,descid,unitid,typeid,scoreid,coursetypegroupid,option){
	serialno = document.getElementById(serialno).value;
	coursecode = document.getElementById(codeid).value.trim();
	//insert a space in course code
	var token = "";
	var str = "";
	for(var k=0; k<coursecode.length; k++){
		token = coursecode.substring(k,k+1);
		if(token == " "){
			break;
		}
		if(isNaN(token)){
			str += token;
		}else{
			coursecode = str + " " + coursecode.substring(k);
			break;
		}
	}
    coursedescription = document.getElementById(descid).value;
	courseunit = document.getElementById(unitid).value;
    var selectoption=document.getElementById(typeid);
    var coursetype=selectoption.options[selectoption.selectedIndex].text;
	var coursetypegroup="";
	if(coursetype=="Elective"){
		selectoption=document.getElementById(coursetypegroupid);
	    var coursetypegroup=selectoption.options[selectoption.selectedIndex].text;
	}
	minimumscore = document.getElementById(scoreid).value;

    var faculty = document.getElementById("facultycode2").value;
    var department = document.getElementById("departmentcode2").value;
    var programme = document.getElementById("programmecode2").value;
    var level = document.getElementById("studentlevel2").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    //var entryyear = document.getElementById("entryyear").value;
    var lecturerid = "";
	var entryyear = "";
    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    //if (entryyear=="") error += "Group Code must not be blank.<br><br>";

    if (coursecode=="") error += "course Code must not be blank.<br><br>";
    if (coursedescription=="") error += "Course Description must not be blank.<br><br>";
    if (courseunit=="") error += "Course Unit must not be blank.<br><br>";
    if (coursetype=="") error += "Course Type must not be blank.<br><br>";
    if (minimumscore=="") error += "Minimum Score must not be blank.<br><br>";
    if (isNaN(courseunit)) error += "Course Unit must be numeric.<br><br>";
    if (isNaN(minimumscore)) error += "Minimum Score must be numeric.<br><br>";

    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie('ordersort','ASC',false);
    var table ="coursestable";
    //var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');

    var param = "&param="+serialno+"]["+coursecode+"]["+coursedescription+"]["+courseunit+"]["+coursetype;
	param +="]["+minimumscore+"]["+programme+"]["+lecturerid+"]["+faculty+"]["+department+"]["+sesions;
	param +="]["+semester+"]["+level+"]["+entryyear+"][Both"+"]["+coursetypegroup;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function CopyCourseFromPreviousSession(){
    var faculty = document.getElementById("facultycode2").value;
    var department = document.getElementById("departmentcode2").value;
    var programme = document.getElementById("programmecode2").value;
    var level = document.getElementById("studentlevel2").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;
    //var entryyear = document.getElementById("entryyear").value;

    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    //if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	$('#copycoursetable').dialog('open');
}

function PasteCourseToCurrentSession(){
    var faculty = document.getElementById("facultycode2B").value;
    var department = document.getElementById("departmentcode2B").value;
    var programme = document.getElementById("programmecode2B").value;
    var level = document.getElementById("studentlevel2B").value;
    var sesions = document.getElementById("sesionsB").value;
    var semester = document.getElementById("semesterB").value;
    //var entryyear = document.getElementById("entryyearB").value;

    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    //if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	var param2="";
	var k=0;
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		var hiddenid="hidden"+(i);
		k=i+1;
		if(document.getElementById(checkboxid).checked==true){
			//serialnoid="serialnoid"+k;
			//serialnovalue=document.getElementById(serialnoid).value;
			codeid="codeidB"+k;
			codevalue=document.getElementById(codeid).value;
			descid="descidB"+k;
			descvalue=document.getElementById(descid).value;
			unitid="unitidB"+k;
			unitvalue=document.getElementById(unitid).value;
			typeid="typeidB"+k;
			typevalue=document.getElementById(typeid).value;
			//coursetypegroupid="coursetypegroupidB"+k;
			//coursetypegroupvalue=document.getElementById(coursetypegroupid).value;
			coursetypegroupvalue="";
			scoreid="scoreidB"+k;
			scorevalue=document.getElementById(scoreid).value;
			param2 +=codevalue+"!!!"+descvalue+"!!!"+unitvalue+"!!!"+typevalue+"!!!"+scorevalue+"!!!"+coursetypegroupvalue+"_~_";
		}
	}
	if(param2.length==0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some records to copy: ";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
    var facultyA = document.getElementById("facultycode2").value;
    var departmentA = document.getElementById("departmentcode2").value;
    var programmeA = document.getElementById("programmecode2").value;
    var levelA = document.getElementById("studentlevel2").value;
    var sesionsA = document.getElementById("sesions").value;
    var semesterA = document.getElementById("semester").value;
	var entryyear="";
	var entryyearA="";
    //var entryyearA = document.getElementById("entryyear").value;
	param2 = "&param2="+param2;
    var param = "&param="+facultyA+"]["+departmentA+"]["+programmeA+"]["+levelA+"]["+sesionsA+"]["+semesterA+"]["+entryyearA;
	param +="]["+faculty+"]["+department+"]["+programme+"]["+level+"]["+sesions+"]["+semester+"]["+entryyear+"][Both";
    var url = "/laspotechportal/setupbackend.php?option=copyCourses&table=coursestable"+param+param2;
	AjaxFunctionSetup(url);
}

function populateLockCourse(arg,arg2){
	if(arg2!=null) createCookie("ordersort",arg2,false);
    var faculty = document.getElementById("facultycode").value;
    var department = document.getElementById("departmentcode").value;
    var programme = document.getElementById("programmecode").value;
    var level = document.getElementById("studentlevel").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;

    var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_faculty_",faculty.replace(/\,/g, '_'),365);
	createCookie("_department_",department.replace(/\,/g, '_'),365);
	createCookie("_programme_",programme.replace(/\,/g, '_'),365);
	createCookie("_level_",level.replace(/\,/g, '_'),365);
	createCookie("_session_",sesions.replace(/\,/g, '_'),365);
	createCookie("_semester_",semester.replace(/\,/g, '_'),365);

    var param = "&table=coursestableC&facultycode="+faculty+"&departmentcode="+department+"&programmecode="+programme+"&studentlevel="+level;
	param += "&sesions="+sesions+"&semester="+semester+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateLockCourses(arg){
	myCheckboxes=0;
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a style='font-weight:bold; color:black' href=javascript:populateLockCourse('coursecode') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Course_Code',event) onmouseout=toolTip('msgdivB','',event)>Course_Code</a></td>";
	str += "<td>Course_Description</td><td>Course_unit</td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateLockCourse('coursetype') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Course_Type',event) onmouseout=toolTip('msgdivB','',event)>Course_Type</a></td>";
	str += "<td>&nbsp;</td><td>Student_Type</td>";
	str += "<td>Minimum_Score</td><td><input type='checkbox' id='selectall' onclick='lockRecords();'>&nbsp;Lock/Unlock All</td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var codeid="";
    var codevalue="";
    var descid="";
    var descvalue="";
    var unitid="";
    var unitvalue="";
    var typeid="";
    var typevalue="";
    var studentypeid="";
    var studentypevalue="";
	var mycoursetypegroupid="";
    var scoreid="";
    var scorevalue="";
	var checkboxid="";
	var hiddenid="";
    var col_split = "";
    var lockid="";
    var lockvalue="";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		codeid="codeidB"+k;
		codevalue=col_split[1];
		descid="descidB"+k;
		descvalue=col_split[2];
		unitid="unitidB"+k;
		unitvalue=col_split[3];
		typeid="typeidB"+k;
		typevalue=col_split[4];
		studentypeid="studentypeidB"+k;
		studentypevalue=col_split[14];
		coursetypegroupid="coursetypegroupidB"+k;
		coursetypegroupvalue=col_split[15];
		scoreid="scoreidB"+k;
		scorevalue=col_split[5];
		lockid="lockidB"+k;
		lockvalue=col_split[16];
		checkboxid="box"+(k-1);
		hiddenid="hidden"+(k-1);
		mycoursetypegroupid="mycoursetypegroupid"+k;
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+codevalue+"' id='"+codeid+"' size='10' /></td>";
        str += "<td><input type='text' readonly value='"+descvalue+"' id='"+descid+"' size='50' /></td>";
        str += "<td><input type='text' readonly value='"+unitvalue+"' id='"+unitid+"' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
		if(col_split[4]==null || col_split[4]==""){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
			str += "<td>&nbsp;</td>";
		}else if(col_split[4]=="Compulsory"){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option></option><option selected>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
			str += "<td>&nbsp;</td>";
		}else if(col_split[4]=="Required"){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option></option><option>Compulsory</option><option selected>Required</option><option>Elective</option></select></td>";
			str += "<td>&nbsp;</td>";
		}else if(col_split[4]=="Elective"){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option></option><option>Compulsory</option><option>Required</option><option selected>Elective</option></select></td>";
			str += "<td>";
			if(coursetypegroupvalue==""){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option selected></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 1"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option selected>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 2"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option selected>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 3"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option selected>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 4"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option selected>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 5"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option selected>Group 5</option></select>";
			}
			str += "</td>";
		}

		if(col_split[14]==null || col_split[14]==""){
			str += "<td><select readonly disabled='true' id='"+studentypeid+"'><option selected></option><option>Both</option><option>UTME</option><option>PCE</option></select></td>";
		}else if(col_split[14]=="Both"){
			str += "<td><select readonly disabled='true' id='"+studentypeid+"'><option></option><option selected>Both</option><option>UTME</option><option>PCE</option></select></td>";
		}else if(col_split[14]=="UTME"){
			str += "<td><select readonly disabled='true' id='"+studentypeid+"'><option></option><option>Both</option><option selected>UTME</option><option>PCE</option></select></td>";
		}else if(col_split[14]=="PCE"){
			str += "<td><select readonly disabled='true' id='"+studentypeid+"'><option></option><option>Both</option><option>UTME</option><option selected>PCE</option></select></td>";
		}
        str += "<td><input type='text' readonly value='"+scorevalue+"' id='"+scoreid+"' size='10' /></td>";
        //str += "<td><a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','deleteRecord')>Delete</a></td></tr>";
		myCheckboxes++;
		codevalue=codevalue.replace(/ /g,'_');
		if(lockvalue=="1"){
			str += "<td><input type='checkbox' id='"+checkboxid+"' checked onclick=updateLocks('"+serialnovalue+"','"+lockvalue+"','"+codevalue+"'); >&nbsp;[Locked]<input type='hidden' id='"+hiddenid+"' value='"+codevalue+"'></td></tr>";
		}else{
			str += "<td><input type='checkbox' id='"+checkboxid+"' onclick=updateLocks('"+serialnovalue+"','"+lockvalue+"','"+codevalue+"'); >&nbsp;[Open]<input type='hidden' id='"+hiddenid+"' value='"+codevalue+"'></td></tr>";
		}
	}
    str += "</table>";
    document.getElementById('coursetablelist').innerHTML=str;
    //document.getElementById(codeid).focus();
	eraseCookie("ordersort");
}

function updateLocks(serialno, lock, coursecode){
	//codevalue=codevalue.replace(/_/g,' ');
	createCookie("ordersort","ASC",false);
	if(lock=="1"){
		lock="";
	}else{
		lock="1";
	}
    var faculty = document.getElementById("facultycode").value;
    var department = document.getElementById("departmentcode").value;
    var programme = document.getElementById("programmecode").value;
    var level = document.getElementById("studentlevel").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;

    var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&param="+serialno+"]["+lock+"]["+faculty+"]["+department+"]["+programme+"]["+level+"]["+sesions+"]["+semester+"]["+coursecode;
    var url = "/laspotechportal/setupbackend.php?option=updateLocks&table=coursestable"+param;
	AjaxFunctionSetup(url);
}

var globalvariable="";
createCookie("globalvariable", globalvariable,false);
function uploadRecords(){
	/*for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		if(document.getElementById(checkboxid).checked==true){
			document.getElementById(checkboxid).checked=false;
		}else{
			document.getElementById(checkboxid).checked=true;
		}
	}*/
    var faculty = document.getElementById("facultycode").value;
    var department = document.getElementById("departmentcode").value;
    var programme = document.getElementById("programmecode").value;
    var level = document.getElementById("studentlevel").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;

    var error="";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_faculty_",faculty,365);
	createCookie("_department_",department,365);
	createCookie("_programme_",programme,365);
	createCookie("_level_",level,365);
	createCookie("_session_",sesions,365);
	createCookie("_semester_",semester,365);
	var param2="";
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		table="table"+i;
		if(document.getElementById(checkboxid).checked==true){
			param2 += table+"_~_";
		}
	}
	if(param2.length==0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some TABLES to upload: ";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
	globalvariable=param2;
	param2 = "&param2="+param2;
    var param1 = "&param1="+faculty+"]["+department+"]["+programme+"]["+level+"]["+sesions+"]["+semester;
    var url = "/laspotechportal/datatransfer.php?option=uploadRecords"+param1+param2;
//alert(url);
	AjaxFunctionSetup(url);
}

function lockRecords(){
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		//if(document.getElementById('selectall').checked==true){
		if(document.getElementById(checkboxid).checked==true){
			document.getElementById(checkboxid).checked=false;
		}else{
			document.getElementById(checkboxid).checked=true;
		}
	}
    var faculty = document.getElementById("facultycode").value;
    var department = document.getElementById("departmentcode").value;
    var programme = document.getElementById("programmecode").value;
    var level = document.getElementById("studentlevel").value;
    var sesions = document.getElementById("sesions").value;
    var semester = document.getElementById("semester").value;

    var error="";
    if (faculty=="") error += "Faculty must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	var param2="";
	var k=0;
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		var hiddenid="hidden"+(i);
		k=i+1;
		//serialnoid="serialnoid"+k;
		//serialnovalue=document.getElementById(serialnoid).value;
		codeid="codeidB"+k;
		codevalue=document.getElementById(codeid).value;
		/*(descid="descidB"+k;
		descvalue=document.getElementById(descid).value;
		unitid="unitidB"+k;
		unitvalue=document.getElementById(unitid).value;
		typeid="typeidB"+k;
		typevalue=document.getElementById(typeid).value;
		studentypeid="studentypeidB"+k;
		studentypevalue=document.getElementById(studentypeid).value;
		coursetypegroupvalue="";
		if(typevalue=="Elective"){
			coursetypegroupid="coursetypegroupidB"+k;
			coursetypegroupvalue=document.getElementById(coursetypegroupid).value;
		}
		scoreid="scoreidB"+k;
		scorevalue=document.getElementById(scoreid).value;*/
		if(document.getElementById(checkboxid).checked==true){
			lockvalue="1";
		}else{
			lockvalue="";
		}
		//param2 +=codevalue+"!!!"+descvalue+"!!!"+unitvalue+"!!!"+typevalue+"!!!"+scorevalue+"!!!"+studentypevalue+"!!!"+coursetypegroupvalue+"!!!"+scorevalue+"!!!"+lockvalue+"_~_";
		param2 +=codevalue+"!!!"+lockvalue+"_~_";
	}
	if(param2.length==0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some COURSES to lock: ";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
	param2 = "&param2="+param2;
    var param = "&param="+faculty+"]["+department+"]["+programme+"]["+level+"]["+sesions+"]["+semester;
    var url = "/laspotechportal/setupbackend.php?option=lockrecords&table=coursestable"+param+param2;
	AjaxFunctionSetup(url);
}

function populateCopyCourse(arg){
    var faculty = document.getElementById("facultycode2B").value;
    var department = document.getElementById("departmentcode2B").value;
    var programme = document.getElementById("programmecode2B").value;
    var level = document.getElementById("studentlevel2B").value;
    var sesions = document.getElementById("sesionsB").value;
    var semester = document.getElementById("semesterB").value;
    //var entryyear = document.getElementById("entryyearB").value;
	var entryyear="";

    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    //if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=coursestableB&facultycode="+faculty+"&departmentcode="+department+"&programmecode="+programme+"&studentlevel="+level;
	param += "&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateCopyCourses(arg){
	myCheckboxes=0;
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a href=javascript:populateCopyCourse('coursecode') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Course_Code',event) onmouseout=toolTip('msgdivB','',event)>Course_Code</a></td>";
	str += "<td>Course_Description</td><td>Course_unit</td>";
	str += "<td><a href=javascript:populateCopyCourse('coursetype') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Course_Type',event) onmouseout=toolTip('msgdivB','',event)>Course_Type</a></td>";
	str += "<td>&nbsp;</td>";
	str += "<td>Minimum_Score</td><td><input type='checkbox' id='selectall' onclick='doCheckboxes();'></td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var codeid="";
    var codevalue="";
    var descid="";
    var descvalue="";
    var unitid="";
    var unitvalue="";
    var typeid="";
    var typevalue="";
	var mycoursetypegroupid="";
    var scoreid="";
    var scorevalue="";
	var checkboxid="";
	var hiddenid="";
    var col_split = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoidB"+k;
		serialnovalue=col_split[0];
		codeid="codeidB"+k;
		codevalue=col_split[1];
		descid="descidB"+k;
		descvalue=col_split[2];
		unitid="unitidB"+k;
		unitvalue=col_split[3];
		typeid="typeidB"+k;
		typevalue=col_split[4];
		coursetypegroupid="coursetypegroupidB"+k;
		coursetypegroupvalue=col_split[15];
		scoreid="scoreidB"+k;
		scorevalue=col_split[5];
		checkboxid="box"+(k-1);
		hiddenid="hidden"+(k-1);
		mycoursetypegroupid="mycoursetypegroupid"+k;
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+codevalue+"' id='"+codeid+"' size='10' /></td>";
        str += "<td><input type='text' readonly value='"+descvalue+"' id='"+descid+"' size='50' /></td>";
        str += "<td><input type='text' readonly value='"+unitvalue+"' id='"+unitid+"' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
		if(col_split[4]==null || col_split[4]==""){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
			str += "<td>&nbsp;</td>";
		}else if(col_split[4]=="Compulsory"){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option></option><option selected>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
			str += "<td>&nbsp;</td>";
		}else if(col_split[4]=="Required"){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option></option><option>Compulsory</option><option selected>Required</option><option>Elective</option></select></td>";
			str += "<td>&nbsp;</td>";
		}else if(col_split[4]=="Elective"){
			str += "<td><select readonly disabled='true' id='"+typeid+"'><option></option><option>Compulsory</option><option>Required</option><option selected>Elective</option></select></td>";
			str += "<td>";
			if(coursetypegroupvalue==""){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option selected></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 1"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option selected>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 2"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option selected>Group 2</option><option>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 3"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option selected>Group 3</option><option>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 4"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option selected>Group 4</option><option>Group 5</option></select>";
			}else if(coursetypegroupvalue=="Group 5"){
				str += "<select readonly disabled='true' id='"+coursetypegroupid+"'><option></option><option>Group 1</option><option>Group 2</option><option>Group 3</option><option>Group 4</option><option selected>Group 5</option></select>";
			}
			str += "</td>";
		}
		/*if(col_split[4]==null || col_split[4]==""){
			str += "<td><select readonly id='"+typeid+"'><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Compulsory"){
			str += "<td><select readonly id='"+typeid+"'><option></option><option selected>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Required"){
			str += "<td><select readonly id='"+typeid+"'><option></option><option>Compulsory</option><option selected>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Elective"){
			str += "<td><select readonly id='"+typeid+"'><option></option><option>Compulsory</option><option>Required</option><option selected>Elective</option></select></td>";
		}*/
        str += "<td><input type='text' readonly value='"+scorevalue+"' id='"+scoreid+"' size='10' /></td>";
        //str += "<td><a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','deleteRecord')>Delete</a></td></tr>";
		myCheckboxes++;
		str += "<td><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+codevalue+"'></td></tr>";
    }
    str += "</table>";
    document.getElementById('coursetablelistB').innerHTML=str;
}

/*function populateCopyCourse(arg){
    var faculty = document.getElementById("facultycode2B").value;
    var department = document.getElementById("departmentcode2B").value;
    var programme = document.getElementById("programmecode2B").value;
    var level = document.getElementById("studentlevel2B").value;
    var sesions = document.getElementById("sesionsB").value;
    var semester = document.getElementById("semesterB").value;
    //var entryyear = document.getElementById("entryyearB").value;
	var entryyear="";

    var error="";
    if (faculty=="") error += "School must not be blank.<br><br>";
    if (department=="") error += "Department must not be blank.<br><br>";
    if (programme=="") error += "Programme must not be blank.<br><br>";
    if (level=="") error += "Student Level must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if (semester=="") error += "Semester must not be blank.<br><br>";
    //if (entryyear=="") error += "Group Code must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
    var param = "&table=coursestableB&facultycode="+faculty+"&departmentcode="+department+"&programmecode="+programme+"&studentlevel="+level;
	param += "&sesions="+sesions+"&semester="+semester+"&entryyear="+entryyear+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateCopyCourses(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a href=javascript:populateCourse('coursecode') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Course_Code',event) onmouseout=toolTip('msgdivB','',event)>Course_Code</a></td>";
	str += "<td>Course_Description</td><td>Course_unit</td>";
	str += "<td><a href=javascript:populateCourse('coursetype') onmouseover=toolTip('msgdivB','Click_here_to_sort_by_Course_Type',event) onmouseout=toolTip('msgdivB','',event)>Course_Type</a></td>";
	str += "<td>Minimum_Score</td><td><input type='checkbox' id='selectall' onclick='doCheckboxes();'></td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var codeid="";
    var codevalue="";
    var descid="";
    var descvalue="";
    var unitid="";
    var unitvalue="";
    var typeid="";
    var typevalue="";
    var scoreid="";
    var scorevalue="";
	var checkboxid="";
	var hiddenid="";
    var col_split = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		codeid="codeidB"+k;
		codevalue=col_split[1];
		descid="descidB"+k;
		descvalue=col_split[2];
		unitid="unitidB"+k;
		unitvalue=col_split[3];
		typeid="typeidB"+k;
		typevalue=col_split[4];
		scoreid="scoreidB"+k;
		scorevalue=col_split[5];
		checkboxid="box"+(k-1);
		hiddenid="hidden"+(k-1);
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+codevalue+"' id='"+codeid+"' size='10' /></td>";
        str += "<td><input type='text' readonly value='"+descvalue+"' id='"+descid+"' size='50' /></td>";
        str += "<td><input type='text' readonly value='"+unitvalue+"' id='"+unitid+"' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
		if(col_split[4]==null || col_split[4]==""){
			str += "<td><select readonly id='"+typeid+"'><option selected></option><option>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Compulsory"){
			str += "<td><select readonly id='"+typeid+"'><option></option><option selected>Compulsory</option><option>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Required"){
			str += "<td><select readonly id='"+typeid+"'><option></option><option>Compulsory</option><option selected>Required</option><option>Elective</option></select></td>";
		}else if(col_split[4]=="Elective"){
			str += "<td><select readonly id='"+typeid+"'><option></option><option>Compulsory</option><option>Required</option><option selected>Elective</option></select></td>";
		}
        str += "<td><input type='text' readonly value='"+scorevalue+"' id='"+scoreid+"' size='10' /></td>";
        //str += "<td><a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateCourse('"+serialnoid+"','"+codeid+"','"+descid+"','"+unitid+"','"+typeid+"','"+scoreid+"','deleteRecord')>Delete</a></td></tr>";
		myCheckboxes++;
		str += "<td><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+codevalue+"'></td></tr>";
    }
    str += "</table>";
    document.getElementById('coursetablelistB').innerHTML=str;
}*/

function showGrades(){
	$('#gradestable').dialog('open');
}

function populateGrade(arg){
	createCookie("sortby",arg,false);
    var qualification = document.getElementById("qualification").value;
    var sesions = document.getElementById("sesions").value;
    var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_gradequlification_",qualification,365);
	createCookie("_gradesession_",sesions,365);
    var param = "&table=gradestable&qualification="+qualification+"&sesions="+sesions+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateGrades(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a style='font-weight:bold; color:black' href=javascript:populateGrade('gradecode') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Grade_Codes',event) onmouseout=toolTip('msgdiv','',event)>Grade_Code</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateGrade('lowerrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Lower-Range_Scores',event) onmouseout=toolTip('msgdiv','',event)>Lower_Range_Score</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateGrade('upperrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Upper_Range_Scores',event) onmouseout=toolTip('msgdiv','',event)>Upper_Range_Score</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateGrade('gradeunit') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Garede_Points',event) onmouseout=toolTip('msgdiv','',event)>Grade_Point</a></td><td>&nbsp;</td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var gradeid="";
    var gradevalue="";
    var lowerid="";
    var lowervalue="";
    var upperid="";
    var uppervalue="";
    var pointid="";
    var pointvalue="";
    var col_split = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		gradeid="gradeid"+k;
		gradevalue=col_split[1];
		lowerid="lowerid"+k;
		lowervalue=col_split[2];
		upperid="upperid"+k;
		uppervalue=col_split[3];
		pointid="pointid"+k;
		pointvalue=col_split[4];
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' value='"+gradevalue+"' id='"+gradeid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='text' value='"+lowervalue+"' id='"+lowerid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='text' value='"+uppervalue+"' id='"+upperid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td><input type='text' value='"+pointvalue+"' id='"+pointid+"' size='10' /></td>";
        str += "<td><a href=javascript:updateGrade('"+serialnoid+"','"+gradeid+"','"+lowerid+"','"+upperid+"','"+pointid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateGrade('"+serialnoid+"','"+gradeid+"','"+lowerid+"','"+upperid+"','"+pointid+"','deleteRecord')>Delete</a></td></tr>";
    }
	if(flag==0){
		str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
		flag=1;
	}else{
		str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
		flag=0;
	}
	serialnoid="serialnoid"+k;
	serialnovalue="";
	gradeid="gradeid"+k;
	gradevalue="";
	lowerid="lowerid"+k;
	lowervalue="";
	upperid="upperid"+k;
	uppervalue="";
	pointid="pointid"+k;
	pointvalue="";
	
	str += "<td align='right'>"+(++count)+".</td>";
	str += "<td><input type='text' value='"+gradevalue+"' id='"+gradeid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
	str += "<td><input type='text' value='"+lowervalue+"' id='"+lowerid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
	str += "<td><input type='text' value='"+uppervalue+"' id='"+upperid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
	str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
	str += "<td><input type='text' value='"+pointvalue+"' id='"+pointid+"' size='10' /></td>";
	str += "<td><a href=javascript:updateGrade('"+serialnoid+"','"+gradeid+"','"+lowerid+"','"+upperid+"','"+pointid+"','addRecord')>Save</a></td></tr>";
    str += "</table>";
    document.getElementById('gradeslist').innerHTML=str;
    document.getElementById(gradeid).focus();
}


function populateCopyGrade(arg){
	createCookie("sortby",arg,false);
    var qualification = document.getElementById("qualificationB").value;
    var sesions = document.getElementById("sesionsB").value;
    var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    var param = "&table=gradestableB&qualification="+qualification+"&sesions="+sesions+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateCopyGrades(arg){
	myCheckboxes=0;
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td><BR>S/No</td><td><a style='font-weight:bold; color:black' href=javascript:populateCopyGrade('gradecode') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Grade_Codes',event) onmouseout=toolTip('msgdiv','',event)><BR>Grade_Code</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateCopyGrade('lowerrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Lower-Range_Scores',event) onmouseout=toolTip('msgdiv','',event)><BR>Lower_Range_Score</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateCopyGrade('upperrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Upper_Range_Scores',event) onmouseout=toolTip('msgdiv','',event)><BR>Upper_Range_Score</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateCopyGrade('gradeunit') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Garede_Points',event) onmouseout=toolTip('msgdiv','',event)><BR>Grade_Point</a></td>";
	str += "<td align='center'>Select All&nbsp;<BR><input type='checkbox' id='selectall' onclick='doCheckboxes();'></td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var gradeid="";
    var gradevalue="";
    var lowerid="";
    var lowervalue="";
    var upperid="";
    var uppervalue="";
    var pointid="";
    var pointvalue="";
    var col_split = "";
	var checkboxid="";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoidB"+k;
		serialnovalue=col_split[0];
		gradeid="gradeidB"+k;
		gradevalue=col_split[1];
		lowerid="loweridB"+k;
		lowervalue=col_split[2];
		upperid="upperidB"+k;
		uppervalue=col_split[3];
		pointid="pointidB"+k;
		pointvalue=col_split[4];
		checkboxid="box"+(k-1);
		hiddenid="hidden"+(k-1);

		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+gradevalue+"' id='"+gradeid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='text' readonly value='"+lowervalue+"' id='"+lowerid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='text' readonly value='"+uppervalue+"' id='"+upperid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td><input type='text' value='"+pointvalue+"' id='"+pointid+"' size='10' /></td>";
		myCheckboxes++;
		str += "<td align='center'><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+gradevalue+"'></td></tr>";
    }
    str += "</table>";
    document.getElementById('gradeslistB').innerHTML=str;
}

function updateGrade(serialnoid, gradeid, lowerid, upperid, pointid, option){
    var serialno = document.getElementById(serialnoid).value;
    var qualification = document.getElementById("qualification").value;
    var sesions = document.getElementById("sesions").value;
    var gradecode = document.getElementById(gradeid).value;
    var gradeunit = document.getElementById(pointid).value;
    var lowerrange = document.getElementById(lowerid).value;
    var upperrange = document.getElementById(upperid).value;
    var error = "";
    if (gradecode==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Grade code must not be blank.<br><br>";
        }
    }
    if (gradeunit=="") error += "Grade Point must not be blank.<br><br>";
    if (lowerrange=="") error += "Lower Range score must not be blank.<br><br>";
    if (upperrange=="") error += "Upper Range score must not be blank.<br><br>";
    if (isNaN(gradeunit)) error += "Grade unit must be numeric.<br><br>";
    if (isNaN(lowerrange)) error += "Lower range score must be numeric.<br><br>";
    if (isNaN(upperrange)) error += "Upper range score must be numeric.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+gradecode+"]["+lowerrange+"]["+upperrange+"]["+gradeunit+"]["+qualification+"]["+sesions;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table=gradestable"+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function CopyGradeFromPreviousSession(){
    var qualification = document.getElementById("qualification").value;
    var sesions = document.getElementById("sesions").value;

	var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	$('#copygradestable').dialog('open');
}

function PasteGradeToCurrentSession(){
    var qualification = document.getElementById("qualificationB").value;
    var sesions = document.getElementById("sesionsB").value;

    var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	var param2="";
	var k=0;
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		var hiddenid="hidden"+(i);
		k=i+1;
		if(document.getElementById(checkboxid).checked==true){
			//serialnoid="serialnoid"+k;
			//serialnovalue=document.getElementById(serialnoid).value;
			gradeid="gradeidB"+k;
			gradevalue=document.getElementById(gradeid).value;
			lowerid="loweridB"+k;
			lowervalue=document.getElementById(lowerid).value;
			upperid="upperidB"+k;
			uppervalue=document.getElementById(upperid).value;
			pointid="pointidB"+k;
			pointvalue=document.getElementById(pointid).value;
			param2 +=gradevalue+"!!!"+lowervalue+"!!!"+uppervalue+"!!!"+pointvalue+"_~_";
		}
	}
	if(param2.length==0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some records to copy: ";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
    var qualificationA = document.getElementById("qualification").value;
    var sesionsA = document.getElementById("sesions").value;
	param2 = "&param2="+param2;
    var param = "&param="+qualificationA+"]["+sesionsA;
	param +="]["+qualification+"]["+sesions;
    var url = "/laspotechportal/setupbackend.php?option=copyGrades&table=gradestable"+param+param2;
	AjaxFunctionSetup(url);
}

var myCheckboxes=0;
function initializeOnlineVariable(){
	myCheckboxes=21;
}

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

function updateStudentsLevel(option, table){
    var leveldescription = document.getElementById("leveldescription").value;
    var examofficer = document.getElementById("examofficer").value;
    var error = "";
    if (leveldescription==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Level must not be blank.<br><br>";
        }
    }
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
    var param = "&param="+serialno+"]["+leveldescription+"]["+examofficer;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function updateQualifications(option, table){
    var qualification = document.getElementById("qualificationcode").value;
    var description = document.getElementById("qualificationdescription").value;
    var error = "";
    if (qualification==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Qualification code must not be blank.<br><br>";
        }
    }
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
    var param = "&param="+serialno+"]["+qualification+"]["+description;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function updateSession(option, table){
    var sessiondescription = document.getElementById("sessiondescription").value;
    var semesterdescription = document.getElementById("semesterdescription").value;
    var semesterstartdate = document.getElementById("semesterstartdate").value;
    var semesterenddate = document.getElementById("semesterenddate").value;
    var selectoption = document.getElementById("currentperiod");
    var currentperiod = selectoption.options[selectoption.selectedIndex].text;
    var error = "";
    if (sessiondescription=="" || semesterdescription==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }
    }
    if (sessiondescription=="") error += "Session must not be blank.<br><br>";
    if (semesterdescription=="") error += "Semester must not be blank.<br><br>";
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
    var param = "&param="+serialno+"]["+sessiondescription+"]["+semesterdescription+"]["+semesterstartdate+"]["+semesterenddate+"]["+currentperiod;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table="+table+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function showCgpas(){
	$('#cgpatable').dialog('open');
}

function populateCgpa(arg){
	createCookie("sortby",arg,false);
    var qualification = document.getElementById("qualification").value;
    var sesions = document.getElementById("sesions").value;
    var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	createCookie("_cgpaqulification_",qualification,365);
	createCookie("_cgpasession_",sesions,365);
    var param = "&table=cgpatable&qualification="+qualification+"&sesions="+sesions+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
    AjaxFunctionSetup(url);
}

function populateCgpas(arg){
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td>S/No</td><td><a style='font-weight:bold; color:black' href=javascript:populateCgpa('cgpacode') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Cgpa_Codes',event) onmouseout=toolTip('msgdiv','',event)>Cgpa</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateCgpa('lowerrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Lower-Range_Scores',event) onmouseout=toolTip('msgdiv','',event)>Lower_Range_Point</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateCgpa('upperrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Upper_Range_Scores',event) onmouseout=toolTip('msgdiv','',event)>Upper_Range_Point</a></td><td>&nbsp;</td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var cgpaid="";
    var cgpavalue="";
    var lowerid="";
    var lowervalue="";
    var upperid="";
    var uppervalue="";
    var col_split = "";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoid"+k;
		serialnovalue=col_split[0];
		cgpaid="cgpaid"+k;
		cgpavalue=col_split[1];
		lowerid="lowerid"+k;
		lowervalue=col_split[2];
		upperid="upperid"+k;
		uppervalue=col_split[3];
		pointid="pointid"+k;
		pointvalue=col_split[4];
        
		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' value='"+cgpavalue+"' id='"+cgpaid+"' onblur='this.value=capitalize(this.value)' size='30' /></td>";
        str += "<td><input type='text' value='"+lowervalue+"' id='"+lowerid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='text' value='"+uppervalue+"' id='"+upperid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
        str += "<td><a href=javascript:updateCgpa('"+serialnoid+"','"+cgpaid+"','"+lowerid+"','"+upperid+"','updateRecord')>Update</a>&nbsp;&nbsp;<a href=javascript:updateCgpa('"+serialnoid+"','"+cgpaid+"','"+lowerid+"','"+upperid+"','deleteRecord')>Delete</a></td></tr>";
    }
	if(flag==0){
		str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
		flag=1;
	}else{
		str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
		flag=0;
	}
	serialnoid="serialnoid"+k;
	serialnovalue="";
	cgpaid="cgpaid"+k;
	cgpavalue="";
	lowerid="lowerid"+k;
	lowervalue="";
	upperid="upperid"+k;
	uppervalue="";
	pointid="pointid"+k;
	pointvalue="";
	
	str += "<td align='right'>"+(++count)+".</td>";
	str += "<td><input type='text' value='"+cgpavalue+"' id='"+cgpaid+"' onblur='this.value=capitalize(this.value)' size='30' /></td>";
	str += "<td><input type='text' value='"+lowervalue+"' id='"+lowerid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
	str += "<td><input type='text' value='"+uppervalue+"' id='"+upperid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
	str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
	str += "<td><a href=javascript:updateCgpa('"+serialnoid+"','"+cgpaid+"','"+lowerid+"','"+upperid+"','addRecord')>Save</a></td></tr>";
    str += "</table>";
    document.getElementById('cgpaslist').innerHTML=str;
    document.getElementById(cgpaid).focus();
}


function populateCopyCgpa(arg){
	createCookie("sortby",arg,false);
    var qualification = document.getElementById("qualificationB").value;
    var sesions = document.getElementById("sesionsB").value;
    var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    var param = "&table=cgpatableB&qualification="+qualification+"&sesions="+sesions+"&access="+arg;
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+param;
	AjaxFunctionSetup(url);
}

function populateCopyCgpas(arg){
	myCheckboxes=0;
	var row_split = arg.split('getAllRecs');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#336699;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:#000000'>";
    str += "<td><BR>S/No</td><td><a style='font-weight:bold; color:black' href=javascript:populateCopyCgpa('cgpacode') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Cgpa_Codes',event) onmouseout=toolTip('msgdiv','',event)><BR>Cgpa</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateCopyCgpa('lowerrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Lower-Range_Scores',event) onmouseout=toolTip('msgdiv','',event)><BR>Lower_Range_Point</a></td>";
	str += "<td><a style='font-weight:bold; color:black' href=javascript:populateCopyCgpa('upperrange') onmouseover=toolTip('msgdiv','Click_here_to_sort_by_Upper_Range_Scores',event) onmouseout=toolTip('msgdiv','',event)><BR>Upper_Range_Point</a></td>";
	str += "<td align='center'>Select All&nbsp;<BR><input type='checkbox' id='selectall' onclick='doCheckboxes();'></td></tr>";
    var flag=0;
    var serialnoid="";
    var serialnovalue="";
    var cgpaid="";
    var cgpavalue="";
    var lowerid="";
    var lowervalue="";
    var upperid="";
    var uppervalue="";
    var col_split = "";
	var checkboxid="";
    var count=0;
	var k=1;
	for(k=1; k<row_split.length-1; k++){
        col_split = row_split[k].split('_~_');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
			flag=1;
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
			flag=0;
        }
		serialnoid="serialnoidB"+k;
		serialnovalue=col_split[0];
		cgpaid="cgpaidB"+k;
		cgpavalue=col_split[1];
		lowerid="loweridB"+k;
		lowervalue=col_split[2];
		upperid="upperidB"+k;
		uppervalue=col_split[3];
		checkboxid="box"+(k-1);
		hiddenid="hidden"+(k-1);

		str += "<td align='right'>"+(++count)+".</td>";
        str += "<td><input type='text' readonly value='"+cgpavalue+"' id='"+cgpaid+"' onblur='this.value=capitalize(this.value)' size='30' /></td>";
        str += "<td><input type='text' readonly value='"+lowervalue+"' id='"+lowerid+"' onblur='this.value=capitalize(this.value)' size='10' /></td>";
        str += "<td><input type='text' readonly value='"+uppervalue+"' id='"+upperid+"' onblur='this.value=numberFormat(this.value)' size='10' />";
        str += "<input type='hidden' value='"+serialnovalue+"' id='"+serialnoid+"' /></td>";
		myCheckboxes++;
		str += "<td align='center'><input type='checkbox' id='"+checkboxid+"'><input type='hidden' id='"+hiddenid+"' value='"+cgpavalue+"'></td></tr>";
    }
    str += "</table>";
    document.getElementById('cgpaslistB').innerHTML=str;
}

function updateCgpa(serialnoid, cgpaid, lowerid, upperid, option){
    var serialno = document.getElementById(serialnoid).value;
    var qualification = document.getElementById("qualification").value;
    var sesions = document.getElementById("sesions").value;
    var cgpacode = document.getElementById(cgpaid).value;
    var lowerrange = document.getElementById(lowerid).value;
    var upperrange = document.getElementById(upperid).value;
    var error = "";
    if (cgpacode==""){
        if(option=="deleteRecord"){
            error += "Select a record to delete.<br><br>";
        }else{
            error += "Cgpa code must not be blank.<br><br>";
        }
    }
    if (lowerrange=="") error += "Lower Range score must not be blank.<br><br>";
    if (upperrange=="") error += "Upper Range score must not be blank.<br><br>";
    if (isNaN(lowerrange)) error += "Lower range score must be numeric.<br><br>";
    if (isNaN(upperrange)) error += "Upper range score must be numeric.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }

    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    if(serialno==null) serialno="";
    var param = "&param="+serialno+"]["+cgpacode+"]["+lowerrange+"]["+upperrange+"]["+qualification+"]["+sesions;
    var url = "/laspotechportal/setupbackend.php?option="+option+"&table=cgpatable"+param+"&currentuser="+readCookie("currentuser")+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function CopyCgpaFromPreviousSession(){
    var qualification = document.getElementById("qualification").value;
    var sesions = document.getElementById("sesions").value;

	var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	$('#copycgpatable').dialog('open');
}

function PasteCgpaToCurrentSession(){
    var qualification = document.getElementById("qualificationB").value;
    var sesions = document.getElementById("sesionsB").value;

    var error="";
    if (qualification=="") error += "Qualification must not be blank.<br><br>";
    if (sesions=="") error += "Session must not be blank.<br><br>";
    if(error.length >0) {
        error = "<br><b>Please correct the following errors:</b> <br><br><br>" + error;
        document.getElementById("showError").innerHTML = error;
        $('#showError').dialog('open');
        return true;
    }
	var param2="";
	var k=0;
	for(var i=0; i < myCheckboxes; i++){
		var checkboxid="box"+(i);
		var hiddenid="hidden"+(i);
		k=i+1;
		if(document.getElementById(checkboxid).checked==true){
			//serialnoid="serialnoid"+k;
			//serialnovalue=document.getElementById(serialnoid).value;
			cgpaid="cgpaidB"+k;
			cgpavalue=document.getElementById(cgpaid).value;
			lowerid="loweridB"+k;
			lowervalue=document.getElementById(lowerid).value;
			upperid="upperidB"+k;
			uppervalue=document.getElementById(upperid).value;
			param2 +=cgpavalue+"!!!"+lowervalue+"!!!"+uppervalue+"!!!"+pointvalue+"_~_";
		}
	}
	if(param2.length==0) {
		error = "<br><b>Please correct the following errors:</b> <br><br><br>Please select some records to copy: ";
		document.getElementById("showError").innerHTML = error;
		$('#showError').dialog('open');
		return true;
	}
    var qualificationA = document.getElementById("qualification").value;
    var sesionsA = document.getElementById("sesions").value;
	param2 = "&param2="+param2;
    var param = "&param="+qualificationA+"]["+sesionsA;
	param +="]["+qualification+"]["+sesions;
    var url = "/laspotechportal/setupbackend.php?option=copyCgpas&table=cgpatable"+param+param2;
	AjaxFunctionSetup(url);
}

function getRecords(table,serialno){
    if(serialno == null || serialno.length == 0) serialno = "1";
    /*$('#menuList').dialog('close');
    resetForm();
    if(table=='schoolinformation') $('#schoolinfo').dialog('open');
    if(table=='facultiestable') $('#faculty').dialog('open');
    if(table=='departmentstable') $('#department').dialog('open');
    if(table=='programmestable') $('#programme').dialog('open');
    if(table=='coursestable')$('#coursetable').dialog('open');
    if(table=='studentslevels') $('#studentslevel').dialog('open');
    if(table=='qualificationstable') $('#qualification').dialog('open');
    if(table=='sessionstable') $('#sessions').dialog('open');
    if(table=='gradestable') $('#grades').dialog('open');
    if(table=='cgpatable') $('#cgpas').dialog('open');*/
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/laspotechportal/setupbackend.php?option=getAllRecs"+"&table="+table+"&serialno="+serialno;
    if(table=='schoolinformation') url = "/laspotechportal/setupbackend.php?option=getARecord"+"&table="+table+"&serialno="+serialno;
	AjaxFunctionSetup(url);
}

function populateRecords(serialno, table){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/laspotechportal/setupbackend.php?option=getARecord"+"&table="+table+"&serialno="+serialno;
    AjaxFunctionSetup(url);
}

function getRecordlist(arg2,arg3,arg4){
    curr_obj = document.getElementById(arg2);
    temp_table = arg3;
    list_obj = arg4;
	if(arg2=="departmentcode"){
		var facultycode=document.getElementById("facultycode").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on School selected.\nPlease select a faculty");
			document.getElementById("facultycode").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode"){
		var departmentcode=document.getElementById("departmentcode").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="programmedescription"){
		var departmentcode=document.getElementById("departmentcode").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="studentlevel"){
		var programmecode=document.getElementById("programmecode").value;
		if(programmecode==null || programmecode==""){
			alert("programme selection is dependent on Programme selected.\nPlease select a programme");
			document.getElementById("programmecode").focus();
			return true;
		}
		createCookie("parent_obj",programmecode,false);
	}
	if(arg2=="departmentcode2"){
		var facultycode=document.getElementById("facultycode2").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on School selected.\nPlease select a faculty");
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
	if(arg2=="studentlevel2"){
		var programmecode=document.getElementById("programmecode2").value;
		if(programmecode==null || programmecode==""){
			alert("programme selection is dependent on Programme selected.\nPlease select a programme");
			document.getElementById("programmecode2").focus();
			return true;
		}
		createCookie("parent_obj",programmecode,false);
	}
	if(arg2=="departmentcode2B"){
		var facultycode=document.getElementById("facultycode2B").value;
		if(facultycode==null || facultycode==""){
			alert("Department selection is dependent on School selected.\nPlease select a faculty");
			document.getElementById("facultycode2B").focus();
			return true;
		}
		createCookie("parent_obj",facultycode,false);
	}
	if(arg2=="programmecode2B"){
		var departmentcode=document.getElementById("departmentcode2B").value;
		if(departmentcode==null || departmentcode==""){
			alert("programme selection is dependent on Department selected.\nPlease select a department");
			document.getElementById("departmentcode2B").focus();
			return true;
		}
		createCookie("parent_obj",departmentcode,false);
	}
	if(arg2=="studentlevel2B"){
		var programmecode=document.getElementById("programmecode2B").value;
		if(programmecode==null || programmecode==""){
			alert("programme selection is dependent on Programme selected.\nPlease select a programme");
			document.getElementById("programmecode2B").focus();
			return true;
		}
		createCookie("parent_obj",programmecode,false);
	}
    var url = "/laspotechportal/setupbackend.php?option=getRecordlist&table="+arg3+"&currentobject="+arg2;
//alert(arg2+"  "+arg3+"  "+arg4);
    AjaxFunctionSetup(url);
}

function populateCode(code){
    curr_obj.value = code.replace(/#/g,' ');
    clearLists(list_obj);
	if(readCookie('getunit')=='1'){
		eraseCookie('getunit');
		document.getElementById("maximumunit").value="";
		doMaxUnit('get');
	}
}

function clearLists(arg){
    if(arg==null) arg=list_obj;
    document.getElementById(arg).innerHTML = "";
}

function resetForm(table){
	if(table=="facultiestable"){
	    document.getElementById("facultydescription").value="";
		document.getElementById("dof").value="";
    }
	if(table=="departmentstable"){
		document.getElementById("facultycode").value="";
		document.getElementById("departmentdescription").value="";
		document.getElementById("hod").value="";
	}
	if(table=="programmestable"){
		document.getElementById("departmentcode").value="";
		document.getElementById("programmedescription").value="";
		document.getElementById("courseadvisor").value="";
	}
	if(table=="studentslevels"){
		document.getElementById("leveldescription").value="";
		document.getElementById("examofficer").value="";
	}
	if(table=="sessionstable"){
		document.getElementById("sessiondescription").value="";
		document.getElementById("semesterdescription").value="";
		document.getElementById("semesterstartdate").value="";
		document.getElementById("semesterenddate").value="";
		selectoption = document.getElementById("currentperiod");
		selectoption.selectedIndex = 0;
	}
	if(table=="qualificationstable"){
		document.getElementById("qualificationcode").value="";
		document.getElementById("qualificationdescription").value="";
	}
 	if(table=="gradestable"){
		document.getElementById("gradecode").value="";
		document.getElementById("gradeunit").value="";
		document.getElementById("glowerrange").value="";
		document.getElementById("gupperrange").value="";
	}
 	if(table=="cgpatable"){
		document.getElementById("cgpacode").value="";
		document.getElementById("clowerrange").value="";
		document.getElementById("cupperrange").value="";
	}
}

function clearCurrentRecord(){
    var url = "/laspotechportal/dataentrybackend.php?option=clearCurrentRecord";
	AjaxFunctionSetup(url);
}

var xmlhttp

function AjaxFunctionSetup(arg){
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
			alert(resp);
		}
        if(resp.match("checkAccess")){
            if(resp.match("checkAccessSuccess")){
				if(readCookie('access').match('divcodechangeid')){
					document.getElementById(readCookie('access')).innerHTML="<input style='display:inline' type='text' id='newcodeid' onblur=updateCodeChange(this.id) size='10' />";
					document.getElementById('newcodeid').focus();
				}else{
					window.location="home.php?pgid=1";
				}
            }else{
                break_resp = resp.split("checkAccessFailed");
                resp = "<b>Access Denied!!!</b><br><br>Menu ["+break_resp[1]+"] not accessible by "+readCookie("currentuser");
                document.getElementById("showPrompt").innerHTML = resp;
                $('#showPrompt').dialog('open');
            }
        }
        if(resp.match("editCourseCode")){
			editCourseCode();
		}
        /*if(resp.match("checkAccess")){
            if(resp.match("checkAccessSuccess")){
                break_resp = resp.split("checkAccessSuccess");
                if(break_resp[2]!=null && break_resp[2]!=""){
                    var prg = break_resp[1]+"('"+break_resp[2]+"','1')";
alert(prg);    
                    eval(prg);
                }
                if(break_resp[2]==null || break_resp[2]==""){
                    var prg = break_resp[1]+"('"+break_resp[2]+"')";
alert(prg);    
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
            return true;
        }*/

        if(resp.match("readCookies")){
			var currentrecord = resp.split("readCookies");
			var break_resp = currentrecord[1].split("_-_");
			var percentage =  parseInt((parseInt(break_resp[2])/parseInt(break_resp[1]))*100);
			if(isNaN(percentage)) percentage=0;
			document.getElementById(break_resp[0]).innerHTML = break_resp[2]+"/"+break_resp[1]+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+percentage+" % "; //+break_resp[4];
			if(break_resp[3]=='Y'){
				clearCurrentRecord();
			}
		}

		if(resp.match("myStopFunction")) {
			myStopFunction();
		}

		if(resp.match("getAllRecs")){
			eraseCookie("ordersort", null, false);
            break_resp = resp.split("getAllRecs");
            var allrecords = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:95%;background-color:#336699;margin-top:5px;'>";
            allrecords += "<tr style='font-weight:bold; color:white'>";
            if(break_resp[0]=="facultiestable"){
                allrecords += "<td>S/No</td><td>Schools</td><td>Directors of Schools</td></tr>";
            }else if(break_resp[0]=="departmentstable"){
                allrecords += "<td>S/No</td><td>Departments</td><td>Schools</td><td>Programme Coordinators</td></tr>";
            }else if(break_resp[0]=="programmestable"){
                allrecords += "<td>S/No</td><td>Programmes</td><td>Departments</td><td>Course Advisor</td></tr>";
            }else if(break_resp[0]=="coursestable"){
				populateCourses(resp);
				return true;
            }else if(break_resp[0]=="coursestableB"){
				populateCopyCourses(resp);
				return true;
                //allrecords += "<td width='5%'>S/No</td><td width='20%'>Course code</td><td width='35%'>Description</td><td width='15%'>Course Unit</td><td width='25%'>Course Type</td></tr>";
            }else if(break_resp[0]=="coursestableC"){
				populateLockCourses(resp);
				return true;
            }else if(break_resp[0]=="studentslevels"){
                allrecords += "<td>S/No</td><td>Levels</td><td>Examination Officer</td></tr>";
            }else if(break_resp[0]=="qualificationstable"){
                allrecords += "<td>S/No</td><td>Code</td><td>Description</td></tr>";
            }else if(break_resp[0]=="sessionstable"){
                allrecords += "<td>S/No</td><td>Session</td><td>Semester</td><td>Semester Start</td><td>Semester End</td><td>Current Period</td></tr>";
            }else if(break_resp[0]=="gradestable"){
				populateGrades(resp);
				return true;
            }else if(break_resp[0]=="gradestableB"){
				populateCopyGrades(resp);
				return true;
                //allrecords += "<td>S/No</td><td>Grade Code</td><td>Lower Range Score</td><td>Upper Range Score</td><td>Grade Unit</td></tr>";
            }else if(break_resp[0]=="cgpatable"){
				populateCgpas(resp);
				return true;
            }else if(break_resp[0]=="cgpatableB"){
				populateCopyCgpas(resp);
				return true;
                //allrecords += "<td>S/No</td><td>CGPA</td><td>Lower Range Point</td><td>Upper Range Point</td></tr>";
            }
            var recordlist = null;
            if(break_resp[0]=="facultiestable") recordlist = document.getElementById('facultylist');
            if(break_resp[0]=="departmentstable") recordlist = document.getElementById('departmentlist');
            if(break_resp[0]=="programmestable") recordlist = document.getElementById('programmelist');
            //if(break_resp[0]=="coursestable") recordlist = document.getElementById('coursetablelist');
            if(break_resp[0]=="studentslevels") recordlist = document.getElementById('studentslevellist');
            if(break_resp[0]=="qualificationstable") recordlist = document.getElementById('qualificationlist');
            if(break_resp[0]=="sessionstable") recordlist = document.getElementById('sessionslist');
            //if(break_resp[0]=="gradestable") recordlist = document.getElementById('gradeslist');
            //if(break_resp[0]=="cgpatable") recordlist = document.getElementById('cgpaslist');
            var counter = 0;
            var rsp = "";
            var flg = 0;
            var break_row = "";
            var compare1 = "departmentstable programmestable coursestable sessionstable gradestable cgpatable";
            var compare2 = "coursestable sessionstable gradestable";
            var compare3 = "sessionstable";
            for(var i=1; i < (break_resp.length-1); i++){
                break_row = break_resp[i].split("_~_");

                if (flg == 1) {
                    flg = 0;
                    rsp += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
                    rsp += "<td align='right'>" + (++counter) + ".</td>";
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
                    rsp += "</tr>";
                } else {
                    flg = 1;
                    rsp += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
                    rsp += "<td width='5%' align='right'>" + (++counter) + ".</td>";
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
                    rsp += "</tr>";
                }
            }
            recordlist.innerHTML = allrecords+rsp+"</table>";
			if(break_resp[0]=="coursestable") document.getElementById("programmecode").value = readCookie("programme").replace(/#/g,' ');
        }

        if(resp.match("getRecordlist")){
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

            var token = "";
            var tokensent = "";
            counter = 1;
            var colorflag = 0;
            var k=0;

            if(keyword.trim().length==0){
                for(k=0; k<allCodes.length; k++){
                    if(curr_obj.id=='lecturerid' && !allCodes[k].match("Staff")) continue;
                    if(allCodes[k].trim().length>0){
                        token = allCodes[k].split("_~_");
                        tokensent = token[1].replace(/ /g,'#');
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
                        inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+tokensent+"')>"+token[1]+"</a></td>";
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
                        inner_codeslist += "</tr>";
                    }
                }
            } else {
                for(k=0; k<allCodes.length; k++){
                    if(curr_obj.id=='lecturerid' && !allCodes[k].match("Staff")) continue;
                    if(allCodes[k].trim().length>0 && (allCodes[k].toUpperCase().match(keyword.toUpperCase()))){
                        token = allCodes[k].split("_~_");
                        tokensent = token[1].replace(/ /g,'#');
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;color:#FFFFFF'>"

                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'>"
                        }
                        inner_codeslist += "<td align='right'>"+counter+++".</td><td><a href=javascript:populateCode('"+tokensent+"')>"+token[1]+"</a></td>";
                        if(token[2]!=null && token[2]!="") inner_codeslist += "<td>"+token[2]+"</td>";
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
            break_resp = resp.split("getARecord");
            createCookie("serialno",break_resp[1],false)
            var selectoption = null;
            if(break_resp[0]=="schoolinformation"){
                document.getElementById("schoolname").value = break_resp[2];
                document.getElementById("addressline1").value = break_resp[3];
                document.getElementById("addressline2").value = break_resp[4];
                document.getElementById("addressline3").value = break_resp[5];
                document.getElementById("addressline4").value = break_resp[6];
                document.getElementById("telephonenumber").value = break_resp[7];
                document.getElementById("faxnumber").value = break_resp[8];
                document.getElementById("emailaddress").value = break_resp[9];
            }
            if(break_resp[0]=="facultiestable"){
                document.getElementById("facultydescription").value = break_resp[2];
                document.getElementById("dof").value = break_resp[3];
            }
            if(break_resp[0]=="departmentstable"){
                document.getElementById("departmentdescription").value = break_resp[2];
                document.getElementById("facultycode").value = break_resp[3];
                document.getElementById("hod").value = break_resp[4];
            }
            if(break_resp[0]=="programmestable"){
                document.getElementById("programmedescription").value = break_resp[2];
                document.getElementById("departmentcode").value = break_resp[3];
                document.getElementById("courseadvisor").value = break_resp[4];
            }
            if(break_resp[0]=="coursestable"){
                document.getElementById("coursecode").value= break_resp[2];
                document.getElementById("coursedescription").value= break_resp[3];
                document.getElementById("courseunit").value= break_resp[4];
                document.getElementById("coursetype").value= break_resp[5];
                document.getElementById("minimumscore").value= break_resp[6];
                document.getElementById("programmecode").value= break_resp[7];
                document.getElementById("lecturerid").value= break_resp[8];
            }
            if(break_resp[0]=="studentslevels"){
                document.getElementById("leveldescription").value = break_resp[2];
                document.getElementById("examofficer").value = break_resp[3];
            }
            if(break_resp[0]=="qualificationstable"){
                document.getElementById("qualificationcode").value = break_resp[2];
                document.getElementById("qualificationdescription").value = break_resp[3];
            }
            if(break_resp[0]=="sessionstable"){
                document.getElementById("sessiondescription").value= break_resp[2];
                document.getElementById("semesterdescription").value= break_resp[3];
                document.getElementById("semesterstartdate").value= break_resp[4];
                document.getElementById("semesterenddate").value= break_resp[5];
                document.getElementById("currentperiod").value= break_resp[6];
                selectoption = document.getElementById("currentperiod");
                for(k=0; selectoption.options[k].text != null; k++){
                    if(selectoption.options[k].text == break_resp[6]){
                        selectoption.selectedIndex = k;
                        break;
                    }
                }
                /*var selectoption = document.getElementById("currentperiod");
                if(break_resp[6] == 'Yes'){
                    selectoption.selectedIndex = 2;
                }else if(break_resp[6] == 'No'){
                    selectoption.selectedIndex = 1;
                }else{
                    selectoption.selectedIndex = 0;
                }*/
            }
            if(break_resp[0]=="gradestable"){
                document.getElementById("gradecode").value= break_resp[2];
                document.getElementById("glowerrange").value= break_resp[3];
                document.getElementById("gupperrange").value= break_resp[4];
                document.getElementById("gradeunit").value= break_resp[5];
            }
            if(break_resp[0]=="cgpatable"){
                document.getElementById("cgpacode").value= break_resp[2];
                document.getElementById("clowerrange").value= break_resp[3];
                document.getElementById("cupperrange").value= break_resp[4];
            }
            return true;
        }

        if(resp.match("inserted")){
			createCookie('ordersort','ASC',false);
            break_resp = resp.split("inserted");
			if(break_resp[0]=="coursestable"){
				var sortby=readCookie("sortby");
				populateCourse(sortby);
				return true;
			}else if(break_resp[0]=="gradestable"){
				var sortby=readCookie("sortby");
				populateGrade(sortby);
				return true;
			}else if(break_resp[0]=="cgpatable"){
				var sortby=readCookie("sortby");
				populateCgpa(sortby);
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Added!!!</b><br><br>Your record was successfully added.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("updated")){
			createCookie('ordersort','ASC',false);
            break_resp = resp.split("updated");
			if(break_resp[0]=="coursestable"){
				var sortby=readCookie("sortby");
				populateCourse(sortby);
				return true;
			}else if(break_resp[0]=="gradestable"){
				var sortby=readCookie("sortby");
				populateGrade(sortby);
				return true;
			}else if(break_resp[0]=="cgpatable"){
				var sortby=readCookie("sortby");
				populateCgpa(sortby);
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Updated!!!</b><br><br>Your record was successfully updated.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("deleted")){
//document.getElementById("showPrompt").innerHTML = resp;
//$('#showPrompt').dialog('open');
//return true;
			createCookie('ordersort','ASC',false);
            break_resp = resp.split("deleted");
			if(break_resp[0]=="coursestable"){
				var sortby=readCookie("sortby");
				populateCourse(sortby);
				return true;
			}else if(break_resp[0]=="gradestable"){
				var sortby=readCookie("sortby");
				populateGrade(sortby);
				return true;
			}else if(break_resp[0]=="cgpatable"){
				var sortby=readCookie("sortby");
				populateCgpa(sortby);
				return true;
			}else{
				resetForm(break_resp[0]);
				getRecords(break_resp[0],"1");
			}
            document.getElementById("showPrompt").innerHTML = "<b>Record Deleted!!!</b><br><br>Your record was successfully deleted.";
            $('#showPrompt').dialog('open');
        }

        if(resp.match("recordlocked")){
            break_resp = resp.split("recordlocked");
            document.getElementById("showPrompt").innerHTML = "<b>Records Locked!!!</b><br><br>The record your are trying to change is locked "+break_resp[1];
			$('#showPrompt').dialog('open');
        }

        if(resp.match("showMaxUnit")){
            break_resp = resp.split("showMaxUnit");
			document.getElementById("maximumunit").value= break_resp[1];
		}

        if(resp.match("coursecode_exists")){
            resp = resp.replace(/_/g, ' ');
            document.getElementById("showError").innerHTML = "<b>Course Code Used!!!</b><br><br>The new course code have been used, try another one.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("exists_in")){
            resp = resp.replace(/_/g, ' ');
            document.getElementById("showError").innerHTML = "<b>Record Exists!!!</b><br><br>The "+resp+".";
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
