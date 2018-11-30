<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 11;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");  

?>

<!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Admin-charts</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<link href="css/progressBar.css" rel="stylesheet">
		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>






		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>

			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			

			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Charts</h1>				
				</div>
			</div>
			<!--/.row-->
						
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
							

						<div class="container Upload">							

							<div class="row">

								<div class="col-sm-2 col-md-5 col-lg-3">
									<div class="form-group">
										<label>SY Term</label>
											<select class="form-control" id = "dropDown_Main_SchoolYear">
											</select>
									</div>
								</div>
										
								<div class="col-sm-2 col-md-5 col-lg-3">
									<div class="form-group">
										<label>Grade Level</label>
											<select class="form-control" id = "dropDown_Main_GradeLevel">
											</select>
									</div>
								</div>


								<div class="col-sm-2 col-md-5 col-lg-3">
									<div class="form-group">
										<label>Section</label>
											<select class="form-control" id = "dropDown_Main_Section">
											</select>
									</div>
								</div>

								<div class="col-sm-2 col-md-5 col-lg-3">
									<div class="form-group">
										<label>Subject</label>
											<select class="form-control" id = "dropDown_Main_Subject">
											</select>
									</div>
								</div>

							</div>							
									
							<div class="container">
								<button type="submit" class="btn btn-primary">Show</button>
							</div>


						</div>

					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">

						<div class="panel-heading" id = chart1Name> Average Written Work Grades of class X in Subject Y
						</div>

						<div class="panel-body">

							<div class="canvas-wrapper chart1Container">								
								<canvas id = "chart1">
								</canvas>
							</div>

							</br></br>

							<table id = table1 class="panel-heading" align = center width = 95% 
							border = 1 BORDERCOLOR="CCCCCC">
								<thead id = tableHead1>
								</thead>

								<tbody>
									<tr id = tableRow1 align = center>
									</tr>
								</tbody>
							</table>

							</br></br>

						</div>
					
					</div>
				</div>
			</div>
			<!--/.row-->
			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						
						<div class="panel-heading" id = chart2Name> Average Practical Test Grades of class X in Subject Y
						</div>
						
						<div class="panel-body">

							<div class="canvas-wrapper chart2Container">
	 							<canvas id="chart2">
								</canvas>
							</div>

							</br></br>

							<table id = table2 class="panel-heading" align = center width = 95% 
							border = 1 BORDERCOLOR="CCCCCC">
								<thead id = tableHead2>
								</thead>

								<tbody>
									<tr id = tableRow2 align = center>
									</tr>
								</tbody>
							</table>

							</br></br>

						</div>
						
					</div>
				</div>
			</div>
			<!--/.row-->		

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						
						<div class="panel-heading" id = chart3Name> Pass / Fail Percentages of students in Class X in Subject Y
						</div>
						
						<div class="panel-body">
							<div class="canvas-wrapper chart3Container">
	 							<canvas id="chart3">

								</canvas>
							</div>

							</br></br>

							<div id = "legendDiv" >
							</div>
							
							</br></br>

						</div>
						
					</div>
				</div>
			</div>
			<!--/.row-->	


			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						
						<div class="panel-heading" id = chart4Name> Individual Quarterly Grades of Students in section X in Subject Y
						</div>
						
						<div class="panel-body">
							<div class="canvas-wrapper">

								<div id = progressBarArray>
								</div>	

								<canvas id = "chart4">								
								</canvas>

							</div>
						</div>
						
					</div>
				</div>
			</div>
			<!--/.row-->					
												
		</div>	
		<!--/.col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main-->
		  

		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/chart.min.js"></script>
	<!-- 	<script src="js/chart-data.js"></script> -->
		<script src="js/easypiechart.js"></script>
		<script src="js/easypiechart-data.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>

		<script src="js/chart.HorizontalBar.js"></script>

		<script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>
		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

		<script type="text/javascript" src="js_created/js_Charts.js"></script> 


	<!-- 	<script>
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
		</script>	 -->


	</body>

</html>
