<?php


include 'b_ConnectionString.php';

	//function selection block	
	if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
	    switch($action) 
	    {	  



	      case '4' : load_Main_Subjects();break;
	      case '5' : load_Main_Teachers();break;

	      case '6' : submitNewClassSubject();break;
	      case '7' : retrieveClassSubject();break; 
	      case '8' : updateClassSubject();break; 
	      case '9' : deleteClassSubject();break;

        case '21' : load_Main_ClassDetails();break;
        case '22' : load_Main_SYTerms();break;
	      case '23' : load_Main_ClassSubjectTable();break;

	      //default : echo 'NOTHING';break;
	    }
	}


    function checkTableSize()
    {
      $query = 'SELECT COUNT(*) FROM classSubjects';
      $result = mysql_query($query); 
      $tableCount = mysql_fetch_row($result);
      return $tableCount[0];
    }


    function tableCount()
    {
      $query = 
      "
        select 
        (select count(*) FROM syTerms) as syTermCount, 
        (Select count(*) FROM subjects) as subjectCount, 
        (select count(*) FROM sections) as sectionCount 
      ";

        $result = mysql_query($query); 
        $otherTableCount = mysql_fetch_row($result);
        return $otherTableCount;
    }


	//---------------------------------------------------------------------------
	// L O A D   M A I N P A G E
	//---------------------------------------------------------------------------

  // 21
  function load_Main_ClassDetails()
  {
    $captured_ClassID = $_POST['sent_ClassID'];

    $query = 
      "SELECT
      merged.sectionName,
      merged.schoolYear 

      FROM
      (
        SELECT * from classes as c

        INNER JOIN
        (SELECT sectionID, sectionName from sections) as se 
        on se.sectionID = c.sectionID_Classes 

        INNER JOIN 
        (SELECT syTermID, schoolYear from syterms) as sy 
        on sy.syTermID = c.syTermID_Start_Classes
      ) as merged

      WHERE merged.classID = $captured_ClassID";

    $tableQuery = mysql_query($query) 
      or die ("cannot load tables");      

    $classDetails = mysql_fetch_assoc($tableQuery); 
    echo json_encode($classDetails);
  }


  // 22
  function load_Main_SYTerms()
  {
    $captured_ClassID = $_POST['sent_ClassID'];
    $syTermArray = [];

    $query = 
      " SELECT 
          syTermIDValues.schoolYear, 
          syTermIDValues.termNumber,
          syTermIDValues.syTermID,    
          IFNULL(COUNT(cs.syTermID_ClassSubjects), 0) AS 'children'

        FROM                 
        (
          SELECT syTermID_Start_Classes FROM classes 
          WHERE classID = $captured_ClassID
        ) AS c  
        
        LEFT JOIN 
        (
          SELECT syTermID, schoolYear FROM syTerms 
        ) as sy 
        ON c.syTermID_Start_Classes = sy.syTermID

        LEFT JOIN 
        (
          SELECT schoolYear, syTermID, termNumber FROM syTerms
        ) as syTermIDValues
        ON sy.schoolYear = syTermIDValues.schoolYear 

        LEFT JOIN 
        (
          SELECT * FROM classSubjects 
        ) as cs 
        ON cs.syTermID_ClassSubjects = syTermIDValues.syTermID
        AND cs.classID_ClassSubjects = $captured_ClassID 

        GROUP by syTermIDValues.syTermID
        ORDER by syTermIDValues.syTermID ASC;";


    $tableQuery = mysql_query($query) 
      or die ("cannot load tables");  

    while($getRow = mysql_fetch_assoc($tableQuery))
    {
         $syTermArray[] = $getRow;
    }

    echo json_encode($syTermArray);

  }


  // 23
	function load_Main_ClassSubjectTable()
	{
    $captured_ClassID = $_POST['sent_ClassID'];
		$captured_SYTermID = $_POST['sent_SYTermID'];

		$classSubjectArray = [];

		$query = 
		"
			SELECT

				merged.classSubjectID,
				merged.classID_ClassSubjects, 
		    merged.className, 
		    merged.subjectID_ClassSubjects,
		    merged.subjectName, 
		    merged.teacherID_ClassSubjects,
		    merged.employeeName

			FROM 
			(
				SELECT * FROM classsubjects
			    
			    INNER JOIN 
			    (SELECT classID, className FROM classes) as J1
			    ON classsubjects.classID_ClassSubjects = J1.classID
			    INNER JOIN 
			    (SELECT subjectID, subjectName FROM subjects) as J2 
			    ON classsubjects.subjectID_ClassSubjects = J2.subjectID 
			    INNER JOIN 
			    (SELECT employeeID, employeeName FROM employees) as J3 
			    ON classsubjects.teacherID_ClassSubjects = J3.employeeID
			)

			AS merged

			WHERE
			(syTermID_ClassSubjects = '".$captured_SYTermID."')
			AND
			(classID_ClassSubjects = '".$captured_ClassID."')
      ORDER by merged.classSubjectID ASC
		";

		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  

		while($getRow = mysql_fetch_assoc($tableQuery))
		{
			$classSubjectArray[] = $getRow;
		}		

		echo json_encode($classSubjectArray);
	}








	//---------------------------------------------------------------------------
	// L O A D   D R O P D O W N S
	//---------------------------------------------------------------------------


  // 4
	function load_Main_Subjects()
	{

		$captured_ClassID = $_POST['sent_ClassID'];

		$query = 
      "
        SELECT su.subjectID, su.gradeLevelID_Subjects, su.subjectName

        FROM                 
        (
          SELECT sectionID_Classes FROM classes 
          WHERE classID = $captured_ClassID
        )AS c

        LEFT JOIN 
        (SELECT sectionID, gradeLevelID_Sections FROM sections) as se
        ON se.sectionID = c.sectionID_Classes
        
        LEFT JOIN 
        (SELECT * FROM subjects) as su 
        ON su.gradeLevelID_Subjects = se.gradeLevelID_Sections

        ORDER BY su.subjectID
      ";  

		$tableQuery = mysql_query($query) 
			or die ("cannot load tables");  

		while($getRow = mysql_fetch_assoc($tableQuery))
		{
			$subjectArray[] = $getRow;
		}

		echo json_encode($subjectArray);	
	}


  // 5
	function load_Main_Teachers()
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

  // 6
	function submitNewClassSubject()
	{
    $captured_SYTermID = $_POST['sent_SYTermID'];
    $captured_ClassID = $_POST['sent_ClassID'];
		$captured_SubjectID = $_POST['sent_SubjectID'];
		$captured_TeacherID = $_POST['sent_AdviserID'];



    $firstQuery = 
      "SELECT syTermID from syTerms 
      WHERE schoolYear = 
      (
        select schoolYear from syterms 
        where syTermID = $captured_SYTermID
      )";

      $tableQuery = mysql_query($firstQuery) 
          or die ("cannot load tables");  



      while($getRow = mysql_fetch_assoc($tableQuery))
      {
        $secondQuery = "INSERT INTO classSubjects (syTermID_ClassSubjects, classID_ClassSubjects, subjectID_ClassSubjects, teacherID_ClassSubjects) 
        
        VALUES 
        (
          '".$getRow['syTermID']."',
          '$captured_ClassID',
          '$captured_SubjectID',
          '$captured_TeacherID'
        )";

        mysql_query($secondQuery);
      }


    echo json_encode(true);      
	}


  // 7
	function retrieveClassSubject()
	{
		$captured_ClassSubjectID = $_POST['sent_ClassSubjectID'];

		$query = "SELECT * FROM classSubjects WHERE classSubjectID = '$captured_ClassSubjectID'";

		$result = mysql_query($query);
		$returnValue = mysql_fetch_array($result);

		echo json_encode($returnValue);
	}


  // 8
	function updateClassSubject()
	{
    $captured_ClassSubjectID   = $_POST['sent_ClassSubjectID'];

		$captured_SubjectID = $_POST['sent_SubjectID'];
		$captured_TeacherID = $_POST['sent_TeacherID'];

    $captured_AffectedTerms = $_POST['sent_AffectedTerms'];

    switch ($captured_AffectedTerms) 
    {
      case 1: //update the four terms
        
        $firstQuery = 
        "
          SELECT syTermID 
          FROM syTerms 
          WHERE schoolYear = 
          (                       
            SELECT schoolYear 
            FROM syTerms 
            WHERE syTermID = 
            (
              SELECT syTermID_ClassSubjects 
              FROM classsubjects
              WHERE classSubjectID = '".$captured_ClassSubjectID."'
            )
          )
        ";
        $firstTableQuery = mysql_query($firstQuery);

        while($getRow = mysql_fetch_array($firstTableQuery))
        {
          $secondQuery = 
          "
            UPDATE classSubjects 
            SET 
            teacherID_ClassSubjects = '$captured_TeacherID'

            WHERE 
              (subjectID_ClassSubjects = '$captured_SubjectID') 
              AND
              (syTermID_ClassSubjects = '".$getRow[0]."') 
          ";

          mysql_query($secondQuery);
        }

        break;


      case 2: //update the selected term

        $query = 
        "
          UPDATE classSubjects 
          SET 
          teacherID_ClassSubjects = '$captured_TeacherID'
          WHERE
          classSubjectID = '$captured_ClassSubjectID'
        ";

        mysql_query($query);

        break;
      
      default:
        break;
    }


    echo json_encode(true);
	}


  // 9
	function deleteClassSubject()
	{
		$captured_ClassSubjectID   = $_POST['sent_ClassSubjectID'];

        $subjectQuery = 
        "
          SELECT subjectID_ClassSubjects
          FROM classsubjects 
          WHERE classSubjectID = '$captured_ClassSubjectID'
        ";
        $subjectTableQuery = mysql_query($subjectQuery);
        $subjectID = mysql_fetch_array($subjectTableQuery)[0];


        $syTermQuery = 
        "
          SELECT syTermID 
          FROM syTerms 
          WHERE schoolYear = 
          (                       
            SELECT schoolYear 
            FROM syTerms 
            WHERE syTermID = 
            (
              SELECT syTermID_ClassSubjects 
              FROM classSubjects
              WHERE classSubjectID = '".$captured_ClassSubjectID."'
            )
          )
        ";


        $syTermTableQuery = mysql_query($syTermQuery);


        while($getRow = mysql_fetch_array($syTermTableQuery))
        {
          $deleteQuery = 
          "
            DELETE FROM classSubjects 
            WHERE (subjectID_ClassSubjects = $subjectID)
            AND
            (syTermID_ClassSubjects = '".$getRow[0]."')
          ";
          mysql_query($deleteQuery);
        }


    echo json_encode(true);
	}


?>