<?php

	include "Backend/b_ConnectionString.php";
	//$dbConnection = mysqli_connect($mySQL_HostName, $mySQL_User, $mySQL_Password, $mySQL_Database); 

	require_once ('Backend/c_AccountInfo.php');



	include_once("Backend/a_Accounts.php");

	//check if success or fail
	echo "";  
?>

<script>
	var storedAccountID = <?php echo json_encode($_SESSION['accountID']); ?>;
	var storedUserName = <?php echo json_encode($_SESSION['userName']); ?>;
</script>


<!DOCTYPE html>
<html>





	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin-Teachers</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>

		<!--more Javascripts-->
		<script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>
 		<script type="text/javascript" src="js_created/js_Accounts.js"></script> 
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>





	<body>

				<!--Header-->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">

					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<a class="navbar-brand" href="#">
						
							<span>
							<span> ADMIN </span> 			
							</span>
					</a>

					<ul class="user-menu">
						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> 
								<?php echo $_SESSION['userName']; ?> 
								<span class="caret"></span>
							</a>

							<ul class="dropdown-menu" role="menu">
								<li><a href="Admin-UserInfo.php"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
								<!--LOGOUT-->
								<li><a href="login.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
							</ul>

						</li>
					</ul>


				</div>					
			</div>
		</nav>
		<!--/Header-->

		<!--Side Bar-->
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		
			<ul class="nav menu">
				<li><a href="Admin-Dashboard.php">Dashboard</a></li>
				
				<li role="presentation" class="divider"></li>
				
				<li><a href="Admin-SYTermManagement.php">SY Term Management</a></li>
				<li class = "active"><a href="Admin-AccountsManagement.php">Accounts Management</a></li>
				<li><a href="Admin-SectionManagement.php">Section Management</a></li>
				<li><a href="Admin-SubjectManagement.php">Subject Management</a></li>
				<li><a href="Admin-ClassManagement.php">Class Management</a></li>
				
				<li role="presentation" class="divider"></li>
				
				<li><a href="Admin-Charts.php">Charts</a></li>
				<li><a href="Admin-Records.php">Records</a></li>
				<li><a href="Admin-Uploads.php">Uploads</a></li>
				
				<li role="presentation" class="divider"></li>
				
				<li><a href="Admin-UserInfo.php">User Info</a></li>
			</ul>
		</div>
		<!--/.sidebar-->
			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Accounts Management</h1>
					
				</div>
			</div><!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="row">
													
							<div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
								<button type="button" 
								class="btn btn-primary" 
								data-toggle="modal" 
								data-title="addteacher" 
								data-target="#addteacher" 
								id="addTeacherEntry">
								Add teacher
								</button>
							</div>

						</div>

						<div class="container teacher-table">
							<div class="row">       
					        	<div class="col-md-12">

					        		<h4>List of Accounts</h4>

					        		<div class="table-responsive">               
							            <table id="mytable" class="table table-bordred table-striped">
							                   
							                <thead>               
							                   
										    		<th>Account ID</th>
													<th>Username</th> 
													<th>UserType</th>
													<th>Employee ID</th>
													<th>Employee Name</th>
													<th>    </th>
													<th>    </th>
							                </thead>

								 		    <tbody>
												<?php
													$teacherArray = loadTables();  

													$counter = 1;

													//while($getRow = mysql_fetch_array($teacherArray))
													foreach ($teacherArray as $getRow)
													{
														//GET
														$accountID_get     = $getRow['accountID'];
														$userName_get      = $getRow['userName'];
														$userType_get      = $getRow['userType'];   
														$accountImage_get  = $getRow['accountImage']; 
														$employeeID_get    = $getRow['employeeID']; 
														$employeeName_get  = $getRow['employeeName']; 
														$employeeImage_get = $getRow['employeeImage']; 

														echo "<tr>"; 
														//SET TO TABLE
														echo "<tr>"; 
														echo "<td><center>".$userName_get."</center></td>";
														echo "<td><center>".$userType_get."</center></td>";
														echo "<td><center>".$employeeID_get."</center></td>";
														echo "<td><center>".$employeeName_get."</center></td>";

														//EDIT
														$buttonEdit =  
														'<td>
														<p data-placement="top" data-toggle="tooltip" title="Edit">
														
														<button 
														class="btn btn-primary btn-xs editTeacherEntry" 
														data-title="Edit" 
														data-toggle="modal" 
														data-target="#edit"  
														name = "editTeacherButton"
														value ='.$accountID_get.' 
														>

														<span class="glyphicon glyphicon-pencil"></span>
														</button></p></td>';

														//onClick="alert(Hello_world!)"

														echo $buttonEdit;

														//DELETE
														echo 
														'<td>
														<p data-placement="top" data-toggle="tooltip" title="Delete">
														<button class="btn btn-danger btn-xs deleteTeacherEntry" 
														data-title="Delete" 
														data-toggle="modal" 
														data-target="#delete"
														value ='.$accountID_get.'
														>


														<span class="glyphicon glyphicon-trash"></span>
														</button></p></td>';

														echo "</tr>"; 

														//echo $accountID_get;
														$counter ++;						
													}

												?>
								    		</tbody>

										</table>                
					        		</div>

					            
					    		</div>
							</div>
						</div> 	
						<!-- /Container teacher table -->

					</div>
				</div>
			</div>
			<!--/.row-->	

				
		</div>	
		<!--/.col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main-->

	<!-- ADD TEACHER FORM -->
	<form action = "sadnew/Backend/a_Accounts.php" method="post"
	id = "formAddTeacher" name = "formAddTeacher">
	
		<!-- Add Teacher Modal-->
		<div class="modal fade" 
		id="addteacher" 
		tabindex="-1" 
		role="dialog" 
		aria-labelledby="edit" 
		aria-hidden="true">
		    <div class="modal-dialog">
		    	<div class="modal-content">
		    
				    <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
				        <h4 class="modal-title custom_align" id="Heading">Add Teacher</h4>
				    </div>

				<!--  enctype="multipart/form-data"  -->

			    	<div class="modal-body">

				    	<div class="form-group">
				        <input class="form-control " type="text" placeholder="Employee Name" 
				        id="addTeacherName" name="addTeacherName">
				        </br></br>
				        </div>

			<!-- 
				        <div class="form-group">	        
				        <input class="form-control " type="text" placeholder="Last Name" id="addTeacherLastName">
				        </div>
					    <div class="form-group">
				        <input class="form-control" type="number" placeholder="Teacher ID"  id="addTeacherID">
				        </div> 
			-->

				        <div class="form-group">
				        <input class="form-control" type="text" placeholder="Username" 
				        id="addTeacherUserName" name="addTeacherUserName">
				        </div>
				        <div class="form-group">
				        <input class="form-control" type="password" placeholder="Password"
				        id="addTeacherPassword" id="addTeacherPassword">	        
				        </div>

				    </div>

				    <div id="response">
				    <!--This will hold our error messages and the response from the server. -->
				    </div>  


				    <div class="modal-footer">
				        <button type="button" 
				        class="btn btn-warning btn-lg" style="width: 100%;"
				        id="submitNewTeacherEntry">

				        <!--input type="submit" name="submit" -->
				        <span class="glyphicon glyphicon-ok-sign"></span>Add</button>
				    </div>
	    		</div>
	    		<!-- /.modal-content --> 
	  		</div>
	    	<!-- /.modal-dialog --> 
		</div>
		<!-- /.modal-fade --> 

	</form>
	<!-- /teacher form --> 



	<!-- EDIT TEACHER FORM -->
	<form 	action = "sadnew/Backend/a_Accounts.php" 
	method="post"
	id = "formAddTeacher" 
	name = "formAddTeacher">

		<!-- Edit Teacher Modal-->
		<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	    	<div class="modal-dialog">
	    		<div class="modal-content">
	          		<div class="modal-header">
	        			<button type="button" 
	        			class="close" 
	        			data-dismiss="modal" 
	        			aria-hidden="true">
	        			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
	        			</button>
	       				<h4 class="modal-title custom_align" id="Heading">Edit</h4>
	      			</div>


		        	<div class="modal-body">

		        		<div class="form-group">
		        			<input class="form-control" 
		        			type="text" 
		        			placeholder="Name"
		        			id = "editTeacher_TextName">
		        		</div>

		        		<div class="form-group">
		<!--        
		        <input class="form-control " type="text" placeholder="Last Name">
		        </div>
		-->
		        			<div class="form-group">
		 	       				<input class="form-control" 
		 	       				type="text" 
		 	       				placeholder="Teacher ID" 
		 	       				id = "editTeacher_TextTeacherID"
		 	       				disabled="disabled">
		        			</div>

				        	<div class="form-group">
				        		<input class="form-control" 
				        		type="text" 
				        		placeholder="Username"
				        		id = "editTeacher_TextUserName">
				        	</div>

				        	<div class="form-group">
				        		<input class="form-control" 
				        		type="text" 
				        		placeholder="Password"
				        		id = "editTeacher_TextPassword">

				        		<p>To reset password</p>
				        	</div>

				        </div>

					    <div id="response">
					    <!--This will hold our error messages and the response from the server. -->
					    </div> 

				        <div class="modal-footer ">

				        	<button type="button" 
				        	class="btn btn-warning btn-lg" 
				        	style="width: 100%;"
				        	id="updateEditedTeacherEntry">
				        	
					        	<span class="glyphicon glyphicon-ok-sign">					        		
					        	</span> Update
				        	</button>

				        </div> 

				    </div> 
	    			
	  			</div>
	      		<!-- /.modal-content --> 
	    	</div>
	    	<!-- /.modal-dialog --> 
		</div>   
	    <!-- /.modal-fade --> 
	</form>
	<!-- /.form --> 


	<!-- DELETE TEACHER FORM -->
	<form 	action = "sadnew/Backend/a_Accounts.php" 
	method="post"
	id = "formDeleteTeacher" 
	name = "formDeleteTeacher">

		<!-- Delete Teacher Modal-->
	    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	    	<div class="modal-dialog">
	    		<div class="modal-content">

	          		<div class="modal-header">
	        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
	        			<h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
	      			</div>

		          	<div class="modal-body">      
		       			<div class="alert alert-danger">
			       			<span class="glyphicon glyphicon-warning-sign"></span> 
			       			Are you sure you want to delete this?
		       			</div>   
		       			<div class="form-group">
				        	<input class="form-control" 
				        	type="text" 
				        	placeholder="Account ID"
				        	id = "deleteTeacher_TextAccountID"
				        	disabled="disabled">
				        </div>   
		      		</div>

			        <div class="modal-footer ">
			        	<button type="button" class="btn btn-success" id = 'removeSelectedTeacherEntry'><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
			        	<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
			      	</div>

	        	</div>
	    		<!-- /.modal-content --> 
	  		</div>
	      	<!-- /.modal-dialog --> 
	    </div>
	    <!-- /.modal-fade --> 
	</form>
	<!-- /.form --> 

		  
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>
		<script src="js/chart-data.js"></script>
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
		<script>
			$('#calendar').datepicker({
			});

			!function ($) {
			    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
			        $(this).find('em:first').toggleClass("glyphicon-minus");      
			    }); 
			    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
			}(window.jQuery);

			$(window).on('resize', function () {
			  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
			})
			$(window).on('resize', function () {
			  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
			})
		</script>	
	</body>

</html>
