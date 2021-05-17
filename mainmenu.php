	<link rel="stylesheet" href="css_JQuery_Menu/lavalamp_test.css" type="text/css" media="screen" />

	<script type="text/javascript" src="js_JQuery_Menu/ui.core.min.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/effects.core.min.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/jquery.scrollTo.min.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/jquery.fancybox-1.2.6.pack.js"></script>

	<script type="text/javascript" src="js_JQuery_Menu/jquery.lavalamp.min.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/facebox.min.js"></script>

	<script type="text/javascript" src="js_JQuery_Menu/jquery.cookie.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/jquery.lazyload.js"></script>

	<script type="text/javascript" src="js_JQuery_Menu/shCore.min.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/shBrushJScript.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/shBrushPhp.js"></script>
	<script type="text/javascript" src="js_JQuery_Menu/shBrushCss.js"></script>

	<script type="text/javascript" src="js_JQuery_Menu/shBrushXml.js"></script>
        <script type='text/javascript' src='js/manifest.js'></script>
        
	<script type="text/javascript">
		$(function() {
			$("img").lazyload({
				placeholder : "/pic/layout/transp.gif",
				effect      : "fadeIn"
			});
		});

		SyntaxHighlighter.all();
		$(window).load(function () {
			$("#lavalampMenu").lavaLamp({
				fx: "easeOutBack",
				speed: 750,
				click: function(event, menuItem) {

				}
			});
			subNavi();
			if (document.location.hash){
				setTimeout(function(){
					$(window).scrollTo(document.location.hash,{
						duration: 500
					});
				},500);
			}
		});
	</script>

	<DIV style="height: 30px; width: 1100px; background-color:#33c; border-top:1px solid #999; border-left:1px solid #999; border-right:2px solid #666; border-bottom:2px solid #666;">
		<ul class="lavaLampNoImageZoom" id="lavalampMenu">
			<li><a href="home.php">Home</a></li>
			<li><a href="setup.php">Setup</a></li>
			<li><a href="dataentry.php">Data Entry/Report</a></li>
			<li><a href="manageusers.php">Users</a></li>
			<li><a href="javascript: logout()">Logout</a></li>
		</ul>
	</DIV>
<div id="welcomeuser" style="display:inline; color:blue; font-style:italic; font-size:30px; height: 30px;"></div>
<script type="text/javascript">
    var welcomeuser = document.getElementById("welcomeuser");
    welcomeuser.innerHTML = "<b>Welcome "+readCookie("currentfirstname")+"</b>";
</script>

