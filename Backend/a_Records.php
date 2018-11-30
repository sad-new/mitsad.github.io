<?php

	include 'b_ConnectionString.php';


		//function selection block	
		if(isset($_POST['action']) && !empty($_POST['action'])) 
		{
	    $action = $_POST['action'];
		    switch($action) 
		    {
		    	case '1' : getGradesTable() ; break ;

		        //default : echo 'NOTHING';break;
		    }
		}


	function loadAccountType($accountNumber)
	{
		$query = '';
	}


	function loadDropDownSYTerm($userType, $accountNumber)
	{
		include "b_ConnectionString.php";

		$classArray = array();

		$query = 
			'SELECT * from 
			(		
				SELECT DISTINCT 
					classID, subjectID_Classes, 
					sectionID_Classes, syTermID_Classes, 
					adviserID_Classes 
				FROM classes 
				
				INNER JOIN
				( SELECT classID_Grades, accountID_Grades from grades ) AS C1
				ON classes.classID = C1.classID_Grades 
			) as J0

			INNER JOIN
			( SELECT sectionID, sectionName, gradeLevelID_Sections FROM sections ) AS J1 
			ON J0.sectionID_Classes = J1.sectionID 			
			INNER JOIN
			( SELECT  subjectID, subjectName FROM subjects ) AS J2 
			ON J0.subjectID_Classes = J2.subjectID			
			INNER JOIN
			( SELECT employeeID, employeeName FROM employees ) AS J3
			ON J0.adviserID_Classes = J3.employeeID			
			INNER JOIN
			( SELECT syTermID, schoolYear, termNumber FROM syTerms ) AS J4
			ON J0.syTermID_Classes = J4.syTermID
			INNER JOIN
			( SELECT employeeID, accountID_Employees from employees ) as J5
			ON J0.adviserID_Classes = J5.employeeID 



      ';

			if ($userType != 'schoolAdministrator')
			{
				$query .= 'AND J5.accountID_Employees = '.$accountNumber.' ';
			}


		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_array($tableQuery))
		{
			//fill one row of the array
			$classEntry = array();

			$classEntry['classID']     = $getRow['classID'];

			$classEntry['syTermID']     = $getRow['syTermID'];
			$classEntry['schoolYear']     = $getRow['schoolYear'];
			$classEntry['termNumber']     = $getRow['termNumber'];

			$classEntry['sectionID']     = $getRow['sectionID'];
			$classEntry['sectionName']   = $getRow['sectionName'];
			$classEntry['gradeLevelID_Sections']   = $getRow['gradeLevelID_Sections'];

			$classEntry['subjectID']   = $getRow['subjectID'];
			$classEntry['subjectName']   = $getRow['subjectName'];

			$classEntry['employeeID']  = $getRow['employeeID'];
			$classEntry['employeeName']  = $getRow['employeeName'];

			$classArray[] = $classEntry;
		}

		return $classArray;
	}






	//1
	function getGradesTable()
	{
		include "b_ConnectionString.php";
		
		$capturedSelectedClass  = $_POST['selectedClass'];

		$gradeArray = [];

		$colNames = getColumnNames();
		$gradeArray[] = $colNames;

	 	//ENTRIES
		$capturedGradeArray = getGradeEntries($colNames, $capturedSelectedClass);
		foreach($capturedGradeArray as $gradeArrayEntry)
	 	{
		 	//$string1=implode(",",$string);

	 		$arrayEntry = [];

	 		foreach($gradeArrayEntry as $GradeArrayEntryElement)
	 		{
	 			$arrayEntry[] =  $GradeArrayEntryElement;
	 		}
	 		$gradeArray[] = $arrayEntry;
		}


		echo json_encode($gradeArray);
	}



			// echo 'script language="javascript">';
			// echo('alert("THIS TOOL IS INVALUABLE. USE THIS TO MAKE ALERTS!");');
			// echo '</script>';



	//TABLE: COLUMN NAMES
	function getColumnNames()
	{
		include "b_ConnectionString.php";

		$query = 'show columns from grades;';
		$tableQuery = mysqli_query($mySQL_ConStr, $query); 

		//array of column Names
		$colNames = [];

		//place extracted field to the array
		while ($getRow = mysqli_fetch_array($tableQuery))
		{
			$colNames[] = $getRow['Field'];
		}

		return $colNames;
	}


	//TABLE: TABLE ENTRIES
	function getGradeEntries($colNames, $capturedSelectedClass)
	{
		include "b_ConnectionString.php";


		$gradeArray = array();

		$query = 'select * from grades where classID_Grades = ' .$capturedSelectedClass;
		$tableQuery = mysqli_query($mySQL_ConStr, $query); 

		while ($row = mysqli_fetch_array($tableQuery))
		{
			$rowEntry = array();
			for ($i = 0; $i < count($colNames) ; $i++)
			{
				$rowEntry[strval($colNames[$i])] = $row[strval($colNames[$i])];

			}
			$gradeArray[] = $rowEntry;
		}		

		return $gradeArray;
	}


?>