
<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 12;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");  


	$path = "Backend/a_Records.php";
	include_once($path);
?>


<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>admin-Uploads</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>


		<script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>
		<script type="text/javascript" src="js_created/js_Records.js"></script> 

		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>

	
			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Records</h1>
				</div>
			</div><!--/.row-->
			
		
			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">View Records</div>

							<div class="container Upload">
								<div class="row upload-files">

									<div class="col-sm-2 col-md-5 col-lg-3">
										<div class="form-group">
											<label>Classes</label>
											<select class="form-control" id = "dropDown_ClassDropDown">

												
												<?php

													// echo ($_SESSION['accountID']);

													$classArray = loadDropDownSYTerm($_SESSION['userType'], $_SESSION['accountID']);  
													foreach ($classArray as $getRow)
													{
														//GET FROM SERVER
														$classID_Get      = $getRow['classID'];

														$syTermID_Get     = $getRow['syTermID'];
														$schoolYear_Get   = $getRow['schoolYear'];
														$termNumber_Get   = $getRow['termNumber'];

														$sectionID_Get    = $getRow['sectionID'];
														$sectionName_Get  = $getRow['sectionName'];
														$gradeLevelID_Get = $getRow['gradeLevelID_Sections'];

														$subjectID_Get    = $getRow['subjectID'];
														$subjectName_Get  = $getRow['subjectName'];

														$employeeID_Get   = $getRow['employeeID'];
														$employeeName_Get = $getRow['employeeName'];

														//SET TO DROPDOWN
														echo "<option value = " .$classID_Get. "> SY " .$schoolYear_Get. " Term " .$termNumber_Get. 
														", Grade " .$gradeLevelID_Get .", Section ". $sectionName_Get . " " .$subjectName_Get. "</option>";
													}
												?>


											</select>
										</div>
									</div>

									</br>
									</br>
									</br>
									</br>


									<div class="container">
										<button type="submit" name = "showTable" id = "showTable" class="btn btn-primary"> Show 
										</button>
									</div>
										
									</br>
									</br>

									<div class="form-group">
											<table id="recordsTable" class="table table-bordred table-striped">
											</table>
									</div>

									<div class="container">
										<button type="submit" name = "downloadCSV" id = "downloadCSV" class="btn btn-primary">download CSV
										</button>
									</div>
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
