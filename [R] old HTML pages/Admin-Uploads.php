<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 9;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");  


	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/SADnew/Backend/a_Uploads.php";
	include_once($path);


	//check if success or fail
	echo "";  
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
		<!--<script type="text/javascript" src="js/jquery.csv.js"></script>-->
		<script type="text/javascript" src="js/papaparse.js"></script>
		<script type="text/javascript" src="js_created/js_Uploads.js"></script> 


		<!-- JS-XLSX -->
		<script type="text/javascript" src="js/xlsx/jszip.js"></script>
		<script type="text/javascript" src="js/xlsx/xlsx.js"></script>

		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>



	<body>

			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Uploads</h1>
				</div>
			</div>
			<!--/.row-->
					
			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						
						<div class="panel-heading">Upload here
						</div>

						<div class="container Upload">
								
							<div class="row upload-files">									
								<div class="col-sm-2 col-md-5 col-lg-3">
									<div class="form-group">
										<label>Class</label>
										<select class="form-control" id = "classDropDown">

											<?php

												$classArray = loadDropDown();  

												foreach ($classArray as $getRow)
												{
													//GET FROM SERVER
													$classID_Get      = $getRow['classID'];

													$syTermID_Get     = $getRow['syTermID'];
													$schoolYear_Get   = $getRow['schoolYear'];
													$termNumber_Get   = $getRow['termNumber'];

													$sectionID_Get    = $getRow['sectionID'];
													$sectionName_Get  = $getRow['sectionName'];
													$sectionYearLevel_Get  = $getRow['sectionYearLevel'];

													$subjectID_Get    = $getRow['subjectID'];
													$subjectName_Get  = $getRow['subjectName'];

													$employeeID_Get   = $getRow['employeeID'];
													$employeeName_Get = $getRow['employeeName'];

													//SET TO DROPDOWN
													echo "<option value = " .$classID_Get. "> SY " .$schoolYear_Get. " Term " .$termNumber_Get. 
													", Grade " .$sectionYearLevel_Get ." Section ". $sectionName_Get . " " .$subjectName_Get. "</option>";
												}
											?>


										</select>
									</div>
								</div>										
							</div> 


							<div class="form-group">
								<label>File input</label>
								<input type="file"
								accept=".csv" 
								id = "fileCSV"
								name = "fileCSV"/>
								<p class="help-block">Please use CSV file.</p>
							</div>

							<div class="container">
								<button type="submit" 
								name = "submitCSV" 
								id = "submitCSV"
								class="btn btn-primary">Submit Button</button>
							</div>

							<div>
								<!-- 									
									<pre id = "chartText">
									</pre> 
								-->
								<table id="uploadsTable" class="table table-bordred table-striped">
								</table>
							</div>

							<!--RESPONSE DIV ITEMS. USE THESE WHEN DEBUGGING. --> 
							<div id="response1">
							<!--This will hold our error messages and the response from the server. -->
							</div>  

							<div id="response2">
							</div>  

							<div id="response3">
							</div> 
						</div>

					</div>
				</div>
			</div>
			<!--/.row-->
			

		</div>
		<!--col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main-->
				


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
