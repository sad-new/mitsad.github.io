<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 6;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");  

	include_once("Backend/a_ClassListManagement.php");

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

    <script src="js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="js_created/js_ClassListManagement.js"></script> 

		<!-- JS-XLSX -->
		<script type="text/javascript" src="js/xlsx/jszip.js"></script>
		<script type="text/javascript" src="js/xlsx/xlsx.js"></script>
    <script type="text/javascript" src="js/papaparse.js"></script>

		<script>
			var accountID = <?php echo json_encode($_SESSION['accountID']); ?> 
      		var userType = <?php echo json_encode($_SESSION['userType']); ?>
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
					<h1 class="page-header">Class list</h1>
				</div>
			</div>
			<!--/.row-->
					
			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">

						<div class="container upload">

				            <div class="row">
				                <div class="col-md-12">
				                    <div class = "panel-heading" id = "currentClassLabel">
				                      Current Class List for Grade X - Section Y in SY Z.
				                    </div>
				                </div>
				            </div>


							<div id = "currentClassContainer">
							</div>



							<div class="form-group">
								</br>
								<label>Upload a Class list</label>
								<input type="file"
								id = "fileCSV"
								name = "fileCSV"/>
								<p class="help-block"></p>
								</br>
							</div>



				            <div class="row">
				                <div class="col-md-12">
				                    <div class = "panel-heading" id = "classToBeUploadedLabel">
				                    </div>
				                </div>
				            </div>

							<div id = "classFromExcelContainer">
							</div>

							<div class="container">
								<button type="submit" 
								name = "submitCSV" 
								id = "submitCSV"
								display = "none"
								disabled = "true"
								class="btn btn-primary"
								style="visibility:hidden;">Submit Class List</button>
							</div>

							<!--RESPONSE DIV ITEMS. USE THESE WHEN DEBUGGING. --> 
							<div id="response1">
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
