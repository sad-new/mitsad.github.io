
<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 10;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");  


	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/SADnew/Backend/a_UserInfo.php";
	include_once($path);


	//get data for the chart 
	$employeeEntry = loadEmployeeInfo($_SESSION['accountID']);

?>



<!DOCTYPE html>
<html>


	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>admin-UserInfo</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>


		<!--more Javascripts-->		
		<script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>
		<script type="text/javascript" src="js_created/js_UserInfo.js"></script> 
		
		<script>
			var accountID = <?php echo json_encode($_SESSION['accountID']); ?>
		</script>


		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>
		
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">User Information</h1>
				</div>
			</div>
			<!--/.row-->
		
	
		
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						

						<div class="panel-heading">Profile
						</div>
							
						<div class="container">

							<div class="row">

	                			<div class="col-md-3 col-lg-3 " align="center"> 
	                				<!--<img alt="User Pic" src="http://babyinfoforyou.com/wp-content/uploads/2014/10/avatar-300x300.png" class="img-circle img-responsive"> -->
	                				<img alt="User Pic" src="./Pictures/Blank_Avatar.jpg" class="img-circle img-responsive">
	                			</div>

					            <div class=" col-md-7 col-lg-7 table-user-information"> 
					                  	<table class="table table-user-information">
						                    
						                    <thead>
						                    </thead>

						                    <tbody>


						       					<?php
						       						//summon entry from database, display on screen.

							                      	echo("<tr><td>Name</td>");
							                      	echo("<td>".$employeeEntry['employeeName']."</td></tr>");

							                      	echo("<tr><td>Home Address</td>");
							                        echo("<td>".$employeeEntry['employeeAddress']."</td></tr>");

							                      	echo("<tr><td>Contact Number</td>");
							                        echo("<td>".$employeeEntry['employeePhoneNumber']."</td></tr>");

							                      	echo("<tr><td>Email</td>");
							                        echo("<td>".$employeeEntry['employeeEmail']."</a></td></tr>");


							                        echo("<tr><td>Username</td>");
							                        echo("<td>".$employeeEntry['userName']."</td></tr>");
							                           
							                      	echo("<tr><td>Password</td>");
							                      	echo("<td>".$employeeEntry['password']."</td></tr>");					                      
												?>


						                    </tbody>

					                  	</table>
					            </div>

	                		</div>
	                		<!--/Row-->

		                	<div class="panel-footer">                       
			                    <span>
			                        <a data-original-title="Remove this user" data-toggle="modal"  data-target="#edit"  type="button" class="btn btn-sm btn-primary editEmployeeEntry"><i class="glyphicon glyphicon-pencil">Edit</i></a>
									<!-- 	                            
										<a data-original-title="Remove this user" data-toggle="modal" data-target="#delete"  type="button" class="btn btn-sm btn-danger deleteEmployeeEntry"><i class="glyphicon glyphicon-remove">Remove</i></a> 
									-->
			                    </span>
		                   	</div>
						</div>
						<!--/Container-->

					</div>
				</div>
			</div>

												
	
			<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
			    <div class="modal-dialog">
			    	<div class="modal-content">

			            <div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
			        		<h4 class="modal-title custom_align" id="Heading">Edit</h4>      
					    </div>

				        <div class="modal-body">

						    <div class="form-group">
							    <h5>Profile Picture</h5>
							    <input type="file">
								<p class="help-block">Choose image</p>
						    </div>


					        <div class="form-group">
						       	<input class="form-control" type="text" id = getEmployeeName placeholder="Name">
						    </div>
					       

					        <div class="form-group">
					        	<input class="form-control" type="text" id = getEmployeeAddress placeholder="Address">
					        </div>

					        <div class="form-group">
					       		<input class="form-control" type="Number" id = getEmployeeContact placeholder="Phone#">
					        </div>

					        <div class="form-group">
					        	<input class="form-control" type="Email" id = getEmployeeEmail placeholder="Email">
					        </div>

					        </br></br>

					        <div class="form-group">
					        	<input class="form-control" type="text" id = getUserName placeholder="Username">
					        </div>

					        <div class="form-group">
					        	<input class="form-control" type="password" id = getPassword placeholder="Password">
					        </div>
						</div>
							
						<div class="modal-footer ">
							<button type="button" class="btn btn-warning btn-lg" id = "updateEditedEmployeeEntry" style="width: 100%;">
								<span class="glyphicon glyphicon-ok-sign"></span> Update
							</button>
						</div>

					</div>
				</div> 
			</div>
		    
		    
		    
			<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
			    <div class="modal-dialog">
			    	<div class="modal-content">
			          	
			          	<div class="modal-header">
			        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			        			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			        		</button>
			        		<h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
			    		</div>

			          	<div class="modal-body">
			       
			       			<div class="alert alert-danger">
			       				<span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this?
			       			</div>			       
			      		</div>
			        
			        	<div class="modal-footer ">
						    
						    <button type="button" class="btn btn-success" >
						    	<span class="glyphicon glyphicon-ok-sign"></span> Yes
						    </button>
						    
						    <button type="button" class="btn btn-default" data-dismiss="modal">
						    	<span class="glyphicon glyphicon-remove"></span> No
							</button>							
			      		</div>

			        </div>
			  	</div> 
			</div>

		</div>

		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>
		<script src="js/chart-data.js"></script>
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>

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
