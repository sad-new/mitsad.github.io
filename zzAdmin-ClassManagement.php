


<?php

	include "Backend/b_ConnectionString.php";
	//$dbConnection = mysqli_connect($mySQL_HostName, $mySQL_User, $mySQL_Password, $mySQL_Database); 

	$path = $_SERVER['DOCUMENT_ROOT'];
	$path .= "/SADnew/Backend/a_ClassManagement.php";
	include_once($path);

	//check if success or fail
	echo "";  
?>



<!DOCTYPE html>
<html>




<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin-School Management</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

		<!--more Javascripts-->
		<script type="text/javascript" src="js/jquery-3.2.1.slim.min.js"></script>
 		<script type="text/javascript" src="js_created/js_ClassManagement.js"></script> 



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
				<a class="navbar-brand" href="#"><span>Admin</span></a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="userinfo.php"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<!--LOGOUT-->
							<li><a href="login.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
	
		<!--Side Bar-->
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		
			<ul class="nav menu">
				<li><a href="Admin-Dashboard.php">Dashboard</a></li>
				
				<li role="presentation" class="divider"></li>
				
				<li><a href="Admin-SYTermManagement.php">SY Term Management</a></li>
				<li><a href="Admin-AccountsManagement.php">Accounts Management</a></li>
				<li><a href="Admin-SectionManagement.php">Section Management</a></li>
				<li><a href="Admin-SubjectManagement.php">Subject Management</a></li>
				<li class = "active"><a href="Admin-ClassManagement.php">Class Management</a></li>
				
				<li role="presentation" class="divider"></li>
				
				<li><a href="Admin-Charts.php">Charts</a></li>
				<li><a href="Admin-Records.php">Records</a></li>
				<li><a href="Admin-Uploads.php">Uploads</a></li>
				
				<li role="presentation" class="divider"></li>
				
				<li><a href="Admin-UserInfo.php">User Info</a></li>
			</ul>
		</div>
	<!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Class Management</h1>
			</div>
		</div><!--/.row-->
		
	
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Assign Teachers here</div>

						<div class="container">

							<!-- THIS IS THE GIANT BOX.  -->
<!-- 							<div class="container-fluid  assign-teacher">
								<div class="row">


									<div class="col-sm-2 col-md-5 col-lg-3">
										<div class="form-group">
											<label>Level</label>
											<select class="form-control" 
												id = "dropDown_GradeLevel">
												<option value = '1' selected="selected">Grade 1</option>
												<option value = '2'>Grade 2</option>
												<option value = '3'>Grade 3</option>
												<option value = '4'>Grade 4</option> 
											</select>
										</div>
									</div>
										

									<div class="col-sm-2 col-md-5 col-lg-3">
										<div class="form-group">
											<label>Section</label>
												<select class="form-control"
												id = "dropDown_Section">
											


												</select>
												<br>
												<button type="submit" 
												class="btn btn-primary"
												id = "schoolManagement_AddSection">Add Section</button>
										</div>
									</div>


									<div class="col-sm-2 col-md-5 col-lg-3">
										<div class="form-group">
											<label>Subjects</label>
											<select class="form-control"
											id = "dropDown_Subject">


											</select>
										</div>
									</div>
								</div>
							</div> -->






						<br>
						<div class="buttom">
							<button class="btn btn-primary"
							id = "schoolManagement_SelectAdd">Select/Add</button>
						</div>
							</div>
							<!--Class Table-->
		<div class="row class">
		
        
        <div class="col-md-12">
        <h4></h4>
        <div class="table-responsive">

                
              <table id="mytable" class="table table-bordred table-striped">
                   
                   <thead>
                   
                  
                   <th>Grade Level</th>
                   <th>Section Name</th>
                   <th>Subject Name</th>
                   <th>Assigned Teacher</th> 

                   <th> </th>   
                   <th> </th>
                   </thead>
    <tbody>
    
		    	<?php

 
					$classArray = loadTables();  

					$counter = 1;

								
					foreach ($classArray as $getRow)
					{
						//GET FROM SERVER
						$yearLevel_Get = $getRow['yearLevel'];
						$sectionID_Get = $getRow['sectionID'];
						$sectionName_Get = $getRow['sectionName'];

						$subjectID_Get = $getRow['subjectID'];
						$subjectName_Get = $getRow['subjectName'];

						$employeeID_Get = $getRow['employeeID'];
						$employeeName_Get = $getRow['employeeName'];

						echo "<tr>"; 
						//SET TO TABLE
						echo "<td value = ".$yearLevel_Get."><center> Grade ".$yearLevel_Get.   "</center></td>";
						echo "<td value = ".$sectionID_Get."><center>"       .$sectionName_Get. "</center></td>";
						echo "<td value = ".$subjectID_Get."><center>"       .$subjectName_Get. "</center></td>";
						echo "<td value = ".$employeeID_Get."><center>"      .$employeeName_Get."</center></td>";
					}


					echo '<td><p data-placement="top" 
					data-toggle="tooltip" 
					title="Edit">
					<button class="btn btn-primary btn-xs" 
					data-title="Edit" 
					data-toggle="modal" 
					data-target="#edit" >
					<span class="glyphicon glyphicon-pencil"></span></button></p></td>';

		    		echo '<td><p data-placement="top" 
		    		data-toggle="tooltip" 
		    		title="Delete">
		    		<button class="btn btn-danger btn-xs" 
		    		data-title="Delete" 
		    		data-toggle="modal" 
		    		data-target="#delete" >
		    		<span class="glyphicon glyphicon-trash"></span></button></p></td>';
				?>
		    

	    </tr>
      
    </tbody>
        
</table>

                
            </div>
            
        </div>
	</div>

<!--/Class Table-->

						
				</div>
			</div>
		</div>
	</div>	<!--/.main-->



	<!--MODAL-->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Edit</h4>
      </div>
          <div class="modal-body">

								<div class="form-group">
									<div class="col-sm-2 col-md-5 col-lg-3">
										<div class="form-group">
											<label>Select Teacher</label>
												<select class="form-control">
													<option>Pedro</option>
													<option>Aldrin</option>
												</select>
										</div>
									</div>
								</div>


								        

      </div>
          <div class="modal-footer ">
        <button type="button" 
        class="btn btn-warning btn-lg" 
        style="width: 100%;"
        id = "schoolManagement_Update"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
    </div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
          <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this?</div>
       
      </div>
        <div class="modal-footer ">
        <button type="button" class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
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



	<!--ACTIVATE OTHER SCRIPTS-->
	<script>
		changeSections();
		changeSubjects();
	</script>



</body>

</html>
