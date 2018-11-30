<?php

	include "Backend/b_ConnectionString.php";
	require_once ('Backend/c_AccountInfo.php');


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
		<title>Admin-users</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/datepicker3.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!--Icons-->
		<script src="js/lumino.glyphs.js"></script>

		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>

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
						<?php 
							echo '<span>';
							echo '<span id = accountDetails" value = '. $accountID .'>' . $username .'</span>'; 			
							echo '</span>';
						?>
					</a>
					
					<ul class="user-menu">
						<li class="dropdown pull-right">
							
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<svg class="glyph stroked male-user">
									<use xlink:href="#stroked-male-user"></use>
								</svg> User 
								<span class="caret"></span>
							</a>

							<ul class="dropdown-menu" role="menu">
								<li>
									<a href="#">
										<svg class="glyph stroked male-user">
											<use xlink:href="#stroked-male-user"></use>
										</svg> Profile
									</a>
								</li>

								<!--LOGOUT-->
								<li>
									<a href="login.php">
										<svg class="glyph stroked cancel">
											<use xlink:href="#stroked-cancel"></use>
										</svg> Logout
									</a>
								</li>

							</ul>

						</li>
					</ul>
				</div>						
			</div>
			<!-- /.container-fluid -->
		</nav>
		
		<!--Side Bar-->
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		
			<ul class="nav menu">
				<li><a href="Admin-Dashboard.php">Dashboard</a></li>
				<li><a href="Admin-SchoolManagement.php">School Management</a>
				<li  class="active"><a href="admin-users.php">Teachers</a></li>
				<li role="presentation" class="divider"></li>
				<li><a href="admin-charts.php">Charts</a></li>
				<li><a href="Admin-Records.php">Records</a></li>
				<li><a href="#">Uploads</a></li>
				<li role="presentation" class="divider"></li>
				<li><a href="Admin-UserInfo.php">User Info</a></li>
			</ul>
		</div>
		<!--/.sidebar-->
			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Users</h1>			
				</div>
			</div>
			<!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						
						<div class="row">
							
							<div class="col-sm-3 col-md-6 col-lg-4">
								<div class="panel-heading">Advanced Table</div>
							</div>

							<br>

							<div class="col-sm-4 col-md-7 col-lg-5">
								<button type="submit" class="btn btn-primary">Add teacher</button>
							</div>

						</div>

						<div class="panel-body">

							<table data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
							    
							    <thead>
								    <tr>
								        <th data-field="state" data-checkbox="true" >Item ID</th>
								        <th data-field="id" data-sortable="true">Item ID</th>
								        <th data-field="name"  data-sortable="true">Item Name</th>
								        <th data-field="price" data-sortable="true">Item Price</th>
								    </tr>
							    </thead>
							    
							    <tbody>
							    </tbody>

							</table>
						
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
