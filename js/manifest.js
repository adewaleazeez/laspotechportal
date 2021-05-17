/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var curr_obj = null;
var curr_id = null;
var temp_table = "";
var temp_entrydate = "";
var temp_voyageno = "";
var temp_fromdate = "";
var temp_todate = "";

function clearLists(){
    document.getElementById("codeslist").innerHTML = "";
}
function clearVoyageNoLists(){
    document.getElementById("voyagenolist").innerHTML = "";
}
function doListings(arg){
    if(arg=="newbol"){
        var voyageno = document.getElementById("voyageno").value;
        if(voyageno.length==0){
            document.getElementById("showPrompt").innerHTML = "<b>Alert...</b><br><br>Please enter or select a valid voyage no.";
            $('#showAlert').dialog('close');
            $('#showPrompt').dialog('open');
            return true;
        }
    }
    $('#listings').dialog('close');
    $('#details').dialog('open');
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your records.";
    $('#showAlert').dialog('open');
    resetForm(arg);
    
}
function doDetails(arg){
    var Registry_Number = document.getElementById("Registry_Number").value;
    var Departure_Date = document.getElementById("Departure_Date").value;
    var Customs_Office_Code = document.getElementById("Customs_Office_Code").value;
    var Master_Information = document.getElementById("Master_Information").value;
    var Last_Discharge_Date = document.getElementById("Last_Discharge_Date").value;
    var Date_of_Arrival = document.getElementById("Date_of_Arrival").value;
    var Time_of_Arrival = document.getElementById("Time_of_Arrival").value;
    var Place_of_Departure_Code = document.getElementById("Place_of_Departure_Code").value;
    var Place_of_Destination_Code = document.getElementById("Place_of_Destination_Code").value;
    var Carrier_Code = document.getElementById("Carrier_Code").value;
    var Carrier_Name = document.getElementById("Carrier_Name").value;
    var Carrier_Address = document.getElementById("Carrier_Address").value;
    var Name_of_Transporter = document.getElementById("Name_of_Transporter").value;
    var Place_of_Transporter = document.getElementById("Place_of_Transporter").value;
    var Mode_of_Transport_Code = document.getElementById("Mode_of_Transport_Code").value;
    var Nationality_of_Transporter_Code = document.getElementById("Nationality_of_Transporter_Code").value;
    var Registration_Number = document.getElementById("Registration_Number").value;
    var Registration_Date = document.getElementById("Registration_Date").value;
    var Gross_Tonnage = document.getElementById("Gross_Tonnage").value;
    var Net_Tonnage = document.getElementById("Net_Tonnage").value;
    var entryDate = document.getElementById("entryDate").value;

    var Bol_Reference = document.getElementById("Bol_Reference").value;
    var Line_Number = document.getElementById("Line_Number").value;
    var Previous_Document_Reference = document.getElementById("Previous_Document_Reference").value;
    var Bol_Nature = document.getElementById("Bol_Nature").value;
    var Unique_Carrier_Reference = document.getElementById("Unique_Carrier_Reference").value;
    //var Total_Number_of_Containers = document.getElementById("Total_Number_of_Containers").value;
    var Total_Gross_Mass_Manifested = document.getElementById("Total_Gross_Mass_Manifested").value;
    var Volume_in_Cubic_Meters = document.getElementById("Volume_in_Cubic_Meters").value;
    var BOL_Type_Code = document.getElementById("BOL_Type_Code").value;
    var Exporter_Code = document.getElementById("Exporter_Code").value;
    var Exporter_Name = document.getElementById("Exporter_Name").value;
    var Exporter_Address = document.getElementById("Exporter_Address").value;
    var Consignee_Code = document.getElementById("Consignee_Code").value;
    var Consignee_Name = document.getElementById("Consignee_Name").value;
    var Consignee_Address = document.getElementById("Consignee_Address").value;
    var Notify_Code = document.getElementById("Notify_Code").value;
    var Notify_Name = document.getElementById("Notify_Name").value;
    var Notify_Address = document.getElementById("Notify_Address").value;
    var Package_Type_Code = document.getElementById("Package_Type_Code").value;
    var Number_of_Packages = document.getElementById("Number_of_Packages").value;
    var Shipping_Marks = document.getElementById("Shipping_Marks").value;
    var Goods_Description = document.getElementById("Goods_Description").value;
    var Number_of_Seals = document.getElementById("Number_of_Seals").value;
    var Marks_of_Seals = document.getElementById("Marks_of_Seals").value;
    var Sealing_Party_Code = document.getElementById("Sealing_Party_Code").value;
    var General_Information = document.getElementById("General_Information").value;
    var Location_Code = document.getElementById("Location_Code").value;
    var Location_Information = document.getElementById("Location_Information").value;
    //var Container_Identification = document.getElementById("Container_Identification").value;
    //var Container_Number = document.getElementById("Container_Number").value;
    //var Container_Type_Code = document.getElementById("Container_Type_Code").value;
    //var Empty_Full_Indicator = document.getElementById("Empty_Full_Indicator").value;
    //var Marks_of_Seals_1 = document.getElementById("Marks_of_Seals_1").value;
    //var Marks_of_Seals_2 = document.getElementById("Marks_of_Seals_2").value;
    //var Marks_of_Seals_3 = document.getElementById("Marks_of_Seals_3").value;
    //var Container_Sealing_Party_Code = document.getElementById("Container_Sealing_Party_Code").value;

    Departure_Date = Departure_Date.substr(6,4)+'-'+Departure_Date.substr(3,2)+'-'+Departure_Date.substr(0,2);
    Date_of_Arrival = Date_of_Arrival.substr(6,4)+'-'+Date_of_Arrival.substr(3,2)+'-'+Date_of_Arrival.substr(0,2);
    if(Last_Discharge_Date.length>0) Last_Discharge_Date = Last_Discharge_Date.substr(6,4)+'-'+Last_Discharge_Date.substr(3,2)+'-'+Last_Discharge_Date.substr(0,2);
    //Registration_Date = Registration_Date.substr(6,4)+'-'+Registration_Date.substr(3,2)+'-'+Registration_Date.substr(0,2);
    entryDate = entryDate.substr(6,4)+'-'+entryDate.substr(3,2)+'-'+entryDate.substr(0,2);

    var error = "";
    var serialno = readCookie("serialno");
    if(serialno == null || arg=='add') serialno = "";

    if (Registry_Number.length == 0) error += "Voyage Number must not be blank<br><br>";
    if (Departure_Date.length == 0) error += "Departure Date must not be blank<br><br>";
    if (Customs_Office_Code.length == 0) error += "Customs Office Code must not be blank<br><br>";
    if (Date_of_Arrival.length == 0) error += "Arrival Date must not be blank<br><br>";
    if (Departure_Date > Date_of_Arrival) error += "Departure Date must not be greater than Date of Arrival <br><br>";
    if (Place_of_Departure_Code.length == 0) error += "Loading Port Code must not be blank<br><br>";
    if (Place_of_Destination_Code.length == 0) error += "Unloading Port Code must not be blank<br><br>";
    if (Carrier_Code.length == 0) error += "Carrier Code must not be blank<br><br>";
    if (Name_of_Transporter.length == 0) error += "Plane/Vessel Name must not be blank<br><br>";
    if (Nationality_of_Transporter_Code.length == 0) error += "Plane/Vessel Nationality must not be blank<br><br>";
    if (Mode_of_Transport_Code.length == 0) error += "Mode of Transport Code must not be blank<br><br>";

    if (Line_Number.length == 0) error += "Line Number must not be blank<br><br>";
    if (Bol_Reference.length == 0) error += "Bill of Lading Reference must not be blank<br><br>";
    if (Bol_Nature.length == 0) error += "Bill of Lading Nature must not be blank<br><br>";
    if (Goods_Description.length == 0) error += "Goods Description must not be blank<br><br>";
    if (Total_Gross_Mass_Manifested <= "0") error += "Total Gross Mass Manifested Code must not be blank<br><br>";
    //if (Total_Number_of_Containers <= "0") error += "Total Number of Containers must not be blank<br><br>";
    if (BOL_Type_Code.length == 0) error += "Bill of Lading Type Code must not be blank<br><br>";
    if (Exporter_Name.length == 0) error += "Exporter Name must not be blank<br><br>";
    if (Consignee_Name.length == 0) error += "Consignee Name must not be blank<br><br>";
    if (Package_Type_Code.length == 0) error += "Package Type Code must not be blank<br><br>";
    if (Number_of_Packages.length == 0) error += "Number of Packages must not be blank<br><br>";

    if (isNaN(parseInt(Line_Number,10)) && Line_Number.trim().length>0) error += "Line Number must be numeric<br><br>";
    if (isNaN(parseInt(Number_of_Packages,10)) && Number_of_Packages.trim().length>0) error += "Number of Packages must be numeric<br><br>";

    //if (isNaN(parseInt(Total_Number_of_Containers,10))) Total_Number_of_Containers = "0";
    if (isNaN(parseInt(Total_Gross_Mass_Manifested,10))) Total_Gross_Mass_Manifested = "0";
    if (isNaN(parseInt(Volume_in_Cubic_Meters,10))) Volume_in_Cubic_Meters = "0";
    if (isNaN(parseInt(Number_of_Seals,10))) Number_of_Seals = "0";
    //if (isNaN(parseInt(Container_Number,10))) Container_Number = "0";
    if (isNaN(parseInt(Net_Tonnage,10))) Net_Tonnage = "0";
    if (isNaN(parseInt(Gross_Tonnage,10))) Gross_Tonnage = "0";

    if (Line_Number.existsinString(".")) error += "Line Number must not have decimal<br><br>";
    if (Number_of_Packages.existsinString(".")) error += "Number of Packages must not have decimal<br><br>";

    if (Total_Gross_Mass_Manifested.existsinString(".")) error += "Total Gross Mass Manifested must not have decimal<br><br>";
    if (Volume_in_Cubic_Meters.existsinString(".")) error += "Volume in Cubic Meters must not have decimal<br><br>";
    if (Number_of_Seals.existsinString(".")) error += "Number of Seals must not have decimal<br><br>";

    if (Net_Tonnage.existsinString(".")) error += "Net Tonnage must not have decimal<br><br>";
    if (Gross_Tonnage.existsinString(".")) error += "Gross Tonnage must not have decimal<br><br>";

    if(error.length > 0) {
        document.getElementById("showError").innerHTML = "<b>Please correct the following:</b><br><br><br>"+error;
        $('#showError').dialog('open');
        return false;
    }


    var param = "&Registry_Number="+Registry_Number;
    param += "&Departure_Date="+Departure_Date;
    param += "&Customs_Office_Code="+Customs_Office_Code;
    param += "&Master_Information="+Master_Information;
    param += "&Last_Discharge_Date="+Last_Discharge_Date;
    param += "&Date_of_Arrival="+Date_of_Arrival;
    param += "&Time_of_Arrival="+Time_of_Arrival;
    param += "&Place_of_Departure_Code="+Place_of_Departure_Code;
    param += "&Place_of_Destination_Code="+Place_of_Destination_Code;
    param += "&Carrier_Code="+Carrier_Code;
    param += "&Carrier_Name="+Carrier_Name;
    param += "&Carrier_Address="+Carrier_Address;
    param += "&Name_of_Transporter="+Name_of_Transporter;
    param += "&Place_of_Transporter="+Place_of_Transporter;
    param += "&Mode_of_Transport_Code="+Mode_of_Transport_Code;
    param += "&Nationality_of_Transporter_Code="+Nationality_of_Transporter_Code;
    param += "&Registration_Number="+Registration_Number;
    param += "&Registration_Date="+Registration_Date;
    param += "&Gross_Tonnage="+Gross_Tonnage;
    param += "&Net_Tonnage="+Net_Tonnage;
    param += "&entryDate="+entryDate;

    param += "&Bol_Reference="+Bol_Reference;
    param += "&Line_Number="+Line_Number;
    param += "&Previous_Document_Reference="+Previous_Document_Reference;
    param += "&Bol_Nature="+Bol_Nature;
    param += "&Unique_Carrier_Reference="+Unique_Carrier_Reference;
    //param += "&Total_Number_of_Containers="+Total_Number_of_Containers;
    param += "&Total_Gross_Mass_Manifested="+Total_Gross_Mass_Manifested;
    param += "&Volume_in_Cubic_Meters="+Volume_in_Cubic_Meters;
    param += "&BOL_Type_Code="+BOL_Type_Code;
    param += "&Exporter_Code="+Exporter_Code;
    param += "&Exporter_Name="+Exporter_Name;
    param += "&Exporter_Address="+Exporter_Address;
    param += "&Consignee_Code="+Consignee_Code;
    param += "&Consignee_Name="+Consignee_Name;
    param += "&Consignee_Address="+Consignee_Address;
    param += "&Notify_Code="+Notify_Code;
    param += "&Notify_Name="+Notify_Name;
    param += "&Notify_Address="+Notify_Address;
    param += "&Package_Type_Code="+Package_Type_Code;
    param += "&Number_of_Packages="+Number_of_Packages;
    param += "&Shipping_Marks="+Shipping_Marks;
    param += "&Goods_Description="+Goods_Description;
    param += "&Number_of_Seals="+Number_of_Seals;
    param += "&Marks_of_Seals="+Marks_of_Seals;
    param += "&Sealing_Party_Code="+Sealing_Party_Code;
    param += "&General_Information="+General_Information;
    param += "&Location_Code="+Location_Code;
    param += "&Location_Information="+Location_Information;
    //param += "&Container_Identification="+Container_Identification;
    //param += "&Container_Number="+Container_Number;
    //param += "&Container_Type_Code="+Container_Type_Code;
    //param += "&Empty_Full_Indicator="+Empty_Full_Indicator;
    //param += "&Marks_of_Seals_1="+Marks_of_Seals_1;
    //param += "&Marks_of_Seals_2="+Marks_of_Seals_2;
    //param += "&Marks_of_Seals_3="+Marks_of_Seals_3;
    //param += "&Container_Sealing_Party_Code="+Container_Sealing_Party_Code;
    param += "&serialno="+serialno;
    var userName = readCookie("currentuser");
    param += "&userName="+userName;

    var container_content = "";
    var containerref="";
    var containerrefvalue="";
    var containertype="";
    var containertypevalue="";
    var containernumber="";
    var containernumbervalue="";
    var containerparty="";
    var containerpartyvalue="";
    var containerindicator="";
    var containerindicatorvalue="";
    var containermark1="";
    var containermark1value="";
    var containermark2="";
    var containermark2value="";
    var containermark3="";
    var containermark3value="";

    for(var k=1; k<containerrow; k++){
        containerref = "containerref"+k;
        containertype = "containertype"+k;
        containernumber = "containernumber"+k;
        containerparty = "containerparty"+k;
        containerindicator = "containerindicator"+k;
        containermark1 = "containermark1"+k;
        containermark2 = "containermark2"+k;
        containermark3 = "containermark3"+k;
        if((k<(containerrow))){
            containerrefvalue = document.getElementById(containerref).value;
            containertypevalue = document.getElementById(containertype).value;
            containernumbervalue = document.getElementById(containernumber).value;
            containerpartyvalue = document.getElementById(containerparty).value;
            containerindicatorvalue = document.getElementById(containerindicator).value;
            containermark1value = document.getElementById(containermark1).value;
            containermark2value = document.getElementById(containermark2).value;
            containermark3value = document.getElementById(containermark3).value;
        }
        container_content += "@@@" + containerrefvalue + "~_~" + containertypevalue + "~_~" + containernumbervalue + "~_~" + containerpartyvalue + "~_~" + containerindicatorvalue + "~_~" + containermark1value + "~_~" + containermark2value + "~_~" + containermark3value;
    }
    param += "&container_content="+container_content;
    var url = "/emanifest/ManifestServlet?operation="+arg+param;
    $('#details').dialog('close');
    $('#listings').dialog('open');
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your records.";
    $('#showAlert').dialog('open');
    AjaxFunctionManifest(url);
    

}
function uploadMyXMLs(){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Uploading your files.";
    $('#showAlert').dialog('open');
    var url = "/emanifest/ManifestServlet?operation=uploadXML";
    AjaxFunctionManifest(url);
    
}
function checkMyFeedBacks(){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Checking your feedbacks.";
    $('#showAlert').dialog('open');
    var fromdate = document.getElementById("fromdate").value;
    var todate = document.getElementById("todate").value;
    var voyageno = document.getElementById("voyageno").value;
    if(voyageno.length==0){
        document.getElementById("showPrompt").innerHTML = "<b>Alert...</b><br><br>Please enter or select a valid voyage no.";
        $('#showAlert').dialog('close');
        $('#showPrompt').dialog('open');
        return true;
    }
    fromdate = fromdate.substr(6,4)+'-'+fromdate.substr(3,2)+'-'+fromdate.substr(0,2);
    todate = todate.substr(6,4)+'-'+todate.substr(3,2)+'-'+todate.substr(0,2);
    var arg = "&entryDate="+fromdate+"&Departure_Date="+todate+"&Registry_Number="+voyageno;

    var url = "/emanifest/ManifestServlet?operation=checkFeedBack"+arg;
    AjaxFunctionManifest(url);
    
}

