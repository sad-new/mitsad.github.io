
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
					<h1 class="page-header">Class Records</h1>
						
				</div>
			</div>
			<!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">


						<div class="row">
							<div class="col-sm-4 col-md-7 col-lg-5 btnaddteacher">
								<button type="button" 
									class="btn btn-primary" 
									data-toggle="modal" 
									data-title="addsyterm" 
									data-target="#addSYTerm" 
									id="addSYTermEntry">
									Add Term
								</button>
							</div>
						</div>

						<div class="container teacher-table">
							<div class="row">

						        <div class="col-md-12">						        	
						       		<h4>List of School Terms</h4>

						       		<div class="table-responsive">               
							            <table id="mytable" class="table table-bordred table-striped">
								                   
								            <thead>            	                   
											    <th>SchoolYear</th>
                                                <th></th>
								            </thead>

									 		<tbody>
									    		

 												<?php

													$yearArray = loadYears();  

													foreach ($yearArray as $getRow)
													{
														$schoolYear_get  = $getRow['schoolYear']; 

														echo "<tr>";

    														echo "<td class='clickable'> + ".$schoolYear_get. " - ".(+$schoolYear_get + 1)."</td>";
    														
    														echo '
                                                                <td>
        															<p data-placement="top" data-toggle="tooltip" title="Delete">
            															<button class="btn btn-danger btn-xs deleteSYTermEntry" 
            															data-title="Delete" 
            															data-toggle="modal" 
            															data-target="#delete"
            															value ='.$schoolYear_get.'> 

            														        <span class="glyphicon glyphicon-trash"></span>
            															
                                                                        </button>
                                                                    </p>
                                                                </td>';

														echo "</tr>";

														echo "<tr><td colspan = '2'>";

    														echo "
                                                            <table id='mytable' class='table table-bordred table-striped'>
                                                            <thead>               
																<th>Term</th> 
																<th>Active</th> 
																<th>    </th>
										           			</thead>

                                                            <tbody>"; 

    														$syTermArray = loadTerms($schoolYear_get);  
    														foreach ($syTermArray as $getRow)
    														{
    															//GET
    															$syTermID_get    = $getRow['syTermID'];
    															$schoolYear_get  = $getRow['schoolYear'];   
    															$termNumber_get  = $getRow['termNumber'];
    															$isActive_get  = $getRow['isActive'];

    															echo "<tr></tr>"; 
    															//SET TO TABLE
    															echo "<tr>"; 
    															echo "<td><center value = '".$syTermID_get."'>".$termNumber_get."</center></td>";
    															echo "<td><center>".$isActive_get ."</center></td>";

    															//EDIT
    															$buttonEdit =  
    															'<td>
    															<p data-placement="top" data-toggle="tooltip" title="Edit">
    																
    															<button 
    															class="btn btn-primary btn-xs editSYTermEntry" 
    															data-title="Edit" 
    															data-toggle="modal" 
    															data-target="#edit"  
    															name = "editSYTermButton"
    															value ='.$syTermID_get.' 
    															>

    															<span class="glyphicon glyphicon-pencil"></span>
    															</button></p></td>';
    															echo $buttonEdit;

    															echo "</tr>"; 				
    														}

    														echo "</tbody></table>"; 
														echo "</td></tr>";
													}
												?> 

									    	</tbody>

										</table>                
						        	</div>

		            
						    	</div>
							</div>
						</div> 
						<!--/Container teacher table-->

					</div>
				</div>
			</div>
			<!--/.row-->	

		</div>
		<!--col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main-->


		<!-- ADD SECTION FORM -->
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
					        <h4 class="modal-title custom_align" id="Heading">Add a new Grading Period</h4>
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
		    		<!-- /.modal-content --> 
		  		</div>
		    	<!-- /.modal-dialog --> 
			</div>
			<!-- /.modal-fade --> 

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
									<select class="form-control" 
										id = "dropDown_editIsActive">
											
										<option value = 'yes'>Yes</option>
										<option value = 'no' selected="selected">No</option>
										
										
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
						        	id="updateEditedSYTermEntry">
						        	
							        	<span class="glyphicon glyphicon-ok-sign">					        		
							        	</span> Update Grading Period
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
		<form 	action = "sadnew/Backend/a_SYTermManagement.php" 
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
				        	<button type="button" class="btn btn-success" id = 'removeSelectedSYTermEntry'><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
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
