<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <!-- uncomment 'base' to view this page without external files
		<base href="http://jquery-border-layout.googlecode.com/svn/trunk/" />
		-->

        <title>Lagos State Polytechnic Portal Systems</title>

        <!-- DEMO styles - specific to this page -->
        <link rel="stylesheet" type="text/css" href="css/complex.css" />
        <!--[if lte IE 7]>
			<style type="text/css"> body { font-size: 85%; } </style>
		<![endif]-->

        <script type="text/javascript" src="js/jquery-latest.js"></script>
        <script type="text/javascript" src="js/jquery-ui-latest.js"></script>
        <script type="text/javascript" src="js/jquery.layout-latest.js"></script>
        <script type="text/javascript" src="js/complex.js"></script>
        <script type="text/javascript" src="js/utilities.js"></script>

        <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" />
        <link href="css/mycss.css" rel="stylesheet" type="text/css"/>
        <link href="css/emsportal.css" rel="stylesheet" type="text/css"/>
        <!--[if IE]> <style type="text/css">@import "css/IE-override.css";</style> <![endif]-->
        <style type="text/css">
            body { font-size: 55%; }
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
            checkLogin();
        </script>
    </head>
    <body onload="javascript: checkLogin()">
        <div class="ui-layout-north">
            <div align="center">
                <img src="images/SCHOOBanner.PNG" width="100%" height="35%" title="Lagos State Polytechnic Logo" alt="Lagos State Polytechnic Portal Logo"/>
				<?php include("mainmenu.php"); ?> 
            </div>
        </div>


        <div class="ui-layout-west">
			<!--div class="header"><b>The Menu</b></div>
			<div class="content">
				<!%@ include file="menupane.jsp" %>
			</div>

			<div class="footer"><b>*** Mouseover to Show Menu ***</b></div-->

		</div>


        <div class="ui-layout-east">

			<!--div class="header"><b>News Ticker</b></div>

			<div id="subhead" class="subhead" align="center"><b>*** Mouseover pauses scrolling ***</b></div>


			<div id="content" class="content">
				<!%@ include file="newsticker.jsp" %>
			</div>
			<div id="footer" class="footer" align="center"><b>*** Mouseout continues scrolling ***</b></div-->
		</div>
        <div id="mainContent">
            <div class="ui-layout-center">
				<?php include("setup_content.php"); ?> 
            </div>
        </div>



        <div class="ui-layout-south">
            <div class="footer_container" id="footer_container">
                <div class="footer_left">
                    <div style="display:inline;text-align:center">
                        &#169;&nbsp;Copyright 2009&nbsp;<a href="" target="_blank">Immaculate High-Tech Systems Ltd.</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
