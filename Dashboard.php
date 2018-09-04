<?php
//Account Check

	require_once ('Backend/b_ConnectionString.php');
	require_once ('Backend/c_AccountInfo.php');

	$activeHeader = 1;

	include_once("Navbars/Navbar.php");
	include_once("Navbars/a_Sidebar.php");
?>




<!DOCTYPE html>


<html>


	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>admin-dashboard</title>

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

	
			
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Dashboard</h1>
				</div>
			</div><!--/.row-->
			
		
			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">Average scores for Written Works (ALL STUDENTS)</div>
						<div class="panel-body">

						<!--Dito lalagay ung chart-->
							<div class="canvas-wrapper">
								<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
							</div>
							
						</div>
					</div>
				</div>
			</div><!--/.row-->

					
			<div class="row">
				<div class="col-md-8">
				
					<div class="panel panel-default chat">
						<div class="panel-heading" id="accordion"><svg class="glyph stroked two-messages"><use xlink:href="#stroked-two-messages"></use></svg> Announcements(Coming Soon)</div>
						<div class="panel-body">
		
						</div>
						
						<div class="panel-footer">
							<div class="input-group">
								<input id="btn-input" type="text" class="form-control input-md" placeholder="Type your message here..." />
								<span class="input-group-btn">
									<button class="btn btn-success btn-md" id="btn-chat">Send</button>
								</span>
							</div>
						</div>
					</div>

				
					
				</div><!--/.col-->

				<!--TO DO LIST-->
				
				<div class="col-md-4">
				
					<div class="panel panel-blue">
						<div class="panel-heading dark-overlay"><svg class="glyph stroked clipboard-with-paper"><use xlink:href="#stroked-clipboard-with-paper"></use></svg>To-do List</div>
						<div class="panel-body">
							<ul class="todo-list">
							<li class="todo-list-item">
									<div class="checkbox">
										<input type="checkbox" id="checkbox" />
										<label for="checkbox">Check Grades</label>
									</div>
									<div class="pull-right action-buttons">
										<a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
										<a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
										<a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
									</div>
								</li>
								<li class="todo-list-item">
									<div class="checkbox">
										<input type="checkbox" id="checkbox" />
										<label for="checkbox">Update Teachers</label>
									</div>
									<div class="pull-right action-buttons">
										<a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
										<a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
										<a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
									</div>
								</li>
						
								
								<li class="todo-list-item">
									<div class="checkbox">
										<input type="checkbox" id="checkbox" />
										<label for="checkbox">Set Classes</label>
									</div>
									<div class="pull-right action-buttons">
										<a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
										<a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
										<a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
									</div>
								</li>
								<li class="todo-list-item">
									<div class="checkbox">
										<input type="checkbox" id="checkbox" />
										<label for="checkbox">Set Grades</label>
									</div>
									<div class="pull-right action-buttons">
										<a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg></a>
										<a href="#" class="flag"><svg class="glyph stroked flag"><use xlink:href="#stroked-flag"></use></svg></a>
										<a href="#" class="trash"><svg class="glyph stroked trash"><use xlink:href="#stroked-trash"></use></svg></a>
									</div>
								</li>
							</ul>
						</div>
						<div class="panel-footer">
							<div class="input-group">
								<input id="btn-input" type="text" class="form-control input-md" placeholder="Add new task" />
								<span class="input-group-btn">
									<button class="btn btn-primary btn-md" id="btn-todo">Add</button>
								</span>
							</div>
						</div>
					</div>
									
				</div><!--/.col-->


				<!--CALENDAR-->
				<div class="col-md-4">
					<div class="panel panel-red">
						<div class="panel-heading dark-overlay"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg>Calendar</div>
						<div class="panel-body">
							<div id="calendar"></div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->

		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/easypiechart.js"></script>
		<script type = "text/javascript" src="js/chart.min.js"></script>
		<script src="js/chart-data.js"></script>
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