function getAllRecords(arg2,arg3){
    curr_obj = document.getElementById(arg2);
    curr_id = arg2;
    temp_table = arg3;
    var serialno = "";
    if(arg3=="ports"){
        if(arg2=="Place_of_Departure_Code"){
            if(document.getElementById("loadingport").value==""){
                document.getElementById("showPrompt").innerHTML = "<b>Alert...</b><br><br>Please select a loading port country code.";
                $('#showPrompt').dialog('open');
                return true;
            }
            serialno= document.getElementById("loadingport").value;
        }else if(arg2=="Place_of_Destination_Code"){
            if(document.getElementById("unloadingport").value==""){
                document.getElementById("showPrompt").innerHTML = "<b>Alert...</b><br><br>Please select an unloading port country code.";
                $('#showPrompt').dialog('open');
                return true;
            }
            serialno= document.getElementById("unloadingport").value;
        }else{
            if(document.getElementById("locationport").value==""){
                document.getElementById("showPrompt").innerHTML = "<b>Alert...</b><br><br>Please select an Operation Location port country code.";
                $('#showPrompt').dialog('open');
                return true;
            }
            serialno= document.getElementById("locationport").value;
        }
        arg3 += "&serialno="+serialno;
    }
    var url = "/emanifest/ManifestServlet?operation=getAllRecords&table="+arg3;
    AjaxFunctionManifest(url);
    
}

