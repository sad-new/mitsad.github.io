<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 2;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");  

	if ($_SESSION['userType'] != 'schoolAdministrator')
	{
		header('Location: Admin-Dashboard.php');
	}

	include_once("Backend/a_SYTermManagement.php");

?>


<!DOCTYPE html>
<html>





	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Subject Management</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>

		<!--more Javascripts-->
		<script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>
 		<script type="text/javascript" src="js_created/js_SYTermManagement.js"></script> 
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>



	<body>
				
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
				
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Term Grading Period Management</h1>			
				</div>
			</div>
			<!--/.row-->


            <?php
                $tableCount = checkTableSize();
               
                //$activeTerm = getActiveTerm();

                if ($tableCount > 0)
                {
                    include_once('mainPages/12_SYTermManagement_Filled.php');
                }
                else
                {
                   include_once('mainPages/12_SYTermManagement_Empty.php'); 
                }
            ?> 


		</div>


        <!-- CHANGE ACTIVE SYTERM -->
        <form action = "sadnew/Backend/a_SYTermManagement.php" method="post"
            id = "formChangeActiveSYTerm" name = "formChangeActiveSYTerm">

            <!-- Change Active Term-->
            <div class="modal fade" 
            id="changeActiveSYTerm" 
            tabindex="-1" 
            role="dialog" 
            aria-labelledby="edit" 
            aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            <h4 class="modal-title custom_align" id="Heading">Change the Active Grading Period</h4>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">

                                <label>School Year / Term</label> 
                                <select class="form-control" 
                                id="dropdown_ChangeActiveSYTerm" 
                                name="dropdown_ChangeActiveSYTerm">
                                </select>

                            </div> 
                        </div>

                        <div id="response">
                        <!--This will hold our error messages and the response from the server. -->
                        </div>  


                        <div class="modal-footer">
                            <button type="button" 
                            class="btn btn-warning btn-lg" style="width: 100%;"
                            id="button_SetActiveSYTermEntry">

                            <span class="glyphicon glyphicon-ok-sign"></span>Set as Active SY Term</button>
                        </div>

                    </div>
                </div>
            </div>


        </form>


		<!-- ADD SY FORM -->
		<form action = "sadnew/Backend/a_SYTermManagement.php" method="post"
			id = "formAddSYTerm" name = "formAddSYTerm">
		
			<!-- Add Section Modal-->
			<div class="modal fade" 
			id="addSYTerm" 
			tabindex="-1" 
			role="dialog" 
			aria-labelledby="edit" 
			aria-hidden="true">
			    <div class="modal-dialog">
			    	<div class="modal-content">
			    
					    <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
					        <h4 class="modal-title custom_align" id="Heading">Add a new School Year</h4>
					    </div>

					<!--  enctype="multipart/form-data"  -->

				    	<div class="modal-body">
					    	<div class="form-group">

						    	<label>School Year</label> 
                                <select class="form-control" 
						        id="addSchoolYear" name="addSchoolYear">
                                </select>

					        </div> 
						</div>

					    <div id="response">
					    <!--This will hold our error messages and the response from the server. -->
					    </div>  


					    <div class="modal-footer">
					        <button type="button" 
					        class="btn btn-warning btn-lg" style="width: 100%;"
					        id="submitNewSYTermEntry">

					        <!--input type="submit" name="submit" -->
					        <span class="glyphicon glyphicon-ok-sign"></span>Add</button>
					    </div>

		    		</div>
		  		</div>
			</div>

		</form>
		<!-- /teacher form --> 



		<!-- EDIT SECTION FORM -->
		<form 	action = "sadnew/Backend/a_SYTermManagement.php" 
			method="post"
			id = "formEditSYTerm" 
			name = "formEditSYTerm">

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
			       				<h4 class="modal-title custom_align" id="Heading">Edit Grading Period</h4>
			      			</div>


   				        	<div class="modal-body">
   								<div class="form-group">
   									<label>Set as 'Active Term'?</label>
   								</div>
   							</div>

   						    <div id="response">
   						    <!--This will hold our error messages and the response from the server.-->
                        </div>

                        <div class="modal-footer ">
                            <button type="button" class="btn btn-success" id = 'button_UpdateEditedSYTermEntry'>
                              <span class="glyphicon glyphicon-ok-sign"></span> Yes
                           </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                              <span class="glyphicon glyphicon-remove"></span> Cancel
                           </button>
                        </div> 
			    			
			  			</div>
			    	</div>
				</div>   

		</form>
		<!-- /.form --> 




		<!-- DELETE SECTION FORM -->
		<form action = "sadnew/Backend/a_SYTermManagement.php" 
		method="post"
		id = "formDeleteSYTerm" 
		name = "formDeleteSYTerm">


          <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
		    	<div class="modal-dialog">
		    		<div class="modal-content">

	          		<div class="modal-header">
	        			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true">
                        </span></button>
	        			  <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
	      			</div>

		          	<div class="modal-body">      
		       			<div class="alert alert-danger">
			       			<span class="glyphicon glyphicon-warning-sign">                              
                        </span> 
			       			Are you sure you want to delete this?
		       			</div>   
		      		</div>

			         <div class="modal-footer ">
			        	
                     <button type="button" class="btn btn-success" id = 'removeSelectedSYTermEntry'>
                        <span class="glyphicon glyphicon-ok-sign">
                        </span> 
                        Yes
                     </button>

   			        	<button type="button" class="btn btn-default" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove">
                        </span> 
                        No
                     </button>
				      	
                  </div>

		        	</div>
		  		</div>
		    </div>

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
		
        <!--CALENDAR--> 
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
		<!--CALENDAR END--> 	

	</body>

</html>
