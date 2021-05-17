<link rel="stylesheet" href="css/menu.css" />
	
<script type="text/javascript" src="js/chili-1.7.pack.js"></script>
<script type="text/javascript" src="js/jquery.easing.js"></script>
<script type="text/javascript" src="js/jquery.dimensions.js"></script>
<script type="text/javascript" src="js/jquery.accordion.js"></script>
<script type='text/javascript' src='js/dataentry.js'></script>
<script type="text/javascript" src="js/utilities.js"></script>
<script type="text/javascript">
	jQuery().ready(function(){
  		jQuery('#navigation').accordion({ 
		    active: false, 
			header: '.head', 
			navigation: true, 
			event: 'click', 
			fillSpace: true, 
			animated: 'bounceslide' 
		});
	});
	
</script>

<ul id="navigation">
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Setup</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('schoolinformation.php', 'Institution Information');">&nbsp;&nbsp;&nbsp;&nbsp;- Institution's Information</a>
			</li>
			<li>
				<a href="javascript: checkAccess('facultiestable.php', 'Schools Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Schools Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('departmentstable.php', 'Departments Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Departments Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('programmestable.php', 'Programmes Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Programmes Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('studentslevels.php', 'Student Levels Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Students Level Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('sessionstable.php', 'Session Semester Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Session/Semester Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('coursestable.php', 'Courses Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Courses Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('qualificationstable.php', 'Qualifications Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Qualifications Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('gradestable.php', 'Grades Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Grades Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('cgpatable.php', 'CGPA Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Classes of Diploma Setup</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Data Entries</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('regularstudents.php', 'Student Details Update');">&nbsp;&nbsp;&nbsp;&nbsp;- Student Details Update</a>
			</li>
			<li>
				<a href="javascript: checkAccess('examresultstable.php', 'Update Student Marks');">&nbsp;&nbsp;&nbsp;&nbsp;- Student Marks Update</a>
			</li>
			<li>
				<a href="javascript: checkAccess('lockrecords.php', 'Lock Records');">&nbsp;&nbsp;&nbsp;&nbsp;- Lock Records</a>
			</li>
			<!--li>
				<a href="javascript: checkAccess('backuprestore.php', 'Data Backup/Restore');">&nbsp;&nbsp;&nbsp;&nbsp;- Data Backup/Restore</a>
			</li-->
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<!--li>
		<a class="head" href="#">&nbsp;&nbsp;Pin Numbers/Online Data</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('generatepinumbers.php', 'Generate Pin Numbers');">&nbsp;&nbsp;&nbsp;&nbsp;- Generate Pin Numbers</a>
			</li>
			<li>
				<a href="javascript: checkAccess('allocatepinumbers.php', 'Allocate Pin Numbers');">&nbsp;&nbsp;&nbsp;&nbsp;- Allocate Pin Numbers</a>
			</li>
			<li>
				<a href="javascript: checkAccess('onlinetransfer.php', 'Upload Online Data');">&nbsp;&nbsp;&nbsp;&nbsp;- Upload Online Data</a>
			</li>
			<li>
				<a href="javascript: checkAccess('backuprestore.php', 'Upload Pin Numbers');">&nbsp;&nbsp;&nbsp;&nbsp;- Upload Pin Numbers</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li-->
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Users Management</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('manageusers.php', 'Manage Users');">&nbsp;&nbsp;&nbsp;&nbsp;- Manage Users</a>
			</li>
			<li>
				<a href="javascript: checkAccess('accesscontrol.php', 'Users Access Control');">&nbsp;&nbsp;&nbsp;&nbsp;- Users Access Control</a>
			</li>
			<li>
				<a href="javascript: checkAccess('changepassword.php', 'Change Users Password');">&nbsp;&nbsp;&nbsp;&nbsp;- Change Users Password</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Results</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('masterresults.php', 'Master Score Sheet','');">&nbsp;&nbsp;&nbsp;&nbsp;- Spread Sheets</a>
			</li>
			<li>
				<a href="javascript: checkAccess('summaryresults.php', 'Summary of Results','');">&nbsp;&nbsp;&nbsp;&nbsp;- Summary of Results</a>
			</li>
			<li>
				<a href="javascript: checkAccess('transcriptresults.php', 'Student Transcript','');">&nbsp;&nbsp;&nbsp;&nbsp;- Students Statement of Results</a>
			</li>
			<!--li>
				<a href="javascript: checkAccess('transcriptresults.php', 'Pin Numbers Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Pin Numbers Reports</a>
			</li-->
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul>
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Logout</a>
		<ul>
			<li>
				<a href="javascript:logoutUser()" title="Logout">&nbsp;&nbsp;&nbsp;&nbsp;- Logout</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
</ul>