/*function addRec(operation, table, param){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Processing your record.";
    $('#showAlert').dialog('open');
    var serialno = readCookie("serialno");
    if(serialno==null) serialno="";
    param += "&serialno="+serialno;
    var url = "/emanifest/SetupServlet?operation="+operation+"&table="+table+param;
    AjaxFunctionManifest(url);
}*/

function getXMLs(arg){
    $('#showPrompt').dialog('open');
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Generating your XML files.";
    $('#showPrompt').dialog('close');
    $('#showAlert').dialog('open');
    var fromdate = "";
    var todate = "";
    //var vesselname = "";
    var voyageno = "";
    if(arg=="filterbutton"){
        fromdate = document.getElementById("fromdate").value;
        todate = document.getElementById("todate").value;
        //vesselname = document.getElementById("vesselname").value;
        voyageno = document.getElementById("voyageno").value;
        if(voyageno.length==0){
            document.getElementById("showPrompt").innerHTML = "<b>Alert...</b><br><br>Please enter or select a valid voyage no.";
            $('#showAlert').dialog('close');
            $('#showPrompt').dialog('open');
            return true;
        }
    }else{
        var d = new Date();
        //var month = d.getMonth()+1;
        var day  = "";
        var mon  = "";
        var year  = "";

        if(fromdate == null || fromdate.trim().length == 0){
            //while((d.getMonth()+1) == month){
            //    d.setDate(d.getDate()-1);
            //}
            //d.setDate(d.getDate()+1);
            date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
            day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
            mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
            year = date_split[2];
            fromdate = day+"/"+mon+"/"+year;
        }

        if(todate == null || todate.trim().length == 0){
            //while((d.getMonth()+1) == month){
            //    d.setDate(d.getDate()+1);
            //}
            //d.setDate(d.getDate()-1);
            date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
            day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
            mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
            year = date_split[2];
            todate = day+"/"+mon+"/"+year;
        }
    }

    //temp_fromdate = fromdate;
    //temp_todate = todate;
    //temp_voyageno = voyageno;
    createCookie("fromdate", fromdate, false);
    createCookie("todate", todate, false);
    //createCookie("vesselname", vesselname, false);
    createCookie("voyageno", voyageno, false);

    //var startdate = fromdate;
    //var enddate = todate;
    //+"&Name_of_Transporter="+vesselname
    fromdate = fromdate.substr(6,4)+'-'+fromdate.substr(3,2)+'-'+fromdate.substr(0,2);
    todate = todate.substr(6,4)+'-'+todate.substr(3,2)+'-'+todate.substr(0,2);
    arg = "&entryDate="+fromdate+"&Departure_Date="+todate+"&Registry_Number="+voyageno;

    var url = "/emanifest/ManifestServlet?operation=generateXMLs"+arg;
    if(voyageno.length==0){
        curr_obj = "generateXMLs";
        url = "/emanifest/ManifestServlet?operation=getVoyageno&entryDate="+fromdate+"&Departure_Date="+todate;
    }
    AjaxFunctionManifest(url);
    
}

function getMyVoyagenos(){
    curr_obj = document.getElementById("voyageno");
    var fromdate = document.getElementById("fromdate").value;
    var todate = document.getElementById("todate").value;
    fromdate = fromdate.substr(6,4)+'-'+fromdate.substr(3,2)+'-'+fromdate.substr(0,2);
    todate = todate.substr(6,4)+'-'+todate.substr(3,2)+'-'+todate.substr(0,2);
    var url = "/emanifest/ManifestServlet?operation=getAllVoyagenos&entryDate="+fromdate+"&Departure_Date="+todate;
    AjaxFunctionManifest(url);
    
}
function getBols(arg){
    $('#showPrompt').dialog('open');
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your records.";
    $('#showPrompt').dialog('close');
    $('#showAlert').dialog('open');
    var fromdate = "";
    var todate = "";
    //var vesselname = "";
    var voyageno = "";
    if(arg=="filterbutton"){
        fromdate = document.getElementById("fromdate").value;
        todate = document.getElementById("todate").value;
        //vesselname = document.getElementById("vesselname").value;
        voyageno = document.getElementById("voyageno").value;
        if(voyageno.length==0){
            $('#showAlert').dialog('close');
            document.getElementById("showPrompt").innerHTML = "<b>Alert...</b><br><br>Please enter a valid voyage no.";
            $('#showPrompt').dialog('open');
            return true;
        }
    }else{
        var d = new Date();
        //var month = d.getMonth()+1;
        var day  = "";
        var mon  = "";
        var year  = "";

        if(fromdate == null || fromdate.trim().length == 0){
            //while((d.getMonth()+1) == month){
            //    d.setDate(d.getDate()-1);
            //}
            //d.setDate(d.getDate()+1);
            date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
            day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
            mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
            year = date_split[2];
            fromdate = day+"/"+mon+"/"+year;
        }

        if(todate == null || todate.trim().length == 0){
            //while((d.getMonth()+1) == month){
            //    d.setDate(d.getDate()+1);
            //}
            //d.setDate(d.getDate()-1);
            date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
            day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
            mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
            year = date_split[2];
            todate = day+"/"+mon+"/"+year;
        }
    }

    //temp_fromdate = fromdate;
    //temp_todate = todate;
    //temp_voyageno = voyageno;
    createCookie("fromdate", fromdate, false);
    createCookie("todate", todate, false);
    //createCookie("vesselname", vesselname, false);
    createCookie("voyageno", voyageno, false);

    //var startdate = fromdate;
    //var enddate = todate;
    //+"&Name_of_Transporter="+vesselname
    fromdate = fromdate.substr(6,4)+'-'+fromdate.substr(3,2)+'-'+fromdate.substr(0,2);
    todate = todate.substr(6,4)+'-'+todate.substr(3,2)+'-'+todate.substr(0,2);
    

    var url = "";
    arg = "&entryDate="+fromdate+"&Departure_Date="+todate+"&Registry_Number="+voyageno;
    if(voyageno.length==0){
        url = "/emanifest/ManifestServlet?operation=getVoyageno&entryDate="+fromdate+"&Departure_Date="+todate;
    }else{
        if(voyageno=="new"){
            voyageno = "";
            document.getElementById("voyageno").value = voyageno;
            createCookie("voyageno", voyageno, false);
            arg = "&entryDate="+fromdate+"&Departure_Date="+todate+"&Registry_Number="+voyageno;
        }
        url = "/emanifest/ManifestServlet?operation=getAllBols"+arg;
    }
    AjaxFunctionManifest(url);
    
}

