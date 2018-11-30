<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 7;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");  

	if ($_SESSION['userType'] != 'schoolAdministrator')
	{
		header('Location: Admin-Dashboard.php');
	}

	include_once("Backend/a_ClassRecordsManagement.php"); 
?>



<!DOCTYPE html>
<html> 



	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Class Records Management</title>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">    
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>


        <!--more Javascripts-->
        <script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>
        <script type="text/javascript" src="js_created/js_ClassRecordsManagement.js"></script> 
		
        <!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>


	<body>

			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Class Records Management</h1>					
				</div>
			</div>
			<!--/.row-->

            <?php
                $tableCount = checkTableSize();

                if ($tableCount > 0)
                {
                    include_once('mainPages/16_ClassRecordsManagement_Filled.php');

                }
                else
                {
                    include_once('mainPages/16_ClassRecordsManagement_Empty.php'); 
                };
            ?>
			
		</div>	

	

		<!-- ADD SECTION FORM -->
		<form action = "sadnew/Backend/a_ClassRecordManagement.php" method="post"
		id = "formAddClass" name = "formAddClass">

			<!-- Add Section Modal-->
			<div class="modal fade" 
			id="addClass" 
			tabindex="-1" 
			role="dialog" 
			aria-labelledby="edit" 
			aria-hidden="true">
			    <div class="modal-dialog">
			    	<div class="modal-content">
			    
					    <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					        <h4 class="modal-title custom_align" id="Heading">Add a new Class</h4>
					    </div>

					<!--  enctype="multipart/form-data"  -->

				    	<div class="modal-body">

							<div class="form-group">
								<label>School Year</label>
								<select class="form-control" 
									id = "dropDown_AddModal_SchoolYear">

								</select>
							</div>

							<div class="form-group">
								<label>Grade Level</label>
								<select class="form-control" 
									id = "dropDown_AddModal_GradeLevel">

								</select>
							</div>

							<div class="form-group">
								<label>Section</label>
								<select class="form-control" 
									id = "dropDown_AddModal_Section">	
									
								</select>
							</div>

						</div>

					    <div id="response">
					    <!--This will hold our error messages and the response from the server. -->
					    </div>  


					    <div class="modal-footer">
					        <button type="button" 
					        class="btn btn-warning btn-lg" style="width: 100%;"
					        id="button_AddModal_AddClass">

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

		<!-- EDIT SECTION FORM -->
		<form 	action = "sadnew/Backend/a_ClassRecordManagement.php" 
		method="post"
		id = "formEditClass" 
		name = "formEditClass">

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
	       				<h4 class="modal-title custom_align" id="Heading">Edit Class Entry</h4>
	      			</div>


			        	<div class="modal-body">

							<div class="form-group">
								<label>School Year</label>
								<select class="form-control" 
									id = "dropDown_EditModal_SchoolYear">
									
								</select>
							</div>

				              <div class="form-group">
				                <label>Grade Level</label>
				                <select class="form-control" 
				                   id = "dropDown_EditModal_GradeLevel">

				                </select>
				              </div>

							<div class="form-group">
								<label>Section</label>
								<select class="form-control" 
									id = "dropDown_EditModal_Section">	
									
								</select>
							</div>



						</div>

					    <div id="response">
					    <!--This will hold our error messages and the response from the server. -->
					    </div>  
					        <div class="modal-footer ">

					        	<button type="button" 
					        	class="btn btn-warning btn-lg" 
					        	style="width: 100%;"
					        	id="button_EditModal_UpdateClass">
					        	
						        	<span class="glyphicon glyphicon-ok-sign">					        		
						        	</span> Update Class
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

		<!-- DELETE SECTION FORM -->
		<form 	action = "sadnew/Backend/a_ClassRecordManagement.php" 
		method="post"
		id = "formDeleteSYTerm" 
		name = "formDeleteSYTerm">

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
			      		</div>

                        <div class="modal-footer ">
                            <button type="button" class="btn btn-success" id = 'button_DeleteModal_DeleteClass'><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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
