<link rel="stylesheet" href="css/menu.css" />
	
<script type="text/javascript" src="js/chili-1.7.pack.js"></script>
<script type="text/javascript" src="js/jquery.easing.js"></script>
<script type="text/javascript" src="js/jquery.dimensions.js"></script>
<script type="text/javascript" src="js/jquery.accordion.js"></script>
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
		<a class="head" href="#">&nbsp;&nbsp;CRM</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('departmentsetup.php', 'Departments Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Departments Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('locationsetup.php', 'Locations Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Locations Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('basestationsetup.php', 'Base Stations Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Base Stations Setup</a>
			</li>
			<li>
				<a href="javascript: checkAccess('usersetup.php', 'Users Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Users Setup</a>
			</li>
			<li>
				<a href="javascript: viewMenu('viewusers.php');">&nbsp;&nbsp;&nbsp;&nbsp;- View Users</a>
			</li>
			<li>
				<a href="javascript: checkAccess('clientsetup.php', 'Clients Setup');">&nbsp;&nbsp;&nbsp;&nbsp;- Clients Setup</a>
			</li>
			<li>
				<a href="javascript: viewMenu('viewclients.php');">&nbsp;&nbsp;&nbsp;&nbsp;- View Clients</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Tickets</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('ticketstable.php', 'Manage Tickets');">&nbsp;&nbsp;&nbsp;&nbsp;- Manage Tickets</a>
			</li>
			<li>
				<a href="javascript: viewMenu('viewtickets.php');">&nbsp;&nbsp;&nbsp;&nbsp;- View Tickets</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Equipments Stock</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('equipmentsetup.php', 'Create Equipments');">&nbsp;&nbsp;&nbsp;&nbsp;- Create Equipments</a>
			</li>
			<li>
				<a href="javascript: checkAccess('stockreplenishment.php', 'Stock Replenishment');">&nbsp;&nbsp;&nbsp;&nbsp;- Stocks Replenishment</a>
			</li>
			<li>
				<a href="javascript: checkAccess('stockrequisition.php', 'Stock Requisition');">&nbsp;&nbsp;&nbsp;&nbsp;- Stocks Requisition</a>
			</li>
			<li>
				<a href="javascript: checkAccess('stockapproval.php', 'Stock Approval/Decline');">&nbsp;&nbsp;&nbsp;&nbsp;- Stocks Approval/Decline</a>
			</li>
			<li>
				<a href="javascript: checkAccess('stocktransfer.php', 'Stock Transfer');">&nbsp;&nbsp;&nbsp;&nbsp;- Stocks Transfer</a>
			</li>
			<li>
				<a href="javascript: checkAccess('stockview.php', 'View Stock');">&nbsp;&nbsp;&nbsp;&nbsp;- View Stocks</a>
			</li>
			<li>
				<a href="javascript: checkAccess('stockhistory.php', 'Stock History');">&nbsp;&nbsp;&nbsp;&nbsp;- Stock History</a>
			</li>
			<li>
				<a href="javascript: checkAccess('lockstock.php', 'Lock Stock Records');">&nbsp;&nbsp;&nbsp;&nbsp;- Lock Stock Records</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Accounts</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('accountsrequisition.php', 'Account Requisition');">&nbsp;&nbsp;&nbsp;&nbsp;- Accounts Requisition</a>
			</li>
			<li>
				<a href="javascript: checkAccess('supervisorapproval.php', 'Supervisor Approval/Decline');">&nbsp;&nbsp;&nbsp;&nbsp;- Supervisor Approval/Decline</a>
			</li>
			<li>
				<a href="javascript: checkAccess('accountsapproval.php', 'Account Approval/Decline');">&nbsp;&nbsp;&nbsp;&nbsp;- Accounts Approval/Decline</a>
			</li>
			<li>
				<a href="javascript: checkAccess('accountsrelease.php', 'Account Release/Decline');">&nbsp;&nbsp;&nbsp;&nbsp;- Accounts Release/Decline</a>
			</li>
			<li>
				<a href="javascript: checkAccess('accountsview.php', 'View Account');">&nbsp;&nbsp;&nbsp;&nbsp;- View Accounts</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Human Resources</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('staffupdate.php', 'Staff Update');">&nbsp;&nbsp;&nbsp;&nbsp;- Staff Update</a>
			</li>
			<li>
				<a href="javascript: viewMenu('viewstaff.php');">&nbsp;&nbsp;&nbsp;&nbsp;- View Staff</a>
			</li>
			<li>
				<a href="javascript: checkAccess('appraisalupdate.php', 'Appraisal Update');">&nbsp;&nbsp;&nbsp;&nbsp;- Appraisal Update</a>
			</li>
			<li>
				<a href="javascript: viewMenu('viewappraisal.php');">&nbsp;&nbsp;&nbsp;&nbsp;- View Appraisal</a>
			</li>
			<li>
				<a href="javascript: checkAccess('leaveupdate.php', 'Leave Update');">&nbsp;&nbsp;&nbsp;&nbsp;- Leave Update</a>
			</li>
			<li>
				<a href="javascript: checkAccess('leavesuperapproval.php', 'Leave Supervisor Approval');">&nbsp;&nbsp;&nbsp;&nbsp;- Leave Supervisor Approval</a>
			</li>
			<li>
				<a href="javascript: checkAccess('leaveadminapproval.php', 'Leave Admin Approval');">&nbsp;&nbsp;&nbsp;&nbsp;- Leave Admin Approval</a>
			</li>
			<li>
				<a href="javascript: viewMenu('viewleave.php');">&nbsp;&nbsp;&nbsp;&nbsp;- View Leave</a>
			</li>
			<li>
				<a href="#">&nbsp;</a>
			</li>
		</ul> 
	</li>
	<li>
		<a class="head" href="#">&nbsp;&nbsp;Users Management</a>
		<ul>
			<!--li>
				<a href="javascript: checkAccess('manageusers.php', 'Manage Users');">&nbsp;&nbsp;&nbsp;&nbsp;- Manage Users</a>
			</li-->
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
		<a class="head" href="#">&nbsp;&nbsp;Reports</a>
		<ul>
			<li>
				<a href="javascript: checkAccess('usersreports.php', 'Users Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Users Reports</a>
			</li>
			<li>
				<a href="javascript: checkAccess('clientreports.php', 'Client Reports');">&nbsp;&nbsp;&nbsp;&nbsp;- Client Reports</a>
			<li>
				<a href="javascript: checkAccess('ticketreports.php', 'Ticket Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Ticket Reports</a>
			</li>
			<li>
				<a href="javascript: checkAccess('stockreports.php', 'Stock Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Stock Reports</a>
			</li>
			<li>
				<a href="javascript: checkAccess('accountsreports.php', 'Stock Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Accounts Reports</a>
			</li>
			<li>
				<a href="javascript: checkAccess('staffreports.php', 'Staff Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Staff Reports</a>
			</li>
			<li>
				<a href="javascript: checkAccess('appraisalreports.php', 'Appraisal Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Appraisal Reports</a>
			</li>
			<li>
				<a href="javascript: checkAccess('leavereports.php', 'Leave Reports','');">&nbsp;&nbsp;&nbsp;&nbsp;- Leave Reports</a>
			</li>
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