function getRecords(table){
    document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    $('#showAlert').dialog('open');
    var url = "/emanifest/SetupServlet?operation=getAllRecords"+"&table="+table;
    AjaxFunctionManifest(url);
}

/*function populateRecords(serialno, table){
    //document.getElementById("showAlert").innerHTML = "<b>Please wait...</b><br><br>Fetching your data.";
    //$('#showAlert').dialog('open');
    var url = "/emanifest/SetupServlet?operation=getARecord"+"&table="+table+"&serialno="+serialno;
    AjaxFunctionManifest(url);
}*/

function populateCode(serialno){
    var url = "/emanifest/SetupServlet?operation=getARecord"+"&table="+temp_table+"&serialno="+serialno;
    AjaxFunctionManifest(url);
}

function resetForm(arg){
    containerrow = 1;
    document.getElementById("Bol_Reference").value="";
    document.getElementById("Line_Number").value="";
    document.getElementById("Previous_Document_Reference").value="";
    document.getElementById("Bol_Nature").value="";
    document.getElementById("Unique_Carrier_Reference").value="";
    //document.getElementById("Total_Number_of_Containers").value="";
    document.getElementById("Total_Gross_Mass_Manifested").value="";
    document.getElementById("Volume_in_Cubic_Meters").value="";
    document.getElementById("BOL_Type_Code").value="";
    document.getElementById("Exporter_Code").value="";
    document.getElementById("Exporter_Name").value="";
    document.getElementById("Exporter_Address").value="";
    document.getElementById("Consignee_Code").value="";
    document.getElementById("Consignee_Name").value="";
    document.getElementById("Consignee_Address").value="";
    document.getElementById("Notify_Code").value="";
    document.getElementById("Notify_Name").value="";
    document.getElementById("Notify_Address").value="";
    document.getElementById("Package_Type_Code").value="";
    document.getElementById("Number_of_Packages").value="";
    document.getElementById("Shipping_Marks").value="";
    document.getElementById("Goods_Description").value="";
    document.getElementById("Number_of_Seals").value="";
    document.getElementById("Marks_of_Seals").value="";
    document.getElementById("Sealing_Party_Code").value="";
    document.getElementById("General_Information").value="";
    document.getElementById("Location_Code").value="";
    document.getElementById("Location_Information").value="";
    //document.getElementById("Container_Identification").value="";
    //document.getElementById("Container_Number").value="";
    //document.getElementById("Container_Type_Code").value="";
    //document.getElementById("Empty_Full_Indicator").value="";
    //document.getElementById("Marks_of_Seals_1").value="";
    //document.getElementById("Marks_of_Seals_2").value="";
    //document.getElementById("Marks_of_Seals_3").value="";
    //document.getElementById("Container_Sealing_Party_Code").value="";
    document.getElementById("container_content").innerHTML = "";

    if(arg=="newman"){
        document.getElementById("Registry_Number").value="";
        document.getElementById("Registry_Number").disabled=false;
        document.getElementById("Departure_Date").value="";
        document.getElementById("Customs_Office_Code").value="";
        document.getElementById("Master_Information").value="";
        document.getElementById("Last_Discharge_Date").value="";
        document.getElementById("Date_of_Arrival").value="";
        document.getElementById("Time_of_Arrival").value="";
        document.getElementById("Place_of_Departure_Code").value="";
        document.getElementById("Place_of_Destination_Code").value="";
        document.getElementById("Carrier_Code").value="";
        document.getElementById("Carrier_Name").value="";
        document.getElementById("Carrier_Address").value="";
        document.getElementById("Name_of_Transporter").value="";
        document.getElementById("Place_of_Transporter").value="";
        document.getElementById("Mode_of_Transport_Code").value="";
        document.getElementById("Nationality_of_Transporter_Code").value="";
        document.getElementById("Registration_Number").value="";
        document.getElementById("Registration_Date").value="";
        document.getElementById("Gross_Tonnage").value="";
        document.getElementById("Net_Tonnage").value="";

        var d = new Date();
        var day  = "";
        var mon  = "";
        var year  = "";

        date_split = ((d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()).split('/');
        day = ((date_split[1].length < 2) ? "0" : "") + date_split[1];
        mon = ((date_split[0].length < 2) ? "0" : "") + date_split[0];
        year = date_split[2];
        document.getElementById("entryDate").value = day+"/"+mon+"/"+year;
        document.getElementById("Line_Number").value = "1";
    }else{
        getNextBol();
    }
    $('#showAlert').dialog('close');
}

function getNextBol(){
    var entryDate = readCookie("entrydate");
    var Registry_Number = readCookie("voyageno");
    entryDate = entryDate.substr(6,4)+'-'+entryDate.substr(3,2)+'-'+entryDate.substr(0,2);
    var url = "/emanifest/ManifestServlet?operation=getNextBol"+"&entryDate="+entryDate+"&Registry_Number="+Registry_Number;
    AjaxFunctionManifest(url);
    
}

function populateMyBol(arg){
    resetForm();
    createCookie("serialno",arg,false)
    var url = "/emanifest/ManifestServlet?operation=getMyBol"+"&serialno="+arg;
    AjaxFunctionManifest(url);
}
function populateVoyageNumber(arg){
    document.getElementById("voyageno").value = arg;
    clearVoyageNoLists();
}
function getManifest(){
    var entryDate = readCookie("entrydate");
    var Registry_Number = readCookie("voyageno");
    entryDate = entryDate.substr(6,4)+'-'+entryDate.substr(3,2)+'-'+entryDate.substr(0,2);
    var url = "/emanifest/ManifestServlet?operation=getManifest"+"&entryDate="+entryDate+"&Registry_Number="+Registry_Number;
    AjaxFunctionManifest(url);
    
}

/*function openFeedback(resp){
    var oWin = window.open("showfeedback.jsp?resp="+resp, "_blank", "directories=0,scrollbars=0,resizable=0,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
    
}*/
function callFeedback(url, type){
    var oWin = window.open("showfeedback.jsp?url="+url+"&type="+type, "_blank", "directories=0,scrollbars=0,resizable=0,location=0,status=0,toolbar=0,menubar=0,width=800,height=500,left=100,top=100");
    if (oWin==null || typeof(oWin)=="undefined"){
        alert("Popup must be enabled on this browser to see the report");
    }
}
var containerrow = 1;
var containerflag = 0;
function addContainer(){
    if(containerrow>1){
        var containerref = "containerref"+(containerrow-1);
        if(document.getElementById(containerref).value==null || document.getElementById(containerref).value==""){
            document.getElementById("showError").innerHTML = "<b>Container not added</b><br><br>Please complete the last document before uploading a new one.";
            $('#showError').dialog('open');
            return true;
        }
    }
    containerrow++;
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td style=" color: red">Container Reference</td><td>Container Type</td><td>Container Number</td><td>Sealing Party code</td><td>Empty_Full Indicator</td><td>Marks of Seal1</td><td>Marks of Seal2</td><td>Marks of Seal3</td></tr>';
    var flag=0;
    containerref="";
    var containerrefvalue="";
    var containertype="";
    var containertypevalue="";
    var containernumber="";
    var containernumbervalue="";
    var containerparty="";
    var containerpartyvalue="";
    var containerindicator="";
    var containerindicatorvalue="";
    var containermark1="";
    var containermark1value="";
    var containermark2="";
    var containermark2value="";
    var containermark3="";
    var containermark3value="";

    for(var k=1; k<containerrow; k++){
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
        }
        containerref="containerref"+k;
        containerrefvalue="";
        containertype="containertype"+k;
        containertypevalue="";
        containernumber="containernumber"+k;
        containernumbervalue="";
        containerparty="containerparty"+k;
        containerpartyvalue="";
        containerindicator="containerindicator"+k;
        containerindicatorvalue="";
        containermark1="containermark1"+k;
        containermark1value="";
        containermark2="containermark2"+k;
        containermark2value="";
        containermark3="containermark3"+k;
        containermark3value="";
        if((k<(containerrow-1)) && containerflag>0){
            containerrefvalue = document.getElementById(containerref).value;
            containertypevalue = document.getElementById(containertype).value;
            containernumbervalue = document.getElementById(containernumber).value;
            containerpartyvalue = document.getElementById(containerparty).value;
            containerindicatorvalue = document.getElementById(containerindicator).value;
            containermark1value = document.getElementById(containermark1).value;
            containermark2value = document.getElementById(containermark2).value;
            containermark3value = document.getElementById(containermark3).value;
        }
        containerflag = 1;
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerrefvalue+"' id='"+containerref+"' onblur='this.value=capAdd(this.value)' size='15' /></td>";
        str += "<td width='10%'><input type='text' onkeyup=getAllRecords(this.id,'containers') onclick=getAllRecords(this.id,'containers') onfocus='clearLists();' value='"+containertypevalue+"' id='"+containertype+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containernumbervalue+"' id='"+containernumber+"' onblur='this.value=capAdd(this.value)' size='10' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerpartyvalue+"' id='"+containerparty+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerindicatorvalue+"' id='"+containerindicator+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark1value+"' id='"+containermark1+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark2value+"' id='"+containermark2+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark3value+"' id='"+containermark3+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td><a href=javascript:deleteContainer('"+k+"')>Delete</a></td>";
    }
    str += "</tr></table>";
    document.getElementById('container_content').innerHTML=str;
}

