<?php

include 'b_ConnectionString.php';

	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) 
	{
    	$action = $_POST['action'];
	    switch($action) 
	    {
	    	case '1' : loadSYTerms() ; break;
	    	case '2' : loadGradeLevels() ; break;
	    	case '3' : loadSections() ; break;
	    	case '4' : loadSubjects() ; break;

	    	case '5' : getClass() ; break;

	    	case '11' : getWWAverageGradeData() ; break;
	    	case '12' : getPTAverageGradeData() ; break;
	    	case '13' : getPassFailGradeData() ; break;
	    	case '14' : getFinalGradeData() ; break;

	        //default : echo 'NOTHING';break;
	    }
	}


//---------------------------------------------------------------------------
// D R O P D O W N S
//---------------------------------------------------------------------------


	// 1
	function loadSYTerms()
	{
    include "b_ConnectionString.php";

		$syTermArray = [];


		$query = 
			'select DISTINCT merged.syTermID, merged.schoolYear, merged.termNumber from 
			( 
				select * from grades 
				INNER JOIN 
				(select * from classes) as classes 
				ON classes.classID = classID_Grades 
				INNER JOIN 
				(select * from syterms) as syterms 
				ON classes.syTermID_Classes = syterms.syTermID 
			) 
			as merged';


		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  


		while($getRow = mysqli_fetch_assoc($tableQuery))
		{


			$syTermArrayEntry = [];
			$syTermArrayEntry['syTermID'] = $getRow['syTermID'];
			$syTermArrayEntry['schoolYear'] = $getRow['schoolYear'];
			$syTermArrayEntry['termNumber'] = $getRow['termNumber'];
			
			$syTermArray[] = $syTermArrayEntry;
		}

		echo json_encode($syTermArray);

	}

	// 2
	function loadGradeLevels()
	{

    include "b_ConnectionString.php";


		$captured_SchoolYear = $_POST['sent_SchoolYear'];

		$gradeLevelArray = [];

		$query = 
					'select DISTINCT merged.gradeLevelID_Sections, merged.syTermID from 
					( 
						select * from grades 
						INNER JOIN 
						(select * from classes) as classes 
						ON classes.classID = grades.classID_Grades 
						INNER JOIN 
						(select * from sections) as sections 
						ON classes.sectionID_Classes = sections.sectionID 
						INNER JOIN 
						(select * from syterms) as syterms 
						ON classes.syTermID_Classes = syterms.syTermID 
					) 
					as merged
					WHERE merged.syTermID = '.$captured_SchoolYear.'';


		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			$gradeLevelArrayEntry = [];
			$gradeLevelArrayEntry['gradeLevelID'] = $getRow['gradeLevelID_Sections'];

			$gradeLevelArray[] = $gradeLevelArrayEntry;
		}

		echo json_encode($gradeLevelArray);

	}

	// 3
	function loadSections()
	{
    
    include "b_ConnectionString.php";


		$captured_SchoolYear = $_POST['sent_SchoolYear'];
		$captured_GradeLevel = $_POST['sent_GradeLevel'];
		
		$sectionArray = [];

		$query = 
					'select DISTINCT merged.sectionID, merged.sectionName from 
					( 
						select * from grades 
						INNER JOIN 
						(select * from classes) as classes 
						ON classes.classID = grades.classID_Grades 
						INNER JOIN 
						(select * from sections) as sections 
						ON classes.sectionID_Classes = sections.sectionID 
						INNER JOIN 
						(select * from syterms) as syterms 
						ON classes.syTermID_Classes = syterms.syTermID 
					) 
					as merged
					WHERE merged.syTermID = '. $captured_SchoolYear .' AND merged.gradeLevelID_Sections ='. $captured_GradeLevel .'';


		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			$sectionArrayEntry = [];
			$sectionArrayEntry['sectionID'] = $getRow['sectionID'];
			$sectionArrayEntry['sectionName'] = $getRow['sectionName'];

			$sectionArray[] = $sectionArrayEntry;
		}

		echo json_encode($sectionArray);

	}

	// 4
	function loadSubjects()
	{

    include "b_ConnectionString.php";

		$captured_SectionID = $_POST['sent_SectionID'];
		$captured_SchoolYear = $_POST['sent_SchoolYear'];

		$subjectArray = [];

		$query = 
					'select DISTINCT merged.subjectID, merged.subjectName from 
					( 
						select * from grades 
						INNER JOIN 
						(select * from classes) as classes 
						ON classes.classID = grades.classID_Grades 
						INNER JOIN 
						(select * from sections) as sections 
						ON classes.sectionID_Classes = sections.sectionID 
						INNER JOIN 	
						(select * from subjects) as subjects
						ON classes.subjectID_Classes = subjects.subjectID	
					)
					as merged
					WHERE merged.sectionID = '.$captured_SectionID. ' AND merged.syTermID_Classes = '.$captured_SchoolYear.'';  


		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			$subjectArrayEntry = [];
			$subjectArrayEntry['subjectID'] = $getRow['subjectID'];
			$subjectArrayEntry['subjectName'] = $getRow['subjectName'];

			$subjectArray[] = $subjectArrayEntry;
		}

		echo json_encode($subjectArray);
	}



