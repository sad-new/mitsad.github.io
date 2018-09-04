


		<!--Side Bar-->
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			<ul class="nav menu">


				<li <?php if ($activeHeader == 1) {echo ('class = "active"');} ?> ><a href="Dashboard.php">Dashboard</a></li>
										
				<?php if ($_SESSION['userType'] == 'schoolAdministrator') 
                    {include_once('a_Sidebar_AdminOptions.php');} 
                ?>


                <li role="presentation" class="divider"></li>
				

				<li <?php if ($activeHeader == 13) {echo ('class = "active"');} ?> ><a href="Uploads.php">Uploads</a></li>

        <li <?php if ($activeHeader == 12) {echo ('class = "active"');} ?> ><a href="Records.php">Records</a></li>
				
        <li <?php if ($activeHeader == 11) {echo ('class = "active"');} ?> ><a href="Charts.php">Charts</a></li>
        
				<li role="presentation" class="divider"></li>
				
 				<li <?php if ($activeHeader == 14) {echo ('class = "active"');} ?> ><a href="UserInfo.php">User Info</a></li> 


			</ul>
		</div>
		<!--/.sidebar-->