function deleteContainer(arg){
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td style=" color: red">Container Reference</td><td>Container Type</td><td>Container Number</td><td>Sealing Party code</td><td>Empty_Full Indicator</td><td>Marks of Seal1</td><td>Marks of Seal2</td><td>Marks of Seal3</td></tr>';
    var flag=0;
    var containerref="";
    var tempcontainerref="";
    var containerrefvalue="";
    var containertype="";
    var tempcontainertype="";
    var containertypevalue="";
    var containernumber="";
    var tempcontainernumber="";
    var containernumbervalue="";
    var containerparty="";
    var tempcontainerparty="";
    var containerpartyvalue="";
    var containerindicator="";
    var tempcontainerindicator="";
    var containerindicatorvalue="";
    var containermark1="";
    var tempcontainermark1="";
    var containermark1value="";
    var containermark2="";
    var tempcontainermark2="";
    var containermark2value="";
    var containermark3="";
    var tempcontainermark3="";
    var containermark3value="";
    var temp = 0;
    deleteflag = 0;
    for(var k=1; k<containerrow; k++){
        if(k==arg && deleteflag==0){
            deleteflag=1;
            containerrow--;
            k--;
            temp++;
            continue;
        }
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
        }
        containerref="containerref"+k;
        tempcontainerref="containerref"+(k+temp);
        containerrefvalue="";
        containertype="containertype"+k;
        tempcontainertype="containertype"+(k+temp);
        containertypevalue="";
        containernumber="containernumber"+k;
        tempcontainernumber="containernumber"+(k+temp);
        containernumbervalue="";
        containerparty="containerparty"+k;
        tempcontainerparty="containerparty"+(k+temp);
        containerpartyvalue="";
        containerindicator="containerindicator"+k;
        tempcontainerindicator="containerindicator"+(k+temp);
        containerindicatorvalue="";
        containermark1="containermark1"+k;
        tempcontainermark1="containermark1"+(k+temp);
        containermark1value="";
        containermark2="containermark2"+k;
        tempcontainermark2="containermark2"+(k+temp);
        containermark2value="";
        containermark3="containermark3"+k;
        tempcontainermark3="containermark3"+(k+temp);
        containermark3value="";
        if((k<(containerrow))){
            containerrefvalue = document.getElementById(tempcontainerref).value;
            containertypevalue = document.getElementById(tempcontainertype).value;
            containernumbervalue = document.getElementById(tempcontainernumber).value;
            containerpartyvalue = document.getElementById(tempcontainerparty).value;
            containerindicatorvalue = document.getElementById(tempcontainerindicator).value;
            containermark1value = document.getElementById(tempcontainermark1).value;
            containermark2value = document.getElementById(tempcontainermark2).value;
            containermark3value = document.getElementById(tempcontainermark3).value;
        }
        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerrefvalue+"' id='"+containerref+"' onblur='this.value=capAdd(this.value)' size='15' /></td>";
        str += "<td width='10%'><input type='text' onkeyup=getAllRecords(this.id,'containers') onclick=getAllRecords(this.id,'containers') onfocus='clearLists();' value='"+containertypevalue+"' id='"+containertype+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containernumbervalue+"' id='"+containernumber+"' onblur='this.value=capAdd(this.value)' size='10' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerpartyvalue+"' id='"+containerparty+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerindicatorvalue+"' id='"+containerindicator+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark1value+"' id='"+containermark1+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark2value+"' id='"+containermark2+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark3value+"' id='"+containermark3+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td><a href=javascript:deleteContainer('"+k+"')>Delete</a></td>";
    }
    str += "</tr></table>";
    document.getElementById('container_content').innerHTML=str;
}

