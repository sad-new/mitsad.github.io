<?php


include 'b_ConnectionString.php';

	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	    switch($action) 
	    {	  


   	    	case '1' : load_Modal_SchoolYears();break;
          case '2' : load_Modal_GradeLevels();break;
   	    	case '3' : load_Modal_Sections();break;
          case '4' : load_Modal_Subjects();break;
          case '5' : load_Modal_Teachers();break;

	       	case '11' : submitNewClass();break;
	       	case '12' : retrieveClass();break; 
	       	case '13' : updateClass();break; 
	       	case '14' : deleteClass();break;

	       	case '21' : load_Main_SYTerms(); break;
	        case '22' : load_Main_GradeLevels(); break;
	        case '23' : load_Main_ClassTableEntries();break;

	      //default : echo 'NOTHING';break;
	    }
	}


   //---------------------------------------------------------------------------
   // _ M A I N _   A J A X E S
   //---------------------------------------------------------------------------

   // 21 
	function load_Main_SYTerms()
	{
		$syTermArray = [];

		$query = 
         "SELECT 
            sy.syTermID,
            sy.schoolYear, sy.termNumber,
            IFNULL(COUNT(c.syTermID_Classes), 0) AS 'children'
          
          FROM                 
          (
             SELECT * from syterms 
          ) AS sy  
       
          LEFT JOIN 
           (
              SELECT * FROM classes 
           ) as c 
          ON c.syTermID_Classes = sy.syTermID
          GROUP by sy.schoolYear ASC, sy.termNumber ASC;
         ";


		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  


		while($getRow = mysql_fetch_assoc($tableQuery))
		{
         $syTermArray[] = $getRow;
		}

		echo json_encode($syTermArray);

	}


   // 22
    function load_Main_GradeLevels()
    {
      $captured_SYTermIDStart = $_POST['sent_SYTermIDStart'];

      $GradeLevelArray = [];
      
      $query = 
         "
            SELECT 
               gl.gradeLevelID,
               gl.gradeLevelName,
               IFNULL(COUNT(c.gradeLevelID_Classes), 0) AS 'children'
            FROM 
               gradeLevels as gl  
    
             LEFT JOIN 
               (
                  SELECT * FROM classes 
                  WHERE syTermID_Classes = '".$captured_SYTermIDStart."'
               ) as c 
             ON c.gradeLevelID_Classes = gl.gradeLevelID
             GROUP by gl.gradeLevelID
         ";


        $tableQuery = mysql_query($query) 
            or die ("cannot load tables");  


        while($getRow = mysql_fetch_assoc($tableQuery))
        {
            $gradeLevelArray[] = $getRow;
        }

        echo json_encode($gradeLevelArray); 

    }

   // 23
	function load_Main_ClassTableEntries()
	{
      $captured_GradeLevelID = $_POST['sent_GradeLevel']; 
      $captured_SYTermID = $_POST['sent_SYTermID'];

		  $sectionArray = array();

        $query = 
            '
            SELECT 
            sectionID, 
            sectionName, 
            IFNULL(COUNT(c.sectionID_Classes), 0) AS "children"
            FROM sections as s

            LEFT JOIN 
            (
              SELECT 
              sectionID_Classes, 
              sytermID_Classes
              FROM classes
              WHERE sytermID_Classes = '.$captured_SYTermID.'
              GROUP BY sectionID_Classes
              
            ) as c

            ON c.sectionID_Classes = s.sectionID
            WHERE s.gradeLevelID_Sections = '.$captured_GradeLevelID.'
            GROUP BY s.sectionID       
            ';                

        $tableQuery = mysql_query($query) 
            or die ("cannot load tables");  

        $counter = 0;
        while($getRow = mysql_fetch_assoc($tableQuery))
        {
            $sectionArray[$counter]['sectionID'] = $getRow['sectionID'];
            $sectionArray[$counter]['sectionName'] = $getRow['sectionName'];
            $sectionArray[$counter]['children'] = $getRow['children'];
            $sectionArray[$counter]['classTable'] = load_Main_ClassTableEntries_Subtable(
              $captured_SYTermID, $getRow['sectionID']);


            $counter++;
        }


		echo json_encode($sectionArray);
	}


  function load_Main_ClassTableEntries_Subtable($var_SYTermID, $var_SectionID)
  {

    $classArray = array();
    
    $query = 
    '
    SELECT merged.classID, merged.subjectName, merged.subjectID, merged.employeeName
    FROM
    (
      SELECT * FROM classes

      INNER JOIN subjects 
      ON classes.subjectID_Classes = subjects.subjectID
      
      INNER JOIN employees 
      ON classes.adviserID_Classes = employees.employeeID

      WHERE classes.sectionID_Classes = '.$var_SectionID.' 
      AND classes.syTermID_Classes = '.$var_SYTermID.'
    ) as merged
    ';

    $tableQuery = mysql_query($query) 
    or die ("cannot load tables");  


    while($getRow = mysql_fetch_assoc($tableQuery))
    {
        $classArray[] = $getRow;
    }

    return $classArray;
  }


	//---------------------------------------------------------------------------
	// _ M O D A L _   A J A X E S
	//---------------------------------------------------------------------------

   // 1
	function load_Modal_SchoolYears()
	{
		$syTermArray = array();

		$query = 'SELECT * FROM syterms';
		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  


		while($getRow = mysql_fetch_assoc($tableQuery))
		{
			$syTermArray[] = $getRow;
		}


		echo json_encode($syTermArray);
	}


   // 2
   function load_Modal_GradeLevels()
   {
      $gradeLevelArray = array();

       $query = 
         "SELECT gradeLevelID, gradeLevelName FROM gradeLevels 
         ORDER BY gradeLevelID ASC";

      $tableQuery = mysql_query($query) 
         or die ("cannot load tables");  

      while($getRow = mysql_fetch_array($tableQuery))
      {
         $gradeLevelArray[] = $getRow;
      }

      echo json_encode($gradeLevelArray);    
   }


   // 3
	function load_Modal_Sections()
	{
    $captured_GradeLevel = $_POST['sent_GradeLevel'];
		$sectionArray = array();


		$query = 
      'SELECT * FROM sections 
		  INNER JOIN gradeLevels 
		  ON gradeLevels.gradeLevelID = sections.gradeLevelID_Sections
      WHERE gradeLevels.gradeLevelID = '.$captured_GradeLevel.';';
		

      $tableQuery = mysql_query($query) 
			or die ("cannot load tables");  

		while($getRow = mysql_fetch_assoc($tableQuery))
		{
			$sectionArray[] = $getRow;
		}

		echo json_encode($sectionArray);
	}


  // 4
  function load_Modal_Subjects()
  {
    $captured_GradeLevel = $_POST['sent_GradeLevel'];
    $subjectArray = array();


    $query = 
      'SELECT * FROM subjects 
      INNER JOIN gradeLevels 
      ON gradeLevels.gradeLevelID = subjects.gradeLevelID_Subjects
      WHERE gradeLevels.gradeLevelID = '.$captured_GradeLevel.';';
    

      $tableQuery = mysql_query($query) 
      or die ("cannot load tables");  

    while($getRow = mysql_fetch_assoc($tableQuery))
    {
      $subjectArray[] = $getRow;
    }

    echo json_encode($subjectArray);
  }


  // 5
  function load_Modal_Teachers()
  {
    $teacherArray = array();

    $query = 'SELECT * FROM employees ORDER BY employeeID ASC';
    $tableQuery = mysql_query($query) 
      or die ("cannot load tables");  

    while($getRow = mysql_fetch_assoc($tableQuery))
    {
      $teacherArray[] = $getRow;
    }

    echo json_encode($teacherArray);
  }



	//---------------------------------------------------------------------------
	// C R U D
	//---------------------------------------------------------------------------	

   // 11

	function submitNewClass()
	{
		$capturedSYTermID  = $_POST['sendSYTermID'];
    $capturedGradeLevelID = $_POST['sendGradeLevelID'];
		$capturedSectionID = $_POST['sendSectionID'];
    $capturedSubjectID = $_POST['sendSubjectID'];
    $capturedTeacherID = $_POST['sendTeacherID'];

		$query = 
      "
      INSERT INTO classes 
      (syTermID_Classes, gradeLevelID_Classes, sectionID_Classes, subjectID_Classes, adviserID_Classes) 
		  VALUES (
		  '".$capturedSYTermID."','".$capturedGradeLevelID."',
      '".$capturedSectionID."','".$capturedSubjectID."',
      '".$capturedTeacherID."'
		)";
		mysql_query($query);
	}


   // 12
	function retrieveClass()
	{
		$capturedClassID = $_POST['sendClassID'];

		$query = "SELECT * FROM classes WHERE classID = '".$capturedClassID."';";

		$result = mysql_query($query);
		$returnValue = mysql_fetch_array($result);

		echo json_encode($returnValue);
	}

   // 13
	function updateClass()
	{
    $capturedClassID   = $_POST['sendClassID'];
    
		$capturedSYTermID  = $_POST['sendSYTermID'];
		$capturedSectionID = $_POST['sendSectionID'];
    $capturedSubjectID = $_POST['sendSubjectID'];
    $capturedTeacherID = $_POST['sendTeacherID'];

      $query = 
      "
      SELECT gradeLevelID_Sections FROM sections 
      WHERE sectionID = $capturedSectionID;  
      ";

      $tableQuery = mysql_query($query);
      $getRow = mysql_fetch_assoc($tableQuery);

		$query = "UPDATE classes 
		SET 
		syTermID_Classes  = '"     .$capturedSYTermID."',
    gradeLevelID_Classes = '".$getRow['gradeLevelID_Sections']."',
		sectionID_Classes = '"     .$capturedSectionID."',
    subjectID_Classes = '"     .$capturedSubjectID."',
    adviserID_Classes = '"     .$capturedTeacherID."'  
		WHERE
		classID = '$capturedClassID';";

		mysql_query($query);
	}


   // 14 
	function deleteClass()
	{
		$capturedClassID   = $_POST['sendClassID'];

		$query = "delete from classes where classID = $capturedClassID";
		mysql_query($query);
	}


   //---------------------------------------------------------------------------
   // N O N   A J A X   F U N C T I O N S
   //---------------------------------------------------------------------------


    function checkTableSize()
    {
        $query = 'SELECT COUNT(*) FROM classes';
        $result = mysql_query($query); 
        $tableCount = mysql_fetch_row($result);
        return $tableCount[0];
    }




    function tableCount()
    {
      $query = 
      "
         select 
         (select count(*) from syTerms) as syTermCount, 
         (Select count(*) from subjects) as subjectCount, 
         (select count(*) from sections) as sectionCount 
      ";

        $result = mysql_query($query); 
        $otherTableCount = mysql_fetch_row($result);
        return $otherTableCount;
    }




?>
