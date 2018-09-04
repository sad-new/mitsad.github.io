<!DOCTYPE html>
    <html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Teacher-Dashboard</title>

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
                        <span>Teacher</span>
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
                                    <a href="userinfo.php">
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
    			<li class="active"><a href="Admin-Dashboard.html">Dashboard</a></li>    			
    			<li role="presentation" class="divider"></li>
    			<li><a href="Admin-Charts.php">Charts</a></li>
    			<li><a href="Admin-Uploads.php">Uploads</a></li>
    			<li role="presentation" class="divider"></li>
    			<li><a href="Admin-Records.php">Records</a></li>
    			<li><a href="Admin-UserInfo.php">User Info</a></li>
    		</ul>
    	</div>
        <!--/.sidebar-->
    		
    	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    	
    		
    		<div class="row">
    			<div class="col-lg-12">
    				<h1 class="page-header">Dashboard</h1>
    			</div>
    		</div>
            <!--/.row-->
    		 		
    		<div class="row">
    			<div class="col-lg-12">
    				<div class="panel panel-default">
    					
                        <div class="panel-heading">Average per section per subject</div>
    					
                        <div class="panel-body">
    					   <!--Dito lalagay ung chart-->
    						<div class="canvas-wrapper">
    							<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
    						</div>
    					</div>

    				</div>
    			</div>
    		</div>
            <!--/.row-->

    				
    		<div class="row">
    			
                <div class="col-md-8">    				
                    <div class="panel panel-default chat">

    					<div class="panel-heading" id="accordion">
                            <svg class="glyph stroked two-messages">
                                <use xlink:href="#stroked-two-messages"></use>
                            </svg> Chat (Coming Soon)
                        </div>
    					
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
    			</div>
                <!--/.col-->

    			<!--TO DO LIST-->
    			<div class="col-md-4"> 			
    				<div class="panel panel-blue">
    					
                        <div class="panel-heading dark-overlay">
                            <svg class="glyph stroked clipboard-with-paper">
                                <use xlink:href="#stroked-clipboard-with-paper"></use>
                            </svg>To-do List
                        </div>

    					<div class="panel-body">
    						<ul class="todo-list">

    						    <li class="todo-list-item">

    								<div class="checkbox">
    									<input type="checkbox" id="checkbox" />
    									<label for="checkbox">Check Grades</label>
    								</div>

    								<div class="pull-right action-buttons">

    									<a href="#">
                                            <svg class="glyph stroked pencil">
                                                <use xlink:href="#stroked-pencil"></use>
                                            </svg>
                                        </a>

    									<a href="#" class="flag">
                                            <svg class="glyph stroked flag">
                                                <use xlink:href="#stroked-flag"></use>
                                            </svg>
                                        </a>

    									<a href="#" class="trash">
                                            <svg class="glyph stroked trash">
                                                <use xlink:href="#stroked-trash"></use>
                                            </svg>
                                        </a>
    								
                                    </div>

    							</li>

    							<li class="todo-list-item">
    								
                                    <div class="checkbox">
    									<input type="checkbox" id="checkbox" />
    									<label for="checkbox">Update Teachers</label>
    								</div>

    								<div class="pull-right action-buttons">
    									
                                        <a href="#">
                                            <svg class="glyph stroked pencil">
                                                <use xlink:href="#stroked-pencil"></use>
                                            </svg>
                                        </a>
    									
                                        <a href="#" class="flag">
                                            <svg class="glyph stroked flag">
                                                <use xlink:href="#stroked-flag"></use>
                                            </svg>
                                        </a>

    									<a href="#" class="trash">
                                            <svg class="glyph stroked trash">
                                                <use xlink:href="#stroked-trash"></use>
                                            </svg>
                                        </a>	
                                    </div>

    							</li>
    					
    							
    							<li class="todo-list-item">
    								
                                    <div class="checkbox">
    									<input type="checkbox" id="checkbox" />
    									<label for="checkbox">Kill Students</label>
    								</div>
    								
                                    <div class="pull-right action-buttons">
    									
                                        <a href="#">
                                            <svg class="glyph stroked pencil">
                                                <use xlink:href="#stroked-pencil"></use>
                                            </svg>
                                        </a>
    									
                                        <a href="#" class="flag">
                                            <svg class="glyph stroked flag">
                                                <use xlink:href="#stroked-flag"></use>
                                            </svg>
                                        </a>
    									
                                        <a href="#" class="trash">
                                            <svg class="glyph stroked trash">
                                                <use xlink:href="#stroked-trash"></use>
                                            </svg>
                                        </a>

    								</div>

    							</li>

    							<li class="todo-list-item">

    								<div class="checkbox">
    									<input type="checkbox" id="checkbox" />
    									<label for="checkbox">Destroy school</label>
    								</div>

    								<div class="pull-right action-buttons">

    									<a href="#">
                                            <svg class="glyph stroked pencil">
                                                <use xlink:href="#stroked-pencil"></use>
                                            </svg>
                                        </a>
    									
                                        <a href="#" class="flag">
                                            <svg class="glyph stroked flag">
                                                <use xlink:href="#stroked-flag"></use>
                                            </svg>
                                        </a>
    									
                                        <a href="#" class="trash">
                                            <svg class="glyph stroked trash">
                                                <use xlink:href="#stroked-trash"></use>
                                            </svg>
                                        </a>

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
    								
    			</div>
                <!--/.col-->


    			<!--CALENDAR-->
    			<div class="col-md-4">
    				<div class="panel panel-red">
    					
                        <div class="panel-heading dark-overlay">
                            <svg class="glyph stroked calendar">
                                <use xlink:href="#stroked-calendar"></use>
                            </svg>Calendar
                        </div>
    					
                        <div class="panel-body">
    						<div id="calendar"></div>
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
