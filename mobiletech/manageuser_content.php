<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>MobileTech Portal Systems</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link rel="stylesheet" href="css/jquery-ui-1.8.4.custom.css" type="text/css">
        <link href="css/calendar.css" rel="stylesheet" type="text/css"/>
        <link href="css/jqueryFileTree.css" rel="stylesheet" type="text/css"/>

        <script type='text/javascript' src='js/utilities.js'></script>
        <script type='text/javascript' src='js/calendar.js'></script>
        <script type='text/javascript' src='js/jqueryFileTree.js'></script>
        <script type="text/javascript" src="js/jquery.ui.core.js"></script>
        <script type="text/javascript" src="js/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="js/jquery.ui.accordion.js"></script>
        <script type='text/javascript' src='js/users.js'></script>

        <style type="text/css">
            body { font-size: 60%; }
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px; }
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }

        </style>
        <script type="text/javascript">
            $(function() {
                // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
                $("#dialog").dialog("destroy");

                $("#showPrompt").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Alert!!!',
                    height: 300,
                    width: 350,
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

                $("#menuList").dialog({
                    autoOpen: true,
                    position:'center',
                    title: 'User Management Menu',
                    height: 350,
                    width: 350,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#menuList').dialog('close');
                        }
                    }
                });

                $("#register").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Manage Users',
                    height: 500,
                    width: 800,
                    modal: false,
                    buttons: {
                        Save: function() {
                            var reg = registerForm('insertUser');
                            if(reg.length>0){
                                $('#showAlert').dialog('close');
                                document.getElementById("showError").innerHTML = reg;
                                $('#showError').dialog('open');
                            }
                        },
                        Update: function() {
                            var reg = registerForm('updateUser');
                            if(reg.length>0){
                                $('#showAlert').dialog('close');
                                document.getElementById("showError").innerHTML = reg;
                                $('#showError').dialog('open');
                            }
                        },
                        New: function() {
                            document.getElementById("username").disabled = false;
                            clearRegisterForm();
                        },
                        Close: function() {
                            $('#register').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

                $("#menuaccess").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'User Access Menu',
                    height: 600,
                    width: 550,
                    modal: false,
                    buttons: {
                        Close: function() {
                            $('#menuaccess').dialog('close');
                        }
                    }
                });

                $("#changepass").dialog({
                    autoOpen: false,
                    position:'center',
                    title: 'Change Users Password',
                    height: 450,
                    width: 600,
                    modal: false,
                    buttons: {
                        Change_Password: function() {
                            var reg = changePass();
                            if(reg.length>0){
                                $('#showAlert').dialog('close');
                                document.getElementById("showError").innerHTML = reg;
                                $('#showError').dialog('open');
                            }
                        },
                        Clear: function() {
                            clearPassForm();
                        },
                        Close: function() {
                            $('#changepass').dialog('close');
                            $('#menuList').dialog('open');
                        }
                    }
                });

            });
            
        </script>
    </head>
    <body>
        <div id="container_id" style="height:250px; overflow:auto;"></div>
        <div id="showError"></div>
        <div id="showPrompt"></div>
        <div id="showAlert"></div>
        <div id="menuList">
            <h5><a href="javascript: checkAccess('getRegister()', 'Manage Users');">Manage Users</a></h5>
            <h5><a href="javascript: checkAccess('doUsersMenu()', 'Users Access Control');">Users Access Control</a></h5>
            <h5><a href="javascript: getPassword();">Change Users Password</a></h5>
        </div>

        <div id="register">
            <table style="width:380px">
                <tr class="formLabel">
                    <td><b>User Name:</b></td>
                    <!-- UserName -->
                    <td class="input">
                        <input type="text" id="username" name="username" size="30" />
                    </td>
                </tr>

                <tr class="formLabel">
                    <td><b>First Name:</b></td>
                    <!-- FirstName -->
                    <td class="input">
                        <input type="text" id="firstname" name="firstname" onblur="this.value=capAdd(this.value);" size="20" />
                    </td>
                </tr>

                <tr class="formLabel">
                    <td><b>Last Name:</b></td>
                    <!-- LastName -->
                    <td class="input">
                        <input type="text" id="lastname" name="lastname" onblur="this.value=capAdd(this.value);" size="20" />
                    </td>
                </tr>

                <tr class="formLabel">
                    <td><b>Active:</b></td>
                    <td class="input">
                        <select id="selectactive" name="selectactive" class="textField" >
                            <option></option>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                    </td>
                </tr>

            </table>
            <div id="userlist" style="height:250px; max-width:795px; overflow:auto;"></div>
        </div>

        <div id="menuaccess">
            <table width="100%">
                <tr>
                    <td>
                        <div id="menulistheader">
                            <table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>
                                <tr style='font-weight:bold; color:white'>
                                    <td>
                                        User Name:&nbsp;<input type="text" id="currentuser" style="display:inline" name="currentuser" size="25" onkeyup="getRecordlist(this.id,'userlist2')" onclick="getRecordlist(this.id,'userlist2')">
                                    </td>
                                    <td>
                                        <input type='button' id="filterbutton" style="display:inline" onclick='getUsersMenu(this.id)' value='List Menus' />
                                    </td>
                                </tr>
                            </table>
                            <div id="userlist2"></div>
                        </div>
                        <div id="menulistheader2">
                            <table border='1' style='border-color:#fff;border-style:solid;border-width:1px; height:10px;width:100%;background-color:#6666FF;margin-top:5px;'>
                                <tr style='font-weight:bold; color:white'>
                                    <td width='5%' align='right'>S/No</td>
                                    <td width='30%'>Menu Item</td>
                                    <td width='5%'>Accessible</td></tr>
                            </table>
                        </div>
                        <div id="menulist2" style="height:418px; max-width:550px; overflow:auto; border-top:3px solid #6600FF;border-left:3px solid #6600FF;border-bottom:3px solid #6600FF;border-right:3px solid #6600FF;background-color:#ddd;"></div>
                    </td>
                </tr>
            </table>
        </div>

        <div id="changepass">
            <table style="width:550px;">
                <tr class="formLabel">
                    <td width="30%"><b>User Name:</b></td>
                    <!-- UserName -->
                    <td width="70%" class="input">
                        <input type="text" id="username2" name="username2" size="27" disabled="true" readonly class="textField" />
                    </td>
                </tr>

                <tr class="formLabel">
                    <td width="30%"><b>First Name:</b></td>
                    <!-- FirstName -->
                    <td width="70%" class="input">
                        <input type="text" id="firstname2" name="firstname2" disabled="true" readonly size="20" />
                    </td>
                </tr>

                <tr class="formLabel">
                    <td width="30%"><b>Last Name:</b></td>
                    <!-- LastName -->
                    <td width="70%" class="input">
                        <input type="text" id="lastname2" name="lastname2" disabled="true" readonly size="20" />
                    </td>
                </tr>

                <tr class="formLabel">
                    <td width="30%"><b>Old Password:</b></td>
                    <!-- Password -->
                    <td width="70%" class="input">
                        <input type="password" id="password" name="password" size="20" maxlength=20 class="textField" />
                    </td>
                </tr>
                <tr class="formLabel">
                    <td width="30%"><b>New Password:</b></td>
                    <!-- Password -->
                    <td width="70%" class="input">
                        <input type="password" id="newpassword" name="newpassword" size="20" maxlength=20 class="textField" />
                    </td>
                </tr>
                <tr class="formLabel">
                    <td width="30%"><b>Repeat New Password:</b></td>
                    <!-- Password -->
                    <td width="70%" class="input">
                        <input type="password" id="rptpassword" name="rptpassword" size="20" maxlength=20 onkeypress="checkEnter(event)" class="textField" />
                    </td>
                </tr>
            </table>
        </div>

    </body>
</html>