function populateContainer(arg){
    var row_split = arg.split('@@@');
    var str = "<table style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
    str += "<tr style='font-weight:bold; color:white'>";
    str += '<td>S/No</td><td style=" color: red">Container Reference</td><td>Container Type</td><td>Container Number</td><td>Sealing Party code</td><td>Empty_Full Indicator</td><td>Marks of Seal1</td><td>Marks of Seal2</td><td>Marks of Seal3</td></tr>';
    var flag=0;
    var containerref="";
    var containerrefvalue="";
    var containertype="";
    var containertypevalue="";
    var containernumber="";
    var containernumbervalue="";
    var containerparty="";
    var containerpartyvalue="";
    var containerindicator="";
    var containerindicatorvalue="";
    var containermark1="";
    var containermark1value="";
    var containermark2="";
    var containermark2value="";
    var containermark3="";
    var containermark3value="";
    containerrow = 1;
    var col_split = "";
    for(var k=1; k<row_split.length; k++){
        col_split = row_split[k].split('~_~');
        if(flag==0){
            str += "<tr style='font-weight:bold; color:#999999;background-color:#FFFFFF;'>";
        }else{
            str += "<tr style='font-weight:bold; color:#FFFFFF;background-color:#999999;'>";
        }
        containerref="containerref"+k;
        containerrefvalue=col_split[0];
        containertype="containertype"+k;
        containertypevalue=col_split[1];
        containernumber="containernumber"+k;
        containernumbervalue=col_split[2];
        containerparty="containerparty"+k;
        containerpartyvalue=col_split[3];
        containerindicator="containerindicator"+k;
        containerindicatorvalue=col_split[4];
        containermark1="containermark1"+k;
        containermark1value=col_split[5];
        containermark2="containermark2"+k;
        containermark2value=col_split[6];
        containermark3="containermark3"+k;
        containermark3value=col_split[7];
        containerrow++;

        str += "<td width='5%' align='right'>"+k+".</td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerrefvalue+"' id='"+containerref+"' onblur='this.value=capAdd(this.value)' size='15' /></td>";
        str += "<td width='10%'><input type='text' onkeyup=getAllRecords(this.id,'containers') onclick=getAllRecords(this.id,'containers') onfocus='clearLists();' value='"+containertypevalue+"' id='"+containertype+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containernumbervalue+"' id='"+containernumber+"' onblur='this.value=capAdd(this.value)' size='10' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerpartyvalue+"' id='"+containerparty+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containerindicatorvalue+"' id='"+containerindicator+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark1value+"' id='"+containermark1+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark2value+"' id='"+containermark2+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td width='10%'><input type='text' onfocus='clearLists();' value='"+containermark3value+"' id='"+containermark3+"' onblur='this.value=capAdd(this.value)' size='5' /></td>";
        str += "<td><a href=javascript:deleteContainer('"+k+"')>Delete</a></td>";
    }
    str += "</tr></table>";
    document.getElementById('container_content').innerHTML=str;
    containerflag = 1;
}

function toDate(){
    displayDatePicker('todate', false, 'dmy', '/');
}

function fromDate(){
    displayDatePicker('fromdate', false, 'dmy', '/');
}

var xmlhttp

function AjaxFunctionManifest(arg){
    xmlhttp=GetXmlHttpObject();
    if(xmlhttp == null){
        alert ("Your browser does not support XMLHTTP!");
        return true;
    }

    var timestamp = new Date().getTime();
    var url = arg+"&timestamp="+timestamp;

    xmlhttp.onreadystatechange=statechangedsetup;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
    
}

