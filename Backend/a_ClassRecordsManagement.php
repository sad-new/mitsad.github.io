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

	       	case '11' : submitNewClass();break;
	       	case '12' : retrieveClass();break; 
	       	case '13' : updateClass();break; 
	       	case '14' : deleteClass();break;

	       	case '21' : load_Main_SYTerms(); break;
	        case '22' : load_Main_GradeLevels(); break;
	        case '23' : load_Main_ClassTableEntries();break;


          case '31' : checkNewEntryForExistence(); break;
          case '32' : checkExistingEntry(); break;


	      //default : echo 'NOTHING';break;
	    }
	}




	//---------------------------------------------------------------------------
	// _ M O D A L _   A J A X E S
	//---------------------------------------------------------------------------

   // 1
	function load_Modal_SchoolYears()
	{
    include 'b_ConnectionString.php';

		$syTermArray = array();

		$query = 'SELECT * FROM syterms WHERE termNumber = 1';
		$tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  


		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			$syTermArray[] = $getRow;
		}


		echo json_encode($syTermArray);
	}


   // 2
   function load_Modal_GradeLevels()
   {
      include 'b_ConnectionString.php';
   
      $gradeLevelArray = array();

       $query = 
         "SELECT gradeLevelID, gradeLevelName FROM gradelevels 
         ORDER BY gradeLevelID ASC";

      $tableQuery = mysqli_query($mySQL_ConStr, $query) 
         or die ("cannot load tables");  

      while($getRow = mysqli_fetch_array($tableQuery))
      {
         $gradeLevelArray[] = $getRow;
      }

      echo json_encode($gradeLevelArray);    
   }


   // 3
	function load_Modal_Sections()
	{
    include 'b_ConnectionString.php';

    $captured_GradeLevel = $_POST['sent_GradeLevel'];
		$sectionArray = array();


		$query = 
      'SELECT * FROM sections 
		  INNER JOIN gradelevels 
		  ON gradelevels.gradeLevelID = sections.gradeLevelID_Sections
      WHERE gradelevels.gradeLevelID = '.$captured_GradeLevel.';';
		

      $tableQuery = mysqli_query($mySQL_ConStr, $query) 
			or die ("cannot load tables");  

		while($getRow = mysqli_fetch_assoc($tableQuery))
		{
			$sectionArray[] = $getRow;
		}

		echo json_encode($sectionArray);
	}


	//---------------------------------------------------------------------------
	// C R U D
	//---------------------------------------------------------------------------	

   // 11

	function submitNewClass()
	{
    include 'b_ConnectionString.php';

		$capturedSYTermID  = $_POST['sendSYTermID'];
    $capturedGradeLevelID = $_POST['sendGradeLevelID'];
		$capturedSectionID = $_POST['sendSectionID'];


		$query = 
      "
      INSERT INTO classes 
      (syTermID_Start_Classes, gradeLevelID_Classes, sectionID_Classes) 
		  VALUES (
		  '".$capturedSYTermID."','".$capturedGradeLevelID."',
      '".$capturedSectionID."'
		)";
		mysqli_query($mySQL_ConStr, $query);
	}


   // 12
	function retrieveClass()
	{
    include 'b_ConnectionString.php';

		$capturedClassID = $_POST['sendClassID'];

		$query = "SELECT * FROM classes WHERE classID = '".$capturedClassID."';";

		$result = mysqli_query($mySQL_ConStr, $query);
		$returnValue = mysqli_fetch_array($result);

		echo json_encode($returnValue);
	}

   // 13
	function updateClass()
	{
    include 'b_ConnectionString.php';

    $capturedClassID   = $_POST['sendClassID'];
		$capturedSYTermID  = $_POST['sendSYTermID'];
		$capturedSectionID = $_POST['sendSectionID'];


      $query = 
      "
        SELECT gradeLevelID_Sections FROM sections 
        WHERE sectionID = $capturedSectionID;  
      ";

      $tableQuery = mysqli_query($mySQL_ConStr, $query);
      $getRow = mysqli_fetch_assoc($tableQuery);

		$query = "UPDATE classes 
		SET 
		syTermID_Start_Classes  = '".$capturedSYTermID."',
    gradeLevelID_Classes = '".$getRow['gradeLevelID_Sections']."',
		sectionID_Classes = '"     .$capturedSectionID."'  
		WHERE
		classID = $capturedClassID;";

		mysqli_query($mySQL_ConStr, $query);
	}


   // 14 
	function deleteClass()
	{
    include 'b_ConnectionString.php';

		$capturedClassID   = $_POST['sendClassID'];
		$query = "delete from classes where classID = $capturedClassID";
		mysqli_query($mySQL_ConStr, $query);
	}



   //---------------------------------------------------------------------------
   // _ M A I N _   A J A X E S
   //---------------------------------------------------------------------------

   // 21 
  function load_Main_SYTerms()
  {
    include 'b_ConnectionString.php';


    $syTermArray = [];

    $query = 
         "SELECT 
        sy1.syTermID,
        sy1.schoolYear,
        IFNULL(COUNT(c.schoolYear), 0) AS 'children' 
        FROM syterms as sy1 
        LEFT JOIN 
        (
            SELECT * from classes 
            INNER JOIN (select * from syterms) as syterms 
            ON classes.syTermID_Start_Classes = syterms.sytermID
        ) as c
        ON c.schoolYear = sy1.schoolYear
        WHERE sy1.termNumber = 1
        GROUP BY sy1.schoolYear ASC

         ";


    $tableQuery = mysqli_query($mySQL_ConStr, $query) 
      or die ("cannot load tables");  


    while($getRow = mysqli_fetch_assoc($tableQuery))
    {
         $syTermArray[] = $getRow;
    }

    echo json_encode($syTermArray);

  }


 // 22
  function load_Main_GradeLevels()
  {
    include 'b_ConnectionString.php';

    $captured_SYTermIDStart = $_POST['sent_SYTermIDStart'];

    $GradeLevelArray = [];
    
    $query = 
       "SELECT 
          gl.gradeLevelID,
          gl.gradeLevelName,
          IFNULL(COUNT(c.gradeLevelID_Classes), 0) AS 'children'
        FROM 
          gradelevels as gl  

        LEFT JOIN 
        (
          SELECT * from classes 
          INNER JOIN (SELECT schoolyear, syTermID FROM syterms) AS syterms 
          ON classes.syTermID_Start_Classes = syterms.sytermID
          WHERE syterms.schoolYear = (SELECT schoolYear FROM syterms WHERE syTermID = '".$captured_SYTermIDStart."')
        ) as c 
        ON c.gradeLevelID_Classes = gl.gradeLevelID
        GROUP by gl.gradeLevelID;
       ";



      $tableQuery = mysqli_query($mySQL_ConStr, $query) 
          or die ("cannot load tables");  


      while($getRow = mysqli_fetch_assoc($tableQuery))
      {
          $gradeLevelArray[] = $getRow;
      }

      echo json_encode($gradeLevelArray); 

  }

   // 23
  function load_Main_ClassTableEntries()
  {
    include 'b_ConnectionString.php';

    $captured_GradeLevelID = $_POST['sent_GradeLevel']; 
    $captured_SYTermID = $_POST['sent_SYTermID'];

    $sectionArray = array();

      $query = 
          "SELECT 
          c.classID,
          sectionID, 
          sectionName, 
          studentCount
          FROM sections AS s

          INNER JOIN 
          (
      
            SELECT
              classID,
              sectionID_Classes, 
              sytermID_Start_Classes,
              syterms.syTermID, 
              IFNULL(COUNT(cs.classStudentID), 0) AS studentCount  
            FROM classes 
            
            LEFT JOIN
            classStudents as cs
            on cs.classID_ClassStudents = classes.classID
         
            LEFT JOIN
            (
              SELECT syTermID, schoolYear
              FROM syterms 
            ) AS syterms            
            ON syterms.syTermID = classes.sytermID_Start_Classes          
            
            WHERE syterms.schoolYear = 
            (
              SELECT schoolYear FROM syterms WHERE syTermID = ".$captured_SYTermID."
            )

            GROUP by classes.classID
                  
          ) as c
          ON s.sectionID = c.sectionID_Classes
          
          WHERE s.gradeLevelID_Sections = ".$captured_GradeLevelID." AND c.studentCount > 0

          ";                

      $tableQuery = mysqli_query($mySQL_ConStr, $query) 
          or die ("cannot load tables");  

      $counter = 0;
      while($getRow = mysqli_fetch_assoc($tableQuery))
      {
          $sectionArray[$counter]['classID'] = $getRow['classID'];
          $sectionArray[$counter]['sectionID'] = $getRow['sectionID'];
          $sectionArray[$counter]['sectionName'] = $getRow['sectionName'];
          $sectionArray[$counter]['studentCount'] = $getRow['studentCount'];
          //$sectionArray[$counter]['classTable'] = load_Main_ClassTableEntries_Subtable
          //($captured_SYTermID, $getRow['sectionID']);


          $counter++;
      }


    echo json_encode($sectionArray);
  }


   //---------------------------------------------------------------------------
   // E X I S T E N C E
   //---------------------------------------------------------------------------



  // 31

  function checkNewEntryForExistence()
  {
    include 'b_ConnectionString.php';

    $captured_SYTermID = $_POST['sent_SYTermID']; 
    $captured_SectionID = $_POST['sent_SectionID'];


    $query = 
    "SELECT 1 as 'exists' FROM
    (
        SELECT * from classes
        INNER JOIN
        (SELECT syTermID from syterms where schoolYear = 
            (SELECT schoolYear from syterms where syTermID = '$captured_SYTermID')
        ) AS sy
        ON classes.syTermID_Start_Classes = sy.syTermID
    ) 
    AS merged
    WHERE merged.sectionID_Classes = '$captured_SectionID'";

      $result = mysqli_query($mySQL_ConStr, $query);
      $returnValue = mysqli_fetch_array($result);

      echo json_encode($returnValue['exists']);  
  }


  // 32

  function checkExistingEntry()
  {
    
      require 'b_ConnectionString.php';

      $captured_ClassID = $_POST['sent_ClassID'];
     $captured_SYTermID = $_POST['sent_SYTermID']; 
    $captured_SectionID = $_POST['sent_SectionID'];     

      $query = 
      "SELECT 1 as 'exists' FROM
      (
          SELECT * from classes
          INNER JOIN
          (SELECT syTermID from syterms where schoolYear = 
              (SELECT schoolYear from syterms where syTermID = '$captured_SYTermID')
          ) AS sy
          ON classes.syTermID_Start_Classes = sy.syTermID
      ) 
      AS merged
      WHERE 
      (merged.sectionID_Classes = '$captured_SectionID') AND 
      (merged.classID != 'captured_ClassID')";

      $result = mysqli_query($mySQL_ConStr, $query);
      $returnValue = mysqli_fetch_array($result);

      echo json_encode($returnValue['exists']);  
  }


   //---------------------------------------------------------------------------
   // N O N   A J A X   F U N C T I O N S
   //---------------------------------------------------------------------------


    function checkTableSize()
    {
      include 'b_ConnectionString.php';

      $query = 'SELECT COUNT(*) FROM classes';
      $result = mysqli_query($mySQL_ConStr, $query); 
      $tableCount = mysqli_fetch_row($result);
      return $tableCount[0];
    }




    function tableCount()
    {
      include 'b_ConnectionString.php';

      $query = 
      "
         select 
         (select count(*) from syTerms) as syTermCount, 
         (Select count(*) from subjects) as subjectCount, 
         (select count(*) from sections) as sectionCount 
      ";

        $result = mysqli_query($mySQL_ConStr, $query); 
        $otherTableCount = mysqli_fetch_row($result);
        return $otherTableCount;
    }






?>
