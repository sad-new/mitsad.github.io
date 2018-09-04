<?php


include 'b_ConnectionString.php';



	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) 
	{
	    $action = $_POST['action'];
		    switch($action) 
		    {
		    	case '1' : loadCharts();break;
		        //default : echo 'NOTHING';break;
		    }
	}


	function loadCharts()
	{
		$gradeArray = array();

		$query = 'SELECT 
				AVG(ww_1) as ww_1, 
				AVG(ww_2) as ww_2, 
				AVG(ww_3) as ww_3, 
				AVG(ww_4) as ww_4, 
				AVG(ww_5) as ww_5, 
				AVG(ww_6) as ww_6, 
				AVG(ww_7) as ww_7, 
				AVG(ww_8) as ww_8, 
				AVG(ww_9) as ww_9, 
				AVG(ww_10) as ww_10, 

				AVG(ww_total) as ww_total,
				AVG(ww_ps) as ww_ps, 
				AVG(ww_ws) as ww_ws
				from import';


		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  

		while($getRow = mysql_fetch_assoc($tableQuery))
		{
			$gradeArray[] = $getRow;
		}

		//echo json_encode($gradeArray);
	}

?>