//---------------------------------------------------------------------------
// G E T   C L A S S
//---------------------------------------------------------------------------

	// 5
	function getClass()
	{

    include "b_ConnectionString.php";


		$captured_Selections = $_POST['sent_SchoolYear'];
		$captured_Section = $_POST['sent_Section'];
		$captured_Subject = $_POST['sent_Subject'];

		$selectedClass = ''; 

		$query = 
			'select classID 

			from classes

			WHERE syTermID_Classes = ' . $captured_Selections . 
			' and sectionID_Classes = ' . $captured_Section . 
			' and subjectID_Classes = ' . $captured_Subject .
			'';

		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			//$gradeArrayEntry = [];
			$selectedClass = $getRow['classID'];

		}		

		echo json_encode($selectedClass);
	}


//---------------------------------------------------------------------------
// C H A R T S
//---------------------------------------------------------------------------


	// 11
	function getWWAverageGradeData()
	{

    include "b_ConnectionString.php";

		$captured_ClassID = $_POST['sent_ClassID'];

		$gradeArray = [];

		$query = 
			'select
			avg(ww_1) AS ww_1, avg(ww_2) AS ww_2, avg(ww_3) AS ww_3, 
			avg(ww_4) AS ww_4, avg(ww_5) AS ww_5, avg(ww_6) AS ww_6, 
			avg(ww_7) AS ww_7, avg(ww_8) AS ww_8, avg(ww_9) AS ww_9, avg(ww_10) AS ww_10

			from grades 
			WHERE classID_Grades = '.$captured_ClassID.'';		

		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		//iterate each and every one of the elements inside fetch assoc.
	
		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			//$gradeArrayEntry = [];
			$gradeArray[] = $getRow;

		}

		echo json_encode($gradeArray);
	}


	// 12
	function getPTAverageGradeData()
	{
    
    include "b_ConnectionString.php";

		$captured_ClassID = $_POST['sent_ClassID'];

		$gradeArray = [];

		$query = 
			'select
			avg(pt_1) AS pt_1, avg(pt_2) AS pt_2, avg(pt_3) AS pt_3, 
			avg(pt_4) AS pt_4, avg(pt_5) AS pt_5, avg(pt_6) AS pt_6, 
			avg(pt_7) AS pt_7, avg(pt_8) AS pt_8, avg(pt_9) AS pt_9, avg(pt_10) AS pt_10


			from grades 
			WHERE classID_Grades = '.$captured_ClassID.'';		

		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		//iterate each and every one of the elements inside fetch assoc.
	
		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			//$gradeArrayEntry = [];
			$gradeArray[] = $getRow;

		}

		echo json_encode($gradeArray);
	}


	// 13
	function getPassFailGradeData()
	{

    include "b_ConnectionString.php";


		$captured_ClassID = $_POST['sent_ClassID'];

		$gradeArray = [];

		$query = 
		'
			select 

			COUNT(IF(quarterly_grade >= 75,1, NULL)) as PASS, 
			COUNT(IF(quarterly_grade < 75,1, NULL)) as FAIL 

			from grades where classID_Grades = '.$captured_ClassID.'
		';

		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		//iterate each and every one of the elements inside fetch assoc.
	
		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			$gradeArray[] = $getRow;
		}

		echo json_encode($gradeArray);

	}

	// 14
	function getFinalGradeData()
	{

    include "b_ConnectionString.php";


		$captured_ClassID = $_POST['sent_ClassID'];

		$gradeArray = [];

		$query = 
			'select 
			student_ID, student_name, 
			quarterly_grade

			from grades 
			WHERE classID_Grades = '.$captured_ClassID.'';		

		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		//iterate each and every one of the elements inside fetch assoc.	
		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			//$gradeArrayEntry = [];
			$gradeArray[] = $getRow;

		}

		echo json_encode($gradeArray);
	}


?>