function statechangedsetup(){
    if (xmlhttp.readyState==4){
        var resp = xmlhttp.responseText;
        //alert(resp);
        var break_resp = "";
        $('#showAlert').dialog('close');
        if(resp.match("uploadXMLnofile")){
            document.getElementById("showPrompt").innerHTML = "<b>No XML Files Found!!!</b><br><br>Your XML files are not yet generated<br><br>Please generate the XML files and try again.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            return true;
        }
        if(resp.match("uploadXMLsuccess")){
            document.getElementById("showPrompt").innerHTML = "<b>XML Files Uploaded!!!</b><br><br>Your XML files are successfully Uploaded<br><br>Check your response folders for your rotation number.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            return true;
        }
        if(resp.match("uploadXMLfailed")){
            document.getElementById("showPrompt").innerHTML = "<b>XML Files not Uploaded!!!</b><br><br>Your XML files are not Uploaded<br><br>Please ensure that your internet speed is quite good and your VPN is connected.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            return true;
        }
        if(resp.match("generateXMLsuccess")){
            document.getElementById("showPrompt").innerHTML = "<b>XML Files Generated!!!</b><br><br>Your XML files are successfully generated.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            $('#details').dialog('close');
            $('#listings').dialog('open');
            return true;
        }
        if(resp.match("generateXMLfailed")){
            document.getElementById("showPrompt").innerHTML = "<b>XML Files not Generated!!!</b><br><br>Your XML files are not generated<br><br>Check your dates and voyage number.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            $('#details').dialog('close');
            $('#listings').dialog('open');
            return true;
        }
        if(resp.match("nofeedback")){
            document.getElementById("showPrompt").innerHTML = "<b>Sorry, no Feedback generated yet!!!</b><br><br>No Feedback is found for the specified dates and voyage number<br><br>Please ensure that the specified date range covers the departure date of the manifest and the correct voyage number is picked.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            return true;
        }
        if(resp.match("checkFeedBack")){
            break_resp = resp.split("checkFeedBack");
            break_row = break_resp[1].split("_~_");
            var feedback = document.getElementById("feedback");
            var count = 1;
            var str = "<table><tr><td colspan='3'><h3> Please pick your feedback from the following:</h3></td></tr>";
            for(var k=0; k < break_row.length-1; k++){
                var break_col = break_row[k].split("~_~");
                var filename = break_col[1].replace(/\\/g,'/');
                ;
                //alert('2 '+filename);
                str += "<tr><td align='right'>" + count++ +".</td><td>" + break_col[0] + "</td><td>" + filename + "</td>";
                str += "<td><a href=javascript:callFeedback('" + filename + "','html')>HTML</a>&nbsp;";
                str += "&nbsp;<a href=javascript:callFeedback('" + filename + "','xml')>XML</a></td></tr>";
            }
            feedback.innerHTML = str;
            $('#showError').dialog('open');
            $('#feedback').dialog('open');
            $('#showError').dialog('close');
            return true;
        }

        if(resp.match("getXMLObject")){
            break_resp = resp.split("getXMLObject");
            openFeedback(break_resp[1]);
        }
        
        if(resp.match("getManifest")){
            break_resp = resp.split("getManifest");
            break_row = break_resp[1].split("_~_");
            document.getElementById("Registry_Number").value = break_row[12];
            if(break_row[12]!=null && break_row[12]!="") document.getElementById("Registry_Number").disabled=true;
            document.getElementById("Departure_Date").value = break_row[15];
            document.getElementById("Departure_Date").value = break_row[15];
            document.getElementById("Customs_Office_Code").value = break_row[3];
            document.getElementById("Master_Information").value = break_row[4];
            document.getElementById("Last_Discharge_Date").value = break_row[18];
            document.getElementById("Date_of_Arrival").value = break_row[14];
            document.getElementById("Time_of_Arrival").value = break_row[13];
            document.getElementById("Place_of_Departure_Code").value = break_row[8];
            document.getElementById("Place_of_Destination_Code").value = break_row[9];
            document.getElementById("Carrier_Code").value = break_row[1];
            document.getElementById("Carrier_Name").value = break_row[2];
            document.getElementById("Carrier_Address").value = break_row[0];
            document.getElementById("Name_of_Transporter").value = break_row[6];
            document.getElementById("Place_of_Transporter").value = break_row[10];
            document.getElementById("Mode_of_Transport_Code").value = break_row[5];
            document.getElementById("Nationality_of_Transporter_Code").value = break_row[7];
            document.getElementById("Registration_Number").value = break_row[11];
            document.getElementById("Registration_Date").value = break_row[20];
            document.getElementById("Gross_Tonnage").value = break_row[17];
            document.getElementById("Net_Tonnage").value = break_row[19];
            document.getElementById("entryDate").value = break_row[16];

            $('#listings').dialog('close');
            $('#details').dialog('open');
            return true;
        }

        if(resp.match("getNextBol")){
            break_resp = resp.split("getNextBol");
            document.getElementById("Line_Number").value = break_resp[1];
            getManifest();
            return true;
        }
        if(resp.match("getVoyageno")){
            break_resp = resp.split("getVoyageno");
            if(curr_obj == "generateXMLs"){
                document.getElementById("fromdate").value = readCookie("fromdate");
                document.getElementById("todate").value = readCookie("todate");
                document.getElementById("voyageno").value = break_resp[1];
                curr_obj = "";
            }else{
                curr_obj = "";
                var bolheader = "<table border='0' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
                bolheader += "<tr style='font-weight:bold; color:white'>";
                bolheader += "<td align='right'>From:</td><td align='left'><input type='text' id='fromdate' name='fromdate' size='10' onclick='javascript:fromDate();' /></td>";
                bolheader += "<td align='right'>To:</td><td align='left'><input type='text' id='todate' name='todate' size='10' onclick='javascript:toDate();' /></td>";
                //bolheader += '<td align="right">Vessel Name:</td><td align="left"><input type="text" id="vesselname" size="15" onkeyup="getVesselname()" onfocus="getVesselname()"></td>';
                bolheader += '<td align="right">Voyage Number:</td><td align="left"><input type="text" id="voyageno" size="15" onkeyup="getMyVoyagenos()" onfocus="getMyVoyagenos()"></td>';
                bolheader += "<td align='center'><input type='button' id='filterbutton' onclick='getBols(this.id)' value='List Records' /></td></tr></table>";
                var bollistheader = document.getElementById('bollistheader');
                bollistheader.innerHTML = bolheader;
                document.getElementById("fromdate").value = readCookie("fromdate");
                document.getElementById("todate").value = readCookie("todate");
                document.getElementById("voyageno").value = break_resp[1];
                createCookie("voyageno", break_resp[1], false);
                createCookie("entrydate", readCookie("fromdate"), false);
                if(break_resp[1].length==0){
                    document.getElementById("voyageno").value = "new";
                }
                getBols("filterbutton");
            }
            return true;
        }

        if(resp.match("getAllBols")){
            break_resp = resp.split("getAllBols");
            bolheader = "<table border='0' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
            bolheader += "<tr style='font-weight:bold; color:white'>";
            bolheader += "<td align='right'>From:</td><td align='left'><input type='text' id='fromdate' name='fromdate' size='10' onclick='javascript:fromDate();' /></td>";
            bolheader += "<td align='right'>To:</td><td align='left'><input type='text' id='todate' name='todate' size='10' onclick='javascript:toDate();' /></td>";
            //bolheader += '<td align="right">Vessel Name:</td><td align="left"><input type="text" id="vesselname" size="15" onkeyup="getVesselname()" onfocus="getVesselname()"></td>';
            bolheader += '<td align="right">Voyage Number:</td>';
            bolheader += '<td align="left"><input type="text" id="voyageno" size="15" onkeyup="getMyVoyagenos()" onfocus="getMyVoyagenos()"></td>';
            bolheader += "<td align='center'><input type='button' id='filterbutton' onclick='getBols(this.id)' value='List Records' /></td></tr></table>";
            bollistheader = document.getElementById('bollistheader');
            bollistheader.innerHTML = bolheader;

            var allbols = "<table border='1' style='font-size:12px; border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
            allbols += "<tr style='font-weight:bold; color:white'>";
            allbols += "<td>S/No</td><td>Line No</td><td>BOL Ref.</td><td>Exporter</td><td>Consignee</td><td>Voyage No</td><td>Vessel Name</td>";
            allbols += "<td>Loading Port</td><td>Unloading Port</td><td>Departure Date</td><td>Arrival Date</td><td>Customs Office</td></tr>";
            var bollist = document.getElementById('bollist');
            bollist.innerHTML = allbols+break_resp[1]+"</table>";
            if(readCookie("fromdate") != null) document.getElementById("fromdate").value = readCookie("fromdate");
            if(readCookie("todate") != null) document.getElementById("todate").value = readCookie("todate");

            if(resp=="getAllBolsgetAllBols"){
                createCookie("voyageno","",false);
                if(document.getElementById("voyageno").value!=null && document.getElementById("voyageno").value!=""){
                    $('#showAlert').dialog('close');
                    document.getElementById("showPrompt").innerHTML = "<b>Invalid dates/voyage number</b><br><br>Check your dates and voyage number.";
                    $('#showPrompt').dialog('open');
                }
            }else{
                if(readCookie("voyageno") != null) document.getElementById("voyageno").value = readCookie("voyageno");
                createCookie("entrydate",break_resp[2],false);
            }
            return true;
        }

        if(resp.match("getAllVoyagenos")){
            var keyword = curr_obj.value;
            var allCodes = resp.split("getAllVoyagenos");
            var inner_voyagenolist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
            inner_voyagenolist += "<tr style='font-weight:bold; color:white'>";
            inner_voyagenolist += "<td>S/No</td><td>Voyage No</td><td>Vessel Name</td><td>Entry Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td align='right'><a title='Close' style='font-weight:bold; font-size:20px; color:white;background-color:red;' href=javascript:clearVoyageNoLists()>X</a></td></tr>";

            var voyagenolist = document.getElementById('voyagenolist');
            voyagenolist.style.zIndex = 1000;
            voyagenolist.style.position = "absolute";
            /*voyagenolist.style.top = (findPosY(curr_obj) - 120 + curr_obj.clientHeight) + 'px';
            voyagenolist.style.left = (findPosX(curr_obj) - 10) + 'px';
            if(navigator.appName=="Microsoft Internet Explorer"){
                //var height = $(window).height()/2;
                //var width = $(document).width()/2;
                voyagenolist.style.top = '200px';
                voyagenolist.style.left ='200px';
                voyagenolist.style.top = (findPosY(curr_obj) - 80 + curr_obj.clientHeight) + 'px';
                voyagenolist.style.left = (findPosX(curr_obj) - 10) + 'px';
            }else{
                voyagenolist.style.top = ($(curr_obj).position().top + 23) + 'px';
                voyagenolist.style.left = ($(curr_obj).position().left) + 'px';
            }*/
            voyagenolist.style.top = ($(curr_obj).position().top + 23) + 'px';
            voyagenolist.style.left = ($(curr_obj).position().left) + 'px';
            var token = "";
            var colorflag = 0;
            var k=0;
            if(keyword.trim().length==0){
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0){
                        token = allCodes[k].split("_~_");
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_voyagenolist += "<tr style='background-color:#CCCCCC;'><td align='right'>"+token[0]+".</td><td><a href=javascript:populateVoyageNumber('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>"+token[3]+"</td><td>&nbsp;</td></tr>";
                        } else {
                            colorflag = 0;
                            inner_voyagenolist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'><td align='right'>"+token[0]+".</td><td><a href=javascript:populateVoyageNumber('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>"+token[3]+"</td><td>&nbsp;</td></tr>";
                        }
                    }
                }
            } else {
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0 && (allCodes[k].toUpperCase().match(keyword.toUpperCase()))){
                        token = allCodes[k].split("_~_");
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_voyagenolist += "<tr style='background-color:#CCCCCC;'><td align='right'>"+token[0]+".</td><td><a href=javascript:populateVoyageNumber('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>"+token[3]+"</td><td>&nbsp;</td></tr>";
                        } else {
                            colorflag = 0;
                            inner_voyagenolist += "<tr style='background-color:#FFFFFF;color:#CCCCCC'><td align='right'>"+token[0]+".</td><td><a href=javascript:populateVoyageNumber('"+token[1]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>"+token[3]+"</td><td>&nbsp;</td></tr>";
                        }
                    }
                }
            }
            inner_voyagenolist += "</table>";
            voyagenolist.style.zIndex = 100;
            voyagenolist.innerHTML = "";
            voyagenolist.innerHTML = inner_voyagenolist;
            return true;
        }
        if(resp.match("getMyBol")){
            break_resp = resp.split("getMyBol");
            var break_row = break_resp[1].split("_~_");
            document.getElementById("Bol_Nature").value = break_row[0];
            document.getElementById("Bol_Reference").value = break_row[1];
            document.getElementById("BOL_Type_Code").value = break_row[2];
            document.getElementById("Consignee_Address").value = break_row[3];
            document.getElementById("Consignee_Code").value = break_row[4];
            document.getElementById("Consignee_Name").value = break_row[5];
            document.getElementById("Exporter_Address").value = break_row[6];
            document.getElementById("Exporter_Code").value = break_row[7];
            document.getElementById("Exporter_Name").value = break_row[8];
            document.getElementById("General_Information").value = break_row[9];
            document.getElementById("Goods_Description").value = break_row[10];
            document.getElementById("Location_Code").value = break_row[11];
            document.getElementById("Location_Information").value = break_row[12];
            document.getElementById("Marks_of_Seals").value = break_row[13];
            document.getElementById("Notify_Address").value = break_row[14];
            document.getElementById("Notify_Code").value = break_row[15];
            document.getElementById("Notify_Name").value = break_row[16];
            document.getElementById("Package_Type_Code").value = break_row[17];
            document.getElementById("Previous_Document_Reference").value = break_row[18];
            document.getElementById("Sealing_Party_Code").value = break_row[19];
            document.getElementById("Shipping_Marks").value = break_row[20];
            document.getElementById("Unique_Carrier_Reference").value = break_row[21];
            document.getElementById("Line_Number").value = break_row[22];
            document.getElementById("Number_of_Packages").value = break_row[23];
            document.getElementById("Number_of_Seals").value = break_row[24];
            document.getElementById("Total_Gross_Mass_Manifested").value = break_row[25];
            document.getElementById("Volume_in_Cubic_Meters").value = break_row[26];
            createCookie("voyageno",break_row[27],false);
            createCookie("entrydate",break_row[28],false);
            if(break_row[29]!=null && break_row[29] != "") populateContainer(break_row[29]);
            getManifest();
            return true;
        }

        if(resp.match("getAllRecords")){
            keyword = curr_obj.value;
            allCodes = resp.split("getAllRecords");
            var inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
            if(navigator.appName == "Microsoft Internet Explorer"){
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:30%;background-color:#6666FF;margin-top:5px;'>";
            }else{
                inner_codeslist = "<table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>";
            }
            inner_codeslist += "<tr style='font-weight:bold; color:white'>";
            inner_codeslist += "<td>S/No</td><td>Codes</td><td>Description&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td align='right'><a title='Close' style='font-weight:bold; font-size:20px; color:white;background-color:red;' href=javascript:clearLists()>X</a></td></tr>";

            var codeslist = document.getElementById('codeslist');
            codeslist.style.zIndex = 100;
            codeslist.style.position = "absolute";

            //codeslist.style.top = (findPosY(curr_obj) - 120 + curr_obj.clientHeight) + 'px';
            //codeslist.style.left = (findPosX(curr_obj) - 35) + 'px';
            //codeslist.style.top = ($(curr_obj).position().top + 23) + 'px';
            //codeslist.style.left = ($(curr_obj).position().left) + 'px';
            if(navigator.appName=="Microsoft Internet Explorer"){
                //var height = $(window).height()/2;
                //var width = $(document).width()/2;
                codeslist.style.top = '200px';
                codeslist.style.left ='200px';
                codeslist.style.top = (findPosY(curr_obj) - 80 + curr_obj.clientHeight) + 'px';
                codeslist.style.left = (findPosX(curr_obj) - 30) + 'px';
            }else{
                codeslist.style.top = ($(curr_obj).position().top + 23) + 'px';
                codeslist.style.left = ($(curr_obj).position().left) + 'px';
            }
            //codeslist.style.top = ($(curr_obj).position().top + 104) + 'px';
            //codeslist.style.left = ($(curr_obj).position().left + 35) + 'px';
                codeslist.style.top = '50px';
                codeslist.style.left ='650px';

            token = "";
            colorflag = 0;
            k=0;
            if(keyword.trim().length==0){
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0){
                        token = allCodes[k].split("_~_");
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;'><td align='right'>"+k+".</td><td><a href=javascript:populateCode('"+token[0]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;'><td align='right'>"+k+".</td><td><a href=javascript:populateCode('"+token[0]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
                        }
                    }
                }
            } else {
                for(k=0; k<allCodes.length; k++){
                    if(allCodes[k].trim().length>0 && (allCodes[k].toUpperCase().match(keyword.toUpperCase()))){
                        token = allCodes[k].split("_~_");
                        if(colorflag == 0){
                            colorflag = 1;
                            inner_codeslist += "<tr style='background-color:#CCCCCC;'><td align='right'>"+k+".</td><td><a href=javascript:populateCode('"+token[0]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
                        } else {
                            colorflag = 0;
                            inner_codeslist += "<tr style='background-color:#FFFFFF;'><td align='right'>"+k+".</td><td><a href=javascript:populateCode('"+token[0]+"')>"+token[1]+"</a></td><td>"+token[2]+"</td><td>&nbsp;</td></tr>";
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
            break_resp = resp.split("getARecord");
            curr_obj.value = break_resp[2];
            if(curr_id=="Carrier_Code"){
                document.getElementById("Carrier_Name").value = break_resp[3];
                document.getElementById("Carrier_Address").value = break_resp[4];
            }
            clearLists();
        }

        /*if(resp.match("getAManifest")){
            break_resp = resp.split("getAManifest");
            createCookie("serialno",break_resp[1],false)
            if(break_resp[0]=="xml"){
                document.getElementById("manifest").value = break_resp[2];
                document.getElementById("bol").value = break_resp[3];
                document.getElementById("reg").value = break_resp[4];
            }
            if(break_resp[0]=="bols"){
                document.getElementById("bolcode").value = break_resp[2];
                document.getElementById("boldescription").value = break_resp[3];
            }
            if(break_resp[0]=="carriers"){
                document.getElementById("carriercode").value = break_resp[2];
                document.getElementById("carriername").value = break_resp[3];
                document.getElementById("carrieraddress").value = break_resp[4];
            }
            if(break_resp[0]=="customs"){
                document.getElementById("customcode").value = break_resp[2];
                document.getElementById("customdescription").value = break_resp[3];
            }
            if(break_resp[0]=="nations"){
                document.getElementById("nationcode").value = break_resp[2];
                document.getElementById("nationdescription").value = break_resp[3];
            }
            if(break_resp[0]=="containers"){
                document.getElementById("containercode").value = break_resp[2];
                document.getElementById("containerdescription").value = break_resp[3];
            }
            if(break_resp[0]=="packages"){
                document.getElementById("packagecode").value = break_resp[2];
                document.getElementById("packagedescription").value = break_resp[3];
            }
            if(break_resp[0]=="ports"){
                document.getElementById("portcode").value = break_resp[2];
                document.getElementById("portdescription").value = break_resp[3];
            }
            if(break_resp[0]=="transports"){
                document.getElementById("transportcode").value = break_resp[2];
                document.getElementById("transportdescription").value = break_resp[3];
            }
            return true;
        }*/


        if(resp.match("added")){
            //break_resp = resp.split("added");
            //getRecords(break_resp[0]+"s");
            //resetForm();
            document.getElementById("showPrompt").innerHTML = "<b>Record Added!!!</b><br><br>Your record was successfully added.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            $('#details').dialog('close');
            $('#listings').dialog('open');
            getBols("filterbutton");
            return true;
        }

        if(resp.match("updated")){
            //break_resp = resp.split("updated");
            //getRecords(break_resp[0]+"s");
            //resetForm();
            document.getElementById("showPrompt").innerHTML = "<b>Record Updated!!!</b><br><br>Your record was successfully updated.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            $('#details').dialog('close');
            $('#listings').dialog('open');
            getBols("filterbutton");
            return true;
        }

        if(resp.match("deleted")){
            //break_resp = resp.split("deleted");
            //getRecords(break_resp[0]+"s");
            //resetForm();
            document.getElementById("showPrompt").innerHTML = "<b>Record Deleted!!!</b><br><br>Your record was successfully deleted.";
            $('#showError').dialog('open');
            $('#showPrompt').dialog('open');
            $('#showError').dialog('close');
            $('#details').dialog('close');
            $('#listings').dialog('open');
            getBols("filterbutton");
            return true;
        }

        if(resp.match("bolexists")){
            document.getElementById("showError").innerHTML = "<b>Code Exists!!!</b><br><br>Bill of Lading already exists.";
            $('#showError').dialog('open');
            return true;
        }

        if(resp.match("bolnotexist")){
            document.getElementById("showError").innerHTML = "<b>Code Not Existing!!!</b><br><br>Bill of Lading does not exist.";
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
